<?php
$biz = config('business');
$siteUrl = rtrim($biz['url'] ?? 'https://amaanullah.com', '/');
$canonical = $siteUrl . '/projects/category/mobile-apps';
?>
<!doctype html><html lang="en"><head>
<script src="<?= asset_url('js/theme.js') ?>"></script><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Mobile App Projects — Flutter Apps for iOS &amp; Android | Amaanullah Khan</title>
<meta name="description" content="Cross-platform Flutter mobile apps for iOS and Android by Amaanullah Khan — e-commerce, healthcare and travel apps connected to Laravel REST APIs and Firebase.">
<link rel="canonical" href="<?= $canonical ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Amaanullah">
<meta property="og:title" content="Mobile App Projects — Flutter Apps for iOS &amp; Android | Amaanullah Khan">
<meta property="og:description" content="Cross-platform Flutter mobile apps for iOS and Android by Amaanullah Khan — e-commerce, healthcare and travel apps connected to Laravel REST APIs and Firebase.">
<meta property="og:url" content="<?= $canonical ?>">
<meta property="og:image" content="<?= asset_url('images/og-projects.png') ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Mobile App Projects — Flutter Apps for iOS &amp; Android | Amaanullah Khan">
<meta name="twitter:description" content="Cross-platform Flutter mobile apps for iOS and Android by Amaanullah Khan — e-commerce, healthcare and travel apps connected to Laravel REST APIs and Firebase.">
<meta name="twitter:image" content="<?= asset_url('images/og-projects.png') ?>">
<link rel="icon" href="<?= asset_url('logo-v2/favicon.ico') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Caveat:wght@600&display=swap" rel="stylesheet">
<script type="application/ld+json" class="pld">{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        {"@type": "ListItem", "position": 1, "name": "Home", "item": "<?= $siteUrl ?>/"},
        {"@type": "ListItem", "position": 2, "name": "Projects", "item": "<?= $siteUrl ?>/projects"},
        {"@type": "ListItem", "position": 3, "name": "Mobile Applications", "item": "<?= $canonical ?>"}
      ]
    },
    {
      "@type": "CollectionPage",
      "name": "Mobile App Projects — Flutter Apps for iOS & Android | Amaanullah Khan",
      "description": "Cross-platform Flutter mobile apps for iOS and Android by Amaanullah Khan — e-commerce, healthcare and travel apps connected to Laravel REST APIs and Firebase.",
      "url": "<?= $canonical ?>",
      "mainEntity": {
        "@type": "ItemList",
        "numberOfItems": 3,
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "item": {
              "@type": "CreativeWork",
              "name": "Babyshop — Flutter E-Commerce Mobile App",
              "url": "<?= base_url('/projects/babyshop-mobile-app-ecommerce-firebase-solution') ?>",
              "genre": "Mobile Applications",
              "creator": {"@type": "Person", "name": "Amaanullah Khan"}
            }
          },
          {
            "@type": "ListItem",
            "position": 2,
            "item": {
              "@type": "CreativeWork",
              "name": "Healink — Hospital & Medical Records Management App",
              "url": "<?= base_url('/projects/healink-medicine-app-healthcare-hospital-management-solution') ?>",
              "genre": "Mobile Applications",
              "creator": {"@type": "Person", "name": "Amaanullah Khan"}
            }
          },
          {
            "@type": "ListItem",
            "position": 3,
            "item": {
              "@type": "CreativeWork",
              "name": "Tour Guide Mobile App — Travel Companion for Pakistan",
              "url": "<?= base_url('/projects/tour-guide-mobile-app-explore-pakistan-travel-solution') ?>",
              "genre": "Mobile Applications",
              "creator": {"@type": "Person", "name": "Amaanullah Khan"}
            }
          }
        ]
      }
    },
    {
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Do you build for both iOS and Android?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Using Flutter, a single compiled codebase delivers 60fps native performance across both iOS and Android, dramatically reducing development time and maintenance overhead while maintaining platform-specific UI behaviors."
          }
        },
        {
          "@type": "Question",
          "name": "Can the app connect to my existing website or backend?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. I build secure, authenticated REST and GraphQL APIs that seamlessly sync mobile clients with your existing MySQL/PostgreSQL databases, web dashboards, or third-party enterprise services."
          }
        },
        {
          "@type": "Question",
          "name": "Do you help with publishing to the App Store and Play Store?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes, I guide the entire release lifecycle — including developer account setup, build signing, privacy policy compliance, App Store Review Guidelines, and automated CI/CD deployment pipelines."
          }
        }
      ]
    }
  ]
}</script>
<link rel="stylesheet" href="<?= asset_url('css/projects.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
</head><body>
<div class="bgfx"></div>
<?php $home = false; $active = 'Projects'; require view_path('layouts/header.php'); ?>

