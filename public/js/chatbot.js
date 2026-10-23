var AK_BASE=((document.currentScript&&document.currentScript.src)||'').replace(/\/js\/chatbot\.js.*$/,'');
/*! AK Chatbot widget — UI only, vanilla JS, no dependencies.
 *  Configure BEFORE this script loads:
 *    window.AK_CHATBOT_CONFIG = { endpoint: '/chatbot/message' }   // null => DEMO mock
 *  Backend contract:  POST endpoint  JSON {message, history, session_id}
 *    -> JSON { reply: "markdown-lite text", chips?: [..], cards?: [{tag,title,text,button,url}], lead?: true }
 */
(function () {
  'use strict';
  var CFG = Object.assign({
    endpoint: null,                       // EDIT: '/chatbot/message' when your trained bot is ready
    leadEndpoint: null,                   // EDIT: '/chatbot/lead' (optional)
    botName: '[Bot Name]',                // EDIT
    whatsapp: 'https://wa.me/[NUMBER]',   // EDIT: talk-to-human link
    poweredBy: '[Powered by]', poweredUrl: 'javascript:void(0)', // EDIT
    greetingDelay: 4000, maxChars: 500, timeout: 20000
  }, window.AK_CHATBOT_CONFIG || {});

  var SKEY = 'akc_state_v1', TKEY = 'akc_tip_dismissed';
  var CHIPS = ['Services', 'Get a quote', 'See projects', 'Book a call', 'Pricing'];

  /* ---------------- API stub ---------------- */
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
      if (CFG.endpoint) return post(CFG.endpoint, p).then(function (d) { return typeof d === 'string' ? { reply: d } : d; });
      return DEMO.reply(p.message);
    },
    lead: function (p) { return CFG.leadEndpoint ? post(CFG.leadEndpoint, p) : new Promise(function (r) { setTimeout(function () { r({ ok: true }); }, 900); }); }
  };
  window.ChatbotAPI = ChatbotAPI;

  /* ============ DEMO MOCK — remove/ignore once CFG.endpoint is set ============
     Generic canned replies only. No prices or claims. */
  var DEMO = {
    fail: false, // set true in console to preview the error/retry state
    rules: [
      [/servic/i, { reply: "Here are the main things I can help with. Tap one to learn more:", cards: [
        { tag: 'Service', title: 'Web Development', text: 'Websites and web apps built around your business goals.', button: 'View services', url: AK_BASE + '/services' },
        { tag: 'Service', title: 'CRM & SaaS', text: 'Custom CRMs and multi-tenant SaaS platforms.', button: 'View services', url: AK_BASE + '/services' },
        { tag: 'Service', title: 'Automation & AI', text: 'Workflows and chatbots that save your team time.', button: 'View services', url: AK_BASE + '/services' }],
        chips: ['Get a quote', 'See projects'] }],
      [/quote|estimate|start a project/i, { reply: "Happy to help! Share your **name** and **email** below and a short note about the project — you'll get a reply with next steps.", lead: true }],
      [/project|portfolio|work/i, { reply: "Here are a few recent projects:", cards: [
        { tag: 'Product', title: 'Chatrox', text: 'Real-time chat platform for web & mobile.', button: 'Read case study', url: AK_BASE + '/projects/chatrox' },
        { tag: 'Web App', title: 'Multi-Tenant CRM', text: 'One platform, many businesses, isolated data.', button: 'View project', url: AK_BASE + '/projects' },
        { tag: 'Web App', title: 'HRM', text: 'People, attendance and payroll in one place.', button: 'View project', url: AK_BASE + '/projects' }],
        chips: ['Get a quote', 'Services'] }],
      [/call|meet|book|schedule/i, { reply: "Sure! You can:\n- Book a call via the **[Contact page](" + AK_BASE + "/contact)**\n- Or message directly on **[WhatsApp](" + CFG.whatsapp + ")**\n\nWant me to take your details instead?", chips: ['Get a quote'] }],
      [/pric|cost|budget|rate|how much/i, { reply: "Pricing **depends on the scope** — features, integrations and timeline all play a part. The best way to get an accurate number is a free quote.\n\nShall I take your details?", chips: ['Get a quote', 'Book a call'] }],
      [/^(hi|hello|hey|salam|assalam)/i, { reply: "Hi there! 👋 How can I help you today?", chips: CHIPS }]
    ],
    reply: function (msg) {
      var self = this;
      return new Promise(function (res, rej) {
        setTimeout(function () {
          if (self.fail) return rej(new Error('demo failure'));
          for (var i = 0; i < self.rules.length; i++) if (self.rules[i][0].test(msg)) return res(JSON.parse(JSON.stringify(self.rules[i][1])));
          res({ reply: "*(Demo mode)* Thanks for your message! Once the trained assistant is connected, I'll answer this properly. Meanwhile, pick an option:", chips: CHIPS });
        }, 1100 + Math.random() * 700);
      });
    }
  };
  /* ============================ END DEMO MOCK ============================ */

  /* ---------------- helpers ---------------- */
  function esc(s) { return String(s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
  function safeUrl(u) { return /^(https?:|mailto:|tel:|\/|#|[\w-]+\.html|javascript:void\(0\))/i.test(u) ? u : '#'; }
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
    down: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#14141c" stroke-width="2.4" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>'
  };
  var eyes = function (n) { return new Array(n + 1).join('<i></i>'); };

  /* ---------------- state ---------------- */
  var S = { open: false, msgs: [], unread: true };
  try { var saved = JSON.parse(sessionStorage.getItem(SKEY)); if (saved) S = Object.assign(S, saved); } catch (e) {}
  function save() { try { sessionStorage.setItem(SKEY, JSON.stringify({ open: S.open, msgs: S.msgs.slice(-60), unread: S.unread })); } catch (e) {} }

  /* ---------------- DOM ---------------- */
  var root = el('div', 'akc');
  root.innerHTML =
    '<div class="akc-tip" role="status"><button class="akc-tip-open" type="button">Hi! Need help with a project?<span>Ask me anything — I reply instantly.</span></button><button class="akc-tip-x" type="button" aria-label="Dismiss">✕</button></div>' +
    '<section class="akc-win" role="dialog" aria-modal="true" aria-label="Chat with ' + esc(CFG.botName) + '">' +
      '<header class="akc-head"><span class="akc-grab" aria-hidden="true"></span><div class="akc-av" aria-hidden="true">' + eyes(2) + '<b></b></div>' +
        '<div class="akc-ttl"><strong>' + esc(CFG.botName) + '</strong><small>Online · Typically replies instantly</small></div>' +
        '<button class="akc-hb akc-more" type="button" aria-label="Chat options" aria-haspopup="true" aria-expanded="false">' + I.dots + '</button>' +
        '<button class="akc-hb akc-min" type="button" aria-label="Minimize chat">' + I.min + '</button>' +
        '<button class="akc-hb akc-close" type="button" aria-label="Close chat">' + I.x + '</button>' +
        '<div class="akc-menu" role="menu"><button role="menuitem" type="button" class="akc-clear">🗑️ Clear chat</button>' +
        '<a role="menuitem" class="akc-human" href="' + esc(CFG.whatsapp) + '" target="_blank" rel="noopener">💬 Talk to a human</a></div>' +
      '</header>' +
      '<div class="akc-body" aria-live="polite" aria-relevant="additions" tabindex="-1"></div>' +
      '<button class="akc-down" type="button" aria-label="Scroll to latest">' + I.down + '</button>' +
      '<footer class="akc-foot"><form class="akc-comp" novalidate><label class="akc-sr" for="akc-in">Type your message</label>' +
        '<textarea id="akc-in" rows="1" placeholder="Type your message…" maxlength="' + CFG.maxChars + '"></textarea>' +
        '<button class="akc-send" type="submit" aria-label="Send message" disabled>' + I.send + '</button></form>' +
        '<div class="akc-meta"><a href="' + esc(CFG.poweredUrl) + '">⚡ <b>' + esc(CFG.poweredBy) + '</b></a><span class="akc-count" aria-live="polite"></span></div></footer>' +
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
    $('form').addEventListener('submit', function (e) { e.preventDefault(); submit(); });
    ta.addEventListener('input', onInput);
    ta.addEventListener('keydown', function (e) { if (e.key === 'Enter' && !e.shiftKey && !e.isComposing) { e.preventDefault(); submit(); } });
    body.addEventListener('scroll', function () { down.classList.toggle('show', body.scrollHeight - body.scrollTop - body.clientHeight > 120); });
    down.addEventListener('click', function () { toBottom(); });
    root.addEventListener('keydown', trap);
    swipe(); keyboard();
  }

  function setOpen(o, instant) {
    S.open = o; root.classList.toggle('open', o);
    launch.setAttribute('aria-expanded', o); launch.setAttribute('aria-label', o ? 'Close chat' : 'Open chat');
    if (o) { tip.classList.remove('show'); sessionStorage.setItem(TKEY, '1'); S.unread = false; root.classList.remove('unread');
      setTimeout(function () { toBottom(true); if (!matchMedia('(max-width:560px)').matches || !instant) ta.focus({ preventScroll: true }); }, instant ? 0 : 350);
      if (matchMedia('(max-width:560px)').matches) document.documentElement.style.overflow = 'hidden';
    } else { toggleMenu(false); document.documentElement.style.overflow = ''; if (!instant) launch.focus(); }
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
    var w = el('div', 'akc-welcome', '<div class="akc-big" aria-hidden="true">' + eyes(2) + '</div><h3>Hi there <em>👋</em></h3><p>I\'m ' + esc(CFG.botName) + ', Amaanullah\'s assistant. Ask about services, projects or start a quote.</p>');
    w.appendChild(chips(CHIPS, true)); body.appendChild(w);
  }
  function chips(list, center) {
    var c = el('div', 'akc-chips' + (center ? '' : ' left'));
    list.forEach(function (t, i) { var b = el('button', 'akc-chip', esc(t)); b.type = 'button'; b.style.animationDelay = i * 60 + 'ms'; b.onclick = function () { c.remove(); send(t); }; c.appendChild(b); });
    return c;
  }
  function draw(m, last) {
    var row = el('div', 'akc-row ' + (m.role === 'user' ? 'user' : 'bot') + (m.error ? ' akc-err' : ''));
    row.innerHTML = '<div class="akc-mini" aria-hidden="true">' + eyes(2) + '</div>';
    var col = el('div', 'akc-col');
    col.appendChild(el('div', 'akc-bub', m.role === 'user' ? esc(m.text).replace(/\n/g, '<br>') : md(m.text)));
    if (m.error) { var r = el('button', 'akc-retry', '↻ Retry'); r.type = 'button'; r.onclick = function () { S.msgs.splice(S.msgs.indexOf(m), 1); save(); render(); ask(m.retry); }; col.appendChild(r); }
    col.appendChild(el('div', 'akc-time', (m.role === 'user' ? 'You · ' : '') + time(m.ts)));
    row.appendChild(col); body.appendChild(row);
    if (m.cards && m.cards.length) {
      var cs = el('div', 'akc-cards');
      m.cards.forEach(function (c) {
        cs.appendChild(el('article', 'akc-card', '<div class="akc-card-ban"><span>' + esc(c.tag || '') + '</span></div><div class="akc-card-b"><strong>' + esc(c.title) + '</strong><p>' + esc(c.text || '') + '</p><a class="akc-btn" href="' + esc(safeUrl(c.url || '#')) + '">' + esc(c.button || 'Learn more') + ' →</a></div>'));
      });
      var wrap = el('div'); wrap.style.paddingLeft = '38px'; wrap.appendChild(cs); body.appendChild(wrap);
    }
    if (m.lead) body.appendChild(leadCard(m));
    if (last && m.chips && m.chips.length && !m.lead) body.appendChild(chips(m.chips));
  }
  function leadCard(m) {
    var f = el('form', 'akc-lead');
    if (m.leadDone) { f.classList.add('done'); f.innerHTML = '<div class="akc-ok">✓</div><strong>Thanks, ' + esc(m.leadDone) + '!</strong><p>Your details were received. You\'ll hear back soon.</p>'; return f; }
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
      ChatbotAPI.lead({ name: n, email: em, session_id: sid(), history: S.msgs.slice(-10) }).then(function () {
        m.leadDone = n.split(' ')[0]; save(); var nf = leadCard(m); f.replaceWith(nf);
      }).catch(function () { b.disabled = false; b.textContent = 'Try again'; errs[1].textContent = 'Couldn\'t send. Please retry.'; });
    };
    return f;
  }

  /* ---------------- flow ---------------- */
  function submit() { var v = ta.value.trim().slice(0, CFG.maxChars); if (!v || waiting) return; ta.value = ''; onInput(); send(v); }
  function send(text) {
    S.msgs.push({ role: 'user', text: text, ts: Date.now() }); save();
    if (body.querySelector('.akc-welcome')) render(); else { body.querySelectorAll('.akc-chips.left').forEach(function (c) { c.remove(); }); draw(S.msgs[S.msgs.length - 1]); }
    toBottom(); ask(text);
  }
  function ask(text) {
    waiting = true; onInput(); ta.setAttribute('aria-busy', 'true');
    var t = el('div', 'akc-row bot akc-typing-row', '<div class="akc-mini" aria-hidden="true">' + eyes(2) + '</div><div class="akc-bub akc-typing" aria-label="' + esc(CFG.botName) + ' is typing"><i></i><i></i><i></i></div>');
    body.appendChild(t); toBottom();
    var hist = S.msgs.slice(-12).map(function (m) { return { role: m.role, content: m.text }; });
    ChatbotAPI.send({ message: text, history: hist, session_id: sid() }).then(function (r) {
      t.remove(); var m = { role: 'bot', text: r.reply || '', cards: r.cards, chips: r.chips, lead: r.lead, ts: Date.now() };
      S.msgs.push(m); if (!S.open) { S.unread = true; root.classList.add('unread'); } save(); draw(m, true);
    }).catch(function () {
      t.remove(); var m = { role: 'bot', error: true, retry: text, text: 'Sorry, something went wrong. Please check your connection and try again.', ts: Date.now() };
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

  window.AKChatbot = { open: function () { setOpen(true); }, close: function () { setOpen(false); }, send: function (t) { setOpen(true); send(t); }, demo: DEMO, api: ChatbotAPI };
  (document.readyState === 'loading') ? document.addEventListener('DOMContentLoaded', mount) : mount();
})();
