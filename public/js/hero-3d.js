import * as THREE from 'three';
import {RoomEnvironment} from 'three/addons/environments/RoomEnvironment.js';
import {RoundedBoxGeometry} from 'three/addons/geometries/RoundedBoxGeometry.js';
import {EffectComposer} from 'three/addons/postprocessing/EffectComposer.js';
import {RenderPass} from 'three/addons/postprocessing/RenderPass.js';
import {UnrealBloomPass} from 'three/addons/postprocessing/UnrealBloomPass.js';
import {OutputPass} from 'three/addons/postprocessing/OutputPass.js';
import {CSS2DRenderer,CSS2DObject} from 'three/addons/renderers/CSS2DRenderer.js';

// ===== Shared clear glass cube =====
function makeClearCube(){const G=new THREE.Group();
 const T=(draw,w=256,h=256)=>{const c=document.createElement('canvas');c.width=w;c.height=h;draw(c.getContext('2d'),w,h);const t=new THREE.CanvasTexture(c);t.colorSpace=THREE.SRGBColorSpace;t.anisotropy=8;return t};
 const shell=new THREE.Mesh(new RoundedBoxGeometry(2.6,2.6,2.6,6,.22),new THREE.MeshPhysicalMaterial({color:0xffffff,roughness:.02,metalness:0,opacity:.16,clearcoat:1,clearcoatRoughness:0,specularIntensity:.8,envMapIntensity:.6,transparent:true,depthWrite:false,side:THREE.DoubleSide}));shell.castShadow=true;G.add(shell);
 const back=new THREE.Mesh(new RoundedBoxGeometry(2.58,2.58,2.58,6,.22),new THREE.MeshPhysicalMaterial({color:0xffe8d6,roughness:.05,envMapIntensity:.3,transparent:true,opacity:.12,side:THREE.BackSide,depthWrite:false,clearcoat:1}));G.add(back);
 const edges=new THREE.LineSegments(new THREE.EdgesGeometry(new THREE.BoxGeometry(2.5,2.5,2.5)),new THREE.LineBasicMaterial({color:0xffb27a,transparent:true,opacity:.9}));G.add(edges);
 const circ=T((g,w,h)=>{const r=g.createLinearGradient(0,0,w,h);r.addColorStop(0,'#ff9a3c');r.addColorStop(1,'#e84a00');g.fillStyle=r;g.fillRect(0,0,w,h);g.strokeStyle='rgba(255,230,200,.55)';g.lineWidth=3;for(let i=0;i<14;i++){g.beginPath();const x=(i*37)%w,y=(i*59)%h;g.moveTo(x,0);g.lineTo(x,y);g.lineTo(x+40,y+30);g.lineTo(x+40,h);g.stroke();g.fillStyle='#ffe2c4';g.beginPath();g.arc(x+40,y+30,4,0,7);g.fill()}
  g.strokeStyle='#fff';g.lineWidth=16;g.lineCap=g.lineJoin='round';g.shadowColor='#fff';g.shadowBlur=16;g.beginPath();g.moveTo(92,86);g.lineTo(52,128);g.lineTo(92,170);g.moveTo(164,86);g.lineTo(204,128);g.lineTo(164,170);g.moveTo(142,76);g.lineTo(114,180);g.stroke()});
 const core=new THREE.Mesh(new RoundedBoxGeometry(1.45,1.45,1.45,4,.1),new THREE.MeshStandardMaterial({map:circ,emissiveMap:circ,color:0xffffff,emissive:0xffffff,emissiveIntensity:1.1,roughness:.4}));G.add(core);
 const halo=new THREE.Sprite(new THREE.SpriteMaterial({map:T((g,w,h)=>{const r=g.createRadialGradient(w/2,h/2,0,w/2,h/2,w/2);r.addColorStop(0,'rgba(255,140,50,.75)');r.addColorStop(.4,'rgba(255,120,40,.18)');r.addColorStop(1,'rgba(255,120,40,0)');g.fillStyle=r;g.fillRect(0,0,w,h)}),transparent:true,depthWrite:false,blending:THREE.AdditiveBlending}));halo.scale.setScalar(4.5);halo.renderOrder=-1;G.add(halo);
 G.userData={core,halo,edges};return G}
function cubeTick(G,t){const p=.5+.5*Math.sin(t*2.2);G.userData.core.material.emissiveIntensity=.08+p*.14;G.userData.halo.material.opacity=.08+p*.1;G.userData.halo.scale.setScalar(3.8+p*.6);G.rotation.y=t*.25;G.rotation.x=-.4+Math.sin(t*.5)*.06;G.userData.core.rotation.y=-t*.15}

const stage=document.getElementById('stage'),canvas=document.getElementById('c');
const R=new THREE.WebGLRenderer({canvas,antialias:true,alpha:true});
R.setPixelRatio(Math.min(devicePixelRatio,2));R.toneMapping=THREE.NoToneMapping;R.shadowMap.enabled=true;R.shadowMap.type=THREE.PCFSoftShadowMap;
const scene=new THREE.Scene();const BG={l:new THREE.Color(0xfbf3ea),d:new THREE.Color(0x0f0f15)};scene.background=document.body.classList.contains('dark')?BG.d.clone():BG.l.clone();
scene.environment=new THREE.PMREMGenerator(R).fromScene(new RoomEnvironment(),.04).texture;
const cam=new THREE.PerspectiveCamera(36,1,.1,100);cam.position.set(0,.6,13);
const lr=new CSS2DRenderer();lr.domElement.style.cssText='position:absolute;inset:0;pointer-events:none;z-index:3';stage.appendChild(lr.domElement);
scene.add(new THREE.AmbientLight(0xfff1e6,.6));
const key=new THREE.DirectionalLight(0xffffff,1.6);key.position.set(4,7,6);key.castShadow=true;key.shadow.mapSize.set(1024,1024);key.shadow.radius=8;Object.assign(key.shadow.camera,{left:-8,right:8,top:8,bottom:-8});scene.add(key);
const warm=new THREE.PointLight(0xff7a2a,30,12);scene.add(warm);

const root=new THREE.Group();scene.add(root);root.position.x=-.2;const world=new THREE.Group();root.add(world);
// shadow catcher
const sh=new THREE.Mesh(new THREE.PlaneGeometry(30,30),new THREE.ShadowMaterial({opacity:.08}));sh.rotation.x=-Math.PI/2;sh.position.y=-3.4;sh.receiveShadow=true;scene.add(sh);

