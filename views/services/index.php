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
            'provider' => [
                '@type' => 'Person',
                'name' => 'Amaanullah Khan',
                'jobTitle' => 'Independent Software Developer'
            ]
        ]
    ];
}

$servicesFaqs = [
    [
        'question' => 'What kinds of projects can you build?',
        'answer' => 'I work on business websites, online stores, web apps, mobile apps and custom software. That can mean a simple site for a new business, a customer portal, a subscription product or a tool for your team. The scope starts with what people need to do.'
    ],
    [
        'question' => 'Can you build a simple website?',
        'answer' => 'Yes. A project does not need to be a large software system. A clear business website with useful pages, a contact form and an easy way to update content may be the right fit. We choose the platform around your needs and budget.'
    ],
    [
        'question' => 'How much will my project cost?',
        'answer' => 'The estimate depends on the features, design, integrations and existing work. Share your main requirements and any budget range so we can discuss a realistic scope. Hosting, licences, external services and ongoing support should be identified separately in the proposal.'
    ],
    [
        'question' => 'How long will development take?',
        'answer' => 'The timeline depends on the size of the work, content readiness, access to other systems and feedback. A useful estimate needs an agreed feature list. We can also discuss a smaller first release if you want to test the idea before adding more features.'
    ],
    [
        'question' => 'Can you improve an existing website?',
        'answer' => 'Often, yes. A review helps identify whether the problem is in the design, code, database or hosting. Some projects need a focused fix, while others need a larger change. Start with the free technical audit if you are unsure which applies.'
    ],
    [
        'question' => 'What is the difference between AI and workflow automation?',
        'answer' => 'Workflow automation follows defined steps, such as sending an alert when an order arrives. AI can help interpret less structured information, such as reading an enquiry or drafting a summary. A project may combine both, with people reviewing important decisions.'
    ],
    [
        'question' => 'Should I use custom or ready-made software?',
        'answer' => 'Use an existing tool when it meets your main needs at a sensible total cost. Consider custom development when your process needs more control or different features. Compare the setup effort, integrations, maintenance and running costs before deciding.'
    ],
    [
        'question' => 'What happens to the code and accounts?',
        'answer' => 'Ownership, licences, access and handover should be written into the project agreement. Third-party tools have their own terms. Discuss these points before work starts so you know which code, accounts, documentation and data access are included in your project.'
    ],
    [
        'question' => 'Is support included after launch?',
        'answer' => 'Support arrangements depend on the agreement. The proposal should explain any included fixes, the support period and how future changes are handled. Maintenance, monitoring and new features can be discussed as a separate scope where needed.'
    ],
    [
        'question' => 'How do I start?',
        'answer' => 'Send a short description of the project, your current website or system if you have one, and what you want to improve. You do not need a technical specification to start the conversation. We can work through the requirements together.'
    ]
];

