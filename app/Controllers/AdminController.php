<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;
use App\Core\Logger;
use App\Models\ArticleModel;
use App\Models\CategoryModel;
use App\Models\ContactModel;
use App\Models\LandingPageModel;
use App\Models\LeadModel;
use App\Models\ProjectModel;
use App\Models\ServiceModel;
use App\Models\SettingsModel;
use App\Models\UserModel;
use App\Models\VisitorModel;
use App\Services\GoogleSearchConsoleService;
use App\Services\PageSpeedService;

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
                $viewData['recentLeads'] = LeadModel::all('id DESC LIMIT 5');
                $viewData['recentChats'] = \App\Models\ChatModel::listConversations('all', '', 4);

                $anFrom = date('Y-m-d', strtotime('-29 days'));
                $anTo = date('Y-m-d');
                $analytics = VisitorModel::getAnalyticsData($anFrom, $anTo);
                $viewData['analytics'] = $analytics;
                $viewData['trafficChart'] = $analytics['chart'] ?? null;
                $viewData['trafficSources'] = $analytics['donut'] ?? [];
                $viewData['topPages'] = array_slice($analytics['pages'] ?? [], 0, 7);
                $viewData['liveVisitors'] = VisitorModel::getVisitorsList('online', null, null, 5);
                $viewData['totalOnline'] = count(VisitorModel::getVisitorsList('online'));
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

            case 'landing-pages':
                $viewData['landingPages'] = LandingPageModel::all('id ASC');
                break;

            case 'landing-edit':
                $id = $_GET['id'] ?? null;
                $slug = $_GET['slug'] ?? null;
                $viewData['landing'] = $id ? LandingPageModel::findById($id) : ($slug ? LandingPageModel::find($slug) : null);
                $viewData['allLandings'] = LandingPageModel::all('title ASC');
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

            case 'search-console':
                $range = $_GET['range'] ?? '30d';
                $from = $_GET['from'] ?? null;
                $to = $_GET['to'] ?? null;

                if (empty($from) || empty($to)) {
                    $to = date('Y-m-d', strtotime('-2 days'));
                    switch ($range) {
                        case 'today':
                            $from = $to;
                            break;
                        case '7d':
                            $from = date('Y-m-d', strtotime('-8 days'));
                            break;
                        case '90d':
                            $from = date('Y-m-d', strtotime('-91 days'));
                            break;
                        case '30d':
                        default:
                            $range = '30d';
                            $from = date('Y-m-d', strtotime('-31 days'));
                            break;
                    }
                }

                $viewData['gsc'] = GoogleSearchConsoleService::getData(false, $from, $to);
                $viewData['currentRange'] = $range;
                break;

            case 'performance':
                $strategy = $_GET['strategy'] ?? 'mobile';
                $viewData['perf'] = PageSpeedService::getData(false, $strategy);
                $viewData['currentStrategy'] = $strategy;
                break;

            case 'analytics':
                $range = $_GET['range'] ?? '30d';
                $from = $_GET['from'] ?? null;
                $to = $_GET['to'] ?? null;

                if (empty($from) || empty($to)) {
                    $to = date('Y-m-d');
                    switch ($range) {
                        case 'today':
                            $from = $to;
                            break;
                        case '7d':
                            $from = date('Y-m-d', strtotime('-6 days'));
                            break;
                        case '90d':
                            $from = date('Y-m-d', strtotime('-89 days'));
                            break;
                        case '30d':
                        default:
                            $range = '30d';
                            $from = date('Y-m-d', strtotime('-29 days'));
                            break;
                    }
                }

                $viewData['analytics'] = VisitorModel::getAnalyticsData($from, $to);
                $viewData['currentRange'] = $range;
                $viewData['from'] = $from;
                $viewData['to'] = $to;
                break;

            case 'page-analytics':
                $range = $_GET['range'] ?? '30d';
                $from = $_GET['from'] ?? date('Y-m-d', strtotime('-29 days'));
                $to = $_GET['to'] ?? date('Y-m-d');
                $path = $_GET['path'] ?? '/projects/chatrox-real-time-messaging-professional-networking';
                $viewData['pageAnalytics'] = VisitorModel::getPageAnalyticsData($path, $from, $to);
                $viewData['currentRange'] = $range;
                $viewData['from'] = $from;
                $viewData['to'] = $to;
                break;

            case 'visitors':
                $filter = $_GET['filter'] ?? null;
                $country = $_GET['country'] ?? null;
                $search = $_GET['q'] ?? null;
                $page = max(1, (int) ($_GET['p'] ?? 1));
                $limit = 12;
                $offset = ($page - 1) * $limit;
                $viewData['visitors'] = VisitorModel::getVisitorsList($filter, $country, $search, $limit, $offset);
                $viewData['totalVisitors'] = VisitorModel::count();
                $viewData['currentPage'] = $page;
                break;

            case 'visitor':
                $id = (int) ($_GET['id'] ?? 1);
                $viewData['visitorProfile'] = VisitorModel::getVisitorDetailProfile($id);
                break;

            case 'live-chat':
                $filter = $_GET['tab'] ?? 'active';
                $search = trim($_GET['q'] ?? '');
                $conversations = \App\Models\ChatModel::listConversations($filter, $search);
                $activeSessionKey = $_GET['session'] ?? '';

                $activeConversation = null;
                if (!empty($activeSessionKey)) {
                    $activeConversation = \App\Models\ChatModel::getConversationBySession($activeSessionKey);
                }
                if (!$activeConversation && !empty($conversations)) {
                    $activeConversation = $conversations[0];
                }

                $activeMessages = [];
                $visitorProfile = null;
                if ($activeConversation) {
                    $activeMessages = \App\Models\ChatModel::getMessages($activeConversation['id']);
                    $visitorProfile = \App\Models\ChatModel::getVisitorProfile(
                        $activeConversation['visitor_ip'], 
                        $activeConversation['session_id']
                    );
                }

                $viewData['conversations'] = $conversations;
                $viewData['activeConversation'] = $activeConversation;
                $viewData['activeMessages'] = $activeMessages;
                $viewData['visitorProfile'] = $visitorProfile;
                $viewData['currentTab'] = $filter;
                $viewData['needsHumanCount'] = \App\Models\ChatModel::countNeedsHuman();
                break;

            case 'settings':
                $db = Database::connection();
                $raw = $db->query("SELECT `key`, `value` FROM settings")->fetchAll(\PDO::FETCH_KEY_PAIR);
                $viewData['settings'] = $raw;
                $viewData['seoFiles'] = \App\Services\SeoFilesService::getFilesList();
                $intConfig = \App\Services\IntegrationService::getAll();
                $viewData['integrationsConfig'] = $intConfig;

                $gscConn = !empty($intConfig['gsc']['connected']);
                $psConn  = !empty($intConfig['pagespeed']['connected']);
                $waConn  = !empty($intConfig['whatsapp']['connected']);
                $smtpConn = !empty($intConfig['smtp']['connected']);
                $alertsConn = !empty($intConfig['alerts']['connected']);
                $cfConn  = !empty($intConfig['cloudflare']['connected']);

                $viewData['integrations'] = [
                    'gsc' => [
                        'connected' => $gscConn,
                        'title' => 'Google Search Console',
                        'desc' => $gscConn ? 'Queries, impressions, sitemaps (' . ($intConfig['gsc']['site_url'] ?: 'Site verified') . ')' : 'Service account credentials required',
                        'badge' => $gscConn ? 'Connected' : 'Not Connected',
                        'badge_class' => $gscConn ? 'good' : 'bad',
                        'link' => base_url('/admin/search-console')
                    ],
                    'pagespeed' => [
                        'connected' => $psConn,
                        'title' => 'Google PageSpeed Insights',
                        'desc' => $psConn ? 'Lighthouse Core Web Vitals auditing engine (Active)' : 'Google PageSpeed Insights API key required',
                        'badge' => $psConn ? 'Connected' : 'Not Configured',
                        'badge_class' => $psConn ? 'good' : 'warn',
                        'link' => base_url('/admin/performance')
                    ],
                    'whatsapp' => [
                        'connected' => $waConn,
                        'title' => 'WhatsApp Direct Integration',
                        'desc' => $waConn ? ($intConfig['whatsapp']['phone'] . ' · Live Chat Direct Handoff') : 'WhatsApp phone number not configured',
                        'badge' => $waConn ? 'Connected' : 'Not Configured',
                        'badge_class' => $waConn ? 'good' : 'warn',
                        'link' => $intConfig['whatsapp']['whatsapp_url'] ?: 'javascript:void(0)'
                    ],
                    'smtp' => [
                        'connected' => $smtpConn,
                        'title' => 'SMTP / Mail Server',
                        'desc' => $smtpConn ? ($intConfig['smtp']['host'] . ':' . $intConfig['smtp']['port'] . ' (' . $intConfig['smtp']['user'] . ')') : 'SMTP credentials required for email delivery',
                        'badge' => $smtpConn ? 'Connected' : 'Not Configured',
                        'badge_class' => $smtpConn ? 'good' : 'warn',
                        'link' => 'javascript:void(0)'
                    ],
                    'alerts' => [
                        'connected' => $alertsConn,
                        'title' => 'Email Alerts & Notifications',
                        'desc' => $alertsConn ? ('Live takeover alerts & lead briefs sent to ' . $intConfig['alerts']['alert_email']) : 'Alert recipient email not configured',
                        'badge' => $alertsConn ? 'Active' : 'Disabled',
                        'badge_class' => $alertsConn ? 'good' : 'warn',
                        'link' => 'javascript:void(0)'
                    ],
                    'cloudflare' => [
                        'connected' => $cfConn,
                        'title' => 'Cloudflare Workers AI',
                        'desc' => $cfConn ? ($intConfig['cloudflare']['model'] . ' (Active AI Engine)') : 'Cloudflare Workers AI API Token & Account ID required',
                        'badge' => $cfConn ? 'Connected' : 'Not Configured',
                        'badge_class' => $cfConn ? 'good' : 'warn',
                        'link' => 'javascript:void(0)'
                    ]
                ];
                break;

            case 'media':
                $med = $this->getMediaLibrary();
                $viewData['media'] = $med['files'];
                $viewData['mediaCount'] = $med['count'];
                $viewData['mediaSizeMb'] = $med['size_mb'];
                break;

            case 'profile':
                $uId = Auth::id();
                $db = Database::connection();
                $stmt = $db->prepare('SELECT id, name, email, role, avatar FROM `users` WHERE id = :id LIMIT 1');
                $stmt->execute(['id' => $uId]);
                $fullUser = $stmt->fetch() ?: $currentUser;
                $fullUser['bio'] = SettingsModel::get('admin_bio', 'PHP & Laravel developer building custom CRM, SaaS and enterprise web apps, plus Flutter mobile apps.');
                $viewData['userProfile'] = $fullUser;
                $viewData['currentSession'] = [
                    'ip' => client_ip(),
                    'ua' => $_SERVER['HTTP_USER_AGENT'] ?? 'Desktop Browser',
                    'time' => date('M j, Y H:i'),
                ];
                break;
        }

        // Global layout counts and notifications for sidebar & topbar
        $db = Database::connection();
        $navCounts = [
            'projects' => ProjectModel::count(),
            'articles' => ArticleModel::count(),
            'leads' => LeadModel::count(),
            'messages' => ContactModel::count(),
            'unread_messages' => (int)($db->query("SELECT COUNT(*) FROM `contacts` WHERE `status` = 'new'")->fetchColumn() ?: 0),
            'new_leads' => (int)($db->query("SELECT COUNT(*) FROM `leads` WHERE `status` = 'new'")->fetchColumn() ?: 0),
            'needs_human_chats' => \App\Models\ChatModel::countNeedsHuman(),
        ];
        $badgeCount = $navCounts['unread_messages'] + $navCounts['new_leads'] + $navCounts['needs_human_chats'];

        $recentNotifications = [];
        $latestLeads = LeadModel::all('id DESC LIMIT 3');
        foreach ($latestLeads as $nl) {
            $recentNotifications[] = [
                'type' => 'lead',
                'title' => 'New chat lead: ' . htmlspecialchars($nl['name'] ?? 'Visitor'),
                'desc' => htmlspecialchars(substr($nl['requirement'] ?? 'Inquiry', 0, 45)),
                'time' => !empty($nl['created_at']) ? date('M d, H:i', strtotime($nl['created_at'])) : 'Recent',
                'url' => base_url('/admin/leads'),
                'unread' => ($nl['status'] ?? 'new') === 'new',
            ];
        }
        $latestMsgs = ContactModel::all('id DESC LIMIT 3');
        foreach ($latestMsgs as $nm) {
            $recentNotifications[] = [
                'type' => 'message',
                'title' => 'Contact: ' . htmlspecialchars($nm['name'] ?? 'Visitor'),
                'desc' => htmlspecialchars(substr($nm['message'] ?? 'Inquiry', 0, 45)),
                'time' => !empty($nm['created_at']) ? date('M d, H:i', strtotime($nm['created_at'])) : 'Recent',
                'url' => base_url('/admin/messages'),
                'unread' => ($nm['status'] ?? 'new') === 'new',
            ];
        }
        $waitingChats = \App\Models\ChatModel::listConversations('human');
        foreach (array_slice($waitingChats, 0, 2) as $wc) {
            $recentNotifications[] = [
                'type' => 'chat',
                'title' => 'Live chat waiting: ' . htmlspecialchars($wc['visitor_name'] ?? 'Visitor'),
                'desc' => htmlspecialchars(substr($wc['last_message'] ?? 'Waiting for operator', 0, 45)),
                'time' => !empty($wc['updated_at']) ? date('H:i', strtotime($wc['updated_at'])) : 'Active',
                'url' => base_url('/admin/live-chat?session=' . urlencode($wc['session_id'] ?? '')),
                'unread' => true,
            ];
        }

        $viewData['navCounts'] = $navCounts;
        $viewData['recentNotifications'] = $recentNotifications;
        $viewData['badgeCount'] = $badgeCount;

        $content = view('admin/pages/' . $key, $viewData);

        return $this->render('admin/layouts/app', compact('title', 'active', 'editor', 'bare', 'content', 'currentUser', 'navCounts', 'recentNotifications', 'badgeCount'));
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

    public function saveLandingPage(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired. Please reload the page.'], 419);
        }

        try {
            $p = $this->getPayload();
            $title = trim((string)($p['title'] ?? ''));
            if ($title === '') {
                return $this->json(['success' => false, 'error' => 'Landing page title is required.'], 422);
            }

            $slug = trim((string)($p['slug'] ?? ''));
            if ($slug === '') {
                $slug = $title;
            }
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug), '-'));
            if ($slug === '') {
                $slug = 'landing-' . time();
            }

            $id = !empty($p['id']) ? (int)$p['id'] : null;

            $existing = LandingPageModel::find($slug);
            if ($existing && (!$id || (int)$existing['id'] !== $id)) {
                $slug .= '-' . time();
            }

            $data = [
                'title' => $title,
                'slug' => $slug,
                'city' => trim((string)($p['city'] ?? 'Karachi')),
                'seo_title' => trim((string)($p['seo_title'] ?? '')),
                'meta_description' => trim((string)($p['meta_description'] ?? '')),
                'schema_json' => !empty($p['schema_json']) ? trim((string)$p['schema_json']) : null,
                'is_active' => !empty($p['is_active']) ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if (isset($p['content_html'])) {
                $data['content_html'] = (string)$p['content_html'];
            }

            if ($id) {
                LandingPageModel::update($id, $data);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $id = LandingPageModel::create($data);
            }

            return $this->json([
                'success' => true,
                'message' => 'Landing page saved successfully!',
                'id' => $id,
                'slug' => $slug,
                'redirect' => base_url('/admin/landing-pages/edit?id=' . $id)
            ]);
        } catch (\Throwable $e) {
            Logger::error('Admin saveLandingPage error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to save landing page. Please check server logs.'], 500);
        }
    }

    public function deleteLandingPage(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            if ($id <= 0) {
                return $this->json(['success' => false, 'error' => 'Invalid landing page ID.'], 422);
            }

            LandingPageModel::delete($id);
            return $this->json(['success' => true, 'message' => 'Landing page deleted successfully.']);
        } catch (\Throwable $e) {
            Logger::error('Admin deleteLandingPage error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to delete landing page.'], 500);
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

    public function saveLeadNote(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            $note = trim((string)($p['note'] ?? ''));

            if ($id <= 0 || $note === '') {
                return $this->json(['success' => false, 'error' => 'Note cannot be empty.'], 422);
            }

            $lead = LeadModel::findById($id);
            if (!$lead) {
                return $this->json(['success' => false, 'error' => 'Lead not found.'], 404);
            }

            $existing = trim((string)($lead['notes'] ?? ''));
            $newEntry = '[' . date('Y-m-d H:i') . ' Admin]: ' . $note;
            $combined = $existing !== '' ? $existing . "\n" . $newEntry : $newEntry;

            LeadModel::update($id, ['notes' => $combined, 'updated_at' => date('Y-m-d H:i:s')]);
            return $this->json(['success' => true, 'message' => 'Note saved successfully.', 'notes' => $combined]);
        } catch (\Throwable $e) {
            Logger::error('Admin saveLeadNote error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to save note.'], 500);
        }
    }

    public function replyMessage(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $id = (int)($p['id'] ?? 0);
            $replyBody = trim((string)($p['reply'] ?? $p['message'] ?? ''));

            if ($id <= 0 || $replyBody === '') {
                return $this->json(['success' => false, 'error' => 'Reply message cannot be empty.'], 422);
            }

            $msg = ContactModel::findById($id);
            if (!$msg) {
                return $this->json(['success' => false, 'error' => 'Message not found.'], 404);
            }

            $toEmail = $msg['email'] ?? '';
            $toName = $msg['name'] ?? 'Client';
            if (empty($toEmail)) {
                return $this->json(['success' => false, 'error' => 'Recipient email missing.'], 422);
            }

            $subject = 'Re: ' . ($msg['project_type'] ?: (!empty($msg['service']) ? ucfirst($msg['service']) . ' Inquiry' : 'Your Inquiry with Amaanullah'));
            $sent = \App\Services\IntegrationService::sendEmail(
                $toEmail,
                $subject,
                nl2br(htmlspecialchars($replyBody)),
                $replyBody,
                $toName
            );

            ContactModel::update($id, ['status' => 'replied']);

            if (!$sent) {
                return $this->json([
                    'success' => true,
                    'warning' => 'Message marked as replied in DB, but SMTP email delivery was skipped or failed. Verify SMTP settings in Settings > Integrations.',
                    'message' => 'Status updated to Replied.'
                ]);
            }

            return $this->json([
                'success' => true,
                'message' => 'Reply sent successfully to ' . htmlspecialchars($toEmail) . '!'
            ]);
        } catch (\Throwable $e) {
            Logger::error('Admin replyMessage error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to process reply.'], 500);
        }
    }

    public function markAllMessagesRead(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            Database::connection()->exec("UPDATE `contacts` SET `status` = 'read' WHERE `status` = 'new'");
            return $this->json(['success' => true, 'message' => 'All messages marked as read.']);
        } catch (\Throwable $e) {
            Logger::error('Admin markAllMessagesRead error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to mark messages read.'], 500);
        }
    }

    public function updateProfile(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $name = trim((string)($p['name'] ?? ''));
            $email = trim(strtolower((string)($p['email'] ?? '')));
            $bio = trim((string)($p['bio'] ?? ''));

            if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->json(['success' => false, 'error' => 'Valid name and email are required.'], 422);
            }

            $uId = Auth::id();
            if ($uId > 0) {
                UserModel::update($uId, [
                    'name' => $name,
                    'email' => $email,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $_SESSION['admin_user_name'] = $name;
                $_SESSION['admin_user_email'] = $email;
            }

            if ($bio !== '') {
                SettingsModel::set('admin_bio', $bio, 'general');
            }

            return $this->json(['success' => true, 'message' => 'Profile updated successfully!']);
        } catch (\Throwable $e) {
            Logger::error('Admin updateProfile error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to update profile.'], 500);
        }
    }

    public function updatePassword(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $currPass = (string)($p['current_password'] ?? '');
            $newPass = (string)($p['new_password'] ?? '');

            if ($currPass === '' || strlen($newPass) < 8) {
                return $this->json(['success' => false, 'error' => 'Current password and new password (min 8 chars) required.'], 422);
            }

            $uId = Auth::id();
            $user = UserModel::findById($uId);
            if (!$user) {
                return $this->json(['success' => false, 'error' => 'User not found.'], 404);
            }

            if (!UserModel::verifyPassword($currPass, $user['password'])) {
                return $this->json(['success' => false, 'error' => 'Current password is incorrect.'], 422);
            }

            $newHash = UserModel::hashPassword($newPass);
            UserModel::update($uId, [
                'password' => $newHash,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return $this->json(['success' => true, 'message' => 'Password changed successfully!']);
        } catch (\Throwable $e) {
            Logger::error('Admin updatePassword error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to update password.'], 500);
        }
    }

    public function uploadMedia(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                return $this->json(['success' => false, 'error' => 'No file uploaded or upload error.'], 422);
            }

            $file = $_FILES['file'];
            $origName = pathinfo($file['name'], PATHINFO_FILENAME);
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            $allowed = ['svg', 'png', 'jpg', 'jpeg', 'webp', 'gif', 'mp4', 'webm', 'pdf'];
            if (!in_array($ext, $allowed, true)) {
                return $this->json(['success' => false, 'error' => 'File extension .' . $ext . ' not allowed.'], 422);
            }

            $cleanName = strtolower(trim(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $origName), '-'));
            $finalName = $cleanName . '-' . time() . '.' . $ext;

            $destDir = dirname(__DIR__, 2) . '/public/uploads';
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0755, true);
            }

            $destPath = $destDir . '/' . $finalName;
            if (!move_uploaded_file($file['tmp_name'], $destPath)) {
                return $this->json(['success' => false, 'error' => 'Failed to save uploaded file.'], 500);
            }

            $relUrl = '/uploads/' . $finalName;
            return $this->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'url' => $relUrl,
                'asset_url' => asset_url('uploads/' . $finalName),
                'name' => $finalName
            ]);
        } catch (\Throwable $e) {
            Logger::error('Admin uploadMedia error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Upload failed.'], 500);
        }
    }

    public function deleteMedia(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $url = trim((string)($p['url'] ?? ''));

            if ($url === '') {
                return $this->json(['success' => false, 'error' => 'File URL is required.'], 422);
            }

            $cleanRel = ltrim(parse_url($url, PHP_URL_PATH) ?? '', '/');
            $basePathUrl = trim(base_path_url(), '/');
            if ($basePathUrl !== '' && str_starts_with($cleanRel, $basePathUrl . '/')) {
                $cleanRel = substr($cleanRel, strlen($basePathUrl) + 1);
            }

            if (str_contains($cleanRel, '..')) {
                return $this->json(['success' => false, 'error' => 'Invalid file path.'], 403);
            }

            $basePublic = realpath(dirname(__DIR__, 2) . '/public');
            $target = realpath($basePublic . '/' . $cleanRel);

            if (!$target || !str_starts_with($target, $basePublic) || !is_file($target)) {
                return $this->json(['success' => false, 'error' => 'File not found on server.'], 404);
            }

            @unlink($target);
            return $this->json(['success' => true, 'message' => 'Media file deleted.']);
        } catch (\Throwable $e) {
            Logger::error('Admin deleteMedia error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Failed to delete file.'], 500);
        }
    }

    private function getMediaLibrary(): array
    {
        $basePublic = dirname(__DIR__, 2) . '/public';
        $folders = [
            'banners' => $basePublic . '/images/banners',
            'covers'  => $basePublic . '/images/covers',
            'images'  => $basePublic . '/images',
            'media'   => $basePublic . '/media',
            'uploads' => $basePublic . '/uploads',
        ];

        if (!is_dir($folders['uploads'])) {
            @mkdir($folders['uploads'], 0755, true);
        }

        $items = [];
        $totalBytes = 0;

        foreach ($folders as $folderName => $path) {
            if (!is_dir($path)) continue;
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..' || is_dir($path . '/' . $file)) continue;
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (!in_array($ext, ['svg', 'png', 'jpg', 'jpeg', 'webp', 'gif', 'mp4', 'webm', 'pdf'], true)) continue;

                $filePath = $path . '/' . $file;
                $size = filesize($filePath) ?: 0;
                $totalBytes += $size;

                $sizeKb = round($size / 1024);
                $meta = strtoupper($ext) . ' · ' . ($sizeKb > 1024 ? round($sizeKb / 1024, 1) . ' MB' : $sizeKb . ' KB');

                $relUrl = '';
                if ($folderName === 'banners') $relUrl = 'images/banners/' . $file;
                elseif ($folderName === 'covers') $relUrl = 'images/covers/' . $file;
                elseif ($folderName === 'media') $relUrl = 'media/' . $file;
                elseif ($folderName === 'uploads') $relUrl = 'uploads/' . $file;
                else $relUrl = 'images/' . $file;

                $items[] = [
                    'name' => $file,
                    'folder' => $folderName,
                    'ext' => $ext,
                    'size' => $size,
                    'meta' => $meta,
                    'url' => '/' . $relUrl,
                    'asset_url' => asset_url($relUrl),
                    'mtime' => filemtime($filePath),
                ];
            }
        }

        usort($items, fn($a, $b) => $b['mtime'] <=> $a['mtime']);

        return [
            'files' => $items,
            'count' => count($items),
            'size_mb' => round($totalBytes / (1024 * 1024), 1),
        ];
    }

    /**
     * POST /admin/search-console/sync
     * Live sync from Google Search Console API.
     */
    public function syncSearchConsole(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $from = $_POST['from'] ?? null;
            $to = $_POST['to'] ?? null;
            $data = GoogleSearchConsoleService::getData(true, $from, $to);
            if ($this->wantsJson()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Search Console data successfully synced from Google API!',
                    'data' => $data
                ]);
            }
            $_SESSION['toast'] = 'Search Console data synced successfully!';
            redirect('/admin/search-console');
            return '';
        } catch (\Throwable $e) {
            Logger::error('Search Console sync error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Sync failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * POST /admin/search-console/sitemap
     * Live submit/ping sitemap to Google Search Console API.
     */
    public function submitSitemap(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $p = $this->getPayload();
            $sitemap = trim((string)($p['sitemap'] ?? '/sitemap.xml'));
            if ($sitemap === '') {
                $sitemap = '/sitemap.xml';
            }

            $res = GoogleSearchConsoleService::submitSitemap($sitemap);
            if ($this->wantsJson()) {
                return $this->json($res, $res['success'] ? 200 : 400);
            }

            $_SESSION['toast'] = $res['message'] ?? ($res['error'] ?? 'Sitemap processed');
            redirect('/admin/search-console');
            return '';
        } catch (\Throwable $e) {
            Logger::error('Search Console submitSitemap error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Submission error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * POST /admin/performance/run
     * Run live Lighthouse audit using Google PageSpeed Insights API.
     */
    public function runPerformanceAudit(): string
    {
        $this->requireAuth();
        if (!$this->verifyAdminCsrf()) {
            return $this->json(['success' => false, 'error' => 'Security token expired.'], 419);
        }

        try {
            $strategy = $_POST['strategy'] ?? 'mobile';
            $data = PageSpeedService::getData(true, $strategy);
            if ($this->wantsJson()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Lighthouse audit completed via Google PageSpeed API!',
                    'data' => $data
                ]);
            }
            $_SESSION['toast'] = 'Lighthouse audit completed successfully!';
            redirect('/admin/performance?strategy=' . urlencode($strategy));
            return '';
        } catch (\Throwable $e) {
            Logger::error('PageSpeed audit error: ' . $e->getMessage());
            return $this->json(['success' => false, 'error' => 'Audit failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET /admin/performance/download-log
     */
    public function downloadErrorLog(): void
    {
        $this->requireAuth();
        $logFile = BASE_PATH . '/storage/logs/app.log';
        if (!file_exists($logFile) || filesize($logFile) === 0) {
            header('Content-Type: text/plain; charset=utf-8');
            echo "[" . date('Y-m-d H:i:s') . "] INFO: System initialized. No errors recorded.\n";
            exit;
        }

        header('Content-Description: File Transfer');
        header('Content-Type: text/plain; charset=utf-8');
        header('Content-Disposition: attachment; filename="app-log-' . date('Y-m-d') . '.log"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($logFile));
        readfile($logFile);
        exit;
    }

    /**
     * GET /admin/live-chat/poll — Admin side polling for active conversations & messages.
     */
    public function liveChatPoll(): string
    {
        $this->requireAuth();
        $convId = (int)($_GET['conversation_id'] ?? 0);
        $lastMsgId = (int)($_GET['last_msg_id'] ?? 0);
        $filter = $_GET['tab'] ?? 'active';

        $conversations = \App\Models\ChatModel::listConversations($filter);
        $needsHumanCount = \App\Models\ChatModel::countNeedsHuman();

        $newMessages = [];
        $activeConv = null;
        if ($convId > 0) {
            $activeConv = \App\Models\ChatModel::getConversation($convId);
            $newMessages = \App\Models\ChatModel::getMessages($convId, $lastMsgId);
        }

        return $this->json([
            'conversations'     => $conversations,
            'needs_human_count' => $needsHumanCount,
            'active_status'     => $activeConv['status'] ?? null,
            'messages'          => $newMessages
        ]);
    }

    /**
     * POST /admin/live-chat/send — Admin replies to visitor.
     */
    public function liveChatSend(): string
    {
        $this->requireAuth();
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $convId = (int)($input['conversation_id'] ?? 0);
        $message = trim($input['message'] ?? '');

        if (!$convId || empty($message)) {
            return $this->json(['success' => false, 'error' => 'Missing conversation or message'], 400);
        }

        $msgId = \App\Models\ChatModel::addMessage($convId, 'admin', $message);
        \App\Models\ChatModel::updateStatus($convId, 'active');

        return $this->json([
            'success' => true,
            'message_id' => $msgId,
            'created_at' => date('H:i')
        ]);
    }

    /**
     * POST /admin/live-chat/takeover — Toggle bot/human handling.
     */
    public function liveChatTakeover(): string
    {
        $this->requireAuth();
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $convId = (int)($input['conversation_id'] ?? 0);
        $takeover = !empty($input['takeover']);

        if (!$convId) {
            return $this->json(['success' => false, 'error' => 'Missing conversation ID'], 400);
        }

        $newStatus = $takeover ? 'active' : 'bot';
        \App\Models\ChatModel::updateStatus($convId, $newStatus);

        return $this->json(['success' => true, 'status' => $newStatus]);
    }

    /**
     * POST /admin/live-chat/close — Admin closes conversation.
     */
    public function liveChatClose(): string
    {
        $this->requireAuth();
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $convId = (int)($input['conversation_id'] ?? 0);

        if (!$convId) {
            return $this->json(['success' => false, 'error' => 'Missing conversation ID'], 400);
        }

        \App\Models\ChatModel::updateStatus($convId, 'closed');
        \App\Models\ChatModel::addMessage($convId, 'admin', '__CLOSED__');

        return $this->json(['success' => true]);
    }

    /**
     * POST /admin/settings/save
     */
    public function saveSettings(): string
    {
        $this->requireAuth();
        $this->verifyAdminCsrf();

        $db = Database::connection();
        $fields = [
            'site_name', 'tagline', 'site_domain', 'contact_email', 'phone_number', 'whatsapp_number',
            'meta_default_title', 'meta_default_desc', 'robots_txt',
            'chatbot_name', 'chatbot_welcome', 'chatbot_timeout', 'chatbot_handoff_trigger',
            'chatbot_capture_leads', 'chatbot_notify_needs_human', 'chatbot_show_mobile',
            'auto_generate_sitemap', 'person_website_schema', 'default_theme_dark'
        ];

        // Ensure checkboxes have 0/1 values
        $checkboxes = [
            'chatbot_capture_leads', 'chatbot_notify_needs_human', 'chatbot_show_mobile',
            'auto_generate_sitemap', 'person_website_schema', 'default_theme_dark'
        ];
        foreach ($checkboxes as $cb) {
            $_POST[$cb] = isset($_POST[$cb]) ? '1' : '0';
        }

        $stmt = $db->prepare("INSERT INTO settings (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)");
        foreach ($fields as $k) {
            if (isset($_POST[$k])) {
                $stmt->execute([$k, trim((string)$_POST[$k])]);
            }
        }

        // Sync robots.txt file if present
        if (!empty($_POST['robots_txt'])) {
            \App\Services\SeoFilesService::saveFile('robots.txt', (string)$_POST['robots_txt']);
        }

        $_SESSION['toast'] = 'Settings saved successfully!';
        redirect('/admin/settings');
        return '';
    }

    /**
     * POST /admin/settings/test-chatbot
     */
    public function testChatbotConnection(): string
    {
        $this->requireAuth();

        $start = microtime(true);
        $testPrompt = "Hi! Quick connection check from admin settings. In 1 short polite sentence, introduce yourself.";
        $reply = \App\Services\ChatbotService::ask($testPrompt, []);
        $elapsed = round((microtime(true) - $start) * 1000);

        return $this->json([
            'success' => true,
            'latency' => $elapsed . 'ms',
            'model'   => setting('cf_ai_model', '@cf/meta/llama-3.1-8b-instruct-fast'),
            'reply'   => $reply
        ]);
    }

    /**
     * GET /admin/settings/file?file=robots.txt
     */
    public function getSeoFile(): string
    {
        $this->requireAuth();
        $file = trim((string)($_GET['file'] ?? 'robots.txt'));
        $data = \App\Services\SeoFilesService::readFile($file);
        return $this->json($data);
    }

    /**
     * POST /admin/settings/file/save
     */
    public function saveSeoFile(): string
    {
        $this->requireAuth();
        $this->verifyAdminCsrf();
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $file = trim((string)($input['file'] ?? ''));
        $content = (string)($input['content'] ?? '');
        $res = \App\Services\SeoFilesService::saveFile($file, $content);
        return $this->json($res);
    }

    /**
     * POST /admin/settings/file/create
     */
    public function createSeoFile(): string
    {
        $this->requireAuth();
        $this->verifyAdminCsrf();
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $name = trim((string)($input['filename'] ?? ''));
        $content = (string)($input['content'] ?? '');
        $res = \App\Services\SeoFilesService::saveFile($name, $content);
        return $this->json($res);
    }

    /**
     * POST /admin/settings/file/delete
     */
    public function deleteSeoFile(): string
    {
        $this->requireAuth();
        $this->verifyAdminCsrf();
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $name = trim((string)($input['filename'] ?? ''));
        $res = \App\Services\SeoFilesService::deleteFile($name);
        return $this->json($res);
    }

    /**
     * POST /admin/settings/file/generate-sitemap
     */
    public function generateSitemapAction(): string
    {
        $this->requireAuth();
        $this->verifyAdminCsrf();
        $res = \App\Services\SeoFilesService::generateSitemap();
        return $this->json($res);
    }

    /**
     * POST /admin/settings/file/generate-llms
     */
    public function generateLlmsAction(): string
    {
        $this->requireAuth();
        $this->verifyAdminCsrf();
        $res = \App\Services\SeoFilesService::generateLlmsFull();
        return $this->json($res);
    }

    /**
     * POST /admin/settings/integration/save
     */
    public function saveIntegrationAction(): string
    {
        $this->requireAuth();
        $this->verifyAdminCsrf();
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $type = trim((string)($input['type'] ?? ''));
        $data = $input['data'] ?? [];

        $res = \App\Services\IntegrationService::saveIntegration($type, $data);
        return $this->json($res);
    }

    /**
     * POST /admin/settings/integration/test-smtp
     */
    public function testSmtpAction(): string
    {
        $this->requireAuth();
        $this->verifyAdminCsrf();
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $to = trim((string)($input['to_email'] ?? setting('smtp_user', 'akamaanullah@gmail.com')));

        $res = \App\Services\IntegrationService::testSmtp($to);
        return $this->json($res);
    }

    /**
     * POST /admin/settings/integration/test-gsc
     */
    public function testGscAction(): string
    {
        $this->requireAuth();
        $this->verifyAdminCsrf();
        $siteUrl = setting('gsc_site_url', 'https://amaanullah.com/');
        $data = \App\Services\GoogleSearchConsoleService::getAnalytics($siteUrl, '28d');
        if (!empty($data['connected'])) {
            return $this->json([
                'success' => true,
                'message' => 'Connected to Google Search Console! Fetched ' . count($data['queries'] ?? []) . ' search queries.',
                'site_url' => $siteUrl
            ]);
        }
        return $this->json([
            'success' => false,
            'error' => $data['error'] ?? 'Could not connect to Google Search Console API. Please verify service account credentials.'
        ]);
    }

    /**
     * POST /admin/settings/integration/test-pagespeed
     */
    public function testPageSpeedAction(): string
    {
        $this->requireAuth();
        $this->verifyAdminCsrf();
        $url = setting('pagespeed_audit_url', setting('site_domain', 'https://amaanullah.com'));
        $data = \App\Services\PageSpeedService::audit($url, 'mobile', false);
        if (!empty($data['connected']) || !empty($data['score'])) {
            return $this->json([
                'success' => true,
                'message' => "PageSpeed API connected! Mobile Performance Score: {$data['score']}/100.",
                'score' => $data['score']
            ]);
        }
        return $this->json([
            'success' => false,
            'error' => 'Failed to connect to Google PageSpeed Insights. Please check your API key.'
        ]);
    }
}
