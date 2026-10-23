<!DOCTYPE html>
<html lang="en">
<head>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<!--
  ARTICLE TEMPLATE — Blade mapping (resources/views/articles/show.blade.php)
  Route: /articles/{category:slug}/{article:slug}  ->  ArticleController@show
  Slots are marked with "DYNAMIC: $article->field" comments.
  Body: {!! $article->body_html !!} (rendered + sanitised Markdown/HTML). H2/H3 in the body MUST carry id="slug".
  TOC: auto-built from H2/H3 in body (parse on save into $article->toc, or in a view composer) — same markup as below (li.l2 / li.l3).
  Code blocks: render as <figure class="code"> with .lang label + .cp copy button; colour with span.k/.s/.v/.c (server-side, e.g. a small highlighter or commonmark extension).
  Reading time: JS computes from #content, or $article->reading_time.
  FAQ: $article->faqs; FAQPage JSON-LD may be enabled because answers are real (keep it in sync).
  SAMPLE ARTICLE — general technical content; replace dates, cover and related items.
-->
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>How to Build a Multi-Tenant SaaS in Laravel: Architecture, Database Strategy and Pitfalls | Amaanullah Khan</title><!-- DYNAMIC: $article->seo_title -->
<meta name="description" content="Learn how to build a multi-tenant SaaS in Laravel: tenant identification, shared vs separate databases, global scopes, tenant-aware queues and cache, testing isolation and common pitfalls."><!-- DYNAMIC: $article->meta_description -->
<link rel="canonical" href="https://[your-domain]/articles/laravel/multi-tenant-saas-laravel">
<meta property="og:type" content="article"><meta property="og:title" content="How to Build a Multi-Tenant SaaS in Laravel: Architecture, Database Strategy and Pitfalls"><meta property="og:description" content="A practical guide to tenant identification, choosing between shared and separate databases, scoping queries safely, and avoiding the mistakes that leak data between customers."><meta property="og:image" content="https://[your-domain]/images/articles/multi-tenant-saas-laravel.webp"><meta property="og:url" content="https://[your-domain]/articles/laravel/multi-tenant-saas-laravel">
<meta property="article:published_time" content="[YYYY-MM-DD]"><meta property="article:modified_time" content="[YYYY-MM-DD]"><meta property="article:author" content="Amaanullah Khan"><meta property="article:section" content="Laravel"><meta property="article:tag" content="Laravel"><meta property="article:tag" content="Multi-Tenancy"><meta property="article:tag" content="SaaS Architecture"><meta property="article:tag" content="Database Design"><meta property="article:tag" content="Eloquent"><meta property="article:tag" content="Security">
<meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="How to Build a Multi-Tenant SaaS in Laravel: Architecture, Database Strategy and Pitfalls"><meta name="twitter:description" content="A practical guide to tenant identification, choosing between shared and separate databases, scoping queries safely, and avoiding the mistakes that leak data between customers."><meta name="twitter:image" content="https://[your-domain]/images/articles/multi-tenant-saas-laravel.webp">
<link rel="icon" href="<?= asset_url('logo-v2/favicon-32.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [{"@type": "ListItem", "position": 1, "name": "Home", "item": "https://[your-domain]/index.html"}, {"@type": "ListItem", "position": 2, "name": "Articles", "item": "https://[your-domain]/articles-page.html"}, {"@type": "ListItem", "position": 3, "name": "Laravel", "item": "https://[your-domain]/articles-page.html"}, {"@type": "ListItem", "position": 4, "name": "Multi-Tenant SaaS in Laravel", "item": "https://[your-domain]/articles/laravel/multi-tenant-saas-laravel"}]}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "BlogPosting", "headline": "How to Build a Multi-Tenant SaaS in Laravel: Architecture, Database Strategy and Pitfalls", "description": "A practical guide to tenant identification, choosing between shared and separate databases, scoping queries safely, and avoiding the mistakes that leak data between customers.", "image": "https://[your-domain]/images/articles/multi-tenant-saas-laravel.webp", "author": {"@type": "Person", "name": "Amaanullah Khan", "url": "https://[your-domain]/about", "jobTitle": "PHP & Laravel Developer"}, "publisher": {"@type": "Person", "name": "Amaanullah Khan"}, "datePublished": "[YYYY-MM-DD]", "dateModified": "[YYYY-MM-DD]", "mainEntityOfPage": "https://[your-domain]/articles/laravel/multi-tenant-saas-laravel", "articleSection": "Laravel", "keywords": "Laravel multi-tenancy, multi-tenant SaaS, tenant_id, database per tenant, global scopes", "wordCount": "[auto]"}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "Which database strategy is best for a new Laravel SaaS?", "acceptedAnswer": {"@type": "Answer", "text": "For most new products, a single database with a tenant_id column is the simplest and cheapest to run. Move to schema- or database-per-tenant when customers require stronger isolation, data residency or individual backups."}}, {"@type": "Question", "name": "Do global scopes protect raw DB queries?", "acceptedAnswer": {"@type": "Answer", "text": "No. Global scopes only apply to Eloquent queries. Raw DB::table() and DB::select() calls, and validation rules such as unique and exists, need explicit tenant conditions."}}, {"@type": "Question", "name": "How do queued jobs know which tenant they belong to?", "acceptedAnswer": {"@type": "Answer", "text": "Pass the tenant ID into the job, then restore the tenant context at the start of handle() before running any queries."}}, {"@type": "Question", "name": "Should I use stancl/tenancy or build my own?", "acceptedAnswer": {"@type": "Answer", "text": "For database-per-tenant setups a package usually saves significant time. For a simple shared-database model, a small trait and middleware may be all you need."}}]}</script>
<link rel="stylesheet" href="<?= asset_url('css/article.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/article.dark.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
</head>
<body>
<div class="prog" id="prog"></div>
<?php $home = false; $active = ''; require view_path('layouts/header.php'); ?>

