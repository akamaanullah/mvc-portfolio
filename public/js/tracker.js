/*!
 * Web3D Real-time Interaction Analytics Tracker
 * Captures accurate dwell time, scroll milestones (25/50/75/90/100%), and user CTA clicks.
 * Zero external dependencies, non-blocking, passive event listeners.
 */
(function () {
  'use strict';

  if (window.__AK_TRACKER_LOADED) return;
  window.__AK_TRACKER_LOADED = true;

  // Do not track admin portal interactions
  var path = window.location.pathname || '/';
  if (path.indexOf('/admin') !== -1) return;

  // Resolve base URL dynamically
  var defaultBase = (typeof window.__BASE_URL === 'string') ? window.__BASE_URL : '';
  if (!defaultBase) {
    var m = path.match(/^(\/[^\/]+)\/(admin|api|services|projects|articles|about|contact)/);
    if (m) defaultBase = m[1];
  }
  defaultBase = defaultBase.replace(/\/$/, '');
  var endpoint = defaultBase + '/api/analytics/event';

  // Normalize path without subfolder prefix
  var currentUrl = path;
  if (defaultBase && currentUrl.indexOf(defaultBase) === 0) {
    currentUrl = currentUrl.slice(defaultBase.length) || '/';
  }

  /* ---------------- Event Queue & Transmission ---------------- */
  var queue = [];
  var flushTimer = null;

  function flushEvents() {
    if (flushTimer) {
      clearTimeout(flushTimer);
      flushTimer = null;
    }
    if (!queue.length) return;

    var payload = JSON.stringify({ events: queue });
    queue = [];

    // Attempt Beacon API first (safest for background/unload)
    if (typeof navigator.sendBeacon === 'function') {
      try {
        var blob = new Blob([payload], { type: 'application/json' });
        var sent = navigator.sendBeacon(endpoint, blob);
        if (sent) return;
      } catch (e) {}
    }

    // Modern fetch keepalive fallback
    if (typeof fetch === 'function') {
      try {
        fetch(endpoint, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: payload,
          keepalive: true,
          credentials: 'same-origin'
        }).catch(function () {});
        return;
      } catch (e) {}
    }

    // Synchronous/Asynchronous XHR fallback
    try {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', endpoint, true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.send(payload);
    } catch (e) {}
  }

  function queueEvent(type, name, value) {
    queue.push({
      url: currentUrl,
      type: type,
      name: name,
      value: typeof value === 'number' ? value : 0
    });

    if (queue.length >= 5) {
      flushEvents();
    } else if (!flushTimer) {
      flushTimer = setTimeout(flushEvents, 800);
    }
  }

  /* ---------------- 1. Active Dwell Time ---------------- */
  var activeSeconds = 0;
  var lastActiveTime = Date.now();
  var isVisible = !document.hidden;
  var dwellSent = false;

  function updateActiveDwell() {
    if (isVisible) {
      var now = Date.now();
      var diff = Math.round((now - lastActiveTime) / 1000);
      if (diff > 0 && diff < 300) {
        activeSeconds += diff;
      }
      lastActiveTime = now;
    }
  }

  function sendFinalDwell() {
    updateActiveDwell();
    if (activeSeconds > 2 && !dwellSent) {
      dwellSent = true;
      queueEvent('dwell', 'dwell_time', activeSeconds);
      flushEvents();
    }
  }

  // Track tab visibility changes
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      updateActiveDwell();
      isVisible = false;
      sendFinalDwell();
    } else {
      lastActiveTime = Date.now();
      isVisible = true;
      dwellSent = false; // reset for subsequent active periods
    }
  });

  // Page unload handlers
  window.addEventListener('pagehide', sendFinalDwell);
  window.addEventListener('beforeunload', sendFinalDwell);

  /* ---------------- 2. Scroll Depth Milestones ---------------- */
  var reached = { 25: false, 50: false, 75: false, 90: false, 100: false };
  var scrollTicking = false;

  function checkScrollDepth() {
    var winHeight = window.innerHeight || document.documentElement.clientHeight;
    var docHeight = Math.max(
      document.body.scrollHeight,
      document.documentElement.scrollHeight,
      document.body.offsetHeight,
      document.documentElement.offsetHeight
    ) - winHeight;

    var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    var pct = docHeight > 0 ? Math.round((scrollTop / docHeight) * 100) : 100;

    [25, 50, 75, 90, 100].forEach(function (m) {
      if (pct >= m && !reached[m]) {
        reached[m] = true;
        queueEvent('scroll', 'scroll_' + m, m);
      }
    });
  }

  window.addEventListener('scroll', function () {
    if (!scrollTicking) {
      window.requestAnimationFrame(function () {
        checkScrollDepth();
        scrollTicking = false;
      });
      scrollTicking = true;
    }
  }, { passive: true });

  // Initial check on load (in case page is short or starts scrolled)
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    setTimeout(checkScrollDepth, 600);
  } else {
    document.addEventListener('DOMContentLoaded', function () {
      setTimeout(checkScrollDepth, 600);
    });
  }

  /* ---------------- 3. User CTA & Interaction Clicks ---------------- */
  document.addEventListener('click', function (e) {
    var target = e.target;
    if (!target) return;

    // A. WhatsApp Link Clicks
    var waLink = target.closest('a[href*="whatsapp.com"], a[href*="wa.me"]');
    if (waLink) {
      queueEvent('click', 'whatsapp_click', 1);
      flushEvents();
      return;
    }

    // B. Chat Launcher Clicks
    var chatTrigger = target.closest('#akc, #akc-btn, .cb-launcher, [data-chat-trigger]');
    if (chatTrigger) {
      queueEvent('click', 'chat_launcher', 1);
      flushEvents();
      return;
    }

    // C. Primary CTA Buttons (Start a project, Contact)
    var ctaBtn = target.closest('.cta a, .cta .btn, .bo.pri, .sbtn, a[href*="/contact"]');
    if (ctaBtn) {
      var text = (ctaBtn.textContent || '').trim().toLowerCase();
      if (text.indexOf('start') !== -1 || text.indexOf('project') !== -1) {
        queueEvent('click', 'cta_start_project', 1);
      } else if (ctaBtn.getAttribute('href') && ctaBtn.getAttribute('href').indexOf('/contact') !== -1) {
        queueEvent('click', 'contact_click', 1);
      } else {
        queueEvent('click', 'cta_start_project', 1);
      }
      flushEvents();
      return;
    }

    // D. Project Card Clicks
    var projCard = target.closest('.pcard, .pcard a, a[href*="/projects/"]');
    if (projCard) {
      queueEvent('click', 'project_card', 1);
      flushEvents();
      return;
    }

    // E. Hero "See all projects" Link
    var heroProjects = target.closest('.hero a, a[href$="/projects"]');
    if (heroProjects) {
      queueEvent('click', 'see_all_projects', 1);
      flushEvents();
      return;
    }

    // F. Explicit data-track elements
    var trackedEl = target.closest('[data-track]');
    if (trackedEl) {
      var trackName = trackedEl.getAttribute('data-track');
      if (trackName) {
        queueEvent('click', trackName, 1);
        flushEvents();
      }
    }
  }, { passive: true });

})();
