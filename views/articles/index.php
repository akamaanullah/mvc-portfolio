<?php
$allArticles = $articles ?? [];
if (empty($allArticles)) {
    $allArticles = \App\Models\ArticleModel::all('id ASC');
}

$counts = [
    'all'     => count($allArticles),
    'laravel' => 0,
    'saas'    => 0,
    'ai'      => 0,
    'mobile'  => 0,
    'web'     => 0,
    'career'  => 0,
];
foreach ($allArticles as $art) {
    $c = $art['category_slug'] ?? '';
    if (str_contains($c, 'laravel') || str_contains($c, 'php')) $counts['laravel']++;
    elseif (str_contains($c, 'saas') || str_contains($c, 'crm')) $counts['saas']++;
    elseif (str_contains($c, 'auto') || str_contains($c, 'ai')) $counts['ai']++;
    elseif (str_contains($c, 'flutter') || str_contains($c, 'mobile')) $counts['mobile']++;
    elseif (str_contains($c, 'web')) $counts['web']++;
    elseif (str_contains($c, 'career')) $counts['career']++;
}

$featuredBig = $allArticles[0] ?? null;
$featuredSide = array_slice($allArticles, 1, 2);
$gridArticles = array_slice($allArticles, 3);
?>
<!doctype html><html lang="en"><head>
<script src="<?= asset_url('js/theme.js') ?>"></script><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Articles on Laravel, SaaS, Automation &amp; Flutter | Amaanullah Khan</title>
<meta name="description" content="Practical articles by Amaanullah Khan, a Karachi-based PHP &amp; Laravel developer, on building CRMs, SaaS products, business automation, Flutter apps and fast websites.">
<link rel="canonical" href="<?= base_url('/articles') ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="Articles on Laravel, SaaS, Automation &amp; Flutter | Amaanullah Khan">
<meta property="og:description" content="Practical articles by Amaanullah Khan, a Karachi-based PHP &amp; Laravel developer, on building CRMs, SaaS products, business automation, Flutter apps and fast websites.">
<meta property="og:url" content="<?= base_url('/articles') ?>">
<meta property="og:image" content="<?= asset_url('images/og-articles.png') ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Articles on Laravel, SaaS, Automation &amp; Flutter | Amaanullah Khan">
<meta name="twitter:description" content="Practical articles by Amaanullah Khan, a Karachi-based PHP &amp; Laravel developer, on building CRMs, SaaS products, business automation, Flutter apps and fast websites.">
<meta name="twitter:image" content="<?= asset_url('images/og-articles.png') ?>">
<link rel="icon" href="<?= asset_url('logo-v2/favicon.ico') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Caveat:wght@600&display=swap" rel="stylesheet">
<script type="application/ld+json" class="pld">{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [{"@type": "ListItem", "position": 1, "name": "Home", "item": "<?= base_url('/') ?>"}, {"@type": "ListItem", "position": 2, "name": "Articles", "item": "<?= base_url('/articles') ?>"}]}</script>
<script type="application/ld+json" class="pld">{
 "@context": "https://schema.org",
 "@type": ["Blog", "CollectionPage"],
 "name": "Articles on Laravel, SaaS, Automation & Flutter | Amaanullah Khan",
 "description": "Practical articles by Amaanullah Khan, a Karachi-based PHP & Laravel developer, on building CRMs, SaaS products, business automation, Flutter apps and fast websites.",
 "url": "<?= base_url('/articles') ?>",
 "author": {"@type": "Person", "name": "Amaanullah Khan"},
 "mainEntity": {
  "@type": "ItemList",
  "itemListElement": [
   <?php foreach (array_slice($allArticles, 0, 10) as $i => $a): ?>
   {"@type": "ListItem", "position": <?= $i + 1 ?>, "url": "<?= base_url('/articles/' . $a['slug']) ?>", "name": <?= json_encode($a['title']) ?>}<?= $i < min(9, count($allArticles) - 1) ? ',' : '' ?>
   <?php endforeach; ?>
  ]
 }
}</script>
<link rel="stylesheet" href="<?= asset_url('css/articles.css') ?>"><link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
</head><body>
<div class="bgfx"></div>
<?php $home = false; $active = ''; require view_path('layouts/header.php'); ?>

