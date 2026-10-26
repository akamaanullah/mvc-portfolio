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
}
