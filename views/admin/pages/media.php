<?php /* Admin · Media library — 100% Dynamic file scanner and uploader. */ 
$mediaList = $media ?? [];
$cnt = $mediaCount ?? count($mediaList);
$sizeMb = $mediaSizeMb ?? '0';
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / Content</div>
    <h1>Media library <span class="pill ok" style="font-size:12px;margin-left:8px;vertical-align:middle"><?= $cnt ?> Files</span></h1>
    <p>Banners, covers, media and uploads dynamically scanned from public directories.</p>
  </div>
  <div class="acts">
    <button class="btn o" type="button" onclick="document.getElementById('mediaUploadInput').click()">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg> Upload media
    </button>
  </div>
</div>

<label class="drop" style="display:block;margin-bottom:18px;cursor:pointer" id="mediaDropZone">
  <input type="file" id="mediaUploadInput" multiple accept="image/*,video/*,application/pdf" hidden onchange="handleMediaUpload(this.files)">
  <div style="font-size:30px">
    <svg class="i" style="width:36px;height:36px" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
  </div>
  <p><b>Drag &amp; drop files here</b> or click to browse</p>
  <small>SVG, PNG, JPG, WebP, MP4, PDF · Saved directly to server public storage</small>
</label>

<section class="card" style="margin-bottom:18px">
  <div class="toolbar" style="border:0">
    <label class="isrch">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg>
      <input placeholder="Search files…" data-filter="#mg">
    </label>
    <select class="sel" id="mediaFolderFilter" onchange="filterMediaByFolder(this.value)">
      <option value="">All folders</option>
      <option value="banners">banners</option>
      <option value="covers">covers</option>
      <option value="images">images</option>
      <option value="media">media</option>
      <option value="uploads">uploads</option>
    </select>
    <span class="mut sm" style="margin-left:auto" id="mediaStatsLbl"><?= $cnt ?> files · <?= $sizeMb ?> MB total</span>
  </div>
</section>

<div class="mgrid" id="mg">
  <?php if (empty($mediaList)): ?>
    <div style="grid-column:1/-1;text-align:center;padding:40px" class="mut">No media files found. Upload some assets to get started!</div>
  <?php else: ?>
    <?php foreach ($mediaList as $m): 
      $isVid = in_array($m['ext'], ['mp4', 'webm'], true);
    ?>
      <div class="mi2" data-row data-name="<?= htmlspecialchars($m['name']) ?>" data-meta="<?= htmlspecialchars($m['meta']) ?>" data-url="<?= htmlspecialchars($m['url']) ?>" data-folder="<?= htmlspecialchars($m['folder']) ?>" onclick="openMediaDetails(this)" style="cursor:pointer">
        <div class="th" style="display:flex;align-items:center;justify-content:center;background:var(--subtle);min-height:120px">
          <?php if ($isVid): ?>
            <div style="text-align:center;padding:20px;font-size:12px;font-weight:700;color:var(--brand)">VIDEO<br><small><?= htmlspecialchars($m['ext']) ?></small></div>
          <?php else: ?>
            <img src="<?= $m['asset_url'] ?>" alt="" loading="lazy" style="max-height:100%;object-fit:cover">
          <?php endif; ?>
        </div>
        <div class="mt2">
          <b><?= htmlspecialchars($m['name']) ?></b>
          <span class="mut"><?= htmlspecialchars($m['folder']) ?> · <?= htmlspecialchars($m['meta']) ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<div class="drawer" id="dMedia" role="dialog" aria-label="Media details">
  <div class="dh">
    <h3>Media details</h3>
    <button class="ib" data-close aria-label="Close">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
    </button>
  </div>
  <div class="db">
    <div class="cover-up" style="max-height:220px;overflow:hidden;border-radius:8px;background:var(--subtle);display:flex;align-items:center;justify-content:center">
      <img id="mdImg" src="" alt="" style="max-height:220px;max-width:100%;object-fit:contain">
    </div>
    <h4 id="mdName" style="margin:14px 0 2px;word-break:break-all"></h4>
    <small class="mut" id="mdMeta"></small>
    <hr class="s">
    <div class="fld">
      <label for="mdUrl">File relative URL</label>
      <div class="row">
        <input class="inp" id="mdUrl" readonly style="flex:1">
        <button class="btn sm" data-copy="#mdUrl" type="button">Copy</button>
      </div>
    </div>
  </div>
  <div class="df">
    <button class="btn d" type="button" id="btnDeleteMedia">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg> Delete file
    </button>
  </div>
</div>

<script>
var curMediaEl = null;

function openMediaDetails(el) {
  curMediaEl = el;
  var name = el.getAttribute('data-name');
  var meta = el.getAttribute('data-meta');
  var url = el.getAttribute('data-url');
  var img = el.querySelector('img');

  document.getElementById('mdName').textContent = name;
  document.getElementById('mdMeta').textContent = meta;
  document.getElementById('mdUrl').value = url;
  var dImg = document.getElementById('mdImg');
  if (img) {
    dImg.src = img.src;
    dImg.style.display = 'block';
  } else {
    dImg.style.display = 'none';
  }

  openM('dMedia');
}

function filterMediaByFolder(folder) {
  var items = document.querySelectorAll('#mg .mi2');
  items.forEach(function(item) {
    if (!folder || item.getAttribute('data-folder') === folder) {
      item.style.display = '';
    } else {
      item.style.display = 'none';
    }
  });
}

function handleMediaUpload(files) {
  if (!files || !files.length) return;
  var csrf = (document.querySelector('meta[name="csrf-token"]')||{}).content||'';
  var baseUrl = (document.querySelector('meta[name="base-url"]')||{}).content||'';

  Array.from(files).forEach(function(f) {
    var fd = new FormData();
    fd.append('_token', csrf);
    fd.append('file', f);

    toast('Uploading ' + f.name + '…', 'ok');
    fetch(baseUrl + '/admin/media/upload', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf },
      body: fd
    }).then(function(r){return r.json()}).then(function(d){
      if (d.success) {
        toast('Uploaded ' + d.name, 'ok');
        setTimeout(function(){ location.reload(); }, 600);
      } else {
        toast(d.error || 'Upload failed', 'bad');
      }
    }).catch(function(){
      toast('Upload network error', 'bad');
    });
  });
}

document.getElementById('btnDeleteMedia').addEventListener('click', function() {
  var url = document.getElementById('mdUrl').value;
  if (!url || !confirm('Permanently delete this media file from disk?')) return;

  var csrf = (document.querySelector('meta[name="csrf-token"]')||{}).content||'';
  var baseUrl = (document.querySelector('meta[name="base-url"]')||{}).content||'';

  fetch(baseUrl + '/admin/media/delete', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify({ _token: csrf, url: url })
  }).then(function(r){return r.json()}).then(function(d){
    if (d.success) {
      closeM();
      if (curMediaEl) curMediaEl.remove();
      toast('File deleted successfully', 'ok');
    } else {
      toast(d.error || 'Failed to delete file', 'bad');
    }
  });
});
</script>
