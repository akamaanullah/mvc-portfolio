<?php
$serviceMap = [];
foreach (($services ?? []) as $s) {
    if (!empty($s['slug'])) {
        $serviceMap[$s['slug']] = $s;
    }
}

$getSvc = function(string $slug, string $defTitle, string $defSummary, array $defTags = []) use ($serviceMap) {
    $row = $serviceMap[$slug] ?? null;
    $title = !empty($row['title']) ? $row['title'] : $defTitle;
    $summary = !empty($row['summary']) ? $row['summary'] : $defSummary;
    $tags = !empty($row['tags']) ? array_filter(array_map('trim', explode(',', $row['tags']))) : $defTags;
    $url = base_url('/services/' . ($row['slug'] ?? $slug));
    return ['title' => $title, 'summary' => $summary, 'tags' => $tags, 'url' => $url];
};

$schemaItems = [];
$pos = 1;
foreach (($services ?? []) as $sItem) {
    if (($sItem['status'] ?? 'published') !== 'published') continue;
    $schemaItems[] = [
        '@type' => 'ListItem',
        'position' => $pos++,
        'item' => [
            '@type' => 'Service',
            'name' => $sItem['title'],
            'description' => $sItem['summary'] ?? $sItem['title'],
            'serviceType' => $sItem['title'],
            'url' => base_url('/services/' . $sItem['slug']),
            'areaServed' => ['Pakistan', 'United States', 'United Kingdom', 'United Arab Emirates'],
            'provider' => [
                '@type' => 'Person',
                'name' => 'Amaanullah Khan',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Karachi',
                    'addressCountry' => 'PK'
                ]
            ]
        ]
    ];
}

$servicesFaqs = [
    [
        'question' => 'How much does custom software development cost?',
        'answer' => "It depends on scope, not a price list. The biggest cost drivers are the number of integrations, user roles and permissions, reporting needs, whether the system is multi-tenant, and whether you also need a mobile app. After a discovery call you receive a written quote with milestones, so you know the number before development starts."
    ],
    [
        'question' => 'How long does a custom software project take?',
        'answer' => "A focused CRM MVP usually takes 3–5 weeks. A larger multi-tenant platform or SaaS product runs about 2–4 months, and a custom Laravel web application typically takes 6–12 weeks, depending on database complexity and user roles. WordPress sites launch in 1–3 weeks. You get a specific timeline after the discovery call."
    ],
    [
        'question' => 'Should I build custom software or use an off-the-shelf tool?',
        'answer' => "If a ready-made tool covers almost everything and your team is small, use it. Custom software makes sense when per-user fees keep growing, your process doesn't fit the tool, or you need several systems to work together. I'll tell you honestly which side you're on."
    ],
    [
        'question' => 'Is custom software scalable?',
        'answer' => "Yes, when it is designed for it. Scalability depends on database design, how customer data is separated, and how heavy tasks run in the background. A multi-tenant CRM I built manages over 1.5 million leads for 300+ daily users."
    ],
    [
        'question' => 'Can you improve my existing system instead of rebuilding it?',
        'answer' => "Often, yes. I review the current setup, find what is actually causing slowdowns, downtime or security gaps, and fix it without a full rebuild unless a rebuild is genuinely needed. The Free Technical Audit is the starting point."
    ],
    [
        'question' => 'Can you integrate the software with tools we already use?',
        'answer' => "Yes. I build REST APIs and webhook-based integrations so your CRM, accounting, e-commerce and internal tools exchange data automatically instead of through copy-paste or spreadsheets."
    ],
    [
        'question' => 'Who owns the code and data when the project is finished?',
        'answer' => "You do. Projects end with a complete source code handover, administrator documentation and a walkthrough, under a standard intellectual property handover agreement, so your team or another developer can maintain the system."
    ],
    [
        'question' => 'What support do you offer after launch?',
        'answer' => "After launch I monitor performance and can provide regular security updates and scaling support as your business grows. You also get documentation and a walkthrough so your team can handle basic changes without waiting on me."
    ],
    [
        'question' => 'How does the Free Technical Audit work?',
        'answer' => "Send me details of your website, CRM or internal tool. I review it and tell you what is actually slowing it down and what to fix first. There is no cost, no obligation and no pressure to hire me afterwards."
    ],
    [
        'question' => 'Do you build mobile apps, and how do they connect to the backend?',
        'answer' => "Yes. I build cross-platform iOS and Android apps with Flutter, connected to a custom Laravel REST API backend, with offline sync and push notifications where the project needs them."
    ]
];

$pageMeta = [
    'title' => 'Custom Software Development Services in Karachi | CRM & SaaS',
    'description' => 'Custom CRM, Laravel SaaS, web & mobile apps and automation by a Karachi developer. Clients in Pakistan, UAE, UK and US. Free technical audit.',
    'canonical' => base_url('/services'),
    'og_type' => 'website',
    'image' => asset_url('images/og-services.png'),
    'page_type' => 'CollectionPage',
    'faqs' => $servicesFaqs,
    'itemList' => $schemaItems
];

