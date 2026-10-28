<?php
$p = $item ?? [];
$slug = $p['slug'] ?? 'chatrox';
$title = $p['title'] ?? 'Chatrox – Custom Enterprise Chat App';
$highlightEm = $p['highlight_em'] ?? ($slug === 'chatrox' ? '(Slack Alternative)' : '');
$domain = $p['domain'] ?? '';
$summary = $p['summary'] ?? 'A fully owned, real-time enterprise messaging and professional networking platform: the speed of Slack with the control of a private system.';
$catSlug = $p['category_slug'] ?? 'products';
$catName = match($catSlug) {
    'web-design-development' => 'Web Design & Development',
    'web-applications'       => 'Web Applications',
    'mobile-apps'            => 'Mobile Apps',
    default                  => 'Products',
};
$seoTitle = !empty($p['seo_title']) ? $p['seo_title'] : ($title . ($highlightEm ? " $highlightEm" : '') . ' | Case Study · Amaanullah Khan');
$metaDesc = !empty($p['meta_description']) ? $p['meta_description'] : $summary;
$bannerUrl = !empty($p['banner']) ? asset_url($p['banner']) : asset_url('images/banners/chatrox.svg');
$bannerAlt = $p['banner_alt'] ?? ($title . ' banner');
$client = $p['client'] ?? 'Internal Enterprise Digital Tool';
$industry = $p['industry'] ?? 'Communication Tech / Enterprise Systems';
$role = $p['role'] ?? 'Lead Full-Stack Architect';
$timeline = $p['timeline'] ?? '4–5 months';
$platform = $p['platform'] ?? 'Web & Mobile (Flutter)';
$projectStatus = $p['project_status'] ?? 'Completed';
$chips = !empty($p['tech_chips']) ? array_filter(array_map('trim', explode(',', $p['tech_chips']))) : ['Flutter', 'Firebase Real-Time Database', 'WebSockets', 'PHP', 'Cloud Storage'];
$tldr = !empty($p['tldr']) ? $p['tldr'] : 'Custom enterprise-grade solution built for scalability, security, and direct integration into core business operations.';
$keyResultsRaw = !empty($p['key_results']) ? explode("\n", trim($p['key_results'])) : [
    'Real-time | sub-second delivery via WebSockets',
    '100% owned | messages, files & access data',
];
$ctaTitle = !empty($p['cta_title']) ? $p['cta_title'] : 'Ready to achieve similar results?';
$ctaText = !empty($p['cta_text']) ? $p['cta_text'] : 'Let’s discuss how we can build a similar high-performance solution for your business.';
$ctaLabel = !empty($p['cta_label']) ? $p['cta_label'] : 'Start your custom project →';
$prevProject = $prev ?? null;
$nextProject = $next ?? null;
$relatedProjects = $related ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($seoTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
<link rel="canonical" href="<?= base_url('/projects/' . $slug) ?>">
<meta property="og:type" content="article">
<meta property="og:title" content="<?= htmlspecialchars($title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($summary) ?>">
<meta property="og:image" content="<?= htmlspecialchars($bannerUrl) ?>">
<meta property="og:url" content="<?= base_url('/projects/' . $slug) ?>">
<meta property="article:author" content="Amaanullah Khan">
<meta property="article:section" content="<?= htmlspecialchars($catName) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($title) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($summary) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($bannerUrl) ?>">
<link rel="icon" href="<?= asset_url('logo-v2/favicon-32.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [{"@type": "ListItem", "position": 1, "name": "Home", "item": "<?= base_url('/') ?>"}, {"@type": "ListItem", "position": 2, "name": "Projects", "item": "<?= base_url('/projects') ?>"}, {"@type": "ListItem", "position": 3, "name": "<?= htmlspecialchars($catName) ?>", "item": "<?= base_url('/projects/category/' . $catSlug) ?>"}, {"@type": "ListItem", "position": 4, "name": "<?= htmlspecialchars($title) ?>", "item": "<?= base_url('/projects/' . $slug) ?>"}]}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": ["Article", "CreativeWork"], "headline": <?= json_encode($seoTitle) ?>, "description": <?= json_encode($metaDesc) ?>, "image": <?= json_encode($bannerUrl) ?>, "author": {"@type": "Person", "name": "Amaanullah Khan", "url": "<?= base_url('/about') ?>"}, "publisher": {"@type": "Person", "name": "Amaanullah Khan"}, "datePublished": "<?= !empty($p['published_at']) ? date('Y-m-d', strtotime($p['published_at'])) : date('Y-m-d') ?>", "dateModified": "<?= !empty($p['updated_at']) ? date('Y-m-d', strtotime($p['updated_at'])) : date('Y-m-d') ?>", "mainEntityOfPage": "<?= base_url('/projects/' . $slug) ?>"}</script>
<link rel="stylesheet" href="<?= asset_url('css/case-study.css') ?>?v=<?= time() ?>">
<link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
</head>
<body>
<div class="prog" id="prog"></div>
<?php $home = false; $active = 'Projects'; require view_path('layouts/header.php'); ?>

