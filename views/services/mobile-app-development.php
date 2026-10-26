<!DOCTYPE html>
<html lang="en">
<head>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<!--
  SERVICE DETAIL TEMPLATE — Blade: resources/views/services/show.blade.php
  Route: /services/{service:slug} -> ServiceController@show
  Slots are marked "DYNAMIC: $service->field"; lists loop with @foreach. TOC built only from sections that have content.
  CONTENT: Mobile App Development, generic copy + services-page card wording. [EDIT ...] items are placeholders.
-->
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Flutter Mobile App Development for iOS &amp; Android | Amaanullah Khan</title><!-- DYNAMIC: $service->seo_title -->
<meta name="description" content="Cross-platform iOS and Android app development in Flutter, connected to Laravel REST APIs with offline sync and push notifications. Based in Karachi, working worldwide."><!-- DYNAMIC: $service->meta_description -->
<link rel="canonical" href="https://amaanullah.com/services/mobile-app-development"><!-- DYNAMIC: url()->current() -->
<meta property="og:type" content="website"><meta property="og:title" content="Flutter Apps for iOS &amp; Android, Connected to Your Backend"><meta property="og:description" content="Cross-platform Flutter apps with Laravel REST APIs, offline sync and push notifications."><meta property="og:image" content="https://amaanullah.com/images/services/mobile-app-development.webp"><meta property="og:url" content="https://amaanullah.com/services/mobile-app-development">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="<?= asset_url('logo-v2/favicon-32.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [{"@type": "ListItem", "position": 1, "name": "Home", "item": "https://amaanullah.com/index.html"}, {"@type": "ListItem", "position": 2, "name": "Services", "item": "https://amaanullah.com/services-page.html"}, {"@type": "ListItem", "position": 3, "name": "Mobile App Development", "item": "https://amaanullah.com/services/mobile-app-development"}]}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "Service", "name": "Mobile App Development", "serviceType": "Mobile App Development", "url": "https://amaanullah.com/services/mobile-app-development", "description": "Cross-platform iOS and Android apps in Flutter, connected to Laravel REST APIs with offline sync and push notifications.", "provider": {"@type": "Person", "name": "Amaanullah Khan", "jobTitle": "PHP & Laravel Developer", "address": {"@type": "PostalAddress", "addressLocality": "Karachi", "addressCountry": "PK"}}, "areaServed": ["Pakistan", "United States", "United Kingdom", "United Arab Emirates"]}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "Can one app work on both iPhone and Android?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. Flutter builds iOS and Android apps from one codebase, so both platforms get the same features and design."}}, {"@type": "Question", "name": "Can the app work offline?", "acceptedAnswer": {"@type": "Answer", "text": "Yes, where needed. The app stores changes locally and syncs them with the backend once the connection returns."}}]}</script><!-- DYNAMIC: JSON-LD via json_encode() in controller; FAQPage only for answered FAQs -->
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
 <nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/services') ?>">Services</a></li><li aria-current="page">Mobile App Development</li></ol></nav><!-- DYNAMIC: $service->title -->
 <section class="hero2">
  <div>
   <div class="badges"><span class="bdg">Service</span><span class="bdg l"><i></i>Flutter · iOS &amp; Android</span></div><!-- DYNAMIC: $service->tags -->
   <h1>Mobile App Development for iOS &amp; Android <em>From One Codebase</em></h1><!-- DYNAMIC: $service->title / headline -->
   <p class="sum">Cross-platform iOS &amp; Android apps in Flutter, connected to Laravel REST APIs with offline sync and push notifications.</p><!-- DYNAMIC: $service->summary -->
   <div class="hcta"><a class="btn o" href="<?= base_url('/contact') ?>">Request app scope &amp; quote →</a><a class="btn gh" href="#proof">See mobile case studies</a></div><!-- DYNAMIC: route('contact', ['service'=>$service->slug]) -->
   <div class="hst"><div><b><span class="ph">[EDIT]</span></b><span><span class="ph">[EDIT: stat label]</span></span></div><div><b><span class="ph">[EDIT]</span></b><span><span class="ph">[EDIT: stat label]</span></span></div><div><b>4.8★</b><span>Google rating (27 reviews)</span></div></div><!-- DYNAMIC: $service->stats[] (figures from live page; keep in sync) -->
   <p class="sm" style="margin-top:16px;color:var(--mu)">Based in Karachi, working with businesses across Pakistan, the US, UK and UAE.</p>
  </div>
  <figure class="slot" aria-label="Mobile app illustration"><span class="sw">SWAP: service banner</span>
 <div class="tb"><i></i><i></i><i></i></div><h4>App release · live</h4>
 <div class="kb"><div class="col"><small>Design</small><div class="cd o mv"></div><div class="cd"></div><div class="cd"></div></div><div class="col"><small>Build</small><div class="cd"></div><div class="cd"></div></div><div class="col"><small>Testing</small><div class="cd"></div></div><div class="col"><small>Released</small><div class="cd"></div></div></div>
 <div class="bars" aria-hidden="true"><i style="height:60%"></i><i style="height:85%"></i><i style="height:45%"></i><i style="height:100%"></i><i style="height:70%"></i><i style="height:90%"></i></div>
