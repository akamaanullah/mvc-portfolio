<?php
/**
 * Dynamic Project Category View
 * Completely driven by MySQL database records with live Schema.org JSON-LD.
 */
$catSlug = $category['slug'] ?? 'web-applications';
$catName = $category['name'] ?? 'Web Applications';
$catIntro = !empty($category['seo_intro']) 
    ? $category['seo_intro'] 
    : "Explore production case studies, custom architectures, and scalable solutions in {$catName} by Amaanullah Khan.";

$allProjects = $allProjects ?? \App\Models\ProjectModel::summaryList('sort_order ASC, id ASC');
$catProjects = $projects ?? array_values(array_filter($allProjects, fn($p) => ($p['category_slug'] ?? '') === $catSlug));

// Calculate live counts per category for the filter bar
$counts = [
    'all'      => count($allProjects),
    'web'      => 0,
    'apps'     => 0,
    'products' => 0,
    'mobile'   => 0,
];
foreach ($allProjects as $p) {
    $c = $p['category_slug'] ?? '';
    if (str_contains($c, 'design') || str_contains($c, 'web-design')) $counts['web']++;
    elseif (str_contains($c, 'app') && !str_contains($c, 'mobile')) $counts['apps']++;
    elseif (str_contains($c, 'product')) $counts['products']++;
    elseif (str_contains($c, 'mobile')) $counts['mobile']++;
    else $counts['apps']++;
}

// Map slug to filter key
$activeFilter = match($catSlug) {
    'web-design-development' => 'web',
    'web-applications'       => 'apps',
    'products'               => 'products',
    'mobile-apps'            => 'mobile',
    default                  => 'apps'
};

// Category FAQs dictionary
$faqDictionary = [
    'web-applications' => [
        [
            'q' => 'Can you build a CRM around our existing sales process?',
            'a' => 'Yes. Instead of forcing your business into rigid off-the-shelf software like Salesforce or HubSpot, I engineer custom CRMs with stages, custom fields, automated assignment rules, and WhatsApp/email triggers tailored exactly to your pipeline.'
        ],
        [
            'q' => 'Do you build multi-tenant systems for SaaS?',
            'a' => 'Yes. I specialize in multi-tenant architectures in Laravel, utilizing safe tenant scoping (either single-database with tenant IDs or multi-database architectures) to ensure complete data isolation and high throughput.'
        ],
        [
            'q' => 'Can my existing data be migrated into the new system?',
            'a' => 'Yes. I build automated sanitization and migration scripts to import legacy records from Excel, CSV, Google Sheets, or legacy SQL databases with zero data loss and historical integrity preserved.'
        ]
    ],
    'web-design-development' => [
        [
            'q' => 'Do you build custom e-commerce without Shopify or WooCommerce?',
            'a' => 'Yes. For stores that have outgrown rigid SaaS themes or suffer from high plugin licensing fees, I build bespoke PHP/Laravel e-commerce engines with sub-second page loads, custom checkouts, and zero transaction fee markups.'
        ],
        [
            'q' => 'Can you redesign or speed up my existing website?',
            'a' => 'Yes. I conduct comprehensive technical audits covering Core Web Vitals, server configuration, database query optimization, and asset pipelines, consistently achieving 95+ PageSpeed scores.'
        ],
        [
            'q' => 'Will I be able to manage products and content myself?',
            'a' => 'Yes. Every custom build includes an intuitive, bespoke administrative control panel where your team can easily update inventory, prices, banners, and blog content without touching a single line of code.'
        ]
    ],
    'products' => [
        [
            'q' => 'Can you build a SaaS product from an idea to launch?',
            'a' => 'Yes. From technical architecture, multi-tenant database modeling, and billing integrations (Stripe, Lemon Squeezy, Paddle) to high-speed RESTful APIs and modern frontend dashboards, I handle end-to-end engineering to take your SaaS from concept to scalable production.'
        ],
        [
            'q' => 'Do you handle subscription billing?',
            'a' => 'Yes, I implement webhook-driven recurring billing with Stripe Billing, Paddle, and custom multi-currency invoicing engines, including prorations, automated dunning, seat-based pricing, and usage-based tiers.'
        ],
        [
            'q' => 'Can a product like Chatrox be set up for my company?',
            'a' => 'Absolutely. Chatrox can be deployed on your private cloud (AWS, DigitalOcean, or private VPS) with complete code ownership, zero per-seat SaaS licensing fees, enterprise encryption, and custom integrations into your internal CRM or operational databases.'
        ]
    ],
    'mobile-apps' => [
        [
            'q' => 'Do you build for both iOS and Android?',
            'a' => 'Yes. Using Flutter, a single compiled codebase delivers 60fps native performance across both iOS and Android, dramatically reducing development time and maintenance overhead while maintaining platform-specific UI behaviors.'
        ],
        [
            'q' => 'Can the app connect to my existing website or backend?',
            'a' => 'Yes. I build secure, authenticated REST and GraphQL APIs that seamlessly sync mobile clients with your existing MySQL/PostgreSQL databases, web dashboards, or third-party enterprise services.'
        ],
        [
            'q' => 'Do you help with publishing to the App Store and Play Store?',
            'a' => 'Yes, I guide the entire release lifecycle — including developer account setup, build signing, privacy policy compliance, App Store Review Guidelines, and automated CI/CD deployment pipelines.'
        ]
    ]
];