<main>
<div class="wrap">
 <nav class="crumb" aria-label="Breadcrumb"><ol><li><a href="<?= base_url('/') ?>">Home</a></li><li><a href="<?= base_url('/projects') ?>">Projects</a></li><li><a href="<?= base_url('/projects/category/' . $catSlug) ?>"><?= htmlspecialchars($catName) ?></a></li><li aria-current="page"><?= htmlspecialchars($title) ?></li></ol></nav>
 <section class="hero">
  <div class="badges"><span class="bdg"><?= htmlspecialchars($catName) ?></span><?php if ($domain): ?><span class="bdg l"><i></i><?= htmlspecialchars($domain) ?></span><?php endif; ?></div>
  <h1><?= htmlspecialchars($title) ?><?php if ($highlightEm): ?> <em><?= htmlspecialchars($highlightEm) ?></em><?php endif; ?></h1>
  <p class="sum"><?= htmlspecialchars($summary) ?></p>
  <div class="hmeta"><span>By Amaanullah Khan</span><span>·</span><span id="rtime">— min read</span><span>·</span><span>Updated <?= !empty($p['updated_at']) ? date('M Y', strtotime($p['updated_at'])) : date('M Y') ?></span></div>
  <div class="ban"><img src="<?= htmlspecialchars($bannerUrl) ?>" alt="<?= htmlspecialchars($bannerAlt) ?>" width="1600" height="1000" fetchpriority="high"></div>
  <dl class="facts"><div><dt>Client</dt><dd><?= htmlspecialchars($client) ?></dd></div><div><dt>Industry</dt><dd><?= htmlspecialchars($industry) ?></dd></div><div><dt>Role</dt><dd><?= htmlspecialchars($role) ?></dd></div><div><dt>Timeline</dt><dd><?= htmlspecialchars($timeline) ?></dd></div><div><dt>Platform</dt><dd><?= htmlspecialchars($platform) ?></dd></div><div><dt>Status</dt><dd><?= htmlspecialchars($projectStatus) ?></dd></div></dl>
  <div class="chips"><?php foreach ($chips as $ch): ?><span class="chip"><?= htmlspecialchars($ch) ?></span><?php endforeach; ?></div>
 </section>
 <section class="tldr" aria-label="Key results">
  <div class="tl main"><h2>TL;DR</h2><p><?= htmlspecialchars($tldr) ?></p></div>
  <?php foreach ($keyResultsRaw as $kr): $parts = explode('|', $kr, 2); ?>
  <div class="tl"><b><?= htmlspecialchars(trim($parts[0] ?? '')) ?></b><span><?= htmlspecialchars(trim($parts[1] ?? '')) ?></span></div>
  <?php endforeach; ?>
 </section>
 <div class="layout">
  <?php if ($slug === 'chatrox'): ?>
  <aside class="toc" aria-label="On this page"><div class="rt"><span>On this page</span><span id="pct">0%</span></div><div class="bar"><i id="tbar"></i></div><ol><li><a href="#overview">Overview</a></li><li><a href="#challenge">The Challenge</a></li><li><a href="#goals">Goals</a></li><li><a href="#role">My Role &amp; Team</a></li><li><a href="#research">Research &amp; Discovery</a></li><li><a href="#architecture">Solution Architecture</a></li><li><a href="#features">Key Features</a></li><li><a href="#process">Development Process</a></li><li><a href="#stack">Tech Stack</a></li><li><a href="#challenges">Challenges &amp; Solutions</a></li><li><a href="#security">Security &amp; Performance</a></li><li><a href="#integrations">Integrations</a></li><li><a href="#results">Results &amp; Impact</a></li><li><a href="#gallery">Gallery</a></li><li><a href="#testimonial">Testimonial</a></li><li><a href="#lessons">Lessons Learned</a></li><li><a href="#faq">FAQ</a></li></ol>
   <div class="share">Share<br><a href="javascript:void(0)">LinkedIn</a><a href="javascript:void(0)">X</a><a href="javascript:void(0)" id="copy">Copy link</a></div></aside>
  <div class="mtoc"><details><summary>On this page <span id="mcur">Overview</span></summary><ol><li><a href="#overview">Overview</a></li><li><a href="#challenge">The Challenge</a></li><li><a href="#goals">Goals</a></li><li><a href="#role">My Role &amp; Team</a></li><li><a href="#research">Research &amp; Discovery</a></li><li><a href="#architecture">Solution Architecture</a></li><li><a href="#features">Key Features</a></li><li><a href="#process">Development Process</a></li><li><a href="#stack">Tech Stack</a></li><li><a href="#challenges">Challenges &amp; Solutions</a></li><li><a href="#security">Security &amp; Performance</a></li><li><a href="#integrations">Integrations</a></li><li><a href="#results">Results &amp; Impact</a></li><li><a href="#gallery">Gallery</a></li><li><a href="#testimonial">Testimonial</a></li><li><a href="#lessons">Lessons Learned</a></li><li><a href="#faq">FAQ</a></li></ol></details></div>
  <article class="content" id="content">

