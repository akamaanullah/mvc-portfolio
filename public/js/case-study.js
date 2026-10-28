(()=>{
  const c = document.getElementById('content');
  if (!c) return;

  // 1. Immediately reveal .rv sections so content is NEVER hidden
  const io = new IntersectionObserver((entries) => {
    entries.forEach(x => {
      if (x.isIntersecting) {
        x.target.classList.add('in');
        io.unobserve(x.target);
      }
    });
  }, { rootMargin: '0px 0px -4% 0px' });
  document.querySelectorAll('.rv').forEach(s => io.observe(s));

  // 2. Reading time calculation
  const words = c.innerText.trim().split(/\s+/).length;
  const rtEl = document.getElementById('rtime');
  if (rtEl) rtEl.textContent = Math.max(1, Math.round(words / 230)) + ' min read';

  const p = document.getElementById('prog');
  const tb = document.getElementById('tbar');
  const pc = document.getElementById('pct');
  const mc = document.getElementById('mcur');

  // 3. Dynamic Table of Contents (TOC) builder from available sections
  const tocOl = document.querySelector('.toc ol');
  const mtocOl = document.querySelector('.mtoc ol');
  const sectionsInContent = [...c.querySelectorAll('section[id]')];

  if (sectionsInContent.length > 0 && tocOl) {
    tocOl.innerHTML = '';
    if (mtocOl) mtocOl.innerHTML = '';
    sectionsInContent.forEach(sec => {
      const h = sec.querySelector('h2, h3');
      const title = h ? h.textContent.replace(/^\d+\s*[·•-]\s*/, '').trim() : sec.id;
      const li = document.createElement('li');
      li.innerHTML = `<a href="#${sec.id}">${title}</a>`;
      tocOl.appendChild(li);

      if (mtocOl) {
        const mli = document.createElement('li');
        mli.innerHTML = `<a href="#${sec.id}">${title}</a>`;
        mtocOl.appendChild(mli);
      }
    });
  }

  // 4. Scroll tracking with null-safety
  const links = [...document.querySelectorAll('.toc a[href^="#"]')];
  const secs = links.map(a => {
    const targetId = a.getAttribute('href');
    return targetId ? document.querySelector(targetId) : null;
  });

  function on() {
    const r = c.getBoundingClientRect();
    const scrollMax = r.height - innerHeight;
    const progress = scrollMax > 0 ? Math.min(1, Math.max(0, -r.top / scrollMax)) : 0;
    if (p) p.style.width = (progress * 100) + '%';
    if (tb) tb.style.width = (progress * 100) + '%';
    if (pc) pc.textContent = Math.round(progress * 100) + '%';

    let k = 0;
    secs.forEach((s, i) => {
      if (s && s.getBoundingClientRect().top < 160) k = i;
    });

    links.forEach((a, i) => a.classList.toggle('on', i === k));
    if (mc && links[k]) mc.textContent = links[k].textContent;
  }

  addEventListener('scroll', on, { passive: true });
  on();

  // Mobile TOC close on click
  document.querySelectorAll('.mtoc a').forEach(a => {
    a.onclick = () => {
      const det = a.closest('details');
      if (det) det.open = false;
    };
  });

  // Lightbox
  const lb = document.getElementById('lb');
  if (lb) {
    document.querySelectorAll('.gi').forEach(b => {
      b.onclick = () => {
        const img = lb.querySelector('img');
        const cap = lb.querySelector('p');
        if (img) {
          img.src = b.querySelector('img')?.src || '';
          img.alt = b.querySelector('img')?.alt || '';
        }
        if (cap) cap.textContent = b.dataset.cap || '';
        lb.classList.add('on');
      };
    });
    lb.onclick = e => {
      if (e.target !== lb.querySelector('img')) lb.classList.remove('on');
    };
    addEventListener('keydown', e => {
      if (e.key === 'Escape') lb.classList.remove('on');
    });
  }

  // Copy link
  const copyBtn = document.getElementById('copy');
  if (copyBtn) {
    copyBtn.onclick = () => {
      if (navigator.clipboard) {
        navigator.clipboard.writeText(location.href);
        const originalText = copyBtn.textContent;
        copyBtn.textContent = 'Copied!';
        setTimeout(() => { copyBtn.textContent = originalText; }, 2000);
      }
    };
  }
})();
