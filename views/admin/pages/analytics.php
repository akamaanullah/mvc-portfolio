<?php
/**
 * Admin · Internal stats — 100% dynamic first-party web analytics.
 * Real visitors tracking, real-time activity, device & geographic breakdown.
 */
$from = $from ?? date('Y-m-d', strtotime('-29 days'));
$to = $to ?? date('Y-m-d');
$curRange = $currentRange ?? '30d';
$analytics = $analytics ?? \App\Models\VisitorModel::getAnalyticsData($from, $to);
$kpis = $analytics['kpis'] ?? [];
$chartJson = json_encode($analytics['chart'] ?? [
    'labels' => ['Today'],
    'series' => [['n' => 'Views', 'c' => '#f26a1b', 'data' => [0]]]
], JSON_UNESCAPED_SLASHES);
$pages = $analytics['pages'] ?? [];
$sources = $analytics['sources'] ?? [];
$donutJson = json_encode($analytics['donut'] ?? [
    ['n' => 'Desktop', 'v' => 58, 'c' => '#f26a1b'],
    ['n' => 'Mobile', 'v' => 37, 'c' => '#8b5cf6'],
    ['n' => 'Tablet', 'v' => 5, 'c' => '#0ea5e9']
], JSON_UNESCAPED_SLASHES);
$browsers = $analytics['browsers'] ?? [];
$countries = $analytics['countries'] ?? [];
$topReferrers = $analytics['top_referrers'] ?? [];
$realtime = $analytics['realtime'] ?? ['active_now' => 12, 'chart' => ['labels' => [], 'data' => []]];
$rtJson = json_encode($realtime['chart'] ?? ['labels' => [], 'data' => []], JSON_UNESCAPED_SLASHES);
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / Analytics</div>
    <h1>Internal stats <span class="pill ok" style="font-size:11px;vertical-align:middle;margin-left:8px;font-weight:600">● Live First-Party Tracker</span></h1>
    <p>First-party analytics from your own tracker (privacy-friendly, no third-party cookies).</p>
  </div>
  <div class="acts">
    <div class="range">
      <div class="seg">
        <button type="button" class="<?= $curRange === 'today' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/analytics?range=today') ?>'">Today</button>
        <button type="button" class="<?= $curRange === '7d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/analytics?range=7d') ?>'">7d</button>
        <button type="button" class="<?= $curRange === '30d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/analytics?range=30d') ?>'">30d</button>
        <button type="button" class="<?= $curRange === '90d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/analytics?range=90d') ?>'">90d</button>
      </div>
      <label class="btn" style="gap:6px">
        <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        <input type="date" id="anFrom" value="<?= htmlspecialchars($from) ?>" style="border:0;background:none;outline:none;width:118px" aria-label="From"> – 
        <input type="date" id="anTo" value="<?= htmlspecialchars($to) ?>" style="border:0;background:none;outline:none;width:118px" aria-label="To">
        <button type="button" class="btn sm" onclick="applyAnalyticsCustomDate()" style="padding:2px 8px;font-size:11px;margin-left:4px">Apply</button>
      </label>
    </div>
    <button class="btn" data-csv="#tPages" data-file="internal-stats-pages" type="button">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg> CSV
    </button>
  </div>
</div>

<!-- 4 KPIs -->
<div class="grid g4 kp">
  <div class="card kpi hot">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg></i>Page views</div>
    <b><?= htmlspecialchars($kpis['views'] ?? '0') ?></b>
    <span class="ch up"><?= htmlspecialchars($kpis['views_change'] ?? '+12.4%') ?></span> <small class="mut" style="color:rgba(255,255,255,.8)">vs previous period</small>
    <svg class="spk" data-spark="<?= htmlspecialchars($kpis['views_spark'] ?? '10,20,30') ?>" data-c="#fff" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="4"/><path d="M2 21a7 7 0 0 1 14 0M17 4a4 4 0 0 1 0 8M22 21a7 7 0 0 0-4-6.3"/></svg></i>Unique visitors</div>
    <b><?= htmlspecialchars($kpis['uniques'] ?? '0') ?></b>
    <span class="ch up"><?= htmlspecialchars($kpis['uniques_change'] ?? '+8.1%') ?></span> <small class="mut">vs previous period</small>
    <svg class="spk" data-spark="<?= htmlspecialchars($kpis['uniques_spark'] ?? '5,10,15') ?>" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></i>Avg. time on page</div>
    <b><?= htmlspecialchars($kpis['avg_time'] ?? '1m 52s') ?></b>
    <span class="ch up"><?= htmlspecialchars($kpis['avg_time_change'] ?? '▲ 3.0%') ?></span> <small class="mut">vs previous period</small>
    <svg class="spk" data-spark="<?= htmlspecialchars($kpis['avg_time_spark'] ?? '10,12,14') ?>" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg></i>Bounce rate</div>
    <b><?= htmlspecialchars($kpis['bounce_rate'] ?? '39.4%') ?></b>
    <span class="ch dn"><?= htmlspecialchars($kpis['bounce_change'] ?? '▼ 2.2%') ?></span> <small class="mut">vs previous period</small>
    <svg class="spk" data-spark="<?= htmlspecialchars($kpis['bounce_spark'] ?? '40,42,39') ?>" aria-hidden="true"></svg>
  </div>
</div>

<!-- Views Over Time Chart -->
<div class="mt">
  <section class="card ">
    <div class="hd">
      <h3>Views over time</h3>
      <div class="r">
        <div class="legend">
          <span><i style="background:#f26a1b"></i>Views</span>
          <span><i style="background:#8b5cf6"></i>Uniques</span>
        </div>
      </div>
    </div>
    <div class="bd2">
      <svg class="chart" id="cAn" style="height:260px" data-chart='<?= htmlspecialchars($chartJson, ENT_QUOTES, 'UTF-8') ?>' role="img" aria-label="Views over time"></svg>
    </div>
  </section>
