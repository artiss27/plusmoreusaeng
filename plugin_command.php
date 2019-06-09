<?php

chdir(__DIR__);

include 'error_reporting.php';
require 'vendor/autoload.php';

session_start();

if (php_sapi_name() != "cli") {
	die("invalid enviroment");
}

define('TMVC_BASEDIR', 'system/');
define('TMVC_MYAPPDIR', 'system/app/');
define('TMVC_ERROR_HANDLING', 1);

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('TMVC_BASEDIR')) {
	define('TMVC_BASEDIR', dirname(__FILE__) . DS . '..' . DS . 'tmvc' . DS);
}

if (!defined('TMVC_MYAPPDIR'))
	define('TMVC_MYAPPDIR', TMVC_BASEDIR . 'myapp' . DS);

set_include_path(get_include_path() . PATH_SEPARATOR . TMVC_BASEDIR . 'sysfiles' . DS . 'plugins' . DS . PATH_SEPARATOR . TMVC_BASEDIR . 'myfiles' . DS . 'plugins' . DS . PATH_SEPARATOR . TMVC_MYAPPDIR . 'models' . DS . PATH_SEPARATOR . TMVC_MYAPPDIR . 'plugins' . DS);


spl_autoload_extensions('.php,.inc');

$spl_funcs = spl_autoload_functions();
if ($spl_funcs === false)
	spl_autoload_register();
elseif (!in_array('spl_autoload', $spl_funcs))
	spl_autoload_register('spl_autoload');

/* instantiate */
$tmvc = new tmvc();
$tmvc->main($argv[1], $argv[2], $argv[3]);	

class tmvc
{
    
    public $config = null;    
    public $controller = null;  
    public $action = null;    
    public $path_info = null;    
    public $url_segments = null;    
	static $_instance;
	    
    public function __construct($id = 'default')
    {        
        self::instance($this, $id);		
    }    
    
    public function main($plugin, $command, $id)
    {		
		 $controller_file = TMVC_MYAPPDIR . DS . 'plugins' . DS . $plugin . DS . 'controller' . DS ."admin.php";
		 include($controller_file);
		 $this->controller = new Admin_Controller(true);
		 $adapter = new \Desarrolla2\Cache\Adapter\File('storage/cache');
		 $adapter->setOption('ttl', 60*60*24);
		 $this->controller->cache = new \Desarrolla2\Cache\Cache($adapter); 
		 $this->setupAutoloaders();
		 $this->controller->hooks = \voku\helper\Hooks::getInstance();
		 $this->controller->load->model('Admin_Model', 'admin');
         $this->controller->load->model('Core_Model', 'core');  
		 $this->controller->{ucfirst($command)}($id);		
		
	}
	
	public static function &instance($new_instance = null, $id = 'default')
    {
        static $instance = array();
        if (isset($new_instance) && is_object($new_instance))
            $instance[$id] = $new_instance;
        return $instance[$id];
    }
	
	public function setupAutoloaders()
    {
        include(TMVC_MYAPPDIR . 'configs' . DS . 'autoload.php');
        if (!empty($config['libraries'])) {
            foreach ($config['libraries'] as $library)
                if (is_array($library))
                    $this->controller->load->library($library[0], $library[1]);
                else
                    $this->controller->load->library($library);
        }
        if (!empty($config['scripts'])) {
            foreach ($config['scripts'] as $script)
                $this->controller->load->script($script);
        }
		$this->controller->load->plugins();
    }
	
}


?>
