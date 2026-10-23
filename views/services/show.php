<!DOCTYPE html>
<html lang="en">
<head>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<!--
  SERVICE DETAIL TEMPLATE — Blade: resources/views/services/show.blade.php
  Route: /services/{service:slug} -> ServiceController@show
  Slots are marked "DYNAMIC: $service->field"; lists loop with @foreach. TOC built only from sections that have content.
  SAMPLE CONTENT: Custom CRM Development, curated from the live page. [EDIT ...] items are placeholders.
-->
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Custom CRM Development in Laravel | Amaanullah Khan, Karachi</title><!-- DYNAMIC: $service->seo_title -->
<meta name="description" content="Custom CRM development on Laravel: lead routing, pipeline tracking, multi-tenant access and reporting dashboards built around your actual sales process. Based in Karachi, working worldwide."><!-- DYNAMIC: $service->meta_description -->
<link rel="canonical" href="https://[your-domain]/services/custom-crm-development"><!-- DYNAMIC: url()->current() -->
<meta property="og:type" content="website"><meta property="og:title" content="Custom CRM Development Built Around How Your Team Sells"><meta property="og:description" content="Laravel CRMs with lead routing, pipelines, multi-tenant access and dashboards, owned by you."><meta property="og:image" content="https://[your-domain]/images/services/custom-crm-development.webp"><meta property="og:url" content="https://[your-domain]/services/custom-crm-development">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="<?= asset_url('logo-v2/favicon-32.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [{"@type": "ListItem", "position": 1, "name": "Home", "item": "https://[your-domain]/index.html"}, {"@type": "ListItem", "position": 2, "name": "Services", "item": "https://[your-domain]/services-page.html"}, {"@type": "ListItem", "position": 3, "name": "Custom CRM Development", "item": "https://[your-domain]/services/custom-crm-development"}]}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "Service", "name": "Custom CRM Development", "serviceType": "Custom CRM Development", "url": "https://[your-domain]/services/custom-crm-development", "description": "Custom CRM systems built on Laravel: lead routing, pipeline tracking, multi-tenant access and reporting dashboards shaped around your actual sales process.", "provider": {"@type": "Person", "name": "Amaanullah Khan", "jobTitle": "PHP & Laravel Developer", "address": {"@type": "PostalAddress", "addressLocality": "Karachi", "addressCountry": "PK"}}, "areaServed": ["Pakistan", "United States", "United Kingdom", "United Arab Emirates"]}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "How much does custom CRM development cost?", "acceptedAnswer": {"@type": "Answer", "text": "Custom CRM development typically costs $2,500–$15,000+, depending on the number of users, features and integrations required. A basic MVP with lead management and role-based access usually takes 4–6 weeks. A multi-tenant enterprise CRM with real-time reporting and integrations takes 3–5 months. I give an exact quote after a short discovery call; no cost estimate goes out without understanding your actual workflow first."}}, {"@type": "Question", "name": "Why build a custom CRM instead of using HubSpot or Salesforce?", "acceptedAnswer": {"@type": "Answer", "text": "Off-the-shelf CRMs are built for thousands of companies at once, so your team works around fields, workflows and pricing tiers that weren’t designed for it, and the per-seat bill grows with your headcount. A custom CRM is built around your actual workflow, with no per-seat license fee and no vendor deciding which features you can have. For a small team just getting started, a free HubSpot tier is often the better choice."}}, {"@type": "Question", "name": "Will we own the CRM software?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. With custom development you own the source code and the database outright, control your data privacy, and are not tied to a vendor’s pricing or roadmap. Handover includes staff training and full documentation."}}]}</script><!-- DYNAMIC: JSON-LD via json_encode() in controller; FAQPage only for answered FAQs -->
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
 <nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/services') ?>">Services</a></li><li aria-current="page">Custom CRM Development</li></ol></nav><!-- DYNAMIC: $service->title -->
 <section class="hero2">
  <div>
   <div class="badges"><span class="bdg">Service</span><span class="bdg l"><i></i>Laravel · Enterprise scale</span></div><!-- DYNAMIC: $service->tags -->
   <h1>Custom CRM Development Built Around How Your Team <em>Actually Sells</em></h1><!-- DYNAMIC: $service->title / headline -->
   <p class="sum">Lead routing, pipeline tracking, multi-tenant access and reporting dashboards on Laravel, shaped around your real sales process, not a template full of fields you’ll never use.</p><!-- DYNAMIC: $service->summary -->
   <div class="hcta"><a class="btn o" href="<?= base_url('/contact') ?>">Request CRM scope &amp; quote →</a><a class="btn gh" href="#proof">See CRM case studies</a></div><!-- DYNAMIC: route('contact', ['service'=>$service->slug]) -->
   <div class="hst"><div><b>1.5M+</b><span>leads managed in production</span></div><div><b>300+</b><span>concurrent daily users</span></div><div><b>4.8★</b><span>Google rating (27 reviews)</span></div></div><!-- DYNAMIC: $service->stats[] (figures from live page; keep in sync) -->
   <p class="sm" style="margin-top:16px;color:var(--mu)">Based in Karachi, working with businesses across Pakistan, the US, UK and UAE.</p>
  </div>
  <figure class="slot" aria-label="Custom CRM dashboard illustration"><span class="sw">SWAP: service banner</span>
 <div class="tb"><i></i><i></i><i></i></div><h4>Sales pipeline · live</h4>
 <div class="kb"><div class="col"><small>New</small><div class="cd o mv"></div><div class="cd"></div><div class="cd"></div></div><div class="col"><small>Contacted</small><div class="cd"></div><div class="cd"></div></div><div class="col"><small>Proposal</small><div class="cd"></div></div><div class="col"><small>Won</small><div class="cd"></div></div></div>
 <div class="bars" aria-hidden="true"><i style="height:60%"></i><i style="height:85%"></i><i style="height:45%"></i><i style="height:100%"></i><i style="height:70%"></i><i style="height:90%"></i></div>
