# Technical SEO, GEO & AEO Comprehensive Audit Report
**Target Entity**: Amaanullah Khan (`https://amaanullah.com`)
**Audited Environment**: Local Project Workspace (`d:\xampp\htdocs\web3d-full`)
**Audit Date**: October 31, 2026
**Auditor**: Senior Technical SEO, GEO & AEO Systems Architect
**Mode**: STRICT READ-ONLY SOURCE AUDIT (No external fetching, zero source modifications)

---

## 1. Executive Summary

This audit evaluates the newly rebuilt custom PHP MVC platform powering `amaanullah.com`. The codebase demonstrates strong architectural intentions—featuring an in-house SEO Engine (`App\Helpers\SeoEngine`), Knowledge Graph entity definitions (`config/business.php`), specialized AI crawler endpoint integration (`llms.txt`, `llms-full.txt`), and rich schema graphs. However, critical implementation disconnects between the unified engine and legacy standalone templates significantly depress the site's search engine, generative engine, and answer engine performance.

### Scorecard Breakdown

| Category | Score (/100) | Status | Primary Focus |
| :--- | :---: | :---: | :--- |
| **Technical SEO** | **71/100** | ⚠️ At Risk | Canonical URL environment pollution (localhost leakage), duplicate `<head>` engines, missing server security & redirect rules in `.htaccess`. |
| **On-Page SEO** | **78/100** | ⚠️ Needs Work | 52 broken internal links, title tag truncation across articles, duplicate title suffixes, unoptimized image alt text. |
| **Performance (Est.)** | **67/100** | ❌ High Risk | Uncompressed raw PNG images (>1MB per banner), render-blocking CSS in `<head>`, canvas/3D JS runtime overhead. |
| **Schema / Structured Data** | **62/100** | ❌ Broken | Line-by-line newline explosion bug in `landing/show.php` breaking JSON-LD parser; disconnected `@graph` entities across project/article templates. |
| **AEO (Answer Engine)** | **76/100** | ⚠️ Moderate | Strong buyer FAQs on services and landing pages, but missing structured definition snippets and voice-query targeting on core hubs. |
| **GEO (Generative Engine)** | **79/100** | ⚠️ Moderate | `llms.txt` and `llms-full.txt` exist with rich entity anchors, but contain fatal 404 links to dead project routes; missing modern AI crawler tokens in `robots.txt`. |
| **Content & Keywords** | **81/100** | 🟢 Good | High-depth copy, excellent commercial intent for Karachi/Pakistan, but keyword cannibalization between CRM services vs CRM landing pages. |
| **Trust & Local** | **75/100** | ⚠️ Moderate | Accurate NAP in `config/business.php`, but contact form lacks rate limiting/spam throttle; missing web app manifest. |
| **OVERALL COMPOSITE** | **73.6 / 100** | ⚠️ **Grade: C+ (High Potential, Critical Fixes Required)** | |

---

## 2. Gap Summary Table per Category

| Category | What is Missing | What is Weak | What is Broken |
| :--- | :--- | :--- | :--- |
| **Technical SEO** | HTTPS 301 redirect, www-to-non-www redirect, HSTS, CSP, and `site.webmanifest` in `public/`. | Dual `<head>` architecture: standard hubs use `layouts/head.php` while detail templates build `<head>` manually. | Canonical tags leak `http://localhost/web3d-full` when `base_url()` is called directly without `config('business.url')`. |
| **On-Page SEO** | Responsive `srcset` attributes and WebP/AVIF variants for all blog and project banners. | Title tags exceeding 60 characters on 24 pages; meta descriptions under 110 characters on 8 pages. | 52 broken internal links across core pages (e.g. `/services/saas-development`, `/services/chat-application-development`). |
| **Performance** | Asset minification pipeline, WebP modern image formats, font self-hosting. | 3 to 4 unminified stylesheets loaded sequentially in `<head>` (~150KB CSS before first paint). | 28 unoptimized PNG images exceeding 500KB - 1.3MB directly slowing mobile Largest Contentful Paint (LCP). |
| **Schema / Data** | `Review` / `AggregateRating` JSON-LD for visible client testimonials; `Service` schema on category views. | Fragmented standalone `<script>` tags instead of unified, entity-linked `@graph` structures on detail views. | `views/landing/show.php` splits JSON string by newline (`\n`), outputting dozens of invalid single-line `<script>` tags. |
| **AEO** | Direct 40-word definition sentences ("X is a software architecture that...") above complex technical concepts. | Homepage hero focuses on marketing copy rather than concise conversational answer blocks. | Zero voice-search structured FAQ schema on the primary homepage and category archives. |
| **GEO** | Google-Extended, OAI-SearchBot, and ChatGPT-User declarations in `robots.txt`. | Testimonial verification links (Clutch/Google Maps citation URLs) directly inside body copy. | `public/llms.txt` cites broken 404 URLs (`/projects/multi-tenant-crm` and `/projects/chatrox`). |
| **Content & Keywords** | Dedicated target landing pages for international markets (UAE/Dubai, UK, US) despite explicit business claims. | Cannibalization between `/services/custom-crm-development` and `/crm-developer-pakistan`. | Hardcoded dead article links in `/articles` index hero banner (`multi-tenant-saas-laravel`). |
| **Trust & Local** | Rate limiting / IP throttling middleware on `POST /contact` to prevent submission floods. | Missing automated SMTP email notification trigger when lead is submitted (stores to DB only). | `apple-touch-icon` points to rectangular 1722x444 banner logo (`images/logo.png`) instead of square icon. |

---

## 3. Top 10 Critical Fixes

| Rank | Issue | Category | File & Location | Impact | Effort |
| :---: | :--- | :--- | :--- | :--- | :---: |
| **1** | **Fix Fatal JSON-LD Newline Explode Bug** | Schema | `views/landing/show.php:35-44` | **Critical**: Fixes 50+ syntax errors across all high-intent landing pages in Google Rich Results. | **S** |
| **2** | **Enforce Absolute Production Canonicals** | Tech SEO | `app/Helpers/SeoEngine.php:20-31`, `views/projects/show.php:90`, `views/articles/show.php:30`, `views/services/show.php:8` | **Critical**: Eliminates localhost URL pollution in Google SERP indexing; guarantees single source of truth. | **S** |
| **3** | **Fix 52 Broken Internal Links** | On-Page | `views/home/index.php`, `views/about/index.php`, `views/articles/index.php`, `projects/` & `services/` templates | **High**: Eliminates crawl traps, 404 soft errors, and restores internal PageRank flow. | **M** |
| **4** | **Correct Broken Case Study Links in `llms.txt`** | GEO | `public/llms.txt:29-30`, `app/Services/SeoFilesService.php:447` | **High**: Prevents AI scrapers (ChatGPT, Claude, Perplexity) from crawling 404 links for core case studies. | **S** |
| **5** | **Update `robots.txt` for Next-Gen AI Agents** | GEO / Tech | `public/robots.txt:1-19`, `app/Services/SeoFilesService.php:320-345` | **High**: Explicitly permits `Google-Extended`, `OAI-SearchBot`, `ChatGPT-User`, and `PerplexityBot`. | **S** |
| **6** | **Unify Dual `<head>` Architecture** | Tech / Schema | Migrate `views/projects/show.php`, `views/articles/show.php`, `views/services/show.php` to `layouts/head.php` | **High**: Guarantees Dublin Core, GEO spatial tags, Twitter tags, and unified `@graph` schemas sit on 100% of pages. | **M** |
| **7** | **Implement Production `.htaccess` Redirects & Security** | Tech SEO | `public/.htaccess:29-34` | **High**: Enforces 301 HTTPS redirect, non-www canonicalization, HSTS header, and trailing slash sanity. | **S** |
| **8** | **Convert Heavy PNG Banners to WebP & Add Dimensions** | Performance | `public/images/articles/*.png`, `views/articles/index.php:98` | **High**: Reduces page weight from ~4.2MB to <650KB, vastly improving mobile LCP and Core Web Vitals. | **M** |
| **9** | **Fix `apple-touch-icon` Dimension Mismatch** | Trust / PWA | `views/layouts/head.php:114` | **Medium**: Replaces 1722x444 banner with existing `public/logo-v2/apple-touch-icon-180.png`. | **S** |
| **10** | **Add Honeypot & Rate Limiting to Contact Endpoint** | Trust / Local | `app/Controllers/ContactController.php:13-33` | **Medium**: Protects inbox and database against automated spam submission bursts. | **S** |

