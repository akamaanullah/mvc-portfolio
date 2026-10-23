<?php
namespace App\Models;

use App\Core\Model;

class CategoryModel extends Model
{
    protected static string $table = 'categories';

    protected static function data(): array
    {
        return [
            ['id' => 1, 'type' => 'article', 'name' => 'Laravel & PHP', 'slug' => 'laravel-php'],
            ['id' => 2, 'type' => 'article', 'name' => 'SaaS & CRM', 'slug' => 'saas-crm'],
            ['id' => 3, 'type' => 'article', 'name' => 'Automation & AI', 'slug' => 'automation-ai'],
            ['id' => 4, 'type' => 'article', 'name' => 'Mobile & Flutter', 'slug' => 'mobile-flutter'],
            ['id' => 5, 'type' => 'article', 'name' => 'Web Development', 'slug' => 'web-development'],
            ['id' => 6, 'type' => 'article', 'name' => 'Career Insights', 'slug' => 'career-insights'],
            ['id' => 7, 'type' => 'project', 'name' => 'Web Design & Development', 'slug' => 'web-design-development'],
            ['id' => 8, 'type' => 'project', 'name' => 'Web Applications', 'slug' => 'web-applications'],
            ['id' => 9, 'type' => 'project', 'name' => 'Products', 'slug' => 'products'],
            ['id' => 10, 'type' => 'project', 'name' => 'Mobile Apps', 'slug' => 'mobile-apps'],
        ];
    }
}
