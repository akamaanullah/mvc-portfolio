<?php
namespace App\Services;

use App\Core\Logger;

class IntegrationService
{
    /**
     * Get active configurations for all 6 integrations.
     */
    public static function getAll(): array
    {
        $gscKeyPath = BASE_PATH . '/' . ltrim(env('GSC_KEY_PATH', 'config/keys/search-console-key.json'), '/\\');
        $gscKeyJson = file_exists($gscKeyPath) ? file_get_contents($gscKeyPath) : '';
        $gscClientEmail = '';
        if ($gscKeyJson) {
            $parsed = json_decode($gscKeyJson, true);
            $gscClientEmail = $parsed['client_email'] ?? '';
        }

        return [
            'gsc' => [
                'title' => 'Google Search Console',
                'connected' => file_exists($gscKeyPath),
                'site_url' => env('GSC_SITE_URL', 'https://amaanullah.com/'),
                'key_path' => env('GSC_KEY_PATH', 'config/keys/search-console-key.json'),
                'client_email' => $gscClientEmail,
                'key_json' => $gscKeyJson
            ],
            'pagespeed' => [
                'title' => 'Google PageSpeed Insights',
                'connected' => !empty(env('PAGESPEED_API_KEY')),
                'api_key' => env('PAGESPEED_API_KEY', ''),
                'audit_url' => env('SITE_URL', 'https://amaanullah.com')
            ],
            'whatsapp' => [
                'title' => 'WhatsApp Direct Integration',
                'connected' => true,
                'phone' => env('CONTACT_PHONE', '+92 319 6935307'),
                'whatsapp_url' => env('CONTACT_WHATSAPP', 'https://api.whatsapp.com/send?phone=923196935307'),
                'default_msg' => 'Hello Amaanullah, I came across your portfolio and would like to discuss a project.'
            ],
            'smtp' => [
                'title' => 'SMTP / Mail Server',
                'connected' => !empty(env('SMTP_USER')),
                'host' => env('SMTP_HOST', 'smtp.gmail.com'),
                'port' => env('SMTP_PORT', '465'),
                'encryption' => env('SMTP_ENCRYPTION', 'ssl'),
                'user' => env('SMTP_USER', 'akamaanullah@gmail.com'),
                'pass' => env('SMTP_PASS', ''),
                'from' => env('SMTP_FROM', 'akamaanullah@gmail.com'),
                'from_name' => env('SMTP_FROM_NAME', 'Amaanullah Khan Portfolio')
            ],
            'alerts' => [
                'title' => 'Email Alerts & Notifications',
                'connected' => true,
                'alert_email' => env('CONTACT_EMAIL', 'info@amaanullah.com'),
                'notify_leads' => '1',
                'notify_needs_human' => '1',
                'notify_messages' => '1'
            ],
            'cloudflare' => [
                'title' => 'Cloudflare Workers AI',
                'connected' => !empty(env('CF_API_TOKEN')),
                'account_id' => env('CF_ACCOUNT_ID', '9f63cf53ac893a6a5f2725278f7f86d3'),
                'api_token' => env('CF_API_TOKEN', ''),
                'model' => env('CF_AI_MODEL', '@cf/meta/llama-3.1-8b-instruct-fast')
            ]
        ];
    }

    /**
     * Safely update .env file with given key-value pairs.
     */
    public static function updateEnv(array $updates): bool
    {
        $envPath = BASE_PATH . '/.env';
        if (!file_exists($envPath)) {
            return false;
        }

        $content = file_get_contents($envPath);

        foreach ($updates as $key => $val) {
            $valStr = (string)$val;
            if (preg_match('/\s|[#"$]/', $valStr)) {
                $formatted = '"' . addcslashes($valStr, '"\\$') . '"';
            } else {
                $formatted = $valStr;
            }

            if (preg_match('/^' . preg_quote($key, '/') . '=.*/m', $content)) {
                $content = preg_replace('/^' . preg_quote($key, '/') . '=.*/m', "{$key}={$formatted}", $content);
            } else {
                $content .= "\n{$key}={$formatted}";
            }
        }

        return file_put_contents($envPath, $content) !== false;
    }