<section class="sec rv" id="overview" aria-labelledby="h-overview">
 <p class="eyb"><span>01 · Overview</span></p>
 <h2 id="h-overview">Building a Fully Owned Slack Alternative for Enterprise Teams</h2>
 <p class="lead"><strong>Chatrox</strong> is a custom real-time enterprise messaging and professional networking platform built for organizations that need the speed of Slack, the control of a private system, and the flexibility of a purpose-built internal communication product.</p>
 <p>Instead of depending on recurring per-user SaaS subscriptions, limited workspace policies, and third-party data storage, Chatrox gives the business full ownership over chat history, files, channels, user access, and future integrations. The project was engineered as a serious custom chat application development case study for companies that want private, scalable, and secure communication infrastructure.</p>
 <p>The platform supports private one-to-one messaging, team channels, live user presence, typing indicators, media/file sharing, pinned messages, real-time notifications, role-aware access boundaries, and a professional team networking experience.</p>
 <aside class="pull"><p>It is not just a chat UI; it is a complete communication layer that can sit inside a CRM, HRM, ticketing platform, project management system, or enterprise SaaS product.</p></aside>
 <p>This makes Chatrox highly relevant for businesses planning custom web application development, business process automation, or a private internal collaboration hub.</p>
</section>

<section class="sec rv" id="challenge" aria-labelledby="h-challenge">
 <p class="eyb"><span>02 · The Challenge</span></p>
 <h2 id="h-challenge">Why Chatrox Was Built Instead of Using Slack or Microsoft Teams</h2>
 <p>Commercial messaging platforms are fast to start with, but they become restrictive when a company needs deeper workflow control, custom data retention rules, internal automation, private hosting, and integrations tailored to its own departments.</p>
 <p>Chatrox solves this by replacing the generic SaaS model with a dedicated communication engine owned by the business.</p>
 <div class="pts"><div class="pt"><b>Data Ownership</b><p>Messages, files, channels, and internal discussions remain under the company’s own infrastructure instead of being stored only inside a third-party SaaS workspace.</p></div><div class="pt"><b>Lower Long-Term Cost</b><p>The system removes per-user pricing pressure and becomes more cost-effective as the team grows.</p></div><div class="pt"><b>Custom Workflow Fit</b><p>Channels, roles, notifications, moderation, AI bots, ticket creation, CRM records, and HR workflows can be shaped around the business process instead of generic workspace limitations.</p></div><div class="pt"><b>Enterprise Expansion</b><p>The architecture can be extended into a multi-company SaaS communication platform, a private networking product, or an embedded chat module for larger systems.</p></div></div>
</section>

<section class="sec rv" id="goals" aria-labelledby="h-goals">
 <p class="eyb"><span>03 · Goals</span></p>
 <h2 id="h-goals">Project Goals for a Private Enterprise Messenger</h2>
 <p>From the brief, the goal was to reduce subscription dependency, improve data sovereignty, and create a modular system that could evolve with the company instead of forcing the company to adjust to a fixed vendor roadmap.</p>
 <ol class="goals"><li><b>Reduce subscription dependency</b><span>Replace recurring per-user SaaS pricing with an owned platform.</span></li>
 <li><b>Improve data sovereignty</b><span>Keep messages, files and access events on company infrastructure.</span></li>
 <li><b>Stay modular</b><span>A system that grows with the company’s own roadmap.</span></li></ol>
