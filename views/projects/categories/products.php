<!doctype html><html lang="en"><head>
<script src="<?= asset_url('js/theme.js') ?>"></script><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<!-- Laravel route: /projects/products -->
<title>Software Products — SaaS &amp; Custom Platforms | Amaanullah Khan</title>
<meta name="description" content="Software products built by Amaanullah Khan, including Chatrox, a real-time enterprise chat app built with Laravel and WebSockets as a fully owned alternative to per-seat tools.">
<link rel="canonical" href="https://example.com/projects/products"><!-- EDIT: real domain -->
<meta property="og:type" content="website"><meta property="og:title" content="Software Products — SaaS &amp; Custom Platforms | Amaanullah Khan"><meta property="og:description" content="Software products built by Amaanullah Khan, including Chatrox, a real-time enterprise chat app built with Laravel and WebSockets as a fully owned alternative to per-seat tools.">
<meta property="og:url" content="https://example.com/projects/products"><meta property="og:image" content="https://example.com/images/og-projects.png"><!-- EDIT: og image -->
<meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="Software Products — SaaS &amp; Custom Platforms | Amaanullah Khan"><meta name="twitter:description" content="Software products built by Amaanullah Khan, including Chatrox, a real-time enterprise chat app built with Laravel and WebSockets as a fully owned alternative to per-seat tools."><meta name="twitter:image" content="https://example.com/images/og-projects.png">
<link rel="icon" href="<?= asset_url('logo-v2/favicon.ico') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Caveat:wght@600&display=swap" rel="stylesheet">
<script type="application/ld+json" class="pld">{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [{"@type": "ListItem", "position": 1, "name": "Home", "item": "https://example.com/"}, {"@type": "ListItem", "position": 2, "name": "Projects", "item": "https://example.com/projects"}, {"@type": "ListItem", "position": 3, "name": "Products", "item": "https://example.com/projects/products"}]}</script>
<script type="application/ld+json" class="pld">{
 "@context": "https://schema.org",
 "@type": "CollectionPage",
 "name": "Software Products \u2014 SaaS & Custom Platforms | Amaanullah Khan",
 "description": "Software products built by Amaanullah Khan, including Chatrox, a real-time enterprise chat app built with Laravel and WebSockets as a fully owned alternative to per-seat tools.",
 "url": "https://example.com/projects/products",
 "mainEntity": {
  "@type": "ItemList",
  "numberOfItems": 1,
  "itemListElement": [
   {
    "@type": "ListItem",
    "position": 1,
    "item": {
     "@type": "CreativeWork",
     "name": "Chatrox \u2014 Custom Enterprise Chat App (Slack Alternative)",
     "genre": "Products",
     "creator": {
      "@type": "Person",
      "name": "Amaanullah Khan"
     }
    }
   }
  ]
 }
}</script>
<link rel="stylesheet" href="<?= asset_url('css/projects.css') ?>"><link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/projects.dark.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
</head><body>
<div class="bgfx"></div>
<?php $home = false; $active = 'Projects'; require view_path('layouts/header.php'); ?>

<main id="main" data-page="products">
<header class="ph"><nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/projects') ?>">Projects</a></li><li aria-current="page">Products</li></ol></nav>
 <span class="eyebrow rv2">✦ Products</span>
 <div class="row"><div><h1 class="rv2">Products you own, <em>not rent.</em></h1><p class="lead2 rv2" style="max-width:640px;margin-top:12px">Software products and SaaS platforms built on Laravel — designed to scale, with multi-tenant architecture, subscription billing and solid REST APIs.</p><p class="lead2 rv2" style="max-width:640px;margin-top:12px">Chatrox is a real-time chat platform built with Laravel and WebSockets: a fully owned alternative to per-seat tools like Slack.</p></div>
 <nav class="hcs rv2" aria-label="Project categories"><a class="hc" href="<?= base_url('/projects/category/web-design-development') ?>" data-f="web"><b>03</b><span>Web Design & Development</span><small>E-commerce, marketplaces and custom websites.</small></a><a class="hc" href="<?= base_url('/projects/category/web-applications') ?>" data-f="apps"><b>06</b><span>Web Applications</span><small>Custom CRMs, HR portals and business systems.</small></a><a class="hc act" href="<?= base_url('/projects/category/products') ?>" data-f="products"><b>01</b><span>Products</span><small>Owned software products like chat platforms.</small></a><a class="hc" href="<?= base_url('/projects/category/mobile-apps') ?>" data-f="mobile"><b>03</b><span>Mobile Applications</span><small>Cross-platform Flutter apps for iOS and Android.</small></a></nav></div>
