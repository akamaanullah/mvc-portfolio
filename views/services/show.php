<!DOCTYPE html>
<html lang="en">
<head>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($service['seo_title'] ?? ($service['title'] . ' | Amaanullah Khan, Karachi')) ?></title>
<meta name="description" content="<?= htmlspecialchars($service['meta_description'] ?? ($service['summary'] ?? '')) ?>">
<link rel="canonical" href="<?= base_url('/services/' . $service['slug']) ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?= htmlspecialchars($service['seo_title'] ?? $service['title']) ?>">
<meta property="og:description" content="<?= htmlspecialchars($service['meta_description'] ?? ($service['summary'] ?? '')) ?>">
<meta property="og:image" content="<?= !empty($service['banner']) ? asset_url($service['banner']) : asset_url('images/services/' . $service['slug'] . '.webp') ?>">
<meta property="og:url" content="<?= base_url('/services/' . $service['slug']) ?>">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="<?= asset_url('logo-v2/favicon-32.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
<?php if (!empty($service['schema_json'])): ?>
<?= $service['schema_json'] ?>
<?php endif; ?>
<link rel="stylesheet" href="<?= asset_url('css/service-detail.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/service-detail.dark.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
</head>
<body>
<div class="prog" id="prog"></div>
<?php $home = false; $active = 'Services'; require view_path('layouts/header.php'); ?>

<main>
<?php if (!empty($service['body_html'])): ?>
<?= $service['body_html'] ?>
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
<script src="<?= asset_url('js/chatbot-config.js') ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>" defer></script>
</body></html>