<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<script src="<?= asset_url('js/index.js') ?>"></script>

<title>Amaanullah — Web Developer</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap&family=Caveat:wght@600&display=swap&family=Kalam:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/index.css') ?>">
<script type="importmap">{"imports":{"three":"https://unpkg.com/three@0.160.0/build/three.module.js","three/addons/":"https://unpkg.com/three@0.160.0/examples/jsm/"}}</script>
<link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/media.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/index-overrides.css') ?>">
<link rel="icon" href="<?= asset_url('logo-v2/favicon.ico') ?>">
</head><body>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<!-- ===== SPLASH / WELCOME SCREEN (shown once per session; add ?splash=1 to force) ===== -->
<div id="splash" role="dialog" aria-label="Loading Amaanullah portfolio">
 <div class="sbg"></div><canvas id="splashC"></canvas><div class="sflash"></div>
 <button class="sskip" id="sSkip" type="button">Skip <span>→</span></button>
 <div class="stxt"><div class="slogo">A</div><div class="sname" id="sName" aria-label="Amaanullah."></div><div class="ssub">Web Developer | Software Solutions</div><div class="shand">Let's build something great</div></div>
 <div class="sprog"><b><span id="sPct">0</span><i>%</i></b>LOADING EXPERIENCE</div>
 <div class="sbar"><i id="sBar"></i></div>
</div>

<div class="bgfx"></div><div class="dots"><i></i><i></i><i></i><i></i></div>
<?php $home = true; $active = ''; require view_path('layouts/header.php'); ?>

<section class="hero" id="home">
 <div class="left">
  <div class="pill rev" style="animation-delay:.2s">✦ MY SERVICES</div>
  <h1 class="rev" style="animation-delay:.35s">I build systems<br>that work <em>harder.</em></h1>
  <p class="lead rev" style="animation-delay:.5s">From custom web applications to automation and team collaboration tools — I turn ideas into scalable digital solutions.</p>
  <div class="chips rev" style="animation-delay:.65s">
   <button class="chip on" data-i="0">&lt;/&gt; Web Apps</button><button class="chip" data-i="1">👤 CRM</button><button class="chip" data-i="2">💬 Chat</button><button class="chip" data-i="3">⚙ Automation</button><span class="drag">⤧ Drag to explore ↗</span>
  </div>
  <div class="tech rev" style="animation-delay:.8s">
   <span><i style="background:#7a86b8"></i>PHP</span><span><i style="background:#ff2d20"></i>Laravel</span><span><i style="background:#00758f"></i>MySQL</span><span><i style="background:#61dafb"></i>React</span><span><i style="background:#539e43"></i>Node.js</span><span><i style="background:#47c5fb"></i>Flutter</span>
  </div>
 </div>
 <div class="stage" id="stage"><canvas id="c"></canvas><svg id="lines"></svg></div>
