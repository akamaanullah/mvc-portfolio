<?php
namespace App\Services;

use App\Models\ArticleModel;
use App\Models\CategoryModel;
use App\Models\LandingPageModel;
use App\Models\ProjectModel;
use App\Models\ServiceModel;

class SeoFilesService
{
    /**
     * Core files managed by the system.
     */
    private const CORE_FILES = [
        'robots.txt' => [
            'name' => 'robots.txt',
            'title' => 'robots.txt',
            'badge' => 'Search & AI Crawlers',
            'badge_color' => '#f26a1b',
            'desc' => 'Rules for search engine bots (Googlebot, Bingbot) and AI web crawlers (GPTBot, ClaudeBot, PerplexityBot).',
            'url' => '/robots.txt',
            'is_core' => true
        ],
        'sitemap.xml' => [
            'name' => 'sitemap.xml',
            'title' => 'sitemap.xml',
            'badge' => 'XML Sitemap',
            'badge_color' => '#10b981',
            'desc' => 'Standard XML sitemap indexing all canonical pages, services, articles, projects, and landing pages.',
            'url' => '/sitemap.xml',
            'is_core' => true
        ],
        'llms.txt' => [
            'name' => 'llms.txt',
            'title' => 'llms.txt',
            'badge' => 'AI Overview',
            'badge_color' => '#8b5cf6',
            'desc' => 'Standard Markdown file providing LLMs (ChatGPT, Claude, Perplexity, Cursor) concise site summary and doc links.',
            'url' => '/llms.txt',
            'is_core' => true
        ],
        'llms-full.txt' => [
            'name' => 'llms-full.txt',
            'title' => 'llms-full.txt (Detail LLMs)',
            'badge' => 'Full LLM Context',
            'badge_color' => '#3b82f6',
            'desc' => 'Comprehensive LLM training file with full developer bio, tech stack, services, project case studies, and FAQs.',
            'url' => '/llms-full.txt',
            'is_core' => true
        ],
        'security.txt' => [
            'name' => 'security.txt',
            'title' => 'security.txt',
            'badge' => 'RFC 9116',
            'badge_color' => '#06b6d4',
            'desc' => 'Standard security vulnerability disclosure contact and disclosure policy file (also mirrored in /.well-known/).',
            'url' => '/security.txt',
            'is_core' => true
        ],
        'humans.txt' => [
            'name' => 'humans.txt',
            'title' => 'humans.txt',
            'badge' => 'Colophon & Credits',
            'badge_color' => '#ec4899',
            'desc' => 'Colophon text acknowledging author, developer tools, open-source stack, and site creation credits.',
            'url' => '/humans.txt',
            'is_core' => true
        ]
    ];

    /**
     * Get all manageable files with metadata and live status.
     */
    public static function getFilesList(): array
    {
        $publicPath = rtrim(PUBLIC_PATH, '/\\');
        $files = self::CORE_FILES;

        // Ensure default core files exist on disk if missing
        foreach ($files as $name => &$meta) {
            $filePath = $publicPath . DIRECTORY_SEPARATOR . $name;
            if (!file_exists($filePath)) {
                self::initDefaultFile($name);
            }
            $meta['exists'] = file_exists($filePath);
            $meta['size'] = $meta['exists'] ? filesize($filePath) : 0;
            $meta['size_formatted'] = $meta['exists'] ? self::formatBytes($meta['size']) : '0 B';
            $meta['updated_at'] = $meta['exists'] ? date('M j, Y H:i', filemtime($filePath)) : 'Not created';
            $meta['lines_count'] = $meta['exists'] ? count(file($filePath)) : 0;
        }
        unset($meta);

        // Scan for additional custom .txt, .xml, .json files in public/
        if (is_dir($publicPath)) {
            $scanned = scandir($publicPath);
            foreach ($scanned as $item) {
                if ($item === '.' || $item === '..' || is_dir($publicPath . DIRECTORY_SEPARATOR . $item)) {
                    continue;
                }
                $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                if (in_array($ext, ['txt', 'xml', 'json']) && !isset($files[$item]) && $item !== 'composer.json') {
                    $itemPath = $publicPath . DIRECTORY_SEPARATOR . $item;
                    $files[$item] = [
                        'name' => $item,
                        'title' => $item,
                        'badge' => 'Custom ' . strtoupper($ext),
                        'badge_color' => '#64748b',
                        'desc' => 'Custom web file served at /' . $item,
                        'url' => '/' . $item,
                        'is_core' => false,
                        'exists' => true,
                        'size' => filesize($itemPath),
                        'size_formatted' => self::formatBytes(filesize($itemPath)),
                        'updated_at' => date('M j, Y H:i', filemtime($itemPath)),
                        'lines_count' => count(file($itemPath))
                    ];
                }
            }
        }

        return $files;
    }

