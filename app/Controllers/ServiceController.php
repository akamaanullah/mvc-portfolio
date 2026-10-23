<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ServiceModel;

class ServiceController extends Controller
{
    public function index(): string { return $this->render('services/index', ['services' => ServiceModel::all()]); }

    public function show(string $slug): string
    {
        $service = ServiceModel::find($slug);
        return $service ? $this->render($service['view'] ?? 'services/show', ['service' => $service]) : $this->notFound();
    }
}