$faqs = $faqDictionary[$catSlug] ?? [
    [
        'q' => "What technologies do you use for {$catName}?",
        'a' => "I work with modern, battle-tested technologies including Laravel, PHP 8+, MySQL, React, Flutter, Node.js, and Redis to build scalable, high-speed solutions."
    ],
    [
        'q' => 'What is your typical project timeline?',
        'a' => 'Most custom platforms take between 4 to 12 weeks depending on scope, feature complexity, third-party integrations, and testing requirements.'
    ]
];

// Split projects into Featured (top 2 or flagged) and Remaining
$featured = [];
$remaining = [];
foreach ($catProjects as $p) {
    if (!empty($p['is_featured']) && count($featured) < 2) {
        $featured[] = $p;
    } else {
        $remaining[] = $p;
    }
}
if (empty($featured) && !empty($remaining)) {
    $featured = array_splice($remaining, 0, min(2, count($remaining)));
}

// Build SEO ItemList
$schemaItems = [];
foreach ($catProjects as $idx => $p) {
    $schemaItems[] = [
        '@type' => 'ListItem',
        'position' => $idx + 1,
        'item' => [
            '@type' => 'CreativeWork',
            'name' => $p['title'],
            'url' => base_url('/projects/' . $p['slug']),
            'genre' => $catName,
            'creator' => ['@type' => 'Person', 'name' => 'Amaanullah Khan']
        ]
    ];
}

$pageMeta = [
    'title'       => "{$catName} Projects & Case Studies | Amaanullah Khan",
    'description' => $catIntro,
    'canonical'   => base_url('/projects/category/' . $catSlug),
    'og_type'     => 'website',
    'image'       => asset_url('images/og-projects.png'),
    'page_type'   => 'CollectionPage',
    'itemList'    => $schemaItems,
    'faqs'        => $faqs,
    'breadcrumbs' => [
        ['name' => 'Home', 'url' => base_url('/')],
        ['name' => 'Projects', 'url' => base_url('/projects')],
        ['name' => $catName, 'url' => base_url('/projects/category/' . $catSlug)]
    ]
];

$extraCss = [
    'css/projects.css',
    'css/chatbot.css',
    'css/layout.css'
];
?>
<!doctype html>
<html lang="en">
<head>
<?php require view_path('layouts/head.php'); ?>
</head>
<body>
<div class="bgfx"></div>
<?php $home = false; $active = 'Projects'; require view_path('layouts/header.php'); ?>

