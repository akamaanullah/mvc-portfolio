<!doctype html><html lang="en"><head>
<script src="<?= asset_url('js/theme.js') ?>"></script>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>404 — Page not found | Amaanullah Khan</title>
<meta name="robots" content="noindex">
<link rel="icon" href="<?= asset_url('logo-v2/favicon.ico') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset_url('css/errors.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/layout.css') ?>">
<link rel="stylesheet" href="<?= asset_url('css/chatbot.css') ?>">
</head><body>
<?php $home = false; $active = ''; require view_path('layouts/header.php'); ?>

<main class="err"><div>
 <div class="code">404</div>
 <h1>Page not found</h1>
 <p>The page you’re looking for doesn’t exist or has moved.</p>
 <div class="acts2"><a class="btn pri" href="<?= base_url('/') ?>">Back to home &nbsp;→</a><a class="btn sec" href="<?= base_url('/contact') ?>">Contact me</a></div>
 <?php if (!empty($error)): ?><pre><?= e($error->getMessage() . "\n" . $error->getFile() . ':' . $error->getLine()) ?></pre><?php endif; ?>
</div></main>
<?php require view_path('layouts/footer.php'); ?>

<script src="<?= asset_url('js/layout.js') ?>"></script>
<script>window.__BASE_URL = '<?= base_path_url() ?>';</script><script src="<?= asset_url('js/chatbot-config.js') ?>?v=<?= time() ?>"></script>
<script src="<?= asset_url('js/chatbot.js') ?>?v=<?= time() ?>" defer></script>
</body></html>
