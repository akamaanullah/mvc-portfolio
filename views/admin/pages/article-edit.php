<?php /* Admin · Edit article — dynamic UI. */ 
$a = $article ?? [];
$isEdit = !empty($a['id']);
$categoriesList = $categories ?? [];
$allArticlesList = $allArticles ?? [];
$coverUrl = !empty($a['cover_image']) ? asset_url($a['cover_image']) : asset_url('images/covers/multi-tenant-laravel.svg');
?>
<div class="ph-h"><div><div class="crumbs">Admin / <a href="<?= base_url('/admin/articles') ?>">Articles</a> / <?= $isEdit ? 'Edit' : 'New' ?></div><h1><?= $isEdit ? 'Edit article' : 'New article' ?></h1><p>Every block maps 1:1 to a section style on the live article page.</p></div><div class="acts"><a class="btn" href="<?= base_url('/admin/articles') ?>">Cancel</a><button class="btn" data-save="Draft saved" type="button" id="btnDraft">Save draft</button><button class="btn o" data-save="Published" type="button" id="btnPublish"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg> Publish</button></div></div>
<div class="ed-top"><div class="st2"><span><b id="wc">0</b> words</span><span><b id="rt"><?= htmlspecialchars($a['reading_time'] ?? '1 min') ?></b></span><span><b id="bc">0</b> blocks</span><span><b id="tc">0</b> TOC items</span><span id="saveSt" class="saved">✓ All changes saved</span></div>
<div class="seg" role="tablist" aria-label="View mode"><button class="on" data-mode="write" type="button"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg> Write</button><button data-mode="split" type="button">Split</button><button data-mode="prev" type="button"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg> Preview</button></div></div>
<div class="bar" style="margin:-4px 0 16px" title="Progress to 2,500-word target"><i id="wcGoal" data-goal="2500" style="width:0"></i></div>
<form id="articleForm" action="" method="post">
<input type="hidden" id="projId" name="id" value="<?= $a['id'] ?? '' ?>">
<input type="hidden" name="body_json" id="bodyJson">
<div class="ed" data-editor="article" data-site-css="<?= asset_url('css/') ?>" data-asset="<?= base_url('/') ?>">
<div class="ed-main"><section class="card meta-card">
<div class="fg3"><div class="fld"><label for="mCat">Badge: category</label><input class="inp" id="mCat" data-m="category" value="<?= htmlspecialchars($a['badge_category'] ?? 'Laravel & PHP') ?>"></div><div class="fld"><label for="mType">Badge: type</label><select class="sel" id="mType" data-m="type">
<?php $curType = $a['badge_type'] ?? 'Guide'; ?>
<option <?= $curType === 'Guide' ? 'selected' : '' ?>>Guide</option>
<option <?= $curType === 'Tutorial' ? 'selected' : '' ?>>Tutorial</option>
<option <?= $curType === 'Opinion' ? 'selected' : '' ?>>Opinion</option>
<option <?= $curType === 'Case notes' ? 'selected' : '' ?>>Case notes</option>
<option <?= $curType === 'Deep Dive' ? 'selected' : '' ?>>Deep Dive</option>
</select></div><div class="fld"><label for="mDate">Published date</label><input class="inp" id="mDate" data-m="date" type="date" value="<?= !empty($a['published_at']) ? date('Y-m-d', strtotime($a['published_at'])) : date('Y-m-d') ?>"></div></div>
<textarea class="ttl-in" data-m="title" rows="2" aria-label="Article title (H1)" placeholder="Article title (H1)"><?= htmlspecialchars($a['title'] ?? '') ?></textarea>
<textarea class="sum-in" data-m="summary" rows="2" aria-label="Subtitle / summary" placeholder="Subtitle shown under the title"><?= htmlspecialchars($a['excerpt'] ?? '') ?></textarea></section>
<div id="blocks" aria-label="Content blocks"></div>
<div class="addbar"><button type="button" id="addBtn"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg> Add block</button><div class="bmenu" id="bmenu"><input class="inp" placeholder="Search block types…" aria-label="Search block types"><div class="bl"></div></div></div></div>
<div class="ed-pv"><div class="pvbar"><i></i><i></i><i></i><span id="pvUrl" data-base="<?= base_url('/articles/') ?>">…</span><div class="seg"><button class="on" data-dev="d" type="button" aria-label="Desktop"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="4" width="20" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg></button><button data-dev="m" type="button" aria-label="Mobile"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><rect x="7" y="2" width="10" height="20" rx="2"/><path d="M11 18h2"/></svg></button></div></div><iframe id="pvFrame" title="Live preview" loading="lazy"></iframe></div>
<aside class="ed-side">
<section class="card"><div class="hd"><h3>Publish</h3></div><div class="bd2">
<div class="fld"><label for="pst">Status</label><select class="sel" id="pst">
<?php $curSt = $a['status'] ?? 'published'; ?>
<option value="draft" <?= $curSt === 'draft' ? 'selected' : '' ?>>Draft</option>
<option value="in_review" <?= $curSt === 'in_review' ? 'selected' : '' ?>>In review</option>
<option value="published" <?= $curSt === 'published' ? 'selected' : '' ?>>Published</option>
<option value="scheduled" <?= $curSt === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
</select></div>
<div class="fld"><label for="pdt">Publish date &amp; time</label><input class="inp" id="pdt" type="datetime-local" value="<?= !empty($a['published_at']) ? date('Y-m-d\TH:i', strtotime($a['published_at'])) : date('Y-m-d\TH:i') ?>"></div>
<div class="fld"><label for="pcat">Category</label><select class="sel" id="pcat">
<?php $curCat = $a['category_slug'] ?? 'laravel-php';
foreach ($categoriesList as $cat): ?>
<option value="<?= htmlspecialchars($cat['slug']) ?>" <?= $curCat === $cat['slug'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
<?php endforeach; ?>
</select></div>
<div class="fld"><label for="slugIn">Slug</label><div class="row"><span class="mut sm">/articles/</span><input class="inp" id="slugIn" style="flex:1" value="<?= htmlspecialchars($a['slug'] ?? '') ?>"></div></div>
</div></section>
<section class="card"><div class="hd"><h3>Table of contents</h3><div class="r"><small class="mut">auto from H2/H3</small></div></div><div class="bd2"><ol class="toc-l" id="tocL"></ol></div></section>
<section class="card"><div class="hd"><h3>Cover image</h3><div class="r"><small class="mut">1600×900</small></div></div><div class="bd2">
<div class="cover-up"><img id="coverImg" src="<?= $coverUrl ?>" alt=""><div class="ov2"><button type="button" class="btn sm" data-pick-cover>Library</button></div></div>
<div class="drop" data-preview="#coverImg" style="padding:12px;margin-top:10px"><input type="file" accept="image/*" hidden><small><b>Upload</b> or drop a new image</small></div>
<input type="hidden" id="coverIn" value="<?= htmlspecialchars($a['cover_image'] ?? 'images/covers/multi-tenant-laravel.svg') ?>">
<div class="fld" style="margin-top:10px"><label for="calt">Alt text</label><input class="inp" id="calt" data-m="coverAlt" value="<?= htmlspecialchars($a['cover_alt'] ?? '') ?>"></div></div></section>
<section class="card"><div class="hd"><h3>Excerpt</h3></div><div class="bd2"><div class="fld"><label for="exc">Card excerpt <span class="cnt" id="cE"></span></label><textarea class="inp" id="exc" rows="3" data-count="cE" data-max="180"><?= htmlspecialchars($a['excerpt'] ?? '') ?></textarea></div></div></section>
<section class="card"><div class="hd"><h3>Article extras</h3></div><div class="bd2">
<div class="fld"><label>Tags <span class="cnt">Enter to add</span></label><div class="chips-in" id="tagsIn">
<?php 
$tags = array_filter(array_map('trim', explode(',', $a['tags'] ?? 'Laravel, PHP, SaaS')));
foreach ($tags as $t): ?>
<span><?= htmlspecialchars($t) ?><button type=button aria-label=Remove>×</button></span>
<?php endforeach; ?>
<input placeholder="Add tag…" aria-label="Add tag"></div></div>
<div class="chk-row">Author bio box <label class="sw"><input type="checkbox" data-m="bio" checked><i></i></label></div>
<div class="chk-row">Newsletter box <label class="sw"><input type="checkbox" data-m="news" checked><i></i></label></div>
<div class="chk-row">Prev / next links <label class="sw"><input type="checkbox" checked><i></i></label></div>
<div class="chk-row">Bottom CTA <label class="sw"><input type="checkbox" data-m="cta" checked><i></i></label></div>
<div class="fld"><input class="inp" data-m="ctaTitle" value="<?= htmlspecialchars($a['cta_title'] ?? 'Building a software product?') ?>" aria-label="CTA title"></div><div class="fld"><input class="inp" data-m="ctaText" value="<?= htmlspecialchars($a['cta_text'] ?? 'I help teams design and ship scalable web and mobile applications.') ?>" aria-label="CTA text"></div></div></section>
<section class="card"><div class="hd"><h3>SEO</h3><div class="r"><span class="pill ok nd">Good</span></div></div><div class="bd2">
<div class="fld"><label for="focusKw">Focus keyword</label><input class="inp" id="focusKw" value="<?= htmlspecialchars($a['focus_keyword'] ?? '') ?>"></div><ul class="list" id="kwChecks" style="margin:-4px 0 12px"></ul>
<div class="fld"><label for="seoT">Meta title <span class="cnt" id="cT"></span></label><input class="inp" id="seoT" data-count="cT" data-min="30" data-max="60" value="<?= htmlspecialchars($a['seo_title'] ?? '') ?>"></div>
<div class="fld"><label for="seoD">Meta description <span class="cnt" id="cD"></span></label><textarea class="inp" id="seoD" rows="3" data-count="cD" data-min="120" data-max="160"><?= htmlspecialchars($a['meta_description'] ?? '') ?></textarea></div>
<div class="fld"><label>Google preview</label><div class="serp"><div class="u"><i></i><span id="serpU" data-base="<?= base_url() ?> › articles"></span></div><div class="tt" id="serpT"></div><div class="dsc" id="serpD"></div></div></div>
<div class="fld"><label for="canon">Canonical URL</label><input class="inp" id="canon" placeholder="Leave empty to use the page URL" value="<?= htmlspecialchars($a['canonical_url'] ?? '') ?>"></div>
<div class="chk-row">Index in search engines <label class="sw"><input type="checkbox" checked><i></i></label></div>
<div class="chk-row">FAQPage schema <label class="sw"><input type="checkbox" checked><i></i></label></div>
<div class="chk-row">BlogPosting schema <label class="sw"><input type="checkbox" checked><i></i></label></div>
</div></section>
<?php if ($isEdit): ?>
<section class="card"><div class="bd2"><button class="btn d" style="width:100%" type="button" data-confirm="Delete this article permanently?" data-del-article="<?= $a['id'] ?>"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg> Delete article</button></div></section>
<?php endif; ?>
</aside></div></form>
<div class="modal" id="mPick" style="width:min(760px,calc(100vw - 32px))"><div class="mh2"><h3>Choose from media library</h3><button class="ib" data-close aria-label="Close"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg></button></div><div class="mb"><div class="drop" style="margin-bottom:14px"><input type="file" accept="image/*" hidden><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg><p><b>Drop an image</b> or click to upload</p><small>SVG, PNG, WebP · max 5 MB</small></div><div class="mgrid"><button type="button" class="mi2" data-img="images/banners/multi-tenant-crm.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/banners/multi-tenant-crm.svg') ?>" alt=""></div><div class="mt2"><b>multi-tenant-crm.svg</b></div></button><button type="button" class="mi2" data-img="images/banners/chatrox.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/banners/chatrox.svg') ?>" alt=""></div><div class="mt2"><b>chatrox.svg</b></div></button><button type="button" class="mi2" data-img="images/covers/multi-tenant-laravel.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/covers/multi-tenant-laravel.svg') ?>" alt=""></div><div class="mt2"><b>multi-tenant-laravel.svg</b></div></button><button type="button" class="mi2" data-img="images/covers/laravel-queues-at-scale.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/covers/laravel-queues-at-scale.svg') ?>" alt=""></div><div class="mt2"><b>laravel-queues-at-scale.svg</b></div></button><button type="button" class="mi2" data-img="images/covers/saas-billing-basics.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/covers/saas-billing-basics.svg') ?>" alt=""></div><div class="mt2"><b>saas-billing-basics.svg</b></div></button></div></div></div>
<?php
$initBlocks = !empty($a['body_json']) ? json_decode($a['body_json'], true) : null;
if (!is_array($initBlocks)) {
    $initBlocks = [
        'blocks' => [
            ['type' => 'lead', 't' => $a['excerpt'] ?? 'Introduction to the article topic.'],
            ['type' => 'h2', 't' => 'Core Architecture', 'id' => 'core-architecture'],
            ['type' => 'p', 't' => 'Detailed explanation of patterns and implementation techniques.'],
            ['type' => 'callout', 'k' => 'note', 'title' => 'Best Practice', 't' => 'Always separate concern layers to keep your code clean and maintainable.'],
            ['type' => 'h2', 't' => 'Summary & Takeaways', 'id' => 'summary'],
            ['type' => 'take', 'title' => 'Key takeaway', 't' => 'Design around clean domain models before optimizing performance.']
        ]
    ];
}
?>
<script type="application/json" id="edInitData"><?= json_encode($initBlocks, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?></script>
<script>
try {
    window.ED_INIT = JSON.parse(document.getElementById('edInitData').textContent || '{}');
} catch (e) {
    window.ED_INIT = { blocks: [] };
}
</script>
