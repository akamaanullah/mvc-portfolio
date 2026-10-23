<?php /* Admin · Categories & tags — dynamic UI. */ 
$categoriesList = $categories ?? [];
$artCats = array_filter($categoriesList, fn($c) => ($c['type'] ?? '') === 'article');
$projCats = array_filter($categoriesList, fn($c) => ($c['type'] ?? '') === 'project');
?>
<div class="ph-h"><div><div class="crumbs">Admin / Content</div><h1>Categories &amp; tags </h1><p>Each category is its own SEO page (title, intro, canonical).</p></div><div class="acts"><button class="btn o" data-open="mCat"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg> New category</button></div></div>
<div class="grid g2">
<section class="card "><div class="hd"><h3>Article categories (<?= count($artCats) ?>)</h3><div class="r"></div></div><div class=""><div class="tw"><table class="t"><thead><tr><th>Name</th><th>Slug</th><th></th></tr></thead><tbody>
<?php foreach ($artCats as $c): ?>
<tr data-row data-id="<?= $c['id'] ?>">
  <td><b><?= htmlspecialchars($c['name']) ?></b></td>
  <td class="mut"><?= htmlspecialchars($c['slug']) ?></td>
  <td>
    <button class="btn sm g d" data-confirm="Delete category “<?= htmlspecialchars($c['name']) ?>”?" data-del-category="<?= $c['id'] ?>" aria-label="Delete"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg></button>
  </td>
</tr>
<?php endforeach; ?>
</tbody></table></div></div></section>

<section class="card "><div class="hd"><h3>Project categories (<?= count($projCats) ?>)</h3><div class="r"></div></div><div class=""><div class="tw"><table class="t"><thead><tr><th>Name</th><th>Slug</th><th></th></tr></thead><tbody>
<?php foreach ($projCats as $c): ?>
<tr data-row data-id="<?= $c['id'] ?>">
  <td><b><?= htmlspecialchars($c['name']) ?></b></td>
  <td class="mut"><?= htmlspecialchars($c['slug']) ?></td>
  <td>
    <button class="btn sm g d" data-confirm="Delete category “<?= htmlspecialchars($c['name']) ?>”?" data-del-category="<?= $c['id'] ?>" aria-label="Delete"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg></button>
  </td>
</tr>
<?php endforeach; ?>
</tbody></table></div></div></section>
</div>

<div class="modal" id="mCat"><div class="mh2"><h3>Category</h3><button class="ib" data-close aria-label="Close"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg></button></div><form id="catForm" onsubmit="event.preventDefault(); saveCatAjax();"><div class="mb"><div class="fld"><label for="cn">Name</label><input class="inp" id="cn" required minlength="2"><span class="err">Name is required.</span></div><div class="fld"><label for="cs">Slug</label><input class="inp" id="cs" placeholder="auto"></div><div class="fld"><label for="ct">Type</label><select class="sel" id="ct"><option value="article">Article category</option><option value="project">Project category</option></select></div><div class="fld"><label for="cd">SEO intro (shown on category page)</label><textarea class="inp" id="cd" rows="3"></textarea></div></div><div class="mf"><button class="btn" type="button" data-close>Cancel</button><button class="btn o" type="submit">Save</button></div></form></div>

<script>
function saveCatAjax() {
  var csrf = (document.querySelector('meta[name="csrf-token"]')||{}).content||'';
  var baseUrl = (document.querySelector('meta[name="base-url"]')||{}).content||'';
  var name = document.getElementById('cn').value.trim();
  var slug = document.getElementById('cs').value.trim();
  var type = document.getElementById('ct').value;
  var intro = document.getElementById('cd').value.trim();

  if (!name) return;

  fetch(baseUrl + '/admin/categories/save', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': csrf
    },
    body: JSON.stringify({
      _token: csrf,
      name: name,
      slug: slug,
      type: type,
      seo_intro: intro
    })
  })
  .then(function(res){ return res.json(); })
  .then(function(d){
    if (d.success) {
      toast(d.message || 'Category saved', 'ok');
      setTimeout(function(){ window.location.reload(); }, 600);
    } else {
      toast(d.error || 'Failed to save', 'bad');
    }
  })
  .catch(function(){
    toast('Error saving category', 'bad');
  });
}
</script>
