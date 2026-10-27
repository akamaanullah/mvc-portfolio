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
 // Chat: cycle messages
 const ch=document.querySelector('[data-anim=chat]');
 if(ch){const msgs=[['l','Order #482 shipped?'],['r','Yes — tracking sent ✓'],['l','Can I add a teammate?'],['r','Done, invite sent ✓'],['l','Thanks!']];let i=0;
  every(ch,2200,()=>{const ty=ch.querySelector('.typing');const [s,t]=msgs[i%msgs.length];i++;
   const b=document.createElement('div');b.className='bub '+s;b.textContent=t;ch.insertBefore(b,ty);
   const all=ch.querySelectorAll('.bub:not(.typing)');if(all.length>2)all[0].remove();
   ty.classList.toggle('r',s==='l');ty.classList.toggle('l',s!=='l')},600);}
})();
