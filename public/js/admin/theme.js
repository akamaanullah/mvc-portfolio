/* Admin theme boot (runs in <head>): dark by default, saved in localStorage.adminTheme */
(function(){var t;try{t=localStorage.getItem('adminTheme')}catch(e){}var d=document.documentElement;d.setAttribute('data-theme',t==='light'?'light':'dark');try{if(localStorage.getItem('adminSbMini')==='1')d.classList.add('sbm')}catch(e){}})();
