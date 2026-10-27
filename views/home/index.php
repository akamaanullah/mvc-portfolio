<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<script src="<?= asset_url('js/splash-gate.js') ?>"></script>

<title>Amaanullah — Web Developer</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap&family=Caveat:wght@600&display=swap&family=Kalam:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/index.css') ?>">
<script type="importmap">{"imports":{"three":"https://unpkg.com/three@0.160.0/build/three.module.js","three/addons/":"https://unpkg.com/three@0.160.0/examples/jsm/"}}</script>
<link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/media.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/index-overrides.css') ?>">
<link rel="icon" href="<?= asset_url('logo-v2/favicon.ico') ?>">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "Amaanullah Khan",
  "jobTitle": "Custom Software Developer",
  "url": "https://amaanullah.com",
  "email": "info@amaanullah.com",
  "telephone": "+923196935307",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Karachi",
    "addressCountry": "PK"
  },
  "sameAs": [
    "https://maps.google.com/?cid=AmaanullahKhan",
    "https://github.com/akamaanullah",
    "https://linkedin.com"
  ]
}
</script>
</head><body>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<!-- ===== SPLASH / WELCOME SCREEN (shown once per session; add ?splash=1 to force) ===== -->
<div id="splash" role="dialog" aria-label="Loading Amaanullah portfolio">
 <div class="sbg"></div><canvas id="splashC"></canvas><div class="sflash"></div>
 <button class="sskip" id="sSkip" type="button">Skip <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
 <div class="stxt"><div class="slogo">A</div><div class="sname" id="sName" aria-label="Amaanullah."></div><div class="ssub">Web Developer | Software Solutions</div><div class="shand">Let's build something great</div></div>
 <div class="sprog"><b><span id="sPct">0</span><i>%</i></b>LOADING EXPERIENCE</div>
 <div class="sbar"><i id="sBar"></i></div>
</div>

<div class="bgfx"></div><div class="dots"><i></i><i></i><i></i><i></i></div>
<?php $home = true; $active = ''; require view_path('layouts/header.php'); ?>

<section class="hero" id="home">
 <div class="left">
  <div class="pill rev" style="animation-delay:.2s">Software Developer · Karachi, Pakistan</div>
  <h1 class="rev" style="animation-delay:.35s">Custom software<br>that works <em>harder.</em></h1>
  <p class="lead rev" style="animation-delay:.5s">CRM systems, SaaS platforms and web apps built with Laravel &amp; PHP for businesses in Pakistan, the UAE, Saudi Arabia, the US and UK.</p>
  <div class="chips rev" style="animation-delay:.65s">
   <button class="chip on" data-i="0"><svg class="chip-ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg><span>Web Apps</span></button><button class="chip" data-i="1"><svg class="chip-ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span>CRM</span></button><button class="chip" data-i="2"><svg class="chip-ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg><span>SaaS</span></button><button class="chip" data-i="3"><svg class="chip-ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg><span>Automation</span></button>
  </div>
  <div class="tech rev" style="animation-delay:.8s">
   <span><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="PHP" width="16" height="16" loading="lazy">PHP</span><span><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg" alt="Laravel" width="16" height="16" loading="lazy">Laravel</span><span><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg" alt="React" width="16" height="16" loading="lazy">React</span><span><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nodejs/nodejs-original.svg" alt="Node.js" width="16" height="16" loading="lazy">Node.js</span><span><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/flutter/flutter-original.svg" alt="Flutter" width="16" height="16" loading="lazy">Flutter</span>
  </div>
 </div>
 <div class="stage" id="stage"><canvas id="c"></canvas><svg id="lines"></svg></div>
</section>
<!-- ===== ABOUT ===== -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
 <clipPath id="cpPortrait" clipPathUnits="objectBoundingBox"><path d="M0.04,0.12 Q0.04,0.05 0.12,0.04 L0.78,0 Q0.86,0 0.88,0.04 L0.92,0.09 Q0.94,0.11 0.97,0.11 Q1,0.12 1,0.17 V0.86 Q1,0.93 0.93,0.94 L0.55,0.98 Q0.48,1 0.42,0.97 Q0.36,0.94 0.28,0.95 L0.08,0.96 Q0,0.96 0,0.89 V0.2 Q0,0.15 0.04,0.12Z"/></clipPath>
 <clipPath id="cpPhoto" clipPathUnits="objectBoundingBox"><path d="M0,0.08 L0.08,0 H0.86 Q0.92,0 0.95,0.05 L1,0.12 V0.9 L0.9,1 H0.1 Q0,1 0,0.92Z"/></clipPath>
 <clipPath id="cpJourney" clipPathUnits="objectBoundingBox"><path d="M0,0.12 Q0,0.02 0.03,0.02 L0.3,0.02 Q0.34,0.02 0.36,0 H0.97 Q1,0 1,0.08 V0.86 Q1,0.98 0.97,0.98 H0.62 Q0.58,0.98 0.55,1 H0.03 Q0,1 0,0.9Z"/></clipPath>