---

## 4. Full Findings Table

| ID | Category | Severity | File : Line or Route | Issue Description | Code Evidence | Recommended Fix | Effort |
| :---: | :--- | :---: | :--- | :--- | :--- | :--- | :---: |
| **T-01** | Tech SEO | **Critical** | `app/Helpers/SeoEngine.php:20-31` | Canonical fallback accepts relative or localhost URI | `$canonical = $ctx['canonical'] ?? null; if (!$canonical) { ... $canonical = $siteUrl . $clean; }` | Force `$canonical = rtrim(config('business.canonical_url'), '/') . parse_url($canonical, PHP_URL_PATH);` | S |
| **T-02** | Tech SEO | **Critical** | `views/projects/show.php:90` | Localhost canonical rendered directly | `<link rel="canonical" href="<?= base_url('/projects/' . $slug) ?>">` | Replace with absolute domain: `<?= config('business.url') . '/projects/' . $slug ?>` or use `SeoEngine`. | S |
| **T-03** | Tech SEO | **Critical** | `views/articles/show.php:30` | Localhost canonical rendered directly | `<link rel="canonical" href="<?= $currentUrl ?>">` where `$currentUrl = base_url(...)` | Enforce production domain: `<?= config('business.url') . '/articles/' . $slug ?>`. | S |
| **T-04** | Tech SEO | **Critical** | `views/services/show.php:8` | Localhost canonical rendered directly | `<link rel="canonical" href="<?= base_url('/services/' . $service['slug']) ?>">` | Enforce production domain: `<?= config('business.url') . '/services/' . $service['slug'] ?>`. | S |
| **T-05** | Tech SEO | **High** | `public/.htaccess:29-34` | Missing HTTPS and canonical domain redirects | Only handles `RewriteCond %{REQUEST_FILENAME} !-f ... RewriteRule ^ index.php [QSA,L]` | Add `RewriteCond %{HTTPS} off [OR] RewriteCond %{HTTP_HOST} ^www\. [NC] ... RewriteRule ^ https://... [R=301,L]`. | S |
| **T-06** | Tech SEO | **High** | `public/.htaccess:3-10` | Missing HSTS and Content-Security-Policy headers | Contains `nosniff`, `SAMEORIGIN`, `strict-origin-when-cross-origin` | Add `Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"`. | S |
| **T-07** | Tech SEO | **Medium** | `public/sitemap.xml`, `app/Services/SeoFilesService.php:218` | Legal pages missing from XML sitemap | Sitemap generator indexes 58 URLs but omits `/privacy` and `/terms` | Add `/privacy` and `/terms` to `SeoFilesService::generateSitemap()`. | S |
| **T-08** | Tech SEO | **Medium** | `views/layouts/head.php:114` | Distorted rectangular `apple-touch-icon` | `<link rel="apple-touch-icon" href="<?= asset_url('images/logo.png') ?>">` | Point to square icon: `<link rel="apple-touch-icon" href="<?= asset_url('logo-v2/apple-touch-icon-180.png') ?>">`. | S |
| **T-09** | Tech SEO | **Low** | `public/manifest.json` | Web App Manifest is missing | File not found in workspace `public/` directory | Create `public/manifest.json` with PWA icons, name, theme color `#f26a1b`, and standalone display. | S |
| **O-01** | On-Page | **High** | `views/home/index.php:336-340` | Broken internal service link on Homepage | `href="/services/chat-application-development"` | Update to valid route: `href="/services/chat-app-development"`. | S |
| **O-02** | On-Page | **High** | `views/home/index.php:350` | Broken internal service link on Homepage | `href="/services/saas-development"` | Update to valid route: `href="/services/saas-application-development"`. | S |
| **O-03** | On-Page | **High** | `views/about/index.php:127` | Broken project link on About page | `href="/projects/multi-tenant-crm"` | Update to canonical project slug: `href="/projects/multi-tenant-crm-sales-operations-management-system"`. | S |
| **O-04** | On-Page | **High** | `views/about/index.php:168` | Broken article link on About page | `href="/articles/ai-wont-replace-fundamentals"` | Update to real article slug: `/articles/ai-coding-agents-2026-custom-software`. | S |
| **O-05** | On-Page | **High** | `views/articles/index.php:48-52` | 4 Broken featured article links in hub banner | Links to `multi-tenant-saas-laravel`, `flutter-with-laravel-api`, etc. | Update `views/articles/index.php` hero cards to query latest published articles from DB. | M |
| **O-06** | On-Page | **High** | `views/projects/show.php:240` | Broken service link in 7 project case studies | `href="/services/saas-development"` | Update to canonical: `href="/services/saas-application-development"`. | S |
| **O-07** | On-Page | **Medium** | `views/services/index.php:310-318` | Non-existent category filters on Services page | Links to `/projects/category/real-estate-tech`, `e-commerce`, etc. | Change to real category slugs: `web-design-development`, `web-applications`, `products`. | S |
| **O-08** | On-Page | **Medium** | `views/home/index.php:140-180` | 13 homepage screenshot images missing `alt` attributes | `<img class="lp-mock" src="...">` without `alt` | Add descriptive alt text (e.g. `alt="CRM lead pipeline dashboard interface"`). | S |
| **O-09** | On-Page | **Low** | `views/articles/show.php:28` | Truncated title tag on long article headlines | `How to Build a Multi-Tenant SaaS in Laravel... \| Amaanullah Khan` (98 chars) | Enforce concise `<title>` under 60 chars while keeping full title in `og:title`. | S |
| **P-01** | Performance | **High** | `public/images/articles/*.png` | Gigantic raw PNG article banners (>1MB each) | `deploy-web-app-vps-guide.png` (1.3MB), `ecommerce-website.png` (1.04MB) | Convert to WebP format (<85KB each); add `width="1200" height="630"` to prevent CLS. | M |
| **P-02** | Performance | **High** | `views/layouts/head.php:119-122` | Multiple render-blocking Google Font network calls | `<link href="https://fonts.googleapis.com/..." rel="stylesheet">` | Add `&display=swap` and self-host fonts in `public/fonts/` with `preload`. | M |
| **P-03** | Performance | **Medium** | `views/layouts/head.php:29-37` | Unbundled, unminified CSS in `<head>` | Sequential `<link>` tags for `service-detail.css` (65KB), `landing.css` (48KB) | Combine and minify critical CSS; load non-critical styling asynchronously. | M |
| **P-04** | Performance | **Medium** | `views/home/index.php:15-18` | Heavy 3D canvas animation scripts on homepage | `hero-3d.js` (37.4KB), `splash-portal.js` (25.2KB), `splash-particles.js` (15.8KB) | Lazy-load 3D scripts after First Meaningful Paint; add reduced-motion bypass. | M |
| **S-01** | Schema | **Critical** | `views/landing/show.php:35-44` | Newline explosion destroys JSON-LD syntax | `$schemas = explode("\n", trim($l['schema_json'])); foreach ($schemas as $s): echo '<script>' . $s . '</script>';` | Replace with: `echo str_starts_with($s, '<script') ? $s : "<script type=\"application/ld+json\">{$s}</script>";` | S |
| **S-02** | Schema | **High** | `views/projects/show.php:106-107` | Standalone unlinked JSON-LD on Case Studies | Emits independent `Article` without referencing `#organization` or `#person` | Connect via `@id` to `https://amaanullah.com/#organization` and author `#person`. | S |
| **S-03** | Schema | **High** | `views/articles/show.php:47-48` | Standalone unlinked JSON-LD on Articles | Emits independent `BlogPosting` without publisher `@id` | Connect publisher to `https://amaanullah.com/#organization`. | S |
| **S-04** | Schema | **Medium** | `app/Helpers/SeoEngine.php:198-202` | `alumniOf` schema uses plain text rather than entity | `'alumniOf' => ['@type' => 'EducationalOrganization', 'name' => 'Aptech Learning']` | Add Wikidata / official URL: `'sameAs' => 'https://aptech-education.com.pk'`. | S |
| **S-05** | Schema | **Low** | `views/home/index.php` | Missing `Review` / `AggregateRating` schema for testimonials | 27 Google reviews claimed in `config/business.php` but no schema markup | Add `AggregateRating` (`ratingValue: 4.8`, `reviewCount: 27`) to `ProfessionalService`. | S |
| **G-01** | GEO | **High** | `public/llms.txt:29-30` | Dead 404 links to case studies in `llms.txt` | `- [Multi-Tenant CRM](.../projects/multi-tenant-crm)
- [Chatrox](.../projects/chatrox)` | Change to live database slugs: `/projects/multi-tenant-crm-sales-operations-management-system`, etc. | S |
| **G-02** | GEO | **High** | `public/robots.txt:6-17` | Missing modern AI web search crawler permissions | Allows `GPTBot`, `ClaudeBot`, `PerplexityBot`, `CCBot` | Add explicit Allow rules for `OAI-SearchBot`, `ChatGPT-User`, and `Google-Extended`. | S |
| **G-03** | GEO | **Medium** | `public/llms-full.txt` | Missing direct client engagement / pricing guidelines | States 'Custom CRM' but lacks typical starting budget transparency | Add honest budgetary brackets (e.g. "Projects typically start from $2,500+") for AI query matching. | S |
| **A-01** | AEO | **High** | `views/home/index.php:90-110` | Homepage hero lacks concise definition snippet | Opening paragraph uses conversational copy | Add definition block: "Amaanullah Khan is an independent software developer in Karachi...". | S |
| **A-02** | AEO | **Medium** | `views/services/index.php:160` | Service catalog hub lacks FAQPage schema | Category index lists 10 services but has no schema FAQs | Inject 6 buyer FAQs into `SeoEngine::renderHead` on `/services`. | S |
| **A-03** | AEO | **Low** | `views/articles/index.php` | Articles hub missing FAQ / Question snippet targeting | Blog archive contains no structured Q&A | Add 4 key technical advisory questions at bottom of `/articles`. | S |
| **C-01** | Content | **High** | `views/services/show.php` vs `views/landing/show.php` | Keyword cannibalization on CRM Development | Both target "CRM developer Pakistan" without distinct intent separation | Shift `/services/custom-crm-development` to Architecture/Specs; keep `/crm-developer-pakistan` for Direct Hiring. | M |
| **C-02** | Content | **Medium** | Dedicated Landing Pages | Missing international landing pages | Site claims clients in UAE, UK, US, but zero targeted URLs exist | Create `/laravel-developer-dubai` and `/laravel-developer-uk` to capture commercial expat queries. | L |
| **T-10** | Trust / Local | **Medium** | `app/Controllers/ContactController.php:13-33` | Contact endpoint vulnerable to automated POST floods | Only checks CSRF and single honeypot input | Implement IP-based session rate limiting (max 5 requests per 10 mins). | S |

