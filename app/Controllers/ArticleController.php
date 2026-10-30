<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    public function index(): string 
    { 
        $articles = ArticleModel::summaryList('sort_order ASC, id ASC');
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
        if (!$category) {
            return $this->notFound();
        }

        $allArticles = ArticleModel::summaryList('sort_order ASC, id ASC');
        $catArticles = array_values(array_filter($allArticles, function ($a) use ($cat, $category) {
            $cSlug = $a['category_slug'] ?? '';
            return $cSlug === $cat || (!empty($category['id']) && (int)($a['category_id'] ?? 0) === (int)$category['id']);
        }));

        return $this->render('articles/category', [
            'category'    => $category,
            'articles'    => $catArticles,
            'allArticles' => $allArticles,
        ]);
    }

    public function show(string $slug): string
    {
        $legacy = [
            'data-privacy-security-custom-software-compliance-guide' => '/articles/ai-coding-agents-2026-custom-software',
        ];
        if (isset($legacy[$slug])) {
            header('Location: ' . base_url($legacy[$slug]), true, 301);
            exit;
        }

        $item = ArticleModel::find($slug);
        if (!$item) {
            return $this->notFound();
        }

        // Use lightweight summary list for prev/next and related articles (saves bandwidth/RAM)
        $all = ArticleModel::summaryList('sort_order ASC, id ASC');
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