</figure><!-- SWAP BANNER: replace with <img src="{{ asset($service->banner) }}" alt="{{ $service->banner_alt }}" width="1600" height="1300"> (keep the figure size) -->
 </section>
 <div class="layout">
  <aside class="toc" aria-label="On this page"><div class="rt"><span>On this page</span><span id="pct">0%</span></div><div class="bar"><i id="tbar"></i></div><ol><li><a href="#why">Why custom</a></li><li><a href="#compare">Custom vs off-the-shelf</a></li><li><a href="#build">What I build</a></li><li><a href="#who">Who it’s for</a></li><li><a href="#process">How a project runs</a></li><li><a href="#stack">Tech stack</a></li><li><a href="#proof">Production proof</a></li><li><a href="#faq">FAQ</a></li></ol>
   <div class="share">Need this?<br><a href="<?= base_url('/contact') ?>">Get a quote →</a></div></aside>
  <div class="mtoc"><details><summary>On this page <span id="mcur">Why custom</span></summary><ol><li><a href="#why">Why custom</a></li><li><a href="#compare">Custom vs off-the-shelf</a></li><li><a href="#build">What I build</a></li><li><a href="#who">Who it’s for</a></li><li><a href="#process">How a project runs</a></li><li><a href="#stack">Tech stack</a></li><li><a href="#proof">Production proof</a></li><li><a href="#faq">FAQ</a></li></ol></details></div>
  <article class="content" id="content">

