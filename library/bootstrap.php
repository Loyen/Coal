<?php
// Define paths
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)).DS);
define('CONFIG', ROOT.'config'.DS);
define('CACHE', ROOT.'cache'.DS);
define('LIBRARY', ROOT.'library'.DS);
define('CORE', LIBRARY.'core'.DS);
define('MODULE', LIBRARY.'module'.DS);
define('HELPER', LIBRARY.'helper'.DS);
define('THEME', ROOT.'theme'.DS);

// Load
require_once(CORE.'error.php');
require_once(CORE.'file.php');
require_once(CORE.'cache.php');
require_once(CORE.'setting.php');
require_once(CORE.'dispatcher.php');
require_once(CORE.'helper.php');
require_once(CORE.'hook.php');
require_once(CORE.'http.php');
require_once(CORE.'module.php');
require_once(CORE.'renderer.php');
require_once(CORE.'session.php');
require_once(CORE.'theme.php');
require_once(CORE.'theme.parser.php');
require_once(CORE.'utilities.php');