function tex(draw,w=256,h=256){const c=document.createElement('canvas');c.width=w;c.height=h;draw(c.getContext('2d'),w,h);const t=new THREE.CanvasTexture(c);t.colorSpace=THREE.SRGBColorSpace;t.anisotropy=8;return t}
const glass=(o={})=>new THREE.MeshPhysicalMaterial(Object.assign({color:0xffffff,metalness:0,roughness:.12,transmission:.96,thickness:1.2,ior:1.4,clearcoat:1,clearcoatRoughness:.05,transparent:true,envMapIntensity:.9,iridescence:.4,specularIntensity:1},o));
const orangeM=new THREE.MeshStandardMaterial({color:0xff6a1a,emissive:0xff5a0a,emissiveIntensity:.25,roughness:.3,metalness:.2});

const cube=makeClearCube();world.add(cube);const core=cube.userData.core,frame=cube.userData.edges,halo=cube.userData.halo;
// RINGS
const rings=[];
[[5.2,3.0,.35,0xff8a3d,.7],[5.8,2.2,-.25,0xb9b4ff,.5],[4.4,1.6,.6,0xffb070,.35]].forEach(([a,b,tilt,c,op])=>{const pts=new THREE.EllipseCurve(0,0,a,b).getPoints(200).map(p=>new THREE.Vector3(p.x,0,p.y));const geo=new THREE.BufferGeometry().setFromPoints(pts);const l=new THREE.LineLoop(geo,new THREE.LineBasicMaterial({color:c,transparent:true,opacity:op}));l.rotation.set(1.25,0,tilt);world.add(l);rings.push(l)});

// SATELLITES
const sats=[];const labelsDiv=[];
function label(text){const d=document.createElement('div');d.className='lbl';d.textContent=text;labelsDiv.push(d);return d}
function sphereSat(tint,att){const g=new THREE.Group();const s=new THREE.Mesh(new THREE.SphereGeometry(.95,64,64),new THREE.MeshPhysicalMaterial({color:tint,transparent:true,opacity:.14,roughness:.1,clearcoat:1,iridescence:.3,envMapIntensity:.45,depthWrite:false,side:THREE.DoubleSide}));const rim=new THREE.Mesh(new THREE.SphereGeometry(.97,48,48),new THREE.ShaderMaterial({transparent:true,depthWrite:false,uniforms:{c:{value:new THREE.Color(att)}},vertexShader:'varying vec3 n;varying vec3 v;void main(){n=normalize(normalMatrix*normal);vec4 p=modelViewMatrix*vec4(position,1.);v=normalize(-p.xyz);gl_Position=projectionMatrix*p;}',fragmentShader:'uniform vec3 c;varying vec3 n;varying vec3 v;void main(){float f=pow(1.-abs(dot(n,v)),2.5);gl_FragColor=vec4(c,f*.9);}'}));g.add(rim);s.castShadow=true;g.add(s);g.userData.hit=s;return g}
// 1 editor
{const g=new THREE.Group();const body=new THREE.Mesh(new RoundedBoxGeometry(1.9,1.35,.18,4,.08),new THREE.MeshPhysicalMaterial({color:0x2a2f45,roughness:.25,clearcoat:1,metalness:.3}));body.castShadow=true;g.add(body);
const t=tex((g2,w,h)=>{g2.fillStyle='#1b1f33';g2.fillRect(0,0,w,h);g2.fillStyle='#2a3050';g2.fillRect(0,0,w,34);['#ff5f57','#febc2e','#28c840'].forEach((c,i)=>{g2.fillStyle=c;g2.beginPath();g2.arc(22+i*20,17,6,0,7);g2.fill()});const cs=['#ff8a3d','#7aa2ff','#c792ea','#9ece6a','#ffcb6b','#89ddff'];for(let i=0;i<9;i++){g2.fillStyle='#4a5070';g2.fillRect(14,52+i*20,14,6);let x=40+(i%3)*14;for(let k=0;k<3;k++){const wd=20+((i*7+k*13)%50);g2.fillStyle=cs[(i+k)%6];g2.fillRect(x,52+i*20,wd,7);x+=wd+8}}},360,256);
const scr=new THREE.Mesh(new THREE.PlaneGeometry(1.75,1.2),new THREE.MeshBasicMaterial({map:t,toneMapped:false}));scr.position.z=.1;g.add(scr);g.userData.hit=body;g.userData.lbl=[-.6,1.4];sats.push({g,name:'Custom Web Apps',r:0,phase:2.35,a:3.9,b:2.5});}
// 2 CRM
{const g=sphereSat(0xffffff,0xffb27a);const nodes=[];for(let i=0;i<6;i++){const a=i/6*Math.PI*2;const v=new THREE.Vector3(Math.cos(a)*.55,Math.sin(a)*.55,(i%2?.15:-.15));const n=new THREE.Mesh(new THREE.SphereGeometry(.13,24,24),orangeM);n.position.copy(v);g.add(n);nodes.push(v)}
const lp=[];nodes.forEach(v=>{lp.push(new THREE.Vector3(),v)});g.add(new THREE.LineSegments(new THREE.BufferGeometry().setFromPoints(lp),new THREE.LineBasicMaterial({color:0xff7a2a})));
const u=new THREE.Mesh(new THREE.CircleGeometry(.24,32),new THREE.MeshBasicMaterial({map:tex((c,w,h)=>{c.fillStyle='#3a3f55';c.beginPath();c.arc(128,128,128,0,7);c.fill();c.fillStyle='#fff';c.beginPath();c.arc(128,100,38,0,7);c.fill();c.beginPath();c.ellipse(128,200,64,46,0,Math.PI,0);c.fill()})}));u.position.z=.3;g.add(u);g.userData.spin=u;g.userData.lbl=[1.2,.9];sats.push({g,name:'CRM Systems',r:1,phase:.6,a:3.9,b:2.5});}
// 3 Chat
{const g=sphereSat(0xc9c6ff,0x7d6cff);const b=new THREE.Mesh(new RoundedBoxGeometry(.95,.7,.3,4,.15),new THREE.MeshPhysicalMaterial({color:0x6a5cff,emissive:0x4a3cff,emissiveIntensity:.5,roughness:.2,clearcoat:1}));g.add(b);for(let i=-1;i<=1;i++){const d=new THREE.Mesh(new THREE.SphereGeometry(.07,16,16),new THREE.MeshBasicMaterial({color:0xffffff}));d.position.set(i*.22,0,.17);g.add(d)}const tail=new THREE.Mesh(new THREE.ConeGeometry(.12,.25,12),b.material);tail.position.set(-.3,-.4,0);tail.rotation.z=.6;g.add(tail);g.userData.lbl=[-.4,-1.25];sats.push({g,name:'Team Chat',r:0,phase:3.9,a:3.9,b:2.5});}
// 4 Automation
{const g=sphereSat(0xffffff,0xffa060);const gs=new THREE.Shape();const N=8;for(let i=0;i<N*2;i++){const a=i/(N*2)*Math.PI*2,r=i%2?.32:.42;const a2=a+Math.PI/(N*2);i?gs.lineTo(Math.cos(a)*r,Math.sin(a)*r):gs.moveTo(Math.cos(a)*r,Math.sin(a)*r);gs.lineTo(Math.cos(a2)*r,Math.sin(a2)*r)}const hole=new THREE.Path();hole.absarc(0,0,.13,0,Math.PI*2,true);gs.holes.push(hole);
const gear=new THREE.Mesh(new THREE.ExtrudeGeometry(gs,{depth:.18,bevelEnabled:true,bevelSize:.02,bevelThickness:.02}),new THREE.MeshStandardMaterial({color:0x3a3d4a,metalness:.7,roughness:.3}));gear.position.z=-.09;g.add(gear);
const arr=new THREE.Group();for(let k=0;k<2;k++){const t=new THREE.Mesh(new THREE.TorusGeometry(.66,.06,12,48,Math.PI*.75),orangeM);t.rotation.z=k*Math.PI;arr.add(t);const h=new THREE.Mesh(new THREE.ConeGeometry(.13,.25,12),orangeM);const a=k*Math.PI+Math.PI*.75;h.position.set(Math.cos(a)*.66,Math.sin(a)*.66,0);h.rotation.z=a;arr.add(h)}g.add(arr);g.userData.spin=gear;g.userData.arr=arr;g.userData.lbl=[1.3,-1.1];sats.push({g,name:'Workflow Automation',r:1,phase:5.55,a:3.9,b:2.5});}