<section class="sec rv" id="why" aria-labelledby="h-why">
 <p class="eyb"><span>01 · Why custom</span></p>
 <!-- DYNAMIC: $service->intro (rich text) -->
 <h2 id="h-why">Why Businesses Choose Custom CRM Over HubSpot, Salesforce or Zoho</h2>
 
 <p class="lead">Off-the-shelf CRMs are built to fit thousands of different companies at once, so every team ends up working around fields, workflows and pricing tiers that weren’t designed for them. As the team grows, so does the monthly per-seat bill, and the platform still doesn’t match how you actually sell.</p>
 <p>Custom CRM development flips that. Instead of adapting your sales process to someone else’s software, I build the database, admin panels and automation around your real workflow. You own the source code outright, which is <a class="il" href="javascript:void(0)">why custom software scales better than SaaS</a><!-- DYNAMIC: internal link -> route() -->: no license fee that grows with headcount, and no vendor deciding which features you are allowed to have.</p>
 <aside class="pull"><p>Honest note: a 3-person team just getting started is often better off on a free HubSpot tier.</p></aside>
 <p>Custom development makes sense once you’ve outgrown what a template can do: multi-branch operations, non-standard sales stages, integrations off-the-shelf tools don’t support, or a monthly SaaS bill that’s growing faster than your headcount. For the bigger picture, see <a class="il" href="javascript:void(0)">how CRM and AI automation drive business growth</a><!-- DYNAMIC: internal link -> route() -->.</p>
</section>

<section class="sec rv" id="compare" aria-labelledby="h-compare">
 <p class="eyb"><span>02 · Comparison</span></p>
 <!-- DYNAMIC: $service->comparison[] (feature, off_the_shelf, custom) -->
 <h2 id="h-compare">Custom CRM vs Off-the-Shelf CRM at a Glance</h2>
 
 <p>The short version, side by side.</p>
 <div class="tbl" role="region" aria-label="Comparison table" tabindex="0"><table><thead><tr><th scope="col">Feature</th><th scope="col">Off-the-shelf CRM<small>HubSpot / Salesforce / Zoho</small></th><th scope="col" class="us">Custom CRM<small>built for you</small></th></tr></thead><tbody><tr><th scope="row">Cost structure</th><td data-l="Off-the-shelf">Per-seat, scales with team size</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>One-time build, no per-seat fee</td></tr><tr><th scope="row">Workflow fit</th><td data-l="Off-the-shelf">Generic: you adapt to it</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Built around your actual process</td></tr><tr><th scope="row">Data ownership</th><td data-l="Off-the-shelf">Hosted on the vendor’s platform</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>You own the source code and database</td></tr><tr><th scope="row">Customization</th><td data-l="Off-the-shelf">Limited to the vendor’s plugin ecosystem</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Any feature you need</td></tr><tr><th scope="row">Multi-branch support</th><td data-l="Off-the-shelf">Often needs expensive add-on tiers</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Built in from the start if needed</td></tr><tr><th scope="row">Long-term cost</th><td data-l="Off-the-shelf">Increases with users</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Flat: only support / hosting costs</td></tr></tbody></table></div>
</section>

