<?php
namespace App\Controllers;

use App\Core\Controller;

/** SEO landing pages: /laravel-developer-karachi, /crm-developers-pakistan, /full-stack-developer-karachi */
class LandingController extends Controller
{
    public const PAGES = ['laravel-developer-karachi', 'crm-developers-pakistan', 'full-stack-developer-karachi'];

    public function show(string $slug): string
    {
        return in_array($slug, self::PAGES, true) ? $this->render('landing/show', ['slug' => $slug]) : $this->notFound();
    }
}