</header>
<div class="fbar2"><nav class="fts" role="tablist" aria-label="Filter projects by category"><span class="ind" aria-hidden="true"></span><a class="ft" role="tab" href="<?= base_url('/projects') ?>" aria-selected="false" data-f="all">All <sup>13</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/web-design-development') ?>" aria-selected="false" data-f="web">Web Design &amp; Development <sup>3</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/web-applications') ?>" aria-selected="false" data-f="apps">Web Applications <sup>6</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/products') ?>" aria-selected="true" aria-current="page" data-f="products">Products <sup>1</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/mobile-apps') ?>" aria-selected="false" data-f="mobile">Mobile Applications <sup>3</sup></a></nav></div>
<div id="swap">
<section class="sec2" id="featured" aria-labelledby="h-feat"><div class="lbl2 rv2"><h2 id="h-feat">Featured products</h2></div>
<!-- EDIT: featured choice for this page: chatrox -->
<div class="featg n1"><article class="pc big" data-cat="products"><!-- EDIT: description trimmed from live page (was truncated); tags inferred from description — confirm. Filter: products -->
<a href="javascript:void(0)" data-project="chatrox" class="pl" aria-label="View case study: Chatrox — Custom Enterprise Chat App (Slack Alternative)"><!-- URL: case study page for chatrox -->
<div class="ban"><!-- SWAP BANNER: images/banners/chatrox.svg → your 1600x1000 (16:10) banner --><img src="<?= asset_url('images/banners/chatrox.svg') ?>" alt="Chatrox — Custom Enterprise Chat App (Slack Alternative) — Products project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Products</span><span class="pst live">Live</span><!-- EDIT: status Live/Beta --></div>
<div class="pb"><span class="lab">Communication Tech / Enterprise Systems</span><div class="pt"><h3>Chatrox — Custom Enterprise Chat App (Slack Alternative)</h3><span class="ar" aria-hidden="true">↗</span></div><p>Real-time messaging platform built with Laravel and WebSockets.</p>
<div class="tg"><span>Laravel</span><span>WebSockets</span></div><span class="vc">View case study <b>→</b></span></div></a></article></div></section>
<!-- no further projects in this category yet -->
<section class="sec2 pfaq" aria-labelledby="h-faq"><div class="lbl2 rv2"><h2 id="h-faq">Questions about products</h2></div><div class="rv2"><details><summary>Can you build a SaaS product from an idea to launch?</summary><!-- EDIT: answer; add FAQPage JSON-LD once real answers exist --><p>[Answer coming soon — EDIT]</p></details><details><summary>Do you handle subscription billing?</summary><!-- EDIT: answer; add FAQPage JSON-LD once real answers exist --><p>[Answer coming soon — EDIT]</p></details><details><summary>Can a product like Chatrox be set up for my company?</summary><!-- EDIT: answer; add FAQPage JSON-LD once real answers exist --><p>[Answer coming soon — EDIT]</p></details></div></section>
<section class="cta2"><div class="band rv2"><div><h2>Planning a SaaS product?</h2><p>Tell me about your idea — I'll help turn it into a phased build plan. I reply within 24 hours.</p></div><div class="btns" style="margin:0"><a class="bo w" href="<?= base_url('/contact') ?>">Get a Quote →</a><a class="bo g" href="<?= base_url('/contact') ?>">Book a Demo</a></div></div></section>
</div>
</main>
<?php require view_path('layouts/footer.php'); ?>

<div class="cur" id="cur" aria-hidden="true">View ↗</div>
<script src="<?= asset_url('js/projects.js') ?>"></script><script src="<?= asset_url('js/layout.js') ?>"></script>
<script src="<?= asset_url('js/chatbot-config.js') ?>"></script><!-- EDIT: chatbot config -->
<script src="<?= asset_url('js/chatbot.js') ?>" defer></script>
</body></html>