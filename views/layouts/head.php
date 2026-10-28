<?php
/**
 * Unified Shared HTML <head> Partial
 * Automatically renders complete On-Page SEO, GEO, AEO, and Schema.org @graph.
 */
use App\Helpers\SeoEngine;
require_once BASE_PATH . '/app/Helpers/SeoEngine.php';

// Render full Meta, GEO, OG, and JSON-LD Schema
echo SeoEngine::renderHead($pageMeta ?? []);
?>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<?php if (!empty($extraCss) && is_array($extraCss)): ?>
  <?php foreach ($extraCss as $cssPath): ?>
    <link rel="stylesheet" href="<?= asset_url($cssPath) ?><?= str_contains($cssPath, '?') ? '' : '?v=' . time() ?>">
  <?php endforeach; ?>
<?php endif; ?>
