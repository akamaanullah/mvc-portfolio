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
<script>
(function(){
  var t;try{t=localStorage.getItem('theme')}catch(e){}
  var dark=t!=='light';
  var d=document.documentElement;
  d.setAttribute('data-theme',dark?'dark':'light');
  d.style.colorScheme=dark?'dark':'light';
  if(dark){
    if(document.body)document.body.classList.add('dark');
    else {
      var obs=new MutationObserver(function(){if(document.body){document.body.classList.add('dark');obs.disconnect();}});
      obs.observe(d,{childList:true,subtree:true});
    }
  }
})();
document.addEventListener('DOMContentLoaded',function(){if(window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches){document.querySelectorAll('video.pvid').forEach(function(v){v.removeAttribute('autoplay');v.pause();v.preload='none';v.load()})}});
</script>
<?php if (!empty($extraCss) && is_array($extraCss)): ?>
  <?php foreach ($extraCss as $cssPath): ?>
    <?php
      $rawPath = parse_url($cssPath, PHP_URL_PATH) ?? $cssPath;
      $fsPath = PUBLIC_PATH . '/' . ltrim($rawPath, '/');
      $ver = is_file($fsPath) ? filemtime($fsPath) : '1.0';
    ?>
    <link rel="stylesheet" href="<?= asset_url($cssPath) ?><?= str_contains($cssPath, '?') ? '' : '?v=' . $ver ?>">
  <?php endforeach; ?>
<?php endif; ?>

