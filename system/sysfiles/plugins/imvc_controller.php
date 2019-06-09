<?php


class iMVC_Controller
{

  function __construct()
  {
    /* save controller instance */
    tmvc::instance($this,'controller');
  
    /* instantiate load library */
    $this->load = new iMVC_Load;  

    /* instantiate view library */
    $this->view = new iMVC_View;
  }
  
   
  function index() { }


  function __call($function, $args) {
  
    throw new Exception("Unknown controller method '{$function}'");

  }
  
}

?>