const lineSvg=document.getElementById('lines');
sats.forEach((s,i)=>{world.add(s.g);s.g.scale.setScalar(.001);const anchor=new THREE.Object3D();anchor.position.set(s.g.userData.lbl[0],s.g.userData.lbl[1],0);s.g.add(anchor);const o=new CSS2DObject(label(s.name));anchor.add(o);s.anchor=anchor;s.lblObj=o;s.path=document.createElementNS('http://www.w3.org/2000/svg','path');s.path.setAttribute('fill','none');s.path.setAttribute('stroke','#f26a1b');s.path.setAttribute('stroke-width','1.2');s.path.setAttribute('stroke-opacity','.6');lineSvg.appendChild(s.path);s.hl=0;s.target=1});

// particles
const pts=new THREE.BufferGeometry();const P=[];for(let i=0;i<160;i++)P.push((Math.random()-.5)*14,(Math.random()-.5)*8,(Math.random()-.5)*6);pts.setAttribute('position',new THREE.Float32BufferAttribute(P,3));
const dotT=tex((g,w,h)=>{const r=g.createRadialGradient(w/2,h/2,0,w/2,h/2,w/2);r.addColorStop(0,'#fff');r.addColorStop(.3,'rgba(255,170,90,.8)');r.addColorStop(1,'rgba(255,140,60,0)');g.fillStyle=r;g.fillRect(0,0,w,h)},64,64);
const particles=new THREE.Points(pts,new THREE.PointsMaterial({size:.12,map:dotT,transparent:true,depthWrite:false,blending:THREE.AdditiveBlending}));world.add(particles);
const balls=[];for(let i=0;i<12;i++){const m=new THREE.Mesh(new THREE.SphereGeometry(.06+Math.random()*.1,24,24),i%3?orangeM:glass({thickness:.4}));m.position.set((Math.random()-.5)*10,(Math.random()-.5)*6,(Math.random()-.5)*3);m.userData.p=Math.random()*6;world.add(m);balls.push(m)}

// post
const comp=new EffectComposer(R);comp.addPass(new RenderPass(scene,cam));const bloom=new UnrealBloomPass(new THREE.Vector2(1,1),.55,.5,1.02);comp.addPass(bloom);comp.addPass(new OutputPass());

function size(){const w=stage.clientWidth,h=stage.clientHeight;R.setSize(w,h,false);comp.setSize(w,h);lr.setSize(w,h);cam.aspect=w/h;cam.position.z=w<600?Math.max(15.5,8.3/(Math.tan(THREE.MathUtils.degToRad(18))*w/h)):15.5;root.position.x=w<600?0:-.2;cam.updateProjectionMatrix();lineSvg.setAttribute('viewBox',`0 0 ${w} ${h}`)}
addEventListener('resize',size);size();

// interaction
let mx=0,my=0,dragY=0,dragX=0,vy=0,vx=0,down=false,lx=0,ly=0;const ray=new THREE.Raycaster(),m2=new THREE.Vector2();let hover=-1,focus=0;
addEventListener('pointermove',e=>{mx=e.clientX/innerWidth-.5;my=e.clientY/innerHeight-.5;if(down){vy=(e.clientX-lx)*.005;vx=(e.clientY-ly)*.003;lx=e.clientX;ly=e.clientY}
const r=canvas.getBoundingClientRect();m2.set((e.clientX-r.left)/r.width*2-1,-(e.clientY-r.top)/r.height*2+1);ray.setFromCamera(m2,cam);hover=-1;sats.forEach((s,i)=>{if(ray.intersectObject(s.g,true).length)hover=i});canvas.style.cursor=hover>=0?'pointer':''});
canvas.addEventListener('pointerdown',e=>{down=true;lx=e.clientX;ly=e.clientY;if(hover>=0)setFocus(hover)});addEventListener('pointerup',()=>down=false);
const chips=[...document.querySelectorAll('.chip')];
function setFocus(i){focus=i;chips.forEach((c,k)=>c.classList.toggle('on',k===i));const s=sats[i];// rotate world so satellite comes front
const ang=Math.atan2(s.g.position.x,s.g.position.z);targetSpin=dragY-ang+(s.g.position.x>0?.5:-.5)*0}
let targetSpin=null;chips.forEach(c=>c.onclick=()=>setFocus(+c.dataset.i));
document.getElementById('dm').onclick=()=>{document.body.classList.toggle('dark');{const dk=document.body.classList.contains('dark');try{localStorage.setItem('theme',dk?'dark':'light')}catch(e){}document.documentElement.setAttribute('data-theme',dk?'dark':'light')}scene.background=document.body.classList.contains('dark')?BG.d.clone():BG.l.clone()};
let actx;document.getElementById('snd').onclick=()=>{actx=actx||new AudioContext();const o=actx.createOscillator(),g=actx.createGain();o.frequency.value=660;g.gain.setValueAtTime(.08,actx.currentTime);g.gain.exponentialRampToValueAtTime(.0001,actx.currentTime+.4);o.connect(g).connect(actx.destination);o.start();o.stop(actx.currentTime+.4)};

