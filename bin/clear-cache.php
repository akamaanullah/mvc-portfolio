<?php
/* Usage: php bin/clear-cache.php [--logs]  — empties storage/cache (and app.log with --logs) */
$base = dirname(__DIR__);
$n = 0;
foreach (glob($base . '/storage/cache/*') as $f) if (is_file($f) && basename($f) !== '.gitkeep') { unlink($f); $n++; }
if (in_array('--logs', $argv, true)) file_put_contents($base . '/storage/logs/app.log', '');
echo "Cleared {$n} cache file(s).\n";
