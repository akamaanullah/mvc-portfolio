<?php /* Admin · Projects — dynamic UI. */ 
$projectsList = $projects ?? [];
$categoriesList = $categories ?? [];
?>
<div class="ph-h"><div><div class="crumbs">Admin / Content</div><h1>Projects <span class="pill ok" style="font-size:12px;margin-left:8px;vertical-align:middle"><?= count($projectsList) ?> Active</span></h1><p>Case studies by category. Each category page has its own featured projects.</p></div><div class="acts"><div class="seg"><button class="on" data-view="grid" aria-label="Grid view"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg></button><button data-view="table" aria-label="Table view"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg></button></div><a class="btn o" href="<?= base_url('/admin/projects/create') ?>"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg> New project</a></div></div>
<section class="card" style="margin-bottom:18px"><div class="toolbar" style="border:0"><label class="isrch"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg><input placeholder="Search projects…" data-filter="#pWrap" aria-label="Search projects"></label><select class="sel" data-chipfilter="#pWrap" aria-label="Category"><option value="">All categories (<?= count($projectsList) ?>)</option><?php foreach ($categoriesList as $cat): ?><option value="<?= htmlspecialchars($cat['name']) ?>"><?= htmlspecialchars($cat['name']) ?></option><?php endforeach; ?></select><span class="mut sm" style="margin-left:auto">Drag to reorder within a category (sort order)</span></div></section>
<div id="pWrap">
<div class="pgrid" data-viewpane="grid">
<?php foreach ($projectsList as $p): 
    $catName = 'Web Applications';
    foreach ($categoriesList as $c) {
        if ($c['slug'] === ($p['category_slug'] ?? '')) {
            $catName = $c['name'];
            break;
        }
    }
    $status = $p['status'] ?? 'draft';
    $statusClass = $status === 'published' ? 'ok' : ($status === 'in_review' ? 'warn' : ($status === 'scheduled' ? 'info' : 'mu'));
    $statusLabel = ucfirst(str_replace('_', ' ', $status));
    $bannerUrl = !empty($p['banner']) ? asset_url($p['banner']) : asset_url('images/banners/chatrox.svg');
?>
<article class="card pcard" data-row data-k="<?= htmlspecialchars($catName) ?> <?= htmlspecialchars($statusLabel) ?>" data-id="<?= $p['id'] ?>">
  <div class="th">
    <img src="<?= $bannerUrl ?>" alt="" loading="lazy">
    <span class="pill <?= $statusClass ?>"><?= $statusLabel ?></span>
    <?php if (!empty($p['is_featured'])): ?><span class="star">★ Featured</span><?php endif; ?>
  </div>
  <div class="pb">
    <h4><?= htmlspecialchars($p['title']) ?></h4>
    <small class="mut"><?= htmlspecialchars($catName) ?> · /projects/<?= htmlspecialchars($p['slug']) ?></small>
  </div>
  <div class="pf">
    <a class="btn sm" href="<?= base_url('/admin/projects/edit?id=' . $p['id']) ?>"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg> Edit</a>
    <a class="btn sm g" href="<?= base_url('/projects/' . $p['slug']) ?>" target="_blank" aria-label="View"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg></a>
    <span style="flex:1"></span>
    <button class="btn sm g d" data-confirm="Delete project “<?= htmlspecialchars($p['title']) ?>”?" data-del-project="<?= $p['id'] ?>" aria-label="Delete"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg></button>
  </div>
</article>
<?php endforeach; ?>
</div>

<section class="card" data-viewpane="table" hidden>
<div class="bulk"><span class="bc">0 selected</span><button class="btn sm" data-toast="Featured updated">Mark featured</button><button class="btn sm d" data-confirm="Delete selected projects?">Delete</button></div>
<div class="tw"><table class="t"><thead><tr><th><input type="checkbox" class="chk" aria-label="Select all"></th><th>Project</th><th>Category</th><th>Featured</th><th>Status</th><th class="num">Views</th><th></th></tr></thead><tbody>
<?php foreach ($projectsList as $p): 
    $catName = 'Web Applications';
    foreach ($categoriesList as $c) {
        if ($c['slug'] === ($p['category_slug'] ?? '')) {
            $catName = $c['name'];
            break;
        }
    }
    $status = $p['status'] ?? 'draft';
    $statusClass = $status === 'published' ? 'ok' : ($status === 'in_review' ? 'warn' : ($status === 'scheduled' ? 'info' : 'mu'));
    $statusLabel = ucfirst(str_replace('_', ' ', $status));
    $bannerUrl = !empty($p['banner']) ? asset_url($p['banner']) : asset_url('images/banners/chatrox.svg');
?>
<tr data-row data-k="<?= htmlspecialchars($catName) ?> <?= htmlspecialchars($statusLabel) ?>" data-id="<?= $p['id'] ?>">
  <td><input type="checkbox" class="chk" value="<?= $p['id'] ?>" aria-label="Select"></td>
  <td>
    <div class="ttl">
      <img src="<?= $bannerUrl ?>" alt="">
      <div><b><?= htmlspecialchars($p['title']) ?></b><small>/projects/<?= htmlspecialchars($p['slug']) ?></small></div>
    </div>
  </td>
  <td><span class="tag"><?= htmlspecialchars($catName) ?></span></td>
  <td>
    <label class="sw">
      <input type="checkbox" <?= !empty($p['is_featured']) ? 'checked' : '' ?> data-toggle-featured="<?= $p['id'] ?>"><i></i>
    </label>
  </td>
  <td><span class="pill <?= $statusClass ?>"><?= $statusLabel ?></span></td>
  <td class="num"><?= number_format((int)($p['views_count'] ?? 0)) ?></td>
  <td>
    <a class="btn sm g" href="<?= base_url('/admin/projects/edit?id=' . $p['id']) ?>" aria-label="Edit"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg></a>
    <button class="btn sm g d" data-confirm="Delete project “<?= htmlspecialchars($p['title']) ?>”?" data-del-project="<?= $p['id'] ?>" aria-label="Delete"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg></button>
  </td>
</tr>
<?php endforeach; ?>
</tbody></table></div></section>
</div>
