<?php



class iMVC_Model
{

  var $db = null;  
    

  function __construct($poolname=null) {
    $this->db = tmvc::instance()->controller->load->database($poolname);
  }
  
}

?>