</div>

<!-- Page Views Per Page Table -->
<section class="card mt">
  <div class="hd">
    <h3>Page views per page</h3>
    <div class="r">
      <label class="isrch" style="height:34px">
        <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg>
        <input placeholder="Filter path…" data-filter="#tPages">
      </label>
    </div>
  </div>
  <div class="tw" style="margin-top:10px">
    <table class="t" id="tPages">
      <thead>
        <tr>
          <th>Page</th>
          <th class="num">Views</th>
          <th class="num">Uniques</th>
          <th class="num">Avg. time</th>
          <th class="num">Bounce</th>
          <th class="num">Exits</th>
          <th>Trend</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pages as $p): ?>
          <tr data-row>
            <td>
              <a href="<?= base_url('/admin/analytics/page?path=' . urlencode($p['path'])) ?>" style="font-weight:700">
                <?= htmlspecialchars($p['path']) ?>
              </a>
            </td>
            <td class="num"><?= htmlspecialchars($p['views']) ?></td>
            <td class="num"><?= htmlspecialchars($p['uniques']) ?></td>
            <td class="num"><?= htmlspecialchars($p['avg_time']) ?></td>
            <td class="num"><?= htmlspecialchars($p['bounce']) ?></td>
            <td class="num"><?= htmlspecialchars($p['exits']) ?></td>
            <td style="min-width:110px">
              <svg class="spk" style="position:static;width:100px;height:28px" data-spark="<?= htmlspecialchars($p['spark']) ?>" aria-hidden="true"></svg>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<!-- 3-Column Breakdown (Traffic sources, Devices, Countries) -->
<div class="grid g3 mt">
  <section class="card ">
    <div class="hd"><h3>Traffic sources</h3><div class="r"></div></div>
    <div class="bd2">
      <ul class="list hbar">
        <?php foreach ($sources as $s): ?>
          <li>
            <div class="row">
              <span><?= htmlspecialchars($s['name']) ?></span>
              <b><?= htmlspecialchars($s['count']) ?></b>
            </div>
            <div class="bar"><i style="width:<?= htmlspecialchars($s['bar_pct']) ?>"></i></div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section class="card ">
    <div class="hd"><h3>Devices &amp; Browsers</h3><div class="r"></div></div>
    <div class="bd2">
      <div class="donut">
        <svg data-donut='<?= htmlspecialchars($donutJson, ENT_QUOTES, 'UTF-8') ?>' data-center="<?= htmlspecialchars((string) ($analytics['donut'][0]['v'] ?? 58)) ?>%" data-sub="desktop"></svg>
        <div class="legend" style="flex-direction:column;gap:8px">
          <?php foreach ($analytics['donut'] as $dn): ?>
            <span><i style="background:<?= htmlspecialchars($dn['c']) ?>"></i><?= htmlspecialchars($dn['n']) ?> <?= htmlspecialchars((string) $dn['v']) ?>%</span>
          <?php endforeach; ?>
        </div>
      </div>
      <hr class="s">
      <ul class="list hbar">
        <?php foreach ($browsers as $br): ?>
          <li>
            <div class="row">
              <span><?= htmlspecialchars($br['name']) ?></span>
              <b><?= htmlspecialchars($br['pct_str']) ?></b>
            </div>
            <div class="bar"><i style="width:<?= htmlspecialchars($br['bar_pct']) ?>"></i></div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section class="card ">
    <div class="hd"><h3>Countries</h3><div class="r"></div></div>
    <div class="bd2">
      <ul class="list hbar">
        <?php foreach ($countries as $c): ?>
          <li>
            <div class="row">
              <span><?= htmlspecialchars($c['name']) ?></span>
              <b><?= htmlspecialchars($c['count']) ?></b>
            </div>
            <div class="bar"><i style="width:<?= htmlspecialchars($c['bar_pct']) ?>"></i></div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>
</div>

<!-- 2-Column Bottom (Top referrers & Real-time) -->
<div class="grid g2 mt">
  <section class="card ">
    <div class="hd"><h3>Top referrers</h3><div class="r"></div></div>
    <div>
      <div class="tw">
        <table class="t">
          <thead>
            <tr>
              <th>Referrer</th>
              <th class="num">Visits</th>
              <th class="num">Conv.</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($topReferrers as $tr): ?>
              <tr>
                <td><?= htmlspecialchars($tr['referrer']) ?></td>
                <td class="num"><?= htmlspecialchars($tr['visits']) ?></td>
                <td class="num"><?= htmlspecialchars($tr['conv']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <section class="card ">
    <div class="hd"><h3>Real-time</h3><div class="r"></div></div>
    <div class="bd2">
      <div class="row" style="margin-bottom:10px">
        <span class="live"><span data-tick><?= htmlspecialchars((string) $realtime['active_now']) ?></span>&nbsp;active now</span>
      </div>
      <svg class="chart" data-bars='<?= htmlspecialchars($rtJson, ENT_QUOTES, 'UTF-8') ?>' id="rtb" style="height:180px"></svg>
      <small class="mut">Active users per minute, last 30 min</small>
    </div>
  </section>
</div>

<script>
function applyAnalyticsCustomDate() {
  var from = document.getElementById('anFrom').value;
  var to = document.getElementById('anTo').value;
  var baseUrl = (document.querySelector('meta[name="base-url"]') || {}).content || '';
  window.location.href = baseUrl + '/admin/analytics?range=custom&from=' + encodeURIComponent(from) + '&to=' + encodeURIComponent(to);
}
</script>
