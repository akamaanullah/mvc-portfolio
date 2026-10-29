-- =====================================================================
-- web3d — Complete Database Schema & Seed Data
-- Compatible with MySQL 5.7+ / 8.0+ / MariaDB 10.3+
-- Engine: InnoDB | Charset: utf8mb4 | Collation: utf8mb4_unicode_ci
-- =====================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- 1. USERS (Admin & Team Accounts)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) NOT NULL DEFAULT 'admin',
  `avatar` VARCHAR(255) NULL,
  `remember_token` VARCHAR(100) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 2. CATEGORIES (Articles, Projects, Services)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `type` ENUM('article', 'project', 'service') NOT NULL DEFAULT 'article',
  `name` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `seo_intro` TEXT NULL,
  `icon` VARCHAR(100) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_cat_type` (`type`),
  INDEX `idx_cat_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 3. TAGS
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `items_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 4. ARTICLES (Blog / Deep Dives)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT UNSIGNED NULL,
  `category_slug` VARCHAR(100) NOT NULL DEFAULT 'laravel-php',
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `subtitle` TEXT NULL,
  `badge_category` VARCHAR(100) NOT NULL DEFAULT 'Laravel',
  `badge_type` VARCHAR(100) NOT NULL DEFAULT 'Guide',
  `cover_image` VARCHAR(255) NULL,
  `cover_alt` VARCHAR(255) NULL,
  `excerpt` TEXT NULL,
  `body_json` LONGTEXT NULL,
  `body_html` LONGTEXT NULL,
  `toc_json` LONGTEXT NULL,
  `tags` VARCHAR(255) NULL,
  `status` ENUM('draft', 'in_review', 'scheduled', 'published', 'trash') NOT NULL DEFAULT 'published',
  `published_at` DATETIME NULL,
  `views_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `reading_time` VARCHAR(50) NOT NULL DEFAULT '8 min',
  `show_bio` TINYINT(1) NOT NULL DEFAULT 1,
  `show_newsletter` TINYINT(1) NOT NULL DEFAULT 1,
  `show_prev_next` TINYINT(1) NOT NULL DEFAULT 1,
  `show_cta` TINYINT(1) NOT NULL DEFAULT 1,
  `cta_title` VARCHAR(255) NULL DEFAULT 'Building a SaaS product in Laravel?',
  `cta_text` TEXT NULL,
  `related_article_ids` VARCHAR(255) NULL,
  `focus_keyword` VARCHAR(150) NULL,
  `seo_title` VARCHAR(255) NULL,
  `meta_description` TEXT NULL,
  `canonical_url` VARCHAR(255) NULL,
  `og_image` VARCHAR(255) NULL,
  `is_indexed` TINYINT(1) NOT NULL DEFAULT 1,
  `faq_schema` TINYINT(1) NOT NULL DEFAULT 1,
  `blog_schema` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `view` VARCHAR(100) NOT NULL DEFAULT 'articles/show',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_art_status` (`status`),
  INDEX `idx_art_cat` (`category_slug`),
  INDEX `idx_art_pub` (`published_at`),
  INDEX `idx_art_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 5. PROJECTS (Case Studies & Systems)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT UNSIGNED NULL,
  `category_slug` VARCHAR(100) NOT NULL DEFAULT 'products',
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `highlight_em` VARCHAR(150) NULL,
  `domain` VARCHAR(150) NULL,
  `summary` TEXT NULL,
  `banner` VARCHAR(255) NULL,
  `banner_alt` VARCHAR(255) NULL,
  `client` VARCHAR(255) NULL,
  `industry` VARCHAR(255) NULL,
  `role` VARCHAR(255) NULL,
  `timeline` VARCHAR(100) NULL,
  `platform` VARCHAR(150) NULL,
  `project_status` VARCHAR(100) NOT NULL DEFAULT 'Completed',
  `tech_chips` VARCHAR(255) NULL,
  `tldr` TEXT NULL,
  `key_results` TEXT NULL,
  `body_json` LONGTEXT NULL,
  `body_html` LONGTEXT NULL,
  `status` ENUM('draft', 'in_review', 'scheduled', 'published', 'trash') NOT NULL DEFAULT 'published',
  `published_at` DATETIME NULL,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `show_on_home` TINYINT(1) NOT NULL DEFAULT 0,
  `views_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `cta_title` VARCHAR(255) NULL,
  `cta_text` TEXT NULL,
  `cta_label` VARCHAR(100) NULL,
  `related_project_ids` VARCHAR(255) NULL,
  `focus_keyword` VARCHAR(150) NULL,
  `seo_title` VARCHAR(255) NULL,
  `meta_description` TEXT NULL,
  `canonical_url` VARCHAR(255) NULL,
  `og_image` VARCHAR(255) NULL,
  `is_indexed` TINYINT(1) NOT NULL DEFAULT 1,
  `faq_schema` TINYINT(1) NOT NULL DEFAULT 1,
  `creative_work_schema` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `view` VARCHAR(100) NOT NULL DEFAULT 'projects/show',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_proj_status` (`status`),
  INDEX `idx_proj_cat` (`category_slug`),
  INDEX `idx_proj_feat` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 6. SERVICES
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `highlight_em` VARCHAR(150) NULL,
  `summary` TEXT NULL,
  `tags` VARCHAR(255) NULL,
  `banner` VARCHAR(255) NULL,
  `banner_alt` VARCHAR(255) NULL,
  `stats_json` TEXT NULL,
  `intro` LONGTEXT NULL,
  `comparison_json` LONGTEXT NULL,
  `sections_json` LONGTEXT NULL,
  `body_json` LONGTEXT NULL,
  `body_html` LONGTEXT NULL,
  `status` ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'published',
  `seo_title` VARCHAR(255) NULL,
  `meta_description` TEXT NULL,
  `schema_json` LONGTEXT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `view` VARCHAR(100) NOT NULL DEFAULT 'services/show',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_svc_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 7. LANDING PAGES (Local SEO & Campaigns)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `landing_pages`;
