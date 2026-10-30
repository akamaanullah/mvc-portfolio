<?php
$pageMeta = [
    'title' => 'About Amaanullah Khan | Software Developer, Karachi',
    'description' => 'Amaanullah Khan is a Karachi software developer and team lead at Richmond Tech Group, building Laravel CRM, SaaS and automation systems worldwide.',
    'canonical' => base_url('/about'),
    'og_type' => 'profile',
    'image' => asset_url('media/profile-poster.jpg'),
    'page_type' => 'AboutPage',
    'faqs' => [
        [
            'question' => 'Who is Amaanullah Khan?',
            'answer' => 'Amaanullah Khan is a software developer and systems architect based in Karachi, Pakistan. He is a Team Lead and Senior Developer at Richmond Tech Group and builds CRM systems, SaaS platforms and automation tools using PHP and Laravel, along with React, Node.js and Flutter.'
        ],
        [
            'question' => 'Where is Amaanullah Khan based, and who does he work with?',
            'answer' => 'He is based in Karachi, Pakistan, and works with businesses in Pakistan, the United States, the United Kingdom, the UAE and Saudi Arabia. Projects are handled remotely through email, calls and WhatsApp, and he usually replies within 24 hours.'
        ],
        [
            'question' => 'Do you only work with Laravel, or do you handle full projects?',
            'answer' => 'Laravel and PHP are the daily stack, but projects are handled end to end: database design, backend, web interface and mobile apps with Flutter. When a project needs React, Node.js or Python, those are used too, so you don\'t need a second developer just to connect the pieces.'
        ],
        [
            'question' => 'What kind of projects do you usually take on?',
            'answer' => 'Mostly CRM systems, SaaS platforms, web applications, workflow automation and mobile apps. The common thread is software a team uses every day to run their business, not a one-time demo or proof of concept.'
        ],
        [
            'question' => 'Do you use AI tools when building software?',
            'answer' => 'Yes, mainly to speed up repetitive work. Everything that goes into a project is reviewed personally, because responsibility for how it behaves in production, how secure it is and how easy it is to maintain stays with the developer. AI helps write code faster but doesn\'t replace understanding it.'
        ],
        [
            'question' => 'What happens after I contact you?',
            'answer' => 'Send a short description of what\'s slowing your team down. You\'ll get a reply, usually within 24 hours, with questions about how your team works before any solution is suggested. After launch you receive documentation and a walkthrough so your team can handle basic changes without waiting.'
        ]
    ]
];
$extraCss = [
    'css/about-page.css',
    'css/chatbot.css',
    'css/media.css',
    'css/layout.css'
];
?>
<!doctype html>
<html lang="en">
<head>
<?php require view_path('layouts/head.php'); ?>
</head><body class="dark">
<div class="bgfx"></div>
<?php $home = false; $active = 'About'; require view_path('layouts/header.php'); ?>

<main>
<!-- ==========================================================================
     HERO SECTION
     ========================================================================== -->
