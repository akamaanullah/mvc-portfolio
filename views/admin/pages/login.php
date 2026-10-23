<?php /* Admin · Sign in — High-End Glassmorphic UI */ ?>
<div class="auth-wrapper">
  <!-- Left Column: Brand & Technology Showcase -->
  <aside class="auth-showcase">
    <div class="showcase-glow" aria-hidden="true"></div>
    <div class="showcase-grid-pattern" aria-hidden="true"></div>

    <div class="showcase-content">
      <!-- Top Brand Header -->
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

      <!-- Center Showcase Hero -->
      <div class="showcase-hero">
        <div class="hero-chip">
          <span class="chip-spark">✦</span>
          <span>ADMIN COMMAND CENTER</span>
        </div>
        <h1 class="hero-title">
          Run your portfolio like an <em>enterprise product</em>.
        </h1>
        <p class="hero-desc">
          Unified administration for visual block content, live client inquiries, real-time messaging, and deep search console analytics.
        </p>

        <!-- Glassmorphic Overview Widget -->
        <div class="stats-overview-widget">
          <div class="widget-head">
            <div class="widget-dots">
              <span class="dot-red"></span>
              <span class="dot-yellow"></span>
              <span class="dot-green"></span>
            </div>
            <span class="widget-caption">Command Overview · v2.4</span>
            <span class="widget-badge-live">● Live</span>
          </div>
          <div class="widget-metrics">
            <div class="metric-card">
              <span class="metric-val">18.4k</span>
              <span class="metric-lbl">Page Views</span>
              <span class="metric-badge up">▲ +12.4%</span>
            </div>
            <div class="metric-card">
              <span class="metric-val">64</span>
              <span class="metric-lbl">Active Leads</span>
              <span class="metric-badge up">▲ Live</span>
            </div>
            <div class="metric-card">
              <span class="metric-val">99.9%</span>
              <span class="metric-lbl">Core Uptime</span>
              <span class="metric-badge ok">✓ Nominal</span>
            </div>
          </div>
          <div class="widget-chips">
            <span class="feature-chip">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><path d="M14 3v6h6M8 13h8M8 17h5"/></svg>
              Visual Block CMS
            </span>
            <span class="feature-chip">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              CRM Lead Pipeline
            </span>
            <span class="feature-chip">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 0 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 0 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 0 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 0 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/></svg>
              SEO Diagnostics
            </span>
          </div>
        </div>
      </div>

      <!-- Bottom Showcase Footer -->
      <footer class="showcase-footer">
        <span>© <?= date('Y') ?> Amaanullah Khan · All Rights Reserved</span>
        <span class="security-badge">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          256-Bit Encrypted Admin Session
        </span>
      </footer>
    </div>
  </aside>

  <!-- Right Column: Authentication Card Panel -->
  <main class="auth-form-side">
    <div class="auth-card">
      <div class="card-top-bar">
        <div class="card-brand-badge">
          <img src="<?= asset_url('logo-v2/ak-mark.svg') ?>" alt="AK" width="44" height="44">
        </div>
        <button class="theme-toggle-btn" data-theme-ic type="button" aria-label="Toggle light or dark theme" title="Toggle theme"></button>
      </div>

      <div class="card-title-group">
        <h2 class="card-heading">Welcome back</h2>
        <p class="card-caption">Sign in to manage your site, leads, and analytics.</p>
      </div>

      <!-- Flash Alert -->
      <div id="authAlert" class="auth-alert <?= !empty($authError) ? 'show' : '' ?>">
        <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span id="authAlertMsg"><?= e($authError ?? '') ?></span>
      </div>

      <!-- Login Form -->
      <form id="loginForm" action="<?= base_url('/admin/login') ?>" method="post" autocomplete="on">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

        <div class="form-group">
          <label class="form-label" for="loginEmail">Email Address</label>
          <div class="input-container">
            <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <input class="modern-input" id="loginEmail" name="email" type="email" required placeholder="admin@amaanullah.com" autocomplete="username" spellcheck="false">
          </div>
        </div>

        <div class="form-group">
          <div class="label-split-row">
            <label class="form-label" for="loginPassword">Password</label>
            <a href="<?= base_url('/admin/forgot-password') ?>" class="forgot-link">Forgot password?</a>
          </div>
          <div class="input-container">
            <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <input class="modern-input" id="loginPassword" name="password" type="password" required minlength="6" placeholder="••••••••••••" autocomplete="current-password">
            <button type="button" class="pwd-toggle-btn" id="togglePasswordBtn" aria-label="Toggle password visibility">
              <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
        </div>

        <div class="form-options">
          <label class="remember-label">
            <input type="checkbox" name="remember" class="native-chk" checked>
            <span class="custom-checkbox">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span class="chk-caption">Keep me signed in</span>
          </label>
        </div>

        <button id="submitBtn" class="submit-login-btn" type="submit">
          <span class="btn-shine"></span>
          <span class="btn-content">
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <span>Sign In</span>
          </span>
        </button>
      </form>

      <div class="card-footer-nav">
        <a href="<?= base_url('/') ?>" class="back-home-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
          <span>Back to portfolio</span>
        </a>
      </div>
    </div>
  </main>