---

## 5. Step 0: Complete Page Inventory Table

Every single page and route across the entire application was inventoried and inspected at runtime via local HTTP requests:

| # | Route / URL | View File | Layout Used | Title Tag | Meta Description | H1 Heading | Canonical URL | Robots Meta | Words | Sitemap | Internal Links |
| :---: | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :---: | :---: | :---: |
| 1 | `/` | `views/home/index.php` | `views/layouts/header.php + footer.php` | Amaanullah Khan | Amaanullah Khan is a software developer in Ka... | Custom softwarethat works harder. | `/web3d-full` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 1977 | Yes | 445 in / 48 out |
| 2 | `/about` | `views/about/index.php` | `views/layouts/header.php + footer.php` | About Amaanullah Khan - Software Developer, K | Amaanullah Khan is a Karachi software develop... | Hi, I'm Amaanullah Khan,Software De | `/web3d-full/about` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 1541 | Yes | 60 in / 32 out |
| 3 | `/services` | `views/services/index.php` | `views/layouts/header.php + footer.php` | Software Development Services - Amaanullah | Explore website, web app, mobile app, SaaS an... | Web and App Development | `/web3d-full/services` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 1941 | Yes | 60 in / 35 out |
| 4 | `/projects` | `views/projects/index.php` | `views/layouts/header.php + footer.php` | Projects &amp; Case Studies | Case studies of production systems by Amaanul... | Case studies &amp; production syste | `/web3d-full/projects` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 1763 | Yes | 60 in / 34 out |
| 5 | `/articles` | `views/articles/index.php` | `views/layouts/header.php + footer.php` | Articles on Laravel, SaaS, Automation &amp; F | Practical articles by Amaanullah Khan, a Kara... | Notes from building real systems. | `/web3d-full/articles` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 861 | Yes | 60 in / 47 out |
| 6 | `/contact` | `views/contact/index.php` | `views/layouts/header.php + footer.php` | Contact Amaanullah Khan - Software Developer  | Get in touch with Amaanullah Khan, a Karachi-... | Let's build something that works. | `/web3d-full/contact` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 528 | Yes | 62 in / 25 out |
| 7 | `/privacy` | `views/legal/privacy.php` | `views/layouts/header.php + footer.php` | Privacy Policy - Amaanullah Khan — Software D | Privacy Policy for Amaanullah Khan portfolio ... | Privacy Policy | `/web3d-full/privacy` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 397 | No | 60 in / 22 out |
| 8 | `/terms` | `views/legal/terms.php` | `views/layouts/header.php + footer.php` | Terms of Service - Amaanullah Khan — Software | Terms of service and professional engagement ... | Terms of Service | `/web3d-full/terms` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 370 | No | 60 in / 22 out |
| 9 | `/projects/category/web-design-development` | `views/projects/category.php` | `views/layouts/header.php + footer.php` | Web Design &amp; Development Projects &amp; C | E-commerce, marketplaces, bespoke web experie... | Web Design &amp; Development: Built | `/web3d-full/projects/category/web-design-development` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 495 | Yes | 60 in / 24 out |
| 10 | `/projects/category/web-applications` | `views/projects/category.php` | `views/layouts/header.php + footer.php` | Web Applications Projects &amp; Case Studies  | Enterprise software, internal tools, HR porta... | Web Applications: Built for Scale & | `/web3d-full/projects/category/web-applications` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 650 | Yes | 60 in / 27 out |
| 11 | `/projects/category/products` | `views/projects/category.php` | `views/layouts/header.php + footer.php` | Products Projects &amp; Case Studies - Amaanu | Proprietary software products and real-time c... | Products: Built for Scale &amp; Imp | `/web3d-full/projects/category/products` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 362 | Yes | 60 in / 22 out |
| 12 | `/projects/category/mobile-apps` | `views/projects/category.php` | `views/layouts/header.php + footer.php` | Mobile Apps Projects &amp; Case Studies - Ama | Cross-platform iOS and Android applications b... | Mobile Apps: Built for Scale &amp;  | `/web3d-full/projects/category/mobile-apps` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 477 | Yes | 60 in / 24 out |
| 13 | `/articles/category/laravel-php` | `views/articles/category.php` | `views/layouts/header.php + footer.php` | Laravel &amp; PHP Articles &amp; Guides - Ama | Deep-dives into building scalable Laravel and... | Laravel &amp; PHP Articles &amp; In | `/web3d-full/articles/category/laravel-php` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 385 | Yes | 7 in / 31 out |
| 14 | `/articles/category/saas-crm` | `views/articles/category.php` | `views/layouts/header.php + footer.php` | SaaS &amp; CRM Articles &amp; Guides - Amaanu | Practical advice on building and scaling mult... | SaaS &amp; CRM Articles &amp; Insig | `/web3d-full/articles/category/saas-crm` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 400 | Yes | 11 in / 34 out |
| 15 | `/articles/category/automation-ai` | `views/articles/category.php` | `views/layouts/header.php + footer.php` | Automation &amp; AI Articles &amp; Guides - A | Automating manual operational workflows and i... | Automation &amp; AI Articles &amp;  | `/web3d-full/articles/category/automation-ai` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 487 | Yes | 13 in / 35 out |
| 16 | `/articles/category/mobile-flutter` | `views/articles/category.php` | `views/layouts/header.php + footer.php` | Mobile &amp; Flutter Articles &amp; Guides -  | Cross-platform mobile app development with Fl... | Mobile &amp; Flutter Articles &amp; | `/web3d-full/articles/category/mobile-flutter` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 384 | Yes | 7 in / 31 out |
| 17 | `/articles/category/web-development` | `views/articles/category.php` | `views/layouts/header.php + footer.php` | Web Development Articles &amp; Guides - Amaan | Core web technologies, performance optimizati... | Web Development Articles &amp; Insi | `/web3d-full/articles/category/web-development` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 458 | Yes | 13 in / 36 out |
| 18 | `/articles/category/career-insights` | `views/articles/category.php` | `views/layouts/header.php + footer.php` | Career Insights Articles &amp; Guides - Amaan | Lessons from client projects, software engine... | Career Insights Articles &amp; Insi | `/web3d-full/articles/category/career-insights` | `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | 379 | Yes | 7 in / 31 out |
| 19 | `/services/custom-crm-development` | `views/services/show.php` | `views/layouts/header.php + footer.php` | Custom CRM Development Services - Amaanullah | A CRM built around your sales process. Plan l... | Custom CRM Built Around Your Sales  | `/web3d-full/services/custom-crm-development` | `None (defaults to index,follow)` | 1375 | Yes | 71 in / 36 out |
| 20 | `/services/ai-automation-services` | `views/services/show.php` | `views/layouts/header.php + footer.php` | AI Automation Services for Business - Amaanul | Add AI to document handling, enquiry sorting ... | AI Automation for Useful Business T | `/web3d-full/services/ai-automation-services` | `None (defaults to index,follow)` | 1455 | Yes | 61 in / 35 out |
| 21 | `/services/chat-app-development` | `views/services/show.php` | `views/layouts/header.php + footer.php` | Real-Time Chat App Development - Amaanullah | Build messaging for your app, website or team... | Chat Apps That Keep Conversations i | `/web3d-full/services/chat-app-development` | `None (defaults to index,follow)` | 1380 | Yes | 4 in / 34 out |
| 22 | `/services/web-development` | `views/services/show.php` | `views/layouts/header.php + footer.php` | Website Developer in Karachi - Amaanullah | Need a business website, online store or web ... | A Website That Fits Your Business | `/web3d-full/services/web-development` | `None (defaults to index,follow)` | 1277 | Yes | 65 in / 26 out |
| 23 | `/services/saas-application-development` | `views/services/show.php` | `views/layouts/header.php + footer.php` | SaaS Application Development - Amaanullah | Build a SaaS product with accounts, customer ... | SaaS Development From Idea to First | `/web3d-full/services/saas-application-development` | `None (defaults to index,follow)` | 1347 | Yes | 60 in / 35 out |
| 24 | `/services/mobile-app-development` | `views/services/show.php` | `views/layouts/header.php + footer.php` | Mobile App Development - Amaanullah | Plan and build Android and iPhone apps with a... | Mobile Apps Built for Everyday Use | `/web3d-full/services/mobile-app-development` | `None (defaults to index,follow)` | 1331 | Yes | 64 in / 35 out |
| 25 | `/services/business-process-automation` | `views/services/show.php` | `views/layouts/header.php + footer.php` | Business Process Automation Services - Amaanu | Connect business tools and automate repeatabl... | Business Automation for Repeated Wo | `/web3d-full/services/business-process-automation` | `None (defaults to index,follow)` | 1367 | Yes | 21 in / 35 out |
| 26 | `/services/saas-product-strategy` | `views/services/show.php` | `views/layouts/header.php + footer.php` | SaaS Product Strategy and MVP Planning - Amaa | Define your SaaS users, core workflow and fir... | SaaS Product Strategy Before You Bu | `/web3d-full/services/saas-product-strategy` | `None (defaults to index,follow)` | 1433 | Yes | 4 in / 35 out |
| 27 | `/services/performance-tuning` | `views/services/show.php` | `views/layouts/header.php + footer.php` | Website Performance Optimization - Amaanullah | Find what slows down your website or web app.... | Performance Tuning for Slow Website | `/web3d-full/services/performance-tuning` | `None (defaults to index,follow)` | 1397 | Yes | 60 in / 35 out |
| 28 | `/services/free-technical-audit` | `views/services/show.php` | `views/layouts/header.php + footer.php` | Free Technical Website Audit - Amaanullah | Request an initial technical review of your w... | A Free Technical Audit for a Cleare | `/web3d-full/services/free-technical-audit` | `None (defaults to index,follow)` | 1415 | Yes | 7 in / 37 out |
| 29 | `/projects/adsimpressions-custom-digital-agency-platform` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | Adsimpressions Case Study - Custom Digital Ag | Case study on Adsimpressions: a 37-page custo... | Adsimpressions – Custom Digital Age | `/web3d-full/projects/adsimpressions-custom-digital-agency-platform` | `None (defaults to index,follow)` | 1974 | Yes | 6 in / 37 out |
| 30 | `/projects/it-hardware-bin-bulk-hardware-ecommerce-platform` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | IT Hardware Bin – B2B Bulk Hardware E-Commerc | B2B wholesale e-commerce case study: 2,000+ I... | IT Hardware Bin – B2B Bulk Hardware | `/web3d-full/projects/it-hardware-bin-bulk-hardware-ecommerce-platform` | `None (defaults to index,follow)` | 1735 | Yes | 6 in / 35 out |
| 31 | `/projects/expense-voyage-budget-expense-management-web-app` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | Expense Voyage – FinTech Budget &amp; Expense | Award-winning FinTech web app case study: rea... | Expense Voyage – Budget &amp; Expen | `/web3d-full/projects/expense-voyage-budget-expense-management-web-app` | `None (defaults to index,follow)` | 1644 | Yes | 6 in / 35 out |
| 32 | `/projects/babyshop-mobile-app-ecommerce-firebase-solution` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | Babyshop – Flutter E-Commerce Mobile App Case | Aptech Semester Final Capstone case study: du... | Babyshop – Real-Time Retail E-Comme | `/web3d-full/projects/babyshop-mobile-app-ecommerce-firebase-solution` | `None (defaults to index,follow)` | 1938 | Yes | 9 in / 35 out |
| 33 | `/projects/healink-medicine-app-healthcare-hospital-management-solution` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | Healink – Hospital &amp; Medical Records Mana | Enterprise healthcare management platform cas... | Healink – Hospital &amp; Medical Re | `/web3d-full/projects/healink-medicine-app-healthcare-hospital-management-solution` | `None (defaults to index,follow)` | 1509 | Yes | 5 in / 36 out |
| 34 | `/projects/tour-guide-mobile-app-explore-pakistan-travel-solution` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | Tour Guide Mobile App – Pakistan Travel Compa | TechWiz Global Competition winning travel app... | Tour Guide Mobile App – Explore Pak | `/web3d-full/projects/tour-guide-mobile-app-explore-pakistan-travel-solution` | `None (defaults to index,follow)` | 1790 | Yes | 3 in / 33 out |
| 35 | `/projects/ticketing-crm-jobs-vendor-management-enterprise-portal` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | Ticketing CRM &amp; Vendor Management Portal  | Enterprise field operations CRM case study: j... | Ticketing CRM – Job &amp; Vendor Ma | `/web3d-full/projects/ticketing-crm-jobs-vendor-management-enterprise-portal` | `None (defaults to index,follow)` | 1916 | Yes | 8 in / 35 out |
| 36 | `/projects/multi-tenant-crm-sales-operations-management-system` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | Multi-Tenant CRM &amp; Sales Operations Platf | Multi-tenant B2B SaaS CRM case study: managin... | Multi-Tenant CRM – Sales &amp; Oper | `/web3d-full/projects/multi-tenant-crm-sales-operations-management-system` | `None (defaults to index,follow)` | 2236 | Yes | 36 in / 34 out |
| 37 | `/projects/hrm-employee-management-payroll-portal` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | HRM &amp; Payroll Portal Case Study - Amaanul | Enterprise HRM &amp; automated payroll case s... | HRM &amp; Payroll Software – Employ | `/web3d-full/projects/hrm-employee-management-payroll-portal` | `None (defaults to index,follow)` | 2141 | Yes | 26 in / 34 out |
| 38 | `/projects/workspace-kanban-project-task-management-platform` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | Workspace Kanban Project Management Tool Case | Custom Kanban workspace case study: HTML5 dra... | Workspace Kanban – Collaborative Ag | `/web3d-full/projects/workspace-kanban-project-task-management-platform` | `None (defaults to index,follow)` | 2183 | Yes | 10 in / 35 out |
| 39 | `/projects/chatrox-real-time-messaging-professional-networking` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | Chatrox Real-Time Messaging &amp; Slack Alter | Custom enterprise chat platform case study: W... | Chatrox – Real-Time Messaging &amp; | `/web3d-full/projects/chatrox-real-time-messaging-professional-networking` | `None (defaults to index,follow)` | 2026 | Yes | 22 in / 34 out |
| 40 | `/projects/real-estate-property-portal-multi-role-marketplace` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | Real Estate Property Portal &amp; Flutter Mob | Omnichannel PropTech case study: 5-tier web p... | Landsfy – Multi-Role Real Estate Ma | `/web3d-full/projects/real-estate-property-portal-multi-role-marketplace` | `None (defaults to index,follow)` | 2316 | Yes | 5 in / 36 out |
| 41 | `/projects/the-perfect-vape-custom-ecommerce-platform-theme-builder` | `views/projects/show.php` | `views/layouts/header.php + footer.php` | Custom E-Commerce Platform &amp; Theme Builde | Custom PHP e-commerce case study: admin visua... | The Perfect Vape – Custom E-Commerc | `/web3d-full/projects/the-perfect-vape-custom-ecommerce-platform-theme-builder` | `None (defaults to index,follow)` | 2166 | Yes | 6 in / 36 out |
| 42 | `/articles/enterprise-solutions-development-roadmap` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | Enterprise Software Development Roadmap: Arch | A practical 2026 enterprise software roadmap:... | Enterprise Software Development Roa | `/web3d-full/articles/enterprise-solutions-development-roadmap` | `None (defaults to index,follow)` | 2590 | Yes | 32 in / 46 out |
| 43 | `/articles/ai-in-software-development-future-trends` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | AI in Software Development: Tools, Workflows  | Explore how AI transforms software engineerin... | AI in Software Development: How Dev | `/web3d-full/articles/ai-in-software-development-future-trends` | `None (defaults to index,follow)` | 2428 | Yes | 22 in / 42 out |
| 44 | `/articles/mastering-tech-tips-modern-developers` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | Developer Productivity Tips &amp; Coding Hack | Boost developer productivity with practical c... | Developer Productivity Tips: Coding | `/web3d-full/articles/mastering-tech-tips-modern-developers` | `None (defaults to index,follow)` | 2138 | Yes | 22 in / 42 out |
| 45 | `/articles/ai-developer-toolkit-2026-agentic-trends` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | Best AI Tools for Developers in 2026 - Comple | Discover the best AI developer tools in 2026:... | Best AI Tools for Developers in 202 | `/web3d-full/articles/ai-developer-toolkit-2026-agentic-trends` | `None (defaults to index,follow)` | 2238 | Yes | 12 in / 42 out |
| 46 | `/articles/ai-automation-business-development-intelligent-growth` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | AI Automation for Business: Scale Operations  | Learn how AI automation helps modern business... | AI Automation for Business: Scale O | `/web3d-full/articles/ai-automation-business-development-intelligent-growth` | `None (defaults to index,follow)` | 2020 | Yes | 5 in / 44 out |
| 47 | `/articles/web-design-development-business-growth-strategy` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | Web Development for Business Growth: Strategy | Turn your website into a growth engine with s... | Web Development for Business Growth | `/web3d-full/articles/web-design-development-business-growth-strategy` | `None (defaults to index,follow)` | 1995 | Yes | 4 in / 44 out |
| 48 | `/articles/ui-ux-design-psychic-user-experience-screens` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | UX Design Principles: Anticipatory UI That Bo | Master anticipatory UX design principles: pre... | UX Design Principles: Anticipatory  | `/web3d-full/articles/ui-ux-design-psychic-user-experience-screens` | `None (defaults to index,follow)` | 1937 | Yes | 6 in / 43 out |
| 49 | `/articles/seo-paid-marketing-balanced-growth-strategy` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | SEO vs Paid Ads in 2026: ROI, Timelines &amp; | A data-backed comparison of SEO and paid ads ... | SEO vs Paid Ads: The Real Data on B | `/web3d-full/articles/seo-paid-marketing-balanced-growth-strategy` | `None (defaults to index,follow)` | 2051 | Yes | 5 in / 45 out |
| 50 | `/articles/modern-web-development-technologies-guide` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | Modern Web Development Technologies: 2026 Sta | The definitive 2026 web technology guide: com... | Modern Web Development Technologies | `/web3d-full/articles/modern-web-development-technologies-guide` | `None (defaults to index,follow)` | 1942 | Yes | 6 in / 46 out |
| 51 | `/articles/ecommerce-website-design-digital-branding-growth` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | Ecommerce Website Design &amp; Branding for G | The definitive 2026 e-commerce playbook: movi... | Ecommerce Website Design &amp; Bran | `/web3d-full/articles/ecommerce-website-design-digital-branding-growth` | `None (defaults to index,follow)` | 1946 | Yes | 5 in / 43 out |
| 52 | `/articles/ai-automation-transforming-businesses` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | What Is AI Automation? Business Use Cases, RO | A comprehensive 2026 guide to AI automation: ... | What Is AI Automation? Business Use | `/web3d-full/articles/ai-automation-transforming-businesses` | `None (defaults to index,follow)` | 1877 | Yes | 4 in / 43 out |
| 53 | `/articles/deploy-web-app-vps-guide` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | How to Deploy a Web App on a VPS: Secure 2026 | Step-by-step 2026 guide to deploying web apps... | How to Deploy a Web App on VPS: Sec | `/web3d-full/articles/deploy-web-app-vps-guide` | `None (defaults to index,follow)` | 2030 | Yes | 6 in / 44 out |
| 54 | `/articles/custom-software-crm-ai-automation-business-growth` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | Custom Software for Business: CRM, AI Automat | Discover why high-growth enterprises replace ... | Custom Software for Business: CRM,  | `/web3d-full/articles/custom-software-crm-ai-automation-business-growth` | `None (defaults to index,follow)` | 2378 | Yes | 6 in / 46 out |
| 55 | `/articles/custom-software-vs-saas-business-scalability` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | Custom Software vs SaaS: Which Is Better for  | Build vs Buy in 2026: An engineering guide co... | Custom Software vs SaaS: Which Is B | `/web3d-full/articles/custom-software-vs-saas-business-scalability` | `None (defaults to index,follow)` | 2423 | Yes | 14 in / 49 out |
| 56 | `/articles/ai-coding-agents-2026-custom-software` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | AI Coding Agents in 2026: Custom Software Eco | Explore how autonomous AI coding agents redef... | AI Coding Agents in 2026: The New E | `/web3d-full/articles/ai-coding-agents-2026-custom-software` | `None (defaults to index,follow)` | 2375 | Yes | 5 in / 46 out |
| 57 | `/articles/vibe-coding-risks-startups-need-real-developer` | `views/articles/show.php` | `views/layouts/header.php + footer.php` | Vibe Coding Risks: Why Startups Still Need a  | Explore why 40-60% of vibe-coded apps contain... | Vibe Coding Risks: Why Startups Sti | `/web3d-full/articles/vibe-coding-risks-startups-need-real-developer` | `None (defaults to index,follow)` | 2376 | Yes | 4 in / 45 out |
| 58 | `/laravel-developer-karachi` | `views/landing/show.php` | `views/layouts/header.php + footer.php` | Laravel Developer in Karachi - Amaanullah | Hire a Laravel developer in Karachi for web a... | Build or Improve Your Laravel App | `/web3d-full/laravel-developer-karachi` | `None (defaults to index,follow)` | 1236 | Yes | 4 in / 25 out |
| 59 | `/crm-developer-pakistan` | `views/landing/show.php` | `views/layouts/header.php + footer.php` | CRM Developer in Pakistan - Amaanullah | Looking for a CRM developer in Pakistan? Disc... | A CRM Built Around Your Team | `/web3d-full/crm-developer-pakistan` | `None (defaults to index,follow)` | 1240 | Yes | 0 in / 25 out |
| 60 | `/hire-a-developer-karachi` | `views/landing/show.php` | `views/layouts/header.php + footer.php` | Hire a Full Stack Developer in Karachi - Amaa | Hire a full stack developer in Karachi for yo... | One Developer for Your Web Project | `/web3d-full/hire-a-developer-karachi` | `None (defaults to index,follow)` | 1377 | Yes | 0 in / 26 out |

### Dynamic & Templated Pages Audit

1. **Service Detail Pages (`/services/{slug}`)**:
   - **Title**: Dynamic from database column `services.seo_title` (fallback: `title . ' | Amaanullah Khan, Karachi'`).
   - **Description**: Dynamic from `services.meta_description` (fallback: `services.summary`).
   - **Canonical**: Built using `base_url('/services/' . $service['slug'])` (⚠️ **Bug**: Leaks `localhost` in local environment).
   - **Schema**: Injects `BreadcrumbList` and custom `services.schema_json`.

2. **Project Case Studies (`/projects/{slug}`)**:
   - **Title**: Dynamic from `projects.seo_title` (fallback: `title . ' | Case Study · Amaanullah Khan'`).
   - **Description**: Dynamic from `projects.meta_description` (fallback: `projects.summary`).
   - **Canonical**: Built using `base_url('/projects/' . $slug)`.
   - **Schema**: Injects `BreadcrumbList` and standalone `[Article, CreativeWork]`.

3. **Article Detail Pages (`/articles/{slug}`)**:
   - **Title**: Dynamic from `articles.seo_title` (fallback: `title . ' | Amaanullah Khan'`).
   - **Description**: Dynamic from `articles.meta_description` (fallback: `articles.subtitle`).
   - **Canonical**: Built using `base_url('/articles/' . $slug)`.
   - **Schema**: Injects `BreadcrumbList` and standalone `BlogPosting`.

4. **Dedicated Landing Pages (`/{landing}`)**:
   - **Title**: Dynamic from `landing_pages.seo_title` (fallback: `title . ' | Amaanullah'`).
   - **Description**: Dynamic from `landing_pages.meta_description`.
   - **Canonical**: Dynamic from `landing_pages.slug`.
   - **Schema**: ⚠️ **Critical Bug**: `views/landing/show.php` splits JSON string by newline, causing parser failure.

---

## 6. Consistency Matrix

| Verification Point | Standard Defined in `config/business.php` | Header (`views/layouts/header.php`) | Footer (`views/layouts/footer.php`) | Schema Engine (`SeoEngine.php`) | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **Brand Name** | `Amaanullah` | Logo alt="Amaanullah" | "© 2026 Amaanullah" | `alternateName: "Amaanullah"` | 🟢 **100% Consistent** |
| **Founder Name** | `Amaanullah Khan` | N/A (Brand logo only) | N/A | `name: "Amaanullah Khan"` | 🟢 **100% Consistent** |
| **Founder Title** | `Software Developer & Systems Architect` | N/A | Tagline: "Custom web apps, CRMs..." | `jobTitle: "Software Developer..."` | 🟢 **100% Consistent** |
| **Phone Number** | `+92 319 6935307` | Embedded in `__SITE_SETTINGS` | `<a href="tel:+923196935307">` | `telephone: "+92 319 6935307"` | 🟢 **100% Consistent** |
| **Email Address** | `info@amaanullah.com` | N/A | `<a href="mailto:info@amaanullah.com">` | `email: "info@amaanullah.com"` | 🟢 **100% Consistent** |
| **Primary Location** | `Karachi, Sindh, Pakistan` | N/A | N/A | `addressLocality: "Karachi"` | 🟢 **100% Consistent** |
| **Canonical Domain** | `https://amaanullah.com` | Links use `base_url()` | Links use `base_url()` | In `SeoEngine.php` only | ⚠️ **Inconsistent (Dual Engine)** |
| **Social Profiles** | LinkedIn, GitHub, Google Business | Social links omitted | Social links omitted | Injected via `sameAs` array | ⚠️ **Missing in Footer HTML** |