<header class="wrap ahero">
 <aside class="card pcard fade">
  <div class="pcard-media">
   <video width="400" height="400" class="pvid" autoplay muted loop playsinline preload="metadata" poster="<?= asset_url('media/profile-poster.jpg') ?>" aria-label="Amaanullah Khan, software developer and team lead based in Karachi, Pakistan"><source src="<?= asset_url('media/profile.webm') ?>" type="video/webm"><source src="<?= asset_url('media/profile.mp4') ?>" type="video/mp4"></video>
  </div>
  <div class="pcard-body">
   <h2>Amaanullah Khan</h2>
   <div class="role">Software Developer &amp; Team Lead</div>
   <div class="meta"><span style="display:inline-flex;align-items:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px;"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>Karachi, Pakistan</span><span>PHP · Laravel · Flutter</span></div>
  </div>
  <a class="grate" href="https://maps.google.com/?cid=AmaanullahKhan" target="_blank" rel="noopener"><span class="g">G</span><span><b>4.8 ★ Google Rating</b><small>27 Google reviews</small></span></a>
 </aside>
 <div class="fade ahero-content">
  <span class="eyebrow">✦ About Amaanullah Khan</span>
  <h1>Hi, I'm <em>Amaanullah Khan</em>,<br>Software Developer &amp; Systems Architect</h1>
  <p class="lead2">I'm a software developer based in Karachi, Pakistan, and I lead a development team at Richmond Tech Group. My daily stack is PHP and Laravel, and I build CRM systems, SaaS platforms and workflow automation for businesses in Pakistan, the United States, the United Kingdom, the UAE and Saudi Arabia.</p>
  <p class="lead2" style="margin-top:14px;font-size:16px">I started with small Shopify fixes and grew into building multi-user systems that run a company's daily operations. This page explains how I got here, how I think about software, and what you can expect if we work together.</p>
  <div class="btns">
   <a class="bo pri" href="<?= base_url('/contact') ?>">Let's work together →</a>
   <a class="bo sec" href="<?= asset_url('media/AK-Resume.pdf') ?>" download><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>Download CV</a>
  </div>
  <div class="facts">
   <div><b>PHP &amp; Laravel</b><small>my daily stack</small></div>
   <div><b>React · Node · Flutter</b><small>web to mobile</small></div>
   <div><b>1.5M+ leads</b><small>handled by a CRM I built</small></div>
  </div>
  <div class="vp">VERIFIED PROFILES <a href="https://www.linkedin.com/in/akamaanullah" target="_blank" rel="noopener me">LinkedIn</a><a href="https://github.com/akamaanullah" target="_blank" rel="noopener me">GitHub</a></div>
 </div>
</header>

<!-- ==========================================================================
     HOW I GOT HERE
     ========================================================================== -->
<section class="wrap blk" id="story" aria-labelledby="h-story">
 <div class="fade">
  <span class="eyebrow">How I got here</span>
  <h2 id="h-story">From one small build to <em>real systems</em></h2>
  <p class="sub">I built something small, watched a stranger use it, and got hooked on that feeling. Everything since has been about making software that people keep using.</p>
 </div>
 <div class="story-grid">
  <article class="story-card fade">
   <div class="story-head">
    <span class="story-num">01</span>
    <span class="story-tag">E-Commerce &amp; ROI</span>
   </div>
   <h3>Shopify Developer</h3>
   <p>My first paid job was at a small software studio, where I customised Liquid themes, fixed slow-loading store pages and adjusted checkout flows to reduce drop-offs. It was a good place to start because every change had a direct, visible effect on whether a customer finished a purchase or left. That taught me that a feature isn't done just because it works. It's done when it actually helps the business.</p>
  </article>

  <article class="story-card fade">
   <div class="story-head">
    <span class="story-num">02</span>
    <span class="story-tag">UI Engineering</span>
   </div>
   <h3>Frontend Development</h3>
   <p>From Shopify I moved into frontend work with HTML, CSS and JavaScript. I cared about page speed and accessibility from the beginning, not as an afterthought. But the longer I worked on interfaces, the more curious I became about what was happening behind them: how data moved, how it was stored and how it stayed secure.</p>
  </article>

  <article class="story-card fade">
   <div class="story-head">
    <span class="story-num">03</span>
    <span class="story-tag">Architecture &amp; Scale</span>
   </div>
   <h3>PHP and MySQL</h3>
   <p>That curiosity pulled me toward PHP and MySQL. I spent time learning proper database design, writing secure server-side logic and understanding what breaks when a system goes from 10 users to 1,000. Backend development stopped being just another skill on a resume. It became the part of the job I look forward to: keeping an application fast and stable as it grows, instead of patching it after it slows down.</p>
  </article>

  <article class="story-card fade">
   <div class="story-head">
    <span class="story-num">04</span>
    <span class="story-tag">Leadership &amp; Delivery</span>
   </div>
   <h3>Senior Developer and Team Lead</h3>
   <p>Today I work as a Senior Developer and Team Lead at Richmond Tech Group. My role isn't limited to writing code. I help plan how a project should be built before development starts, review other developers' work, and stay involved so the finished product solves the problem it was meant to solve, not just the problem as it was described in the first meeting.</p>
  </article>
 </div>

 <div class="story-proof fade">
  <div class="sp-text">
   <div class="sp-badge">Enterprise Proven</div>
   <p>You can see this approach in my <a href="<?= base_url('/projects') ?>">case studies</a>, including a <a href="<?= base_url('/projects/multi-tenant-crm') ?>">CRM that handles over 1.5 million leads and 300+ daily users</a>.</p>
  </div>
  <a class="sp-btn" href="<?= base_url('/projects/multi-tenant-crm') ?>">View CRM Case Study <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
 </div>
