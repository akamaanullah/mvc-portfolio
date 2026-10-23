<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    public function index(): string { return $this->render('articles/index', ['categories' => ArticleModel::categories()]); }

    public function category(string $cat): string
    {
        $category = ArticleModel::category($cat);
        return $category ? $this->render('articles/category', ['category' => $category]) : $this->notFound();
    }

    public function show(string $slug): string
    {
        $item = ArticleModel::find($slug);
        return $item ? $this->render($item['view'] ?? 'articles/show', ['item' => $item]) : $this->notFound();
    }
}
