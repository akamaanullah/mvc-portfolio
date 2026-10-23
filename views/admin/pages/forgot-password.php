<?php /* Admin · Forgot password — static UI. Replace demo data with controller vars (see @dynamic comments). */ ?>
<div class="auth"><div class="art"><img src="<?= asset_url('images/logo.png') ?>" alt="Amaanullah" style="height:42px;width:auto">
<div><h2>Run your portfolio like a <em>product</em>.</h2><p style="color:#a3a3b0;margin:14px 0 26px;max-width:420px">Articles, projects, chat leads, live chat and analytics in one place.</p>
<div class="orb"><div><b>CMS</b><small>Block editor</small></div><div><b>Leads</b><small>Chatbot CRM</small></div><div><b>Stats</b><small>Per-page views</small></div></div></div>
<small style="color:#7c7c8a">© Amaanullah Khan · Admin</small></div>
<div class="frm"><div class="box"><div class="row sb2"><img src="<?= asset_url('logo-v2/ak-mark.svg') ?>" alt="AK" width="46" height="46"><button class="ib" data-theme-ic type="button" aria-label="Toggle theme"></button></div>
<h1>Forgot password?</h1><p class="mut" style="margin-bottom:24px">Enter your admin email and we’ll send a secure reset link.</p><form data-validate data-msg="Reset link sent (demo, no email was sent)" action="#" method="post"><!-- @dynamic: route('admin.password.email') @csrf -->
<div class="fld"><label for="em">Email</label><input class="inp" id="em" type="email" required placeholder="admin@your-domain.com"><span class="err">Enter a valid email address.</span></div>
<button class="btn o" type="submit" style="width:100%;height:46px"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4z"/></svg> Send reset link</button></form>
<p style="margin-top:18px;text-align:center"><a href="<?= base_url('/admin/login') ?>" style="color:var(--o);font-weight:700">← Back to sign in</a></p></div></div></div>
