<?php



class iMVC_Load
{

  function __construct() { }

    
  public function model($model_name,$model_alias=null,$filename=null,$pool_name=null)
  {

    /* if no alias, use the model name */
    if(!isset($model_alias))
      $model_alias = $model_name;

    /* if no filename, use the lower-case model name */
    if(!isset($filename))
      $filename = strtolower($model_name) . '.php';

    if(empty($model_alias))  
      throw new Exception("Model name cannot be empty");

    if(!preg_match('!^[a-zA-Z][a-zA-Z0-9_]+$!',$model_alias))
      throw new Exception("Model name '{$model_alias}' is an invalid syntax");
      
    if(method_exists($this,$model_alias))
      throw new Exception("Model name '{$model_alias}' is an invalid (reserved) name");

    /* model already loaded? silently skip */
    if(isset($this->$model_alias))
      return true;
    
    /* get instance of controller object */
    $controller = tmvc::instance(null,'controller');
    
    /* instantiate the object as a property */
    $controller->$model_alias = new $model_name($pool_name);
    
    return true;
      
  }
  
  public function plugin_model($model_name,$model_alias)
  {

    /* if no alias, use the model name */
    if(!isset($model_alias))
      $model_alias = $model_name;

    if(empty($model_alias))  
      throw new Exception("Model name cannot be empty");

    if(!preg_match('!^[a-zA-Z][a-zA-Z0-9_]+$!',$model_alias))
      throw new Exception("Model name '{$model_alias}' is an invalid syntax");
      
    if(method_exists($this,$model_alias))
      throw new Exception("Model name '{$model_alias}' is an invalid (reserved) name");

    /* model already loaded? silently skip */
    if(isset($this->$model_alias))
      return true;
    
    /* get instance of controller object */
    $controller = tmvc::instance(null,'controller');  
	/* model_alias must match plugin main directory */  
	include_once TMVC_MYAPPDIR . 'plugins/' . $model_alias . '/model/' . strtolower($model_name) . '.php';
    /* instantiate the object as a property */
    $controller->$model_alias = new $model_name();
    
    return true;
      
  }

   
  public function library($lib_name,$alias=null,$filename=null)
  {

    /* if no alias, use the class name */
    if(!isset($alias))
      $alias = $lib_name;

    if(empty($alias))  
      throw new Exception("Library name cannot be empty");

    if(!preg_match('!^[a-zA-Z][a-zA-Z_]+$!',$alias))
      throw new Exception("Library name '{$alias}' is an invalid syntax");
      
    if(method_exists($this,$alias))
      throw new Exception("Library name '{$alias}' is an invalid (reserved) name");
    
    /* get instance of tmvc object */
    $controller = tmvc::instance(null,'controller');    

    /* library already loaded? silently skip */
    if(isset($controller->$alias))
      return true;
    
    $class_name = "iMVC_Library_{$lib_name}";
    
    /* instantiate the object as a property */
    $controller->$alias = new $class_name;  
    
    return true;
      
  }

   
  public function script($script_name)
  {

    if(!preg_match('!^[a-zA-Z][a-zA-Z_]+$!',$script_name))
      throw new Exception("Invalid script name '{$script_name}'");
    
    $filename = strtolower("iMVC_Script_{$script_name}.php");

    $filepath = TMVC_MYAPPDIR . 'plugins' . DS . $filename;
    if(!file_exists($filepath))
      $filepath = TMVC_BASEDIR . 'myfiles' . DS . 'plugins' . DS . $filename;
    if(!file_exists($filepath))
      $filepath = TMVC_BASEDIR . 'sysfiles' . DS . 'plugins' . DS . $filename;
  
    if(!file_exists($filepath))
      throw new Exception("Unknown script file '{$filename}'");

    return require_once($filepath);
      
  }
  
  public function plugins()
  {
	foreach(glob(TMVC_MYAPPDIR . 'plugins' . DS . 'imvc_plugin*') as $filepath) {
		require_once($filepath);
	}       
  }


  public function database($poolname = null) {
    static $dbs = array();
    /* load config information */
    include(TMVC_MYAPPDIR . 'configs' . DS . 'database.php');
    if(!$poolname) 
      $poolname=isset($config['default_pool']) ? $config['default_pool'] : 'default';
    if ($poolname && isset($dbs[$poolname]))
    {
      /* returns object from runtime cache */
	    return $dbs[$poolname];
    }
    if($poolname && isset($config[$poolname]) && !empty($config[$poolname]['plugin']))
    {
      /* add to runtime cache */
      $dbs[$poolname] = new $config[$poolname]['plugin']($config[$poolname]);
      return $dbs[$poolname];
     }
  }  
  
}

?>
