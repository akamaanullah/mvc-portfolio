<?php
// Validate that project item and slug exist
if (empty($item) || empty($item['slug'])) {
    header('Location: ' . base_url('/projects'), true, 302);
    exit;
}

$p = $item;
$slug = $p['slug'];
$title = $p['title'] ?? '';
$highlightEm = $p['highlight_em'] ?? '';
$domain = $p['domain'] ?? '';
$summary = $p['summary'] ?? '';
$catSlug = $p['category_slug'] ?? 'web-design-development';
$catName = match($catSlug) {
    'web-design-development' => 'Web Design & Development',
    'web-applications'       => 'Web Applications',
    'mobile-apps'            => 'Mobile Apps',
    default                  => 'Products & Systems',
};

// If body_html is missing from database, show explicit missing content screen
if (empty($p['body_html'])) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Content Missing — <?= htmlspecialchars($title ?: $slug) ?></title>
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, "Plus Jakarta Sans", "Segoe UI", Roboto, sans-serif; background: #14141c; color: #f4ebe1; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 24px; box-sizing: border-box; }
            .err-box { background: #1e1e29; border: 1px solid #462e22; border-radius: 20px; padding: 44px 36px; max-width: 620px; width: 100%; text-align: center; box-shadow: 0 25px 60px rgba(0,0,0,0.5); }
            .err-badge { display: inline-block; background: rgba(242,106,27,0.15); color: #f26a1b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; padding: 6px 14px; border-radius: 999px; margin-bottom: 20px; }
            h1 { font-size: 26px; margin: 0 0 14px; font-weight: 800; color: #fff; line-height: 1.25; }
            p { color: #d2b088; font-size: 16px; line-height: 1.6; margin: 0 0 20px; }
            code { background: #0b0b10; color: #ff8a3d; padding: 4px 8px; border-radius: 6px; font-family: "JetBrains Mono", monospace; font-size: 14px; }
            .btn { display: inline-block; background: #f26a1b; color: #fff; font-weight: 700; text-decoration: none; padding: 12px 28px; border-radius: 999px; transition: 0.2s; font-size: 15px; margin-top: 10px; }
            .btn:hover { background: #ff8a3d; transform: translateY(-1px); }
        </style>
    </head>
    <body>
        <div class="err-box">
            <span class="err-badge">Database Content Required</span>
            <h1>Project Content Missing</h1>
            <p>The case study content (<code>body_html</code>) for project <code><?= htmlspecialchars($slug) ?></code> has not been populated in the database yet.</p>
            <p style="font-size: 14px; color: #9c9285;">Please import the corresponding SQL / seeder data for this project into the MySQL database.</p>
            <a href="<?= base_url('/projects') ?>" class="btn">← Back to All Projects</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

$seoTitle = !empty($p['seo_title']) ? $p['seo_title'] : ($title . ($highlightEm ? " $highlightEm" : '') . ' | Case Study · Amaanullah Khan');
$metaDesc = !empty($p['meta_description']) ? $p['meta_description'] : $summary;
$bannerUrl = !empty($p['banner']) ? asset_url($p['banner']) : asset_url('images/banners/' . $slug . '.svg');
$bannerAlt = !empty($p['banner_alt']) ? $p['banner_alt'] : ($title . ' banner');
$client = $p['client'] ?? '';
$industry = $p['industry'] ?? '';
$role = $p['role'] ?? '';
$timeline = $p['timeline'] ?? '';
$platform = $p['platform'] ?? '';
$projectStatus = $p['project_status'] ?? 'Completed';
$chips = !empty($p['tech_chips']) ? array_filter(array_map('trim', explode(',', $p['tech_chips']))) : [];
$tldr = $p['tldr'] ?? '';
$keyResultsRaw = !empty($p['key_results']) ? array_filter(array_map('trim', explode("\n", trim($p['key_results'])))) : [];
$ctaTitle = !empty($p['cta_title']) ? $p['cta_title'] : 'Ready to build a high-performance web platform?';
$ctaText = !empty($p['cta_text']) ? $p['cta_text'] : 'Whether you need an agency platform, custom web application, or technical SEO overhaul, let’s discuss how custom architecture can drive measurable ROI.';
$ctaLabel = !empty($p['cta_label']) ? $p['cta_label'] : 'Book a free technical consultation →';
$prevProject = $prev ?? null;
$nextProject = $next ?? null;
$relatedProjects = $related ?? [];
$projectCanonicalUrl = canonical_url('/projects/' . $slug);
$shareEncodedUrl = rawurlencode($projectCanonicalUrl);
$shareEncodedTitle = rawurlencode($title . ($highlightEm ? ' ' . $highlightEm : ''));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script>
(function(){var t;try{t=localStorage.getItem('theme')}catch(e){}var dark=t!=='light';var d=document.documentElement;d.setAttribute('data-theme',dark?'dark':'light');d.style.colorScheme=dark?'dark':'light';if(document.body&&dark)document.body.classList.add('dark');})();
document.addEventListener('DOMContentLoaded',function(){if(window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches){document.querySelectorAll('video.pvid').forEach(function(v){v.removeAttribute('autoplay');v.pause();v.preload='none';v.load()})}});
</script>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($seoTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
<link rel="canonical" href="<?= $projectCanonicalUrl ?>">
<meta property="og:type" content="article">
<meta property="og:site_name" content="Amaanullah">
<meta property="og:title" content="<?= htmlspecialchars($title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($summary) ?>">
<meta property="og:image" content="<?= htmlspecialchars($bannerUrl) ?>">
<meta property="og:url" content="<?= $projectCanonicalUrl ?>">
<meta property="article:author" content="Amaanullah Khan">
<meta property="article:section" content="<?= htmlspecialchars($catName) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@akamaanullah">
<meta name="twitter:creator" content="@akamaanullah">
<meta name="twitter:title" content="<?= htmlspecialchars($title) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($summary) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($bannerUrl) ?>">
<meta name="geo.region" content="PK-SD">
<meta name="geo.placename" content="Karachi, Sindh, Pakistan">
<meta name="geo.position" content="24.8607;67.0011">
<meta name="ICBM" content="24.8607, 67.0011">
<meta name="DC.creator" content="Amaanullah Khan">
<meta name="DC.publisher" content="Amaanullah Khan">
<link rel="manifest" href="<?= asset_url('manifest.json') ?>">
<link rel="icon" href="<?= asset_url('logo-v2/favicon-32.png') ?>">
<link rel="apple-touch-icon" href="<?= asset_url('logo-v2/apple-touch-icon-180.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [{"@type": "ListItem", "position": 1, "name": "Home", "item": "<?= canonical_url('/') ?>"}, {"@type": "ListItem", "position": 2, "name": "Projects", "item": "<?= canonical_url('/projects') ?>"}, {"@type": "ListItem", "position": 3, "name": "<?= htmlspecialchars($catName) ?>", "item": "<?= canonical_url('/projects/category/' . $catSlug) ?>"}, {"@type": "ListItem", "position": 4, "name": "<?= htmlspecialchars($title) ?>", "item": "<?= $projectCanonicalUrl ?>"}]}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": ["Article", "CreativeWork"], "headline": <?= json_encode($seoTitle) ?>, "description": <?= json_encode($metaDesc) ?>, "image": <?= json_encode($bannerUrl) ?>, "author": {"@type": "Person", "name": "Amaanullah Khan", "url": "<?= canonical_url('/about') ?>"}, "publisher": {"@type": "Person", "name": "Amaanullah Khan"}, "datePublished": "<?= !empty($p['published_at']) ? date('Y-m-d', strtotime($p['published_at'])) : date('Y-m-d') ?>", "dateModified": "<?= !empty($p['updated_at']) ? date('Y-m-d', strtotime($p['updated_at'])) : date('Y-m-d') ?>", "mainEntityOfPage": "<?= $projectCanonicalUrl ?>"}</script>
<link rel="stylesheet" href="<?= asset_url('css/case-study.css') ?>?v=<?= filemtime(PUBLIC_PATH . '/css/case-study.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>?v=<?= filemtime(PUBLIC_PATH . '/css/chatbot.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>?v=<?= filemtime(PUBLIC_PATH . '/css/layout.css') ?>">
</head>
<body>
<div class="prog" id="prog"></div>
<?php $home = false; $active = 'Projects'; require view_path('layouts/header.php'); ?>

<main>
<div class="wrap">
 <nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/projects') ?>">Projects</a></li><li><a href="<?= base_url('/projects/category/' . $catSlug) ?>"><?= htmlspecialchars($catName) ?></a></li><li aria-current="page"><?= htmlspecialchars($title) ?></li></ol></nav>
 
 <section class="hero">
  <div class="badges">
    <a class="bdg" href="<?= base_url('/projects/category/' . $catSlug) ?>"><?= htmlspecialchars($catName) ?></a>
    <?php if ($domain): 
      $domainUrl = str_starts_with($domain, 'http') ? $domain : 'https://' . $domain;
    ?><a class="bdg l" href="<?= htmlspecialchars($domainUrl) ?>" target="_blank" rel="noopener noreferrer" title="Visit <?= htmlspecialchars($domain) ?>"><i></i><?= htmlspecialchars($domain) ?><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-left:5px;opacity:.75"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg></a><?php endif; ?>
  </div>
  
  <h1><?= htmlspecialchars($title) ?><?php if ($highlightEm): ?> <em><?= htmlspecialchars($highlightEm) ?></em><?php endif; ?></h1>
  <?php if ($summary): ?><p class="sum"><?= htmlspecialchars($summary) ?></p><?php endif; ?>
  
  <div class="hmeta">
    <span>By Amaanullah Khan</span><span>·</span>
    <span id="rtime">— min read</span><span>·</span>
    <span>Updated <?= !empty($p['updated_at']) ? date('M Y', strtotime($p['updated_at'])) : date('M Y') ?></span>
  </div>
  
  <?php if ($bannerUrl): ?>
  <div class="ban"><img src="<?= htmlspecialchars($bannerUrl) ?>" alt="<?= htmlspecialchars($bannerAlt) ?>" width="1600" height="1000" fetchpriority="high"></div>
  <?php endif; ?>
  
  <dl class="facts">
    <?php if ($client): ?><div><dt>Client</dt><dd><?= htmlspecialchars($client) ?></dd></div><?php endif; ?>
    <?php if ($industry): ?><div><dt>Industry</dt><dd><?= htmlspecialchars($industry) ?></dd></div><?php endif; ?>
    <?php if ($role): ?><div><dt>Role</dt><dd><?= htmlspecialchars($role) ?></dd></div><?php endif; ?>
    <?php if ($timeline): ?><div><dt>Timeline</dt><dd><?= htmlspecialchars($timeline) ?></dd></div><?php endif; ?>
    <?php if ($platform): ?><div><dt>Platform</dt><dd><?= htmlspecialchars($platform) ?></dd></div><?php endif; ?>
    <div><dt>Status</dt><dd><?= htmlspecialchars($projectStatus) ?></dd></div>
  </dl>
  
  <?php if (!empty($chips)): ?>
  <div class="chips"><?php foreach ($chips as $ch): ?><span class="chip"><?= htmlspecialchars($ch) ?></span><?php endforeach; ?></div>
  <?php endif; ?>
 </section>

 <?php if ($tldr || !empty($keyResultsRaw)): ?>
 <section class="tldr-wrap" aria-label="Executive summary and key results">
  <?php if ($tldr): ?>
  <div class="tl-story">
   <div class="tl-head"><span class="tl-tag">TL;DR</span><span class="tl-sub">Executive Summary</span></div>
   <p><?= htmlspecialchars($tldr) ?></p>
  </div>
  <?php endif; ?>
  <?php if (!empty($keyResultsRaw)): ?>
  <div class="tl-metrics">
   <?php foreach ($keyResultsRaw as $kr): $parts = explode('|', $kr, 2); ?>
   <div class="tl-kpi">
     <b><?= htmlspecialchars(trim($parts[0] ?? '')) ?></b>
     <span><?= htmlspecialchars(trim($parts[1] ?? '')) ?></span>
   </div>
   <?php endforeach; ?>
  </div>
  <?php endif; ?>
 </section>
 <?php endif; ?>

 <div class="layout">
  <aside class="toc" aria-label="On this page">
   <div class="rt"><span>On this page</span><span id="pct">0%</span></div>
   <div class="bar"><i id="tbar"></i></div>
   <ol>
     <!-- Dynamically generated from section headers by case-study.js -->
   </ol>
   <div class="share">Share<br>
     <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $shareEncodedUrl ?>" target="_blank" rel="noopener noreferrer" title="Share on LinkedIn">LinkedIn</a>
     <a href="https://twitter.com/intent/tweet?url=<?= $shareEncodedUrl ?>&text=<?= $shareEncodedTitle ?>" target="_blank" rel="noopener noreferrer" title="Share on X">X</a>
     <a href="javascript:void(0)" class="copy-link-btn" title="Copy project link">Copy link</a>
   </div>
  </aside>
  
  <div class="mtoc">
   <details>
    <summary>On this page <span id="mcur">Overview</span></summary>
    <ol>
      <!-- Dynamically generated from section headers by case-study.js -->
    </ol>
   </details>
  </div>
  
  <article class="content" id="content">
    <?= $p['body_html'] ?>
  </article>
 </div>

 <nav class="pn" aria-label="More projects">
  <?php if ($prevProject): ?>
    <a href="<?= base_url('/projects/' . $prevProject['slug']) ?>"><small>← Previous project</small><b><?= htmlspecialchars($prevProject['title']) ?></b></a>
  <?php else: ?>
    <a href="<?= base_url('/projects') ?>"><small>← All projects</small><b>Explore Portfolio</b></a>
  <?php endif; ?>
  <?php if ($nextProject): ?>
    <a href="<?= base_url('/projects/' . $nextProject['slug']) ?>"><small>Next project →</small><b><?= htmlspecialchars($nextProject['title']) ?></b></a>
  <?php else: ?>
    <a href="<?= base_url('/projects') ?>"><small>Next →</small><b>All Projects</b></a>
  <?php endif; ?>
 </nav>

 <?php if (!empty($relatedProjects)): ?>
 <section class="rel" aria-labelledby="h-rel">
  <p class="eyb">Related systems</p>
  <h2 id="h-rel">More Projects</h2>
  <div class="rgrid">
    <?php foreach ($relatedProjects as $rel): 
      $rCat = match($rel['category_slug'] ?? '') {
        'web-design-development' => 'Web Design & Development',
        'web-applications'       => 'Web Applications',
        'mobile-apps'            => 'Mobile Apps',
        default                  => 'Products & Systems',
      };
      $rBanner = !empty($rel['banner']) ? asset_url($rel['banner']) : asset_url('images/banners/' . ($rel['slug'] ?? 'default') . '.svg');
    ?>
    <a class="rc" href="<?= base_url('/projects/' . $rel['slug']) ?>">
      <img src="<?= htmlspecialchars($rBanner) ?>" alt="<?= htmlspecialchars($rel['title']) ?>" loading="lazy" width="1600" height="1000">
      <div>
        <small><?= htmlspecialchars($rCat) ?></small>
        <h3><?= htmlspecialchars($rel['title']) ?></h3>
        <p><?= htmlspecialchars(mb_strimwidth($rel['summary'] ?? '', 0, 85, '…')) ?></p>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
 </section>
 <?php endif; ?>

 <section class="cta">
  <div>
    <h2><?= htmlspecialchars($ctaTitle) ?></h2>
    <p><?= htmlspecialchars($ctaText) ?></p>
  </div>
  <a class="btn" href="<?= base_url('/#contact') ?>"><?= htmlspecialchars($ctaLabel) ?></a>
 </section>
</div>
</main>

<?php require view_path('layouts/footer.php'); ?>

<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Image preview"><button aria-label="Close">✕</button><figure><img alt=""><p></p></figure></div>
<script src="<?= asset_url('js/case-study.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/case-study.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script>
<script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/chatbot-config.js') ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/chatbot.js') ?>" defer></script>
</body>
</html>