    /**
     * Read content of a specific file.
     */
    public static function readFile(string $filename): array
    {
        $sanitized = self::sanitizeFilename($filename);
        if (!$sanitized) {
            return ['success' => false, 'error' => 'Invalid filename.'];
        }

        $publicPath = rtrim(PUBLIC_PATH, '/\\');
        $filePath = $publicPath . DIRECTORY_SEPARATOR . $sanitized;

        if (!file_exists($filePath)) {
            self::initDefaultFile($sanitized);
        }

        if (!file_exists($filePath)) {
            return ['success' => false, 'error' => 'File not found.'];
        }

        $content = file_get_contents($filePath);
        return [
            'success' => true,
            'filename' => $sanitized,
            'content' => $content,
            'size' => filesize($filePath),
            'size_formatted' => self::formatBytes(filesize($filePath)),
            'updated_at' => date('M j, Y H:i', filemtime($filePath)),
            'lines' => count(explode("\n", $content))
        ];
    }

    /**
     * Save content to a specific file.
     */
    public static function saveFile(string $filename, string $content): array
    {
        $sanitized = self::sanitizeFilename($filename);
        if (!$sanitized) {
            return ['success' => false, 'error' => 'Invalid filename. Only .txt, .xml, .json are allowed.'];
        }

        $publicPath = rtrim(PUBLIC_PATH, '/\\');
        $filePath = $publicPath . DIRECTORY_SEPARATOR . $sanitized;

        if (file_put_contents($filePath, $content) === false) {
            return ['success' => false, 'error' => 'Failed to write to file. Please check folder permissions.'];
        }

        // Mirror security.txt into public/.well-known/security.txt
        if ($sanitized === 'security.txt') {
            $wellKnownDir = $publicPath . DIRECTORY_SEPARATOR . '.well-known';
            if (!is_dir($wellKnownDir)) {
                @mkdir($wellKnownDir, 0755, true);
            }
            @file_put_contents($wellKnownDir . DIRECTORY_SEPARATOR . 'security.txt', $content);
        }

        return [
            'success' => true,
            'message' => "File '{$sanitized}' saved successfully!",
            'filename' => $sanitized,
            'size' => filesize($filePath),
            'size_formatted' => self::formatBytes(filesize($filePath)),
            'updated_at' => date('M j, Y H:i', filemtime($filePath))
        ];
    }

    /**
     * Delete a custom file.
     */
    public static function deleteFile(string $filename): array
    {
        $sanitized = self::sanitizeFilename($filename);
        if (!$sanitized) {
            return ['success' => false, 'error' => 'Invalid filename.'];
        }

        if (isset(self::CORE_FILES[$sanitized])) {
            return ['success' => false, 'error' => "Core file '{$sanitized}' cannot be deleted."];
        }

        $publicPath = rtrim(PUBLIC_PATH, '/\\');
        $filePath = $publicPath . DIRECTORY_SEPARATOR . $sanitized;

        if (file_exists($filePath)) {
            @unlink($filePath);
            return ['success' => true, 'message' => "File '{$sanitized}' deleted successfully!"];
        }

        return ['success' => false, 'error' => 'File not found.'];
    }

