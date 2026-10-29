/* Shared header/footer behaviour (same as the home page): dark-mode toggle, sound tick, back-to-top, year, mobile drawer */
(function(){
var RM=matchMedia('(prefers-reduced-motion: reduce)').matches;
var dm=document.getElementById('dm');if(dm)dm.onclick=function(){var dk=document.documentElement.getAttribute('data-theme')!=='dark';document.documentElement.setAttribute('data-theme',dk?'dark':'light');document.documentElement.style.colorScheme=dk?'dark':'light';document.body.classList.toggle('dark',dk);try{localStorage.setItem('theme',dk?'dark':'light')}catch(e){}};
var actx,snd=document.getElementById('snd');if(snd)snd.onclick=function(){actx=actx||new AudioContext();var o=actx.createOscillator(),g=actx.createGain();o.frequency.value=660;g.gain.setValueAtTime(.08,actx.currentTime);g.gain.exponentialRampToValueAtTime(.0001,actx.currentTime+.4);o.connect(g).connect(actx.destination);o.start();o.stop(actx.currentTime+.4)};
var btt=document.getElementById('btt');if(btt)btt.onclick=function(){scrollTo({top:0,behavior:RM?'auto':'smooth'})};
var yr=document.getElementById('yr');if(yr)yr.textContent=new Date().getFullYear();

// Mobile Navigation Drawer Toggle
var mobToggle=document.getElementById('mobNavToggle');
var mobDrawer=document.getElementById('mobDrawer');
var mobClose=document.getElementById('mobNavClose');
var mobBackdrop=document.getElementById('mobBackdrop');

function openMobNav(){
  if(!mobDrawer)return;
  mobDrawer.classList.add('open');
  mobDrawer.setAttribute('aria-hidden','false');
  if(mobToggle)mobToggle.setAttribute('aria-expanded','true');
  document.body.classList.add('mob-nav-open');
  document.body.style.overflow='hidden';
  var chat = document.querySelector('.akc');
  if(chat) chat.style.setProperty('display','none','important');
}
function closeMobNav(){
  if(!mobDrawer)return;
  mobDrawer.classList.remove('open');
  mobDrawer.setAttribute('aria-hidden','true');
  if(mobToggle)mobToggle.setAttribute('aria-expanded','false');
  document.body.classList.remove('mob-nav-open');
  document.body.style.overflow='';
  var chat = document.querySelector('.akc');
  if(chat) chat.style.removeProperty('display');
}

if(mobToggle)mobToggle.onclick=function(e){e.preventDefault();openMobNav()};
if(mobClose)mobClose.onclick=function(e){e.preventDefault();closeMobNav()};
if(mobBackdrop)mobBackdrop.onclick=closeMobNav;
document.addEventListener('keydown',function(e){if(e.key==='Escape'&&mobDrawer&&mobDrawer.classList.contains('open')){closeMobNav()}});
})();
