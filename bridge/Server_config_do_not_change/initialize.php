<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : 
	define('SITE_ROOT', DS.'home'.DS.'astahm'.DS.'public_html'.DS.'anup.pro.np'.DS.'bridge');
// /home/astahm/public_html/anup.pro.np/bridge
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');
$location = DS;
// header("Location: {$location}");
// exit;
// print_r($_SERVER);
// load config file first
require_once(LIB_PATH.DS.'config.php');

// echo SITE_ROOT;
// echo "<br/>";
// echo LIB_PATH;

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'database_object.php');

// load database-related classes
require_once(LIB_PATH.DS.'user.php');

?>