</defs></svg>
<section class="abt" id="about">
 <div class="cube3" style="--s:30px;right:3%;top:70px"><i></i><i></i><i></i><i></i><i></i><i></i></div>
 <svg class="crystal" style="left:36%;top:60px" width="40" height="52" viewBox="0 0 54 70"><polygon points="27,0 54,24 40,70 6,62 0,22" fill="url(#gCry)"/><polygon points="27,0 54,24 27,30" fill="#fff" opacity=".35"/></svg>
 <div class="agrid">
  <div class="pframe av" id="pframe">
   <div class="shape"></div>
   <div class="photo"><!-- SWAP IMAGE: replace images/profile.svg with your own portrait (e.g. images/profile.jpg) --><video class="pvid" autoplay muted loop playsinline preload="metadata" poster="<?= asset_url('media/profile-poster.jpg') ?>" aria-label="Amaanullah Khan, custom software developer in Karachi"><source src="<?= asset_url('media/profile.webm') ?>" type="video/webm"><source src="<?= asset_url('media/profile.mp4') ?>" type="video/mp4"><img src="<?= asset_url('media/profile-poster.jpg') ?>" alt="Amaanullah Khan, custom software developer in Karachi"></video></div>
   <div class="avail"><i></i>Available for projects</div>
   <div class="tbadge"><b>&lt;/&gt; Full-stack</b><span>Laravel</span><span>React</span><span>Flutter</span></div>
   <div class="sig">Amaanullah<svg width="170" height="16" viewBox="0 0 170 16"><path d="M2 10 Q60 0 120 8 T168 4" fill="none" stroke="#f26a1b" stroke-width="2.5" stroke-linecap="round"/></svg></div>
   <div class="cube3" style="--s:20px;right:24px;top:-14px;animation-duration:7s"><i></i><i></i><i></i><i></i><i></i><i></i></div>
  </div>
  <div class="atext" style="position:relative">
   <div class="av"><span class="pill2">About Me</span>
    <div class="hand hnote">Clean code,<br>real results ↘</div>
    <h2>Turning <em>complex problems</em><br>into simple, <em>scalable software</em></h2>
    <p class="bio">I’m Amaanullah Khan, a custom software developer based in Karachi. I handle <a href="<?= base_url('/services') ?>">web development</a>, <a href="<?= base_url('/services') ?>">business process automation</a> and <a href="<?= base_url('/services') ?>">mobile apps</a> from start to finish, from planning and database design to launch and ongoing support, so you always deal directly with the person building your product. I focus on clean architecture, fast interfaces and software that stays simple for the people who use it every day.</p></div>
   <div class="skills av" style="transition-delay:.22s">
    <!-- EDIT SKILLS: change --w to set each proficiency bar -->
    <a class="sk" href="https://www.php.net/" target="_blank" rel="noopener noreferrer"><div class="h"><span class="lg" style="background:#7a86b8">PHP</span>PHP</div><div class="bar"><i style="--w:95%"></i></div><span class="lv">Expert</span></a>
    <a class="sk" href="https://laravel.com/" target="_blank" rel="noopener noreferrer"><div class="h"><span class="lg" style="background:#ff2d20">L</span>Laravel</div><div class="bar"><i style="--w:95%"></i></div><span class="lv">Expert</span></a>
    <a class="sk" href="https://dotnet.microsoft.com/" target="_blank" rel="noopener noreferrer"><div class="h"><span class="lg" style="background:#512bd4">.N</span>.NET</div><div class="bar"><i style="--w:75%"></i></div><span class="lv">Advanced</span></a>
    <a class="sk" href="https://www.python.org/" target="_blank" rel="noopener noreferrer"><div class="h"><span class="lg" style="background:#3776ab">Py</span>Python</div><div class="bar"><i style="--w:70%"></i></div><span class="lv">Advanced</span></a>
    <a class="sk" href="https://www.mysql.com/" target="_blank" rel="noopener noreferrer"><div class="h"><span class="lg" style="background:#00758f">SQL</span>MySQL</div><div class="bar"><i style="--w:90%"></i></div><span class="lv">Expert</span></a>
    <a class="sk" href="https://react.dev/" target="_blank" rel="noopener noreferrer"><div class="h"><span class="lg" style="background:#20232a;display:inline-flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#61dafb" stroke-width="2"><ellipse cx="12" cy="12" rx="10" ry="4"/><ellipse cx="12" cy="12" rx="10" ry="4" transform="rotate(60 12 12)"/><ellipse cx="12" cy="12" rx="10" ry="4" transform="rotate(120 12 12)"/><circle cx="12" cy="12" r="1.5" fill="#61dafb"/></svg></span>React</div><div class="bar"><i style="--w:82%"></i></div><span class="lv">Advanced</span></a>
    <a class="sk" href="https://nodejs.org/" target="_blank" rel="noopener noreferrer"><div class="h"><span class="lg" style="background:#539e43">JS</span>Node.js</div><div class="bar"><i style="--w:80%"></i></div><span class="lv">Advanced</span></a>
    <a class="sk" href="https://flutter.dev/" target="_blank" rel="noopener noreferrer"><div class="h"><span class="lg" style="background:#47c5fb">F</span>Flutter</div><div class="bar"><i style="--w:78%"></i></div><span class="lv">Advanced</span></a>
   </div>
   <div class="actas av" style="transition-delay:.3s">
    <a class="cv" href="javascript:void(0)" download><!-- URL: link to your CV file, e.g. files/Amaanullah-CV.pdf --><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg><span>Download CV</span></a>
    <a class="lt2" href="<?= base_url('/contact') ?>"><!-- URL: contact page or #contact -->Let's Talk <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    <a class="story-link" href="<?= base_url('/about') ?>">About Amaanullah Khan →</a>
   </div>
  </div>
 </div>
 <div class="journey av">
  <div class="jbg"></div>
  <h2>My Development <em>Process</em></h2><p>From first call to launch, you see working software at every stage.</p>
  <div class="steps">
   <div class="stp"><span class="n">01</span><b>Discover</b><small>I map your current workflow, users and goals before writing a line of code.</small></div>
   <div class="stp"><span class="n">02</span><b>Design</b><small>Database, architecture and UI/UX flows are planned in phases, not guessed.</small></div>
   <div class="stp"><span class="n">03</span><b>Develop</b><small>Secure, scalable code built in stages, with regular demos and your feedback.</small></div>
   <div class="stp"><span class="n">04</span><b>Deliver</b><small>Tested on a staging copy first, then launched with documentation, a walkthrough and ongoing support.</small></div>
  </div>
 </div>