---

## 7. Schema / Structured Data Report & Ready-to-Paste Corrections

### Identified Schema Gaps:
1. **Landing Page Syntax Corruption**: As discovered in `views/landing/show.php:35`, the multi-line JSON string is exploded by `\n` and each line is wrapped in `<script>`, destroying JSON syntax.
2. **Fragmented Unconnected Entities**: Articles emit independent `BlogPosting` and projects emit independent `CreativeWork` schemas without connecting to the parent `https://amaanullah.com/#organization` or `https://amaanullah.com/#person` nodes.
3. **Missing Service Schemas on Category Hubs**: `/services` lists 10 services but provides no unified `ItemList` linking them directly.

### Ready-to-Paste Corrected JSON-LD (For Reference Only - Do Not Apply):

#### A. Unified Knowledge Graph Entity (To inject globally via `SeoEngine.php`):
```json
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "ProfessionalService",
      "@id": "https://amaanullah.com/#organization",
      "name": "Amaanullah Khan - Software Developer",
      "alternateName": "Amaanullah",
      "url": "https://amaanullah.com",
      "logo": {
        "@type": "ImageObject",
        "@id": "https://amaanullah.com/#logo",
        "url": "https://amaanullah.com/images/logo.png",
        "caption": "Amaanullah Khan"
      },
      "image": "https://amaanullah.com/media/profile-poster.jpg",
      "description": "Custom software developer and systems architect in Karachi specializing in PHP and Laravel. Multi-tenant CRM systems, SaaS platforms, and business automation.",
      "telephone": "+92 319 6935307",
      "email": "info@amaanullah.com",
      "priceRange": "$$",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Karachi",
        "addressRegion": "Sindh",
        "addressCountry": "PK"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 24.8607,
        "longitude": 67.0011
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "reviewCount": "27"
      },
      "founder": {
        "@id": "https://amaanullah.com/#person"
      },
      "sameAs": [
        "https://www.linkedin.com/in/akamaanullah",
        "https://github.com/akamaanullah",
        "https://www.google.com/search?kgmid=/g/11xyj_sq2m&q=Amaanullah+Khan+-+Software+Developer"
      ]
    },
    {
      "@type": "Person",
      "@id": "https://amaanullah.com/#person",
      "name": "Amaanullah Khan",
      "alternateName": "Amaanullah",
      "jobTitle": "Software Developer & Systems Architect",
      "url": "https://amaanullah.com/about",
      "sameAs": [
        "https://www.linkedin.com/in/akamaanullah",
        "https://github.com/akamaanullah"
      ]
    }
  ]
}
```

