<?php
namespace App\Models;

use App\Core\Model;

class LeadModel extends Model
{
    protected static string $table = 'leads';

    protected static function data(): array
    {
        return [];
    }
}
