(()=>{const c=document.getElementById('content');const w=c.innerText.trim().split(/\s+/).length;document.getElementById('rtime').textContent=Math.max(1,Math.round(w/230))+' min read';
const p=document.getElementById('prog'),tb=document.getElementById('tbar'),pc=document.getElementById('pct'),mc=document.getElementById('mcur');
const links=[...document.querySelectorAll('.toc a[href^="#"]')],secs=links.map(a=>document.querySelector(a.getAttribute('href')));
function on(){const r=c.getBoundingClientRect(),t=Math.min(1,Math.max(0,-r.top/(r.height-innerHeight)));p.style.width=tb.style.width=(t*100)+'%';pc.textContent=Math.round(t*100)+'%';
let k=0;secs.forEach((s,i)=>{if(s.getBoundingClientRect().top<140)k=i});links.forEach((a,i)=>a.classList.toggle('on',i===k));mc.textContent=links[k].textContent}
addEventListener('scroll',on,{passive:true});on();
document.querySelectorAll('.mtoc a').forEach(a=>a.onclick=()=>a.closest('details').open=false);
const io=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('in');io.unobserve(x.target)}}),{rootMargin:'0px 0px -8% 0px'});document.querySelectorAll('.rv').forEach(s=>io.observe(s));
const lb=document.getElementById('lb');document.querySelectorAll('.gi').forEach(b=>b.onclick=()=>{lb.querySelector('img').src=b.querySelector('img').src;lb.querySelector('img').alt=b.querySelector('img').alt;lb.querySelector('p').textContent=b.dataset.cap;lb.classList.add('on')});
lb.onclick=e=>{if(e.target!==lb.querySelector('img'))lb.classList.remove('on')};addEventListener('keydown',e=>{if(e.key==='Escape')lb.classList.remove('on')});
document.getElementById('copy').onclick=()=>navigator.clipboard&&navigator.clipboard.writeText(location.href);})();