</section>
<section class="svc" id="services">
 <div class="shead sv"><span class="pill2">Our Services</span>
  <h2><em>Smart Digital Solutions</em><br>for Your Business</h2>
  <p class="sub">We build custom software, automate workflows and create digital solutions that help your business grow, scale and stay ahead in the digital world.</p></div>
 <div class="sgrid">
  <!-- SERVICE LINKS: replace each href="javascript:void(0)" with that service page URL (e.g. href="/services/web-apps.html").
       The matching 3D tile in the scene uses the same link automatically. -->
  <nav class="slist sv" style="transition-delay:.15s">
   <a class="srow on" href="javascript:void(0)" data-service="web"><!-- URL: Custom Web Apps page --><span class="ic" style="background:linear-gradient(135deg,#f26a1b,#ff9a4a)">&lt;/&gt;</span><span><b>Custom Web Apps</b><small>Tailored web applications with PHP, Laravel, .NET and more.</small></span><span class="ch">›</span></a>
   <a class="srow" href="javascript:void(0)" data-service="crm"><!-- URL: CRM Development page --><span class="ic" style="background:#dfe6ff;color:#5b7cff">☁</span><span><b>CRM Development</b><small>Manage leads, customers and operations with smart CRM systems.</small></span><span class="ch">›</span></a>
   <a class="srow" href="javascript:void(0)" data-service="chat"><!-- URL: Chat Applications page --><span class="ic" style="background:#d6f5ea;color:#13a37a">💬</span><span><b>Chat Applications</b><small>Real-time chat, team collaboration and communication tools.</small></span><span class="ch">›</span></a>
   <a class="srow" href="javascript:void(0)" data-service="auto"><!-- URL: Business Process Automation page --><span class="ic" style="background:#fbe0f0;color:#c0287a">⚙</span><span><b>Business Process Automation</b><small>Save time with smart workflows and automation systems.</small></span><span class="ch">›</span></a>
   <a class="srow" href="javascript:void(0)" data-service="mobile"><!-- URL: Mobile App Development page --><span class="ic" style="background:#ece2ff;color:#7d4cff">▯</span><span><b>Mobile App Development</b><small>Cross-platform apps with Flutter, Firebase and modern tech.</small></span><span class="ch">›</span></a>
   <a class="srow" href="javascript:void(0)" data-service="ui"><!-- URL: UI/UX & Performance page --><span class="ic" style="background:#ffe9cf;color:#e07b00">🎨</span><span><b>UI/UX &amp; Performance</b><small>Modern UI/UX, fast, responsive and optimized performance.</small></span><span class="ch">›</span></a>
  </nav>
  <div class="sstage sv" id="sstage" style="transition-delay:.05s"><canvas id="sc"></canvas></div>
  <div class="fcard sv" id="fcard" style="transition-delay:.3s"><span class="tag">Featured Service</span>
   <div class="fx"><h3 id="ft"></h3><p id="fd"></p><ul id="fl"></ul></div>
   <a class="fbtn" href="javascript:void(0)"><!-- URL: consultation / contact page -->Get a Free Consultation →</a></div>
 </div>
 <div class="feats sv" style="transition-delay:.45s">
  <div class="feat"><span class="fi">⚡</span><div><b>Fast Delivery</b><small>On-time project delivery with agile process.</small></div></div>
  <div class="feat"><span class="fi">🛡</span><div><b>Secure Solutions</b><small>Your data and business are always protected.</small></div></div>
  <div class="feat"><span class="fi">👥</span><div><b>Expert Team</b><small>Skilled developers with real-world experience.</small></div></div>
  <div class="feat"><span class="fi">🎧</span><div><b>24/7 Support</b><small>We're always here when you need us.</small></div></div>
  <div class="note">Let's Build<br>Something Great<svg width="40" height="40" viewBox="0 0 40 40" fill="none" stroke="#f26a1b" stroke-width="2" stroke-linecap="round"><path d="M5 5c10 4 20 14 24 28M22 30l7 4 3-8"/></svg></div>
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
  <a class="vall" href="javascript:void(0)"><!-- URL: all projects page -->View All Projects &nbsp;→</a>
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
   <a class="vcs" id="fpL" href="javascript:void(0)"><!-- URL: case study page (per slide, see SLIDES in the script) -->View Case Study <b>→</b></a>
  </div>
  <svg class="rock" viewBox="0 0 400 200" preserveAspectRatio="none"><defs><radialGradient id="rk" cx=".5" cy=".3"><stop offset="0" stop-color="#4a4038"/><stop offset="1" stop-color="#15120f"/></radialGradient></defs><path d="M20,70 Q60,20 140,30 Q220,5 300,28 Q380,30 390,80 Q400,150 330,180 Q200,200 80,185 Q0,160 20,70Z" fill="url(#rk)"/><path d="M60,60 Q140,40 200,50 M220,40 Q300,35 350,60" stroke="#ff7a2a" stroke-opacity=".35" fill="none"/></svg>
  <svg class="wire" viewBox="0 0 400 300" preserveAspectRatio="none"><path d="M10,250 C80,180 40,80 160,120 S300,260 390,150"/><path d="M30,280 C120,240 200,300 260,220 S350,120 395,60"/></svg>
  <div class="laptop fslide"><div class="lscreen"><!-- SWAP IMAGE: replace images/crm-1.svg with your CRM screenshot --><img id="fpI" src="<?= asset_url('images/crm-1.svg') ?>" alt="CRM dashboard screenshot"></div><div class="lbase"></div></div>
  <div class="stat"><i>👥</i><div>Multi-tenant</div><b>5M – 10M+</b><div>Leads Capacity</div></div>
  <div class="flist fslide" id="fpF"><div>Lead Management</div><div>Real-time Analytics</div><div>7-Level RBAC</div><div>Secure &amp; Scalable</div></div>
  <div class="thumbs">
   <!-- SWAP IMAGES: thumbnails for the featured project gallery -->
   <a href="javascript:void(0)" class="on" data-i="0"><img src="<?= asset_url('images/crm-1.svg') ?>" alt="CRM screen 1"></a>
   <a href="javascript:void(0)" data-i="1"><img src="<?= asset_url('images/crm-2.svg') ?>" alt="CRM screen 2"></a>
   <a href="javascript:void(0)" data-i="2"><img src="<?= asset_url('images/crm-3.svg') ?>" alt="CRM screen 3"></a>
   <a href="javascript:void(0)" data-i="3"><img src="<?= asset_url('images/crm-4.svg') ?>" alt="CRM screen 4"></a>
  </div>
  <div class="pager"><span id="fpN">01 / 04</span><button id="fpPrev" aria-label="Previous">←</button><button id="fpNext" aria-label="Next">→</button></div>
 </div>

 <div class="pcards">
  <a class="pc dk pv" data-p="chatrox" href="javascript:void(0)" style="transition-delay:.15s"><!-- URL: Chatrox project page -->
   <div class="sh"></div><div class="bg"></div><div class="img"></div>
   <div class="dev" style="left:30%"><!-- SWAP IMAGE: Chatrox desktop screenshot --><img src="<?= asset_url('images/chatrox.svg') ?>" alt="Chatrox screenshot"></div>
   <div class="phone"><!-- SWAP IMAGE: Chatrox mobile screenshot --><img src="<?= asset_url('images/chatrox-mobile.svg') ?>" alt="Chatrox mobile screenshot"></div>
   <span class="badge" style="background:linear-gradient(135deg,#7d8cff,#4b52e8)">💬</span>
   <div class="panel"><span class="ty">💬 Chat Application</span><h4>Chatrox</h4><p>Slack-like chat application with channels, files, voice &amp; more. Built for real-time communication.</p><div class="tc"><span>PHP</span><span>MySQL</span><span>Flutter</span></div><span class="vp">View Project →</span></div>
   <div class="hand">Connect<br>Collaborate<br>Achieve</div></a>
  <a class="pc lt b pv" data-p="rtg" href="javascript:void(0)" style="transition-delay:.25s"><!-- URL: RTG Workspace project page -->
   <div class="sh"></div><div class="bg"></div><div class="img"></div>
   <div class="dev"><!-- SWAP IMAGE: RTG Workspace screenshot --><img src="<?= asset_url('images/rtg-workspace.svg') ?>" alt="RTG Workspace screenshot"></div>
   <span class="badge" style="background:linear-gradient(135deg,#ff9a4a,#f25a0a)">▤</span>
   <div class="panel"><span class="ty">◉ Web Application</span><h4>RTG Workspace</h4><p>A Trello-style project management tool for internal team collaboration with task tracking and file sharing.</p><div class="tc"><span>PHP</span><span>MySQL</span><span>jQuery</span></div><span class="vp">View Project →</span></div>
   <div class="hand">Plan<br>Track<br>Deliver</div></a>
  <a class="pc dk pv" data-p="it" href="javascript:void(0)" style="transition-delay:.35s"><!-- URL: IT Hardware Bin project page -->
   <div class="sh"></div><div class="bg"></div><div class="img"></div>
   <div class="dev"><!-- SWAP IMAGE: IT Hardware Bin screenshot --><img src="<?= asset_url('images/it-hardware-bin.svg') ?>" alt="IT Hardware Bin screenshot"></div>
   <span class="badge" style="background:linear-gradient(135deg,#5b9bff,#2f5bff)">🛒</span>
   <div class="panel"><span class="ty" style="background:rgba(242,106,27,.2)">● E-Commerce</span><h4>IT Hardware Bin</h4><p>An complete e-commerce platform for IT hardware with quote requests, product catalog and smooth checkout.</p><div class="tc"><span>PHP</span><span>MySQL</span><span>Laravel</span></div><span class="vp">View Project →</span></div>
   <div class="hand">Hardware<br>Tech<br>Business</div></a>
  <a class="pc lt b pv" data-p="landsfy" href="javascript:void(0)" style="transition-delay:.45s"><!-- URL: Landsfy project page -->
   <div class="sh"></div><div class="bg"></div><div class="img"></div>
   <div class="dev"><!-- SWAP IMAGE: Landsfy screenshot --><img src="<?= asset_url('images/landsfy.svg') ?>" alt="Landsfy screenshot"></div>
   <span class="badge" style="background:linear-gradient(135deg,#3fd08a,#13a36a)">⌂</span>
   <div class="panel"><span class="ty">◉ Web Application</span><h4>Landsfy</h4><p>Real estate portal with property listings, search filters and RBAC-based access control.</p><div class="tc"><span>PHP</span><span>MySQL</span><span>Laravel</span></div><span class="vp">View Project →</span></div>
   <div class="hand">Find<br>Your<br>Dream Home</div></a>
 </div>

 <div class="wave">
  <svg viewBox="0 0 1440 160" preserveAspectRatio="none"><defs><linearGradient id="wv" x1="0" x2="1"><stop offset="0" stop-color="#14151d"/><stop offset=".5" stop-color="#22232e"/><stop offset="1" stop-color="#14151d"/></linearGradient></defs>
   <path d="M0,60 C200,10 380,90 600,50 C820,10 980,80 1180,40 C1300,18 1380,30 1440,50 V128 C1240,150 1040,118 760,136 C480,154 260,120 0,138Z" fill="url(#wv)"/>
   <path d="M0,60 C200,10 380,90 600,50 C820,10 980,80 1180,40 C1300,18 1380,30 1440,50" fill="none" stroke="#ff7a2a" stroke-width="2" stroke-opacity=".7" style="filter:drop-shadow(0 0 6px #ff6a1a)"/></svg>
  <a class="more" href="javascript:void(0)"><!-- URL: more projects page --><span class="mi">◆</span><span><b>More Projects</b><small>Explore all my work and see how I turn ideas into real solutions.</small></span><span class="ar">→</span></a>
 </div>
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
   <div class="photo"><!-- SWAP IMAGE: replace images/profile.svg with your own portrait (e.g. images/profile.jpg) --><video class="pvid" autoplay muted loop playsinline preload="metadata" poster="<?= asset_url('media/profile-poster.jpg') ?>" aria-label="Portrait of Amaanullah"><source src="<?= asset_url('media/profile.webm') ?>" type="video/webm"><source src="<?= asset_url('media/profile.mp4') ?>" type="video/mp4"></video></div>
   <div class="avail"><i></i>Available for projects</div>
   <div class="tbadge"><b>&lt;/&gt; Full-stack</b><span>Laravel</span><span>React</span><span>Flutter</span></div>
   <div class="sig">Amaanullah<svg width="170" height="16" viewBox="0 0 170 16"><path d="M2 10 Q60 0 120 8 T168 4" fill="none" stroke="#f26a1b" stroke-width="2.5" stroke-linecap="round"/></svg></div>
   <div class="cube3" style="--s:20px;right:24px;top:-14px;animation-duration:7s"><i></i><i></i><i></i><i></i><i></i><i></i></div>
  </div>
  <div class="atext" style="position:relative">
   <div class="av"><span class="pill2">About Me</span>
    <div class="hand hnote">Clean code,<br>real results ↘</div>
    <h2>Turning <em>complex problems</em><br>into simple, <em>scalable software</em></h2>
    <p class="bio">I'm Amaanullah, a web developer focused on software solutions that actually move a business forward. I design and build custom web apps, CRMs, chat platforms, automations and mobile apps, from the first idea to a secure, scalable product. I care about clean architecture, fast interfaces and software that's simple for the people who use it every day.</p></div>
   <div class="stats av" style="transition-delay:.12s">
    <!-- EDIT STATS: set data-to to your real number and the suffix text; these are placeholders -->
    <div class="st"><b><span data-ph="X">X</span><em>+</em></b><small>Years Experience</small></div><!-- EDIT: years -->
    <div class="st"><b><span data-ph="XX">XX</span><em>+</em></b><small>Projects Delivered</small></div><!-- EDIT: projects -->
    <div class="st"><b><span data-ph="XX">XX</span><em>+</em></b><small>Happy Clients</small></div><!-- EDIT: clients -->
    <div class="st dk"><b><span data-to="5">0</span>M<em>+</em></b><small>Leads handled by CRM</small></div><!-- EDIT: leads (from your CRM project) -->
   </div>
   <div class="skills av" style="transition-delay:.22s">
    <!-- EDIT SKILLS: change --w to set each proficiency bar -->
    <div class="sk"><div class="h"><span class="lg" style="background:#7a86b8">PHP</span>PHP</div><div class="bar"><i style="--w:95%"></i></div><span class="lv">Expert</span></div>
    <div class="sk"><div class="h"><span class="lg" style="background:#ff2d20">L</span>Laravel</div><div class="bar"><i style="--w:95%"></i></div><span class="lv">Expert</span></div>
    <div class="sk"><div class="h"><span class="lg" style="background:#512bd4">.N</span>.NET</div><div class="bar"><i style="--w:75%"></i></div><span class="lv">Advanced</span></div>
    <div class="sk"><div class="h"><span class="lg" style="background:#3776ab">Py</span>Python</div><div class="bar"><i style="--w:70%"></i></div><span class="lv">Advanced</span></div>
    <div class="sk"><div class="h"><span class="lg" style="background:#00758f">SQL</span>MySQL</div><div class="bar"><i style="--w:90%"></i></div><span class="lv">Expert</span></div>
    <div class="sk"><div class="h"><span class="lg" style="background:#20232a;color:#61dafb">⚛</span>React</div><div class="bar"><i style="--w:82%"></i></div><span class="lv">Advanced</span></div>
    <div class="sk"><div class="h"><span class="lg" style="background:#539e43">JS</span>Node.js</div><div class="bar"><i style="--w:80%"></i></div><span class="lv">Advanced</span></div>
    <div class="sk"><div class="h"><span class="lg" style="background:#47c5fb">F</span>Flutter</div><div class="bar"><i style="--w:78%"></i></div><span class="lv">Advanced</span></div>
   </div>
   <div class="actas av" style="transition-delay:.3s">
    <a class="cv" href="javascript:void(0)"><!-- URL: link to your CV file, e.g. files/Amaanullah-CV.pdf (add the download attribute) -->⤓ Download CV</a>
    <a class="lt2" href="javascript:void(0)"><!-- URL: contact page or #contact -->Let's Talk &nbsp;→</a>
    <span class="hand" style="color:var(--o);transform:rotate(-5deg)">↖ let's work together!</span>
   </div>
  </div>
 </div>
 <div class="journey av">
  <div class="jbg"></div>
  <h3>My <em>Approach</em></h3><p>A simple, transparent process from idea to launch.</p>
  <div class="steps">
   <div class="stp"><span class="n">01</span><b>Discover</b><small>Understand your business, users and goals before writing a single line of code.</small></div>
   <div class="stp"><span class="n">02</span><b>Design</b><small>Plan the architecture and craft clean, intuitive UI/UX flows.</small></div>
   <div class="stp"><span class="n">03</span><b>Develop</b><small>Build secure, scalable software with regular demos and feedback.</small></div>
   <div class="stp"><span class="n">04</span><b>Deliver</b><small>Launch, monitor and keep improving with ongoing support.</small></div>
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
   <h2>What <em>clients say</em><br>about <em>working</em> with me</h2>
   <p class="sub">Feedback from the teams and businesses I've built software for. Drag or swipe the cards to read more.</p>
   <div class="agg"><!-- EDIT: replace X.X and XX with your real rating and review count -->
    <span class="big">X.X</span><div><span class="stars">★★★★★</span><small>Average rating · XX reviews</small></div>
    <div class="avs"><img src="<?= asset_url('images/avatar-1.svg') ?>" alt=""><img src="<?= asset_url('images/avatar-2.svg') ?>" alt=""><img src="<?= asset_url('images/avatar-3.svg') ?>" alt=""><img src="<?= asset_url('images/avatar-4.svg') ?>" alt=""></div>
   </div>
   <div class="dctl"><button id="dPrev" aria-label="Previous review">←</button><button id="dNext" aria-label="Next review">→</button><div class="dots2" id="dDots"></div><span class="hnt">drag me ↗</span></div>
  </div>
  <div class="deck tv" id="deck" style="transition-delay:.15s">
   <!-- EDIT: each .qc card is a SAMPLE testimonial; replace the text, name, company, avatar and project with real ones -->
   <div class="qc"><!-- EDIT: replace with real testimonial --><div class="qbg"></div><span class="qm">“</span><span class="pj">◆ Multi-tenant CRM</span><div class="stars">★★★★★</div>
    <blockquote>Sample testimonial: the CRM changed how our team handles leads. Everything is in one place, it's fast, and the permission levels fit exactly how we work.</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-1.svg') ?>" alt="Client avatar"><div><b>Client Name</b><small>Role, Company Name</small></div></div><span class="smp">SAMPLE REVIEW</span></div>
   <div class="qc"><!-- EDIT: replace with real testimonial --><div class="qbg"></div><span class="qm">“</span><span class="pj">◆ Chatrox</span><div class="stars">★★★★★</div>
    <blockquote>Sample testimonial: our team moved its internal communication to Chatrox. Channels, files and real-time messaging just work, on desktop and mobile.</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-2.svg') ?>" alt="Client avatar"><div><b>Client Name</b><small>Role, Company Name</small></div></div><span class="smp">SAMPLE REVIEW</span></div>
   <div class="qc lite"><!-- EDIT: replace with real testimonial --><div class="qbg"></div><span class="qm">“</span><span class="pj">◆ RTG Workspace</span><div class="stars">★★★★★</div>
    <blockquote>Sample testimonial: RTG Workspace gave us a clear board for every project. Task tracking and file sharing replaced three separate tools.</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-3.svg') ?>" alt="Client avatar"><div><b>Client Name</b><small>Role, Company Name</small></div></div><span class="smp">SAMPLE REVIEW</span></div>
   <div class="qc"><!-- EDIT: replace with real testimonial --><div class="qbg"></div><span class="qm">“</span><span class="pj">◆ IT Hardware Bin</span><div class="stars">★★★★★</div>
    <blockquote>Sample testimonial: the store, quote requests and checkout were delivered on time and are easy for our staff to manage day to day.</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-4.svg') ?>" alt="Client avatar"><div><b>Client Name</b><small>Role, Company Name</small></div></div><span class="smp">SAMPLE REVIEW</span></div>
   <div class="qc lite"><!-- EDIT: replace with real testimonial --><div class="qbg"></div><span class="qm">“</span><span class="pj">◆ Landsfy</span><div class="stars">★★★★★</div>
    <blockquote>Sample testimonial: Landsfy made our listings easy to search and manage, and the role-based access keeps agents and admins in the right places.</blockquote>
    <div class="who"><img src="<?= asset_url('images/avatar-5.svg') ?>" alt="Client avatar"><div><b>Client Name</b><small>Role, Company Name</small></div></div><span class="smp">SAMPLE REVIEW</span></div>
  </div>
 </div>
 <div class="mq tv" style="transition-delay:.25s">
  <!-- EDIT: marquee chips are SAMPLE reviews; replace with real short quotes (row content is duplicated by script for the loop) -->
  <div class="mrow" id="mr1">
   <div class="chipr"><img src="<?= asset_url('images/avatar-1.svg') ?>" alt=""><div><b>Client Name · Company Name</b><small>"Sample: fast, clear communication."</small></div><span class="s">★★★★★</span></div><!-- EDIT: replace with real testimonial -->
   <div class="chipr dk"><img src="<?= asset_url('images/avatar-2.svg') ?>" alt=""><div><b>Client Name · Company Name</b><small style="color:#aaa">"Sample: delivered exactly what we needed."</small></div><span class="s">★★★★★</span></div><!-- EDIT: replace with real testimonial -->
   <div class="chipr"><img src="<?= asset_url('images/avatar-3.svg') ?>" alt=""><div><b>Client Name · Company Name</b><small>"Sample: clean code and great support."</small></div><span class="s">★★★★★</span></div><!-- EDIT: replace with real testimonial -->
   <div class="chipr"><img src="<?= asset_url('images/avatar-4.svg') ?>" alt=""><div><b>Client Name · Company Name</b><small>"Sample: our workflows run themselves now."</small></div><span class="s">★★★★★</span></div><!-- EDIT: replace with real testimonial -->
  </div>
  <div class="mrow rev2" id="mr2">
   <div class="chipr dk"><img src="<?= asset_url('images/avatar-5.svg') ?>" alt=""><div><b>Client Name · Company Name</b><small style="color:#aaa">"Sample: the app feels native on both phones."</small></div><span class="s">★★★★★</span></div><!-- EDIT: replace with real testimonial -->
   <div class="chipr"><img src="<?= asset_url('images/avatar-1.svg') ?>" alt=""><div><b>Client Name · Company Name</b><small>"Sample: dashboards our managers love."</small></div><span class="s">★★★★★</span></div><!-- EDIT: replace with real testimonial -->
   <div class="chipr"><img src="<?= asset_url('images/avatar-2.svg') ?>" alt=""><div><b>Client Name · Company Name</b><small>"Sample: secure, scalable and on budget."</small></div><span class="s">★★★★★</span></div><!-- EDIT: replace with real testimonial -->
   <div class="chipr"><img src="<?= asset_url('images/avatar-3.svg') ?>" alt=""><div><b>Client Name · Company Name</b><small>"Sample: would happily work together again."</small></div><span class="s">★★★★★</span></div><!-- EDIT: replace with real testimonial -->
  </div>
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
   <h2>Have an idea?<br><em>Let's build something great.</em></h2>
   <p class="cs">Tell me about your project, whether it's a web app, CRM, chat platform, automation or mobile app, and I'll turn it into a scalable product.</p>
   <div class="cbtns">
    <a class="mag" id="mag" href="#contact"><!-- scrolls to the contact form -->Start a Project <span>→</span></a>
    <a class="bcall" href="javascript:void(0)"><!-- URL: booking link, e.g. Calendly -->☏ Book a Call</a>
   </div>
   <div class="cchips">
    <a href="javascript:void(0)"><!-- URL: mailto:your@email.com --><i style="background:rgba(242,106,27,.25)">✉</i>your@email.com</a><!-- EDIT: your email -->
    <a href="javascript:void(0)"><!-- URL: https://wa.me/<your number> --><i style="background:rgba(37,211,102,.25)">✆</i>WhatsApp</a>
   </div>
  </div>
  <div class="ficons">
   <span class="fi2" style="left:8%;top:16%;color:#ff8a3d">&lt;/&gt;<small>Web Apps</small></span>
   <span class="fi2" style="left:52%;top:8%;animation-delay:-1s">☁<small>CRM</small></span>
   <span class="fi2" style="left:80%;top:36%;animation-delay:-2s">💬<small>Chat</small></span>
   <span class="fi2" style="left:30%;top:46%;animation-delay:-3s">⚙<small>Automation</small></span>
   <span class="fi2" style="left:64%;top:66%;animation-delay:-4s">▯<small>Mobile</small></span>
   <span class="fi2" style="left:4%;top:72%;animation-delay:-5s">🎨<small>UI/UX</small></span>
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
  <h2>Let's start your <em>next project</em><br>and make it <em>real</em></h2>
  <p class="sub">Share a few details about what you need and I'll get back to you with ideas, a timeline and a clear estimate.</p>
  <div class="reply">I usually reply within 24 hours<svg width="60" height="44" viewBox="0 0 60 44" fill="none" stroke="#f26a1b" stroke-width="2.4" stroke-linecap="round"><path d="M4 4C14 20 30 34 54 38M46 30l9 8-11 4"/></svg></div>
 </div>
 <div class="cgrid">
  <aside class="icard cv2" style="transition-delay:.1s">
   <div class="ibg"></div>
   <span class="avail2"><i></i>Available for projects</span>
   <h3>Contact Information</h3>
   <p>Prefer a direct line? Reach me on any of these, whichever suits you best.</p>
   <div class="irows">
    <a class="irow" href="javascript:void(0)"><!-- URL: mailto:your@email.com --><span class="ii">✉</span><span><small>Email</small><b>your@email.com</b></span></a><!-- EDIT: your email -->
    <a class="irow" href="javascript:void(0)"><!-- URL: https://wa.me/92XXXXXXXXXX --><span class="ii">✆</span><span><small>Phone / WhatsApp</small><b>+92 XXX XXXXXXX</b></span></a><!-- EDIT: your number -->
    <div class="irow"><span class="ii">⌖</span><span><small>Location</small><b>City, Country</b></span></div><!-- EDIT: your location -->
    <div class="irow"><span class="ii">◷</span><span><small>Working Hours</small><b>Mon – Fri, 9:00 – 18:00</b></span></div><!-- EDIT: your hours -->
   </div>
   <div class="socials">
    <a href="javascript:void(0)" aria-label="GitHub"><!-- URL: GitHub profile --><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 .5a11.5 11.5 0 0 0-3.6 22.4c.6.1.8-.3.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.8 1.3 3.5 1 .1-.8.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.7 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.2 1.2a11 11 0 0 1 5.8 0c2.2-1.5 3.2-1.2 3.2-1.2.6 1.6.2 2.8.1 3.1.8.8 1.2 1.9 1.2 3.1 0 4.4-2.7 5.4-5.3 5.7.4.4.8 1.1.8 2.2v3.2c0 .3.2.7.8.6A11.5 11.5 0 0 0 12 .5z"/></svg></a>
    <a href="javascript:void(0)" aria-label="LinkedIn"><!-- URL: LinkedIn profile --><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM9 9h3.8v1.7h.1c.5-1 1.8-2 3.8-2 4 0 4.8 2.6 4.8 6V21h-4v-5.6c0-1.3 0-3-1.9-3s-2.1 1.4-2.1 2.9V21H9z"/></svg></a>
    <a href="javascript:void(0)" aria-label="X"><!-- URL: X profile --><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.2 2h3.4l-7.4 8.5L23 22h-6.8l-5.3-7-6.1 7H1.4l7.9-9L1 2h7l4.8 6.4zm-1.2 18h1.9L7.1 3.9H5.1z"/></svg></a>
    <a href="javascript:void(0)" aria-label="Instagram"><!-- URL: Instagram profile --><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg></a>
    <a href="javascript:void(0)" aria-label="WhatsApp"><!-- URL: https://wa.me/92XXXXXXXXXX --><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2zm5.2 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.5-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.9s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.9 2.1c.1.2.1.4 0 .5l-.4.6-.4.4c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.4 2.4 1.5.3.1.5.1.6-.1l.9-1c.2-.3.4-.2.7-.1l2 1c.3.1.5.2.5.3.1.2.1.7-.1 1.3z"/></svg></a>
   </div>
  </aside>
  <div style="position:relative" class="cv2">
   <div class="fglow"></div>
   <div class="fglass" id="fglass" style="transition-delay:.2s">
    <!-- LARAVEL: change action to {{ route('contact.store') }} and remove the fake submit handler in the script (search "FAKE SUBMIT").
         Controller example: Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
         Alternatives: Formspree (action="https://formspree.io/f/XXXX") or any backend endpoint. -->
    <form id="cform" method="POST" action="javascript:void(0)" novalidate>
     <!-- LARAVEL: uncomment the next line in a Blade view -->
     <!-- @csrf -->
     <input type="hidden" name="_token" value=""><!-- LARAVEL: @csrf renders this token automatically; delete this placeholder -->
     <!-- LARAVEL: show a global error list here if needed:
          @if ($errors->any()) <div class="alert">{{ $errors->first() }}</div> @endif
          For each field use value="{{ old('name') }}" and render @error('name') <span class="err">{{ $message }}</span> @enderror in its .err span. -->
     <div class="hp" aria-hidden="true"><label>Leave this empty<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div><!-- honeypot: reject the request server-side if "website" is filled -->
     <div class="frow">
      <div class="fl"><input id="f_name" name="name" type="text" placeholder=" " autocomplete="name" required minlength="2"><!-- LARAVEL: value="{{ old('name') }}" --><label for="f_name">Your Name *</label><span class="err">Please enter your name.</span></div>
      <div class="fl"><input id="f_email" name="email" type="email" placeholder=" " autocomplete="email" required><!-- LARAVEL: value="{{ old('email') }}" --><label for="f_email">Email Address *</label><span class="err">Please enter a valid email.</span></div>
     </div>
     <div class="frow">
      <div class="fl"><input id="f_phone" name="phone" type="tel" placeholder=" " autocomplete="tel" pattern="[0-9+ ()\-]{7,20}"><!-- LARAVEL: value="{{ old('phone') }}" --><label for="f_phone">Phone (optional)</label><span class="err">Please enter a valid phone number.</span></div>
      <div class="fl"><select id="f_service" name="service" required><!-- LARAVEL: mark the option matching old('service') as selected -->
        <option value="">Choose a service…</option><option value="web_apps">Custom Web Apps</option><option value="crm">CRM Development</option><option value="chat">Chat Applications</option><option value="automation">Business Process Automation</option><option value="mobile">Mobile App Development</option><option value="ui_ux">UI/UX &amp; Performance</option></select><label for="f_service">Service *</label><span class="err">Please choose a service.</span></div>
     </div>
     <span class="glab">Quick pick a service</span>
     <div class="chs" id="svcChips"><button type="button" data-v="web_apps">Web Apps</button><button type="button" data-v="crm">CRM</button><button type="button" data-v="chat">Chat</button><button type="button" data-v="automation">Automation</button><button type="button" data-v="mobile">Mobile</button><button type="button" data-v="ui_ux">UI/UX</button></div>
     <span class="glab">Budget range</span>
     <input type="hidden" name="budget" id="f_budget" value=""><!-- LARAVEL: value="{{ old('budget') }}" -->
     <div class="chs" id="budChips"><button type="button" data-v="under_1k">&lt; $1k</button><button type="button" data-v="1k_5k">$1k – $5k</button><button type="button" data-v="5k_10k">$5k – $10k</button><button type="button" data-v="10k_plus">$10k+</button><button type="button" data-v="not_sure">Not sure yet</button></div>
     <div class="fl"><textarea id="f_message" name="message" placeholder=" " required minlength="10"></textarea><!-- LARAVEL: {{ old('message') }} inside the textarea --><label for="f_message">Tell me about your project *</label><span class="err">Please write at least 10 characters.</span></div>
     <div class="fsend"><button class="sbtn" id="sbtn" type="submit"><span class="tx">Send Message &nbsp;→</span><span class="sp"></span></button><span class="fnote">🔒 Your details stay private.</span></div>
    </form>
    <div class="success" role="status" aria-live="polite"><span class="ck"><svg width="40" height="40" viewBox="0 0 40 40" fill="none" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21l7 7 15-16"/></svg></span><h4>Message sent!</h4><p>Thanks for reaching out. I'll get back to you within 24 hours.</p><button type="button" id="fagain">Send another message</button></div>
   </div>
  </div>
 </div>
</section>
<!-- ===== FOOTER ===== -->
<?php require view_path('layouts/footer.php'); ?>


<script type="module" src="<?= asset_url('js/index-2.js') ?>"></script>
<script type="module" src="<?= asset_url('js/index-3.js') ?>"></script>
<script type="module" src="<?= asset_url('js/index-4.js') ?>"></script><script src="<?= asset_url('js/chatbot-config.js') ?>"></script><!-- EDIT: chatbot config -->
<script src="<?= asset_url('js/chatbot.js') ?>" defer></script>
</body></html>