</section>
<section class="svc" id="services">
 <div class="shead sv"><span class="pill2">Our Services</span>
  <h2><span class="nowrap">Custom Software Services</span><br>for <em>Your Business</em></h2>
  <p class="sub">Six services, each built around how your business actually runs. Pick one, or combine them into a single custom software system.</p></div>
 <div class="sgrid">
  <!-- SERVICE LINKS: replace each href="javascript:void(0)" with that service page URL (e.g. href="/services/web-apps.html").
       The matching 3D tile in the scene uses the same link automatically. -->
  <nav class="slist sv" style="transition-delay:.15s">
   <a class="srow on" href="<?= base_url('/services/web-development') ?>" data-service="web"><!-- URL: Custom Web Applications page --><span class="ic" style="background:linear-gradient(135deg,#f26a1b,#ff9a4a)"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></span><span><b>Custom Web Applications</b><small>Scalable web applications and SaaS platforms built with Laravel &amp; PHP.</small></span><span class="ch"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></span></a>
   <a class="srow" href="<?= base_url('/services/custom-crm-development') ?>" data-service="crm"><!-- URL: CRM Development page --><span class="ic" style="background:#dfe6ff;color:#5b7cff"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span><span><b>CRM Development</b><small>Custom CRM systems for leads, customers and sales operations.</small></span><span class="ch"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></span></a>
   <a class="srow" href="<?= base_url('/services/chat-application-development') ?>" data-service="chat"><!-- URL: Chat Applications page --><span class="ic" style="background:#d6f5ea;color:#13a37a"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span><span><b>Chat Applications</b><small>Real-time chat, team collaboration and communication tools.</small></span><span class="ch"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></span></a>
   <a class="srow" href="<?= base_url('/services/business-process-automation') ?>" data-service="auto"><!-- URL: Business Process Automation page --><span class="ic" style="background:#fbe0f0;color:#c0287a"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></span><span><b>Business Process Automation</b><small>Replace manual work and spreadsheets with automated workflows.</small></span><span class="ch"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></span></a>
   <a class="srow" href="<?= base_url('/services/mobile-app-development') ?>" data-service="mobile"><!-- URL: Mobile App Development page --><span class="ic" style="background:#ece2ff;color:#7d4cff"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg></span><span><b>Mobile App Development</b><small>Android &amp; iOS apps with Flutter and Firebase.</small></span><span class="ch"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></span></a>
   <a class="srow" href="<?= base_url('/services') ?>" data-service="ui"><!-- URL: UI/UX & Performance page --><span class="ic" style="background:#ffe9cf;color:#e07b00"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg></span><span><b>UI/UX &amp; Performance</b><small>Fast, responsive interfaces designed around how people use your product.</small></span><span class="ch"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></span></a>
   <div class="slist-all"><a href="<?= base_url('/services') ?>" class="vall-services">View all services →</a></div>
  </nav>
  <div class="sstage sv" id="sstage" style="transition-delay:.05s" aria-label="Custom software services: web apps, CRM, chat, automation and mobile apps"><canvas id="sc" aria-label="Custom software services: web apps, CRM, chat, automation and mobile apps"></canvas></div>
  <div class="fcard sv" id="fcard" style="transition-delay:.3s"><span class="tag">Featured Service</span>
   <div class="fx fpanel on" data-panel="web">
    <h3>Custom Web Application Development</h3>
    <p>Scalable web applications, customer portals, admin dashboards and SaaS products built on Laravel, PHP and .NET for businesses in Pakistan and abroad. Planned around your workflow, not forced into a template.</p>
    <ul>
     <li>Laravel, PHP &amp; .NET</li>
     <li><a href="<?= base_url('/services/saas-development') ?>">SaaS &amp; Multi-user Platforms</a></li>
     <li>Dashboards &amp; Customer Portals</li>
     <li>API Integrations</li>
     <li>Scalable Architecture</li>
    </ul>
    <a class="fbtn" href="<?= base_url('/contact') ?>">Get a Free Consultation <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    <a class="fmore" href="<?= base_url('/services/web-development') ?>">Learn more about Custom Web Applications →</a>
   </div>

   <div class="fx fpanel" data-panel="crm">
    <h3>Custom CRM Development</h3>
    <p>Custom CRM software that centralises your leads, customers and deals, with pipelines, reports and automations shaped around how your team actually sells. Replace per-seat CRM subscriptions with a system you own.</p>
    <ul>
     <li>Lead &amp; Pipeline Management</li>
     <li>Multi-tenant Architecture</li>
     <li>Role-based Access</li>
     <li>Reports &amp; Dashboards</li>
     <li>Email / WhatsApp Integration</li>
    </ul>
    <a class="fbtn" href="<?= base_url('/contact') ?>">Get a Free Consultation <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    <a class="fmore" href="<?= base_url('/services/custom-crm-development') ?>">Learn more about Custom CRM Development →</a>
   </div>

   <div class="fx fpanel" data-panel="chat">
    <h3>Chat Application Development</h3>
    <p>Real-time chat and team collaboration platforms built on WebSockets, for teams that want their own Slack-style workspace without per-seat pricing.</p>
    <ul>
     <li>Real-time Messaging</li>
     <li>Channels &amp; Direct Messages</li>
     <li>File Sharing</li>
     <li>Roles &amp; Admin Controls</li>
     <li>No Per-seat Fees</li>
    </ul>
    <a class="fbtn" href="<?= base_url('/contact') ?>">Get a Free Consultation <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    <a class="fmore" href="<?= base_url('/services/chat-application-development') ?>">Learn more about Chat Application Development →</a>
   </div>

   <div class="fx fpanel" data-panel="auto">
    <h3>Business Process Automation</h3>
    <p>Custom-coded workflows that replace repetitive manual work: approvals, reports, alerts and data syncing between your tools, instead of a fragile chain of no-code connectors.</p>
    <ul>
     <li>Workflow &amp; Approval Automation</li>
     <li>API &amp; Third-party Integrations</li>
     <li>Spreadsheet-to-System Migration</li>
     <li>Automated Reports &amp; Alerts</li>
     <li><a href="<?= base_url('/services/ai-automation-services') ?>">AI Automation</a></li>
    </ul>
    <a class="fbtn" href="<?= base_url('/contact') ?>">Get a Free Consultation <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    <a class="fmore" href="<?= base_url('/services/business-process-automation') ?>">Learn more about Business Process Automation →</a>
   </div>

   <div class="fx fpanel" data-panel="mobile">
    <h3>Mobile App Development</h3>
    <p>Cross-platform Android and iOS apps built with Flutter and Firebase, from first prototype to store release, connected to your backend and an admin panel you can manage yourself.</p>
    <ul>
     <li>Android &amp; iOS from One Codebase</li>
     <li>Flutter &amp; Firebase</li>
     <li>REST API &amp; Backend Integration</li>
     <li>Push Notifications</li>
     <li>Admin Panel &amp; Store Release</li>
    </ul>
    <a class="fbtn" href="<?= base_url('/contact') ?>">Get a Free Consultation <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    <a class="fmore" href="<?= base_url('/services/mobile-app-development') ?>">Learn more about Mobile App Development →</a>
   </div>

   <div class="fx fpanel" data-panel="ui">
    <h3>UI/UX Design &amp; Performance</h3>
    <p>Clean, responsive interfaces and fast page loads for web and mobile apps, from UI/UX design and prototyping to React front-ends and performance tuning.</p>
    <ul>
     <li>UI/UX Design &amp; Prototyping</li>
     <li>Responsive Front-end (React)</li>
     <li>Page Speed &amp; Core Web Vitals</li>
     <li>Dashboard &amp; Admin Panel Design</li>
     <li>Database &amp; Query Tuning</li>
    </ul>
    <a class="fbtn" href="<?= base_url('/contact') ?>">Get a Free Consultation <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    <a class="fmore" href="<?= base_url('/services') ?>">Learn more about UI/UX &amp; Performance →</a>
   </div>
  </div>
 </div>
 <div class="feats sv" style="transition-delay:.45s">
   <div class="feat"><span class="fi"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span><div><b>Clear Timelines</b><small>Agreed milestones and dates before work starts.</small></div></div>
   <div class="feat"><span class="fi"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></span><div><b>Reply Within 24 Hours</b><small>Clear answers and next steps within one working day.</small></div></div>
   <div class="feat"><span class="fi"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg></span><div><b>Secure by Design</b><small>Role-based access and staging tests before anything goes live.</small></div></div>
   <div class="feat"><span class="fi"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg></span><div><b>Support After Launch</b><small>Documentation, a walkthrough and help after go-live.</small></div></div>
   <div class="note"><svg class="note-arrow" width="42" height="42" viewBox="0 0 40 40" fill="none" stroke="#f26a1b" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M6 34 C 14 26, 22 16, 26 6 M 17 9 L 26 6 L 27 16"/></svg>Let's Build<br>Something Great</div>
  </div>
</section>

