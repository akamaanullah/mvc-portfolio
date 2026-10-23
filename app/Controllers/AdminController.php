<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Logger;

class AdminController extends Controller
{
    /** URL slug => [view key, title, active nav key, uses block editor, is bare (no sidebar/topbar)] */
    private const PAGES = [
        'login'           => ['login', 'Sign in', '', false, true],
        'forgot-password' => ['forgot-password', 'Forgot password', '', false, true],
        'articles'        => ['articles', 'Articles', 'articles', false, false],
        'projects'        => ['projects', 'Projects', 'projects', false, false],
        'services'        => ['services', 'Services', 'services', false, false],
        'landing-pages'   => ['landing-pages', 'Landing pages', 'landing-pages', false, false],
        'categories'      => ['categories', 'Categories & tags', 'categories', false, false],
        'media'           => ['media', 'Media library', 'media', false, false],
        'leads'           => ['leads', 'Chat leads', 'leads', false, false],
        'messages'        => ['messages', 'Contact messages', 'messages', false, false],
        'analytics'       => ['analytics', 'Internal stats', 'analytics', false, false],
        'visitors'        => ['visitors', 'Visitors', 'visitors', false, false],
        'search-console'  => ['search-console', 'Search Console', 'search-console', false, false],
        'performance'     => ['performance', 'Performance', 'performance', false, false],
        'live-chat'       => ['live-chat', 'Live chat', 'live-chat', false, false],
        'settings'        => ['settings', 'Settings', 'settings', false, false],
        'profile'         => ['profile', 'Profile', 'profile', false, false],
    ];

    /** "section/action" => same tuple */
    private const SUB = [
        'articles/create'     => ['article-edit', 'New article', 'articles', true, false],
        'articles/edit'       => ['article-edit', 'Edit article', 'articles', true, false],
        'projects/create'     => ['project-edit', 'New project', 'projects', true, false],
        'projects/edit'       => ['project-edit', 'Edit project', 'projects', true, false],
        'services/edit'       => ['service-edit', 'Edit service', 'services', true, false],
        'landing-pages/edit'  => ['landing-edit', 'Edit landing page', 'landing-pages', true, false],
        'analytics/page'      => ['page-analytics', 'Page analytics', 'analytics', false, false],
        'visitors/show'       => ['visitor', 'Visitor profile', 'visitors', false, false],
    ];

    public function index(): string
    {
        $this->requireAuth();
        return $this->screen(['index', 'Dashboard', 'index', false, false]);
    }

    public function page(string $page): string
    {
        // Publicly accessible auth screens
        if ($page === 'login' || $page === 'forgot-password') {
            if (Auth::check()) {
                redirect('/admin');
            }
            return $this->screen(self::PAGES[$page] ?? null);
        }

        $this->requireAuth();
        return $this->screen(self::PAGES[$page] ?? null);
    }

    public function sub(string $section, string $action): string
    {
        $this->requireAuth();
        return $this->screen(self::SUB[$section . '/' . $action] ?? null);
    }

    /**
     * POST /admin/login — Verify CSRF, authenticate, and respond with JSON or redirect.
     */
    public function postLogin(): string
    {
        Auth::start();

        $token = $_POST['_token'] ?? null;
        if (!csrf_verify($token)) {
            Logger::warning('Admin login: CSRF verification failed');
            if ($this->wantsJson()) {
                return $this->json(['success' => false, 'error' => 'Security token expired. Please refresh the page.'], 419);
            }
            $_SESSION['auth_error'] = 'Security token expired. Please reload and try again.';
            redirect('/admin/login');
        }

        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $msg = 'Please enter both email and password.';
            if ($this->wantsJson()) {
                return $this->json(['success' => false, 'error' => $msg], 422);
            }
            $_SESSION['auth_error'] = $msg;
            redirect('/admin/login');
        }

        $result = Auth::attempt($email, $password);

        if (!$result['success']) {
            if ($this->wantsJson()) {
                return $this->json(['success' => false, 'error' => $result['error']], 401);
            }
            $_SESSION['auth_error'] = $result['error'];
            redirect('/admin/login');
        }

        if ($this->wantsJson()) {
            return $this->json([
                'success' => true,
                'message' => 'Signed in successfully!',
                'redirect' => base_url('/admin')
            ]);
        }

        redirect('/admin');
        return '';
    }

    /**
     * GET / POST /admin/logout
     */
    public function logout(): string
    {
        Auth::logout();
        redirect('/admin/login');
        return '';
    }

    /**
     * Enforce authentication on protected admin endpoints.
     */
    private function requireAuth(): void
    {
        if (!Auth::check()) {
            redirect('/admin/login');
        }
    }

    private function screen(?array $p): string
    {
        if ($p === null) {
            http_response_code(404);
            $p = ['404', 'Page not found', '', false, false];
        }

        [$key, $title, $active, $editor, $bare] = $p;
        header('X-Robots-Tag: noindex, nofollow');

        $currentUser = Auth::user();
        $error = $_SESSION['auth_error'] ?? null;
        unset($_SESSION['auth_error']);

        $content = view('admin/pages/' . $key, [
            'currentUser' => $currentUser,
            'authError' => $error,
        ]);

        return $this->render('admin/layouts/app', compact('title', 'active', 'editor', 'bare', 'content', 'currentUser'));
    }
}