<main>
<!-- SAMPLE ARTICLE -->
<div class="wrap">
 <nav class="crumb c" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/articles') ?>">Articles</a></li><li><a href="<?= base_url('/articles') ?>">Laravel</a></li><li aria-current="page">Multi-Tenant SaaS in Laravel</li></ol></nav><!-- DYNAMIC: $article->category->name, $article->title -->
 <header class="ahero">
  <div class="badges"><span class="bdg">Laravel</span><!-- DYNAMIC: $article->category --><span class="bdg l">Guide</span><!-- DYNAMIC: $article->type --></div>
  <h1>How to Build a Multi-Tenant SaaS in Laravel: Architecture, Database Strategy and Pitfalls</h1><!-- DYNAMIC: $article->title -->
  <p class="sum">A practical guide to tenant identification, choosing between shared and separate databases, scoping queries safely, and avoiding the mistakes that leak data between customers.</p><!-- DYNAMIC: $article->subtitle -->
  <div class="by"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="Amaanullah Khan" width="48" height="48"><!-- SWAP AVATAR --><div class="who"><b>Amaanullah Khan</b><small>PHP &amp; Laravel Developer</small></div>
   <div class="who"><small>Published <span class="ph">[Date]</span> · Updated <span class="ph">[Date]</span></small><small style="display:block" id="rtime">— min read</small></div></div><!-- DYNAMIC: $article->published_at, $article->updated_at -->
  <div class="shr" aria-label="Share this article"><!-- DYNAMIC: share URLs use url()->current() + $article->title --><button type="button" class="copyl" aria-label="Copy link"><svg viewBox="0 0 24 24"><path d="M10.6 13.4a1 1 0 0 1 0-1.4l3.5-3.5a1 1 0 1 1 1.4 1.4L12 13.4a1 1 0 0 1-1.4 0zM8.5 20a5.5 5.5 0 0 1-3.9-9.4l2-2 1.4 1.4-2 2a3.5 3.5 0 0 0 5 5l2-2 1.4 1.4-2 2A5.5 5.5 0 0 1 8.5 20zm9-7-1.4-1.4 2-2a3.5 3.5 0 0 0-5-5l-2 2L9.7 5.2l2-2A5.5 5.5 0 0 1 19.5 11z"/></svg></button><a href="https://www.linkedin.com/sharing/share-offsite/?url=https%3A%2F%2F%5Byour-domain%5D%2Farticles%2Flaravel%2Fmulti-tenant-saas-laravel" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><svg viewBox="0 0 24 24"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM9 9h3.8v1.7h.05c.53-1 1.83-2.05 3.77-2.05 4.03 0 4.78 2.65 4.78 6.1V21h-4v-5.5c0-1.3-.02-3-1.83-3-1.83 0-2.1 1.43-2.1 2.9V21H9z"/></svg></a><a href="https://twitter.com/intent/tweet?url=https%3A%2F%2F%5Byour-domain%5D%2Farticles%2Flaravel%2Fmulti-tenant-saas-laravel&amp;text=How%20to%20Build%20a%20Multi-Tenant%20SaaS%20in%20Laravel%3A%20Architecture%2C%20Database%20Strategy%20and%20Pitfalls" target="_blank" rel="noopener" aria-label="Share on X"><svg viewBox="0 0 24 24"><path d="M17.8 3h3.3l-7.2 8.2L22.4 21h-6.6l-5.2-6.8L4.7 21H1.4l7.7-8.8L1 3h6.8l4.7 6.2zm-1.2 16h1.8L7.5 4.9H5.6z"/></svg></a><a href="https://wa.me/?text=How%20to%20Build%20a%20Multi-Tenant%20SaaS%20in%20Laravel%3A%20Architecture%2C%20Database%20Strategy%20and%20Pitfalls%20https%3A%2F%2F%5Byour-domain%5D%2Farticles%2Flaravel%2Fmulti-tenant-saas-laravel" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2zm5.3 13.9c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.5-3.9-4.7-4.1-.1-.2-1.1-1.5-1.1-2.9s.7-2.1 1-2.4c.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .6l-.4.6-.4.4c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.3 2.4 1.5.3.1.5.1.6-.1l.9-1c.2-.3.4-.2.6-.1l2 1c.3.1.5.2.5.3.1.2.1.7-.1 1.3z"/></svg></a></div>
 </header>
 <div class="cover"><img src="<?= asset_url('images/banners/multi-tenant-crm.svg') ?>" alt="Cover: multi-tenant SaaS architecture in Laravel" width="1600" height="900" fetchpriority="high"></div><!-- SWAP COVER 1600x900 · DYNAMIC: $article->cover, $article->cover_alt -->
 <div class="alay">
  <aside class="toc" aria-label="On this page"><div class="rt"><span>On this page</span><span id="pct">0%</span></div><div class="bar"><i id="tbar"></i></div><ol><li class="l2"><a href="#what-is-multi-tenancy">What Multi-Tenancy Means (and What It Doesn’t)</a></li><li class="l2"><a href="#choosing-a-database-strategy">Choosing a Database Strategy</a></li><li class="l3"><a href="#single-database">Single database with a tenant_id column</a></li><li class="l3"><a href="#database-per-tenant">Database per tenant</a></li><li class="l2"><a href="#identifying-the-tenant">Identifying the Current Tenant</a></li><li class="l2"><a href="#scoping-queries">Scoping Queries So Data Never Leaks</a></li><li class="l3"><a href="#where-scopes-dont-reach">Where global scopes don’t reach</a></li><li class="l2"><a href="#authentication-and-roles">Authentication, Users and Roles</a></li><li class="l2"><a href="#queues-cache-storage">Queues, Cache and File Storage</a></li><li class="l3"><a href="#tenant-aware-jobs">Tenant-aware jobs</a></li><li class="l3"><a href="#cache-and-files">Cache keys and file paths</a></li><li class="l2"><a href="#migrations-and-onboarding">Migrations and Tenant Onboarding</a></li><li class="l2"><a href="#common-pitfalls">Common Pitfalls and How to Avoid Them</a></li><li class="l2"><a href="#billing-and-plans">Plans, Limits and Billing per Tenant</a></li><li class="l2"><a href="#testing-tenant-isolation">Testing Tenant Isolation</a></li><li class="l2"><a href="#performance-and-scaling">Performance and Scaling</a></li><li class="l2"><a href="#build-or-use-a-package">Build It Yourself or Use a Package?</a></li><li class="l2"><a href="#conclusion">Conclusion</a></li><li class="l2"><a href="#faq">FAQ</a></li></ol></aside><!-- DYNAMIC: $article->toc -->
  <div class="mtoc"><details><summary>On this page <span id="mcur">Introduction</span></summary><ol><li class="l2"><a href="#what-is-multi-tenancy">What Multi-Tenancy Means (and What It Doesn’t)</a></li><li class="l2"><a href="#choosing-a-database-strategy">Choosing a Database Strategy</a></li><li class="l3"><a href="#single-database">Single database with a tenant_id column</a></li><li class="l3"><a href="#database-per-tenant">Database per tenant</a></li><li class="l2"><a href="#identifying-the-tenant">Identifying the Current Tenant</a></li><li class="l2"><a href="#scoping-queries">Scoping Queries So Data Never Leaks</a></li><li class="l3"><a href="#where-scopes-dont-reach">Where global scopes don’t reach</a></li><li class="l2"><a href="#authentication-and-roles">Authentication, Users and Roles</a></li><li class="l2"><a href="#queues-cache-storage">Queues, Cache and File Storage</a></li><li class="l3"><a href="#tenant-aware-jobs">Tenant-aware jobs</a></li><li class="l3"><a href="#cache-and-files">Cache keys and file paths</a></li><li class="l2"><a href="#migrations-and-onboarding">Migrations and Tenant Onboarding</a></li><li class="l2"><a href="#common-pitfalls">Common Pitfalls and How to Avoid Them</a></li><li class="l2"><a href="#billing-and-plans">Plans, Limits and Billing per Tenant</a></li><li class="l2"><a href="#testing-tenant-isolation">Testing Tenant Isolation</a></li><li class="l2"><a href="#performance-and-scaling">Performance and Scaling</a></li><li class="l2"><a href="#build-or-use-a-package">Build It Yourself or Use a Package?</a></li><li class="l2"><a href="#conclusion">Conclusion</a></li><li class="l2"><a href="#faq">FAQ</a></li></ol></details></div>
  <article class="prose" id="content">
   <!-- DYNAMIC: {!! $article->body_html !!} START -->
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
<p>Whatever you choose, resolve the tenant in one middleware and store it in a single, request-scoped place. Do not let controllers parse hostnames themselves.</p>
<figure class="code"><div class="ch"><span class="lang">php</span><span class="fn">app/Http/Middleware/IdentifyTenant.php</span><button class="cp" type="button">Copy</button></div><pre><code><span class="k">class</span> IdentifyTenant
{
    <span class="k">public</span> <span class="k">function</span> handle(Request <span class="v">$request</span>, Closure <span class="v">$next</span>)
    {
        <span class="v">$host</span> = <span class="v">$request</span>-&gt;getHost();

        <span class="v">$tenant</span> = Tenant::query()
            -&gt;whereHas(<span class="s">'domains'</span>, <span class="k">fn</span> (<span class="v">$q</span>) =&gt; <span class="v">$q</span>-&gt;where(<span class="s">'domain'</span>, <span class="v">$host</span>))
            -&gt;firstOrFail();

        app()-&gt;instance(Tenant::<span class="k">class</span>, <span class="v">$tenant</span>);   <span class="c">// the single source of truth</span>
        URL::defaults([<span class="s">'tenant'</span> =&gt; <span class="v">$tenant</span>-&gt;slug]);

        <span class="k">return</span> <span class="v">$next</span>(<span class="v">$request</span>);
    }
}</code></pre></figure>
<p>Binding the tenant into the container means any service can type-hint <code>Tenant $tenant</code> and receive the current one. Cache the domain lookup, since this runs on every request.</p>
<aside class="cl warn"><b>Warning</b><p>Never trust a <code>tenant_id</code> sent from the browser in a form or query string. Always derive the tenant from the domain or the authenticated token on the server, then verify the user actually belongs to it.</p></aside>
<h2 id="scoping-queries">Scoping Queries So Data Never Leaks</h2>
<p>In a shared-database setup, the safest approach is to make tenant filtering automatic rather than something every developer must remember. Laravel’s global scopes and model events do exactly that.</p>
<div class="stepbox"><div class="st"><span>1</span><div><b>Create a global scope</b><p>Add <code>where tenant_id = ?</code> to every query on tenant-owned models.</p></div></div><div class="st"><span>2</span><div><b>Fill tenant_id on create</b><p>Set the column automatically in the <code>creating</code> event.</p></div></div><div class="st"><span>3</span><div><b>Wrap it in a trait</b><p>Every tenant-owned model uses <code>BelongsToTenant</code>, nothing else.</p></div></div></div>
<figure class="code"><div class="ch"><span class="lang">php</span><span class="fn">app/Models/Concerns/BelongsToTenant.php</span><button class="cp" type="button">Copy</button></div><pre><code>trait BelongsToTenant
{
    <span class="k">protected</span> <span class="k">static</span> <span class="k">function</span> bootBelongsToTenant(): void
    {
        <span class="k">static</span>::addGlobalScope(<span class="s">'tenant'</span>, <span class="k">function</span> (Builder <span class="v">$query</span>) {
            <span class="k">if</span> (<span class="v">$tenant</span> = app()-&gt;has(Tenant::<span class="k">class</span>) ? app(Tenant::<span class="k">class</span>) : <span class="k">null</span>) {
                <span class="v">$query</span>-&gt;where(<span class="v">$query</span>-&gt;qualifyColumn(<span class="s">'tenant_id'</span>), <span class="v">$tenant</span>-&gt;id);
            }
        });

        <span class="k">static</span>::creating(<span class="k">function</span> (Model <span class="v">$model</span>) {
            <span class="v">$model</span>-&gt;tenant_id ??= app(Tenant::<span class="k">class</span>)-&gt;id;
        });
    }

    <span class="k">public</span> <span class="k">function</span> tenant(): BelongsTo
    {
        <span class="k">return</span> <span class="v">$this</span>-&gt;belongsTo(Tenant::<span class="k">class</span>);
    }
}</code></pre></figure>
<p>Using <code>qualifyColumn()</code> matters: without it, joins between two tenant-aware tables produce an ambiguous <code>tenant_id</code> column error. Then each model opts in with a single line:</p>
<figure class="code"><div class="ch"><span class="lang">php</span><span class="fn">app/Models/Invoice.php</span><button class="cp" type="button">Copy</button></div><pre><code><span class="k">class</span> Invoice <span class="k">extends</span> Model
{
    <span class="k">use</span> BelongsToTenant;
}</code></pre></figure>
<h3 id="where-scopes-dont-reach">Where global scopes don’t reach</h3>
<p>Global scopes only protect Eloquent. They do <strong>not</strong> apply to raw <code>DB::table()</code> queries, to <code>DB::select()</code>, or to validation rules like <code>exists:invoices,id</code> and <code>unique:invoices,number</code>. Those need explicit tenant conditions:</p>
<figure class="code"><div class="ch"><span class="lang">php</span><span class="fn">InvoiceController@store</span><button class="cp" type="button">Copy</button></div><pre><code><span class="v">$request</span>-&gt;validate([
    <span class="s">'number'</span> =&gt; [
        <span class="s">'required'</span>,
        Rule::unique(<span class="s">'invoices'</span>)-&gt;where(<span class="s">'tenant_id'</span>, <span class="v">$tenant</span>-&gt;id),
    ],
    <span class="s">'customer_id'</span> =&gt; [
        <span class="s">'required'</span>,
        Rule::exists(<span class="s">'customers'</span>, <span class="s">'id'</span>)-&gt;where(<span class="s">'tenant_id'</span>, <span class="v">$tenant</span>-&gt;id),
    ],
]);</code></pre></figure>
<p>Route model binding is another subtle spot. If the global scope is registered, <code>/invoices/{invoice}</code> already returns a 404 for another tenant’s ID. But if a model is resolved before the tenant middleware runs, the scope is not yet active. Make sure <code>IdentifyTenant</code> runs before <code>SubstituteBindings</code> in your middleware priority.</p>
<div class="take"><b>Key takeaway</b><p>Make isolation the default. A global scope plus a creating hook means a developer has to go out of their way to break tenancy, instead of having to remember to enforce it.</p></div>
<div class="mcta"><div><b>Planning a multi-tenant SaaS?</b><p>Get a second opinion on your architecture before the database design is locked in.</p></div><a class="btn o" href="<?= base_url('/#contact') ?>">Book a free consultation →</a></div><!-- DYNAMIC: $article->mid_cta -->
<h2 id="authentication-and-roles">Authentication, Users and Roles</h2>
<p>Decide early whether users are global (one login across tenants) or tenant-local (the same email can register separately in two tenants). Global users with a pivot are friendlier for people who work across organisations; tenant-local users are simpler and match the database-per-tenant model naturally.</p>
<p>For permissions, packages such as <code>spatie/laravel-permission</code> support a “teams” mode where roles are scoped per team, which maps neatly onto tenants. Whatever tool you use, authorisation policies should check two things: that the record belongs to the current tenant, and that the user’s role in that tenant allows the action.</p>
<figure class="code"><div class="ch"><span class="lang">php</span><span class="fn">app/Policies/InvoicePolicy.php</span><button class="cp" type="button">Copy</button></div><pre><code><span class="k">public</span> <span class="k">function</span> update(User <span class="v">$user</span>, Invoice <span class="v">$invoice</span>): bool
{
    <span class="k">return</span> <span class="v">$invoice</span>-&gt;tenant_id === app(Tenant::<span class="k">class</span>)-&gt;id
        &amp;&amp; <span class="v">$user</span>-&gt;hasTenantPermission(<span class="s">'invoices.update'</span>);
}</code></pre></figure>
<p>The first condition looks redundant when a global scope exists, but policies are a good second line of defence, especially for code paths that bypass the scope.</p>
<h2 id="queues-cache-storage">Queues, Cache and File Storage</h2>
<p>Tenancy is easy to get right in HTTP requests and easy to forget everywhere else. Background jobs, cached values and uploaded files all run outside the request that resolved the tenant.</p>
<h3 id="tenant-aware-jobs">Tenant-aware jobs</h3>
<p>A queued job runs in a fresh worker process with no current tenant. Serialise the tenant ID with the job and restore it before doing any work:</p>
<figure class="code"><div class="ch"><span class="lang">php</span><span class="fn">app/Jobs/GenerateMonthlyReport.php</span><button class="cp" type="button">Copy</button></div><pre><code><span class="k">class</span> GenerateMonthlyReport <span class="k">implements</span> ShouldQueue
{
    <span class="k">use</span> Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    <span class="k">public</span> <span class="k">function</span> __construct(<span class="k">public</span> int <span class="v">$tenantId</span>) {}

    <span class="k">public</span> <span class="k">function</span> handle(TenantManager <span class="v">$tenancy</span>): void
    {
        <span class="v">$tenancy</span>-&gt;run(<span class="v">$this</span>-&gt;tenantId, <span class="k">function</span> () {
            <span class="c">// every query in here is scoped to the tenant</span>
            Report::buildFor(now()-&gt;subMonth());
        });
    }
}</code></pre></figure>
<p>A <code>run()</code> helper that sets the tenant, executes a callback and then resets state is worth building early. It is also what you use in scheduled commands that loop over all tenants.</p>
<h3 id="cache-and-files">Cache keys and file paths</h3>
<p>Prefix every cache key and storage path with the tenant. Otherwise a cached “dashboard stats” value computed for one tenant will be served to the next one who asks.</p>
<figure class="code"><div class="ch"><span class="lang">php</span><span class="fn">Example</span><button class="cp" type="button">Copy</button></div><pre><code><span class="v">$stats</span> = Cache::remember(<span class="s">"tenant:{$tenant-&gt;id}:dashboard"</span>, 300, <span class="k">fn</span> () =&gt;
    Invoice::selectRaw(<span class="s">'count(*) as total, sum(total) as revenue'</span>)-&gt;first()
);

