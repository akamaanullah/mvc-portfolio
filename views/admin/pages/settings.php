<?php
/**
 * Admin · Settings — 100% Dynamic Site, SEO, Web & LLM Files, Chatbot & Full Integrations Management.
 */
$settings = $settings ?? [];
$integrations = $integrations ?? [];
$integrationsConfig = $integrationsConfig ?? [];
$seoFiles = $seoFiles ?? [];
?>

<style>
/* Modern Settings & Switch UI */
.toggle-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 14px 18px;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid var(--line);
    border-radius: 12px;
    margin-bottom: 12px;
    transition: all 0.2s ease;
}
.toggle-card:hover {
    border-color: rgba(242, 106, 27, 0.4);
    background: rgba(255, 255, 255, 0.035);
}
.toggle-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 0;
}
.toggle-title {
    font-weight: 700;
    font-size: 13.5px;
    color: var(--ink);
}
.toggle-desc {
    font-size: 12px;
    color: var(--mut);
    line-height: 1.4;
}

/* File Manager Grid & Editor */
.file-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}
.file-card {
    padding: 14px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid var(--line);
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.file-card:hover, .file-card.active {
    border-color: var(--o);
    background: rgba(242, 106, 27, 0.06);
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(242, 106, 27, 0.12);
}
.file-card .fn {
    font-family: "JetBrains Mono", Consolas, monospace;
    font-weight: 700;
    font-size: 13.5px;
    color: var(--ink);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.file-card .fdesc {
    font-size: 11.5px;
    color: var(--mut);
    margin: 8px 0;
    line-height: 1.35;
}
.file-card .fmeta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 11px;
    color: var(--mut);
    padding-top: 6px;
    border-top: 1px dashed var(--line);
}
.file-editor-box {
    background: #0d0e15;
    border: 1px solid var(--line);
    border-radius: 14px;
    overflow: hidden;
}
.file-editor-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 18px;
    background: rgba(255, 255, 255, 0.02);
    border-bottom: 1px solid var(--line);
    flex-wrap: wrap;
    gap: 10px;
}
.file-editor-textarea {
    width: 100%;
    min-height: 380px;
    padding: 18px;
    background: transparent;
    border: none;
    outline: none;
    font-family: "JetBrains Mono", Consolas, monospace;
    font-size: 13px;
    line-height: 1.6;
    color: #e2e8f0;
    resize: vertical;
    white-space: pre;
    tab-size: 4;
}
.file-editor-foot {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 18px;
    background: rgba(255, 255, 255, 0.02);
    border-top: 1px solid var(--line);
    flex-wrap: wrap;
    gap: 12px;
}

/* Modal Styling */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(5px);
    z-index: 999;
    place-items: center;
    padding: 20px;
    overflow-y: auto;
}
.modal-box {
    background: #14151d;
    border: 1px solid var(--line);
    border-radius: 16px;
    width: 100%;
    max-width: 620px;
    padding: 26px;
    box-shadow: 0 24px 50px rgba(0, 0, 0, 0.6);
    position: relative;
    max-height: 90vh;
    overflow-y: auto;
}
</style>

<form action="<?= base_url('/admin/settings/save') ?>" method="POST" id="settingsForm">
<input type="hidden" name="_token" value="<?= csrf_token() ?>">

<div class="ph-h">
    <div>
        <div class="crumbs">Admin / System</div>
        <h1>Settings</h1>
        <p>Site, SEO, Web &amp; AI Crawler Files, Chatbot Engine, and Integrations.</p>
    </div>
    <div class="acts">
        <button class="btn o" type="submit">
            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg> 
            Save changes
        </button>
    </div>
</div>

