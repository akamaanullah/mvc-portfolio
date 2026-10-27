<?php
/* Shared site header. $active = Home|Services|Projects|About|Articles|Contact. */
?><script>
window.__BASE_URL = '<?= rtrim(base_url(), '/') ?>';
window.__SITE_SETTINGS = {
    botName: <?= json_encode((string) setting('chatbot_name', '')) ?>,
    welcomeMsg: <?= json_encode((string) setting('chatbot_welcome', '')) ?>,
    phone: <?= json_encode((string) setting('phone_number', '')) ?>,
    whatsapp: <?= json_encode((string) setting('whatsapp_url', '')) ?>,
    showMobile: <?= json_encode((bool) setting('chatbot_show_mobile', 1)) ?>
};
</script><?php
if (!empty($home)): ?><nav class="rev" style="animation-delay:.05s">
 <div class="logo"><a href="<?= base_url('/') ?>" aria-label="Amaanullah — home"><img class="hlogo" src="<?= asset_url('images/logo.png') ?>" alt="Amaanullah" width="1722" height="444" decoding="async"></a></div>
 <div class="links"><a class="on" href="<?= base_url('/') ?>">Home</a><a href="<?= base_url('/services') ?>">Services</a><a href="<?= base_url('/projects') ?>">Projects</a><a href="<?= base_url('/about') ?>">About</a><a href="<?= base_url('/articles') ?>">Articles</a><a href="<?= base_url('/contact') ?>">Contact</a></div>
 <div class="acts"><button class="ib" id="snd" title="Sound"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5 6 9H2v6h4l5 4z"/><path d="M15.5 8.5a5 5 0 0 1 0 7M19 5a10 10 0 0 1 0 14"/></svg></button>
 <button class="ib" id="dm" title="Dark mode"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg></button>
 <a class="talk" href="<?= base_url('/contact') ?>" style="text-decoration:none">Let's Talk <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a></div>
</nav><?php else: ?><div id="akh"><nav class="aknav rev" style="animation-delay:.05s">
 <a class="logo" href="<?= base_url('/') ?>" aria-label="Amaanullah — home" style="text-decoration:none;color:inherit"><img class="hlogo" src="<?= asset_url('images/logo.png') ?>" alt="Amaanullah" width="1722" height="444" decoding="async"></a>
 <div class="links"><a<?= ($active ?? '')==='Home' ? ' class="on"' : '' ?> href="<?= base_url('/') ?>">Home</a><a<?= ($active ?? '')==='Services' ? ' class="on"' : '' ?> href="<?= base_url('/services') ?>">Services</a><a<?= ($active ?? '')==='Projects' ? ' class="on"' : '' ?> href="<?= base_url('/projects') ?>">Projects</a><a<?= ($active ?? '')==='About' ? ' class="on"' : '' ?> href="<?= base_url('/about') ?>">About</a><a<?= ($active ?? '')==='Articles' ? ' class="on"' : '' ?> href="<?= base_url('/articles') ?>">Articles</a><a<?= ($active ?? '')==='Contact' ? ' class="on"' : '' ?> href="<?= base_url('/contact') ?>">Contact</a></div>
 <div class="acts"><button class="ib" id="snd" title="Sound"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5 6 9H2v6h4l5 4z"/><path d="M15.5 8.5a5 5 0 0 1 0 7M19 5a10 10 0 0 1 0 14"/></svg></button>
 <button class="ib" id="dm" title="Dark mode"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg></button>
 <a class="talk" href="<?= base_url('/contact') ?>" style="text-decoration:none">Let's Talk <svg class="btn-arr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a></div>
</nav></div><?php endif; ?>