$extraCss = [
    'css/services-page.css',
    'css/chatbot.css',
    'css/layout.css'
];
?>
<!doctype html>
<html lang="en">
<head>
<?php require view_path('layouts/head.php'); ?>
</head><body>
<div class="bgfx"></div>
<?php $home = false; $active = 'Services'; require view_path('layouts/header.php'); ?>

<main>
<!-- ==========================================================================
     1. HERO SECTION
     ========================================================================== -->
<header class="hx">
 <div class="hgrid" aria-hidden="true"></div><div class="blob" aria-hidden="true"></div>
 <div>
  <span class="eyebrow fade">✦ Custom CRM, SaaS &amp; Automation Development</span>
  <h1 class="fade">Custom Software Development Services for <em>CRM, SaaS</em> &amp; <span class="ul">Automation<svg viewBox="0 0 300 20" preserveAspectRatio="none" aria-hidden="true"><path d="M3 14 C 80 4, 200 2, 297 10" fill="none" stroke="#f26a1b" stroke-width="5" stroke-linecap="round"/></svg></span></h1>
  <p class="lead2 fade">I build custom CRMs, Laravel SaaS platforms, web and mobile apps and business automation for companies that have outgrown off-the-shelf software. I'm a developer based in Karachi, working with local businesses and remote teams in Pakistan, the UAE, Saudi Arabia, the UK and the US.</p>
  
  <p class="local-seo-line fade">Based in Karachi? See <a href="<?= base_url('/laravel-developer-karachi') ?>">Laravel development in Karachi</a>, <a href="<?= base_url('/crm-developer-pakistan') ?>">CRM development in Pakistan</a> or <a href="<?= base_url('/hire-a-developer-karachi') ?>">hiring a developer in Karachi</a>.</p>

  <div class="btns fade"><a class="bo pri" href="<?= base_url('/contact') ?>">Book a Call →</a><a class="bo sec" href="#services">Explore services</a></div>
  <p class="hqt fade">“True scalability isn't about more servers; it's about cleaner architecture and predictable ROI-driven logic.”</p>
 </div>
 <div class="stage fade" aria-hidden="true">
  <div class="code tilt"><div class="mkbar"><i></i><i></i><i></i><span>LeadRouter.php</span></div><pre><span class="c">// app/Services/LeadRouter.php</span>
<span class="k">class</span> <span class="f">LeadRouter</span>
{
  <span class="k">public function</span> <span class="f">assign</span>(Lead $lead)
  {
    $agent = Agent::<span class="f">available</span>()
      -><span class="f">forRegion</span>($lead->region)
      -><span class="f">leastBusy</span>();

    $lead-><span class="f">assignTo</span>($agent);
    <span class="k">event</span>(<span class="k">new</span> <span class="f">LeadRouted</span>($lead));
  }
}</pre></div>
  <div class="flt f1 o"><span><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c.8-3.6 3.4-5.5 6.5-5.5s5.7 1.9 6.5 5.5"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7M18.5 14.8c1.6.9 2.6 2.6 3 5.2"/></svg></span>Custom CRM</div>
  <div class="flt f2"><span><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 0 1-15.5 6.3M3 12A9 9 0 0 1 18.5 5.7"/><path d="M18.5 2v3.7h-3.7M5.5 22v-3.7h3.7"/></svg></span>Automation</div>
  <div class="flt f3"><span><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 3 7.5l9 4.5 9-4.5z"/><path d="m3 12 9 4.5 9-4.5M3 16.5 12 21l9-4.5"/></svg></span>SaaS Platforms</div>
  <div class="flt f4"><span><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6.5" y="2.5" width="11" height="19" rx="2.5"/><path d="M11 18.5h2"/></svg></span>Flutter Apps</div>
 </div>
</header>

<div class="marq" aria-hidden="true"><div>
  <span>Free Technical Audit</span><span>Performance Tuning</span><span>SaaS Product Strategy</span><span>Business Process Automation</span><span>Mobile App Development</span><span>SaaS Application Development</span><span>Laravel &amp; PHP</span><span>MySQL</span><span>Flutter</span>
  <span>Free Technical Audit</span><span>Performance Tuning</span><span>SaaS Product Strategy</span><span>Business Process Automation</span><span>Mobile App Development</span><span>SaaS Application Development</span><span>Laravel &amp; PHP</span><span>MySQL</span><span>Flutter</span>
</div></div>

<!-- ==========================================================================
     2. CORE SERVICES SECTION
     ========================================================================== -->