CREATE TABLE `landing_pages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `seo_title` VARCHAR(255) NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `city` VARCHAR(100) NULL,
  `meta_description` TEXT NULL,
  `content_html` LONGTEXT NULL,
  `schema_json` LONGTEXT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `views_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_lp_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 8. CONTACTS (Contact Form Inquiries)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(100) NULL,
  `company` VARCHAR(150) NULL,
  `service` VARCHAR(150) NULL,
  `project_type` VARCHAR(150) NULL,
  `budget` VARCHAR(100) NULL,
  `timeline` VARCHAR(100) NULL,
  `preferred_contact` VARCHAR(50) NULL,
  `message` TEXT NULL,
  `description` TEXT NULL,
  `ip` VARCHAR(45) NULL,
  `status` ENUM('new', 'read', 'replied', 'archived') NOT NULL DEFAULT 'new',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_contact_email` (`email`),
  INDEX `idx_contact_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 9. LEADS (Chatbot & Campaign Leads)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `leads`;
CREATE TABLE `leads` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NULL,
  `phone` VARCHAR(100) NULL,
  `source_url` VARCHAR(255) NULL,
  `requirement` TEXT NULL,
  `budget` VARCHAR(100) NULL,
  `status` ENUM('new', 'contacted', 'qualified', 'proposal', 'won', 'lost') NOT NULL DEFAULT 'new',
  `notes` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_lead_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 10. CHAT CONVERSATIONS & MESSAGES (Live Chat & Bot)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `chat_messages`;
DROP TABLE IF EXISTS `chat_conversations`;

