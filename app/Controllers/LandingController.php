<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\LandingPageModel;

/** Dynamic SEO landing pages */
class LandingController extends Controller
{
    public function show(string $slug): string
    {
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
