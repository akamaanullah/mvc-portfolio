document.getElementById('yr').textContent=new Date().getFullYear();
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target)}}),{threshold:.12});
document.querySelectorAll('.fade').forEach((el,i)=>{el.style.transitionDelay=(i%4)*70+'ms';io.observe(el)});
document.getElementById('btt').onclick=()=>scrollTo({top:0,behavior:'smooth'});
