<?php
// Define paths
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__).DS);
define('CONFIG', ROOT.'config'.DS);
define('CACHE', ROOT.'cache'.DS);
define('LIBRARY', ROOT.'library'.DS);
define('CORE', LIBRARY.'core'.DS);
define('MODULE', LIBRARY.'module'.DS);
define('HELPER', LIBRARY.'helper'.DS);
define('THEME', ROOT.'theme'.DS);

// Load bootstrap
require_once('library'.DIRECTORY_SEPARATOR.'bootstrap.php');
