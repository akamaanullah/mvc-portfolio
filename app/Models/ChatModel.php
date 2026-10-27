<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class ChatModel
{
    private static function db(): PDO
    {
        return Database::connection();
    }

    /**
     * Clean OS & Browser helper from User-Agent string.
     */
    public static function parseUserAgent(?string $ua): string
    {
        if (empty($ua)) return 'Unknown Device';
        $os = 'Unknown OS';
        $browser = 'Unknown Browser';

        if (preg_match('/iphone|ipad|ipod/i', $ua)) {
            $os = 'iOS';
        } elseif (preg_match('/android/i', $ua)) {
            $os = 'Android';
        } elseif (preg_match('/windows nt 10/i', $ua)) {
            $os = 'Windows 10/11';
        } elseif (preg_match('/windows/i', $ua)) {
            $os = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $ua)) {
            $os = 'macOS';
        } elseif (preg_match('/linux/i', $ua)) {
            $os = 'Linux';
        }

        if (preg_match('/edg/i', $ua)) {
            $browser = 'Edge';
        } elseif (preg_match('/opr|opera/i', $ua)) {
            $browser = 'Opera';
        } elseif (preg_match('/chrome/i', $ua)) {
            $browser = 'Chrome';
        } elseif (preg_match('/safari/i', $ua)) {
            $browser = 'Safari';
        } elseif (preg_match('/firefox/i', $ua)) {
            $browser = 'Firefox';
        }

        return "{$os} · {$browser}";
    }

    /**
     * Get or create conversation for visitor session.
     */
    public static function getOrCreateConversation(string $sessionId, array $meta = []): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM chat_conversations WHERE session_id = ? LIMIT 1");
        $stmt->execute([$sessionId]);
        $row = $stmt->fetch();

        $ip = trim((string)($meta['ip'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'));
        if (str_contains($ip, ',')) $ip = trim(explode(',', $ip)[0]);
        $ua = self::parseUserAgent($meta['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? '');
        $page = $meta['current_page'] ?? $_SERVER['HTTP_REFERER'] ?? '/';
        $location = $meta['location'] ?? null;

        if (empty($location)) {
            if ($ip === '127.0.0.1' || $ip === '::1') {
                $location = 'Karachi, Pakistan (Local)';
            } elseif (!empty($_SERVER['HTTP_CF_IPCOUNTRY'])) {
                $location = $_SERVER['HTTP_CF_IPCOUNTRY'];
            } else {
                $vStmt = $db->prepare("SELECT country, city FROM visitors WHERE ip = ? LIMIT 1");
                $vStmt->execute([$ip]);
                $vRow = $vStmt->fetch();
                if ($vRow && (!empty($vRow['country']) || !empty($vRow['city']))) {
                    $location = trim(($vRow['city'] ?? '') . ', ' . ($vRow['country'] ?? ''), ', ');
                }
            }
        }
        if (empty($location)) {
            $location = 'Pakistan';
        }

        if (!$row) {
            // New conversation
            $vName = $meta['visitor_name'] ?? 'Visitor #' . substr(abs(crc32($sessionId)), 0, 4);
            $vEmail = $meta['visitor_email'] ?? null;

            $ins = $db->prepare("INSERT INTO chat_conversations 
                (session_id, visitor_name, visitor_email, visitor_ip, location, user_agent, current_page, status, last_message, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'bot', 'Started chat', NOW(), NOW())");
            $ins->execute([$sessionId, $vName, $vEmail, $ip, $location, $ua, $page]);
            $newId = (int)$db->lastInsertId();

            $stmt->execute([$sessionId]);
            return $stmt->fetch() ?: ['id' => $newId, 'session_id' => $sessionId];
        }

        // Update last seen metadata
        $updates = [];
        $params = [];
        if (!empty($page) && $page !== $row['current_page']) {
            $updates[] = "current_page = ?";
            $params[] = $page;
        }
        if (!empty($location) && empty($row['location'])) {
            $updates[] = "location = ?";
            $params[] = $location;
        }
        if (!empty($meta['visitor_name']) && $meta['visitor_name'] !== $row['visitor_name']) {
            $updates[] = "visitor_name = ?";
            $params[] = $meta['visitor_name'];
        }
        if (!empty($meta['visitor_email']) && $meta['visitor_email'] !== $row['visitor_email']) {
            $updates[] = "visitor_email = ?";
            $params[] = $meta['visitor_email'];
        }

        if (!empty($updates)) {
            $params[] = $row['id'];
            $db->prepare("UPDATE chat_conversations SET " . implode(', ', $updates) . ", updated_at = NOW() WHERE id = ?")
                ->execute($params);
            $stmt->execute([$sessionId]);
            $row = $stmt->fetch();
        }

        return $row;
    }

    /**
     * Add message to conversation.
     */
    public static function addMessage(int $conversationId, string $sender, string $message): int
    {
        $db = self::db();
        $stmt = $db->prepare("INSERT INTO chat_messages (conversation_id, sender, message, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$conversationId, $sender, $message]);
        $msgId = (int)$db->lastInsertId();

        // Update conversation last message & updated_at
        $db->prepare("UPDATE chat_conversations SET last_message = ?, updated_at = NOW() WHERE id = ?")
            ->execute([mb_substr($message, 0, 255), $conversationId]);

        return $msgId;
    }

    /**
     * Get messages for conversation.
     */
    public static function getMessages(int $conversationId, int $afterId = 0): array
    {
        $db = self::db();
        if ($afterId > 0) {
            $stmt = $db->prepare("SELECT id, conversation_id, sender, message, created_at 
                FROM chat_messages 
                WHERE conversation_id = ? AND id > ? 
                ORDER BY id ASC");
            $stmt->execute([$conversationId, $afterId]);
        } else {
            $stmt = $db->prepare("SELECT id, conversation_id, sender, message, created_at 
                FROM chat_messages 
                WHERE conversation_id = ? 
                ORDER BY id ASC");
            $stmt->execute([$conversationId]);
        }
        return $stmt->fetchAll();
    }

    /**
     * Update conversation status: 'bot', 'needs_human', 'active', 'closed'.
     */
    public static function updateStatus(int $conversationId, string $status): bool
    {
        return self::db()->prepare("UPDATE chat_conversations SET status = ?, updated_at = NOW() WHERE id = ?")
            ->execute([$status, $conversationId]);
    }

    /**
     * Update visitor contact info.
     */
    public static function updateVisitorContact(int $conversationId, string $name, string $email): bool
    {
        return self::db()->prepare("UPDATE chat_conversations SET visitor_name = ?, visitor_email = ?, updated_at = NOW() WHERE id = ?")
            ->execute([$name, $email, $conversationId]);
    }

    /**
     * Get single conversation by ID.
     */
    public static function getConversation(int $id): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM chat_conversations WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Get single conversation by Session ID.
     */
    public static function getConversationBySession(string $sessionId): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM chat_conversations WHERE session_id = ? LIMIT 1");
        $stmt->execute([$sessionId]);
        return $stmt->fetch() ?: null;
    }

    /**
     * List conversations for Admin live chat panel.
     */
    public static function listConversations(string $filter = 'all', string $search = ''): array
    {
        $db = self::db();
        $where = [];
        $params = [];

        if ($filter === 'active') {
            $where[] = "status IN ('bot', 'needs_human', 'active')";
        } elseif ($filter === 'needs_human') {
            $where[] = "status = 'needs_human'";
        } elseif ($filter === 'closed') {
            $where[] = "status = 'closed'";
        }

        if (!empty($search)) {
            $where[] = "(visitor_name LIKE ? OR visitor_email LIKE ? OR last_message LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $sql = "SELECT c.*, 
            (SELECT COUNT(*) FROM chat_messages m WHERE m.conversation_id = c.id AND m.sender = 'visitor') as user_msg_count,
            (SELECT MAX(id) FROM chat_messages m WHERE m.conversation_id = c.id) as max_msg_id
            FROM chat_conversations c";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        // Sort: needs_human on top, then active & bot strictly by updated_at DESC (newest at the top)
        $sql .= " ORDER BY (CASE WHEN status = 'needs_human' THEN 0 ELSE 1 END), updated_at DESC LIMIT 50";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Count conversations requiring admin attention.
     */
    public static function countNeedsHuman(): int
    {
        return (int) self::db()->query("SELECT COUNT(*) FROM chat_conversations WHERE status = 'needs_human'")->fetchColumn();
    }

    /**
     * Fetch visitor browsing profile and timeline from visitors table.
     */
    public static function getVisitorProfile(?string $ip, ?string $sessionId = null): array
    {
        $db = self::db();
        $pages = [];
        $sessionsCount = 1;
        $source = 'Direct';
        $visitorId = 1;

        if (!empty($ip)) {
            $stmt = $db->prepare("SELECT id, url, referrer, created_at FROM visitors 
                WHERE ip = ? AND url NOT LIKE '/api/%' AND url NOT LIKE '/admin/%' AND url NOT LIKE '%poll%' 
                ORDER BY id DESC LIMIT 15");
            $stmt->execute([$ip]);
            $visits = $stmt->fetchAll();

            if (!empty($visits)) {
                $visitorId = (int)$visits[0]['id'];
                $seen = [];
                foreach ($visits as $v) {
                    $cleanUrl = preg_replace('#^/web3d-full#', '', $v['url'] ?: '/');
                    if (empty($cleanUrl) || $cleanUrl === '') $cleanUrl = '/';
                    if (isset($seen[$cleanUrl])) continue;
                    $seen[$cleanUrl] = true;
                    $pages[] = [
                        'path' => $cleanUrl,
                        'time' => date('H:i', strtotime($v['created_at']))
                    ];
                    if (!empty($v['referrer']) && $source === 'Direct') {
                        $parsed = parse_url($v['referrer'], PHP_URL_HOST);
                        $source = $parsed ? ucfirst(str_replace('www.', '', $parsed)) : 'Referral';
                    }
                }
                $cnt = $db->prepare("SELECT COUNT(DISTINCT DATE(created_at)) FROM visitors WHERE ip = ?");
                $cnt->execute([$ip]);
                $sessionsCount = max(1, (int)$cnt->fetchColumn());
            } else {
                $vIdStmt = $db->prepare("SELECT id FROM visitors WHERE ip = ? ORDER BY id DESC LIMIT 1");
                $vIdStmt->execute([$ip]);
                $vId = (int)$vIdStmt->fetchColumn();
                if ($vId > 0) $visitorId = $vId;
            }
        }

        return [
            'visitor_id' => $visitorId,
            'sessions_count' => $sessionsCount,
            'source' => $source,
            'pages' => $pages,
            'lead_score' => min(95, 45 + (count($pages) * 12))
        ];
    }
}
