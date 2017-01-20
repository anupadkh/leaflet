<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : 
	define('SITE_ROOT', __DIR__ .DS."..");

	//'C:'.DS.'Domains'. DS . 'ftpserver.gov' .DS .'ddc'.DS.'bridge');
// C:\xampp\htdocs\bridge\includes
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');
// echo "Hello";
// load config file first
// echo SITE_ROOT;
// echo ;
require_once LIB_PATH.DS.'config.php';

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'database_object.php');

// load database-related classes
require_once(LIB_PATH.DS.'user.php');

?>
