<?php


	session_start();
	
	require_once("shared.inc.php");    
    require_once("settings.inc.php");    
	require_once("functions.inc.php");
	require_once("languages.inc.php");	

	$database_host		= isset($_REQUEST['database_host']) ? $_REQUEST['database_host'] : "localhost";
	$database_name 		= isset($_REQUEST['database_name']) ? $_REQUEST['database_name'] : "";
	$database_username	= isset($_REQUEST['database_username']) ? $_REQUEST['database_username'] : "";
	$database_password	= isset($_REQUEST['database_password']) ? $_REQUEST['database_password'] : "";
	$database_prefix	= isset($_REQUEST['database_prefix']) ? $_REQUEST['database_prefix'] : "";	
	$install_type		= isset($_REQUEST['install_type']) ? $_REQUEST['install_type'] : "create";
	$password_encryption = isset($_REQUEST['password_encryption']) ? $_REQUEST['password_encryption'] : EI_PASSWORD_ENCRYPTION_TYPE;
	$program_already_installed = false;
	
    if(file_exists("../".EI_CONFIG_FILE_PATH)){        
		$program_already_installed = true;
		if($install_type == "create"){
			if(EI_ALLOW_UPDATE) $install_type = "update";
			else if(EI_ALLOW_UN_INSTALLATION) $install_type = "un-install";
		}
		include_once("../".EI_CONFIG_FILE_PATH);
		if(defined("DB_PREFIX")) $database_prefix = DB_PREFIX;	
		///header("location: ../".EI_APPLICATION_START_FILE);
        ///exit;
	}
	
	// prepare focus field
	if($database_host == ""){
		$focus_field = "database_host";
	}else if($database_name == ""){
		$focus_field = "database_name";
	}else if($database_username == ""){
		$focus_field = "database_username";
	}else if($database_password == ""){
		$focus_field = "database_password";		
	}else{
		$focus_field = "database_host";
	}


?>	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title><?php echo lang_key("installation_guide"); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="css/stylesIE.css"></link>
	<![endif]-->
	<script type="text/javascript">
		var EI_LOCAL_PATH = "language/<?php echo $curr_lang; ?>/";
	</script>
<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="css/styles.css"></link>
	<?php
		if(file_exists("languages/js/".$curr_lang.".js")){
			echo "<script type='text/javascript' src='language/".$curr_lang."/assets/frontpage/js/common.js'></script>";
		}else{
			echo "<script type='text/javascript' src='language/en/js/common.js'></script>";
		}
	?>