</div>

<style>
/* =====================================================================
   Sign-in Page Stylesheet — Luxury Glassmorphism & Pixel-Perfect Layout
   ===================================================================== */
:root {
  --auth-orange: #f26a1b;
  --auth-orange-light: #ff8a3d;
  --auth-orange-glow: rgba(242, 106, 27, 0.4);
  --auth-orange-soft: rgba(242, 106, 27, 0.12);
  --auth-grad: linear-gradient(135deg, #f26a1b 0%, #ff8a3d 100%);
}

html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

.auth-wrapper {
  height: 100vh;
  min-height: 100vh;
  max-height: 100vh;
  display: grid;
  grid-template-columns: 1.15fr 1fr;
  background: #0c0d14;
  overflow: hidden;
  font-family: var(--font, 'Plus Jakarta Sans', system-ui, sans-serif);
  color-scheme: dark;
}

/* -------------------------------------------------------------
   Left Column: Showcase
   ------------------------------------------------------------- */
.auth-showcase {
  position: relative;
  height: 100vh;
  max-height: 100vh;
  background: #0b0c13;
  color: #f4ebe1;
  border-right: 1px solid rgba(255, 255, 255, 0.06);
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

/* Background atmospheric glow & grid — strictly non-interactive and out of flow */
.showcase-glow {
  position: absolute !important;
  top: -120px;
  right: -120px;
  width: 560px;
  height: 560px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(242, 106, 27, 0.38) 0%, rgba(255, 138, 61, 0.12) 40%, transparent 70%);
  filter: blur(55px);
  pointer-events: none;
  z-index: 1;
}

.showcase-grid-pattern {
  position: absolute !important;
  inset: 0;
  background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
  background-size: 28px 28px;
  opacity: 0.5;
  pointer-events: none;
  z-index: 1;
}

/* Inner content container */
.showcase-content {
  position: relative;
  z-index: 2;
  height: 100%;
  padding: clamp(24px, 4vh, 48px) clamp(28px, 4.5vw, 56px);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-sizing: border-box;
  overflow-y: auto;
}

/* Header */
.showcase-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  flex-shrink: 0;
}

.brand-badge-link {
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none;
  color: inherit;
  transition: opacity 0.2s;
}

.brand-badge-link:hover {
  opacity: 0.9;
}

.brand-avatar {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  box-shadow: 0 4px 14px rgba(242, 106, 27, 0.35);
  flex-shrink: 0;
}

.brand-meta {
  display: flex;
  flex-direction: column;
}

.brand-title {
  font-size: 16px;
  font-weight: 800;
  letter-spacing: -0.01em;
  color: #fff;
  line-height: 1.2;
}

.brand-subtitle {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.14em;
  color: #8f909e;
  margin-top: 2px;
}

.live-status-pill {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(34, 197, 94, 0.1);
  border: 1px solid rgba(34, 197, 94, 0.25);
  padding: 5px 12px;
  border-radius: 99px;
  font-size: 11.5px;
  font-weight: 600;
  color: #4ade80;
  white-space: nowrap;
}

.status-pulse-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #22c55e;
  box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.25);
}

/* Hero */
.showcase-hero {
  margin: auto 0;
  padding: 16px 0;
  max-width: 540px;
}

.hero-chip {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(242, 106, 27, 0.12);
  border: 1px solid rgba(242, 106, 27, 0.3);
  color: #ff9a4a;
  padding: 4px 12px;
  border-radius: 99px;
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 0.08em;
  margin-bottom: 16px;
}

.chip-spark {
  color: var(--auth-orange);
}

.hero-title {
  font-size: clamp(26px, 2.8vw, 38px);
  font-weight: 800;
  line-height: 1.18;
  letter-spacing: -0.02em;
  color: #f4ebe1;
  margin: 0 0 12px;
}

.hero-title em {
  font-style: normal;
  background: var(--auth-grad);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}

