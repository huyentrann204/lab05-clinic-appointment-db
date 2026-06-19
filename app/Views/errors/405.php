<?php ob_start(); ?>

<h1>405 Method Not Allowed</h1>

<p>
    This HTTP method is not allowed for the requested URL.
</p>

<a href="/">
    Back to Dashboard
</a>

<?php
$content = ob_get_clean();
$title = '405 Method Not Allowed';

require __DIR__ . '/../layout.php';