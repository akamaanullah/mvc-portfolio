<?php
/**
 * Admin · Visitors — 100% dynamic visitors directory.
 */
$from = $from ?? date('Y-m-d', strtotime('-29 days'));
$to = $to ?? date('Y-m-d');
$curRange = $currentRange ?? '30d';
$visitors = $visitors ?? \App\Models\VisitorModel::getVisitorsList();
$totalVisitors = $totalVisitors ?? \App\Models\VisitorModel::count();
$currentPage = $currentPage ?? 1;
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / Analytics</div>
    <h1>Visitors <span class="pill ok" style="font-size:11px;vertical-align:middle;margin-left:8px;font-weight:600">● Live Tracker</span></h1>
    <p>Every visitor, their sessions and full journey. Privacy-conscious first-party logs.</p>
  </div>
  <div class="acts">
    <div class="range">
      <div class="seg">
        <button type="button" class="<?= $curRange === 'today' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/visitors?range=today') ?>'">Today</button>
        <button type="button" class="<?= $curRange === '7d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/visitors?range=7d') ?>'">7d</button>
        <button type="button" class="<?= $curRange === '30d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/visitors?range=30d') ?>'">30d</button>
        <button type="button" class="<?= $curRange === '90d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/visitors?range=90d') ?>'">90d</button>
      </div>
    </div>
  </div>
</div>

<section class="card">
  <div class="toolbar">
    <label class="isrch">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg>
      <input placeholder="Search visitor, city, source…" data-filter="#tVis" id="visSearch">
    </label>
    <select class="sel" id="visStatusFilter" onchange="filterVisitorsTable()">
      <option value="">All visitors</option>
      <option value="online">Online now</option>
      <option value="direct">Direct</option>
      <option value="google">Google</option>
    </select>
    <select class="sel hide-sm" id="visCountryFilter" onchange="filterVisitorsTable()">
      <option value="">Any country</option>
      <option value="Pakistan">Pakistan</option>
      <option value="United States">United States</option>
      <option value="UAE">UAE</option>
      <option value="United Kingdom">United Kingdom</option>
      <option value="Saudi Arabia">Saudi Arabia</option>
    </select>
  </div>

  <div class="tw">
    <table class="t" id="tVis">
      <thead>
        <tr>
          <th>Visitor</th>
          <th>Location</th>
          <th>Device</th>
          <th>Sessions</th>
          <th class="num">Pages</th>
          <th>Source</th>
          <th>Last seen</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($visitors as $v): ?>
          <tr data-row style="cursor:pointer" onclick="location.href=this.dataset.href" data-href="<?= base_url('/admin/visitors/show?id=' . $v['id']) ?>">
            <td>
              <div class="row">
                <span class="ava <?= htmlspecialchars($v['avatar_class']) ?>"><?= htmlspecialchars($v['avatar_text']) ?></span>
                <div>
                  <b><?= htmlspecialchars($v['name']) ?></b><br>
                  <small class="mut"><?= htmlspecialchars($v['subtext']) ?></small>
                </div>
              </div>
            </td>
            <td><?= $v['location'] ?></td>
            <td><?= htmlspecialchars($v['device']) ?></td>
            <td><?= htmlspecialchars((string) $v['sessions']) ?></td>
            <td class="num"><?= htmlspecialchars((string) $v['pages']) ?></td>
            <td class="mut"><?= htmlspecialchars($v['source']) ?></td>
            <td><?= $v['last_seen'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="pg">
    <span class="info">Showing 1–<?= count($visitors) ?> of <?= number_format($totalVisitors) ?></span>
    <?php if ($currentPage > 1): ?>
      <button aria-label="Previous" onclick="location.href='<?= base_url('/admin/visitors?p=' . ($currentPage - 1)) ?>'">‹</button>
    <?php endif; ?>
    <button class="on" data-p><?= $currentPage ?></button>
    <button data-p onclick="location.href='<?= base_url('/admin/visitors?p=' . ($currentPage + 1)) ?>'"><?= $currentPage + 1 ?></button>
    <button data-p onclick="location.href='<?= base_url('/admin/visitors?p=' . ($currentPage + 2)) ?>'"><?= $currentPage + 2 ?></button>
    <button aria-label="Next" onclick="location.href='<?= base_url('/admin/visitors?p=' . ($currentPage + 1)) ?>'">›</button>
  </div>
</section>

<script>
function filterVisitorsTable() {
  var stat = (document.getElementById('visStatusFilter').value || '').toLowerCase();
  var ctry = (document.getElementById('visCountryFilter').value || '').toLowerCase();
  var rows = document.querySelectorAll('#tVis tbody tr');

  rows.forEach(function(r) {
    var txt = r.textContent.toLowerCase();
    var matchStat = !stat || txt.indexOf(stat) > -1;
    var matchCtry = !ctry || txt.indexOf(ctry) > -1;
    r.style.display = (matchStat && matchCtry) ? '' : 'none';
  });
}
</script>
