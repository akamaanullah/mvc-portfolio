<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\ChatModel;
use App\Services\ChatbotService;

class ChatbotController extends Controller
{
    /**
     * POST /api/chat/message — Main visitor chat endpoint.
     */
    public function message(): string
    {
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $userMessage = trim($input['message'] ?? '');
        $sessionId   = trim($input['session_id'] ?? $input['session_key'] ?? '');
        $history     = $input['history'] ?? [];
        $currentPage = trim($input['current_page'] ?? $_SERVER['HTTP_REFERER'] ?? '/');

        if (empty($userMessage)) {
            return $this->json(['error' => 'Empty message'], 400);
        }

        if (empty($sessionId)) {
            $sessionId = 'sess_' . substr(md5(uniqid((string)mt_rand(), true)), 0, 12);
        }

        // Get or initialize conversation
        $conv = ChatModel::getOrCreateConversation($sessionId, [
            'current_page' => $currentPage,
            'ip'           => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'user_agent'   => $_SERVER['HTTP_USER_AGENT'] ?? '',
        ]);

        // Save visitor's message
        $visitorMsgId = ChatModel::addMessage($conv['id'], 'visitor', $userMessage);

        // If conversation is already in human mode, don't call bot
        if (in_array($conv['status'], ['needs_human', 'active'])) {
            return $this->json([
                'live_mode'  => true,
                'status'     => $conv['status'],
                'session_id' => $sessionId,
                'message_id' => $visitorMsgId,
                'reply'      => null
            ]);
        }

        // Check if user is asking for a real person / human takeover
        if (ChatbotService::isHumanRequested($userMessage)) {
            ChatModel::updateStatus($conv['id'], 'needs_human');
            
            // Dispatch instant takeover alert email to admin
            ChatbotService::sendTakeoverAlert(
                $conv, 
                $conv['visitor_name'] ?? 'Visitor', 
                $conv['visitor_email'] ?? 'Not submitted yet', 
                $userMessage
            );

            return $this->json([
                'handoff'    => true,
                'session_id' => $sessionId,
                'status'     => 'needs_human',
                'reply'      => "I have just notified Amaanullah Khan! He is receiving an alert to take over this chat right now. You can also message or call him directly on WhatsApp: " . env('CONTACT_PHONE', '+92 319 6935307') . "."
            ]);
        }

        // Ask AI
        $aiReply = ChatbotService::ask($userMessage, $history);

        // Save AI reply to database
        $botMsgId = ChatModel::addMessage($conv['id'], 'bot', $aiReply);

        return $this->json([
            'reply'      => $aiReply,
            'session_id' => $sessionId,
            'status'     => 'bot',
            'message_id' => $botMsgId
        ]);
    }

    /**
     * POST /api/chat/init-live — Visitor submits details for live takeover.
     */
    public function initLive(): string
    {
        $input       = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $name        = trim($input['name'] ?? '');
        $email       = trim($input['email'] ?? '');
        $sessionId   = trim($input['session_id'] ?? $input['session_key'] ?? '');
        $context     = trim($input['context'] ?? '');

        if (empty($name) || empty($email) || empty($sessionId)) {
            return $this->json(['error' => 'Name, email, and session are required.'], 422);
        }

        $conv = ChatModel::getOrCreateConversation($sessionId, [
            'visitor_name'  => $name,
            'visitor_email' => $email,
            'ip'            => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ]);

        ChatModel::updateVisitorContact($conv['id'], $name, $email);
        ChatModel::updateStatus($conv['id'], 'needs_human');

        if (!empty($context)) {
            ChatModel::addMessage($conv['id'], 'visitor', "[AI Chat Summary]:\n" . $context);
        }

        // Send urgent email notification to admin
        ChatbotService::sendTakeoverAlert($conv, $name, $email, $context);

        return $this->json([
            'success'    => true,
            'session_id' => $sessionId,
            'status'     => 'needs_human'
        ]);
    }

