<?php


function apphp_db_install($sql_dpif_file) {
	global $error_mg;
	global $username;
	global $password;
	global $database_prefix;
	global $password_encryption;
	global $db;
	
	$sql_array = array();
	$query = "";
	

	$sql_dump = file($sql_dpif_file);
	

	$sql_dump = str_replace("<DB_PREFIX>", $database_prefix, $sql_dump);

	
	if(substr($sql_dump[count($sql_dump)-1], -1) != ";") $sql_dump[count($sql_dump)-1] .= ";";


	if(EI_USE_USERNAME_AND_PASWORD){
		$sql_dump = str_replace("<USERNAME>", $username, $sql_dump);
		if(EI_USE_PASSWORD_ENCRYPTION){
			if($password_encryption == "AES"){
				$sql_dump = str_replace("<PASSWORD>", "AES_ENCRYPT('".$password."', '".EI_PASSWORD_ENCRYPTION_KEY."')", $sql_dump);
			}else if($password_encryption == "MD5"){
				$sql_dump = str_replace("<PASSWORD>", "MD5('".$password."')", $sql_dump);
			}else{
				$sql_dump = str_replace("<PASSWORD>", "AES_ENCRYPT('".$password."', '".EI_PASSWORD_ENCRYPTION_KEY."')", $sql_dump);				
			}
		}else{
			/*$options = [
			'cost' => 11,
			];*/
			//$hash = password_hash($password, PASSWORD_BCRYPT, $options);
			$hash = hash('sha256', $password);
			$sql_dump = str_replace("<PASSWORD>", $hash, $sql_dump);
		}
	}else{
		$sql_dump = str_replace("<USER_NAME>", "", $sql_dump);
		$sql_dump = str_replace("<PASSWORD>", "", $sql_dump);
	}
	
	$sql_dump = str_replace("<SITEPATH>", dirname(dirname(__FILE__))."/", $sql_dump);
	$sql_dump = str_replace("<SITEURL>", "http://".$_SERVER['HTTP_HOST']."/", $sql_dump);

	if(EI_USE_ENCODING){
		$db->SetEncoding(EI_DUMP_FILE_ENCODING, EI_DUMP_FILE_COLLATION);
	}		
	
	foreach($sql_dump as $sql_line){
		$tsl = trim(utf8_decode($sql_line));
		if(($sql_line != "") && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != "?") && (substr($tsl, 0, 1) != "#")){
			$query .= $sql_line;
			if(preg_match("/;\s*$/", $sql_line)){
				if(strlen(trim($query)) > 5){					
					if(EI_MODE == "debug"){
						if(!$db->Query($query)){ $error_mg[] = "<b>SQL</b>:<br />".$query."<br /><br /><b>".lang_key("error")."</b>:<br />".$db->Error(); return false; }						
					}else{
						if(!@$db->Query($query)) return false;
					}
				}
				$query = "";
			}
		}
	}
	return true;
}

/**
 * 	Returns language key
 * 		@param $key
 */
function lang_key($key){
	global $arrLang;
        $output = "";
        
	if(isset($arrLang[$key])){
		$output = $arrLang[$key];
	}else{
		$output = str_replace("_", " ", $key);		
	}
	return $output;
}

/**
 *	Remove bad chars from input
 *	  	@param $str_words - input
 **/
function prepare_input($str_words, $escape = false, $level = "high")
{
	$found = false;
	if($level == "low"){
		$bad_string = array("drop", ";", "--", "insert", "xp_", "%20union%20", "/*", "*/union/*", "+union+", "load_file", "outfile", "document.cookie", "onmouse", "<script", "<iframe", "<applet", "<meta", "<style", "<form", "<body", "<link", "_GLOBALS", "_REQUEST", "_GET", "_POST", "include_path", "prefix", "ftp://", "smb://", "onmouseover=", "onmouseout=");
	}else if($level == "medium"){
		$bad_string = array("select", "drop", ";", "--", "insert", "xp_", "%20union%20", "/*", "*/union/*", "+union+", "load_file", "outfile", "document.cookie", "onmouse", "<script", "<iframe", "<applet", "<meta", "<style", "<form", "<body", "<link", "_GLOBALS", "_REQUEST", "_GET", "_POST", "include_path", "prefix", "ftp://", "smb://", "onmouseover=", "onmouseout=");		
	}else{
		$bad_string = array("select", "drop", ";", "--", "insert", "xp_", "%20union%20", "/*", "*/union/*", "+union+", "load_file", "outfile", "document.cookie", "onmouse", "<script", "<iframe", "<applet", "<meta", "<style", "<form", "<img", "<body", "<link", "_GLOBALS", "_REQUEST", "_GET", "_POST", "include_path", "prefix", "http://", "https://", "ftp://", "smb://", "onmouseover=", "onmouseout=");
	}
	for($i = 0; $i < count($bad_string); $i++){
		$str_words = str_replace($bad_string[$i], "", $str_words);
	}
	
	if($escape){
		$str_words = mysql_real_escape_string($str_words); 
	}
	
	return $str_words;
}

?>