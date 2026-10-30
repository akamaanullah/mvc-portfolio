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

        $contactPhone = setting('phone_number', '+92 319 6935307');
        $whatsappUrl = setting('whatsapp_url', 'https://api.whatsapp.com/send?phone=923196935307');
        $contactEmail = setting('contact_email', 'info@amaanullah.com');
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

### CONVERSATION FLOW & DEAL PROCESS (MANDATORY RULES)
1. **GREETINGS & CASUAL HELLOS**:
   - When a visitor simply says 'hi', 'hello', 'hey', 'salam', etc.:
     * Respond warmly, naturally, and briefly (e.g., 'Hello! I am Amaanullah, a full-stack software developer. How can I help you with your project or web application today?').
     * DO NOT dump phone numbers, email, or forms in a simple greeting. Keep it conversational.
     * NEVER append `LEAD_FORM_REQUEST:` on greetings.

2. **PROJECT INQUIRY & DISCOVERY (PHASE 1 - GATHER REQUIREMENTS FIRST!)**:
   - When a visitor says they want a website, custom CRM, web app, mobile app, or ecommerce store (e.g. 'I want a website for business', 'mujhe app banwani he', 'need a web portal'):
     * DO NOT TRIGGER ANY FORM YET! STRICTLY FORBIDDEN to ask for their name/email or output `LEAD_FORM_REQUEST:` on this initial inquiry!
     * Act like an expert, consultative developer:
       1. Warmly acknowledge what they want to build. Mention briefly that I specialize in custom PHP/Laravel, modern APIs, and tailored database systems with zero monthly per-user licensing fees.
       2. Ask 2 or 3 focused, specific questions to understand their exact project needs:
          - What specific business or industry is this for?
          - What core features do they need? (e.g. product catalog, online checkout/payments, client portal, appointment booking, admin dashboard?)
          - Do they have existing branding/designs, or do they need it built from scratch?
          - What is their ideal timeline or launch target?
     * CRITICAL RULE: IF YOUR RESPONSE ASKS QUESTIONS TO GATHER PROJECT DETAILS, YOU MUST NEVER APPEND `LEAD_FORM_REQUEST:`! You must wait for the visitor to answer first!

3. **EVALUATION & PROPOSAL (PHASE 2 - ONCE DETAILS ARE COLLECTED)**:
   - When the visitor replies and provides details about their business, features, or project scope:
     * Acknowledge their requirements with technical confidence and outline the proposed architecture in simple words.
     * Once enough project details have been gathered to clearly understand what they need (OR if the visitor explicitly asks for pricing, cost, quote, proposal, estimate, or how to get started):
       - State: 'This gives me a clear picture of what you need. Please provide your name and email below so I can prepare an exact scope breakdown and tailored proposal for you.'
       - Append the keyword: `LEAD_FORM_REQUEST:` at the very end of your response.

4. **EXPLICIT QUOTE / PRICING / CONTACT INQUIRIES**:
   - If the visitor directly asks for pricing ('how much will it cost?', 'what are your charges?', 'quote chahiye', 'kya rate hoga'):
     * Explain transparently that pricing is tailored to project scope and features.
     * Invite them to submit details with `LEAD_FORM_REQUEST:`.

5. **STRICT FORM RULES**:
   - NEVER mention Google Forms, forms.gle, Typeform, or external links! NEVER write `[insert link]` or placeholder URLs. Everything is submitted directly inside this chat!

6. **CONFIRMATION & SEE-OFF**:
   - When project details or contact info have been submitted, confirm warmly:
     'Thank you! I have received your project details. I will review everything and get in touch with you within 24 hours via email or WhatsApp.'

7. **DIRECT CONNECT & CONTACT INFO**:
   - When a visitor asks to speak with a real person, call live, or requests contact details:
     * State that I am being notified right now.
     * Share direct WhatsApp (**{$contactPhone}**) ([Chat on WhatsApp]({$whatsappUrl})) and Email (**{$contactEmail}**).

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
        $accountId = (string) setting('cf_account_id', '');
        $apiToken  = (string) setting('cf_api_token', '');
        $model     = (string) setting('cf_ai_model', '');

        if (empty($accountId) || empty($apiToken) || empty($model)) {
            $phone = (string) setting('phone_number', '');
            $email = (string) setting('contact_email', '');
            return "AI service is currently not configured. Please reach out directly" . ($phone ? " via WhatsApp ({$phone})" : "") . ($email ? " or Email ({$email})" : "") . ".";
        }

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
        $phone = (string) setting('phone_number', '');
        $email = (string) setting('contact_email', '');
        return "I'm having a brief connection issue. Please feel free to reach me directly" . ($phone ? " on WhatsApp ({$phone})" : "") . ($email ? " or email ({$email})" : "") . ".";
    }

    /**
     * Send email via PHPMailer or native mail using database credentials.
     */
    public static function sendEmail(string $to, string $subject, string $htmlBody): bool
    {
        return IntegrationService::sendEmail($to, $subject, $htmlBody);
    }

    /**
     * Send urgent email alert when a visitor requests a human takeover.
     */
    public static function sendTakeoverAlert(array $conversation, string $name, string $email, string $context = ''): bool
    {
        $adminUrl = base_url('/admin/live-chat?session=' . urlencode($conversation['session_id']));
        $subject = '[URGENT] ' . $name . ' requested a LIVE chat session';

        $body = '
        <div style="font-family: \'Segoe UI\', Roboto, Arial, sans-serif; background: #0b0c10; padding: 40px 20px; color: #fff;">
            <div style="max-width: 600px; margin: 0 auto; background: #14151d; border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08);">
                <div style="background: linear-gradient(135deg, #ef4444, #dc2626); padding: 30px; text-align: center;">
                    <h1 style="margin:0; color:#fff; font-size: 1.5rem; font-weight:800; letter-spacing:0.02em;">LIVE CHAT REQUEST</h1>
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
                            Open Live Chat Now →
                        </a>
                    </div>
                </div>
            </div>
        </div>';

        $alertEmail = (string) setting('alert_email', (string) setting('contact_email', 'akamaanullah@gmail.com'));
        if (empty($alertEmail)) return false;

        return self::sendEmail($alertEmail, $subject, $body);
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
            'model'   => (string) setting('cf_ai_model', ''),
            'reply'   => $reply
        ];
    }
}

