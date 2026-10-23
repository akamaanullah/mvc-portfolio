<?php /* Admin · Sign in — Secure Backend Auth */ ?>
<div class="auth">
  <div class="art">
    <img src="<?= asset_url('images/logo.png') ?>" alt="Amaanullah" style="height:42px;width:auto">
    <div>
      <h2>Run your portfolio like a <em>product</em>.</h2>
      <p style="color:#a3a3b0;margin:14px 0 26px;max-width:420px">Articles, projects, chat leads, live chat and analytics in one place.</p>
      <div class="orb">
        <div><b>CMS</b><small>Block editor</small></div>
        <div><b>Leads</b><small>Chatbot CRM</small></div>
        <div><b>Stats</b><small>Per-page views</small></div>
      </div>
    </div>
    <small style="color:#7c7c8a">© Amaanullah Khan · Admin</small>
  </div>
  <div class="frm">
    <div class="box">
      <div class="row sb2">
        <img src="<?= asset_url('logo-v2/ak-mark.svg') ?>" alt="AK" width="46" height="46">
        <button class="ib" data-theme-ic type="button" aria-label="Toggle theme"></button>
      </div>
      <h1>Welcome back</h1>
      <p class="mut" style="margin-bottom:20px">Sign in to manage your site, leads and analytics.</p>

      <?php if (!empty($authError)): ?>
        <div id="authAlert" style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.3);color:#ef4444;border-radius:10px;padding:12px 14px;font-size:13px;font-weight:600;margin-bottom:18px;display:flex;align-items:center;gap:8px">
          <svg style="width:16px;height:16px;flex-shrink:0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <span id="authAlertMsg"><?= e($authError) ?></span>
        </div>
      <?php else: ?>
        <div id="authAlert" style="display:none;background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.3);color:#ef4444;border-radius:10px;padding:12px 14px;font-size:13px;font-weight:600;margin-bottom:18px;align-items:center;gap:8px">
          <svg style="width:16px;height:16px;flex-shrink:0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <span id="authAlertMsg"></span>
        </div>
      <?php endif; ?>

      <form id="loginForm" action="<?= base_url('/admin/login') ?>" method="post">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
        <div class="fld">
          <label for="em">Email</label>
          <input class="inp" id="em" name="email" type="email" required placeholder="admin@amaanullah.com" autocomplete="username">
          <span class="err">Enter a valid email address.</span>
        </div>
        <div class="fld">
          <label for="pw">Password <a href="<?= base_url('/admin/forgot-password') ?>" style="color:var(--o);font-weight:600">Forgot?</a></label>
          <input class="inp" id="pw" name="password" type="password" required minlength="6" placeholder="••••••••" autocomplete="current-password">
          <span class="err">Password must be at least 6 characters.</span>
        </div>
        <label class="row" style="margin:4px 0 18px;font-weight:600">
          <input type="checkbox" name="remember" class="chk" checked> Keep me signed in
        </label>
        <button id="submitBtn" class="btn o" type="submit" style="width:100%;height:46px">
          <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Sign in
        </button>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var form = document.getElementById('loginForm');
  var alertBox = document.getElementById('authAlert');
  var alertMsg = document.getElementById('authAlertMsg');
  var btn = document.getElementById('submitBtn');

  if (!form) return;

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    if (alertBox) alertBox.style.display = 'none';

    var email = form.email.value.trim();
    var pass = form.password.value;
    if (!email || !pass) {
      if (alertBox) {
        alertMsg.textContent = 'Please enter both email and password.';
        alertBox.style.display = 'flex';
      }
      return;
    }

    var originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span style="display:inline-block;animation:spin 1s linear infinite">⏳</span> Signing in…';

    var fd = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: fd
    })
    .then(function(res) {
      return res.json().then(function(data) {
        return { status: res.status, ok: res.ok, data: data };
      });
    })
    .then(function(res) {
      if (res.ok && res.data.success) {
        if (typeof window.toast === 'function') {
          window.toast('Signed in successfully!', 'ok');
        }
        window.location.href = res.data.redirect || '<?= base_url('/admin') ?>';
      } else {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
        var err = (res.data && res.data.error) ? res.data.error : 'Invalid email or password.';
        if (alertBox) {
          alertMsg.textContent = err;
          alertBox.style.display = 'flex';
        }
        if (typeof window.toast === 'function') {
          window.toast(err, 'bad');
        }
      }
    })
    .catch(function() {
      // Fallback to standard submission if network or JSON parse fails
      form.submit();
    });
  });
});
</script>