<section class="sec rv" id="build" aria-labelledby="h-build">
 <p class="eyb"><span>03 · What I build</span></p>
 <!-- DYNAMIC: $service->features[] (icon, title, text), $service->benefits[] -->
 <h2 id="h-build">What I Build Inside a Custom CRM System</h2>
 
 <p>Every CRM is assembled from the modules your business actually needs. These are the building blocks I deliver most often.</p>
 <div class="fgrid"><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 5h18l-7 8v6l-4-2v-4z"/></svg></span><h3>Lead Management &amp; Routing</h3><p>Leads arrive from web forms, imports, ad platforms or manual entry and are assigned automatically by rules you define: territory, source, deal size or round-robin. No more leads sitting untouched in a spreadsheet.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="5" height="16" rx="1.5"/><rect x="10" y="4" width="5" height="11" rx="1.5"/><rect x="17" y="4" width="4" height="7" rx="1.5"/></svg></span><h3>Pipeline &amp; Deal Tracking</h3><p>Custom stages that match how your team actually closes deals, not a generic “Lead → Qualified → Won” default. Activity history, visibility into stuck deals, and status changes that trigger the right follow-up.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="2"/><rect x="13" y="3" width="8" height="8" rx="2"/><rect x="3" y="13" width="8" height="8" rx="2"/><rect x="13" y="13" width="8" height="8" rx="2"/></svg></span><h3>Multi-Tenant Architecture</h3><p>For agencies, franchises or B2B SaaS products serving many client accounts on one platform, with full data isolation between tenants. The same architecture runs my production CRM.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h18v3a2 2 0 0 0 0 4v3H3v-3a2 2 0 0 0 0-4z"/><path d="M13 7v10"/></svg></span><h3>Operations &amp; Ticketing Modules</h3><p>Job tracking, vendor management, SLA monitoring and approval workflows for businesses that have outgrown a simple deal-stage CRM.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M17 11h5M19.5 8.5v5"/></svg></span><h3>HRM &amp; Payroll Add-Ons</h3><p>Attendance, leave requests and payroll inside the same system as your CRM, so HR and sales share one internal platform instead of paying for two tools that don’t talk to each other.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 2v5M15 2v5M6 7h12v4a6 6 0 0 1-12 0zM12 17v5"/></svg></span><h3>Integrations &amp; Reporting</h3><p>REST APIs and webhooks that connect the CRM to your marketing, accounting and mobile tools, plus dashboards built around the metrics your managers actually check.</p></article></div>
 <h3 class="h3">Why invest in a custom CRM?</h3>
 <div class="why3"><div class="w"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="8" width="16" height="11" rx="3"/><path d="M12 4v4M9 13h.01M15 13h.01"/></svg></span><b>Smart CRM Automation</b><p>Lead scoring rules, follow-up triggers and reporting alerts where they save time, without stacking unnecessary AI layers on top of solid workflow design.</p></div><div class="w"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 2v5M15 2v5M6 7h12v4a6 6 0 0 1-12 0zM12 17v5"/></svg></span><b>Seamless Data Integrations</b><p>A CRM should not live in a silo. Secure APIs connect it with ERP tools, marketing systems, accounting software and external lead sources.</p></div><div class="w"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6z"/><path d="m9 12 2 2 4-4"/></svg></span><b>Ownership &amp; Scalability</b><p>Stop paying per-user monthly SaaS fees that multiply as you grow. You own the source code, control your data privacy and scale without penalty.</p></div></div>
</section>

<section class="sec rv" id="who" aria-labelledby="h-who">
 <p class="eyb"><span>04 · Who it’s for</span></p>
 <!-- DYNAMIC: $service->industries[] (title, text, link) -->
 <h2 id="h-who">Custom CRM Development for These Industries</h2>
 
 <p>CRM architecture isn’t one-size-fits-all: a real estate lead pipeline looks nothing like a field service ticketing system. This is where most of my custom CRM work has been.</p>
 <div class="who"><div class="wc"><span class="wn">01</span><div><b>Real estate &amp; call centers</b><p>High-volume lead assignment, follow-up tracking and agent performance dashboards. Similar to the <a class="il" href="javascript:void(0)">real estate portal</a><!-- DYNAMIC: internal link -> route() --> I built.</p></div></div><div class="wc"><span class="wn">02</span><div><b>B2B sales &amp; agencies</b><p>Multi-client data isolation, per-account pipeline reporting and role-based access.</p></div></div><div class="wc"><span class="wn">03</span><div><b>Field service &amp; logistics</b><p>Vendor ticketing, job status tracking and SLA monitoring across teams.</p></div></div><div class="wc"><span class="wn">04</span><div><b>Internal enterprise operations</b><p>HRM, payroll and admin portals running alongside CRM data in one system.</p></div></div></div>
 <div class="fit"><div class="y"><b>Good fit if…</b><ul><li>You run multiple branches or teams</li><li>Your sales stages aren’t standard</li><li>You need integrations SaaS tools don’t support</li><li>Your per-seat bill is outgrowing your headcount</li></ul></div><div class="n"><b>Probably not yet if…</b><ul><li>You’re a 3-person team just getting started</li><li>A free HubSpot tier already covers your process</li></ul></div></div>
</section>

