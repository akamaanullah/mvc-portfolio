<?php
namespace App\Helpers;

/**
 * Unified SEO, GEO, and AEO Engine for amaanullah.com
 * Handles traditional On-Page SEO, Generative Engine Optimization (GEO/Entity Anchors),
 * and Answer Engine Optimization (AEO/AI Crawlers/Schema.org @graph).
 */
class SeoEngine
{
    /**
     * Build and render the entire HTML <head> content including meta, GEO, OG, and JSON-LD Schema.
     */
    public static function renderHead(array $ctx = []): string
    {
        $biz = config('business');
        $siteUrl = rtrim($biz['url'] ?? 'https://amaanullah.com', '/');

        // Resolve Canonical URL
        $canonical = $ctx['canonical'] ?? null;
        if (!$canonical) {
            $reqUri = $_SERVER['REQUEST_URI'] ?? '/';
            $path = parse_url($reqUri, PHP_URL_PATH) ?? '/';
            $clean = preg_replace('#^/index\.php#', '', $path);
            $clean = preg_replace('#/page/1/?$#', '', $clean);
            $clean = rtrim($clean, '/');
            $canonical = $siteUrl . ($clean === '' ? '/' : $clean);
        } else {
            $canonical = rtrim($canonical, '/');
            if ($canonical === $siteUrl) $canonical .= '/';
        }

        $isHome = ($canonical === $siteUrl || $canonical === $siteUrl . '/');

        // Title Tag & Meta Description
        $rawTitle = $ctx['title'] ?? ($biz['name'] . ' | ' . $biz['founder_role']);
        $description = $ctx['description'] ?? $biz['description'];
        $keywords = $ctx['keywords'] ?? 'custom CRM development, Laravel SaaS developer, business process automation, software architect Karachi';
        $robots = $ctx['robots'] ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';

        // Title optimization for SERPs (aim <= 60 chars while keeping full title in OG/DC)
        $metaTitle = $rawTitle;
        if (mb_strlen($metaTitle) > 60 && str_contains($metaTitle, ' | ')) {
            $parts = explode(' | ', $metaTitle);
            if (mb_strlen($parts[0]) <= 60) {
                $metaTitle = $parts[0];
            }
        }

        // Image Handling (absolute URL)
        $image = $ctx['image'] ?? ($siteUrl . '/images/og-services.png');
        if (!str_starts_with($image, 'http')) {
            $image = $siteUrl . '/' . ltrim($image, '/');
        }

        $pageType = $ctx['page_type'] ?? ($isHome ? 'WebPage' : 'WebPage');

        // Dublin Core / Geographic Entities
        $geoRegion = $biz['geo_region'] ?? 'PK-SD';
        $geoPlacename = $biz['geo_placename'] ?? 'Karachi, Sindh, Pakistan';
        $geoPosition = ($biz['latitude'] ?? '24.8607') . ';' . ($biz['longitude'] ?? '67.0011');
        $icbm = ($biz['latitude'] ?? '24.8607') . ', ' . ($biz['longitude'] ?? '67.0011');

        // Build Unified Schema Graph
        $schemaGraph = self::buildSchemaGraph($ctx, $canonical, $rawTitle, $description, $image, $isHome);

        ob_start();
        ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($metaTitle, ENT_QUOTES, 'UTF-8') ?></title>
<meta name="description" content="<?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>">
<meta name="keywords" content="<?= htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8') ?>">
<meta name="robots" content="<?= htmlspecialchars($robots, ENT_QUOTES, 'UTF-8') ?>">
<meta name="author" content="Amaanullah Khan">
<meta name="publisher" content="Amaanullah Khan">
<link rel="canonical" href="<?= htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') ?>">
<link rel="author" href="<?= $siteUrl ?>/about">

<!-- GEO & Spatial Metadata (Entity SEO) -->
<meta name="geo.region" content="<?= htmlspecialchars($geoRegion, ENT_QUOTES, 'UTF-8') ?>">
<meta name="geo.placename" content="<?= htmlspecialchars($geoPlacename, ENT_QUOTES, 'UTF-8') ?>">
<meta name="geo.position" content="<?= htmlspecialchars($geoPosition, ENT_QUOTES, 'UTF-8') ?>">
<meta name="ICBM" content="<?= htmlspecialchars($icbm, ENT_QUOTES, 'UTF-8') ?>">

<!-- Dublin Core Semantic Metadata (Machine Readability & AI Citation) -->
<meta name="DC.title" content="<?= htmlspecialchars($rawTitle, ENT_QUOTES, 'UTF-8') ?>">
<meta name="DC.creator" content="Amaanullah Khan">
<meta name="DC.description" content="<?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>">
<meta name="DC.subject" content="<?= htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8') ?>">
<meta name="DC.language" content="en">
<meta name="DC.format" content="text/html">
<meta name="DC.type" content="Text">

<!-- Open Graph / Social Sharing -->
<meta property="og:type" content="<?= htmlspecialchars($ctx['og_type'] ?? 'website', ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:site_name" content="<?= htmlspecialchars($biz['brand'] ?? 'Amaanullah', ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:title" content="<?= htmlspecialchars($rawTitle, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:description" content="<?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:url" content="<?= htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:image" content="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:locale" content="en_US">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@akamaanullah">
<meta name="twitter:creator" content="@akamaanullah">
<meta name="twitter:title" content="<?= htmlspecialchars($rawTitle, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>">

<!-- PWA, Favicons & Theme -->
<link rel="icon" href="<?= asset_url('logo-v2/favicon.ico') ?>">
<link rel="apple-touch-icon" href="<?= asset_url('images/logo.png') ?>">
<meta name="theme-color" content="#f26a1b">
<link rel="alternate" type="application/rss+xml" title="Amaanullah Insights Feed" href="<?= $siteUrl ?>/feed">

<!-- Typography Preconnects -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Caveat:wght@600&display=swap" rel="stylesheet">

<!-- Unified JSON-LD Schema (Google Rich Results & AI Engine Optimized) -->
<script type="application/ld+json">
<?= json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
        <?php
        return trim(ob_get_clean());
    }