.hero-desc {
  font-size: clamp(13px, 1.2vw, 15px);
  line-height: 1.6;
  color: #9da0b0;
  margin: 0 0 clamp(18px, 2.5vh, 28px);
  max-width: 480px;
}

/* Overview Widget */
.stats-overview-widget {
  background: rgba(20, 21, 31, 0.7);
  border: 1px solid rgba(255, 255, 255, 0.09);
  border-radius: 18px;
  padding: 18px;
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.06);
}

.widget-head {
  display: flex;
  align-items: center;
  margin-bottom: 14px;
  padding-bottom: 12px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.widget-dots {
  display: flex;
  gap: 5px;
}

.widget-dots span {
  width: 9px;
  height: 9px;
  border-radius: 50%;
  display: inline-block;
}

.dot-red { background: #ef4444; }
.dot-yellow { background: #f59e0b; }
.dot-green { background: #10b981; }

.widget-caption {
  font-size: 11.5px;
  font-weight: 600;
  color: #8f909e;
  margin-left: 12px;
  font-family: var(--mono, monospace);
}

.widget-badge-live {
  margin-left: auto;
  font-size: 10.5px;
  font-weight: 700;
  color: var(--auth-orange);
  background: rgba(242, 106, 27, 0.15);
  padding: 2px 7px;
  border-radius: 5px;
}

.widget-metrics {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
  margin-bottom: 12px;
}

.metric-card {
  background: rgba(255, 255, 255, 0.03);
  border: 1px solid rgba(255, 255, 255, 0.06);
  border-radius: 12px;
  padding: 10px 12px;
  display: flex;
  flex-direction: column;
}

.metric-val {
  font-size: clamp(17px, 1.8vw, 21px);
  font-weight: 800;
  color: #fff;
  letter-spacing: -0.02em;
  line-height: 1.1;
}

.metric-lbl {
  font-size: 10.5px;
  color: #8b8c99;
  font-weight: 600;
  margin: 3px 0;
}

.metric-badge {
  font-size: 9.5px;
  font-weight: 700;
}

.metric-badge.up { color: #22c55e; }
.metric-badge.ok { color: #38bdf8; }

.widget-chips {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}

.feature-chip {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.07);
  border-radius: 6px;
  padding: 4px 9px;
  font-size: 11px;
  font-weight: 600;
  color: #c9cdd4;
}

.feature-chip svg {
  color: #ff9a4a;
}

/* Footer */
.showcase-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 12px;
  color: #6b6d7a;
  border-top: 1px solid rgba(255, 255, 255, 0.06);
  padding-top: 18px;
  flex-shrink: 0;
}

.security-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: #8b8c99;
}

/* -------------------------------------------------------------
   Right Column: Auth Form Side
   ------------------------------------------------------------- */
.auth-form-side {
  height: 100vh;
  max-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: clamp(20px, 3vh, 36px) clamp(20px, 3vw, 40px);
  background: radial-gradient(circle at 50% 35%, rgba(242, 106, 27, 0.07) 0%, transparent 65%), #11121a;
  overflow-y: auto;
  box-sizing: border-box;
}

html[data-theme="light"] .auth-form-side {
  background: radial-gradient(circle at 50% 35%, rgba(242, 106, 27, 0.06) 0%, transparent 65%), #f8f4ee;
}

/* The Auth Card */
.auth-card {
  width: 100%;
  max-width: 420px;
  margin: auto;
  background: rgba(22, 23, 33, 0.85);
  border: 1px solid rgba(255, 255, 255, 0.09);
  border-radius: 24px;
  padding: clamp(26px, 3.5vh, 36px) clamp(24px, 3vw, 34px);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.65), inset 0 1px 0 rgba(255, 255, 255, 0.06);
  box-sizing: border-box;
  transition: transform 0.2s, box-shadow 0.2s;
}

html[data-theme="light"] .auth-card {
  background: #ffffff;
  border-color: #eadfd2;
  box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.04);
}

.card-top-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}

.card-brand-badge img {
  width: 42px;
  height: 42px;
  border-radius: 12px;
  box-shadow: 0 5px 16px rgba(242, 106, 27, 0.35);
}

.theme-toggle-btn {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  border: 1px solid rgba(255, 255, 255, 0.1);
  background: rgba(255, 255, 255, 0.05);
  color: #f4ebe1;
  display: grid;
  place-items: center;
  cursor: pointer;
  transition: all 0.2s;
}

html[data-theme="light"] .theme-toggle-btn {
  background: #fbf6ef;
  border-color: #eadfd2;
  color: #14141c;
}