    /**
     * Dynamically generate sitemap.xml from live database records.
     */
    public static function generateSitemap(): array
    {
        $siteUrl = rtrim((string) setting('site_domain', ''), '/');
        $urls = [];

        // 1. Static Core Pages
        $today = date('Y-m-d');
        $urls[] = ['loc' => $siteUrl . '/', 'priority' => '1.0', 'changefreq' => 'daily', 'lastmod' => $today];
        $urls[] = ['loc' => $siteUrl . '/services', 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => $today];
        $urls[] = ['loc' => $siteUrl . '/projects', 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => $today];
        $urls[] = ['loc' => $siteUrl . '/about', 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => $today];
        $urls[] = ['loc' => $siteUrl . '/articles', 'priority' => '0.85', 'changefreq' => 'daily', 'lastmod' => $today];
        $urls[] = ['loc' => $siteUrl . '/contact', 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => $today];

        // 2. High-Intent Landing Pages
        try {
            $landings = LandingPageModel::active();
            foreach ($landings as $l) {
                if (!empty($l['slug'])) {
                    $urls[] = [
                        'loc' => $siteUrl . '/' . ltrim($l['slug'], '/'),
                        'priority' => '0.9',
                        'changefreq' => 'weekly',
                        'lastmod' => !empty($l['updated_at']) ? date('Y-m-d', strtotime($l['updated_at'])) : $today
                    ];
                }
            }
        } catch (\Throwable $e) {}

        // 3. Dynamic Services
        try {
            $services = ServiceModel::all();
            foreach ($services as $s) {
                if (!empty($s['slug'])) {
                    $urls[] = [
                        'loc' => $siteUrl . '/services/' . $s['slug'],
                        'priority' => '0.85',
                        'changefreq' => 'weekly',
                        'lastmod' => !empty($s['updated_at']) ? date('Y-m-d', strtotime($s['updated_at'])) : $today
                    ];
                }
            }
        } catch (\Throwable $e) {}

        // 4. Portfolio Projects
        try {
            $projects = ProjectModel::all('id DESC');
            foreach ($projects as $p) {
                if (!empty($p['slug'])) {
                    $urls[] = [
                        'loc' => $siteUrl . '/projects/' . $p['slug'],
                        'priority' => !empty($p['is_featured']) ? '0.8' : '0.7',
                        'changefreq' => 'monthly',
                        'lastmod' => !empty($p['updated_at']) ? date('Y-m-d', strtotime($p['updated_at'])) : $today
                    ];
                }
            }
        } catch (\Throwable $e) {}

        // 5. Technical Articles
        try {
            $articles = ArticleModel::all('published_at DESC');
            foreach ($articles as $a) {
                if (!empty($a['slug'])) {
                    $urls[] = [
                        'loc' => $siteUrl . '/articles/' . $a['slug'],
                        'priority' => '0.75',
                        'changefreq' => 'weekly',
                        'lastmod' => !empty($a['updated_at']) ? date('Y-m-d', strtotime($a['updated_at'])) : $today
                    ];
                }
            }
        } catch (\Throwable $e) {}

        // 6. Article Categories
        try {
            $cats = ArticleModel::categories();
            foreach ($cats as $c) {
                if (!empty($c['slug'])) {
                    $urls[] = [
                        'loc' => $siteUrl . '/articles/category/' . $c['slug'],
                        'priority' => '0.6',
                        'changefreq' => 'weekly',
                        'lastmod' => $today
                    ];
                }
            }
        } catch (\Throwable $e) {}

        // 7. Project Categories
        $projectCats = ['web-applications', 'web-design-development', 'mobile-apps', 'products'];
        foreach ($projectCats as $pc) {
            $urls[] = [
                'loc' => $siteUrl . '/projects/category/' . $pc,
                'priority' => '0.6',
                'changefreq' => 'monthly',
                'lastmod' => $today
            ];
        }

        // Build XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\n";
        $xml .= '        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
            $xml .= "    <lastmod>{$u['lastmod']}</lastmod>\n";
            $xml .= "    <changefreq>{$u['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$u['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        $res = self::saveFile('sitemap.xml', $xml);
        if ($res['success']) {
            $res['message'] = "Sitemap regenerated successfully with " . count($urls) . " indexed URLs!";
            $res['url_count'] = count($urls);
        }
        return $res;
    }