<!-- ===== FEATURED PROJECTS ===== -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
 <!-- featured card: notched top-left, cream cut-in bottom-left, wavy bottom edge -->
 <clipPath id="cpFeat" clipPathUnits="objectBoundingBox"><path d="M0,0.16 Q0,0.1 0.02,0.08 L0.07,0.02 Q0.09,0 0.12,0 H0.84 Q0.87,0 0.88,0.03 Q0.895,0.07 0.93,0.07 H0.975 Q1,0.07 1,0.11 V0.86 Q1,0.93 0.97,0.94 L0.93,0.96 Q0.9,0.97 0.86,0.97 H0.52 Q0.45,0.97 0.43,0.92 Q0.41,0.86 0.35,0.86 Q0.25,0.88 0.17,0.84 Q0.1,0.8 0.05,0.86 Q0.02,0.9 0,0.86Z"/></clipPath>
 <clipPath id="cpFeatM" clipPathUnits="objectBoundingBox"><path d="M0,0.05 Q0,0.02 0.04,0.01 L0.12,0 H0.96 Q1,0 1,0.03 V0.95 Q1,0.98 0.95,0.98 H0.5 Q0.3,1 0.2,0.97 Q0.08,0.94 0.03,0.97 Q0,0.98 0,0.95Z"/></clipPath>
 <!-- project card A: slanted top, folded top-right corner -->
 <clipPath id="cpCardA" clipPathUnits="objectBoundingBox"><path d="M0,0.1 Q0,0.05 0.06,0.045 L0.78,0 L0.9,0 L1,0.06 V0.94 Q1,0.99 0.94,0.99 L0.08,1 Q0,1 0,0.95Z"/></clipPath>
 <!-- project card B: slant the other way, angled bottom-left -->
 <clipPath id="cpCardB" clipPathUnits="objectBoundingBox"><path d="M0,0.04 Q0,0 0.06,0 L0.94,0.05 Q1,0.055 1,0.1 V0.95 Q1,1 0.94,1 L0.12,0.99 L0,0.9Z"/></clipPath>
 <!-- folded text panels -->
 <clipPath id="cpPanel" clipPathUnits="objectBoundingBox"><path d="M0,0.12 Q0,0.04 0.06,0.04 L0.62,0 Q0.68,0 0.72,0.05 L0.78,0.12 H0.94 Q1,0.12 1,0.2 V0.92 Q1,1 0.94,1 H0.06 Q0,1 0,0.92Z"/></clipPath>
 <clipPath id="cpPanelB" clipPathUnits="objectBoundingBox"><path d="M0,0.2 Q0,0.12 0.06,0.12 H0.24 L0.3,0.04 Q0.33,0 0.38,0 L0.94,0.04 Q1,0.04 1,0.12 V0.92 Q1,1 0.94,1 H0.06 Q0,1 0,0.92Z"/></clipPath>
 <linearGradient id="gCry" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#b8c8ff"/><stop offset=".5" stop-color="#5b6cff"/><stop offset="1" stop-color="#1e2a8a"/></linearGradient>
</defs></svg>
<section class="prj" id="projects">
 <div class="cube3" style="--s:34px;left:-14px;top:330px"><i></i><i></i><i></i><i></i><i></i><i></i></div>
 <div class="cube3" style="--s:26px;left:22%;top:600px;animation-duration:12s"><i></i><i></i><i></i><i></i><i></i><i></i></div>
 <div class="phead pv">
  <div><span class="pill3"><i>✦</i>My Recent Work</span><h2>Featured <em>Projects</em></h2><p>Real solutions. Built with modern technologies to help businesses grow and operate more efficiently.</p></div>
  <div class="hand">Ideas<br>→ Code<br>→ Real Impact</div>
  <a class="vall" href="<?= base_url('/projects') ?>"><!-- URL: all projects page -->View All Projects <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
 </div>
 <div class="feat-wrap pv" id="featWrap" style="transition-delay:.1s">
  <div class="fshape"></div>
  <svg class="crystal" style="left:30%;top:20%" width="54" height="70" viewBox="0 0 54 70"><polygon points="27,0 54,24 40,70 6,62 0,22" fill="url(#gCry)"/><polygon points="27,0 54,24 27,30" fill="#fff" opacity=".35"/><polygon points="27,30 40,70 6,62" fill="#0d1460" opacity=".35"/></svg>
  <div class="cube3" style="--s:22px;left:31%;top:76%;animation-duration:7s"><i></i><i></i><i></i><i></i><i></i><i></i></div>
  <div class="ftext fslide">
   <span class="ftag">✦ Featured Project</span>
   <h3 id="fpT">Multi-tenant<br><span>CRM System</span></h3>
   <p id="fpD">A powerful multi-tenant CRM platform with lead management, analytics, real-time updates and 7-level RBAC. Built for scale and security.</p>
   <div class="tchips" id="fpC"><span>PHP</span><span>MySQL</span><span>Laravel</span><span>WebSockets</span></div>
   <a class="vcs" id="fpL" href="<?= base_url('/projects/multi-tenant-crm') ?>"><!-- URL: case study page (per slide, see SLIDES in the script) -->View Case Study <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
  </div>
  <svg class="rock" viewBox="0 0 400 200" preserveAspectRatio="none"><defs><radialGradient id="rk" cx=".5" cy=".4" r=".55"><stop offset="0%" stop-color="#2a2420" stop-opacity=".85"/><stop offset="50%" stop-color="#161720" stop-opacity=".6"/><stop offset="82%" stop-color="#101118" stop-opacity=".2"/><stop offset="100%" stop-color="#0e0f15" stop-opacity="0"/></radialGradient></defs><path d="M20,70 Q60,20 140,30 Q220,5 300,28 Q380,30 390,80 Q400,150 330,180 Q200,200 80,185 Q0,160 20,70Z" fill="url(#rk)"/><path d="M60,60 Q140,40 200,50 M220,40 Q300,35 350,60" stroke="#ff7a2a" stroke-opacity=".4" fill="none"/></svg>
  <svg class="wire" viewBox="0 0 400 300" preserveAspectRatio="none"><path d="M10,250 C80,180 40,80 160,120 S300,260 390,150"/><path d="M30,280 C120,240 200,300 260,220 S350,120 395,60"/></svg>
  <div class="laptop fslide"><div class="lscreen"><!-- SWAP IMAGE: replace images/crm-1.svg with your CRM screenshot --><img id="fpI" src="<?= asset_url('images/crm-1.svg') ?>" alt="CRM dashboard screenshot"></div><div class="lbase"></div></div>
  <div class="stat"><i style="display:flex;align-items:center;justify-content:center;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></i><div>Multi-tenant</div><b>5M – 10M+</b><div>Leads Capacity</div></div>
  <div class="flist fslide" id="fpF"><div>Lead Management</div><div>Real-time Analytics</div><div>7-Level RBAC</div><div>Secure &amp; Scalable</div></div>
  <div class="thumbs">
   <!-- SWAP IMAGES: thumbnails for the featured project gallery -->
   <a href="javascript:void(0)" class="on" data-i="0"><img src="<?= asset_url('images/crm-1.svg') ?>" alt="CRM screen 1"></a>
   <a href="javascript:void(0)" data-i="1"><img src="<?= asset_url('images/crm-2.svg') ?>" alt="CRM screen 2"></a>
   <a href="javascript:void(0)" data-i="2"><img src="<?= asset_url('images/crm-3.svg') ?>" alt="CRM screen 3"></a>
   <a href="javascript:void(0)" data-i="3"><img src="<?= asset_url('images/crm-4.svg') ?>" alt="CRM screen 4"></a>
  </div>
  <div class="pager"><span id="fpN">01 / 04</span><button id="fpPrev" aria-label="Previous"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button><button id="fpNext" aria-label="Next"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button></div>
 </div>

 <div class="pcards">
  <a class="pc dk pv" data-p="chatrox" href="<?= base_url('/projects/chatrox') ?>" style="transition-delay:.15s"><!-- URL: Chatrox project page -->
   <div class="sh"></div><div class="bg"></div><div class="img"></div>
   <div class="dev" style="left:30%"><!-- SWAP IMAGE: Chatrox desktop screenshot --><img src="<?= asset_url('images/chatrox.svg') ?>" alt="Chatrox screenshot"></div>
   <div class="phone"><!-- SWAP IMAGE: Chatrox mobile screenshot --><img src="<?= asset_url('images/chatrox-mobile.svg') ?>" alt="Chatrox mobile screenshot"></div>
   <span class="badge" style="background:linear-gradient(135deg,#7d8cff,#4b52e8); display:flex; align-items:center; justify-content:center;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
   <div class="panel"><span class="ty">Chat Application</span><h4>Chatrox</h4><p>Slack-like chat application with channels, files, voice &amp; more. Built for real-time communication.</p><div class="tc"><span>PHP</span><span>MySQL</span><span>Flutter</span></div><span class="vp">View Project <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span></div>
   <div class="hand">Connect<br>Collaborate<br>Achieve</div></a>
  <a class="pc lt b pv" data-p="rtg" href="<?= base_url('/projects/kanban-workspace') ?>" style="transition-delay:.25s"><!-- URL: RTG Workspace project page -->
   <div class="sh"></div><div class="bg"></div><div class="img"></div>
   <div class="dev"><!-- SWAP IMAGE: RTG Workspace screenshot --><img src="<?= asset_url('images/rtg-workspace.svg') ?>" alt="RTG Workspace screenshot"></div>
   <span class="badge" style="background:linear-gradient(135deg,#ff9a4a,#f25a0a); display:flex; align-items:center; justify-content:center;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="14" y1="3" x2="14" y2="21"/></svg></span>
   <div class="panel"><span class="ty">◉ Web Application</span><h4>RTG Workspace</h4><p>A Trello-style project management tool for internal team collaboration with task tracking and file sharing.</p><div class="tc"><span>PHP</span><span>MySQL</span><span>jQuery</span></div><span class="vp">View Project <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span></div>
   <div class="hand">Plan<br>Track<br>Deliver</div></a>
  <a class="pc dk pv" data-p="it" href="<?= base_url('/projects/it-hardware-bin') ?>" style="transition-delay:.35s"><!-- URL: IT Hardware Bin project page -->
   <div class="sh"></div><div class="bg"></div><div class="img"></div>
   <div class="dev"><!-- SWAP IMAGE: IT Hardware Bin screenshot --><img src="<?= asset_url('images/it-hardware-bin.svg') ?>" alt="IT Hardware Bin screenshot"></div>
   <span class="badge" style="background:linear-gradient(135deg,#5b9bff,#2f5bff); display:flex; align-items:center; justify-content:center;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></span>
   <div class="panel"><span class="ty" style="background:rgba(242,106,27,.2)">● E-Commerce</span><h4>IT Hardware Bin</h4><p>An complete e-commerce platform for IT hardware with quote requests, product catalog and smooth checkout.</p><div class="tc"><span>PHP</span><span>MySQL</span><span>Laravel</span></div><span class="vp">View Project <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span></div>
   <div class="hand">Hardware<br>Tech<br>Business</div></a>
  <a class="pc lt b pv" data-p="landsfy" href="<?= base_url('/projects/real-estate-portal') ?>" style="transition-delay:.45s"><!-- URL: Landsfy project page -->
   <div class="sh"></div><div class="bg"></div><div class="img"></div>
   <div class="dev"><!-- SWAP IMAGE: Landsfy screenshot --><img src="<?= asset_url('images/landsfy.svg') ?>" alt="Landsfy screenshot"></div>
   <span class="badge" style="background:linear-gradient(135deg,#3fd08a,#13a36a); display:flex; align-items:center; justify-content:center;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
   <div class="panel"><span class="ty">◉ Web Application</span><h4>Landsfy</h4><p>Real estate portal with property listings, search filters and RBAC-based access control.</p><div class="tc"><span>PHP</span><span>MySQL</span><span>Laravel</span></div><span class="vp">View Project <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span></div>
   <div class="hand">Find<br>Your<br>Dream Home</div></a>
 </div>

 <div class="wave">
  <svg viewBox="0 0 1440 160" preserveAspectRatio="none"><defs><linearGradient id="wv" x1="0" x2="1"><stop offset="0" stop-color="#14151d"/><stop offset=".5" stop-color="#22232e"/><stop offset="1" stop-color="#14151d"/></linearGradient></defs>
   <path d="M0,60 C200,10 380,90 600,50 C820,10 980,80 1180,40 C1300,18 1380,30 1440,50 V128 C1240,150 1040,118 760,136 C480,154 260,120 0,138Z" fill="url(#wv)"/>
   <path d="M0,60 C200,10 380,90 600,50 C820,10 980,80 1180,40 C1300,18 1380,30 1440,50" fill="none" stroke="#ff7a2a" stroke-width="2" stroke-opacity=".7" style="filter:drop-shadow(0 0 6px #ff6a1a)"/></svg>
  <a class="more" href="<?= base_url('/projects') ?>"><!-- URL: more projects page --><span class="mi"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg></span><span><b>More Projects</b><small>Explore all my work and see how I turn ideas into real solutions.</small></span><span class="ar"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span></a>
 </div>
