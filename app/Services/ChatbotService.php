<?php
namespace App\Services;

use App\Core\Logger;
use App\Models\ServiceModel;
use App\Models\ProjectModel;

class ChatbotService
{
    /**
     * Check if visitor is asking to talk with a real person / human agent.
     */
    public static function isHumanRequested(string $message): bool
    {
        $keywords = [
            'real human', 'real person', 'talk to someone', 'speak to a person',
            'speak to someone', 'human support', 'talk to you', 'talk to amaanullah',
            'connect me', 'live chat', 'real agent', 'actual person', 'not a bot',
            'talk live', 'speak live', 'human help', 'can i talk to you', 'call me',
            'human please', 'insaan se baat', 'live agent', 'human agent'
        ];
        $lower = strtolower($message);
        foreach ($keywords as $kw) {
            if (str_contains($lower, $kw)) return true;
        }
        return false;
    }

    /**
     * Build rich system prompt with portfolio data, services, and persona.
     */
    public static function getSystemPrompt(): string
    {
        $brainFile = BASE_PATH . '/config/brain.json';
        $brain = file_exists($brainFile) ? json_decode(file_get_contents($brainFile), true) : [];

        $contactPhone = env('CONTACT_PHONE', '+92 319 6935307');
        $whatsappUrl = env('CONTACT_WHATSAPP', 'https://api.whatsapp.com/send?phone=923196935307');
        $contactEmail = env('CONTACT_EMAIL', 'info@amaanullah.com');
        $contactLoc = "Karachi, Pakistan (Serving clients worldwide: USA, UAE, UK, Europe, Australia, etc.)";
        $contactPage = base_url('/contact');

        // Dynamic services summary
        $services = ServiceModel::all();
        $servicesList = [];
        foreach ($services as $s) {
            $servicesList[] = [
                'title' => $s['title'],
                'url' => base_url('/services/' . $s['slug']),
                'summary' => $s['summary'] ?? ''
            ];
        }

        // Dynamic projects summary
        $projects = ProjectModel::all('is_featured DESC, id DESC LIMIT 6');
        $projectsList = [];
        foreach ($projects as $p) {
            $projectsList[] = [
                'title' => $p['title'],
                'url' => base_url('/projects/' . $p['slug']),
                'summary' => $p['summary'] ?? ''
            ];
        }

        return "
### IDENTITY & PERSONA
- You are Amaanullah (@akamaanullah), Full-Stack Software Developer & Web Application Specialist based in Karachi, Pakistan.
- Tone: Friendly, polite, helpful, simple, clear, and professional.
- Speak naturally like a real human software developer using 'I', 'My', and 'Me'. NEVER say 'We' or 'Our'.
- CRITICAL: Use plain, simple everyday words. NEVER use complex buzzwords or heavy jargon (DO NOT say 'Strategic Systems Architect', 'strategic proxy', 'clinical pacing', 'predictive ecosystem', 'recalibrating', etc.).
- Multi-lingual capability: If the visitor asks in Roman Urdu, Urdu, or Hindi (e.g. 'contact no do', 'kese rabta kru', 'mujhe website banwani hai'), reply naturally and politely in conversational Roman Urdu or English.

### DIRECT CONTACT DETAILS
- **Phone / WhatsApp**: {$contactPhone}
- **Direct WhatsApp Link**: {$whatsappUrl}
- **Email**: {$contactEmail}
- **Location**: {$contactLoc}
- **Contact Page**: {$contactPage}

### HOW TO RESPOND TO COMMON QUERIES
1. **GREETINGS & CASUAL HELLOS (CRITICAL)**:
   - When a visitor simply says 'hi', 'hello', 'hey', 'salam', 'good morning', etc.:
     * Respond warmly, naturally, and briefly (e.g., 'Hello! I am Amaanullah, a full-stack software developer. How can I help you with your project or web application today?').
     * **DO NOT share phone numbers, WhatsApp, or email in a basic greeting.** Keep it light and conversational.

2. **CONTACT NUMBER / WHATSAPP / CALL / EMAIL (ONLY WHEN ASKED)**:
   - When a visitor asks for phone, contact number, WhatsApp, call, email, or how to reach out:
     * Immediately share my direct WhatsApp/Phone (**{$contactPhone}**) ([Chat on WhatsApp]({$whatsappUrl})) and Email (**{$contactEmail}**).
     * Ask what project or requirement they have in mind.
     * NEVER refuse, and NEVER say contact numbers cannot be shared.

3. **SERVICES & STACK**:
   - Custom CRM & Business Systems: Tailor-made CRM/HRM built for specific business workflows with zero recurring per-user fees.
   - Web App & Laravel Development: Fast, secure web applications, portals, and SaaS platforms.
   - AI Automation & API Integrations: Automating business workflows, chatbots, and connecting software systems.
   - Mobile App Development: Clean mobile apps for iOS and Android built with Flutter & Firebase.

4. **TALKING ABOUT A PROJECT / PRICING / TIMELINE**:
   - Keep answers simple and straight to the point (2-3 short paragraphs max).
   - Ask 1 or 2 simple questions to understand what they need (e.g. key features, timeline).
   - If they want to talk directly or schedule a call, suggest a quick WhatsApp call or Google Meet.

5. **LEAD FORM & CLOSING**:
   - When the user is ready to share details or request a proposal, you can include: 'LEAD_FORM_REQUEST:'
   - After they submit details: 'Thank you! I have received your project details. I will review everything and get back to you within 24 hours via email or WhatsApp.' Append 'DEAL_CLOSE: [summary]'.

### KNOWLEDGE BASE
- Services: " . json_encode($servicesList) . "
- Featured Portfolio Projects: " . json_encode($projectsList) . "
- Bio & Background: " . ($brain['identity']['bio'] ?? 'Full-Stack Software Developer with 6+ years experience.') . "
";
    }

