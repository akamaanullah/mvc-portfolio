<?php /* Admin · Forgot Password — High-End Glassmorphic UI */ ?>
<div class="auth-wrapper">
  <!-- Left Column: Brand & Technology Showcase -->
  <aside class="auth-showcase">
    <div class="showcase-glow" aria-hidden="true"></div>
    <div class="showcase-grid-pattern" aria-hidden="true"></div>

    <div class="showcase-content">
      <header class="showcase-header">
        <a href="<?= base_url('/') ?>" class="brand-badge-link" title="Return to public portfolio">
          <img src="<?= asset_url('logo-v2/ak-mark.svg') ?>" alt="AK" width="40" height="40" class="brand-avatar">
          <div class="brand-meta">
            <span class="brand-title">Amaanullah Khan</span>
            <span class="brand-subtitle">PORTFOLIO &amp; SYSTEM SUITE</span>
          </div>
        </a>
        <div class="live-status-pill">
          <span class="status-pulse-dot"></span>
          <span class="status-text">Systems Operational</span>
        </div>
      </header>

      <div class="showcase-hero">
        <div class="hero-chip">
          <span class="chip-spark">✦</span>
          <span>ACCOUNT RECOVERY</span>
        </div>
        <h1 class="hero-title">
          Recover your <em>admin access</em> securely.
        </h1>
        <p class="hero-desc">
          Enter your registered administrator email address. We will verify your account and dispatch a cryptographic, single-use authentication token.
        </p>

        <div class="stats-overview-widget">
          <div class="widget-head">
            <div class="widget-dots">
              <span class="dot-red"></span>
              <span class="dot-yellow"></span>
              <span class="dot-green"></span>
            </div>
            <span class="widget-caption">Security Protocol · v2.4</span>
            <span class="widget-badge-live">● Protected</span>
          </div>
          <div class="widget-metrics">
            <div class="metric-card">
              <span class="metric-val">256-bit</span>
              <span class="metric-lbl">Encryption</span>
              <span class="metric-badge ok">✓ SHA-256</span>
            </div>
            <div class="metric-card">
              <span class="metric-val">15 min</span>
              <span class="metric-lbl">Token Expiry</span>
              <span class="metric-badge up">▲ Auto Revoke</span>
            </div>
            <div class="metric-card">
              <span class="metric-val">100%</span>
              <span class="metric-lbl">Audit Logged</span>
              <span class="metric-badge ok">✓ Active</span>
            </div>
          </div>
        </div>
      </div>

      <footer class="showcase-footer">
        <span>© <?= date('Y') ?> Amaanullah Khan · All Rights Reserved</span>
        <span class="security-badge">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          Encrypted Admin Session
        </span>
      </footer>
    </div>
  </aside>

  <!-- Right Column: Forgot Password Form Panel -->
  <main class="auth-form-side">
    <div class="auth-card">
      <div class="card-top-bar">
        <div class="card-brand-badge">
          <img src="<?= asset_url('logo-v2/ak-mark.svg') ?>" alt="AK" width="44" height="44">
        </div>
        <button class="theme-toggle-btn" data-theme-ic type="button" aria-label="Toggle light or dark theme" title="Toggle theme"></button>
      </div>

      <div class="card-title-group">
        <h2 class="card-heading">Forgot password?</h2>
        <p class="card-caption">Enter your verified email to receive a secure password recovery link.</p>
      </div>

      <div id="resetAlert" class="auth-alert">
        <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span id="resetAlertMsg"></span>
      </div>

      <form id="forgotForm" action="<?= base_url('/admin/forgot-password') ?>" method="post">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

        <div class="form-group">
          <label class="form-label" for="resetEmail">Admin Email</label>
          <div class="input-container">
            <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <input class="modern-input" id="resetEmail" name="email" type="email" required placeholder="admin@amaanullah.com" autocomplete="email" spellcheck="false">
          </div>
        </div>

        <button id="resetSubmitBtn" class="submit-login-btn" type="submit" style="margin-top:10px;">
          <span class="btn-shine"></span>
          <span class="btn-content">
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4z"/></svg>
            <span>Send Recovery Link</span>
          </span>
        </button>
      </form>

      <div class="card-footer-nav">
        <a href="<?= base_url('/admin/login') ?>" class="back-home-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
          <span>Return to Sign In</span>
        </a>
      </div>
    </div>
  </main>