    /**
     * Dynamically generate detailed llms-full.txt context from database.
     */
    public static function generateLlmsFull(): array
    {
        $siteUrl = rtrim((string) setting('site_domain', ''), '/');
        $phone = (string) setting('phone_number', '');
        $email = (string) setting('contact_email', '');
        $whatsapp = (string) setting('whatsapp_url', '');

        $services = ServiceModel::all();
        $projects = ProjectModel::all('is_featured DESC, id DESC LIMIT 10');
        $articles = ArticleModel::all('published_at DESC LIMIT 10');

        $content = "# Amaanullah Khan - Comprehensive Developer Specification & LLM Reference\n\n";
        $content .= "> Full-Stack Software Developer & Web Application Specialist based in Karachi, Pakistan.\n";
        $content .= "> Serving global clients across USA, UAE, UK, Europe, Australia, and Middle East.\n\n";

        $content .= "## 1. Identity & Profile\n";
        $content .= "- **Full Name**: Amaanullah Khan (@akamaanullah)\n";
        $content .= "- **Professional Title**: Full-Stack Software Developer & Web Specialist\n";
        $content .= "- **Official Website**: {$siteUrl}\n";
        $content .= "- **Direct Phone / WhatsApp**: {$phone}\n";
        $content .= "- **Direct WhatsApp Chat**: {$whatsapp}\n";
        $content .= "- **Email**: {$email}\n";
        $content .= "- **Location**: Karachi, Sindh, Pakistan (UTC+5 PKT)\n";
        $content .= "- **Years Experience**: 6+ years in production enterprise web applications\n\n";

        $content .= "## 2. Technical Stack & Engineering Philosophy\n";
        $content .= "- **Backend**: PHP 8.2+, Laravel, Custom MVC Frameworks, RESTful APIs, OOP, Clean Architecture.\n";
        $content .= "- **Database**: MySQL, PostgreSQL, SQLite, Redis caching, indexing & query optimization.\n";
        $content .= "- **Frontend**: Modern Vanilla JS (ES6+), HTML5, CSS3, TailwindCSS, Vue.js, React, Three.js 3D WebGL.\n";
        $content .= "- **Mobile**: Flutter, Dart, Firebase, Cross-platform iOS & Android engineering.\n";
        $content .= "- **AI & Automations**: Cloudflare Workers AI (Llama 3.1), OpenAI APIs, Webhook pipelines, Background Queues.\n";
        $content .= "- **DevOps & Cloud**: Apache, Nginx, cPanel, Cloudflare CDN/DNS/Workers, Docker, Git, CI/CD.\n\n";

        $content .= "## 3. Core Service Offerings\n";
        foreach ($services as $s) {
            $content .= "### " . $s['title'] . "\n";
            $content .= "- **URL**: {$siteUrl}/services/" . $s['slug'] . "\n";
            if (!empty($s['summary'])) $content .= "- **Overview**: " . trim($s['summary']) . "\n";
            $content .= "\n";
        }

        $content .= "## 4. Notable Portfolio Projects & Deliverables\n";
        foreach ($projects as $p) {
            $content .= "### " . $p['title'] . "\n";
            $content .= "- **URL**: {$siteUrl}/projects/" . $p['slug'] . "\n";
            if (!empty($p['category'])) $content .= "- **Category**: " . $p['category'] . "\n";
            if (!empty($p['summary'])) $content .= "- **Case Summary**: " . trim($p['summary']) . "\n";
            $content .= "\n";
        }

        $content .= "## 5. Technical Articles & Insights\n";
        foreach ($articles as $a) {
            $content .= "- [" . $a['title'] . "]({$siteUrl}/articles/" . $a['slug'] . ")\n";
        }
        $content .= "\n";

        $content .= "## 6. Frequently Asked Questions (FAQs)\n";
        $content .= "**Q: How do you charge for custom CRM & web application projects?**\n";
        $content .= "A: I offer transparent milestone-based fixed pricing and dedicated sprint contracts with zero recurring per-user software licensing fees.\n\n";
        $content .= "**Q: What is the typical project turnaround time?**\n";
        $content .= "A: Standard web apps and MVPs take 2–4 weeks; enterprise CRM/ERP solutions typically take 4–8 weeks with weekly staging demonstrations.\n\n";
        $content .= "**Q: How can clients get in touch immediately?**\n";
        $content .= "A: Direct WhatsApp at {$phone} or email at {$email}.\n";

        $res = self::saveFile('llms-full.txt', $content);
        if ($res['success']) {
            $res['message'] = "Detailed llms-full.txt context generated and saved!";
        }
        return $res;
    }

