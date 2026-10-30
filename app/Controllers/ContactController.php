<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Logger;
use App\Models\ContactModel;

class ContactController extends Controller
{
    public function index(): string { return $this->render('contact/index'); }

    /** POST /contact — Rate limit + CSRF + honeypot + validation, then ContactModel (DB or log). JSON for fetch(), redirect otherwise. */
    public function store(): string
    {
        $in = $_POST;

        // Rate limiting: max 5 submissions per 15 minutes
        if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
            session_start();
        }
        $ip = client_ip();
        $now = time();
        $window = 15 * 60; // 15 minutes
        $maxAttempts = 5;

        $_SESSION['contact_rate_limit'] = array_filter(
            $_SESSION['contact_rate_limit'] ?? [],
            fn($timestamp) => ($now - $timestamp) < $window
        );

        if (count($_SESSION['contact_rate_limit']) >= $maxAttempts) {
            Logger::warning("Contact form rate limit exceeded for IP: {$ip}");
            return $this->wantsJson()
                ? $this->json(['message' => 'Too many requests. Please wait a few minutes before submitting again.'], 429)
                : $this->back('error=429');
        }

        if (!csrf_verify($in['_token'] ?? null)) {
            Logger::warning('Contact form: bad CSRF token');
            return $this->wantsJson() ? $this->json(['message' => 'Session expired, please reload the page.'], 419) : $this->back('error=419');
        }
        if (!empty($in['website'])) { // honeypot: humans never fill this hidden field
            Logger::info('Contact form: honeypot triggered');
            return $this->wantsJson() ? $this->json(['message' => 'Thanks!']) : $this->back('sent=1');
        }
        $errors = [];
        if (sanitize($in['name'] ?? '') === '') $errors['name'] = 'Please enter your name.';
        if (!filter_var($in['email'] ?? '', FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Please enter a valid email.';
        if ($errors) {
            return $this->wantsJson() ? $this->json(['message' => 'Please fix the highlighted fields.', 'errors' => $errors], 422) : $this->back('error=422');
        }

        $_SESSION['contact_rate_limit'][] = $now;

        $data = array_intersect_key($in, array_flip(ContactModel::FIELDS));
        ContactModel::create($data);

        // Dispatch instant email notification to admin & confirmation to client
        try {
            $alertEmail = (string) setting('alert_email', (string) setting('contact_email', 'akamaanullah@gmail.com'));
            $name = $data['name'] ?? 'Potential Client';
            $email = $data['email'] ?? '';
            $phone = $data['phone'] ?? '';
            $company = $data['company'] ?? '';
            $service = $data['service'] ?? '';
            $projectType = $data['project_type'] ?? '';
            $budget = $data['budget'] ?? '';
            $timeline = $data['timeline'] ?? '';
            $preferredContact = $data['preferred_contact'] ?? '';
            $message = $data['message'] ?? $data['description'] ?? '';

            $subject = "New Inquiry: {$name}" . ($service ? " — " . ucfirst($service) : ($projectType ? " — " . ucfirst($projectType) : ""));

            $adminBody = '
            <div style="font-family: \'Segoe UI\', Roboto, Arial, sans-serif; background: #0b0c10; padding: 35px 20px; color: #fff;">
                <div style="max-width: 600px; margin: 0 auto; background: #14151d; border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 12px 40px rgba(0,0,0,0.5);">
                    <div style="background: linear-gradient(135deg, #f26a1b, #ff8a3d); padding: 25px 30px; text-align: left;">
                        <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.85); display: block; margin-bottom: 4px;">Website Inquiry Received</span>
                        <h1 style="margin: 0; color: #fff; font-size: 1.45rem; font-weight: 800; letter-spacing: -0.01em;">New Project Contact</h1>
                    </div>
                    <div style="padding: 30px;">
                        <table style="width: 100%; border-collapse: collapse; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); overflow: hidden;">
                            <tr><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; width: 120px;">Name</td><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); font-weight: 700; color: #fff;">' . htmlspecialchars($name) . '</td></tr>
                            <tr><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Email</td><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06);"><a href="mailto:' . htmlspecialchars($email) . '" style="color: #f26a1b; font-weight: 600; text-decoration: none;">' . htmlspecialchars($email) . '</a></td></tr>
                            ' . ($phone ? '<tr><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Phone</td><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #cbd5e1;">' . htmlspecialchars($phone) . '</td></tr>' : '') . '
                            ' . ($company ? '<tr><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Company</td><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #cbd5e1;">' . htmlspecialchars($company) . '</td></tr>' : '') . '
                            ' . ($service ? '<tr><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Service</td><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #fff; font-weight: 600;">' . htmlspecialchars($service) . '</td></tr>' : '') . '
                            ' . ($projectType ? '<tr><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Project Type</td><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #cbd5e1;">' . htmlspecialchars($projectType) . '</td></tr>' : '') . '
                            ' . ($budget ? '<tr><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Budget</td><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #10b981; font-weight: 600;">' . htmlspecialchars($budget) . '</td></tr>' : '') . '
                            ' . ($timeline ? '<tr><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Timeline</td><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #cbd5e1;">' . htmlspecialchars($timeline) . '</td></tr>' : '') . '
                            ' . ($preferredContact ? '<tr><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Channel</td><td style="padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); color: #cbd5e1;">' . htmlspecialchars($preferredContact) . '</td></tr>' : '') . '
                            <tr><td style="padding: 12px 18px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">IP &amp; Time</td><td style="padding: 12px 18px; color: #94a3b8; font-size: 12px;">' . client_ip() . ' · ' . date('M j, Y H:i:s') . '</td></tr>
                        </table>
                        ' . ($message ? '
                        <div style="margin-top: 20px;">
                            <h4 style="margin: 0 0 8px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: #94a3b8;">Project Brief / Message:</h4>
                            <div style="background: rgba(255,255,255,0.03); border-radius: 10px; padding: 16px; font-size: 13.5px; line-height: 1.6; color: #e2e8f0; border: 1px solid rgba(255,255,255,0.06); white-space: pre-wrap;">' . htmlspecialchars($message) . '</div>
                        </div>' : '') . '
                        <div style="margin-top: 28px; text-align: center;">
                            <a href="' . base_url('/admin/messages') . '" style="display: inline-block; background: linear-gradient(135deg, #f26a1b, #ff8a3d); color: #fff; text-decoration: none; padding: 14px 32px; border-radius: 10px; font-weight: 700; font-size: 0.95rem; box-shadow: 0 6px 20px rgba(242,106,27,0.35);">
                                View In Admin Dashboard →
                            </a>
                        </div>
                    </div>
                </div>
            </div>';

            \App\Services\IntegrationService::sendEmail(
                $alertEmail,
                $subject,
                $adminBody,
                strip_tags($adminBody),
                'Amaanullah Khan',
                $email,
                $name
            );

            // Optional client confirmation
            if (!empty($email)) {
                $clientSubject = "Thank you for contacting Amaanullah Khan";
                $clientBody = '
                <div style="font-family: \'Segoe UI\', Roboto, Arial, sans-serif; background: #0b0c10; padding: 35px 20px; color: #fff;">
                    <div style="max-width: 580px; margin: 0 auto; background: #14151d; border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); padding: 30px;">
                        <div style="margin-bottom: 24px;">
                            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #f26a1b; display: block; margin-bottom: 6px;">Inquiry Confirmed</span>
                            <h2 style="margin: 0; color: #fff; font-size: 1.4rem; font-weight: 800;">Hi ' . htmlspecialchars($name) . ',</h2>
                        </div>
                        <p style="color: #cbd5e1; font-size: 14px; line-height: 1.6; margin: 0 0 16px;">
                            Thank you for reaching out! I have received your project details and will review your requirements thoroughly.
                        </p>
                        <p style="color: #cbd5e1; font-size: 14px; line-height: 1.6; margin: 0 0 20px;">
                            I typically reply within <strong>24 business hours</strong> with technical insights, feasibility notes, and clear next steps.
                        </p>
                        ' . ($message ? '
                        <div style="background: rgba(255,255,255,0.03); border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; border: 1px solid rgba(255,255,255,0.06);">
                            <strong style="color: #94a3b8; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 4px;">Summary of your message:</strong>
                            <p style="margin: 0; font-size: 13px; color: #cbd5e1; font-style: italic;">"' . htmlspecialchars(mb_substr($message, 0, 300)) . (mb_strlen($message) > 300 ? '...' : '') . '"</p>
                        </div>' : '') . '
                        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 20px; margin-top: 20px;">
                            <strong style="color: #fff; font-size: 14px; display: block;">Amaanullah Khan</strong>
                            <span style="color: #94a3b8; font-size: 12px; display: block; margin-bottom: 8px;">Full-Stack Architect &amp; Software Consultant</span>
                            <a href="https://api.whatsapp.com/send?phone=923196935307" style="color: #25d366; text-decoration: none; font-size: 12.5px; font-weight: 600;">Chat on WhatsApp →</a>
                        </div>
                    </div>
                </div>';

                \App\Services\IntegrationService::sendEmail(
                    $email,
                    $clientSubject,
                    $clientBody,
                    strip_tags($clientBody),
                    $name,
                    'info@amaanullah.com',
                    'Amaanullah Khan'
                );
            }
        } catch (\Throwable $e) {
            Logger::error('Contact form email notification failed: ' . $e->getMessage());
        }

        return $this->wantsJson() ? $this->json(['message' => "Thanks! I'll get back to you soon."]) : $this->back('sent=1');
    }

    private function back(string $qs): string { redirect('/contact?' . $qs); return ''; }
}
