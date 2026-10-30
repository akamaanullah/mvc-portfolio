/*! Amaanullah AI Assistant & Real-time Live Takeover Widget
 *  Powered by Cloudflare Workers AI (Llama 3.1)
 *  Zero external dependencies, vanilla modern JavaScript.
 */
(function () {
  'use strict';
  if (window.__AK_CHATBOT_LOADED) return;
  window.__AK_CHATBOT_LOADED = true;

  // Auto-detect base path dynamically
  var path = window.location.pathname || '';
  var defaultBase = (typeof window.__BASE_URL === 'string') ? window.__BASE_URL : '';
  if (!defaultBase) {
    var m = path.match(/^(\/[^\/]+)\/(admin|api|services|projects|articles|about|contact)/);
    if (m) defaultBase = m[1];
  }
  defaultBase = defaultBase.replace(/\/$/, '');

  var CFG = Object.assign({
    endpoint: defaultBase + '/api/chat/message',
    leadEndpoint: defaultBase + '/api/chat/lead',
    initLiveEndpoint: defaultBase + '/api/chat/init-live',
    pollEndpoint: defaultBase + '/api/chat/poll',
    closeEndpoint: defaultBase + '/api/chat/close',
    botName: 'Amaanullah AI',
    whatsapp: 'https://api.whatsapp.com/send?phone=923196935307',
    poweredBy: 'Amaanullah Khan',
    poweredUrl: defaultBase + '/about',
    greetingDelay: 3500, maxChars: 500, timeout: 25000
  }, window.AK_CHATBOT_CONFIG || {});

  var SKEY = 'akc_state_v3', TKEY = 'akc_tip_dismissed';
  var CHIPS = ['Services', 'Get a quote', 'See projects', 'Book a call', 'Pricing'];

  // Purge legacy demo states
  try {
    sessionStorage.removeItem('akc_state_v1');
    sessionStorage.removeItem('akc_state_v2');
  } catch(e) {}

  // Ensure real-time analytics interaction tracker is active
  if (!window.__AK_TRACKER_LOADED && !document.querySelector('script[src*="tracker.js"]') && window.location.pathname.indexOf('/admin') === -1) {
    try {
      var ts = document.createElement('script');
      ts.src = defaultBase + '/js/tracker.js';
      ts.defer = true;
      document.head.appendChild(ts);
    } catch(e) {}
  }

  /* ---------------- API ---------------- */
  function sid() {
    var s = sessionStorage.getItem('akc_sid');
    if (!s) { s = 'akc_' + Date.now().toString(36) + Math.random().toString(36).slice(2, 8); sessionStorage.setItem('akc_sid', s); }
    return s;
  }
  function csrf() { var m = document.querySelector('meta[name="csrf-token"]'); return m ? m.content : ''; }
  function post(url, body) {
    var ctl = new AbortController(), t = setTimeout(function () { ctl.abort(); }, CFG.timeout);
    return fetch(url, {
      method: 'POST', signal: ctl.signal, credentials: 'same-origin',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf(), 'X-Requested-With': 'XMLHttpRequest' },
      body: JSON.stringify(body)
    }).then(function (r) { clearTimeout(t); if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); });
  }

  var ChatbotAPI = {
    send: function (p) {
      return post(CFG.endpoint, p).then(function (d) { return typeof d === 'string' ? { reply: d } : d; });
    },
    lead: function (p) {
      return post(CFG.leadEndpoint, p);
    },
    initLive: function (p) {
      return post(CFG.initLiveEndpoint, p);
    },
    poll: function (sessionId, lastId) {
      return fetch(CFG.pollEndpoint + '?session_id=' + encodeURIComponent(sessionId) + '&last_id=' + (lastId || 0) + '&_=' + Date.now(), {
        headers: { 'Accept': 'application/json' }
      }).then(function (r) { return r.json(); });
    }
  };
  window.ChatbotAPI = ChatbotAPI;

  /* ---------------- helpers ---------------- */
  function esc(s) { return String(s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
  function safeUrl(u) { return /^(https?:|mailto:|tel:|\/|#|[\w-]+\.html)/i.test(u) ? u : '#'; }
  function inline(s) {
    return s.replace(/`([^`]+)`/g, '<code>$1</code>')
      .replace(/\[([^\]]+)\]\(([^)\s]+)\)/g, function (_, t, u) { return '<a href="' + safeUrl(u.replace(/&amp;/g, '&')) + '" target="_blank" rel="noopener">' + t + '</a>'; })
      .replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>').replace(/(^|[^*])\*([^*]+)\*/g, '$1<em>$2</em>')
      .replace(/(^|\s)(https?:\/\/[^\s<]+)/g, '$1<a href="$2" target="_blank" rel="noopener">$2</a>');
  }
  function md(src) {
    var lines = esc(src).split('\n'), out = '', list = null;
    lines.forEach(function (l) {
      var ul = /^\s*[-•*]\s+(.*)/.exec(l), ol = /^\s*\d+[.)]\s+(.*)/.exec(l), kind = ul ? 'ul' : ol ? 'ol' : null;
      if (list && kind !== list) { out += '</' + list + '>'; list = null; }
      if (kind) { if (!list) { out += '<' + kind + '>'; list = kind; } out += '<li>' + inline((ul || ol)[1]) + '</li>'; }
      else if (l.trim()) out += '<p>' + inline(l) + '</p>';
    });
    if (list) out += '</' + list + '>';
    return out;
  }
  function time(ts) { return new Date(ts).toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' }); }
  function el(tag, cls, html) { var e = document.createElement(tag); if (cls) e.className = cls; if (html != null) e.innerHTML = html; return e; }
  var I = {
    min: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M6 12h12"/></svg>',
    x: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>',
    dots: '<svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="12" cy="19" r="2"/></svg>',
    send: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>',
    down: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#14141c" stroke-width="2.4" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>',
    trash: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/></svg>',
    human: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
    whatsapp: '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.456 5.711 1.457h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
    bolt: '<svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
    check: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>'
  };
  var eyes = function (n) { return new Array(n + 1).join('<i></i>'); };

  /* ---------------- state ---------------- */
  var S = { open: false, msgs: [], unread: true };
  try { 
    var saved = JSON.parse(sessionStorage.getItem(SKEY)); 
    if (saved && Array.isArray(saved.msgs)) {
      // Clean legacy mock text and remove duplicate consecutive/identical bubbles
      var seenIds = {}, cleaned = [];
      saved.msgs.forEach(function(m, idx) {
        if (!m || !m.text) return;
        if (m.text.indexOf('Demo mode') !== -1) return;
        if (m.mid) {
          if (seenIds[m.mid]) return;
          seenIds[m.mid] = true;
        }
        // Deduplicate identical consecutive messages within 30s
        if (cleaned.length > 0) {
          var prev = cleaned[cleaned.length - 1];
          if (prev && prev.role === m.role && prev.text === m.text && Math.abs((prev.ts || 0) - (m.ts || 0)) < 30000) {
            return;
          }
        }
        cleaned.push(m);
      });
      saved.msgs = cleaned;
      S = Object.assign(S, saved);
    } 
  } catch (e) {}
  function save() { try { sessionStorage.setItem(SKEY, JSON.stringify({ open: S.open, msgs: S.msgs.slice(-60), unread: S.unread })); } catch (e) {} }

  function computeLastLiveMsgId() {
    var max = 0;
    if (Array.isArray(S.msgs)) {
      for (var i = 0; i < S.msgs.length; i++) {
        var id = parseInt(S.msgs[i].mid, 10);
        if (!isNaN(id) && id > max) {
          max = id;
        }
      }
    }
    return max;
  }

  /* ---------------- live mode state ---------------- */
  var isLiveMode = false, livePollTimer = null, lastLiveMsgId = computeLastLiveMsgId();
  function setLiveMode(active) {
    var wasActive = isLiveMode;
    isLiveMode = active;
    var ttl = $('.akc-ttl');
    if (active) {
      if (ttl) ttl.innerHTML = '<strong>Amaanullah Khan</strong><small style="color:#ef4444; font-weight:700;"><span class="akc-live-dot"></span> Live Session Active</small>';
      if (!wasActive || !livePollTimer) {
        startLivePolling();
      }
    } else {
      if (ttl) ttl.innerHTML = '<strong>' + esc(CFG.botName) + '</strong><small>Online · Typically replies instantly</small>';
      if (livePollTimer) {
        clearInterval(livePollTimer);
        livePollTimer = null;
      }
    }
  }

  function startLivePolling() {
    if (livePollTimer) {
      clearInterval(livePollTimer);
      livePollTimer = null;
    }
    lastLiveMsgId = Math.max(lastLiveMsgId, computeLastLiveMsgId());

    livePollTimer = setInterval(function () {
      ChatbotAPI.poll(sid(), lastLiveMsgId).then(function (res) {
        if (res.status === 'active' || res.status === 'needs_human') {
          if (!isLiveMode) setLiveMode(true);
        }
        if (res.status === 'closed') {
          setLiveMode(false);
          var hasClosed = S.msgs.some(function(x) {
            return x.text && x.text.indexOf('Chat session was closed') !== -1;
          });
          if (!hasClosed) {
            var m = { mid: 'closed_' + Date.now(), role: 'bot', text: 'Chat session was closed. Feel free to message again if you need any further help!', ts: Date.now() };
            S.msgs.push(m); save(); draw(m, true); toBottom();
          }
          return;
        }
        if (res.messages && res.messages.length > 0) {
          var anyNew = false;
          res.messages.forEach(function (msg) {
            if (msg.message === '__CLOSED__') return;
            var numId = parseInt(msg.id, 10);
            if (!isNaN(numId) && numId > lastLiveMsgId) {
              lastLiveMsgId = numId;
            }

            // Deduplication: check if already in S.msgs by mid or by identical content & close timestamp
            var alreadyInState = S.msgs.some(function (x) {
              return (x.mid && x.mid === numId) || (x.role === 'bot' && x.text === msg.message && Math.abs((x.ts || 0) - (new Date(msg.created_at).getTime() || 0)) < 4000);
            });
            if (alreadyInState) return;

            // Deduplication: check if already rendered in DOM
            if (body && body.querySelector('[data-mid="' + numId + '"]')) return;

            var m = {
              mid: numId,
              role: 'bot',
              text: msg.message,
              isLiveAdmin: true,
              ts: new Date(msg.created_at).getTime() || Date.now()
            };
            S.msgs.push(m);
            draw(m, true);
            anyNew = true;
          });

          if (anyNew) {
            save();
            toBottom();
          }
        }
      }).catch(function () {});
    }, 2000);
  }

  /* ---------------- DOM ---------------- */
  var root = el('div', 'akc');
  root.innerHTML =
    '<div class="akc-tip" role="status"><button class="akc-tip-open" type="button">Hi! Need help with a project?<span>Ask me anything — I reply instantly.</span></button><button class="akc-tip-x" type="button" aria-label="Dismiss">' + I.x + '</button></div>' +
    '<section class="akc-win" role="dialog" aria-modal="true" aria-label="Chat with ' + esc(CFG.botName) + '">' +
      '<header class="akc-head"><span class="akc-grab" aria-hidden="true"></span><div class="akc-av" aria-hidden="true">' + eyes(2) + '<b></b></div>' +
        '<div class="akc-ttl"><strong>' + esc(CFG.botName) + '</strong><small>Online · Typically replies instantly</small></div>' +
        '<button class="akc-hb akc-more" type="button" aria-label="Chat options" aria-haspopup="true" aria-expanded="false">' + I.dots + '</button>' +
        '<button class="akc-hb akc-min" type="button" aria-label="Minimize chat">' + I.min + '</button>' +
        '<button class="akc-hb akc-close" type="button" aria-label="Close chat">' + I.x + '</button>' +
        '<div class="akc-menu" role="menu">' +
          '<button role="menuitem" type="button" class="akc-clear">' + I.trash + ' Clear chat</button>' +
          '<button role="menuitem" type="button" class="akc-human">' + I.human + ' Talk to a human</button>' +
          '<a role="menuitem" class="akc-wa" href="' + esc(CFG.whatsapp) + '" target="_blank" rel="noopener">' + I.whatsapp + ' Chat on WhatsApp</a>' +
        '</div>' +
      '</header>' +
      '<div class="akc-body" aria-live="polite" aria-relevant="additions" tabindex="-1"></div>' +
      '<button class="akc-down" type="button" aria-label="Scroll to latest">' + I.down + '</button>' +
      '<footer class="akc-foot"><form class="akc-comp" novalidate><label class="akc-sr" for="akc-in">Type your message</label>' +
        '<textarea id="akc-in" rows="1" placeholder="Type your message…" maxlength="' + CFG.maxChars + '"></textarea>' +
        '<button class="akc-send" type="submit" aria-label="Send message" disabled>' + I.send + '</button></form>' +
        '<div class="akc-meta"><a href="' + esc(CFG.poweredUrl) + '">' + I.bolt + ' <b>' + esc(CFG.poweredBy) + '</b></a><span class="akc-count" aria-live="polite"></span></div></footer>' +
    '</section>' +
    '<button class="akc-launch" type="button" aria-label="Open chat" aria-expanded="false"><span class="akc-orb"></span><span class="akc-face" aria-hidden="true"><i></i><i></i></span><span class="akc-x" aria-hidden="true"></span><span class="akc-dot" aria-hidden="true"></span></button>';

  var $ = function (s) { return root.querySelector(s); };
  var body, ta, sendBtn, launch, tip, win, menu, down, waiting = false;

  function mount() {
    document.body.appendChild(root);
    body = $('.akc-body'); ta = $('textarea'); sendBtn = $('.akc-send'); launch = $('.akc-launch'); tip = $('.akc-tip'); win = $('.akc-win'); menu = $('.akc-menu'); down = $('.akc-down');
    render();
    root.classList.toggle('unread', !!S.unread);
    if (S.open) setOpen(true, true);
    if (!S.open && !sessionStorage.getItem(TKEY)) setTimeout(function () { if (!S.open) tip.classList.add('show'); }, CFG.greetingDelay);

    launch.addEventListener('click', function () { setOpen(!S.open); });
    $('.akc-tip-open').addEventListener('click', function () { setOpen(true); });
    $('.akc-tip-x').addEventListener('click', function () { tip.classList.remove('show'); sessionStorage.setItem(TKEY, '1'); });
    $('.akc-close').addEventListener('click', function () { setOpen(false); });
    $('.akc-min').addEventListener('click', function () { setOpen(false); });
    $('.akc-more').addEventListener('click', function (e) { e.stopPropagation(); toggleMenu(); });
    document.addEventListener('click', function (e) { if (!menu.contains(e.target)) toggleMenu(false); });
    $('.akc-clear').addEventListener('click', function () { S.msgs = []; save(); render(); toggleMenu(false); ta.focus(); });
    $('.akc-human').addEventListener('click', function (e) {
      e.preventDefault();
      toggleMenu(false);
      var m = { role: 'bot', text: "Of course! Let's connect you directly with Amaanullah.", handoff: true, ts: Date.now() };
      S.msgs.push(m); save(); draw(m, true); toBottom();
    });
    $('form').addEventListener('submit', function (e) { e.preventDefault(); submit(); });
    ta.addEventListener('input', onInput);
    ta.addEventListener('keydown', function (e) { if (e.key === 'Enter' && !e.shiftKey && !e.isComposing) { e.preventDefault(); submit(); } });
    body.addEventListener('scroll', function () { down.classList.toggle('show', body.scrollHeight - body.scrollTop - body.clientHeight > 120); });
    down.addEventListener('click', function () { toBottom(); });
    root.addEventListener('keydown', trap);
    swipe(); keyboard();

    // Check if live session already open
    setTimeout(function () {
      ChatbotAPI.poll(sid(), lastLiveMsgId).then(function (res) {
        if (res.status === 'active' || res.status === 'needs_human') {
          setLiveMode(true);
        }
      }).catch(function () {});
    }, 600);
  }

  function setOpen(o, instant) {
    S.open = o; root.classList.toggle('open', o);
    launch.setAttribute('aria-expanded', o); launch.setAttribute('aria-label', o ? 'Close chat' : 'Open chat');
    if (o) { 
      tip.classList.remove('show'); sessionStorage.setItem(TKEY, '1'); S.unread = false; root.classList.remove('unread');
      startLivePolling();
      setTimeout(function () { toBottom(true); if (!matchMedia('(max-width:560px)').matches || !instant) ta.focus({ preventScroll: true }); }, instant ? 0 : 350);
      if (matchMedia('(max-width:560px)').matches) document.documentElement.style.overflow = 'hidden';
    } else { 
      toggleMenu(false); document.documentElement.style.overflow = ''; if (!instant) launch.focus(); 
      if (!isLiveMode && livePollTimer) { clearInterval(livePollTimer); livePollTimer = null; }
    }
    save();
  }
  function toggleMenu(f) { var s = f == null ? !menu.classList.contains('show') : f; menu.classList.toggle('show', s); $('.akc-more').setAttribute('aria-expanded', s); }
  function trap(e) {
    if (e.key === 'Escape' && S.open) { if (menu.classList.contains('show')) toggleMenu(false); else setOpen(false); return; }
    if (e.key !== 'Tab' || !S.open) return;
    var f = [].filter.call(root.querySelectorAll('.akc-win button:not([disabled]),.akc-win a[href],.akc-win textarea,.akc-win input,.akc-launch'), function (n) { return n.offsetParent !== null && !n.closest('.akc-menu:not(.show)'); });
    if (!f.length) return; var a = f[0], z = f[f.length - 1];
    if (e.shiftKey && document.activeElement === a) { e.preventDefault(); z.focus(); } else if (!e.shiftKey && document.activeElement === z) { e.preventDefault(); a.focus(); }
  }
  function onInput() {
    ta.style.height = 'auto'; ta.style.height = Math.min(ta.scrollHeight, 110) + 'px';
    var n = ta.value.length, c = $('.akc-count');
    c.textContent = n > CFG.maxChars * .7 ? n + '/' + CFG.maxChars : ''; c.classList.toggle('warn', n >= CFG.maxChars);
    sendBtn.disabled = waiting || !ta.value.trim();
  }
  function toBottom(instant) { body.style.scrollBehavior = instant ? 'auto' : ''; body.scrollTop = body.scrollHeight; body.style.scrollBehavior = ''; }

  /* ---------------- render ---------------- */
  function render() {
    body.innerHTML = '';
    if (!S.msgs.length) return welcome();
    body.appendChild(el('div', 'akc-day', 'Today'));
    S.msgs.forEach(function (m, i) { draw(m, i === S.msgs.length - 1); });
  }
  function welcome() {
    var w = el('div', 'akc-welcome', '<div class="akc-big" aria-hidden="true">' + eyes(2) + '</div><h3>Welcome!</h3><p>I\'m ' + esc(CFG.botName) + ', Amaanullah\'s AI assistant. Ask about custom CRMs, Laravel web applications, AI automation, or start your project inquiry.</p>');
    w.appendChild(chips(CHIPS, true)); body.appendChild(w);
  }
  function chips(list, center) {
    var c = el('div', 'akc-chips' + (center ? '' : ' left'));
    list.forEach(function (t, i) { var b = el('button', 'akc-chip', esc(t)); b.type = 'button'; b.style.animationDelay = i * 60 + 'ms'; b.onclick = function () { c.remove(); send(t); }; c.appendChild(b); });
    return c;
  }
  function draw(m, last) {
    if (m.mid && body && body.querySelector('[data-mid="' + m.mid + '"]')) {
      return; // Element with this mid already rendered in DOM
    }
    var row = el('div', 'akc-row ' + (m.role === 'user' ? 'user' : 'bot') + (m.error ? ' akc-err' : ''));
    if (m.mid) row.setAttribute('data-mid', m.mid);
    row.innerHTML = '<div class="akc-mini" aria-hidden="true">' + eyes(2) + '</div>';
    var col = el('div', 'akc-col');
    col.appendChild(el('div', 'akc-bub', m.role === 'user' ? esc(m.text).replace(/\n/g, '<br>') : md(m.text)));
    if (m.error) { var r = el('button', 'akc-retry', '↻ Retry'); r.type = 'button'; r.onclick = function () { S.msgs.splice(S.msgs.indexOf(m), 1); save(); render(); ask(m.retry); }; col.appendChild(r); }
    var timeLabel = (m.role === 'user' ? 'You · ' : (m.isLiveAdmin ? 'Amaanullah (Live) · ' : '')) + time(m.ts);
    col.appendChild(el('div', 'akc-time', timeLabel));
    row.appendChild(col); body.appendChild(row);

    if (m.cards && m.cards.length) {
      var cs = el('div', 'akc-cards');
      m.cards.forEach(function (c) {
        cs.appendChild(el('article', 'akc-card', '<div class="akc-card-ban"><span>' + esc(c.tag || '') + '</span></div><div class="akc-card-b"><strong>' + esc(c.title) + '</strong><p>' + esc(c.text || '') + '</p><a class="akc-btn" href="' + esc(safeUrl(c.url || '#')) + '">' + esc(c.button || 'Learn more') + ' →</a></div>'));
      });
      var wrap = el('div'); wrap.style.paddingLeft = '38px'; wrap.appendChild(cs); body.appendChild(wrap);
    }
    if (m.lead) body.appendChild(leadCard(m));
    if (m.handoff) body.appendChild(handoffCard(m));
    if (last && m.chips && m.chips.length && !m.lead && !m.handoff) body.appendChild(chips(m.chips));
  }

  function leadCard(m) {
    var f = el('form', 'akc-lead');
    if (m.leadDone) { f.classList.add('done'); f.innerHTML = '<div class="akc-ok">' + I.check + '</div><strong>Thanks, ' + esc(m.leadDone) + '!</strong><p>Your details were received. You\'ll hear back soon.</p>'; return f; }
    f.noValidate = true;
    f.innerHTML = '<strong>Get a free quote</strong><p>Takes 10 seconds. No spam.</p>' +
      '<label for="akc-ln">Name</label><input id="akc-ln" name="name" autocomplete="name" placeholder="Your name" required><div class="akc-ferr"></div>' +
      '<label for="akc-le">Email</label><input id="akc-le" name="email" type="email" autocomplete="email" placeholder="you@company.com" required><div class="akc-ferr"></div>' +
      '<button class="akc-btn o" type="submit">Send my details</button>';
    f.onsubmit = function (e) {
      e.preventDefault();
      var n = f.name.value.trim(), em = f.email.value.trim(), ok = true, errs = f.querySelectorAll('.akc-ferr');
      [[f.name, !n, 'Please enter your name', 0], [f.email, !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em), 'Please enter a valid email', 1]].forEach(function (x) {
        x[0].setAttribute('aria-invalid', x[1]); errs[x[3]].textContent = x[1] ? x[2] : ''; if (x[1] && ok) { ok = false; x[0].focus(); } });
      if (!ok) return;
      var b = f.querySelector('button'); b.disabled = true; b.textContent = 'Sending…';
      var transcript = S.msgs.slice(-10).map(function(x){ return (x.role === 'user' ? 'User: ' : 'AI: ') + x.text; }).join('\n');
      ChatbotAPI.lead({ name: n, email: em, session_id: sid(), requirement: 'Lead from chatbot', transcript: transcript }).then(function () {
        m.leadDone = n.split(' ')[0]; save(); var nf = leadCard(m); f.replaceWith(nf);
      }).catch(function () { b.disabled = false; b.textContent = 'Try again'; errs[1].textContent = 'Couldn\'t send. Please retry.'; });
    };
    return f;
  }

  function handoffCard(m) {
    var f = el('form', 'akc-lead akc-handoff-form');
    if (m.handoffDone) {
      f.classList.add('done');
      f.innerHTML = '<div class="akc-ok" style="background:#fee2e2; color:#ef4444;"><span class="akc-live-dot" style="margin:0; width:10px; height:10px;"></span></div><strong>Connecting live...</strong><p>Amaanullah has been notified. You can message directly here.</p>';
      return f;
    }
    f.noValidate = true;
    f.innerHTML = '<strong>Talk Live with Amaanullah</strong><p>Enter your contact details so we can alert him:</p>' +
      '<label for="akc-hn">Your Name</label><input id="akc-hn" name="name" autocomplete="name" placeholder="Your name" required><div class="akc-ferr"></div>' +
      '<label for="akc-he">Email or Phone</label><input id="akc-he" name="email" placeholder="you@company.com" required><div class="akc-ferr"></div>' +
      '<button class="akc-btn o" type="submit" style="background:linear-gradient(135deg, #f26a1b, #ff8a3d); color:#fff; border:none; padding:10px 16px; border-radius:10px; font-weight:700; cursor:pointer; width:100%; margin-top:8px;">Connect Me Now →</button>';
    f.onsubmit = function (e) {
      e.preventDefault();
      var n = f.name.value.trim(), em = f.email.value.trim(), errs = f.querySelectorAll('.akc-ferr');
      if (!n || !em) {
        if (!n) errs[0].textContent = 'Please enter your name';
        if (!em) errs[1].textContent = 'Please enter your email or phone';
        return;
      }
      var b = f.querySelector('button');
      b.disabled = true; b.textContent = 'Connecting...';
      var ctx = S.msgs.slice(-6).map(function(x){ return (x.role === 'user' ? 'User: ' : 'Bot: ') + x.text; }).join('\n');
      ChatbotAPI.initLive({ name: n, email: em, session_id: sid(), context: ctx }).then(function () {
        m.handoffDone = true;
        save();
        setLiveMode(true);
        var nf = handoffCard(m);
        f.replaceWith(nf);
      }).catch(function () {
        b.disabled = false; b.textContent = 'Try again';
        errs[1].textContent = 'Connection failed. Please retry or contact via WhatsApp.';
      });
    };
    return f;
  }

  /* ---------------- flow ---------------- */
  function submit() { var v = ta.value.trim().slice(0, CFG.maxChars); if (!v || waiting) return; ta.value = ''; onInput(); send(v); }
  function send(text) {
    var m = { mid: 'u_' + Date.now() + '_' + Math.floor(Math.random() * 1000), role: 'user', text: text, ts: Date.now() };
    S.msgs.push(m); save();
    if (body.querySelector('.akc-welcome')) render(); else { body.querySelectorAll('.akc-chips.left').forEach(function (c) { c.remove(); }); draw(m); }
    toBottom(); ask(text);
  }
  function ask(text) {
    waiting = true; onInput(); ta.setAttribute('aria-busy', 'true');
    var t = el('div', 'akc-row bot akc-typing-row', '<div class="akc-mini" aria-hidden="true">' + eyes(2) + '</div><div class="akc-bub akc-typing" aria-label="' + esc(CFG.botName) + ' is typing"><i></i><i></i><i></i></div>');
    body.appendChild(t); toBottom();
    var hist = S.msgs.slice(-12).map(function (m) { return { role: m.role, content: m.text }; });
    ChatbotAPI.send({ message: text, history: hist, session_id: sid(), current_page: window.location.pathname }).then(function (r) {
      t.remove();
      if (r.handoff) {
        var m = { mid: 'sys_' + Date.now(), role: 'bot', text: r.reply || "Of course! Let's connect you directly with Amaanullah.", handoff: true, ts: Date.now() };
        S.msgs.push(m); save(); draw(m, true);
        return;
      }
      if (r.live_mode) {
        setLiveMode(true);
        return;
      }
      var cleanText = (r.reply || '').replace(/LEAD_FORM_REQUEST:?/g, '').replace(/DEAL_CLOSE:?/g, '').trim();
      var showLead = !!(r.lead || (r.reply && (r.reply.indexOf('LEAD_FORM_REQUEST:') !== -1 || r.reply.indexOf('DEAL_CLOSE:') !== -1)));
      var botMid = r.message_id ? parseInt(r.message_id, 10) : ('b_' + Date.now() + '_' + Math.floor(Math.random() * 1000));
      var m = { mid: botMid, role: 'bot', text: cleanText, cards: r.cards, chips: r.chips, lead: showLead, ts: Date.now() };
      S.msgs.push(m); if (!S.open) { S.unread = true; root.classList.add('unread'); } save(); draw(m, true);
    }).catch(function (err) {
      console.error('Chat error:', err);
      t.remove(); var m = { mid: 'err_' + Date.now(), role: 'bot', error: true, retry: text, text: 'Sorry, I had trouble connecting. Please try again or reach out on WhatsApp (+92 319 6935307).', ts: Date.now() };
      S.msgs.push(m); save(); draw(m, true);
    }).then(function () { waiting = false; ta.removeAttribute('aria-busy'); onInput(); toBottom(); });
  }

  /* ---------------- mobile: swipe-down + keyboard ---------------- */
  function swipe() {
    var head = $('.akc-head'), y0 = null, dy = 0;
    head.addEventListener('touchstart', function (e) { if (e.target.closest('button,a')) return; y0 = e.touches[0].clientY; dy = 0; root.classList.add('dragging'); }, { passive: true });
    head.addEventListener('touchmove', function (e) { if (y0 == null) return; dy = Math.max(0, e.touches[0].clientY - y0); win.style.setProperty('--akc-drag', dy + 'px'); }, { passive: true });
    head.addEventListener('touchend', function () { if (y0 == null) return; root.classList.remove('dragging'); win.style.removeProperty('--akc-drag'); if (dy > 110) setOpen(false); y0 = null; });
  }
  function keyboard() {
    if (!window.visualViewport) return;
    var vv = window.visualViewport, fit = function () { win.style.setProperty('--akc-vh', vv.height + 'px'); if (S.open) toBottom(true); };
    vv.addEventListener('resize', fit); fit();
  }

  window.AKChatbot = { open: function () { setOpen(true); }, close: function () { setOpen(false); }, send: function (t) { setOpen(true); send(t); }, api: ChatbotAPI };
  (document.readyState === 'loading') ? document.addEventListener('DOMContentLoaded', mount) : mount();
})();