    /**
     * Initialize default content for core files if missing.
     */
    private static function initDefaultFile(string $filename): void
    {
        $siteUrl = rtrim((string) setting('site_domain', ''), '/');
        $phone = (string) setting('phone_number', '');
        $email = (string) setting('contact_email', '');

        switch ($filename) {
            case 'robots.txt':
                $content = "User-agent: *\nDisallow: /admin\nDisallow: /api/\nAllow: /\n\n# AI Crawlers & LLM Web Crawlers\nUser-agent: GPTBot\nAllow: /\n\nUser-agent: ClaudeBot\nAllow: /\n\nUser-agent: PerplexityBot\nAllow: /\n\nUser-agent: CCBot\nAllow: /\n\nSitemap: {$siteUrl}/sitemap.xml\n";
                self::saveFile('robots.txt', $content);
                break;

            case 'sitemap.xml':
                self::generateSitemap();
                break;

            case 'llms.txt':
                $content = "# Amaanullah Khan - Full-Stack Software Developer\n\n> Full-Stack Web Application Developer & Custom Software Specialist based in Karachi, Pakistan.\n> Specializing in Custom CRM Systems, SaaS Platforms, Laravel APIs, AI Automations, and Cross-Platform Mobile Apps.\n\n## Core Capabilities\n- Custom CRM & ERP Development: Tailored business systems with zero monthly user licenses.\n- SaaS & Web App Development: High-performance PHP/Laravel applications, modern APIs, clean architectures.\n- AI Automation & LLM Workflows: Cloudflare Workers AI, custom chatbot integration, automated lead capture.\n- Mobile App Development: Flutter & Firebase for iOS and Android.\n\n## Key Links & Documentation\n- [Home Page]({$siteUrl}/)\n- [Services Catalog]({$siteUrl}/services)\n- [Enterprise CRM Development]({$siteUrl}/services/custom-crm-development)\n- [Portfolio Projects]({$siteUrl}/projects)\n- [Technical Articles & Blog]({$siteUrl}/articles)\n- [Contact & WhatsApp]({$siteUrl}/contact)\n\n## Comprehensive Context\n- For full background, detailed projects, and architectural philosophy, see [Full LLM Specification]({$siteUrl}/llms-full.txt).\n";
                self::saveFile('llms.txt', $content);
                break;

            case 'llms-full.txt':
                self::generateLlmsFull();
                break;

            case 'security.txt':
                $content = "Contact: mailto:{$email}\nExpires: 2027-12-31T23:59:59.000Z\nPreferred-Languages: en, ur\nCanonical: {$siteUrl}/.well-known/security.txt\nPolicy: {$siteUrl}/contact\n";
                self::saveFile('security.txt', $content);
                break;

            case 'humans.txt':
                $content = "/* TEAM */\nDeveloper: Amaanullah Khan (@akamaanullah)\nContact: {$email} / {$phone}\nLocation: Karachi, Pakistan\nSite: {$siteUrl}\n\n/* THANKS */\nTo open-source creators: PHP, Laravel, Three.js, Cloudflare Workers AI.\n\n/* TECHNOLOGY COLOPHON */\nHTML5, Vanilla CSS, Modern JavaScript, PHP 8.2+, MySQL, Cloudflare CDN & Workers AI.\n";
                self::saveFile('humans.txt', $content);
                break;
        }
    }

    /**
     * Sanitize filename to prevent directory traversal and restrict to safe extensions.
     */
    public static function sanitizeFilename(string $filename): ?string
    {
        $filename = trim(basename($filename));
        if ($filename === '' || !preg_match('/^[a-zA-Z0-9_\-\.]+$/', $filename)) {
            return null;
        }
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($ext, ['txt', 'xml', 'json', 'md'])) {
            return null;
        }
        return $filename;
    }

    private static function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }
}
