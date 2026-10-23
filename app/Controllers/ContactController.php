<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Logger;
use App\Models\ContactModel;

class ContactController extends Controller
{
    public function index(): string { return $this->render('contact/index'); }

    /** POST /contact — CSRF + honeypot + validation, then ContactModel (DB or log). JSON for fetch(), redirect otherwise. */
    public function store(): string
    {
        $in = $_POST;
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
        ContactModel::create($in);
        return $this->wantsJson() ? $this->json(['message' => "Thanks! I'll get back to you soon."]) : $this->back('sent=1');
    }

    private function back(string $qs): string { redirect('/contact?' . $qs); return ''; }
}
