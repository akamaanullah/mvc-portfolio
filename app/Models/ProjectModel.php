<?php
namespace App\Models;

use App\Core\Model;

class ProjectModel extends Model
{
    protected static string $table = 'projects';

    public static function categories(): array
    {
        $cats = CategoryModel::where('type', 'project', 'sort_order ASC, id ASC');
        return !empty($cats) ? $cats : [
            ['slug' => 'web-design-development', 'name' => 'Web Design & Development'],
            ['slug' => 'web-applications',       'name' => 'Web Applications'],
            ['slug' => 'products',               'name' => 'Products'],
            ['slug' => 'mobile-apps',            'name' => 'Mobile Apps'],
        ];
    }

    public static function category(string $slug): ?array
    {
        foreach (self::categories() as $c) if ($c['slug'] === $slug) return $c;
        return null;
    }
}
