<?php ob_start(); ?>

<h1>404 Not Found</h1>

<p>
    The page you requested does not exist.
</p>

<a href="/">
    Back to Dashboard
</a>

<?php
$content = ob_get_clean();
$title = '404 Not Found';

require __DIR__ . '/../layout.php';