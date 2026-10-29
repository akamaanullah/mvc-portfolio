<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProjectModel;

class ProjectController extends Controller
{
    public function index(): string 
    { 
        $projects = ProjectModel::summaryList('sort_order ASC, id ASC');
        if (empty($projects)) {
            $projects = ProjectModel::all('sort_order ASC, id ASC');
        }
        return $this->render('projects/index', [
            'categories' => ProjectModel::categories(),
            'projects'   => $projects
        ]); 
    }

    public function category(string $cat): string
    {
        $category = ProjectModel::category($cat);
        return $category ? $this->render('projects/category', ['category' => $category]) : $this->notFound();
    }

    public function show(string $slug): string
    {
        $item = ProjectModel::find($slug);
        if (!$item) {
            return $this->notFound();
        }

        // Use lightweight summary list for prev/next and related projects (saves bandwidth/RAM)
        $all = ProjectModel::summaryList('sort_order ASC, id ASC');
        $prev = null;
        $next = null;
        $currentIndex = null;

        foreach ($all as $idx => $p) {
            if ($p['slug'] === $item['slug']) {
                $currentIndex = $idx;
                break;
            }
        }

        if ($currentIndex !== null) {
            $prev = $all[$currentIndex - 1] ?? null;
            $next = $all[$currentIndex + 1] ?? null;
        }

        $related = [];
        foreach ($all as $p) {
            if ($p['slug'] !== $item['slug']) {
                $related[] = $p;
                if (count($related) >= 3) break;
            }
        }

        return $this->render($item['view'] ?? 'projects/show', [
            'item'    => $item,
            'prev'    => $prev,
            'next'    => $next,
            'related' => $related,
        ]);
    }
}