</figure><!-- SWAP BANNER: replace with <img src="{{ asset($service->banner) }}" alt="{{ $service->banner_alt }}" width="1600" height="1300"> (keep the figure size) -->
 </section>
 <div class="layout">
  <aside class="toc" aria-label="On this page"><div class="rt"><span>On this page</span><span id="pct">0%</span></div><div class="bar"><i id="tbar"></i></div><ol><li><a href="#why">Why cross-platform</a></li><li><a href="#compare">Flutter vs native</a></li><li><a href="#build">What I build</a></li><li><a href="#who">Who it’s for</a></li><li><a href="#process">How a project runs</a></li><li><a href="#stack">Tech stack</a></li><li><a href="#proof">Production proof</a></li><li><a href="#faq">FAQ</a></li></ol>
   <div class="share">Need this?<br><a href="<?= base_url('/contact') ?>">Get a quote →</a></div></aside>
  <div class="mtoc"><details><summary>On this page <span id="mcur">Why cross-platform</span></summary><ol><li><a href="#why">Why cross-platform</a></li><li><a href="#compare">Flutter vs native</a></li><li><a href="#build">What I build</a></li><li><a href="#who">Who it’s for</a></li><li><a href="#process">How a project runs</a></li><li><a href="#stack">Tech stack</a></li><li><a href="#proof">Production proof</a></li><li><a href="#faq">FAQ</a></li></ol></details></div>
  <article class="content" id="content">

<section class="sec rv" id="why" aria-labelledby="h-why">
 <p class="eyb"><span>01 · Why cross-platform</span></p>
 <!-- DYNAMIC: $service->intro (rich text) -->
 <h2 id="h-why">Why Build Your App Once for Both iOS and Android</h2>
 
 <p class="lead">Building separate native apps means two codebases, two sets of bugs and roughly twice the effort for every new feature.</p>
 <p>With Flutter, one codebase produces apps for both iOS and Android. I connect them to a Laravel REST API backend, so the app, the admin panel and your website can all share the same data.</p>
 <aside class="pull"><p>Honest note: apps that depend heavily on very specific native device features can still be better built natively.</p></aside>
 <p>For most business apps, such as e-commerce, healthcare, travel or field tools, cross-platform development gets you to both app stores faster and keeps maintenance simpler. Need the backend too? See <a class="il" href="<?= base_url('/services/saas-application-development') ?>">SaaS Application Development</a>.</p>
</section>

