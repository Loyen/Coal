<?php
// Load
require_once(CORE.'cache.php');
require_once(CORE.'controller.php');
//require_once(CORE.'error.php');
require_once(CORE.'dispatcher.php');
require_once(CORE.'file.php');
require_once(CORE.'helper.php');
require_once(CORE.'hook.php');
require_once(CORE.'http.php');
require_once(CORE.'session.php');
require_once(CORE.'setting.php');
require_once(CORE.'theme.php');
require_once(CORE.'utilities.php');

// Execute page
$dispatcher = new dispatcher();
$output = $dispatcher->dispatch();

// Print output
echo $output;