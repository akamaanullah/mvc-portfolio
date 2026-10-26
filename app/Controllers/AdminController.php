<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Logger;
use App\Models\ArticleModel;
use App\Models\CategoryModel;
use App\Models\ContactModel;
use App\Models\LeadModel;
use App\Models\ProjectModel;
use App\Models\ServiceModel;

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
        if (!headers_sent()) {
            header('X-Robots-Tag: noindex, nofollow');
        }

        $currentUser = Auth::user();
        $error = $_SESSION['auth_error'] ?? null;
        unset($_SESSION['auth_error']);

        $viewData = [
            'currentUser' => $currentUser,
            'authError' => $error,
        ];

        switch ($key) {
            case 'index':
                $viewData['projectsCount'] = ProjectModel::count();
                $viewData['articlesCount'] = ArticleModel::count();
                $viewData['leadsCount'] = LeadModel::count();
                $viewData['messagesCount'] = ContactModel::count();
                $viewData['recentProjects'] = ProjectModel::all('id DESC LIMIT 5');
                $viewData['recentArticles'] = ArticleModel::all('id DESC LIMIT 5');
                break;

            case 'projects':
                $viewData['projects'] = ProjectModel::all('sort_order ASC, id DESC');
                $viewData['categories'] = CategoryModel::where('type', 'project');
                break;

            case 'project-edit':
                $id = $_GET['id'] ?? null;
                $slug = $_GET['slug'] ?? null;
                $viewData['project'] = $id ? ProjectModel::findById($id) : ($slug ? ProjectModel::find($slug) : null);
                $viewData['categories'] = CategoryModel::where('type', 'project');
                $viewData['allProjects'] = ProjectModel::all('title ASC');
                break;

            case 'articles':
                $viewData['articles'] = ArticleModel::all('published_at DESC, id DESC');
                $viewData['categories'] = CategoryModel::where('type', 'article');
                break;

            case 'article-edit':
                $id = $_GET['id'] ?? null;
                $slug = $_GET['slug'] ?? null;
                $viewData['article'] = $id ? ArticleModel::findById($id) : ($slug ? ArticleModel::find($slug) : null);
                $viewData['categories'] = CategoryModel::where('type', 'article');
                $viewData['allArticles'] = ArticleModel::all('title ASC');
                break;

            case 'services':
                $viewData['services'] = ServiceModel::all('sort_order ASC, id ASC');
                break;

            case 'service-edit':
                $id = $_GET['id'] ?? null;
                $slug = $_GET['slug'] ?? null;
                $viewData['service'] = $id ? ServiceModel::findById($id) : ($slug ? ServiceModel::find($slug) : null);
                $viewData['allServices'] = ServiceModel::all('title ASC');
                break;

            case 'categories':
                $viewData['categories'] = CategoryModel::all('type ASC, sort_order ASC');
                break;

            case 'messages':
                $viewData['messages'] = ContactModel::all('created_at DESC');
                break;

            case 'leads':
                $viewData['leads'] = LeadModel::all('created_at DESC');
                break;
        }

        $content = view('admin/pages/' . $key, $viewData);

        return $this->render('admin/layouts/app', compact('title', 'active', 'editor', 'bare', 'content', 'currentUser'));
    }

    private function verifyAdminCsrf(): bool
    {
        $token = $_POST['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
        if (!$token) {
            $input = json_decode(file_get_contents('php://input'), true);
            $token = $input['_token'] ?? null;
        }
        return csrf_verify($token);
    }

    private function getPayload(): array
    {
        $data = $_POST;
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            $json = json_decode(file_get_contents('php://input'), true);
            if (is_array($json)) {
                $data = array_merge($data, $json);
            }
        }
        return $data;
    }

    public function saveProject(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired. Please reload the page.'], 419);
        }

        try {
            $p = $this->getPayload();
            $title = trim((string)($p['title'] ?? ''));
            if ($title === '') {
                return $this->json(['success' => false, 'error' => 'Project title is required.'], 422);
            }

            $slug = trim((string)($p['slug'] ?? ''));
            if ($slug === '') {
                $slug = $title;
            }
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug), '-'));
            if ($slug === '') {
                $slug = 'project-' . time();
            }

            $id = !empty($p['id']) ? (int)$p['id'] : null;

            $existing = ProjectModel::find($slug);
            if ($existing && (!$id || (int)$existing['id'] !== $id)) {
                $slug .= '-' . time();
            }

            $status = in_array($p['status'] ?? '', ['draft', 'in_review', 'scheduled', 'published', 'trash'], true) ? $p['status'] : 'published';

            $data = [
                'title' => $title,
                'slug' => $slug,
                'category_slug' => trim((string)($p['category_slug'] ?? $p['category'] ?? 'web-applications')),
                'highlight_em' => trim((string)($p['highlight_em'] ?? $p['em'] ?? '')),
                'domain' => trim((string)($p['domain'] ?? '')),
                'summary' => trim((string)($p['summary'] ?? '')),
                'banner' => trim((string)($p['banner'] ?? $p['cover'] ?? 'images/banners/chatrox.svg')),
                'banner_alt' => trim((string)($p['banner_alt'] ?? $p['coverAlt'] ?? '')),
                'client' => trim((string)($p['client'] ?? '')),
                'industry' => trim((string)($p['industry'] ?? '')),
                'role' => trim((string)($p['role'] ?? '')),
                'timeline' => trim((string)($p['timeline'] ?? '')),
                'platform' => trim((string)($p['platform'] ?? '')),
                'project_status' => trim((string)($p['project_status'] ?? 'Completed')),
                'tech_chips' => trim((string)($p['tech_chips'] ?? $p['chips'] ?? '')),
                'tldr' => trim((string)($p['tldr'] ?? '')),
                'key_results' => trim((string)($p['key_results'] ?? $p['results'] ?? '')),
                'body_json' => !empty($p['body_json']) ? (is_array($p['body_json']) ? json_encode($p['body_json']) : (string)$p['body_json']) : null,
                'body_html' => trim((string)($p['body_html'] ?? '')),
                'status' => $status,
                'published_at' => !empty($p['published_at']) ? date('Y-m-d H:i:s', strtotime($p['published_at'])) : ($status === 'published' ? date('Y-m-d H:i:s') : null),
                'is_featured' => !empty($p['is_featured']) ? 1 : 0,
                'show_on_home' => !empty($p['show_on_home']) ? 1 : 0,
                'cta_title' => trim((string)($p['cta_title'] ?? $p['ctaTitle'] ?? '')),
                'cta_text' => trim((string)($p['cta_text'] ?? $p['ctaText'] ?? '')),
                'cta_label' => trim((string)($p['cta_label'] ?? $p['ctaLabel'] ?? '')),
                'focus_keyword' => trim((string)($p['focus_keyword'] ?? '')),
                'seo_title' => trim((string)($p['seo_title'] ?? '')),
                'meta_description' => trim((string)($p['meta_description'] ?? '')),
                'canonical_url' => trim((string)($p['canonical_url'] ?? '')),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($id) {
                ProjectModel::update($id, $data);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $id = ProjectModel::create($data);
            }

            return $this->json([
                'success' => true,
                'message' => 'Project saved successfully!',
                'id' => $id,
                'slug' => $slug,
                'redirect' => base_url('/admin/projects/edit?id=' . $id)
            ]);
        } catch (\Throwable $e) {
            Logger::error('Admin saveProject error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to save project. Please check server logs.'], 500);
        }
    }

    public function deleteProject(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            if ($id <= 0) {
                return $this->json(['success' => false, 'error' => 'Invalid project ID.'], 422);
            }

            ProjectModel::delete($id);
            return $this->json(['success' => true, 'message' => 'Project deleted successfully.']);
        } catch (\Throwable $e) {
            Logger::error('Admin deleteProject error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to delete project.'], 500);
        }
    }

    public function toggleProjectFeatured(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            $featured = !empty($p['is_featured']) ? 1 : 0;

            ProjectModel::update($id, ['is_featured' => $featured, 'updated_at' => date('Y-m-d H:i:s')]);
            return $this->json([
                'success' => true,
                'message' => $featured ? 'Marked as featured' : 'Removed from featured'
            ]);
        } catch (\Throwable $e) {
            Logger::error('Admin toggleProjectFeatured error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to toggle status.'], 500);
        }
    }

    public function saveArticle(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired. Please reload the page.'], 419);
        }

        try {
            $p = $this->getPayload();
            $title = trim((string)($p['title'] ?? ''));
            if ($title === '') {
                return $this->json(['success' => false, 'error' => 'Article title is required.'], 422);
            }

            $slug = trim((string)($p['slug'] ?? ''));
            if ($slug === '') {
                $slug = $title;
            }
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug), '-'));
            if ($slug === '') {
                $slug = 'article-' . time();
            }

            $id = !empty($p['id']) ? (int)$p['id'] : null;

            $existing = ArticleModel::find($slug);
            if ($existing && (!$id || (int)$existing['id'] !== $id)) {
                $slug .= '-' . time();
            }

            $status = in_array($p['status'] ?? '', ['draft', 'in_review', 'scheduled', 'published', 'trash'], true) ? $p['status'] : 'published';

            $data = [
                'title' => $title,
                'slug' => $slug,
                'category_slug' => trim((string)($p['category_slug'] ?? $p['category'] ?? 'laravel-php')),
                'badge_category' => trim((string)($p['badge_category'] ?? $p['category'] ?? '')),
                'badge_type' => trim((string)($p['badge_type'] ?? $p['type'] ?? 'Guide')),
                'cover_image' => trim((string)($p['cover_image'] ?? $p['cover'] ?? '')),
                'cover_alt' => trim((string)($p['cover_alt'] ?? $p['coverAlt'] ?? '')),
                'excerpt' => trim((string)($p['excerpt'] ?? $p['summary'] ?? '')),
                'body_json' => !empty($p['body_json']) ? (is_array($p['body_json']) ? json_encode($p['body_json']) : (string)$p['body_json']) : null,
                'body_html' => trim((string)($p['body_html'] ?? '')),
                'tags' => trim((string)($p['tags'] ?? '')),
                'status' => $status,
                'published_at' => !empty($p['published_at']) ? date('Y-m-d H:i:s', strtotime($p['published_at'])) : ($status === 'published' ? date('Y-m-d H:i:s') : null),
                'reading_time' => trim((string)($p['reading_time'] ?? '5 min')),
                'focus_keyword' => trim((string)($p['focus_keyword'] ?? '')),
                'seo_title' => trim((string)($p['seo_title'] ?? '')),
                'meta_description' => trim((string)($p['meta_description'] ?? '')),
                'canonical_url' => trim((string)($p['canonical_url'] ?? '')),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($id) {
                ArticleModel::update($id, $data);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $id = ArticleModel::create($data);
            }

            return $this->json([
                'success' => true,
                'message' => 'Article saved successfully!',
                'id' => $id,
                'slug' => $slug,
                'redirect' => base_url('/admin/articles/edit?id=' . $id)
            ]);
        } catch (\Throwable $e) {
            Logger::error('Admin saveArticle error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to save article. Please check server logs.'], 500);
        }
    }

    public function deleteArticle(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            if ($id <= 0) {
                return $this->json(['success' => false, 'error' => 'Invalid article ID.'], 422);
            }

            ArticleModel::delete($id);
            return $this->json(['success' => true, 'message' => 'Article deleted successfully.']);
        } catch (\Throwable $e) {
            Logger::error('Admin deleteArticle error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to delete article.'], 500);
        }
    }

    public function saveService(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired. Please reload the page.'], 419);
        }

        try {
            $p = $this->getPayload();
            $title = trim((string)($p['title'] ?? ''));
            if ($title === '') {
                return $this->json(['success' => false, 'error' => 'Service title is required.'], 422);
            }

            $slug = trim((string)($p['slug'] ?? ''));
            if ($slug === '') {
                $slug = $title;
            }
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug), '-'));
            if ($slug === '') {
                $slug = 'service-' . time();
            }

            $id = !empty($p['id']) ? (int)$p['id'] : null;

            $existing = ServiceModel::find($slug);
            if ($existing && (!$id || (int)$existing['id'] !== $id)) {
                $slug .= '-' . time();
            }

            $status = in_array($p['status'] ?? '', ['draft', 'published', 'archived'], true) ? $p['status'] : 'published';

            $data = [
                'title' => $title,
                'slug' => $slug,
                'highlight_em' => trim((string)($p['highlight_em'] ?? '')),
                'summary' => trim((string)($p['summary'] ?? '')),
                'tags' => trim((string)($p['tags'] ?? '')),
                'banner' => trim((string)($p['banner'] ?? '')),
                'banner_alt' => trim((string)($p['banner_alt'] ?? '')),
                'status' => $status,
                'seo_title' => trim((string)($p['seo_title'] ?? '')),
                'meta_description' => trim((string)($p['meta_description'] ?? '')),
                'schema_json' => !empty($p['schema_json']) ? trim((string)$p['schema_json']) : null,
                'sort_order' => isset($p['sort_order']) ? (int)$p['sort_order'] : 0,
                'view' => 'services/show',
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if (isset($p['body_html'])) {
                $data['body_html'] = (string)$p['body_html'];
            }

            if ($id) {
                ServiceModel::update($id, $data);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $id = ServiceModel::create($data);
            }

            return $this->json([
                'success' => true,
                'message' => 'Service saved successfully!',
                'id' => $id,
                'slug' => $slug,
                'redirect' => base_url('/admin/services/edit?id=' . $id)
            ]);
        } catch (\Throwable $e) {
            Logger::error('Admin saveService error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to save service. Please check server logs.'], 500);
        }
    }

    public function deleteService(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            if ($id <= 0) {
                return $this->json(['success' => false, 'error' => 'Invalid service ID.'], 422);
            }

            ServiceModel::delete($id);
            return $this->json(['success' => true, 'message' => 'Service deleted successfully.']);
        } catch (\Throwable $e) {
            Logger::error('Admin deleteService error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to delete service.'], 500);
        }
    }

    public function saveCategory(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $name = trim((string)($p['name'] ?? ''));
            if ($name === '') {
                return $this->json(['success' => false, 'error' => 'Category name is required.'], 422);
            }

            $slug = trim((string)($p['slug'] ?? ''));
            if ($slug === '') {
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
            }
            if ($slug === '') {
                $slug = 'category-' . time();
            }

            $type = in_array($p['type'] ?? '', ['article', 'project', 'service'], true) ? $p['type'] : 'project';
            $id = !empty($p['id']) ? (int)$p['id'] : null;

            $data = [
                'name' => $name,
                'slug' => $slug,
                'type' => $type,
                'seo_intro' => trim((string)($p['seo_intro'] ?? '')),
                'icon' => trim((string)($p['icon'] ?? '')),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($id) {
                CategoryModel::update($id, $data);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $id = CategoryModel::create($data);
            }

            return $this->json(['success' => true, 'message' => 'Category saved successfully!', 'id' => $id]);
        } catch (\Throwable $e) {
            Logger::error('Admin saveCategory error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to save category.'], 500);
        }
    }

    public function deleteCategory(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            if ($id > 0) {
                CategoryModel::delete($id);
            }
            return $this->json(['success' => true, 'message' => 'Category deleted.']);
        } catch (\Throwable $e) {
            Logger::error('Admin deleteCategory error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to delete category.'], 500);
        }
    }

    public function updateMessageStatus(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            $status = in_array($p['status'] ?? '', ['new', 'read', 'replied', 'archived'], true) ? $p['status'] : 'read';

            if ($id > 0) {
                ContactModel::update($id, ['status' => $status]);
            }
            return $this->json(['success' => true, 'message' => 'Status updated.']);
        } catch (\Throwable $e) {
            Logger::error('Admin updateMessageStatus error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to update message status.'], 500);
        }
    }

    public function deleteMessage(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            if ($id > 0) {
                ContactModel::delete($id);
            }
            return $this->json(['success' => true, 'message' => 'Message deleted.']);
        } catch (\Throwable $e) {
            Logger::error('Admin deleteMessage error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to delete message.'], 500);
        }
    }

    public function updateLeadStatus(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            $status = in_array($p['status'] ?? '', ['new', 'contacted', 'qualified', 'proposal', 'won', 'lost'], true) ? $p['status'] : 'new';

            if ($id > 0) {
                LeadModel::update($id, ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
            }
            return $this->json(['success' => true, 'message' => 'Lead status updated.']);
        } catch (\Throwable $e) {
            Logger::error('Admin updateLeadStatus error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to update lead status.'], 500);
        }
    }

    public function deleteLead(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            if ($id > 0) {
                LeadModel::delete($id);
            }
            return $this->json(['success' => true, 'message' => 'Lead deleted.']);
        } catch (\Throwable $e) {
            Logger::error('Admin deleteLead error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to delete lead.'], 500);
        }
    }
}
