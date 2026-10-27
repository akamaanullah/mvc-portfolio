/* Amaanullah Admin — static UI behaviour. No network calls; every action is a demo.
   Laravel: replace demo handlers with fetch()/forms posting to admin routes (see @dynamic comments in views). */
(function(){
'use strict';
var $=function(s,c){return(c||document).querySelector(s)},$$=function(s,c){return Array.prototype.slice.call((c||document).querySelectorAll(s))};
var D=document.documentElement,B=document.body;
window.AK={$:$,$$:$$};
/* theme */
function setTheme(t){D.setAttribute('data-theme',t);try{localStorage.setItem('adminTheme',t)}catch(e){}$$('[data-theme-ic]').forEach(function(b){b.innerHTML=t==='dark'?IC.sun:IC.moon});document.dispatchEvent(new Event('ak:theme'))}
var IC={sun:'<svg class="i" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>',moon:'<svg class="i" viewBox="0 0 24 24"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>'};
$$('[data-theme-ic]').forEach(function(b){b.innerHTML=D.getAttribute('data-theme')==='dark'?IC.sun:IC.moon;b.addEventListener('click',function(){setTheme(D.getAttribute('data-theme')==='dark'?'light':'dark')})});
/* sidebar */
if(D.classList.contains('sbm'))B.classList.add('sb-mini');
$$('[data-sb-toggle]').forEach(function(b){b.addEventListener('click',function(){if(innerWidth<=1024){B.classList.toggle('sb-open');ov(B.classList.contains('sb-open'))}else{B.classList.toggle('sb-mini');try{localStorage.setItem('adminSbMini',B.classList.contains('sb-mini')?'1':'0')}catch(e){}}})});
var OV=document.createElement('div');OV.className='ov';B.appendChild(OV);
function ov(on){OV.classList.toggle('open',!!on)}
OV.addEventListener('click',closeAll);
function closeAll(){B.classList.remove('sb-open');$$('.modal.open,.drawer.open,.pal.open').forEach(function(m){m.classList.remove('open')});ov(false)}
document.addEventListener('keydown',function(e){if(e.key==='Escape'){closeAll();$$('.dd.open').forEach(function(d){d.classList.remove('open')})}});
/* dropdowns */
$$('[data-dd]').forEach(function(t){t.addEventListener('click',function(e){e.stopPropagation();var d=t.closest('.dd'),o=d.classList.contains('open');$$('.dd.open').forEach(function(x){x.classList.remove('open')});d.classList.toggle('open',!o)})});
document.addEventListener('click',function(e){if(!e.target.closest('.menu'))$$('.dd.open').forEach(function(x){x.classList.remove('open')})});
$$('[data-mark-read]').forEach(function(b){b.addEventListener('click',function(e){e.stopPropagation();$$('.nt.unread').forEach(function(n){n.classList.remove('unread')});var bd=$('#nbadge');if(bd)bd.remove();toast('All notifications marked as read','ok')})});
/* modal / drawer */
window.openM=function(id){var m=document.getElementById(id);if(!m)return;m.classList.add('open');ov(true);var f=m.querySelector('input,textarea,button.btn');if(f)setTimeout(function(){f.focus()},50)};
$$('[data-open]').forEach(function(b){b.addEventListener('click',function(e){e.preventDefault();openM(b.getAttribute('data-open'))})});
B.addEventListener('click',function(e){var c=e.target.closest('[data-close]');if(c){e.preventDefault();closeAll()}});
/* confirm delete */
var pending=null;
B.addEventListener('click',function(e){var b=e.target.closest('[data-confirm]');if(!b)return;e.preventDefault();pending=b;var m=$('#mConfirm');if(!m)return;$('#cTitle',m).textContent=b.getAttribute('data-confirm')||'Delete this item?';openM('mConfirm')});
var cy=$('#cYes');if(cy)cy.addEventListener('click',function(){
  closeAll();
  if(pending){
    var r=pending.closest('tr,.mi2,.pcard,.cv,li[data-row]');
    var csrf=(document.querySelector('meta[name="csrf-token"]')||{}).content||'';
    var baseUrl=(document.querySelector('meta[name="base-url"]')||{}).content||'';
    var delProj=pending.getAttribute('data-del-project');
    var delArt=pending.getAttribute('data-del-article');
    var delCat=pending.getAttribute('data-del-category');
    var delMsg=pending.getAttribute('data-del-message');
    var delLead=pending.getAttribute('data-del-lead');

    var url='', id=null;
    if(delProj){url=baseUrl+'/admin/projects/delete';id=delProj}
    else if(delArt){url=baseUrl+'/admin/articles/delete';id=delArt}
    else if(delCat){url=baseUrl+'/admin/categories/delete';id=delCat}
    else if(delMsg){url=baseUrl+'/admin/messages/delete';id=delMsg}
    else if(delLead){url=baseUrl+'/admin/leads/delete';id=delLead}

    if(url && id){
      fetch(url,{
        method:'POST',
        headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf},
        body:JSON.stringify({_token:csrf,id:id})
      }).then(function(res){return res.json()}).then(function(d){
        if(d.success){
          if(r){r.style.transition='.3s';r.style.opacity='0';setTimeout(function(){r.remove()},300)}
          toast(d.message||'Deleted','ok');
          if(!r && window.location.pathname.indexOf('/edit')>-1){
            window.location.href=baseUrl+(delProj?'/admin/projects':'/admin/articles');
          }
        }else{
          toast(d.error||'Failed to delete','bad');
        }
      }).catch(function(){toast('Error deleting item','bad')});
    }else{
      if(r){r.style.transition='.3s';r.style.opacity='0';setTimeout(function(){r.remove()},300)}
      toast('Deleted','bad');
    }
    pending=null;
  }
});

/* toggle featured */
document.addEventListener('change',function(e){
  var sw=e.target.closest('[data-toggle-featured]');
  if(!sw)return;
  var id=sw.getAttribute('data-toggle-featured'),feat=sw.checked?1:0;
  var csrf=(document.querySelector('meta[name="csrf-token"]')||{}).content||'';
  var baseUrl=(document.querySelector('meta[name="base-url"]')||{}).content||'';
  fetch(baseUrl+'/admin/projects/toggle-featured',{
    method:'POST',
    headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf},
    body:JSON.stringify({_token:csrf,id:id,is_featured:feat})
  }).then(function(res){return res.json()}).then(function(d){
    toast(d.message||(feat?'Marked as featured':'Removed from featured'),'ok');
  }).catch(function(){
    toast('Error updating featured','bad');
    sw.checked=!sw.checked;
  });
});
/* toast */
window.toast=function(msg,type){var w=$('.toasts');if(!w){w=document.createElement('div');w.className='toasts';w.setAttribute('aria-live','polite');B.appendChild(w)}var t=document.createElement('div');t.className='toast '+(type||'');var icon=type==='bad'?'<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>':type==='ok'?'<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>':'<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>';t.innerHTML='<span style="display:inline-flex;align-items:center;">'+icon+'</span><span>'+msg+'</span>';w.appendChild(t);setTimeout(function(){t.style.transition='.3s';t.style.opacity='0';setTimeout(function(){t.remove()},300)},3200)};
$$('[data-toast]').forEach(function(b){b.addEventListener('click',function(e){if(b.tagName==='A')e.preventDefault();toast(b.getAttribute('data-toast'),b.getAttribute('data-tt')||'ok')})});
/* command palette */
var pal=$('#pal');
function openPal(){if(!pal)return;pal.classList.add('open');ov(true);var i=$('input',pal);i.value='';filt('');setTimeout(function(){i.focus()},30)}
$$('[data-pal]').forEach(function(b){b.addEventListener('click',openPal)});
document.addEventListener('keydown',function(e){if((e.metaKey||e.ctrlKey)&&e.key.toLowerCase()==='k'){e.preventDefault();openPal()}});
function filt(q){q=q.toLowerCase();var first=null;$$('li',pal).forEach(function(li){var ok=li.textContent.toLowerCase().indexOf(q)>-1;li.style.display=ok?'':'none';li.classList.remove('sel');if(ok&&!first)first=li});if(first)first.classList.add('sel')}
if(pal){var pin=$('input',pal);pin.addEventListener('input',function(){filt(pin.value)});pin.addEventListener('keydown',function(e){var v=$$('li',pal).filter(function(l){return l.style.display!=='none'}),i=v.indexOf($('li.sel',pal));if(e.key==='ArrowDown'||e.key==='ArrowUp'){e.preventDefault();if(i>-1)v[i].classList.remove('sel');i=(i+(e.key==='ArrowDown'?1:-1)+v.length)%v.length;v[i].classList.add('sel');v[i].scrollIntoView({block:'nearest'})}if(e.key==='Enter'&&v[i]){location.href=$('a',v[i]).href}})}
/* tabs */
$$('[data-tabs]').forEach(function(t){var g=t.getAttribute('data-tabs');$$('[data-tab]',t).forEach(function(b){b.addEventListener('click',function(){$$('[data-tab]',t).forEach(function(x){x.classList.toggle('on',x===b)});$$('[data-pane="'+g+'"]').forEach(function(p){p.classList.toggle('on',p.id===b.getAttribute('data-tab'))})})})});
$$('.seg').forEach(function(s){$$('button',s).forEach(function(b){b.addEventListener('click',function(){$$('button',s).forEach(function(x){x.classList.toggle('on',x===b)});var v=b.getAttribute('data-view');if(v){$$('[data-viewpane]').forEach(function(p){p.hidden=p.getAttribute('data-viewpane')!==v})}if(s.hasAttribute('data-range')){reloadCharts()}})})});
/* bulk select */
$$('table.t').forEach(function(tb){var all=$('thead .chk',tb),bulk=tb.closest('.card')&&$('.bulk',tb.closest('.card'));if(!all)return;function upd(){var n=$$('tbody .chk:checked',tb).length;if(bulk){bulk.classList.toggle('show',n>0);var c=$('.bc',bulk);if(c)c.textContent=n+' selected'}}all.addEventListener('change',function(){$$('tbody .chk',tb).forEach(function(c){c.checked=all.checked});upd()});tb.addEventListener('change',function(e){if(e.target.matches('tbody .chk'))upd()})});
/* client-side filter (demo of server search) */
$$('[data-filter]').forEach(function(inp){var tgt=$(inp.getAttribute('data-filter'));inp.addEventListener('input',function(){var q=inp.value.toLowerCase();$$('[data-row]',tgt).forEach(function(r){r.style.display=r.textContent.toLowerCase().indexOf(q)>-1?'':'none'})})});
$$('[data-chipfilter]').forEach(function(sel){var tgt=$(sel.getAttribute('data-chipfilter'));sel.addEventListener('change',function(){var v=sel.value;$$('[data-row]',tgt).forEach(function(r){r.style.display=!v||(r.getAttribute('data-k')||'').indexOf(v)>-1?'':'none'})})});
$$('.pg').forEach(function(p){$$('button[data-p]',p).forEach(function(b){b.addEventListener('click',function(){$$('button[data-p]',p).forEach(function(x){x.classList.toggle('on',x===b)});var c=p.closest('.card');if(c){c.classList.add('loading');setTimeout(function(){c.classList.remove('loading')},600)}})})});
/* skeleton demo */
$$('.loading[data-autoload]').forEach(function(c){setTimeout(function(){c.classList.remove('loading')},700)});
/* counters + validation */
$$('[data-count]').forEach(function(i){var c=document.getElementById(i.getAttribute('data-count'));var mn=+i.getAttribute('data-min')||0,mx=+i.getAttribute('data-max')||999;function u(){var n=i.value.length;c.textContent=n+' / '+mx;c.className='cnt '+(n>mx||n<mn&&n>0?'bad':n>=mn?'ok':'')}i.addEventListener('input',u);u()});
$$('form[data-validate]').forEach(function(f){f.setAttribute('novalidate','');f.addEventListener('submit',function(e){e.preventDefault();var ok=true;$$('[required]',f).forEach(function(i){var fl=i.closest('.fld'),v=i.value.trim(),good=!!v&&(i.type!=='email'||/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(v))&&(!i.minLength||i.minLength<0||v.length>=i.minLength);if(fl){fl.classList.toggle('invalid',!good);fl.classList.toggle('valid',good)}if(!good)ok=false});if(!ok){toast('Please fix the highlighted fields','bad');return}var go=f.getAttribute('data-go');var b=$('button[type=submit]',f);if(b){b.disabled=true;b.dataset.t=b.innerHTML;b.innerHTML='Please wait…'}setTimeout(function(){if(b){b.disabled=false;b.innerHTML=b.dataset.t}toast(f.getAttribute('data-msg')||'Saved (demo)','ok');if(go)location.href=go},700)})});
/* dropzone */
$$('.drop').forEach(function(d){var inp=$('input[type=file]',d);d.addEventListener('click',function(e){if(inp&&e.target!==inp)inp.click()});['dragenter','dragover'].forEach(function(ev){d.addEventListener(ev,function(e){e.preventDefault();d.classList.add('over')})});['dragleave','drop'].forEach(function(ev){d.addEventListener(ev,function(e){e.preventDefault();d.classList.remove('over')})});d.addEventListener('drop',function(e){var n=e.dataTransfer&&e.dataTransfer.files.length;toast((n||1)+' file(s) queued (demo, not uploaded)','ok')});if(inp)inp.addEventListener('change',function(){var f=inp.files[0];if(!f)return;var pv=d.getAttribute('data-preview')&&document.querySelector(d.getAttribute('data-preview'));if(pv&&/^image\//.test(f.type)){pv.src=URL.createObjectURL(f);pv.dispatchEvent(new Event('change'))}toast(inp.files.length+' file(s) selected (demo, not uploaded)','ok')})});
/* media select -> drawer */
$$('.mi2[data-name]').forEach(function(m){m.addEventListener('click',function(){$$('.mi2.sel').forEach(function(x){x.classList.remove('sel')});m.classList.add('sel');var dr=$('#dMedia');if(!dr)return;$('#mdImg',dr).src=$('img',m).src;$('#mdName',dr).textContent=m.getAttribute('data-name');$('#mdMeta',dr).textContent=m.getAttribute('data-meta');$('#mdUrl',dr).value=m.getAttribute('data-url')||'';$('#mdAlt',dr).value=m.getAttribute('data-alt')||'';openM('dMedia')})});
$$('[data-copy]').forEach(function(b){b.addEventListener('click',function(){var t=document.querySelector(b.getAttribute('data-copy'));try{navigator.clipboard.writeText(t.value||t.textContent)}catch(e){}toast('Copied to clipboard','ok')})});
/* lead drawer */
var curLead = null;
$$('[data-lead]').forEach(function(r){
  r.addEventListener('click',function(e){
    if(e.target.closest('input,button,a,select'))return;
    var d=JSON.parse(r.getAttribute('data-lead'));
    curLead = { data: d, row: r };
    var dr=$('#dLead');
    $('#ldName',dr).textContent=d.n;
    $('#ldMail',dr).textContent=d.e;
    $('#ldSrc',dr).textContent=d.s;
    $('#ldInt',dr).textContent=d.i;
    $('#ldScore',dr).style.setProperty('--s',d.sc);
    $('#ldScoreN',dr).textContent=d.sc;
    $$('.pipe button',dr).forEach(function(b){
      b.classList.toggle('on',b.textContent.trim().toLowerCase()===(d.st||'').toLowerCase());
    });
    $('#ldAva',dr).textContent=d.n.split(' ').map(function(x){return x[0]}).join('').slice(0,2);

    // Update mailto link
    var mailBtn = $('#btnMailLead', dr);
    if (mailBtn && d.e) {
      mailBtn.href = 'mailto:' + encodeURIComponent(d.e) + '?subject=' + encodeURIComponent('Re: ' + (d.i || 'Your Web / Software Inquiry') + ' - Amaanullah Khan');
    }

    // Populate dynamic conversation transcript
    var msgsBox = $('#ldMsgs', dr);
    if (msgsBox) {
      msgsBox.innerHTML = '';
      var rawNotes = d.notes ? d.notes.trim() : '';
      if (rawNotes) {
        var lines = rawNotes.split('\n');
        lines.forEach(function(line){
          line = line.trim();
          if (!line) return;
          var div = document.createElement('div');
          if (/^(user|visitor):/i.test(line)) {
            div.className = 'm v';
            div.innerHTML = line.replace(/^(user|visitor):\s*/i, '').replace(/</g,'&lt;') + '<small>Visitor</small>';
          } else if (/^(bot|assistant|ai):/i.test(line)) {
            div.className = 'm b';
            div.innerHTML = line.replace(/^(bot|assistant|ai):\s*/i, '').replace(/</g,'&lt;') + '<small>Bot · Assistant</small>';
          } else if (/^\[.*admin\]:/i.test(line)) {
            div.className = 'm a';
            div.innerHTML = line.replace(/</g,'&lt;') + '<small>Admin Note</small>';
          } else {
            div.className = 'm sys';
            div.textContent = line;
          }
          msgsBox.appendChild(div);
        });
      } else {
        msgsBox.innerHTML = '<div class="m sys">— Captured directly via web brief on ' + (d.s||'/') + ' —</div>' +
          '<div class="m v">' + (d.i || 'General inquiry').replace(/</g,'&lt;') + '<small>' + d.n.replace(/</g,'&lt;') + '</small></div>' +
          '<div class="m b">Inquiry captured in CRM database. Ready for client follow-up.<small>System</small></div>';
      }
    }

    // Populate existing notes tab
    var exNotes = $('#ldExistingNotes', dr);
    if (exNotes) {
      exNotes.textContent = d.notes || 'No private notes added yet.';
    }

    openM('dLead');
  });
});

$$('#dLead .pipe button').forEach(function(b){
  b.addEventListener('click',function(){
    var st = b.textContent.trim().toLowerCase();
    $$('#dLead .pipe button').forEach(function(x){x.classList.toggle('on',x===b)});
    if(curLead && curLead.data && curLead.data.id){
      var csrf=(document.querySelector('meta[name="csrf-token"]')||{}).content||'';
      var baseUrl=(document.querySelector('meta[name="base-url"]')||{}).content||'';
      fetch(baseUrl+'/admin/leads/status',{
        method:'POST',
        headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf},
        body:JSON.stringify({_token:csrf,id:curLead.data.id,status:st})
      }).then(function(res){return res.json()}).then(function(d){
        if(d.success){
          toast('Status updated to “'+b.textContent+'”','ok');
          if(curLead.row){
            var pill=$('.pill',curLead.row);
            if(pill){
              pill.textContent=b.textContent;
              pill.className='pill '+(st==='won'?'ok':(st==='proposal'?'warn':(st==='contacted'?'info':(st==='lost'?'bad':''))));
            }
            curLead.row.setAttribute('data-k',b.textContent);
          }
        }
      }).catch(function(){toast('Error updating status','bad')});
    }
  });
});

// Save Lead Private Note
var btnSaveNote = $('#btnSaveLeadNote');
if (btnSaveNote) {
  btnSaveNote.addEventListener('click', function(){
    if (!curLead || !curLead.data || !curLead.data.id) return;
    var inp = $('#ldNoteInput');
    var text = inp ? inp.value.trim() : '';
    if (!text) return;

    var csrf = (document.querySelector('meta[name="csrf-token"]')||{}).content||'';
    var baseUrl = (document.querySelector('meta[name="base-url"]')||{}).content||'';

    btnSaveNote.disabled = true;
    fetch(baseUrl + '/admin/leads/note', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
      body: JSON.stringify({ _token: csrf, id: curLead.data.id, note: text })
    }).then(function(res){ return res.json(); }).then(function(d){
      btnSaveNote.disabled = false;
      if (d.success) {
        inp.value = '';
        curLead.data.notes = d.notes;
        var exNotes = $('#ldExistingNotes');
        if (exNotes) exNotes.textContent = d.notes;
        toast('Note saved successfully!', 'ok');
      } else {
        toast(d.error || 'Failed to save note', 'bad');
      }
    }).catch(function(){
      btnSaveNote.disabled = false;
      toast('Error saving note', 'bad');
    });
  });
}

/* CSV export (real client-side export of the visible demo table) */
$$('[data-csv]').forEach(function(b){b.addEventListener('click',function(){var t=$(b.getAttribute('data-csv'));var rows=$$('tr',t).filter(function(r){return r.style.display!=='none'}).map(function(r){return $$('th,td',r).slice(1).map(function(c){return '"'+c.innerText.replace(/\s+/g,' ').trim().replace(/"/g,'""')+'"'}).join(',')});var a=document.createElement('a');a.href=URL.createObjectURL(new Blob([rows.join('\n')],{type:'text/csv'}));a.download=(b.getAttribute('data-file')||'export')+'.csv';a.click();toast('CSV exported (demo data)','ok')})});
/* ---------- charts (inline SVG, no library) ---------- */
var tip=document.createElement('div');tip.className='tip';B.appendChild(tip);
function css(v){return getComputedStyle(D).getPropertyValue(v).trim()}
function seeded(n,base,amp,seed){var s=seed||7,a=[];for(var i=0;i<n;i++){s=(s*9301+49297)%233280;a.push(Math.round(base+amp*Math.sin(i/2.2+seed)+amp*.6*(s/233280-.5)+i*base*.012))}return a}
window.AK.seeded=seeded;
function area(svg){var cfg=JSON.parse(svg.getAttribute('data-chart'));var W=svg.clientWidth||600,H=svg.clientHeight||260,p={l:40,r:24,t:14,b:26};svg.setAttribute('viewBox','0 0 '+W+' '+H);var S=cfg.series,labels=cfg.labels,n=labels.length;var max=0;S.forEach(function(s){s.data.forEach(function(v){if(v>max)max=v})});max=Math.ceil(max*1.15/10)*10||10;var x=function(i){return p.l+(W-p.l-p.r)*i/(n-1)},y=function(v){return p.t+(H-p.t-p.b)*(1-v/max)};var h='<defs>';S.forEach(function(s,k){h+='<linearGradient id="g'+k+svg.id+'" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="'+s.c+'" stop-opacity=".35"/><stop offset="1" stop-color="'+s.c+'" stop-opacity="0"/></linearGradient>'});h+='</defs>';for(var g=0;g<=4;g++){var yy=p.t+(H-p.t-p.b)*g/4;h+='<line class="gl" x1="'+p.l+'" x2="'+(W-p.r)+'" y1="'+yy+'" y2="'+yy+'"/><text x="'+(p.l-8)+'" y="'+(yy+4)+'" text-anchor="end">'+fmt(max*(1-g/4))+'</text>'}var step=Math.ceil(n/(W<500?5:9));labels.forEach(function(l,i){if(i%step===0&&(n-1-i>=step/2||i===n-1)||i===n-1)h+='<text x="'+x(i)+'" y="'+(H-6)+'" text-anchor="middle">'+l+'</text>'});S.forEach(function(s,k){var d=s.data.map(function(v,i){return(i?'L':'M')+x(i).toFixed(1)+' '+y(v).toFixed(1)}).join(' ');if(!s.line)h+='<path d="'+d+' L'+x(n-1)+' '+y(0)+' L'+x(0)+' '+y(0)+'Z" fill="url(#g'+k+svg.id+')"/>';h+='<path d="'+d+'" fill="none" stroke="'+s.c+'" stroke-width="'+(s.w||2.5)+'" stroke-linejoin="round" stroke-linecap="round"'+(s.dash?' stroke-dasharray="5 5"':'')+'/>'});h+='<line id="cx'+svg.id+'" y1="'+p.t+'" y2="'+(H-p.b)+'" stroke="'+css('--o')+'" stroke-width="1" opacity="0"/>';svg.innerHTML=h;svg.onmousemove=function(e){var r=svg.getBoundingClientRect(),i=Math.max(0,Math.min(n-1,Math.round((e.clientX-r.left-p.l)/(r.width-p.l-p.r)*(n-1))));var ln=svg.querySelector('#cx'+svg.id);ln.setAttribute('x1',x(i));ln.setAttribute('x2',x(i));ln.setAttribute('opacity','.6');tip.innerHTML='<b>'+labels[i]+'</b><br>'+S.map(function(s){return '<span style="color:'+s.c+'">●</span> '+s.n+': '+s.data[i].toLocaleString()}).join('<br>');tip.style.opacity=1;tip.style.left=Math.min(e.clientX+14,innerWidth-170)+'px';tip.style.top=(e.clientY-10)+'px'};svg.onmouseleave=function(){tip.style.opacity=0;var ln=svg.querySelector('#cx'+svg.id);if(ln)ln.setAttribute('opacity','0')}}
function fmt(v){return v>=1000?(v/1000).toFixed(v>=10000?0:1)+'k':Math.round(v)}
function spark(svg){var d=svg.getAttribute('data-spark').split(',').map(Number),W=110,H=40,mx=Math.max.apply(0,d),mn=Math.min.apply(0,d);svg.setAttribute('viewBox','0 0 '+W+' '+H);var c=svg.getAttribute('data-c')||css('--o');var pts=d.map(function(v,i){return[(W*i/(d.length-1)).toFixed(1),(H-4-(H-8)*(v-mn)/((mx-mn)||1)).toFixed(1)]});var l='M'+pts.map(function(q){return q.join(' ')}).join(' L');var id='s'+Math.random().toString(36).slice(2,7);svg.innerHTML='<defs><linearGradient id="'+id+'" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="'+c+'" stop-opacity=".35"/><stop offset="1" stop-color="'+c+'" stop-opacity="0"/></linearGradient></defs><path d="'+l+' L'+W+' '+H+' L0 '+H+'Z" fill="url(#'+id+')"/><path d="'+l+'" fill="none" stroke="'+c+'" stroke-width="2" stroke-linecap="round"/>'}
function donut(svg){var d=JSON.parse(svg.getAttribute('data-donut')),t=d.reduce(function(a,b){return a+b.v},0),a=-Math.PI/2,h='';svg.setAttribute('viewBox','0 0 120 120');d.forEach(function(s){var a2=a+2*Math.PI*s.v/t,lg=a2-a>Math.PI?1:0,r=48;h+='<path d="M'+(60+r*Math.cos(a))+' '+(60+r*Math.sin(a))+' A'+r+' '+r+' 0 '+lg+' 1 '+(60+r*Math.cos(a2))+' '+(60+r*Math.sin(a2))+'" stroke="'+s.c+'" stroke-width="16" fill="none"><title>'+s.n+': '+s.v+'%</title></path>';a=a2});h+='<text x="60" y="58" text-anchor="middle" style="font:800 18px var(--font);fill:'+css('--ink')+'">'+(svg.getAttribute('data-center')||'')+'</text><text x="60" y="74" text-anchor="middle" style="font:600 9px var(--font);fill:'+css('--mut')+'">'+(svg.getAttribute('data-sub')||'')+'</text>';svg.innerHTML=h}
function bars(svg){var cfg=JSON.parse(svg.getAttribute('data-bars'));var W=svg.clientWidth||500,H=svg.clientHeight||220,p={l:30,r:8,t:10,b:24},n=cfg.data.length,mx=Math.max.apply(0,cfg.data)*1.15;svg.setAttribute('viewBox','0 0 '+W+' '+H);var bw=(W-p.l-p.r)/n,h='<defs><linearGradient id="bg'+svg.id+'" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#ff8a3d"/><stop offset="1" stop-color="#f26a1b"/></linearGradient></defs>';cfg.data.forEach(function(v,i){var bh=(H-p.t-p.b)*v/mx;h+='<rect x="'+(p.l+i*bw+bw*.18)+'" y="'+(H-p.b-bh)+'" width="'+(bw*.64)+'" height="'+bh+'" rx="5" fill="url(#bg'+svg.id+')" opacity="'+(i===n-1?1:.75)+'"><title>'+cfg.labels[i]+': '+v+'</title></rect>';if(n<16||i%2===0)h+='<text x="'+(p.l+i*bw+bw/2)+'" y="'+(H-6)+'" text-anchor="middle">'+cfg.labels[i]+'</text>'});svg.innerHTML=h}
function reloadCharts(){$$('svg[data-chart]').forEach(function(s){var c=JSON.parse(s.getAttribute('data-chart'));c.series.forEach(function(se,k){se.data=se.data.map(function(v){return Math.max(0,Math.round(v*(0.8+Math.random()*.4)))})});s.setAttribute('data-chart',JSON.stringify(c));area(s)});toast('Range updated (demo data regenerated)','ok')}
function draw(){$$('svg[data-chart]').forEach(area);$$('svg[data-spark]').forEach(spark);$$('svg[data-donut]').forEach(donut);$$('svg[data-bars]').forEach(bars)}
draw();var rt;addEventListener('resize',function(){clearTimeout(rt);rt=setTimeout(draw,150)});document.addEventListener('ak:theme',draw);
/* auto-grow textareas */
$$('textarea.ttl-in,textarea.sum-in').forEach(function(t){function g(){t.style.height='auto';t.style.height=t.scrollHeight+'px'}t.addEventListener('input',g);g();addEventListener('resize',g)});
/* live counters (demo ticker) */
$$('[data-tick]').forEach(function(el){var b=+el.textContent;setInterval(function(){b=Math.max(1,b+Math.round(Math.random()*4-2));el.textContent=b},3000)});
/* live chat */
var thr=$('#msgs');
if(thr){thr.scrollTop=thr.scrollHeight;var tk=$('#takeover'),cmp=$('#cmpTxt'),send=$('#cmpSend');
 function st(){var on=tk.checked;cmp.disabled=!on;send.disabled=!on;cmp.placeholder=on?'Type a reply… (Enter to send)':'Bot is replying. Turn on “Take over” to reply yourself.';$('#tkLbl').textContent=on?'You are live':'Bot is handling'}
 tk.addEventListener('change',function(){st();var m=document.createElement('div');m.className='m sys';m.textContent=tk.checked?'— You took over this chat from the bot —':'— Handed back to the bot —';thr.insertBefore(m,$('#typing'));thr.scrollTop=thr.scrollHeight;toast(tk.checked?'You took over from the bot':'Chat handed back to bot','ok')});st();
 function snd(){var v=cmp.value.trim();if(!v)return;var m=document.createElement('div');m.className='m a';m.innerHTML=v.replace(/</g,'&lt;')+'<small>You · just now</small>';thr.insertBefore(m,$('#typing'));cmp.value='';thr.scrollTop=thr.scrollHeight;var ty=$('#typing');ty.hidden=false;thr.scrollTop=thr.scrollHeight;setTimeout(function(){ty.hidden=true;var r=document.createElement('div');r.className='m v';r.innerHTML='Thanks, that helps! (demo auto-reply)<small>Visitor · just now</small>';thr.insertBefore(r,ty);thr.scrollTop=thr.scrollHeight},1800)}
 send.addEventListener('click',snd);cmp.addEventListener('keydown',function(e){if(e.key==='Enter'&&!e.shiftKey){e.preventDefault();snd()}});
 $$('.canned button').forEach(function(b){b.addEventListener('click',function(){if(!tk.checked){tk.checked=true;tk.dispatchEvent(new Event('change'))}cmp.value=b.getAttribute('data-t');cmp.focus()})});
 $$('.cv').forEach(function(c){c.addEventListener('click',function(){$$('.cv').forEach(function(x){x.classList.toggle('on',x===c)});var u=$('.un',c);if(u)u.remove();$('#cvName').textContent=$('b',c).childNodes[0].textContent.trim();$('#viName').textContent=$('#cvName').textContent;if(innerWidth<760)$('.thr').scrollIntoView({behavior:'smooth'})})});
 var ib=$('[data-info]');if(ib)ib.addEventListener('click',function(){$('.inbox').classList.toggle('showinfo')});
}
/* messages inbox */
$$('[data-msg]').forEach(function(r){
  r.addEventListener('click',function(){
    $$('[data-msg]').forEach(function(x){x.classList.toggle('on',x===r)});
    r.classList.remove('unr');
    var dot = $('.dot', r);
    if(dot) dot.remove();
    var d=JSON.parse(r.getAttribute('data-msg'));
    $('#rmSub').textContent=d.s;
    $('#rmFrom').textContent=d.n+' <'+d.e+'>';
    $('#rmBody').innerHTML=(d.b||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
    $('#rmAva').textContent=(d.n||'U')[0];
    var bg=$('#rmBudget');if(bg)bg.textContent=d.budget||'Not specified';
    var sv=$('#rmService');if(sv)sv.textContent=d.service||'General';
    var ip=$('#rmIp');if(ip)ip.textContent=d.ip||'—';
    var del=$('#btnDelCurMsg');if(del)del.setAttribute('data-del-message',d.id);

    var csrf=(document.querySelector('meta[name="csrf-token"]')||{}).content||'';
    var baseUrl=(document.querySelector('meta[name="base-url"]')||{}).content||'';
    fetch(baseUrl+'/admin/messages/status',{
      method:'POST',
      headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf},
      body:JSON.stringify({_token:csrf,id:d.id,status:'read'})
    });
  });
});
})();