</section>

<!-- ==========================================================================
     WHAT I CARE ABOUT (Principles)
     ========================================================================== -->
<section class="wrap blk" id="values" aria-labelledby="h-val">
 <div class="fade">
  <span class="eyebrow">Principles</span>
  <h2 id="h-val">What I care about on <em>every project</em></h2>
  <p class="sub">I focus on building systems that solve real operational problems and deliver long-term business value.</p>
 </div>
 <div class="g2">
  <article class="card fade">
   <div class="ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5 9-10"/></svg></div>
   <h3>Understanding the problem first</h3>
   <p>I ask how a team actually works before I suggest a solution, instead of proposing the same setup for every client.</p>
  </article>
  <article class="card fade">
   <div class="ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5 9-10"/></svg></div>
   <h3>Building software that's easy to maintain</h3>
   <p>A system that looks impressive in a demo but breaks the first time someone edits it isn't a win, for the client or for me.</p>
  </article>
  <article class="card fade">
   <div class="ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5 9-10"/></svg></div>
   <h3>Measuring results, not just shipping features</h3>
   <p>If a CRM is supposed to save a sales team time, I want to know it's actually doing that, not just that it's technically live.</p>
  </article>
  <article class="card fade">
   <div class="ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5 9-10"/></svg></div>
   <h3>Staying involved after launch</h3>
   <p>Handover isn't the end of the relationship. I give documentation and a walkthrough so your team isn't stuck waiting on me for basic changes.</p>
  </article>
 </div>
</section>

<!-- ==========================================================================
     TRAINED ENGINEER & TOOLS I BUILD WITH
     ========================================================================== -->
<section class="wrap blk split" id="foundation" aria-labelledby="h-fnd">
 <div class="fade">
  <span class="eyebrow">Engineering Depth</span>
  <h2 id="h-fnd">Trained engineer, <em>not just a prompt</em></h2>
  <div class="quote">
   <p>Right now, almost anyone can describe an app in plain language and get an AI tool to generate something that runs. That part is genuinely useful, and I use AI tools in my own workflow to move faster on repetitive work. But there's a difference between code that runs today and a system that still works after <b>300 people are using it daily</b>, after a client asks for a feature nobody planned for, or after it needs to survive a security review.</p>
   <p>My <b>3-year Aptech diploma</b> covered databases, system architecture and multiple programming languages, not just one framework. That's the part that doesn't show up in a quick demo but matters six months later: being able to read and debug the code that ships, explain why a system is structured a certain way, and adjust when a project needs something outside my usual stack. <b>AI speeds up how I write code. It doesn't replace understanding what that code does.</b></p>
  </div>
  <div class="ai-article-link">
   If you're weighing AI-generated code against a real engineer, I wrote about it here: <a href="<?= base_url('/articles/ai-wont-replace-fundamentals') ?>">why startups still need a real developer →</a>
  </div>
 </div>
 <div class="fade" id="stack">
  <span class="eyebrow">Tech ecosystem</span>
  <h2 style="font-size:28px">Tools I build with</h2>
  <div class="lbl">MASTERED ARCHITECTURE</div>
  <div class="chips2">
   <span>PHP / Laravel</span>
   <span>MySQL / MongoDB</span>
   <span>Node.js / React.js</span>
   <span>Python / API Design</span>
   <span>Flutter / Dart / Firebase</span>
   <span>JavaScript / HTML / CSS</span>
  </div>
  <div class="lbl">FUTURE FRONTIERS</div>
  <div class="chips2 fut">
   <span>AI / OpenAI / LangChain</span>
   <span>Go (Golang) / Rust</span>
   <span>Bun.js / Hono</span>
   <span>Web3 / Blockchain</span>
  </div>
 </div>