#### B. Connected Article Schema (Correct format for `views/articles/show.php`):
```json
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "How to Build a Multi-Tenant SaaS in Laravel",
  "description": "A practical guide to tenant identification, database strategies and query scoping.",
  "image": "https://amaanullah.com/images/articles/multi-tenant.webp",
  "datePublished": "2026-10-15T00:00:00+05:00",
  "dateModified": "2026-10-30T23:00:00+05:00",
  "mainEntityOfPage": "https://amaanullah.com/articles/multi-tenant-saas-laravel",
  "author": {
    "@id": "https://amaanullah.com/#person"
  },
  "publisher": {
    "@id": "https://amaanullah.com/#organization"
  }
}
```

---

## 8. Keyword-to-Page Map & Gap List

### Inferred Keyword Mapping & Intent:

| Priority | Target Keyword / Topic | Search Intent | Target URL | Optimization Status | Cannibalization Risk |
| :---: | :--- | :---: | :--- | :---: | :--- |
| **1** | Website Developer in Karachi | Commercial / Transactional | `/services/web-development` | 🟢 Strong | Low (Consolidated with old slug) |
| **2** | Laravel Developer in Karachi | Commercial / Transactional | `/laravel-developer-karachi` | 🟢 Strong | Low |
| **3** | CRM Developer in Pakistan | Commercial / Transactional | `/crm-developer-pakistan` | ⚠️ Moderate | **High Risk**: Competes with `/services/custom-crm-development` |
| **4** | Hire Full Stack Developer Karachi | Transactional | `/hire-a-developer-karachi` | 🟢 Strong | Low |
| **5** | Custom CRM Development Services | Commercial | `/services/custom-crm-development` | 🟢 Strong | **High Risk**: Competes with `/crm-developer-pakistan` |
| **6** | SaaS Application Development | Commercial | `/services/saas-application-development` | 🟢 Strong | Low |
| **7** | Real-Time Chat App Development | Commercial | `/services/chat-app-development` | 🟢 Strong | Low |
| **8** | Business Process Automation Pakistan | Commercial | `/services/business-process-automation` | 🟢 Strong | Low |
| **9** | Mobile App Development Flutter | Commercial | `/services/mobile-app-development` | 🟢 Strong | Low |
| **10** | Website Performance Optimization | Commercial / Transactional | `/services/performance-tuning` | 🟢 Strong | Low |
| **11** | Free Technical Website Audit | Informational / Lead Gen | `/services/free-technical-audit` | 🟢 Strong | Low |
| **12** | Multi-Tenant SaaS Architecture Laravel | Informational | `/articles/custom-software-vs-saas-business-scalability` | ⚠️ Moderate | Medium (Article title vs slug mismatch) |
| **13** | AI Coding Agents 2026 Trends | Informational | `/articles/ai-coding-agents-2026-custom-software` | 🟢 Strong | Low |
| **14** | Laravel Developer in Dubai / UAE | Commercial / Expat | **MISSING** (Gap) | ❌ Missing | None |
| **15** | Laravel Developer for UK / US Startups | Commercial / Remote | **MISSING** (Gap) | ❌ Missing | None |

