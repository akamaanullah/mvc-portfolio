<!doctype html><html lang="en"><head>
<script src="<?= asset_url('js/theme.js') ?>"></script><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<!-- Laravel route: /articles/category/career-insights -->
<title>Career &amp; Insights Articles | Amaanullah Khan</title>
<meta name="description" content="Thoughts on growing as a developer — from first freelance jobs to team lead, and why fundamentals still matter in the age of AI.">
<link rel="canonical" href="https://example.com/articles/category/career-insights"><!-- EDIT: real domain -->
<link rel="alternate" type="application/rss+xml" title="Amaanullah Khan — Articles" href="https://example.com/articles/feed"><!-- EDIT: feed URL if added -->
<meta property="og:type" content="website"><meta property="og:title" content="Career &amp; Insights Articles | Amaanullah Khan"><meta property="og:description" content="Thoughts on growing as a developer — from first freelance jobs to team lead, and why fundamentals still matter in the age of AI.">
<meta property="og:url" content="https://example.com/articles/category/career-insights"><meta property="og:image" content="https://example.com/images/og-articles.png"><!-- EDIT: og image -->
<meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="Career &amp; Insights Articles | Amaanullah Khan"><meta name="twitter:description" content="Thoughts on growing as a developer — from first freelance jobs to team lead, and why fundamentals still matter in the age of AI."><meta name="twitter:image" content="https://example.com/images/og-articles.png">
<link rel="icon" href="<?= asset_url('logo-v2/favicon.ico') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Caveat:wght@600&display=swap" rel="stylesheet">
<script type="application/ld+json" class="pld">{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [{"@type": "ListItem", "position": 1, "name": "Home", "item": "https://example.com/"}, {"@type": "ListItem", "position": 2, "name": "Articles", "item": "https://example.com/articles"}, {"@type": "ListItem", "position": 3, "name": "Career & Insights", "item": "https://example.com/articles/category/career-insights"}]}</script>
<script type="application/ld+json" class="pld">{
 "@context": "https://schema.org",
 "@type": [
  "Blog",
  "CollectionPage"
 ],
 "name": "Career & Insights Articles | Amaanullah Khan",
 "description": "Thoughts on growing as a developer \u2014 from first freelance jobs to team lead, and why fundamentals still matter in the age of AI.",
 "url": "https://example.com/articles/category/career-insights",
 "author": {
  "@type": "Person",
  "name": "Amaanullah Khan"
 },
 "mainEntity": {
  "@type": "ItemList",
  "itemListElement": [
   {
    "@type": "ListItem",
    "position": 1,
    "url": "https://example.com/articles/from-shopify-dev-to-team-lead",
    "name": "From Shopify developer to team lead: what changed"
   },
   {
    "@type": "ListItem",
    "position": 2,
    "url": "https://example.com/articles/ai-wont-replace-fundamentals",
    "name": "AI speeds up coding \u2014 it doesn't replace fundamentals"
   }
  ]
 }
}</script>
<!-- NOTE: all articles are SAMPLE placeholders -->
<link rel="stylesheet" href="<?= asset_url('css/articles.css') ?>"><link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/articles.dark.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
</head><body>
<div class="bgfx"></div>
<?php $home = false; $active = ''; require view_path('layouts/header.php'); ?>

<main id="main" data-page="career">
<header class="ph"><nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/articles') ?>">Articles</a></li><li aria-current="page">Career &amp; Insights</li></ol></nav>
 <span class="eyebrow rv2">✦ Career &amp; Insights</span>
 <div class="row"><div><h1 class="rv2">Career &amp; <em>insights.</em></h1><p class="lead2 rv2" style="max-width:640px;margin-top:12px">Thoughts on growing as a developer — from first freelance jobs to team lead, and why fundamentals still matter in the age of AI.</p>
 <form class="srch rv2" role="search" action="<?= base_url('/articles') ?>" method="get"><!-- Laravel: route('articles.index') ; search via ?q= --><label for="q-career" class="hp" style="position:absolute;left:-9999px">Search articles</label><input id="q-career" type="search" name="q" placeholder="Search articles…"><button type="submit">Search</button></form>
 <div class="ptags rv2"><b>POPULAR</b><a href="javascript:void(0)">Laravel</a><a href="javascript:void(0)">Multi-tenant</a><a href="javascript:void(0)">CRM</a><a href="javascript:void(0)">Automation</a><a href="javascript:void(0)">Flutter</a><a href="javascript:void(0)">REST API</a><a href="javascript:void(0)">Page speed</a><a href="javascript:void(0)">SaaS billing</a></div></div></div>
