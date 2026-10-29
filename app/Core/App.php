<?php
namespace App\Core;

use Throwable;

/** Application kernel + tiny router: GET/POST routes with {param} placeholders. */
class App
{
    private static ?App $instance = null;
    private array $routes = ['GET' => [], 'POST' => []];

    public function __construct(public readonly string $basePath) {}

    public static function boot(string $basePath): self
    {
        $app = self::$instance = new self($basePath);
        date_default_timezone_set((string) config('app.timezone', 'UTC'));
        ini_set('display_errors', config('app.debug') ? '1' : '0');
        error_reporting(E_ALL);
        set_exception_handler(fn(Throwable $e) => $app->fail($e));
        set_error_handler(function ($no, $str, $file, $line) {
            if (!(error_reporting() & $no)) return false;
            throw new \ErrorException($str, 0, $no, $file, $line);
        });
        $app->routes();
        return $app;
    }

    public static function instance(): ?self { return self::$instance; }

    public function get(string $pattern, array $handler): void  { $this->routes['GET'][$pattern] = $handler; }
    public function post(string $pattern, array $handler): void { $this->routes['POST'][$pattern] = $handler; }

    private function routes(): void
    {
        $C = 'App\\Controllers\\';
        // ---- Admin Routes ----
        $this->get('/admin', [$C . 'AdminController', 'index']);
        $this->get('/admin/logout', [$C . 'AdminController', 'logout']);
        $this->post('/admin/logout', [$C . 'AdminController', 'logout']);
        $this->post('/admin/login', [$C . 'AdminController', 'postLogin']);

        // Admin CRUD endpoints
        $this->post('/admin/projects/save', [$C . 'AdminController', 'saveProject']);
        $this->post('/admin/projects/delete', [$C . 'AdminController', 'deleteProject']);
        $this->post('/admin/projects/toggle-featured', [$C . 'AdminController', 'toggleProjectFeatured']);

        $this->post('/admin/articles/save', [$C . 'AdminController', 'saveArticle']);
        $this->post('/admin/articles/delete', [$C . 'AdminController', 'deleteArticle']);

        $this->post('/admin/categories/save', [$C . 'AdminController', 'saveCategory']);
        $this->post('/admin/categories/delete', [$C . 'AdminController', 'deleteCategory']);

        $this->post('/admin/services/save', [$C . 'AdminController', 'saveService']);
        $this->post('/admin/services/delete', [$C . 'AdminController', 'deleteService']);

        $this->post('/admin/landing-pages/save', [$C . 'AdminController', 'saveLandingPage']);
        $this->post('/admin/landing-pages/delete', [$C . 'AdminController', 'deleteLandingPage']);

        $this->post('/admin/messages/status', [$C . 'AdminController', 'updateMessageStatus']);
        $this->post('/admin/messages/delete', [$C . 'AdminController', 'deleteMessage']);
        $this->post('/admin/messages/reply', [$C . 'AdminController', 'replyMessage']);
        $this->post('/admin/messages/mark-all-read', [$C . 'AdminController', 'markAllMessagesRead']);

        $this->post('/admin/leads/status', [$C . 'AdminController', 'updateLeadStatus']);
        $this->post('/admin/leads/delete', [$C . 'AdminController', 'deleteLead']);
        $this->post('/admin/leads/note', [$C . 'AdminController', 'saveLeadNote']);

        // Profile & Account Endpoints
        $this->post('/admin/profile/update', [$C . 'AdminController', 'updateProfile']);
        $this->post('/admin/profile/password', [$C . 'AdminController', 'updatePassword']);

        // Media Library Endpoints
        $this->post('/admin/media/upload', [$C . 'AdminController', 'uploadMedia']);
        $this->post('/admin/media/delete', [$C . 'AdminController', 'deleteMedia']);

        // Search Console & Performance live endpoints
        $this->post('/admin/search-console/sync', [$C . 'AdminController', 'syncSearchConsole']);
        $this->post('/admin/search-console/sitemap', [$C . 'AdminController', 'submitSitemap']);
        $this->post('/admin/performance/run', [$C . 'AdminController', 'runPerformanceAudit']);
        $this->get('/admin/performance/download-log', [$C . 'AdminController', 'downloadErrorLog']);

        // Chatbot Public Endpoints
        $this->post('/api/chat/message', [$C . 'ChatbotController', 'message']);
        $this->post('/api/chat/init-live', [$C . 'ChatbotController', 'initLive']);
        $this->get('/api/chat/poll', [$C . 'ChatbotController', 'poll']);
        $this->post('/api/chat/lead', [$C . 'ChatbotController', 'lead']);
        $this->post('/api/chat/close', [$C . 'ChatbotController', 'close']);

        // Real-Time Analytics Event Tracking Endpoint
        $this->post('/api/analytics/event', [$C . 'AnalyticsController', 'recordEvent']);

        // Admin Live Chat Management Endpoints
        $this->get('/admin/live-chat/poll', [$C . 'AdminController', 'liveChatPoll']);
        $this->post('/admin/live-chat/send', [$C . 'AdminController', 'liveChatSend']);
        $this->post('/admin/live-chat/takeover', [$C . 'AdminController', 'liveChatTakeover']);
        $this->post('/admin/live-chat/close', [$C . 'AdminController', 'liveChatClose']);

        // Admin Settings Endpoints
        $this->post('/admin/settings/save', [$C . 'AdminController', 'saveSettings']);
        $this->post('/admin/settings/test-chatbot', [$C . 'AdminController', 'testChatbotConnection']);
        $this->get('/admin/settings/file', [$C . 'AdminController', 'getSeoFile']);
        $this->post('/admin/settings/file/save', [$C . 'AdminController', 'saveSeoFile']);
        $this->post('/admin/settings/file/create', [$C . 'AdminController', 'createSeoFile']);
        $this->post('/admin/settings/file/delete', [$C . 'AdminController', 'deleteSeoFile']);
        $this->post('/admin/settings/file/generate-sitemap', [$C . 'AdminController', 'generateSitemapAction']);
        $this->post('/admin/settings/file/generate-llms', [$C . 'AdminController', 'generateLlmsAction']);

        // Admin Integrations Management Endpoints
        $this->post('/admin/settings/integration/save', [$C . 'AdminController', 'saveIntegrationAction']);
        $this->post('/admin/settings/integration/test-smtp', [$C . 'AdminController', 'testSmtpAction']);
        $this->post('/admin/settings/integration/test-gsc', [$C . 'AdminController', 'testGscAction']);
        $this->post('/admin/settings/integration/test-pagespeed', [$C . 'AdminController', 'testPageSpeedAction']);

        // Public Web & AI Crawler Specification Files
        $this->get('/robots.txt', [$C . 'HomeController', 'robotsTxt']);
        $this->get('/sitemap.xml', [$C . 'HomeController', 'sitemapXml']);
        $this->get('/llms.txt', [$C . 'HomeController', 'llmsTxt']);
        $this->get('/llms-full.txt', [$C . 'HomeController', 'llmsFullTxt']);
        $this->get('/feed', [$C . 'HomeController', 'feed']);
        $this->get('/privacy', [$C . 'HomeController', 'privacy']);
        $this->get('/terms', [$C . 'HomeController', 'terms']);

        $this->get('/admin/{page}', [$C . 'AdminController', 'page']);
        $this->get('/admin/{section}/{action}', [$C . 'AdminController', 'sub']);
        $this->get('/', [$C . 'HomeController', 'index']);
        $this->get('/about', [$C . 'AboutController', 'index']);
        $this->get('/services', [$C . 'ServiceController', 'index']);
        $this->get('/services/{slug}', [$C . 'ServiceController', 'show']);
        $this->get('/projects', [$C . 'ProjectController', 'index']);
        $this->get('/projects/category/{cat}', [$C . 'ProjectController', 'category']);
        $this->get('/projects/{slug}', [$C . 'ProjectController', 'show']);
        $this->get('/articles', [$C . 'ArticleController', 'index']);
        $this->get('/articles/category/{cat}', [$C . 'ArticleController', 'category']);
        $this->get('/articles/{slug}', [$C . 'ArticleController', 'show']);
        $this->get('/contact', [$C . 'ContactController', 'index']);
        $this->post('/contact', [$C . 'ContactController', 'store']);
        $this->get('/{landing}', [$C . 'LandingController', 'show']); // laravel-developer-karachi, crm-developers-pakistan, full-stack-developer-karachi
    }

    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if ($method === 'HEAD') $method = 'GET';
        $path = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/');
        $base = base_path_url();
        if ($base !== '' && str_starts_with($path, $base)) $path = substr($path, strlen($base));
        $path = preg_replace('#^/(index\.php|public)(?=/|$)#', '', $path);
        $path = '/' . trim((string) $path, '/');

        foreach ($this->routes[$method] ?? [] as $pattern => [$class, $action]) {
            $regex = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[a-z0-9-]+)', $pattern) . '$#';
            if (preg_match($regex, $path, $m)) {
                $params = array_values(array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY));
                if ($method === 'GET' && !str_starts_with($path, '/admin') && !str_starts_with($path, '/api')) {
                    register_shutdown_function(function () use ($path) {
                        try {
                            if (function_exists('fastcgi_finish_request')) fastcgi_finish_request();
                            \App\Models\VisitorModel::trackCurrentRequest($path);
                        } catch (\Throwable) {}
                    });
                }
                echo (new $class())->$action(...$params);
                return;
            }
        }
        $this->notFound();
    }

    public function notFound(): void
    {
        http_response_code(404);
        echo view('errors/404');
    }

    public function fail(Throwable $e): void
    {
        Logger::error($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
        if (!headers_sent()) http_response_code(500);
        while (ob_get_level() > 0) ob_end_clean();
        try { echo view('errors/500', ['error' => config('app.debug') ? $e : null]); }
        catch (Throwable) { echo 'Server error'; }
    }
}
