// ===== SPLASH (runs before the hero; disposes itself on exit) =====
import * as THREE from 'three';
import {RoundedBoxGeometry} from 'three/addons/geometries/RoundedBoxGeometry.js';
import {EffectComposer} from 'three/addons/postprocessing/EffectComposer.js';
import {RenderPass} from 'three/addons/postprocessing/RenderPass.js';
import {UnrealBloomPass} from 'three/addons/postprocessing/UnrealBloomPass.js';
import {OutputPass} from 'three/addons/postprocessing/OutputPass.js';
(()=>{
const root=document.documentElement,el=document.getElementById('splash');
if(!el||!root.classList.contains('splashing')){el&&el.remove();root.classList.remove('splash-on');return}
if(root.dataset.splash&&root.dataset.splash!=='particles')return;
if(new URLSearchParams(location.search).has('splashT'))window.__splashT=+new URLSearchParams(location.search).get('splashT');
const RM=matchMedia('(prefers-reduced-motion: reduce)').matches,MOB=innerWidth<700;
const MIN=RM?1200:4000,MAX=7000,T0=performance.now();
// --- real loading progress: fonts, window load, hero first frame
const P={fonts:0,load:0,hero:0};
document.fonts&&document.fonts.ready.then(()=>P.fonts=1);
if(document.readyState==='complete')P.load=1;else addEventListener('load',()=>P.load=1);
const realP=()=>(P.fonts*.3+P.load*.4+(window.__heroReady?1:0)*.3);
const pctEl=document.getElementById('sPct'),bar=document.getElementById('sBar');let shown=0,done=false;
// --- name scramble
const NAME='Amaanullah.',nameEl=document.getElementById('sName');
NAME.split('').forEach(c=>{const s=document.createElement('span');s.textContent=c;if(c==='.')s.className='dot';s.setAttribute('aria-hidden','true');nameEl.appendChild(s)});
const GL='{}<>/;=#*01ABXZ$';
function scramble(){[...nameEl.children].forEach((s,i)=>{const fin=s.textContent;let n=0;setTimeout(()=>{s.classList.add('on','scr');const iv=setInterval(()=>{s.textContent=GL[Math.random()*GL.length|0];if(++n>6+i){clearInterval(iv);s.textContent=fin;s.classList.remove('scr')}},40)},i*70)})}
const stage=(c,ms)=>setTimeout(()=>el.classList.add(c),ms);
// --- optional sound (off by default; enable with localStorage.setItem('sound','on'))
function chime(){try{if(localStorage.getItem('sound')!=='on')return;const a=new AudioContext(),o=a.createOscillator(),g=a.createGain();o.type='sine';o.frequency.setValueAtTime(220,a.currentTime);o.frequency.exponentialRampToValueAtTime(880,a.currentTime+.6);g.gain.setValueAtTime(.0001,a.currentTime);g.gain.exponentialRampToValueAtTime(.06,a.currentTime+.1);g.gain.exponentialRampToValueAtTime(.0001,a.currentTime+1);o.connect(g).connect(a.destination);o.start();o.stop(a.currentTime+1)}catch(e){}}
function finish(){try{sessionStorage.setItem('splashSeen','1')}catch(e){}root.classList.remove('splashing');window.dispatchEvent(new Event('splashend'))}
document.getElementById('sSkip').onclick=()=>exit(true);
addEventListener('keydown',function k(e){if(e.key==='Escape'){removeEventListener('keydown',k);exit(true)}});

// --- reduced motion: simple fade
if(RM){el.classList.add('rm','t1','t3');[...nameEl.children].forEach(s=>s.classList.add('on'));
 const tick=()=>{const t=performance.now()-T0;shown=Math.round(Math.min(realP(),t/MIN)*100);pctEl.textContent=shown;bar.style.width=shown+'%';if((realP()>=1&&t>=MIN)||t>=MAX)exit();else if(!done)requestAnimationFrame(tick)};tick();
 var exit=()=>{if(done)return;done=true;finish();el.style.transition='opacity .5s';el.style.opacity=0;setTimeout(()=>{el.remove();root.classList.remove('splash-on')},550)};return}

// --- WebGL scene
const canvas=document.getElementById('splashC');
const R=new THREE.WebGLRenderer({canvas,antialias:!MOB,alpha:true,powerPreference:'high-performance'});R.setPixelRatio(Math.min(devicePixelRatio,MOB?1.5:2));
const BGD=new THREE.Color(0x0c0907),BGM=new THREE.Color(0xd98a52),BGC=new THREE.Color(0xfbf4ec);const scene=new THREE.Scene();scene.background=BGD.clone();const cam=new THREE.PerspectiveCamera(40,1,.1,200);cam.position.set(0,0,MOB?15:11);
scene.add(new THREE.AmbientLight(0xffffff,.5));const dl=new THREE.DirectionalLight(0xffffff,1.4);dl.position.set(3,5,6);scene.add(dl);const pl=new THREE.PointLight(0xff7a2a,0,12);scene.add(pl);
const comp=new EffectComposer(R);comp.addPass(new RenderPass(scene,cam));const bloom=new UnrealBloomPass(new THREE.Vector2(1,1),.75,.45,.55);comp.addPass(bloom);comp.addPass(new OutputPass());
function size(){const w=innerWidth,h=innerHeight;R.setSize(w,h,false);comp.setSize(w,h);cam.aspect=w/h;cam.updateProjectionMatrix()}size();addEventListener('resize',size);
const tex=(draw,w=128,h=128)=>{const c=document.createElement('canvas');c.width=w;c.height=h;draw(c.getContext('2d'),w,h);const t=new THREE.CanvasTexture(c);t.colorSpace=THREE.SRGBColorSpace;return t};
const dotT=tex((g,w,h)=>{const r=g.createRadialGradient(w/2,h/2,0,w/2,h/2,w/2);r.addColorStop(0,'rgba(255,255,255,1)');r.addColorStop(.25,'rgba(255,200,150,.8)');r.addColorStop(1,'rgba(255,140,60,0)');g.fillStyle=r;g.fillRect(0,0,w,h)},64,64);
const neb=new THREE.Sprite(new THREE.SpriteMaterial({map:dotT,color:0x5a2a0c,transparent:true,opacity:.55,depthWrite:false,blending:THREE.AdditiveBlending}));neb.position.z=-30;neb.scale.setScalar(70);scene.add(neb);
const world=new THREE.Group();scene.add(world);world.position.y=MOB?1.6:.85;
// starfield
{const n=MOB?500:1400,a=new Float32Array(n*3);for(let i=0;i<n;i++){a[i*3]=(Math.random()-.5)*120;a[i*3+1]=(Math.random()-.5)*80;a[i*3+2]=-20-Math.random()*60}
 const g=new THREE.BufferGeometry();g.setAttribute('position',new THREE.BufferAttribute(a,3));scene.add(new THREE.Points(g,new THREE.PointsMaterial({size:.25,map:dotT,transparent:true,opacity:.55,depthWrite:false,blending:THREE.AdditiveBlending,color:0xffe7d0})))}
// assembling particles
const H=1.3,N=MOB?1800:5000,pos=new Float32Array(N*3),start=new Float32Array(N*3),target=new Float32Array(N*3),col=new Float32Array(N*3),del=new Float32Array(N);
const E=[];const c8=[[-1,-1,-1],[1,-1,-1],[1,1,-1],[-1,1,-1],[-1,-1,1],[1,-1,1],[1,1,1],[-1,1,1]];[[0,1],[1,2],[2,3],[3,0],[4,5],[5,6],[6,7],[7,4],[0,4],[1,5],[2,6],[3,7]].forEach(([a,b])=>E.push([c8[a],c8[b]]));
const cO=new THREE.Color(0xff7a2a),cW=new THREE.Color(0xfff2e4),cA=new THREE.Color(0xffb36b);
for(let i=0;i<N;i++){const r=6+Math.random()*18,th=Math.random()*Math.PI*2,ph=Math.acos(2*Math.random()-1);
 start[i*3]=r*Math.sin(ph)*Math.cos(th);start[i*3+1]=r*Math.sin(ph)*Math.sin(th)*.7;start[i*3+2]=Math.min(r*Math.cos(ph)-4,4);
 let x,y,z;if(Math.random()<.62){const [a,b]=E[Math.random()*12|0],t=Math.random();x=a[0]+(b[0]-a[0])*t;y=a[1]+(b[1]-a[1])*t;z=a[2]+(b[2]-a[2])*t}else{const f=Math.random()*6|0,u=Math.random()*2-1,v=Math.random()*2-1,s=f%2?1:-1;[x,y,z]=f<2?[s,u,v]:f<4?[u,s,v]:[u,v,s];if(Math.random()<.5){x*=.5;y*=.5;z*=.5}}
 target[i*3]=x*H;target[i*3+1]=y*H;target[i*3+2]=z*H;del[i]=Math.random()*.6;
 const c=Math.random()<.55?cO:Math.random()<.5?cW:cA;col[i*3]=c.r;col[i*3+1]=c.g;col[i*3+2]=c.b}
pos.set(start);const pg=new THREE.BufferGeometry();pg.setAttribute('position',new THREE.BufferAttribute(pos,3));pg.setAttribute('color',new THREE.BufferAttribute(col,3));
const pm=new THREE.PointsMaterial({size:MOB?.16:.13,map:dotT,vertexColors:true,transparent:true,depthWrite:false,blending:THREE.AdditiveBlending});const pts=new THREE.Points(pg,pm);world.add(pts);
// code glyph sprites
const glyphs=[];['{','}','<','/','>',';','=','</>','( )','[ ]'].forEach((ch,k)=>{const t=tex((g,w,h)=>{g.font='bold 64px monospace';g.textAlign='center';g.textBaseline='middle';g.shadowColor='#ff7a2a';g.shadowBlur=16;g.fillStyle=k%3?'#ffb27a':'#fff';g.fillText(ch,w/2,h/2)});
 for(let j=0;j<(MOB?2:4);j++){const s=new THREE.Sprite(new THREE.SpriteMaterial({map:t,transparent:true,depthWrite:false,blending:THREE.AdditiveBlending,opacity:0}));const r=5+Math.random()*9,a=Math.random()*Math.PI*2;s.userData={r,a,y:(Math.random()-.5)*7,sp:.1+Math.random()*.25};s.scale.setScalar(.35+Math.random()*.35);world.add(s);glyphs.push(s)}});
// cube
const cube=new THREE.Group();world.add(cube);
const edgeGeo=new THREE.EdgesGeometry(new THREE.BoxGeometry(2*H*.97,2*H*.97,2*H*.97));const edges=new THREE.LineSegments(edgeGeo,new THREE.LineBasicMaterial({color:0xffa060,transparent:true,opacity:1}));edges.geometry.setDrawRange(0,0);cube.add(edges);
const shell=new THREE.Mesh(new RoundedBoxGeometry(2*H,2*H,2*H,5,.22),new THREE.MeshPhysicalMaterial({color:0xffffff,roughness:.05,transparent:true,opacity:0,clearcoat:1,depthWrite:false,side:THREE.DoubleSide,emissive:0xff8a3d,emissiveIntensity:.05}));cube.add(shell);
const emb=tex((g,w,h)=>{const r=g.createLinearGradient(0,0,w,h);r.addColorStop(0,'#ff9a3c');r.addColorStop(1,'#e84a00');g.fillStyle=r;g.fillRect(0,0,w,h);g.strokeStyle='#fff';g.lineWidth=16;g.lineCap=g.lineJoin='round';g.shadowColor='#fff';g.shadowBlur=18;g.beginPath();g.moveTo(92,86);g.lineTo(52,128);g.lineTo(92,170);g.moveTo(164,86);g.lineTo(204,128);g.lineTo(164,170);g.moveTo(142,76);g.lineTo(114,180);g.stroke()},256,256);
const core=new THREE.Mesh(new RoundedBoxGeometry(1.4,1.4,1.4,4,.1),new THREE.MeshStandardMaterial({map:emb,emissiveMap:emb,emissive:0xffffff,emissiveIntensity:0,color:0xffffff,transparent:true,opacity:0}));cube.add(core);
const halo=new THREE.Sprite(new THREE.SpriteMaterial({map:dotT,transparent:true,opacity:0,depthWrite:false,blending:THREE.AdditiveBlending,color:0xff8a3d}));halo.scale.setScalar(7);world.add(halo);
// rings + orbs with trails
const rings=[];[[3.6,2.1,.35,0xff8a3d],[4.2,1.6,-.25,0xb9b4ff]].forEach(([a,b,tl,c])=>{const p=new THREE.EllipseCurve(0,0,a,b).getPoints(160).map(q=>new THREE.Vector3(q.x,0,q.y));const l=new THREE.LineLoop(new THREE.BufferGeometry().setFromPoints(p),new THREE.LineBasicMaterial({color:c,transparent:true,opacity:0}));l.rotation.set(1.25,0,tl);l.scale.setScalar(.01);world.add(l);rings.push(l)});
const orbs=[];[0xff7a22,0xffb27a,0x8c7cff,0xff9a4a].forEach((c,i)=>{const m=new THREE.Mesh(new THREE.SphereGeometry(.26,24,24),new THREE.MeshStandardMaterial({color:c,emissive:c,emissiveIntensity:1.4}));m.visible=false;world.add(m);
 const TL=28,tp=new Float32Array(TL*3),tg=new THREE.BufferGeometry();tg.setAttribute('position',new THREE.BufferAttribute(tp,3));const tr=new THREE.Line(tg,new THREE.LineBasicMaterial({color:c,transparent:true,opacity:.8,blending:THREE.AdditiveBlending}));tr.visible=false;world.add(tr);
 orbs.push({m,tr,tp,TL,ph:i*Math.PI/2,init:false})});
// timeline
const sm=(a,b,t)=>{t=Math.min(Math.max((t-a)/(b-a),0),1);return t*t*(3-2*t)};let exitT=null,handoff=null,raf;
let scr=false;const _m=new THREE.Color();const sbg=el.querySelector('.sbg');const _v=new THREE.Vector3(),_eu=new THREE.Euler(0,0,.35);window.__splashHideCube=true;
function frame(now){if(!el.isConnected)return;raf=requestAnimationFrame(frame);const _js0=performance.now();const MAN=window.__splashT!=null;const t=MAN?window.__splashT:(now-T0)/1000;
 if(t>=2.3)el.classList.add('t1');if(t>=2.6&&!scr){scr=true;scramble()}if(t>=3.3)el.classList.add('t3');if(t>=3.8)el.classList.add('t4');
 // progress
 const tp=Math.min(1,(now-T0)/MIN),rp=realP();const goal=Math.min(rp,tp)*100;shown+=(goal-shown)*.12;if(goal>=100&&shown>99.4)shown=100;
 pctEl.textContent=Math.round(shown);bar.style.width=shown+'%';
 if(MAN){shown=Math.min(100,t/(MIN/1000)*100)}
 if(!done&&!MAN&&((rp>=1&&now-T0>=MIN&&shown>=100)||now-T0>=MAX))exit();
 // drift → converge
 const cv=sm(1.0,2.6,t),swirl=t*.25;
 for(let i=0;i<N;i++){const k=sm(1.0+del[i],2.4+del[i],t),i3=i*3,sx=start[i3],sz=start[i3+2];const ca=Math.cos(swirl*(1-k)),sa=Math.sin(swirl*(1-k));
  const dx=sx*ca-sz*sa,dz=sx*sa+sz*ca;pos[i3]=dx+(target[i3]-dx)*k;pos[i3+1]=start[i3+1]+Math.sin(t+i)*.15*(1-k)+(target[i3+1]-start[i3+1])*k;pos[i3+2]=dz+(target[i3+2]-dz)*k}
 pg.attributes.position.needsUpdate=true;pm.opacity=1-sm(2.6,3.4,t)*.85;pm.size=(MOB?.16:.13)*(1-.45*cv);
 glyphs.forEach(s=>{const u=s.userData;u.a+=u.sp*.01;const k=sm(1.4,2.8,t),r=u.r*(1-k*.3);s.position.set(Math.cos(u.a+t*.2)*r,u.y*(1-k),Math.sin(u.a+t*.2)*r-1);s.material.opacity=sm(.1,.8,t)*(1-sm(1.6,2.3,t))*.55});
 // cube build
 edges.geometry.setDrawRange(0,Math.floor(sm(2.0,2.9,t)*24));shell.material.opacity=sm(2.5,3.3,t)*.16;
 const pulse=.5+.5*Math.sin(t*3.2),ig=sm(2.7,3.3,t);core.material.opacity=sm(2.3,2.9,t);core.material.emissiveIntensity=ig*(.22+.18*pulse)+sm(3.0,3.15,t)*(1-sm(3.15,3.6,t))*.7;
 halo.material.opacity=sm(2.2,3.0,t)*(.18+.1*pulse);halo.scale.setScalar(5+pulse*1.2);pl.intensity=ig*8;bloom.strength=.75-sm(3,4,t)*.25;
 if(exitT===null){cube.rotation.y=t*.45;cube.rotation.x=-.42+Math.sin(t*.6)*.07;world.rotation.y=Math.sin(t*.2)*.15}
 rings.forEach((l,i)=>{const k=sm(3.0+i*.15,3.8+i*.15,t);l.scale.setScalar(.01+k);l.material.opacity=k*.7;l.rotation.y=t*.1*(i?-1:1)});
 orbs.forEach((o,i)=>{const s0=3.2+i*.12,k=sm(s0,s0+.7,t);if(t<s0)return;o.m.visible=o.tr.visible=true;const a=o.ph+t*.9,R0=3.9,rad=R0+(1-k)*14;
  const p=_v.set(Math.cos(a)*rad,Math.sin(a)*1.4*(1-k*.4)+(1-k)*6*(i%2?1:-1),Math.sin(a)*1.6).applyEuler(_eu);o.m.position.copy(p);
  if(!o.init){for(let j=0;j<o.TL;j++){o.tp[j*3]=p.x;o.tp[j*3+1]=p.y;o.tp[j*3+2]=p.z}o.init=true}o.tp.copyWithin(3,0,(o.TL-1)*3);o.tp[0]=p.x;o.tp[1]=p.y;o.tp[2]=p.z;o.tr.geometry.attributes.position.needsUpdate=true});
 // exit: glide cube to the hero cube's screen position, fade bg, flash
 if(exitT!==null){const e=Math.min(t-exitT,1.4);const k=sm(0,1,e);if(e>=.7&&!el.classList.contains('fl0')){el.classList.add('fl0','flash');finish()}if(e>=1&&!el.classList.contains('gone')){el.classList.remove('flash');el.classList.add('gone');window.__splashHideCube=false}
  if(k<.45)scene.background.lerpColors(BGD,BGM,sm(0,.45,k)*.55);else scene.background.lerpColors(_m.lerpColors(BGD,BGM,.55),BGC,sm(.45,1,k));neb.material.opacity=.55*(1-k);bloom.strength=.5*(1-k);
  if(handoff){world.position.lerpVectors(handoff.p0,handoff.p1,k);world.scale.setScalar(1+(handoff.s-1)*k);world.rotation.y*=1-k;const hr=window.__heroCubeScreen&&window.__heroCubeScreen();if(hr){const dy=((hr.ry-cube.rotation.y)%(2*Math.PI)+3*Math.PI)%(2*Math.PI)-Math.PI;cube.rotation.y+=dy*k;cube.rotation.x+=(hr.rx-cube.rotation.x)*k}}
  rings.forEach(l=>l.material.opacity*=1-k);orbs.forEach(o=>{o.m.material.opacity=1-k;o.m.material.transparent=true;o.tr.material.opacity=.8*(1-k)});pm.opacity*=1-k;
  if(e>=1.4){cleanup();return}}
 (window.__splashJs||(window.__splashJs=[])).push(performance.now()-_js0);comp.render()}
raf=requestAnimationFrame(frame);
// safety: if the device is too slow to finish the timeline, end cleanly by wall-clock
const safety=setTimeout(()=>{if(window.__splashT==null)exit(true)},MAX+2500);
function heroTarget(){const h=window.__heroCubeScreen&&window.__heroCubeScreen();if(!h)return null;
 const d=cam.position.z,vh=2*d*Math.tan(THREE.MathUtils.degToRad(cam.fov/2)),vw=vh*cam.aspect;
 const p1=new THREE.Vector3((h.x/innerWidth-.5)*vw,(.5-h.y/innerHeight)*vh+cam.position.y,0);const splashPx=(2*H)/vh*innerHeight;return{p0:world.position.clone(),p1,s:Math.max(.25,h.size/splashPx)}}
var exit=function(skip){if(done)return;done=true;chime();
 if(skip){window.__splashHideCube=false;el.classList.add('exit','flash');finish();el.style.transition='opacity .45s ease';setTimeout(()=>{el.style.opacity=0;setTimeout(cleanup,480)},150);return}
 sbg.style.display='none';handoff=heroTarget();window.__handoff=handoff&&{p1:handoff.p1.toArray(),s:handoff.s,hero:window.__heroCubeScreen&&window.__heroCubeScreen()};exitT=window.__splashT!=null?window.__splashT:(performance.now()-T0)/1000;el.classList.add('exit');
 if(handoff){el.style.setProperty('--fx',(50+handoff.p1.x/(2*cam.position.z*Math.tan(THREE.MathUtils.degToRad(20))*cam.aspect)*100)+'%');}
 };
window.__splashExit=()=>exit();
function cleanup(){clearTimeout(safety);if(!el.isConnected)return;root.classList.remove('splash-on');window.__splashHideCube=false;cancelAnimationFrame(raf);removeEventListener('resize',size);
 scene.traverse(o=>{o.geometry&&o.geometry.dispose();if(o.material){[].concat(o.material).forEach(m=>{m.map&&m.map.dispose();m.emissiveMap&&m.emissiveMap.dispose();m.dispose()})}});
 comp.dispose&&comp.dispose();R.dispose();R.forceContextLoss();el.remove();window.__splashDisposed=true}
})();