</section>

<section class="sec rv" id="role" aria-labelledby="h-role">
 <p class="eyb"><span>04 · My Role &amp; Team</span></p>
 <h2 id="h-role">My Role, Responsibilities &amp; Team</h2>
 <p>As the Lead Full-Stack Architect, I led the complete technical execution from WebSocket architecture to mobile client integration in Flutter and backend database design.</p>
</section>

<section class="sec rv" id="research" aria-labelledby="h-research">
 <p class="eyb"><span>05 · Research &amp; Discovery</span></p>
 <h2 id="h-research">Research &amp; Discovery</h2>
 <p>We audited common pain points with existing enterprise chat tools: bloated interfaces, unexpected subscription fee jumps, loss of historical data on lower tiers, and lack of deep integration with internal company workflows.</p>
</section>

<section class="sec rv" id="architecture" aria-labelledby="h-architecture">
 <p class="eyb"><span>06 · Solution Architecture</span></p>
 <h2 id="h-architecture">Real-Time WebSocket Messaging Architecture</h2>
 <p>The technical foundation of Chatrox is its <strong>real-time WebSocket communication layer</strong>. Traditional AJAX polling creates unnecessary server load because the browser repeatedly checks for new messages even when nothing has changed.</p>
 <p>Chatrox uses persistent socket connections so new messages, typing states, online/offline activity, and notifications are pushed instantly to the right users. This creates a native-app-like experience inside a browser while keeping the backend efficient under heavy usage.</p>
 <figure class="arch" aria-label="Chatrox architecture diagram">
 <div class="lane"><span class="lt">Clients</span><div class="node">Web app<small>browser</small></div><div class="node">Flutter app<small>Android / iOS</small></div></div>
 <div class="flow"><i></i><span>persistent WebSocket</span><i></i></div>
 <div class="lane"><span class="lt">Real-time</span><div class="node hot">Socket layer<small>messages · typing · presence · notifications</small></div></div>
 <div class="flow"><i></i><span>validated by role</span><i></i></div>
 <div class="lane"><span class="lt">Core</span><div class="node">PHP backend<small>auth · roles · channel rules</small></div><div class="node">Database<small>messages · channels · membership</small></div><div class="node">Cloud storage<small>files &amp; media</small></div></div>
 <figcaption>Simplified view. Delivery runs on the socket layer; storage stays structured for long-term retrieval.</figcaption>
</figure>
 <div class="take"><b>Key takeaway</b><p>Push, don’t poll: the socket layer handles instant delivery while the message store stays structured for history and search.</p></div>
</section>

<section class="sec rv" id="features" aria-labelledby="h-features">
 <p class="eyb"><span>07 · Key Features</span></p>
 <h2 id="h-features">Enterprise Collaboration Features Beyond Basic Chat</h2>
 <p>Chatrox was planned as a full collaboration ecosystem, not a minimal messenger. The platform supports productivity features that are often required inside real business teams: pinned messages, rich media sharing, reply threads, reactions, channel-based communication, private conversations, and modular notification handling.</p>
 <div class="fgrid"><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5h16v11H8l-4 4z"/></svg></span><h3>Instant Private Messages</h3><p>Direct conversations update in real time with no manual refresh and no delayed polling cycle.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 3 7 21M17 3l-2 18M4 8h17M3 16h17"/></svg></span><h3>Live Channels</h3><p>Departmental or project-based channels let teams collaborate around specific work areas, similar to Slack channels but controlled through custom business rules.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="6" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="18" cy="12" r="1.6"/></svg></span><h3>Typing &amp; Presence Indicators</h3><p>Users can see when teammates are online, offline, typing, or active, improving collaboration speed and reducing communication friction.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 16V11a6 6 0 0 1 12 0v5l2 2H4zM10 20h4"/></svg></span><h3>Real-Time Notifications</h3><p>Message alerts, mentions, pinned updates, file shares, and channel activity are delivered instantly across the workspace.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 3h6l-1 6 4 4H6l4-4zM12 13v8"/></svg></span><h3>Pinned Messages</h3><p>Important decisions, deadlines, notices, and documents can be pinned inside conversations so teams can find them quickly later.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 8 4 13l6 5M4 13h10a6 6 0 0 1 6 6"/></svg></span><h3>Replies &amp; Context Preservation</h3><p>Reply-to-message functionality keeps conversations organized and prevents important context from getting buried inside fast-moving chats.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 11 12 19a5 5 0 0 1-7-7l8-8a3.5 3.5 0 0 1 5 5l-8 8a2 2 0 0 1-3-3l7-7"/></svg></span><h3>Media &amp; Attachments</h3><p>Teams can share screenshots, documents, audio notes, and project files directly inside relevant channels or private conversations.</p></article><article class="feat"><span class="fi"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="5" r="2.5"/><circle cx="5" cy="18" r="2.5"/><circle cx="19" cy="18" r="2.5"/><path d="M11 7 6 16M13 7l5 9M7.5 18h9"/></svg></span><h3>Professional Networking Layer</h3><p>User profiles, company teams, departments, availability, and internal relationship mapping make it useful for both communication and workforce discovery.</p></article></div>
