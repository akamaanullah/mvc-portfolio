<?php
$biz = config('business');
$siteUrl = rtrim($biz['url'] ?? 'https://amaanullah.com', '/');
$pageMeta = [
    'title' => 'Terms of Service | Amaanullah Khan — Software Developer',
    'description' => 'Terms of service and professional engagement standards for software engineering, custom CRM development, and architecture consulting by Amaanullah Khan.',
    'canonical' => base_url('/terms'),
    'og_type' => 'website',
    'image' => asset_url('images/og-services.png'),
    'page_type' => 'WebPage',
    'breadcrumbs' => [
        ['name' => 'Home', 'url' => base_url('/')],
        ['name' => 'Terms of Service', 'url' => base_url('/terms')]
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
  <h1>Terms of Service</h1>
  <div class="updated">Last Updated: <?= date('F d, Y') ?></div>

  <p>Welcome to the portfolio and professional software consultancy portal of Amaanullah Khan (<a href="<?= $siteUrl ?>"><?= htmlspecialchars($siteUrl) ?></a>). By accessing this site or engaging in engineering consultations, you agree to comply with and be bound by the following terms.</p>

  <h2>1. Intellectual Property & Code Ownership</h2>
  <p>Unless explicitly agreed under a custom Master Services Agreement (MSA) or Statement of Work (SOW):</p>
  <ul>
    <li><strong>Client Deliverables:</strong> Bespoke custom software, source code, data schemas, and proprietary business applications engineered under paid contract are transferred to the client upon full project settlement, ensuring 100% intellectual property ownership without recurring software licensing fees.</li>
    <li><strong>Portfolio Materials:</strong> Case study text, architecture diagrams, technical benchmarks, and editorial articles hosted on this domain are the intellectual property of Amaanullah Khan and may not be republished without written attribution.</li>
  </ul>

  <h2>2. Professional Consultations & Estimates</h2>
  <p>Technical assessments, discovery calls, and preliminary architectural estimates provided via this website are intended for scoping and planning purposes. Formal engineering engagements, milestones, SLAs, and deliverables are governed by individual contractual agreements signed prior to sprint kickoff.</p>

  <h2>3. System Performance & Guarantees</h2>
  <p>All production systems are engineered adhering to industry standards (OWASP security guidelines, sub-second TTFB, PageSpeed 90+ targets, and atomic transaction handling). However, overall system uptime, external third-party API dependencies (e.g. payment gateways, cloud hosting providers, AI model providers), and client infrastructure environments are subject to third-party availability.</p>

  <h2>4. Limitation of Liability</h2>
  <p>Information published across technical articles and case studies represents professional engineering practices and architectural analysis. Readers implementing code patterns or system architectures on their own infrastructure do so at their own discretion.</p>

  <h2>5. Contact & Jurisdiction</h2>
  <p>For inquiries regarding these terms or commercial service contracts, please contact:</p>
  <p>Email: <a href="mailto:<?= htmlspecialchars($biz['email']) ?>"><?= htmlspecialchars($biz['email']) ?></a><br>
  Entity: <?= htmlspecialchars($biz['legal_name']) ?><br>
  Location: <?= htmlspecialchars($biz['geo_placename']) ?></p>
</main>

<?php require view_path('layouts/footer.php'); ?>
<script src="<?= asset_url('js/layout.js') ?>"></script>
</body>
</html>

