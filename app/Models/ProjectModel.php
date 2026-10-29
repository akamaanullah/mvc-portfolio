<?php
namespace App\Models;

use App\Core\Model;

class ProjectModel extends Model
{
    protected static string $table = 'projects';

    protected static array $aliases = [
        'chatrox'                => 'chatrox-real-time-messaging-professional-networking',
        'babyshop'               => 'babyshop-mobile-app-ecommerce-firebase-solution',
        'healink'                => 'healink-medicine-app-healthcare-hospital-management-solution',
        'tour-guide-app'         => 'tour-guide-mobile-app-explore-pakistan-travel-solution',
        'tour-guide'             => 'tour-guide-mobile-app-explore-pakistan-travel-solution',
        'custom-vape-ecommerce'  => 'the-perfect-vape-custom-ecommerce-platform-theme-builder',
        'the-perfect-vape'       => 'the-perfect-vape-custom-ecommerce-platform-theme-builder',
        'it-hardware-bin'        => 'it-hardware-bin-bulk-hardware-ecommerce-platform',
        'adsimpressions'         => 'adsimpressions-custom-digital-agency-platform',
        'multi-tenant-crm'       => 'multi-tenant-crm-sales-operations-management-system',
        'hrm-payroll'            => 'hrm-employee-management-payroll-portal',
        'ticketing-crm'          => 'ticketing-crm-jobs-vendor-management-enterprise-portal',
        'real-estate-portal'     => 'real-estate-property-portal-multi-role-marketplace',
        'kanban-workspace'       => 'workspace-kanban-project-task-management-platform',
        'expense-voyage'         => 'expense-voyage-budget-expense-management-web-app',
    ];

    public static function normalize(array $row): array
    {
        if (empty($row)) return $row;

        if (!isset($row['summary']) && isset($row['description'])) {
            $row['summary'] = $row['description'];
        }
        if (!isset($row['banner']) && !empty($row['image_url'])) {
            $row['banner'] = $row['image_url'];
        }
        if (!isset($row['timeline']) && !empty($row['duration'])) {
            $row['timeline'] = $row['duration'];
        }
        if (!isset($row['tech_chips']) && !empty($row['tech_stack'])) {
            $row['tech_chips'] = $row['tech_stack'];
        }
        if (!isset($row['tldr']) && !empty($row['result_summary'])) {
            $row['tldr'] = $row['result_summary'];
        }
        if (!isset($row['role'])) {
            $row['role'] = 'Lead Full-Stack Architect';
        }
        if (!isset($row['platform'])) {
            $row['platform'] = match($row['service_hub'] ?? '') {
                'mobile' => 'Mobile App (iOS & Android)',
                'saas'   => 'Web & Cloud SaaS',
                default  => 'Custom Web Platform'
            };
        }
        if (!isset($row['project_status']) && !empty($row['status'])) {
            $row['project_status'] = $row['status'];
        }
        if (!isset($row['industry']) && !empty($row['category'])) {
            $row['industry'] = $row['category'];
        }
        if (!isset($row['category_slug'])) {
            $row['category_slug'] = match($row['service_hub'] ?? '') {
                'web'    => 'web-design-development',
                'saas'   => 'web-applications',
                'mobile' => 'mobile-apps',
                default  => 'web-applications'
            };
        }
        if (!isset($row['key_results']) && (!empty($row['impact_efficiency']) || !empty($row['impact_growth']))) {
            $parts = [];
            if (!empty($row['impact_efficiency'])) $parts[] = 'Speed & Efficiency | ' . $row['impact_efficiency'];
            if (!empty($row['impact_growth'])) $parts[] = 'Scale & Growth | ' . $row['impact_growth'];
            $row['key_results'] = implode("\n", $parts);
        }
        if (!isset($row['body_html']) && (!empty($row['overview']) || !empty($row['conclusion']))) {
            $body = ($row['overview'] ?? '');
            if (!empty($row['conclusion'])) {
                $body .= "\n" . $row['conclusion'];
            }
            $row['body_html'] = $body;
        }
        return $row;
    }

    public static function all(string $orderBy = 'sort_order ASC, id ASC'): array
    {
        $rows = parent::all($orderBy);
        return array_map([self::class, 'normalize'], $rows);
    }

    public static function summaryList(string $orderBy = 'sort_order ASC, id ASC'): array
    {
        $rows = static::select(
            'id, category_id, category_slug, title, slug, highlight_em, domain, summary, banner, banner_alt, client, industry, role, timeline, platform, project_status, tech_chips, tldr, key_results, is_featured, show_on_home, sort_order',
            "status = 'published'",
            [],
            $orderBy
        );
        return array_map([self::class, 'normalize'], $rows);
    }

    public static function find(string $slug): ?array
    {
        $canonical = static::$aliases[$slug] ?? $slug;
        $row = parent::find($canonical);
        if ($row) {
            return self::normalize($row);
        }
        if ($canonical !== $slug) {
            $row = parent::find($slug);
            return $row ? self::normalize($row) : null;
        }
        return null;
    }

    public static function findById(int|string $id): ?array
    {
        $row = parent::findById($id);
        return $row ? self::normalize($row) : null;
    }

    public static function where(string $column, mixed $value, string $orderBy = 'sort_order ASC, id ASC'): array
    {
        $rows = parent::where($column, $value, $orderBy);
        return array_map([self::class, 'normalize'], $rows);
    }

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