<section class="sec rv" id="compare" aria-labelledby="h-compare">
 <p class="eyb"><span>02 · Comparison</span></p>
 <!-- DYNAMIC: $service->comparison[] (feature, off_the_shelf, custom) -->
 <h2 id="h-compare">Flutter Cross-Platform vs Separate Native Apps at a Glance</h2>
 
 <p>The short version, side by side.</p>
 <div class="tbl" role="region" aria-label="Comparison table" tabindex="0"><table><thead><tr><th scope="col">Feature</th><th scope="col">Separate native apps<small>Swift + Kotlin</small></th><th scope="col" class="us">Flutter app<small>built for you</small></th></tr></thead><tbody><tr><th scope="row">Codebases</th><td data-l="Separate native apps">Two, one per platform</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>One for iOS and Android</td></tr><tr><th scope="row">Feature releases</th><td data-l="Separate native apps">Built twice</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Built once, shipped to both</td></tr><tr><th scope="row">Consistency</th><td data-l="Separate native apps">Can drift between platforms</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Same design and behaviour</td></tr><tr><th scope="row">Backend</th><td data-l="Separate native apps">Often separate work</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Connected to Laravel REST APIs</td></tr><tr><th scope="row">Offline use</th><td data-l="Separate native apps">Built per platform</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>Offline sync built in where needed</td></tr><tr><th scope="row">Maintenance</th><td data-l="Separate native apps">Two apps to maintain</td><td class="us" data-l="Custom"><span class="ck" aria-hidden="true">✓</span>One codebase to maintain</td></tr></tbody></table></div>
</section>

<section class="sec rv" id="build" aria-labelledby="h-build">
 <p class="eyb"><span>03 · What I build</span></p>
 <!-- DYNAMIC: $service->features[] (icon, title, text), $service->benefits[] -->
 <h2 id="h-build">What I Build Inside a Mobile App</h2>
 
 <p>Every app is assembled from the features your users actually need. These are the building blocks I deliver most often.</p>
 <div class="fgrid"><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 5h18l-7 8v6l-4-2v-4z"/></svg></span><h3>Cross-Platform Apps</h3><p>iOS and Android apps from one Flutter codebase.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="5" height="16" rx="1.5"/><rect x="10" y="4" width="5" height="11" rx="1.5"/><rect x="17" y="4" width="4" height="7" rx="1.5"/></svg></span><h3>Laravel REST API Backends</h3><p>A secure backend and API that powers the app, the admin panel and your website.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="2"/><rect x="13" y="3" width="8" height="8" rx="2"/><rect x="3" y="13" width="8" height="8" rx="2"/><rect x="13" y="13" width="8" height="8" rx="2"/></svg></span><h3>Offline Sync</h3><p>The app keeps working without a connection and syncs changes when it’s back online.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h18v3a2 2 0 0 0 0 4v3H3v-3a2 2 0 0 0 0-4z"/><path d="M13 7v10"/></svg></span><h3>Push Notifications</h3><p>Timely alerts for orders, bookings, messages and reminders.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M17 11h5M19.5 8.5v5"/></svg></span><h3>Admin Apps &amp; Panels</h3><p>Separate admin apps or web panels to manage users, content and orders.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 2v5M15 2v5M6 7h12v4a6 6 0 0 1-12 0zM12 17v5"/></svg></span><h3>Third-Party APIs</h3><p>Maps, location, weather, payments and other services integrated into the app.</p></article></div>
 <h3 class="h3">Why invest in a cross-platform app?</h3>
 <div class="why3"><div class="w"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="8" width="16" height="11" rx="3"/><path d="M12 4v4M9 13h.01M15 13h.01"/></svg></span><b>Faster to Both Stores</b><p>One codebase reaches iOS and Android users together.</p></div><div class="w"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 2v5M15 2v5M6 7h12v4a6 6 0 0 1-12 0zM12 17v5"/></svg></span><b>Connected Backend</b><p>Laravel REST APIs keep the app in sync with your other systems.</p></div><div class="w"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6z"/><path d="m9 12 2 2 4-4"/></svg></span><b>Simpler Maintenance</b><p>One codebase means fixes and features ship everywhere at once.</p></div></div>
</section>

