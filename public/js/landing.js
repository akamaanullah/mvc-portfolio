(()=>{const p=document.getElementById('prog');addEventListener('scroll',()=>{const h=document.documentElement;p.style.width=(scrollY/(h.scrollHeight-innerHeight)*100)+'%'},{passive:true});
const io=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('in');io.unobserve(x.target)}}),{rootMargin:'0px 0px -8% 0px'});document.querySelectorAll('.rv').forEach(s=>io.observe(s));
const jl=[...document.querySelectorAll('.jump a')],js=jl.map(a=>document.querySelector(a.getAttribute('href'))).filter(Boolean);
addEventListener('scroll',()=>{let k=-1;js.forEach((s,i)=>{if(s.getBoundingClientRect().top<160)k=i});jl.forEach((a,i)=>a.classList.toggle('on',i===k))},{passive:true});
const t=document.querySelector('.term');if(t)new IntersectionObserver(e=>t.classList.toggle('paused',!e[0].isIntersecting)).observe(t);})();
