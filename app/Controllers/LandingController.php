<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\LandingPageModel;

/** Dynamic SEO landing pages */
class LandingController extends Controller
{
    private const REDIRECTS = [
        'crm-developers-pakistan' => 'crm-developer-pakistan',
        'full-stack-developer-karachi' => 'hire-a-developer-karachi',
        'web-developer-karachi' => 'services/web-development',
        'hire-laravel-developer-karachi' => 'laravel-developer-karachi',
    ];

    public function show(string $slug): string
    {
        if (isset(self::REDIRECTS[$slug])) {
            $dest = base_url('/' . self::REDIRECTS[$slug]);
            header('Location: ' . $dest, true, 301);
            exit;
        }

        $page = LandingPageModel::findActive($slug);
        if (!$page) {
            return $this->notFound();
        }

        return $this->render('landing/show', [
            'landing' => $page,
            'page' => $page,
            'slug' => $slug,
        ]);
    }
}
