<?php
/* Shared site header. $active = Home|Services|Projects|About|Articles|Contact. */
?>
<script>
window.__BASE_URL = '<?= base_path_url() ?>';
window.__SITE_SETTINGS = {
    botName: <?= json_encode((string) setting('chatbot_name', '')) ?>,
    welcomeMsg: <?= json_encode((string) setting('chatbot_welcome', '')) ?>,
    phone: <?= json_encode((string) setting('phone_number', '')) ?>,
    whatsapp: <?= json_encode((string) setting('whatsapp_url', '')) ?>,
    showMobile: <?= json_encode((bool) setting('chatbot_show_mobile', 1)) ?>
};
</script>
<?php
$isHome = !empty($home);
$navClass = $isHome ? 'rev' : 'aknav rev';
?>
<div id="<?= $isHome ? 'homeHeaderWrap' : 'akh' ?>">
  <nav class="<?= $navClass ?>" style="animation-delay:.05s">
    <div class="logo">
      <a href="<?= base_url('/') ?>" aria-label="Amaanullah — home" style="text-decoration:none;color:inherit">
        <img class="hlogo" src="<?= asset_url('images/logo.png') ?>" alt="Amaanullah" width="1722" height="444" decoding="async">
      </a>
    </div>

    <div class="links">
      <a class="<?= ($active ?? '') === 'Home' || ($isHome && empty($active)) ? 'on' : '' ?>" href="<?= base_url('/') ?>">Home</a>
      <a class="<?= ($active ?? '') === 'Services' ? 'on' : '' ?>" href="<?= base_url('/services') ?>">Services</a>
      <a class="<?= ($active ?? '') === 'Projects' ? 'on' : '' ?>" href="<?= base_url('/projects') ?>">Projects</a>
      <a class="<?= ($active ?? '') === 'About' ? 'on' : '' ?>" href="<?= base_url('/about') ?>">About</a>
      <a class="<?= ($active ?? '') === 'Articles' ? 'on' : '' ?>" href="<?= base_url('/articles') ?>">Articles</a>
      <a class="<?= ($active ?? '') === 'Contact' ? 'on' : '' ?>" href="<?= base_url('/contact') ?>">Contact</a>
    </div>

    <div class="acts">
      <button class="ib snd-btn" id="snd" title="Sound" aria-label="Toggle sound">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5 6 9H2v6h4l5 4z"/><path d="M15.5 8.5a5 5 0 0 1 0 7M19 5a10 10 0 0 1 0 14"/></svg>
      </button>
      <button class="ib dm-btn" id="dm" title="Dark mode" aria-label="Toggle dark mode">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
      </button>
      <a class="talk desk-talk" href="<?= base_url('/contact') ?>" style="text-decoration:none">
        Let's Talk <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
      <button class="ib mob-menu-btn" id="mobNavToggle" aria-label="Open navigation menu" aria-expanded="false">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </nav>
</div>

<!-- Mobile Navigation Drawer -->
<div class="mob-drawer" id="mobDrawer" aria-hidden="true">
  <div class="mob-backdrop" id="mobBackdrop"></div>
  <div class="mob-panel">
    <div class="mob-top">
      <a href="<?= base_url('/') ?>" class="mob-logo"><img class="hlogo" src="<?= asset_url('images/logo.png') ?>" alt="Amaanullah" width="140" height="36"></a>
      <button class="ib mob-close" id="mobNavClose" aria-label="Close menu">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="mob-links-list">
      <a class="<?= ($active ?? '') === 'Home' || ($isHome && empty($active)) ? 'act' : '' ?>" href="<?= base_url('/') ?>">
        <span class="mob-nav-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
        <span class="mob-nav-text">Home</span>
        <span class="mob-nav-arr">→</span>
      </a>
      <a class="<?= ($active ?? '') === 'Services' ? 'act' : '' ?>" href="<?= base_url('/services') ?>">
        <span class="mob-nav-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></span>
        <span class="mob-nav-text">Services</span>
        <span class="mob-nav-arr">→</span>
      </a>
      <a class="<?= ($active ?? '') === 'Projects' ? 'act' : '' ?>" href="<?= base_url('/projects') ?>">
        <span class="mob-nav-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></span>
        <span class="mob-nav-text">Projects</span>
        <span class="mob-nav-arr">→</span>
      </a>
      <a class="<?= ($active ?? '') === 'About' ? 'act' : '' ?>" href="<?= base_url('/about') ?>">
        <span class="mob-nav-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
        <span class="mob-nav-text">About</span>
        <span class="mob-nav-arr">→</span>
      </a>
      <a class="<?= ($active ?? '') === 'Articles' ? 'act' : '' ?>" href="<?= base_url('/articles') ?>">
        <span class="mob-nav-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg></span>
        <span class="mob-nav-text">Articles</span>
        <span class="mob-nav-arr">→</span>
      </a>
      <a class="<?= ($active ?? '') === 'Contact' ? 'act' : '' ?>" href="<?= base_url('/contact') ?>">
        <span class="mob-nav-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
        <span class="mob-nav-text">Contact</span>
        <span class="mob-nav-arr">→</span>
      </a>
    </div>
    <div class="mob-status">
      <span class="mob-status-dot"></span>
      <span class="mob-status-text">Available for remote projects</span>
    </div>
    <div class="mob-foot">
      <a class="mob-talk-cta" href="<?= base_url('/contact') ?>">
        <span>Let's Talk</span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div>