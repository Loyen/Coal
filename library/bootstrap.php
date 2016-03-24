<?php
// Load
require_once(CORE.'cache.php');
require_once(CORE.'controller.php');
//require_once(CORE.'error.php');
require_once(CORE.'dispatcher.php');
require_once(CORE.'file.php');
require_once(CORE.'helper.php');
require_once(CORE.'hook.php');
require_once(CORE.'setting.php');
require_once(CORE.'theme.php');
require_once(CORE.'utilities.php');

// Execute page
$dispatcher = new dispatcher();
$output = $dispatcher->dispatch();

// If error code, run it through the set error controller
if (is_int($output))
	$output = $dispatcher->dispatch($output);

// Print output
echo $output;