---

## 9. AEO Question List with Target Pages

10 high-value conversational queries that people ask when evaluating these services, structured for voice search, featured snippets, and LLM answer generation:

| # | Exact Buyer Question | Direct 40-50 Word Answer Formula | Target Page Host |
| :---: | :--- | :--- | :--- |
| **1** | **How much does a custom CRM cost in Pakistan?** | A custom CRM typically ranges between $1,500 and $8,000 depending on role tiers, pipeline automation, and integrations. Unlike SaaS tools charging per-user monthly fees, custom systems provide full code and database ownership with zero recurring seat licensing costs. | `/services/custom-crm-development` |
| **2** | **Why choose custom Laravel over off-the-shelf SaaS?** | Off-the-shelf SaaS charges recurring fees per user that compound as teams grow, while locking your data in proprietary ecosystems. Custom Laravel applications give you 100% intellectual property ownership, unlimited user accounts, zero licensing overhead, and custom business logic tailored to your exact workflows. | `/laravel-developer-karachi` |
| **3** | **Can I keep my existing domain and ranking during a redesign?** | Yes. A redesign preserves your existing domain and search visibility when executed with a 1-to-1 301 redirect map, metadata migration, and structured URLs. This ensures search engines and existing backlinks seamlessly transition without losing established keyword authority. | `/services/web-development` |
| **4** | **What is multi-tenant database architecture in SaaS?** | Multi-tenancy is an architectural approach where a single software instance serves multiple distinct customer organizations (tenants). Each tenant's data is isolated either through row-level scoping (`tenant_id`) or separate databases, ensuring complete security while sharing underlying compute infrastructure. | `/articles/custom-software-vs-saas-business-scalability` |
| **5** | **How does business process automation replace spreadsheets?** | Business process automation connects your existing web tools, databases, and APIs through automated workflows. Instead of manually copying data between spreadsheets, system triggers automatically route leads, dispatch notifications, generate invoices, and sync inventory in real time with zero human error. | `/services/business-process-automation` |
| **6** | **What is the difference between WebSockets and standard HTTP for chat?** | HTTP requires the client to repeatedly poll the server for new messages, adding latency and overhead. WebSockets maintain a continuous, bi-directional TCP connection, allowing the server to push incoming messages to users in under 30 milliseconds without repeated polling. | `/services/chat-app-development` |
| **7** | **Can Flutter apps share the same backend as a Laravel website?** | Yes. A single unified Laravel REST or GraphQL API backend can power both your web application and your cross-platform iOS and Android mobile apps. This eliminates duplicated database queries and keeps business logic centralized across all client devices. | `/services/mobile-app-development` |
| **8** | **How does a technical website audit identify speed bottlenecks?** | A technical performance audit inspects Time to First Byte (TTFB), unoptimized database queries, render-blocking scripts, and layout shifts (CLS). It pinpoints whether slowness stems from hosting limits, unindexed SQL queries, or heavy frontend asset payloads. | `/services/free-technical-audit` |
| **9** | **Do you sign non-disclosure agreements (NDAs) before project discussions?** | Yes. All enterprise CRM, proprietary SaaS algorithms, and startup product specifications are protected under formal Non-Disclosure Agreements prior to reviewing internal workflows, codebase repositories, or sensitive customer data. | `/contact` |
| **10** | **Can an independent developer support an enterprise application long-term?** | Direct collaboration with a senior developer provides dedicated architectural continuity, direct Slack/WhatsApp communication, and zero account management bureaucracy. Post-launch maintenance includes automated monitoring, database backups, security patches, and phased feature releases. | `/about` |