</header>
<div class="fbar2"><nav class="fts" role="tablist" aria-label="Article categories"><span class="ind" aria-hidden="true"></span><a class="ft" role="tab" href="<?= base_url('/articles') ?>" aria-selected="false" data-f="all">All <sup>12</sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/laravel-php') ?>" aria-selected="false" data-f="laravel">Laravel &amp; PHP <sup>2</sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/saas-crm') ?>" aria-selected="false" data-f="saas">SaaS &amp; CRM <sup>2</sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/automation-ai') ?>" aria-selected="false" data-f="ai">Automation &amp; AI <sup>2</sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/mobile-flutter') ?>" aria-selected="false" data-f="mobile">Mobile (Flutter) <sup>2</sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/web-development') ?>" aria-selected="false" data-f="web">Web Development <sup>2</sup></a><a class="ft" role="tab" href="<?= base_url('/articles/category/career-insights') ?>" aria-selected="true" aria-current="page" data-f="career">Career &amp; Insights <sup>2</sup></a></nav></div>
<div id="swap">
<section class="sec2" aria-labelledby="h-feat"><div class="lbl2 rv2"><h2 id="h-feat">Latest in Career &amp; Insights</h2></div>
<!-- EDIT: featured article choice --><div class="afeat" style="grid-template-columns:1fr"><article class="ac pc big"><!-- SAMPLE article: replace title, excerpt, cover, date -->
<a class="pl al" href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>" data-article="from-shopify-dev-to-team-lead"><!-- URL: /articles/from-shopify-dev-to-team-lead -->
<div class="cov"><!-- SWAP COVER: images/covers/from-shopify-dev-to-team-lead.svg → 1600x900 --><img src="<?= asset_url('images/covers/from-shopify-dev-to-team-lead.svg') ?>" alt="From Shopify developer to team lead: what changed — cover image" width="1600" height="900" loading="lazy" decoding="async"><span class="cb">Career &amp; Insights</span></div>
<div class="ab"><h3>From Shopify developer to team lead: what changed</h3><p>Lessons from moving from themes to architecture, code reviews and mentoring.</p><div class="am"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="" width="28" height="28" loading="lazy"><!-- SWAP: author avatar --><span><b>Amaanullah Khan</b><small><time datetime="">[Date]</time><!-- EDIT: publish date --> · 7 min read</small></span></div></div></a></article></div></section>
<section class="sec2" aria-labelledby="h-all"><div class="lbl2 rv2"><h2 id="h-all">More articles</h2></div>
<div class="alay"><div><div class="agrid"><article class="ac pc "><!-- SAMPLE article: replace title, excerpt, cover, date -->
<a class="pl al" href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>" data-article="ai-wont-replace-fundamentals"><!-- URL: /articles/ai-wont-replace-fundamentals -->
<div class="cov"><!-- SWAP COVER: images/covers/ai-wont-replace-fundamentals.svg → 1600x900 --><img src="<?= asset_url('images/covers/ai-wont-replace-fundamentals.svg') ?>" alt="AI speeds up coding — it doesn&#x27;t replace fundamentals — cover image" width="1600" height="900" loading="lazy" decoding="async"><span class="cb">Career &amp; Insights</span></div>
<div class="ab"><h3>AI speeds up coding — it doesn&#x27;t replace fundamentals</h3><p>Why understanding databases and architecture still matters when AI writes code.</p><div class="am"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="" width="28" height="28" loading="lazy"><!-- SWAP: author avatar --><span><b>Amaanullah Khan</b><small><time datetime="">[Date]</time><!-- EDIT: publish date --> · 6 min read</small></span></div></div></a></article></div></div><aside class="aside" aria-label="Sidebar">
 <section class="box rv2"><h3>Most read</h3><!-- EDIT: populate from analytics; SAMPLE list --><ol class="mr"><li><a href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>" data-article="multi-tenant-laravel">How I structure multi-tenant SaaS apps in Laravel</a></li><li><a href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>" data-article="crm-around-your-sales-process">Build your CRM around your sales process — not the other way round</a></li><li><a href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>" data-article="flutter-with-laravel-api">Connecting a Flutter app to a Laravel REST API</a></li><li><a href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>" data-article="ai-wont-replace-fundamentals">AI speeds up coding — it doesn&#x27;t replace fundamentals</a></li></ol></section>
 <section class="box nlb rv2" aria-labelledby="h-nl"><h3 id="h-nl">Get new articles by email</h3><p>Occasional, practical posts on Laravel, SaaS and automation. No spam.</p>
  <!-- Laravel: action="{{ route('newsletter.subscribe') }}" method="POST" + @csrf ; show $errors->first('email') ; old('email') -->
  <form class="nlf" action="javascript:void(0)" method="post" novalidate><!-- @csrf -->
   <label class="hp" aria-hidden="true">Leave empty<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
   <label for="nl-career" class="hp">Email address</label><input id="nl-career" type="email" name="email" placeholder="you@company.com" required autocomplete="email">
   <button type="submit">Subscribe</button><div class="msg" role="status" aria-live="polite"></div></form><!-- FAKE SUBMIT: UI only -->
 </section>
 <section class="box rv2"><h3>Topics</h3><div class="tagc"><a href="<?= base_url('/articles/category/laravel-php') ?>">Laravel &amp; PHP</a><a href="<?= base_url('/articles/category/saas-crm') ?>">SaaS &amp; CRM</a><a href="<?= base_url('/articles/category/automation-ai') ?>">Automation &amp; AI</a><a href="<?= base_url('/articles/category/mobile-flutter') ?>">Mobile (Flutter)</a><a href="<?= base_url('/articles/category/web-development') ?>">Web Development</a><a href="<?= base_url('/articles/category/career-insights') ?>">Career &amp; Insights</a></div></section>
</aside></div></section>
<section class="cta2"><div class="band rv2"><div><h2>Need help with Career &amp; Insights?</h2><p>Tell me about your project — I reply within 24 hours with clear next steps.</p></div><div class="btns" style="margin:0"><a class="bo w" href="<?= base_url('/contact') ?>">Book a Call →</a><a class="bo g" href="<?= base_url('/services') ?>">View services</a></div></div></section>
</div></main>
<?php require view_path('layouts/footer.php'); ?>

<div class="cur" id="cur" aria-hidden="true">Read ↗</div>
<script src="<?= asset_url('js/articles.js') ?>"></script><script src="<?= asset_url('js/layout.js') ?>"></script>
<script src="<?= asset_url('js/chatbot-config.js') ?>"></script><!-- EDIT: chatbot config -->
<script src="<?= asset_url('js/chatbot.js') ?>" defer></script>
</body></html>