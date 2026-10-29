<?php
$biz = config('business');
$siteUrl = rtrim($biz['url'] ?? 'https://amaanullah.com', '/');
$canonical = $siteUrl . '/projects/category/web-applications';
?>
<!doctype html><html lang="en"><head>
<script src="<?= asset_url('js/theme.js') ?>"></script><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Web Application Projects — Custom CRM, HRM &amp; Business Systems | Amaanullah Khan</title>
<meta name="description" content="Custom web applications by Amaanullah Khan: multi-tenant CRMs, HRM &amp; payroll, ticketing, project management and fintech tools built with Laravel, PHP, React and Node.js.">
<link rel="canonical" href="<?= $canonical ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Amaanullah">
<meta property="og:title" content="Web Application Projects — Custom CRM, HRM &amp; Business Systems | Amaanullah Khan">
<meta property="og:description" content="Custom web applications by Amaanullah Khan: multi-tenant CRMs, HRM &amp; payroll, ticketing, project management and fintech tools built with Laravel, PHP, React and Node.js.">
<meta property="og:url" content="<?= $canonical ?>">
<meta property="og:image" content="<?= asset_url('images/og-projects.png') ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Web Application Projects — Custom CRM, HRM &amp; Business Systems | Amaanullah Khan">
<meta name="twitter:description" content="Custom web applications by Amaanullah Khan: multi-tenant CRMs, HRM &amp; payroll, ticketing, project management and fintech tools built with Laravel, PHP, React and Node.js.">
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
        {"@type": "ListItem", "position": 3, "name": "Web Applications", "item": "<?= $canonical ?>"}
      ]
    },
    {
      "@type": "CollectionPage",
      "name": "Web Application Projects — Custom CRM, HRM & Business Systems | Amaanullah Khan",
      "description": "Custom web applications by Amaanullah Khan: multi-tenant CRMs, HRM & payroll, ticketing, project management and fintech tools built with Laravel, PHP, React and Node.js.",
      "url": "<?= $canonical ?>",
      "mainEntity": {
        "@type": "ItemList",
        "numberOfItems": 6,
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "item": {
              "@type": "CreativeWork",
              "name": "Multi-Tenant CRM — Sales & Operations Platform",
              "url": "<?= base_url('/projects/multi-tenant-crm-sales-operations-management-system') ?>",
              "genre": "Web Applications",
              "creator": {"@type": "Person", "name": "Amaanullah Khan"}
            }
          },
          {
            "@type": "ListItem",
            "position": 2,
            "item": {
              "@type": "CreativeWork",
              "name": "HRM & Payroll Software — Employee Management Portal",
              "url": "<?= base_url('/projects/hrm-employee-management-payroll-portal') ?>",
              "genre": "Web Applications",
              "creator": {"@type": "Person", "name": "Amaanullah Khan"}
            }
          },
          {
            "@type": "ListItem",
            "position": 3,
            "item": {
              "@type": "CreativeWork",
              "name": "Ticketing CRM — Job & Vendor Management System",
              "url": "<?= base_url('/projects/ticketing-crm-jobs-vendor-management-enterprise-portal') ?>",
              "genre": "Web Applications",
              "creator": {"@type": "Person", "name": "Amaanullah Khan"}
            }
          },
          {
            "@type": "ListItem",
            "position": 4,
            "item": {
              "@type": "CreativeWork",
              "name": "Real Estate Portal — Multi-Role Property Marketplace",
              "url": "<?= base_url('/projects/real-estate-property-portal-multi-role-marketplace') ?>",
              "genre": "Web Applications",
              "creator": {"@type": "Person", "name": "Amaanullah Khan"}
            }
          },
          {
            "@type": "ListItem",
            "position": 5,
            "item": {
              "@type": "CreativeWork",
              "name": "Kanban Project Management Tool — Team Workspace",
              "url": "<?= base_url('/projects/workspace-kanban-project-task-management-platform') ?>",
              "genre": "Web Applications",
              "creator": {"@type": "Person", "name": "Amaanullah Khan"}
            }
          },
          {
            "@type": "ListItem",
            "position": 6,
            "item": {
              "@type": "CreativeWork",
              "name": "Expense Voyage — Budget & Expense Tracking Web App",
              "url": "<?= base_url('/projects/expense-voyage-budget-expense-management-web-app') ?>",
              "genre": "Web Applications",
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
          "name": "Can you build a CRM around our existing sales process?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Instead of forcing your business into rigid off-the-shelf software like Salesforce or HubSpot, I engineer custom CRMs with stages, custom fields, automated assignment rules, and WhatsApp/email triggers tailored exactly to your pipeline."
          }
        },
        {
          "@type": "Question",
          "name": "Do you build multi-tenant systems for SaaS?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. I specialize in multi-tenant architectures in Laravel, utilizing safe tenant scoping (either single-database with tenant IDs or multi-database architectures) to ensure complete data isolation and high throughput."
          }
        },
        {
          "@type": "Question",
          "name": "Can my existing data be migrated into the new system?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. I build automated sanitization and migration scripts to import legacy records from Excel, CSV, Google Sheets, or legacy SQL databases with zero data loss and historical integrity preserved."
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

<main id="main" data-page="apps">
<header class="ph"><nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/projects') ?>">Projects</a></li><li aria-current="page">Web Applications</li></ol></nav>
 <span class="eyebrow rv2">✦ Web Applications</span>
 <div class="row"><div><h1 class="rv2">Web applications that <em>run operations.</em></h1><p class="lead2 rv2" style="max-width:640px;margin-top:12px">CRMs, HR portals, ticketing systems and internal tools built with Laravel and PHP, with React or Node.js where it fits. Each one replaces spreadsheets and manual steps with a system your team opens every morning.</p><p class="lead2 rv2" style="max-width:640px;margin-top:12px">Built for real teams — role-based access, multi-tenant architecture and integrations with the tools you already use.</p></div>
 <nav class="hcs rv2" aria-label="Project categories"><a class="hc" href="<?= base_url('/projects/category/web-design-development') ?>" data-f="web"><b>03</b><span>Web Design & Development</span><small>E-commerce, marketplaces and custom websites.</small></a><a class="hc act" href="<?= base_url('/projects/category/web-applications') ?>" data-f="apps"><b>06</b><span>Web Applications</span><small>Custom CRMs, HR portals and business systems.</small></a><a class="hc" href="<?= base_url('/projects/category/products') ?>" data-f="products"><b>01</b><span>Products</span><small>Owned software products like chat platforms.</small></a><a class="hc" href="<?= base_url('/projects/category/mobile-apps') ?>" data-f="mobile"><b>03</b><span>Mobile Applications</span><small>Cross-platform Flutter apps for iOS and Android.</small></a></nav></div>
</header>
<div class="fbar2"><nav class="fts" role="tablist" aria-label="Filter projects by category"><span class="ind" aria-hidden="true"></span><a class="ft" role="tab" href="<?= base_url('/projects') ?>" aria-selected="false" data-f="all">All <sup>13</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/web-design-development') ?>" aria-selected="false" data-f="web">Web Design &amp; Development <sup>3</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/web-applications') ?>" aria-selected="true" aria-current="page" data-f="apps">Web Applications <sup>6</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/products') ?>" aria-selected="false" data-f="products">Products <sup>1</sup></a><a class="ft" role="tab" href="<?= base_url('/projects/category/mobile-apps') ?>" aria-selected="false" data-f="mobile">Mobile Applications <sup>3</sup></a></nav></div>
<div id="swap">
<section class="sec2" id="featured" aria-labelledby="h-feat"><div class="lbl2 rv2"><h2 id="h-feat">Featured web applications</h2></div>
<div class="featg n2"><article class="pc big" data-cat="apps">
<a href="<?= base_url('/projects/multi-tenant-crm-sales-operations-management-system') ?>" data-project="multi-tenant-crm" class="pl" aria-label="View case study: Multi-Tenant CRM — Sales &amp; Operations Platform">
<div class="ban"><img src="<?= asset_url('images/banners/multi-tenant-crm.svg') ?>" alt="Multi-Tenant CRM — Sales &amp; Operations Platform — Web Applications project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Web Applications</span></div>
<div class="pb"><span class="lab">Enterprise CRM / Enterprise Systems</span><div class="pt"><h3>Multi-Tenant CRM — Sales &amp; Operations Platform</h3><span class="ar" aria-hidden="true">↗</span></div><p>Custom CRM handling 1.5M+ leads and 300+ concurrent users.</p>
<div class="tg"><span>Multi-Tenant</span><span>CRM</span></div><span class="vc">View case study <b>→</b></span></div></a></article><article class="pc big" data-cat="apps">
<a href="<?= base_url('/projects/hrm-employee-management-payroll-portal') ?>" data-project="hrm-payroll" class="pl" aria-label="View case study: HRM &amp; Payroll Software — Employee Management Portal">
<div class="ban"><img src="<?= asset_url('images/banners/hrm-payroll.svg') ?>" alt="HRM &amp; Payroll Software — Employee Management Portal — Web Applications project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Web Applications</span></div>
<div class="pb"><span class="lab">CRM &amp; HRM Systems</span><div class="pt"><h3>HRM &amp; Payroll Software — Employee Management Portal</h3><span class="ar" aria-hidden="true">↗</span></div><p>Laravel-based HRM system automating attendance, leave and payroll.</p>
<div class="tg"><span>Laravel</span><span>HRM</span></div><span class="vc">View case study <b>→</b></span></div></a></article></div></section>
<section class="sec2" id="all-projects" aria-labelledby="h-all"><div class="lbl2 rv2"><h2 id="h-all">More web applications</h2></div><div class="pgrid"><article class="pc" data-cat="apps">
<a href="<?= base_url('/projects/ticketing-crm-jobs-vendor-management-enterprise-portal') ?>" data-project="ticketing-crm" class="pl" aria-label="View case study: Ticketing CRM — Job &amp; Vendor Management System">
<div class="ban"><img src="<?= asset_url('images/banners/ticketing-crm.svg') ?>" alt="Ticketing CRM — Job &amp; Vendor Management System — Web Applications project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Web Applications</span></div>
<div class="pb"><span class="lab">CRM &amp; Enterprise Systems</span><div class="pt"><h3>Ticketing CRM — Job &amp; Vendor Management System</h3><span class="ar" aria-hidden="true">↗</span></div><p>Enterprise ticketing platform for job lifecycle tracking and vendor matching.</p>
<div class="tg"><span>CRM</span><span>Enterprise</span></div><span class="vc">View case study <b>→</b></span></div></a></article><article class="pc" data-cat="apps">
<a href="<?= base_url('/projects/real-estate-property-portal-multi-role-marketplace') ?>" data-project="real-estate-portal" class="pl" aria-label="View case study: Real Estate Portal — Multi-Role Property Marketplace">
<div class="ban"><img src="<?= asset_url('images/banners/real-estate-portal.svg') ?>" alt="Real Estate Portal — Multi-Role Property Marketplace — Web Applications project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Web Applications</span></div>
<div class="pb"><span class="lab">Enterprise Solutions / Web Applications</span><div class="pt"><h3>Real Estate Portal — Multi-Role Property Marketplace</h3><span class="ar" aria-hidden="true">↗</span></div><p>Property listing platform for agencies, agents and buyers with role-based access.</p>
<div class="tg"><span>Marketplace</span><span>Multi-Role</span></div><span class="vc">View case study <b>→</b></span></div></a></article><article class="pc" data-cat="apps">
<a href="<?= base_url('/projects/workspace-kanban-project-task-management-platform') ?>" data-project="kanban-workspace" class="pl" aria-label="View case study: Kanban Project Management Tool — Team Workspace">
<div class="ban"><img src="<?= asset_url('images/banners/kanban-workspace.svg') ?>" alt="Kanban Project Management Tool — Team Workspace — Web Applications project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Web Applications</span></div>
<div class="pb"><span class="lab">Workflow Automation / Project Management</span><div class="pt"><h3>Kanban Project Management Tool — Team Workspace</h3><span class="ar" aria-hidden="true">↗</span></div><p>Custom project and task management platform with drag-and-drop Kanban boards.</p>
<div class="tg"><span>Kanban</span><span>Workflow</span></div><span class="vc">View case study <b>→</b></span></div></a></article><article class="pc" data-cat="apps">
<a href="<?= base_url('/projects/expense-voyage-budget-expense-management-web-app') ?>" data-project="expense-voyage" class="pl" aria-label="View case study: Expense Voyage — Budget &amp; Expense Tracking Web App">
<div class="ban"><img src="<?= asset_url('images/banners/expense-voyage.svg') ?>" alt="Expense Voyage — Budget &amp; Expense Tracking Web App — Web Applications project banner" width="1600" height="1000" loading="lazy" decoding="async"><span class="cb">Web Applications</span></div>
<div class="pb"><span class="lab">FinTech &amp; Web Applications</span><div class="pt"><h3>Expense Voyage — Budget &amp; Expense Tracking Web App</h3><span class="ar" aria-hidden="true">↗</span></div><p>Budget tracking web application with real-time financial monitoring.</p>
<div class="tg"><span>FinTech</span></div><span class="vc">View case study <b>→</b></span></div></a></article></div></section>
<section class="sec2 pfaq" aria-labelledby="h-faq"><div class="lbl2 rv2"><h2 id="h-faq">Questions about web applications</h2></div><div class="rv2"><details><summary>Can you build a CRM around our existing sales process?</summary><p>Yes. Instead of forcing your business into rigid off-the-shelf software like Salesforce or HubSpot, I engineer custom CRMs with stages, custom fields, automated assignment rules, and WhatsApp/email triggers tailored exactly to your pipeline.</p></details><details><summary>Do you build multi-tenant systems for SaaS?</summary><p>Yes. I specialize in multi-tenant architectures in Laravel, utilizing safe tenant scoping (either single-database with tenant IDs or multi-database architectures) to ensure complete data isolation and high throughput.</p></details><details><summary>Can my existing data be migrated into the new system?</summary><p>Yes. I build automated sanitization and migration scripts to import legacy records from Excel, CSV, Google Sheets, or legacy SQL databases with zero data loss and historical integrity preserved.</p></details></div></section>
<section class="cta2"><div class="band rv2"><div><h2>Outgrown spreadsheets and off-the-shelf tools?</h2><p>Tell me about your CRM, HRM or internal system — I reply within 24 hours with clear next steps.</p></div><div class="btns" style="margin:0"><a class="bo w" href="<?= base_url('/contact') ?>">Get a Quote →</a><a class="bo g" href="<?= base_url('/contact') ?>">Book a Demo</a></div></div></section>
</div>
</main>
<?php require view_path('layouts/footer.php'); ?>

<div class="cur" id="cur" aria-hidden="true">View ↗</div>
<script src="<?= asset_url('js/projects.js') ?>"></script><script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script><script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/chatbot-config.js') ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/chatbot.js') ?>" defer></script>
</body></html>