</div>

<style>
/* Mirror login styles for seamless consistency */
:root {
  --auth-orange: #f26a1b;
  --auth-orange-light: #ff8a3d;
  --auth-orange-glow: rgba(242, 106, 27, 0.4);
  --auth-orange-soft: rgba(242, 106, 27, 0.12);
  --auth-grad: linear-gradient(135deg, #f26a1b 0%, #ff8a3d 100%);
}
html, body { height: 100%; margin: 0; padding: 0; }
.auth-wrapper { height: 100vh; min-height: 100vh; max-height: 100vh; display: grid; grid-template-columns: 1.15fr 1fr; background: #0c0d14; overflow: hidden; font-family: var(--font, 'Plus Jakarta Sans', system-ui, sans-serif); color-scheme: dark; }
.auth-showcase { position: relative; height: 100vh; max-height: 100vh; background: #0b0c13; color: #f4ebe1; border-right: 1px solid rgba(255, 255, 255, 0.06); overflow: hidden; display: flex; flex-direction: column; }
.showcase-glow { position: absolute !important; top: -120px; right: -120px; width: 560px; height: 560px; border-radius: 50%; background: radial-gradient(circle, rgba(242, 106, 27, 0.38) 0%, rgba(255, 138, 61, 0.12) 40%, transparent 70%); filter: blur(55px); pointer-events: none; z-index: 1; }
.showcase-grid-pattern { position: absolute !important; inset: 0; background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px); background-size: 28px 28px; opacity: 0.5; pointer-events: none; z-index: 1; }
.showcase-content { position: relative; z-index: 2; height: 100%; padding: clamp(24px, 4vh, 48px) clamp(28px, 4.5vw, 56px); display: flex; flex-direction: column; justify-content: space-between; box-sizing: border-box; overflow-y: auto; }
.showcase-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-shrink: 0; }
.brand-badge-link { display: flex; align-items: center; gap: 12px; text-decoration: none; color: inherit; transition: opacity 0.2s; }
.brand-avatar { width: 40px; height: 40px; border-radius: 12px; box-shadow: 0 4px 14px rgba(242, 106, 27, 0.35); flex-shrink: 0; }
.brand-meta { display: flex; flex-direction: column; }
.brand-title { font-size: 16px; font-weight: 800; letter-spacing: -0.01em; color: #fff; line-height: 1.2; }
.brand-subtitle { font-size: 10px; font-weight: 700; letter-spacing: 0.14em; color: #8f909e; margin-top: 2px; }
.live-status-pill { display: inline-flex; align-items: center; gap: 8px; background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.25); padding: 5px 12px; border-radius: 99px; font-size: 11.5px; font-weight: 600; color: #4ade80; white-space: nowrap; }
.status-pulse-dot { width: 7px; height: 7px; border-radius: 50%; background: #22c55e; box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.25); }
.showcase-hero { margin: auto 0; padding: 16px 0; max-width: 540px; }
.hero-chip { display: inline-flex; align-items: center; gap: 6px; background: rgba(242, 106, 27, 0.12); border: 1px solid rgba(242, 106, 27, 0.3); color: #ff9a4a; padding: 4px 12px; border-radius: 99px; font-size: 10.5px; font-weight: 800; letter-spacing: 0.08em; margin-bottom: 16px; }
.chip-spark { color: var(--auth-orange); }
.hero-title { font-size: clamp(26px, 2.8vw, 38px); font-weight: 800; line-height: 1.18; letter-spacing: -0.02em; color: #f4ebe1; margin: 0 0 12px; }
.hero-title em { font-style: normal; background: var(--auth-grad); -webkit-background-clip: text; background-clip: text; color: transparent; }
.hero-desc { font-size: clamp(13px, 1.2vw, 15px); line-height: 1.6; color: #9da0b0; margin: 0 0 clamp(18px, 2.5vh, 28px); max-width: 480px; }
.stats-overview-widget { background: rgba(20, 21, 31, 0.7); border: 1px solid rgba(255, 255, 255, 0.09); border-radius: 18px; padding: 18px; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.06); }
.widget-head { display: flex; align-items: center; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid rgba(255, 255, 255, 0.06); }
.widget-dots { display: flex; gap: 5px; }
.widget-dots span { width: 9px; height: 9px; border-radius: 50%; display: inline-block; }
.dot-red { background: #ef4444; } .dot-yellow { background: #f59e0b; } .dot-green { background: #10b981; }
.widget-caption { font-size: 11.5px; font-weight: 600; color: #8f909e; margin-left: 12px; font-family: var(--mono, monospace); }
.widget-badge-live { margin-left: auto; font-size: 10.5px; font-weight: 700; color: var(--auth-orange); background: rgba(242, 106, 27, 0.15); padding: 2px 7px; border-radius: 5px; }
.widget-metrics { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
.metric-card { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 10px 12px; display: flex; flex-direction: column; }
.metric-val { font-size: clamp(16px, 1.6vw, 19px); font-weight: 800; color: #fff; letter-spacing: -0.02em; line-height: 1.1; }
.metric-lbl { font-size: 10.5px; color: #8b8c99; font-weight: 600; margin: 3px 0; }
.metric-badge { font-size: 9.5px; font-weight: 700; }
.metric-badge.up { color: #22c55e; } .metric-badge.ok { color: #38bdf8; }
.showcase-footer { display: flex; align-items: center; justify-content: space-between; font-size: 12px; color: #6b6d7a; border-top: 1px solid rgba(255, 255, 255, 0.06); padding-top: 18px; flex-shrink: 0; }
.security-badge { display: inline-flex; align-items: center; gap: 6px; color: #8b8c99; }
.auth-form-side { height: 100vh; max-height: 100vh; display: flex; align-items: center; justify-content: center; padding: clamp(20px, 3vh, 36px) clamp(20px, 3vw, 40px); background: radial-gradient(circle at 50% 35%, rgba(242, 106, 27, 0.07) 0%, transparent 65%), #11121a; overflow-y: auto; box-sizing: border-box; }
html[data-theme="light"] .auth-form-side { background: radial-gradient(circle at 50% 35%, rgba(242, 106, 27, 0.06) 0%, transparent 65%), #f8f4ee; }
.auth-card { width: 100%; max-width: 420px; margin: auto; background: rgba(22, 23, 33, 0.85); border: 1px solid rgba(255, 255, 255, 0.09); border-radius: 24px; padding: clamp(26px, 3.5vh, 36px) clamp(24px, 3vw, 34px); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.65), inset 0 1px 0 rgba(255, 255, 255, 0.06); box-sizing: border-box; }
html[data-theme="light"] .auth-card { background: #ffffff; border-color: #eadfd2; box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.04); }
.card-top-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.card-brand-badge img { width: 42px; height: 42px; border-radius: 12px; box-shadow: 0 5px 16px rgba(242, 106, 27, 0.35); }
.theme-toggle-btn { width: 38px; height: 38px; border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.05); color: #f4ebe1; display: grid; place-items: center; cursor: pointer; transition: all 0.2s; }
html[data-theme="light"] .theme-toggle-btn { background: #fbf6ef; border-color: #eadfd2; color: #14141c; }
.theme-toggle-btn:hover { border-color: var(--auth-orange); color: var(--auth-orange); transform: translateY(-2px); }
.card-title-group { margin-bottom: 22px; }
.card-heading { font-size: 24px; font-weight: 800; letter-spacing: -0.02em; color: #f4ebe1; margin: 0 0 5px; }
html[data-theme="light"] .card-heading { color: #14141c; }
.card-caption { font-size: 13px; color: #8b8c99; margin: 0; line-height: 1.5; }
html[data-theme="light"] .card-caption { color: #6c6d7a; }
.auth-alert { display: none; background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; border-radius: 10px; padding: 10px 14px; font-size: 12.5px; font-weight: 600; margin-bottom: 18px; align-items: center; gap: 8px; }
.auth-alert.show { display: flex; }
.alert-icon { width: 16px; height: 16px; flex-shrink: 0; }
.form-group { margin-bottom: 18px; }
.form-label { display: block; font-size: 12px; font-weight: 700; color: #d1d5db; letter-spacing: 0.01em; margin-bottom: 7px; }
html[data-theme="light"] .form-label { color: #374151; }
.input-container { position: relative; display: flex; align-items: center; }
.field-icon { position: absolute; left: 14px; width: 17px; height: 17px; color: #6b6e82; pointer-events: none; }
.modern-input { width: 100%; height: 46px; padding: 0 16px 0 40px; border-radius: 12px; border: 1.5px solid #282939; background: #171824; color: #f4ebe1; font-size: 13.5px; font-family: inherit; transition: all 0.2s ease; outline: none; box-sizing: border-box; }
html[data-theme="light"] .modern-input { background: #fbf6ef; border-color: #eadfd2; color: #14141c; }
.modern-input:focus { border-color: var(--auth-orange); box-shadow: 0 0 0 4px rgba(242, 106, 27, 0.18); background: #1c1d2c; }
html[data-theme="light"] .modern-input:focus { background: #ffffff; border-color: var(--auth-orange); }
.modern-input:focus + .field-icon, .input-container:focus-within .field-icon { color: var(--auth-orange); }
.submit-login-btn { width: 100%; height: 48px; border-radius: 12px; border: none; background: var(--auth-grad); color: #fff; font-size: 14.5px; font-weight: 700; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 8px 22px -3px rgba(242, 106, 27, 0.5); transition: transform 0.2s, box-shadow 0.2s; }
.submit-login-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 28px -3px rgba(242, 106, 27, 0.65); }
.btn-content { display: inline-flex; align-items: center; gap: 8px; }
.btn-icon { width: 17px; height: 17px; }
.card-footer-nav { margin-top: 20px; padding-top: 16px; border-top: 1px solid rgba(255, 255, 255, 0.06); text-align: center; }
html[data-theme="light"] .card-footer-nav { border-top-color: #eadfd2; }
.back-home-link { display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 600; color: #8b8c99; text-decoration: none; transition: color 0.2s; }
.back-home-link:hover { color: var(--auth-orange); }
.back-home-link svg { width: 13px; height: 13px; }
@media (max-width: 1080px) {
  .auth-wrapper { grid-template-columns: 1fr; height: auto; min-height: 100vh; max-height: none; overflow-y: auto; }
  .auth-showcase { display: none; }
  .auth-form-side { height: auto; min-height: 100vh; max-height: none; padding: 36px 20px; }
  .auth-card { padding: 32px 24px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var form = document.getElementById('forgotForm');
  var alertBox = document.getElementById('resetAlert');
  var alertMsg = document.getElementById('resetAlertMsg');
  var submitBtn = document.getElementById('resetSubmitBtn');

  if (!form) return;

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    var email = form.email.value.trim();
    if (!email) return;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="btn-content">Dispatching link…</span>';

    setTimeout(function() {
      alertBox.style.background = 'rgba(34, 197, 94, 0.12)';
      alertBox.style.borderColor = 'rgba(34, 197, 94, 0.3)';
      alertBox.style.color = '#4ade80';
      alertMsg.textContent = 'A password recovery link has been sent to ' + email + ' (demo mode).';
      alertBox.classList.add('show');
      submitBtn.disabled = false;
      submitBtn.innerHTML = '<span class="btn-content">✓ Link Dispatched</span>';
    }, 600);
  });
});
</script>
