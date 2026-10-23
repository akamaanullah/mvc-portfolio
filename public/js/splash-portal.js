// ===== SPLASH PORTAL (wormhole variant; runs before the hero; disposes itself on exit) =====
import * as THREE from 'three';
import {RoundedBoxGeometry} from 'three/addons/geometries/RoundedBoxGeometry.js';
import {EffectComposer} from 'three/addons/postprocessing/EffectComposer.js';
import {RenderPass} from 'three/addons/postprocessing/RenderPass.js';
import {UnrealBloomPass} from 'three/addons/postprocessing/UnrealBloomPass.js';
import {OutputPass} from 'three/addons/postprocessing/OutputPass.js';
(()=>{
const root=document.documentElement,el=document.getElementById('splash');
if(!el||!root.classList.contains('splashing')){el&&el.remove();root.classList.remove('splash-on');return}
if(root.dataset.splash!=='portal')return;
el.classList.add('sportal');
const Q=new URLSearchParams(location.search);if(Q.has('splashT'))window.__splashT=+Q.get('splashT');
const RM=matchMedia('(prefers-reduced-motion: reduce)').matches,MOB=innerWidth<700;
const MIN=RM?1200:7000,MAX=9000,T0=performance.now();
// --- real loading progress: fonts, window load, hero first frame
const P={fonts:0,load:0};
document.fonts&&document.fonts.ready.then(()=>P.fonts=1);
if(document.readyState==='complete')P.load=1;else addEventListener('load',()=>P.load=1);
const realP=()=>(P.fonts*.3+P.load*.4+(window.__heroReady?1:0)*.3);
const pctEl=document.getElementById('sPct'),bar=document.getElementById('sBar');let shown=0,done=false;
// --- name decode
const NAME='Amaanullah.',nameEl=document.getElementById('sName');
NAME.split('').forEach(c=>{const s=document.createElement('span');s.textContent=c;if(c==='.')s.className='dot';s.setAttribute('aria-hidden','true');nameEl.appendChild(s)});
const GL='{}<>/;=#*01ABXZ$';
function scramble(){[...nameEl.children].forEach((s,i)=>{const fin=s.textContent;let n=0;setTimeout(()=>{s.classList.add('on','scr');const iv=setInterval(()=>{s.textContent=GL[Math.random()*GL.length|0];if(++n>6+i){clearInterval(iv);s.textContent=fin;s.classList.remove('scr')}},40)},i*60)})}
// --- optional sound, tied to the site's sound toggle (off by default)
function chime(){try{if(localStorage.getItem('sound')!=='on')return;const a=new AudioContext(),o=a.createOscillator(),g=a.createGain();o.type='sine';o.frequency.setValueAtTime(160,a.currentTime);o.frequency.exponentialRampToValueAtTime(960,a.currentTime+.7);g.gain.setValueAtTime(.0001,a.currentTime);g.gain.exponentialRampToValueAtTime(.05,a.currentTime+.12);g.gain.exponentialRampToValueAtTime(.0001,a.currentTime+1.1);o.connect(g).connect(a.destination);o.start();o.stop(a.currentTime+1.1)}catch(e){}}
function finish(){try{sessionStorage.setItem('splashSeen','1')}catch(e){}root.classList.remove('splashing');window.dispatchEvent(new Event('splashend'))}
document.getElementById('sSkip').onclick=()=>exit(true);
addEventListener('keydown',function k(e){if(e.key==='Escape'){removeEventListener('keydown',k);exit(true)}});
// --- reduced motion: simple fade
if(RM){el.classList.add('rm','t1','t3');[...nameEl.children].forEach(s=>s.classList.add('on'));
 const tick=()=>{const t=performance.now()-T0;shown=Math.round(Math.min(realP(),t/MIN)*100);pctEl.textContent=shown;bar.style.width=shown+'%';if((realP()>=1&&t>=MIN)||t>=MAX)exit();else if(!done)requestAnimationFrame(tick)};tick();
 var exit=()=>{if(done)return;done=true;finish();el.style.transition='opacity .5s';el.style.opacity=0;setTimeout(()=>{el.remove();root.classList.remove('splash-on')},550)};return}

// --- WebGL scene (camera stays at the origin looking down -Z; the tunnel flows toward it)
const canvas=document.getElementById('splashC');
const R=new THREE.WebGLRenderer({canvas,antialias:!MOB,powerPreference:'high-performance'});R.setPixelRatio(Math.min(devicePixelRatio,MOB?1.5:2));
const BGD=new THREE.Color(0x0a0706),BGO=new THREE.Color(0xf07a2e),BGP=new THREE.Color(0xffc9a2),BGW=new THREE.Color(0xfff0dc),BGC=new THREE.Color(0xfbf4ec);
const scene=new THREE.Scene();scene.background=BGD.clone();const FOV0=48;const cam=new THREE.PerspectiveCamera(FOV0,1,.05,200);
scene.add(new THREE.AmbientLight(0xffffff,.6));const dl=new THREE.DirectionalLight(0xffffff,1.4);dl.position.set(3,5,6);scene.add(dl);
const comp=new EffectComposer(R);comp.addPass(new RenderPass(scene,cam));const bloom=new UnrealBloomPass(new THREE.Vector2(1,1),.75,.45,.72);comp.addPass(bloom);comp.addPass(new OutputPass());
function size(){const w=innerWidth,h=innerHeight;R.setSize(w,h,false);comp.setSize(w,h);cam.aspect=w/h;cam.updateProjectionMatrix();window.__fitP&&window.__fitP()}size();addEventListener('resize',size);
const ctex=(draw,w=128,h=128)=>{const c=document.createElement('canvas');c.width=w;c.height=h;draw(c.getContext('2d'),w,h);const t=new THREE.CanvasTexture(c);t.colorSpace=THREE.SRGBColorSpace;return t};
const dotT=ctex((g,w,h)=>{const r=g.createRadialGradient(w/2,h/2,0,w/2,h/2,w/2);r.addColorStop(0,'rgba(255,255,255,1)');r.addColorStop(.25,'rgba(255,205,160,.75)');r.addColorStop(1,'rgba(255,140,60,0)');g.fillStyle=r;g.fillRect(0,0,w,h)},64,64);
const ADD={transparent:true,depthWrite:false,blending:THREE.AdditiveBlending};
const sm=(a,b,t)=>{t=Math.min(Math.max((t-a)/(b-a),0),1);return t*t*(3-2*t)};
// distance travelled: speed eases from 0 (t=.9) to VMAX (t=.9+RAMP), closed form so the timeline is frame-rate independent
// speed eases up after the dive and dips smoothly at each project focus; distance is integrated once into a table
const VMAX=MOB?30:34,TS=.9,RAMP=1.5,DIP=.74,FT=[2.7,3.6,4.5,5.4,6.3];
const vel=t=>{let b=0;for(let k=0;k<5;k++){const x=(t-FT[k]-.05)/.32;b+=Math.exp(-x*x)}return VMAX*sm(TS,TS+RAMP,t)*(1-DIP*Math.min(b,1))};
const DTS=1/240,NT=12*240+1,DTab=new Float32Array(NT);for(let i=1;i<NT;i++)DTab[i]=DTab[i-1]+(vel((i-1)*DTS)+vel(i*DTS))*.5*DTS;
const D=t=>{if(t<=0)return 0;const f=t/DTS;if(f>=NT-1)return DTab[NT-1]+VMAX*(t-(NT-1)*DTS);const i=f|0;return DTab[i]+(DTab[i+1]-DTab[i])*(f-i)};
const SPD=t=>vel(t)/VMAX;
const L=80,RAD=3.2,RING_Z=-5.5;
// --- portal ring
const portal=new THREE.Group();scene.add(portal);
const RR=1.35,rp=[];for(let i=0;i<=200;i++){const a=i/200*Math.PI*2+Math.PI/2;rp.push(new THREE.Vector3(Math.cos(a)*RR,Math.sin(a)*RR,0))}
const ringLine=new THREE.Line(new THREE.BufferGeometry().setFromPoints(rp),new THREE.LineBasicMaterial({color:0xffc89a,...ADD}));ringLine.geometry.setDrawRange(0,0);portal.add(ringLine);
const ringGlowT=ctex((g,w,h)=>{const r=g.createRadialGradient(w/2,h/2,w*.30,w/2,h/2,w*.5);r.addColorStop(0,'rgba(255,120,30,0)');r.addColorStop(.44,'rgba(255,130,50,.35)');r.addColorStop(.5,'rgba(255,236,214,1)');r.addColorStop(.56,'rgba(255,120,30,.35)');r.addColorStop(1,'rgba(255,90,20,0)');g.fillStyle=r;g.fillRect(0,0,w,h)},256,256);
const ringGlow=new THREE.Sprite(new THREE.SpriteMaterial({map:ringGlowT,...ADD,opacity:0}));ringGlow.scale.setScalar(4.1);portal.add(ringGlow);
// energy swirl + shimmer inside the ring
const swirlU={uT:{value:0},uO:{value:0}};
const swirl=new THREE.Mesh(new THREE.CircleGeometry(RR*1.02,64),new THREE.ShaderMaterial({uniforms:swirlU,...ADD,
 vertexShader:'varying vec2 vU;void main(){vU=uv*2.-1.;gl_Position=projectionMatrix*modelViewMatrix*vec4(position,1.);}',
 fragmentShader:`uniform float uT,uO;varying vec2 vU;void main(){float r=length(vU),a=atan(vU.y,vU.x);
  float sp=sin(a*3.-r*9.+uT*4.+sin(r*14.-uT*3.)*.35);float arms=smoothstep(.2,1.,sp)*.8;
  float shim=.5+.5*sin(r*40.-uT*9.+a*2.);float edge=smoothstep(1.,.75,r);float core=smoothstep(.55,0.,r);
  vec3 c=mix(vec3(1.,.42,.12),vec3(.75,.68,1.),smoothstep(.2,.9,r)*.45);c=mix(c,vec3(1.,.95,.88),core*.6);
  float al=(arms*(.25+.35*r)+shim*.06+core*.35)*edge*uO;gl_FragColor=vec4(c*al,al);}`}));portal.add(swirl);
// sparks thrown off the ring (deterministic from t: no per-frame allocation)
const NS=MOB?160:340,sPos=new Float32Array(NS*3),sSeed=new Float32Array(NS*3);for(let i=0;i<NS;i++){sSeed[i*3]=Math.random()*Math.PI*2;sSeed[i*3+1]=Math.random();sSeed[i*3+2]=.6+Math.random()*1.2}
const sg=new THREE.BufferGeometry();sg.setAttribute('position',new THREE.BufferAttribute(sPos,3));
const sparkM=new THREE.PointsMaterial({size:.07,map:dotT,color:0xffb070,...ADD,opacity:0});portal.add(new THREE.Points(sg,sparkM));
portal.position.z=RING_Z;
// fit the portal (and text-safe area) to any viewport: ring stays fully visible and centred
function fitPortal(){const hh=Math.abs(RING_Z)*Math.tan(THREE.MathUtils.degToRad(FOV0/2)),hw=hh*cam.aspect;portal.scale.setScalar(Math.min(1,.52*Math.min(hw,hh)/(RR*1.25)))}fitPortal();window.__fitP=fitPortal;
// --- tunnel: open cylinder with flowing energy lanes (shader), fades into the distance
const tunU={uT:{value:0},uD:{value:0},uO:{value:0},uCut:{value:RING_Z},uS:{value:0}};
const tg=new THREE.CylinderGeometry(RAD,RAD,L,MOB?40:64,1,true);tg.rotateX(Math.PI/2);tg.translate(0,0,-L/2+2);
const tunnel=new THREE.Mesh(tg,new THREE.ShaderMaterial({uniforms:tunU,side:THREE.BackSide,...ADD,
 vertexShader:'varying vec3 vW;varying vec2 vU;void main(){vU=uv;vW=position;gl_Position=projectionMatrix*modelViewMatrix*vec4(position,1.);}',
 fragmentShader:`uniform float uT,uD,uO,uCut,uS;varying vec3 vW;varying vec2 vU;
  float h1(float n){return fract(sin(n*91.73)*43758.55);}
  void main(){if(vW.z>uCut)discard;float q=vW.z-uD;float a=fract(vU.x+q*.004+uT*.01)*56.;float id=floor(a),f=fract(a);
   float h=h1(id),lane=pow(1.-abs(f-.5)*2.,10.);
   float d=fract(q*(.012+h*.02)+h*7.+uT*.05);float len=.18+uS*.5;float seg=smoothstep(0.,.04,d)*(1.-smoothstep(len*.5,len,d));
   vec3 c=h<.55?vec3(1.,.45,.13):h<.8?vec3(1.,.93,.84):vec3(.72,.66,1.);
   float depth=-vW.z;float fade=smoothstep(L_,18.,depth)*smoothstep(-1.,4.,depth);
   float haze=.05+.04*sin(q*.15+vU.x*25.);
   float al=(lane*seg*(.55+.45*h)+haze)*fade*uO;gl_FragColor=vec4(c*al,al);}`.replace('L_','78.')}));
scene.add(tunnel);
// --- concentric ring segments flowing past
const segs=[];const NSEG=MOB?8:14;for(let i=0;i<NSEG;i++){const th=1.2+Math.random()*2.6;const m=new THREE.Mesh(new THREE.RingGeometry(RAD*.93,RAD*.96,64,1,0,th),new THREE.MeshBasicMaterial({color:i%4===0?0xb9b0ff:i%3?0xff8a3d:0xfff0e0,...ADD,opacity:0,side:THREE.DoubleSide}));m.rotation.z=Math.random()*Math.PI*2;m.userData={z0:i*(L/NSEG),w:(Math.random()-.5)*.6};scene.add(m);segs.push(m)}
// --- warp streaks (line segments stretched by speed)
const NK=MOB?280:650,kp=new Float32Array(NK*6),kc=new Float32Array(NK*6),kd=new Float32Array(NK*3);
const cO=new THREE.Color(0xff7a2a),cW=new THREE.Color(0xfff2e4),cL=new THREE.Color(0xa99cff);
for(let i=0;i<NK;i++){const a=Math.random()*Math.PI*2,r=.7+Math.pow(Math.random(),.5)*(RAD-.9);kd[i*3]=a;kd[i*3+1]=r;kd[i*3+2]=Math.random()*L;const c=Math.random()<.5?cO:Math.random()<.7?cW:cL;
 kc[i*6]=c.r;kc[i*6+1]=c.g;kc[i*6+2]=c.b;kc[i*6+3]=c.r*.05;kc[i*6+4]=c.g*.05;kc[i*6+5]=c.b*.05;kp[i*6]=kp[i*6+3]=Math.cos(a)*r;kp[i*6+1]=kp[i*6+4]=Math.sin(a)*r}
const kg=new THREE.BufferGeometry();kg.setAttribute('position',new THREE.BufferAttribute(kp,3));kg.setAttribute('color',new THREE.BufferAttribute(kc,3));
const streakM=new THREE.LineBasicMaterial({vertexColors:true,...ADD,opacity:0});const streaks=new THREE.LineSegments(kg,streakM);streaks.frustumCulled=false;scene.add(streaks);
// --- code glyphs drifting on the walls
const glyphs=[];['{ }','</>',';','=>','[ ]','#','( )','01','/>','&&'].forEach((ch,k)=>{const t=ctex((g,w,h)=>{g.font='bold 54px monospace';g.textAlign='center';g.textBaseline='middle';g.shadowColor='#ff7a2a';g.shadowBlur=14;g.fillStyle=k%3?'#ffb27a':'#fff4e8';g.fillText(ch,w/2,h/2)});
 for(let j=0;j<(MOB?1:2);j++){const s=new THREE.Sprite(new THREE.SpriteMaterial({map:t,...ADD,opacity:0}));const a=Math.random()*Math.PI*2;s.position.set(Math.cos(a)*RAD*.82,Math.sin(a)*RAD*.82,0);s.userData={z0:Math.random()*L};s.scale.setScalar(.55);scene.add(s);glyphs.push(s)}});
// --- project panels (glass cards with the placeholder screenshots)
// EDIT: project names + category tags shown during the fly-by focus
const PRJ=[['crm-1.svg','Multi-tenant CRM','CRM Platform'],['chatrox.svg','Chatrox','Chat Application'],['rtg-workspace.svg','RTG Workspace','Web Application'],['it-hardware-bin.svg','IT Hardware Bin','E-Commerce'],['landsfy.svg','Landsfy','Web Application']];
// panels alternate left/right, slightly below the camera path; camera gets a brief cinematic focus on each
const SIDE=[-1,1,-1,1,-1],PX=MOB?.5:1.75,PY=MOB?-.42:-.55,ZF=MOB?7.2:5.8,PS=MOB?.56:1;
const rr=(g,x,y,w,h,r)=>{g.beginPath();g.roundRect?g.roundRect(x,y,w,h,r):g.rect(x,y,w,h)};
const glowT=ctex((g,w,h)=>{g.shadowColor='#ff7a1a';g.shadowBlur=28;g.strokeStyle='rgba(255,150,70,1)';g.lineWidth=6;rr(g,34,34,w-68,h-68,40);g.stroke();g.shadowBlur=0;g.strokeStyle='rgba(255,236,214,.9)';g.lineWidth=2;rr(g,34,34,w-68,h-68,40);g.stroke()},720,550);
const panels=PRJ.map(([src,label,tag],i)=>{const c=document.createElement('canvas');c.width=640;c.height=470;const g=c.getContext('2d');
 const paint=img=>{g.clearRect(0,0,640,470);rr(g,4,4,632,462,30);g.fillStyle='rgba(255,246,236,.12)';g.fill();g.lineWidth=3;g.strokeStyle='rgba(255,200,160,.7)';g.stroke();
  g.save();rr(g,22,22,596,360,18);g.clip();if(img)g.drawImage(img,22,22,596,360);else{g.fillStyle='#2a1a10';g.fillRect(22,22,596,360)}g.restore();
  g.fillStyle='rgba(255,255,255,.55)';[0,1,2].forEach(k=>{g.beginPath();g.arc(44+k*20,426,6,0,7);g.fill()});g.fillStyle='rgba(255,220,190,.35)';rr(g,420,418,196,16,8);g.fill()};
 paint(null);const t=new THREE.CanvasTexture(c);t.colorSpace=THREE.SRGBColorSpace;t.anisotropy=4;
 const img=new Image();img.onload=()=>{paint(img);t.needsUpdate=true};img.src='images/'+src;
 const m=new THREE.Mesh(new THREE.PlaneGeometry(2.2,2.2*470/640),new THREE.MeshBasicMaterial({map:t,transparent:true,opacity:0,depthWrite:false,color:0xa89f98,side:THREE.DoubleSide}));
 m.position.set(SIDE[i]*PX,PY,0);m.rotation.set(-.2,-SIDE[i]*(MOB?.3:.5),0,'YXZ');m.userData={tk:FT[i],label,tag,w:0};m.scale.setScalar(PS);
 const gl=new THREE.Mesh(new THREE.PlaneGeometry(2.2*720/640*1.0,2.2*550/640),new THREE.MeshBasicMaterial({map:glowT,...ADD,opacity:0}));gl.position.z=-.01;m.add(gl);m.userData.glow=gl;scene.add(m);return m});
// focus label (DOM: crisp text) + soft vignette that de-emphasises everything but the focused panel
const foc=document.createElement('div');foc.className='sfoc';foc.innerHTML='<i></i><b></b>';el.appendChild(foc);const focB=foc.querySelector('b'),focI=foc.querySelector('i');let focK=-1;
const vig=document.createElement('div');vig.className='svig';el.insertBefore(vig,el.querySelector('.sflash'));
// camera path: Catmull-Rom splines (position + look-at) through centre → panel → centre … sampled by time
const CT0=FT[0]-.9,CDT=.45,cpP=[],cpL=[],CEN=new THREE.Vector3(0,0,0),CENL=new THREE.Vector3(0,0,-12);
cpP.push(CEN.clone(),CEN.clone());cpL.push(CENL.clone(),CENL.clone());
FT.forEach((tk,k)=>{cpP.push(new THREE.Vector3(SIDE[k]*PX*(MOB?.3:.55),MOB?.1:.14,0));cpL.push(new THREE.Vector3(SIDE[k]*PX*(MOB?.75:1),PY*.95,-ZF*1.05));if(k<4){cpP.push(CEN.clone());cpL.push(CENL.clone())}});
cpP.push(CEN.clone(),CEN.clone());cpL.push(CENL.clone(),CENL.clone());
const camCurve=new THREE.CatmullRomCurve3(cpP,false,'centripetal'),lookCurve=new THREE.CatmullRomCurve3(cpL,false,'centripetal'),CTN=(cpP.length-1)*CDT;
const _cp=new THREE.Vector3(),_lt=new THREE.Vector3(),_lp=new THREE.Vector3();
// --- service orbs (glowing icons streaking by)
const icon=(k)=>ctex((g,w,h)=>{const r=g.createRadialGradient(64,64,0,64,64,64);r.addColorStop(0,'rgba(255,190,130,.95)');r.addColorStop(.45,'rgba(242,106,27,.75)');r.addColorStop(1,'rgba(242,106,27,0)');g.fillStyle=r;g.fillRect(0,0,128,128);
 g.strokeStyle=g.fillStyle='#fff';g.lineWidth=6;g.lineCap=g.lineJoin='round';g.beginPath();
 if(k===0){g.moveTo(48,48);g.lineTo(32,64);g.lineTo(48,80);g.moveTo(80,48);g.lineTo(96,64);g.lineTo(80,80);g.moveTo(70,42);g.lineTo(58,86);g.stroke()}
 else if(k===1){[[40,72,10,16],[58,58,10,30],[76,48,10,40]].forEach(b=>g.fillRect(...b))}
 else if(k===2){rr(g,36,42,56,38,12);g.stroke();g.beginPath();g.moveTo(50,80);g.lineTo(44,92);g.lineTo(62,80);g.stroke()}
 else{g.arc(64,64,14,0,7);g.stroke();for(let s=0;s<8;s++){const a=s*Math.PI/4;g.beginPath();g.moveTo(64+Math.cos(a)*20,64+Math.sin(a)*20);g.lineTo(64+Math.cos(a)*28,64+Math.sin(a)*28);g.stroke()}}},128,128);
const OT=[3.15,4.05,4.95,5.85],OA=[.6,3.6,1.9,5.0];
const orbs=OT.map((tk,i)=>{const s=new THREE.Sprite(new THREE.SpriteMaterial({map:icon(i),...ADD,opacity:0}));s.scale.setScalar(.62);const a=OA[i],r=MOB?.95:1.35;s.position.set(Math.cos(a)*r,Math.sin(a)*r,0);
 const tp=new Float32Array(6);tp[0]=tp[3]=s.position.x;tp[1]=tp[4]=s.position.y;const g=new THREE.BufferGeometry();g.setAttribute('position',new THREE.BufferAttribute(tp,3));
 const tr=new THREE.Line(g,new THREE.LineBasicMaterial({color:i===2?0xb9b0ff:0xffa060,...ADD,opacity:0}));tr.frustumCulled=false;scene.add(s,tr);return{s,tr,tp,tk}});
// --- light at the end of the tunnel
const endL=new THREE.Sprite(new THREE.SpriteMaterial({map:dotT,color:0xfff1e0,...ADD,opacity:0}));endL.position.z=-60;endL.scale.setScalar(10);scene.add(endL);
// --- hero glass cube that materializes from the burst
const H=1.3,cube=new THREE.Group();cube.visible=false;scene.add(cube);
const edges=new THREE.LineSegments(new THREE.EdgesGeometry(new THREE.BoxGeometry(2*H*.97,2*H*.97,2*H*.97)),new THREE.LineBasicMaterial({color:0xffa060,transparent:true,opacity:0}));cube.add(edges);
const shell=new THREE.Mesh(new RoundedBoxGeometry(2*H,2*H,2*H,5,.22),new THREE.MeshPhysicalMaterial({color:0xffffff,roughness:.05,transparent:true,opacity:0,clearcoat:1,depthWrite:false,side:THREE.DoubleSide}));cube.add(shell);
const emb=ctex((g,w,h)=>{const r=g.createLinearGradient(0,0,w,h);r.addColorStop(0,'#ff9a3c');r.addColorStop(1,'#e84a00');g.fillStyle=r;g.fillRect(0,0,w,h);g.strokeStyle='#fff';g.lineWidth=16;g.lineCap=g.lineJoin='round';g.beginPath();g.moveTo(92,86);g.lineTo(52,128);g.lineTo(92,170);g.moveTo(164,86);g.lineTo(204,128);g.lineTo(164,170);g.moveTo(142,76);g.lineTo(114,180);g.stroke()},256,256);
const core=new THREE.Mesh(new RoundedBoxGeometry(1.4,1.4,1.4,4,.1),new THREE.MeshStandardMaterial({map:emb,color:0xffffff,transparent:true,opacity:0}));cube.add(core);
const burst=new THREE.Sprite(new THREE.SpriteMaterial({map:dotT,color:0xffd2a8,...ADD,opacity:0}));scene.add(burst);
const CZ=-11;
const HT={p:new THREE.Vector3(0,0,CZ),s:.8,rx:-.4,ry:.6,hero:false};
function heroTarget(){const h=window.__heroCubeScreen&&window.__heroCubeScreen();if(!h)return HT;const d=-CZ,vh=2*d*Math.tan(THREE.MathUtils.degToRad(FOV0/2)),vw=vh*cam.aspect;
 HT.p.set((h.x/innerWidth-.5)*vw,(.5-h.y/innerHeight)*vh,CZ);HT.s=Math.max(.05,h.size/((2*H)/vh*innerHeight));HT.rx=h.rx;HT.ry=h.ry;HT.hero=true;return HT}
// --- timeline
let exitT=null,ht=null,raf,scr=false;const sbg=el.querySelector('.sbg');let wmP=0;const _pv=new THREE.Vector3(),_fp=new THREE.Vector3(),CS=window.__splashCubeScr={x:0,y:0};window.__splashHideCube=true;window.__splashF=0;
const wrapZ=(z0,d)=>{let z=((z0-d)%L+L)%L;return -z+2};
function frame(now){if(!el.isConnected)return;raf=requestAnimationFrame(frame);const _js0=performance.now();const MAN=window.__splashT!=null;const t=MAN?window.__splashT:(now-T0)/1000;
 if(t>=.35)el.classList.add('t0');if(t>=2.2)el.classList.add('t1');if(t>=2.45&&!scr){scr=true;scramble()}if(t>=3.2)el.classList.add('t3');if(t>=3.7)el.classList.add('t4');
 // progress
 const tp=Math.min(1,(now-T0)/MIN),rp=realP();const goal=Math.min(rp,tp)*100;shown+=(goal-shown)*.12;if(goal>=100&&shown>99.4)shown=100;if(MAN)shown=Math.min(100,t/(MIN/1000)*100);
 pctEl.textContent=Math.round(shown);bar.style.width=shown+'%';
 if(!done&&!MAN&&((rp>=1&&now-T0>=MIN&&shown>=100)||now-T0>=MAX))exit();
 const e=exitT===null?0:Math.min(t-exitT,1.4),ex=sm(0,.6,e);
 const d=D(t)+(exitT===null?0:22*e*e),spd=Math.min(1,SPD(t)+ex);
 // camera: FOV kick with speed, gentle roll
 const u=Math.min(Math.max((t-CT0)/CTN,0),1),cf=1-sm(0,.35,e);camCurve.getPoint(u,_cp);lookCurve.getPoint(u,_lt);cam.position.copy(_cp).multiplyScalar(cf);_lt.lerp(CENL,1-cf);cam.lookAt(_lt);
 cam.fov=FOV0+16*spd*(1-sm(.45,.7,e))+10*sm(TS,TS+.5,t)*(1-sm(TS+.5,TS+1.4,t));cam.rotateZ((Math.sin(t*.7)*.05*spd-_cp.x*.09)*cf);
 // lift the vanishing point to ~40% so portal/tunnel clear the text block; eased back to centre before the cube appears
 cam.setViewOffset(innerWidth,innerHeight,0,innerHeight*.1*(1-sm(.1,.48,e)),innerWidth,innerHeight);
 // portal
 const ig=sm(.1,1.0,t);ringLine.geometry.setDrawRange(0,Math.floor(sm(.1,.8,t)*201));const nearF=1-sm(-2.2,-.6,portal.position.z);ringGlow.material.opacity=sm(.5,1.1,t)*(.7+.12*Math.sin(t*9))*nearF;ringGlow.scale.setScalar(RR*2.65+Math.sin(t*5)*.05);
 swirlU.uT.value=t;swirlU.uO.value=sm(.6,1.3,t)*(1-sm(-4,-2,RING_Z+d));portal.position.z=RING_Z+d;portal.rotation.z=t*.3;portal.visible=portal.position.z<1.5;
 for(let i=0;i<NS;i++){const i3=i*3,lf=(sSeed[i3+1]+t*sSeed[i3+2]*.6)%1,a=sSeed[i3]+t*.8*(.5+sSeed[i3+2]*.4)+lf*.9,r=RR+lf*lf*(.9+sSeed[i3+2]*.4);sPos[i3]=Math.cos(a)*r;sPos[i3+1]=Math.sin(a)*r;sPos[i3+2]=lf*.6*(sSeed[i3+1]-.5)}
 sg.attributes.position.needsUpdate=true;sparkM.opacity=sm(.4,1,t)*.9*nearF;
 // tunnel
 tunU.uT.value=t;tunU.uD.value=d;tunU.uS.value=spd;tunU.uCut.value=Math.min(RING_Z+d,3);tunU.uO.value=sm(.6,1.6,t)*(1-sm(.15,.6,e));
 const fo=(1-sm(.15,.6,e))*sm(3.5,6.5,d);
 segs.forEach(m=>{const z=wrapZ(m.userData.z0,d);m.position.z=z;m.rotation.z+=m.userData.w*.01;m.material.opacity=sm(-70,-30,z)*sm(2,-2,z)*.3*fo});
 const sl=.12+spd*spd*2.4;for(let i=0;i<NK;i++){const i6=i*6,z=wrapZ(kd[i*3+2],d);kp[i6+2]=z;kp[i6+5]=z-sl}kg.attributes.position.needsUpdate=true;streakM.opacity=fo*.6*(1-.3*wmP);
 glyphs.forEach(s=>{const z=wrapZ(s.userData.z0,d);s.position.z=z;s.material.opacity=sm(-45,-20,z)*sm(1,-3,z)*.4*fo});
 const pz=tk=>d-D(tk);// z of an object that reaches the camera at time tk
 let wm=0,km=-1;panels.forEach((m,k)=>{const tk=m.userData.tk,z=d-D(tk)-ZF;m.position.z=z;m.visible=z>-60&&z<2.5;const w=sm(tk-.42,tk-.08,t)*(1-sm(tk+.28,tk+.55,t))*fo;
  m.material.opacity=sm(-55,-26,z)*sm(-.5,-2.0,z)*fo;m.scale.setScalar(PS*(1+.12*w));const br=.55+.15*w;m.material.color.setRGB(br,br*.96,br*.93);m.userData.glow.material.opacity=w*.95*m.material.opacity;if(w>wm){wm=w;km=k}});
 vig.style.opacity=(wm*.85).toFixed(3);wmP=wm;cam.updateMatrixWorld();
 if(km>=0&&wm>.01){const m=panels[km];if(km!==focK){focK=km;focB.textContent=m.userData.label;focI.textContent=m.userData.tag}m.localToWorld(_fp.set(0,1.02,0));_fp.project(cam);
  foc.style.transform='translate('+((_fp.x+1)/2*innerWidth).toFixed(1)+'px,'+((1-_fp.y)/2*innerHeight).toFixed(1)+'px) translate(-50%,-100%) translateY('+((1-wm)*8).toFixed(1)+'px)';foc.style.opacity=sm(.25,.8,wm).toFixed(3)}else foc.style.opacity=0;
 orbs.forEach(o=>{const z=pz(o.tk);o.s.position.z=z;o.tp[2]=z;o.tp[5]=z-sl*1.6;o.tr.geometry.attributes.position.needsUpdate=true;const op=sm(-50,-22,z)*sm(1,-1,z)*fo*(1-.75*wmP);o.s.material.opacity=op;o.tr.material.opacity=op*.7});
 endL.material.opacity=sm(1.4,3,t)*(.35+.25*spd)*(1-sm(.55,.9,e));endL.scale.setScalar(10+spd*6+sm(0,.55,e)*150);endL.position.z=-60+sm(0,.55,e)*40;
 bloom.strength=(.75+spd*.15)*(1-sm(.35,.75,e));
 // exit: warm-white burst → cream; the glass cube materializes at the hero cube's position
 if(exitT!==null){// warm ramp: dark → orange → peach → cream, under an additive white flash (never mixes dark with cream)
  if(e<.28)scene.background.lerpColors(BGD,BGO,Math.sqrt(sm(0,.24,e)));else if(e<.5)scene.background.lerpColors(BGO,BGP,sm(.28,.5,e));else scene.background.lerpColors(BGP,BGC,sm(.5,.85,e));
  if(e>=.22&&!el.classList.contains('fl1'))el.classList.add('fl1','flash');if(e>=.45&&!el.classList.contains('fl0')){el.classList.add('fl0');finish()}if(e>=.68)el.classList.remove('flash');
  if(e>=.45)heroTarget();const k=sm(.5,1.0,e),pop=1+Math.sin(Math.min(k,1)*Math.PI)*.08;cube.visible=e>=.5;cube.position.copy(ht.p);cube.scale.setScalar(ht.s*(.55+.45*k)*pop);
  if(ht.hero){cube.rotation.set(ht.rx+(1-k)*.5,ht.ry-(1-k)*1.2,0)}else{cube.rotation.set(-.4,.6-(1-k)*1.2+t*.2,0)}
  shell.material.opacity=k*.22;core.material.opacity=k;edges.material.opacity=sm(.5,.7,e)*(1-sm(.85,1.1,e))*.9;
  burst.position.copy(ht.p);burst.scale.setScalar(ht.s*(3+sm(.45,.8,e)*6));burst.material.opacity=sm(.45,.6,e)*(1-sm(.7,1.05,e))*.9;
  _pv.copy(cube.position).project(cam);CS.x=(_pv.x+1)/2*innerWidth;CS.y=(1-_pv.y)/2*innerHeight;
  if(e>=1&&!el.classList.contains('gone')){el.classList.add('gone');window.__splashHideCube=false}
  if(e>=1.4){cleanup();return}}
 (window.__splashJs||(window.__splashJs=[])).push(performance.now()-_js0);comp.render();window.__splashF++}
raf=requestAnimationFrame(frame);
// stall fallback: if the device can't finish the timeline, end cleanly by wall-clock
const safety=setTimeout(()=>{if(window.__splashT==null)exit(true)},MAX+2500);
var exit=function(skip){if(done)return;done=true;chime();
 if(skip){window.__splashHideCube=false;el.classList.add('exit');finish();el.style.transition='opacity .45s ease';setTimeout(()=>{el.style.opacity=0;setTimeout(cleanup,480)},120);return}
 sbg.style.display='none';ht=heroTarget();window.__handoff=ht;exitT=window.__splashT!=null?window.__splashT:(performance.now()-T0)/1000;el.classList.add('exit')};
window.__splashExit=()=>exit();
function cleanup(){clearTimeout(safety);if(!el.isConnected)return;root.classList.remove('splash-on');window.__splashHideCube=false;cancelAnimationFrame(raf);removeEventListener('resize',size);
 scene.traverse(o=>{o.geometry&&o.geometry.dispose();if(o.material){[].concat(o.material).forEach(m=>{m.map&&m.map.dispose();m.dispose()})}});
 comp.dispose&&comp.dispose();R.dispose();R.forceContextLoss();el.remove();window.__splashDisposed=true}
})();