CREATE TABLE `chat_conversations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `session_id` VARCHAR(100) NOT NULL UNIQUE,
  `visitor_name` VARCHAR(150) NULL DEFAULT 'Visitor',
  `visitor_ip` VARCHAR(45) NULL,
  `status` ENUM('bot', 'needs_human', 'active', 'closed') NOT NULL DEFAULT 'bot',
  `last_message` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_chat_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `chat_messages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `conversation_id` INT UNSIGNED NOT NULL,
  `sender` ENUM('visitor', 'bot', 'admin') NOT NULL DEFAULT 'visitor',
  `message` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_msg_conv` (`conversation_id`),
  CONSTRAINT `fk_chat_conv` FOREIGN KEY (`conversation_id`) REFERENCES `chat_conversations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 11. MEDIA (Uploaded Assets & Gallery)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `filename` VARCHAR(255) NOT NULL,
  `filepath` VARCHAR(255) NOT NULL,
  `filetype` VARCHAR(50) NOT NULL DEFAULT 'image/svg+xml',
  `filesize` INT UNSIGNED NOT NULL DEFAULT 0,
  `alt_text` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 12. ANALYTICS & VISITORS
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `visitors`;
CREATE TABLE `visitors` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `ip` VARCHAR(45) NOT NULL,
  `country` VARCHAR(100) NULL,
  `country_code` VARCHAR(10) NULL,
  `city` VARCHAR(100) NULL,
  `device` ENUM('desktop', 'mobile', 'tablet') NOT NULL DEFAULT 'desktop',
  `browser` VARCHAR(100) NULL,
  `url` VARCHAR(255) NOT NULL,
  `referrer` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_vis_created` (`created_at`),
  INDEX `idx_vis_url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `analytics_events`;
CREATE TABLE `analytics_events` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `visitor_ip` VARCHAR(45) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `event_type` ENUM('scroll', 'click', 'dwell') NOT NULL,
  `event_name` VARCHAR(100) NOT NULL,
  `event_value` INT UNSIGNED DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_evt_url_type` (`url`, `event_type`),
  INDEX `idx_evt_url_created` (`url`, `created_at`),
  INDEX `idx_evt_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 13. SETTINGS (General & SEO Options)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(100) NOT NULL UNIQUE,
  `value` LONGTEXT NULL,
  `type` VARCHAR(50) NOT NULL DEFAULT 'text',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================================
-- SEED DATA (Ready-to-Use Initial Records)
-- =====================================================================

-- Default Administrator: admin@amaanullah.com / admin123
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `avatar`, `created_at`) VALUES
(1, 'Amaanullah Khan', 'admin@amaanullah.com', '$2y$12$FgLOFc6qCfBXDy3OsY2z9Oce4rZ3oWi71ThlWmTdy1amOquj9mojq', 'admin', 'media/profile-poster.jpg', NOW())
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Categories: Articles & Projects
INSERT INTO `categories` (`type`, `name`, `slug`, `seo_intro`, `sort_order`, `created_at`) VALUES
('article', 'Laravel & PHP', 'laravel-php', 'Deep-dives into building scalable Laravel and PHP backends, architecture patterns, and enterprise APIs.', 1, NOW()),
('article', 'SaaS & CRM', 'saas-crm', 'Practical advice on building and scaling multi-tenant SaaS products and bespoke CRM platforms.', 2, NOW()),
('article', 'Automation & AI', 'automation-ai', 'Automating manual operational workflows and integrating AI models safely into business tools.', 3, NOW()),
('article', 'Mobile & Flutter', 'mobile-flutter', 'Cross-platform mobile app development with Flutter, state management, and real-time backend synchronization.', 4, NOW()),
('article', 'Web Development', 'web-development', 'Core web technologies, performance optimization, page speed checklists, and modern UI architectures.', 5, NOW()),
('article', 'Career Insights', 'career-insights', 'Lessons from client projects, software engineering leadership, and working with international teams.', 6, NOW()),
('project', 'Web Design & Development', 'web-design-development', 'E-commerce, marketplaces, bespoke web experiences, and custom platforms built for speed.', 1, NOW()),
('project', 'Web Applications', 'web-applications', 'Enterprise software, internal tools, HR portals, and custom CRMs driving business operations.', 2, NOW()),
('project', 'Products', 'products', 'Proprietary software products and real-time communication tools built from scratch.', 3, NOW()),
('project', 'Mobile Apps', 'mobile-apps', 'Cross-platform iOS and Android applications built in Flutter with custom backend APIs.', 4, NOW())
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Tags
INSERT INTO `tags` (`name`, `slug`, `items_count`) VALUES
('Laravel', 'laravel', 12),
('Multi-Tenancy', 'multi-tenancy', 7),
('SaaS Architecture', 'saas-architecture', 7),
('Database Design', 'database-design', 8),
('Eloquent', 'eloquent', 9),
('Flutter', 'flutter', 9),
('WebSockets', 'websockets', 4),
('CRM', 'crm', 8),
('Performance', 'performance', 9),
('Security', 'security', 5),
('Automation', 'automation', 6)
ON DUPLICATE KEY UPDATE `items_count`=VALUES(`items_count`);