const clock=new THREE.Clock();const ease=t=>1-Math.pow(1-Math.min(Math.max(t,0),1),3);const v3=new THREE.Vector3();
let heroVis=true;new IntersectionObserver(e=>heroVis=e[0].isIntersecting).observe(stage);
window.__heroCubeScreen=()=>{const r=canvas.getBoundingClientRect(),p=new THREE.Vector3(),q=new THREE.Vector3();cube.getWorldPosition(p);q.copy(p).add(new THREE.Vector3(0,1.3*cube.scale.y,0));p.project(cam);q.project(cam);const y1=(1-p.y)/2*r.height,y2=(1-q.y)/2*r.height;return{x:r.left+(p.x+1)/2*r.width,y:r.top+y1,size:Math.abs(y1-y2)*2,rx:cube.rotation.x,ry:cube.rotation.y}};
let hf=0;function loop(){requestAnimationFrame(loop);if(!heroVis)return;if(document.documentElement.classList.contains("splashing")&&window.__heroReady)return;const t=clock.getElapsedTime();
 // entrance
 const e=ease((t-.2)/1.6);cube.scale.setScalar(.3+.7*e);cube.position.y=(1-e)*-2;rings.forEach((r,i)=>{r.material.opacity=[.7,.5,.35][i]*ease((t-.6-i*.15)/1)});
 cubeTick(cube,t);cube.visible=!window.__splashHideCube;cube.position.y+=Math.sin(t*1.1)*.12;warm.intensity=10+Math.sin(t*2.2)*6;
 if(!down){vy*=.94;vx*=.9}dragY+=vy;dragX=THREE.MathUtils.clamp(dragX+vx,-.5,.5);dragX*=.97;
 if(targetSpin!==null){dragY+=(targetSpin-dragY)*.06;if(Math.abs(targetSpin-dragY)<.01)targetSpin=null}
 root.rotation.y+=((mx*.35)-root.rotation.y)*.05;root.rotation.x+=((my*.2+dragX)-root.rotation.x)*.05;
 const orbit=(t-6)*.08+dragY;
 sats.forEach((s,i)=>{const a=s.phase+orbit;s.g.position.set(Math.cos(a)*s.a,Math.sin(a)*s.b*.9*(1)+Math.sin(t*1.3+i)*.15,Math.sin(a)*1.6);
  const se=ease((t-.8-i*.18)/1.1);const want=(i===hover?1.12:1)*(i===focus?1.1:1);s.sc=(s.sc||1)+(want-(s.sc||1))*.12;s.g.scale.setScalar(Math.max(se*s.sc*.8*(innerWidth<600?.85:1),.001));
  s.g.rotation.y=Math.sin(t*.6+i)*.3;s.g.rotation.x=Math.sin(t*.5+i)*.1;if(i===0)s.g.rotation.set(-.15,.5+Math.sin(t*.6)*.15,.1);
  if(s.g.userData.spin&&i===3)s.g.userData.spin.rotation.z=t*.8;if(s.g.userData.arr)s.g.userData.arr.rotation.z=-t*.6;
  const hi=i===hover||i===focus;s.lblObj.element.classList.toggle('hi',hi);s.lblObj.element.style.opacity=se;
 });
 particles.rotation.y=t*.02;balls.forEach(b=>{b.position.y+=Math.sin(t+b.userData.p)*.003});
 comp.render();lr.render(scene,cam);window.__heroReady=true;
 // leader lines
 const w=stage.clientWidth,h=stage.clientHeight;sats.forEach(s=>{s.g.getWorldPosition(v3);v3.project(cam);const x1=(v3.x+1)/2*w,y1=(1-v3.y)/2*h;s.anchor.getWorldPosition(v3);v3.project(cam);const x2=(v3.x+1)/2*w,y2=(1-v3.y)/2*h;const dx=x2-x1,dy=y2-y1;const k=.55;s.path.setAttribute('d',`M${x1+dx*k},${y1+dy*k} L${x2},${y1+dy*k+(y2-y1-dy*k)} `);s.path.setAttribute('d',`M${x1+dx*.5},${y1+dy*.5} Q${x2},${y1+dy*.5} ${x2},${y2}`);s.path.style.opacity=s.lblObj.element.style.opacity});
 }
