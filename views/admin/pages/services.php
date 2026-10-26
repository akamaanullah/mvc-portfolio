<?php /* Admin · Services — dynamic view. */ 
$servicesList = $services ?? [];
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / Content</div>
    <h1>Services <span class="pill ok"><?= count($servicesList) ?> active</span></h1>
    <p>Service detail pages rendered dynamically through the master services template.</p>
  </div>
  <div class="acts">
    <a class="btn o" href="<?= base_url('/admin/services/edit') ?>">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg> New service
    </a>
  </div>
</div>

<section class="card">
  <div class="toolbar">
    <label class="isrch">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg>
      <input placeholder="Search services…" data-filter="#tSvc">
    </label>
  </div>
  <div class="tw">
    <table class="t" id="tSvc">
      <thead>
        <tr>
          <th style="width:40px">#</th>
          <th>Service</th>
          <th>Slug &amp; URL</th>
          <th>Status</th>
          <th style="width:140px;text-align:right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($servicesList)): ?>
          <tr><td colspan="5" class="mut" style="text-align:center;padding:24px">No services found. Click "New service" to add one.</td></tr>
        <?php else: ?>
          <?php foreach ($servicesList as $i => $s): 
            $statusClass = ($s['status'] ?? 'published') === 'published' ? 'ok' : 'mu';
            $statusLabel = ucfirst($s['status'] ?? 'published');
          ?>
          <tr data-row id="svc-row-<?= $s['id'] ?>">
            <td><span class="mut" style="font-size:12px"><?= $i + 1 ?></span></td>
            <td>
              <b><?= htmlspecialchars($s['title']) ?></b>
              <?php if (!empty($s['highlight_em'])): ?>
                <span class="mut" style="font-size:12px;display:block"><?= htmlspecialchars($s['highlight_em']) ?></span>
              <?php endif; ?>
            </td>
            <td>
              <a href="<?= base_url('/services/' . $s['slug']) ?>" target="_blank" style="color:var(--brand);text-decoration:none">
                /services/<?= htmlspecialchars($s['slug']) ?> ↗
              </a>
            </td>
            <td><span class="pill <?= $statusClass ?>"><?= $statusLabel ?></span></td>
            <td style="text-align:right;white-space:nowrap">
              <a class="btn sm g" title="View live" href="<?= base_url('/services/' . $s['slug']) ?>" target="_blank">
                <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
              </a>
              <a class="btn sm g" title="Edit service" href="<?= base_url('/admin/services/edit?id=' . $s['id']) ?>">
                <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
              </a>
              <button class="btn sm g d" title="Delete" data-confirm="Delete service “<?= htmlspecialchars($s['title']) ?>”?" data-del-service="<?= $s['id'] ?>">
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

  document.querySelectorAll('[data-del-service]').forEach(function(btn){
    btn.addEventListener('click', function(e){
      e.preventDefault();
      var id = this.getAttribute('data-del-service');
      var msg = this.getAttribute('data-confirm') || 'Are you sure you want to delete this service?';
      if (!confirm(msg)) return;

      fetch(baseUrl + '/admin/services/delete', {
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
          var row = document.getElementById('svc-row-' + id);
          if (row) row.remove();
          if (typeof AK !== 'undefined' && AK.toast) {
            AK.toast('Service deleted successfully.', 'ok');
          } else {
            alert('Service deleted successfully.');
          }
        } else {
          alert(data.error || 'Failed to delete service.');
        }
      })
      .catch(function(){
        alert('Network error deleting service.');
      });
    });
  });
});
</script>