<section class="sec rv" id="process" aria-labelledby="h-process">
 <p class="eyb"><span>05 · Process</span></p>
 <!-- DYNAMIC: $service->process_steps[] (title, text), $service->timeline_note -->
 <h2 id="h-process">How a Custom CRM Development Project Runs</h2>
 
 <p>Four phases, with working software in your hands early and often.</p>
 <ol class="tline"><li><span class="sn">01</span><div><b>Workflow Audit</b><p>Before any code is written, I map how leads currently enter your system, who touches them, and which reports your managers actually pull. Most scoping mistakes happen when this step is skipped.</p></div></li><li><span class="sn">02</span><div><b>Data &amp; Permission Design</b><p>Database schema, role-based permissions, tenant boundaries and integration points are planned upfront. This is what makes the system hold up once real users are on it, not just a demo.</p></div></li><li><span class="sn">03</span><div><b>Iterative Build</b><p>You see working software every 1–2 weeks: lead routing, dashboards and core modules you can test against real scenarios, not a single reveal at the end of the project.</p></div></li><li><span class="sn">04</span><div><b>Launch &amp; Handover</b><p>Deployment, staff training and full documentation, so you are not dependent on me for every small change after launch.</p></div></li></ol>
 <div class="take"><b>Typical timelines</b><p>Basic MVP with lead management and role-based access: about 4–6 weeks. Multi-tenant enterprise CRM with real-time reporting and integrations: about 3–5 months.</p></div>
</section>

<section class="sec rv" id="stack" aria-labelledby="h-stack">
 <p class="eyb"><span>06 · Tech stack</span></p>
 <!-- DYNAMIC: $service->tech[] (group, name) -->
 <h2 id="h-stack">Technology Behind the CRMs I Build</h2>
 
 <p>Built on Laravel for a secure, maintainable core that your own team or any PHP developer can extend later.</p>
 <div class="tgrid"><div class="tc"><small>Backend</small><b>Laravel (PHP)</b></div><div class="tc"><small>Integrations</small><b>REST APIs &amp; webhooks</b></div><div class="tc"><small>Access</small><b>Role-based permissions &amp; tenant isolation</b></div><div class="tc"><small>Database</small><b><span class="ph">[EDIT: e.g. MySQL]</span></b></div><div class="tc"><small>Front-end</small><b><span class="ph">[EDIT: e.g. Blade / Livewire / Vue]</span></b></div><div class="tc"><small>Hosting</small><b><span class="ph">[EDIT: e.g. your cloud / VPS]</span></b></div></div>
</section>

<section class="sec rv" id="proof" aria-labelledby="h-proof">
 <p class="eyb"><span>07 · Proof</span></p>
 <!-- DYNAMIC: $service->proof_text, related projects -->
 <h2 id="h-proof">Production CRM Proof, Not a Demo</h2>
 
 <p>My flagship build is a <a class="il" href="javascript:void(0)">multi-tenant CRM handling 1.5M+ leads</a><!-- DYNAMIC: internal link -> route() --> with <strong>300+ concurrent daily users</strong> in production, plus ticketing and HRM portals running in the same enterprise stack.</p>
 <div class="cgrid"><a class="cc" href="javascript:void(0)"><img src="<?= asset_url('images/banners/multi-tenant-crm.svg') ?>" alt="Multi-Tenant CRM case study banner" loading="lazy" width="1600" height="1000"><div><small>Sales &amp; operations platform</small><h3>Multi-Tenant CRM case study</h3><p>1.5M+ leads · 300+ concurrent daily users</p><span>Read case study →</span></div></a><a class="cc" href="javascript:void(0)"><img src="<?= asset_url('images/banners/ticketing-crm.svg') ?>" alt="Ticketing CRM case study banner" loading="lazy" width="1600" height="1000"><div><small>Job &amp; vendor management</small><h3>Ticketing CRM case study</h3><p>Vendors · SLA · workflows</p><span>Read case study →</span></div></a><a class="cc" href="javascript:void(0)"><img src="<?= asset_url('images/banners/hrm-payroll.svg') ?>" alt="HRM &amp; Payroll Portal case study banner" loading="lazy" width="1600" height="1000"><div><small>Employee management</small><h3>HRM &amp; Payroll Portal case study</h3><p>Attendance · payroll automation</p><span>Read case study →</span></div></a></div><!-- DYNAMIC: $service->caseStudies (3) -->
 <p class="sm">Looking for a local engagement? See <a class="il" href="javascript:void(0)">CRM Developer in Pakistan</a><!-- DYNAMIC: internal link -> route() --> or <a class="il" href="javascript:void(0)">Laravel developer in Karachi</a><!-- DYNAMIC: internal link -> route() -->.</p>
