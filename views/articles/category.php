<?php
/**
 * Dynamic Article Category Page
 * Powered by unified SeoEngine, real database content, and live schema graphs.
 */
$catSlug = $category['slug'] ?? 'web-development';
$catName = $category['name'] ?? 'Web Development';
$catIntro = !empty($category['seo_intro']) ? $category['seo_intro'] : "Explore practical articles, architectural deep-dives, and performance case studies in {$catName} by Amaanullah Khan.";

$all = $allArticles ?? \App\Models\ArticleModel::summaryList('sort_order ASC, id ASC');
$catArticles = $articles ?? array_values(array_filter($all, fn($a) => ($a['category_slug'] ?? '') === $catSlug));

// Calculate live counts per category for the filter tabs
$counts = [
    'all'     => count($all),
    'laravel' => 0,
    'saas'    => 0,
    'ai'      => 0,
    'mobile'  => 0,
    'web'     => 0,
    'career'  => 0,
];
foreach ($all as $art) {
    $c = $art['category_slug'] ?? '';
    if (str_contains($c, 'laravel') || str_contains($c, 'php')) $counts['laravel']++;
    elseif (str_contains($c, 'saas') || str_contains($c, 'crm')) $counts['saas']++;
    elseif (str_contains($c, 'auto') || str_contains($c, 'ai')) $counts['ai']++;
    elseif (str_contains($c, 'flutter') || str_contains($c, 'mobile')) $counts['mobile']++;
    elseif (str_contains($c, 'web')) $counts['web']++;
    elseif (str_contains($c, 'career')) $counts['career']++;
}

$schemaItems = [];
foreach ($catArticles as $i => $a) {
    $schemaItems[] = [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $a['title'],
        'url' => base_url('/articles/' . $a['slug'])
    ];
}

$pageMeta = [
    'title' => "{$catName} Articles & Guides | Amaanullah Khan",
    'description' => $catIntro,
    'canonical' => base_url('/articles/category/' . $catSlug),
    'og_type' => 'website',
    'image' => asset_url('images/og-articles.png'),
    'page_type' => 'CollectionPage',
    'itemList' => $schemaItems,
    'breadcrumbs' => [
        ['name' => 'Home', 'url' => base_url('/')],
        ['name' => 'Articles', 'url' => base_url('/articles')],
        ['name' => $catName, 'url' => base_url('/articles/category/' . $catSlug)]
    ]
];

$extraCss = [
    'css/articles.css',
    'css/chatbot.css',
    'css/layout.css'
];

$featured = $catArticles[0] ?? null;
$remaining = array_slice($catArticles, 1);
?>
<!doctype html>
<html lang="en">
<head>
<?php require view_path('layouts/head.php'); ?>
</head><body>
<div class="bgfx"></div>
<?php $home = false; $active = 'Articles'; require view_path('layouts/header.php'); ?>

<main id="main" data-page="<?= htmlspecialchars($catSlug) ?>">
<header class="ph"><nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/articles') ?>">Articles</a></li><li aria-current="page"><?= htmlspecialchars($catName) ?></li></ol></nav>
 <span class="eyebrow rv2">✦ <?= htmlspecialchars($catName) ?></span>
 <div class="row"><div><h1 class="rv2"><?= htmlspecialchars($catName) ?> <em>Articles &amp; Insights</em></h1><p class="lead2 rv2" style="max-width:640px;margin-top:12px"><?= htmlspecialchars($catIntro) ?></p>
 <form class="srch rv2" role="search" action="<?= base_url('/articles') ?>" method="get"><label for="q-cat" class="hp" style="position:absolute;left:-9999px">Search articles</label><input id="q-cat" type="search" name="q" placeholder="Search articles…"><button type="submit">Search</button></form>
 <div class="ptags rv2"><b>TOPICS</b><a href="<?= base_url('/articles/category/laravel-php') ?>">Laravel</a><a href="<?= base_url('/articles/category/saas-crm') ?>">SaaS & CRM</a><a href="<?= base_url('/articles/category/automation-ai') ?>">Automation & AI</a><a href="<?= base_url('/articles/category/mobile-flutter') ?>">Flutter</a><a href="<?= base_url('/articles/category/web-development') ?>">Web Dev</a><a href="<?= base_url('/articles/category/career-insights') ?>">Career</a></div></div></div>
</header>

