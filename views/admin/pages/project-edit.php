<?php /* Admin · Edit project — dynamic UI. */ 
$p = $project ?? [];
$isEdit = !empty($p['id']);
$categoriesList = $categories ?? [];
$allProjectsList = $allProjects ?? [];
$bannerUrl = !empty($p['banner']) ? asset_url($p['banner']) : asset_url('images/banners/chatrox.svg');
?>
<div class="ph-h"><div><div class="crumbs">Admin / <a href="<?= base_url('/admin/projects') ?>">Projects</a> / <?= $isEdit ? 'Edit' : 'New' ?></div><h1><?= $isEdit ? 'Edit project' : 'New project' ?></h1><p>Sections, blocks and hero mirror the case-study page exactly.</p></div><div class="acts"><a class="btn" href="<?= base_url('/admin/projects') ?>">Cancel</a><button class="btn" data-save="Draft saved" type="button" id="btnDraft">Save draft</button><button class="btn o" data-save="Published" type="button" id="btnPublish"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg> Publish</button></div></div>
<div class="ed-top"><div class="st2"><span><b id="wc">0</b> words</span><span><b id="rt">1 min</b> read</span><span><b id="bc">0</b> blocks</span><span><b id="tc">0</b> TOC items</span><span id="saveSt" class="saved">✓ All changes saved</span></div>
<div class="seg" role="tablist" aria-label="View mode"><button class="on" data-mode="write" type="button"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg> Write</button><button data-mode="split" type="button">Split</button><button data-mode="prev" type="button"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg> Preview</button></div></div>
<div class="bar" style="margin:-4px 0 16px" title="Progress to 2,500-word target"><i id="wcGoal" data-goal="2500" style="width:0"></i></div>
<form id="projectForm" action="" method="post">
<input type="hidden" id="projId" name="id" value="<?= $p['id'] ?? '' ?>">
<input type="hidden" name="body_json" id="bodyJson">
<div class="ed" data-editor="project" data-site-css="<?= asset_url('css/') ?>" data-asset="<?= base_url('/') ?>">
<div class="ed-main"><section class="card meta-card">
<div class="fg2"><div class="fld"><label for="mCat">Badge: category</label><input class="inp" id="mCat" data-m="category" value="<?= htmlspecialchars($p['category_slug'] ?? 'products') ?>"></div><div class="fld"><label for="mDom">Badge: domain</label><input class="inp" id="mDom" data-m="domain" value="<?= htmlspecialchars($p['domain'] ?? '') ?>"></div></div>
<textarea class="ttl-in" data-m="title" rows="2" aria-label="Project title (H1)"><?= htmlspecialchars($p['title'] ?? '') ?></textarea>
<div class="fld"><label for="mEm">Title highlight (orange &lt;em&gt;)</label><input class="inp" id="mEm" data-m="em" value="<?= htmlspecialchars($p['highlight_em'] ?? '') ?>"></div>
<textarea class="sum-in" data-m="summary" rows="2" aria-label="Summary"><?= htmlspecialchars($p['summary'] ?? '') ?></textarea>
<hr class="s"><div class="sec-t">Project facts</div><p class="sec-d">Shown as the facts grid under the banner.</p>
<div class="fg3"><div class="fld"><label for="fclient">Client</label><input class="inp" id="fclient" data-m="client" value="<?= htmlspecialchars($p['client'] ?? '') ?>"></div><div class="fld"><label for="findustry">Industry</label><input class="inp" id="findustry" data-m="industry" value="<?= htmlspecialchars($p['industry'] ?? '') ?>"></div><div class="fld"><label for="frole">Role</label><input class="inp" id="frole" data-m="role" value="<?= htmlspecialchars($p['role'] ?? 'Full-Stack Developer') ?>"></div><div class="fld"><label for="ftimeline">Timeline</label><input class="inp" id="ftimeline" data-m="timeline" value="<?= htmlspecialchars($p['timeline'] ?? '3–4 months') ?>"></div><div class="fld"><label for="fplatform">Platform</label><input class="inp" id="fplatform" data-m="platform" value="<?= htmlspecialchars($p['platform'] ?? 'Web Application') ?>"></div><div class="fld"><label for="fstatus">Status</label><input class="inp" id="fstatus" data-m="status" value="<?= htmlspecialchars($p['project_status'] ?? 'Completed') ?>"></div></div>
<div class="fld"><label for="mChips">Tech chips (comma separated)</label><input class="inp" id="mChips" data-m="chips" value="<?= htmlspecialchars($p['tech_chips'] ?? '') ?>"></div>
<hr class="s"><div class="sec-t">TL;DR &amp; key results</div>
<div class="fld"><label for="mTl">TL;DR</label><textarea class="inp" id="mTl" data-m="tldr" rows="3"><?= htmlspecialchars($p['tldr'] ?? '') ?></textarea></div>
<div class="fld"><label for="mKr">Key results (value | text, one per line)</label><textarea class="inp" id="mKr" data-m="results" rows="3"><?= htmlspecialchars($p['key_results'] ?? '') ?></textarea></div></section>
<div id="blocks" aria-label="Content blocks"></div>
<div class="addbar"><button type="button" id="addBtn"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg> Add block</button><div class="bmenu" id="bmenu"><input class="inp" placeholder="Search block types…" aria-label="Search block types"><div class="bl"></div></div></div></div>
<div class="ed-pv"><div class="pvbar"><i></i><i></i><i></i><span id="pvUrl" data-base="<?= base_url('/projects/') ?>">…</span><div class="seg"><button class="on" data-dev="d" type="button" aria-label="Desktop"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="4" width="20" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg></button><button data-dev="m" type="button" aria-label="Mobile"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><rect x="7" y="2" width="10" height="20" rx="2"/><path d="M11 18h2"/></svg></button></div></div><iframe id="pvFrame" title="Live preview" loading="lazy"></iframe></div>
<aside class="ed-side">
<section class="card"><div class="hd"><h3>Publish</h3></div><div class="bd2">
<div class="fld"><label for="pst">Status</label><select class="sel" id="pst">
<?php $curSt = $p['status'] ?? 'published'; ?>
<option value="draft" <?= $curSt === 'draft' ? 'selected' : '' ?>>Draft</option>
<option value="in_review" <?= $curSt === 'in_review' ? 'selected' : '' ?>>In review</option>
<option value="published" <?= $curSt === 'published' ? 'selected' : '' ?>>Published</option>
<option value="scheduled" <?= $curSt === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
</select></div>
<div class="fld"><label for="pdt">Publish date &amp; time</label><input class="inp" id="pdt" type="datetime-local" value="<?= !empty($p['published_at']) ? date('Y-m-d\TH:i', strtotime($p['published_at'])) : date('Y-m-d\TH:i') ?>"></div>
<div class="fld"><label for="pcat">Category</label><select class="sel" id="pcat">
<?php $curCat = $p['category_slug'] ?? 'web-applications';
foreach ($categoriesList as $cat): ?>
<option value="<?= htmlspecialchars($cat['slug']) ?>" <?= $curCat === $cat['slug'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
<?php endforeach; ?>
</select></div>
<div class="fld"><label for="slugIn">Slug</label><div class="row"><span class="mut sm">/projects/</span><input class="inp" id="slugIn" style="flex:1" value="<?= htmlspecialchars($p['slug'] ?? '') ?>"></div></div>
</div></section>
<section class="card"><div class="hd"><h3>Table of contents</h3><div class="r"><small class="mut">auto from sections</small></div></div><div class="bd2"><ol class="toc-l" id="tocL"></ol></div></section>
<section class="card"><div class="hd"><h3>Banner</h3><div class="r"><small class="mut">1600×1000</small></div></div><div class="bd2">
<div class="cover-up"><img id="coverImg" src="<?= $bannerUrl ?>" alt=""><div class="ov2"><button type="button" class="btn sm" data-pick-cover>Library</button></div></div>
<div class="drop" data-preview="#coverImg" style="padding:12px;margin-top:10px"><input type="file" accept="image/*" hidden><small><b>Upload</b> or drop a new image</small></div>
<input type="hidden" id="coverIn" value="<?= htmlspecialchars($p['banner'] ?? 'images/banners/chatrox.svg') ?>">
<div class="fld" style="margin-top:10px"><label for="calt">Alt text</label><input class="inp" id="calt" data-m="coverAlt" value="<?= htmlspecialchars($p['banner_alt'] ?? '') ?>"></div></div></section>

<section class="card"><div class="hd"><h3>Project extras</h3></div><div class="bd2">
<div class="chk-row">Featured project <label class="sw"><input type="checkbox" id="chkFeatured" <?= !empty($p['is_featured']) ? 'checked' : '' ?>><i></i></label></div>
<div class="chk-row">Show on home page <label class="sw"><input type="checkbox" id="chkHome" <?= !empty($p['show_on_home']) ? 'checked' : '' ?>><i></i></label></div>
<div class="fld"><label for="ctT">CTA title</label><input class="inp" id="ctT" data-m="ctaTitle" value="<?= htmlspecialchars($p['cta_title'] ?? '') ?>"></div><div class="fld"><label for="ctX">CTA text</label><input class="inp" id="ctX" data-m="ctaText" value="<?= htmlspecialchars($p['cta_text'] ?? '') ?>"></div><div class="fld"><label for="ctL">CTA button</label><input class="inp" id="ctL" data-m="ctaLabel" value="<?= htmlspecialchars($p['cta_label'] ?? 'Start a project →') ?>"></div></div></section>
<section class="card"><div class="hd"><h3>SEO</h3><div class="r"><span class="pill ok nd">Good</span></div></div><div class="bd2">
<div class="fld"><label for="focusKw">Focus keyword</label><input class="inp" id="focusKw" value="<?= htmlspecialchars($p['focus_keyword'] ?? '') ?>"></div><ul class="list" id="kwChecks" style="margin:-4px 0 12px"></ul>
<div class="fld"><label for="seoT">Meta title <span class="cnt" id="cT"></span></label><input class="inp" id="seoT" data-count="cT" data-min="30" data-max="60" value="<?= htmlspecialchars($p['seo_title'] ?? '') ?>"></div>
<div class="fld"><label for="seoD">Meta description <span class="cnt" id="cD"></span></label><textarea class="inp" id="seoD" rows="3" data-count="cD" data-min="120" data-max="160"><?= htmlspecialchars($p['meta_description'] ?? '') ?></textarea></div>
<div class="fld"><label>Google preview</label><div class="serp"><div class="u"><i></i><span id="serpU" data-base="<?= base_url() ?> › projects"></span></div><div class="tt" id="serpT"></div><div class="dsc" id="serpD"></div></div></div>
<div class="fld"><label for="canon">Canonical URL</label><input class="inp" id="canon" placeholder="Leave empty to use the page URL" value="<?= htmlspecialchars($p['canonical_url'] ?? '') ?>"></div>
<div class="chk-row">Index in search engines <label class="sw"><input type="checkbox" checked><i></i></label></div>
<div class="chk-row">FAQPage schema <label class="sw"><input type="checkbox" checked><i></i></label></div>
<div class="chk-row">CreativeWork schema <label class="sw"><input type="checkbox" checked><i></i></label></div>
</div></section>
<?php if ($isEdit): ?>
<section class="card"><div class="bd2"><button class="btn d" style="width:100%" type="button" data-confirm="Delete this project permanently?" data-del-project="<?= $p['id'] ?>"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg> Delete project</button></div></section>
<?php endif; ?>
</aside></div></form>
<div class="modal" id="mPick" style="width:min(760px,calc(100vw - 32px))"><div class="mh2"><h3>Choose from media library</h3><button class="ib" data-close aria-label="Close"><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg></button></div><div class="mb"><div class="drop" style="margin-bottom:14px"><input type="file" accept="image/*" hidden><svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg><p><b>Drop an image</b> or click to upload</p><small>SVG, PNG, WebP · max 5 MB</small></div><div class="mgrid"><button type="button" class="mi2" data-img="images/banners/multi-tenant-crm.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/banners/multi-tenant-crm.svg') ?>" alt=""></div><div class="mt2"><b>multi-tenant-crm.svg</b></div></button><button type="button" class="mi2" data-img="images/banners/chatrox.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/banners/chatrox.svg') ?>" alt=""></div><div class="mt2"><b>chatrox.svg</b></div></button><button type="button" class="mi2" data-img="images/banners/hrm-payroll.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/banners/hrm-payroll.svg') ?>" alt=""></div><div class="mt2"><b>hrm-payroll.svg</b></div></button><button type="button" class="mi2" data-img="images/banners/ticketing-crm.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/banners/ticketing-crm.svg') ?>" alt=""></div><div class="mt2"><b>ticketing-crm.svg</b></div></button><button type="button" class="mi2" data-img="images/covers/multi-tenant-laravel.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/covers/multi-tenant-laravel.svg') ?>" alt=""></div><div class="mt2"><b>multi-tenant-laravel.svg</b></div></button><button type="button" class="mi2" data-img="images/covers/laravel-queues-at-scale.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/covers/laravel-queues-at-scale.svg') ?>" alt=""></div><div class="mt2"><b>laravel-queues-at-scale.svg</b></div></button><button type="button" class="mi2" data-img="images/covers/saas-billing-basics.svg" style="text-align:left;padding:0"><div class="th"><img src="<?= asset_url('images/covers/saas-billing-basics.svg') ?>" alt=""></div><div class="mt2"><b>saas-billing-basics.svg</b></div></button></div></div></div>
<?php
$initBlocks = !empty($p['body_json']) ? json_decode($p['body_json'], true) : null;
if (!is_array($initBlocks)) {
    $initBlocks = [
        'blocks' => [
            ['type' => 'sec', 'label' => 'Overview', 't' => $p['title'] ?? 'Project Overview', 'id' => 'overview'],
            ['type' => 'lead', 't' => $p['summary'] ?? 'Summary of the project.'],
            ['type' => 'sec', 'label' => 'The Challenge', 't' => 'Why the Business Needed This Solution', 'id' => 'challenge'],
            ['type' => 'pts', 't' => "Scalability | Built to handle enterprise load.\nSecurity | Private data ownership."],
            ['type' => 'sec', 'label' => 'Solution Architecture', 't' => 'How the System is Built', 'id' => 'architecture'],
            ['type' => 'sec', 'label' => 'Results & Impact', 't' => 'Measurable Business Value', 'id' => 'results'],
            ['type' => 'stats', 't' => "100% | High Availability\n< 1s | Fast Response Time"]
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