loop();
// ===== SERVICES SCENE =====
(()=>{
const SV={web:{t:'Custom Web Apps',d:'We build high-performance, scalable and secure web applications tailored to your business needs. From simple websites to complex systems — we turn your ideas into powerful digital products.',l:['PHP / Laravel','.NET & Python','API Integrations','Scalable Architecture','Ongoing Support']},
crm:{t:'CRM Development',d:'Custom CRM platforms that centralise leads, customers and deals — with pipelines, reports and automations shaped around how your team actually sells.',l:['Lead & Pipeline Management','Multi-tenant Architecture','Role-based Access','Reports & Dashboards','Email / WhatsApp Integration']},
chat:{t:'Chat Applications',d:'Real-time messaging and collaboration tools — channels, direct messages, file sharing and notifications, built to stay fast as your team grows.',l:['WebSockets / Real-time','Channels & DMs','File & Media Sharing','Push Notifications','End-to-end Security']},
auto:{t:'Business Process Automation',d:'We map your repetitive work and replace it with reliable workflows — approvals, data syncing, reminders and reports that run on their own.',l:['Workflow Design','Third-party API Sync','Scheduled Jobs & Triggers','Automated Reporting','Error Monitoring']},
mobile:{t:'Mobile App Development',d:'Cross-platform iOS and Android apps with Flutter and Firebase — one codebase, native feel, and smooth release to the app stores.',l:['Flutter (iOS & Android)','Firebase Backend','Offline Support','Push Notifications','Store Deployment']},
ui:{t:'UI/UX & Performance',d:'Clean, modern interfaces that convert — plus performance tuning so every page loads fast and scores well on Core Web Vitals.',l:['UX Research & Wireframes','Design Systems','Responsive Layouts','Core Web Vitals Tuning','Accessibility']}};
const rows=[...document.querySelectorAll('.srow')],card=document.getElementById('fcard');
let active='web',hov=null;
function fill(k){document.getElementById('ft').textContent=SV[k].t;document.getElementById('fd').textContent=SV[k].d;document.getElementById('fl').innerHTML=SV[k].l.map(x=>`<li>${x}</li>`).join('')}
fill('web');let swapT;
function show(k){if(k===active)return;active=k;rows.forEach(r=>r.classList.toggle('on',r.dataset.service===k));card.classList.add('swap');clearTimeout(swapT);swapT=setTimeout(()=>{fill(k);card.classList.remove('swap')},300)}
rows.forEach(r=>{r.addEventListener('mouseenter',()=>{hov=r.dataset.service;show(hov)});r.addEventListener('mouseleave',()=>hov=null);r.addEventListener('click',()=>{show(r.dataset.service);window.__svcClicked=r.dataset.service})});
const sec=document.getElementById('services');new IntersectionObserver(e=>e.forEach(x=>x.isIntersecting&&sec.classList.add('in')),{threshold:.12}).observe(sec);

const stage=document.getElementById('sstage'),canvas=document.getElementById('sc');
const R=new THREE.WebGLRenderer({canvas,antialias:true,alpha:true});R.setPixelRatio(Math.min(devicePixelRatio,2));R.shadowMap.enabled=true;R.shadowMap.type=THREE.PCFSoftShadowMap;
const scene=new THREE.Scene();
scene.environment=new THREE.PMREMGenerator(R).fromScene(new RoomEnvironment(),.04).texture;
const cam=new THREE.PerspectiveCamera(34,1,.1,100);cam.position.set(0,3.2,15);cam.lookAt(0,-.3,0);
const lr=new CSS2DRenderer();lr.domElement.style.cssText='position:absolute;inset:0;pointer-events:none';stage.appendChild(lr.domElement);
scene.add(new THREE.AmbientLight(0xfff1e6,.4));const key=new THREE.DirectionalLight(0xffffff,1.0);key.position.set(4,8,6);key.castShadow=true;key.shadow.radius=8;key.shadow.mapSize.set(1024,1024);scene.add(key);
const warm=new THREE.PointLight(0xff7a2a,10,10);warm.position.y=-.4;scene.add(warm);
const root=new THREE.Group();scene.add(root);const world=new THREE.Group();root.add(world);
const mkTex=(draw,w=256,h=256)=>{const c=document.createElement('canvas');c.width=w;c.height=h;draw(c.getContext('2d'),w,h);const t=new THREE.CanvasTexture(c);t.colorSpace=THREE.SRGBColorSpace;t.anisotropy=8;return t};

// pedestal: layered discs
const ped=new THREE.Group();world.add(ped);ped.position.y=-1.9;
[[2.9,.45,-.55,0xfff6ee],[2.4,.35,-.15,0xffffff],[1.9,.25,.15,0xfffaf5]].forEach(([r,h,y,c])=>{const m=new THREE.Mesh(new THREE.CylinderGeometry(r,r,h,96),new THREE.MeshPhysicalMaterial({color:c,roughness:.25,clearcoat:1}));m.position.y=y;m.castShadow=m.receiveShadow=true;ped.add(m);
 const ring=new THREE.Mesh(new THREE.TorusGeometry(r+.01,.035,12,128),new THREE.MeshBasicMaterial({color:0xff7a2a,toneMapped:false}));ring.rotation.x=Math.PI/2;ring.position.y=y-h/2+.02;ped.add(ring)});
const pglow=new THREE.Sprite(new THREE.SpriteMaterial({map:mkTex((g,w,h)=>{const r=g.createRadialGradient(w/2,h/2,0,w/2,h/2,w/2);r.addColorStop(0,'rgba(255,130,40,.9)');r.addColorStop(.5,'rgba(255,120,40,.2)');r.addColorStop(1,'rgba(255,120,40,0)');g.fillStyle=r;g.fillRect(0,0,w,h)}),transparent:true,depthWrite:false,blending:THREE.AdditiveBlending}));pglow.scale.set(8,3,1);pglow.position.y=-.7;ped.add(pglow);
// dashed rings
const dashed=[];[[4.6,0xff8a3d],[5.6,0x9aa8ff]].forEach(([r,c],i)=>{const pts=new THREE.EllipseCurve(0,0,r,r).getPoints(240).map(p=>new THREE.Vector3(p.x,0,p.y));const l=new THREE.LineLoop(new THREE.BufferGeometry().setFromPoints(pts),new THREE.LineDashedMaterial({color:c,dashSize:.18,gapSize:.14,transparent:true,opacity:.7}));l.computeLineDistances();l.position.y=i?-2.4:-.2;world.add(l);dashed.push(l)});
// cube
const cube=makeClearCube();cube.position.y=.1;world.add(cube);
const om=new THREE.MeshStandardMaterial({color:0xff6a1a,emissive:0xff5a0a,emissiveIntensity:.5,roughness:.3});
const orbs=[];for(let i=0;i<5;i++){const m=new THREE.Mesh(new THREE.SphereGeometry(.1+(i%2)*.06,24,24),om);m.userData.a=i*1.3;m.userData.r=4.6+(i%2);orbs.push(m);world.add(m)}

// tiles
const TL=[['crm','CRM','#dfe6ff','#5b7cff',-2.4,2.5],['chat','Chat','#d6f5ea','#13a37a',1.7,2.7],['web','Web Apps','#ff7a22','#ffffff',-3.7,.8],['auto','Automation','#fbe0f0','#c0287a',3.7,.8],['ui','UI/UX','#ffe9cf','#e07b00',-3.0,-1.3],['mobile','Mobile Apps','#ece2ff','#7d4cff',3.1,-1.1]];
function icon(g,k,c){g.fillStyle=c;g.strokeStyle=c;g.lineWidth=14;g.lineCap=g.lineJoin='round';const cx=128,cy=118;g.beginPath();
 if(k==='crm'){g.arc(100,130,30,0,7);g.arc(140,112,40,0,7);g.arc(172,135,26,0,7);g.fill();g.fillRect(100,128,72,32)}
 else if(k==='chat'){g.roundRect(66,72,124,88,24);g.fill();g.beginPath();g.moveTo(90,150);g.lineTo(80,186);g.lineTo(120,155);g.fill();g.fillStyle='#fff';[100,128,156].forEach(x=>{g.beginPath();g.arc(x,116,9,0,7);g.fill()})}
 else if(k==='web'){g.moveTo(98,82);g.lineTo(62,118);g.lineTo(98,154);g.moveTo(158,82);g.lineTo(194,118);g.lineTo(158,154);g.moveTo(140,72);g.lineTo(116,164);g.stroke()}
 else if(k==='auto'){for(let i=0;i<8;i++){g.save();g.translate(cx,cy);g.rotate(i*Math.PI/4);g.fillRect(-11,-62,22,26);g.restore()}g.beginPath();g.arc(cx,cy,42,0,7);g.fill();g.fillStyle='#fbe0f0';g.beginPath();g.arc(cx,cy,16,0,7);g.fill()}
 else if(k==='ui'){g.ellipse(cx,cy,64,54,0,0,7);g.fill();g.fillStyle='#fff';[[100,100,'#ff5a5a'],[128,88,'#5b7cff'],[156,102,'#13a37a'],[106,132,'#fff']].forEach(([x,y,col])=>{g.fillStyle=col;g.beginPath();g.arc(x,y,10,0,7);g.fill()});g.fillStyle='#ffe9cf';g.beginPath();g.arc(156,140,14,0,7);g.fill()}
 else {g.roundRect(94,58,68,120,14);g.fill();g.fillStyle='#ece2ff';g.fillRect(104,74,48,84);g.beginPath();g.arc(128,168,5,0,7);g.fill()}}
const tiles=[];
TL.forEach(([k,name,bg,fg,x,y],i)=>{const g=new THREE.Group();
 const body=new THREE.Mesh(new RoundedBoxGeometry(1.35,1.35,.42,6,.2),new THREE.MeshPhysicalMaterial({color:0xffffff,roughness:.2,clearcoat:1,envMapIntensity:.7,emissive:new THREE.Color(0xff6a1a),emissiveIntensity:0}));body.castShadow=true;g.add(body);
 const face=new THREE.Mesh(new THREE.PlaneGeometry(1.08,1.08),new THREE.MeshBasicMaterial({map:mkTex((c,w,h)=>{c.fillStyle=bg;c.beginPath();c.roundRect(8,8,240,240,54);c.fill();icon(c,k,fg)}),transparent:true}));face.position.z=.22;g.add(face);
 const lab=document.createElement('div');lab.className='slbl';lab.textContent=name;const lo=new CSS2DObject(lab);lo.position.set(0,-.95,0);g.add(lo);
 g.position.set(x,y,0);g.userData={k,base:new THREE.Vector3(x,y,Math.abs(x)<2.5?-1:.6),body,lab,ph:i*1.1,s:0,glow:0};world.add(g);tiles.push(g)});

const sh=new THREE.Mesh(new THREE.PlaneGeometry(30,30),new THREE.ShadowMaterial({opacity:.07}));sh.rotation.x=-Math.PI/2;sh.position.y=-2.6;sh.receiveShadow=true;scene.add(sh);
const comp=new EffectComposer(R);comp.addPass(new RenderPass(scene,cam));comp.addPass(new UnrealBloomPass(new THREE.Vector2(1,1),.22,.4,1.0));comp.addPass(new OutputPass());
function size(){const w=stage.clientWidth,h=stage.clientHeight;R.setSize(w,h,false);comp.setSize(w,h);lr.setSize(w,h);cam.aspect=w/h;cam.position.z=w<600?19.5:15;cam.updateProjectionMatrix()}addEventListener('resize',size);size();

// interaction
const ray=new THREE.Raycaster(),m2=new THREE.Vector2();let tHover=null,mx=0,my=0,down=false,moved=0,lx=0,vy=0,spin=0;
function pick(e){const r=canvas.getBoundingClientRect();m2.set((e.clientX-r.left)/r.width*2-1,-(e.clientY-r.top)/r.height*2+1);ray.setFromCamera(m2,cam);const h=ray.intersectObjects(tiles,true)[0];if(!h)return null;let o=h.object;while(o&&!o.userData.k)o=o.parent;return o}
canvas.addEventListener('pointermove',e=>{const r=canvas.getBoundingClientRect();mx=(e.clientX-r.left)/r.width-.5;my=(e.clientY-r.top)/r.height-.5;if(down){vy=(e.clientX-lx)*.004;moved+=Math.abs(e.clientX-lx);lx=e.clientX}
 const t=pick(e);const k=t?t.userData.k:null;if(k!==tHover){tHover=k;if(k)show(k)}canvas.style.cursor=k?'pointer':(down?'grabbing':'grab')});
canvas.addEventListener('pointerleave',()=>tHover=null);
canvas.addEventListener('pointerdown',e=>{down=true;moved=0;lx=e.clientX});addEventListener('pointerup',()=>down=false);
canvas.addEventListener('click',e=>{if(moved>6)return;const t=pick(e);if(!t)return;// shared link: clicking the tile clicks the matching list row, so its href is used
 const a=document.querySelector(`.srow[data-service="${t.userData.k}"]`);a&&a.click()});
window.__svcPick=(k)=>{const t=tiles.find(x=>x.userData.k===k);const v=new THREE.Vector3();t.getWorldPosition(v);v.project(cam);const r=canvas.getBoundingClientRect();return{x:r.left+(v.x+1)/2*r.width,y:r.top+(1-v.y)/2*r.height}};

let visible=false;new IntersectionObserver(e=>visible=e[0].isIntersecting).observe(stage);
const clock=new THREE.Clock();let start=null;const ease=t=>1-Math.pow(1-Math.min(Math.max(t,0),1),3);
function loop(){requestAnimationFrame(loop);if(!visible)return;const t=clock.getElapsedTime();if(start===null)start=t;const e=t-start;
 cube.scale.setScalar(.4+.6*ease(e/1.4));cubeTick(cube,t);cube.position.y=.15+Math.sin(t*1.1)*.1;
 if(!down)vy*=.94;spin+=vy;root.rotation.y+=((mx*.3+spin*.0)-root.rotation.y)*.05;root.rotation.x+=((my*.12)-root.rotation.x)*.05;
 world.rotation.y=Math.max(-.6,Math.min(.6,spin));spin*=.985;
 dashed[0].rotation.y=t*.05;dashed[1].rotation.y=-t*.03;dashed.forEach(d=>d.material.opacity=.7*ease((e-.5)/1));
 orbs.forEach((o,i)=>{const a=o.userData.a+t*.25*(i%2?-1:1);o.position.set(Math.cos(a)*o.userData.r,-.2-(i%2)*2.2+Math.sin(t+i)*.1,Math.sin(a)*o.userData.r)});
 pglow.material.opacity=.16+.08*Math.sin(t*2);warm.intensity=6+3*Math.sin(t*2);
 tiles.forEach((g,i)=>{const u=g.userData,on=u.k===active,se=ease((e-.4-i*.12)/1);const tg=on?1:0;u.glow+=(tg-u.glow)*.1;
  g.position.set(u.base.x,u.base.y+Math.sin(t*1.2+u.ph)*.15,u.base.z+u.glow*1.4);g.scale.setScalar(Math.max(.001,se*1.05*(1+u.glow*.2)));
  g.rotation.set(Math.sin(t*.7+u.ph)*.08,-u.base.x*.06+Math.sin(t*.5+u.ph)*.12,Math.sin(t*.6+u.ph)*.04);
  u.body.material.emissiveIntensity=u.glow*.35;u.lab.classList.toggle('hi',on);u.lab.style.opacity=se});
 comp.render();lr.render(scene,cam)}
loop();
})();
// ===== FEATURED PROJECTS =====
(()=>{
const sec=document.getElementById('projects');if(!sec)return;
new IntersectionObserver(e=>e.forEach(x=>x.isIntersecting&&sec.classList.add('in')),{threshold:.08}).observe(sec);
// Featured slides — set img / url to your own files and pages
const SLIDES=[
 {t:'Multi-tenant<br><span>CRM System</span>',d:'A powerful multi-tenant CRM platform with lead management, analytics, real-time updates and 7-level RBAC. Built for scale and security.',c:['PHP','MySQL','Laravel','WebSockets'],f:['Lead Management','Real-time Analytics','7-Level RBAC','Secure & Scalable'],img:'images/crm-1.svg',url:'javascript:void(0)'},
 {t:'CRM<br><span>Lead Pipelines</span>',d:'Kanban pipelines that move leads from first touch to closed deal, with automatic assignment and reminders.',c:['Laravel','Vue','Redis'],f:['Drag & Drop Stages','Auto Assignment','Follow-up Reminders','Activity Timeline'],img:'images/crm-2.svg',url:'javascript:void(0)'},
 {t:'CRM<br><span>Reports</span>',d:'Live reports and exports for every tenant — conversions, team performance and revenue forecasts.',c:['PHP','MySQL','Chart.js'],f:['Custom Reports','CSV / PDF Export','Scheduled Emails','Team KPIs'],img:'images/crm-3.svg',url:'javascript:void(0)'},
 {t:'CRM<br><span>Analytics</span>',d:'Real-time analytics dashboards powered by WebSockets, so managers see every change the moment it happens.',c:['Node.js','WebSockets','MySQL'],f:['Live Dashboards','Lead Sources','Funnel Analysis','Role-based Views'],img:'images/crm-4.svg',url:'javascript:void(0)'}];
const W=document.getElementById('featWrap'),th=[...W.querySelectorAll('.thumbs a')];let cur=0,tm;
function go(i){i=(i+SLIDES.length)%SLIDES.length;if(i===cur)return;cur=i;W.classList.add('swap');th.forEach((a,k)=>a.classList.toggle('on',k===i));clearTimeout(tm);
 tm=setTimeout(()=>{const s=SLIDES[i];fpT.innerHTML=s.t;fpD.textContent=s.d;fpC.innerHTML=s.c.map(x=>`<span>${x}</span>`).join('');fpF.innerHTML=s.f.map(x=>`<div>${x}</div>`).join('');fpI.src=s.img;fpL.href=s.url;fpN.textContent=`0${i+1} / 0${SLIDES.length}`;W.classList.remove('swap')},420)}
fpPrev.onclick=()=>go(cur-1);fpNext.onclick=()=>go(cur+1);th.forEach(a=>a.onclick=()=>go(+a.dataset.i));
let auto=setInterval(()=>go(cur+1),7000);W.addEventListener('mouseenter',()=>clearInterval(auto));
// mouse tilt on project cards
document.querySelectorAll('.pc').forEach(c=>{c.addEventListener('mousemove',e=>{const r=c.getBoundingClientRect(),x=(e.clientX-r.left)/r.width-.5,y=(e.clientY-r.top)/r.height-.5;c.style.transform=`perspective(900px) rotateY(${x*8}deg) rotateX(${-y*6}deg) translateY(-8px)`});c.addEventListener('mouseleave',()=>c.style.transform='')});
// parallax for featured mockup
W.addEventListener('mousemove',e=>{const r=W.getBoundingClientRect(),x=(e.clientX-r.left)/r.width-.5,y=(e.clientY-r.top)/r.height-.5;W.querySelector('.laptop').style.transform=`translate(${x*14}px,${y*10}px)`;W.querySelector('.flist').style.transform=`perspective(600px) rotateY(-14deg) translate(${x*-10}px,${y*-8}px)`});
})();
// ===== ABOUT =====
(()=>{
const sec=document.getElementById('about');if(!sec)return;
const io=new IntersectionObserver(es=>es.forEach(e=>{if(!e.isIntersecting)return;e.target.classList.add('in');io.unobserve(e.target);
 if(e.target.classList.contains('stats'))e.target.querySelectorAll('[data-to]').forEach(el=>{const to=+el.dataset.to,t0=performance.now();const f=t=>{const p=Math.min((t-t0)/1400,1);el.textContent=Math.round(to*(1-Math.pow(1-p,3)));p<1&&requestAnimationFrame(f)};requestAnimationFrame(f)})}),{threshold:.15});
sec.querySelectorAll('.av').forEach(el=>io.observe(el));
new IntersectionObserver(e=>e[0].isIntersecting&&sec.classList.add('in'),{threshold:.1}).observe(sec.querySelector('.skills'));
const pf=document.getElementById('pframe');pf.addEventListener('mousemove',e=>{const r=pf.getBoundingClientRect(),x=(e.clientX-r.left)/r.width-.5,y=(e.clientY-r.top)/r.height-.5;pf.style.transform=`perspective(1000px) rotateY(${x*6}deg) rotateX(${-y*5}deg)`});pf.addEventListener('mouseleave',()=>pf.style.transform='');
})();
// ===== TESTIMONIALS + CTA =====
(()=>{
const RM=matchMedia('(prefers-reduced-motion: reduce)').matches;
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target)}}),{threshold:.15});
document.querySelectorAll('.tv').forEach(el=>io.observe(el));
const cta=document.getElementById('cta');new IntersectionObserver(e=>e[0].isIntersecting&&cta.classList.add('in'),{threshold:.3}).observe(cta);
// marquee loop: duplicate content
['mr1','mr2'].forEach(id=>{const r=document.getElementById(id);r.innerHTML+=r.innerHTML;[...r.children].slice(r.children.length/2).forEach(c=>c.setAttribute('aria-hidden','true'))});
// stacked deck
const deck=document.getElementById('deck'),cards=[...deck.querySelectorAll('.qc')],dots=document.getElementById('dDots');let top=0;
cards.forEach((_,i)=>{const d=document.createElement('i');d.onclick=()=>{top=i;lay()};dots.appendChild(d)});
function lay(dx=0){const n=cards.length;cards.forEach((c,i)=>{const k=(i-top+n)%n;
 if(k===0){c.style.transform=`translateX(${dx}px) rotate(${dx*.03}deg)`;c.style.zIndex=n;c.style.opacity=1;c.style.filter='none'}
 else{c.style.transform=`translate(${k*22}px,${-k*16}px) rotate(${k*2.5}deg) scale(${1-k*.05})`;c.style.zIndex=n-k;c.style.opacity=k>3?0:1-k*.12;c.style.filter=`blur(${k*.4}px)`}
 c.setAttribute('aria-hidden',k?'true':'false')});[...dots.children].forEach((d,i)=>d.classList.toggle('on',i===top))}
