<?php
/**
 * Master dynamic template for SEO Landing Pages.
 * Loaded by LandingController with ['landing' => $page].
 */
$l = $landing ?? $page ?? [];
$slug = $l['slug'] ?? '';
$title = !empty($l['seo_title']) ? $l['seo_title'] : (!empty($l['title']) ? $l['title'] : 'Web & Software Development | Amaanullah Khan');
$desc = !empty($l['meta_description']) ? $l['meta_description'] : 'Senior software developer building custom CRM systems, SaaS platforms, automation workflows and modern web apps.';
$canonical = base_url('/' . $slug);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($title) ?></title>
<meta name="description" content="<?= htmlspecialchars($desc) ?>">
<link rel="canonical" href="<?= $canonical ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?= htmlspecialchars($title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($desc) ?>">
<meta property="og:url" content="<?= $canonical ?>">
<meta property="og:image" content="<?= asset_url('images/og/landing.webp') ?>">
<meta property="og:locale" content="en_PK">
<meta name="twitter:card" content="summary_large_image">
<meta name="geo.region" content="PK-SD">
<meta name="geo.placename" content="<?= htmlspecialchars($l['city'] ?? 'Karachi') ?>">
<link rel="icon" href="<?= asset_url('logo-v2/favicon-32.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&family=Caveat:wght@600&display=swap" rel="stylesheet">
<?php if (!empty($l['schema_json'])): ?>
<?php
  $schemas = explode("\n", trim($l['schema_json']));
  foreach ($schemas as $s):
    $s = trim($s);
    if ($s === '') continue;
    if (str_starts_with($s, '<script')) {
      echo $s . "\n";
    } else {
      echo '<script type="application/ld+json">' . $s . "</script>\n";
    }
  endforeach;
?>
<?php else: ?>
<script type="application/ld+json">{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Home", "item": "<?= base_url('/') ?>"},
    {"@type": "ListItem", "position": 2, "name": "<?= htmlspecialchars($title) ?>", "item": "<?= $canonical ?>"}
  ]
}</script>
<?php endif; ?>
<link rel="stylesheet" href="<?= asset_url('css/landing.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
</head>
<body>
<div class="prog" id="prog"></div>
<?php $home = false; $active = 'Services'; require view_path('layouts/header.php'); ?>

<main>
<?php if (!empty($l['content_html'])): ?>
  <?= $l['content_html'] ?>
<?php else: ?>
  <div class="wrap" style="padding:80px 20px;text-align:center">
    <h1><?= htmlspecialchars($l['title'] ?? 'Landing Page') ?></h1>
    <p class="lead"><?= htmlspecialchars($desc) ?></p>
    <a class="btn o" href="<?= base_url('/contact') ?>">Get in touch →</a>
  </div>
<?php endif; ?>
</main>

<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/landing.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script src="<?= asset_url('js/chatbot-config.js') ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>" defer></script>
</body>
</html>
