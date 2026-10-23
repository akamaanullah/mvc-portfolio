<?php
namespace App\Models;

use App\Core\Model;

class ArticleModel extends Model
{
    protected static string $table = 'articles';

    /** Article categories. Markup: views/articles/categories/<slug>.php */
    public static function categories(): array
    {
        return [
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

    protected static function data(): array
    {
        return [
            ['slug' => 'multi-tenant-saas-laravel', 'title' => 'How to Build a Multi-Tenant SaaS in Laravel', 'category' => 'laravel-php', 'view' => 'articles/show'],
        ];
    }
}
