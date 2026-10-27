document.getElementById('yr')&&(document.getElementById('yr').textContent=new Date().getFullYear());
const RM=matchMedia('(prefers-reduced-motion: reduce)').matches;
const btt=document.getElementById('btt');if(btt)btt.onclick=()=>scrollTo({top:0,behavior:RM?'auto':'smooth'});
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target)}}),{threshold:.08});
document.querySelectorAll('.rv3,.rv2').forEach((el,i)=>{if(el.closest('.methods'))el.style.transitionDelay=(i%4)*80+'ms';io.observe(el)});
// copy to clipboard
document.querySelectorAll('.cp').forEach(b=>b.addEventListener('click',async ev=>{ev.preventDefault();ev.stopPropagation();const t=b.dataset.copy;try{await navigator.clipboard.writeText(t)}catch(_){const x=document.createElement('textarea');x.value=t;document.body.appendChild(x);x.select();document.execCommand('copy');x.remove()}b.textContent='Copied ✓';b.classList.add('ok');setTimeout(()=>{b.textContent='Copy';b.classList.remove('ok')},1800)}));
// live Karachi clock
const clk=document.getElementById('clk'),ost=document.getElementById('ost'),ostt=document.getElementById('ostt');
function tick(){const d=new Date(),f=new Intl.DateTimeFormat('en-GB',{timeZone:'Asia/Karachi',hour:'2-digit',minute:'2-digit',weekday:'short',hourCycle:'h23'}).formatToParts(d),g=k=>f.find(p=>p.type==k).value;
clk.textContent=g('hour')+':'+g('minute');const h=+g('hour'),wd=g('weekday');const open=!['Sat','Sun'].includes(wd)&&h>=9&&h<18;/* EDIT: match working hours */
ost.classList.toggle('off',!open);ostt.textContent=open?'Within working hours':'Outside working hours — I\'ll reply next working day'}
tick();setInterval(tick,15000);
// form
const F=document.getElementById('cf'),fc=document.getElementById('fc'),msg=document.getElementById('msg'),cnt=document.getElementById('msg-c'),sum=document.getElementById('sumerr');
msg.addEventListener('input',()=>{const n=msg.value.length;cnt.textContent=n+' / 2000';cnt.classList.toggle('hi',n>1800)});
let files=[];const att=document.getElementById('att'),drop=document.getElementById('drop'),list=document.getElementById('files'),attE=document.getElementById('att-e');
const OK=/\.(pdf|docx?|txt|png|jpe?g|zip)$/i,fmt=b=>b>1048576?(b/1048576).toFixed(1)+' MB':Math.max(1,Math.round(b/1024))+' KB';
function addFiles(fl){attE.textContent='';for(const f of fl){if(files.length>=5){attE.textContent='Up to 5 files.';break}if(!OK.test(f.name)){attE.textContent=f.name+': file type not allowed.';continue}if(f.size>10485760){attE.textContent=f.name+' is larger than 10 MB.';continue}files.push(f)}render()}
function render(){list.innerHTML='';files.forEach((f,i)=>{const li=document.createElement('li');li.innerHTML='<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;vertical-align:middle;margin-right:4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span></span><small>'+fmt(f.size)+'</small><button type="button" aria-label="Remove file">×</button>';li.querySelector('span').textContent=f.name;li.querySelector('button').onclick=()=>{files.splice(i,1);render()};list.appendChild(li)});
try{const dt=new DataTransfer();files.forEach(f=>dt.items.add(f));att.files=dt.files}catch(_){}}
att.addEventListener('change',()=>{addFiles([...att.files])});
['dragenter','dragover'].forEach(t=>drop.addEventListener(t,e=>{e.preventDefault();drop.classList.add('over')}));['dragleave','drop'].forEach(t=>drop.addEventListener(t,e=>{e.preventDefault();drop.classList.remove('over')}));
drop.addEventListener('drop',e=>addFiles([...e.dataTransfer.files]));
const rules={name:v=>v.trim().length<2?'Please enter your name.':'',email:v=>!v.trim()?'Please enter your email.':!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v.trim())?'That email doesn\'t look right.':'',
phone:v=>v.trim()&&!/^[+()\d\s-]{7,20}$/.test(v.trim())?'Use digits, spaces or + only.':'',service:v=>!v?'Please choose a service (or “Not sure yet”).':'',
message:v=>v.trim().length<20?'Please add a few more details (at least 20 characters).':'',consent:(v,el)=>!el.checked?'Please confirm so I can reply.':''};
function check(el){const r=rules[el.name];if(!r)return true;const m=r(el.value,el),box=el.closest('.f'),er=document.getElementById(el.getAttribute('aria-describedby').split(' ')[0]);
er.textContent=m;box.classList.toggle('bad',!!m);el.setAttribute('aria-invalid',m?'true':'false');return !m}
Object.keys(rules).forEach(n=>{const el=F.elements[n];el.addEventListener('blur',()=>{if(el.value||el.closest('.f').classList.contains('bad'))check(el)});el.addEventListener(n=='consent'||n=='service'?'change':'input',()=>{if(el.closest('.f').classList.contains('bad'))check(el)})});
F.addEventListener('submit',e=>{e.preventDefault();if(F.elements.website.value)return;/* honeypot */
const bad=Object.keys(rules).filter(n=>!check(F.elements[n]));
if(bad.length){sum.textContent='Please fix '+bad.length+' field'+(bad.length>1?'s':'')+' highlighted below.';F.elements[bad[0]].focus({preventScroll:true});F.elements[bad[0]].closest('.f').scrollIntoView({behavior:RM?'auto':'smooth',block:'center'});return}
sum.textContent='';const b=document.getElementById('send');b.disabled=true;b.classList.add('busy');b.querySelector('.klbl').textContent='Sending…';
/* FAKE SUBMIT (demo). Laravel: remove preventDefault above to post normally, or:
   fetch(F.action,{method:'POST',body:new FormData(F),headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}}) -> 422 => show $errors */
setTimeout(()=>{fc.classList.add('done');b.disabled=false;b.classList.remove('busy');b.querySelector('.klbl').textContent='Send enquiry';fc.scrollIntoView({behavior:RM?'auto':'smooth',block:'start'})},1400)});
document.getElementById('again').onclick=()=>{F.reset();files=[];render();cnt.textContent='0 / 2000';fc.classList.remove('done')};