---

## 10. GEO (Generative Engine Optimization) Checklist

| GEO Audit Checkpoint | Criteria Evaluated | Status | Detailed Finding |
| :--- | :--- | :---: | :--- |
| **1. AI Bot Crawler Access** | `robots.txt` allows top LLM scrapers | ⚠️ **PARTIAL** | Allows `GPTBot`, `ClaudeBot`, `PerplexityBot`. **Missing**: `Google-Extended`, `OAI-SearchBot`, `ChatGPT-User`. |
| **2. Standard `llms.txt` Present** | Concise markdown file for LLM summarization | ⚠️ **PARTIAL** | Exists in `public/llms.txt`, but contains **broken 404 links** (`/projects/multi-tenant-crm`). |
| **3. Deep `llms-full.txt` Present** | Comprehensive developer spec for LLM context | 🟢 **PASS** | `public/llms-full.txt` provides 11KB of rich technical specs, architecture philosophy, and career history. |
| **4. Clear Named Entity Identity** | Factual statement of Who, What, Where | 🟢 **PASS** | Consistently declared as "Amaanullah Khan - Software Developer & Systems Architect, Karachi, Pakistan". |
| **5. Verified `sameAs` Authority** | Links to verified external profiles | 🟢 **PASS** | Includes LinkedIn, GitHub, Google Knowledge Graph mid (`/g/11xyj_sq2m`), and Google Business Profile. |
| **6. Semantic `knowsAbout` Links** | Entities tied to Wikidata / Wikipedia URLs | 🟢 **PASS** | 10 entities in `config/business.php` link directly to Wikipedia (Laravel, PHP, Multi-tenancy, etc.). |
| **7. E-E-A-T Case Study Proof** | Verifiable production projects with stats | 🟢 **PASS** | 13 detailed case studies with measurable metrics (1.5M+ leads, <30ms WebSocket latency, 95+ PageSpeed). |
| **8. Quotable Pricing & Process** | Transparent numbers for LLM quoting | ⚠️ **PARTIAL** | Explains process clearly, but lacks clear pricing brackets in `llms.txt` for budget query matches. |
| **9. Author Transparency** | Visible author bio, photo, contact channels | 🟢 **PASS** | Verified photo, bio, WhatsApp, email, and Aptech Learning alumni credentials prominently featured. |
| **10. Freshness Signals** | Published & modified timestamps in schema | 🟢 **PASS** | Articles and projects emit `datePublished` and `dateModified` timestamps in ISO 8601 format. |