<div class="fbar2"><nav class="fts" role="tablist" aria-label="Article categories"><span class="ind" aria-hidden="true"></span><a class="ft" role="tab" href="<?= base_url('/articles') ?>" aria-selected="false" data-f="all">All <sup><?= $counts['all'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/laravel-php') ?>" aria-selected="<?= $catSlug === 'laravel-php' ? 'true' : 'false' ?>" <?= $catSlug === 'laravel-php' ? 'aria-current="page"' : '' ?> data-f="laravel">Laravel &amp; PHP <sup><?= $counts['laravel'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/saas-crm') ?>" aria-selected="<?= $catSlug === 'saas-crm' ? 'true' : 'false' ?>" <?= $catSlug === 'saas-crm' ? 'aria-current="page"' : '' ?> data-f="saas">SaaS &amp; CRM <sup><?= $counts['saas'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/automation-ai') ?>" aria-selected="<?= $catSlug === 'automation-ai' ? 'true' : 'false' ?>" <?= $catSlug === 'automation-ai' ? 'aria-current="page"' : '' ?> data-f="ai">Automation &amp; AI <sup><?= $counts['ai'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/mobile-flutter') ?>" aria-selected="<?= $catSlug === 'mobile-flutter' ? 'true' : 'false' ?>" <?= $catSlug === 'mobile-flutter' ? 'aria-current="page"' : '' ?> data-f="mobile">Mobile (Flutter) <sup><?= $counts['mobile'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/web-development') ?>" aria-selected="<?= $catSlug === 'web-development' ? 'true' : 'false' ?>" <?= $catSlug === 'web-development' ? 'aria-current="page"' : '' ?> data-f="web">Web Development <sup><?= $counts['web'] ?></sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/career-insights') ?>" aria-selected="<?= $catSlug === 'career-insights' ? 'true' : 'false' ?>" <?= $catSlug === 'career-insights' ? 'aria-current="page"' : '' ?> data-f="career">Career &amp; Insights <sup><?= $counts['career'] ?></sup></a></nav></div>

<div id="swap">
<?php if (!empty($catArticles)): ?>
  <?php if ($featured): ?>
  <section class="sec2" aria-labelledby="h-feat"><div class="lbl2 rv2"><h2 id="h-feat">Featured in <?= htmlspecialchars($catName) ?></h2></div>
  <div class="afeat" style="grid-template-columns:1fr">
    <article class="ac pc big">
      <a class="pl al" href="<?= base_url('/articles/' . $featured['slug']) ?>" data-article="<?= htmlspecialchars($featured['slug']) ?>">
      <div class="cov"><img src="<?= asset_url($featured['cover_image']) ?>" alt="<?= htmlspecialchars($featured['title']) ?> — cover image" width="1600" height="900" loading="lazy" decoding="async"><span class="cb"><?= htmlspecialchars($featured['badge_category']) ?></span></div>
      <div class="ab"><h3><?= htmlspecialchars($featured['title']) ?></h3><p><?= htmlspecialchars($featured['excerpt']) ?></p><div class="am"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="Amaanullah Khan" width="28" height="28" loading="lazy"><span><b>Amaanullah Khan</b><small><time><?= !empty($featured['published_at']) ? date('M d, Y', strtotime($featured['published_at'])) : 'Recent' ?></time> · <?= htmlspecialchars($featured['reading_time']) ?></small></span></div></div></a>
    </article>
  </div></section>
  <?php endif; ?>

  <?php if (!empty($remaining)): ?>
  <section class="sec2" aria-labelledby="h-all"><div class="lbl2 rv2"><h2 id="h-all">More in <?= htmlspecialchars($catName) ?></h2></div>
  <div class="alay"><div><div class="agrid">
    <?php foreach ($remaining as $ra): ?>
    <article class="ac pc">
      <a class="pl al" href="<?= base_url('/articles/' . $ra['slug']) ?>" data-article="<?= htmlspecialchars($ra['slug']) ?>">
      <div class="cov"><img src="<?= asset_url($ra['cover_image']) ?>" alt="<?= htmlspecialchars($ra['title']) ?> — cover image" width="1600" height="900" loading="lazy" decoding="async"><span class="cb"><?= htmlspecialchars($ra['badge_category']) ?></span></div>
      <div class="ab"><h3><?= htmlspecialchars($ra['title']) ?></h3><p><?= htmlspecialchars($ra['excerpt']) ?></p><div class="am"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="Amaanullah Khan" width="28" height="28" loading="lazy"><span><b>Amaanullah Khan</b><small><time><?= !empty($ra['published_at']) ? date('M d, Y', strtotime($ra['published_at'])) : 'Recent' ?></time> · <?= htmlspecialchars($ra['reading_time']) ?></small></span></div></div></a>
    </article>
    <?php endforeach; ?>
  </div></div><aside class="aside" aria-label="Sidebar">
    <section class="box rv2"><h3>Most read</h3><ol class="mr">
      <?php foreach (array_slice($all, 0, 4) as $mr): ?>
      <li><a href="<?= base_url('/articles/' . $mr['slug']) ?>" data-article="<?= htmlspecialchars($mr['slug']) ?>"><?= htmlspecialchars($mr['title']) ?></a></li>
      <?php endforeach; ?>
    </ol></section>
    <section class="box nlb rv2" aria-labelledby="h-nl"><h3 id="h-nl">Get new articles by email</h3><p>Occasional, practical posts on Laravel, SaaS and automation. No spam.</p>
      <form class="nlf" action="javascript:void(0)" method="post" novalidate>
        <label class="hp" aria-hidden="true">Leave empty<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        <label for="nl-cat" class="hp">Email address</label><input id="nl-cat" type="email" name="email" placeholder="you@company.com" required autocomplete="email">
        <button type="submit">Subscribe</button><div class="msg" role="status" aria-live="polite"></div></form>
    </section>
    <section class="box rv2"><h3>Topics</h3><div class="tagc"><a href="<?= base_url('/articles/category/laravel-php') ?>">Laravel &amp; PHP</a><a href="<?= base_url('/articles/category/saas-crm') ?>">SaaS &amp; CRM</a><a href="<?= base_url('/articles/category/automation-ai') ?>">Automation &amp; AI</a><a href="<?= base_url('/articles/category/mobile-flutter') ?>">Mobile (Flutter)</a><a href="<?= base_url('/articles/category/web-development') ?>">Web Development</a><a href="<?= base_url('/articles/category/career-insights') ?>">Career &amp; Insights</a></div></section>
  </aside></div></section>
  <?php endif; ?>

