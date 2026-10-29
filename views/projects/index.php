<?php
$catFilterMap = [
    'web-design-development' => 'web',
    'web-applications'       => 'apps',
    'products'               => 'products',
    'mobile-apps'            => 'mobile',
];
$catLabelMap = [
    'web-design-development' => 'Web Design & Development',
    'web-applications'       => 'Web Applications',
    'products'               => 'Products',
    'mobile-apps'            => 'Mobile Applications',
];

$allProjects = $projects ?? \App\Models\ProjectModel::all('sort_order ASC, id ASC');
$counts = ['all' => count($allProjects), 'web' => 0, 'apps' => 0, 'products' => 0, 'mobile' => 0];

$schemaItems = [];
foreach ($allProjects as $i => $pj) {
    $cSlug = $pj['category_slug'] ?? '';
    $fKey = $catFilterMap[$cSlug] ?? 'apps';
    if (isset($counts[$fKey])) $counts[$fKey]++;

    $schemaItems[] = [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'item' => [
            '@type' => 'CreativeWork',
            'name' => $pj['title'],
            'url' => base_url('/projects/' . $pj['slug']),
            'genre' => $pj['category_name'] ?? 'Software',
            'creator' => [
                '@type' => 'Person',
                'name' => 'Amaanullah Khan'
            ]
        ]
    ];
}

$featuredProjects = array_values(array_filter($allProjects, fn($p) => !empty($p['is_featured'])));
if (empty($featuredProjects)) {
    $featuredProjects = array_slice($allProjects, 0, 4);
}

$pageMeta = [
    'title' => 'Projects & Case Studies | CRM, SaaS & Apps by Amaanullah Khan',
    'description' => 'Case studies of production systems by Amaanullah Khan — custom CRMs, web applications, SaaS products and Flutter mobile apps built in Karachi, Pakistan.',
    'canonical' => base_url('/projects'),
    'og_type' => 'website',
    'image' => asset_url('images/og-projects.png'),
    'page_type' => 'CollectionPage',
    'itemList' => $schemaItems
];
$extraCss = [
    'css/projects.css',
    'css/chatbot.css',
    'css/layout.css'
];
?>
<!doctype html>
<html lang="en">
<head>
<?php require view_path('layouts/head.php'); ?>
</head><body>
<div class="bgfx"></div>
<?php $home = false; $active = 'Projects'; require view_path('layouts/header.php'); ?>

<main id="main" data-page="all">
<header class="ph"><nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li aria-current="page">Projects</li></ol></nav>
 <span class="eyebrow rv2">✦ Projects</span>
 <div class="row"><div><h1 class="rv2">Case studies &amp; <em>production systems.</em></h1><p class="lead2 rv2" style="max-width:640px;margin-top:12px">Real production systems built in Laravel, PHP and Flutter. Each case study covers the business problem, architectural decisions and production results.</p><p class="lead2 rv2" style="max-width:640px;margin-top:12px">Browse everything below, or pick a category — web design &amp; development, web applications, products or mobile apps.</p></div>
 <nav class="hcs rv2" aria-label="Project categories"><a class="hc" href="<?= base_url('/projects/category/web-design-development') ?>" data-f="web"><b><?= sprintf('%02d', $counts['web']) ?></b><span>Web Design & Development</span><small>E-commerce, marketplaces and custom websites.</small></a><a class="hc" href="<?= base_url('/projects/category/web-applications') ?>" data-f="apps"><b><?= sprintf('%02d', $counts['apps']) ?></b><span>Web Applications</span><small>Custom CRMs, HR portals and business systems.</small></a><a class="hc" href="<?= base_url('/projects/category/products') ?>" data-f="products"><b><?= sprintf('%02d', $counts['products']) ?></b><span>Products</span><small>Owned software products like chat platforms.</small></a><a class="hc" href="<?= base_url('/projects/category/mobile-apps') ?>" data-f="mobile"><b><?= sprintf('%02d', $counts['mobile']) ?></b><span>Mobile Applications</span><small>Cross-platform Flutter apps for iOS and Android.</small></a></nav></div>
