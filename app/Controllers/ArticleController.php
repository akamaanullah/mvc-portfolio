<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    public function index(): string 
    { 
        $articles = ArticleModel::where('status', 'published', 'sort_order ASC, id ASC');
        if (empty($articles)) {
            $articles = ArticleModel::all('sort_order ASC, id ASC');
        }
        return $this->render('articles/index', [
            'categories' => ArticleModel::categories(),
            'articles'   => $articles,
        ]); 
    }

    public function category(string $cat): string
    {
        $category = ArticleModel::category($cat);
        return $category ? $this->render('articles/category', ['category' => $category]) : $this->notFound();
    }

    public function show(string $slug): string
    {
        $item = ArticleModel::find($slug);
        if (!$item) {
            return $this->notFound();
        }

        $all = ArticleModel::all('sort_order ASC, id ASC');
        $prev = null;
        $next = null;
        $currentIndex = null;

        foreach ($all as $idx => $a) {
            if ($a['slug'] === $item['slug']) {
                $currentIndex = $idx;
                break;
            }
        }

        if ($currentIndex !== null) {
            $prev = $all[$currentIndex - 1] ?? null;
            $next = $all[$currentIndex + 1] ?? null;
        }

        $related = [];
        foreach ($all as $a) {
            if ($a['slug'] !== $item['slug']) {
                $related[] = $a;
                if (count($related) >= 3) break;
            }
        }

        return $this->render($item['view'] ?? 'articles/show', [
            'item'    => $item,
            'prev'    => $prev,
            'next'    => $next,
            'related' => $related,
        ]);
    }
}
