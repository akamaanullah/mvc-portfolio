<?php
/**
 * Admin · Performance — Fully dynamic Core Web Vitals & Google PageSpeed Insights.
 * Live Google PageSpeed API integration, server TTFB tracking, and error log viewer.
 */
$perf = $perf ?? \App\Services\PageSpeedService::getData();
$vitals = $perf['vitals'] ?? [];
$kpis = $perf['kpis'] ?? [];
$pages = $perf['pages'] ?? [];
$logs = $perf['error_logs'] ?? [];
$curStrategy = $currentStrategy ?? ($perf['strategy'] ?? 'mobile');
$isLive = !empty($perf['is_live']);
$chartJson = json_encode($perf['chart_ttfb'] ?? [
    'labels' => ['00:00', '06:00', '12:00', '18:00', '23:00'],
    'series' => [['n' => 'TTFB ms', 'c' => '#f26a1b', 'data' => [180, 160, 190, 210, 175]]]
], JSON_UNESCAPED_SLASHES);
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / Analytics</div>
    <h1>Performance <?php if ($isLive): ?><span class="pill ok" style="font-size:11px;vertical-align:middle;margin-left:8px;font-weight:600">● Live PageSpeed API</span><?php else: ?><span class="demo" title="Sample data for UI only, not real stats">Demo data</span><?php endif; ?></h1>
    <p>Core Web Vitals (field data, 75th percentile), Lighthouse scores, uptime and real system logs.</p>
  </div>
  <div class="acts">
    <div class="seg">
      <button type="button" class="<?= $curStrategy === 'mobile' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/performance?strategy=mobile') ?>'">Mobile</button>
      <button type="button" class="<?= $curStrategy === 'desktop' ? 'on' : '' ?>" onclick="location.href='<?= base_url('/admin/performance?strategy=desktop') ?>'">Desktop</button>
    </div>
    <button class="btn o" id="btnRunAudit" type="button" onclick="runLighthouseAudit()">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M13 2L3 14h9l-1 8 10-12h-9z"/></svg> <span id="auditText">Run audit</span>
    </button>
  </div>
</div>

<!-- Core Web Vitals (3 cards) -->
<div class="grid g3">
  <div class="card vit">
    <div class="row sb2">
      <b>LCP</b>
      <span class="pill <?= htmlspecialchars($vitals['lcp']['pill'] ?? 'ok') ?>"><?= htmlspecialchars($vitals['lcp']['status'] ?? 'Pass') ?></span>
    </div>
    <small class="mut">Largest Contentful Paint</small>
    <div style="margin-top:10px">
      <b class="v"><?= htmlspecialchars($vitals['lcp']['value'] ?? '2.1') ?></b> 
      <span class="mut"><?= htmlspecialchars($vitals['lcp']['unit'] ?? 's') ?></span>
    </div>
    <div class="gauge"><i style="left:<?= htmlspecialchars($vitals['lcp']['gauge_left'] ?? '30%') ?>"></i></div>
    <small class="mut">Good ≤ 2.5 s · Poor > 4 s</small>
  </div>

  <div class="card vit">
    <div class="row sb2">
      <b>INP</b>
      <span class="pill <?= htmlspecialchars($vitals['inp']['pill'] ?? 'warn') ?>"><?= htmlspecialchars($vitals['inp']['status'] ?? 'Needs work') ?></span>
    </div>
    <small class="mut">Interaction to Next Paint</small>
    <div style="margin-top:10px">
      <b class="v"><?= htmlspecialchars($vitals['inp']['value'] ?? '240') ?></b> 
      <span class="mut"><?= htmlspecialchars($vitals['inp']['unit'] ?? 'ms') ?></span>
    </div>
    <div class="gauge"><i style="left:<?= htmlspecialchars($vitals['inp']['gauge_left'] ?? '45%') ?>"></i></div>
    <small class="mut">Good ≤ 200 ms · Poor > 500 ms</small>
  </div>

  <div class="card vit">
    <div class="row sb2">
      <b>CLS</b>
      <span class="pill <?= htmlspecialchars($vitals['cls']['pill'] ?? 'ok') ?>"><?= htmlspecialchars($vitals['cls']['status'] ?? 'Pass') ?></span>
    </div>
    <small class="mut">Cumulative Layout Shift</small>
    <div style="margin-top:10px">
      <b class="v"><?= htmlspecialchars($vitals['cls']['value'] ?? '0.04') ?></b> 
      <span class="mut"><?= htmlspecialchars($vitals['cls']['unit'] ?? '') ?></span>
    </div>
    <div class="gauge"><i style="left:<?= htmlspecialchars($vitals['cls']['gauge_left'] ?? '12%') ?>"></i></div>
    <small class="mut">Good ≤ 0.1 · Poor > 0.25</small>
  </div>
</div>

<!-- 4 KPIs -->
<div class="grid g4 kp mt">
  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M13 2L3 14h9l-1 8 10-12h-9z"/></svg></i>Uptime (30d)</div>
    <b><?= htmlspecialchars($kpis['uptime'] ?? '99.98%') ?></b>
    <span class="ch up"><?= htmlspecialchars($kpis['uptime_change'] ?? '▲ 0.02%') ?></span>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></i>Avg. TTFB</div>
    <b><?= htmlspecialchars($kpis['ttfb'] ?? '182 ms') ?></b>
    <span class="ch up"><?= htmlspecialchars($kpis['ttfb_change'] ?? '▲ 12%') ?></span>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 16v-4M12 8h.01"/></svg></i>Errors (24h)</div>
    <b><?= htmlspecialchars((string) ($kpis['errors_24h'] ?? 0)) ?></b>
    <span class="ch dn"><?= htmlspecialchars($kpis['errors_change'] ?? '0 active') ?></span>
  </div>

  <div class="card kpi">
    <div class="l"><i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 8h10M7 12h6"/><path d="M12 21l-3-3H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2h-4z"/></svg></i>Chatbot latency</div>
    <b><?= htmlspecialchars($kpis['chatbot_latency'] ?? '1.2 s') ?></b>
    <span class="ch dn"><?= htmlspecialchars($kpis['chatbot_change'] ?? '▼ 0.3 s') ?></span>
  </div>