</section>

<!-- ===== DEVELOPER VS SOFTWARE HOUSE COMPARISON ===== -->
<section class="vs-sec" id="developer-vs-agency">
 <div class="vs-card">
  <div class="vs-head">
   <span class="pill2">One developer vs a software house</span>
   <h2>Why hire a custom software developer <em>instead of a software house?</em></h2>
   <p class="vs-lead">When one developer plans, builds and deploys your software, there are no handoffs, no account managers and no requirements lost along the way. You talk directly to the person writing the code, decisions are faster, and one name is accountable for the result. A larger agency makes sense when a project needs many specialists at once. For most CRMs, web apps and SaaS products, one experienced developer is simpler and quicker.</p>
  </div>

  <div class="vs-table-wrap">
   <table class="vs-table">
    <caption class="sr-only">Comparison of hiring one custom software developer versus a typical software house</caption>
    <thead>
     <tr>
      <th scope="col" class="th-factor">Comparison</th>
      <th scope="col" class="th-dev">
       <span class="th-badge">Recommended</span>
       <span class="th-title">One developer (me)</span>
      </th>
      <th scope="col" class="th-agency">
       <span class="th-title">Typical software house</span>
      </th>
     </tr>
    </thead>
    <tbody>
     <tr>
      <th scope="row">Who you talk to</th>
      <td class="td-dev">
       <span class="cell-highlight">
        <svg class="check-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
        <span>The developer building your project</span>
       </span>
      </td>
      <td class="td-agency">
       <span class="cell-subtle">
        <svg class="dash-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>An account or project manager</span>
       </span>
      </td>
     </tr>
     <tr>
      <th scope="row">Handoffs</th>
      <td class="td-dev">
       <span class="cell-highlight">
        <svg class="check-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
        <span>None, from planning to deployment</span>
       </span>
      </td>
      <td class="td-agency">
       <span class="cell-subtle">
        <svg class="dash-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Between sales, managers, designers and developers</span>
       </span>
      </td>
     </tr>
     <tr>
      <th scope="row">Decisions</th>
      <td class="td-dev">
       <span class="cell-highlight">
        <svg class="check-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
        <span>Same conversation, same day</span>
       </span>
      </td>
      <td class="td-agency">
       <span class="cell-subtle">
        <svg class="dash-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Passed through the team</span>
       </span>
      </td>
     </tr>
     <tr>
      <th scope="row">Accountability</th>
      <td class="td-dev">
       <span class="cell-highlight">
        <svg class="check-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
        <span>One name</span>
       </span>
      </td>
      <td class="td-agency">
       <span class="cell-subtle">
        <svg class="dash-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Spread across a team</span>
       </span>
      </td>
     </tr>
     <tr>
      <th scope="row">Best for</th>
      <td class="td-dev">
       <span class="cell-highlight">
        <svg class="check-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
        <span>CRMs, web apps, SaaS, automation, mobile apps</span>
       </span>
      </td>
      <td class="td-agency">
       <span class="cell-subtle">
        <svg class="dash-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Large projects needing many specialists at once</span>
       </span>
      </td>
     </tr>
    </tbody>
   </table>
  </div>

  <div class="vs-action">
   <a href="<?= base_url('/about') ?>" class="vs-btn">
    <span>Read the full story of how I got here</span>
    <svg class="btn-arr" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
   </a>
  </div>
 </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
 <clipPath id="cpQuote" clipPathUnits="objectBoundingBox"><path d="M0,0.1 Q0,0.03 0.05,0.03 L0.55,0.03 Q0.6,0.03 0.63,0 H0.95 Q1,0 1,0.06 V0.84 Q1,0.9 0.96,0.92 L0.86,0.98 Q0.83,1 0.79,1 H0.05 Q0,1 0,0.94Z"/></clipPath>
 <clipPath id="cpCta" clipPathUnits="objectBoundingBox"><path d="M0,0.14 Q0,0.04 0.04,0.04 L0.22,0.04 Q0.26,0.04 0.28,0 H0.96 Q1,0 1,0.08 V0.78 Q1,0.86 0.97,0.88 Q0.94,0.9 0.9,0.88 Q0.84,0.85 0.8,0.92 Q0.77,1 0.7,1 H0.04 Q0,1 0,0.92Z"/></clipPath>
 <linearGradient id="gSw" x1="0" x2="1"><stop offset="0" stop-color="#f26a1b" stop-opacity="0"/><stop offset=".4" stop-color="#ff8a3d"/><stop offset="1" stop-color="#ffd0a0"/></linearGradient>
