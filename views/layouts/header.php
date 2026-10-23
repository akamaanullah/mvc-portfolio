<?php
/* Shared site header (copied from the home page). Home renders its original nav (in-page anchors);
   every other page renders the same nav linked to real routes, with $active = Home|Services|Projects|About|Reviews|Contact. */
if (!empty($home)): ?><nav class="rev" style="animation-delay:.05s">
 <div class="logo"><img class="hlogo" src="<?= asset_url('images/logo.png') ?>" alt="Amaanullah" width="1722" height="444" decoding="async"><div><small>Web Developer | Software Solutions</small></div></div>
 <div class="links"><a class="on" href="#">Home</a><a href="#">Services</a><a href="#">Projects</a><a href="#">About</a><a href="#">Reviews</a><a href="#">Contact</a></div>
 <div class="acts"><button class="ib" id="snd" title="Sound"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5 6 9H2v6h4l5 4z"/><path d="M15.5 8.5a5 5 0 0 1 0 7M19 5a10 10 0 0 1 0 14"/></svg></button>
 <button class="ib" id="dm" title="Dark mode"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg></button>
 <a class="talk" href="#contact" style="text-decoration:none">Let's Talk &nbsp;→</a></div>
</nav><?php else: ?><div id="akh"><nav class="aknav rev" style="animation-delay:.05s">
 <a class="logo" href="<?= base_url('/') ?>" aria-label="Amaanullah — home" style="text-decoration:none;color:inherit"><img class="hlogo" src="<?= asset_url('images/logo.png') ?>" alt="Amaanullah" width="1722" height="444" decoding="async"><div><small>Web Developer | Software Solutions</small></div></a>
 <div class="links"><a<?= ($active ?? '')==='Home' ? ' class="on"' : '' ?> href="<?= base_url('/') ?>">Home</a><a<?= ($active ?? '')==='Services' ? ' class="on"' : '' ?> href="<?= base_url('/services') ?>">Services</a><a<?= ($active ?? '')==='Projects' ? ' class="on"' : '' ?> href="<?= base_url('/projects') ?>">Projects</a><a<?= ($active ?? '')==='About' ? ' class="on"' : '' ?> href="<?= base_url('/about') ?>">About</a><a<?= ($active ?? '')==='Reviews' ? ' class="on"' : '' ?> href="<?= base_url('/#reviews') ?>">Reviews</a><a<?= ($active ?? '')==='Contact' ? ' class="on"' : '' ?> href="<?= base_url('/contact') ?>">Contact</a></div>
 <div class="acts"><button class="ib" id="snd" title="Sound"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5 6 9H2v6h4l5 4z"/><path d="M15.5 8.5a5 5 0 0 1 0 7M19 5a10 10 0 0 1 0 14"/></svg></button>
 <button class="ib" id="dm" title="Dark mode"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg></button>
 <a class="talk" href="<?= base_url('/contact') ?>" style="text-decoration:none">Let's Talk &nbsp;→</a></div>
</nav></div><?php endif; ?>