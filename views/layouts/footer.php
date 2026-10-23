<?php /* Shared site footer (home page design). */
if (!empty($home)): ?><footer class="foot" id="footer">
 <svg class="fwave" viewBox="0 0 1440 120" preserveAspectRatio="none"><defs><linearGradient id="gFw" x1="0" x2="1"><stop offset="0" stop-color="#f26a1b" stop-opacity=".1"/><stop offset=".5" stop-color="#ff8a3d"/><stop offset="1" stop-color="#f26a1b" stop-opacity=".1"/></linearGradient></defs>
  <path d="M0,70 C180,20 360,110 560,60 C760,10 900,90 1100,50 C1250,22 1360,40 1440,60 V120 H0Z" fill="#14151d"/>
  <path d="M0,70 C180,20 360,110 560,60 C760,10 900,90 1100,50 C1250,22 1360,40 1440,60" fill="none" stroke="url(#gFw)" stroke-width="2.5" style="filter:drop-shadow(0 0 6px #ff6a1a)"/></svg>
 <div class="fbody"><div class="fin">
  <button class="btt" id="btt" aria-label="Back to top">↑</button>
  <div class="fcols">
   <div><div class="logo"><img class="hlogo" src="<?= asset_url('images/logo.png') ?>" alt="Amaanullah" width="1722" height="444" decoding="async"></div>
    <p class="fabout">Custom web apps, CRMs, chat platforms, automation and mobile apps, built to be secure, fast and scalable.</p></div>
   <div class="fcol"><h5>Quick Links</h5><a href="#home">Home</a><a href="<?= base_url('/about') ?>">About</a><a href="<?= base_url('/services') ?>">Services</a><a href="<?= base_url('/projects') ?>">Projects</a><a href="<?= base_url('/articles') ?>">Articles</a><a href="#reviews">Reviews</a><a href="<?= base_url('/contact') ?>">Contact</a></div>
   <div class="fcol"><h5>Services</h5><!-- URL: each service page (only CRM has a detail page so far) -->
    <a href="<?= base_url('/services/custom-crm-development') ?>">Custom CRM Development</a><a href="<?= base_url('/services') ?>">AI Automation Services</a><a href="<?= base_url('/services') ?>">Web App &amp; CMS Development</a><a href="<?= base_url('/services') ?>">SaaS Application Development</a><a href="<?= base_url('/services') ?>">Mobile App Development</a><a href="<?= base_url('/services') ?>">Performance Tuning</a></div>
   <div class="fcol"><h5>Projects</h5><a href="<?= base_url('/projects') ?>">All Projects</a><a href="<?= base_url('/projects/category/web-applications') ?>">Web Applications</a><a href="<?= base_url('/projects/category/web-design-development') ?>">Web Design &amp; Dev</a><a href="<?= base_url('/projects/category/mobile-apps') ?>">Mobile Applications</a><a href="<?= base_url('/projects/category/products') ?>">Products</a></div>
   <div class="fcol"><h5>Contact</h5><a href="tel:+923196935307">+92 319 6935307</a><a href="mailto:info@amaanullah.com">info@amaanullah.com</a><a href="<?= base_url('/contact') ?>">Send a message &rarr;</a></div>
  </div>
  <div class="wm" aria-hidden="true">LET'S BUILD</div>
  <div class="fbar"><span>© <span id="yr">2026</span> Amaanullah | Custom Software Business Solutions. All Rights Reserved.</span><span class="hand">made with ♥ &amp; clean code</span><span><a href="javascript:void(0)" style="color:inherit"><!-- URL: privacy page -->Privacy</a> · <a href="javascript:void(0)" style="color:inherit"><!-- URL: terms page -->Terms</a></span></div>
 </div></div>
</footer><?php else: ?><div id="akf"><footer class="foot" id="footer">
 <svg class="fwave" viewBox="0 0 1440 120" preserveAspectRatio="none"><defs><linearGradient id="gFw" x1="0" x2="1"><stop offset="0" stop-color="#f26a1b" stop-opacity=".1"/><stop offset=".5" stop-color="#ff8a3d"/><stop offset="1" stop-color="#f26a1b" stop-opacity=".1"/></linearGradient></defs>
  <path d="M0,70 C180,20 360,110 560,60 C760,10 900,90 1100,50 C1250,22 1360,40 1440,60 V120 H0Z" fill="#14151d"/>
  <path d="M0,70 C180,20 360,110 560,60 C760,10 900,90 1100,50 C1250,22 1360,40 1440,60" fill="none" stroke="url(#gFw)" stroke-width="2.5" style="filter:drop-shadow(0 0 6px #ff6a1a)"/></svg>
 <div class="fbody"><div class="fin">
  <button class="btt" id="btt" aria-label="Back to top">↑</button>
  <div class="fcols">
   <div><div class="logo"><img class="hlogo" src="<?= asset_url('images/logo.png') ?>" alt="Amaanullah" width="1722" height="444" decoding="async"></div>
    <p class="fabout">Custom web apps, CRMs, chat platforms, automation and mobile apps, built to be secure, fast and scalable.</p></div>
   <div class="fcol"><h5>Quick Links</h5><a href="<?= base_url('/') ?>">Home</a><a href="<?= base_url('/about') ?>">About</a><a href="<?= base_url('/services') ?>">Services</a><a href="<?= base_url('/projects') ?>">Projects</a><a href="<?= base_url('/articles') ?>">Articles</a><a href="<?= base_url('/#reviews') ?>">Reviews</a><a href="<?= base_url('/contact') ?>">Contact</a></div>
   <div class="fcol"><h5>Services</h5><!-- URL: each service page (only CRM has a detail page so far) -->
    <a href="<?= base_url('/services/custom-crm-development') ?>">Custom CRM Development</a><a href="<?= base_url('/services') ?>">AI Automation Services</a><a href="<?= base_url('/services') ?>">Web App &amp; CMS Development</a><a href="<?= base_url('/services') ?>">SaaS Application Development</a><a href="<?= base_url('/services') ?>">Mobile App Development</a><a href="<?= base_url('/services') ?>">Performance Tuning</a></div>
   <div class="fcol"><h5>Projects</h5><a href="<?= base_url('/projects') ?>">All Projects</a><a href="<?= base_url('/projects/category/web-applications') ?>">Web Applications</a><a href="<?= base_url('/projects/category/web-design-development') ?>">Web Design &amp; Dev</a><a href="<?= base_url('/projects/category/mobile-apps') ?>">Mobile Applications</a><a href="<?= base_url('/projects/category/products') ?>">Products</a></div>
   <div class="fcol"><h5>Contact</h5><a href="tel:+923196935307">+92 319 6935307</a><a href="mailto:info@amaanullah.com">info@amaanullah.com</a><a href="<?= base_url('/contact') ?>">Send a message &rarr;</a></div>
  </div>
  <div class="wm" aria-hidden="true">LET'S BUILD</div>
  <div class="fbar"><span>© <span id="yr">2026</span> Amaanullah | Custom Software Business Solutions. All Rights Reserved.</span><span class="hand">made with ♥ &amp; clean code</span><span><a href="javascript:void(0)" style="color:inherit"><!-- URL: privacy page -->Privacy</a> · <a href="javascript:void(0)" style="color:inherit"><!-- URL: terms page -->Terms</a></span></div>
 </div></div>
</footer></div><?php endif; ?>