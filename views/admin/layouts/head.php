<?php /* Admin <head>. Vars: $title, $editor (bool) */ ?>
<!doctype html><html lang="en" data-theme="dark"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<script src="<?= asset_url('js/admin/theme.js') ?>"></script>
<title><?= e($title ?? "Admin") ?> · Admin · Amaanullah</title><meta name="robots" content="noindex,nofollow">
<meta name="csrf-token" content="<?= csrf_token() ?>"><meta name="base-url" content="<?= base_url() ?>"><script>window.__BASE_URL = '<?= rtrim(base_path_url(), '/') ?>';</script>
<link rel="icon" href="<?= asset_url('logo-v2/favicon-32.png') ?>"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet"><link rel="stylesheet" href="<?= asset_url('css/admin/admin.css') ?>"><?php if (!empty($editor)): ?><link rel="stylesheet" href="<?= asset_url('css/admin/editor.css') ?>"><?php endif; ?></head>
