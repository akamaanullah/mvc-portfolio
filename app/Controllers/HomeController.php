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
}
