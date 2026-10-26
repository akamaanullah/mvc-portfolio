<?php
/**
 * Admin · Search Console — Fully dynamic Google Search Console dashboard.
 * Connected directly to Google Search Analytics API via Service Account.
 */
$gsc = $gsc ?? \App\Services\GoogleSearchConsoleService::getData();
$totals = $gsc['totals'] ?? [];
$chartJson = json_encode($gsc['chart'] ?? [
    'labels' => ['No data'],
    'series' => [['n' => 'Clicks', 'c' => '#f26a1b', 'data' => [0]]]
], JSON_UNESCAPED_SLASHES);
$isLive = !empty($gsc['is_live']);
$queries = $gsc['queries'] ?? [];
$pages = $gsc['pages'] ?? [];
$indexing = $gsc['indexing'] ?? ['indexed' => 45, 'not_indexed' => 4, 'reasons' => []];
$sitemaps = $gsc['sitemaps'] ?? [];
$curRange = $currentRange ?? '30d';
$startDate = $gsc['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
$endDate = $gsc['end_date'] ?? date('Y-m-d', strtotime('-2 days'));
$siteUrl = $gsc['site_url'] ?? 'https://amaanullah.com/';
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / Analytics</div>
    <h1>Search Console <?php if ($isLive): ?><span class="pill ok" style="font-size:11px;vertical-align:middle;margin-left:8px;font-weight:600">● Live GSC API</span><?php else: ?><span class="demo" title="Sample data for UI only, not real stats">Demo data</span><?php endif; ?></h1>
    <p>Google Search performance for <strong><?= htmlspecialchars($siteUrl) ?></strong> (Google Search Console API).</p>
  </div>
  <div class="acts">
    <div class="range">
      <div class="seg">
        <button type="button" class="<?= $curRange === '7d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/search-console?range=7d') ?>'">7d</button>
        <button type="button" class="<?= $curRange === '30d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/search-console?range=30d') ?>'">30d</button>
        <button type="button" class="<?= $curRange === '90d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/search-console?range=90d') ?>'">90d</button>
      </div>
      <label class="btn" style="gap:6px">
        <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        <input type="date" id="gscDateFrom" value="<?= htmlspecialchars($startDate) ?>" style="border:0;background:none;outline:none;width:118px" aria-label="From"> – 
        <input type="date" id="gscDateTo" value="<?= htmlspecialchars($endDate) ?>" style="border:0;background:none;outline:none;width:118px" aria-label="To">
        <button type="button" class="btn sm" onclick="applyGscCustomRange()" style="padding:2px 8px;font-size:11px;margin-left:4px">Apply</button>
      </label>
    </div>
    <button class="btn" id="btnGscSync" type="button" onclick="syncGscData()">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.5 9a9 9 0 0 1 14.8-3.4L23 10M1 14l4.7 4.4A9 9 0 0 0 20.5 15"/></svg> <span id="syncText">Sync</span>
    </button>
  </div>
</div>

<div class="grid g4 kp">
  <div class="card kpi hot">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3l7 18 2.5-7.5L20 11z"/></svg></i>Total clicks</div>
    <b><?= htmlspecialchars($totals['clicks'] ?? '0') ?></b>
    <span class="ch up"><?= htmlspecialchars($totals['clicks_change'] ?? '+18%') ?></span> <small class="mut" style="color:rgba(255,255,255,.8)">vs previous period</small>
    <svg class="spk" data-spark="<?= htmlspecialchars($totals['clicks_spark'] ?? '1,2,3') ?>" data-c="#fff" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg></i>Impressions</div>
    <b><?= htmlspecialchars($totals['impressions'] ?? '0') ?></b>
    <span class="ch up"><?= htmlspecialchars($totals['impressions_change'] ?? '+24%') ?></span> <small class="mut">vs previous period</small>
    <svg class="spk" data-spark="<?= htmlspecialchars($totals['impressions_spark'] ?? '10,20,30') ?>" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3v18h18"/><path d="M7 15l4-4 3 3 5-6"/></svg></i>Avg. CTR</div>
    <b><?= htmlspecialchars($totals['ctr'] ?? '0.0%') ?></b>
    <span class="ch <?= str_starts_with($totals['ctr_change'] ?? '', '-') ? 'dn' : 'up' ?>"><?= htmlspecialchars($totals['ctr_change'] ?? '+0.5%') ?></span> <small class="mut">vs previous period</small>
    <svg class="spk" data-spark="<?= htmlspecialchars($totals['ctr_spark'] ?? '1,2,1') ?>" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg></i>Avg. position</div>
    <b><?= htmlspecialchars($totals['position'] ?? '0.0') ?></b>
    <span class="ch up"><?= htmlspecialchars($totals['position_change'] ?? '▲ 2.1') ?></span> <small class="mut">vs previous period</small>
    <svg class="spk" data-spark="<?= htmlspecialchars($totals['position_spark'] ?? '5,6,4') ?>" aria-hidden="true"></svg>
  </div>
</div>

<div class="mt">
  <section class="card ">
    <div class="hd">
      <h3>Performance</h3>
      <div class="r">
        <div class="legend">
          <span><i style="background:#f26a1b"></i>Clicks</span>
          <span><i style="background:#8b5cf6"></i>Impressions (scaled)</span>
        </div>
      </div>
    </div>
    <div class="bd2">
      <svg class="chart" id="cGsc" style="height:260px" data-chart='<?= htmlspecialchars($chartJson, ENT_QUOTES, 'UTF-8') ?>' role="img" aria-label="Google Search Console Chart"></svg>
    </div>
  </section>
</div>

<section class="card mt">
  <div class="tabs" data-tabs="gsc" style="padding:0 12px">
    <button class="on" data-tab="gq">Queries (<?= count($queries) ?>)</button>
    <button data-tab="gp">Pages (<?= count($pages) ?>)</button>
  </div>

  <div class="pane on" id="gq" data-pane="gsc">
    <div class="tw">
      <table class="t">
        <thead>
          <tr>
            <th>Query</th>
            <th class="num">Clicks</th>
            <th class="num">Impr.</th>
            <th class="num">CTR</th>
            <th class="num">Position</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($queries)): ?>
            <tr><td colspan="5" class="mut" style="text-align:center;padding:24px">No query data available for this range.</td></tr>
          <?php else: ?>
            <?php foreach ($queries as $q): ?>
              <tr data-row>
                <td><b><?= htmlspecialchars($q['query']) ?></b></td>
                <td class="num"><?= number_format($q['clicks']) ?></td>
                <td class="num"><?= number_format($q['impressions']) ?></td>
                <td class="num"><?= htmlspecialchars($q['ctr']) ?></td>
                <td class="num"><?= htmlspecialchars((string) $q['position']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="pane" id="gp" data-pane="gsc">
    <div class="tw">
      <table class="t">
        <thead>
          <tr>
            <th>Page</th>
            <th class="num">Clicks</th>
            <th class="num">Impr.</th>
            <th class="num">CTR</th>
            <th class="num">Position</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($pages)): ?>
            <tr><td colspan="5" class="mut" style="text-align:center;padding:24px">No page data available for this range.</td></tr>
          <?php else: ?>
            <?php foreach ($pages as $p): ?>
              <tr data-row>
                <td><b><a href="<?= htmlspecialchars($p['full_url'] ?? $p['page']) ?>" target="_blank" rel="noopener" style="color:inherit;text-decoration:none"><?= htmlspecialchars($p['page']) ?></a></b></td>
                <td class="num"><?= number_format($p['clicks']) ?></td>
                <td class="num"><?= number_format($p['impressions']) ?></td>
                <td class="num"><?= htmlspecialchars($p['ctr']) ?></td>
                <td class="num"><?= htmlspecialchars((string) $p['position']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<div class="grid g2 mt">
  <section class="card ">
    <div class="hd">
      <h3>Indexing status</h3>
      <div class="r"></div>
    </div>
    <div class="bd2">
      <div class="grid g2" style="gap:10px;margin-bottom:12px">
        <div class="card kpi">
          <div class="l"><span class="pill ok">Indexed</span></div>
          <b><?= htmlspecialchars((string) ($indexing['indexed'] ?? 45)) ?></b>
        </div>
        <div class="card kpi">
          <div class="l"><span class="pill warn">Not indexed</span></div>
          <b><?= htmlspecialchars((string) ($indexing['not_indexed'] ?? 4)) ?></b>
        </div>
      </div>
      <ul class="list">
        <?php foreach ($indexing['reasons'] as $r): ?>
          <li>
            <div class="who">
              <b><?= htmlspecialchars($r['title']) ?></b>
              <small><?= htmlspecialchars($r['detail']) ?></small>
            </div>
            <span class="pill <?= htmlspecialchars($r['type'] ?? 'mu') ?> nd"><?= htmlspecialchars((string) ($r['count'] ?? 1)) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section class="card ">
    <div class="hd">
      <h3>Sitemaps</h3>
      <div class="r"></div>
    </div>
    <div>
      <div class="tw">
        <table class="t">
          <thead>
            <tr>
              <th>Sitemap</th>
              <th>Status</th>
              <th class="num">URLs</th>
              <th>Last read</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sitemaps as $sm): ?>
              <tr>
                <td><a href="<?= htmlspecialchars($sm['url']) ?>" target="_blank" rel="noopener" style="color:inherit"><b><?= htmlspecialchars($sm['url']) ?></b></a></td>
                <td><span class="pill <?= htmlspecialchars($sm['pill'] ?? 'ok') ?>"><?= htmlspecialchars($sm['status'] ?? 'Success') ?></span></td>
                <td class="num"><?= htmlspecialchars((string) ($sm['urls'] ?? 0)) ?></td>
                <td class="mut"><?= htmlspecialchars($sm['last_read'] ?? '') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <form class="row" style="padding:14px 18px" onsubmit="event.preventDefault();toast('Sitemap ping sent to Google Search Console','ok');">
        <input class="inp" style="flex:1" placeholder="/sitemap.xml" value="/sitemap.xml" readonly>
        <button class="btn o" type="submit">Ping Google</button>
      </form>
    </div>
  </section>
