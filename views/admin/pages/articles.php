<?php /* Admin · Articles — dynamic UI. */ 
$articlesList = $articles ?? [];
$categoriesList = $categories ?? [];
$cntAll = count($articlesList);
$cntPub = count(array_filter($articlesList, fn($a) => ($a['status'] ?? '') === 'published'));
$cntSch = count(array_filter($articlesList, fn($a) => ($a['status'] ?? '') === 'scheduled'));
$cntDrf = count(array_filter($articlesList, fn($a) => ($a['status'] ?? '') === 'draft'));
$cntRev = count(array_filter($articlesList, fn($a) => ($a['status'] ?? '') === 'in_review'));
$cntTrs = count(array_filter($articlesList, fn($a) => ($a['status'] ?? '') === 'trash'));
?>
<div class="ph-h"><div><div class="crumbs">Admin / Content</div><h1>Articles <span class="pill ok" style="font-size:12px;margin-left:8px;vertical-align:middle"><?= $cntAll ?> Total</span></h1><p>Write and manage blog posts. The editor mirrors the article page section by section.</p></div><div class="acts"><a class="btn o" href="<?= base_url('/admin/articles/create') ?>"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg> New article</a></div></div>
<section class="card loading" data-autoload>
<div class="tabs" style="padding:0 12px"><button class="on">All <span class="mut"><?= $cntAll ?></span></button><button class="">Published <span class="mut"><?= $cntPub ?></span></button><button class="">Scheduled <span class="mut"><?= $cntSch ?></span></button><button class="">Drafts <span class="mut"><?= $cntDrf ?></span></button><button class="">In review <span class="mut"><?= $cntRev ?></span></button><button class="">Trash <span class="mut"><?= $cntTrs ?></span></button></div>
<div class="toolbar"><label class="isrch"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-5-5"/></svg><input placeholder="Search title or slug…" data-filter="#tArt" aria-label="Search articles"></label>
<select class="sel" data-chipfilter="#tArt" aria-label="Category"><option value="">All categories</option><?php foreach ($categoriesList as $cat): ?><option value="<?= htmlspecialchars($cat['name']) ?>"><?= htmlspecialchars($cat['name']) ?></option><?php endforeach; ?></select>
<select class="sel" data-chipfilter="#tArt" aria-label="Status"><option value="">Any status</option><option value="Published">Published</option><option value="Scheduled">Scheduled</option><option value="Draft">Draft</option><option value="Review">Review</option></select>
<select class="sel hide-sm" aria-label="Sort"><option>Newest first</option><option>Most viewed</option><option>Title A–Z</option></select></div>
<div class="bulk"><span class="bc">0 selected</span><button class="btn sm" data-toast="Published">Publish</button><button class="btn sm" data-toast="Moved to drafts">Unpublish</button><button class="btn sm d" data-confirm="Delete selected articles?">Delete</button></div>
<div class="skel" style="padding:16px 18px"><div class="row" style="margin-bottom:14px"><div class="sk" style="width:64px;height:40px"></div><div style="flex:1"><div class="sk" style="height:12px;width:80%;margin-bottom:8px"></div><div class="sk" style="height:10px;width:30%"></div></div></div><div class="row" style="margin-bottom:14px"><div class="sk" style="width:64px;height:40px"></div><div style="flex:1"><div class="sk" style="height:12px;width:75%;margin-bottom:8px"></div><div class="sk" style="height:10px;width:30%"></div></div></div><div class="row" style="margin-bottom:14px"><div class="sk" style="width:64px;height:40px"></div><div style="flex:1"><div class="sk" style="height:12px;width:54%;margin-bottom:8px"></div><div class="sk" style="height:10px;width:30%"></div></div></div></div>
<div class="real"><div class="tw"><table class="t" id="tArt"><thead><tr><th><input type="checkbox" class="chk" aria-label="Select all"></th><th>Title</th><th>Category</th><th>Status</th><th class="num">Views</th><th>Date</th><th></th></tr></thead><tbody>
<?php foreach ($articlesList as $a): 
    $catName = 'Laravel & PHP';
    foreach ($categoriesList as $c) {
        if ($c['slug'] === ($a['category_slug'] ?? '')) {
            $catName = $c['name'];
            break;
        }
    }
    $status = $a['status'] ?? 'draft';
    $statusClass = $status === 'published' ? 'ok' : ($status === 'in_review' ? 'warn' : ($status === 'scheduled' ? 'info' : 'mu'));
    $statusLabel = ucfirst(str_replace('_', ' ', $status));
    $coverUrl = !empty($a['cover_image']) ? asset_url($a['cover_image']) : asset_url('images/covers/multi-tenant-laravel.svg');
    $dateLabel = !empty($a['published_at']) ? date('M d', strtotime($a['published_at'])) : '—';
?>
<tr data-row data-k="<?= htmlspecialchars($catName) ?> <?= htmlspecialchars($statusLabel) ?>" data-id="<?= $a['id'] ?>">
  <td><input type="checkbox" class="chk" value="<?= $a['id'] ?>" aria-label="Select"></td>
  <td>
    <div class="ttl">
      <img src="<?= $coverUrl ?>" alt="" loading="lazy">
      <div><b><?= htmlspecialchars($a['title']) ?></b><small>/articles/<?= htmlspecialchars($a['slug']) ?></small></div>
    </div>
  </td>
  <td><span class="tag"><?= htmlspecialchars($catName) ?></span></td>
  <td><span class="pill <?= $statusClass ?>"><?= $statusLabel ?></span></td>
  <td class="num"><?= number_format((int)($a['views_count'] ?? 0)) ?></td>
  <td class="mut"><?= $dateLabel ?></td>
  <td>
    <div class="row" style="gap:4px">
      <a class="btn sm g" href="<?= base_url('/admin/articles/edit?id=' . $a['id']) ?>" aria-label="Edit"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg></a>
      <a class="btn sm g" href="<?= base_url('/articles/' . $a['slug']) ?>" target="_blank" aria-label="View"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg></a>
      <button class="btn sm g d" data-confirm="Delete “<?= htmlspecialchars($a['title']) ?>”?" data-del-article="<?= $a['id'] ?>" aria-label="Delete"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg></button>
    </div>
  </td>
</tr>
<?php endforeach; ?>
</tbody></table></div>
<div class="pg"><span class="info">Showing 1–<?= min(12, $cntAll) ?> of <?= $cntAll ?></span><button aria-label="Previous">‹</button><button class="on" data-p>1</button><button aria-label="Next">›</button></div></div></section>
