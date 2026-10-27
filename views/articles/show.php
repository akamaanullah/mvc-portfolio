<?php
$a = $item ?? [];
$slug = $a['slug'] ?? 'multi-tenant-saas-laravel';
$title = $a['title'] ?? 'How to Build a Multi-Tenant SaaS in Laravel: Architecture, Database Strategy and Pitfalls';
$subtitle = $a['subtitle'] ?? 'A practical guide to tenant identification, choosing between shared and separate databases, scoping queries safely, and avoiding the mistakes that leak data between customers.';
$catSlug = $a['category_slug'] ?? 'laravel-php';
$catBadge = $a['badge_category'] ?? 'Laravel';
$badgeType = $a['badge_type'] ?? 'Guide';
$seoTitle = !empty($a['seo_title']) ? $a['seo_title'] : ($title . ' | Amaanullah Khan');
$metaDesc = !empty($a['meta_description']) ? $a['meta_description'] : $subtitle;
$coverImage = !empty($a['cover_image']) ? asset_url($a['cover_image']) : asset_url('images/banners/multi-tenant-crm.svg');
$readingTime = $a['reading_time'] ?? '8 min read';
$pubDate = !empty($a['published_at']) ? date('M d, Y', strtotime($a['published_at'])) : date('M d, Y');
$tags = !empty($a['tags']) ? array_filter(array_map('trim', explode(',', $a['tags']))) : ['Laravel', 'Multi-Tenancy', 'SaaS Architecture', 'Database Design', 'Security'];
$prevArticle = $prev ?? null;
$nextArticle = $next ?? null;
$relatedArticles = $related ?? [];
$currentUrl = base_url('/articles/' . $slug);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($seoTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
<link rel="canonical" href="<?= $currentUrl ?>">
<meta property="og:type" content="article">
<meta property="og:title" content="<?= htmlspecialchars($title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($subtitle) ?>">
<meta property="og:image" content="<?= htmlspecialchars($coverImage) ?>">
<meta property="og:url" content="<?= $currentUrl ?>">
<meta property="article:published_time" content="<?= !empty($a['published_at']) ? date('Y-m-d', strtotime($a['published_at'])) : date('Y-m-d') ?>">
<meta property="article:author" content="Amaanullah Khan">
<meta property="article:section" content="<?= htmlspecialchars($catBadge) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($title) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($subtitle) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($coverImage) ?>">
<link rel="icon" href="<?= asset_url('logo-v2/favicon-32.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [{"@type": "ListItem", "position": 1, "name": "Home", "item": "<?= base_url('/') ?>"}, {"@type": "ListItem", "position": 2, "name": "Articles", "item": "<?= base_url('/articles') ?>"}, {"@type": "ListItem", "position": 3, "name": "<?= htmlspecialchars($catBadge) ?>", "item": "<?= base_url('/articles/category/' . $catSlug) ?>"}, {"@type": "ListItem", "position": 4, "name": "<?= htmlspecialchars($title) ?>", "item": "<?= $currentUrl ?>"}]}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "BlogPosting", "headline": <?= json_encode($seoTitle) ?>, "description": <?= json_encode($metaDesc) ?>, "image": <?= json_encode($coverImage) ?>, "author": {"@type": "Person", "name": "Amaanullah Khan", "url": "<?= base_url('/about') ?>", "jobTitle": "PHP & Laravel Developer"}, "publisher": {"@type": "Person", "name": "Amaanullah Khan"}, "datePublished": "<?= !empty($a['published_at']) ? date('Y-m-d', strtotime($a['published_at'])) : date('Y-m-d') ?>", "dateModified": "<?= !empty($a['updated_at']) ? date('Y-m-d', strtotime($a['updated_at'])) : date('Y-m-d') ?>", "mainEntityOfPage": "<?= $currentUrl ?>", "articleSection": "<?= htmlspecialchars($catBadge) ?>"}</script>
<link rel="stylesheet" href="<?= asset_url('css/article.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
</head>
<body>
<div class="prog" id="prog"></div>
<?php $home = false; $active = ''; require view_path('layouts/header.php'); ?>

<main>
<div class="wrap">
 <nav class="crumb c" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/articles') ?>">Articles</a></li><li><a href="<?= base_url('/articles/category/' . $catSlug) ?>"><?= htmlspecialchars($catBadge) ?></a></li><li aria-current="page"><?= htmlspecialchars($title) ?></li></ol></nav>
 <header class="ahero">
  <div class="badges"><span class="bdg"><?= htmlspecialchars($catBadge) ?></span><span class="bdg l"><?= htmlspecialchars($badgeType) ?></span></div>
  <h1><?= htmlspecialchars($title) ?></h1>
  <p class="sum"><?= htmlspecialchars($subtitle) ?></p>
  <div class="by"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="Amaanullah Khan" width="48" height="48"><div class="who"><b>Amaanullah Khan</b><small>PHP &amp; Laravel Developer</small></div>
   <div class="who"><small>Published <?= htmlspecialchars($pubDate) ?></small><small style="display:block" id="rtime"><?= htmlspecialchars($readingTime) ?></small></div></div>
  <div class="shr" aria-label="Share this article"><button type="button" class="copyl" aria-label="Copy link"><svg viewBox="0 0 24 24"><path d="M10.6 13.4a1 1 0 0 1 0-1.4l3.5-3.5a1 1 0 1 1 1.4 1.4L12 13.4a1 1 0 0 1-1.4 0zM8.5 20a5.5 5.5 0 0 1-3.9-9.4l2-2 1.4 1.4-2 2a3.5 3.5 0 0 0 5 5l2-2 1.4 1.4-2 2A5.5 5.5 0 0 1 8.5 20zm9-7-1.4-1.4 2-2a3.5 3.5 0 0 0-5-5l-2 2L9.7 5.2l2-2A5.5 5.5 0 0 1 19.5 11z"/></svg></button><a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($currentUrl) ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><svg viewBox="0 0 24 24"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM9 9h3.8v1.7h.05c.53-1 1.83-2.05 3.77-2.05 4.03 0 4.78 2.65 4.78 6.1V21h-4v-5.5c0-1.3-.02-3-1.83-3-1.83 0-2.1 1.43-2.1 2.9V21H9z"/></svg></a><a href="https://twitter.com/intent/tweet?url=<?= urlencode($currentUrl) ?>&amp;text=<?= urlencode($title) ?>" target="_blank" rel="noopener" aria-label="Share on X"><svg viewBox="0 0 24 24"><path d="M17.8 3h3.3l-7.2 8.2L22.4 21h-6.6l-5.2-6.8L4.7 21H1.4l7.7-8.8L1 3h6.8l4.7 6.2zm-1.2 16h1.8L7.5 4.9H5.6z"/></svg></a><a href="https://wa.me/?text=<?= urlencode($title . ' ' . $currentUrl) ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2zm5.3 13.9c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.5-3.9-4.7-4.1-.1-.2-1.1-1.5-1.1-2.9s.7-2.1 1-2.4c.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .6l-.4.6-.4.4c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.3 2.4 1.5.3.1.5.1.6-.1l.9-1c.2-.3.4-.2.6-.1l2 1c.3.1.5.2.5.3.1.2.1.7-.1 1.3z"/></svg></a></div>
 </header>
 <div class="cover"><img src="<?= htmlspecialchars($coverImage) ?>" alt="<?= htmlspecialchars($title) ?>" width="1600" height="900" fetchpriority="high"></div>
 <div class="alay">
  <?php if ($slug === 'multi-tenant-saas-laravel'): ?>
  <aside class="toc" aria-label="On this page"><div class="rt"><span>On this page</span><span id="pct">0%</span></div><div class="bar"><i id="tbar"></i></div><ol><li class="l2"><a href="#what-is-multi-tenancy">What Multi-Tenancy Means (and What It Doesn’t)</a></li><li class="l2"><a href="#choosing-a-database-strategy">Choosing a Database Strategy</a></li><li class="l3"><a href="#single-database">Single database with a tenant_id column</a></li><li class="l3"><a href="#database-per-tenant">Database per tenant</a></li><li class="l2"><a href="#identifying-the-tenant">Identifying the Current Tenant</a></li><li class="l2"><a href="#scoping-queries">Scoping Queries So Data Never Leaks</a></li><li class="l3"><a href="#where-scopes-dont-reach">Where global scopes don’t reach</a></li><li class="l2"><a href="#authentication-and-roles">Authentication, Users and Roles</a></li><li class="l2"><a href="#queues-cache-storage">Queues, Cache and File Storage</a></li><li class="l3"><a href="#tenant-aware-jobs">Tenant-aware jobs</a></li><li class="l3"><a href="#cache-and-files">Cache keys and file paths</a></li><li class="l2"><a href="#migrations-and-onboarding">Migrations and Tenant Onboarding</a></li><li class="l2"><a href="#common-pitfalls">Common Pitfalls and How to Avoid Them</a></li><li class="l2"><a href="#billing-and-plans">Plans, Limits and Billing per Tenant</a></li><li class="l2"><a href="#testing-tenant-isolation">Testing Tenant Isolation</a></li><li class="l2"><a href="#performance-and-scaling">Performance and Scaling</a></li><li class="l2"><a href="#build-or-use-a-package">Build It Yourself or Use a Package?</a></li><li class="l2"><a href="#conclusion">Conclusion</a></li><li class="l2"><a href="#faq">FAQ</a></li></ol></aside>
  <div class="mtoc"><details><summary>On this page <span id="mcur">Introduction</span></summary><ol><li class="l2"><a href="#what-is-multi-tenancy">What Multi-Tenancy Means (and What It Doesn’t)</a></li><li class="l2"><a href="#choosing-a-database-strategy">Choosing a Database Strategy</a></li><li class="l3"><a href="#single-database">Single database with a tenant_id column</a></li><li class="l3"><a href="#database-per-tenant">Database per tenant</a></li><li class="l2"><a href="#identifying-the-tenant">Identifying the Current Tenant</a></li><li class="l2"><a href="#scoping-queries">Scoping Queries So Data Never Leaks</a></li><li class="l3"><a href="#where-scopes-dont-reach">Where global scopes don’t reach</a></li><li class="l2"><a href="#authentication-and-roles">Authentication, Users and Roles</a></li><li class="l2"><a href="#queues-cache-storage">Queues, Cache and File Storage</a></li><li class="l3"><a href="#tenant-aware-jobs">Tenant-aware jobs</a></li><li class="l3"><a href="#cache-and-files">Cache keys and file paths</a></li><li class="l2"><a href="#migrations-and-onboarding">Migrations and Tenant Onboarding</a></li><li class="l2"><a href="#common-pitfalls">Common Pitfalls and How to Avoid Them</a></li><li class="l2"><a href="#billing-and-plans">Plans, Limits and Billing per Tenant</a></li><li class="l2"><a href="#testing-tenant-isolation">Testing Tenant Isolation</a></li><li class="l2"><a href="#performance-and-scaling">Performance and Scaling</a></li><li class="l2"><a href="#build-or-use-a-package">Build It Yourself or Use a Package?</a></li><li class="l2"><a href="#conclusion">Conclusion</a></li><li class="l2"><a href="#faq">FAQ</a></li></ol></details></div>
  <article class="prose" id="content">
<p class="lead">Multi-tenancy is the backbone of almost every B2B SaaS product: one codebase, one deployment, many customers, each of whom must feel like the system was built only for them. Laravel is an excellent fit for this, but the framework does not make the hard decisions for you. This guide walks through those decisions in the order you will meet them.</p>
<p>We will cover what “tenant” actually means in your domain, how to identify the current tenant on every request, the three common database strategies and when each makes sense, how to scope Eloquent queries so data never leaks, and how queues, caching, files and testing need to change once tenancy enters the picture. The examples use Laravel 11 conventions, but the ideas apply to any recent version.</p>
<h2 id="what-is-multi-tenancy">What Multi-Tenancy Means (and What It Doesn’t)</h2>
<p>A <strong>tenant</strong> is the unit of isolation in your product: usually a company, workspace, school or clinic that signs up and invites its own users. Everything a tenant creates (customers, invoices, tickets, files) belongs to that tenant and must never be visible to another one.</p>
<p>Multi-tenancy is not the same as having users with roles. Roles control what a person can do <em>inside</em> a tenant; tenancy controls <em>which data set</em> they are allowed to see at all. Mixing the two is the single most common source of design confusion, so keep them separate from day one:</p>
<ul><li><strong>Tenant</strong>: the organisation boundary (who owns the data).</li><li><strong>User</strong>: a person who logs in; may belong to one or several tenants.</li><li><strong>Role / permission</strong>: what that user may do within the current tenant.</li></ul>
<aside class="cl note"><b>Note</b><p>If a user can belong to more than one tenant (common for agencies and accountants), model it as a <code>tenant_user</code> pivot with the role on the pivot, not a single <code>tenant_id</code> on the users table.</p></aside>
<h2 id="choosing-a-database-strategy">Choosing a Database Strategy</h2>
<p>This is the decision that is most expensive to reverse, so it deserves the most thought. There are three mainstream approaches.</p>
<div class="tbl"><table><thead><tr><th>Strategy</th><th>Isolation</th><th>Ops complexity</th><th>Best for</th></tr></thead><tbody>
<tr><td><strong>Single database, <code>tenant_id</code> column</strong></td><td>Logical (application-enforced)</td><td>Low</td><td>Most early-stage SaaS, many small tenants</td></tr>
<tr><td><strong>Schema per tenant</strong> (PostgreSQL)</td><td>Strong logical</td><td>Medium</td><td>Moderate tenant counts, per-tenant restores</td></tr>
<tr><td><strong>Database per tenant</strong></td><td>Physical</td><td>High</td><td>Enterprise or regulated customers, data residency</td></tr>
</tbody></table></div>
<h3 id="single-database">Single database with a tenant_id column</h3>
<p>Every tenant-owned table gets a <code>tenant_id</code> foreign key, and every query filters by it. Migrations run once, reporting across tenants is a simple query, and one connection pool serves everyone. The trade-off is that isolation depends entirely on your code: one missing <code>where</code> clause and a customer sees someone else’s data.</p>
<figure class="code"><div class="ch"><span class="lang">php</span><span class="fn">database/migrations/create_invoices_table.php</span><button class="cp" type="button">Copy</button></div><pre><code>Schema::create(<span class="s">'invoices'</span>, <span class="k">function</span> (Blueprint <span class="v">$table</span>) {
    <span class="v">$table</span>-&gt;id();
    <span class="v">$table</span>-&gt;foreignId(<span class="s">'tenant_id'</span>)-&gt;constrained()-&gt;cascadeOnDelete();
    <span class="v">$table</span>-&gt;string(<span class="s">'number'</span>);
    <span class="v">$table</span>-&gt;decimal(<span class="s">'total'</span>, 12, 2);
    <span class="v">$table</span>-&gt;timestamps();

    <span class="c">// Uniqueness must be per tenant, not global</span>
    <span class="v">$table</span>-&gt;unique([<span class="s">'tenant_id'</span>, <span class="s">'number'</span>]);
    <span class="v">$table</span>-&gt;index([<span class="s">'tenant_id'</span>, <span class="s">'created_at'</span>]);
});</code></pre></figure>
<p>Notice the composite unique key and index. Two tenants can both have invoice <code>INV-0001</code>, and almost every query will filter by tenant first, so <code>tenant_id</code> should lead your composite indexes.</p>
<h3 id="database-per-tenant">Database per tenant</h3>
<p>Each tenant gets its own database, and a small <strong>central</strong> (landlord) database stores tenants, domains, plans and billing. On each request you look up the tenant centrally, then switch the <code>tenant</code> connection to that tenant’s database. Isolation is physical, a single tenant can be backed up, restored or moved to another server, and noisy neighbours are easier to contain.</p>
<p>The costs are real, though: migrations must run across hundreds of databases, cross-tenant analytics need a separate pipeline, and connection limits become a capacity concern.</p>
<figure class="code"><div class="ch"><span class="lang">php</span><span class="fn">app/Tenancy/DatabaseSwitcher.php</span><button class="cp" type="button">Copy</button></div><pre><code><span class="k">public</span> <span class="k">function</span> switchTo(Tenant <span class="v">$tenant</span>): void
{
    config([<span class="s">'database.connections.tenant.database'</span> =&gt; <span class="v">$tenant</span>-&gt;database]);

    DB::purge(<span class="s">'tenant'</span>);      <span class="c">// drop the old connection</span>
    DB::reconnect(<span class="s">'tenant'</span>);  <span class="c">// reconnect with the new database</span>
    DB::setDefaultConnection(<span class="s">'tenant'</span>);
}</code></pre></figure>
<aside class="cl tip"><b>Tip</b><p>You don’t have to pick one strategy forever. Many products start with a shared database and offer a dedicated database as an enterprise add-on. Design your tenant model with a nullable <code>database</code> column early so that path stays open.</p></aside>
<aside class="pull"><p>Pick the simplest isolation model your customers will accept, and make the upgrade path to stronger isolation cheap.</p></aside>
<h2 id="identifying-the-tenant">Identifying the Current Tenant</h2>
<p>Before any query runs, the application must know which tenant the request belongs to. The common resolution methods are:</p>
<ol><li><strong>Subdomain</strong>: <code>acme.yourapp.com</code>. Clean, cookie-friendly, and the most popular choice.</li><li><strong>Custom domain</strong>: <code>portal.acme.com</code>, mapped through a <code>domains</code> table. Customers love it; you will need wildcard or on-demand TLS.</li><li><strong>Path prefix</strong>: <code>yourapp.com/acme/…</code>. Simple to deploy but noisier routes.</li><li><strong>Header or token claim</strong>: ideal for APIs and mobile apps, where the tenant is carried in the access token.</li></ol>
<h2 id="scoping-queries">Scoping Queries So Data Never Leaks</h2>
<p>In a shared database, query scoping is where safety is won or lost. Laravel developers typically reach for an Eloquent global scope:</p>
<figure class="code"><div class="ch"><span class="lang">php</span><span class="fn">app/Models/Scopes/TenantScope.php</span><button class="cp" type="button">Copy</button></div><pre><code><span class="k">public</span> <span class="k">function</span> apply(Builder <span class="v">$builder</span>, Model <span class="v">$model</span>): void
{
    <span class="k">if</span> (app()-&gt;has(<span class="s">'currentTenant'</span>)) {
        <span class="v">$builder</span>-&gt;where(<span class="v">$model</span>-&gt;getTable() . <span class="s">'.tenant_id'</span>, app(<span class="s">'currentTenant'</span>)-&gt;id);
    }
}</code></pre></figure>
<h2 id="common-pitfalls">Common Pitfalls and How to Avoid Them</h2>
<ul><li><strong>Raw queries without tenant filters.</strong> Search the codebase for <code>DB::table</code> and <code>DB::select</code> regularly, and review each one.</li><li><strong>Global unique constraints.</strong> An email or invoice number that is unique across all tenants blocks legitimate data. Make uniqueness composite with <code>tenant_id</code>.</li><li><strong>Jobs and commands without tenant context.</strong> Anything running outside HTTP must set the tenant explicitly.</li><li><strong>Shared cache keys.</strong> Prefix everything with tenant ID.</li></ul>
<h2 id="conclusion">Conclusion</h2>
<p>A good multi-tenant Laravel application is built on a few deliberate choices: a clear definition of the tenant, a database strategy matched to your customers, one place that resolves the current tenant, automatic query scoping, and tenant context carried into jobs, cache and files. Get those right and tests to prove isolation, and the rest of the product can be built like any other Laravel app.</p>
  <?php else: ?>
  <!-- DYNAMIC VIEW FOR OTHER ARTICLES -->
  <aside class="toc" aria-label="On this page"><div class="rt"><span>On this page</span><span id="pct">0%</span></div><div class="bar"><i id="tbar"></i></div><ol><li class="l2"><a href="#overview">Overview &amp; Context</a></li><li class="l2"><a href="#deep-dive">Key Architecture &amp; Insights</a></li><li class="l2"><a href="#takeaways">Practical Takeaways</a></li></ol></aside>
  <div class="mtoc"><details><summary>On this page <span id="mcur">Introduction</span></summary><ol><li class="l2"><a href="#overview">Overview &amp; Context</a></li><li class="l2"><a href="#deep-dive">Key Architecture &amp; Insights</a></li><li class="l2"><a href="#takeaways">Practical Takeaways</a></li></ol></details></div>
  <article class="prose" id="content">
   <?php if (!empty($a['body_html'])): ?>
     <?= $a['body_html'] ?>
   <?php else: ?>
     <p class="lead"><?= htmlspecialchars($subtitle) ?></p>
     <h2 id="overview">Overview &amp; Practical Context</h2>
     <p><?= htmlspecialchars($a['excerpt'] ?? $subtitle) ?></p>
     <aside class="cl tip"><b>Key Focus</b><p>Building maintainable, production-ready software requires solving the underlying architectural bottlenecks before writing user-facing code.</p></aside>
     <h2 id="deep-dive">Key Architectural Principles</h2>
     <p>When engineering high-throughput business applications, clean separation of concerns and clear data ownership boundaries protect the product as user concurrency increases.</p>
     <ul>
      <li><strong>Structured Data Layers:</strong> Clear entity boundaries and indexed lookups maintain sub-second response times.</li>
      <li><strong>Defensive Code Structure:</strong> Validations, automated retries, and comprehensive error handling prevent silent failures.</li>
      <li><strong>Operational Simplicity:</strong> Clean code patterns that existing teams can easily maintain and extend.</li>
     </ul>
     <h2 id="takeaways">Practical Takeaways &amp; Next Steps</h2>
     <p>Before launching complex workflows or heavy background tasks, test your system under simulated load and ensure proper observability is in place.</p>
     <div class="take"><b>Summary</b><p><?= htmlspecialchars($subtitle) ?></p></div>
   <?php endif; ?>
  <?php endif; ?>

   <div class="tags" aria-label="Tags"><?php foreach ($tags as $t): ?><a href="<?= base_url('/articles') ?>">#<?= htmlspecialchars(ltrim($t, '#')) ?></a><?php endforeach; ?></div>
   <section class="abio" aria-label="About the author"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="Amaanullah Khan" loading="lazy" width="76" height="76"><div><small>Written by</small><h3>Amaanullah Khan</h3><p>PHP &amp; Laravel developer in Karachi building custom CRM, SaaS and enterprise web apps, plus Flutter mobile apps.</p><div class="lk"><a href="<?= base_url('/about') ?>">About me →</a><a href="<?= base_url('/projects') ?>">See projects →</a></div></div></section>
   <section class="afaq" id="faq" aria-labelledby="h-faq"><h2 id="h-faq">Frequently Asked Questions</h2>
    <details class="fq"><summary>Can I apply these patterns to my existing application?<span class="pm" aria-hidden="true"></span></summary><div><p>Yes. These architectural approaches are designed to be incrementally adoptable without requiring a total rewrite of your stack.</p></div></details>
    <details class="fq"><summary>How do these architectural decisions scale over time?<span class="pm" aria-hidden="true"></span></summary><div><p>By enforcing clean separation between storage, business logic, and presentation layers, your application stays performant even as record counts reach millions.</p></div></details>
   </section>
   <section class="news" aria-labelledby="h-news"><div><h2 id="h-news">Get new articles in your inbox</h2><p>Practical Laravel, SaaS and architecture notes. No spam.</p></div><form onsubmit="event.preventDefault();this.querySelector('button').textContent='Subscribed ✓'"><label class="sr" for="em" style="position:absolute;left:-9999px">Email</label><input id="em" type="email" placeholder="you@company.com" required><button class="btn o" type="submit">Subscribe</button></form></section>
  </article>
  <aside class="rail" aria-label="Share"><div class="shr" aria-label="Share this article"><button type="button" class="copyl" aria-label="Copy link"><svg viewBox="0 0 24 24"><path d="M10.6 13.4a1 1 0 0 1 0-1.4l3.5-3.5a1 1 0 1 1 1.4 1.4L12 13.4a1 1 0 0 1-1.4 0zM8.5 20a5.5 5.5 0 0 1-3.9-9.4l2-2 1.4 1.4-2 2a3.5 3.5 0 0 0 5 5l2-2 1.4 1.4-2 2A5.5 5.5 0 0 1 8.5 20zm9-7-1.4-1.4 2-2a3.5 3.5 0 0 0-5-5l-2 2L9.7 5.2l2-2A5.5 5.5 0 0 1 19.5 11z"/></svg></button><a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($currentUrl) ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><svg viewBox="0 0 24 24"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM9 9h3.8v1.7h.05c.53-1 1.83-2.05 3.77-2.05 4.03 0 4.78 2.65 4.78 6.1V21h-4v-5.5c0-1.3-.02-3-1.83-3-1.83 0-2.1 1.43-2.1 2.9V21H9z"/></svg></a><a href="https://twitter.com/intent/tweet?url=<?= urlencode($currentUrl) ?>&amp;text=<?= urlencode($title) ?>" target="_blank" rel="noopener" aria-label="Share on X"><svg viewBox="0 0 24 24"><path d="M17.8 3h3.3l-7.2 8.2L22.4 21h-6.6l-5.2-6.8L4.7 21H1.4l7.7-8.8L1 3h6.8l4.7 6.2zm-1.2 16h1.8L7.5 4.9H5.6z"/></svg></a><a href="https://wa.me/?text=<?= urlencode($title . ' ' . $currentUrl) ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2zm5.3 13.9c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.5-3.9-4.7-4.1-.1-.2-1.1-1.5-1.1-2.9s.7-2.1 1-2.4c.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .6l-.4.6-.4.4c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.3 2.4 1.5.3.1.5.1.6-.1l.9-1c.2-.3.4-.2.6-.1l2 1c.3.1.5.2.5.3.1.2.1.7-.1 1.3z"/></svg></a></div></aside>
 </div>
 <nav class="pn" style="margin-top:70px" aria-label="More articles">
  <?php if ($prevArticle): ?>
    <a href="<?= base_url('/articles/' . $prevArticle['slug']) ?>"><small>← Previous article</small><b><?= htmlspecialchars($prevArticle['title']) ?></b></a>
  <?php else: ?>
    <a href="<?= base_url('/articles') ?>"><small>← All articles</small><b>Browse Library</b></a>
  <?php endif; ?>
  <?php if ($nextArticle): ?>
    <a href="<?= base_url('/articles/' . $nextArticle['slug']) ?>"><small>Next article →</small><b><?= htmlspecialchars($nextArticle['title']) ?></b></a>
  <?php else: ?>
    <a href="<?= base_url('/articles') ?>"><small>Next →</small><b>All Articles</b></a>
  <?php endif; ?>
 </nav>
 <section class="rel" aria-labelledby="h-rel"><p class="eyb">Keep reading</p><h2 id="h-rel">Related Articles</h2>
  <div class="rgrid">
    <?php foreach ($relatedArticles as $rel): 
      $rCov = !empty($rel['cover_image']) ? asset_url($rel['cover_image']) : asset_url('images/covers/crm-around-your-sales-process.svg');
    ?>
    <a class="rc ra" href="<?= base_url('/articles/' . $rel['slug']) ?>">
      <img src="<?= htmlspecialchars($rCov) ?>" alt="<?= htmlspecialchars($rel['title']) ?> cover" loading="lazy" width="1600" height="900">
      <div>
        <small><?= htmlspecialchars($rel['badge_category'] ?? 'Architecture') ?></small>
        <h3><?= htmlspecialchars($rel['title']) ?></h3>
        <p><?= htmlspecialchars(mb_strimwidth($rel['excerpt'] ?? '', 0, 85, '…')) ?></p>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
 </section>
 <section class="cta"><div><h2>Building a SaaS or custom platform?</h2><p>Let’s talk about architecture, timelines and the right stack for your product.</p></div><a class="btn" href="<?= base_url('/#contact') ?>">Start a project →</a></section>
</div>
</main>
<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/article.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script>
<script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= time() ?>" defer></script>
</body></html>