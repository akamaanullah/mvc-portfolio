<!DOCTYPE html>
<html lang="en">
<head>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<!--
  SERVICE DETAIL TEMPLATE — Blade: resources/views/services/show.blade.php
  Route: /services/{service:slug} -> ServiceController@show
  Slots are marked "DYNAMIC: $service->field"; lists loop with @foreach. TOC built only from sections that have content.
  CONTENT: Performance Tuning, generic copy + services-page card wording. [EDIT ...] items are placeholders.
-->
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Website &amp; Laravel Performance Tuning and Security Audit | Amaanullah Khan</title><!-- DYNAMIC: $service->seo_title -->
<meta name="description" content="Performance tuning for slow sites, unpredictable downtime and security gaps: I audit your setup, find what is causing the slowdown and fix it, without a rebuild unless needed."><!-- DYNAMIC: $service->meta_description -->
<link rel="canonical" href="https://amaanullah.com/services/performance-tuning"><!-- DYNAMIC: url()->current() -->
<meta property="og:type" content="website"><meta property="og:title" content="Fix the Slowdown Without a Full Rebuild"><meta property="og:description" content="Audit the setup, find what is actually causing the slowdown, and fix it."><meta property="og:image" content="https://amaanullah.com/images/services/performance-tuning.webp"><meta property="og:url" content="https://amaanullah.com/services/performance-tuning">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="<?= asset_url('logo-v2/favicon-32.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [{"@type": "ListItem", "position": 1, "name": "Home", "item": "https://amaanullah.com/index.html"}, {"@type": "ListItem", "position": 2, "name": "Services", "item": "https://amaanullah.com/services-page.html"}, {"@type": "ListItem", "position": 3, "name": "Performance Tuning", "item": "https://amaanullah.com/services/performance-tuning"}]}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "Service", "name": "Performance Tuning", "serviceType": "Performance Tuning", "url": "https://amaanullah.com/services/performance-tuning", "description": "Performance and security tuning for slow sites and applications: audit the current setup, find the real cause of slowdowns and fix it without a full rebuild unless one is genuinely needed.", "provider": {"@type": "Person", "name": "Amaanullah Khan", "jobTitle": "PHP & Laravel Developer", "address": {"@type": "PostalAddress", "addressLocality": "Karachi", "addressCountry": "PK"}}, "areaServed": ["Pakistan", "United States", "United Kingdom", "United Arab Emirates"]}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "Do I need a full rebuild to fix a slow site?", "acceptedAnswer": {"@type": "Answer", "text": "Usually not. Most slowdowns come from specific bottlenecks that can be fixed in place. If a rebuild really is needed, I’ll explain why."}}, {"@type": "Question", "name": "Do you also check security?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. Security gaps such as outdated packages, weak access controls and exposed settings are reviewed as part of the audit."}}]}</script><!-- DYNAMIC: JSON-LD via json_encode() in controller; FAQPage only for answered FAQs -->
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
<div class="wrap">
 <nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/services') ?>">Services</a></li><li aria-current="page">Performance Tuning</li></ol></nav><!-- DYNAMIC: $service->title -->
 <section class="hero2">
  <div>
   <div class="badges"><span class="bdg">Service</span><span class="bdg l"><i></i>Speed · Security Audit</span></div><!-- DYNAMIC: $service->tags -->
   <h1>Performance Tuning That Fixes <em>What’s Actually Slowing You Down</em></h1><!-- DYNAMIC: $service->title / headline -->
   <p class="sum">A slow site, unpredictable downtime or security gaps? I audit the current setup, flag what’s actually causing the slowdown, and fix it, without a full rebuild unless one is genuinely needed.</p><!-- DYNAMIC: $service->summary -->
   <div class="hcta"><a class="btn o" href="<?= base_url('/contact') ?>">Request a performance review →</a><a class="btn gh" href="#proof">See related work</a></div><!-- DYNAMIC: route('contact', ['service'=>$service->slug]) -->
   <div class="hst"><div><b>1.5M+</b><span>leads in my production CRM</span></div><div><b>300+</b><span>concurrent daily users</span></div><div><b>4.8★</b><span>Google rating (27 reviews)</span></div></div><!-- DYNAMIC: $service->stats[] (figures from live page; keep in sync) -->
   <p class="sm" style="margin-top:16px;color:var(--mu)">Based in Karachi, working with businesses across Pakistan, the US, UK and UAE.</p>
  </div>
  <figure class="slot" aria-label="Performance monitoring illustration"><span class="sw">SWAP: service banner</span>
 <div class="tb"><i></i><i></i><i></i></div><h4>Response time · live</h4>
 <div class="kb"><div class="col"><small>Audit</small><div class="cd o mv"></div><div class="cd"></div><div class="cd"></div></div><div class="col"><small>Diagnose</small><div class="cd"></div><div class="cd"></div></div><div class="col"><small>Fix</small><div class="cd"></div></div><div class="col"><small>Verify</small><div class="cd"></div></div></div>
 <div class="bars" aria-hidden="true"><i style="height:60%"></i><i style="height:85%"></i><i style="height:45%"></i><i style="height:100%"></i><i style="height:70%"></i><i style="height:90%"></i></div>