    /**
     * Generate the complete JSON-LD Schema graph.
     */
    public static function buildSchemaGraph(array $ctx, string $canonical, string $title, string $description, string $image, bool $isHome): array
    {
        $biz = config('business');
        $siteUrl = rtrim($biz['url'] ?? 'https://amaanullah.com', '/');

        $graph = [];

        // 1. Organization (ProfessionalService) Entity with verified Knowledge Graph links
        $organization = [
            '@type' => 'ProfessionalService',
            '@id' => $siteUrl . '/#organization',
            'name' => $biz['name'],
            'alternateName' => $biz['brand'],
            'url' => $siteUrl,
            'logo' => [
                '@type' => 'ImageObject',
                '@id' => $siteUrl . '/#logo',
                'url' => $biz['logo_url'],
                'caption' => $biz['name']
            ],
            'image' => $biz['profile_image'],
            'description' => $biz['description'],
            'telephone' => $biz['phone_display'],
            'email' => $biz['email'],
            'priceRange' => $biz['price_range'],
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $biz['locality'],
                'addressRegion' => $biz['region'],
                'addressCountry' => $biz['country']
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $biz['latitude'],
                'longitude' => $biz['longitude']
            ],
            'founder' => [
                '@id' => $siteUrl . '/#person'
            ],
            'areaServed' => $biz['areas_served'],
            'sameAs' => $biz['same_as'],
            'knowsAbout' => $biz['knows_about']
        ];

        if (!empty($biz['gbp_maps_url'])) {
            $organization['hasMap'] = $biz['gbp_maps_url'];
        }

        $graph[] = $organization;

        // 2. Person (Amaanullah Khan) Entity
        $person = [
            '@type' => 'Person',
            '@id' => $siteUrl . '/#person',
            'name' => $biz['founder_name'],
            'alternateName' => $biz['brand'],
            'jobTitle' => $biz['founder_role'],
            'url' => $siteUrl . '/about',
            'image' => $biz['profile_image'],
            'email' => 'mailto:' . $biz['email'],
            'telephone' => $biz['phone_display'],
            'worksFor' => [
                '@id' => $siteUrl . '/#organization'
            ],
            'alumniOf' => [
                '@type' => 'EducationalOrganization',
                'name' => $biz['founder_alumni'],
                'url' => $biz['founder_alumni_url']
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $biz['locality'],
                'addressRegion' => $biz['region'],
                'addressCountry' => $biz['country']
            ],
            'sameAs' => $biz['same_as'],
            'knowsAbout' => array_column($biz['knows_about'], 'name')
        ];

        $graph[] = $person;

        // 3. WebSite Entity
        $website = [
            '@type' => 'WebSite',
            '@id' => $siteUrl . '/#website',
            'url' => $siteUrl,
            'name' => $biz['name'],
            'alternateName' => $biz['brand'],
            'publisher' => [
                '@id' => $siteUrl . '/#organization'
            ],
            'inLanguage' => 'en'
        ];

        $graph[] = $website;

        // 4. WebPage Entity (Current page)
        $cleanPageId = rtrim($canonical, '/');
        $pageType = $ctx['page_type'] ?? ($isHome ? 'WebPage' : 'WebPage');

        $webpage = [
            '@type' => $pageType,
            '@id' => $cleanPageId . '#webpage',
            'url' => $canonical,
            'name' => $title,
            'description' => $description,
            'isPartOf' => [
                '@id' => $siteUrl . '/#website'
            ],
            'inLanguage' => 'en'
        ];