</defs></svg>
<section class="tst" id="reviews">
 <div class="cube3" style="--s:28px;left:46%;top:90px"><i></i><i></i><i></i><i></i><i></i><i></i></div>
 <svg class="crystal" style="right:2%;top:120px" width="42" height="54" viewBox="0 0 54 70"><polygon points="27,0 54,24 40,70 6,62 0,22" fill="url(#gCry)"/><polygon points="27,0 54,24 27,30" fill="#fff" opacity=".35"/></svg>
 <div class="tgrid">
  <div class="tv">
   <span class="pill2">Client Reviews</span>
   <h2>What <em>clients say</em><br>about working with me</h2>
   <p class="sub">Real reviews from my Google Business Profile. Drag or swipe the cards to read more.</p>
   <a class="agg" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener noreferrer" aria-label="4.8 rating based on 27 Google reviews. Read on Google.">
    <span class="big">4.8</span>
    <div>
     <span class="stars">★★★★★</span>
     <small>Average rating · 27 Google reviews</small>
    </div>
    <div class="avs">
     <img src="<?= asset_url('images/avatar-1.svg') ?>" alt="">
     <img src="<?= asset_url('images/avatar-2.svg') ?>" alt="">
     <img src="<?= asset_url('images/avatar-3.svg') ?>" alt="">
     <img src="<?= asset_url('images/avatar-4.svg') ?>" alt="">
    </div>
   </a>
   <div class="dctl">
    <button id="dPrev" aria-label="Previous review"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
    <button id="dNext" aria-label="Next review"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
    <span class="rcounter" id="dCounter">1 / 9</span>
    <span class="hnt">drag me ↗</span>
   </div>
  </div>
  <div class="deck tv" id="deck" style="transition-delay:.15s">
   <div class="qc">
    <div class="qbg"></div><span class="qm" aria-hidden="true">“</span>
    <span class="pj">Software Development</span>
    <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
    <blockquote>“Amanullah is a skilled and reliable software developer. He delivers high-quality work, writes clean and efficient code, and communicates professionally throughout the project. He is knowledgeable”</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-1.svg') ?>" alt=""><div><cite class="rname">Mr. Abdullah</cite></div></div>
    <a class="glink" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener noreferrer">Google review · Read on Google →</a>
   </div>
   <div class="qc lite">
    <div class="qbg"></div><span class="qm" aria-hidden="true">“</span>
    <span class="pj">Web Development</span>
    <div class="stars" aria-label="4 out of 5 stars">★★★★<span class="dim">★</span></div>
    <blockquote>“I had a great experience working with Amaanullah. He is highly skilled in web development and backend systems. The website he developed was fast, secure, and very well structured.”</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-2.svg') ?>" alt=""><div><cite class="rname">faisal khan</cite></div></div>
    <a class="glink" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener noreferrer">Google review · Read on Google →</a>
   </div>
   <div class="qc">
    <div class="qbg"></div><span class="qm" aria-hidden="true">“</span>
    <span class="pj">Web Development</span>
    <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
    <blockquote>“The web developer has strong technical skills and a deep understanding of web development. They are proficient in various programming languages and frameworks, and have a good eye for design and functionality.”</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-3.svg') ?>" alt=""><div><cite class="rname">Syed Hamza Qadri</cite></div></div>
    <a class="glink" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener noreferrer">Google review · Read on Google →</a>
   </div>
   <div class="qc lite">
    <div class="qbg"></div><span class="qm" aria-hidden="true">“</span>
    <span class="pj">LMS System</span>
    <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
    <blockquote>“I love to work with his team, he build LMS system for my school. Good job guys”</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-4.svg') ?>" alt=""><div><cite class="rname">steve harington</cite></div></div>
    <a class="glink" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener noreferrer">Google review · Read on Google →</a>
   </div>
   <div class="qc">
    <div class="qbg"></div><span class="qm" aria-hidden="true">“</span>
    <span class="pj">Website Maintenance</span>
    <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
    <blockquote>“Great job I love to working with them. They’re very supportive and don’t charge extra for additional work such as website maintenance and technical tasks. Thank you guys”</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-5.svg') ?>" alt=""><div><cite class="rname">Ruben</cite></div></div>
    <a class="glink" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener noreferrer">Google review · Read on Google →</a>
   </div>
   <div class="qc lite">
    <div class="qbg"></div><span class="qm" aria-hidden="true">“</span>
    <span class="pj">Google review</span>
    <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
    <blockquote>“Great productivity highly recommended no matter which country you’re in. The team is reliable, professional and won’t charge extra for additional work, fully satisfied with the services”</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-1.svg') ?>" alt=""><div><cite class="rname">Sonny Hayce</cite></div></div>
    <a class="glink" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener noreferrer">Google review · Read on Google →</a>
   </div>
   <div class="qc">
    <div class="qbg"></div><span class="qm" aria-hidden="true">“</span>
    <span class="pj">Google review</span>
    <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
    <blockquote>“Satisfied and timely results. Thanks for your service. Highly recommended”</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-2.svg') ?>" alt=""><div><cite class="rname">Khujista Azhar</cite></div></div>
    <a class="glink" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener noreferrer">Google review · Read on Google →</a>
   </div>
   <div class="qc lite">
    <div class="qbg"></div><span class="qm" aria-hidden="true">“</span>
    <span class="pj">Google review</span>
    <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
    <blockquote>“Amanullah is professional, responsible, and easy to work with”</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-3.svg') ?>" alt=""><div><cite class="rname">AZFAR BILAL</cite></div></div>
    <a class="glink" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener noreferrer">Google review · Read on Google →</a>
   </div>
   <div class="qc">
    <div class="qbg"></div><span class="qm" aria-hidden="true">“</span>
    <span class="pj">Google review</span>
    <div class="stars" aria-label="4 out of 5 stars">★★★★<span class="dim">★</span></div>
    <blockquote>“Great team, professional, helpful and always willing to go the extra mile. Highly recommended!”</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-4.svg') ?>" alt=""><div><cite class="rname">Johnson Pest Control</cite></div></div>
    <a class="glink" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener noreferrer">Google review · Read on Google →</a>
   </div>
  </div>
 </div>
 <div class="mq tv" style="transition-delay:.25s">
  <div class="mq-hdr">
   <span class="mq-pill">Software built for</span>
  </div>
  <div class="mrow rev2" id="mr2">
   <a class="chipr dk chipr-link" href="<?= base_url('/projects/multi-tenant-crm') ?>"><span class="p-ico" style="background:rgba(242,106,27,.2);color:#ff8a3d"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><path d="M2 10h20"/></svg></span><div><b class="pname">Multi-Tenant CRM</b><small class="pdesc">Sales &amp; operations platform</small></div><span class="p-arr" aria-hidden="true">↗</span></a>
   <a class="chipr chipr-link" href="<?= base_url('/projects/chatrox') ?>"><span class="p-ico" style="background:rgba(19,163,122,.2);color:#13a37a"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span><div><b class="pname">Chatrox</b><small class="pdesc">Real-time team chat</small></div><span class="p-arr" aria-hidden="true">↗</span></a>
   <a class="chipr dk chipr-link" href="<?= base_url('/projects/hrm-payroll') ?>"><span class="p-ico" style="background:rgba(122,162,255,.2);color:#7aa2ff"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span><div><b class="pname">RTG HRM Portal</b><small class="pdesc">HR &amp; payroll</small></div><span class="p-arr" aria-hidden="true">↗</span></a>
   <a class="chipr chipr-link" href="<?= base_url('/projects/it-hardware-bin') ?>"><span class="p-ico" style="background:rgba(232,74,165,.2);color:#e84aa5"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></span><div><b class="pname">IT Hardware Bin</b><small class="pdesc">Bulk hardware e-commerce</small></div><span class="p-arr" aria-hidden="true">↗</span></a>
   <a class="chipr dk chipr-link" href="<?= base_url('/projects/real-estate-portal') ?>"><span class="p-ico" style="background:rgba(255,176,32,.2);color:#ffb020"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span><div><b class="pname">Landsfy</b><small class="pdesc">Real estate portal</small></div><span class="p-arr" aria-hidden="true">↗</span></a>
   <a class="chipr chipr-link" href="<?= base_url('/projects/adsimpressions') ?>"><span class="p-ico" style="background:rgba(157,122,255,.2);color:#9d7aff"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg></span><div><b class="pname">Adsimpressions</b><small class="pdesc">Digital agency platform</small></div><span class="p-arr" aria-hidden="true">↗</span></a>
  </div>
 </div>
 <div class="tst-more tv" style="transition-delay:.3s">
  <a href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener noreferrer" class="btn-g-all"><span>Read all 27 reviews on Google</span> <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
 </div>