</section>

<section class="sec rv" id="process" aria-labelledby="h-process">
 <p class="eyb"><span>08 · Development Process</span></p>
 <h2 id="h-process">Development Process &amp; Timeline</h2>
 <ol class="steps"><li><span class="sn">01</span><b>Discovery</b><small>requirements & scope</small><em>2 weeks</em></li><li><span class="sn">02</span><b>Architecture</b><small>data model & socket design</small><em>3 weeks</em></li><li><span class="sn">03</span><b>Build</b><small>web, Flutter app & admin</small><em>8 weeks</em></li><li><span class="sn">04</span><b>Testing</b><small>load, roles & devices</small><em>2 weeks</em></li><li><span class="sn">05</span><b>Launch</b><small>rollout & handover</small><em>1 week</em></li></ol>
</section>

<section class="sec rv" id="stack" aria-labelledby="h-stack">
 <p class="eyb"><span>09 · Tech Stack</span></p>
 <h2 id="h-stack">Technology Stack</h2>
 <div class="stack"><div class="sg"><h3>Mobile</h3><ul><li><span class="chip">Flutter</span><small>Cross-platform mobile client with unified Dart codebase</small></li></ul></div><div class="sg"><h3>Real-time &amp; data</h3><ul><li><span class="chip">WebSockets</span><small>persistent connections push messages, typing and presence instantly</small></li><li><span class="chip">Firebase Real-Time Database</span><small>Low-latency sync for presence and active conversation feeds</small></li></ul></div><div class="sg"><h3>Backend &amp; storage</h3><ul><li><span class="chip">PHP (Backend Logic)</span><small>Fast, robust business logic and role boundary enforcement</small></li><li><span class="chip">Cloud Storage</span><small>Secure, encrypted file and media storage</small></li></ul></div></div>
</section>

<section class="sec rv" id="challenges" aria-labelledby="h-challenges">
 <p class="eyb"><span>10 · Challenges &amp; Solutions</span></p>
 <h2 id="h-challenges">Strategic Execution &amp; Challenges</h2>
 <p>Three key architectural challenges shaped the build.</p>
 <details class="cs" open><summary><span class="cn">01</span><h3>Replacing Slack With Owned Enterprise Communication Infrastructure</h3><span class="pm" aria-hidden="true"></span></summary>
 <div class="csb"><div class="row"><span class="tag t1">The challenge</span><p>The company needed a reliable internal communication system without rising per-user costs and limited customization of commercial tools.</p></div><div class="row"><span class="tag t2">Strategic solution</span><p>I architected Chatrox as a fully owned custom enterprise messaging platform with private conversations, team channels, file sharing, and role-based access governance.</p></div><div class="row"><span class="tag t3">Impact / result</span><p>The organization gained a private communication ecosystem that eliminates per-user pricing while improving data ownership.</p></div></div></details>
 <details class="cs"><summary><span class="cn">02</span><h3>Real-Time WebSocket Delivery, Presence &amp; Notifications</h3><span class="pm" aria-hidden="true"></span></summary>
 <div class="csb"><div class="row"><span class="tag t1">The challenge</span><p>Users expect messages, typing states, and online/offline presence to appear instantly without page refresh or heavy AJAX polling.</p></div><div class="row"><span class="tag t2">Strategic solution</span><p>I implemented a WebSocket-driven real-time messaging architecture where active users maintain persistent socket connections.</p></div><div class="row"><span class="tag t3">Impact / result</span><p>Sub-second message delivery across web and mobile clients with zero lag.</p></div></div></details>
 <details class="cs"><summary><span class="cn">03</span><h3>Secure Channel Governance, Data Isolation &amp; Workflow Expansion</h3><span class="pm" aria-hidden="true"></span></summary>
 <div class="csb"><div class="row"><span class="tag t1">The challenge</span><p>A business chat platform must protect sensitive internal discussions, executive groups, and confidential files from unauthorized users.</p></div><div class="row"><span class="tag t2">Strategic solution</span><p>I designed a backend-enforced role-aware access control model where channel membership and private conversations are validated before data is served.</p></div><div class="row"><span class="tag t3">Impact / result</span><p>Strict data segregation with audit logs and seamless compatibility with future CRM and HRM integrations.</p></div></div></details>