<section class="wrap blk" id="services" aria-labelledby="h-core">
 <div class="shead fade"><div><span class="eyebrow">Core services</span><h2 id="h-core">What I build for CRM, automation <em>and web platforms</em></h2></div>
 <p class="sub" style="max-width:440px">Most projects fall into seven areas. Some clients need just one, such as a CRM rebuild or a single automation that removes a manual step. Others combine two or three into one system. Most builds run on Laravel, PHP and MySQL, with React, Node.js, Python or Flutter added when a project needs them, so on custom builds you own working software instead of another subscription.</p></div>
 
 <div class="bento">
  <!-- 1. Custom CRM Development -->
  <?php $sCrm = $getSvc('custom-crm-development', 'Custom CRM Development in Laravel', 'I build CRMs around how your team actually sells, not around a generic pipeline template. That means lead routing and assignment, pipeline tracking, role-based permissions, reporting dashboards and integrations with the tools your team already uses. My multi-tenant CRM manages 1.5M+ leads for 300+ daily users.', ['Laravel', 'CRM', 'Multi-Tenant', 'Enterprise']); ?>
  <div class="bc b-crm fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c.8-3.6 3.4-5.5 6.5-5.5s5.7 1.9 6.5 5.5"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7M18.5 14.8c1.6.9 2.6 2.6 3 5.2"/></svg></span><a class="ba" href="<?= $sCrm['url'] ?>" aria-label="Learn more about custom CRM development">↗</a></div>
    <div class="mk crmk live" data-anim="crm" aria-hidden="true"><div class="mkbar"><i></i><i></i><i></i><span>Pipeline · This month</span><em class="lv">● Live</em></div>
    <div class="crmg"><div class="kpis"><div><small>Leads routed</small><b data-c="1240" data-r="7">1.5M+</b></div><div><small>Deals won</small><b data-c="86" data-r="1">86</b></div><div><small>Active users</small><b data-c="312" data-r="2">300+</b></div></div>
    <div class="bars"><i style="--h:38%"></i><i style="--h:62%"></i><i style="--h:48%"></i><i style="--h:80%"></i><i style="--h:56%"></i><i style="--h:92%"></i><i style="--h:70%"></i><i style="--h:86%"></i></div>
    <div class="pipe"><span class="on">New</span><span>Qualified</span><span>Proposal</span><span>Won</span></div></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sCrm['title']) ?></h3>
      <p><?= htmlspecialchars($sCrm['summary']) ?></p>
      <div class="tg"><?php foreach ($sCrm['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links">
        <a href="<?= $sCrm['url'] ?>">Learn more about custom CRM development →</a>
        <a href="<?= base_url('/projects/multi-tenant-crm') ?>" class="cs-link">See the multi-tenant CRM case study →</a>
      </div>
    </div>
  </div>

  <!-- 2. AI Automation Services -->
  <?php $sAi = $getSvc('ai-automation-services', 'AI Automation Services', 'AI-assisted workflows that take over repetitive tasks such as data entry, lead follow-ups, report generation and internal notifications. The goal is fewer manual steps for your team, not AI for its own sake, so each automation is scoped to one task that is currently eating up hours.', ['Workflow AI', 'Task Automation']); ?>
  <div class="bc b-ai fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l1.8 4.7L18.5 9.5l-4.7 1.8L12 16l-1.8-4.7L5.5 9.5l4.7-1.8z"/><path d="M19 15l.8 2.2L22 18l-2.2.8L19 21l-.8-2.2L16 18l2.2-.8z"/></svg></span><a class="ba" href="<?= $sAi['url'] ?>" aria-label="Learn more about AI automation services">↗</a></div>
    <div class="mk aimk live" aria-hidden="true"><div class="node"><b>Trigger</b>New lead</div><div class="wire"></div><div class="node ai">✦ AI step<b>Summarise &amp; tag</b></div><div class="wire"></div><div class="node"><b>Action</b>Notify team</div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sAi['title']) ?></h3>
      <p><?= htmlspecialchars($sAi['summary']) ?></p>
      <div class="tg"><?php foreach ($sAi['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links"><a href="<?= $sAi['url'] ?>">Learn more about AI automation →</a></div>
    </div>
  </div>

  <!-- 3. Chat App Development -->
  <?php $sChat = $getSvc('chat-app-development', 'Chat App Development', 'Real-time chat built with WebSockets: internal team messaging, customer support widgets, or a fully owned alternative to per-seat tools like Slack. Chatrox is one example, built and running in production.', ['Real-Time', 'Encrypted', 'WebSockets']); ?>
  <div class="bc b-chat fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20.5l1.4-4.6A8 8 0 1 1 21 12z"/><path d="M8.5 11h.01M12 11h.01M15.5 11h.01"/></svg></span><a class="ba" href="<?= $sChat['url'] ?>" aria-label="Learn more about chat app development">↗</a></div>
    <div class="mk chmk live" data-anim="chat" aria-hidden="true"><div class="bub l">Order #482 shipped?</div><div class="bub r">Yes — tracking sent ✓</div><div class="bub l typing"><i></i><i></i><i></i></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sChat['title']) ?></h3>
      <p><?= htmlspecialchars($sChat['summary']) ?></p>
      <div class="tg"><?php foreach ($sChat['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links">
        <a href="<?= $sChat['url'] ?>">Learn more →</a>
        <a href="<?= base_url('/projects/chatrox') ?>" class="cs-link">See the Chatrox case study →</a>
      </div>
    </div>
  </div>

  <!-- 4. Web App & CMS Development -->
  <?php $sWeb = $getSvc('web-app-cms-development', 'Web App & CMS Development', 'Custom Laravel web applications, portals and dashboards that scale with a growing business in Pakistan or abroad, plus e-commerce builds on Shopify, WordPress and Wix when a faster launch matters more than a fully custom backend. I help you choose the approach that fits your budget and timeline, not the one I prefer to build.', ['Responsive', 'Fast Load Times', 'CMS']); ?>
  <div class="bc b-web fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="4" width="19" height="15" rx="2.5"/><path d="M2.5 8.5h19M6 6.3h.01M8.5 6.3h.01"/></svg></span><a class="ba" href="<?= $sWeb['url'] ?>" aria-label="Learn more about web app and CMS development">↗</a></div>
    <div class="mk wbmk live" data-anim="web" aria-hidden="true"><div class="mkbar"><i></i><i></i><i></i><span class="url">yourbrand.com</span></div><div class="wbg"><div class="sk hl"></div><div class="sk ln"></div><div class="sk ln s"></div><div class="tiles"><i class="sk"></i><i class="sk btn"></i><i class="sk"></i></div></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sWeb['title']) ?></h3>
      <p><?= htmlspecialchars($sWeb['summary']) ?></p>
      <div class="tg"><?php foreach ($sWeb['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links"><a href="<?= $sWeb['url'] ?>">Learn more about custom web application development →</a></div>
    </div>
  </div>

  <!-- 5. SaaS Application Development -->
  <?php $sSaas = $getSvc('saas-application-development', 'SaaS Application Development', 'Multi-tenant SaaS platforms, customer portals, subscription billing and robust REST APIs, designed to scale securely without recurring third-party licensing fees.', ['Multi-Tenant', 'Stripe Billing', 'REST API']); ?>
  <div class="bc b-saas fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 3 7.5l9 4.5 9-4.5z"/><path d="m3 12 9 4.5 9-4.5M3 16.5 12 21l9-4.5"/></svg></span><a class="ba" href="<?= $sSaas['url'] ?>" aria-label="Learn more about SaaS development">↗</a></div>
    <div class="mk ssmk live" data-anim="saas" aria-hidden="true"><div class="ten" style="--y:0"><b>Tenant A</b><span>Pro</span></div><div class="ten" style="--y:1"><b>Tenant B</b><span>Team</span></div><div class="ten on" style="--y:2"><b>Tenant C</b><span class="bill">Billing <i>✓</i></span></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sSaas['title']) ?></h3>
      <p><?= htmlspecialchars($sSaas['summary']) ?></p>
      <div class="tg"><?php foreach ($sSaas['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links"><a href="<?= $sSaas['url'] ?>">Learn more →</a></div>
    </div>
  </div>

  <!-- 6. Mobile App Development -->
  <?php $sMob = $getSvc('mobile-app-development', 'Mobile App Development', 'High-performance cross-platform apps for iOS and Android built with Flutter, connected to custom Laravel REST API backends, with offline sync and push notifications.', ['Flutter', 'iOS', 'Android', 'REST API']); ?>
  <div class="bc b-mob fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6.5" y="2.5" width="11" height="19" rx="2.5"/><path d="M11 18.5h2"/></svg></span><a class="ba" href="<?= $sMob['url'] ?>" aria-label="Learn more about mobile app development">↗</a></div>
    <div class="mk mbmk live" data-anim="mob" aria-hidden="true"><div class="phone"><div class="notch"></div><div class="pl"></div><div class="pl s"></div><div class="plist"><div class="pc"></div><div class="pc"></div><div class="pc"></div><div class="pc"></div><div class="pc"></div><div class="pc"></div></div><div class="pn"><span class="spin"></span>Synced offline changes</div></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sMob['title']) ?></h3>
      <p><?= htmlspecialchars($sMob['summary']) ?></p>
      <div class="tg"><?php foreach ($sMob['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links"><a href="<?= $sMob['url'] ?>">Learn more →</a></div>
    </div>
  </div>

  <!-- 7. Business Process Automation -->
  <?php $sAuto = $getSvc('business-process-automation', 'Business Process Automation', 'Replace manual spreadsheets, copy-pasting between systems and repetitive data entry with automated workflows and webhooks. I also build API integrations that connect your CRM, accounting, e-commerce and internal tools, so data moves on its own. Many clients save hours every week.', ['Automation', 'Webhooks', 'API Integration']); ?>
  <div class="bc b-auto fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 0 1-15.5 6.3M3 12A9 9 0 0 1 18.5 5.7"/><path d="M18.5 2v3.7h-3.7M5.5 22v-3.7h3.7"/></svg></span><a class="ba" href="<?= $sAuto['url'] ?>" aria-label="Learn more about business process automation">↗</a></div>
    <div class="mk aumk live" aria-hidden="true"><span class="chip2">Spreadsheet</span><span class="arrw"></span><span class="chip2 o">Webhook</span><span class="arrw"></span><span class="chip2">CRM ✓</span></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sAuto['title']) ?></h3>
      <p><?= htmlspecialchars($sAuto['summary']) ?></p>
      <div class="tg"><?php foreach ($sAuto['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links"><a href="<?= $sAuto['url'] ?>">Learn more →</a></div>
    </div>
  </div>
 </div>
</section>

<!-- ==========================================================================
     3. CONSULTING & STRATEGY TABS
     ========================================================================== -->
<section class="wrap blk" id="strategy" aria-labelledby="h-str">
 <div class="fade"><span class="eyebrow">Consulting &amp; strategy</span><h2 id="h-str">Planning and technical strategy <em>for SaaS products</em></h2></div>
 <div class="cons fade">
  <?php 
  $sStrat = $getSvc('saas-product-strategy', 'SaaS Product Strategy', "If you're at the idea stage, I help turn it into an actual build plan: database design, tech stack choices, multi-tenant versus single-tenant architecture, and a phased roadmap, so you aren't building every feature before your first user.", ['MVP Planning', 'Scalable Architecture']);
  $sPerf = $getSvc('performance-tuning', 'Performance Tuning', "For systems you already have: a slow site, unpredictable downtime, or security gaps you aren't sure how to fix. I audit the current setup, flag what is actually causing the problem, and fix it without a full rebuild unless a rebuild is genuinely needed.", ['Speed', 'Security Audit']);
  $sAudit = $getSvc('free-technical-audit', 'Free Technical Audit', "I'll review your current system, whether it's a website, CRM or internal tool, and point out what is actually slowing it down. No cost, no obligation and no pressure to hire me afterwards.", []);
  ?>
  <div class="tabs" role="tablist" aria-label="Consulting services">
   <button class="tab" role="tab" id="t1" aria-controls="p1" aria-selected="true"><span class="tn">01</span><span><b><?= htmlspecialchars($sStrat['title']) ?></b><small>From idea to build plan</small></span></button>
   <button class="tab" role="tab" id="t2" aria-controls="p2" aria-selected="false" tabindex="-1"><span class="tn">02</span><span><b><?= htmlspecialchars($sPerf['title']) ?></b><small>Fix what's slowing you down</small></span></button>
   <button class="tab" role="tab" id="t3" aria-controls="p3" aria-selected="false" tabindex="-1"><span class="tn">03</span><span><b><?= htmlspecialchars($sAudit['title']) ?></b><small>No cost, no obligation</small></span></button>
  </div>
  <div>
   <div class="panel" role="tabpanel" id="p1" aria-labelledby="t1">
     <span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 3 7.5l9 4.5 9-4.5z"/><path d="m3 12 9 4.5 9-4.5M3 16.5 12 21l9-4.5"/></svg></span>
     <h3><?= htmlspecialchars($sStrat['title']) ?></h3>
     <p><?= htmlspecialchars($sStrat['summary']) ?></p>
     <div class="tg"><?php foreach ($sStrat['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
     <a class="bo w" href="<?= base_url('/services/saas-application-development') ?>">Learn more →</a>
   </div>
   <div class="panel" role="tabpanel" id="p2" aria-labelledby="t2" hidden>
     <span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 0 1-15.5 6.3M3 12A9 9 0 0 1 18.5 5.7"/><path d="M18.5 2v3.7h-3.7M5.5 22v-3.7h3.7"/></svg></span>
     <h3><?= htmlspecialchars($sPerf['title']) ?></h3>
     <p><?= htmlspecialchars($sPerf['summary']) ?></p>
     <div class="tg"><?php foreach ($sPerf['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
     <a class="bo w" href="<?= base_url('/services/performance-tuning') ?>">Learn more →</a>
   </div>
   <div class="panel audit2" role="tabpanel" id="p3" aria-labelledby="t3" hidden>
     <span class="bi" style="background:rgba(255,255,255,.2);color:#fff"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg></span>
     <h3><?= htmlspecialchars($sAudit['title']) ?></h3>
     <p><?= htmlspecialchars($sAudit['summary']) ?></p>
     <a class="bo w" href="<?= base_url('/contact') ?>">Claim Free Audit →</a>
   </div>
  </div>
 </div>
</section>

<!-- ==========================================================================
     4. DECISION GUIDE: CUSTOM OR OFF-THE-SHELF?
     ========================================================================== -->
<section class="wrap blk" id="decision-guide" aria-labelledby="h-decide">
 <div class="fade">
  <span class="eyebrow">Decision guide</span>
  <h2 id="h-decide">Custom software or off-the-shelf? <em>How to decide</em></h2>
  <p class="sub">Custom software isn't always the right answer, and I'll tell you when it isn't.</p>
 </div>

 <div class="decision-grid fade">
  <div class="dec-col dec-custom">
   <div class="dec-badge">When Custom Makes Sense</div>
   <h3>Build Custom When:</h3>
   <ul>
    <li>Per-user fees grow every time your team grows, and the tool still doesn't match how you work.</li>
    <li>Your team keeps using spreadsheets or copy-paste next to the tool you already pay for.</li>
    <li>Several systems need to talk to each other through direct, automated integrations.</li>
    <li>You're building a product other companies will use (SaaS) and need control over data, billing and roadmap.</li>
   </ul>
  </div>

  <div class="dec-col dec-shelf">
   <div class="dec-badge shelf">When Ready-Made Makes Sense</div>
   <h3>Choose Off-the-Shelf When:</h3>
   <ul>
    <li>Your process is standard and a ready-made tool covers almost everything you need.</li>
    <li>You need to be live this week, and your team is still small and flexible.</li>
    <li>You have no dedicated budget for custom hosting, maintenance, or staged feature rollouts.</li>
   </ul>
  </div>
 </div>

 <!-- Comparison Table -->
 <div class="factor-wrap fade">
  <table class="factor-table" aria-label="Comparison between Off-the-shelf and Custom Software">
   <thead>
    <tr>
     <th scope="col" style="width:24%">Factor</th>
     <th scope="col" style="width:38%">Off-the-shelf / SaaS subscription</th>
     <th scope="col" style="width:38%">Custom software</th>
    </tr>
   </thead>
   <tbody>
    <tr>
     <th scope="row">Cost over time</th>
     <td>Lower start, fees grow with users</td>
     <td><b>Higher start, you pay for hosting and maintenance, not per-seat licences</b></td>
    </tr>
    <tr>
     <th scope="row">Fit to your process</th>
     <td>You adapt to the tool</td>
     <td><b>Built around how your team works</b></td>
    </tr>
    <tr>
     <th scope="row">Integrations</th>
     <td>Limited to what the vendor supports</td>
     <td><b>Connected to the tools you actually use</b></td>
    </tr>
    <tr>
     <th scope="row">Data and ownership</th>
     <td>Held in the vendor's system</td>
     <td><b>Held in a system you control</b></td>
    </tr>
    <tr>
     <th scope="row">Speed to start</th>
     <td>Fastest</td>
     <td><b>Slower, built in stages</b></td>
    </tr>
   </tbody>
  </table>
 </div>

 <div class="scale-note fade">
  <div class="sn-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
  <div class="sn-text">
   <h4>Is custom software scalable?</h4>
   <p>Yes, if it is built for it. Scalability comes from early decisions: database design, how data is separated between customers (multi-tenant architecture), and how heavy tasks run in the background. My own multi-tenant CRM manages over 1.5 million leads for 300+ daily users.</p>
   <p class="sn-links">Want the full breakdown? Read the <a href="<?= base_url('/articles') ?>">custom software vs SaaS guide</a>. Not sure which side you're on? <a href="<?= base_url('/contact') ?>">Claim a free technical audit</a>.</p>
  </div>
 </div>
</section>

<!-- ==========================================================================
     5. INDUSTRIES
     ========================================================================== -->
<section class="wrap blk" id="industries" aria-labelledby="h-ind">
 <div class="fade"><span class="eyebrow">Industries</span><h2 id="h-ind">Development experience <em>across industries</em></h2></div>
 <div class="igrid2">
  <article class="it2 fade" style="--g:linear-gradient(150deg,#ff8a3d,#f26a1b)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c.8-3.6 3.4-5.5 6.5-5.5s5.7 1.9 6.5 5.5"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7M18.5 14.8c1.6.9 2.6 2.6 3 5.2"/></svg></span>
   <h3>Sales &amp; Lead Operations</h3>
   <p>Lead distribution, pipeline tracking and reporting for sales teams that handle high lead volumes.</p>
   <div class="tg"><span>High Volume</span><span>Reporting</span></div>
   <a class="i-link" href="<?= base_url('/projects/multi-tenant-crm') ?>">View Case Study →</a>
  </article>

  <article class="it2 fade" style="--g:linear-gradient(150deg,#3a2416,#1a120c)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11 12 4l9 7"/><path d="M5.5 9.5V20h13V9.5M10 20v-5h4v5"/></svg></span>
   <h3>PropTech (Real Estate)</h3>
   <p>Lead management and conversion tools for realtors, multi-role property portals, and listing sync so a property doesn't need updating by hand on five platforms.</p>
   <div class="tg"><span>Lead Conversion</span><span>Listing Sync</span></div>
   <a class="i-link" href="<?= base_url('/projects') ?>">Explore PropTech →</a>
  </article>

  <article class="it2 fade" style="--g:linear-gradient(150deg,#24263a,#141524)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></span>
   <h3>E-commerce &amp; Retail</h3>
   <p>Custom e-commerce platforms with theme builders, B2B bulk ordering for hardware suppliers, and mobile shopping apps.</p>
   <div class="tg"><span>Custom Checkout</span><span>B2B Quotes</span></div>
   <a class="i-link" href="<?= base_url('/projects') ?>">View E-commerce →</a>
  </article>

  <article class="it2 fade" style="--g:linear-gradient(150deg,#2b1d16,#17100d)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
   <h3>HR &amp; Workforce</h3>
   <p>Employee management and payroll portals that replace spreadsheets for attendance, leave and salary processing.</p>
   <div class="tg"><span>Payroll</span><span>Attendance</span></div>
   <a class="i-link" href="<?= base_url('/projects') ?>">View HR Portals →</a>
  </article>

  <article class="it2 fade" style="--g:linear-gradient(150deg,#1c2d27,#0e1915)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></span>
   <h3>Healthcare Tech</h3>
   <p>Medicine and hospital management apps for clinics and healthcare providers.</p>
   <div class="tg"><span>Hospital Management</span><span>Mobile</span></div>
   <a class="i-link" href="<?= base_url('/projects') ?>">View Healthcare →</a>
  </article>

  <article class="it2 fade" style="--g:linear-gradient(150deg,#2a2a35,#14141c)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="5.5" width="19" height="13" rx="2.5"/><path d="M2.5 10h19M6.5 14.5h4"/></svg></span>
   <h3>FinTech Systems</h3>
   <p>Payment gateway integrations and custom financial reporting for products that handle sensitive data.</p>
   <div class="tg"><span>Payments</span><span>Reporting</span></div>
   <a class="i-link" href="<?= base_url('/projects') ?>">View FinTech →</a>
  </article>
 </div>
</section>

<!-- ==========================================================================
     6. HOW A PROJECT WORKS
     ========================================================================== -->
<section class="wrap blk" id="process" aria-labelledby="h-pro">
 <div class="fade" style="text-align:center"><span class="eyebrow">Step by step</span><h2 id="h-pro">How a project <em>works</em></h2></div>
 <ol class="proc2 fade">
  <li class="ps2">
    <span class="dot2">01</span>
    <h3>Discovery</h3>
    <p>We go over your current workflow, what is slowing it down and what a fix needs to include, before anything is scoped or quoted.</p>
    <div class="proc-deliv"><b>You get:</b> a written scope and quote.</div>
  </li>
  <li class="ps2">
    <span class="dot2">02</span>
    <h3>Strategy</h3>
    <p>I plan the database structure, tech stack and feature scope, and we agree on what "done" looks like before any code is written.</p>
    <div class="proc-deliv"><b>You get:</b> an agreed scope and a staged build plan.</div>
  </li>
  <li class="ps2">
    <span class="dot2">03</span>
    <h3>Execution</h3>
    <p>Development happens in stages on a private staging URL, with regular reviews and testing at each milestone, so you see working software along the way instead of one big reveal.</p>
    <div class="proc-deliv"><b>You get:</b> working modules to test.</div>
  </li>
  <li class="ps2">
    <span class="dot2">04</span>
    <h3>Optimization and handover</h3>
    <p>After launch I monitor performance under real usage and adjust as your traffic or team grows.</p>
    <div class="proc-deliv"><b>You get:</b> complete source code handover, documentation and a walkthrough. Security updates, monitoring and scaling support are available after launch.</div>
  </li>
 </ol>

 <!-- 7. RESULTS YOU CAN CHECK (Replaces old stat counters) -->
 <div class="results-check-wrap fade" aria-labelledby="h-results">
  <div class="rc-head">
    <span class="eyebrow">Proof points</span>
    <h2 id="h-results">Results you can <em>check</em></h2>
  </div>
  <div class="results-grid">
   <div class="rc-card">
    <b>1.5M+</b>
    <small>leads managed in one multi-tenant CRM I built</small>
   </div>
   <div class="rc-card">
    <b>300+</b>
    <small>daily users on that same system</small>
   </div>
   <a class="rc-card rc-link" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener">
    <b>4.8 / 5 ★</b>
    <small>Google rating from 27 reviews ↗</small>
   </a>
   <div class="rc-card">
    <b>24 hours</b>
    <small>typical reply time on new enquiries</small>
   </div>
  </div>
 </div>
</section>

<!-- ==========================================================================
     8. CLIENT REVIEWS
     ========================================================================== -->
<section class="wrap blk" id="reviews" aria-labelledby="h-rev">
 <div class="rhead fade"><div><span class="eyebrow">Client reviews</span><h2 id="h-rev">What clients say about <em>working with me</em></h2><p class="sub">Feedback from clients and collaborators in Pakistan, the UK, the UAE and the US.</p></div>
 <div class="rnav"><button type="button" id="rp" aria-label="Previous review">←</button><button type="button" id="rn" aria-label="Next review">→</button></div></div>
 <div class="rtrack" id="rt" tabindex="0" aria-label="Client reviews">
  <figure class="card rv fade"><div class="stars" aria-label="5 out of 5 stars">★★★★★</div><blockquote>“I had a great experience working with Amaanullah. He is highly skilled in web development and backend systems. The website he developed was fast, secure, and very well structured.”</blockquote><figcaption><span class="av">FK</span><span><b>Faisal Khan</b><small>Client · Custom Software &amp; Web Apps</small></span><span class="gg">Google</span></figcaption></figure>
  <figure class="card rv fade"><div class="stars" aria-label="5 out of 5 stars">★★★★★</div><blockquote>“The web developer has strong technical skills and a deep understanding of web development. They are proficient in various programming languages and frameworks, and have a good eye for design and functionality.”</blockquote><figcaption><span class="av">SH</span><span><b>Syed Hamza Qadri</b><small>Client · Web Development</small></span><span class="gg">Google</span></figcaption></figure>
  <figure class="card rv fade"><div class="stars" aria-label="5 out of 5 stars">★★★★★</div><blockquote>“Amanullah is a skilled and reliable software developer. He delivers high-quality work, writes clean and efficient code, and communicates professionally throughout the project. He is knowledgeable.”</blockquote><figcaption><span class="av">MA</span><span><b>Mr. Abdullah</b><small>Client · Software Development</small></span><span class="gg">Google</span></figcaption></figure>
  <figure class="card rv fade"><div class="stars" aria-label="5 out of 5 stars">★★★★★</div><blockquote>“I love to work with his team, he build LMS system for my school. Good job guys.”</blockquote><figcaption><span class="av">SH</span><span><b>Steve Harington</b><small>Client · LMS System</small></span><span class="gg">Google</span></figcaption></figure>
  <figure class="card rv fade"><div class="stars" aria-label="5 out of 5 stars">★★★★★</div><blockquote>“Great job I love to working with them. They’re very supportive and don’t charge extra for additional work such as website maintenance and technical tasks. Thank you guys.”</blockquote><figcaption><span class="av">RB</span><span><b>Ruben</b><small>Client · Website Maintenance</small></span><span class="gg">Google</span></figcaption></figure>
  <figure class="card rv fade"><div class="stars" aria-label="5 out of 5 stars">★★★★★</div><blockquote>“Great productivity highly recommended no matter which country you’re in. The team is reliable, professional and won’t charge extra for additional work, fully satisfied with the services.”</blockquote><figcaption><span class="av">SH</span><span><b>Sonny Hayce</b><small>Client · Web Services</small></span><span class="gg">Google</span></figcaption></figure>
 </div>
</section>

<!-- ==========================================================================
     9. FAQ SECTION (10 Service Questions)
     ========================================================================== -->
<section class="wrap blk fqw" id="faq" aria-labelledby="h-faq">
 <div class="fade"><span class="eyebrow">Questions &amp; Answers</span><h2 id="h-faq">Questions about custom software development, <em>answered</em></h2><p class="sub">Straightforward answers about costs, timelines, scalability, and code ownership.</p></div>
 <div class="fade">
  <?php foreach ($servicesFaqs as $idx => $faqItem): ?>
  <details<?= $idx === 0 ? ' open' : '' ?>>
    <summary><?= htmlspecialchars($faqItem['question']) ?></summary>
    <p><?= htmlspecialchars($faqItem['answer']) ?></p>
  </details>
  <?php endforeach; ?>
 </div>
</section>

<!-- ==========================================================================
     10. BOTTOM CTA
     ========================================================================== -->
<section class="band fade" aria-labelledby="h-cta">
  <div>
    <h2 id="h-cta">Ready to start a project?</h2>
    <p>Tell me about your project and I'll get back to you within 24 hours with next steps.</p>
  </div>
  <div class="btns" style="margin:0">
    <a class="bo w" href="<?= base_url('/contact') ?>">Book a Call →</a>
    <a class="bo g" href="<?= base_url('/contact') ?>">Claim Free Audit</a>
  </div>
</section>
</main>

<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/services-page.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script>
<script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= time() ?>" defer></script>
</body></html>