</section>
<!-- ===== CTA ===== -->
<section class="cta" id="cta">
 <div class="cblock tv" id="cblock">
  <div class="cbg"></div><div class="spot"></div>
  <svg class="swoosh" viewBox="0 0 1200 460" preserveAspectRatio="none"><path d="M-20,380 C220,300 380,440 620,330 S980,120 1220,170"/><path class="b" d="M-20,420 C260,360 420,470 660,370 S1000,180 1220,230"/></svg>
  <div class="cube3" style="--s:24px;left:46%;top:-12px;animation-duration:8s"><i></i><i></i><i></i><i></i><i></i><i></i></div>
  <div class="cin">
   <span class="pill2">✦ Let's work together</span>
   <p class="cta-hd">Have a project in mind?<br><em>Let's build it.</em></p>
   <p class="cs">Share a few details about what you need, and I’ll get back to you with clear next steps.</p>
   <div class="cbtns">
    <a class="mag" id="mag" href="#contact" data-event="cta_start_project">Start a Project <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    <?php $hPhone = (string) setting('phone_number', ''); $hPhoneDigits = preg_replace('/[^0-9]/', '', $hPhone); ?><a class="bcall" href="tel:+<?= $hPhoneDigits ?>" data-event="cta_call_me" aria-label="Call <?= htmlspecialchars($hPhone) ?>"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg><span>Call Me</span></a>
   </div>
   <div class="cchips">
    <a href="mailto:<?= htmlspecialchars((string) setting('contact_email', '')) ?>" data-event="cta_email"><i style="background:rgba(242,106,27,.25)"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ff8a3d" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></i>info@amaanullah.com</a>
    <a href="<?= htmlspecialchars((string) setting('whatsapp_url', '')) ?>" target="_blank" rel="noopener noreferrer" data-event="cta_whatsapp"><i style="background:rgba(37,211,102,.25)"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#25d366" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></i>WhatsApp</a>
   </div>
  </div>
  <div class="ficons" aria-hidden="true">
   <span class="fi2" style="left:8%;top:16%;color:#ff8a3d"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg><small>Web Apps</small></span>
   <span class="fi2" style="left:52%;top:8%;animation-delay:-1s"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#7aa2ff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/></svg><small>CRM</small></span>
   <span class="fi2" style="left:80%;top:36%;animation-delay:-2s"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#13a37a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><small>Chat</small></span>
   <span class="fi2" style="left:30%;top:46%;animation-delay:-3s"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#e84aa5" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg><small>Automation</small></span>
   <span class="fi2" style="left:64%;top:66%;animation-delay:-4s"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9d7aff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg><small>Mobile</small></span>
   <span class="fi2" style="left:4%;top:72%;animation-delay:-5s"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ff9a4a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg><small>UI/UX</small></span>
  </div>
  <div class="cnote"><svg width="60" height="44" viewBox="0 0 60 44" fill="none" stroke="#f26a1b" stroke-width="2.4" stroke-linecap="round"><path d="M58 40C40 38 18 30 8 6M4 16l4-11 10 5"/></svg>Let's talk!</div>
 </div>
</section>

<!-- ===== CONTACT ===== -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
 <clipPath id="cpInfo" clipPathUnits="objectBoundingBox"><path d="M0,0.08 Q0,0.02 0.06,0.02 L0.5,0.02 Q0.56,0.02 0.6,0 H0.94 Q1,0 1,0.05 V0.8 Q1,0.86 0.96,0.88 Q0.9,0.9 0.9,0.95 Q0.89,1 0.82,1 H0.06 Q0,1 0,0.95Z"/></clipPath>
 <clipPath id="cpForm" clipPathUnits="objectBoundingBox"><path d="M0,0.04 Q0,0 0.03,0 H0.7 Q0.74,0 0.76,0.015 L0.79,0.03 H0.975 Q1,0.03 1,0.06 V0.97 Q1,1 0.975,1 H0.03 Q0,1 0,0.97Z"/></clipPath>