</section>

<section class="sec rv" id="faq" aria-labelledby="h-faq">
 <p class="eyb"><span>08 · FAQ</span></p>
 <!-- DYNAMIC: $service->faqs[] (q, a)  -- only output FAQPage JSON-LD for answered items -->
 <h2 id="h-faq">Custom CRM Development FAQ</h2>
 <details class="fq" open><summary>How much does custom CRM development cost?<span class="pm" aria-hidden="true"></span></summary><div><p>Custom CRM development typically costs $2,500–$15,000+, depending on the number of users, features and integrations required. A basic MVP with lead management and role-based access usually takes 4–6 weeks. A multi-tenant enterprise CRM with real-time reporting and integrations takes 3–5 months. I give an exact quote after a short discovery call; no cost estimate goes out without understanding your actual workflow first.</p></div></details><details class="fq"><summary>Why build a custom CRM instead of using HubSpot or Salesforce?<span class="pm" aria-hidden="true"></span></summary><div><p>Off-the-shelf CRMs are built for thousands of companies at once, so your team works around fields, workflows and pricing tiers that weren’t designed for it, and the per-seat bill grows with your headcount. A custom CRM is built around your actual workflow, with no per-seat license fee and no vendor deciding which features you can have. For a small team just getting started, a free HubSpot tier is often the better choice.</p></div></details><details class="fq"><summary>Can you integrate AI into our CRM?<span class="pm" aria-hidden="true"></span></summary><div><p><span class="ph">[EDIT: answer, copy from live page]</span></p></div></details><details class="fq"><summary>Will we own the CRM software?<span class="pm" aria-hidden="true"></span></summary><div><p>Yes. With custom development you own the source code and the database outright, control your data privacy, and are not tied to a vendor’s pricing or roadmap. Handover includes staff training and full documentation.</p></div></details><details class="fq"><summary>Can you migrate our data from Salesforce, Zoho, or HubSpot?<span class="pm" aria-hidden="true"></span></summary><div><p><span class="ph">[EDIT: answer, copy from live page]</span></p></div></details><details class="fq"><summary>Do I need my own servers?<span class="pm" aria-hidden="true"></span></summary><div><p><span class="ph">[EDIT: answer, copy from live page]</span></p></div></details>
</section>
  </article>
 </div>
 <section class="rel" aria-labelledby="h-rs"><p class="eyb">Related services</p><h2 id="h-rs">Services That Pair Well With a Custom CRM</h2><!-- DYNAMIC: $service->related (4) -->
  <div class="rs"><a href="javascript:void(0)"><b>Business Process Automation</b><p>Automate approvals, follow-ups and repetitive admin work around your CRM.</p><span>Explore →</span></a><a href="javascript:void(0)"><b>AI Automation</b><p>Practical AI agents and assistants plugged into existing workflows.</p><span>Explore →</span></a><a href="javascript:void(0)"><b>SaaS / Product Development</b><p>Turn an internal system into a multi-tenant product you can sell.</p><span>Explore →</span></a><a href="javascript:void(0)"><b>Real-time Chat App Development</b><p>Private messaging that can sit inside your CRM or HRM.</p><span>Explore →</span></a></div></section>
 <section class="cta"><div><h2>Ready to build a CRM shaped around your workflow?</h2><p>Tell me about your leads, pipeline and team structure. I’ll reply within 24 hours with scope options and next steps.</p></div><div class="bt2"><a class="btn" href="<?= base_url('/contact') ?>">Request CRM quote →</a><a class="btn gw" href="<?= base_url('/projects') ?>">View case studies</a></div></section><!-- DYNAMIC: $service->cta_title, cta_text -->
</div>
</main>
<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/service-detail.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script src="<?= asset_url('js/chatbot-config.js') ?>"></script><!-- EDIT: chatbot config -->
<script src="<?= asset_url('js/chatbot.js') ?>" defer></script>
</body></html>