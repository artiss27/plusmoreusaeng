<?php /* Smarty version Smarty-3.0.8, created on 2019-06-06 18:29:47
         compiled from "system/app/views/members/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5588738275cf9be0b565272-73331505%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '15fd76301aea7faf430985748b3bf1d3fb0f36ee' => 
    array (
      0 => 'system/app/views/members/login.tpl',
      1 => 1546079627,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5588738275cf9be0b565272-73331505',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Acceder/Login</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="/assets/common/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="/assets/common/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="/assets/common/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="/assets/common/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="/assets/common/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="/assets/common/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="/assets/common/styles/style.css">
	<style>
		body #canvas-wrapper {
		  position: fixed;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  width: 100%;
		  height: 100%;
		}
		body {
		  overflow: hidden;
		  background: url("/assets/common/images/1.jpg") no-repeat top center #2d494d;
		}
		h2, h4, small {
				color: white;
		}
	</style>

</head>
<body class="blank">

<div class="color-line"></div>

<div class="login-container">
		<!-- begin canvas animation bg -->
        <div id="canvas-wrapper">
			<canvas id="demo-canvas"></canvas>
        </div>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
				<a href="http://myplusmoreusa.com/mypmu"><img src="/media/images/PMUhighlighted.png" alt="PlusMoreUsa" style="width:135px;height:90px;"></a>
                
            </div>
            <div class="hpanel">
                <div class="panel-body">
                <?php if ($_SESSION['message']){?>
               <p class="alert alert-success">
                  <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('message'), null, null);?>
                  <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

               </p>
               <br />
               <?php }?> 
               <?php if ($_SESSION['error']){?>
               <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('error'), null, null);?>            	
               <?php if (is_array($_smarty_tpl->getVariable('message_var')->value)){?>
               <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('message_var')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
               <p class="alert alert-danger">
                  <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

               </p>
               <br />
               <?php }} ?> 
               <?php }else{ ?>
               <p class="alert alert-danger">
                  <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

               </p>
               <br />
               <?php }?>
               <?php }?> 
                        <form action="" method="post">
                            <div class="form-group"><center><font size="5" color="#6a6c6f"><u>Entrada BackOffice Virtual</u></font><br><font size="3" color="#6a6c6f">Virtual BackOffice Entrance</font></center><br><br>
                                <label class="control-label" for="username"><font size="3">Usuario*</font><br>User Name*</label>
                                <input type="text" title="Por Favor Entrar Usuario/Please enter you username" required value="<?php if (@DEMO==1){?>demo<?php }?>" name="username" id="user" class="form-control">                                
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password"><font size="3">Contrase&ntilde;a*</font><br>Password*</label>
                                <input type="password" title="Favor entrar contrase&ntilde;a correcta / Please enter your password" required value="<?php if (@DEMO==1){?>demo<?php }?>" name="password" id="password" class="form-control">                              
                            </div>
                            
                            <button class="btn btn-success btn-block"><font size="3">Entrar </font>/ Enter</button>
                        </form>
                        <a id="forgot" href="/members/forgotpassword">Contrase&ntilde;a/Password?</a><br><a href="/signup">Registrate/Sign Up<a>
						<?php if (@DEMO==1){?><br><br>Demo is reseted every 20 minutes<?php }?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
        </div>
    </div>
</div>


<!-- Vendor scripts -->
<script src="/assets/common/vendor/jquery/dist/jquery.min.js"></script>
<script src="/assets/common/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/common/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/assets/common/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets/common/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="/assets/common/vendor/iCheck/icheck.min.js"></script>
<script src="/assets/common/vendor/sparkline/index.js"></script>
<script type="text/javascript" src="/assets/common/vendor/login/EasePack.min.js"></script>
<script type="text/javascript" src="/assets/common/vendor/login/rAF.js"></script>
<script type="text/javascript" src="/assets/common/vendor/login/TweenLite.min.js"></script>
<script type="text/javascript" src="/assets/common/vendor/login/login.js"></script>

<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>

<!-- Page Javascript -->
    <script type="text/javascript">
        jQuery(document).ready(function() {

            // Init CanvasBG and pass target starting location
            CanvasBG.init({
                Loc: {
                    x: window.innerWidth / 2,
                    y: window.innerHeight / 3.3
                },
            });


        });
    </script>

</body>
</html>