</figure><!-- SWAP BANNER: replace with <img src="{{ asset($service->banner) }}" alt="{{ $service->banner_alt }}" width="1600" height="1300"> (keep the figure size) -->
 </section>
 <div class="layout">
  <aside class="toc" aria-label="On this page"><div class="rt"><span>On this page</span><span id="pct">0%</span></div><div class="bar"><i id="tbar"></i></div><ol><li><a href="#why">Why it’s slow</a></li><li><a href="#compare">Tuning vs rebuilding</a></li><li><a href="#build">What I fix</a></li><li><a href="#who">Who it’s for</a></li><li><a href="#process">How it runs</a></li><li><a href="#stack">Tech covered</a></li><li><a href="#proof">Related work</a></li><li><a href="#faq">FAQ</a></li></ol>
   <div class="share">Need this?<br><a href="<?= base_url('/contact') ?>">Get a quote →</a></div></aside>
  <div class="mtoc"><details><summary>On this page <span id="mcur">Why it’s slow</span></summary><ol><li><a href="#why">Why it’s slow</a></li><li><a href="#compare">Tuning vs rebuilding</a></li><li><a href="#build">What I fix</a></li><li><a href="#who">Who it’s for</a></li><li><a href="#process">How it runs</a></li><li><a href="#stack">Tech covered</a></li><li><a href="#proof">Related work</a></li><li><a href="#faq">FAQ</a></li></ol></details></div>
  <article class="content" id="content">

<section class="sec rv" id="why" aria-labelledby="h-why">
 <p class="eyb"><span>01 · Why it’s slow</span></p>
 <!-- DYNAMIC: $service->intro (rich text) -->
 <h2 id="h-why">Why Sites and Apps Slow Down, and Why a Rebuild Is Rarely the First Answer</h2>
 
 <p class="lead">Most slowdowns come from a few specific causes: heavy database queries, missing indexes or caching, oversized assets, or a server that was never configured for the current traffic.</p>
 <p>Performance tuning starts with measurement. I audit the current setup, find the bottlenecks that actually matter, and fix them in place, along with the security gaps that often show up in the same review.</p>
 <aside class="pull"><p>Honest note: sometimes a rebuild really is the right call. If so, I’ll tell you why, rather than patching something that can’t be saved.</p></aside>
 <p>Not sure where the problem is? Start with a <a class="il" href="<?= base_url('/services/free-technical-audit') ?>">Free Technical Audit</a>.</p>
</section>

