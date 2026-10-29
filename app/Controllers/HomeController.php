<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): string 
    { 
        return $this->render('home/index'); 
    }

    public function robotsTxt(): string
    {
        if (!headers_sent()) {
            header('Content-Type: text/plain; charset=utf-8');
        }
        $f = PUBLIC_PATH . '/robots.txt';
        return file_exists($f) ? file_get_contents($f) : "User-agent: *\nDisallow: /admin\n";
    }

    public function sitemapXml(): string
    {
        if (!headers_sent()) {
            header('Content-Type: application/xml; charset=utf-8');
        }
        $f = PUBLIC_PATH . '/sitemap.xml';
        return file_exists($f) ? file_get_contents($f) : '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';
    }

    public function llmsTxt(): string
    {
        if (!headers_sent()) {
            header('Content-Type: text/plain; charset=utf-8');
        }
        $f = PUBLIC_PATH . '/llms.txt';
        return file_exists($f) ? file_get_contents($f) : '# Amaanullah Khan';
    }

    public function llmsFullTxt(): string
    {
        if (!headers_sent()) {
            header('Content-Type: text/plain; charset=utf-8');
        }
        $f = PUBLIC_PATH . '/llms-full.txt';
        return file_exists($f) ? file_get_contents($f) : '# Amaanullah Khan - Full Specification';
    }

    public function feed(): string
    {
        if (!headers_sent()) {
            header('Content-Type: application/rss+xml; charset=utf-8');
        }
        $biz = config('business');
        $siteUrl = rtrim($biz['url'] ?? 'https://amaanullah.com', '/');
        $articles = \App\Models\ArticleModel::summaryList('published_at DESC, id DESC');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
        $xml .= '<channel>' . "\n";
        $xml .= '  <title>' . htmlspecialchars($biz['name'] ?? 'Amaanullah Khan') . '</title>' . "\n";
        $xml .= '  <link>' . $siteUrl . '</link>' . "\n";
        $xml .= '  <description>' . htmlspecialchars($biz['description'] ?? '') . '</description>' . "\n";
        $xml .= '  <language>en-us</language>' . "\n";
        $xml .= '  <atom:link href="' . $siteUrl . '/feed" rel="self" type="application/rss+xml" />' . "\n";

        foreach ($articles as $art) {
            $link = $siteUrl . '/articles/' . rawurlencode($art['slug']);
            $pubDate = !empty($art['published_at']) ? date(DATE_RSS, strtotime($art['published_at'])) : date(DATE_RSS);
            $xml .= '  <item>' . "\n";
            $xml .= '    <title>' . htmlspecialchars($art['title']) . '</title>' . "\n";
            $xml .= '    <link>' . $link . '</link>' . "\n";
            $xml .= '    <guid>' . $link . '</guid>' . "\n";
            $xml .= '    <pubDate>' . $pubDate . '</pubDate>' . "\n";
            $xml .= '    <description>' . htmlspecialchars($art['excerpt'] ?? $art['subtitle'] ?? '') . '</description>' . "\n";
            $xml .= '  </item>' . "\n";
        }

        $xml .= '</channel>' . "\n";
        $xml .= '</rss>';
        return $xml;
    }

    public function privacy(): string { return $this->render('legal/privacy'); }
    public function terms(): string { return $this->render('legal/terms'); }
}