</section>

<section class="sec rv" id="security" aria-labelledby="h-security">
 <p class="eyb"><span>11 · Security &amp; Performance</span></p>
 <h2 id="h-security">Role-Based Access, Channel Governance &amp; Data Isolation</h2>
 <p>Chatrox was designed with a role-aware access model supporting administrators, managers, members, private channels, and restricted internal spaces.</p>
 <div class="pts"><div class="pt"><b>Admin Control</b><p>Admins can manage users, channels, access rules, and workspace-level governance from a centralized control layer.</p></div><div class="pt"><b>Private Channel Boundaries</b><p>Sensitive departments or client-specific groups remain hidden from unauthorized users.</p></div><div class="pt"><b>Secure File Sharing</b><p>Files and media are attached to context, ensuring proper access control.</p></div><div class="pt"><b>Audit-Friendly Structure</b><p>Message logs and access events can be retained according to internal compliance policies.</p></div></div>
</section>

<section class="sec rv" id="integrations" aria-labelledby="h-integrations">
 <p class="eyb"><span>12 · Integrations</span></p>
 <h2 id="h-integrations">How Chatrox Connects With Wider Business Systems</h2>
 <p>A chat platform is most powerful when connected to core operations: CRM leads, HRM approvals, and ticket escalations.</p>
 <div class="pts"><div class="pt"><b>CRM Integration</b><p>Sales teams can connect chat activity with leads, clients, follow-ups, and pipeline notifications.</p></div><div class="pt"><b>HRM Integration</b><p>HR teams can connect announcements, leave requests, attendance notices, and employee support conversations.</p></div><div class="pt"><b>Helpdesk Integration</b><p>Internal complaints or IT support messages can become trackable tickets with status, priority, and resolution history.</p></div><div class="pt"><b>AI Knowledge Search</b><p>AI bots can summarize long threads, answer policy questions, and surface relevant files or decisions from past conversations.</p></div></div>
</section>

<section class="sec rv" id="results" aria-labelledby="h-results">
 <p class="eyb"><span>13 · Results &amp; Impact</span></p>
 <h2 id="h-results">Final Impact: A Private Communication System Built for Long-Term Control</h2>
 <div class="stats"><div class="stat"><b>Zero-Latency</b><span>Delivery</span><small>Sub-second message delivery</small></div><div class="stat"><b>Cross-Platform</b><span>Web &amp; Flutter</span><small>Unified team access everywhere</small></div><div class="stat ghost"><b>100%</b><span>Data Ownership</span><small>Zero third-party vendor lock-in</small></div></div>
 <div class="ba"><div class="b"><span class="bt">Before</span><ul><li>Recurring per-user SaaS subscriptions</li><li>Data stored in a third-party workspace</li><li>Generic workspace policies</li><li>Fixed vendor roadmap</li></ul></div><div class="arr" aria-hidden="true">→</div><div class="af"><span class="bt">After · Chatrox</span><ul><li>Owned platform, no per-user pricing pressure</li><li>Messages &amp; files on company infrastructure</li><li>Backend-enforced roles &amp; private channels</li><li>Roadmap shaped by the business</li></ul></div></div>
</section>

<section class="sec rv" id="gallery" aria-labelledby="h-gallery">
 <p class="eyb"><span>14 · Gallery</span></p>
 <h2 id="h-gallery">Chatrox Interface Gallery</h2>
 <div class="gal"><button class="gi" data-cap="Chatrox – Messaging dashboard" aria-label="Open image: Messaging dashboard"><img src="<?= asset_url('images/banners/chatrox.svg') ?>" alt="Chatrox Messaging dashboard banner" loading="lazy" width="1600" height="1000"><span>Messaging dashboard</span></button><button class="gi" data-cap="Chatrox – Mobile app (Flutter)" aria-label="Open image: Mobile app (Flutter)"><img src="<?= asset_url('images/banners/chatrox.svg') ?>" alt="Chatrox Mobile app (Flutter) banner" loading="lazy" width="1600" height="1000"><span>Mobile app (Flutter)</span></button><button class="gi" data-cap="Chatrox – Channels & presence" aria-label="Open image: Channels & presence"><img src="<?= asset_url('images/banners/chatrox.svg') ?>" alt="Chatrox Channels & presence banner" loading="lazy" width="1600" height="1000"><span>Channels & presence</span></button><button class="gi" data-cap="Chatrox – Admin & roles" aria-label="Open image: Admin & roles"><img src="<?= asset_url('images/banners/chatrox.svg') ?>" alt="Chatrox Admin & roles banner" loading="lazy" width="1600" height="1000"><span>Admin & roles</span></button></div>