<section class="sec rv" id="compare" aria-labelledby="h-compare">
 <p class="eyb"><span>02 · Comparison</span></p>
 <!-- DYNAMIC: $service->comparison[] (feature, off_the_shelf, custom) -->
 <h2 id="h-compare">Targeted Tuning vs a Full Rebuild at a Glance</h2>
 
 <p>The short version, side by side.</p>
 <div class="tbl" role="region" aria-label="Comparison table" tabindex="0"><table><thead><tr><th scope="col">Feature</th><th scope="col">Full rebuild<small>start from scratch</small></th><th scope="col" class="us">Targeted tuning<small>fix what matters</small></th></tr></thead><tbody><tr><th scope="row">Cost</th><td data-l="Full rebuild">High</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Focused on the real bottlenecks</td></tr><tr><th scope="row">Time to results</th><td data-l="Full rebuild">Long</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Improvements as each fix ships</td></tr><tr><th scope="row">Risk</th><td data-l="Full rebuild">New code, new bugs</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Existing system kept stable</td></tr><tr><th scope="row">Disruption</th><td data-l="Full rebuild">Migration and retraining</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Users keep working as normal</td></tr><tr><th scope="row">Security</th><td data-l="Full rebuild">Depends on the new build</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Gaps found and fixed during the audit</td></tr><tr><th scope="row">When it fits</th><td data-l="Full rebuild">The foundation can’t be saved</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Most slow or unstable systems</td></tr></tbody></table></div>
</section>

<section class="sec rv" id="build" aria-labelledby="h-build">
 <p class="eyb"><span>03 · What I fix</span></p>
 <!-- DYNAMIC: $service->features[] (icon, title, text), $service->benefits[] -->
 <h2 id="h-build">What I Fix</h2>
 
 <p>Every audit is different, but these are the areas I improve most often.</p>
 <div class="fgrid"><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 5h18l-7 8v6l-4-2v-4z"/></svg></span><h3>Database Queries &amp; Indexes</h3><p>Slow queries found and optimised, with the right indexes added.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="5" height="16" rx="1.5"/><rect x="10" y="4" width="5" height="11" rx="1.5"/><rect x="17" y="4" width="4" height="7" rx="1.5"/></svg></span><h3>Caching</h3><p>Caching added where data doesn’t need to be rebuilt on every request.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="2"/><rect x="13" y="3" width="8" height="8" rx="2"/><rect x="3" y="13" width="8" height="8" rx="2"/><rect x="13" y="13" width="8" height="8" rx="2"/></svg></span><h3>Front-End Load Times</h3><p>Oversized images, scripts and styles reduced so pages load faster.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h18v3a2 2 0 0 0 0 4v3H3v-3a2 2 0 0 0 0-4z"/><path d="M13 7v10"/></svg></span><h3>Server &amp; Hosting Setup</h3><p>Configuration reviewed for your actual traffic and workload.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M17 11h5M19.5 8.5v5"/></svg></span><h3>Security Gaps</h3><p>Outdated packages, weak access controls and exposed settings flagged and fixed.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 2v5M15 2v5M6 7h12v4a6 6 0 0 1-12 0zM12 17v5"/></svg></span><h3>Downtime &amp; Stability</h3><p>Causes of crashes and timeouts traced and fixed.</p></article></div>
 <h3 class="h3">Why invest in performance tuning?</h3>
 <div class="why3"><div class="w"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="8" width="16" height="11" rx="3"/><path d="M12 4v4M9 13h.01M15 13h.01"/></svg></span><b>Faster for Users</b><p>Quicker pages and responses for customers and staff.</p></div><div class="w"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 2v5M15 2v5M6 7h12v4a6 6 0 0 1-12 0zM12 17v5"/></svg></span><b>More Stable</b><p>Fewer unexplained outages and timeouts.</p></div><div class="w"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6z"/><path d="m9 12 2 2 4-4"/></svg></span><b>Safer</b><p>Security gaps closed before they become incidents.</p></div></div>
</section>

