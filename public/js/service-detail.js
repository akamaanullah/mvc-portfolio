(()=>{const c=document.getElementById('content'),p=document.getElementById('prog'),tb=document.getElementById('tbar'),pc=document.getElementById('pct'),mc=document.getElementById('mcur');
const links=[...document.querySelectorAll('.toc ol a')],secs=links.map(a=>document.querySelector(a.getAttribute('href')));
function on(){const r=c.getBoundingClientRect(),t=Math.min(1,Math.max(0,-r.top/(r.height-innerHeight)));p.style.width=tb.style.width=(t*100)+'%';pc.textContent=Math.round(t*100)+'%';
let k=0;secs.forEach((s,i)=>{if(s.getBoundingClientRect().top<140)k=i});links.forEach((a,i)=>a.classList.toggle('on',i===k));mc.textContent=links[k].textContent}
addEventListener('scroll',on,{passive:true});on();
document.querySelectorAll('.mtoc a').forEach(a=>a.onclick=()=>a.closest('details').open=false);
const io=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('in');io.unobserve(x.target)}}),{rootMargin:'0px 0px -8% 0px'});document.querySelectorAll('.rv').forEach(s=>io.observe(s));
const sl=document.querySelector('.slot');new IntersectionObserver(e=>sl.querySelectorAll('.mv,.bars i').forEach(n=>n.style.animationPlayState=e[0].isIntersecting?'running':'paused')).observe(sl);})();
