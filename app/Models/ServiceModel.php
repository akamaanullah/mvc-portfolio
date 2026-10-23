<?php
namespace App\Models;

use App\Core\Model;

class ServiceModel extends Model
{
    protected static string $table = 'services';

    protected static function data(): array
    {
        return [
            // Only CRM has a designed detail page so far; add rows + views for the other services.
            ['slug' => 'custom-crm-development', 'title' => 'Custom CRM Development in Laravel', 'view' => 'services/show'],
        ];
    }
}