<section class="sec rv" id="who" aria-labelledby="h-who">
 <p class="eyb"><span>04 · Who it’s for</span></p>
 <!-- DYNAMIC: $service->industries[] (title, text, link) -->
 <h2 id="h-who">Performance Tuning for These Businesses</h2>
 
 <p>Tuning helps any system that has grown faster than its original setup.</p>
 <div class="who"><div class="wc"><span class="wn">01</span><div><b>Growing web apps</b><p>Laravel and PHP apps slowing down as data and users grow.</p></div></div><div class="wc"><span class="wn">02</span><div><b>E-commerce stores</b><p>Product pages and checkout that need to load quickly.</p></div></div><div class="wc"><span class="wn">03</span><div><b>Internal tools &amp; CRMs</b><p>Dashboards and reports that take too long to load.</p></div></div><div class="wc"><span class="wn">04</span><div><b>Sites with downtime</b><p>Systems that crash or time out under load.</p></div></div></div>
 <div class="fit"><div class="y"><b>Good fit if…</b><ul><li>Your site or app has become noticeably slow</li><li>You see unexplained downtime or errors</li><li>You’re worried about security gaps</li><li>You want to avoid an unnecessary rebuild</li></ul></div><div class="n"><b>Probably not yet if…</b><ul><li>The site is already fast and stable</li><li>You’ve already decided to replace the system</li></ul></div></div>
</section>

<section class="sec rv" id="process" aria-labelledby="h-process">
 <p class="eyb"><span>05 · Process</span></p>
 <!-- DYNAMIC: $service->process_steps[] (title, text), $service->timeline_note -->
 <h2 id="h-process">How a Performance Project Runs</h2>
 
 <p>Four steps, starting with measurement rather than guesswork.</p>
 <ol class="tline"><li><span class="sn">01</span><div><b>Audit</b><p>I review the code, database, server and front end to measure where time is lost.</p></div></li><li><span class="sn">02</span><div><b>Diagnosis</b><p>You get a clear list of what’s causing the problem, ordered by impact.</p></div></li><li><span class="sn">03</span><div><b>Fixes</b><p>Changes are applied carefully, highest impact first, without disrupting users.</p></div></li><li><span class="sn">04</span><div><b>Verify &amp; Report</b><p>Results are measured again and documented so you can see what changed.</p></div></li></ol>
 <div class="take"><b>Typical timelines</b><p><span class="ph">[EDIT: typical timeline for an audit and fixes]</span></p></div>
</section>

<section class="sec rv" id="stack" aria-labelledby="h-stack">
 <p class="eyb"><span>06 · Tech covered</span></p>
 <!-- DYNAMIC: $service->tech[] (group, name) -->
 <h2 id="h-stack">Technology I Tune</h2>
 
 <p>Focused on PHP and Laravel systems, the stack I build with every day.</p>
 <div class="tgrid"><div class="tc"><small>Backend</small><b>Laravel &amp; PHP</b></div><div class="tc"><small>Database</small><b>Queries &amp; indexing</b></div><div class="tc"><small>Caching</small><b>Application &amp; query caching</b></div><div class="tc"><small>Front-end</small><b>Asset size &amp; load times</b></div><div class="tc"><small>Security</small><b>Packages, access &amp; configuration</b></div><div class="tc"><small>Hosting</small><b><span class="ph">[EDIT: servers / platforms you support]</span></b></div></div>
</section>

<section class="sec rv" id="proof" aria-labelledby="h-proof">
 <p class="eyb"><span>07 · Proof</span></p>
 <!-- DYNAMIC: $service->proof_text, related projects -->
 <h2 id="h-proof">Related Work</h2>
 
 <p>I build and maintain production systems under real load, including a <a class="il" href="javascript:void(0)">multi-tenant CRM handling 1.5M+ leads</a><!-- DYNAMIC: internal link -> route() --> with <strong>300+ concurrent daily users</strong>. <span class="ph">[EDIT: add a specific before/after tuning result]</span></p>
 <div class="cgrid"><a class="cc" href="javascript:void(0)"><img src="<?= asset_url('images/banners/multi-tenant-crm.svg') ?>" alt="Multi-Tenant CRM case study banner" loading="lazy" width="1600" height="1000"><div><small>Sales &amp; operations platform</small><h3>Multi-Tenant CRM case study</h3><p>1.5M+ leads · 300+ concurrent daily users</p><span>Read case study →</span></div></a><a class="cc" href="javascript:void(0)"><img src="<?= asset_url('images/banners/it-hardware-bin.svg') ?>" alt="IT Hardware Bin case study banner" loading="lazy" width="1600" height="1000"><div><small>B2B e-commerce platform</small><h3>IT Hardware Bin case study</h3><p>2,000+ products</p><span>Read case study →</span></div></a><a class="cc" href="javascript:void(0)"><img src="<?= asset_url('images/banners/ticketing-crm.svg') ?>" alt="Ticketing CRM case study banner" loading="lazy" width="1600" height="1000"><div><small>Job &amp; vendor management</small><h3>Ticketing CRM case study</h3><p>Vendors · SLA · workflows</p><span>Read case study →</span></div></a></div><!-- DYNAMIC: $service->caseStudies (3) -->
 <p class="sm">Looking for a local engagement? See <a class="il" href="<?= base_url('/laravel-developer-karachi') ?>">Laravel developer in Karachi</a> or <a class="il" href="<?= base_url('/full-stack-developer-karachi') ?>">full-stack developer in Karachi</a>.</p>