    /**
     * Save specific integration settings.
     */
    public static function saveIntegration(string $type, array $data): array
    {
        switch ($type) {
            case 'gsc':
                $siteUrl = trim($data['site_url'] ?? 'https://amaanullah.com/');
                $keyJson = trim($data['key_json'] ?? '');
                
                self::updateEnv(['GSC_SITE_URL' => $siteUrl]);

                if (!empty($keyJson)) {
                    $parsed = json_decode($keyJson, true);
                    if (!$parsed || empty($parsed['client_email'])) {
                        return ['success' => false, 'error' => 'Invalid Google Service Account JSON structure.'];
                    }
                    $keyPath = BASE_PATH . '/config/keys/search-console-key.json';
                    $dir = dirname($keyPath);
                    if (!is_dir($dir)) @mkdir($dir, 0755, true);
                    file_put_contents($keyPath, $keyJson);
                }
                return ['success' => true, 'message' => 'Google Search Console configuration saved!'];

            case 'pagespeed':
                $apiKey = trim($data['api_key'] ?? '');
                self::updateEnv(['PAGESPEED_API_KEY' => $apiKey]);
                return ['success' => true, 'message' => 'PageSpeed API settings saved!'];

            case 'whatsapp':
                $phone = trim($data['phone'] ?? '+92 319 6935307');
                $cleanDigits = preg_replace('/[^0-9]/', '', $phone);
                $whatsappUrl = "https://api.whatsapp.com/send?phone={$cleanDigits}";
                self::updateEnv([
                    'CONTACT_PHONE' => $phone,
                    'CONTACT_WHATSAPP' => $whatsappUrl
                ]);
                return ['success' => true, 'message' => 'WhatsApp configuration saved!'];

            case 'smtp':
                $host = trim($data['host'] ?? 'smtp.gmail.com');
                $port = trim($data['port'] ?? '465');
                $user = trim($data['user'] ?? '');
                $pass = trim($data['pass'] ?? '');
                $enc  = trim($data['encryption'] ?? 'ssl');
                $from = trim($data['from'] ?? $user);
                $fromName = trim($data['from_name'] ?? 'Amaanullah Khan Portfolio');

                $updates = [
                    'SMTP_HOST' => $host,
                    'SMTP_PORT' => $port,
                    'SMTP_USER' => $user,
                    'SMTP_ENCRYPTION' => $enc,
                    'SMTP_FROM' => $from,
                    'SMTP_FROM_NAME' => $fromName
                ];
                if ($pass !== '') {
                    $updates['SMTP_PASS'] = $pass;
                }
                self::updateEnv($updates);
                return ['success' => true, 'message' => 'SMTP Mail Server configuration saved!'];

            case 'alerts':
                $email = trim($data['alert_email'] ?? 'info@amaanullah.com');
                self::updateEnv(['CONTACT_EMAIL' => $email]);
                return ['success' => true, 'message' => 'Email Alerts configuration saved!'];

            case 'cloudflare':
                $accId = trim($data['account_id'] ?? '');
                $token = trim($data['api_token'] ?? '');
                $model = trim($data['model'] ?? '@cf/meta/llama-3.1-8b-instruct-fast');
                $updates = [
                    'CF_ACCOUNT_ID' => $accId,
                    'CF_AI_MODEL'   => $model
                ];
                if ($token !== '') {
                    $updates['CF_API_TOKEN'] = $token;
                }
                self::updateEnv($updates);
                return ['success' => true, 'message' => 'Cloudflare Workers AI settings saved!'];

            default:
                return ['success' => false, 'error' => 'Unknown integration type.'];
        }
    }

    /**
     * Send real live SMTP test email.
     */
    public static function testSmtp(string $toEmail): array
    {
        $phpmailerPath = BASE_PATH . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
        if (!file_exists($phpmailerPath)) {
            return ['success' => false, 'error' => 'PHPMailer library not found.'];
        }

        require_once BASE_PATH . '/vendor/phpmailer/phpmailer/src/Exception.php';
        require_once BASE_PATH . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require_once BASE_PATH . '/vendor/phpmailer/phpmailer/src/SMTP.php';

        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = env('SMTP_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('SMTP_USER', 'akamaanullah@gmail.com');
            $mail->Password   = trim(env('SMTP_PASS', 'gxju qxxb xddo vwgq'), '"\'');
            $mail->Port       = (int)env('SMTP_PORT', 465);

            $enc = strtolower(env('SMTP_ENCRYPTION', 'ssl'));
            if ($enc === 'tls' || $mail->Port == 587) {
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            }

            // SSL bypass options for local environments
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];

            $mail->setFrom(env('SMTP_FROM', 'akamaanullah@gmail.com'), env('SMTP_FROM_NAME', 'Amaanullah Khan Portfolio'));
            $mail->addAddress($toEmail);
            $mail->isHTML(true);
            $mail->Subject = '✅ SMTP Test Email — Amaanullah Khan Portfolio';
            $mail->Body    = '
            <div style="font-family: \'Segoe UI\', Roboto, Arial, sans-serif; background: #0b0c10; padding: 30px 20px; color: #fff;">
                <div style="max-width: 520px; margin: 0 auto; background: #14151d; border-radius: 14px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); padding: 25px;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <span style="font-size: 32px;">⚡</span>
                        <h2 style="color: #10b981; margin: 8px 0 4px;">SMTP Connection Verified!</h2>
                        <p style="color: #94a3b8; font-size: 13px; margin: 0;">This email confirms your SMTP host and credentials are fully functioning.</p>
                    </div>
                    <div style="background: rgba(255,255,255,0.03); border-radius: 10px; padding: 15px; font-size: 12.5px; color: #cbd5e1; border: 1px solid rgba(255,255,255,0.06);">
                        <p style="margin: 4px 0;"><strong>Host:</strong> ' . htmlspecialchars($mail->Host) . '</p>
                        <p style="margin: 4px 0;"><strong>Port:</strong> ' . htmlspecialchars((string)$mail->Port) . '</p>
                        <p style="margin: 4px 0;"><strong>Sender:</strong> ' . htmlspecialchars(env('SMTP_FROM', 'akamaanullah@gmail.com')) . '</p>
                        <p style="margin: 4px 0;"><strong>Timestamp:</strong> ' . date('Y-m-d H:i:s') . '</p>
                    </div>
                </div>
            </div>';

            $mail->send();
            return ['success' => true, 'message' => "Success! Test email was dispatched to {$toEmail}."];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
