document.getElementById('yr').textContent=new Date().getFullYear();
const RM=matchMedia('(prefers-reduced-motion: reduce)').matches;
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target);e.target.querySelectorAll('.cu').forEach(cu)}}),{threshold:.15});
document.querySelectorAll('.fade').forEach((el,i)=>{el.style.transitionDelay=(i%3)*80+'ms';io.observe(el)});
function cu(el){const t=el.dataset.to,n=parseFloat(t);if(RM||isNaN(n))return;const d=t.includes('.')?1:0,t0=performance.now();(function f(now){const p=Math.min(1,(now-t0)/1400),e=1-Math.pow(1-p,3);el.textContent=(n*e).toFixed(d);if(p<1)requestAnimationFrame(f);else el.textContent=t})(t0)}
document.getElementById('btt').onclick=()=>scrollTo({top:0,behavior:'smooth'});
// tabs
const tabs=[...document.querySelectorAll('.tab')];
tabs.forEach((t,i)=>{t.onclick=()=>sel(i);t.onkeydown=e=>{if(e.key==='ArrowDown'||e.key==='ArrowRight'){e.preventDefault();sel((i+1)%tabs.length,1)}if(e.key==='ArrowUp'||e.key==='ArrowLeft'){e.preventDefault();sel((i+tabs.length-1)%tabs.length,1)}}});
function sel(i,f){tabs.forEach((t,j)=>{t.setAttribute('aria-selected',i===j);t.tabIndex=i===j?0:-1;document.getElementById(t.getAttribute('aria-controls')).hidden=i!==j});if(f)tabs[i].focus()}
// reviews carousel
const rt=document.getElementById('rt');const step=()=>rt.querySelector('.rv').offsetWidth+18;
document.getElementById('rp').onclick=()=>rt.scrollBy({left:-step(),behavior:RM?'auto':'smooth'});
document.getElementById('rn').onclick=()=>rt.scrollBy({left:step(),behavior:RM?'auto':'smooth'});
// hover glow + tilt (fine pointers only)
if(!RM&&matchMedia('(hover:hover)').matches){
 document.querySelectorAll('.bc').forEach(c=>c.addEventListener('pointermove',e=>{const r=c.getBoundingClientRect();c.style.setProperty('--mx',(e.clientX-r.left)+'px');c.style.setProperty('--my',(e.clientY-r.top)+'px')}));
 const st=document.querySelector('.stage'),cd=st&&st.querySelector('.code');
 if(st)st.addEventListener('pointermove',e=>{const r=st.getBoundingClientRect(),x=(e.clientX-r.left)/r.width-.5,y=(e.clientY-r.top)/r.height-.5;cd.style.transform=`perspective(900px) rotateY(${x*8}deg) rotateX(${-y*8}deg) rotate(-2deg)`}),st.addEventListener('pointerleave',()=>cd.style.transform='');
}

