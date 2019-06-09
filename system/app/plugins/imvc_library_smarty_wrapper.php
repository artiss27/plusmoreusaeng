<?php


define('SMARTY_SPL_AUTOLOAD', 1);
 
// require the Smarty class
require('system/libs/smarty/Smarty.class.php');
 
class iMVC_Library_Smarty_Wrapper Extends Smarty
{
  function __construct()
  {
    parent::__construct();
	
	$this->force_compile = true;
	$this->caching = false;
	$this->cache_lifetime = 100;
	$this->allow_php_tag = true;
    //$this->template_dir = 'system/app/views/main/';
    $this->compile_dir = 'system/libs/smarty/templates_c/';
    $this->config_dir = 'system/libs/smarty/configs/';
    $this->cache_dir = 'system/libs/smarty/cache/';
  }
}

?>