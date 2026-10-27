<?php
namespace App\Services;

use App\Core\Logger;

class IntegrationService
{
    /**
     * Get active configurations for all 6 integrations directly from database settings.
     * Zero hardcoded credentials or fallback values.
     */
    public static function getAll(): array
    {
        $gscKeyPathSetting = (string) setting('gsc_key_path', '');
        $gscKeyPath = !empty($gscKeyPathSetting) ? BASE_PATH . '/' . ltrim($gscKeyPathSetting, '/\\') : '';
        $gscKeyJson = (!empty($gscKeyPath) && file_exists($gscKeyPath)) ? file_get_contents($gscKeyPath) : '';
        $gscClientEmail = '';
        if ($gscKeyJson) {
            $parsed = json_decode($gscKeyJson, true);
            $gscClientEmail = $parsed['client_email'] ?? '';
        }

        $phone = (string) setting('phone_number', '');
        $whatsappUrl = (string) setting('whatsapp_url', '');
        if (empty($whatsappUrl) && !empty($phone)) {
            $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
            $whatsappUrl = "https://api.whatsapp.com/send?phone={$cleanPhone}";
        }

        $smtpUser = (string) setting('smtp_user', '');
        $cfToken  = (string) setting('cf_api_token', '');
        $psKey    = (string) setting('pagespeed_api_key', '');

        return [
            'gsc' => [
                'title' => 'Google Search Console',
                'connected' => (!empty($gscKeyPath) && file_exists($gscKeyPath)),
                'site_url' => (string) setting('gsc_site_url', ''),
                'key_path' => $gscKeyPathSetting,
                'client_email' => $gscClientEmail,
                'key_json' => $gscKeyJson
            ],
            'pagespeed' => [
                'title' => 'Google PageSpeed Insights',
                'connected' => !empty($psKey),
                'api_key' => $psKey,
                'audit_url' => (string) setting('pagespeed_audit_url', (string) setting('site_domain', ''))
            ],
            'whatsapp' => [
                'title' => 'WhatsApp Direct Integration',
                'connected' => !empty($phone),
                'phone' => $phone,
                'whatsapp_url' => $whatsappUrl,
                'default_msg' => (string) setting('whatsapp_default_msg', '')
            ],
            'smtp' => [
                'title' => 'SMTP / Mail Server',
                'connected' => !empty($smtpUser),
                'host' => (string) setting('smtp_host', ''),
                'port' => (string) setting('smtp_port', ''),
                'encryption' => (string) setting('smtp_encryption', ''),
                'user' => $smtpUser,
                'pass' => (string) setting('smtp_pass', ''),
                'from' => (string) setting('smtp_from', ''),
                'from_name' => (string) setting('smtp_from_name', '')
            ],
            'alerts' => [
                'title' => 'Email Alerts & Notifications',
                'connected' => !empty(setting('alert_email', setting('contact_email', ''))),
                'alert_email' => (string) setting('alert_email', (string) setting('contact_email', '')),
                'notify_leads' => (string) setting('notify_leads', '0'),
                'notify_needs_human' => (string) setting('notify_needs_human', '0'),
                'notify_messages' => (string) setting('notify_messages', '0')
            ],
            'cloudflare' => [
                'title' => 'Cloudflare Workers AI',
                'connected' => !empty($cfToken),
                'account_id' => (string) setting('cf_account_id', ''),
                'api_token' => $cfToken,
                'model' => (string) setting('cf_ai_model', '')
            ]
        ];
    }