</head>
<body onLoad="bodyOnLoad()">
<div class="container">
<div class="row">   
<table align="center" width="100%" cellspacing="0" cellpadding="2" border="0">
<tbody>
<tr><td>&nbsp;</td></tr>
<tr>
    <td class=text valign=top>       
		<div class="panel panel-primary">
		<div class="panel-heading"><h3><?php echo lang_key("new_installation_of"); ?> <?php echo EI_APPLICATION_NAME." ".EI_APPLICATION_VERSION;?>!</h3></div>
		<div class="panel-body">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
        <tr>		
		<td> <?php echo lang_key("follow_the_wizard"); ?><br><br>
		<span class="star">*</span> <?php echo lang_key("alert_required_fields"); ?><br></td>
		</tr>
		<tr>
            <td class="gray_table">
                <table border="0" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <tr><td class="ltcorner"></td><td></td><td class="rtcorner"></td></tr>
                <tr>
                    <td width="2%" nowrap></td>
                    <td align="left">
                        <h4><?php echo lang_key("step_1_database_import"); ?></h4>
                        
                        <form method="post" action="step2.php">
                        <input type="hidden" name="task" value="step2" />  
                        <table class="text" width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td nowrap>&nbsp;<?php echo lang_key("database_host"); ?>: <span class="star">*</span></td>
							<td>
								<input type="text" class="form-control" name="database_host" id="database_host" size="30" value='<?php echo $database_host; ?>' onFocus="textboxOnFocus('notes_host')" onBlur="textboxOnBlur('notes_host')" required/>
								<?php if(EI_MODE == "demo") echo "(demo: localhost)"; ?>
							</td>
						</tr>
						<tr><td colspan="2" nowrap height="9px"></td></tr>
						<tr>
							<td nowrap>&nbsp;<?php echo lang_key("database_name"); ?>: <span class="star">*</span></td>
							<td>
								<input type="text" class="form-control" name="database_name" id="database_name" size="30" value="<?php echo $database_name; ?>" onFocus="textboxOnFocus('notes_db_name')" onBlur="textboxOnBlur('notes_db_name')" required/>
								<?php if(EI_MODE == "demo") echo "(demo: db_name)"; ?>
							</td>
						</tr>
						<tr><td colspan="2" nowrap height="9px"></td></tr>
						<tr>
							<td nowrap>&nbsp;<?php echo lang_key("database_username"); ?>: <span class="star">*</span></td>
							<td>
								<input type="text" class="form-control" name="database_username" id="database_username" size="30" value="<?php echo $database_username; ?>" onFocus="textboxOnFocus('notes_db_user')" onBlur="textboxOnBlur('notes_db_user')" required/>
								<?php if(EI_MODE == "demo") echo "(demo: test)"; ?>
							</td>
						</tr>
						<tr><td colspan="2" nowrap height="9px"></td></tr>
						<tr>
							<td nowrap>&nbsp;<?php echo lang_key("Database Password"); ?>:<span class="star">*</span></td>
							<td>
								<input type="password" class="form-control" name="database_password" id="database_password" size="30" value="<?php echo $database_password; ?>" autocomplete='off' onFocus="textboxOnFocus('notes_db_password')" onBlur="textboxOnBlur('notes_db_password')" required/>
								<?php if(EI_MODE == "demo") echo "(demo: test)"; ?>
							</td>
						</tr>
						<tr><td colspan="2" nowrap height="9px"></td></tr>
						<!--<tr>
							<td nowrap>&nbsp;<?php echo lang_key("database_prefix"); ?></td>
							<td>
								<input type="text" class="form-control" name="database_prefix" size="12" maxlength="12" value="<?php echo $database_prefix; ?>" onFocus="textboxOnFocus('notes_db_prefix')" onBlur="textboxOnBlur('notes_db_prefix')" />
							</td>
						</tr>-->
						<tr>
							<td nowrap>&nbsp;<?php echo lang_key("installation_type"); ?></td>
							<td>
								<?php if(EI_ALLOW_NEW_INSTALLATION && !$program_already_installed) { ?><input type="radio" name="install_type" id="rb_create" value="create" <?php echo ($install_type == "create") ? "checked" : ""; ?> onClick="installTypeOnClick(this.value)" /> <label for="rb_create"><?php echo lang_key("new"); ?></label> <?php } ?>
								<?php if(EI_ALLOW_UPDATE) { ?><input type="radio" name="install_type" id="rb_update" value="update" <?php echo (!$program_already_installed) ? "disabled" : ""; ?> <?php echo ($install_type == "update") ? "checked" : ""; ?> onClick="installTypeOnClick(this.value)" /> <label for="rb_update"><?php echo lang_key("update"); ?></label> <?php } ?>
								<?php if(EI_ALLOW_UN_INSTALLATION) { ?><input type="radio" name="install_type" id="rb_uninstall" value="un-install" <?php echo (!$program_already_installed) ? "disabled" : ""; ?> <?php echo ($install_type == "un-install") ? "checked" : ""; ?> onClick="installTypeOnClick(this.value)" /> <label for="rb_uninstall"><?php echo lang_key("uninstall"); ?></label> <?php } ?>						
							</td>
						</tr>
						<tr><td colspan="2" nowrap height="9px"></td></tr>
						<tr>
							<td>&nbsp;</td>
							<td>								
								<button type="button" class="btn btn-default" onClick="testDatabaseConnection()"><?php echo lang_key("test_database_connection"); ?></button>
							</td>
						</tr>						

						<?php if(EI_USE_USERNAME_AND_PASWORD){ ?>
						<tr><td colspan="3">&nbsp;</td></tr>
						<tr id="line_admin_info"><td class=text align=left><b><?php echo lang_key("admin_access_data"); ?></b></td><td colspan="2"><?php echo lang_key("admin_access_data_descr"); ?></td></tr>
						<tr><td colspan="2" nowrap height="9px"></td></tr>
						<tr id="line_admin_login">
							<td>&nbsp;<?php echo lang_key("admin_login"); ?>&nbsp;<span class="star">*</span></td>
							<td class="text"><input name="username" class="form-control" size="28" maxlength="22" value="" onFocus="textboxOnFocus('notes_admin_username')" onBlur="textboxOnBlur('notes_admin_username')" autocomplete='off' required/> <?php if(EI_MODE == "demo") echo "(demo: test)"; ?></td>
						</tr>
						<tr><td colspan="2" nowrap height="9px"></td></tr>
						<tr id="line_admin_password">
							<td>&nbsp;<?php echo lang_key("admin_password"); ?>&nbsp;<span class="star">*</span></td>
							<td class="text"><input name="password" class="form-control" type="text" size="28" maxlength="22" value="" onFocus="textboxOnFocus('notes_admin_password')" onBlur="textboxOnBlur('notes_admin_password')" autocomplete='off' required/> <?php if(EI_MODE == "demo") echo "(demo: test)"; ?></td>
						</tr>
						<tr><td colspan="2" nowrap height="9px"></td></tr>
							<?php if(EI_USE_PASSWORD_ENCRYPTION){ ?>
							<tr id="line_password_encryption">
								<td>&nbsp;<?php echo lang_key("password_encryption"); ?>&nbsp;</td>
								<td class="text">
									<select class="form-control" name="password_encryption">
									<option <?php echo (($password_encryption == "AES") ? "selected" : ""); ?> value="AES">AES</option>
									<option <?php echo (($password_encryption == "MD5") ? "selected" : ""); ?> value="MD5">MD5</option>
									</select>
								</td>
							</tr>							
							<?php } ?>
						<?php } ?>
						<tr><td colspan="2" nowrap height="20px">&nbsp;</td></tr>
						<tr>
							<td colspan="2" align='left'>								
								<button type="button" class="btn btn-default" onclick="window.history.go(-1); return false;">Cancel</button>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<button type="submit" class="btn btn-default" name="btn_submit" id="button_continue">Continue</button>
							</td>
						</tr>                        
                        </table>
                        </form>                        
						<br />
					</td>
                    <td width="230px" align="left" valign="top" style="padding-top:30px; margin-left: 50px;" class="bg-info">								
						<div id='notes_host'>
							<h4><?php echo lang_key("database_host"); ?></h4>
							<p><?php echo lang_key("database_host_info"); ?></p>
						</div>						
						<div id='notes_db_name'>
							<h4><?php echo lang_key("database_name"); ?></h4>
							<p><?php echo lang_key("database_name_info"); ?></p>
						</div>
						<div id='notes_db_user'>
							<h4><?php echo lang_key("database_username"); ?></h4>
							<p><?php echo lang_key("database_username_info"); ?></p>
						</div>
						<div id='notes_db_password'>
							<h4><?php echo lang_key("database_password"); ?></h4>
							<p><?php echo lang_key("database_password_info"); ?></p>
						</div>
						<div id='notes_db_prefix'>
							<h4><?php echo lang_key("database_prefix"); ?></h4>
							<p><?php echo lang_key("database_prefix_info"); ?></p>
						</div>
						<div id='notes_admin_username'>
							<h4><?php echo lang_key("admin_login"); ?></h4>
							<p><?php echo lang_key("admin_login_info"); ?></p>
						</div>
						<div id='notes_admin_password'>
							<h4><?php echo lang_key("admin_password"); ?></h4>
							<p><?php echo lang_key("admin_password_info"); ?></p>
						</div>
						<img class="loading_img" src="img/ajax_loading.gif" alt="<?php echo lang_key("loading"); ?>..." />
						<div id='notes_message'></div>
					</td>
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
        <?php include_once("footer.php"); ?>        
    </td>
</tr>
</tbody>
</table>
</div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> 
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>   
<script type="text/javascript" src="js/main.js"></script> 
<script type='text/javascript'>
	function bodyOnLoad(){
		setFocus('<?php echo $focus_field; ?>');
		installTypeOnClick($("input[@name='install_type']:checked").val());
	}	
</script>
</body>
</html>