    /**
     * GET /api/chat/poll — Visitor widget polls for admin messages.
     */
    public function poll(): string
    {
        $sessionId = trim($_GET['session_id'] ?? $_GET['session_key'] ?? '');
        $lastId    = (int)($_GET['last_id'] ?? 0);

        if (empty($sessionId)) {
            return $this->json(['error' => 'Missing session_id'], 400);
        }

        $conv = ChatModel::getConversationBySession($sessionId);
        if (!$conv) {
            return $this->json(['status' => 'closed', 'messages' => []]);
        }

        // Fetch new messages from admin
        $db = Database::connection();
        $stmt = $db->prepare("SELECT id, sender, message, created_at 
            FROM chat_messages 
            WHERE conversation_id = ? AND sender = 'admin' AND id > ? 
            ORDER BY id ASC");
        $stmt->execute([$conv['id'], $lastId]);
        $messages = $stmt->fetchAll();

        return $this->json([
            'status'   => $conv['status'],
            'messages' => $messages
        ]);
    }

    /**
     * POST /api/chat/lead — Inline lead submission from chat.
     */
    public function lead(): string
    {
        $input       = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $name        = trim($input['name'] ?? 'Strategic Visitor');
        $email       = trim($input['email'] ?? '');
        $phone       = trim($input['phone'] ?? '');
        $requirement = trim($input['interest'] ?? $input['requirement'] ?? 'Direct Inquiry from Chatbot');
        $transcript  = trim($input['transcript'] ?? '');
        $sourceUrl   = trim($input['source_url'] ?? $_SERVER['HTTP_REFERER'] ?? '/');

        if (empty($email)) {
            return $this->json(['error' => 'Email is required.'], 422);
        }

        $db = Database::connection();
        $stmt = $db->prepare("INSERT INTO leads (name, email, phone, source_url, requirement, status, notes, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, 'new', ?, NOW(), NOW())");
        $stmt->execute([$name, $email, $phone, $sourceUrl, $requirement, $transcript]);
        $leadId = (int)$db->lastInsertId();

        // Send Email notification to admin
        $subject = "🎯 New Chatbot Lead: {$name} ({$email})";
        $body = "
        <div style='font-family: Arial, sans-serif; background: #0b0c10; padding: 30px; color: #fff;'>
            <div style='max-width: 600px; margin: 0 auto; background: #14151d; border-radius: 12px; padding: 25px; border: 1px solid rgba(255,255,255,0.1);'>
                <h2 style='color: #f26a1b; margin-top: 0;'>New Lead Captured via Chatbot</h2>
                <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
                <p><strong>Email:</strong> <a href='mailto:" . htmlspecialchars($email) . "' style='color: #f26a1b;'>" . htmlspecialchars($email) . "</a></p>
                " . ($phone ? "<p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>" : "") . "
                <p><strong>Requirement:</strong> " . htmlspecialchars($requirement) . "</p>
                " . ($transcript ? "<hr style='border-color: rgba(255,255,255,0.1);'><h4 style='color:#94a3b8;'>Chat Transcript:</h4><pre style='background:rgba(255,255,255,0.03); padding:15px; border-radius:8px; font-size:12px; color:#cbd5e1; white-space:pre-wrap;'>" . htmlspecialchars($transcript) . "</pre>" : "") . "
                <p style='margin-top: 25px;'><a href='" . base_url('/admin/leads') . "' style='display:inline-block; padding:12px 24px; background:#f26a1b; color:#fff; text-decoration:none; border-radius:8px; font-weight:bold;'>View in Admin Panel</a></p>
            </div>
        </div>";
        ChatbotService::sendEmail(env('SMTP_USER', 'akamaanullah@gmail.com'), $subject, $body);

        // Synchronize real name and email to chat_conversations record
        $sessionId = trim($input['session_id'] ?? $input['session_key'] ?? '');
        if (!empty($sessionId)) {
            $conv = ChatModel::getConversationBySession($sessionId);
            if ($conv) {
                ChatModel::updateVisitorContact($conv['id'], $name, $email);
            }
        }

        return $this->json(['success' => true, 'lead_id' => $leadId]);
    }

    /**
     * POST /api/chat/close — Close active conversation.
     */
    public function close(): string
    {
        $input     = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $sessionId = trim($input['session_id'] ?? $input['session_key'] ?? '');

        if (!empty($sessionId)) {
            $conv = ChatModel::getConversationBySession($sessionId);
            if ($conv) {
                ChatModel::updateStatus($conv['id'], 'closed');
                ChatModel::addMessage($conv['id'], 'admin', '__CLOSED__');
            }
        }

        return $this->json(['success' => true]);
    }
}