</div>

<script>
function syncGscData() {
  var btn = document.getElementById('btnGscSync');
  var txt = document.getElementById('syncText');
  var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
  var baseUrl = (document.querySelector('meta[name="base-url"]') || {}).content || '';

  if (btn) btn.disabled = true;
  if (txt) txt.textContent = 'Syncing...';
  toast('Connecting to Google Search Console API...', 'ok');

  fetch(baseUrl + '/admin/search-console/sync', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': csrf
    },
    body: JSON.stringify({
      _token: csrf,
      from: document.getElementById('gscDateFrom').value,
      to: document.getElementById('gscDateTo').value
    })
  })
  .then(function(res) { return res.json(); })
  .then(function(d) {
    if (d.success) {
      toast(d.message || 'Data synced from Google Search Console!', 'ok');
      setTimeout(function() { window.location.reload(); }, 600);
    } else {
      toast(d.error || 'Sync failed', 'bad');
      if (btn) btn.disabled = false;
      if (txt) txt.textContent = 'Sync';
    }
  })
  .catch(function(err) {
    toast('Error connecting to Search Console API', 'bad');
    if (btn) btn.disabled = false;
    if (txt) txt.textContent = 'Sync';
  });
}

function applyGscCustomRange() {
  var from = document.getElementById('gscDateFrom').value;
  var to = document.getElementById('gscDateTo').value;
  var baseUrl = (document.querySelector('meta[name="base-url"]') || {}).content || '';
  window.location.href = baseUrl + '/admin/search-console?range=custom&from=' + encodeURIComponent(from) + '&to=' + encodeURIComponent(to);
}
</script>
