# web3d — Amaanullah Khan portfolio (custom PHP MVC)

The same UI as the static bundle (`amaanullah-portfolio.zip`), served by a small PHP 8.1+ MVC app with clean URLs. The rendered HTML matches the static pages byte for byte, apart from URLs and the CSRF field on the contact form. No framework and no Composer are needed (there's a fallback autoloader); Composer works too.

## Run it

**Built-in PHP server (quickest)**
```bash
cd web3d
cp .env.example .env        # already present; edit if needed
php -S localhost:8000 -t public
# open http://localhost:8000/
```
This also works: `php -S localhost:8000 index.php` from the project root.

**XAMPP / Apache**
1. Copy the `web3d` folder to `htdocs/`. Enable `mod_rewrite`, and `mod_headers` for the security headers.
2. Open `http://localhost/web3d/`. The root `.htaccess` forwards everything to `public/`, and the base URL is detected automatically, so a sub-folder works.
3. Production: point the vhost DocumentRoot at `web3d/public` and set `APP_URL` and `APP_DEBUG=false` in `.env`.

**Database (optional)**
Out of the box, page data comes from the model arrays and contact requests go to `storage/logs/contacts.log`. To use MySQL instead:
1. Create the DB.
2. Set `DB_ENABLED=true` and the `DB_*` values in `.env`.
3. Run `php bin/migrate.php`, which uses `database/schema.sql` with the services, projects, articles, categories and contacts tables.

`php bin/clear-cache.php [--logs]` empties `storage/cache` (and `app.log` when you pass `--logs`).

## Routes
| URL | Controller@action | View |
|---|---|---|
| `/` | HomeController@index | views/home/index.php (portal splash + 3D hero) |
| `/about` | AboutController@index | views/about/index.php |
| `/services` · `/services/{slug}` | ServiceController@index / @show | views/services/index.php · show.php (`custom-crm-development`) |
| `/projects` · `/projects/category/{cat}` · `/projects/{slug}` | ProjectController | views/projects/index.php · category.php → categories/{cat}.php · show.php (`chatrox`) |
| `/articles` · `/articles/category/{cat}` · `/articles/{slug}` | ArticleController | views/articles/index.php · category.php → categories/{cat}.php · show.php (`multi-tenant-saas-laravel`) |
| `/contact` (GET, POST) | ContactController@index / @store | views/contact/index.php |
| `/laravel-developer-karachi` · `/crm-developers-pakistan` · `/full-stack-developer-karachi` | LandingController@show | views/landing/show.php → landing/{slug}.php |
| anything else | 404 | views/errors/404.php (500 → errors/500.php, logged to storage/logs/app.log) |

Project categories: `web-design-development`, `web-applications`, `products`, `mobile-apps`. Article categories: `web-development`, `laravel-php`, `saas-crm`, `automation-ai`, `mobile-flutter`, `career-insights`.

**POST /contact** checks the CSRF token (`_token`, kept in the session) and the honeypot (`website`), then validates name and email. It stores the request through `ContactModel::create()`, using the DB if enabled and `storage/logs/contacts.log` otherwise. It returns JSON for `fetch` (Accept: application/json) and a redirect to `/contact?sent=1` otherwise. The page's JS still uses the FAKE SUBMIT demo. To go live, switch to the `fetch(F.action, …)` call noted in `public/js/contact-page.js`.

## Where to edit content
- **Header and footer (every page):** `views/layouts/header.php` and `footer.php`. The home page keeps its in-page anchors, and the other pages link to routes.
- **Page markup:** `views/<section>/…php`. This is the HTML from the design with `base_url()` and `asset_url()` for links.
- **Data / slugs:** `app/Models/*Model.php`. They return the current hard-coded arrays and read from MySQL when `DB_ENABLED=true`.
- **Styles and scripts:** `public/css` and `public/js`. `theme.js` sets dark as the default theme, `layout.js` runs the shared header/footer, and each page has its own CSS and `.dark.css`.
- **Chatbot:** `public/js/chatbot-config.js` holds the bot name, endpoint, WhatsApp number and "Powered by" text.
- **Helpers:** `app/Helpers/helpers.php` has `env()`, `config()`, `base_url()`, `asset_url()`, `e()`, `sanitize()`, `view()` and `csrf_token()`.

## Structure
```
app/Controllers  app/Core (App router, Controller, Database PDO, Model, Logger)  app/Helpers  app/Models
bin/ (migrate.php, clear-cache.php)   config/ (app.php, database.php)   database/schema.sql
public/ (index.php, .htaccess, css, js, images, logo-v2, media)   storage/ (logs, cache)
views/ (layouts, home, about, services, projects, articles, contact, landing, errors)
.env .env.example .gitignore .htaccess composer.json index.php
```

## Admin panel (static UI)
`/admin` (dashboard), `/admin/login`, `/admin/articles`, `/admin/articles/create`, `/admin/projects`, `/admin/projects/create`,
`/admin/services`, `/admin/services/edit`, `/admin/landing-pages`, `/admin/landing-pages/edit`, `/admin/categories`, `/admin/media`,
`/admin/leads`, `/admin/messages`, `/admin/live-chat`, `/admin/analytics`, `/admin/analytics/page`, `/admin/visitors`,
`/admin/visitors/show`, `/admin/search-console`, `/admin/performance`, `/admin/settings`, `/admin/profile`.
Files: `app/Controllers/AdminController.php`, `views/admin/layouts/{app,head,sidebar,topbar,footer}.php`, `views/admin/pages/*.php`,
`public/css/admin/`, `public/js/admin/`. UI only, demo data, no auth yet (see TODO in AdminController).
