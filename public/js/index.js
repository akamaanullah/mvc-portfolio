/* SPLASH gate. SPLASH_VARIANT picks the welcome screen: 'portal' | 'particles'.
   Shown once per session. ?splash=1 forces it, ?splash=portal / ?splash=particles forces a variant, ?splash=0 disables. */
const SPLASH_VARIANT='portal';
(function(){var r=document.documentElement;try{var q=new URLSearchParams(location.search).get('splash');var seen=sessionStorage.getItem('splashSeen');r.dataset.splash=(q==='portal'||q==='particles')?q:SPLASH_VARIANT;var force=q==='1'||q==='portal'||q==='particles';if(force||(q!=='0'&&!seen))r.classList.add('splashing','splash-on')}catch(e){r.dataset.splash=SPLASH_VARIANT;r.classList.add('splashing','splash-on')}})();