lay();window.__deckTop=()=>top;
const go=s=>{top=(top+s+cards.length)%cards.length;lay()};dPrev.onclick=()=>go(-1);dNext.onclick=()=>go(1);
let sx=null,dx=0;deck.addEventListener('pointerdown',e=>{sx=e.clientX;dx=0;cards[top].style.transition='none';deck.setPointerCapture(e.pointerId)});
deck.addEventListener('pointermove',e=>{if(sx===null)return;dx=e.clientX-sx;lay(dx)});
const end=()=>{if(sx===null)return;cards[top].style.transition='';sx=null;if(Math.abs(dx)>80)go(dx<0?1:-1);else lay();dx=0};deck.addEventListener('pointerup',end);deck.addEventListener('pointercancel',end);
addEventListener('keydown',e=>{if(!deck.matches(':hover'))return;if(e.key==='ArrowRight')go(1);if(e.key==='ArrowLeft')go(-1)});
let auto=RM?null:setInterval(()=>go(1),6500);deck.addEventListener('pointerenter',()=>clearInterval(auto));
// CTA spotlight + magnetic button
const cb=document.getElementById('cblock'),mag=document.getElementById('mag');
cb.addEventListener('pointermove',e=>{const r=cb.getBoundingClientRect();cb.style.setProperty('--mx',(e.clientX-r.left)+'px');cb.style.setProperty('--my',(e.clientY-r.top)+'px')});
if(!RM&&matchMedia('(hover:hover)').matches){mag.addEventListener('pointermove',e=>{const r=mag.getBoundingClientRect();mag.style.transform=`translate(${(e.clientX-r.left-r.width/2)*.3}px,${(e.clientY-r.top-r.height/2)*.4}px)`});mag.addEventListener('pointerleave',()=>mag.style.transform='')}
})();
// ===== CONTACT + FOOTER =====
(()=>{
const RM=matchMedia('(prefers-reduced-motion: reduce)').matches;
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target)}}),{threshold:.12});
document.querySelectorAll('.cv2').forEach(el=>io.observe(el));
// copy socials into footer
const s=document.querySelector('.icard .socials');if(s&&document.getElementById('fsoc'))document.getElementById('fsoc').innerHTML=s.innerHTML;
document.getElementById('yr').textContent=new Date().getFullYear();
document.getElementById('btt').onclick=()=>scrollTo({top:0,behavior:RM?'auto':'smooth'});
// form
const f=document.getElementById('cform'),sel=f.querySelector('#f_service'),bud=f.querySelector('#f_budget');
const sc=[...document.querySelectorAll('#svcChips button')],bc=[...document.querySelectorAll('#budChips button')];
const syncSvc=()=>sc.forEach(b=>b.classList.toggle('on',b.dataset.v===sel.value));
sc.forEach(b=>b.onclick=()=>{sel.value=b.dataset.v;syncSvc();check(sel)});sel.addEventListener('change',()=>{syncSvc();check(sel)});
bc.forEach(b=>b.onclick=()=>{bud.value=bud.value===b.dataset.v?'':b.dataset.v;bc.forEach(x=>x.classList.toggle('on',x.dataset.v===bud.value))});
function check(el){const w=el.closest('.fl');let ok=el.checkValidity();if(el.type==='email'&&el.value)ok=ok&&/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(el.value);
 w.classList.toggle('bad',!ok);w.classList.toggle('ok',ok&&!!el.value);return ok}
