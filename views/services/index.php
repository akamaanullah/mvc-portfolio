<!doctype html><html lang="en"><head>
<script src="<?= asset_url('js/theme.js') ?>"></script><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Custom CRM, SaaS &amp; Automation Development Services | Amaanullah Khan, Karachi</title>
<meta name="description" content="Custom CRM systems, Laravel SaaS backends, AI &amp; business automation, chat and mobile apps — built by Amaanullah Khan in Karachi for businesses in Pakistan, the US, UK and UAE.">
<link rel="canonical" href="<?= base_url('/services') ?>">
<meta property="og:type" content="website"><meta property="og:title" content="Custom Software Development Services — CRM, SaaS &amp; Automation"><meta property="og:description" content="Laravel &amp; PHP systems you own: CRMs, SaaS platforms, automation, chat and Flutter apps.">
<meta property="og:url" content="<?= base_url('/services') ?>"><meta property="og:image" content="<?= asset_url('images/og-services.png') ?>">
<meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="Custom CRM, SaaS &amp; Automation Services"><meta name="twitter:description" content="Software built around how your business actually works."><meta name="twitter:image" content="<?= asset_url('images/og-services.png') ?>">
<link rel="icon" href="<?= asset_url('logo-v2/favicon.ico') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Caveat:wght@600&display=swap" rel="stylesheet">
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
$servicesSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => 'Software development services by Amaanullah Khan',
    'itemListElement' => $schemaItems
];
?>
<script type="application/ld+json"><?= json_encode($servicesSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?></script>
<link rel="stylesheet" href="<?= asset_url('css/services-page.css') ?>"><link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
</head><body>
<div class="bgfx"></div>
<?php $home = false; $active = 'Services'; require view_path('layouts/header.php'); ?>

<main>
<header class="hx">
 <div class="hgrid" aria-hidden="true"></div><div class="blob" aria-hidden="true"></div>
 <div>
  <span class="eyebrow fade">✦ Custom CRM, SaaS &amp; Automation Development</span>
  <h1 class="fade">Custom software for <em>CRM, SaaS</em> &amp; <span class="ul">automation<svg viewBox="0 0 300 20" preserveAspectRatio="none" aria-hidden="true"><path d="M3 14 C 80 4, 200 2, 297 10" fill="none" stroke="#f26a1b" stroke-width="5" stroke-linecap="round"/></svg></span></h1>
  <p class="lead2 fade">Custom CRMs, Laravel SaaS backends and automation tools for companies that have outgrown off-the-shelf software. Based in Karachi — working with local businesses and remote teams across the US, UK and UAE.</p>
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
  <?php 
  $marqTitles = !empty($services) ? array_map(fn($row) => $row['title'], $services) : ['Custom CRM', 'AI Automation', 'Web Apps & CMS', 'SaaS Platforms', 'Business Automation', 'Chat Apps', 'Mobile Apps'];
  for ($m = 0; $m < 2; $m++):
    foreach ($marqTitles as $mTitle): ?>
      <span><?= htmlspecialchars($mTitle) ?></span>
    <?php endforeach;
    echo '<span>Laravel &amp; PHP</span><span>MySQL</span><span>Flutter</span>';
  endfor; ?>
</div></div>

<section class="wrap blk" id="services" aria-labelledby="h-core">
 <div class="shead fade"><div><span class="eyebrow">Core services</span><h2 id="h-core">What I build for CRM, automation <em>&amp; web platforms</em></h2></div>
 <p class="sub" style="max-width:380px">Built on Laravel &amp; PHP with a MySQL backend — so you own working software at the end, not a subscription.</p></div>
 <div class="bento">
  <!-- 1. Custom CRM Development -->
  <?php $sCrm = $getSvc('custom-crm-development', 'Custom CRM Development', 'Lead routing, sales pipelines and multi-tenant CRMs built around how your team actually sells — role-based permissions, reporting dashboards and integrations with the tools you already use.', ['Lead Routing', 'Multi-Tenant']); ?>
  <a class="bc b-crm fade" href="<?= $sCrm['url'] ?>" data-service="custom-crm">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c.8-3.6 3.4-5.5 6.5-5.5s5.7 1.9 6.5 5.5"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7M18.5 14.8c1.6.9 2.6 2.6 3 5.2"/></svg></span><span class="ba" aria-hidden="true">↗</span></div>
    <div class="mk crmk live" data-anim="crm" aria-hidden="true"><div class="mkbar"><i></i><i></i><i></i><span>Pipeline · This month</span><em class="lv">● Live</em></div>
    <div class="crmg"><div class="kpis"><div><small>Leads routed</small><b data-c="1240" data-r="7">1,240</b></div><div><small>Deals won</small><b data-c="86" data-r="1">86</b></div><div><small>Active users</small><b data-c="312" data-r="2">312</b></div></div>
    <div class="bars"><i style="--h:38%"></i><i style="--h:62%"></i><i style="--h:48%"></i><i style="--h:80%"></i><i style="--h:56%"></i><i style="--h:92%"></i><i style="--h:70%"></i><i style="--h:86%"></i></div>
    <div class="pipe"><span class="on">New</span><span>Qualified</span><span>Proposal</span><span>Won</span></div></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sCrm['title']) ?></h3>
      <p><?= htmlspecialchars($sCrm['summary']) ?></p>
      <div class="tg"><?php foreach ($sCrm['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
    </div>
  </a>

  <!-- 2. AI Automation Services -->
  <?php $sAi = $getSvc('ai-automation-services', 'AI Automation Services', 'AI-assisted workflows for data entry, lead follow-ups, report generation and internal notifications.', ['Workflow AI', 'Task Automation']); ?>
  <a class="bc b-ai fade" href="<?= $sAi['url'] ?>" data-service="ai-automation">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l1.8 4.7L18.5 9.5l-4.7 1.8L12 16l-1.8-4.7L5.5 9.5l4.7-1.8z"/><path d="M19 15l.8 2.2L22 18l-2.2.8L19 21l-.8-2.2L16 18l2.2-.8z"/></svg></span><span class="ba" aria-hidden="true">↗</span></div>
    <div class="mk aimk live" aria-hidden="true"><div class="node"><b>Trigger</b>New lead</div><div class="wire"></div><div class="node ai">✦ AI step<b>Summarise &amp; tag</b></div><div class="wire"></div><div class="node"><b>Action</b>Notify team</div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sAi['title']) ?></h3>
      <p><?= htmlspecialchars($sAi['summary']) ?></p>
      <div class="tg"><?php foreach ($sAi['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
    </div>
  </a>

  <!-- 3. Chat App Development -->
  <?php $sChat = $getSvc('chat-app-development', 'Chat App Development', 'Real-time WebSocket chat — a fully owned alternative to per-seat tools like Slack.', ['Real-Time', 'Encrypted']); ?>
  <a class="bc b-chat fade" href="<?= $sChat['url'] ?>" data-service="chat-app">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20.5l1.4-4.6A8 8 0 1 1 21 12z"/><path d="M8.5 11h.01M12 11h.01M15.5 11h.01"/></svg></span><span class="ba" aria-hidden="true">↗</span></div>
    <div class="mk chmk live" data-anim="chat" aria-hidden="true"><div class="bub l">Order #482 shipped?</div><div class="bub r">Yes — tracking sent ✓</div><div class="bub l typing"><i></i><i></i><i></i></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sChat['title']) ?></h3>
      <p><?= htmlspecialchars($sChat['summary']) ?></p>
      <div class="tg"><?php foreach ($sChat['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
    </div>
  </a>

  <!-- 4. Web App & CMS Development -->
  <?php $sWeb = $getSvc('web-app-cms-development', 'Web App & CMS Development', 'Custom Laravel apps, plus Shopify, WordPress and Wix when a faster launch matters more.', ['Responsive', 'Fast Load Times']); ?>
  <a class="bc b-web fade" href="<?= $sWeb['url'] ?>" data-service="web-app-cms">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="4" width="19" height="15" rx="2.5"/><path d="M2.5 8.5h19M6 6.3h.01M8.5 6.3h.01"/></svg></span><span class="ba" aria-hidden="true">↗</span></div>
    <div class="mk wbmk live" data-anim="web" aria-hidden="true"><div class="mkbar"><i></i><i></i><i></i><span class="url">yourbrand.com</span></div><div class="wbg"><div class="sk hl"></div><div class="sk ln"></div><div class="sk ln s"></div><div class="tiles"><i class="sk"></i><i class="sk btn"></i><i class="sk"></i></div></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sWeb['title']) ?></h3>
      <p><?= htmlspecialchars($sWeb['summary']) ?></p>
      <div class="tg"><?php foreach ($sWeb['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
    </div>
  </a>

  <!-- 5. SaaS Application Development -->
  <?php $sSaas = $getSvc('saas-application-development', 'SaaS Application Development', 'Multi-tenant platforms, customer portals, subscription billing and robust REST APIs.', ['Multi-Tenant', 'Stripe Billing']); ?>
  <a class="bc b-saas fade" href="<?= $sSaas['url'] ?>" data-service="saas-development">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 3 7.5l9 4.5 9-4.5z"/><path d="m3 12 9 4.5 9-4.5M3 16.5 12 21l9-4.5"/></svg></span><span class="ba" aria-hidden="true">↗</span></div>
    <div class="mk ssmk live" data-anim="saas" aria-hidden="true"><div class="ten" style="--y:0"><b>Tenant A</b><span>Pro</span></div><div class="ten" style="--y:1"><b>Tenant B</b><span>Team</span></div><div class="ten on" style="--y:2"><b>Tenant C</b><span class="bill">Billing <i>✓</i></span></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sSaas['title']) ?></h3>
      <p><?= htmlspecialchars($sSaas['summary']) ?></p>
      <div class="tg"><?php foreach ($sSaas['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
    </div>
  </a>

  <!-- 6. Mobile App Development -->
  <?php $sMob = $getSvc('mobile-app-development', 'Mobile App Development', 'Cross-platform iOS & Android apps in Flutter, connected to Laravel REST APIs with offline sync and push notifications.', ['Flutter', 'iOS & Android']); ?>
  <a class="bc b-mob fade" href="<?= $sMob['url'] ?>" data-service="mobile-app">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6.5" y="2.5" width="11" height="19" rx="2.5"/><path d="M11 18.5h2"/></svg></span><span class="ba" aria-hidden="true">↗</span></div>
    <div class="mk mbmk live" data-anim="mob" aria-hidden="true"><div class="phone"><div class="notch"></div><div class="pl"></div><div class="pl s"></div><div class="plist"><div class="pc"></div><div class="pc"></div><div class="pc"></div><div class="pc"></div><div class="pc"></div><div class="pc"></div></div><div class="pn"><span class="spin"></span>Synced offline changes</div></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sMob['title']) ?></h3>
      <p><?= htmlspecialchars($sMob['summary']) ?></p>
      <div class="tg"><?php foreach ($sMob['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
    </div>
  </a>

  <!-- 7. Business Process Automation -->
  <?php $sAuto = $getSvc('business-process-automation', 'Business Process Automation', 'Replace spreadsheets, copy-pasting between systems and repetitive data entry with automated workflows and webhooks.', ['Cost Saving', 'Fewer Manual Steps']); ?>
  <a class="bc b-auto fade" href="<?= $sAuto['url'] ?>" data-service="business-automation">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 0 1-15.5 6.3M3 12A9 9 0 0 1 18.5 5.7"/><path d="M18.5 2v3.7h-3.7M5.5 22v-3.7h3.7"/></svg></span><span class="ba" aria-hidden="true">↗</span></div>
    <div class="mk aumk live" aria-hidden="true"><span class="chip2">Spreadsheet</span><span class="arrw"></span><span class="chip2 o">Webhook</span><span class="arrw"></span><span class="chip2">CRM ✓</span></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sAuto['title']) ?></h3>
      <p><?= htmlspecialchars($sAuto['summary']) ?></p>
      <div class="tg"><?php foreach ($sAuto['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
    </div>
  </a>
 </div>

 <?php
 // Extra services added through admin panel
 $coreSlugs = [
     'custom-crm-development', 'ai-automation-services', 'chat-app-development',
     'web-app-cms-development', 'saas-application-development', 'mobile-app-development',
     'business-process-automation', 'saas-product-strategy', 'performance-tuning', 'free-technical-audit'
 ];
 $extraServices = array_filter($services ?? [], fn($x) => !in_array($x['slug'], $coreSlugs, true) && ($x['status'] ?? 'published') === 'published');
 if (!empty($extraServices)): ?>
 <div class="bento" style="margin-top:24px">
   <?php foreach ($extraServices as $extra):
     $extraTags = !empty($extra['tags']) ? array_filter(array_map('trim', explode(',', $extra['tags']))) : [];
   ?>
   <a class="bc fade" href="<?= base_url('/services/' . $extra['slug']) ?>">
     <div class="bh"><span class="bi">✦</span><span class="ba" aria-hidden="true">↗</span></div>
     <div class="bt">
       <h3><?= htmlspecialchars($extra['title']) ?></h3>
       <p><?= htmlspecialchars($extra['summary'] ?? '') ?></p>
       <?php if (!empty($extraTags)): ?>
       <div class="tg">
         <?php foreach ($extraTags as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?>
       </div>
       <?php endif; ?>
     </div>
   </a>
   <?php endforeach; ?>
 </div>
 <?php endif; ?>
</section>

<!-- Strategy & Consulting Tabs -->
<section class="wrap blk" id="strategy" aria-labelledby="h-str">
 <div class="fade"><span class="eyebrow">Consulting &amp; strategy</span><h2 id="h-str">Planning &amp; technical strategy <em>for SaaS products</em></h2></div>
 <div class="cons fade">
  <?php 
  $sStrat = $getSvc('saas-product-strategy', 'SaaS Product Strategy', "Turn an idea into an actual build plan — database design, tech stack choices, multi-tenant vs single-tenant architecture, and a phased roadmap so you're not building every feature before your first user.", ['MVP Planning', 'Scalable Architecture']);
  $sPerf = $getSvc('performance-tuning', 'Performance Tuning', "A slow site, unpredictable downtime or security gaps? I audit the current setup, flag what's actually causing the slowdown, and fix it — without a full rebuild unless one is genuinely needed.", ['Speed', 'Security Audit']);
  $sAudit = $getSvc('free-technical-audit', 'Free Technical Audit', "I'll review your current system — site, CRM or internal tool — and point out what's actually slowing it down. No cost, no obligation, and no pressure to hire me afterward.", []);
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
     <a class="bo w" href="<?= $sStrat['url'] ?>" data-service="saas-strategy">Learn more →</a>
   </div>
   <div class="panel" role="tabpanel" id="p2" aria-labelledby="t2" hidden>
     <span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 0 1-15.5 6.3M3 12A9 9 0 0 1 18.5 5.7"/><path d="M18.5 2v3.7h-3.7M5.5 22v-3.7h3.7"/></svg></span>
     <h3><?= htmlspecialchars($sPerf['title']) ?></h3>
     <p><?= htmlspecialchars($sPerf['summary']) ?></p>
     <div class="tg"><?php foreach ($sPerf['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
     <a class="bo w" href="<?= $sPerf['url'] ?>" data-service="performance-tuning">Learn more →</a>
   </div>
   <div class="panel audit2" role="tabpanel" id="p3" aria-labelledby="t3" hidden>
     <span class="bi" style="background:rgba(255,255,255,.2);color:#fff"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg></span>
     <h3><?= htmlspecialchars($sAudit['title']) ?></h3>
     <p><?= htmlspecialchars($sAudit['summary']) ?></p>
     <a class="bo w" href="<?= $sAudit['url'] ?>">Claim Free Audit →</a>
   </div>
  </div>
 </div>
</section>

<section class="wrap blk" id="industries" aria-labelledby="h-ind">
 <div class="fade"><span class="eyebrow">Industries</span><h2 id="h-ind">Development experience <em>across industries</em></h2></div>
 <div class="igrid2"><article class="it2 fade" style="--g:linear-gradient(150deg,#ff8a3d,#f26a1b)"><span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 14v-2a8 8 0 0 1 16 0v2"/><rect x="2.5" y="13" width="4" height="6" rx="1.5"/><rect x="17.5" y="13" width="4" height="6" rx="1.5"/></svg></span><span class="ibig" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 14v-2a8 8 0 0 1 16 0v2"/><rect x="2.5" y="13" width="4" height="6" rx="1.5"/><rect x="17.5" y="13" width="4" height="6" rx="1.5"/></svg></span><h3>Call Center Solutions</h3><p>Auto-dialers, live agent monitoring and lead distribution for high-volume centers.</p><div class="tg"><span>High Volume</span><span>Real-Time Monitoring</span></div></article><article class="it2 fade" style="--g:linear-gradient(150deg,#2a2a35,#14141c)"><span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="5.5" width="19" height="13" rx="2.5"/><path d="M2.5 10h19M6.5 14.5h4"/></svg></span><span class="ibig" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="5.5" width="19" height="13" rx="2.5"/><path d="M2.5 10h19M6.5 14.5h4"/></svg></span><h3>FinTech Systems</h3><p>Payment gateway integrations, custom financial reporting and fraud-detection logic.</p><div class="tg"><span>PCI-Ready</span><span>Scalable</span></div></article><article class="it2 fade" style="--g:linear-gradient(150deg,#ffb47a,#ff7a2e)"><span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 6.5h11v9h-11zM13.5 9.5h4l3 3v3h-7"/><circle cx="6.5" cy="17.5" r="1.8"/><circle cx="17" cy="17.5" r="1.8"/></svg></span><span class="ibig" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 6.5h11v9h-11zM13.5 9.5h4l3 3v3h-7"/><circle cx="6.5" cy="17.5" r="1.8"/><circle cx="17" cy="17.5" r="1.8"/></svg></span><h3>Logistics & Supply</h3><p>Fleet tracking, inventory management and automated order fulfillment.</p><div class="tg"><span>Real-Time</span><span>Efficient</span></div></article><article class="it2 fade" style="--g:linear-gradient(150deg,#3a2416,#1a120c)"><span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11 12 4l9 7"/><path d="M5.5 9.5V20h13V9.5M10 20v-5h4v5"/></svg></span><span class="ibig" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11 12 4l9 7"/><path d="M5.5 9.5V20h13V9.5M10 20v-5h4v5"/></svg></span><h3>PropTech (Real Estate)</h3><p>Lead management for realtors, property portals and automated listing sync across platforms.</p><div class="tg"><span>Lead Conversion</span><span>Listing Sync</span></div></article></div>
</section>

<section class="wrap blk" id="process" aria-labelledby="h-pro">
 <div class="fade" style="text-align:center"><span class="eyebrow">Step by step</span><h2 id="h-pro">How a project <em>works</em></h2></div>
 <ol class="proc2 fade"><li class="ps2"><span class="dot2">01</span><h3>Discovery</h3><p>We go over your workflow, what's slowing it down and what a fix needs — before anything is scoped or quoted.</p></li><li class="ps2"><span class="dot2">02</span><h3>Strategy</h3><p>I plan the database, tech stack and feature scope, and we agree on what "done" looks like.</p></li><li class="ps2"><span class="dot2">03</span><h3>Execution</h3><p>Built in stages with testing at each milestone — working software along the way, not one big reveal.</p></li><li class="ps2"><span class="dot2">04</span><h3>Optimization</h3><p>After launch I monitor real usage and adjust as your traffic or team grows.</p></li></ol>
 <div class="stats2" aria-label="Performance standards"><div class="st2 fade"><b><span class="cu" data-to="99.9">99.9</span>%</b><small>Uptime goal</small></div><div class="st2 fade"><b>&lt; <span class="cu" data-to="2">2</span>s</b><small>Load time</small></div><div class="st2 fade"><b><span class="cu" data-to="100">100</span>/100</b><small>SEO score</small></div><div class="st2 fade"><b><span class="cu" data-to="A+">A+</span></b><small>Security</small></div></div>
</section>

<section class="wrap blk" id="reviews" aria-labelledby="h-rev">
 <div class="rhead fade"><div><span class="eyebrow">Client reviews</span><h2 id="h-rev">What clients say about <em>working with me</em></h2><p class="sub">Feedback from clients and collaborators in Pakistan, UK, UAE and the US.</p></div>
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

<section class="wrap blk fqw" id="faq" aria-labelledby="h-faq">
 <div class="fade"><span class="eyebrow">Business FAQ</span><h2 id="h-faq">Questions, <em>answered</em></h2><p class="sub">Something else on your mind? Just ask.</p></div>
 <div class="fade"><details><summary>Do you only work with Laravel, or do you handle full projects?</summary><p>I handle end-to-end web applications and products — from database architecture and backend APIs in Laravel/PHP to responsive frontend interfaces and Flutter mobile applications.</p></details><details><summary>Do you work with clients outside Pakistan?</summary><p>Yes, I work with startups, businesses and remote teams worldwide across the US, UK, UAE and Europe.</p></details><details><summary>What kind of projects do you usually take on?</summary><p>Custom CRM systems, SaaS platforms, internal business automation tools, WebSocket chat apps and RESTful APIs.</p></details><details><summary>Do you use AI tools when building software?</summary><p>I implement AI automation workflows (LLM integrations, auto-tagging, lead routing) for client applications, while writing clean, hand-crafted, production-ready code.</p></details><details><summary>How long does a project take?</summary><p>Typical custom projects range from 2 to 8 weeks depending on the scope, delivered in iterative milestones with working software at each phase.</p></details><details><summary>How do I get started?</summary><p>Click “Book a Call” or reach out through the contact form with a brief summary of what you are looking to build.</p></details></div>
</section>

<section class="band fade" aria-labelledby="h-cta"><div><h2 id="h-cta">Ready to start a project?</h2><p>Tell me about your project and I'll get back to you within 24 hours with next steps.</p></div>
 <div class="btns" style="margin:0"><a class="bo w" href="<?= base_url('/contact') ?>">Book a Call →</a><a class="bo g" href="<?= base_url('/contact') ?>">Claim Free Audit</a></div></section>
</main>
<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/services-page.js') ?>"></script><script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script><script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= time() ?>" defer></script>
</body></html>