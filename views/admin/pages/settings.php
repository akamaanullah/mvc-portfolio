<?php
/**
 * Admin · Settings — 100% Dynamic Site, SEO, Chatbot & Integrations.
 */
$settings = $settings ?? [];
$integrations = $integrations ?? [];
?>

<form action="<?= base_url('/admin/settings/save') ?>" method="POST" id="settingsForm">
<input type="hidden" name="_token" value="<?= csrf_token() ?>">

<div class="ph-h">
    <div>
        <div class="crumbs">Admin / System</div>
        <h1>Settings</h1>
        <p>Site, SEO, AI Chatbot engine, and API integrations.</p>
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
                <div class="chk-row">Default theme: dark <label class="sw"><input type="checkbox" checked><i></i></label></div>
            </div>
        </section>

        <!-- TAB 2: SEO -->
        <section class="card pane" id="sS" data-pane="set">
            <div class="bd2">
                <div class="sec-t">SEO defaults</div>
                <p class="sec-d">Fallbacks when a page has no own values.</p>
                <div class="fld">
                    <label>Title template</label>
                    <input class="inp code-in" name="meta_default_title" value="<?= htmlspecialchars($settings['meta_default_title'] ?? 'Amaanullah Khan — Web Developer & Software Solutions') ?>">
                </div>
                <div class="fld">
                    <label for="dmd">Default meta description</label>
                    <textarea class="inp" id="dmd" name="meta_default_desc" rows="3"><?= htmlspecialchars($settings['meta_default_desc'] ?? 'PHP & Laravel developer in Karachi building custom CRM, SaaS and automation systems.') ?></textarea>
                </div>
                <div class="fld">
                    <label>robots.txt</label>
                    <textarea class="inp code-in" name="robots_txt" rows="4"><?= htmlspecialchars($settings['robots_txt'] ?? "User-agent: *\nDisallow: /admin\nSitemap: https://amaanullah.com/sitemap.xml") ?></textarea>
                </div>
                <div class="chk-row">Auto-generate sitemap on publish <label class="sw"><input type="checkbox" checked><i></i></label></div>
                <div class="chk-row">Person + WebSite schema on all pages <label class="sw"><input type="checkbox" checked><i></i></label></div>
            </div>
        </section>

        <!-- TAB 3: CHATBOT -->
        <section class="card pane" id="sC" data-pane="set">
            <div class="bd2">
                <div class="sec-t">Chatbot &amp; AI Engine</div>
                <p class="sec-d">Connected to Cloudflare Workers AI with live real-time human takeover.</p>
                
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
                            <option selected>Visitor asks for a human</option>
                            <option>Immediate quote request</option>
                        </select>
                    </div>
                </div>
                <div class="chk-row">Capture leads (ask for email) <label class="sw"><input type="checkbox" name="chatbot_capture_leads" value="1" checked><i></i></label></div>
                <div class="chk-row">Notify me on “needs human” <label class="sw"><input type="checkbox" name="chatbot_notify_needs_human" value="1" checked><i></i></label></div>
                <div class="chk-row">Show on mobile <label class="sw"><input type="checkbox" name="chatbot_show_mobile" value="1" checked><i></i></label></div>

                <div style="margin-top:16px; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                    <button class="btn o" type="button" id="btnTestChatbot">
                        <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M13 2L3 14h9l-1 8 10-12h-9z"/></svg> 
                        Test connection
                    </button>
                    <span id="testChatbotResult" style="font-size:0.88rem; font-weight:600;"></span>
                </div>
                <div id="testChatbotBox" style="display:none; margin-top:14px; padding:14px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:10px; font-size:0.85rem;"></div>
            </div>
        </section>

        <!-- TAB 4: INTEGRATIONS -->
        <section class="pane" id="sI" data-pane="set">
            <div class="grid g2">
                <?php foreach ($integrations as $key => $int): ?>
                    <div class="card" style="padding:18px;">
                        <div class="row sb2">
                            <b><?= htmlspecialchars($int['title']) ?></b>
                            <span class="pill good" style="font-size:11px;">● <?= htmlspecialchars($int['badge']) ?></span>
                        </div>
                        <p class="mut sm" style="margin:8px 0 14px;"><?= htmlspecialchars($int['desc']) ?></p>
                        <a class="btn sm o" href="<?= htmlspecialchars($int['link']) ?>" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                            Manage Integration →
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- TAB 5: USERS & ROLES -->
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

<script>
document.addEventListener('DOMContentLoaded', () => {
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

    // Test Chatbot Button
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
                        'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    resSpan.style.color = '#10b981';
                    resSpan.textContent = `✅ Connected! Response received in ${data.latency}`;
                    resBox.style.display = 'block';
                    resBox.innerHTML = `<strong>AI Assistant Response:</strong><br><p style="margin-top:6px; color:#cbd5e1;">${data.reply.replace(/\n/g, '<br>')}</p>`;
                } else {
                    resSpan.style.color = '#ef4444';
                    resSpan.textContent = '❌ Connection failed.';
                }
            } catch (e) {
                resSpan.style.color = '#ef4444';
                resSpan.textContent = '❌ Network error during test.';
            } finally {
                btnTest.disabled = false;
                btnTest.innerHTML = '<svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M13 2L3 14h9l-1 8 10-12h-9z"/></svg> Test connection';
            }
        });
    }
});
</script>
