<?php /* Admin · Edit service — dynamic view. */ 
$s = $service ?? [];
$isEdit = !empty($s['id']);
$allServicesList = $allServices ?? [];
$slug = $s['slug'] ?? '';
$liveUrl = !empty($slug) ? base_url('/services/' . $slug) : base_url('/services');
?>
<div class="ph-h">
  <div>
    <div class="crumbs">Admin / <a href="<?= base_url('/admin/services') ?>">Services</a> / <?= $isEdit ? 'Edit' : 'New' ?></div>
    <h1><?= $isEdit ? ('Edit service · ' . htmlspecialchars($s['title'] ?? '')) : 'New service' ?></h1>
    <p>Manage service details, full page HTML content, SEO metadata, and JSON-LD schema.</p>
  </div>
  <div class="acts">
    <a class="btn" href="<?= base_url('/admin/services') ?>">Back to services</a>
    <?php if ($isEdit && !empty($slug)): ?>
      <a class="btn" href="<?= $liveUrl ?>" target="_blank">
        <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg> View live
      </a>
    <?php endif; ?>
    <button class="btn o" type="button" id="btnSaveService">
      <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg> Save service
    </button>
  </div>
</div>

<form id="serviceForm" action="" method="post">
  <input type="hidden" id="svcId" name="id" value="<?= htmlspecialchars((string)($s['id'] ?? '')) ?>">
  
  <div class="grid g21">
    <div style="display:flex;flex-direction:column;gap:16px">
      <!-- Main Content Card -->
      <section class="card">
        <div class="hd">
          <h3>Service details</h3>
        </div>
        <div class="bd2">
          <div class="fld">
            <label for="svcTitle">Service Title (H1) *</label>
            <input class="inp" id="svcTitle" name="title" required value="<?= htmlspecialchars($s['title'] ?? '') ?>" placeholder="e.g. Custom CRM Development">
          </div>

          <div class="fld">
            <label for="svcHighlight">Hero Subtitle / Highlight</label>
            <input class="inp" id="svcHighlight" name="highlight_em" value="<?= htmlspecialchars($s['highlight_em'] ?? '') ?>" placeholder="e.g. Laravel-based, scalable architecture">
          </div>

          <div class="fld">
            <label for="svcSummary">Summary / Short Description</label>
            <textarea class="inp" id="svcSummary" name="summary" rows="3" placeholder="Brief overview of the service..."><?= htmlspecialchars($s['summary'] ?? '') ?></textarea>
          </div>

          <div class="fld">
            <label for="svcTags">Tags (comma-separated)</label>
            <input class="inp" id="svcTags" name="tags" value="<?= htmlspecialchars($s['tags'] ?? '') ?>" placeholder="e.g. Laravel, CRM, MySQL, REST API">
          </div>
        </div>
      </section>

      <!-- Full Body HTML Card -->
      <section class="card">
        <div class="hd">
          <h3>Page HTML Content</h3>
          <div class="r">
            <small class="mut">Rendered inside &lt;main&gt; wrapper</small>
          </div>
        </div>
        <div class="bd2">
          <p class="mut" style="font-size:13px;margin:0 0 10px">
            Contains all sections for this service (Hero, Comparison, Modules, Process, Tech Stack, Testimonials, FAQ, CTA).
          </p>
          <div class="fld">
            <textarea class="inp code-in" id="svcBodyHtml" name="body_html" rows="22" style="font-family:'JetBrains Mono',monospace;font-size:13px;line-height:1.5" spellcheck="false"><?= htmlspecialchars($s['body_html'] ?? '') ?></textarea>
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
          <div class="fld">
            <label for="svcStatus">Status</label>
            <select class="sel" id="svcStatus" name="status">
              <?php $curStatus = $s['status'] ?? 'published'; ?>
              <option value="published" <?= $curStatus === 'published' ? 'selected' : '' ?>>Published</option>
              <option value="draft" <?= $curStatus === 'draft' ? 'selected' : '' ?>>Draft</option>
              <option value="archived" <?= $curStatus === 'archived' ? 'selected' : '' ?>>Archived</option>
            </select>
          </div>

          <div class="fld">
            <label for="svcSlug">URL Slug *</label>
            <div class="row">
              <span class="mut sm" style="white-space:nowrap">/services/</span>
              <input class="inp" id="svcSlug" name="slug" style="flex:1" value="<?= htmlspecialchars($s['slug'] ?? '') ?>" placeholder="service-slug">
            </div>
          </div>

          <div class="fld">
            <label for="svcSortOrder">Sort Order</label>
            <input class="inp" type="number" id="svcSortOrder" name="sort_order" value="<?= htmlspecialchars((string)($s['sort_order'] ?? 0)) ?>">
          </div>
        </div>
      </section>

      <!-- SEO Settings -->
      <section class="card">
        <div class="hd"><h3>SEO &amp; Metadata</h3></div>
        <div class="bd2">
          <div class="fld">
            <label for="svcSeoTitle">Meta Title <span class="cnt" id="seoTitleCnt"></span></label>
            <input class="inp" id="svcSeoTitle" name="seo_title" data-count="seoTitleCnt" data-min="30" data-max="60" value="<?= htmlspecialchars($s['seo_title'] ?? '') ?>" placeholder="Primary keyword | Brand">
          </div>

          <div class="fld">
            <label for="svcMetaDesc">Meta Description <span class="cnt" id="metaDescCnt"></span></label>
            <textarea class="inp" id="svcMetaDesc" name="meta_description" rows="3" data-count="metaDescCnt" data-min="120" data-max="160" placeholder="150–160 character description..."><?= htmlspecialchars($s['meta_description'] ?? '') ?></textarea>
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
            <label for="svcSchema">Schema Markup (&lt;script type="application/ld+json"&gt;)</label>
            <textarea class="inp code-in" id="svcSchema" name="schema_json" rows="6" style="font-family:'JetBrains Mono',monospace;font-size:12px"><?= htmlspecialchars($s['schema_json'] ?? '') ?></textarea>
          </div>
        </div>
      </section>

      <?php if ($isEdit): ?>
      <section class="card">
        <div class="bd2">
          <button class="btn d" style="width:100%" type="button" id="btnDeleteService" data-confirm="Delete this service permanently?">
            <svg class="i" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg> Delete service
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
  var saveBtn = document.getElementById('btnSaveService');

  // Slug auto-generation from title if empty
  var titleIn = document.getElementById('svcTitle');
  var slugIn = document.getElementById('svcSlug');
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

  // Save Service
  if (saveBtn) {
    saveBtn.addEventListener('click', function(e){
      e.preventDefault();
      var title = (document.getElementById('svcTitle')?.value || '').trim();
      if (!title) {
        alert('Please enter a service title.');
        document.getElementById('svcTitle')?.focus();
        return;
      }

      var payload = {
        _token: csrf,
        id: document.getElementById('svcId')?.value || '',
        title: title,
        highlight_em: document.getElementById('svcHighlight')?.value || '',
        summary: document.getElementById('svcSummary')?.value || '',
        tags: document.getElementById('svcTags')?.value || '',
        body_html: document.getElementById('svcBodyHtml')?.value || '',
        status: document.getElementById('svcStatus')?.value || 'published',
        slug: document.getElementById('svcSlug')?.value || '',
        sort_order: document.getElementById('svcSortOrder')?.value || '0',
        seo_title: document.getElementById('svcSeoTitle')?.value || '',
        meta_description: document.getElementById('svcMetaDesc')?.value || '',
        schema_json: document.getElementById('svcSchema')?.value || ''
      };

      saveBtn.disabled = true;
      var originalHtml = saveBtn.innerHTML;
      saveBtn.innerHTML = 'Saving...';

      fetch(baseUrl + '/admin/services/save', {
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
            AK.toast(data.message || 'Service saved successfully!', 'ok');
          } else {
            alert(data.message || 'Service saved successfully!');
          }
          if (data.id && (!payload.id || payload.id !== String(data.id))) {
            window.location.href = baseUrl + '/admin/services/edit?id=' + data.id;
          }
        } else {
          alert(data.error || 'Failed to save service.');
        }
      })
      .catch(function(){
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalHtml;
        alert('Network error saving service.');
      });
    });
  }

  // Delete Service
  var delBtn = document.getElementById('btnDeleteService');
  if (delBtn) {
    delBtn.addEventListener('click', function(e){
      e.preventDefault();
      var id = document.getElementById('svcId')?.value;
      if (!id) return;
      var msg = delBtn.getAttribute('data-confirm') || 'Are you sure you want to delete this service?';
      if (!confirm(msg)) return;

      fetch(baseUrl + '/admin/services/delete', {
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
          window.location.href = baseUrl + '/admin/services';
        } else {
          alert(data.error || 'Failed to delete service.');
        }
      })
      .catch(function(){
        alert('Network error deleting service.');
      });
    });
  }
});
</script>