</div>

<!-- Server Response Time Chart -->
<div class="mt">
  <section class="card ">
    <div class="hd">
      <h3>Server response time (24h)</h3>
      <div class="r">
        <div class="legend">
          <span><i style="background:#f26a1b"></i>Avg TTFB</span>
          <span><i style="background:#ef4444"></i>p95</span>
        </div>
      </div>
    </div>
    <div class="bd2">
      <svg class="chart" id="cTt" style="height:220px" data-chart='<?= htmlspecialchars($chartJson, ENT_QUOTES, 'UTF-8') ?>' role="img" aria-label="Server response time"></svg>
    </div>
  </section>
</div>

<!-- Per-page Lighthouse Scores -->
<section class="card mt">
  <div class="hd">
    <h3>Per-page Lighthouse scores</h3>
  </div>
  <div class="tw" style="margin-top:8px">
    <table class="t">
      <thead>
        <tr>
          <th>Page</th>
          <th>Perf.</th>
          <th>A11y</th>
          <th>Best pr.</th>
          <th>SEO</th>
          <th class="num">LCP</th>
          <th class="num">CLS</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pages as $p): ?>
          <tr data-row>
            <td><b><a href="<?= base_url($p['path']) ?>" target="_blank" rel="noopener" style="color:inherit;text-decoration:none"><?= htmlspecialchars($p['path']) ?></a></b></td>
            <td><span class="gscore <?= $p['perf'] >= 90 ? 'ok' : ($p['perf'] >= 50 ? 'warn' : 'bad') ?>"><?= $p['perf'] ?></span></td>
            <td><span class="gscore <?= $p['a11y'] >= 90 ? 'ok' : ($p['a11y'] >= 50 ? 'warn' : 'bad') ?>"><?= $p['a11y'] ?></span></td>
            <td><span class="gscore <?= $p['best_pr'] >= 90 ? 'ok' : ($p['best_pr'] >= 50 ? 'warn' : 'bad') ?>"><?= $p['best_pr'] ?></span></td>
            <td><span class="gscore <?= $p['seo'] >= 90 ? 'ok' : ($p['seo'] >= 50 ? 'warn' : 'bad') ?>"><?= $p['seo'] ?></span></td>
            <td class="num"><?= htmlspecialchars($p['lcp']) ?></td>
            <td class="num"><?= htmlspecialchars($p['cls']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<!-- Error Log Viewer -->
<div class="mt">
  <section class="card ">
    <div class="hd">
      <h3>System & Error log</h3>
      <div class="r">
        <select class="sel" id="selLogLevel" style="height:34px" onchange="filterErrorLogs(this.value)">
          <option value="ALL">All levels</option>
          <option value="ERROR">Errors only</option>
          <option value="WARN">Warnings only</option>
          <option value="INFO">Info only</option>
        </select>
        <a href="<?= base_url('/admin/performance/download-log') ?>" class="btn sm" download style="text-decoration:none;display:inline-flex;align-items:center;gap:4px">
          <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg> Download
        </a>
      </div>
    </div>
    <div class="bd2">
      <pre class="log" id="logContainer"><?php if (empty($logs)): ?><span class="mut">No log entries found.</span><?php else: ?><?php foreach ($logs as $log): ?><div class="log-entry" data-level="<?= trim($log['level']) ?>" style="display:block"><span class="d"><?= htmlspecialchars($log['date']) ?></span> <span class="<?= htmlspecialchars($log['class']) ?>"><?= htmlspecialchars($log['level']) ?></span> <?= $log['message'] ?></div><?php endforeach; ?><?php endif; ?></pre>
    </div>
  </section>
</div>

<script>
function runLighthouseAudit() {
  var btn = document.getElementById('btnRunAudit');
  var txt = document.getElementById('auditText');
  var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
  var baseUrl = (document.querySelector('meta[name="base-url"]') || {}).content || '';
  var strategy = '<?= htmlspecialchars($curStrategy) ?>';

  if (btn) btn.disabled = true;
  if (txt) txt.textContent = 'Auditing...';
  toast('Running Lighthouse audit via Google PageSpeed API (this may take ~10-15s)...', 'ok');

  fetch(baseUrl + '/admin/performance/run', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': csrf
    },
    body: JSON.stringify({
      _token: csrf,
      strategy: strategy
    })
  })
  .then(function(res) { return res.json(); })
  .then(function(d) {
    if (d.success) {
      toast(d.message || 'Lighthouse audit completed!', 'ok');
      setTimeout(function() { window.location.reload(); }, 600);
    } else {
      toast(d.error || 'Audit failed', 'bad');
      if (btn) btn.disabled = false;
      if (txt) txt.textContent = 'Run audit';
    }
  })
  .catch(function(err) {
    toast('Error connecting to PageSpeed API', 'bad');
    if (btn) btn.disabled = false;
    if (txt) txt.textContent = 'Run audit';
  });
}

function filterErrorLogs(level) {
  var entries = document.querySelectorAll('#logContainer .log-entry');
  entries.forEach(function(el) {
    var lvl = el.getAttribute('data-level') || '';
    if (level === 'ALL' || lvl.indexOf(level) > -1) {
      el.style.display = 'block';
    } else {
      el.style.display = 'none';
    }
  });
}
</script>
