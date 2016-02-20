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

// Execute page
$output = hook::execute();

// Write session
session::write();

// Print output
echo $output;