</section>

<!-- ==========================================================================
     HOW I THINK ABOUT BUSINESS SOFTWARE
     ========================================================================== -->
<section class="wrap blk" id="solutions" aria-labelledby="h-sol">
 <div class="fade">
  <span class="eyebrow">CRM, SaaS and automation</span>
  <h2 id="h-sol">How I think about <em>business software</em></h2>
  <p class="sub">I believe the best software doesn't just work. It solves a business problem.</p>
 </div>
 <div class="g3">
  <article class="card fade">
   <div class="ic">◆</div>
   <h3>Automation and efficiency</h3>
   <p>I look for manual, repetitive work in a team's day and replace it with workflows that run on their own, so people spend their time on work that needs a person.</p>
  </article>
  <article class="card fade">
   <div class="ic">◆</div>
   <h3>Multi-tenant architecture</h3>
   <p>When one system serves many companies, data separation and security come first. My CRM work is built this way and handles millions of records.</p>
  </article>
  <article class="card fade">
   <div class="ic">◆</div>
   <h3>Operational visibility</h3>
   <p>Dashboards that show managers what is happening right now, so decisions don't wait for an end-of-week report.</p>
  </article>
 </div>

 <div class="authority-links fade">
  <div class="auth-group">
   <span class="auth-title">Looking for a specific service?</span>
   <div class="auth-chips">
    <a href="<?= base_url('/services/custom-crm-development') ?>">Custom CRM Development</a>
    <a href="<?= base_url('/services/web-app-cms-development') ?>">Scalable Web Applications</a>
    <a href="<?= base_url('/services/business-process-automation') ?>">Business Process Automation</a>
   </div>
  </div>
  <div class="auth-group">
   <span class="auth-title">Local development &amp; consultations:</span>
   <div class="auth-chips">
    <a href="<?= base_url('/laravel-developer-karachi') ?>">Laravel Development in Karachi</a>
    <a href="<?= base_url('/crm-developers-pakistan') ?>">CRM Development in Pakistan</a>
    <a href="<?= base_url('/full-stack-developer-karachi') ?>">Hiring a Developer in Karachi</a>
   </div>
  </div>
 </div>
</section>

<!-- ==========================================================================
     PROFESSIONAL EXPERIENCE & EDUCATION
     ========================================================================== -->
<section class="wrap blk split" id="experience">
 <div class="fade" aria-labelledby="h-exp">
  <span class="eyebrow">Career</span>
  <h2 id="h-exp">Professional experience</h2>
  <div class="tl">
   <div class="it">
    <time>2024 – Present</time>
    <h3>Richmond Tech Group</h3>
    <p><b>Team Lead and Senior Developer</b> — I oversee project architecture, mentor developers and manage delivery on client systems.</p>
   </div>
   <div class="it">
    <time>2023 – 2024</time>
    <h3>Skylink Elevators</h3>
    <p><b>Systems Administrator</b> — I maintained the company's internal systems and infrastructure.</p>
   </div>
   <div class="it">
    <time>2023 – 2024</time>
    <h3>Master Travel &amp; Tours</h3>
    <p><b>Ticketing Agent</b> — My early work experience. It showed me how non-technical teams actually use software during a normal working day, which still shapes how I design tools for them.</p>
   </div>
  </div>
 </div>
 <div class="fade" aria-labelledby="h-edu">
  <span class="eyebrow">Learning</span>
  <h2 id="h-edu">Education &amp; training</h2>
  <div class="tl">
   <div class="it">
    <time>2022 – 2026</time>
    <h3>Aptech Learning <span class="tag">Graduated</span></h3>
    <p><b>Software Engineering Diploma</b> — A 3-year advanced program covering programming fundamentals, database design, system architecture and multiple languages and frameworks.</p>
   </div>
   <div class="it">
    <time>2024 · 6 months</time>
    <h3>Design Station</h3>
    <p><b>Graphic Designing Short Course</b> — It helps me work more effectively with designers and understand UI decisions, not just implement them.</p>
   </div>
   <div class="it">
    <time>2021 – 2022</time>
    <h3>Science College</h3>
    <p><b>Pre-Engineering (Intermediate)</b></p>
   </div>
  </div>
 </div>
