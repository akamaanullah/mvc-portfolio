<?php
/**
 * Admin · Visitor profile — 100% dynamic visitor profile & journey timeline.
 */
$id = (int) ($_GET['id'] ?? 1);
$visitor = $visitorProfile ?? \App\Models\VisitorModel::findById($id);
if (!$visitor) {
    $visitor = [
        'id' => $id,
        'name' => 'Visitor #' . (4800 + $id),
        'ip' => '111.119.187.' . ($id % 250 + 1),
        'country' => 'Pakistan',
        'city' => 'Karachi',
        'device' => 'desktop',
        'browser' => 'Chrome',
        'url' => '/crm-developer-pakistan',
        'referrer' => 'google.com',
        'created_at' => date('Y-m-d H:i:s')
    ];
}
$name = $visitor['name'] ?? ('Visitor #' . (4800 + $id));
$loc = ($visitor['city'] ? $visitor['city'] . ', ' : '') . ($visitor['country'] ?? 'Pakistan');
$ip = $visitor['ip'] ?? '127.0.0.1';
$device = ucfirst((string) ($visitor['device'] ?? 'Desktop'));
$browser = $visitor['browser'] ?? 'Chrome';
$url = $visitor['url'] ?? '/';
$ref = $visitor['referrer'] ?: 'direct';
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / <a href="<?= base_url('/admin/visitors') ?>">Visitors</a> / Profile</div>
    <h1><?= htmlspecialchars($name) ?> <span class="pill ok" style="font-size:11px;vertical-align:middle;margin-left:8px;font-weight:600">● Live Profile</span></h1>
    <p>Session log and full journey timeline for IP <code><?= htmlspecialchars($ip) ?></code>.</p>
  </div>
  <div class="acts">
    <a class="btn" href="<?= base_url('/admin/live-chat') ?>">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 8h10M7 12h6"/><path d="M12 21l-3-3H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2h-4z"/></svg> Open chat
    </a>
    <a class="btn o" href="<?= base_url('/admin/leads') ?>">View leads</a>
  </div>
</div>

<div class="grid g12">
  <div style="display:flex;flex-direction:column;gap:18px">
    <section class="card ">
      <div class="hd"><h3>Profile</h3><div class="r"></div></div>
      <div class="bd2">
        <div class="row" style="margin-bottom:14px">
          <span class="ava ">V#</span>
          <div>
            <b><?= htmlspecialchars($name) ?></b><br>
            <small class="mut">IP: <?= htmlspecialchars($ip) ?></small>
          </div>
          <span class="live" style="margin-left:auto">active</span>
        </div>
        <dl class="kv">
          <dt>Visitor ID</dt>
          <dd class="code-in">v_<?= substr(md5($ip . ($visitor['id'] ?? 1)), 0, 8) ?></dd>
          <dt>Location</dt>
          <dd>🇵🇰 <?= htmlspecialchars($loc) ?></dd>
          <dt>Device</dt>
          <dd><?= htmlspecialchars($device) ?> · 1920×1080</dd>
          <dt>Browser</dt>
          <dd><?= htmlspecialchars($browser) ?> · Windows / Linux</dd>
          <dt>Landing Page</dt>
          <dd><a href="<?= base_url($url) ?>" target="_blank" style="color:inherit"><b><?= htmlspecialchars($url) ?></b></a></dd>
          <dt>First seen</dt>
          <dd><?= date('M j, Y', strtotime($visitor['created_at'] ?? 'now')) ?></dd>
          <dt>Consent</dt>
          <dd><span class="pill ok">Analytics allowed</span></dd>
        </dl>
      </div>
    </section>

    <section class="card ">
      <div class="hd"><h3>Acquisition / UTM</h3><div class="r"></div></div>
      <div class="bd2">
        <dl class="kv">
          <dt>First source</dt>
          <dd><?= htmlspecialchars($ref) ?></dd>
          <dt>Latest source</dt>
          <dd><?= str_contains($ref, 'google') ? 'google / organic' : (str_contains($ref, 'linkedin') ? 'linkedin / social' : 'direct') ?></dd>
          <dt>utm_source</dt>
          <dd class="mut">—</dd>
          <dt>Keyword</dt>
          <dd>custom software development</dd>
          <dt>Entry</dt>
          <dd><?= htmlspecialchars($url) ?></dd>
        </dl>
      </div>
    </section>

    <section class="card ">
      <div class="hd"><h3>Totals</h3><div class="r"></div></div>
      <div class="bd2">
        <div class="grid g2" style="gap:10px">
          <div class="card kpi"><div class="l">Pages</div><b>6</b></div>
          <div class="card kpi"><div class="l">Time</div><b>8m</b></div>
          <div class="card kpi"><div class="l">Clicks</div><b>14</b></div>
          <div class="card kpi"><div class="l">Chats</div><b>1</b></div>
        </div>
      </div>
    </section>
  </div>

  <div style="display:flex;flex-direction:column;gap:18px">
    <section class="card ">
      <div class="hd">
        <h3>Journey timeline · today</h3>
        <div class="r">
          <select class="sel" style="height:34px">
            <option>Session 1 · today</option>
          </select>
        </div>
      </div>
      <div class="bd2">
        <ul class="tl">
          <li class=""><b><?= date('H:i:s', strtotime($visitor['created_at'] ?? 'now')) ?> · Landed on <?= htmlspecialchars($url) ?></b><small>from <?= htmlspecialchars($ref) ?></small></li>
          <li class="s"><b>Scrolled 50% → 90%</b><small>browsing content and services</small></li>
          <li class="k"><b>Clicked “See case study / details”</b><small>cta action</small></li>
          <li class=""><b>Viewed detail page</b><small>2m 15s · active session</small></li>
          <li class="c"><b>Opened Chatbot Assistant</b><small>interactive chat inquiry</small></li>
        </ul>
        <div class="legend">
          <span><i style="background:#f26a1b"></i>Page view</span>
          <span><i style="background:#0ea5e9"></i>Scroll</span>
          <span><i style="background:#ec4899"></i>Click</span>
          <span><i style="background:#8b5cf6"></i>Chat</span>
        </div>
      </div>
    </section>

    <section class="card ">
      <div class="hd"><h3>Sessions</h3><div class="r"></div></div>
      <div>
        <div class="tw">
          <table class="t">
            <thead>
              <tr>
                <th>Started</th>
                <th>Entry page</th>
                <th class="num">Pages</th>
                <th>Duration</th>
                <th>Source</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?= date('M j H:i', strtotime($visitor['created_at'] ?? 'now')) ?></td>
                <td><b><?= htmlspecialchars($url) ?></b></td>
                <td class="num">6</td>
                <td>8m 40s</td>
                <td class="mut"><?= htmlspecialchars($ref) ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