<main id="main" data-page="all">
<header class="ph"><nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li aria-current="page">Articles</li></ol></nav>
 <span class="eyebrow rv2">✦ Articles</span>
 <div class="row"><div><h1 class="rv2">Notes from <em>building real systems.</em></h1><p class="lead2 rv2" style="max-width:640px;margin-top:12px">Practical write-ups on Laravel, SaaS and CRM architecture, automation and Flutter — the decisions behind systems teams actually use, written for founders and developers.</p>
 <form class="srch rv2" role="search" action="<?= base_url('/articles') ?>" method="get"><label for="q-all" class="hp" style="position:absolute;left:-9999px">Search articles</label><input id="q-all" type="search" name="q" placeholder="Search articles…"><button type="submit">Search</button></form>
 <div class="ptags rv2"><b>POPULAR</b><a href="<?= base_url('/articles/category/laravel-php') ?>">Laravel</a><a href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>">Multi-tenant</a><a href="<?= base_url('/articles/category/saas-crm') ?>">CRM</a><a href="<?= base_url('/articles/category/automation-ai') ?>">Automation</a><a href="<?= base_url('/articles/category/mobile-flutter') ?>">Flutter</a><a href="<?= base_url('/articles/flutter-with-laravel-api') ?>">REST API</a><a href="<?= base_url('/articles/fast-websites-checklist') ?>">Page speed</a><a href="<?= base_url('/articles/saas-billing-basics') ?>">SaaS billing</a></div></div></div>
</header>
<div class="fbar2"><nav class="fts" role="tablist" aria-label="Article categories"><span class="ind" aria-hidden="true"></span><a class="ft" role="tab" href="<?= base_url('/articles') ?>" aria-selected="true" aria-current="page" data-f="all">All <sup><?= $counts['all'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/laravel-php') ?>" aria-selected="false" data-f="laravel">Laravel &amp; PHP <sup><?= $counts['laravel'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/saas-crm') ?>" aria-selected="false" data-f="saas">SaaS &amp; CRM <sup><?= $counts['saas'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/automation-ai') ?>" aria-selected="false" data-f="ai">Automation &amp; AI <sup><?= $counts['ai'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/mobile-flutter') ?>" aria-selected="false" data-f="mobile">Mobile (Flutter) <sup><?= $counts['mobile'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/web-development') ?>" aria-selected="false" data-f="web">Web Development <sup><?= $counts['web'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/career-insights') ?>" aria-selected="false" data-f="career">Career &amp; Insights <sup><?= $counts['career'] ?></sup></a></nav></div>
<div id="swap">
<section class="sec2" aria-labelledby="h-feat"><div class="lbl2 rv2"><h2 id="h-feat">Featured</h2></div>
<div class="afeat">
 <?php if ($featuredBig): ?>
 <article class="ac pc big">
 <a class="pl al" href="<?= base_url('/articles/' . $featuredBig['slug']) ?>" data-article="<?= htmlspecialchars($featuredBig['slug']) ?>">
 <div class="cov"><img src="<?= asset_url($featuredBig['cover_image']) ?>" alt="<?= htmlspecialchars($featuredBig['title']) ?> — cover image" width="1600" height="900" loading="lazy" decoding="async"><span class="cb"><?= htmlspecialchars($featuredBig['badge_category']) ?></span></div>
 <div class="ab"><h3><?= htmlspecialchars($featuredBig['title']) ?></h3><p><?= htmlspecialchars($featuredBig['excerpt']) ?></p><div class="am"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="Amaanullah Khan" width="28" height="28" loading="lazy"><span><b>Amaanullah Khan</b><small><time><?= !empty($featuredBig['published_at']) ? date('M Y', strtotime($featuredBig['published_at'])) : 'Recent' ?></time> · <?= htmlspecialchars($featuredBig['reading_time']) ?></small></span></div></div></a></article>
 <?php endif; ?>
 <div class="side">
  <?php foreach ($featuredSide as $fs): ?>
  <article class="ac pc sm">
  <a class="pl al" href="<?= base_url('/articles/' . $fs['slug']) ?>" data-article="<?= htmlspecialchars($fs['slug']) ?>">
  <div class="cov"><img src="<?= asset_url($fs['cover_image']) ?>" alt="<?= htmlspecialchars($fs['title']) ?> — cover image" width="1600" height="900" loading="lazy" decoding="async"><span class="cb"><?= htmlspecialchars($fs['badge_category']) ?></span></div>
  <div class="ab"><h3><?= htmlspecialchars($fs['title']) ?></h3><p><?= htmlspecialchars($fs['excerpt']) ?></p><div class="am"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="Amaanullah Khan" width="28" height="28" loading="lazy"><span><b>Amaanullah Khan</b><small><time><?= !empty($fs['published_at']) ? date('M Y', strtotime($fs['published_at'])) : 'Recent' ?></time> · <?= htmlspecialchars($fs['reading_time']) ?></small></span></div></div></a></article>
  <?php endforeach; ?>
 </div></div></section>
