<?php

ini_set('default_socket_timeout', 10);

include 'error_reporting.php';
require 'vendor/autoload.php';

session_start();

use FS\AttackProtect;
AttackProtect::$defaultProtect = AttackProtect::All;
AttackProtect::protect();

define('TMVC_BASEDIR', 'system/');
define('TMVC_MYAPPDIR', 'system/app/');
define('TMVC_ERROR_HANDLING', 1);

if (!file_exists(TMVC_MYAPPDIR . 'configs/database.php')) {    
    header("Location: /install.php");
    exit;    
}

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('TMVC_BASEDIR')){
    define('TMVC_BASEDIR', dirname(__FILE__) . DS . '..' . DS . 'tmvc' . DS);
}

require(TMVC_BASEDIR . 'sysfiles' . DS . 'iMVC.php');

/* instantiate */
$tmvc = new tmvc();
$tmvc->main();

?>