const fields=[...f.querySelectorAll('.fl input,.fl select,.fl textarea')];
fields.forEach(el=>{el.addEventListener('blur',()=>{if(el.value||el.dataset.t)check(el);el.dataset.t=1});el.addEventListener('input',()=>{if(el.closest('.fl').classList.contains('bad'))check(el)})});
const btn=document.getElementById('sbtn'),g=document.getElementById('fglass');
f.addEventListener('submit',e=>{
 e.preventDefault();// FAKE SUBMIT: remove this handler's fake part when the form posts to {{ route('contact.store') }} (or send with fetch to your endpoint)
 if(f.website.value){return}// honeypot filled → silently ignore (bots)
 const ok=fields.map(check).every(Boolean);if(!ok){const b=f.querySelector('.fl.bad input,.fl.bad select,.fl.bad textarea');b&&b.focus();return}
 btn.classList.add('loading');
 setTimeout(()=>{btn.classList.remove('loading');btn.classList.add('done');btn.querySelector('.tx').textContent='Sent ✓';setTimeout(()=>g.classList.add('sent'),RM?0:500)},RM?100:1400);
});
document.getElementById('fagain').onclick=()=>{f.reset();bud.value='';syncSvc();bc.forEach(x=>x.classList.remove('on'));fields.forEach(el=>{el.closest('.fl').classList.remove('ok','bad');delete el.dataset.t});btn.classList.remove('done');btn.querySelector('.tx').innerHTML='Send Message &nbsp;→';g.classList.remove('sent')};
// newsletter (fake)
document.getElementById('nlform')?.addEventListener('submit',e=>{e.preventDefault();const i=e.target.newsletter_email,m=document.getElementById('nlmsg');const ok=/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(i.value);m.classList.toggle('bad',!ok);m.textContent=ok?'Thanks! You\'re on the list.':'Please enter a valid email.';if(ok)i.value=''});
// nav: smooth anchor scroll + active link on scroll
const links=[...document.querySelectorAll('nav .links a')],ids=['home','services','projects','about','reviews','contact'];
links.forEach((a,i)=>a.setAttribute('href','#'+ids[i]));
document.querySelectorAll('a[href^="#"]').forEach(a=>a.addEventListener('click',e=>{const t=document.querySelector(a.getAttribute('href'));if(!t)return;e.preventDefault();t.scrollIntoView({behavior:RM?'auto':'smooth'});history.replaceState(null,'',a.getAttribute('href'))}));
const secs=ids.map(id=>document.getElementById(id)).filter(Boolean);
function act(){let cur=secs[0]?.id;const y=innerHeight*.35;secs.forEach(s=>{if(s.getBoundingClientRect().top<=y)cur=s.id});links.forEach(a=>a.classList.toggle('on',a.getAttribute('href')==='#'+cur))}
if(links.length){addEventListener('scroll',act,{passive:true});act()}
window.__activeNav=()=>document.querySelector('nav .links a.on')?.textContent;
})();