        // 5. BreadcrumbList (Inner pages only)
        if (!$isHome) {
            $breadcrumbs = self::buildBreadcrumbs($ctx, $canonical, $title);
            if (!empty($breadcrumbs['itemListElement'])) {
                $graph[] = $breadcrumbs;
                $webpage['breadcrumb'] = [
                    '@id' => $cleanPageId . '#breadcrumb'
                ];
            }
        }

        $graph[] = $webpage;

        // 6. Page-Specific Entities
        // FAQPage Entity (for AI citation & Google FAQ rich results)
        if (!empty($ctx['faqs']) && is_array($ctx['faqs'])) {
            $faqElements = [];
            foreach ($ctx['faqs'] as $faq) {
                if (!empty($faq['question']) && !empty($faq['answer'])) {
                    $faqElements[] = [
                        '@type' => 'Question',
                        'name' => trim($faq['question']),
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => trim($faq['answer'])
                        ]
                    ];
                }
            }
            if (!empty($faqElements)) {
                $graph[] = [
                    '@type' => 'FAQPage',
                    '@id' => $cleanPageId . '#faq',
                    'mainEntity' => $faqElements
                ];
            }
        }

        // Service Entity
        if (!empty($ctx['service']) && is_array($ctx['service'])) {
            $svc = $ctx['service'];
            $graph[] = array_merge([
                '@type' => 'Service',
                '@id' => $canonical . '#service',
                'url' => $canonical,
                'provider' => ['@id' => $siteUrl . '/#organization'],
                'areaServed' => $biz['areas_served']
            ], $svc);
        }

        // Project / CreativeWork Entity
        if (!empty($ctx['project']) && is_array($ctx['project'])) {
            $proj = $ctx['project'];
            $graph[] = array_merge([
                '@type' => 'CreativeWork',
                '@id' => $canonical . '#project',
                'url' => $canonical,
                'creator' => ['@id' => $siteUrl . '/#person']
            ], $proj);
        }

        // BlogPosting Entity
        if (!empty($ctx['article']) && is_array($ctx['article'])) {
            $art = $ctx['article'];
            $graph[] = array_merge([
                '@type' => 'BlogPosting',
                '@id' => $canonical . '#article',
                'url' => $canonical,
                'isPartOf' => ['@id' => $cleanPageId . '#webpage'],
                'author' => ['@id' => $siteUrl . '/#person'],
                'publisher' => ['@id' => $siteUrl . '/#organization'],
                'inLanguage' => 'en'
            ], $art);
        }

        // ItemList Entity (for Hub / Collection pages)
        if (!empty($ctx['itemList']) && is_array($ctx['itemList'])) {
            $graph[] = [
                '@type' => 'ItemList',
                '@id' => $cleanPageId . '#itemlist',
                'name' => $title,
                'itemListElement' => $ctx['itemList']
            ];
        }

        // Custom extra entities if any
        if (!empty($ctx['custom_entities']) && is_array($ctx['custom_entities'])) {
            foreach ($ctx['custom_entities'] as $extra) {
                $graph[] = $extra;
            }
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph
        ];
    }

    /**
     * Automatically generate BreadcrumbList schema with minimum 2 valid items.
     */
    private static function buildBreadcrumbs(array $ctx, string $canonical, string $title): array
    {
        $biz = config('business');
        $siteUrl = rtrim($biz['url'] ?? 'https://amaanullah.com', '/');

        if (!empty($ctx['breadcrumbs']) && is_array($ctx['breadcrumbs'])) {
            $items = [];
            $pos = 1;
            foreach ($ctx['breadcrumbs'] as $crumb) {
                $items[] = [
                    '@type' => 'ListItem',
                    'position' => $pos++,
                    'name' => $crumb['name'],
                    'item' => str_starts_with($crumb['url'], 'http') ? $crumb['url'] : ($siteUrl . '/' . ltrim($crumb['url'], '/'))
                ];
            }
            return [
                '@type' => 'BreadcrumbList',
                '@id' => rtrim($canonical, '/') . '#breadcrumb',
                'itemListElement' => $items
            ];
        }

        // Auto-detect breadcrumbs from URL path
        $path = trim(parse_url($canonical, PHP_URL_PATH) ?? '', '/');
        $segments = array_filter(explode('/', $path));

        $items = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => $siteUrl . '/'
            ]
        ];

        $accumulated = $siteUrl;
        $pos = 2;
        foreach ($segments as $idx => $seg) {
            $accumulated .= '/' . $seg;
            $isLast = ($idx === count($segments) - 1);
            $segTitle = $isLast ? $title : ucwords(str_replace('-', ' ', $seg));
            $items[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => $segTitle,
                'item' => $accumulated
            ];
        }

        return [
            '@type' => 'BreadcrumbList',
            '@id' => rtrim($canonical, '/') . '#breadcrumb',
            'itemListElement' => $items
        ];
    }
}
