<?php
namespace App\Models;

use App\Core\Model;

class ServiceModel extends Model
{
    protected static string $table = 'services';

    protected static function data(): array
    {
        return [
            ['slug' => 'custom-crm-development', 'title' => 'Custom CRM Development in Laravel', 'view' => 'services/show'],
            ['slug' => 'web-development', 'title' => 'Custom Web Application Development', 'view' => 'services/show'],
            ['slug' => 'saas-development', 'title' => 'SaaS Application Development', 'view' => 'services/show'],
            ['slug' => 'chat-application-development', 'title' => 'Chat Application Development', 'view' => 'services/show'],
            ['slug' => 'business-process-automation', 'title' => 'Business Process Automation', 'view' => 'services/show'],
            ['slug' => 'ai-automation-services', 'title' => 'AI Automation Services', 'view' => 'services/show'],
            ['slug' => 'mobile-app-development', 'title' => 'Mobile App Development', 'view' => 'services/show'],
        ];
    }
}