<main id="main" data-page="mobile">
<header class="ph"><nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/projects') ?>">Projects</a></li><li aria-current="page">Mobile Applications</li></ol></nav>
 <span class="eyebrow rv2">✦ Mobile Applications</span>
 <div class="row"><div><h1 class="rv2">Flutter apps for <em>iOS &amp; Android.</em></h1><p class="lead2 rv2" style="max-width:640px;margin-top:12px">Cross-platform mobile apps built with Flutter — one codebase for iOS and Android, connected to Laravel REST APIs or Firebase, with offline sync and push notifications.</p><p class="lead2 rv2" style="max-width:640px;margin-top:12px">From e-commerce to healthcare and travel, the same developer builds the backend and the app, so nothing gets lost in translation.</p></div>
 <nav class="hcs rv2" aria-label="Project categories"><a class="hc" href="<?= base_url('/projects/category/web-design-development') ?>" data-f="web"><b>03</b><span>Web Design & Development</span><small>E-commerce, marketplaces and custom websites.</small></a><a class="hc" href="<?= base_url('/projects/category/web-applications') ?>" data-f="apps"><b>06</b><span>Web Applications</span><small>Custom CRMs, HR portals and business systems.</small></a><a class="hc" href="<?= base_url('/projects/category/products') ?>" data-f="products"><b>01</b><span>Products</span><small>Owned software products like chat platforms.</small></a><a class="hc act" href="<?= base_url('/projects/category/mobile-apps') ?>" data-f="mobile"><b>03</b><span>Mobile Applications</span><small>Cross-platform Flutter apps for iOS and Android.</small></a></nav></div>