.theme-toggle-btn:hover {
  border-color: var(--auth-orange);
  color: var(--auth-orange);
  transform: translateY(-2px);
}

/* Card Heading */
.card-title-group {
  margin-bottom: 22px;
}

.card-heading {
  font-size: 24px;
  font-weight: 800;
  letter-spacing: -0.02em;
  color: #f4ebe1;
  margin: 0 0 5px;
}

html[data-theme="light"] .card-heading {
  color: #14141c;
}

.card-caption {
  font-size: 13px;
  color: #8b8c99;
  margin: 0;
  line-height: 1.5;
}

html[data-theme="light"] .card-caption {
  color: #6c6d7a;
}

/* Error Alert */
.auth-alert {
  display: none;
  background: rgba(239, 68, 68, 0.12);
  border: 1px solid rgba(239, 68, 68, 0.3);
  color: #ef4444;
  border-radius: 10px;
  padding: 10px 14px;
  font-size: 12.5px;
  font-weight: 600;
  margin-bottom: 18px;
  align-items: center;
  gap: 8px;
  animation: alertFadeIn 0.2s ease-out;
}

.auth-alert.show {
  display: flex;
}

@keyframes alertFadeIn {
  from { opacity: 0; transform: translateY(-6px); }
  to { opacity: 1; transform: translateY(0); }
}

.alert-icon {
  width: 16px;
  height: 16px;
  flex-shrink: 0;
}

/* Form Controls */
.form-group {
  margin-bottom: 18px;
}

.label-split-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 7px;
}

.form-label {
  display: block;
  font-size: 12px;
  font-weight: 700;
  color: #d1d5db;
  letter-spacing: 0.01em;
  margin-bottom: 7px;
}

html[data-theme="light"] .form-label {
  color: #374151;
}

.forgot-link {
  font-size: 11.5px;
  font-weight: 700;
  color: var(--auth-orange);
  text-decoration: none;
  transition: opacity 0.2s;
}

.forgot-link:hover {
  text-decoration: underline;
  opacity: 0.85;
}

.input-container {
  position: relative;
  display: flex;
  align-items: center;
}

.field-icon {
  position: absolute;
  left: 14px;
  width: 17px;
  height: 17px;
  color: #6b6e82;
  pointer-events: none;
  transition: color 0.2s;
}

.modern-input {
  width: 100%;
  height: 46px;
  padding: 0 42px 0 40px;
  border-radius: 12px;
  border: 1.5px solid #282939;
  background: #171824;
  color: #f4ebe1;
  font-size: 13.5px;
  font-family: inherit;
  transition: all 0.2s ease;
  outline: none;
  box-sizing: border-box;
}

html[data-theme="light"] .modern-input {
  background: #fbf6ef;
  border-color: #eadfd2;
  color: #14141c;
}

.modern-input:focus {
  border-color: var(--auth-orange);
  box-shadow: 0 0 0 4px rgba(242, 106, 27, 0.18);
  background: #1c1d2c;
}

html[data-theme="light"] .modern-input:focus {
  background: #ffffff;
  border-color: var(--auth-orange);
}

.modern-input:focus + .field-icon,
.input-container:focus-within .field-icon {
  color: var(--auth-orange);
}

.pwd-toggle-btn {
  position: absolute;
  right: 10px;
  width: 30px;
  height: 30px;
  display: grid;
  place-items: center;
  background: transparent;
  border: none;
  color: #6b6e82;
  cursor: pointer;
  border-radius: 6px;
  padding: 0;
  transition: color 0.2s;
}

.pwd-toggle-btn:hover {
  color: #f4ebe1;
}

html[data-theme="light"] .pwd-toggle-btn:hover {
  color: #14141c;
}

.pwd-toggle-btn svg {
  width: 17px;
  height: 17px;
}

/* Checkbox */
.form-options {
  margin: 14px 0 20px;
}

.remember-label {
  display: inline-flex;
  align-items: center;
  gap: 9px;
  cursor: pointer;
  user-select: none;
}

.native-chk {
  position: absolute;
  opacity: 0;
  pointer-events: none;
}

.custom-checkbox {
  width: 18px;
  height: 18px;
  border-radius: 5px;
  border: 1.5px solid #333549;
  background: #181926;
  display: grid;
  place-items: center;
  transition: all 0.15s;
  flex-shrink: 0;
}

html[data-theme="light"] .custom-checkbox {
  background: #fbf6ef;
  border-color: #d4c8b8;
}

.custom-checkbox svg {
  width: 11px;
  height: 11px;
  color: #fff;
  opacity: 0;
  transform: scale(0.6);
  transition: all 0.15s;
}

