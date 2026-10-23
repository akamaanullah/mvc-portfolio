document.getElementById('yr').textContent=new Date().getFullYear();
const RM=matchMedia('(prefers-reduced-motion: reduce)').matches;
document.getElementById('btt').onclick=()=>scrollTo({top:0,behavior:RM?'auto':'smooth'});
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target)}}),{threshold:.1});
function reveal(root){root.querySelectorAll('.pc').forEach((el,i)=>{el.classList.add('rv2');el.style.transitionDelay=(i%3)*90+'ms'});root.querySelectorAll('.rv2:not(.in)').forEach(el=>io.observe(el))}
function mv(){const ind=document.querySelector('.ind'),b=document.querySelector('.ft[aria-selected=true]');if(ind&&b){ind.style.width=b.offsetWidth+'px';ind.style.transform=`translateX(${b.offsetLeft}px)`;const c=b.parentElement;if(c.scrollWidth>c.clientWidth)c.scrollTo({left:b.offsetLeft-(c.clientWidth-b.offsetWidth)/2,behavior:RM?'auto':'smooth'})}}
const cur=document.getElementById('cur');let on=false;
const fine=!RM&&matchMedia('(hover:hover) and (pointer:fine)').matches;
function bindCur(root){if(!fine)return;root.querySelectorAll('.pl').forEach(l=>{l.addEventListener('pointerenter',()=>{on=true;cur.classList.add('on')});l.addEventListener('pointerleave',()=>{on=false;cur.classList.remove('on')})})}
if(fine){let x=0,y=0,tx=0,ty=0;addEventListener('pointermove',e=>{tx=e.clientX;ty=e.clientY});(function loop(){x+=(tx-x)*.18;y+=(ty-y)*.18;cur.style.transform=`translate(${x}px,${y}px) scale(${on?1:0})`;requestAnimationFrame(loop)})()}
// Progressive enhancement: tabs are real links; with JS we swap content in place.
const cache={};
function getPage(url){return cache[url]||(cache[url]=fetch(url,{credentials:'same-origin'}).then(r=>{if(!r.ok)throw new Error(r.status);return r.text()}).then(t=>new DOMParser().parseFromString(t,'text/html')))}
function setMeta(doc){document.title=doc.title;
 [['meta[name=description]','content'],['link[rel=canonical]','href'],['meta[property="og:title"]','content'],['meta[property="og:description"]','content'],['meta[property="og:url"]','content'],['meta[name="twitter:title"]','content'],['meta[name="twitter:description"]','content']].forEach(([s,a])=>{const n=doc.querySelector(s),o=document.querySelector(s);if(n&&o)o.setAttribute(a,n.getAttribute(a))});
 document.querySelectorAll('script.pld').forEach(s=>s.remove());doc.querySelectorAll('script.pld').forEach(s=>{const c=document.createElement('script');c.type='application/ld+json';c.className='pld';c.textContent=s.textContent;document.head.appendChild(c)})}
const wait=ms=>new Promise(r=>setTimeout(r,ms));
let busy=false;
async function go(url,push){if(busy)return;busy=true;const m=document.getElementById('main');
 try{const docP=getPage(url);
  const key=(document.querySelector(`.ft[href="${url}"]`)||{}).dataset?.f;
  if(key){document.querySelectorAll('.ft').forEach(t=>{const a=t.dataset.f===key;t.setAttribute('aria-selected',a);a?t.setAttribute('aria-current','page'):t.removeAttribute('aria-current')});mv()}
  if(!RM){m.classList.add('leaving');await wait(280)}
  const doc=await docP,nm=doc.getElementById('main');
  const ph=m.querySelector('.ph'),nph=nm.querySelector('.ph');
  ph.querySelector('.crumb').replaceWith(nph.querySelector('.crumb').cloneNode(true));
  ph.querySelector('.eyebrow').replaceWith(nph.querySelector('.eyebrow').cloneNode(true));
  ph.querySelector('.row>div').replaceWith(nph.querySelector('.row>div').cloneNode(true));
  ph.querySelectorAll('.hc').forEach(h=>h.classList.toggle('act',h.dataset.f===nm.dataset.page));
  document.getElementById('swap').innerHTML=nm.querySelector('#swap').innerHTML;
  m.dataset.page=nm.dataset.page;setMeta(doc);if(push)history.pushState({url},'',url);
  ph.querySelectorAll('.rv2').forEach(e=>e.classList.add('in'));reveal(m);bindCur(m);
  const fb=document.querySelector('.fbar2');if(fb.getBoundingClientRect().top<0)fb.scrollIntoView({behavior:RM?'auto':'smooth'});
  requestAnimationFrame(()=>m.classList.remove('leaving'));
 }catch(e){console.warn(e);location.href=url}finally{busy=false}}
document.addEventListener('click',e=>{const a=e.target.closest('a.ft,a.hc');if(!a||e.metaKey||e.ctrlKey||e.shiftKey||e.altKey||e.button)return;e.preventDefault();
 const u=a.getAttribute('href');if(document.getElementById('main').dataset.page===a.dataset.f)return;go(u,true)});
document.addEventListener('pointerover',e=>{const a=e.target.closest('a.ft,a.hc');if(a)getPage(a.getAttribute('href')).catch(()=>{})});
history.replaceState({url:location.pathname},'');
addEventListener('popstate',e=>{if(e.state&&e.state.url)go(e.state.url,false)});
reveal(document);bindCur(document);
requestAnimationFrame(mv);addEventListener('resize',mv);document.fonts&&document.fonts.ready.then(mv);

document.addEventListener('submit',e=>{const f=e.target.closest('.nlf');if(!f)return;e.preventDefault();const m=f.querySelector('.msg'),v=f.email.value.trim();if(f.website.value)return;if(!/^\S+@\S+\.\S+$/.test(v)){m.style.color='#ff7b7b';m.textContent='Please enter a valid email.';return}m.style.color='';m.textContent='Thanks! You\'re on the list.';f.reset()});