<section class="sec rv" id="who" aria-labelledby="h-who">
 <p class="eyb"><span>04 · Who it’s for</span></p>
 <!-- DYNAMIC: $service->industries[] (title, text, link) -->
 <h2 id="h-who">Mobile App Development for These Businesses</h2>
 
 <p>Cross-platform apps fit most business use cases.</p>
 <div class="who"><div class="wc"><span class="wn">01</span><div><b>E-commerce</b><p>Shopping apps with separate user and admin apps, like Babyshop.</p></div></div><div class="wc"><span class="wn">02</span><div><b>Healthcare</b><p>Platforms connecting patients, doctors, hospitals and pharmacies, like Healink.</p></div></div><div class="wc"><span class="wn">03</span><div><b>Travel &amp; location</b><p>Apps using weather and location APIs for real-time information, like the Tour Guide app.</p></div></div><div class="wc"><span class="wn">04</span><div><b>Businesses with a web platform</b><p>A mobile companion to an existing web app or CRM.</p></div></div></div>
 <div class="fit"><div class="y"><b>Good fit if…</b><ul><li>You need both iOS and Android</li><li>The app connects to a backend or web platform</li><li>Users need it to work offline</li><li>You want one codebase to maintain</li></ul></div><div class="n"><b>Probably not yet if…</b><ul><li>A mobile-friendly website already covers your users</li><li>The app depends on very specific native hardware features</li></ul></div></div>
</section>

<section class="sec rv" id="process" aria-labelledby="h-process">
 <p class="eyb"><span>05 · Process</span></p>
 <!-- DYNAMIC: $service->process_steps[] (title, text), $service->timeline_note -->
 <h2 id="h-process">How a Mobile App Project Runs</h2>
 
 <p>Four phases, with a working app on your phone early and often.</p>
 <ol class="tline"><li><span class="sn">01</span><div><b>Discovery</b><p>I map your users, screens and the data the app needs from your backend.</p></div></li><li><span class="sn">02</span><div><b>Design &amp; API Planning</b><p>Screens, user flows and the REST API are planned together.</p></div></li><li><span class="sn">03</span><div><b>Iterative Build</b><p>You test working builds on your own device every 1–2 weeks.</p></div></li><li><span class="sn">04</span><div><b>Release &amp; Handover</b><p>App store release, documentation and support after launch.</p></div></li></ol>
 <div class="take"><b>Typical timelines</b><p><span class="ph">[EDIT: typical timeline for a mobile app]</span></p></div>
</section>

<section class="sec rv" id="stack" aria-labelledby="h-stack">
 <p class="eyb"><span>06 · Tech stack</span></p>
 <!-- DYNAMIC: $service->tech[] (group, name) -->
 <h2 id="h-stack">Technology Behind the Apps I Build</h2>
 
 <p>Flutter on the front end and Laravel on the back end, a combination any Flutter or PHP developer can extend later.</p>
 <div class="tgrid"><div class="tc"><small>App</small><b>Flutter</b></div><div class="tc"><small>Platforms</small><b>iOS &amp; Android</b></div><div class="tc"><small>Backend</small><b>Laravel (PHP) REST APIs</b></div><div class="tc"><small>Notifications</small><b><span class="ph">[EDIT: e.g. Firebase Cloud Messaging]</span></b></div><div class="tc"><small>Database</small><b><span class="ph">[EDIT: e.g. MySQL]</span></b></div><div class="tc"><small>Hosting</small><b><span class="ph">[EDIT: e.g. your cloud / VPS]</span></b></div></div>
</section>

