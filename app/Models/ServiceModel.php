<?php
namespace App\Models;

use App\Core\Model;

class ServiceModel extends Model
{
    protected static string $table = 'services';

    protected static array $aliases = [
        'chat-application-development' => 'chat-app-development',
        'saas-development'             => 'saas-application-development',
        'web-development'              => 'web-app-cms-development',
        'crm-development'              => 'custom-crm-development',
        'ai-automation'                => 'ai-automation-services',
        'process-automation'           => 'business-process-automation',
        'technical-audit'              => 'free-technical-audit',
    ];

    public static function find(string $slug): ?array
    {
        $canonical = static::$aliases[$slug] ?? $slug;
        $row = parent::find($canonical);
        if ($row) {
            return $row;
        }
        if ($canonical !== $slug) {
            return parent::find($slug);
        }
        return null;
    }

    protected static function data(): array
    {
        return [
            ['slug' => 'custom-crm-development', 'title' => 'Custom CRM Development in Laravel', 'view' => 'services/show'],
            ['slug' => 'ai-automation-services', 'title' => 'AI Automation Services', 'view' => 'services/show'],
            ['slug' => 'chat-app-development', 'title' => 'Chat App Development', 'view' => 'services/show'],
            ['slug' => 'web-app-cms-development', 'title' => 'Web App & CMS Development', 'view' => 'services/show'],
            ['slug' => 'saas-application-development', 'title' => 'SaaS Application Development', 'view' => 'services/show'],
            ['slug' => 'mobile-app-development', 'title' => 'Mobile App Development', 'view' => 'services/show'],
            ['slug' => 'business-process-automation', 'title' => 'Business Process Automation', 'view' => 'services/show'],
            ['slug' => 'saas-product-strategy', 'title' => 'SaaS Product Strategy', 'view' => 'services/show'],
            ['slug' => 'performance-tuning', 'title' => 'Performance Tuning', 'view' => 'services/show'],
            ['slug' => 'free-technical-audit', 'title' => 'Free Technical Audit', 'view' => 'services/show'],
        ];
    }
}