.native-chk:checked + .custom-checkbox {
  background: var(--auth-orange);
  border-color: var(--auth-orange);
  box-shadow: 0 2px 8px rgba(242, 106, 27, 0.4);
}

.native-chk:checked + .custom-checkbox svg {
  opacity: 1;
  transform: scale(1);
}

.chk-caption {
  font-size: 12.5px;
  font-weight: 600;
  color: #d1d5db;
}

html[data-theme="light"] .chk-caption {
  color: #374151;
}

/* Submit Button */
.submit-login-btn {
  width: 100%;
  height: 48px;
  border-radius: 12px;
  border: none;
  background: var(--auth-grad);
  color: #fff;
  font-size: 14.5px;
  font-weight: 700;
  letter-spacing: 0.01em;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  box-shadow: 0 8px 22px -3px rgba(242, 106, 27, 0.5);
  transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
}

.submit-login-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 28px -3px rgba(242, 106, 27, 0.65);
}

.submit-login-btn:active {
  transform: translateY(0);
}

.submit-login-btn:disabled {
  opacity: 0.75;
  cursor: not-allowed;
  transform: none;
}

.btn-content {
  position: relative;
  z-index: 2;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-icon {
  width: 17px;
  height: 17px;
}

/* Back Link */
.card-footer-nav {
  margin-top: 20px;
  padding-top: 16px;
  border-top: 1px solid rgba(255, 255, 255, 0.06);
  text-align: center;
}

html[data-theme="light"] .card-footer-nav {
  border-top-color: #eadfd2;
}

.back-home-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 12.5px;
  font-weight: 600;
  color: #8b8c99;
  text-decoration: none;
  transition: color 0.2s;
}

.back-home-link:hover {
  color: var(--auth-orange);
}

.back-home-link svg {
  width: 13px;
  height: 13px;
  transition: transform 0.2s;
}

.back-home-link:hover svg {
  transform: translateX(-3px);
}

/* -------------------------------------------------------------
   Responsive Breakpoints
   ------------------------------------------------------------- */
@media (max-width: 1080px) {
  .auth-wrapper {
    grid-template-columns: 1fr;
    height: auto;
    min-height: 100vh;
    max-height: none;
    overflow-y: auto;
  }
  .auth-showcase {
    display: none;
  }
  .auth-form-side {
    height: auto;
    min-height: 100vh;
    max-height: none;
    padding: 36px 20px;
  }
  .auth-card {
    padding: 32px 24px;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Password Visibility Toggle
  var passInput = document.getElementById('loginPassword');
  var toggleBtn = document.getElementById('togglePasswordBtn');
  var eyeIcon = document.getElementById('eyeIcon');

  if (toggleBtn && passInput && eyeIcon) {
    toggleBtn.addEventListener('click', function() {
      var isPass = passInput.type === 'password';
      passInput.type = isPass ? 'text' : 'password';
      if (isPass) {
        eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
      } else {
        eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
      }
    });
  }

  // Smooth AJAX Submission with Loading State
  var form = document.getElementById('loginForm');
  var alertBox = document.getElementById('authAlert');
  var alertMsg = document.getElementById('authAlertMsg');
  var submitBtn = document.getElementById('submitBtn');

  if (!form) return;

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    if (alertBox) alertBox.classList.remove('show');

    var email = form.email.value.trim();
    var pass = form.password.value;
    if (!email || !pass) {
      if (alertBox && alertMsg) {
        alertMsg.textContent = 'Please enter both your email and password.';
        alertBox.classList.add('show');
      }
      return;
    }

    var originalBtnContent = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="btn-content"><span style="display:inline-block;animation:spin 1s linear infinite">⏳</span> Authenticating…</span>';

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
        submitBtn.innerHTML = '<span class="btn-content">✓ Verified! Entering dashboard…</span>';
        if (typeof window.toast === 'function') {
          window.toast('Signed in successfully!', 'ok');
        }
        setTimeout(function() {
          window.location.href = res.data.redirect || '<?= base_url('/admin') ?>';
        }, 350);
      } else {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnContent;
        var errMsg = (res.data && res.data.error) ? res.data.error : 'Invalid email or password.';
        if (alertBox && alertMsg) {
          alertMsg.textContent = errMsg;
          alertBox.classList.add('show');
        }
        if (typeof window.toast === 'function') {
          window.toast(errMsg, 'bad');
        }
      }
    })
    .catch(function() {
      // In case of unexpected network interruption, fall back to native submission
      form.submit();
    });
  });
});
</script>