</section>

<section class="sec rv" id="faq" aria-labelledby="h-faq">
 <p class="eyb"><span>08 · FAQ</span></p>
 <!-- DYNAMIC: $service->faqs[] (q, a)  -- only output FAQPage JSON-LD for answered items -->
 <h2 id="h-faq">Performance Tuning FAQ</h2>
 <details class="fq" open><summary>Do I need a full rebuild to fix a slow site?<span class="pm" aria-hidden="true"></span></summary><div><p>Usually not. Most slowdowns come from specific bottlenecks that can be fixed in place. If a rebuild really is needed, I’ll explain why.</p></div></details><details class="fq"><summary>How much does performance tuning cost?<span class="pm" aria-hidden="true"></span></summary><div><p><span class="ph">[EDIT: answer]</span></p></div></details><details class="fq"><summary>Do you also check security?<span class="pm" aria-hidden="true"></span></summary><div><p>Yes. Security gaps such as outdated packages, weak access controls and exposed settings are reviewed as part of the audit.</p></div></details><details class="fq"><summary>Will my site go offline during the work?<span class="pm" aria-hidden="true"></span></summary><div><p><span class="ph">[EDIT: answer]</span></p></div></details>
</section>
  </article>
 </div>
 <section class="rel" aria-labelledby="h-rs"><p class="eyb">Related services</p><h2 id="h-rs">Services That Pair Well With Performance Tuning</h2><!-- DYNAMIC: $service->related (4) -->
  <div class="rs"><a href="<?= base_url('/services/free-technical-audit') ?>"><b>Free Technical Audit</b><p>A no-cost review of your site, CRM or internal tool.</p><span>Explore →</span></a><a href="<?= base_url('/services/web-app-cms-development') ?>"><b>Web App &amp; CMS Development</b><p>Custom Laravel apps, or Shopify, WordPress and Wix for faster launches.</p><span>Explore →</span></a><a href="<?= base_url('/services/saas-application-development') ?>"><b>SaaS Application Development</b><p>Multi-tenant platforms, portals, billing and REST APIs.</p><span>Explore →</span></a><a href="<?= base_url('/services/custom-crm-development') ?>"><b>Custom CRM Development</b><p>Lead routing, pipelines and multi-tenant CRMs built around how your team sells.</p><span>Explore →</span></a></div></section>
 <section class="cta"><div><h2>Ready to find out what’s slowing you down?</h2><p>Tell me about your site or app and the problems you’re seeing. I’ll reply within 24 hours with next steps.</p></div><div class="bt2"><a class="btn" href="<?= base_url('/contact') ?>">Request a review →</a><a class="btn gw" href="<?= base_url('/projects') ?>">View case studies</a></div></section><!-- DYNAMIC: $service->cta_title, cta_text -->
</div>
</main>
<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/service-detail.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script src="<?= asset_url('js/chatbot-config.js') ?>"></script><!-- EDIT: chatbot config -->
<script src="<?= asset_url('js/chatbot.js') ?>" defer></script>
</body></html>