-- Initial Project: Chatrox
INSERT INTO `projects` (
  `id`, `category_slug`, `title`, `slug`, `highlight_em`, `domain`, `summary`,
  `banner`, `banner_alt`, `client`, `industry`, `role`, `timeline`, `platform`,
  `project_status`, `tech_chips`, `tldr`, `key_results`, `status`, `published_at`,
  `is_featured`, `show_on_home`, `views_count`, `cta_title`, `cta_text`, `cta_label`,
  `focus_keyword`, `seo_title`, `meta_description`, `sort_order`
) VALUES (
  1,
  'products',
  'Chatrox – Custom Enterprise Chat App',
  'chatrox',
  '(Slack Alternative)',
  'chatrox.com',
  'A fully owned, real-time enterprise messaging and professional networking platform: the speed of Slack with the control of a private system.',
  'images/banners/chatrox.svg',
  'Chatrox real-time messaging and networking platform banner',
  'Internal Enterprise Digital Tool',
  'Communication Tech / Enterprise Systems',
  'Lead Full-Stack Architect',
  '4–5 months',
  'Web & Mobile (Flutter)',
  'Completed',
  'Flutter, Firebase Real-Time Database, WebSockets, PHP, Cloud Storage',
  'Chatrox replaced dependency on Slack-style SaaS with an owned, WebSocket-powered messenger: private channels, role-aware access and room to grow into CRM, HRM and AI workflows.',
  'Real-time | sub-second delivery via WebSockets\n100% owned | messages, files & access data',
  'published',
  NOW(),
  1,
  1,
  2410,
  'Need a private chat system like Chatrox?',
  'Let’s talk about your requirements and architectural design.',
  'Start a project →',
  'custom chat app websockets flutter',
  'Chatrox Case Study: Custom Enterprise Chat App (Slack Alternative)',
  'How Chatrox, a fully owned Slack alternative, was built with WebSockets, Flutter and PHP for private enterprise communication.',
  1
) ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- Initial Article: Multi-Tenant SaaS
INSERT INTO `articles` (
  `id`, `category_slug`, `title`, `slug`, `subtitle`, `badge_category`, `badge_type`,
  `cover_image`, `cover_alt`, `excerpt`, `status`, `published_at`, `views_count`,
  `reading_time`, `focus_keyword`, `seo_title`, `meta_description`, `tags`
) VALUES (
  1,
  'laravel-php',
  'How to Build a Multi-Tenant SaaS in Laravel: Architecture, Database Strategy and Pitfalls',
  'multi-tenant-saas-laravel',
  'A practical guide to tenant identification, choosing between shared and separate databases, scoping queries safely, and avoiding the mistakes that leak data between customers.',
  'Laravel',
  'Guide',
  'images/banners/multi-tenant-crm.svg',
  'Cover: multi-tenant SaaS architecture in Laravel',
  'Tenant identification, database strategy and query scoping for Laravel SaaS, without leaking data between customers.',
  'published',
  NOW(),
  2774,
  '12 min',
  'multi-tenant saas laravel',
  'Multi-Tenant SaaS in Laravel: Architecture, Database Strategy and Pitfalls',
  'Learn how to build a multi-tenant SaaS in Laravel: tenant identification, database strategies, global scopes, and tenant-aware queues.',
  'Laravel, Multi-Tenancy, SaaS Architecture, Database Design'
) ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- Initial Service: Custom CRM Development
INSERT INTO `services` (
  `id`, `title`, `slug`, `highlight_em`, `summary`, `tags`,
  `banner`, `banner_alt`, `stats_json`, `status`, `seo_title`, `meta_description`, `sort_order`
) VALUES (
  1,
  'Custom CRM Development in Laravel',
  'custom-crm-development',
  'Built Around How Your Team Actually Sells',
  'Lead routing, pipeline tracking, multi-tenant access and reporting dashboards on Laravel, shaped around your real sales process.',
  'Laravel, CRM, Multi-Tenant, Enterprise',
  'images/banners/multi-tenant-crm.svg',
  'Custom CRM Development in Laravel Banner',
  '[{"val":"1.5M+","lbl":"leads managed in production"},{"val":"300+","lbl":"concurrent daily users"},{"val":"4.8★","lbl":"Google rating (27 reviews)"}]',
  'published',
  'Custom CRM Development in Laravel | Amaanullah Khan, Karachi',
  'Custom CRM development on Laravel: lead routing, pipeline tracking, multi-tenant access and reporting dashboards built around your actual sales process.',
  1
) ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- Landing Pages
INSERT INTO `landing_pages` (`title`, `slug`, `city`, `meta_description`, `is_active`, `views_count`) VALUES
('Laravel Developer Karachi — Custom Web Apps & APIs', 'laravel-developer-karachi', 'Karachi', 'Hire an experienced Laravel developer in Karachi for enterprise web applications, custom CRM platforms, and REST APIs.', 1, 1302),
('CRM Developers in Pakistan — Custom CRM Software Solutions', 'crm-developers-pakistan', 'Pakistan', 'Custom CRM software development in Pakistan: lead routing, pipeline automation, and multi-tenant portals.', 1, 954),
('Full Stack Developer Karachi — Web, Backend & Mobile Solutions', 'full-stack-developer-karachi', 'Karachi', 'Full-stack software developer in Karachi specializing in PHP, Laravel, Flutter, and scalable web architectures.', 1, 880)
ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- Core System Settings
INSERT INTO `settings` (`key`, `value`, `type`) VALUES
('site_name', 'Amaanullah Khan Portfolio', 'text'),
('site_email', 'contact@amaanullah.com', 'text'),
('phone_number', '+92 300 0000000', 'text'),
('whatsapp_number', '923000000000', 'text'),
('chatbot_name', 'Amaanullah Assistant', 'text'),
('chatbot_welcome', 'Hi! Ask me about web applications, custom CRMs, Flutter apps or my tech stack.', 'textarea'),
('meta_default_title', 'Amaanullah Khan — Web Developer & Software Solutions', 'text'),
('meta_default_desc', 'Web developer and software architect based in Karachi, building custom CRMs, SaaS products, and high-performance web systems.', 'textarea')
ON DUPLICATE KEY UPDATE `value`=VALUES(`value`);

-- ---------------------------------------------------------------------
-- 14. LIVE CHAT & CONVERSATIONS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `chat_conversations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `session_id` VARCHAR(100) NOT NULL UNIQUE,
  `visitor_name` VARCHAR(150) NULL,
  `visitor_email` VARCHAR(150) NULL,
  `visitor_ip` VARCHAR(45) NULL,
  `location` VARCHAR(255) NULL,
  `user_agent` VARCHAR(255) NULL,
  `current_page` VARCHAR(255) NULL,
  `status` ENUM('bot', 'needs_human', 'active', 'closed') NOT NULL DEFAULT 'bot',
  `last_message` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_status` (`status`),
  INDEX `idx_updated` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `conversation_id` INT UNSIGNED NOT NULL,
  `sender` ENUM('visitor', 'bot', 'admin') NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_conversation` (`conversation_id`),
  FOREIGN KEY (`conversation_id`) REFERENCES `chat_conversations`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