</section>

<section class="sec rv" id="faq" aria-labelledby="h-faq">
 <p class="eyb"><span>15 · FAQ</span></p>
 <h2 id="h-faq">Project Technical FAQ</h2>
 <details class="fq"><summary>Why build a custom enterprise chat application instead of using Slack?<span class="pm" aria-hidden="true"></span></summary><div><p>A custom enterprise chat application gives the company full ownership over messages, files, roles, channels, data retention, and future integrations. It also eliminates long-term per-user subscription fees as the team grows.</p></div></details><details class="fq"><summary>How does the WebSocket system improve performance?<span class="pm" aria-hidden="true"></span></summary><div><p>Persistent WebSocket connections push data instantly from server to client with near-zero latency, avoiding the high CPU and bandwidth waste of HTTP polling.</p></div></details><details class="fq"><summary>Can Chatrox support private channels and restricted departments?<span class="pm" aria-hidden="true"></span></summary><div><p>Yes. Access is validated on the backend at both query and socket subscription levels, ensuring strict role and channel isolation.</p></div></details><details class="fq"><summary>Can this platform be connected with CRM, HRM, or helpdesk systems?<span class="pm" aria-hidden="true"></span></summary><div><p>Yes. The modular PHP backend provides REST and webhook APIs allowing bi-directional synchronization with external business systems.</p></div></details>