</section>

<!-- ==========================================================================
     FREQUENTLY ASKED QUESTIONS
     ========================================================================== -->
<section class="wrap blk" id="faq" aria-labelledby="h-faq" style="max-width:860px">
 <div class="fade" style="text-align:center">
  <span class="eyebrow">FAQ</span>
  <h2 id="h-faq">Frequently asked questions</h2>
  <p class="sub" style="margin:0 auto">Clear answers about my stack, background, and project process.</p>
 </div>
 <div class="fade" style="margin-top:30px">
  <details open>
   <summary>Who is Amaanullah Khan?</summary>
   <p>Amaanullah Khan is a software developer and systems architect based in Karachi, Pakistan. He is a Team Lead and Senior Developer at Richmond Tech Group and builds CRM systems, SaaS platforms and automation tools using PHP and Laravel, along with React, Node.js and Flutter.</p>
  </details>
  <details>
   <summary>Where is Amaanullah Khan based, and who does he work with?</summary>
   <p>He is based in Karachi, Pakistan, and works with businesses in Pakistan, the United States, the United Kingdom, the UAE and Saudi Arabia. Projects are handled remotely through email, calls and WhatsApp, and he usually replies within 24 hours.</p>
  </details>
  <details>
   <summary>Do you only work with Laravel, or do you handle full projects?</summary>
   <p>Laravel and PHP are my daily stack, but I handle projects end to end: database design, backend, web interface and mobile apps with Flutter. When a project needs React, Node.js or Python, I use those too, so you don't need a second developer just to connect the pieces.</p>
  </details>
  <details>
   <summary>What kind of projects do you usually take on?</summary>
   <p>Mostly CRM systems, SaaS platforms, web applications, workflow automation and mobile apps. The common thread is software a team uses every day to run their business, not a one-time demo or proof of concept.</p>
  </details>
  <details>
   <summary>Do you use AI tools when building software?</summary>
   <p>Yes, mainly to speed up repetitive work. I review everything that goes into a project myself, because I'm responsible for how it behaves in production, how secure it is and how easy it is to maintain. AI helps me write code faster, but it doesn't replace understanding it.</p>
  </details>
  <details>
   <summary>What happens after I contact you?</summary>
   <p>Send a short description of what's slowing your team down. I'll reply, usually within 24 hours, and ask how your team actually works before suggesting anything. After launch I provide documentation and a walkthrough so your team can handle basic changes without waiting on me.</p>
  </details>
 </div>
</section>

<!-- ==========================================================================
     BOTTOM CTA
     ========================================================================== -->
<section class="wrap">
 <div class="cta fade">
  <div>
   <h2>Want to talk through your <span style="color:var(--o2)">project?</span></h2>
   <p>Tell me what's slowing your team down and I'll tell you how I'd approach it.</p>
  </div>
  <div class="btns" style="margin:0">
   <a class="bo pri" href="<?= base_url('/contact') ?>">Start a project →</a>
   <a class="bo sec" href="<?= asset_url('media/AK-Resume.pdf') ?>" download>Download CV</a>
  </div>
 </div>
</section>
</main>

<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/about-page.js') ?>"></script>
<script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script>
<script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= time() ?>" defer></script>
</body></html>