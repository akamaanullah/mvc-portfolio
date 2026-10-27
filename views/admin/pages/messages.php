<?php /* Admin · Contact messages — dynamic UI. */ 
$messagesList = $messages ?? [];
$first = $messagesList[0] ?? null;
?>
<div class="ph-h"><div><div class="crumbs">Admin / CRM</div><h1>Contact messages <span class="pill ok" style="font-size:12px;margin-left:8px;vertical-align:middle"><?= count($messagesList) ?> Total</span></h1><p>Submissions from the contact page form.</p></div><div class="acts"><button class="btn" id="btnMarkAllRead" type="button" onclick="markAllMsgsReadAjax()">Mark all read</button></div></div>
<section class="card inbox" style="grid-template-columns:360px minmax(0,1fr)">
<div class="ibl"><div class="toolbar"><label class="isrch" style="max-width:none"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg><input placeholder="Search messages…" data-filter="#ml"></label></div>
<div class="lst" id="ml">
<?php if (empty($messagesList)): ?>
<div style="padding:24px;text-align:center" class="mut">No messages yet.</div>
<?php else: ?>
<?php foreach ($messagesList as $idx => $m): 
    $initials = strtoupper(substr($m['name'] ?? 'U', 0, 2));
    $subj = $m['project_type'] ?: (!empty($m['service']) ? ucfirst($m['service']) . ' Inquiry' : 'Contact Inquiry');
    $time = !empty($m['created_at']) ? date('M d', strtotime($m['created_at'])) : '—';
    $isUnread = ($m['status'] ?? 'new') === 'new';
    $msgData = [
        'id' => $m['id'],
        'n' => $m['name'] ?? '',
        'e' => $m['email'] ?? '',
        's' => $subj,
        'b' => $m['message'] ?? '',
        'budget' => $m['budget'] ?? 'Not specified',
        'service' => $m['service'] ?? 'General',
        'ip' => $m['ip'] ?? 'PK',
    ];
?>
<div class="cv <?= $idx === 0 ? 'on' : '' ?> <?= $isUnread ? 'unr' : '' ?>" data-row data-id="<?= $m['id'] ?>" data-msg="<?= htmlspecialchars(json_encode($msgData, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?>">
  <span class="ava"><?= htmlspecialchars($initials) ?></span>
  <div class="who">
    <b><?= htmlspecialchars($m['name']) ?> <?php if ($isUnread): ?><span class="dot" style="margin-left:4px;animation:none"></span><?php endif; ?></b>
    <p><b style="display:inline"><?= htmlspecialchars($subj) ?></b> — <?= htmlspecialchars(substr($m['message'] ?? '', 0, 48)) ?>…</p>
  </div>
  <span class="tm"><?= $time ?></span>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div></div>

<div class="thr">
<?php if ($first): 
    $firstInit = strtoupper(substr($first['name'] ?? 'U', 0, 1));
    $firstSubj = $first['project_type'] ?: (!empty($first['service']) ? ucfirst($first['service']) . ' Inquiry' : 'Contact Inquiry');
?>
<div class="th2"><span class="ava" id="rmAva"><?= htmlspecialchars($firstInit) ?></span><div><b id="rmSub"><?= htmlspecialchars($firstSubj) ?></b><br><small class="mut" id="rmFrom"><?= htmlspecialchars($first['name']) ?> &lt;<?= htmlspecialchars($first['email']) ?>&gt;</small></div><span style="flex:1"></span><button class="btn sm g d" id="btnDelCurMsg" data-confirm="Delete this message?" data-del-message="<?= $first['id'] ?>"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg></button></div>
<div class="msgs" style="background:none"><div style="font-size:15px;line-height:1.7;max-width:680px" id="rmBody"><?= nl2br(htmlspecialchars($first['message'] ?? '')) ?></div><dl class="kv" style="margin-top:20px;max-width:420px"><dt>Budget</dt><dd id="rmBudget"><?= htmlspecialchars($first['budget'] ?? 'Not specified') ?></dd><dt>Service</dt><dd id="rmService"><?= htmlspecialchars($first['service'] ?? 'General') ?></dd><dt>IP</dt><dd id="rmIp"><?= htmlspecialchars($first['ip'] ?? '—') ?></dd></dl></div>
<div class="comp">
  <form id="msgReplyForm" onsubmit="event.preventDefault(); sendMsgReplyAjax();">
    <input type="hidden" id="curMsgId" value="<?= $first['id'] ?>">
    <div class="row">
      <textarea class="inp" id="msgReplyText" placeholder="Write a reply… (sent via SMTP to recipient email)" required rows="2"></textarea>
      <button class="btn o" type="submit" id="btnSendMsgReply" title="Send Reply via SMTP"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4z"/></svg></button>
    </div>
  </form>
</div>
<?php else: ?>
<div style="padding:40px;text-align:center" class="mut">No conversation selected</div>
<?php endif; ?>
</div>
</section>

<script>
function markAllMsgsReadAjax() {
  var csrf = (document.querySelector('meta[name="csrf-token"]')||{}).content||'';
  var baseUrl = (document.querySelector('meta[name="base-url"]')||{}).content||'';
  fetch(baseUrl + '/admin/messages/mark-all-read', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify({ _token: csrf })
  }).then(function(r){return r.json()}).then(function(d){
    if (d.success) {
      document.querySelectorAll('#ml .cv.unr').forEach(function(el){ el.classList.remove('unr'); });
      document.querySelectorAll('#ml .dot').forEach(function(el){ el.remove(); });
      toast('All messages marked as read', 'ok');
    }
  });
}

function sendMsgReplyAjax() {
  var csrf = (document.querySelector('meta[name="csrf-token"]')||{}).content||'';
  var baseUrl = (document.querySelector('meta[name="base-url"]')||{}).content||'';
  var id = document.getElementById('curMsgId').value;
  var text = document.getElementById('msgReplyText').value.trim();
  var btn = document.getElementById('btnSendMsgReply');
  if (!id || !text) return;

  btn.disabled = true;
  fetch(baseUrl + '/admin/messages/reply', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify({ _token: csrf, id: id, reply: text })
  }).then(function(r){return r.json()}).then(function(d){
    btn.disabled = false;
    if (d.success) {
      document.getElementById('msgReplyText').value = '';
      toast(d.message || 'Reply sent successfully!', 'ok');
    } else {
      toast(d.error || 'Failed to send reply', 'bad');
    }
  }).catch(function(){
    btn.disabled = false;
    toast('Error sending reply via SMTP', 'bad');
  });
}
</script>
