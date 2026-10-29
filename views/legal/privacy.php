<?php
$biz = config('business');
$siteUrl = rtrim($biz['url'] ?? 'https://amaanullah.com', '/');
$pageMeta = [
    'title' => 'Privacy Policy | Amaanullah Khan — Software Developer',
    'description' => 'Privacy Policy for Amaanullah Khan portfolio and custom software development services. Details on data protection, analytics, and contact inquiry confidentiality.',
    'canonical' => base_url('/privacy'),
    'og_type' => 'website',
    'image' => asset_url('images/og-services.png'),
    'page_type' => 'WebPage',
    'breadcrumbs' => [
        ['name' => 'Home', 'url' => base_url('/')],
        ['name' => 'Privacy Policy', 'url' => base_url('/privacy')]
    ]
];
$extraCss = [
    'css/errors.css',
    'css/layout.css'
];
?>
<!doctype html>
<html lang="en">
<head>
<?php require view_path('layouts/head.php'); ?>
<style>
.legal-wrap { max-width: 840px; margin: 120px auto 80px; padding: 0 24px; color: #d2b088; line-height: 1.8; }
.legal-wrap h1 { font-size: 38px; color: #fff; margin-bottom: 8px; font-weight: 800; }
.legal-wrap .updated { font-size: 14px; color: #f26a1b; margin-bottom: 40px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
.legal-wrap h2 { font-size: 22px; color: #fff; margin-top: 36px; margin-bottom: 14px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 8px; }
.legal-wrap p { margin-bottom: 18px; font-size: 16px; }
.legal-wrap ul { margin-bottom: 20px; padding-left: 20px; }
.legal-wrap li { margin-bottom: 8px; }
.legal-wrap a { color: #f26a1b; text-decoration: none; }
.legal-wrap a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="bgfx"></div>
<?php $home = false; $active = ''; require view_path('layouts/header.php'); ?>

<main class="legal-wrap">
  <h1>Privacy Policy</h1>
  <div class="updated">Last Updated: <?= date('F d, Y') ?></div>

  <p>Your privacy is of utmost importance. This Privacy Policy outlines how Amaanullah Khan ("I", "me", "my", or "Amaanullah") collects, uses, and protects any information you provide when using this website (<a href="<?= $siteUrl ?>"><?= htmlspecialchars($siteUrl) ?></a>) and engaging with custom software engineering services.</p>

  <h2>1. Information Collected</h2>
  <p>When you interact with this portfolio or submit an inquiry through the contact form or live chat, the following information may be collected:</p>
  <ul>
    <li><strong>Contact Information:</strong> Name, work email address, phone number, and company name.</li>
    <li><strong>Project Requirements:</strong> Project scope, budget range, target delivery timelines, and technical requirements provided in your messages.</li>
    <li><strong>Technical Interaction Data:</strong> Anonymized IP address, browser type, device category (desktop/mobile), referral sources, and interaction telemetry (scroll depth, session dwell time) collected to maintain performance, uptime, and security.</li>
  </ul>

  <h2>2. How Your Information Is Used</h2>
  <p>Any details submitted through this platform are utilized strictly for professional business purposes:</p>
  <ul>
    <li>Evaluating project inquiries, engineering feasibility, and preparing formal architectural proposals.</li>
    <li>Direct communication regarding consultation bookings, demos, and scope discussions.</li>
    <li>Monitoring server performance, thwarting malicious automated traffic, and ensuring optimal sub-second page delivery globally.</li>
  </ul>

  <h2>3. Data Confidentiality & Non-Disclosure</h2>
  <p>Your commercial ideas, business logic, system architecture briefs, and contact records are treated as strictly confidential. I do <strong>not</strong> sell, lease, trade, or distribute client contact information to any third parties or marketing syndicates. Data submitted is retained exclusively for ongoing client relationships and technical project delivery.</p>

  <h2>4. Security & Protection</h2>
  <p>This platform enforces modern web security best practices, including encrypted TLS/HTTPS transmission, PDO parameterized queries with zero emulation, XSS output encoding, and strict access controls over production server instances.</p>

  <h2>5. Your Rights & Inquiries</h2>
  <p>You have the right to request access to any personal contact information held on file or request its immediate deletion from records. If you have any questions regarding this policy or data processing, please reach out directly:</p>
  <p>Email: <a href="mailto:<?= htmlspecialchars($biz['email']) ?>"><?= htmlspecialchars($biz['email']) ?></a><br>
  Location: <?= htmlspecialchars($biz['geo_placename']) ?></p>
</main>

<?php require view_path('layouts/footer.php'); ?>
<script src="<?= asset_url('js/layout.js') ?>"></script>
</body>
</html>

