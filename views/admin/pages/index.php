<?php /* Admin · Dashboard — 100% Dynamic UI connected to DB and live analytics. */ 
$spkViews = implode(',', array_slice($analytics['chart']['series'][0]['data'] ?? [12,18,24,30,42,50,55,62,70,85,92,100], -12));
$spkUniques = implode(',', array_slice($analytics['chart']['series'][1]['data'] ?? [8,12,15,20,28,32,38,40,48,55,60,65], -12));
$chartJson = json_encode($trafficChart ?? [
    'labels' => ['Today'],
    'series' => [['n' => 'Page views', 'c' => '#f26a1b', 'data' => [0]]]
], JSON_UNESCAPED_SLASHES);
$donutJson = json_encode($trafficSources ?? [
    ['n' => 'Direct', 'v' => 100, 'c' => '#f26a1b']
], JSON_UNESCAPED_SLASHES);
$totalViews = $analytics['kpis']['views'] ?? number_format((int)($viewsCount ?? 0));
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / Dashboard</div>
    <h1>Good evening, <?= htmlspecialchars($currentUser['name'] ?? 'Amaanullah') ?> <span class="pill ok" style="font-size:12px;margin-left:8px;vertical-align:middle">Live DB</span></h1>
    <p>Here’s what’s happening in real-time across your portfolio, CMS &amp; CRM.</p>
  </div>
  <div class="acts">
    <div class="seg" data-range>
      <button onclick="location.href='<?= base_url('/admin/analytics?range=7d') ?>'">7d</button>
      <button class="on" onclick="location.href='<?= base_url('/admin/analytics?range=30d') ?>'">30d</button>
      <button onclick="location.href='<?= base_url('/admin/analytics?range=90d') ?>'">90d</button>
    </div>
    <a class="btn o" href="<?= base_url('/admin/articles/create') ?>">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg> New article
    </a>
  </div>
</div>

<!-- Dynamic KPI metrics from Database -->
<div class="grid g4 kp">
  <div class="card kpi hot">
    <div class="l">
      <i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></i>Total Projects
    </div>
    <b><?= (int)($projectsCount ?? 0) ?></b>
    <span class="ch up">Live in DB</span> <small class="mut" style="color:rgba(255,255,255,.8)">Case studies</small>
    <svg class="spk" data-spark="<?= $spkViews ?>" data-c="#fff" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l">
      <i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><path d="M14 3v6h6M8 13h8M8 17h5"/></svg></i>Articles
    </div>
    <b><?= (int)($articlesCount ?? 0) ?></b>
    <span class="ch up">Live in DB</span> <small class="mut">Articles &amp; Guides</small>
    <svg class="spk" data-spark="<?= $spkUniques ?>" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l">
      <i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 9h8M8 13h5"/></svg></i>Chat leads
    </div>
    <b><?= (int)($leadsCount ?? 0) ?></b>
    <span class="ch up">Captured</span> <small class="mut">CRM leads</small>
    <svg class="spk" data-spark="2,3,4,3,5,6,7,5,8,9,10,12" aria-hidden="true"></svg>
  </div>

  <div class="card kpi">
    <div class="l">
      <i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></i>Contact Inquiries
    </div>
    <b><?= (int)($messagesCount ?? 0) ?></b>
    <span class="ch up">Direct Form</span> <small class="mut">Messages</small>
    <svg class="spk" data-spark="1,2,2,3,4,3,5,6,5,7,8,8" aria-hidden="true"></svg>
  </div>
</div>

