<?php
// Load
require_once(CORE.'cache.php');
require_once(CORE.'controller.php');
//require_once(CORE.'error.php');
require_once(CORE.'file.php');
require_once(CORE.'hook.php');
require_once(CORE.'http.php');
require_once(CORE.'plugin.php');
require_once(CORE.'session.php');
require_once(CORE.'setting.php');
require_once(CORE.'theme.php');
require_once(CORE.'user.php');
require_once(CORE.'utilities.php');

// Start session
session::start();

// Get user data
user::load();

// Load plugins
plugin::autoload();

// Execute page
$output = hook::execute();
if (is_int($output)) {
	if ($output === 403)
		$output = hook::execute('403');
	elseif ($output === 404)
		$output =  hook::execute('404');
}

// Write session
session::write();

// Print output
echo $output;