<div class="settings">
    <nav class="vtabs" data-tabs="set">
        <button class="on" type="button" data-tab="sG">
            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/></svg> 
            General
        </button>
        <button type="button" data-tab="sS">
            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg> 
            SEO
        </button>
        <button type="button" data-tab="sF">
            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg> 
            Files &amp; LLMs
        </button>
        <button type="button" data-tab="sC">
            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 8h10M7 12h6"/><path d="M12 21l-3-3H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2h-4z"/></svg> 
            Chatbot
        </button>
        <button type="button" data-tab="sI">
            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M13 2L3 14h9l-1 8 10-12h-9z"/></svg> 
            Integrations
        </button>
        <button type="button" data-tab="sU">
            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="4"/><path d="M2 21a7 7 0 0 1 14 0M17 4a4 4 0 0 1 0 8M22 21a7 7 0 0 0-4-6.3"/></svg> 
            Users &amp; roles
        </button>
    </nav>

    <div>
        <!-- TAB 1: GENERAL -->
        <section class="card pane on" id="sG" data-pane="set">
            <div class="bd2">
                <div class="sec-t">General</div>
                <p class="sec-d">Basic site identity used in header, footer and schema.</p>
                <div class="fg2" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:0 14px">
                    <div class="fld">
                        <label>Site name</label>
                        <input class="inp" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? 'Amaanullah Khan') ?>">
                    </div>
                    <div class="fld">
                        <label>Tagline</label>
                        <input class="inp" name="tagline" value="<?= htmlspecialchars($settings['tagline'] ?? 'PHP & Laravel Developer in Karachi') ?>">
                    </div>
                    <div class="fld">
                        <label>Domain</label>
                        <input class="inp" name="site_domain" value="<?= htmlspecialchars($settings['site_domain'] ?? 'https://amaanullah.com') ?>">
                    </div>
                    <div class="fld">
                        <label>Contact email</label>
                        <input class="inp" name="contact_email" value="<?= htmlspecialchars($settings['contact_email'] ?? 'info@amaanullah.com') ?>">
                    </div>
                    <div class="fld">
                        <label>Phone</label>
                        <input class="inp" name="phone_number" value="<?= htmlspecialchars($settings['phone_number'] ?? '+92 319 6935307') ?>">
                    </div>
                    <div class="fld">
                        <label>WhatsApp number</label>
                        <input class="inp" name="whatsapp_number" value="<?= htmlspecialchars($settings['whatsapp_number'] ?? '923196935307') ?>">
                    </div>
                </div>
                <div class="fld">
                    <label>Logo</label>
                    <div class="row">
                        <img src="<?= asset_url('images/logo.png') ?>" alt="" style="height:40px;width:auto;background:var(--card2);padding:6px;border-radius:10px">
                        <div class="drop" style="padding:10px 16px;flex:1"><small><b>logo.png (active)</b></small></div>
                    </div>
                </div>

                <div class="toggle-card" style="margin-top:16px;">
                    <div class="toggle-info">
                        <div class="toggle-title">Default theme: dark</div>
                        <div class="toggle-desc">Enable sleek dark mode as default across all visitor landing and portfolio pages.</div>
                    </div>
                    <label class="sw">
                        <input type="checkbox" name="default_theme_dark" value="1" <?= (!isset($settings['default_theme_dark']) || !empty($settings['default_theme_dark'])) ? 'checked' : '' ?>>
                        <i></i>
                    </label>
                </div>
            </div>
        </section>

        <!-- TAB 2: SEO -->
        <section class="card pane" id="sS" data-pane="set">
            <div class="bd2">
                <div class="sec-t">SEO defaults</div>
                <p class="sec-d">Default fallbacks for meta tags and canonical schema data.</p>
                <div class="fld">
                    <label>Title template</label>
                    <input class="inp code-in" name="meta_default_title" value="<?= htmlspecialchars($settings['meta_default_title'] ?? 'Amaanullah Khan — Web Developer & Software Solutions') ?>">
                </div>
                <div class="fld">
                    <label for="dmd">Default meta description</label>
                    <textarea class="inp" id="dmd" name="meta_default_desc" rows="3"><?= htmlspecialchars($settings['meta_default_desc'] ?? 'PHP & Laravel developer in Karachi building custom CRM, SaaS and automation systems.') ?></textarea>
                </div>

                <div class="toggle-card">
                    <div class="toggle-info">
                        <div class="toggle-title">Auto-generate sitemap on publish</div>
                        <div class="toggle-desc">Automatically rebuilds sitemap.xml with updated URLs whenever a new project, article, or service is published.</div>
                    </div>
                    <label class="sw">
                        <input type="checkbox" name="auto_generate_sitemap" value="1" <?= (!isset($settings['auto_generate_sitemap']) || !empty($settings['auto_generate_sitemap'])) ? 'checked' : '' ?>>
                        <i></i>
                    </label>
                </div>

                <div class="toggle-card">
                    <div class="toggle-info">
                        <div class="toggle-title">Person + WebSite schema on all pages</div>
                        <div class="toggle-desc">Injects Google rich snippet JSON-LD structured data for Amaanullah Khan personal brand and portfolio.</div>
                    </div>
                    <label class="sw">
                        <input type="checkbox" name="person_website_schema" value="1" <?= (!isset($settings['person_website_schema']) || !empty($settings['person_website_schema'])) ? 'checked' : '' ?>>
                        <i></i>
                    </label>
                </div>
            </div>
        </section>

        <!-- TAB 3: FILES & LLMs -->
        <section class="card pane" id="sF" data-pane="set">
            <div class="bd2">
                <div class="row sb2" style="margin-bottom:12px; flex-wrap:wrap; gap:10px;">
                    <div>
                        <div class="sec-t">Web &amp; AI Crawler Files</div>
                        <p class="sec-d" style="margin:0;">Manage and edit robots.txt, sitemap.xml, llms.txt, llms-full.txt, and custom specification files.</p>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <button class="btn sm o" type="button" id="btnGenSitemap">
                            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 2v6h-6M3 12a9 9 0 0 1 15-6.7L21 8M3 22v-6h6M21 12a9 9 0 0 1-15 6.7L3 16"/></svg>
                            Regenerate sitemap.xml
                        </button>
                        <button class="btn sm o" type="button" id="btnGenLlms">
                            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                            Regenerate llms-full.txt
                        </button>
                        <button class="btn sm" type="button" id="btnOpenNewFileModal" style="background:var(--card2); border:1px solid var(--line);">
                            + Add custom file
                        </button>
                    </div>
                </div>

                <!-- Grid of manageable files -->
                <div class="file-cards-grid" id="fileCardsGrid">
                    <?php 
                    $firstKey = !empty($seoFiles) ? array_key_first($seoFiles) : 'robots.txt';
                    foreach ($seoFiles as $fName => $file): 
                    ?>
                        <div class="file-card <?= $fName === $firstKey ? 'active' : '' ?>" data-filename="<?= htmlspecialchars($fName) ?>">
                            <div class="fn">
                                <span><?= htmlspecialchars($file['name']) ?></span>
                                <span class="pill" style="font-size:10px; border-color:<?= $file['badge_color'] ?>; color:<?= $file['badge_color'] ?>;">
                                    <?= htmlspecialchars($file['badge']) ?>
                                </span>
                            </div>
                            <div class="fdesc"><?= htmlspecialchars($file['desc']) ?></div>
                            <div class="fmeta">
                                <span><b><?= $file['size_formatted'] ?></b> (<?= $file['lines_count'] ?> lines)</span>
                                <span><?= $file['updated_at'] ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Active In-Page File Editor -->
                <div class="file-editor-box">
                    <div class="file-editor-head">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <svg class="i" style="color:var(--o);" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <span style="font-weight:700; font-size:14px;" id="editorActiveTitle">robots.txt</span>
                            <a id="editorActiveLink" href="<?= base_url('/robots.txt') ?>" target="_blank" style="font-size:12px; color:var(--o); text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                                View live file ↗
                            </a>
                        </div>
                        <div style="display:flex; align-items:center; gap:12px;">
                            <span id="editorMetaInfo" style="font-size:12px; color:var(--mut);">Loading file...</span>
                        </div>
                    </div>
                    <textarea class="file-editor-textarea" id="fileEditorTextarea" spellcheck="false" placeholder="Loading file content..."></textarea>
                    <div class="file-editor-foot">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <button class="btn o sm" type="button" id="btnSaveFile">
                                <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                Save file changes
                            </button>
                            <button class="btn sm" type="button" id="btnDeleteCustomFile" style="display:none; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#ef4444;">
                                Delete custom file
                            </button>
                        </div>
                        <span id="fileEditorStatus" style="font-size:12px; font-weight:600;"></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- TAB 4: CHATBOT -->
        <section class="card pane" id="sC" data-pane="set">
            <div class="bd2">
                <div class="sec-t">Chatbot &amp; AI Engine</div>
                <p class="sec-d">Connected to Cloudflare Workers AI (Llama 3.1) with real-time human takeover.</p>
                
                <div class="fld">
                    <label for="cbe">Endpoint URL</label>
                    <input class="inp code-in" id="cbe" value="<?= base_url('/api/chat/message') ?>" readonly style="background:var(--bg-main); opacity:0.9;">
                    <span class="hint">Live internal proxy running with session tracking and human handoff detection.</span>
                </div>
                <div class="fld">
                    <label for="cbk">AI Provider &amp; Model</label>
                    <input class="inp code-in" id="cbk" value="Cloudflare Workers AI (@cf/meta/llama-3.1-8b-instruct-fast)" readonly style="background:var(--bg-main); opacity:0.9;">
                    <span class="hint">Trained with portfolio knowledge base (config/brain.json + live database models).</span>
                </div>
                <div class="fg2" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:0 14px">
                    <div class="fld">
                        <label>Bot name</label>
                        <input class="inp" name="chatbot_name" value="<?= htmlspecialchars($settings['chatbot_name'] ?? 'Amaanullah AI') ?>">
                    </div>
                    <div class="fld">
                        <label>Greeting</label>
                        <input class="inp" name="chatbot_welcome" value="<?= htmlspecialchars($settings['chatbot_welcome'] ?? "Hi! I’m Amaanullah’s assistant. What are you looking to build?") ?>">
                    </div>
                    <div class="fld">
                        <label>Timeout (s)</label>
                        <input class="inp" type="number" name="chatbot_timeout" value="<?= htmlspecialchars($settings['chatbot_timeout'] ?? '25') ?>">
                    </div>
                    <div class="fld">
                        <label>Hand off to human after</label>
                        <select class="sel" name="chatbot_handoff_trigger">
                            <option <?= ($settings['chatbot_handoff_trigger'] ?? '') === 'Visitor asks for a human' ? 'selected' : '' ?>>Visitor asks for a human</option>
                            <option <?= ($settings['chatbot_handoff_trigger'] ?? '') === 'Immediate quote request' ? 'selected' : '' ?>>Immediate quote request</option>
                        </select>
                    </div>
                </div>

                <div class="toggle-card">
                    <div class="toggle-info">
                        <div class="toggle-title">Capture leads (ask for email)</div>
                        <div class="toggle-desc">Automatically prompts visitor for their email or phone number when discussing project proposals.</div>
                    </div>
                    <label class="sw">
                        <input type="checkbox" name="chatbot_capture_leads" value="1" <?= (!isset($settings['chatbot_capture_leads']) || !empty($settings['chatbot_capture_leads'])) ? 'checked' : '' ?>>
                        <i></i>
                    </label>
                </div>

                <div class="toggle-card">
                    <div class="toggle-info">
                        <div class="toggle-title">Notify me on “needs human”</div>
                        <div class="toggle-desc">Sends an instant high-priority SMTP email alert to <?= htmlspecialchars(setting('alert_email', setting('smtp_user', ''))) ?> with direct chat takeover link.</div>
                    </div>
                    <label class="sw">
                        <input type="checkbox" name="chatbot_notify_needs_human" value="1" <?= (!isset($settings['chatbot_notify_needs_human']) || !empty($settings['chatbot_notify_needs_human'])) ? 'checked' : '' ?>>
                        <i></i>
                    </label>
                </div>

                <div class="toggle-card">
                    <div class="toggle-info">
                        <div class="toggle-title">Show on mobile</div>
                        <div class="toggle-desc">Displays the interactive floating launcher button on smartphones and tablet screen sizes.</div>
                    </div>
                    <label class="sw">
                        <input type="checkbox" name="chatbot_show_mobile" value="1" <?= (!isset($settings['chatbot_show_mobile']) || !empty($settings['chatbot_show_mobile'])) ? 'checked' : '' ?>>
                        <i></i>
                    </label>
                </div>

                <div style="margin-top:20px; padding-top:16px; border-top:1px solid var(--line); display:flex; align-items:center; gap:14px; flex-wrap:wrap;">
                    <button class="btn o" type="button" id="btnTestChatbot">
                        <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M13 2L3 14h9l-1 8 10-12h-9z"/></svg> 
                        Test connection
                    </button>
                    <span id="testChatbotResult" style="font-size:0.88rem; font-weight:600;"></span>
                </div>
                <div id="testChatbotBox" style="display:none; margin-top:14px; padding:16px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:12px; font-size:0.88rem;"></div>
            </div>
        </section>

        <!-- TAB 5: INTEGRATIONS (FULL DYNAMIC MANAGEMENT) -->
        <section class="pane" id="sI" data-pane="set">
            <div class="grid g2">
                <?php foreach ($integrations as $key => $int): ?>
                    <div class="card" style="padding:20px; display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div class="row sb2">
                                <b style="font-size:15px;"><?= htmlspecialchars($int['title']) ?></b>
                                <span class="pill <?= htmlspecialchars($int['badge_class'] ?? ($int['connected'] ? 'good' : 'warn')) ?>" style="font-size:11px;">● <?= htmlspecialchars($int['badge']) ?></span>
                            </div>
                            <p class="mut sm" style="margin:10px 0 16px; line-height:1.5;"><?= htmlspecialchars($int['desc']) ?></p>
                        </div>
                        <div class="row sb2" style="border-top:1px solid var(--line); padding-top:14px; margin-top:10px;">
                            <button type="button" class="btn sm o btn-open-integration" data-int="<?= $key ?>">
                                <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                                Configure &amp; Manage →
                            </button>
                            <span class="mut" style="font-size:11px;"><?= $int['connected'] ? 'Active' : 'Needs Setup' ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- TAB 6: USERS & ROLES -->
        <section class="card pane" id="sU" data-pane="set">
            <div class="hd">
                <h3>Team &amp; Roles</h3>
            </div>
            <div class="tw" style="margin-top:8px">
                <table class="t">
                    <thead><tr><th>User</th><th>Role</th><th>Status</th></tr></thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="row">
                                    <span class="ava">AK</span>
                                    <div><b>Amaanullah Khan</b><br><small class="mut">info@amaanullah.com</small></div>
                                </div>
                            </td>
                            <td><span class="pill good">Super Admin</span></td>
                            <td class="mut">Active now</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
