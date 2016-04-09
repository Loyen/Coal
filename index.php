<?php
// Load bootstrap
require_once('library'.DIRECTORY_SEPARATOR.'bootstrap.php');

// Execute page
$dispatcher = new \Coal\Core\dispatcher();
print ($dispatcher->dispatch() ?: '');