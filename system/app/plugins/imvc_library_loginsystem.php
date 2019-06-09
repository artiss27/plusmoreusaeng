<?php 

class iMVC_Library_LoginSystem extends iMVC_Controller
{ 
    var $username, 
        $password; 

     
    function __construct() 
    {         
		parent::__construct();
		$this->load->model('Core_Model','core');	
		$this->hooks = \voku\helper\Hooks::getInstance();	
	}
     
     
    function isLoggedIn() 
    { 		
        if(isset($_SESSION['LoggedIn'])) 
        { 
            return true; 
        } 
        else {
			return false; 
		}
    } 
     
     
    function doLogin($username, $password) 
    { 
	  
	  $checkAdmin = $this->core->db->queryFirstField("SELECT username FROM admin_users WHERE username = %s AND password = %s", $username, hash('sha256', $password));
       if ($checkAdmin == $username) {
		   $this->core->db->query("INSERT INTO admin_log (admin_username, ip_address, country, date, description, flag) VALUES ('".$username."', '".CoreHelp::getIp()."', '".CoreHelp::getCountryCode(CoreHelp::getIp())."', NOW(), 'Login Successfully', 0)");
            session_regenerate_id(); 
            $_SESSION['LoggedIn'] = true; 
            $_SESSION['userName'] = $username; 
	   }	   
	   else {
		   $this->core->db->query("INSERT INTO admin_log (admin_username, ip_address, country, date, description, flag) VALUES ('".$username."', '".CoreHelp::getIp()."', '".CoreHelp::getCountryCode(CoreHelp::getIp())."', NOW(), 'Login Failed', 1)");
		   return false; 		   
	   } 
        return true; 
    } 
     
     
    function logout() 
    { 
        unset($_SESSION['LoggedIn']); 
        unset($_SESSION['userName']);
		$this->hooks->do_action('logout');        
    } 
     

     
    function clean($str) 
    { 
        // Only remove slashes if it's already been slashed by PHP 
        if(get_magic_quotes_gpc()) 
        { 
            $str = stripslashes($str); 
        } 
        // Let MySQL remove nasty characters. 
        $str = mysql_real_escape_string($str); 
         
        return $str; 
    } 
     
     
    function randomPassword($length = 8) 
    { 
        $pass = ""; 
         
        // possible password chars. 
        $chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J", 
               "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T", 
               "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9"); 
                
        for($i=0 ; $i < $length ; $i++) 
        { 
            $pass .= $chars[mt_rand(0, count($chars) -1)]; 
        } 
         
        return $pass; 
    } 

} 

?>