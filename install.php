<?php
session_start();
require_once("install/settings.inc.php");
require_once("install/functions.inc.php");
require_once("install/languages.inc.php");
$program_already_installed = false;
if (file_exists(EI_CONFIG_FILE_PATH)) {
	$program_already_installed = true;
	$disabled                  = "disabled";
	///header("location: ".EI_APPLICATION_START_FILE);
	///exit;
}
$extensions = get_loaded_extensions();
//var_dump($extensions);exit;
function isEnabled($func)
{
	return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
}
ob_start();
if (function_exists('phpinfo'))
	@phpinfo(-1);
$phpinfo = array(
	'phpinfo' => array()
);

error_reporting(0);
ini_set('display_errors', 'Off');

if (preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', ob_get_clean(), $matches, PREG_SET_ORDER))
	foreach ($matches as $match) {
		if (strlen($match[1])) {
			$phpinfo[$match[1]] = array();
		} else if (isset($match[3])) {
			$phpinfo[end(array_keys($phpinfo))][$match[2]] = isset($match[4]) ? array(
				$match[3],
				$match[4]
			) : $match[3];
		} else {
			$phpinfo[end(array_keys($phpinfo))][] = $match[2];
		}
	}
//var_dump(stripos($phpinfo['PDO']['PDO drivers'], 'mysql'));exit;
//print_r($phpinfo['PDO']['PDO drivers']);exit;
$is_error = false;
$error_mg = array();
if (EI_CHECK_PHP_MINIMUM_VERSION && (version_compare(phpversion(), EI_PHP_MINIMUM_VERSION, '<'))) {
	$is_error              = true;
	$alert_min_version_php = lang_key('alert_min_version_php');
	$alert_min_version_php = str_replace("_PHP_VERSION_", EI_PHP_MINIMUM_VERSION, $alert_min_version_php);
	$alert_min_version_php = str_replace("_PHP_CURR_VERSION_", phpversion(), $alert_min_version_php);
	$error_mg[]            = $alert_min_version_php;
}
if (EI_CHECK_CONFIG_DIR_WRITABILITY && !is_writable(EI_CONFIG_FILE_DIRECTORY)) {
	$is_error   = true;
	$error_mg[] = str_replace("_FILE_DIRECTORY_", EI_CONFIG_FILE_DIRECTORY, lang_key('alert_directory_not_writable'));
}
if (!is_writable("storage/cache/")) {
	$is_error   = true;
	$error_mg[] = "storage/cache/ directory need to be writable, chmod 766 this directory using your ftp client.";
}
if (!is_writable("storage/locks/")) {
	$is_error   = true;
	$error_mg[] = "storage/locks/ directory need to be writable, chmod 766 this directory using your ftp client.";
}
if (!is_writable("storage/logs/")) {
	$is_error   = true;
	$error_mg[] = "storage/logs/ directory need to be writable, chmod 766 this directory using your ftp client.";
}
if (!is_writable("system/libs/smarty/templates_c/")) {
	$is_error   = true;
	$error_mg[] = "system/libs/smarty/templates_c/ directory need to be writable, chmod 766 this directory using your ftp client.";
}
$phpversion          = function_exists("phpversion") ? "<span class='text-primary'>" . phpversion() . "</span>" : "<span class='unknown'>" . lang_key('unknown') . "</span>";
$system              = isset($phpinfo['phpinfo']['System']) ? "<span class='text-primary'>" . $phpinfo['phpinfo']['System'] . "</span>" : "<span class='unknown'>" . lang_key('unknown') . "</span>";
$system_architecture = isset($phpinfo['phpinfo']['Architecture']) ? "<span class='text-primary'>" . $phpinfo['phpinfo']['Architecture'] . "</span>" : "<span class='unknown'>" . lang_key('unknown') . "</span>";
$build_date          = isset($phpinfo['phpinfo']['Build Date']) ? "<span class='text-primary'>" . $phpinfo['phpinfo']['Build Date'] . "</span>" : "<span class='unknown'>" . lang_key('unknown') . "</span>";
$server_api          = isset($phpinfo['phpinfo']['Server API']) ? "<span class='text-primary'>" . $phpinfo['phpinfo']['Server API'] . "</span>" : "<span class='unknown'>" . lang_key('unknown') . "</span>";
$vd_support          = isset($phpinfo['phpinfo']['Virtual Directory Support']) ? $phpinfo['phpinfo']['Virtual Directory Support'] : lang_key('unknown');
$vd_support          = ($vd_support == "enabled") ? "<span class='text-success'>" . $vd_support . "</span>" : "<span class='disabled'>" . $vd_support . "</span>";
$asp_tags            = isset($phpinfo['Core']['asp_tags'][0]) ? "<span class='text-primary'>" . $phpinfo['Core']['asp_tags'][0] . "</span>" : "<span class='unknown'>" . lang_key('unknown') . "</span>";
//$safe_mode 	= isset($phpinfo['Core']['safe_mode'][0]) ? "<span class='text-primary'>".$phpinfo['Core']['safe_mode'][0]."</span>" : "<span class='unknown'>".lang_key('unknown')."</span>";
if (ini_get('safe_mode')) {
	$safe_mode  = "<span class='text-danger'>On</span>";
	$error_mg[] = "Script will not work with Safe Mode enabled, please disable it to continue.";
	$safecheck  = 0;
	$is_error   = true;
} else {
	$safe_mode = "<span class='text-success'>Off</span>";
	$safecheck = 1;
}
if (isEnabled('curl_version')) {
	$curl      = "<span class='text-success'>On</span>";
	$curlcheck = 1;
} else {
	$curl       = "<span class='text-danger'>Off</span>";
	$error_mg[] = "Script need curl extension to work, please enable it to continue.";
	$curlcheck  = 0;
	$is_error   = true;
}
if (isEnabled('shell_exec')) {
	$shell      = "<span class='text-success'>On</span>";
	$shellcheck = 1;
} else {
	$shell      = "<span class='text-danger'>Off</span>";
	$error_mg[] = "Script need shell_exec to be enabled in order to work correctly, please enable it to continue.";
	$shellcheck = 0;
	$is_error   = true;
}
if (isEnabled('exec')) {
	$exec      = "<span class='text-success'>On</span>";
	$execcheck = 1;
} else {
	$exec       = "<span class='text-danger'>Off</span>";
	$error_mg[] = "Script need exec to be enabled in order to work correctly, please enable it to continue.";
	$execcheck  = 0;
	$is_error   = true;
}
if (class_exists('PDO')) {
	if (stripos($phpinfo['PDO']['PDO drivers'], 'mysql') === false) {
		$mpdo = 0;
	} else {
		$mpdo = 1;
	}
}
if ($mpdo == 1) {
	$pdo      = "<span class='text-success'>On</span>";
	$pdocheck = 1;
} else {
	$pdo        = "<span class='text-danger'>Off</span>";
	$error_mg[] = "Script need PDO MySQL plugin to be enabled in order to work correctly, please enable it to continue.";
	$pdocheck   = 0;
	$is_error   = true;
}
$short_open_tag  = isset($phpinfo['Core']['short_open_tag'][0]) ? "<span class='text-primary'>" . $phpinfo['Core']['short_open_tag'][0] . "</span>" : "<span class='unknown'>" . lang_key('unknown') . "</span>";
$session_support = isset($phpinfo['session']['session.save_handler'][0]) ? $phpinfo['session']['session.save_handler'][0] : lang_key('unknown');
if ($session_support == "files" || $session_support == "memcache" || $session_support == "memcached" || $session_support == "redis" || $session_support == "mm" || $session_support == "wincache") {
	$session_support = "<span class='text-success'>" . $session_support . "</span>";
	$sessioncheck    = 1;
} else {
	$session_support = "<span class='text-danger'>" . $session_support . "</span>";
	$error_mg[]      = "Script need Sessions to be enabled in order to work correctly, please enable it to continue.";
	$sessioncheck    = 0;
	$is_error        = true;
}
if (in_array('ionCube Loader', $extensions)) {
	$ioncube      = "<span class='text-success'>On</span>";
	$ioncubecheck = 1;
} else {
	$ioncube      = "<span class='text-danger'>Off</span>";
	$error_mg[]   = "Script need Ioncube plugin to be enabled in order to work correctly, please enable it to continue.";
	$ioncubecheck = 0;
	$is_error     = true;
}
if (EI_CHECK_MAGIC_QUOTES) {
	$magic_quotes_gpc     = ini_get("magic_quotes_gpc") ? "<span class='text-success'>On</span>" : "<span class='disabled'>Off</span>";
	$magic_quotes_runtime = ini_get("magic_quotes_runtime") ? "<span class='text-success'>On</span>" : "<span class='disabled'>Off</span>";
	$magic_quotes_sybase  = ini_get("magic_quotes_sybase") ? "<span class='text-success'>On</span>" : "<span class='disabled'>Off</span>";
}
$smtp          = (ini_get("SMTP") != "") ? "<span class='text-primary'>" . ini_get("SMTP") . "</span>" : "<span class='unknown'>" . lang_key('unknown') . "</span>";
$smtp_port     = (ini_get("smtp_port") != "") ? "<span class='text-primary'>" . ini_get("smtp_port") . "</span>" : "<span class='unknown'>" . lang_key('unknown') . "</span>";
$sendmail_from = (ini_get("sendmail_from") != "") ? "<span class='text-primary'>" . ini_get("sendmail_from") . "</span>" : "<span class='unknown'>" . lang_key('unknown') . "</span>";
$sendmail_path = (ini_get("sendmail_path") != "") ? "<span class='text-primary'>" . ini_get("sendmail_path") . "</span>" : "<span class='unknown'>" . lang_key('unknown') . "</span>";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title><?php
echo lang_key("installation_guide");
?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="install/css/stylesIE.css"></link>
	<![endif]-->
	<script type="text/javascript">
		var EI_LOCAL_PATH = "install/language/<?php
echo $curr_lang;
?>/";
	</script>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
</head>
<body>
<div class="container">
<div class="row">
<table align="center" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr><td>&nbsp;</td></tr>
<tr>
    <td class="text" valign="top">
	<div class="panel panel-primary">
    <div class="panel-heading"><h3><?php
echo lang_key("new_installation_of");
?> <?php
echo EI_APPLICATION_NAME . " " . EI_APPLICATION_VERSION;
?>!</h3></div>
    <div class="panel-body">
		<table width="95%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
        <tr>
			<td class="text">
				<?php
if (EI_ALLOW_MANUAL_INSTALLATION) {
?>
					<input type="radio" name="install_type" id="install_type_wizard" onClick="toggleInstructions(1)" checked='checked' /><label for="install_type_wizard"><?php
	echo lang_key("follow_the_wizard");
?></label>
					<input type="radio" name="install_type" id="install_type_manual" onClick="toggleInstructions(2)" /><label for="install_type_manual"><?php
	echo lang_key("perform_manual_installation");
?></label>
				<?php
} else {
?>
					<?php
	echo lang_key("follow_the_wizard");
?>
				<?php
}
?>
			</td>                
			<td class="text" align="right" valign="middle">
				<?php
if (count($arr_active_languages) > 1) {
	echo lang_key("language") . ": ";
	echo "<select onchange=\"javascript:goTo('install.php?lang='+this.value)\">";
	foreach ($arr_active_languages as $key => $val) {
		echo "<option " . (($key == $curr_lang) ? "selected=selected" : "") . " value='" . $key . "'>" . $val . "</option>";
	}
	echo "</select>";
}
?>
				
			</td>                
		</tr>
		<tr><td colspan="2" nowrap="nowrap" height="8px"></td></tr>
        <tr>
            <td class="gray_table" colspan="2">                
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <tr><td class="ltcorner"></td><td></td><td class="rtcorner"></td></tr>
                <tr>
                    <td></td>
                    <td align="middle">                       
					    <div id="divWizard">
							<table class="text" width="99%" cellspacing="2" cellpadding="0" border="0">
							<tbody>
							<tr>
								<td align="left" colspan="2"><h4><?php
echo lang_key("getting_system_info");
?></h4></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("php_version");
?></b>: <i><?php
echo $phpversion;
?></i></td>
								<td><span class='text-success'><?php
echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("system");
?></b>: <i><?php
echo $system;
?></i></td>
								<td><span class='text-success'><?php
echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("system_architecture");
?></b>: <i><?php
echo $system_architecture;
?></i></td>
								<td><span class='text-success'><?php
echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("build_date");
?></b>: <i><?php
echo $build_date;
?></i></td>
								<td><span class='text-success'><?php
echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("server_api");
?></b>: <i><?php
echo $server_api;
?></i></td>
								<td><span class='text-success'><?php
echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("short_open_tag");
?></b>: <i><?php
echo $short_open_tag;
?></i></td>
								<td><span class='text-success'><?php
echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("virtual_directory_support");
?></b>: <i><?php
echo $vd_support;
?></i></td>
								<td><span class='text-success'><?php
echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("curl");
?></b>: <i><?php
echo $curl;
?></i></td>
								<td><?php
if ($curlcheck == 1) {
?><span class='text-success'><?php
	echo lang_key("checked");
?>!</span><?php
} else {
?> <span class='text-danger'><?php
	echo lang_key("failed");
?>!</span><?php
}
?></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("shell_exec");
?></b>: <i><?php
echo $shell;
?></i></td>
								<td><?php
if ($shellcheck == 1) {
?><span class='text-success'><?php
	echo lang_key("checked");
?>!</span><?php
} else {
?> <span class='text-danger'><?php
	echo lang_key("failed");
?>!</span><?php
}
?></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("exec");
?></b>: <i><?php
echo $exec;
?></i></td>
								<td><?php
if ($execcheck == 1) {
?><span class='text-success'><?php
	echo lang_key("checked");
?>!</span><?php
} else {
?> <span class='text-danger'><?php
	echo lang_key("failed");
?>!</span><?php
}
?></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("pdo");
?></b>: <i><?php
echo $pdo;
?></i></td>
								<td><?php
if ($pdocheck == 1) {
?><span class='text-success'><?php
	echo lang_key("checked");
?>!</span><?php
} else {
?> <span class='text-danger'><?php
	echo lang_key("failed");
?>!</span><?php
}
?></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
echo lang_key("session_support");
?></b>: <i><?php
echo $session_support;
?></i></td>
								<td><?php
if ($sessioncheck == 1) {
?><span class='text-success'><?php
	echo lang_key("checked");
?>!</span><?php
} else {
?> <span class='text-danger'><?php
	echo lang_key("failed");
?>!</span><?php
}
?></td>
							</tr>	
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; Ioncube</b>: <i><?php
echo $ioncube;
?></i></td>
								<td><?php
if ($ioncubecheck == 1) {
?><span class='text-success'><?php
	echo lang_key("checked");
?>!</span><?php
} else {
?> <span class='text-danger'><?php
	echo lang_key("failed");
?>!</span><?php
}
?></td>
							</tr>								
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<?php
if (EI_CHECK_MAGIC_QUOTES) {
?>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
	echo lang_key("magic_quotes_gpc");
?></b>: <i><?php
	echo $magic_quotes_gpc;
?></i></td>
								<td><span class='text-success'><?php
	echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
	echo lang_key("magic_quotes_runtime");
?></b>: <i><?php
	echo $magic_quotes_runtime;
?></i></td>
								<td><span class='text-success'><?php
	echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
	echo lang_key("magic_quotes_sybase");
?></b>: <i><?php
	echo $magic_quotes_sybase;
?></i></td>
								<td><span class='text-success'><?php
	echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<?php
}
?>

							<?php
if (EI_CHECK_MAIL_SETTINGS) {
?>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
	echo lang_key("smtp");
?></b>: <i><?php
	echo $smtp;
?></i></td>
								<td><span class='text-success'><?php
	echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
	echo lang_key("smtp_port");
?></b>: <i><?php
	echo $smtp_port;
?></i></td>
								<td><span class='text-success'><?php
	echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
	echo lang_key("sendmail_from");
?></b>: <i><?php
	echo $sendmail_from;
?></i></td>
								<td><span class='text-success'><?php
	echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
								<td><b>&#8226; <?php
	echo lang_key("sendmail_path");
?></b>: <i><?php
	echo $sendmail_path;
?></i></td>
								<td><span class='text-success'><?php
	echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
							  <td><b>&#8226; Site Path</b>: <i><?php
	echo dirname(__FILE__);
?></i></td>
							  <td><span class='text-success'><?php
	echo lang_key("checked");
?>!</span></td>
							</tr>
							<tr><td colspan="2" nowrap height="9px"></td></tr>
							<tr>
							  <td><b>&#8226; Site Url</b>: <i>http://<?php
	echo $_SERVER['HTTP_HOST'] . "/";
?></i></td>
							  <td><span class='text-success'><?php
	echo lang_key("checked");
?>!</span></td>
							  </tr>
							<?php
}
?>
							
							<tr><td colspan="2">&nbsp;</td></tr>
							<?php
if (!$is_error) {
	echo ($program_already_installed) ? "<tr><td align='left' colspan='2'><span class='alert-danger'>* " . lang_key("alert_unable_to_install") . "</span><br><br></td></tr>" : "";
} else {
	if ($is_error) {
		$disabled = "disabled";
		foreach ($error_mg as $msg) {
			echo "<tr><td colspan='2' align='left'><span class='alert-danger'>&#8226; " . $msg . "</span><br><br></td></tr>";
		}
	}
}
?>
							</tbody>
							</table>			
							
								<table width="100%" border="0" cellspacing="0" cellpadding="2" class="text">
								<tr>
									<td align="left" width="70px">
									<form action="install/step1.php" method="get">
									<button type="submit" class="btn btn-default" <?php
if (isset($disabled)) {
	echo $disabled;
}
?>><?php
echo lang_key("click_to_start_installation");
?></button>
									</form>								
									</td>
								</tr>
						  </table>						

				    </div>
						
						<?php
if (EI_ALLOW_MANUAL_INSTALLATION) {
	echo "<div id='divManually'>";
	include_once(EI_MANUAL_INSTALLATION_DIR . $arr_manual_installations[$curr_lang]);
	echo "</div>";
}
?>
						
					</td>
                    <td></td>
                </tr>
				<tr><td class="lbcorner"></td><td></td><td class="rbcorner"></td></tr>
                </tbody>
                </table>
            </td>
        </tr>
        </tbody>
        </table>
		</div>
		</div> 
        <?php
include_once("install/footer.php");
?>        
    </td>
</tr>
</tbody>
</table>
 </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> 
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>   
<script type="text/javascript" src="install/js/main.js"></script> 
            
</body>
</html>