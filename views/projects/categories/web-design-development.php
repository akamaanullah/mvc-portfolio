<?php
$biz = config('business');
$siteUrl = rtrim($biz['url'] ?? 'https://amaanullah.com', '/');
$canonical = $siteUrl . '/projects/category/web-design-development';
?>
<!doctype html><html lang="en"><head>
<script src="<?= asset_url('js/theme.js') ?>"></script><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Web Design &amp; Development Projects — E-Commerce &amp; Custom Websites | Amaanullah Khan</title>
<meta name="description" content="Custom websites and e-commerce platforms built with PHP and Laravel by Amaanullah Khan, a Karachi-based developer working with businesses in Pakistan, the UK, US and UAE.">
<link rel="canonical" href="<?= $canonical ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Amaanullah">
<meta property="og:title" content="Web Design &amp; Development Projects — E-Commerce &amp; Custom Websites | Amaanullah Khan">
<meta property="og:description" content="Custom websites and e-commerce platforms built with PHP and Laravel by Amaanullah Khan, a Karachi-based developer working with businesses in Pakistan, the UK, US and UAE.">
<meta property="og:url" content="<?= $canonical ?>">
<meta property="og:image" content="<?= asset_url('images/og-projects.png') ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Web Design &amp; Development Projects — E-Commerce &amp; Custom Websites | Amaanullah Khan">
<meta name="twitter:description" content="Custom websites and e-commerce platforms built with PHP and Laravel by Amaanullah Khan, a Karachi-based developer working with businesses in Pakistan, the UK, US and UAE.">
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
        {"@type": "ListItem", "position": 3, "name": "Web Design & Development", "item": "<?= $canonical ?>"}
      ]
    },
    {
      "@type": "CollectionPage",
      "name": "Web Design & Development Projects — E-Commerce & Custom Websites | Amaanullah Khan",
      "description": "Custom websites and e-commerce platforms built with PHP and Laravel by Amaanullah Khan, a Karachi-based developer working with businesses in Pakistan, the UK, US and UAE.",
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
              "name": "The Perfect Vape — Custom E-Commerce Platform & Theme Builder",
              "url": "<?= base_url('/projects/the-perfect-vape-custom-ecommerce-platform-theme-builder') ?>",
              "genre": "Web Design & Development",
              "creator": {"@type": "Person", "name": "Amaanullah Khan"}
            }
          },
          {
            "@type": "ListItem",
            "position": 2,
            "item": {
              "@type": "CreativeWork",
              "name": "IT Hardware Bin — B2B Bulk Hardware E-Commerce Platform",
              "url": "<?= base_url('/projects/it-hardware-bin-bulk-hardware-ecommerce-platform') ?>",
              "genre": "Web Design & Development",
              "creator": {"@type": "Person", "name": "Amaanullah Khan"}
            }
          },
          {
            "@type": "ListItem",
            "position": 3,
            "item": {
              "@type": "CreativeWork",
              "name": "Adsimpressions — Custom Digital Agency Website",
              "url": "<?= base_url('/projects/adsimpressions-custom-digital-agency-platform') ?>",
              "genre": "Web Design & Development",
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
          "name": "Do you build custom e-commerce without Shopify or WooCommerce?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. For stores that have outgrown rigid SaaS themes or suffer from high plugin licensing fees, I build bespoke PHP/Laravel e-commerce engines with sub-second page loads, custom checkouts, and zero transaction fee markups."
          }
        },
        {
          "@type": "Question",
          "name": "Can you redesign or speed up my existing website?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. I conduct comprehensive technical audits covering Core Web Vitals, server configuration, database query optimization, and asset pipelines, consistently achieving 95+ PageSpeed scores."
          }
        },
        {
          "@type": "Question",
          "name": "Will I be able to manage products and content myself?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Every custom build includes an intuitive, bespoke administrative control panel where your team can easily update inventory, prices, banners, and blog content without touching a single line of code."
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

<main id="main" data-page="web">
<header class="ph"><nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/projects') ?>">Projects</a></li><li aria-current="page">Web Design &amp; Development</li></ol></nav>
 <span class="eyebrow rv2">✦ Web Design &amp; Development</span>
 <div class="row"><div><h1 class="rv2">Websites &amp; e-commerce <em>built to sell.</em></h1><p class="lead2 rv2" style="max-width:640px;margin-top:12px">Custom websites and e-commerce platforms built in PHP and Laravel — no locked-in templates. Fast pages, clean admin panels and checkouts designed around how your customers actually buy.</p><p class="lead2 rv2" style="max-width:640px;margin-top:12px">Based in Karachi, building for businesses across Pakistan, the UK, US, UAE and Saudi Arabia.</p></div>
 <nav class="hcs rv2" aria-label="Project categories"><a class="hc act" href="<?= base_url('/projects/category/web-design-development') ?>" data-f="web"><b>03</b><span>Web Design & Development</span><small>E-commerce, marketplaces and custom websites.</small></a><a class="hc" href="<?= base_url('/projects/category/web-applications') ?>" data-f="apps"><b>06</b><span>Web Applications</span><small>Custom CRMs, HR portals and business systems.</small></a><a class="hc" href="<?= base_url('/projects/category/products') ?>" data-f="products"><b>01</b><span>Products</span><small>Owned software products like chat platforms.</small></a><a class="hc" href="<?= base_url('/projects/category/mobile-apps') ?>" data-f="mobile"><b>03</b><span>Mobile Applications</span><small>Cross-platform Flutter apps for iOS and Android.</small></a></nav></div>
</header>
<div class="fbar2"><nav class="fts" role="tablist" aria-label="Filter projects by category"><span class="ind" aria-hidden="true"></span><a class="ft" role="tab" href="<?= base_url('/projects') ?>" aria-selected="false" data-f="all">All <sup>13</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/web-design-development') ?>" aria-selected="true" aria-current="page" data-f="web">Web Design &amp; Development <sup>3</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/web-applications') ?>" aria-selected="false" data-f="apps">Web Applications <sup>6</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/products') ?>" aria-selected="false" data-f="products">Products <sup>1</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/mobile-apps') ?>" aria-selected="false" data-f="mobile">Mobile Applications <sup>3</sup></a></nav></div>
<div id="swap">
<section class="sec2" id="featured" aria-labelledby="h-feat"><div class="lbl2 rv2"><h2 id="h-feat">Featured web design &amp; development</h2></div>
<div class="featg n2"><article class="pc big" data-cat="web">
<a href="<?= base_url('/projects/the-perfect-vape-custom-ecommerce-platform-theme-builder') ?>" data-project="custom-vape-ecommerce" class="pl" aria-label="View case study: Custom Vape E-Commerce Platform (PHP, No Shopify/WooCommerce)">
<div class="ban"><img src="<?= asset_url('images/banners/custom-vape-ecommerce.svg') ?>" alt="Custom Vape E-Commerce Platform (PHP, No Shopify/WooCommerce) — Web Design & Development project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Web Design & Development</span></div>
<div class="pb"><span class="lab">E-Commerce / Custom SaaS Platform</span><div class="pt"><h3>Custom Vape E-Commerce Platform (PHP, No Shopify/WooCommerce)</h3><span class="ar" aria-hidden="true">↗</span></div><p>Fully custom PHP e-commerce platform for a UK vape retailer, including an admin panel.</p>
<div class="tg"><span>PHP</span><span>E-Commerce</span></div><span class="vc">View case study <b>→</b></span></div></a></article><article class="pc big" data-cat="web">
<a href="<?= base_url('/projects/it-hardware-bin-bulk-hardware-ecommerce-platform') ?>" data-project="it-hardware-bin" class="pl" aria-label="View case study: IT Hardware Bin — B2B Bulk Hardware E-Commerce Platform">
<div class="ban"><img src="<?= asset_url('images/banners/it-hardware-bin.svg') ?>" alt="IT Hardware Bin — B2B Bulk Hardware E-Commerce Platform — Web Design & Development project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Web Design & Development</span></div>
<div class="pb"><span class="lab">E-Commerce &amp; Scalable Systems</span><div class="pt"><h3>IT Hardware Bin — B2B Bulk Hardware E-Commerce Platform</h3><span class="ar" aria-hidden="true">↗</span></div><p>E-commerce platform for large-scale IT hardware procurement, with 2,000+ products.</p>
<div class="tg"><span>E-Commerce</span><span>B2B</span></div><span class="vc">View case study <b>→</b></span></div></a></article></div></section>
<section class="sec2" id="all-projects" aria-labelledby="h-all"><div class="lbl2 rv2"><h2 id="h-all">More web design &amp; development</h2></div><div class="pgrid"><article class="pc" data-cat="web">
<a href="<?= base_url('/projects/adsimpressions-custom-digital-agency-platform') ?>" data-project="adsimpressions" class="pl" aria-label="View case study: Adsimpressions — Custom Digital Agency Website">
<div class="ban"><img src="<?= asset_url('images/banners/adsimpressions.svg') ?>" alt="Adsimpressions — Custom Digital Agency Website — Web Design & Development project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Web Design & Development</span></div>
<div class="pb"><span class="lab">Web &amp; Digital Platforms / Custom Solutions</span><div class="pt"><h3>Adsimpressions — Custom Digital Agency Website</h3><span class="ar" aria-hidden="true">↗</span></div><p>Custom-built digital agency platform showcasing services.</p>
<div class="tg"><span>Agency</span><span>Custom Build</span></div><span class="vc">View case study <b>→</b></span></div></a></article></div></section>
<section class="sec2 pfaq" aria-labelledby="h-faq"><div class="lbl2 rv2"><h2 id="h-faq">Questions about web design &amp; development</h2></div><div class="rv2"><details><summary>Do you build custom e-commerce without Shopify or WooCommerce?</summary><p>Yes. For stores that have outgrown rigid SaaS themes or suffer from high plugin licensing fees, I build bespoke PHP/Laravel e-commerce engines with sub-second page loads, custom checkouts, and zero transaction fee markups.</p></details><details><summary>Can you redesign or speed up my existing website?</summary><p>Yes. I conduct comprehensive technical audits covering Core Web Vitals, server configuration, database query optimization, and asset pipelines, consistently achieving 95+ PageSpeed scores.</p></details><details><summary>Will I be able to manage products and content myself?</summary><p>Yes. Every custom build includes an intuitive, bespoke administrative control panel where your team can easily update inventory, prices, banners, and blog content without touching a single line of code.</p></details></div></section>
<section class="cta2"><div class="band rv2"><div><h2>Need a website that actually converts?</h2><p>Tell me about your store or business site — I reply within 24 hours with next steps.</p></div><div class="btns" style="margin:0"><a class="bo w" href="<?= base_url('/contact') ?>">Get a Quote →</a><a class="bo g" href="<?= base_url('/contact') ?>">Book a Demo</a></div></div></section>
</div>
</main>
<?php require view_path('layouts/footer.php'); ?>

<div class="cur" id="cur" aria-hidden="true">View ↗</div>
<script src="<?= asset_url('js/projects.js') ?>"></script><script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script><script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/chatbot-config.js') ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/chatbot.js') ?>" defer></script>
</body></html>