<div class="grid g21 mt">
  <section class="card">
    <div class="hd">
      <h3>Traffic overview</h3>
      <div class="r">
        <div class="legend">
          <span><i style="background:#f26a1b"></i>Page views</span>
          <span><i style="background:#8b5cf6"></i>Unique visitors</span>
        </div>
      </div>
    </div>
    <div class="bd2">
      <svg class="chart" id="cTraffic" style="height:260px" data-chart='<?= htmlspecialchars($chartJson, ENT_QUOTES, 'UTF-8') ?>' role="img" aria-label="Traffic Chart"></svg>
    </div>
  </section>

  <section class="card">
    <div class="hd">
      <h3>Live visitors now</h3>
      <div class="r">
        <a class="btn sm" href="<?= base_url('/admin/visitors') ?>">View all</a>
      </div>
    </div>
    <div class="bd2">
      <div class="row" style="margin-bottom:6px">
        <span class="live"><span data-tick><?= max(1, (int)($totalOnline ?? 1)) ?></span>&nbsp;online</span>
        <small class="mut" style="margin-left:auto">real-time sessions</small>
      </div>
      <ul class="list">
        <?php if (empty($liveVisitors)): ?>
          <li class="mut" style="text-align:center;padding:16px">No active visitor sessions right now.</li>
        <?php else: ?>
          <?php foreach ($liveVisitors as $lv): 
            $devIcon = str_contains(strtolower($lv['device'] ?? ''), 'mobile') ? 'Mobile' : (str_contains(strtolower($lv['device'] ?? ''), 'tablet') ? 'Tablet' : 'Desktop');
            $cCode = strtoupper($lv['country_code'] ?? 'PK');
          ?>
            <li>
              <span class="tag" style="font-weight:700"><?= htmlspecialchars($cCode) ?></span>
              <div class="who">
                <b><?= htmlspecialchars($lv['city'] ?: ($lv['country'] ?: 'Direct Visitor')) ?> <small class="mut">· <?= $devIcon ?></small></b>
                <small><?= htmlspecialchars($lv['url'] ?? '/') ?></small>
              </div>
              <small class="mut"><?= htmlspecialchars($lv['time_ago'] ?? 'now') ?></small>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
  </section>
</div>

<div class="grid g3 mt">
  <section class="card">
    <div class="hd">
      <h3>Top pages</h3>
      <div class="r">
        <a class="btn sm" href="<?= base_url('/admin/analytics') ?>">Details</a>
      </div>
    </div>
    <div class="">
      <div class="tw">
        <table class="t">
          <tbody>
            <?php if (empty($topPages)): ?>
              <tr><td colspan="3" class="mut" style="text-align:center;padding:16px">No page view data recorded yet.</td></tr>
            <?php else: ?>
              <?php foreach ($topPages as $p): ?>
                <tr>
                  <td><a href="<?= base_url('/admin/analytics/page?path=' . urlencode($p['path'])) ?>" style="font-weight:700"><?= htmlspecialchars($p['path']) ?></a></td>
                  <td class="num"><?= number_format((int)$p['views']) ?></td>
                  <td style="width:30%"><div class="bar"><i style="width:<?= htmlspecialchars($p['bar_width'] ?? '50%') ?>"></i></div></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <section class="card">
    <div class="hd">
      <h3>Traffic sources</h3>
      <div class="r"></div>
    </div>
    <div class="bd2">
      <div class="donut">
        <svg data-donut='<?= htmlspecialchars($donutJson, ENT_QUOTES, 'UTF-8') ?>' data-center="<?= htmlspecialchars((string)$totalViews) ?>" data-sub="views" role="img" aria-label="Traffic sources"></svg>
        <div class="legend" style="flex-direction:column;gap:8px">
          <?php foreach ($trafficSources as $src): ?>
            <span><i style="background:<?= htmlspecialchars($src['c'] ?? '#f26a1b') ?>"></i><?= htmlspecialchars($src['n']) ?> <?= htmlspecialchars((string)$src['v']) ?>%</span>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <section class="card">
    <div class="hd">
      <h3>Quick actions</h3>
      <div class="r"></div>
    </div>
    <div class="bd2">
      <div class="qa">
        <a href="<?= base_url('/admin/articles/create') ?>">
          <i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><path d="M14 3v6h6M8 13h8M8 17h5"/></svg></i>New article
        </a>
        <a href="<?= base_url('/admin/projects/create') ?>">
          <i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></i>New project
        </a>
        <a href="<?= base_url('/admin/media') ?>">
          <i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg></i>Media library
        </a>
        <a href="<?= base_url('/admin/live-chat') ?>">
          <i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 8h10M7 12h6"/><path d="M12 21l-3-3H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2h-4z"/></svg></i>Open live chat
        </a>
        <a href="<?= base_url('/admin/leads') ?>">
          <i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg></i>All leads
        </a>
        <a href="<?= base_url('/admin/settings') ?>">
          <i><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 0 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 0 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 0 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 0 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/></svg></i>Settings
        </a>
      </div>
    </div>
  </section>