// ===== live mockups =====
(function(){
 if(RM) return;
 const vis=new IntersectionObserver(es=>es.forEach(e=>e.target.classList.toggle('on-screen',e.isIntersecting)),{threshold:.05});
 document.querySelectorAll('.live').forEach(el=>vis.observe(el));
 const on=el=>el.classList.contains('on-screen')&&!document.hidden;
 const every=(el,ms,fn,delay=0)=>setTimeout(()=>setInterval(()=>{if(on(el))fn()},ms),delay);
 const fmt=n=>n.toLocaleString('en-US');
 // CRM
 const crm=document.querySelector('[data-anim=crm]');
 if(crm){const bars=[...crm.querySelectorAll('.bars i')],pills=[...crm.querySelectorAll('.pipe span')],ks=[...crm.querySelectorAll('[data-c]')];let st=0;
  every(crm,2600,()=>bars.forEach(b=>b.style.height=(30+Math.random()*65|0)+'%'));
  every(crm,1800,()=>{pills[st].classList.remove('on');st=(st+1)%pills.length;pills[st].classList.add('on')},300);
  ks.forEach((k,i)=>every(crm,1300+i*500,()=>{let v=+k.dataset.c+1+(Math.random()*+k.dataset.r|0);k.dataset.c=v;k.textContent=fmt(v);k.classList.add('tick');setTimeout(()=>k.classList.remove('tick'),350)},i*300));}
 // Web (Card 1)
 const web=document.querySelector('[data-anim=web]');
 if(web){
  const tiles=[...web.querySelectorAll('.w-tile')];
  const rows=[...web.querySelectorAll('.wt-row')];
  const search=web.querySelector('.w-search-box span');
  const queries=['Search stores, portals, apps...','Filter: Laravel + React...','Database queries: 0.03s','Stripe checkout: live'];
  let ti=1,qi=0;
  every(web,2600,()=>{
    tiles.forEach(t=>t.classList.remove('feat'));
    ti=(ti+1)%tiles.length;
    tiles[ti].classList.add('feat');
  },500);
  if(search){
    every(web,3000,()=>{
      qi=(qi+1)%queries.length;
      search.style.opacity='0';
      setTimeout(()=>{
        search.textContent=queries[qi];
        search.style.opacity='1';
      },220);
    },1000);
  }
  every(web,2400,()=>{
    if(rows.length){
      const r=rows[Math.floor(Math.random()*rows.length)];
      r.classList.add('flash');
      setTimeout(()=>r.classList.remove('flash'),900);
    }
  },700);
 }
 // SaaS
 const ss=document.querySelector('[data-anim=saas]');
 if(ss){const rows=[...ss.querySelectorAll('.ten')],plans=['Pro','Team','Starter','Business'];let hi=2,t=0;
  every(ss,2400,()=>{t++;
   // rotate order
   rows.forEach(r=>r.style.setProperty('--y',(+r.style.getPropertyValue('--y')+1)%3));
   rows[hi].classList.remove('on');const old=rows[hi].querySelector('span');
   hi=(hi+1)%3;const r=rows[hi];
   // swap labels: old highlighted -> plan, new -> billing
   old.classList.add('sw');setTimeout(()=>{old.className='';old.textContent=plans[t%plans.length]},250);
   const sp=r.querySelector('span');sp.classList.add('sw');
   setTimeout(()=>{sp.className='bill';sp.innerHTML='Billing <i>✓</i>';r.classList.add('on')},300);
  },900);}
 // AI Automation (Card 5)
 const ai=document.querySelector('[data-anim=ai]');
 if(ai){
  const nodes=[...ai.querySelectorAll('.ai-flow .node')];
  const logBox=ai.querySelector('.ai-log');
  const logs=[
    {doc:'Supplier_Invoice_Oct.pdf',res:'Extracted ✓',dot:'green'},
    {doc:'Customer Sales Inquiry',res:'Drafted ✓',dot:'orange'},
    {doc:'Contract_Agreement_v3.pdf',res:'Verified ✓',dot:'green'},
    {doc:'New Support Ticket #914',res:'Routed ✓',dot:'orange'},
    {doc:'Bank_Statement_Q3.pdf',res:'Parsed ✓',dot:'green'}
  ];
  let li=1,ni=1;
  every(ai,2200,()=>{
    nodes.forEach(n=>n.classList.remove('pulse'));
    ni=(ni+1)%nodes.length;
    nodes[ni].classList.add('pulse');
    setTimeout(()=>nodes[ni].classList.remove('pulse'),900);
  },400);
  if(logBox){
    every(ai,2800,()=>{
      li=(li+1)%logs.length;
      const next=logs[li];
      const item=document.createElement('div');
      item.className='ai-log-item new-log';
      item.innerHTML=`<span class="ai-dot ${next.dot}"></span><span class="ai-txt">${next.doc}</span><span class="ai-res">${next.res}</span>`;
      logBox.appendChild(item);
      const all=logBox.querySelectorAll('.ai-log-item');
      if(all.length>2){
        all[0].style.opacity='0';
        setTimeout(()=>all[0].remove(),250);
      }
    },1100);
  }
 }
 // Chat: cycle messages (Card 6)
 const ch=document.querySelector('[data-anim=chat]');
 if(ch){
  const body=ch.querySelector('.ch-body')||ch;
  const msgs=[
    ['l','Can I add real-time chat to our app?'],
    ['r','Yes — private & team channels ready ✓'],
    ['l','Does it support push notifications?'],
    ['r','Instant FCM & WebSockets ⚡'],
    ['l','Can we self-host on our server?'],
    ['r','100% owned — no per-seat fee ✓'],
    ['l','Sounds perfect, let\'s build it!']
  ];
  let i=2;
  every(ch,2400,()=>{
    const ty=body.querySelector('.typing');
    if(!ty)return;
    const [s,t]=msgs[i%msgs.length];
    i++;
    const b=document.createElement('div');
    b.className='bub '+s+' pop-in';
    b.textContent=t;
    body.insertBefore(b,ty);
    const all=body.querySelectorAll('.bub:not(.typing)');
    if(all.length>3){
      all[0].style.opacity='0';
      all[0].style.transform='scale(0.92)';
      setTimeout(()=>all[0].remove(),200);
    }
  },700);
 }
})();