</form>

<!-- Modal: Add Custom File -->
<div id="newFileModal" class="modal-overlay">
    <div class="modal-box">
        <div class="row sb2" style="margin-bottom:16px;">
            <h3 style="margin:0; font-size:1.15rem;">+ Add Custom Web File</h3>
            <button type="button" class="btn-close-modal" data-target="newFileModal" style="background:none; border:none; color:var(--mut); font-size:22px; cursor:pointer;">&times;</button>
        </div>
        <div class="fld">
            <label>Filename (e.g. ai-plugin.json, custom-rules.txt)</label>
            <input class="inp code-in" id="newFilenameInput" placeholder="ai-plugin.json">
            <span class="hint">Must end in .txt, .xml, .json, or .md. Saved to public root directory.</span>
        </div>
        <div class="fld">
            <label>Initial Content</label>
            <textarea class="inp code-in" id="newFileContentInput" rows="6" placeholder="File content here..."></textarea>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
            <button class="btn sm" type="button" class="btn-close-modal" data-target="newFileModal" style="background:var(--card2); border:1px solid var(--line);">Cancel</button>
            <button class="btn o sm" type="button" id="btnSubmitNewFile">Create &amp; Save File</button>
        </div>
    </div>
</div>

<!-- Modal: Manage Integration (Dedicated Configuration Controls) -->
<div id="integrationModal" class="modal-overlay">
    <div class="modal-box">
        <div class="row sb2" style="margin-bottom:16px; border-bottom:1px solid var(--line); padding-bottom:14px;">
            <div>
                <h3 id="modalIntTitle" style="margin:0; font-size:1.25rem;">Configure Integration</h3>
                <small id="modalIntSub" class="mut">Manage credentials and test connection live</small>
            </div>
            <button type="button" class="btn-close-modal" data-target="integrationModal" style="background:none; border:none; color:var(--mut); font-size:22px; cursor:pointer;">&times;</button>
        </div>

        <!-- 1. Google Search Console Form -->
        <div id="intBox_gsc" class="int-subform" style="display:none;">
            <div class="fld">
                <label>Verified Domain / Site URL</label>
                <input class="inp code-in" id="gscSiteUrl" value="<?= htmlspecialchars($integrationsConfig['gsc']['site_url'] ?? 'https://amaanullah.com/') ?>">
            </div>
            <div class="fld">
                <label>Service Account Email</label>
                <input class="inp code-in" value="<?= htmlspecialchars($integrationsConfig['gsc']['client_email'] ?? '') ?>" readonly style="background:var(--bg-main); opacity:0.85;">
                <span class="hint">Must be added as 'Owner' in Google Search Console permissions.</span>
            </div>
            <div class="fld">
                <label>Service Account JSON Key</label>
                <textarea class="inp code-in" id="gscKeyJson" rows="6" placeholder="Paste full service_account.json here..."><?= htmlspecialchars($integrationsConfig['gsc']['key_json'] ?? '') ?></textarea>
                <span class="hint">Stored securely at <?= htmlspecialchars($integrationsConfig['gsc']['key_path'] ?? 'config/keys/search-console-key.json') ?></span>
            </div>
            <div style="display:flex; align-items:center; gap:10px; margin-top:16px; flex-wrap:wrap;">
                <button class="btn o sm" type="button" id="btnTestGsc" style="display:inline-flex; align-items:center; gap:6px;"><svg class="i" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Test GSC Connection</button>
                <a class="btn sm" href="<?= base_url('/admin/search-console') ?>" style="background:var(--card2); border:1px solid var(--line); text-decoration:none;">Open Search Console Page →</a>
            </div>
        </div>

        <!-- 2. Google PageSpeed Insights Form -->
        <div id="intBox_pagespeed" class="int-subform" style="display:none;">
            <div class="fld">
                <label>Google PageSpeed API Key</label>
                <input class="inp code-in" id="psApiKey" value="<?= htmlspecialchars($integrationsConfig['pagespeed']['api_key'] ?? '') ?>" placeholder="AIzaSy...">
                <span class="hint">Used for live Core Web Vitals audits &amp; Lighthouse scoring.</span>
            </div>
            <div class="fld">
                <label>Default Audit URL</label>
                <input class="inp code-in" id="psAuditUrl" value="<?= htmlspecialchars($integrationsConfig['pagespeed']['audit_url'] ?? 'https://amaanullah.com') ?>">
            </div>
            <div style="display:flex; align-items:center; gap:10px; margin-top:16px; flex-wrap:wrap;">
                <button class="btn o sm" type="button" id="btnTestPageSpeed" style="display:inline-flex; align-items:center; gap:6px;"><svg class="i" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Run Test Audit</button>
                <a class="btn sm" href="<?= base_url('/admin/performance') ?>" style="background:var(--card2); border:1px solid var(--line); text-decoration:none;">Open Performance Dashboard →</a>
            </div>
        </div>

        <!-- 3. WhatsApp Direct Form -->
        <div id="intBox_whatsapp" class="int-subform" style="display:none;">
            <div class="fld">
                <label>WhatsApp Phone Number</label>
                <input class="inp code-in" id="waPhone" value="<?= htmlspecialchars($integrationsConfig['whatsapp']['phone'] ?? '+92 319 6935307') ?>">
                <span class="hint">Include country code (e.g. +92 319 6935307).</span>
            </div>
            <div class="fld">
                <label>Live WhatsApp API Link</label>
                <input class="inp code-in" id="waUrlPreview" value="<?= htmlspecialchars($integrationsConfig['whatsapp']['whatsapp_url'] ?? 'https://api.whatsapp.com/send?phone=923196935307') ?>" readonly style="background:var(--bg-main); opacity:0.85;">
            </div>
            <div style="margin-top:16px;">
                <a class="btn o sm" id="waTestLink" href="<?= htmlspecialchars($integrationsConfig['whatsapp']['whatsapp_url'] ?? '') ?>" target="_blank" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <svg class="i" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.456 5.711 1.457h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg> Test WhatsApp Chat (Open in New Tab) ↗
                </a>
            </div>
        </div>

        <!-- 4. SMTP / Mail Server Form -->
        <div id="intBox_smtp" class="int-subform" style="display:none;">
            <div class="fg2" style="display:grid; grid-template-columns:2fr 1fr 1fr; gap:10px;">
                <div class="fld">
                    <label>SMTP Host</label>
                    <input class="inp code-in" id="smtpHost" value="<?= htmlspecialchars($integrationsConfig['smtp']['host'] ?? 'mail.amaanullah.com') ?>">
                </div>
                <div class="fld">
                    <label>Port</label>
                    <input class="inp code-in" type="number" id="smtpPort" value="<?= htmlspecialchars($integrationsConfig['smtp']['port'] ?? '465') ?>">
                </div>
                <div class="fld">
                    <label>Encryption</label>
                    <select class="sel" id="smtpEncryption">
                        <option value="ssl" <?= ($integrationsConfig['smtp']['encryption'] ?? 'ssl') === 'ssl' ? 'selected' : '' ?>>SSL (465)</option>
                        <option value="tls" <?= ($integrationsConfig['smtp']['encryption'] ?? '') === 'tls' ? 'selected' : '' ?>>TLS (587)</option>
                    </select>
                </div>
            </div>
            <div class="fg2" style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div class="fld">
                    <label>SMTP Username / Email</label>
                    <input class="inp code-in" id="smtpUser" value="<?= htmlspecialchars($integrationsConfig['smtp']['user'] ?? 'info@amaanullah.com') ?>">
                </div>
                <div class="fld">
                    <label>SMTP Password / App Password</label>
                    <input class="inp code-in" type="password" id="smtpPass" value="<?= htmlspecialchars($integrationsConfig['smtp']['pass'] ?? '') ?>" placeholder="Leave blank to keep unchanged">
                </div>
            </div>
            <div class="fg2" style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div class="fld">
                    <label>Sender Name</label>
                    <input class="inp" id="smtpFromName" value="<?= htmlspecialchars($integrationsConfig['smtp']['from_name'] ?? 'Amaanullah Khan') ?>">
                </div>
                <div class="fld">
                    <label>Sender Email</label>
                    <input class="inp code-in" id="smtpFrom" value="<?= htmlspecialchars($integrationsConfig['smtp']['from'] ?? 'info@amaanullah.com') ?>">
                </div>
            </div>

            <!-- Send Live Test Email Box -->
            <div style="background:rgba(255,255,255,0.02); border:1px solid var(--line); border-radius:12px; padding:14px; margin-top:10px;">
                <label style="font-weight:700; font-size:12.5px; display:flex; align-items:center; gap:6px; margin-bottom:6px;"><svg class="i" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Send Live Test Email</label>
                <div style="display:flex; gap:10px;">
                    <input class="inp code-in" id="smtpTestRecipient" value="<?= htmlspecialchars($integrationsConfig['alerts']['alert_email'] ?? 'akamaanullah@gmail.com') ?>" placeholder="recipient@example.com" style="flex:1;">
                    <button class="btn sm o" type="button" id="btnSendTestEmail">Send Test Email</button>
                </div>
            </div>
        </div>

        <!-- 5. Email Alerts & Notifications Form -->
        <div id="intBox_alerts" class="int-subform" style="display:none;">
            <div class="fld">
                <label>Primary Alert Recipient Email</label>
                <input class="inp code-in" id="alertsEmail" value="<?= htmlspecialchars($integrationsConfig['alerts']['alert_email'] ?? 'info@amaanullah.com') ?>">
                <span class="hint">Where instant notifications for leads, live chat requests, and contact forms are dispatched.</span>
            </div>
            <div class="toggle-card">
                <div class="toggle-info">
                    <div class="toggle-title">New Chat Lead Alerts</div>
                    <div class="toggle-desc">Instant notification whenever a chatbot visitor submits their project proposal.</div>
                </div>
                <label class="sw"><input type="checkbox" id="alertsNotifyLeads" checked><i></i></label>
            </div>
            <div class="toggle-card">
                <div class="toggle-info">
                    <div class="toggle-title">Urgent Live Chat Takeover Alerts</div>
                    <div class="toggle-desc">Emergency high-priority notification when a visitor requests to talk live right now.</div>
                </div>
                <label class="sw"><input type="checkbox" id="alertsNotifyHuman" checked><i></i></label>
            </div>
            <div class="toggle-card">
                <div class="toggle-info">
                    <div class="toggle-title">Contact Form Message Alerts</div>
                    <div class="toggle-desc">Forward contact form submissions directly to your inbox.</div>
                </div>
                <label class="sw"><input type="checkbox" id="alertsNotifyMessages" checked><i></i></label>
            </div>
        </div>

        <!-- 6. Cloudflare Workers AI Form -->
        <div id="intBox_cloudflare" class="int-subform" style="display:none;">
            <div class="fld">
                <label>Cloudflare Account ID</label>
                <input class="inp code-in" id="cfAccountId" value="<?= htmlspecialchars($integrationsConfig['cloudflare']['account_id'] ?? '9f63cf53ac893a6a5f2725278f7f86d3') ?>">
            </div>
            <div class="fld">
                <label>Cloudflare API Token</label>
                <input class="inp code-in" type="password" id="cfApiToken" value="<?= htmlspecialchars($integrationsConfig['cloudflare']['api_token'] ?? '') ?>" placeholder="Leave blank to keep unchanged">
                <span class="hint">Workers AI permissions required.</span>
            </div>
            <div class="fld">
                <label>AI Model Identifier</label>
                <input class="inp code-in" id="cfModel" value="<?= htmlspecialchars($integrationsConfig['cloudflare']['model'] ?? '@cf/meta/llama-3.1-8b-instruct-fast') ?>">
            </div>
            <div style="margin-top:14px;">
                <button class="btn o sm" type="button" id="btnTestCfAi" style="display:inline-flex; align-items:center; gap:6px;"><svg class="i" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Test Cloudflare AI Model</button>
            </div>
        </div>

        <!-- Shared Status Box inside Modal -->
        <div id="intModalStatus" style="display:none; margin-top:14px; padding:12px; border-radius:10px; font-size:12.5px; font-weight:600;"></div>

        <!-- Modal Footer Actions -->
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:22px; border-top:1px solid var(--line); padding-top:16px;">
            <button class="btn sm btn-close-modal" type="button" data-target="integrationModal" style="background:var(--card2); border:1px solid var(--line);">Cancel</button>
            <button class="btn o sm" type="button" id="btnSaveIntegration">Save &amp; Update Integration</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const CSRF_TOKEN = '<?= csrf_token() ?>';

    // Tab switching
    const tabBtns = document.querySelectorAll('.vtabs button');
    const panes = document.querySelectorAll('.pane[data-pane="set"]');
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('on'));
            panes.forEach(p => p.classList.remove('on'));
            btn.classList.add('on');
            const targetId = btn.getAttribute('data-tab');
            const targetPane = document.getElementById(targetId);
            if (targetPane) targetPane.classList.add('on');
        });
    });

    // Modal Close handler
    document.querySelectorAll('.btn-close-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-target');
            const m = document.getElementById(target);
            if (m) m.style.display = 'none';
        });
    });

    // ==========================================
    // INTEGRATION MANAGEMENT SYSTEM
    // ==========================================
    let currentIntType = '';
    const modalInt = document.getElementById('integrationModal');
    const modalIntTitle = document.getElementById('modalIntTitle');
    const modalIntSub = document.getElementById('modalIntSub');
    const modalIntStatus = document.getElementById('intModalStatus');
    const btnSaveIntegration = document.getElementById('btnSaveIntegration');

    const ICON_OK = '<svg class="i" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><polyline points="20 6 9 17 4 12"/></svg>';
    const ICON_ERR = '<svg class="i" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
    const ICON_BOLT = '<svg class="i" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>';

    function setStatusNotice(targetEl, success, message) {
        targetEl.style.display = 'flex';
        targetEl.style.alignItems = 'center';
        targetEl.style.gap = '8px';
        if (success) {
            targetEl.style.background = 'rgba(16, 185, 129, 0.15)';
            targetEl.style.color = '#10b981';
            targetEl.innerHTML = ICON_OK + '<span>' + (message || '') + '</span>';
        } else {
            targetEl.style.background = 'rgba(239, 68, 68, 0.15)';
            targetEl.style.color = '#ef4444';
            targetEl.innerHTML = ICON_ERR + '<span>' + (message || '') + '</span>';
        }
    }

    const intTitles = {
        gsc: { title: 'Google Search Console Configuration', sub: 'Manage verified site URL and service account credentials' },
        pagespeed: { title: 'Google PageSpeed Insights Settings', sub: 'Configure API key and audit targets' },
        whatsapp: { title: 'WhatsApp Direct Configuration', sub: 'Update phone number and routing rules' },
        smtp: { title: 'SMTP / Mail Server Configuration', sub: 'Configure mail host, port, credentials and test live dispatch' },
        alerts: { title: 'Email Alerts & Notification Triggers', sub: 'Manage notification recipients and event toggles' },
        cloudflare: { title: 'Cloudflare Workers AI Configuration', sub: 'Configure Account ID, API token, and LLM model' }
    };

    document.querySelectorAll('.btn-open-integration').forEach(btn => {
        btn.addEventListener('click', () => {
            const type = btn.getAttribute('data-int');
            currentIntType = type;
            modalIntStatus.style.display = 'none';

            // Hide all subforms
            document.querySelectorAll('.int-subform').forEach(el => el.style.display = 'none');

            // Show selected subform
            const targetBox = document.getElementById('intBox_' + type);
            if (targetBox) targetBox.style.display = 'block';

            const info = intTitles[type] || { title: 'Manage Integration', sub: '' };
            modalIntTitle.textContent = info.title;
            modalIntSub.textContent = info.sub;

            modalInt.style.display = 'grid';
        });
    });

    // Save Integration Settings
    btnSaveIntegration.addEventListener('click', async () => {
        btnSaveIntegration.disabled = true;
        btnSaveIntegration.innerHTML = 'Saving configuration...';
        modalIntStatus.style.display = 'none';

        let payload = {};
        if (currentIntType === 'gsc') {
            payload = {
                site_url: document.getElementById('gscSiteUrl').value,
                key_json: document.getElementById('gscKeyJson').value
            };
        } else if (currentIntType === 'pagespeed') {
            payload = {
                api_key: document.getElementById('psApiKey').value,
                audit_url: document.getElementById('psAuditUrl').value
            };
        } else if (currentIntType === 'whatsapp') {
            payload = {
                phone: document.getElementById('waPhone').value
            };
        } else if (currentIntType === 'smtp') {
            payload = {
                host: document.getElementById('smtpHost').value,
                port: document.getElementById('smtpPort').value,
                encryption: document.getElementById('smtpEncryption').value,
                user: document.getElementById('smtpUser').value,
                pass: document.getElementById('smtpPass').value,
                from: document.getElementById('smtpFrom').value,
                from_name: document.getElementById('smtpFromName').value
            };
        } else if (currentIntType === 'alerts') {
            payload = {
                alert_email: document.getElementById('alertsEmail').value
            };
        } else if (currentIntType === 'cloudflare') {
            payload = {
                account_id: document.getElementById('cfAccountId').value,
                api_token: document.getElementById('cfApiToken').value,
                model: document.getElementById('cfModel').value
            };
        }

        try {
            const res = await fetch('<?= base_url('/admin/settings/integration/save') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ type: currentIntType, data: payload })
            });
            const data = await res.json();
            modalIntStatus.style.display = 'block';
            if (data.success) {
                setStatusNotice(modalIntStatus, true, data.message);
            } else {
                setStatusNotice(modalIntStatus, false, data.error || 'Failed to save settings.');
            }
        } catch (e) {
            setStatusNotice(modalIntStatus, false, 'Network error during save.');
        } finally {
            btnSaveIntegration.disabled = false;
            btnSaveIntegration.innerHTML = 'Save &amp; Update Integration';
        }
    });

    // Test SMTP Button
    const btnSendTestEmail = document.getElementById('btnSendTestEmail');
    if (btnSendTestEmail) {
        btnSendTestEmail.addEventListener('click', async () => {
            const to = document.getElementById('smtpTestRecipient').value.trim();
            if (!to) {
                alert('Please enter a recipient email.');
                return;
            }
            btnSendTestEmail.disabled = true;
            btnSendTestEmail.innerHTML = 'Sending...';
            modalIntStatus.style.display = 'block';
            modalIntStatus.style.background = 'rgba(255, 255, 255, 0.05)';
            modalIntStatus.style.color = 'var(--mut)';
            modalIntStatus.textContent = 'Connecting to SMTP host and sending test email...';

            try {
                const res = await fetch('<?= base_url('/admin/settings/integration/test-smtp') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ to_email: to })
                });
                const data = await res.json();
                if (data.success) {
                    setStatusNotice(modalIntStatus, true, data.message);
                } else {
                    setStatusNotice(modalIntStatus, false, 'SMTP Error: ' + (data.error || 'Failed to send test email.'));
                }
            } catch (e) {
                setStatusNotice(modalIntStatus, false, 'Network error testing SMTP.');
            } finally {
                btnSendTestEmail.disabled = false;
                btnSendTestEmail.innerHTML = 'Send Test Email';
            }
        });
    }

    // Test GSC Button
    const btnTestGsc = document.getElementById('btnTestGsc');
    if (btnTestGsc) {
        btnTestGsc.addEventListener('click', async () => {
            btnTestGsc.disabled = true;
            btnTestGsc.innerHTML = 'Testing GSC API...';
            modalIntStatus.style.display = 'block';
            modalIntStatus.style.background = 'rgba(255, 255, 255, 0.05)';
            modalIntStatus.style.color = 'var(--mut)';
            modalIntStatus.textContent = 'Authenticating with Google Search Console API...';

            try {
                const res = await fetch('<?= base_url('/admin/settings/integration/test-gsc') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                const data = await res.json();
                if (data.success) {
                    setStatusNotice(modalIntStatus, true, data.message);
                } else {
                    setStatusNotice(modalIntStatus, false, data.error || 'GSC test failed.');
                }
            } catch (e) {
                setStatusNotice(modalIntStatus, false, 'Network error testing GSC.');
            } finally {
                btnTestGsc.disabled = false;
                btnTestGsc.innerHTML = ICON_BOLT + ' Test GSC Connection';
            }
        });
    }

    // Test PageSpeed Button
    const btnTestPageSpeed = document.getElementById('btnTestPageSpeed');
    if (btnTestPageSpeed) {
        btnTestPageSpeed.addEventListener('click', async () => {
            btnTestPageSpeed.disabled = true;
            btnTestPageSpeed.innerHTML = 'Auditing...';
            modalIntStatus.style.display = 'block';
            modalIntStatus.style.background = 'rgba(255, 255, 255, 0.05)';
            modalIntStatus.style.color = 'var(--mut)';
            modalIntStatus.textContent = 'Querying Google PageSpeed Insights API...';

            try {
                const res = await fetch('<?= base_url('/admin/settings/integration/test-pagespeed') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                const data = await res.json();
                if (data.success) {
                    setStatusNotice(modalIntStatus, true, data.message);
                } else {
                    setStatusNotice(modalIntStatus, false, data.error || 'PageSpeed test failed.');
                }
            } catch (e) {
                setStatusNotice(modalIntStatus, false, 'Network error testing PageSpeed.');
            } finally {
                btnTestPageSpeed.disabled = false;
                btnTestPageSpeed.innerHTML = ICON_BOLT + ' Run Test Audit';
            }
        });
    }

    // Test Cloudflare in modal
    const btnTestCfAi = document.getElementById('btnTestCfAi');
    if (btnTestCfAi) {
        btnTestCfAi.addEventListener('click', async () => {
            btnTestCfAi.disabled = true;
            btnTestCfAi.innerHTML = 'Calling Cloudflare...';
            modalIntStatus.style.display = 'block';
            modalIntStatus.style.background = 'rgba(255, 255, 255, 0.05)';
            modalIntStatus.style.color = 'var(--mut)';
            modalIntStatus.textContent = 'Running test inference with Llama 3.1...';

            try {
                const res = await fetch('<?= base_url('/admin/settings/test-chatbot') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                const data = await res.json();
                if (data.success) {
                    setStatusNotice(modalIntStatus, true, `Connected in ${data.latency}! Response: "${data.reply}"`);
                } else {
                    setStatusNotice(modalIntStatus, false, 'Cloudflare AI connection failed.');
                }
            } catch (e) {
                setStatusNotice(modalIntStatus, false, 'Network error testing Cloudflare.');
            } finally {
                btnTestCfAi.disabled = false;
                btnTestCfAi.innerHTML = ICON_BOLT + ' Test Cloudflare AI Model';
            }
        });
    }

    // ==========================================
    // FILE MANAGER & EDITOR
    // ==========================================
    let currentActiveFile = 'robots.txt';
    const coreFilesList = ['robots.txt', 'sitemap.xml', 'llms.txt', 'llms-full.txt', 'security.txt', 'humans.txt'];
    const editorTitle = document.getElementById('editorActiveTitle');
    const editorLink = document.getElementById('editorActiveLink');
    const editorMeta = document.getElementById('editorMetaInfo');
    const editorTextarea = document.getElementById('fileEditorTextarea');
    const editorStatus = document.getElementById('fileEditorStatus');
    const btnSaveFile = document.getElementById('btnSaveFile');
    const btnDeleteCustom = document.getElementById('btnDeleteCustomFile');

    async function loadFileContent(filename) {
        currentActiveFile = filename;
        editorTitle.textContent = filename;
        editorLink.href = '<?= base_url() ?>/' + filename;
        editorMeta.textContent = 'Loading...';
        editorStatus.textContent = '';
        editorTextarea.disabled = true;

        if (coreFilesList.includes(filename)) {
            btnDeleteCustom.style.display = 'none';
        } else {
            btnDeleteCustom.style.display = 'inline-block';
        }

        try {
            const res = await fetch('<?= base_url('/admin/settings/file?file=') ?>' + encodeURIComponent(filename));
            const data = await res.json();
            if (data.success) {
                editorTextarea.value = data.content;
                editorMeta.textContent = `${data.size_formatted} · ${data.lines} lines · Last updated: ${data.updated_at}`;
            } else {
                editorTextarea.value = '';
                editorMeta.textContent = data.error || 'Failed to load file.';
            }
        } catch (e) {
            editorMeta.textContent = 'Network error while fetching file.';
        } finally {
            editorTextarea.disabled = false;
        }
    }

    // Bind click to file cards
    const cardsGrid = document.getElementById('fileCardsGrid');
    cardsGrid.addEventListener('click', (e) => {
        const card = e.target.closest('.file-card');
        if (!card) return;
        document.querySelectorAll('.file-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        const fn = card.getAttribute('data-filename');
        loadFileContent(fn);
    });

    // Initial load of robots.txt
    loadFileContent('robots.txt');

    // Save File Button
    btnSaveFile.addEventListener('click', async () => {
        btnSaveFile.disabled = true;
        btnSaveFile.innerHTML = 'Saving...';
        editorStatus.style.color = 'var(--mut)';
        editorStatus.textContent = 'Writing to disk...';

        try {
            const res = await fetch('<?= base_url('/admin/settings/file/save') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({
                    file: currentActiveFile,
                    content: editorTextarea.value
                })
            });
            const data = await res.json();
            if (data.success) {
                editorStatus.style.display = 'inline-flex';
                editorStatus.style.alignItems = 'center';
                editorStatus.style.gap = '6px';
                editorStatus.style.color = '#10b981';
                editorStatus.innerHTML = ICON_OK + `<span>Saved! (${data.size_formatted})</span>`;
                editorMeta.textContent = `${data.size_formatted} · Updated just now`;
            } else {
                editorStatus.style.display = 'inline-flex';
                editorStatus.style.alignItems = 'center';
                editorStatus.style.gap = '6px';
                editorStatus.style.color = '#ef4444';
                editorStatus.innerHTML = ICON_ERR + '<span>' + (data.error || 'Save failed.') + '</span>';
            }
        } catch (e) {
            editorStatus.style.display = 'inline-flex';
            editorStatus.style.alignItems = 'center';
            editorStatus.style.gap = '6px';
            editorStatus.style.color = '#ef4444';
            editorStatus.innerHTML = ICON_ERR + '<span>Network error during save.</span>';
        } finally {
            btnSaveFile.disabled = false;
            btnSaveFile.innerHTML = '<svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Save file changes';
        }
    });

    // Delete Custom File
    btnDeleteCustom.addEventListener('click', async () => {
        if (!confirm(`Are you sure you want to delete '${currentActiveFile}'?`)) return;
        try {
            const res = await fetch('<?= base_url('/admin/settings/file/delete') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ filename: currentActiveFile })
            });
            const data = await res.json();
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.error || 'Delete failed.');
            }
        } catch (e) {
            alert('Error deleting file.');
        }
    });

    // Regenerate Sitemap Action
    const btnGenSitemap = document.getElementById('btnGenSitemap');
    btnGenSitemap.addEventListener('click', async () => {
        btnGenSitemap.disabled = true;
        btnGenSitemap.innerHTML = 'Regenerating sitemap...';
        try {
            const res = await fetch('<?= base_url('/admin/settings/file/generate-sitemap') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            const data = await res.json();
            if (data.success) {
                alert(data.message);
                if (currentActiveFile === 'sitemap.xml') {
                    loadFileContent('sitemap.xml');
                }
            } else {
                alert(data.error || 'Failed to regenerate sitemap.');
            }
        } catch (e) {
            alert('Network error while generating sitemap.');
        } finally {
            btnGenSitemap.disabled = false;
            btnGenSitemap.innerHTML = '<svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 2v6h-6M3 12a9 9 0 0 1 15-6.7L21 8M3 22v-6h6M21 12a9 9 0 0 1-15 6.7L3 16"/></svg> Regenerate sitemap.xml';
        }
    });

    // Regenerate LLMs Full Context
    const btnGenLlms = document.getElementById('btnGenLlms');
    btnGenLlms.addEventListener('click', async () => {
        btnGenLlms.disabled = true;
        btnGenLlms.innerHTML = 'Regenerating LLMs...';
        try {
            const res = await fetch('<?= base_url('/admin/settings/file/generate-llms') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            const data = await res.json();
            if (data.success) {
                alert(data.message);
                if (currentActiveFile === 'llms-full.txt') {
                    loadFileContent('llms-full.txt');
                }
            } else {
                alert(data.error || 'Failed to regenerate LLMs context.');
            }
        } catch (e) {
            alert('Network error while generating LLMs context.');
        } finally {
            btnGenLlms.disabled = false;
            btnGenLlms.innerHTML = '<svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Regenerate llms-full.txt';
        }
    });

    // Modal Add Custom File
    const modalFile = document.getElementById('newFileModal');
    const btnOpenModal = document.getElementById('btnOpenNewFileModal');
    const btnSubmitModal = document.getElementById('btnSubmitNewFile');
    const inputFn = document.getElementById('newFilenameInput');
    const inputContent = document.getElementById('newFileContentInput');

    btnOpenModal.addEventListener('click', () => {
        modalFile.style.display = 'grid';
        inputFn.value = '';
        inputContent.value = '';
        inputFn.focus();
    });

    btnSubmitModal.addEventListener('click', async () => {
        const fn = inputFn.value.trim();
        const cnt = inputContent.value;
        if (!fn) {
            alert('Please enter a valid filename.');
            return;
        }
        btnSubmitModal.disabled = true;
        btnSubmitModal.innerHTML = 'Creating...';
        try {
            const res = await fetch('<?= base_url('/admin/settings/file/create') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ filename: fn, content: cnt })
            });
            const data = await res.json();
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.error || 'Creation failed.');
            }
        } catch (e) {
            alert('Network error while creating file.');
        } finally {
            btnSubmitModal.disabled = false;
            btnSubmitModal.innerHTML = 'Create &amp; Save File';
        }
    });

    // ==========================================
    // CHATBOT TAB TEST CONNECTION
    // ==========================================
    const btnTest = document.getElementById('btnTestChatbot');
    const resSpan = document.getElementById('testChatbotResult');
    const resBox = document.getElementById('testChatbotBox');

    if (btnTest) {
        btnTest.addEventListener('click', async () => {
            btnTest.disabled = true;
            btnTest.innerHTML = 'Testing connection...';
            resSpan.style.color = 'var(--text-muted)';
            resSpan.textContent = 'Calling Cloudflare Workers AI Llama 3.1...';
            resBox.style.display = 'none';

            try {
                const res = await fetch('<?= base_url('/admin/settings/test-chatbot') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                const data = await res.json();
                if (data.success) {
                    resSpan.style.display = 'inline-flex';
                    resSpan.style.alignItems = 'center';
                    resSpan.style.gap = '6px';
                    resSpan.style.color = '#10b981';
                    resSpan.innerHTML = ICON_OK + `<span>Connected! Response received in ${data.latency}</span>`;
                    resBox.style.display = 'block';
                    resBox.innerHTML = `<strong>AI Assistant Response:</strong><br><p style="margin-top:6px; color:#cbd5e1;">${data.reply.replace(/\n/g, '<br>')}</p>`;
                } else {
                    resSpan.style.display = 'inline-flex';
                    resSpan.style.alignItems = 'center';
                    resSpan.style.gap = '6px';
                    resSpan.style.color = '#ef4444';
                    resSpan.innerHTML = ICON_ERR + '<span>Connection failed.</span>';
                }
            } catch (e) {
                resSpan.style.display = 'inline-flex';
                resSpan.style.alignItems = 'center';
                resSpan.style.gap = '6px';
                resSpan.style.color = '#ef4444';
                resSpan.innerHTML = ICON_ERR + '<span>Network error during test.</span>';
            } finally {
                btnTest.disabled = false;
                btnTest.innerHTML = '<svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M13 2L3 14h9l-1 8 10-12h-9z"/></svg> Test connection';
            }
        });
    }
});
</script>