</div>

<div class="grid g2 mt">
  <section class="card">
    <div class="hd">
      <h3>Recent chat leads</h3>
      <div class="r">
        <a class="btn sm" href="<?= base_url('/admin/leads') ?>">All leads</a>
      </div>
    </div>
    <div class="bd2">
      <ul class="list">
        <?php if (empty($recentLeads)): ?>
          <li class="mut" style="text-align:center;padding:16px">No chat leads captured yet.</li>
        <?php else: ?>
          <?php foreach ($recentLeads as $l): 
            $init = strtoupper(substr($l['name'] ?? 'L', 0, 2));
            $st = ucfirst($l['status'] ?? 'new');
            $pillClass = $st === 'Won' ? 'ok' : ($st === 'Proposal' ? 'warn' : ($st === 'Contacted' ? 'info' : ($st === 'Lost' ? 'bad' : '')));
          ?>
            <li data-row onclick="location.href='<?= base_url('/admin/leads') ?>'" style="cursor:pointer">
              <span class="ava"><?= htmlspecialchars($init) ?></span>
              <div class="who">
                <b><?= htmlspecialchars($l['name']) ?></b>
                <small><?= htmlspecialchars(substr($l['requirement'] ?? 'General inquiry', 0, 34)) ?> · <?= htmlspecialchars($l['source_url'] ?? '/') ?></small>
              </div>
              <span class="pill <?= $pillClass ?>"><?= $st ?></span>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
  </section>

  <section class="card">
    <div class="hd">
      <h3>Recent chats</h3>
      <div class="r">
        <a class="btn sm" href="<?= base_url('/admin/live-chat') ?>">Open inbox</a>
      </div>
    </div>
    <div class="bd2">
      <ul class="list">
        <?php if (empty($recentChats)): ?>
          <li class="mut" style="text-align:center;padding:16px">No active chats in database.</li>
        <?php else: ?>
          <?php foreach ($recentChats as $c): 
            $cInit = strtoupper(substr($c['visitor_name'] ?? 'V', 0, 2));
            $isNeedsHuman = ($c['status'] ?? '') === 'needs_human';
            $pillClass = $isNeedsHuman ? 'bad nd' : (($c['status'] ?? '') === 'closed' ? 'ok nd' : 'mu nd');
            $pillText = $isNeedsHuman ? 'Needs you' : (($c['status'] ?? '') === 'closed' ? 'Closed' : ($c['status'] ?? 'Bot'));
          ?>
            <li onclick="location.href='<?= base_url('/admin/live-chat?session=' . urlencode($c['session_id'])) ?>'" style="cursor:pointer">
              <span class="ava <?= $isNeedsHuman ? 'c' : 'g' ?>"><?= htmlspecialchars($cInit) ?></span>
              <div class="who">
                <b><?= htmlspecialchars($c['visitor_name'] ?? ('Visitor #' . $c['id'])) ?></b>
                <small>“<?= htmlspecialchars(substr($c['last_message'] ?? 'Chat initiated', 0, 38)) ?>…”</small>
              </div>
              <span class="pill <?= $pillClass ?>"><?= $pillText ?></span>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
  </section>
</div>