</header>
<div class="fbar2"><nav class="fts" role="tablist" aria-label="Filter projects by category"><span class="ind" aria-hidden="true"></span><a class="ft" role="tab" href="<?= base_url('/projects') ?>" aria-selected="true" aria-current="page" data-f="all">All <sup><?= $counts['all'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/web-design-development') ?>" aria-selected="false" data-f="web">Web Design &amp; Development <sup><?= $counts['web'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/web-applications') ?>" aria-selected="false" data-f="apps">Web Applications <sup><?= $counts['apps'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/products') ?>" aria-selected="false" data-f="products">Products <sup><?= $counts['products'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/mobile-apps') ?>" aria-selected="false" data-f="mobile">Mobile Applications <sup><?= $counts['mobile'] ?></sup></a></nav></div>
<div id="swap">
<section class="sec2" id="featured" aria-labelledby="h-feat"><div class="lbl2 rv2"><h2 id="h-feat">Featured</h2></div>
<div class="featg n4">
<?php foreach ($featuredProjects as $fp):
  $fCatSlug = $fp['category_slug'] ?? 'web-applications';
  $fDataCat = $catFilterMap[$fCatSlug] ?? 'apps';
  $fCatName = $catLabelMap[$fCatSlug] ?? 'Web Applications';
  $fChips = !empty($fp['tech_chips']) ? array_slice(array_filter(array_map('trim', explode(',', $fp['tech_chips']))), 0, 4) : [];
  $fBanner = !empty($fp['banner']) ? asset_url($fp['banner']) : asset_url('images/banners/chatrox.svg');
?>
<article class="pc big" data-cat="<?= $fDataCat ?>">
<a href="<?= base_url('/projects/' . $fp['slug']) ?>" data-project="<?= htmlspecialchars($fp['slug']) ?>" class="pl" aria-label="View case study: <?= htmlspecialchars($fp['title']) ?>">
<div class="ban"><img src="<?= $fBanner ?>" alt="<?= htmlspecialchars($fp['title']) ?> — <?= htmlspecialchars($fCatName) ?> project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb"><?= htmlspecialchars($fCatName) ?></span><?php if (!empty($fp['is_featured'])): ?><span class="pst live">Live</span><?php endif; ?></div>
<div class="pb"><span class="lab"><?= htmlspecialchars($fp['industry'] ?: $fCatName) ?></span><div class="pt"><h3><?= htmlspecialchars($fp['title']) ?></h3><span class="ar" aria-hidden="true">↗</span></div><p><?= htmlspecialchars($fp['summary']) ?></p>
<div class="tg"><?php foreach ($fChips as $c): ?><span><?= htmlspecialchars($c) ?></span><?php endforeach; ?></div><span class="vc">View case study <b>→</b></span></div></a></article>
<?php endforeach; ?>
</div></section>
<section class="sec2" id="all-projects" aria-labelledby="h-all"><div class="lbl2 rv2"><h2 id="h-all">All production case studies</h2></div><div class="pgrid">
<?php foreach ($allProjects as $pj):
  $pCatSlug = $pj['category_slug'] ?? 'web-applications';
  $pDataCat = $catFilterMap[$pCatSlug] ?? 'apps';
  $pCatName = $catLabelMap[$pCatSlug] ?? 'Web Applications';
  $pChips = !empty($pj['tech_chips']) ? array_slice(array_filter(array_map('trim', explode(',', $pj['tech_chips']))), 0, 3) : [];
  $pBanner = !empty($pj['banner']) ? asset_url($pj['banner']) : asset_url('images/banners/chatrox.svg');
  $isMobile = ($pDataCat === 'mobile');
?>
<article class="pc" data-cat="<?= $pDataCat ?>">
<a href="<?= base_url('/projects/' . $pj['slug']) ?>" data-project="<?= htmlspecialchars($pj['slug']) ?>" class="pl" aria-label="View case study: <?= htmlspecialchars($pj['title']) ?>">
<div class="ban"><img src="<?= $pBanner ?>" alt="<?= htmlspecialchars($pj['title']) ?> — <?= htmlspecialchars($pCatName) ?> project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb"><?= htmlspecialchars($pCatName) ?></span></div>
<div class="pb"><span class="lab"><?= htmlspecialchars($pj['industry'] ?: $pCatName) ?></span><div class="pt"><h3><?= htmlspecialchars($pj['title']) ?></h3><span class="ar" aria-hidden="true">↗</span></div><p><?= htmlspecialchars($pj['summary']) ?></p>
<div class="tg"><?php foreach ($pChips as $c): ?><span><?= htmlspecialchars($c) ?></span><?php endforeach; ?></div>
<?php if ($isMobile): ?><div class="plat"><span>Android</span><span>iOS</span></div><?php endif; ?>
<span class="vc">View case study <b>→</b></span></div></a></article>
<?php endforeach; ?>
</div></section>
<section class="sec2 pfaq" aria-labelledby="h-faq"><div class="lbl2 rv2"><h2 id="h-faq">Questions about my projects</h2></div><div class="rv2"><details><summary>Do you only work with Laravel, or do you handle full projects?</summary><p>I handle end-to-end applications: database architecture, backend APIs in Laravel/PHP, reactive web interfaces, and cross-platform mobile apps with Flutter.</p></details><details><summary>Do you work with clients outside Pakistan?</summary><p>Yes, I work with startups, businesses and remote teams worldwide across the US, UK, UAE and Europe.</p></details><details><summary>What kind of projects do you usually take on?</summary><p>Custom CRM systems, SaaS platforms, internal business automation tools, WebSocket chat apps and RESTful APIs.</p></details></div></section>
<section class="cta2"><div class="band rv2"><div><h2>Have a similar project in mind?</h2><p>Tell me about your CRM, HRM or automation project — I reply within 24 hours with clear next steps.</p></div><div class="btns" style="margin:0"><a class="bo w" href="<?= base_url('/contact') ?>">Get a Quote →</a><a class="bo g" href="<?= base_url('/contact') ?>">Book a Demo</a></div></div></section>
</div>
</main>
<?php require view_path('layouts/footer.php'); ?>

<div class="cur" id="cur" aria-hidden="true">View ↗</div>
<script src="<?= asset_url('js/projects.js') ?>"></script><script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script><script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= time() ?>" defer></script>
</body></html>