<?php else: ?>
  <section class="sec2" style="text-align:center;padding:60px 20px;">
    <div style="max-width:640px;margin:0 auto;background:#1b1c26;padding:40px;border-radius:16px;border:1px solid #2b2c3a;">
      <h2 style="font-size:24px;margin-bottom:12px;color:#fff;">New Articles Coming Soon</h2>
      <p style="color:#d2b088;font-size:16px;line-height:1.6;margin-bottom:24px;">Deep-dive guides and production case studies for <strong><?= htmlspecialchars($catName) ?></strong> are currently being authored. In the meantime, explore our latest published articles below:</p>
      <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
        <a href="<?= base_url('/articles/category/web-development') ?>" class="bo w" style="padding:10px 20px;border-radius:999px;text-decoration:none;">Web Development (<?= $counts['web'] ?>)</a>
        <a href="<?= base_url('/articles/category/saas-crm') ?>" class="bo w" style="padding:10px 20px;border-radius:999px;text-decoration:none;">SaaS &amp; CRM (<?= $counts['saas'] ?>)</a>
        <a href="<?= base_url('/articles/category/automation-ai') ?>" class="bo w" style="padding:10px 20px;border-radius:999px;text-decoration:none;">Automation &amp; AI (<?= $counts['ai'] ?>)</a>
      </div>
    </div>
  </section>

  <section class="sec2" aria-labelledby="h-popular"><div class="lbl2 rv2"><h2 id="h-popular">Recommended technical reads</h2></div>
  <div class="alay"><div><div class="agrid">
    <?php foreach (array_slice($all, 0, 4) as $rec): ?>
    <article class="ac pc">
      <a class="pl al" href="<?= base_url('/articles/' . $rec['slug']) ?>" data-article="<?= htmlspecialchars($rec['slug']) ?>">
      <div class="cov"><img src="<?= asset_url($rec['cover_image']) ?>" alt="<?= htmlspecialchars($rec['title']) ?> — cover image" width="1600" height="900" loading="lazy" decoding="async"><span class="cb"><?= htmlspecialchars($rec['badge_category']) ?></span></div>
      <div class="ab"><h3><?= htmlspecialchars($rec['title']) ?></h3><p><?= htmlspecialchars($rec['excerpt']) ?></p><div class="am"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="Amaanullah Khan" width="28" height="28" loading="lazy"><span><b>Amaanullah Khan</b><small><time><?= !empty($rec['published_at']) ? date('M d, Y', strtotime($rec['published_at'])) : 'Recent' ?></time> · <?= htmlspecialchars($rec['reading_time']) ?></small></span></div></div></a>
    </article>
    <?php endforeach; ?>
  </div></div><aside class="aside" aria-label="Sidebar">
    <section class="box rv2"><h3>Most read</h3><ol class="mr">
      <?php foreach (array_slice($all, 0, 4) as $mr): ?>
      <li><a href="<?= base_url('/articles/' . $mr['slug']) ?>" data-article="<?= htmlspecialchars($mr['slug']) ?>"><?= htmlspecialchars($mr['title']) ?></a></li>
      <?php endforeach; ?>
    </ol></section>
  </aside></div></section>
<?php endif; ?>

<section class="cta2"><div class="band rv2"><div><h2>Have a system that needs building?</h2><p>Tell me what's slowing your business down — I reply within 24 hours with next steps.</p></div><div class="btns" style="margin:0"><a class="bo w" href="<?= base_url('/contact') ?>">Book a Call →</a><a class="bo g" href="<?= base_url('/services') ?>">View services</a></div></div></section>
</div>
</main>
<?php require view_path('layouts/footer.php'); ?>

<div class="cur" id="cur" aria-hidden="true">Read ↗</div>
<script src="<?= asset_url('js/articles.js') ?>"></script><script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script><script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/chatbot-config.js') ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/chatbot.js') ?>" defer></script>
</body></html>