---

## 11. Prioritized Action Plan

### Phase 1: Week 1 (Critical Bug Fixes & Crawl Barrier Removal)
1. **Fix `views/landing/show.php`**: Remove the `explode("\n", ...)` loop and properly output valid JSON-LD `<script>` blocks.
2. **Enforce Absolute Canonicals**: Update `app/Helpers/SeoEngine.php` and the 3 manual detail templates to ensure canonical tags always use `config('business.canonical_url')` rather than local relative paths.
3. **Fix 52 Broken Internal Links**: Update dead hrefs on Homepage, About, Services, Projects, and Articles to point to live database slugs.
4. **Fix `llms.txt` Case Study URLs**: Correct the dead project links in `public/llms.txt` and `SeoFilesService.php`.
5. **Update `public/robots.txt`**: Add Allow directives for `Google-Extended`, `OAI-SearchBot`, and `ChatGPT-User`.
6. **Fix `apple-touch-icon`**: Change path in `views/layouts/head.php` to point to `logo-v2/apple-touch-icon-180.png`.

### Phase 2: Weeks 2–3 (Architecture Unification & Performance Optimization)
1. **Unify `<head>` Architecture**: Refactor `views/projects/show.php`, `views/articles/show.php`, and `views/services/show.php` to use the centralized `views/layouts/head.php` and `SeoEngine::renderHead()`.
2. **Convert Banner Images to WebP**: Batch-convert the 28 heavy PNG banners in `public/images/articles/` to WebP format, reducing asset sizes by >85%.
3. **Configure `.htaccess` Redirects**: Add canonical HTTPS, non-www, and HSTS headers in `public/.htaccess`.
4. **Include Legal Pages in Sitemap**: Update `SeoFilesService::generateSitemap()` to index `/privacy` and `/terms`.
5. **Add Contact Form Rate Limiting**: Implement session/IP rate limiting in `app/Controllers/ContactController.php`.

### Phase 3: Month 2 (Expansion, AEO & International Reach)
1. **International Geo Landing Pages**: Create dedicated landing pages for expat and remote markets (`/laravel-developer-dubai`, `/laravel-developer-uk`).
2. **Differentiate CRM Content**: Restructure `/services/custom-crm-development` to focus strictly on architectural specs while keeping `/crm-developer-pakistan` focused on direct founder hiring to resolve cannibalization.
3. **Self-Host Web Fonts**: Download Google Fonts locally to `public/fonts/` with `font-display: swap` to eliminate external render-blocking network requests.
4. **Generate `site.webmanifest`**: Deploy complete PWA manifest in `public/manifest.json`.

---

## 12. "Not Verified" List

In strict accordance with the audit guidelines, items that depend on live external network connections or live production infrastructure could not be verified locally and are cataloged below:

1. **Live Google Search Console Verification**: The local environment contains the GSC service configuration (`app/Services/GoogleSearchConsoleService.php`), but live API tokens and verified domain ownership cannot be tested without outbound internet access.
2. **Live PageSpeed Insights API**: `app/Services/PageSpeedService.php` contains the audit engine, but live Lighthouse / PageSpeed score fetching requires public URL reachability.
3. **Live Production Database Migration**: Production database credentials (`mustgivz_amaanullah`) are commented out in `.env`; table schema synchronization against the live host was not verified.
4. **Live SSL Certificate Validation**: Local server runs on HTTP localhost; SSL certificate chain validity and TLS 1.3 protocol handshake cannot be tested until deployed to production.
5. **Third-Party Email Delivery (SMTP)**: `app/Services/IntegrationService.php` contains SMTP hooks, but actual email delivery to external MX records was not verified locally.

---
*Report compiled autonomously from local workspace source code inspection, AST verification, and runtime HTTP curl parsing.*