<?php
namespace App\Models;

use App\Core\Model;

class ArticleModel extends Model
{
    protected static string $table = 'articles';

    public static function summaryList(string $orderBy = 'sort_order ASC, id ASC'): array
    {
        return static::select(
            'id, category_id, category_slug, title, slug, subtitle, excerpt, badge_category, badge_type, cover_image, reading_time, published_at, sort_order',
            "status = 'published'",
            [],
            $orderBy
        );
    }

    public static function categories(): array
    {
        $cats = CategoryModel::where('type', 'article', 'sort_order ASC, id ASC');
        return !empty($cats) ? $cats : [
            ['slug' => 'web-development', 'name' => 'Web Development'],
            ['slug' => 'laravel-php',     'name' => 'Laravel & PHP'],
            ['slug' => 'saas-crm',        'name' => 'SaaS & CRM'],
            ['slug' => 'automation-ai',   'name' => 'Automation & AI'],
            ['slug' => 'mobile-flutter',  'name' => 'Mobile (Flutter)'],
            ['slug' => 'career-insights', 'name' => 'Career & Insights'],
        ];
    }

    public static function category(string $slug): ?array
    {
        foreach (self::categories() as $c) if ($c['slug'] === $slug) return $c;
        return null;
    }
}
