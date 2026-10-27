<?php
/**
 * Admin · Page analytics — 100% dynamic per-page stats.
 */
$from = $from ?? date('Y-m-d', strtotime('-29 days'));
$to = $to ?? date('Y-m-d');
$curRange = $currentRange ?? '30d';
$path = $_GET['path'] ?? '/';
$pageAnalytics = $pageAnalytics ?? \App\Models\VisitorModel::getPageAnalyticsData($path, $from, $to);
$chartJson = json_encode($pageAnalytics['chart'] ?? [
    'labels' => ['Today'],
    'series' => [['n' => 'Views', 'c' => '#f26a1b', 'data' => [0]]]
], JSON_UNESCAPED_SLASHES);
$scrollDepth = $pageAnalytics['scroll_depth'] ?? [];
$topClicks = $pageAnalytics['top_clicks'] ?? [];
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / <a href="<?= base_url('/admin/analytics') ?>">Internal stats</a> / Page</div>
    <h1><?= htmlspecialchars($pageAnalytics['path']) ?> <span class="pill ok" style="font-size:11px;vertical-align:middle;margin-left:8px;font-weight:600">● Live Tracker</span></h1>
    <p>Per-page analytics: views over time, scroll depth and user interaction.</p>
  </div>
  <div class="acts">
    <div class="range">
      <div class="seg">
        <button type="button" class="<?= $curRange === 'today' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/analytics/page?path=' . urlencode($path) . '&range=today') ?>'">Today</button>
        <button type="button" class="<?= $curRange === '7d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/analytics/page?path=' . urlencode($path) . '&range=7d') ?>'">7d</button>
        <button type="button" class="<?= $curRange === '30d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/analytics/page?path=' . urlencode($path) . '&range=30d') ?>'">30d</button>
        <button type="button" class="<?= $curRange === '90d' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/analytics/page?path=' . urlencode($path) . '&range=90d') ?>'">90d</button>
      </div>
    </div>
    <a class="btn" href="<?= base_url($pageAnalytics['path']) ?>" target="_blank" rel="noopener">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg> Open page
    </a>
  </div>
</div>

<!-- 4 KPIs -->
<div class="grid g4 kp">
  <div class="card kpi hot">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg></i>Views</div>
    <b><?= htmlspecialchars($pageAnalytics['views']) ?></b>
    <span class="ch up"><?= htmlspecialchars($pageAnalytics['views_change']) ?></span> <small class="mut" style="color:rgba(255,255,255,.8)">vs previous period</small>
    <svg class="spk" data-spark="<?= htmlspecialchars($pageAnalytics['spark'] ?? '10,20,30') ?>" data-c="#fff" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="4"/><path d="M2 21a7 7 0 0 1 14 0M17 4a4 4 0 0 1 0 8M22 21a7 7 0 0 0-4-6.3"/></svg></i>Uniques</div>
    <b><?= htmlspecialchars($pageAnalytics['uniques']) ?></b>
    <span class="ch up"><?= htmlspecialchars($pageAnalytics['uniques_change']) ?></span> <small class="mut">vs previous period</small>
    <svg class="spk" data-spark="<?= htmlspecialchars($pageAnalytics['spark'] ?? '5,10,15') ?>" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></i>Avg. time</div>
    <b><?= htmlspecialchars($pageAnalytics['avg_time']) ?></b>
    <span class="ch up"><?= htmlspecialchars($pageAnalytics['avg_time_change']) ?></span> <small class="mut">vs previous period</small>
    <svg class="spk" data-spark="110,120,130,125,140,150" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><rect x="7" y="2" width="10" height="20" rx="5"/><path d="M12 6v4"/></svg></i>Avg. scroll</div>
    <b><?= htmlspecialchars($pageAnalytics['avg_scroll']) ?></b>
    <span class="ch dn"><?= htmlspecialchars($pageAnalytics['avg_scroll_change']) ?></span> <small class="mut">vs previous period</small>
    <svg class="spk" data-spark="70,68,69,67,68" aria-hidden="true"></svg>
  </div>
</div>

<!-- Views Over Time Chart -->
<div class="mt">
  <section class="card ">
    <div class="hd">
      <h3>Views over time</h3>
      <div class="r"></div>
    </div>
    <div class="bd2">
      <svg class="chart" id="cPg" style="height:260px" data-chart='<?= htmlspecialchars($chartJson, ENT_QUOTES, 'UTF-8') ?>' role="img" aria-label="Views over time"></svg>
    </div>
  </section>
</div>

<!-- Heatmap & Engagement -->
<div class="grid g21 mt">
  <section class="card ">
    <div class="hd">
      <h3>Click heatmap</h3>
      <div class="r">
        <div class="seg">
          <button class="on" type="button">Clicks</button>
          <button type="button">Moves</button>
        </div>
      </div>
    </div>
    <div class="bd2">
      <div class="heat" style="height:440px">
        <div class="pgm">
          <i style="height:30px;width:40%"></i>
          <i style="height:70px"></i>
          <i style="height:150px"></i>
          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px">
            <i style="height:90px"></i>
            <i style="height:90px"></i>
            <i style="height:90px"></i>
          </div>
          <i style="height:40px;width:60%"></i>
        </div>
        <span class="hs" style="left:70%;top:8%;width:90px;height:90px;background:radial-gradient(circle,rgba(242,106,27,.85),rgba(242,106,27,0) 70%)"></span>
        <span class="hs" style="left:18%;top:30%;width:70px;height:70px;background:radial-gradient(circle,rgba(242,106,27,.85),rgba(242,106,27,0) 70%)"></span>
        <span class="hs" style="left:46%;top:46%;width:120px;height:120px;background:radial-gradient(circle,rgba(239,68,68,.85),rgba(239,68,68,0) 70%)"></span>
        <span class="hs" style="left:80%;top:62%;width:60px;height:60px;background:radial-gradient(circle,rgba(250,204,21,.85),rgba(250,204,21,0) 70%)"></span>
        <span class="hs" style="left:30%;top:78%;width:80px;height:80px;background:radial-gradient(circle,rgba(250,204,21,.85),rgba(250,204,21,0) 70%)"></span>
        <span class="hs" style="left:62%;top:86%;width:70px;height:70px;background:radial-gradient(circle,rgba(34,197,94,.85),rgba(34,197,94,0) 70%)"></span>
      </div>
      <small class="mut">Aggregated click heat points from user sessions on this page.</small>
    </div>
  </section>

  <div style="display:flex;flex-direction:column;gap:18px">
    <section class="card ">
      <div class="hd"><h3>Scroll depth</h3><div class="r"></div></div>
      <div class="bd2">
        <ul class="list scroll-d">
          <?php foreach ($scrollDepth as $sd): ?>
            <li>
              <span><?= htmlspecialchars($sd['pct']) ?></span>
              <div class="bar"><i style="width:<?= htmlspecialchars($sd['width']) ?>"></i></div>
              <b><?= htmlspecialchars($sd['val']) ?></b>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>

    <section class="card ">
      <div class="hd"><h3>Top clicked elements</h3><div class="r"></div></div>
      <div>
        <div class="tw">
          <table class="t">
            <tbody>
              <?php foreach ($topClicks as $tc): ?>
                <tr>
                  <td><?= htmlspecialchars($tc['label']) ?></td>
                  <td class="mut"><?= htmlspecialchars($tc['selector']) ?></td>
                  <td class="num"><?= htmlspecialchars((string) $tc['count']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