<section class="sec2" aria-labelledby="h-all"><div class="lbl2 rv2"><h2 id="h-all">All articles</h2></div>
<div class="alay"><div><div class="agrid">
 <?php foreach ($gridArticles as $ga): ?>
 <article class="ac pc ">
 <a class="pl al" href="<?= base_url('/articles/' . $ga['slug']) ?>" data-article="<?= htmlspecialchars($ga['slug']) ?>">
 <div class="cov"><img src="<?= asset_url($ga['cover_image']) ?>" alt="<?= htmlspecialchars($ga['title']) ?> — cover image" width="1600" height="900" loading="lazy" decoding="async"><span class="cb"><?= htmlspecialchars($ga['badge_category']) ?></span></div>
 <div class="ab"><h3><?= htmlspecialchars($ga['title']) ?></h3><p><?= htmlspecialchars($ga['excerpt']) ?></p><div class="am"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="Amaanullah Khan" width="28" height="28" loading="lazy"><span><b>Amaanullah Khan</b><small><time><?= !empty($ga['published_at']) ? date('M Y', strtotime($ga['published_at'])) : 'Recent' ?></time> · <?= htmlspecialchars($ga['reading_time']) ?></small></span></div></div></a></article>
 <?php endforeach; ?>
</div></div><aside class="aside" aria-label="Sidebar">
 <section class="box rv2"><h3>Most read</h3><ol class="mr">
  <?php foreach (array_slice($allArticles, 0, 4) as $mr): ?>
  <li><a href="<?= base_url('/articles/' . $mr['slug']) ?>" data-article="<?= htmlspecialchars($mr['slug']) ?>"><?= htmlspecialchars($mr['title']) ?></a></li>
  <?php endforeach; ?>
 </ol></section>
 <section class="box nlb rv2" aria-labelledby="h-nl"><h3 id="h-nl">Get new articles by email</h3><p>Occasional, practical posts on Laravel, SaaS and automation. No spam.</p>
  <form class="nlf" action="javascript:void(0)" method="post" novalidate>
   <label class="hp" aria-hidden="true">Leave empty<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
   <label for="nl-all" class="hp">Email address</label><input id="nl-all" type="email" name="email" placeholder="you@company.com" required autocomplete="email">
   <button type="submit">Subscribe</button><div class="msg" role="status" aria-live="polite"></div></form>
 </section>
 <section class="box rv2"><h3>Topics</h3><div class="tagc"><a href="<?= base_url('/articles/category/laravel-php') ?>">Laravel &amp; PHP</a><a href="<?= base_url('/articles/category/saas-crm') ?>">SaaS &amp; CRM</a><a href="<?= base_url('/articles/category/automation-ai') ?>">Automation &amp; AI</a><a href="<?= base_url('/articles/category/mobile-flutter') ?>">Mobile (Flutter)</a><a href="<?= base_url('/articles/category/web-development') ?>">Web Development</a><a href="<?= base_url('/articles/category/career-insights') ?>">Career &amp; Insights</a></div></section>
</aside></div></section>
<section class="cta2"><div class="band rv2"><div><h2>Have a system that needs building?</h2><p>Tell me what's slowing your business down — I reply within 24 hours with next steps.</p></div><div class="btns" style="margin:0"><a class="bo w" href="<?= base_url('/contact') ?>">Book a Call →</a><a class="bo g" href="<?= base_url('/services') ?>">View services</a></div></div></section>
</div></main>
<?php require view_path('layouts/footer.php'); ?>

<div class="cur" id="cur" aria-hidden="true">Read ↗</div>
<script src="<?= asset_url('js/articles.js') ?>"></script><script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script><script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= time() ?>" defer></script>
</body></html>