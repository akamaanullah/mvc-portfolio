<?php
namespace App\Models;

use App\Core\Model;

class ProjectModel extends Model
{
    protected static string $table = 'projects';

    /** Project categories (tabs on /projects). Markup: views/projects/categories/<slug>.php */
    public static function categories(): array
    {
        return [
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

    protected static function data(): array
    {
        return [
            ['slug' => 'chatrox', 'title' => 'Chatrox — Custom Enterprise Chat App', 'category' => 'products', 'view' => 'projects/show'],
        ];
    }
}
