<!DOCTYPE html>
<html lang="en">
<head>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($service['seo_title'] ?? ($service['title'] . ' | Amaanullah Khan, Karachi')) ?></title>
<meta name="description" content="<?= htmlspecialchars($service['meta_description'] ?? ($service['summary'] ?? '')) ?>">
<link rel="canonical" href="<?= canonical_url('/services/' . $service['slug']) ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?= htmlspecialchars($service['seo_title'] ?? $service['title']) ?>">
<meta property="og:description" content="<?= htmlspecialchars($service['meta_description'] ?? ($service['summary'] ?? '')) ?>">
<meta property="og:image" content="<?= !empty($service['banner']) ? asset_url($service['banner']) : asset_url('images/services/' . $service['slug'] . '.webp') ?>">
<meta property="og:url" content="<?= canonical_url('/services/' . $service['slug']) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@akamaanullah">
<meta name="twitter:creator" content="@akamaanullah">
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
<script type="application/ld+json">{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Home", "item": "<?= canonical_url('/') ?>"},
    {"@type": "ListItem", "position": 2, "name": "Services", "item": "<?= canonical_url('/services') ?>"},
    {"@type": "ListItem", "position": 3, "name": "<?= htmlspecialchars($service['title'] ?? 'Service') ?>", "item": "<?= canonical_url('/services/' . $service['slug']) ?>"}
  ]
}</script>
<?php if (!empty($service['schema_json'])): ?>
<?php
  $schema = trim($service['schema_json']);
  if (!str_starts_with($schema, '<script')) {
    $schema = '<script type="application/ld+json">' . $schema . '</script>';
  }
  echo $schema . "\n";
?>
<?php endif; ?>
<link rel="stylesheet" href="<?= asset_url('css/service-detail.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/landing.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
</head>
<body class="dark">
<div class="prog" id="prog"></div>
<?php $home = false; $active = 'Services'; require view_path('layouts/header.php'); ?>

<main>
<?php if (!empty($service['body_html'])): ?>
<?php
$bodyHtml = $service['body_html'];
$bodyHtml = preg_replace_callback('/<\?=\s*asset_url\(([\'"])(.*?)\1\)\s*\?>/', function($m) { return asset_url($m[2]); }, $bodyHtml);
$bodyHtml = preg_replace_callback('/<\?=\s*base_url\(([\'"])(.*?)\1\)\s*\?>/', function($m) { return base_url($m[2]); }, $bodyHtml);
$bodyHtml = preg_replace_callback('/<\?=\s*base_url\(\)\s*\?>/', function($m) { return base_url('/'); }, $bodyHtml);
echo $bodyHtml;
?>
<?php else: ?>
<div class="wrap">
 <nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/services') ?>">Services</a></li><li aria-current="page"><?= htmlspecialchars($service['title'] ?? '') ?></li></ol></nav>
 <section class="hero2">
  <div>
   <div class="badges"><span class="bdg">Service</span><?php if (!empty($service['tags'])): ?><span class="bdg l"><i></i><?= htmlspecialchars($service['tags']) ?></span><?php endif; ?></div>
   <h1><?= htmlspecialchars($service['title'] ?? '') ?><?php if (!empty($service['highlight_em'])): ?> <em><?= htmlspecialchars($service['highlight_em']) ?></em><?php endif; ?></h1>
   <p class="sum"><?= htmlspecialchars($service['summary'] ?? '') ?></p>
   <div class="hcta"><a class="btn o" href="<?= base_url('/contact') ?>">Request scope &amp; quote →</a></div>
  </div>
 </section>
</div>
<?php endif; ?>
</main>
<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/service-detail.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script><script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= time() ?>" defer></script>
</body></html>