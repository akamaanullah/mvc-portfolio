<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ServiceModel;

class ServiceController extends Controller
{
    public function index(): string { return $this->render('services/index', ['services' => ServiceModel::all()]); }

    public function show(string $slug): string
    {
        $legacy = [
            'web-app-cms-development'     => '/services/web-development',
            'saas-development'             => '/services/saas-application-development',
            'chat-application-development' => '/services/chat-app-development',
        ];
        if (isset($legacy[$slug])) {
            header('Location: ' . base_url($legacy[$slug]), true, 301);
            exit;
        }

        $service = ServiceModel::find($slug);
        if (!$service && $slug === 'web-development') {
            $service = ServiceModel::find('web-app-cms-development');
        }
        return $service ? $this->render($service['view'] ?? 'services/show', ['service' => $service]) : $this->notFound();
    }
}
