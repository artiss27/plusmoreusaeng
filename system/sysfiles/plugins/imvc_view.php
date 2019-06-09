<?php



class iMVC_View
{

 	
  var $view_vars = array();
  
 	
  function __construct() {}
  
	    
  public function assign($key, $value=null)
  {
    if(isset($value))
      $this->view_vars[$key] = $value;
    else
      foreach($key as $k => $v)
        if(is_int($k))
          $this->view_vars[] = $v;
        else
          $this->view_vars[$k] = $v;
  }  

	    
  public function display($_tmvc_filename,$view_vars=null)
  {
    return $this->_view(TMVC_MYAPPDIR . 'views' . DS . "{$_tmvc_filename}.php",$view_vars);
  }  

	    
  public function fetch($filename,$view_vars=null)
  {
    ob_start();
    $this->display($filename,$view_vars);
    $results = ob_get_contents();
    ob_end_clean();
    return $results;
  }  

	    
  public function sysview($filename,$view_vars = null)
  {
    $filepath = TMVC_BASEDIR . 'sysfiles' . DS . 'views' . DS . "{$filename}.php";
    return $this->_view($filepath,$view_vars);
  }

	    
  public function _view($_tmvc_filepath,$view_vars = null)
  {
    if(!file_exists($_tmvc_filepath))
      throw new Exception("Unknown file '$_tmvc_filepath'");

    // bring view vars into view scope
      extract($this->view_vars);
    if(isset($view_vars))
      extract($view_vars);
    include($_tmvc_filepath);
  }

}

?>