$pageMeta = [
    'title' => 'Software Development Services | Amaanullah',
    'description' => 'Explore website, web app, mobile app, SaaS and automation services from Amaanullah, an independent software developer.',
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
  <span class="eyebrow fade">✦ INDEPENDENT SOFTWARE DEVELOPER</span>
  <h1 class="fade">Web and <em>App Development</em></h1>
  <p class="lead2 fade">I build business websites, online stores, web applications and mobile apps. From a simple site to a custom software product, I help you choose a practical approach for your goals and budget.</p>
  
  <p class="local-seo-line fade" style="margin-top:14px;font-weight:600;color:var(--o)">Available for remote projects.</p>

  <div class="btns fade">
    <a class="bo pri" href="<?= base_url('/contact') ?>">Discuss Your Project →</a>
    <a class="bo sec" href="#development-services">Explore Services</a>
  </div>
  
  <p class="fade" style="margin-top:20px;font-size:13.5px;color:var(--mut)">
    Have a website already? <a href="<?= base_url('/services/free-technical-audit') ?>" style="color:var(--o);font-weight:700;text-decoration:underline">Request a free technical audit →</a>
  </p>
 </div>
 <div class="stage fade" aria-hidden="true">
  <div class="code tilt"><div class="mkbar"><i></i><i></i><i></i><span>AppBuilder.php</span></div><pre><span class="c">// App &amp; Web Development Architecture</span>
<span class="k">class</span> <span class="f">ProjectService</span>
{
  <span class="k">public function</span> <span class="f">buildSolution</span>(Requirement $req)
  {
    $stack = TechnologyStack::<span class="f">optimalFor</span>($req)
      -><span class="f">withCleanArchitecture</span>()
      -><span class="f">focusOnPerformance</span>();

    <span class="k">return new</span> <span class="f">ProductionRelease</span>($stack);
  }
}</pre></div>
  <div class="flt f1 o"><span>✦</span>Websites</div>
  <div class="flt f2"><span>✦</span>Web Apps</div>
  <div class="flt f4"><span>✦</span>Mobile Apps</div>
 </div>
</header>

<div class="marq" aria-hidden="true"><div>
  <span>Websites</span><span>Online Stores</span><span>Web Apps</span><span>Mobile Apps</span><span>SaaS Products</span><span>Custom CRM</span><span>Chat Apps</span><span>AI Automation</span><span>Workflow Automation</span><span>Technical Reviews</span>
  <span>Websites</span><span>Online Stores</span><span>Web Apps</span><span>Mobile Apps</span><span>SaaS Products</span><span>Custom CRM</span><span>Chat Apps</span><span>AI Automation</span><span>Workflow Automation</span><span>Technical Reviews</span>
</div></div>

<!-- ==========================================================================
     2. WHAT I CAN BUILD (DEVELOPMENT SERVICES)
     ========================================================================== -->
<section class="wrap blk" id="development-services" aria-labelledby="h-core">
 <div class="shead fade">
  <div>
    <span class="eyebrow">DEVELOPMENT SERVICES</span>
    <h2 id="h-core">What I Can Build</h2>
  </div>
  <p class="sub" style="max-width:540px">Choose the service closest to your project. If you are unsure, describe what you need the website or system to do, and we can work out a sensible starting point.</p>
 </div>
 
 <div class="bento">
  <!-- 1. Websites and Web Apps (First per instructions, span 7) -->
  <?php $sWeb = $getSvc('web-app-cms-development', 'Websites and Web Apps', 'Business websites, online stores and custom web apps, with the pages and tools your customers and team need.', ['Websites', 'Online Stores', 'Portals']); ?>
  <div class="bc b-span7 fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="4" width="19" height="15" rx="2.5"/><path d="M2.5 8.5h19M6 6.3h.01M8.5 6.3h.01"/></svg></span><a class="ba" href="<?= $sWeb['url'] ?>" aria-label="Explore Web Development">↗</a></div>
    <div class="mk wbmk live" data-anim="web" aria-hidden="true"><div class="mkbar"><i></i><i></i><i></i><span class="url">yourbrand.com</span></div><div class="wbg"><div class="sk hl"></div><div class="sk ln"></div><div class="sk ln s"></div><div class="tiles"><i class="sk"></i><i class="sk btn"></i><i class="sk"></i></div></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sWeb['title']) ?></h3>
      <p><?= htmlspecialchars($sWeb['summary']) ?></p>
      <div class="tg"><?php foreach ($sWeb['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links">
        <a href="<?= $sWeb['url'] ?>">Explore Web Development →</a>
      </div>
    </div>
  </div>

  <!-- 2. Mobile App Development (span 5) -->
  <?php $sMob = $getSvc('mobile-app-development', 'Mobile App Development', 'Android and iPhone apps for customers or teams, connected to your website, store or business system where needed.', ['Android', 'iPhone', 'Flutter']); ?>
  <div class="bc b-span5 fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6.5" y="2.5" width="11" height="19" rx="2.5"/><path d="M11 18.5h2"/></svg></span><a class="ba" href="<?= $sMob['url'] ?>" aria-label="Explore Mobile Apps">↗</a></div>
    <div class="mk mbmk live" data-anim="mob" aria-hidden="true"><div class="phone"><div class="notch"></div><div class="pl"></div><div class="pl s"></div><div class="plist"><div class="pc"></div><div class="pc"></div><div class="pc"></div><div class="pc"></div></div><div class="pn"><span class="spin"></span>Ready for iOS &amp; Android</div></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sMob['title']) ?></h3>
      <p><?= htmlspecialchars($sMob['summary']) ?></p>
      <div class="tg"><?php foreach ($sMob['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links"><a href="<?= $sMob['url'] ?>">Explore Mobile Apps →</a></div>
    </div>
  </div>

  <!-- 3. SaaS Application Development (span 5) -->
  <?php $sSaas = $getSvc('saas-application-development', 'SaaS Application Development', 'Turn your software idea into a working product with user accounts, customer workspaces and subscription features.', ['Accounts', 'Subscriptions', 'Dashboards']); ?>
  <div class="bc b-span5 fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 3 7.5l9 4.5 9-4.5z"/><path d="m3 12 9 4.5 9-4.5M3 16.5 12 21l9-4.5"/></svg></span><a class="ba" href="<?= $sSaas['url'] ?>" aria-label="Explore SaaS Development">↗</a></div>
    <div class="mk ssmk live" data-anim="saas" aria-hidden="true"><div class="ten" style="--y:0"><b>Workspace A</b><span>Active</span></div><div class="ten" style="--y:1"><b>Workspace B</b><span>Team</span></div><div class="ten on" style="--y:2"><b>Subscription</b><span class="bill">Paid <i>✓</i></span></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sSaas['title']) ?></h3>
      <p><?= htmlspecialchars($sSaas['summary']) ?></p>
      <div class="tg"><?php foreach ($sSaas['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links"><a href="<?= $sSaas['url'] ?>">Explore SaaS Development →</a></div>
    </div>
  </div>

  <!-- 4. Custom CRM Development (span 4) -->
  <?php $sCrm = $getSvc('custom-crm-development', 'Custom CRM Development', "Keep leads, customer records, follow-ups and sales reports together in a system built around your team's process.", ['Leads', 'Follow-ups', 'Reports']); ?>
  <div class="bc b-span4 fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c.8-3.6 3.4-5.5 6.5-5.5s5.7 1.9 6.5 5.5"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7M18.5 14.8c1.6.9 2.6 2.6 3 5.2"/></svg></span><a class="ba" href="<?= $sCrm['url'] ?>" aria-label="Explore CRM Development">↗</a></div>
    <div class="mk crmk live" data-anim="crm" aria-hidden="true"><div class="mkbar"><i></i><i></i><i></i><span>Pipeline · Active</span><em class="lv">● Live</em></div>
    <div class="crmg"><div class="kpis"><div><small>Leads</small><b>Active</b></div><div><small>Deals</small><b>Won</b></div><div><small>Tasks</small><b>Done</b></div></div>
    <div class="bars"><i style="--h:42%"></i><i style="--h:65%"></i><i style="--h:52%"></i><i style="--h:85%"></i><i style="--h:60%"></i><i style="--h:90%"></i></div>
    <div class="pipe"><span class="on">New</span><span>Follow-up</span><span>Proposal</span><span>Won</span></div></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sCrm['title']) ?></h3>
      <p><?= htmlspecialchars($sCrm['summary']) ?></p>
      <div class="tg"><?php foreach ($sCrm['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links">
        <a href="<?= $sCrm['url'] ?>">Explore CRM Development →</a>
      </div>
    </div>
  </div>

  <!-- 5. AI Automation Services (span 4) -->
  <?php $sAi = $getSvc('ai-automation-services', 'AI Automation Services', 'Use AI to read documents, sort enquiries or draft responses, with review steps where accuracy matters.', ['Documents', 'Enquiries', 'Drafts']); ?>
  <div class="bc b-span4 fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l1.8 4.7L18.5 9.5l-4.7 1.8L12 16l-1.8-4.7L5.5 9.5l4.7-1.8z"/><path d="M19 15l.8 2.2L22 18l-2.2.8L19 21l-.8-2.2L16 18l2.2-.8z"/></svg></span><a class="ba" href="<?= $sAi['url'] ?>" aria-label="Explore AI Automation">↗</a></div>
    <div class="mk aimk live" aria-hidden="true"><div class="node"><b>Enquiry</b>Inbound</div><div class="wire"></div><div class="node ai">✦ AI Step<b>Sort &amp; Draft</b></div><div class="wire"></div><div class="node"><b>Review</b>Team</div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sAi['title']) ?></h3>
      <p><?= htmlspecialchars($sAi['summary']) ?></p>
      <div class="tg"><?php foreach ($sAi['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links"><a href="<?= $sAi['url'] ?>">Explore AI Automation →</a></div>
    </div>
  </div>

  <!-- 6. Chat App Development (span 4) -->
  <?php $sChat = $getSvc('chat-app-development', 'Chat App Development', 'Add private messaging, team conversations or customer support chat to your own website or application.', ['Messaging', 'Groups', 'Notifications']); ?>
  <div class="bc b-span4 fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20.5l1.4-4.6A8 8 0 1 1 21 12z"/><path d="M8.5 11h.01M12 11h.01M15.5 11h.01"/></svg></span><a class="ba" href="<?= $sChat['url'] ?>" aria-label="Explore Chat Development">↗</a></div>
    <div class="mk chmk live" data-anim="chat" aria-hidden="true"><div class="bub l">Need help with our order?</div><div class="bub r">On it — checking details ✓</div><div class="bub l typing"><i></i><i></i><i></i></div></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sChat['title']) ?></h3>
      <p><?= htmlspecialchars($sChat['summary']) ?></p>
      <div class="tg"><?php foreach ($sChat['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links">
        <a href="<?= $sChat['url'] ?>">Explore Chat Development →</a>
      </div>
    </div>
  </div>

  <!-- 7. Business Process Automation (span 12, wider final card) -->
  <?php $sAuto = $getSvc('business-process-automation', 'Business Process Automation', 'Connect your tools and automate repeatable steps such as approvals, data updates, reminders and reports.', ['Workflows', 'Integrations', 'Approvals']); ?>
  <div class="bc b-span12 fade">
    <div class="bh"><span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 0 1-15.5 6.3M3 12A9 9 0 0 1 18.5 5.7"/><path d="M18.5 2v3.7h-3.7M5.5 22v-3.7h3.7"/></svg></span><a class="ba" href="<?= $sAuto['url'] ?>" aria-label="Explore Workflow Automation">↗</a></div>
    <div class="mk aumk live" aria-hidden="true"><span class="chip2">Input Trigger</span><span class="arrw"></span><span class="chip2 o">Automated Step</span><span class="arrw"></span><span class="chip2">System Updated ✓</span></div>
    <div class="bt">
      <h3><?= htmlspecialchars($sAuto['title']) ?></h3>
      <p><?= htmlspecialchars($sAuto['summary']) ?></p>
      <div class="tg"><?php foreach ($sAuto['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
      <div class="card-links"><a href="<?= $sAuto['url'] ?>">Explore Workflow Automation →</a></div>
    </div>
  </div>
 </div>
</section>

<!-- ==========================================================================
     3. PLAN, CHECK OR IMPROVE
     ========================================================================== -->
<section class="wrap blk" id="strategy" aria-labelledby="h-str">
 <div class="fade">
  <span class="eyebrow">BEFORE YOUR NEXT BUILD</span>
  <h2 id="h-str">Plan, Check or Improve</h2>
  <p class="sub">You may need a plan or a focused fix before you need a new system.</p>
 </div>
 <div class="cons fade">
  <?php 
  $sStrat = $getSvc('saas-product-strategy', 'SaaS Product Strategy', "Define the problem, the users and the first useful version of your product. Get a clearer feature list and a plan for development.", ['Product Plan', 'First Release', 'Priorities']);
  $sPerf = $getSvc('performance-tuning', 'Performance Tuning', "Identify slow pages, database delays or server issues. Focus improvements on the parts that affect everyday use.", ['Page Speed', 'Database', 'Server']);
  $sAudit = $getSvc('free-technical-audit', 'Free Technical Audit', "Share your website or application and the problem you are seeing. Start with an initial review and a short list of next steps.", ['Initial Review', 'Priorities', 'Next Steps']);
  ?>
  <div class="tabs" role="tablist" aria-label="Planning and technical review services">
   <button class="tab" role="tab" id="t1" aria-controls="p1" aria-selected="true"><span class="tn">01</span><span><b><?= htmlspecialchars($sStrat['title']) ?></b><small>Decide what to build first</small></span></button>
   <button class="tab" role="tab" id="t2" aria-controls="p2" aria-selected="false" tabindex="-1"><span class="tn">02</span><span><b><?= htmlspecialchars($sPerf['title']) ?></b><small>Find what is slowing you down</small></span></button>
   <button class="tab" role="tab" id="t3" aria-controls="p3" aria-selected="false" tabindex="-1"><span class="tn">03</span><span><b><?= htmlspecialchars($sAudit['title']) ?></b><small>Start with a focused review</small></span></button>
  </div>
  <div>
   <div class="panel" role="tabpanel" id="p1" aria-labelledby="t1">
     <span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 3 7.5l9 4.5 9-4.5z"/><path d="m3 12 9 4.5 9-4.5M3 16.5 12 21l9-4.5"/></svg></span>
     <h3><?= htmlspecialchars($sStrat['title']) ?></h3>
     <p><?= htmlspecialchars($sStrat['summary']) ?></p>
     <div class="tg"><?php foreach ($sStrat['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
     <a class="bo w" href="<?= base_url('/services/saas-product-strategy') ?>">Plan Your Product →</a>
   </div>
   <div class="panel" role="tabpanel" id="p2" aria-labelledby="t2" hidden>
     <span class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 0 1-15.5 6.3M3 12A9 9 0 0 1 18.5 5.7"/><path d="M18.5 2v3.7h-3.7M5.5 22v-3.7h3.7"/></svg></span>
     <h3><?= htmlspecialchars($sPerf['title']) ?></h3>
     <p><?= htmlspecialchars($sPerf['summary']) ?></p>
     <div class="tg"><?php foreach ($sPerf['tags'] as $tag): ?><span><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
     <a class="bo w" href="<?= base_url('/services/performance-tuning') ?>">Improve Performance →</a>
   </div>
   <div class="panel audit2" role="tabpanel" id="p3" aria-labelledby="t3" hidden>
     <span class="bi" style="background:rgba(255,255,255,.2);color:#fff"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg></span>
     <h3><?= htmlspecialchars($sAudit['title']) ?></h3>
     <p><?= htmlspecialchars($sAudit['summary']) ?></p>
     <div class="tg"><?php foreach ($sAudit['tags'] as $tag): ?><span style="background:rgba(255,255,255,.2);color:#fff"><?= htmlspecialchars($tag) ?></span><?php endforeach; ?></div>
     <a class="bo w" href="<?= base_url('/services/free-technical-audit') ?>">Request Free Audit →</a>
   </div>
  </div>
 </div>
</section>

<!-- ==========================================================================
     4. CUSTOM OR READY MADE?
     ========================================================================== -->
<section class="wrap blk" id="decision-guide" aria-labelledby="h-decide">
 <div class="fade">
  <span class="eyebrow">CHOOSE A PRACTICAL FIT</span>
  <h2 id="h-decide">Custom or Ready Made?</h2>
  <p class="sub">The right choice depends on how you work, what is already available and what the system will cost to run.</p>
 </div>

 <div class="decision-grid fade">
  <div class="dec-col dec-custom">
   <div class="dec-badge">Custom Software</div>
   <h3>Consider Custom Software</h3>
   <p style="color:var(--mut);line-height:1.7;font-size:15px;margin:0">
     Your workflow needs features that standard tools cannot provide. Several systems need to share information, or you are building a product for your own customers.
   </p>
  </div>

  <div class="dec-col dec-shelf">
   <div class="dec-badge shelf">Existing Tool</div>
   <h3>Consider an Existing Tool</h3>
   <p style="color:var(--mut);line-height:1.7;font-size:15px;margin:0">
     A reliable product already covers your main needs. You want a quicker start and can work within its features and pricing.
   </p>
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
   <h4>Can Custom Software Grow?</h4>
   <p>It can, when the design and hosting suit the workload. More users and data may require better database queries, testing and changes to the server setup. Growth is something to plan and measure, rather than promise with a single word.</p>
   <p class="sn-links" style="margin-top:10px">
     <a href="<?= base_url('/articles/custom-software-vs-saas-business-scalability') ?>">Compare Custom Software and SaaS →</a> &nbsp;|&nbsp; 
     <a href="<?= base_url('/contact') ?>">Get Help Choosing →</a>
   </p>
  </div>
 </div>
</section>

<!-- ==========================================================================
     5. WHERE MY WORK FITS (SECTOR CARDS)
     ========================================================================== -->
<section class="wrap blk" id="industries" aria-labelledby="h-ind">
 <div class="fade">
  <span class="eyebrow">PROJECT EXPERIENCE</span>
  <h2 id="h-ind">Where My Work Fits</h2>
  <p class="sub">Examples of the sectors and day-to-day processes covered in my portfolio.</p>
 </div>
 <div class="igrid2">
  <!-- 1. Sales and Operations -->
  <article class="it2 fade" style="--g:linear-gradient(150deg,#ff8a3d,#f26a1b)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c.8-3.6 3.4-5.5 6.5-5.5s5.7 1.9 6.5 5.5"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7M18.5 14.8c1.6.9 2.6 2.6 3 5.2"/></svg></span>
   <h3>Sales and Operations</h3>
   <p>Lead tracking, customer records and sales reports for busy teams.</p>
   <div class="tg"><span>Leads</span><span>Reports</span></div>
   <a class="i-link" href="<?= base_url('/projects/multi-tenant-crm-sales-operations-management-system') ?>">View Sales Platform →</a>
  </article>

  <!-- 2. Real Estate -->
  <article class="it2 fade" style="--g:linear-gradient(150deg,#3a2416,#1a120c)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11 12 4l9 7"/><path d="M5.5 9.5V20h13V9.5M10 20v-5h4v5"/></svg></span>
   <h3>Real Estate</h3>
   <p>Property listings, enquiries and dashboards for agents and agencies.</p>
   <div class="tg"><span>Listings</span><span>Enquiries</span></div>
   <a class="i-link" href="<?= base_url('/projects/category/real-estate-tech') ?>">View Property Projects →</a>
  </article>

  <!-- 3. E-commerce and Retail -->
  <article class="it2 fade" style="--g:linear-gradient(150deg,#24263a,#141524)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></span>
   <h3>E-commerce and Retail</h3>
   <p>Online stores, product catalogues and ordering tools for retail businesses.</p>
   <div class="tg"><span>Stores</span><span>Orders</span></div>
   <a class="i-link" href="<?= base_url('/projects/category/e-commerce') ?>">View Retail Projects →</a>
  </article>

  <!-- 4. HR and Payroll -->
  <article class="it2 fade" style="--g:linear-gradient(150deg,#2b1d16,#17100d)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
   <h3>HR and Payroll</h3>
   <p>Employee records, attendance, leave and payroll workflows in one place.</p>
   <div class="tg"><span>Attendance</span><span>Payroll</span></div>
   <a class="i-link" href="<?= base_url('/projects/hrm-employee-management-payroll-portal') ?>">View HR Portal →</a>
  </article>

  <!-- 5. Healthcare -->
  <article class="it2 fade" style="--g:linear-gradient(150deg,#1c2d27,#0e1915)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></span>
   <h3>Healthcare</h3>
   <p>Apps for medical records, hospital workflows and healthcare services.</p>
   <div class="tg"><span>Records</span><span>Mobile Apps</span></div>
   <a class="i-link" href="<?= base_url('/projects/category/healthcare-tech') ?>">View Healthcare Projects →</a>
  </article>

  <!-- 6. Expense Management -->
  <article class="it2 fade" style="--g:linear-gradient(150deg,#222538,#10131e)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="5.5" width="19" height="13" rx="2.5"/><path d="M2.5 10h19M6.5 14.5h4"/></svg></span>
   <h3>Expense Management</h3>
   <p>Expense records, budgets and spending summaries for clearer tracking.</p>
   <div class="tg"><span>Expenses</span><span>Budgets</span></div>
   <a class="i-link" href="<?= base_url('/projects/expense-voyage-budget-expense-management-web-app') ?>">View Expense App →</a>
  </article>

  <!-- 7. Messaging and Communities -->
  <article class="it2 fade" style="--g:linear-gradient(150deg,#2b1d16,#17100d)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20.5l1.4-4.6A8 8 0 1 1 21 12z"/><path d="M8.5 11h.01M12 11h.01M15.5 11h.01"/></svg></span>
   <h3>Messaging and Communities</h3>
   <p>Private conversations, group messaging and professional networking tools.</p>
   <div class="tg"><span>Messaging</span><span>Communities</span></div>
   <a class="i-link" href="<?= base_url('/projects/chatrox-real-time-messaging-professional-networking') ?>">View Chatrox →</a>
  </article>

  <!-- 8. Team Collaboration -->
  <article class="it2 fade" style="--g:linear-gradient(150deg,#2a2a35,#14141c)">
   <span class="iic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></span>
   <h3>Team Collaboration</h3>
   <p>Task boards and shared workspaces that make project progress easier to follow.</p>
   <div class="tg"><span>Tasks</span><span>Workspaces</span></div>
   <a class="i-link" href="<?= base_url('/projects/workspace-kanban-project-task-management-platform') ?>">View Team Workspace →</a>
  </article>
 </div>
</section>

<!-- ==========================================================================
     6. HOW A PROJECT WORKS
     ========================================================================== -->
<section class="wrap blk" id="process" aria-labelledby="h-pro">
 <div class="fade" style="text-align:center">
  <span class="eyebrow">FROM IDEA TO HANDOVER</span>
  <h2 id="h-pro">How a Project Works</h2>
 </div>
 <ol class="proc2 fade">
  <li class="ps2">
    <span class="dot2">01</span>
    <h3>Understand the Need</h3>
    <p>We discuss the users, the problem and the tools you already have. This helps define the right starting point.</p>
  </li>
  <li class="ps2">
    <span class="dot2">02</span>
    <h3>Agree the Scope</h3>
    <p>We set out the features, responsibilities and delivery stages, with an estimate based on the agreed work.</p>
  </li>
  <li class="ps2">
    <span class="dot2">03</span>
    <h3>Build and Review</h3>
    <p>Development follows the agreed stages. You review the key screens and workflows before the final release.</p>
  </li>
  <li class="ps2">
    <span class="dot2">04</span>
    <h3>Test and Launch</h3>
    <p>We check the agreed features, prepare the release and arrange handover. Ongoing support is scoped separately.</p>
  </li>
 </ol>

 <!-- SEE THE WORK (PROOF TILES) -->
 <div class="results-check-wrap fade" aria-labelledby="h-see-work" style="margin-top:70px">
  <div class="rc-head">
    <span class="eyebrow">PROJECTS YOU CAN EXPLORE</span>
    <h2 id="h-see-work">See the Work</h2>
    <p class="sub" style="margin:8px auto 0">Explore examples before deciding what your own project needs.</p>
  </div>
  <div class="results-grid">
   <a class="rc-card rc-link" href="<?= base_url('/projects/category/web-design-development') ?>" aria-label="Explore Online Stores projects">
    <b>Online Stores</b>
    <small>Catalogues and order flows</small>
    <span class="rc-arrow" aria-hidden="true">Explore →</span>
   </a>
   <a class="rc-card rc-link" href="<?= base_url('/projects/category/web-applications') ?>" aria-label="Explore Business Systems projects">
    <b>Business Systems</b>
    <small>Records and daily workflows</small>
    <span class="rc-arrow" aria-hidden="true">Explore →</span>
   </a>
   <a class="rc-card rc-link" href="<?= base_url('/projects/category/mobile-apps') ?>" aria-label="Explore Mobile Apps projects">
    <b>Mobile Apps</b>
    <small>Apps for customers and teams</small>
    <span class="rc-arrow" aria-hidden="true">Explore →</span>
   </a>
   <a class="rc-card rc-link" href="<?= base_url('/projects/category/products') ?>" aria-label="Explore Team Tools projects">
    <b>Team Tools</b>
    <small>Messaging and shared work</small>
    <span class="rc-arrow" aria-hidden="true">Explore →</span>
   </a>
  </div>
  <div style="text-align:center;margin-top:32px">
    <a class="bo pri" href="<?= base_url('/projects') ?>">Explore Projects →</a>
  </div>
 </div>
</section>

<!-- ==========================================================================
     7. CLIENT FEEDBACK
     ========================================================================== -->
<section class="wrap blk" id="reviews" aria-labelledby="h-rev">
 <div class="rhead fade">
  <div>
    <span class="eyebrow">CLIENT FEEDBACK</span>
    <h2 id="h-rev">What Clients Say</h2>
    <p class="sub">Read feedback alongside the projects it relates to.</p>
  </div>
  <div class="rnav"><button type="button" id="rp" aria-label="Previous review">←</button><button type="button" id="rn" aria-label="Next review">→</button></div>
 </div>
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
     8. COMMON QUESTIONS (10 FAQ ITEMS)
     ========================================================================== -->
<section class="wrap blk fqw" id="faq" aria-labelledby="h-faq">
 <div class="fade">
  <span class="eyebrow">BEFORE YOU START</span>
  <h2 id="h-faq">Common Questions</h2>
  <p class="sub">Straight answers about choosing a service and planning the work.</p>
 </div>
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
     9. FINAL CONTACT SECTION
     ========================================================================== -->
<section class="wrap svc-contact-sec fade" id="contact-section" aria-labelledby="h-contact">
  <div class="svc-contact-left">
    <span class="eyebrow">START A CONVERSATION</span>
    <h2 id="h-contact">Tell Me What You Need</h2>
    <p>Share your idea, your current website or the problem you want to solve. We can discuss a practical next step.</p>
    <div class="btns" style="margin-top:12px">
      <a class="bo pri" href="<?= base_url('/contact') ?>">Discuss Your Project →</a>
      <a class="bo sec" href="<?= base_url('/services/free-technical-audit') ?>">Request Free Audit</a>
    </div>
    <div class="svc-contact-desc">
      Websites, web applications, mobile apps and custom software. Available for remote projects.
    </div>
  </div>

  <div class="svc-contact-card">
    <h3>Tell Me About Your Project</h3>
    <form class="sc-form" id="svcProjectForm" action="<?= base_url('/contact') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off" aria-hidden="true">
      
      <div class="form-success" id="svcFormSuccess" style="display:none" role="status">
        Thanks. Your project details have been sent.
      </div>

      <div class="sc-field">
        <label for="sc_name">Name *</label>
        <input type="text" id="sc_name" name="name" required placeholder="Your full name" autocomplete="name">
      </div>

      <div class="sc-field">
        <label for="sc_email">Email *</label>
        <input type="email" id="sc_email" name="email" required placeholder="you@company.com" autocomplete="email">
      </div>

      <div class="sc-field">
        <label for="sc_link">Website or App Link</label>
        <input type="url" id="sc_link" name="project_link" placeholder="https://example.com (if existing)">
      </div>

      <div class="sc-field">
        <label for="sc_service">Service Needed *</label>
        <select id="sc_service" name="service" required>
          <option value="">Select a service…</option>
          <option value="Website or Web App">Website or Web App</option>
          <option value="Mobile App">Mobile App</option>
          <option value="SaaS Product">SaaS Product</option>
          <option value="Custom CRM">Custom CRM</option>
          <option value="AI Automation">AI Automation</option>
          <option value="Business Automation">Business Automation</option>
          <option value="Chat App">Chat App</option>
          <option value="Product Planning">Product Planning</option>
          <option value="Performance Tuning">Performance Tuning</option>
          <option value="Free Technical Audit">Free Technical Audit</option>
          <option value="Not Sure Yet">Not Sure Yet</option>
        </select>
      </div>

      <div class="sc-field">
        <label for="sc_details">Project Details *</label>
        <textarea id="sc_details" name="message" required rows="4" placeholder="What do you want to build or improve? Include the main features or the problem you are seeing."></textarea>
      </div>

      <button type="submit" class="bo pri" id="svcSubmitBtn" style="width:100%;justify-content:center;margin-top:6px">Send Project Details</button>

      <div class="priv-note">
        Your details are only used to reply to your enquiry. See my <a href="<?= base_url('/about') ?>">Privacy Policy</a>.
      </div>
    </form>
  </div>
</section>
</main>

<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/services-page.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script>
window.__BASE_URL = '<?= base_path_url() ?>';

// AJAX handler for the Project Details form
(function(){
  var form = document.getElementById('svcProjectForm');
  var success = document.getElementById('svcFormSuccess');
  var btn = document.getElementById('svcSubmitBtn');
  if(!form) return;
  form.addEventListener('submit', function(e){
    e.preventDefault();
    if(btn) { btn.disabled = true; btn.textContent = 'Sending…'; }
    var fd = new FormData(form);
    fetch(form.action, {
      method: 'POST',
      body: fd,
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    }).then(function(res){
      return res.json().catch(function(){ return { message: 'Thanks. Your project details have been sent.' }; });
    }).then(function(data){
      if(success) {
        success.textContent = data.message || 'Thanks. Your project details have been sent.';
        success.style.display = 'block';
      }
      form.reset();
      if(btn) { btn.disabled = false; btn.textContent = 'Send Project Details'; }
    }).catch(function(){
      if(success) {
        success.textContent = 'Thanks. Your project details have been sent.';
        success.style.display = 'block';
      }
      if(btn) { btn.disabled = false; btn.textContent = 'Send Project Details'; }
    });
  });
})();
</script>
<script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= time() ?>" defer></script>
</body></html>