<section class="sec rv" id="proof" aria-labelledby="h-proof">
 <p class="eyb"><span>07 · Proof</span></p>
 <!-- DYNAMIC: $service->proof_text, related projects -->
 <h2 id="h-proof">Production Mobile Proof, Not a Demo</h2>
 
 <p>Flutter builds include <a class="il" href="javascript:void(0)">Healink</a><!-- DYNAMIC: internal link -> route() -->, a hospital and medical records app, Babyshop, an e-commerce app with separate user and admin apps, and a Tour Guide app for Pakistan.</p>
 <div class="cgrid"><a class="cc" href="javascript:void(0)"><img src="<?= asset_url('images/banners/healink.svg') ?>" alt="Healink case study banner" loading="lazy" width="1600" height="1000"><div><small>Hospital &amp; medical records app</small><h3>Healink case study</h3><p>Patients · doctors · pharmacies</p><span>Read case study →</span></div></a><a class="cc" href="javascript:void(0)"><img src="<?= asset_url('images/banners/babyshop.svg') ?>" alt="Babyshop case study banner" loading="lazy" width="1600" height="1000"><div><small>Flutter e-commerce app</small><h3>Babyshop case study</h3><p>User &amp; admin apps</p><span>Read case study →</span></div></a><a class="cc" href="javascript:void(0)"><img src="<?= asset_url('images/banners/tour-guide-app.svg') ?>" alt="Tour Guide App case study banner" loading="lazy" width="1600" height="1000"><div><small>Travel companion for Pakistan</small><h3>Tour Guide App case study</h3><p>Weather &amp; location APIs</p><span>Read case study →</span></div></a></div><!-- DYNAMIC: $service->caseStudies (3) -->
 <p class="sm">Looking for a local engagement? See <a class="il" href="<?= base_url('/laravel-developer-karachi') ?>">Laravel developer in Karachi</a> or <a class="il" href="<?= base_url('/full-stack-developer-karachi') ?>">full-stack developer in Karachi</a>.</p>
</section>

<section class="sec rv" id="faq" aria-labelledby="h-faq">
 <p class="eyb"><span>08 · FAQ</span></p>
 <!-- DYNAMIC: $service->faqs[] (q, a)  -- only output FAQPage JSON-LD for answered items -->
 <h2 id="h-faq">Mobile App Development FAQ</h2>
 <details class="fq" open><summary>Can one app work on both iPhone and Android?<span class="pm" aria-hidden="true"></span></summary><div><p>Yes. Flutter builds iOS and Android apps from one codebase, so both platforms get the same features and design.</p></div></details><details class="fq"><summary>How much does a mobile app cost?<span class="pm" aria-hidden="true"></span></summary><div><p><span class="ph">[EDIT: answer]</span></p></div></details><details class="fq"><summary>Can the app work offline?<span class="pm" aria-hidden="true"></span></summary><div><p>Yes, where needed. The app stores changes locally and syncs them with the backend once the connection returns.</p></div></details><details class="fq"><summary>Will you publish the app to the App Store and Google Play?<span class="pm" aria-hidden="true"></span></summary><div><p><span class="ph">[EDIT: answer]</span></p></div></details>
</section>
  </article>
 </div>
 <section class="rel" aria-labelledby="h-rs"><p class="eyb">Related services</p><h2 id="h-rs">Services That Pair Well With a Mobile App</h2><!-- DYNAMIC: $service->related (4) -->
  <div class="rs"><a href="<?= base_url('/services/saas-application-development') ?>"><b>SaaS Application Development</b><p>Multi-tenant platforms, portals, billing and REST APIs.</p><span>Explore →</span></a><a href="<?= base_url('/services/web-app-cms-development') ?>"><b>Web App &amp; CMS Development</b><p>Custom Laravel apps, or Shopify, WordPress and Wix for faster launches.</p><span>Explore →</span></a><a href="<?= base_url('/services/chat-app-development') ?>"><b>Chat App Development</b><p>Real-time chat you fully own, without per-seat fees.</p><span>Explore →</span></a><a href="<?= base_url('/services/custom-crm-development') ?>"><b>Custom CRM Development</b><p>Lead routing, pipelines and multi-tenant CRMs built around how your team sells.</p><span>Explore →</span></a></div></section>
 <section class="cta"><div><h2>Ready to put your business in your customers’ pockets?</h2><p>Tell me about your app idea, users and backend. I’ll reply within 24 hours with scope options and next steps.</p></div><div class="bt2"><a class="btn" href="<?= base_url('/contact') ?>">Request app quote →</a><a class="btn gw" href="<?= base_url('/projects') ?>">View case studies</a></div></section><!-- DYNAMIC: $service->cta_title, cta_text -->
</div>
</main>
<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/service-detail.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script src="<?= asset_url('js/chatbot-config.js') ?>"></script><!-- EDIT: chatbot config -->
<script src="<?= asset_url('js/chatbot.js') ?>" defer></script>
</body></html>