    /**
     * Send messages to Cloudflare Workers AI model.
     */
    public static function ask(string $userMessage, array $history = []): string
    {
        $accountId = env('CF_ACCOUNT_ID', '9f63cf53ac893a6a5f2725278f7f86d3');
        $apiToken  = env('CF_API_TOKEN', 'IBC_S6M6VaP-os0EOJF6CeK-0lunySidP-crvIEf');
        $model     = env('CF_AI_MODEL', '@cf/meta/llama-3.1-8b-instruct-fast');

        $url = "https://api.cloudflare.com/client/v4/accounts/{$accountId}/ai/run/{$model}";

        $systemPrompt = self::getSystemPrompt();

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];

        // Add last 8 messages for context
        $history = array_slice($history, -8);
        foreach ($history as $msg) {
            if (!empty($msg['role']) && !empty($msg['content'])) {
                $role = in_array($msg['role'], ['user', 'visitor']) ? 'user' : 'assistant';
                $messages[] = ['role' => $role, 'content' => (string)$msg['content']];
            }
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        $payload = [
            'messages' => $messages,
            'max_tokens' => 450,
            'temperature' => 0.5
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiToken
            ],
            CURLOPT_TIMEOUT        => 15
        ]);

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($code === 200 && !empty($response)) {
            $json = json_decode($response, true);
            $aiText = $json['result']['response'] ?? $json['result']['choices'][0]['message']['content'] ?? null;
            if (!empty($aiText)) {
                return trim($aiText);
            }
        }

        Logger::warning('Cloudflare AI request failed', ['code' => $code, 'error' => $err, 'resp' => $response]);
        return "I'm having a brief connection issue. Please feel free to reach me directly on WhatsApp (+92 319 6935307) or email (info@amaanullah.com).";
    }

    /**
     * Send email via PHPMailer or native mail.
     */
    public static function sendEmail(string $to, string $subject, string $htmlBody): bool
    {
        $phpmailerPath = BASE_PATH . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
        if (file_exists($phpmailerPath)) {
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
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = (int)env('SMTP_PORT', 465);

                $mail->setFrom(env('SMTP_FROM', 'akamaanullah@gmail.com'), env('SMTP_FROM_NAME', 'Amaanullah Khan Portfolio'));
                $mail->addAddress($to);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $htmlBody;

                return $mail->send();
            } catch (\Throwable $e) {
                Logger::error('SMTP Send Failed: ' . $e->getMessage());
            }
        }

        // Fallback to mail()
        $headers = "MIME-Version: 1.0\r\nContent-type:text/html;charset=UTF-8\r\nFrom: " . env('SMTP_FROM', 'info@amaanullah.com') . "\r\n";
        return @mail($to, $subject, $htmlBody, $headers);
    }

    /**
     * Send urgent email alert when a visitor requests a human takeover.
     */
    public static function sendTakeoverAlert(array $conversation, string $name, string $email, string $context = ''): bool
    {
        $adminUrl = base_url('/admin/live-chat?session=' . urlencode($conversation['session_id']));
        $subject = '🔴 URGENT: ' . $name . ' wants to talk LIVE right now!';

        $body = '
        <div style="font-family: \'Segoe UI\', Roboto, Arial, sans-serif; background: #0b0c10; padding: 40px 20px; color: #fff;">
            <div style="max-width: 600px; margin: 0 auto; background: #14151d; border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08);">
                <div style="background: linear-gradient(135deg, #ef4444, #dc2626); padding: 30px; text-align: center;">
                    <h1 style="margin:0; color:#fff; font-size: 1.5rem; font-weight:800;">🔴 LIVE CHAT REQUEST</h1>
                    <p style="color:rgba(255,255,255,0.9); margin: 8px 0 0; font-size: 0.95rem;">A visitor requested to speak with you <strong>right now!</strong></p>
                </div>
                <div style="padding: 30px;">
                    <table style="width:100%; border-collapse:collapse; background:rgba(255,255,255,0.02); border-radius:12px; border:1px solid rgba(255,255,255,0.06); overflow:hidden;">
                        <tr><td style="padding:14px 18px; border-bottom:1px solid rgba(255,255,255,0.06); color:#94a3b8; font-size:0.75rem; text-transform:uppercase; width:100px;">Name</td><td style="padding:14px 18px; border-bottom:1px solid rgba(255,255,255,0.06); font-weight:700; color:#fff;">' . htmlspecialchars($name) . '</td></tr>
                        <tr><td style="padding:14px 18px; border-bottom:1px solid rgba(255,255,255,0.06); color:#94a3b8; font-size:0.75rem; text-transform:uppercase;">Email</td><td style="padding:14px 18px; border-bottom:1px solid rgba(255,255,255,0.06);"><a href="mailto:' . htmlspecialchars($email) . '" style="color:#f26a1b; font-weight:600;">' . htmlspecialchars($email) . '</a></td></tr>
                        <tr><td style="padding:14px 18px; color:#94a3b8; font-size:0.75rem; text-transform:uppercase;">Time</td><td style="padding:14px 18px; color:#cbd5e1;">' . date('M j, Y H:i:s') . '</td></tr>
                    </table>
                    ' . ($context ? '<div style="margin-top:20px; padding:15px; background:rgba(255,255,255,0.03); border-radius:10px; font-size:0.85rem; color:#94a3b8; white-space:pre-wrap;">' . htmlspecialchars($context) . '</div>' : '') . '
                    <div style="margin-top: 30px; text-align: center;">
                        <a href="' . $adminUrl . '" style="display:inline-block; background:linear-gradient(135deg, #f26a1b, #ff8a3d); color:#fff; text-decoration:none; padding:16px 36px; border-radius:12px; font-weight:800; font-size:1rem; box-shadow:0 6px 20px rgba(242,106,27,0.35);">
                            👉 Open Live Chat Now
                        </a>
                    </div>
                </div>
            </div>
        </div>';

        return self::sendEmail(env('SMTP_USER', 'akamaanullah@gmail.com'), $subject, $body);
    }

    /**
     * Test Cloudflare AI connection and return latency + test response.
     */
    public static function testConnection(): array
    {
        $start = microtime(true);
        $testPrompt = "Hi! Quick connection check from admin settings. In 1 short polite sentence, introduce yourself.";
        $reply = self::ask($testPrompt, []);
        $elapsed = round((microtime(true) - $start) * 1000);

        return [
            'success' => true,
            'latency' => $elapsed . 'ms',
            'model'   => env('CF_AI_MODEL', '@cf/meta/llama-3.1-8b-instruct-fast'),
            'reply'   => $reply
        ];
    }
}

