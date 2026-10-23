<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProjectModel;

class ProjectController extends Controller
{
    public function index(): string { return $this->render('projects/index', ['categories' => ProjectModel::categories()]); }

    public function category(string $cat): string
    {
        $category = ProjectModel::category($cat);
        return $category ? $this->render('projects/category', ['category' => $category]) : $this->notFound();
    }

    public function show(string $slug): string
    {
        $item = ProjectModel::find($slug);
        return $item ? $this->render($item['view'] ?? 'projects/show', ['item' => $item]) : $this->notFound();
    }
}