</header>
<div class="fbar2"><nav class="fts" role="tablist" aria-label="Filter projects by category"><span class="ind" aria-hidden="true"></span><a class="ft" role="tab" href="<?= base_url('/projects') ?>" aria-selected="false" data-f="all">All <sup>13</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/web-design-development') ?>" aria-selected="false" data-f="web">Web Design &amp; Development <sup>3</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/web-applications') ?>" aria-selected="false" data-f="apps">Web Applications <sup>6</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/products') ?>" aria-selected="false" data-f="products">Products <sup>1</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/mobile-apps') ?>" aria-selected="true" aria-current="page" data-f="mobile">Mobile Applications <sup>3</sup></a></nav></div>
<div id="swap">
<section class="sec2" id="featured" aria-labelledby="h-feat"><div class="lbl2 rv2"><h2 id="h-feat">Featured mobile applications</h2></div>
<div class="featg n2"><article class="pc big" data-cat="mobile">
<a href="<?= base_url('/projects/babyshop-mobile-app-ecommerce-firebase-solution') ?>" data-project="babyshop" class="pl" aria-label="View case study: Babyshop — Flutter E-Commerce Mobile App">
<div class="ban"><img src="<?= asset_url('images/banners/babyshop.svg') ?>" alt="Babyshop — Flutter E-Commerce Mobile App — Mobile Applications project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Mobile Applications</span></div>
<div class="pb"><span class="lab">Mobile App Development / Firebase Systems</span><div class="pt"><h3>Babyshop — Flutter E-Commerce Mobile App</h3><span class="ar" aria-hidden="true">↗</span></div><p>E-commerce mobile app with separate user and admin apps.</p>
<div class="tg"><span>Flutter</span><span>Firebase</span></div><div class="plat"><span>Android</span><span>iOS</span></div><span class="vc">View case study <b>→</b></span></div></a></article><article class="pc big" data-cat="mobile">
<a href="<?= base_url('/projects/healink-medicine-app-healthcare-hospital-management-solution') ?>" data-project="healink" class="pl" aria-label="View case study: Healink — Hospital &amp; Medical Records Management App">
<div class="ban"><img src="<?= asset_url('images/banners/healink.svg') ?>" alt="Healink — Hospital &amp; Medical Records Management App — Mobile Applications project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Mobile Applications</span></div>
<div class="pb"><span class="lab">Healthcare Tech / Enterprise Systems</span><div class="pt"><h3>Healink — Hospital &amp; Medical Records Management App</h3><span class="ar" aria-hidden="true">↗</span></div><p>Healthcare platform connecting patients, doctors, hospitals and pharmacies.</p>
<div class="tg"><span>Healthcare</span></div><div class="plat"><span>Android</span><span>iOS</span></div><span class="vc">View case study <b>→</b></span></div></a></article></div></section>
<section class="sec2" id="all-projects" aria-labelledby="h-all"><div class="lbl2 rv2"><h2 id="h-all">More mobile applications</h2></div><div class="pgrid"><article class="pc" data-cat="mobile">
<a href="<?= base_url('/projects/tour-guide-mobile-app-explore-pakistan-travel-solution') ?>" data-project="tour-guide-app" class="pl" aria-label="View case study: Tour Guide Mobile App — Travel Companion for Pakistan">
<div class="ban"><img src="<?= asset_url('images/banners/tour-guide-app.svg') ?>" alt="Tour Guide Mobile App — Travel Companion for Pakistan — Mobile Applications project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Mobile Applications</span></div>
<div class="pb"><span class="lab">Mobile Development / Tourism Tech</span><div class="pt"><h3>Tour Guide Mobile App — Travel Companion for Pakistan</h3><span class="ar" aria-hidden="true">↗</span></div><p>Flutter travel app integrating Weather and Location APIs for real-time info.</p>
<div class="tg"><span>Flutter</span><span>APIs</span></div><div class="plat"><span>Android</span><span>iOS</span></div><span class="vc">View case study <b>→</b></span></div></a></article></div></section>
<section class="sec2 pfaq" aria-labelledby="h-faq"><div class="lbl2 rv2"><h2 id="h-faq">Questions about mobile applications</h2></div><div class="rv2"><details><summary>Do you build for both iOS and Android?</summary><p>Yes. Using Flutter, a single compiled codebase delivers 60fps native performance across both iOS and Android, dramatically reducing development time and maintenance overhead while maintaining platform-specific UI behaviors.</p></details><details><summary>Can the app connect to my existing website or backend?</summary><p>Yes. I build secure, authenticated REST and GraphQL APIs that seamlessly sync mobile clients with your existing MySQL/PostgreSQL databases, web dashboards, or third-party enterprise services.</p></details><details><summary>Do you help with publishing to the App Store and Play Store?</summary><p>Yes, I guide the entire release lifecycle — including developer account setup, build signing, privacy policy compliance, App Store Review Guidelines, and automated CI/CD deployment pipelines.</p></details></div></section>
<section class="cta2"><div class="band rv2"><div><h2>Have an app idea?</h2><p>Tell me what your app needs to do — I reply within 24 hours with next steps.</p></div><div class="btns" style="margin:0"><a class="bo w" href="<?= base_url('/contact') ?>">Get a Quote →</a><a class="bo g" href="<?= base_url('/contact') ?>">Book a Demo</a></div></div></section>
</div>
</main>
<?php require view_path('layouts/footer.php'); ?>

<div class="cur" id="cur" aria-hidden="true">View ↗</div>
<script src="<?= asset_url('js/projects.js') ?>"></script><script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script><script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/chatbot-config.js') ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/chatbot.js') ?>" defer></script>
</body></html>
