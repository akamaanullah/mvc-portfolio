<?php /* Admin · Edit landing page — dynamic view. */ 
$lp = $landing ?? [];
$isEdit = !empty($lp['id']);
$slug = $lp['slug'] ?? '';
$liveUrl = !empty($slug) ? base_url('/' . $slug) : base_url('/');
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / <a href="<?= base_url('/admin/landing-pages') ?>">Landing pages</a> / <?= $isEdit ? 'Edit' : 'New' ?></div>
    <h1><?= $isEdit ? ('Edit landing page · ' . htmlspecialchars($lp['title'] ?? '')) : 'New landing page' ?></h1>
    <p>Manage localized SEO landing pages targeting specific regions, roles, and tech stacks.</p>
  </div>
  <div class="acts">
    <a class="btn" href="<?= base_url('/admin/landing-pages') ?>">Back to landing pages</a>
    <?php if ($isEdit && !empty($slug)): ?>
      <a class="btn" href="<?= $liveUrl ?>" target="_blank">
        <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg> View live
      </a>
    <?php endif; ?>
    <button class="btn o" type="button" id="btnSaveLanding">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg> Save landing page
    </button>
  </div>
</div>

<form id="landingForm" action="javascript:void(0)" method="post">
  <input type="hidden" id="lpId" name="id" value="<?= htmlspecialchars((string)($lp['id'] ?? '')) ?>">
  
  <div class="grid g21">
    <div style="display:flex;flex-direction:column;gap:16px">
      <!-- General Info -->
      <section class="card">
        <div class="hd">
          <h3>General information</h3>
        </div>
        <div class="bd2">
          <div class="fld">
            <label for="lpTitle">Page Title (H1) *</label>
            <input class="inp" id="lpTitle" name="title" required value="<?= htmlspecialchars($lp['title'] ?? '') ?>" placeholder="e.g. Laravel Developer in Karachi">
          </div>

          <div class="fld">
            <label for="lpCity">Target City / Region</label>
            <input class="inp" id="lpCity" name="city" value="<?= htmlspecialchars($lp['city'] ?? 'Karachi') ?>" placeholder="e.g. Karachi, Pakistan">
          </div>
        </div>
      </section>

      <!-- Full Body HTML Card -->
      <section class="card">
        <div class="hd">
          <h3>Landing Page HTML Content</h3>
          <div class="r">
            <small class="mut">Rendered inside &lt;main&gt; wrapper</small>
          </div>
        </div>
        <div class="bd2">
          <p class="mut" style="font-size:13px;margin:0 0 10px">
            Contains all sections for this landing page (Hero, Why, Services, Takeover/Audit, Process, Projects, FAQ, CTA).
          </p>
          <div class="fld">
            <textarea class="inp code-in" id="lpContentHtml" name="content_html" rows="22" style="font-family:'JetBrains Mono',monospace;font-size:13px;line-height:1.5" spellcheck="false"><?= htmlspecialchars($lp['content_html'] ?? '') ?></textarea>
          </div>
        </div>
      </section>
    </div>

    <!-- Sidebar Settings -->
    <aside style="display:flex;flex-direction:column;gap:16px">
      <!-- Page Settings -->
      <section class="card">
        <div class="hd"><h3>Settings</h3></div>
        <div class="bd2">
          <div class="chk-row">
            Active / Published
            <label class="sw">
              <input type="checkbox" id="lpActive" name="is_active" <?= (!isset($lp['is_active']) || !empty($lp['is_active'])) ? 'checked' : '' ?>>
              <i></i>
            </label>
          </div>

          <div class="fld">
            <label for="lpSlug">URL Slug *</label>
            <div class="row">
              <span class="mut sm" style="white-space:nowrap">/</span>
              <input class="inp" id="lpSlug" name="slug" style="flex:1" value="<?= htmlspecialchars($lp['slug'] ?? '') ?>" placeholder="laravel-developer-karachi">
            </div>
          </div>
        </div>
      </section>

      <!-- SEO Settings -->
      <section class="card">
        <div class="hd"><h3>SEO &amp; Metadata</h3></div>
        <div class="bd2">
          <div class="fld">
            <label for="lpSeoTitle">Meta Title <span class="cnt" id="seoTitleCnt"></span></label>
            <input class="inp" id="lpSeoTitle" name="seo_title" data-count="seoTitleCnt" data-min="30" data-max="60" value="<?= htmlspecialchars($lp['seo_title'] ?? '') ?>" placeholder="e.g. Laravel Developer in Karachi, Pakistan | Amaanullah Khan">
          </div>

          <div class="fld">
            <label for="lpMetaDesc">Meta Description <span class="cnt" id="metaDescCnt"></span></label>
            <textarea class="inp" id="lpMetaDesc" name="meta_description" rows="3" data-count="metaDescCnt" data-min="120" data-max="160" placeholder="150–160 character description..."><?= htmlspecialchars($lp['meta_description'] ?? '') ?></textarea>
          </div>
        </div>
      </section>

      <!-- JSON-LD Structured Data -->
      <section class="card">
        <div class="hd">
          <h3>JSON-LD Schema</h3>
          <div class="r"><small class="mut">Structured Data</small></div>
        </div>
        <div class="bd2">
          <div class="fld">
            <label for="lpSchema">Schema Markup</label>
            <textarea class="inp code-in" id="lpSchema" name="schema_json" rows="6" style="font-family:'JetBrains Mono',monospace;font-size:12px"><?= htmlspecialchars($lp['schema_json'] ?? '') ?></textarea>
          </div>
        </div>
      </section>

      <?php if ($isEdit): ?>
      <section class="card">
        <div class="bd2">
          <button class="btn d" style="width:100%" type="button" id="btnDeleteLanding" data-confirm="Delete this landing page permanently?">
            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg> Delete landing page
          </button>
        </div>
      </section>
      <?php endif; ?>
    </aside>
  </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  var baseUrl = '<?= base_url() ?>';
  var saveBtn = document.getElementById('btnSaveLanding');

  // Slug auto-generation from title if empty
  var titleIn = document.getElementById('lpTitle');
  var slugIn = document.getElementById('lpSlug');
  if (titleIn && slugIn && !slugIn.value) {
    titleIn.addEventListener('input', function(){
      if (!slugIn.dataset.manual) {
        slugIn.value = titleIn.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
      }
    });
    slugIn.addEventListener('input', function(){
      slugIn.dataset.manual = 'true';
    });
  }

  // Live character counters
  document.querySelectorAll('[data-count]').forEach(function(el){
    var target = document.getElementById(el.getAttribute('data-count'));
    if (!target) return;
    function updateCount(){
      var len = el.value.length;
      var min = parseInt(el.getAttribute('data-min') || '0', 10);
      var max = parseInt(el.getAttribute('data-max') || '0', 10);
      target.textContent = len + (max ? ' / ' + max : ' chars');
      if (max && len > max) {
        target.style.color = 'var(--bad, #ef4444)';
      } else if (min && len < min) {
        target.style.color = 'var(--warn, #f59e0b)';
      } else {
        target.style.color = 'var(--ok, #10b981)';
      }
    }
    el.addEventListener('input', updateCount);
    updateCount();
  });

  // Save Landing Page
  if (saveBtn) {
    saveBtn.addEventListener('click', function(e){
      e.preventDefault();
      var title = (document.getElementById('lpTitle')?.value || '').trim();
      if (!title) {
        alert('Please enter a landing page title.');
        document.getElementById('lpTitle')?.focus();
        return;
      }

      var payload = {
        _token: csrf,
        id: document.getElementById('lpId')?.value || '',
        title: title,
        city: document.getElementById('lpCity')?.value || 'Karachi',
        content_html: document.getElementById('lpContentHtml')?.value || '',
        is_active: document.getElementById('lpActive')?.checked ? 1 : 0,
        slug: document.getElementById('lpSlug')?.value || '',
        seo_title: document.getElementById('lpSeoTitle')?.value || '',
        meta_description: document.getElementById('lpMetaDesc')?.value || '',
        schema_json: document.getElementById('lpSchema')?.value || ''
      };

      saveBtn.disabled = true;
      var originalHtml = saveBtn.innerHTML;
      saveBtn.innerHTML = 'Saving...';

      fetch(baseUrl + '/admin/landing-pages/save', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify(payload)
      })
      .then(function(r){ return r.json(); })
      .then(function(data){
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalHtml;

        if (data.success) {
          if (typeof AK !== 'undefined' && AK.toast) {
            AK.toast(data.message || 'Landing page saved successfully!', 'ok');
          } else {
            alert(data.message || 'Landing page saved successfully!');
          }
          if (data.id && (!payload.id || payload.id !== String(data.id))) {
            window.location.href = baseUrl + '/admin/landing-pages/edit?id=' + data.id;
          }
        } else {
          alert(data.error || 'Failed to save landing page.');
        }
      })
      .catch(function(){
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalHtml;
        alert('Network error saving landing page.');
      });
    });
  }

  // Delete Landing Page
  var delBtn = document.getElementById('btnDeleteLanding');
  if (delBtn) {
    delBtn.addEventListener('click', function(e){
      e.preventDefault();
      var id = document.getElementById('lpId')?.value;
      if (!id) return;
      var msg = delBtn.getAttribute('data-confirm') || 'Are you sure you want to delete this landing page?';
      if (!confirm(msg)) return;

      fetch(baseUrl + '/admin/landing-pages/delete', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({ id: id, _token: csrf })
      })
      .then(function(r){ return r.json(); })
      .then(function(data){
        if (data.success) {
          window.location.href = baseUrl + '/admin/landing-pages';
        } else {
          alert(data.error || 'Failed to delete landing page.');
        }
      })
      .catch(function(){
        alert('Network error deleting landing page.');
      });
    });
  }
});
</script>
