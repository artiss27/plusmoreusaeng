<?php


class iMVC_Library_checklogin extends iMVC_Controller {
	
    function __construct() { 
	
	parent::__construct();
        
		$this->load->library('uri');
	
		echo $this->uri->segment(2);
		
		$this->load->library('LoginSystem','loginSys');
			if(!$this->loginSys->isLoggedIn())
			{			
				//$this->smarty->display('login.tpl');
		 		exit;	
			}
    } 
     
}
?>