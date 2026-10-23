<?php
/* Admin layout: head + sidebar + topbar + page content + footer.
   Vars: $title, $active, $content (rendered page HTML), $editor (bool), $bare (bool, login screens) */
require __DIR__ . '/head.php'; ?>
<body>
<?php if (!empty($bare)): ?>
<?= $content ?>
<?php else: ?>
<div class="app"><?php require __DIR__ . '/sidebar.php'; ?><div class="main"><?php require __DIR__ . '/topbar.php'; ?>
<main class="content" id="main"><?= $content ?></main></div></div>
<?php endif; ?>
<?php require __DIR__ . '/footer.php';