<span class="v">$path</span> = <span class="v">$request</span>-&gt;file(<span class="s">'logo'</span>)-&gt;store(<span class="s">"tenants/{$tenant-&gt;id}/branding"</span>, <span class="s">'s3'</span>);</code></pre></figure>
<aside class="cl note"><b>Note</b><p>If you use Redis cache tags or a separate Redis database per tenant, flushing one tenant’s cache becomes a single operation, which is handy when a tenant is deleted or migrated.</p></aside>
<h2 id="migrations-and-onboarding">Migrations and Tenant Onboarding</h2>
<p>In a shared database, migrations are ordinary. With database-per-tenant, split migrations into two folders: <code>database/migrations/landlord</code> for central tables and <code>database/migrations/tenant</code> for tenant tables, and write a command that runs the tenant set across every database.</p>
<figure class="code"><div class="ch"><span class="lang">bash</span><span class="fn">terminal</span><button class="cp" type="button">Copy</button></div><pre><code><span class="c"># central tables (tenants, domains, plans)</span>
<span class="k">php</span> <span class="k">artisan</span> migrate --path=database/migrations/landlord

<span class="c"># every tenant database, one at a time</span>
<span class="k">php</span> <span class="k">artisan</span> tenants:migrate --force</code></pre></figure>
<p>Onboarding should be a single, idempotent action: create the tenant record, attach the domain, create (or allocate) the database, run tenant migrations, seed default roles and settings, and invite the first admin. Run it as a queued job and show progress in the UI, because creating a database can take a few seconds.</p>
<figure class="img"><img src="<?= asset_url('images/banners/multi-tenant-crm.svg') ?>" alt="Diagram placeholder: tenant onboarding flow from signup to first login" loading="lazy" width="1600" height="900"><!-- SWAP IMAGE --><figcaption>Placeholder figure: a typical onboarding pipeline (signup → tenant record → database → migrations → seed → invite).</figcaption></figure>
<h2 id="common-pitfalls">Common Pitfalls and How to Avoid Them</h2>
<p>Most multi-tenant bugs are not exotic. They are the same handful of mistakes repeated across projects:</p>
<ul><li><strong>Raw queries without tenant filters.</strong> Search the codebase for <code>DB::table</code> and <code>DB::select</code> regularly, and review each one.</li><li><strong>Global unique constraints.</strong> An email or invoice number that is unique across all tenants blocks legitimate data. Make uniqueness composite with <code>tenant_id</code>.</li><li><strong>Jobs and commands without tenant context.</strong> Anything running outside HTTP must set the tenant explicitly.</li><li><strong>Shared cache keys.</strong> Prefix everything.</li><li><strong>Admin panels that bypass scopes.</strong> Super-admin tooling often uses <code>withoutGlobalScopes()</code>; keep it in a separate, heavily guarded area of the app.</li><li><strong>Leaky exports and reports.</strong> CSV exports and scheduled emails are a frequent source of cross-tenant leaks because they run in the background.</li></ul>
<blockquote><p>Treat every cross-tenant data leak as a security incident, not a bug. Your customers will.</p></blockquote>
<h2 id="billing-and-plans">Plans, Limits and Billing per Tenant</h2>
<p>Subscriptions belong to the tenant, not the user. Attach the billable entity (for example with Laravel Cashier on the <code>Tenant</code> model) and store plan limits such as seats, storage or monthly records in a <code>plans</code> table rather than hard-coding them. Enforce limits in one place, for instance a <code>TenantLimits</code> service that policies and form requests call, so that upgrading a plan instantly changes behaviour everywhere.</p>
<p>Feature flags work the same way: a small <code>tenant_features</code> table or a package such as Laravel Pennant scoped to the tenant lets you roll out new modules to selected customers first, which is far safer than shipping a change to every tenant at once.</p>
<h2 id="testing-tenant-isolation">Testing Tenant Isolation</h2>
<p>Isolation deserves its own tests, separate from feature tests. The pattern is simple: create two tenants with data, act as a user of the first, and assert that nothing from the second is ever visible or writable.</p>
<figure class="code"><div class="ch"><span class="lang">php</span><span class="fn">tests/Feature/TenantIsolationTest.php</span><button class="cp" type="button">Copy</button></div><pre><code>it(<span class="s">'never shows another tenant\'s invoices'</span>, <span class="k">function</span> () {
    [<span class="v">$a</span>, <span class="v">$b</span>] = Tenant::factory()-&gt;count(2)-&gt;create();
    Invoice::factory()-&gt;for(<span class="v">$b</span>)-&gt;create([<span class="s">'number'</span> =&gt; <span class="s">'B-001'</span>]);

    actingAsTenantUser(<span class="v">$a</span>)
        -&gt;get(<span class="s">'/invoices'</span>)
        -&gt;assertOk()
        -&gt;assertDontSee(<span class="s">'B-001'</span>);
});</code></pre></figure>
<p>Add similar tests for route model binding (expect a 404 for another tenant’s ID), validation rules, exports and queued jobs. These tests are cheap and catch the regressions that matter most.</p>
<h2 id="performance-and-scaling">Performance and Scaling</h2>
<p>With a <code>tenant_id</code> column, performance mostly comes down to indexing: put <code>tenant_id</code> first in composite indexes used by list pages and reports, and watch for large tenants that dominate table size. PostgreSQL partitioning by tenant or table-level row-level security are options once tables grow very large.</p>
<p>With database-per-tenant, watch connection counts. A connection pooler such as PgBouncer (or ProxySQL for MySQL) helps, and you can shard tenants across several database servers by storing the host on the tenant record. In both models, rate-limit per tenant rather than per IP, so one busy customer cannot starve everyone else.</p>
<div class="take"><b>Key takeaway</b><p>Index for the tenant first, isolate the noisy ones, and limit by tenant. Scaling multi-tenant apps is mostly about preventing one customer from affecting the rest.</p></div>
<h2 id="build-or-use-a-package">Build It Yourself or Use a Package?</h2>
<p>Mature packages such as <code>stancl/tenancy</code> and <code>spatie/laravel-multitenancy</code> handle tenant identification, database switching, and tenant-aware queues, cache and storage. They save weeks of work and encode lessons the community has already learned. Building your own makes sense when your model is simple (a single database with a global scope may be a hundred lines of code) or when you need unusual behaviour the packages don’t support.</p>
<p>A sensible rule: for a shared database, a small in-house trait and middleware is often enough; for database-per-tenant, start with a package unless you have a strong reason not to.</p>
<h2 id="conclusion">Conclusion</h2>
<p>A good multi-tenant Laravel application is built on a few deliberate choices: a clear definition of the tenant, a database strategy matched to your customers, one place that resolves the current tenant, automatic query scoping, and tenant context carried into jobs, cache and files. Get those right and tests to prove isolation, and the rest of the product can be built like any other Laravel app.</p>
<p>If you are early, start simple with a shared database and a global scope, and keep the door open to dedicated databases for the customers who need them.</p>
   <!-- DYNAMIC: body END -->
   <div class="tags" aria-label="Tags"><a href="javascript:void(0)">#Laravel</a><a href="javascript:void(0)">#Multi-Tenancy</a><a href="javascript:void(0)">#SaaS Architecture</a><a href="javascript:void(0)">#Database Design</a><a href="javascript:void(0)">#Eloquent</a><a href="javascript:void(0)">#Security</a></div><!-- DYNAMIC: $article->tags[] -->
   <section class="abio" aria-label="About the author"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="Amaanullah Khan" loading="lazy" width="76" height="76"><!-- SWAP AVATAR --><div><small>Written by</small><h3>Amaanullah Khan</h3><p>PHP &amp; Laravel developer in Karachi building custom CRM, SaaS and enterprise web apps, plus Flutter mobile apps.</p><div class="lk"><a href="<?= base_url('/about') ?>">About me →</a><a href="<?= base_url('/projects') ?>">See projects →</a></div></div></section><!-- DYNAMIC: $article->author -->
   <section class="afaq" id="faq" aria-labelledby="h-faq"><h2 id="h-faq">Frequently Asked Questions</h2><details class="fq"><summary>Which database strategy is best for a new Laravel SaaS?<span class="pm" aria-hidden="true"></span></summary><div><p>For most new products, a single database with a tenant_id column is the simplest and cheapest to run. Move to schema- or database-per-tenant when customers require stronger isolation, data residency or individual backups.</p></div></details><details class="fq"><summary>Do global scopes protect raw DB queries?<span class="pm" aria-hidden="true"></span></summary><div><p>No. Global scopes only apply to Eloquent queries. Raw DB::table() and DB::select() calls, and validation rules such as unique and exists, need explicit tenant conditions.</p></div></details><details class="fq"><summary>How do queued jobs know which tenant they belong to?<span class="pm" aria-hidden="true"></span></summary><div><p>Pass the tenant ID into the job, then restore the tenant context at the start of handle() before running any queries.</p></div></details><details class="fq"><summary>Should I use stancl/tenancy or build my own?<span class="pm" aria-hidden="true"></span></summary><div><p>For database-per-tenant setups a package usually saves significant time. For a simple shared-database model, a small trait and middleware may be all you need.</p></div></details></section><!-- DYNAMIC: $article->faqs[] -->
   <section class="news" aria-labelledby="h-news"><div><h2 id="h-news">Get new articles in your inbox</h2><p>Practical Laravel, SaaS and architecture notes. No spam.</p></div><form onsubmit="event.preventDefault();this.querySelector('button').textContent='Subscribed ✓'"><label class="sr" for="em" style="position:absolute;left:-9999px">Email</label><input id="em" type="email" placeholder="you@company.com" required><button class="btn o" type="submit">Subscribe</button></form></section><!-- DYNAMIC: newsletter form action -->
  </article>
  <aside class="rail" aria-label="Share"><div class="shr" aria-label="Share this article"><!-- DYNAMIC: share URLs use url()->current() + $article->title --><button type="button" class="copyl" aria-label="Copy link"><svg viewBox="0 0 24 24"><path d="M10.6 13.4a1 1 0 0 1 0-1.4l3.5-3.5a1 1 0 1 1 1.4 1.4L12 13.4a1 1 0 0 1-1.4 0zM8.5 20a5.5 5.5 0 0 1-3.9-9.4l2-2 1.4 1.4-2 2a3.5 3.5 0 0 0 5 5l2-2 1.4 1.4-2 2A5.5 5.5 0 0 1 8.5 20zm9-7-1.4-1.4 2-2a3.5 3.5 0 0 0-5-5l-2 2L9.7 5.2l2-2A5.5 5.5 0 0 1 19.5 11z"/></svg></button><a href="https://www.linkedin.com/sharing/share-offsite/?url=https%3A%2F%2F%5Byour-domain%5D%2Farticles%2Flaravel%2Fmulti-tenant-saas-laravel" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><svg viewBox="0 0 24 24"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM9 9h3.8v1.7h.05c.53-1 1.83-2.05 3.77-2.05 4.03 0 4.78 2.65 4.78 6.1V21h-4v-5.5c0-1.3-.02-3-1.83-3-1.83 0-2.1 1.43-2.1 2.9V21H9z"/></svg></a><a href="https://twitter.com/intent/tweet?url=https%3A%2F%2F%5Byour-domain%5D%2Farticles%2Flaravel%2Fmulti-tenant-saas-laravel&amp;text=How%20to%20Build%20a%20Multi-Tenant%20SaaS%20in%20Laravel%3A%20Architecture%2C%20Database%20Strategy%20and%20Pitfalls" target="_blank" rel="noopener" aria-label="Share on X"><svg viewBox="0 0 24 24"><path d="M17.8 3h3.3l-7.2 8.2L22.4 21h-6.6l-5.2-6.8L4.7 21H1.4l7.7-8.8L1 3h6.8l4.7 6.2zm-1.2 16h1.8L7.5 4.9H5.6z"/></svg></a><a href="https://wa.me/?text=How%20to%20Build%20a%20Multi-Tenant%20SaaS%20in%20Laravel%3A%20Architecture%2C%20Database%20Strategy%20and%20Pitfalls%20https%3A%2F%2F%5Byour-domain%5D%2Farticles%2Flaravel%2Fmulti-tenant-saas-laravel" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2zm5.3 13.9c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.5-3.9-4.7-4.1-.1-.2-1.1-1.5-1.1-2.9s.7-2.1 1-2.4c.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .6l-.4.6-.4.4c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.3 2.4 1.5.3.1.5.1.6-.1l.9-1c.2-.3.4-.2.6-.1l2 1c.3.1.5.2.5.3.1.2.1.7-.1 1.3z"/></svg></a></div></aside>
 </div>
 <nav class="pn" style="margin-top:70px" aria-label="More articles"><a href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>"><small>← Previous article</small><b><span class="ph">[Previous article title]</span></b></a><!-- DYNAMIC: $prev --><a href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>"><small>Next article →</small><b><span class="ph">[Next article title]</span></b></a><!-- DYNAMIC: $next --></nav>
 <section class="rel" aria-labelledby="h-rel"><p class="eyb">Keep reading</p><h2 id="h-rel">Related Articles</h2><!-- DYNAMIC: $related (3) -->
  <div class="rgrid"><a class="rc ra" href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>"><img src="<?= asset_url('images/banners/hrm-payroll.svg') ?>" alt="Designing Role-Based Permissions for SaaS Teams cover" loading="lazy" width="1600" height="900"><div><small>Laravel</small><h3>Designing Role-Based Permissions for SaaS Teams</h3><p>[Related article excerpt — 1–2 lines]</p></div></a><a class="rc ra" href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>"><img src="<?= asset_url('images/banners/chatrox.svg') ?>" alt="Custom Software vs SaaS: When Building Your Own Pays Off cover" loading="lazy" width="1600" height="900"><div><small>Architecture</small><h3>Custom Software vs SaaS: When Building Your Own Pays Off</h3><p>[Related article excerpt — 1–2 lines]</p></div></a><a class="rc ra" href="<?= base_url('/articles/multi-tenant-saas-laravel') ?>"><img src="<?= asset_url('images/banners/ticketing-crm.svg') ?>" alt="Real-Time Features in Laravel with WebSockets cover" loading="lazy" width="1600" height="900"><div><small>Real-time</small><h3>Real-Time Features in Laravel with WebSockets</h3><p>[Related article excerpt — 1–2 lines]</p></div></a></div></section>
 <section class="cta"><div><h2>Building a SaaS or custom platform?</h2><p>Let’s talk about architecture, timelines and the right stack for your product.</p></div><a class="btn" href="<?= base_url('/#contact') ?>">Start a project →</a></section>
</div>
</main>
<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/article.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script src="<?= asset_url('js/chatbot-config.js') ?>"></script><!-- EDIT: chatbot config -->
<script src="<?= asset_url('js/chatbot.js') ?>" defer></script>
</body></html>