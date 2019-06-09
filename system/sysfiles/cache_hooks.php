<?php

use \Desarrolla2\Cache\Adapter\File;
use \Desarrolla2\Cache\Cache;

$adapter = new File('storage/cache');
$adapter->setOption('ttl', 60*60*24);
$this->controller->cache = new Cache($adapter); 
$this->setupAutoloaders();
$this->controller->hooks = \voku\helper\Hooks::getInstance();   

?>
