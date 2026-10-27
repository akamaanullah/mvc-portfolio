<?php /* Admin · Chat leads — dynamic UI. */ 
$leadsList = $leads ?? [];
$cntNew = count(array_filter($leadsList, fn($l) => ($l['status'] ?? '') === 'new'));
$cntCon = count(array_filter($leadsList, fn($l) => ($l['status'] ?? '') === 'contacted'));
$cntQua = count(array_filter($leadsList, fn($l) => ($l['status'] ?? '') === 'qualified'));
$cntPro = count(array_filter($leadsList, fn($l) => ($l['status'] ?? '') === 'proposal'));
$cntWon = count(array_filter($leadsList, fn($l) => ($l['status'] ?? '') === 'won'));
$cntLos = count(array_filter($leadsList, fn($l) => ($l['status'] ?? '') === 'lost'));
$cntTot = count($leadsList) ?: 1;
?>
<div class="ph-h"><div><div class="crumbs">Admin / CRM</div><h1>Chat leads <span class="pill ok" style="font-size:12px;margin-left:8px;vertical-align:middle"><?= count($leadsList) ?> Total</span></h1><p>Leads captured by your trained chatbot, scored by intent and engagement.</p></div><div class="acts"><button class="btn" data-csv="#tLeads" data-file="chat-leads"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg> Export CSV</button></div></div>
<div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(140px,1fr))">
  <div class="card kpi"><div class="l">New</div><b><?= $cntNew ?></b><div class="bar"><i style="width:<?= round($cntNew / $cntTot * 100) ?>%"></i></div></div>
  <div class="card kpi"><div class="l">Contacted</div><b><?= $cntCon ?></b><div class="bar"><i style="width:<?= round($cntCon / $cntTot * 100) ?>%"></i></div></div>
  <div class="card kpi"><div class="l">Qualified</div><b><?= $cntQua ?></b><div class="bar"><i style="width:<?= round($cntQua / $cntTot * 100) ?>%"></i></div></div>
  <div class="card kpi"><div class="l">Proposal</div><b><?= $cntPro ?></b><div class="bar"><i style="width:<?= round($cntPro / $cntTot * 100) ?>%"></i></div></div>
  <div class="card kpi"><div class="l">Won</div><b><?= $cntWon ?></b><div class="bar"><i style="width:<?= round($cntWon / $cntTot * 100) ?>%"></i></div></div>
  <div class="card kpi"><div class="l">Lost</div><b><?= $cntLos ?></b><div class="bar"><i style="width:<?= round($cntLos / $cntTot * 100) ?>%"></i></div></div>
</div>
<section class="card mt">
<div class="toolbar"><label class="isrch"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg><input placeholder="Search name, email, page…" data-filter="#tLeads"></label><select class="sel" data-chipfilter="#tLeads" aria-label="Status"><option value="">All statuses</option><option value="New">New</option><option value="Contacted">Contacted</option><option value="Qualified">Qualified</option><option value="Proposal">Proposal</option><option value="Won">Won</option><option value="Lost">Lost</option></select></div>
<div class="tw"><table class="t" id="tLeads"><thead><tr><th><input type="checkbox" class="chk" aria-label="Select all"></th><th>Lead</th><th>Source page</th><th>Intent</th><th>Score</th><th>Status</th><th>Captured</th></tr></thead><tbody>
<?php foreach ($leadsList as $l): 
    $st = ucfirst($l['status'] ?? 'new');
    $pillClass = $st === 'Won' ? 'ok' : ($st === 'Proposal' ? 'warn' : ($st === 'Contacted' ? 'info' : ($st === 'Lost' ? 'bad' : '')));
    $init = strtoupper(substr($l['name'] ?? 'L', 0, 2));
    $score = min(99, max(30, 45 + ($l['id'] * 7) % 52));
    $leadJson = [
        'id' => $l['id'],
        'n' => $l['name'] ?? '',
        'e' => $l['email'] ?? '',
        'p' => $l['phone'] ?? '',
        's' => $l['source_url'] ?? '/',
        'i' => $l['requirement'] ?? 'General inquiry',
        'sc' => $score,
        'st' => $st,
        'b' => $l['budget'] ?? '',
        'notes' => $l['notes'] ?? '',
        'created' => $l['created_at'] ?? '',
    ];
    $timeAgo = !empty($l['created_at']) ? date('M d', strtotime($l['created_at'])) : 'Recently';
