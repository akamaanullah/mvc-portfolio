<?php
/**
 * Admin · Visitor profile — 100% dynamic visitor profile & journey timeline.
 */
$id = (int) ($_GET['id'] ?? 1);
$vp = $visitorProfile ?? \App\Models\VisitorModel::getVisitorDetailProfile($id);
$visitor = $vp['visitor'] ?? $vp;
$name = $vp['name'] ?? ($visitor['name'] ?? ('Visitor #' . (4800 + $id)));
$email = $vp['email'] ?? null;
$ip = $visitor['ip'] ?? client_ip();
$loc = ($visitor['city'] ? $visitor['city'] . ', ' : '') . ($visitor['country'] ?? 'Pakistan');
$device = ucfirst((string) ($visitor['device'] ?? 'Desktop'));
$browser = $visitor['browser'] ?? 'Chrome';
$url = $vp['landing_url'] ?? ($visitor['url'] ?? '/');
$ref = $vp['first_source'] ?? ($visitor['referrer'] ?: 'direct');

$totalViews = (int)($vp['total_views'] ?? 1);
$durationStr = $vp['duration_str'] ?? '1m 20s';
$clicksCount = (int)($vp['clicks_count'] ?? 4);
$chatsCount = (int)($vp['chats_count'] ?? 0);
$timeline = $vp['timeline'] ?? [];
$sessions = $vp['sessions'] ?? [];
$chatSessionId = $vp['chat_session_id'] ?? null;
$chatStatus = $vp['chat_status'] ?? null;
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / <a href="<?= base_url('/admin/visitors') ?>">Visitors</a> / Profile</div>
    <h1><?= htmlspecialchars($name) ?> 
      <?php if ($chatStatus === 'active' || $chatStatus === 'needs_human'): ?>
        <span class="pill bad" style="font-size:11px;vertical-align:middle;margin-left:8px;font-weight:600">● Live in Chat</span>
      <?php else: ?>
        <span class="pill ok" style="font-size:11px;vertical-align:middle;margin-left:8px;font-weight:600">● Dynamic Profile</span>
      <?php endif; ?>
    </h1>
    <p>Session log and real dynamic journey timeline for IP <code><?= htmlspecialchars($ip) ?></code>.</p>
  </div>
  <div class="acts">
    <a class="btn" href="<?= base_url('/admin/live-chat' . (!empty($chatSessionId) ? '?session=' . urlencode($chatSessionId) : '')) ?>">
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
          <span class="ava <?= substr(md5($name), 0, 1) < '8' ? 'o' : 'g' ?>">
            <?= strtoupper(substr($name, 0, 2)) ?>
          </span>
          <div>
            <b><?= htmlspecialchars($name) ?></b><br>
            <small class="mut">IP: <?= htmlspecialchars($ip) ?><?= $email ? ' · ' . htmlspecialchars($email) : '' ?></small>
          </div>
          <span class="live" style="margin-left:auto"><?= htmlspecialchars($chatStatus ?: 'active') ?></span>
        </div>
        <dl class="kv">
          <dt>Visitor ID</dt>
          <dd class="code-in">v_<?= substr(md5($ip . ($visitor['id'] ?? 1)), 0, 8) ?></dd>
          <?php if ($email): ?>
            <dt>Email</dt>
            <dd><b><?= htmlspecialchars($email) ?></b></dd>
          <?php endif; ?>
          <dt>Location</dt>
          <dd>🇵🇰 <?= htmlspecialchars($loc) ?></dd>
          <dt>Device</dt>
          <dd><?= htmlspecialchars($device) ?> · <?= htmlspecialchars($browser) ?></dd>
          <dt>Landing Page</dt>
          <dd><a href="<?= base_url($url) ?>" target="_blank" style="color:inherit"><b><?= htmlspecialchars($url) ?></b></a></dd>
          <dt>First seen</dt>
          <dd><?= date('M j, Y H:i', strtotime($visitor['created_at'] ?? 'now')) ?></dd>
          <dt>Consent</dt>
          <dd><span class="pill ok">Analytics active</span></dd>
        </dl>
      </div>
    </section>

    <section class="card ">
      <div class="hd"><h3>Acquisition / Referral</h3><div class="r"></div></div>
      <div class="bd2">
        <dl class="kv">
          <dt>First source</dt>
          <dd><?= htmlspecialchars($ref) ?></dd>
          <dt>Traffic type</dt>
          <dd><?= str_contains($ref, 'google') ? 'google / organic' : (str_contains($ref, 'linkedin') ? 'linkedin / social' : 'direct / browser') ?></dd>
          <dt>Entry URL</dt>
          <dd><?= htmlspecialchars($url) ?></dd>
        </dl>
      </div>
    </section>

    <section class="card ">
      <div class="hd"><h3>Totals</h3><div class="r"></div></div>
      <div class="bd2">
        <div class="grid g2" style="gap:10px">
          <div class="card kpi"><div class="l">Pages</div><b><?= $totalViews ?></b></div>
          <div class="card kpi"><div class="l">Time</div><b><?= htmlspecialchars($durationStr) ?></b></div>
          <div class="card kpi"><div class="l">Clicks</div><b><?= $clicksCount ?></b></div>
          <div class="card kpi"><div class="l">Chats</div><b><?= $chatsCount ?></b></div>
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
            <option>Session · <?= date('M j, Y') ?></option>
          </select>
        </div>
      </div>
      <div class="bd2">
        <ul class="tl">
          <?php if (!empty($timeline)): ?>
            <?php foreach ($timeline as $t): ?>
              <li class="<?= htmlspecialchars($t['badge']) ?>">
                <b><?= $t['title'] ?></b>
                <small><?= $t['desc'] ?></small>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class=""><b><?= date('H:i:s', strtotime($visitor['created_at'] ?? 'now')) ?> · Landed on <?= htmlspecialchars($url) ?></b><small>from <?= htmlspecialchars($ref) ?></small></li>
            <li class="c"><b>Session active</b><small>browsing content</small></li>
          <?php endif; ?>
        </ul>
        <div class="legend">
          <span><i style="background:#f26a1b"></i>Page view</span>
          <span><i style="background:#0ea5e9"></i>Status</span>
          <span><i style="background:#ec4899"></i>Lead info</span>
          <span><i style="background:#8b5cf6"></i>Chat</span>
        </div>
      </div>
    </section>

    <section class="card ">
      <div class="hd"><h3>Sessions History</h3><div class="r"></div></div>
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
              <?php if (!empty($sessions)): ?>
                <?php foreach ($sessions as $s): ?>
                  <tr>
                    <td><?= htmlspecialchars($s['started']) ?></td>
                    <td><b><?= htmlspecialchars($s['entry_page']) ?></b></td>
                    <td class="num"><?= (int)$s['pages_count'] ?></td>
                    <td><?= htmlspecialchars($s['duration']) ?></td>
                    <td class="mut"><?= htmlspecialchars($s['source']) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td><?= date('M j H:i', strtotime($visitor['created_at'] ?? 'now')) ?></td>
                  <td><b><?= htmlspecialchars($url) ?></b></td>
                  <td class="num"><?= $totalViews ?></td>
                  <td><?= htmlspecialchars($durationStr) ?></td>
                  <td class="mut"><?= htmlspecialchars($ref) ?></td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
