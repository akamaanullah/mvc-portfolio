<?php
namespace App\Models;

use App\Core\Model;

class LandingPageModel extends Model
{
    protected static string $table = 'landing_pages';

    /**
     * Find active landing page by slug.
     */
    public static function findActive(string $slug): ?array
    {
        $page = static::find($slug);
        return ($page && !empty($page['is_active'])) ? $page : null;
    }

    /**
     * Return all active landing pages.
     */
    public static function active(): array
    {
        return static::where('is_active', 1, 'id ASC');
    }
}