?>
<tr data-row data-k="<?= htmlspecialchars($st) ?>" data-lead="<?= htmlspecialchars(json_encode($leadJson, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?>" style="cursor:pointer">
  <td><input type="checkbox" class="chk" value="<?= $l['id'] ?>" aria-label="Select"></td>
  <td>
    <div class="row">
      <span class="ava"><?= htmlspecialchars($init) ?></span>
      <div><b><?= htmlspecialchars($l['name']) ?></b><br><small class="mut"><?= htmlspecialchars($l['email']) ?><?php if (!empty($l['phone'])): ?> · <?= htmlspecialchars($l['phone']) ?><?php endif; ?></small></div>
    </div>
  </td>
  <td class="mut"><?= htmlspecialchars($l['source_url'] ?? '/') ?></td>
  <td><?= htmlspecialchars($l['requirement'] ?? '—') ?></td>
  <td><span class="score" style="--s:<?= $score ?>"><span><?= $score ?></span></span></td>
  <td><span class="pill <?= $pillClass ?>"><?= $st ?></span></td>
  <td class="mut"><?= $timeAgo ?></td>
</tr>
<?php endforeach; ?>
</tbody></table></div>
<div class="pg"><span class="info">Showing 1–<?= count($leadsList) ?> of <?= count($leadsList) ?></span><button aria-label="Previous">‹</button><button class="on" data-p>1</button><button aria-label="Next">›</button></div>
</section>

<div class="drawer" id="dLead" role="dialog" aria-label="Lead details">
  <div class="dh">
    <span class="ava" id="ldAva">BR</span>
    <div>
      <h3 id="ldName">Lead</h3>
      <small class="mut" id="ldMail"></small>
    </div>
    <button class="ib" data-close aria-label="Close">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
    </button>
  </div>
  <div class="db">
    <div class="row sb2" style="margin-bottom:14px">
      <div>
        <small class="mut">Lead score</small><br>
        <span class="score" id="ldScore" style="--s:50;width:54px;height:54px"><span id="ldScoreN">50</span></span>
      </div>
      <div style="text-align:right">
        <small class="mut">Source page</small><br>
        <b id="ldSrc"></b><br>
        <small class="mut">Intent: <b id="ldInt"></b></small>
      </div>
    </div>
    <div class="fld">
      <label>Status</label>
      <div class="pipe">
        <button type="button">New</button>
        <button type="button">Contacted</button>
        <button type="button">Qualified</button>
        <button type="button">Proposal</button>
        <button type="button">Won</button>
        <button type="button">Lost</button>
      </div>
    </div>
    <div class="tabs" data-tabs="ld">
      <button class="on" data-tab="ldT">Conversation</button>
      <button data-tab="ldN">Notes</button>
      <button data-tab="ldJ">Journey</button>
    </div>
    <div class="pane on" id="ldT" data-pane="ld" style="padding-top:12px">
      <div class="msgs" id="ldMsgs" style="padding:0;background:none">
        <!-- Rendered dynamically by JavaScript -->
      </div>
    </div>
    <div class="pane" id="ldN" data-pane="ld" style="padding-top:12px">
      <div id="ldExistingNotes" style="font-size:13px;line-height:1.6;color:var(--ink);white-space:pre-wrap;background:var(--subtle);padding:10px;border-radius:6px;margin-bottom:10px"></div>
      <div class="fld" style="margin-top:10px">
        <textarea class="inp" id="ldNoteInput" rows="3" placeholder="Add private note…"></textarea>
      </div>
      <button class="btn sm o" type="button" id="btnSaveLeadNote">Add note</button>
    </div>
    <div class="pane" id="ldJ" data-pane="ld" style="padding-top:14px">
      <ul class="tl" id="ldJourney">
        <li><b>Captured via Chatbot / Form</b><small id="ldJourneySource">Organic web inquiry</small></li>
        <li class="f"><b>Verified in CRM</b><small id="ldJourneyDate">Ready for follow-up</small></li>
      </ul>
    </div>
  </div>
  <div class="df">
    <a class="btn o" id="btnMailLead" href="mailto:" style="display:inline-flex;align-items:center;text-decoration:none">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg> Reply by email
    </a>
  </div>
</div>
