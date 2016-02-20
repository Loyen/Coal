<?php
// Define paths
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__).DS);
define('APPLICATION', ROOT.'application'.DS);
define('CONFIG', ROOT.'config'.DS);
define('CACHE', ROOT.'cache'.DS);
define('LIBRARY', ROOT.'library'.DS);
define('CORE', LIBRARY.'core'.DS);
define('PLUGIN', LIBRARY.'plugin'.DS);
define('THEME', ROOT.'theme'.DS);

// Load bootstrap
require_once('library'.DIRECTORY_SEPARATOR.'bootstrap.php');