</defs></svg>
<section class="cnt" id="contact">
 <div class="cube3" style="--s:26px;left:40%;top:70px"><i></i><i></i><i></i><i></i><i></i><i></i></div>
 <svg class="crystal" style="left:-10px;top:52%" width="40" height="52" viewBox="0 0 54 70"><polygon points="27,0 54,24 40,70 6,62 0,22" fill="url(#gCry)"/><polygon points="27,0 54,24 27,30" fill="#fff" opacity=".35"/></svg>
 <div class="chead cv2">
  <span class="pill2">Get In Touch</span>
  <h2>Get a free consultation<br>for <em>your software project</em></h2>
  <p class="sub">Share a few details about what you need, and I’ll get back to you with ideas, a timeline and a clear estimate.</p>
  <div class="reply">I usually reply within 24 hours<svg width="60" height="44" viewBox="0 0 60 44" fill="none" stroke="#f26a1b" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M56 4C46 20 30 34 6 38M14 30l-9 8 11 4"/></svg></div>
 </div>
 <div class="cgrid">
  <aside class="icard cv2" style="transition-delay:.1s">
   <div class="ibg"></div>
   <span class="avail2"><i></i>Available for projects</span>
   <p class="ic-title">Contact Information</p>
   <p class="ic-sub">Prefer a direct line? Reach me on any of these, whichever suits you best.</p>
   <div class="irows">
    <a class="irow" href="mailto:<?= htmlspecialchars((string) setting('contact_email', '')) ?>" aria-label="Email"><span class="ii"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></span><span><small>Email</small><b><?= htmlspecialchars((string) setting('contact_email', '')) ?></b></span></a>
    <a class="irow" href="tel:+<?= $hPhoneDigits ?>" aria-label="Call"><span class="ii"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span><span><small>Phone / WhatsApp</small><b><?= htmlspecialchars($hPhone) ?></b></span></a>
    <div class="irow"><span class="ii"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg></span><span><small>Location</small><b>Karachi, Pakistan</b></span></div>
    <div class="irow"><span class="ii"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></span><span><small>Working Hours</small><b>Mon – Fri, 9:00 – 18:00 PKT</b></span></div>
   </div>
   <div class="socials">
    <a href="https://github.com/akamaanullah" target="_blank" rel="noopener noreferrer" aria-label="GitHub profile"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .5a11.5 11.5 0 0 0-3.6 22.4c.6.1.8-.3.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.8 1.3 3.5 1 .1-.8.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.7 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.2 1.2a11 11 0 0 1 5.8 0c2.2-1.5 3.2-1.2 3.2-1.2.6 1.6.2 2.8.1 3.1.8.8 1.2 1.9 1.2 3.1 0 4.4-2.7 5.4-5.3 5.7.4.4.8 1.1.8 2.2v3.2c0 .3.2.7.8.6A11.5 11.5 0 0 0 12 .5z"/></svg></a>
    <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn profile"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM9 9h3.8v1.7h.1c.5-1 1.8-2 3.8-2 4 0 4.8 2.6 4.8 6V21h-4v-5.6c0-1.3 0-3-1.9-3s-2.1 1.4-2.1 2.9V21H9z"/></svg></a>
    <a href="https://x.com" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter) profile"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.2 2h3.4l-7.4 8.5L23 22h-6.8l-5.3-7-6.1 7H1.4l7.9-9L1 2h7l4.8 6.4zm-1.2 18h1.9L7.1 3.9H5.1z"/></svg></a>
    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram profile"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg></a>
    <a href="<?= htmlspecialchars((string) setting('whatsapp_url', '')) ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp chat"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2zm5.2 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.5-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.9s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .5l-.4.6-.4.4c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.4 2.4 1.5.3.1.5.1.6-.1l.9-1c.2-.3.4-.2.7-.1l2 1c.3.1.5.2.5.3.1.2.1.7-.1 1.3z"/></svg></a>
   </div>
  </aside>
  <div style="position:relative" class="cv2">
   <div class="fglow"></div>
   <div class="fglass" id="fglass" style="transition-delay:.2s">
    <form id="cform" method="POST" action="javascript:void(0)" novalidate>
     <input type="hidden" name="_token" value="">
     <div class="hp" aria-hidden="true"><label>Leave this empty<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
     <div class="frow">
      <div class="fl"><input id="f_name" name="name" type="text" placeholder=" " autocomplete="name" required minlength="2"><label for="f_name">Your Name *</label><span class="err">Please enter your name.</span></div>
      <div class="fl"><input id="f_email" name="email" type="email" placeholder=" " autocomplete="email" required><label for="f_email">Email Address *</label><span class="err">Please enter a valid email.</span></div>
     </div>
     <div class="frow">
      <div class="fl"><input id="f_phone" name="phone" type="tel" placeholder=" " autocomplete="tel" pattern="[0-9+ ()\-]{7,20}"><label for="f_phone">Phone (optional)</label><span class="err">Please enter a valid phone number.</span></div>
      <div class="fl"><select id="f_service" name="service" required>
        <option value="">Choose a service…</option>
        <option value="web_apps">Custom Web Application / SaaS Platform</option>
        <option value="crm">CRM Development</option>
        <option value="chat">Chat Application</option>
        <option value="automation">Business Process Automation</option>
        <option value="mobile">Mobile App</option>
        <option value="ui_ux">UI/UX &amp; Performance</option>
        <option value="other">Something else</option>
       </select><label for="f_service">Service *</label><span class="err">Please choose a service.</span></div>
     </div>
     <span class="glab">Quick pick a service</span>
     <div class="chs" id="svcChips"><button type="button" data-v="web_apps">Web Apps</button><button type="button" data-v="crm">CRM</button><button type="button" data-v="chat">Chat</button><button type="button" data-v="automation">Automation</button><button type="button" data-v="mobile">Mobile</button><button type="button" data-v="ui_ux">UI/UX</button></div>
     <div class="fl"><textarea id="f_message" name="message" placeholder=" " required minlength="10"></textarea><label for="f_message">Tell me about your project * (what you want to build, who will use it, and any deadline)</label><span class="err">Please write at least 10 characters.</span></div>
     <div class="fsend">
      <button class="sbtn" id="sbtn" type="submit"><span class="tx">Send Message <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span><span class="sp"></span></button>
      <p class="f-privacy">Your details are only used to reply to your enquiry. See my <a href="<?= base_url('/about') ?>">Privacy Policy</a>.</p>
      <div class="f-err-msg" id="fErrMsg" style="display:none" role="alert">Something went wrong. Please try again, or email me at <a href="mailto:info@amaanullah.com">info@amaanullah.com</a>.</div>
     </div>
    </form>
    <div class="success" role="status" aria-live="polite"><span class="ck"><svg width="40" height="40" viewBox="0 0 40 40" fill="none" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21l7 7 15-16"/></svg></span><h4>Thanks! I’ve received your message and will reply within 24 hours.</h4><p>Thanks for reaching out. I'll get back to you with clear next steps.</p><button type="button" id="fagain">Send another message</button></div>
   </div>
  </div>
 </div>
</section>
<!-- ===== FOOTER ===== -->
<?php require view_path('layouts/footer.php'); ?>


<script type="module" src="<?= asset_url('js/splash-particles.js') ?>"></script>
<script type="module" src="<?= asset_url('js/splash-portal.js') ?>"></script>
<script type="module" src="<?= asset_url('js/hero-3d.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script>
<script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= time() ?>" defer></script>
</body></html>
