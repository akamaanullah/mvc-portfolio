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

  <!-- Mobile Navigation Drawer -->
  <div class="mob-drawer" id="mobDrawer" aria-hidden="true">
    <div class="mob-backdrop" id="mobBackdrop"></div>
    <div class="mob-panel">
      <div class="mob-top">
        <a href="<?= base_url('/') ?>" class="mob-logo"><img class="hlogo" src="<?= asset_url('images/logo.png') ?>" alt="Amaanullah" width="140" height="36"></a>
        <button class="ib mob-close" id="mobNavClose" aria-label="Close menu">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
      <div class="mob-links-list">
        <a class="<?= ($active ?? '') === 'Home' || ($isHome && empty($active)) ? 'act' : '' ?>" href="<?= base_url('/') ?>"><span>✦</span> Home</a>
        <a class="<?= ($active ?? '') === 'Services' ? 'act' : '' ?>" href="<?= base_url('/services') ?>"><span>✦</span> Services</a>
        <a class="<?= ($active ?? '') === 'Projects' ? 'act' : '' ?>" href="<?= base_url('/projects') ?>"><span>✦</span> Projects</a>
        <a class="<?= ($active ?? '') === 'About' ? 'act' : '' ?>" href="<?= base_url('/about') ?>"><span>✦</span> About</a>
        <a class="<?= ($active ?? '') === 'Articles' ? 'act' : '' ?>" href="<?= base_url('/articles') ?>"><span>✦</span> Articles</a>
        <a class="<?= ($active ?? '') === 'Contact' ? 'act' : '' ?>" href="<?= base_url('/contact') ?>"><span>✦</span> Contact</a>
      </div>
      <div class="mob-foot">
        <a class="talk mob-talk" href="<?= base_url('/contact') ?>" style="width:100%;text-align:center;justify-content:center;">
          Let's Talk <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </div>
</div>