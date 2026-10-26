<?php /* Admin · Landing pages — dynamic view. */ 
$landingsList = $landingPages ?? [];
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / Content</div>
    <h1>Landing pages <span class="pill ok"><?= count($landingsList) ?> active</span></h1>
    <p>SEO landing pages targeting localized searches (e.g. Karachi, Pakistan).</p>
  </div>
  <div class="acts">
    <a class="btn o" href="<?= base_url('/admin/landing-pages/edit') ?>">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg> New landing page
    </a>
  </div>
</div>

<section class="card">
  <div class="toolbar">
    <label class="isrch">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg>
      <input placeholder="Search landing pages…" data-filter="#tLanding">
    </label>
  </div>
  <div class="tw">
    <table class="t" id="tLanding">
      <thead>
        <tr>
          <th style="width:40px">#</th>
          <th>Page</th>
          <th>City / Region</th>
          <th>Status</th>
          <th class="num">Views</th>
          <th style="width:140px;text-align:right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($landingsList)): ?>
          <tr><td colspan="6" class="mut" style="text-align:center;padding:24px">No landing pages found. Click "New landing page" to add one.</td></tr>
        <?php else: ?>
          <?php foreach ($landingsList as $i => $lp): 
            $isActive = !empty($lp['is_active']);
            $statusClass = $isActive ? 'ok' : 'mu';
            $statusLabel = $isActive ? 'Active' : 'Draft';
          ?>
          <tr data-row id="lp-row-<?= $lp['id'] ?>">
            <td><span class="mut" style="font-size:12px"><?= $i + 1 ?></span></td>
            <td>
              <b><?= htmlspecialchars($lp['title']) ?></b>
              <br>
              <a href="<?= base_url('/' . $lp['slug']) ?>" target="_blank" style="color:var(--brand);text-decoration:none;font-size:12px">
                /<?= htmlspecialchars($lp['slug']) ?> ↗
              </a>
            </td>
            <td><span class="tag"><?= htmlspecialchars($lp['city'] ?? 'Karachi') ?></span></td>
            <td><span class="pill <?= $statusClass ?>"><?= $statusLabel ?></span></td>
            <td class="num"><?= number_format((int)($lp['views_count'] ?? 0)) ?></td>
            <td style="text-align:right;white-space:nowrap">
              <a class="btn sm g" title="View live" href="<?= base_url('/' . $lp['slug']) ?>" target="_blank">
                <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
              </a>
              <a class="btn sm g" title="Edit" href="<?= base_url('/admin/landing-pages/edit?id=' . $lp['id']) ?>">
                <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
              </a>
              <button class="btn sm g d" title="Delete" data-confirm="Delete landing page “<?= htmlspecialchars($lp['title']) ?>”?" data-del-landing="<?= $lp['id'] ?>">
                <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg>
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  var baseUrl = '<?= base_url() ?>';

  document.querySelectorAll('[data-del-landing]').forEach(function(btn){
    btn.addEventListener('click', function(e){
      e.preventDefault();
      var id = this.getAttribute('data-del-landing');
      var msg = this.getAttribute('data-confirm') || 'Are you sure you want to delete this landing page?';
      if (!confirm(msg)) return;

      fetch(baseUrl + '/admin/landing-pages/delete', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({ id: id, _token: csrf })
      })
      .then(function(r){ return r.json(); })
      .then(function(data){
        if (data.success) {
          var row = document.getElementById('lp-row-' + id);
          if (row) row.remove();
          if (typeof AK !== 'undefined' && AK.toast) {
            AK.toast('Landing page deleted.', 'ok');
          } else {
            alert('Landing page deleted.');
          }
        } else {
          alert(data.error || 'Failed to delete landing page.');
        }
      })
      .catch(function(){
        alert('Network error deleting landing page.');
      });
    });
  });
});
</script>
