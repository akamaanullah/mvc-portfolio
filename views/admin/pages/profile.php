<?php /* Admin · Profile — 100% Dynamic account management. */ 
$u = $userProfile ?? $currentUser ?? [];
$userName = $u['name'] ?? 'Admin';
$userEmail = $u['email'] ?? '';
$userRole = ucfirst($u['role'] ?? 'Administrator');
$userAvatar = !empty($u['avatar']) ? asset_url($u['avatar']) : asset_url('media/profile-poster.jpg');
$userBio = $u['bio'] ?? 'PHP & Laravel developer building custom CRM, SaaS and enterprise web apps, plus Flutter mobile apps.';
$sess = $currentSession ?? ['ip' => client_ip(), 'ua' => $_SERVER['HTTP_USER_AGENT'] ?? 'Desktop', 'time' => date('M j, Y H:i')];
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / Account</div>
    <h1>Profile <span class="pill ok" style="font-size:12px;margin-left:8px;vertical-align:middle">Active</span></h1>
    <p>Manage your administrator credentials, password, and active security sessions.</p>
  </div>
  <div class="acts"></div>
</div>

<div class="grid g12">
  <section class="card" style="padding:24px;text-align:center">
    <img src="<?= $userAvatar ?>" alt="" style="width:110px;height:110px;border-radius:50%;object-fit:cover;margin:0 auto 12px;border:3px solid var(--o);box-shadow:var(--glow)">
    <h3 id="profNameDisplay"><?= htmlspecialchars($userName) ?></h3>
    <p class="mut"><?= htmlspecialchars($userRole) ?></p>
    <div class="drop" style="padding:12px;margin-top:14px" onclick="document.getElementById('profPhotoInput').click()">
      <input type="file" id="profPhotoInput" accept="image/*" hidden onchange="uploadProfilePhotoAjax(this)">
      <small><b>Change photo</b></small>
    </div>
  </section>

  <div style="display:flex;flex-direction:column;gap:18px">
    <section class="card">
      <div class="hd"><h3>Personal info</h3></div>
      <form class="bd2" id="formProfile" onsubmit="event.preventDefault(); saveProfileAjax();">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0 14px">
          <div class="fld">
            <label for="pn">Full name</label>
            <input class="inp" id="pn" required value="<?= htmlspecialchars($userName) ?>">
            <span class="err">Required.</span>
          </div>
          <div class="fld">
            <label for="pe">Email address</label>
            <input class="inp" id="pe" type="email" required value="<?= htmlspecialchars($userEmail) ?>">
            <span class="err">Valid email required.</span>
          </div>
        </div>
        <div class="fld">
          <label for="pb">Author bio (shown on articles &amp; guides)</label>
          <textarea class="inp" id="pb" rows="3"><?= htmlspecialchars($userBio) ?></textarea>
        </div>
        <button class="btn o" type="submit" id="btnSaveProfile">Save profile</button>
      </form>
    </section>

    <section class="card">
      <div class="hd"><h3>Security &amp; Password</h3></div>
      <form class="bd2" id="formPassword" onsubmit="event.preventDefault(); updatePasswordAjax();">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:0 14px">
          <div class="fld">
            <label for="p0">Current password</label>
            <input class="inp" id="p0" type="password" required>
            <span class="err">Required.</span>
          </div>
          <div class="fld">
            <label for="p1">New password</label>
            <input class="inp" id="p1" type="password" required minlength="8" placeholder="Min. 8 characters">
            <span class="err">At least 8 characters.</span>
          </div>
        </div>
        <button class="btn o" type="submit" id="btnUpdatePass">Update password</button>
      </form>
    </section>

    <section class="card">
      <div class="hd"><h3>Active sessions</h3></div>
      <div class="bd2">
        <ul class="list">
          <li>
            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="4" width="20" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            <div class="who">
              <b><?= htmlspecialchars(substr($sess['ua'], 0, 40)) ?>…</b>
              <small>IP: <?= htmlspecialchars($sess['ip']) ?> · <?= htmlspecialchars($sess['time']) ?></small>
            </div>
            <span class="pill ok">Current device</span>
          </li>
        </ul>
      </div>
    </section>
  </div>
</div>

<script>
function saveProfileAjax() {
  var csrf = (document.querySelector('meta[name="csrf-token"]')||{}).content||'';
  var baseUrl = (document.querySelector('meta[name="base-url"]')||{}).content||'';
  var name = document.getElementById('pn').value.trim();
  var email = document.getElementById('pe').value.trim();
  var bio = document.getElementById('pb').value.trim();
  var btn = document.getElementById('btnSaveProfile');

  if (!name || !email) return;
  btn.disabled = true;

  fetch(baseUrl + '/admin/profile/update', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify({ _token: csrf, name: name, email: email, bio: bio })
  }).then(function(r){return r.json()}).then(function(d){
    btn.disabled = false;
    if (d.success) {
      document.getElementById('profNameDisplay').textContent = name;
      toast(d.message || 'Profile updated successfully!', 'ok');
    } else {
      toast(d.error || 'Failed to update profile', 'bad');
    }
  }).catch(function(){
    btn.disabled = false;
    toast('Error updating profile', 'bad');
  });
}

function updatePasswordAjax() {
  var csrf = (document.querySelector('meta[name="csrf-token"]')||{}).content||'';
  var baseUrl = (document.querySelector('meta[name="base-url"]')||{}).content||'';
  var curPass = document.getElementById('p0').value;
  var newPass = document.getElementById('p1').value;
  var btn = document.getElementById('btnUpdatePass');

  if (!curPass || newPass.length < 8) {
    toast('New password must be at least 8 characters', 'bad');
    return;
  }
  btn.disabled = true;

  fetch(baseUrl + '/admin/profile/password', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify({ _token: csrf, current_password: curPass, new_password: newPass })
  }).then(function(r){return r.json()}).then(function(d){
    btn.disabled = false;
    if (d.success) {
      document.getElementById('p0').value = '';
      document.getElementById('p1').value = '';
      toast(d.message || 'Password changed successfully!', 'ok');
    } else {
      toast(d.error || 'Failed to update password', 'bad');
    }
  }).catch(function(){
    btn.disabled = false;
    toast('Error updating password', 'bad');
  });
}

function uploadProfilePhotoAjax(input) {
  if (!input.files || !input.files[0]) return;
  var csrf = (document.querySelector('meta[name="csrf-token"]')||{}).content||'';
  var baseUrl = (document.querySelector('meta[name="base-url"]')||{}).content||'';
  var fd = new FormData();
  fd.append('_token', csrf);
  fd.append('file', input.files[0]);

  fetch(baseUrl + '/admin/media/upload', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': csrf },
    body: fd
  }).then(function(r){return r.json()}).then(function(d){
    if (d.success) {
      toast('Photo uploaded! Refresh to see new avatar.', 'ok');
    } else {
      toast(d.error || 'Upload failed', 'bad');
    }
  });
}
</script>