</section>
  </article>

  <?php else: ?>
  <!-- DYNAMIC CASE STUDY FOR OTHER PROJECTS -->
  <aside class="toc" aria-label="On this page"><div class="rt"><span>On this page</span><span id="pct">0%</span></div><div class="bar"><i id="tbar"></i></div><ol><li><a href="#overview">Overview</a></li><li><a href="#architecture">Architecture &amp; Features</a></li><li><a href="#stack">Technology Stack</a></li><li><a href="#results">Results &amp; Impact</a></li></ol>
   <div class="share">Share<br><a href="javascript:void(0)">LinkedIn</a><a href="javascript:void(0)">X</a><a href="javascript:void(0)" id="copy">Copy link</a></div></aside>
  <div class="mtoc"><details><summary>On this page <span id="mcur">Overview</span></summary><ol><li><a href="#overview">Overview</a></li><li><a href="#architecture">Architecture &amp; Features</a></li><li><a href="#stack">Technology Stack</a></li><li><a href="#results">Results &amp; Impact</a></li></ol></details></div>
  <article class="content" id="content">

   <?php if (!empty($p['body_html'])): ?>
     <?= $p['body_html'] ?>
   <?php else: ?>
     <section class="sec rv" id="overview" aria-labelledby="h-overview">
      <p class="eyb"><span>01 · Overview</span></p>
      <h2 id="h-overview"><?= htmlspecialchars($title) ?></h2>
      <p class="lead"><?= htmlspecialchars($summary) ?></p>
      <p><?= htmlspecialchars($tldr) ?></p>
      <div class="pts">
        <div class="pt"><b>Platform Scope</b><p><?= htmlspecialchars($platform) ?></p></div>
        <div class="pt"><b>Target Industry</b><p><?= htmlspecialchars($industry) ?></p></div>
        <div class="pt"><b>Role &amp; Ownership</b><p><?= htmlspecialchars($role) ?></p></div>
        <div class="pt"><b>Delivery Timeline</b><p><?= htmlspecialchars($timeline) ?> (Status: <?= htmlspecialchars($projectStatus) ?>)</p></div>
      </div>
     </section>

     <section class="sec rv" id="architecture" aria-labelledby="h-arch">
      <p class="eyb"><span>02 · Architecture &amp; Execution</span></p>
      <h2 id="h-arch">Custom Engineering &amp; System Capabilities</h2>
      <p>Engineered from ground up with clean code, secure role boundaries, and performant data structures to support reliable day-to-day operations.</p>
      <div class="pts">
       <div class="pt"><b>Data Integrity &amp; Security</b><p>Robust database schemas with transaction safety, audit-ready logs, and backend-enforced authorization rules.</p></div>
       <div class="pt"><b>Operational Efficiency</b><p>Designed to reduce manual overhead, speed up workflow execution, and provide real-time status visibility.</p></div>
       <div class="pt"><b>Scalability</b><p>Modular code architecture allowing fast future enhancements and enterprise multi-company expansion.</p></div>
      </div>
     </section>

     <section class="sec rv" id="stack" aria-labelledby="h-stack">
      <p class="eyb"><span>03 · Tech Stack</span></p>
      <h2 id="h-stack">Technologies &amp; Libraries Used</h2>
      <div class="chips" style="margin-top:16px">
       <?php foreach ($chips as $ch): ?><span class="chip"><?= htmlspecialchars($ch) ?></span><?php endforeach; ?>
      </div>
     </section>

     <section class="sec rv" id="results" aria-labelledby="h-results">
      <p class="eyb"><span>04 · Results &amp; Impact</span></p>
      <h2 id="h-results">Measured Impact &amp; Business Value</h2>
      <div class="stats">
       <?php foreach ($keyResultsRaw as $kr): $parts = explode('|', $kr, 2); ?>
       <div class="stat"><b><?= htmlspecialchars(trim($parts[0] ?? '')) ?></b><span><?= htmlspecialchars(trim($parts[1] ?? '')) ?></span></div>
       <?php endforeach; ?>
      </div>
      <p style="margin-top:20px"><?= htmlspecialchars($tldr) ?></p>
     </section>
   <?php endif; ?>

  </article>
  <?php endif; ?>
 </div>

 <nav class="pn" aria-label="More projects">
  <?php if ($prevProject): ?>
    <a href="<?= base_url('/projects/' . $prevProject['slug']) ?>"><small>← Previous project</small><b><?= htmlspecialchars($prevProject['title']) ?></b></a>
  <?php else: ?>
    <a href="<?= base_url('/projects') ?>"><small>← All projects</small><b>Explore Portfolio</b></a>
  <?php endif; ?>
  <?php if ($nextProject): ?>
    <a href="<?= base_url('/projects/' . $nextProject['slug']) ?>"><small>Next project →</small><b><?= htmlspecialchars($nextProject['title']) ?></b></a>
  <?php else: ?>
    <a href="<?= base_url('/projects') ?>"><small>Next →</small><b>All Projects</b></a>
  <?php endif; ?>
 </nav>

 <section class="rel" aria-labelledby="h-rel">
  <p class="eyb">Related systems</p>
  <h2 id="h-rel">More Projects</h2>
  <div class="rgrid">
    <?php foreach ($relatedProjects as $rel): 
      $rCat = match($rel['category_slug'] ?? '') {
        'web-design-development' => 'Web Design & Development',
        'web-applications'       => 'Web Applications',
        'mobile-apps'            => 'Mobile Apps',
        default                  => 'Products & Systems',
      };
      $rBanner = !empty($rel['banner']) ? asset_url($rel['banner']) : asset_url('images/banners/chatrox.svg');
    ?>
    <a class="rc" href="<?= base_url('/projects/' . $rel['slug']) ?>">
      <img src="<?= htmlspecialchars($rBanner) ?>" alt="<?= htmlspecialchars($rel['title']) ?>" loading="lazy" width="1600" height="1000">
      <div>
        <small><?= htmlspecialchars($rCat) ?></small>
        <h3><?= htmlspecialchars($rel['title']) ?></h3>
        <p><?= htmlspecialchars(mb_strimwidth($rel['summary'] ?? '', 0, 85, '…')) ?></p>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
 </section>

 <section class="cta">
  <div>
    <h2><?= htmlspecialchars($ctaTitle) ?></h2>
    <p><?= htmlspecialchars($ctaText) ?></p>
  </div>
  <a class="btn" href="<?= base_url('/#contact') ?>"><?= htmlspecialchars($ctaLabel) ?></a>
 </section>
</div>
</main>

<?php require view_path('layouts/footer.php'); ?>

<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Image preview"><button aria-label="Close">✕</button><figure><img alt=""><p></p></figure></div>
<script src="<?= asset_url('js/case-study.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script>
<script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= time() ?>" defer></script>
</body>
</html>