<main id="main" data-page="<?= htmlspecialchars($activeFilter) ?>">
  <header class="ph">
    <nav class="crumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="<?= base_url('/') ?>">Home</a></li>
        <li><a href="<?= base_url('/projects') ?>">Projects</a></li>
        <li aria-current="page"><?= htmlspecialchars($catName) ?></li>
      </ol>
    </nav>
    <span class="eyebrow rv2">✦ <?= htmlspecialchars($catName) ?></span>
    <div class="row">
      <div>
        <h1 class="rv2"><?= htmlspecialchars($catName) ?>: <em>Built for Scale &amp; Impact.</em></h1>
        <p class="lead2 rv2" style="max-width:640px;margin-top:12px"><?= htmlspecialchars($catIntro) ?></p>
      </div>
      <nav class="hcs rv2" aria-label="Project categories">
        <a class="hc <?= $catSlug === 'web-design-development' ? 'act' : '' ?>" href="<?= base_url('/projects/category/web-design-development') ?>" data-f="web">
          <b><?= sprintf('%02d', $counts['web']) ?></b><span>Web Design &amp; Development</span><small>E-commerce, marketplaces and custom websites.</small>
        </a>
        <a class="hc <?= $catSlug === 'web-applications' ? 'act' : '' ?>" href="<?= base_url('/projects/category/web-applications') ?>" data-f="apps">
          <b><?= sprintf('%02d', $counts['apps']) ?></b><span>Web Applications</span><small>Custom CRMs, HR portals and business systems.</small>
        </a>
        <a class="hc <?= $catSlug === 'products' ? 'act' : '' ?>" href="<?= base_url('/projects/category/products') ?>" data-f="products">
          <b><?= sprintf('%02d', $counts['products']) ?></b><span>Products</span><small>Owned software products like chat platforms.</small>
        </a>
        <a class="hc <?= $catSlug === 'mobile-apps' ? 'act' : '' ?>" href="<?= base_url('/projects/category/mobile-apps') ?>" data-f="mobile">
          <b><?= sprintf('%02d', $counts['mobile']) ?></b><span>Mobile Applications</span><small>Cross-platform Flutter apps for iOS and Android.</small>
        </a>
      </nav>
    </div>
  </header>

  <div class="fbar2">
    <nav class="fts" role="tablist" aria-label="Filter projects by category">
      <span class="ind" aria-hidden="true"></span>
      <a class="ft" role="tab" href="<?= base_url('/projects') ?>" aria-selected="false" data-f="all">All <sup><?= $counts['all'] ?></sup></a>
      <a class="ft <?= $catSlug === 'web-design-development' ? 'act' : '' ?>" role="tab" href="<?= base_url('/projects/category/web-design-development') ?>" aria-selected="<?= $catSlug === 'web-design-development' ? 'true' : 'false' ?>" data-f="web">Web Design &amp; Development <sup><?= $counts['web'] ?></sup></a>
      <a class="ft <?= $catSlug === 'web-applications' ? 'act' : '' ?>" role="tab" href="<?= base_url('/projects/category/web-applications') ?>" aria-selected="<?= $catSlug === 'web-applications' ? 'true' : 'false' ?>" data-f="apps">Web Applications <sup><?= $counts['apps'] ?></sup></a>
      <a class="ft <?= $catSlug === 'products' ? 'act' : '' ?>" role="tab" href="<?= base_url('/projects/category/products') ?>" aria-selected="<?= $catSlug === 'products' ? 'true' : 'false' ?>" data-f="products">Products <sup><?= $counts['products'] ?></sup></a>
      <a class="ft <?= $catSlug === 'mobile-apps' ? 'act' : '' ?>" role="tab" href="<?= base_url('/projects/category/mobile-apps') ?>" aria-selected="<?= $catSlug === 'mobile-apps' ? 'true' : 'false' ?>" data-f="mobile">Mobile Applications <sup><?= $counts['mobile'] ?></sup></a>
    </nav>
  </div>

  <div id="swap">
    <?php if (!empty($featured)): ?>
      <section class="sec2" id="featured" aria-labelledby="h-feat">
        <div class="lbl2 rv2"><h2 id="h-feat">Featured <?= htmlspecialchars(strtolower($catName)) ?></h2></div>
        <div class="featg n<?= count($featured) ?>">
          <?php foreach ($featured as $fp): 
              $chips = array_filter(array_map('trim', explode(',', $fp['tech_chips'] ?? 'PHP, MySQL')));
              $tagLabel = !empty($fp['industry']) ? $fp['industry'] : $catName;
          ?>
            <article class="pc big" data-cat="<?= htmlspecialchars($activeFilter) ?>">
              <a href="<?= base_url('/projects/' . $fp['slug']) ?>" class="pl" aria-label="View case study: <?= htmlspecialchars($fp['title']) ?>">
                <div class="ban">
                  <img src="<?= asset_url($fp['banner'] ?? 'images/banners/chatrox.svg') ?>" alt="<?= htmlspecialchars($fp['title']) ?>" width="1600" height="1000" loading="lazy" decoding="async">
                  <span class="cb"><?= htmlspecialchars($catName) ?></span>
                </div>
                <div class="pb">
                  <span class="lab"><?= htmlspecialchars($tagLabel) ?></span>
                  <div class="pt">
                    <h3><?= htmlspecialchars($fp['title']) ?></h3>
                    <span class="ar" aria-hidden="true">↗</span>
                  </div>
                  <p><?= htmlspecialchars($fp['summary'] ?? '') ?></p>
                  <div class="tg">
                    <?php foreach (array_slice($chips, 0, 3) as $c): ?><span><?= htmlspecialchars($c) ?></span><?php endforeach; ?>
                  </div>
                  <span class="vc">View case study <b>→</b></span>
                </div>
              </a>
            </article>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

    <?php if (!empty($remaining)): ?>
      <section class="sec2" id="all-projects" aria-labelledby="h-all">
        <div class="lbl2 rv2"><h2 id="h-all">More <?= htmlspecialchars(strtolower($catName)) ?></h2></div>
        <div class="pgrid">
          <?php foreach ($remaining as $rp): 
              $chips = array_filter(array_map('trim', explode(',', $rp['tech_chips'] ?? 'PHP, MySQL')));
              $tagLabel = !empty($rp['industry']) ? $rp['industry'] : $catName;
          ?>
            <article class="pc" data-cat="<?= htmlspecialchars($activeFilter) ?>">
              <a href="<?= base_url('/projects/' . $rp['slug']) ?>" class="pl" aria-label="View case study: <?= htmlspecialchars($rp['title']) ?>">
                <div class="ban">
                  <img src="<?= asset_url($rp['banner'] ?? 'images/banners/chatrox.svg') ?>" alt="<?= htmlspecialchars($rp['title']) ?>" width="1600" height="1000" loading="lazy" decoding="async">
                  <span class="cb"><?= htmlspecialchars($catName) ?></span>
                </div>
                <div class="pb">
                  <span class="lab"><?= htmlspecialchars($tagLabel) ?></span>
                  <div class="pt">
                    <h3><?= htmlspecialchars($rp['title']) ?></h3>
                    <span class="ar" aria-hidden="true">↗</span>
                  </div>
                  <p><?= htmlspecialchars($rp['summary'] ?? '') ?></p>
                  <div class="tg">
                    <?php foreach (array_slice($chips, 0, 2) as $c): ?><span><?= htmlspecialchars($c) ?></span><?php endforeach; ?>
                  </div>
                  <span class="vc">View case study <b>→</b></span>
                </div>
              </a>
            </article>
          <?php endforeach; ?>
        </div>
      </section>
    <?php elseif (empty($featured)): ?>
      <section class="sec2" style="text-align:center;padding:80px 20px;">
        <h2>No projects currently listed in this category</h2>
        <p style="margin:16px auto 24px;max-width:500px;color:var(--mut);">New projects are being deployed and added regularly. Browse all projects or get in touch for custom development.</p>
        <a class="btn o" href="<?= base_url('/projects') ?>">Explore All Projects →</a>
      </section>
    <?php endif; ?>

    <?php if (!empty($faqs)): ?>
      <section class="sec2 pfaq" aria-labelledby="h-faq">
        <div class="lbl2 rv2"><h2 id="h-faq">Questions about <?= htmlspecialchars(strtolower($catName)) ?></h2></div>
        <div class="rv2">
          <?php foreach ($faqs as $faq): ?>
            <details>
              <summary><?= htmlspecialchars($faq['q']) ?></summary>
              <p><?= htmlspecialchars($faq['a']) ?></p>
            </details>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

    <section class="cta2">
      <div class="band rv2">
        <div>
          <h2>Have a project in mind for <?= htmlspecialchars($catName) ?>?</h2>
          <p>Share your vision and requirements — I reply within 24 hours with an actionable roadmap.</p>
        </div>
        <div class="btns" style="margin:0">
          <a class="bo w" href="<?= base_url('/contact') ?>">Get a Quote →</a>
          <a class="bo g" href="<?= base_url('/contact') ?>">Book a Call</a>
        </div>
      </div>
    </section>
  </div>
</main>

<?php require view_path('layouts/footer.php'); ?>

<div class="cur" id="cur" aria-hidden="true">View ↗</div>
<script src="<?= asset_url('js/projects.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script>
<script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= file_exists(PUBLIC_PATH . '/js/chatbot-config.js') ? filemtime(PUBLIC_PATH . '/js/chatbot-config.js') : '1.0' ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= file_exists(PUBLIC_PATH . '/js/chatbot.js') ? filemtime(PUBLIC_PATH . '/js/chatbot.js') : '1.0' ?>" defer></script>
</body>
</html>