    /**
     * Save specific integration settings directly into the database 'settings' table.
     * Pure dynamic input without hardcoded defaults.
     */
    public static function saveIntegration(string $type, array $data): array
    {
        switch ($type) {
            case 'gsc':
                $siteUrl = trim((string)($data['site_url'] ?? ''));
                $keyJson = trim((string)($data['key_json'] ?? ''));
                
                save_setting('gsc_site_url', $siteUrl);

                if (!empty($keyJson)) {
                    $parsed = json_decode($keyJson, true);
                    if (!$parsed || empty($parsed['client_email'])) {
                        return ['success' => false, 'error' => 'Invalid Google Service Account JSON structure.'];
                    }
                    $keyPath = BASE_PATH . '/config/keys/search-console-key.json';
                    $dir = dirname($keyPath);
                    if (!is_dir($dir)) @mkdir($dir, 0755, true);
                    file_put_contents($keyPath, $keyJson);
                    save_setting('gsc_key_path', 'config/keys/search-console-key.json');
                }
                return ['success' => true, 'message' => 'Google Search Console configuration saved in database!'];

            case 'pagespeed':
                $apiKey = trim((string)($data['api_key'] ?? ''));
                $auditUrl = trim((string)($data['audit_url'] ?? ''));
                save_setting('pagespeed_api_key', $apiKey);
                save_setting('pagespeed_audit_url', $auditUrl);
                return ['success' => true, 'message' => 'PageSpeed API settings saved in database!'];

            case 'whatsapp':
                $phone = trim((string)($data['phone'] ?? ''));
                $cleanDigits = preg_replace('/[^0-9]/', '', $phone);
                $whatsappUrl = $cleanDigits ? "https://api.whatsapp.com/send?phone={$cleanDigits}" : '';
                
                save_setting('phone_number', $phone);
                save_setting('whatsapp_number', $cleanDigits);
                save_setting('whatsapp_url', $whatsappUrl);
                return ['success' => true, 'message' => 'WhatsApp configuration saved in database!'];

            case 'smtp':
                $host = trim((string)($data['host'] ?? ''));
                $port = trim((string)($data['port'] ?? ''));
                $user = trim((string)($data['user'] ?? ''));
                $pass = trim((string)($data['pass'] ?? ''));
                $enc  = trim((string)($data['encryption'] ?? ''));
                $from = trim((string)($data['from'] ?? $user));
                $fromName = trim((string)($data['from_name'] ?? ''));

                save_setting('smtp_host', $host);
                save_setting('smtp_port', $port);
                save_setting('smtp_user', $user);
                save_setting('smtp_encryption', $enc);
                save_setting('smtp_from', $from);
                save_setting('smtp_from_name', $fromName);
                if ($pass !== '') {
                    save_setting('smtp_pass', $pass);
                }
                return ['success' => true, 'message' => 'SMTP Mail Server configuration saved in database!'];

            case 'alerts':
                $email = trim((string)($data['alert_email'] ?? ''));
                save_setting('alert_email', $email);
                save_setting('contact_email', $email);
                save_setting('site_email', $email);
                if (isset($data['notify_leads'])) {
                    save_setting('notify_leads', !empty($data['notify_leads']) ? '1' : '0');
                }
                if (isset($data['notify_needs_human'])) {
                    save_setting('notify_needs_human', !empty($data['notify_needs_human']) ? '1' : '0');
                }
                if (isset($data['notify_messages'])) {
                    save_setting('notify_messages', !empty($data['notify_messages']) ? '1' : '0');
                }
                return ['success' => true, 'message' => 'Email Alerts configuration saved in database!'];

            case 'cloudflare':
                $accId = trim((string)($data['account_id'] ?? ''));
                $token = trim((string)($data['api_token'] ?? ''));
                $model = trim((string)($data['model'] ?? ''));
                
                save_setting('cf_account_id', $accId);
                save_setting('cf_ai_model', $model);
                if ($token !== '') {
                    save_setting('cf_api_token', $token);
                }
                return ['success' => true, 'message' => 'Cloudflare Workers AI settings saved in database!'];

            default:
                return ['success' => false, 'error' => 'Unknown integration type.'];
        }
    }

    /**
     * Send real live SMTP test email using settings from database.
     */
    public static function testSmtp(string $toEmail): array
    {
        $phpmailerPath = BASE_PATH . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
        if (!file_exists($phpmailerPath)) {
            return ['success' => false, 'error' => 'PHPMailer library not found.'];
        }

        $host = (string) setting('smtp_host', '');
        $user = (string) setting('smtp_user', '');
        $pass = trim((string) setting('smtp_pass', ''), '"\'');
        $port = (int) setting('smtp_port', 0);
        $enc  = strtolower((string) setting('smtp_encryption', ''));
        $from = (string) setting('smtp_from', $user);
        $fromName = (string) setting('smtp_from_name', (string) setting('site_name', ''));

        if (empty($host) || empty($user) || empty($pass)) {
            return ['success' => false, 'error' => 'SMTP Host, Username, or Password is not configured in database settings.'];
        }

        require_once BASE_PATH . '/vendor/phpmailer/phpmailer/src/Exception.php';
        require_once BASE_PATH . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require_once BASE_PATH . '/vendor/phpmailer/phpmailer/src/SMTP.php';

        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = $host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $user;
            $mail->Password   = $pass;
            $mail->Port       = $port ?: 465;

            if ($enc === 'tls' || $mail->Port == 587) {
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            }

            // SSL options for local development
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];

            $mail->setFrom($from, $fromName);
            $mail->addAddress($toEmail);
            $mail->isHTML(true);
            $mail->Subject = '[Verified] SMTP Test Email — ' . ($fromName ?: 'Portfolio');
            $mail->Body    = '
            <div style="font-family: \'Segoe UI\', Roboto, Arial, sans-serif; background: #0b0c10; padding: 30px 20px; color: #fff;">
                <div style="max-width: 520px; margin: 0 auto; background: #14151d; border-radius: 14px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); padding: 25px;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(16,185,129,0.15); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 8px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <h2 style="color: #10b981; margin: 8px 0 4px;">SMTP Connection Verified!</h2>
                        <p style="color: #94a3b8; font-size: 13px; margin: 0;">This email confirms your database-driven SMTP host and credentials are fully functioning.</p>
                    </div>
                    <div style="background: rgba(255,255,255,0.03); border-radius: 10px; padding: 15px; font-size: 12.5px; color: #cbd5e1; border: 1px solid rgba(255,255,255,0.06);">
                        <p style="margin: 4px 0;"><strong>Host:</strong> ' . htmlspecialchars($mail->Host) . '</p>
                        <p style="margin: 4px 0;"><strong>Port:</strong> ' . htmlspecialchars((string)$mail->Port) . '</p>
                        <p style="margin: 4px 0;"><strong>Sender:</strong> ' . htmlspecialchars($from) . '</p>
                        <p style="margin: 4px 0;"><strong>Database Stored:</strong> Yes (settings table)</p>
                        <p style="margin: 4px 0;"><strong>Timestamp:</strong> ' . date('Y-m-d H:i:s') . '</p>
                    </div>
                </div>
            </div>';

            $mail->send();
            return ['success' => true, 'message' => "Success! Test email was dispatched to {$toEmail} using database SMTP credentials."];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
