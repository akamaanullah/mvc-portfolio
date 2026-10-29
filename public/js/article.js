(()=>{const c=document.getElementById('content');const w=c.innerText.trim().split(/\s+/).length;document.getElementById('rtime').textContent=Math.max(1,Math.round(w/230))+' min read';
const p=document.getElementById('prog'),tb=document.getElementById('tbar'),pc=document.getElementById('pct'),mc=document.getElementById('mcur');
const links=[...document.querySelectorAll('.toc a')],secs=links.map(a=>document.querySelector(a.getAttribute('href')));
function on(){const r=c.getBoundingClientRect(),t=Math.min(1,Math.max(0,-r.top/(r.height-innerHeight)));p.style.width=tb.style.width=(t*100)+'%';pc.textContent=Math.round(t*100)+'%';
let k=-1;secs.forEach((s,i)=>{if(s&&s.getBoundingClientRect().top<140)k=i});links.forEach((a,i)=>a.classList.toggle('on',i===k));mc.textContent=k<0?'Introduction':links[k].textContent}
addEventListener('scroll',on,{passive:true});on();
document.querySelectorAll('.mtoc a').forEach(a=>a.onclick=()=>a.closest('details').open=false);
const cp=(t,b)=>{(navigator.clipboard?navigator.clipboard.writeText(t):Promise.reject()).then(()=>{b.classList.add('copied','ok');const o=b.innerHTML;b.textContent='Copied';setTimeout(()=>{b.classList.remove('copied','ok');b.innerHTML=o},1600)}).catch(()=>{})};
document.querySelectorAll('.cp, .code-copy-btn').forEach(b=>b.onclick=()=>{
  const parent = b.closest('.code, .code-box');
  const codeEl = parent ? parent.querySelector('code') : null;
  if(codeEl) cp(codeEl.innerText, b);
});
document.querySelectorAll('.copyl').forEach(b=>b.onclick=()=>cp(location.href,b));})();
