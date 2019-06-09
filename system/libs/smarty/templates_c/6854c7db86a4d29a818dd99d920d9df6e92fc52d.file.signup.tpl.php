<?php /* Smarty version Smarty-3.0.8, created on 2019-06-06 13:01:05
         compiled from "system/app/views/members/signup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12659306945cf97101713108-84713631%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6854c7db86a4d29a818dd99d920d9df6e92fc52d' => 
    array (
      0 => 'system/app/views/members/signup.tpl',
      1 => 1545999711,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12659306945cf97101713108-84713631',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/hermes/walnaweb10a/b1543/pow.plusmoreusaengcom/htdocs/system/libs/smarty/plugins/modifier.replace.php';
?><!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title><?php echo $_smarty_tpl->getVariable('lang')->value['registration'];?>
</title>

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
		  /*overflow: hidden;*/
		  background: url("/assets/common/images/1.jpg") no-repeat top center #2d494d;
		}
		h1, h3, small {
				color: white;
		}
		.login-container {
			max-width: 700px;
			margin: auto;
			padding-top: 6%;
		}
	</style>

</head>
<body class="blank">

<div class="color-line"></div>
<!-- begin canvas animation bg -->
        <div id="canvas-wrapper">
			<canvas id="demo-canvas"></canvas>
        </div>
<div class="login-container">
	
    <div class="row">
        <div class="col-md-12"><a href="/members" class="btn btn-primary"><font size="4">Accede Tu Cuenta</font><br>Access Your Account</a><br>
            <div class="text-center m-b-md">
				
				<br><br>
<img src="/media/images/PMUhighlighted.png" alt="PlusMoreUsa" style="width:135px;height:90px;">                

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
               <?php if ($_smarty_tpl->getVariable('errors')->value){?>
                  <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
                  <p class="alert alert-danger">
                     <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

                  </p>
                  <?php }} ?>
               <?php }?>
                        <form action="" method="post"> 

 <div class="form-group"> <center><font size="6" color="#6a6c6f">Formulario de Registracion</font><br><font size="5" color="#6a6c6f">Sign Up Form</font><br><br><input type="checkbox" name="agree" required value="1" class="form-control">
                                <label class="control-label"><font size="3">Por favor marcar le cuadro para aceptar los<a class="link_left" href="/site/membresia-terminos/" target="_blank"> Terminos De La Membresia.*</a></font><br><font size="2">Please click the box to accept the <a class="link_left" href="/site/terms/" target="_blank"> Membership Terms.*</a></font></label> </center><br>          
                                                    
                            </div>


                            <div class="form-group">
                                <label class="control-label" for="username"><font size="3">Invited By*</font><br><font size="2">Invitado Por*</font></label>
                                <input type="text" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['your_sponsor_username'];?>
" <?php if ($_smarty_tpl->getVariable('hooks')->value->apply_filters('get_setting','signup_sponsor_required')=='yes'){?>required<?php }?> value="<?php if (isset($_SESSION['signup']['sponsor'])){?><?php echo $_SESSION['signup']['sponsor'];?>
<?php }else{ ?><?php echo $_SESSION['enroller'];?>
<?php }?>" name="sponsor" class="form-control" >                                
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">First Name*</font><br>Primer Nombre*</label>
                                <input type="text" placeholder="" required name="firstName" id="firstname" value="<?php echo $_SESSION['signup']['firstName'];?>
" class="form-control" />                       
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">Last Name*</font><br>Apellido*</label>
                                <input type="text" placeholder="" required name="lastName" id="lastname" value="<?php echo $_SESSION['signup']['lastName'];?>
" class="form-control" />                       
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">Gender*</font><br>G&eacutenero*</label>
                                 <select name="gender" id="gender" class="form-control">
                                 <option value="0">Select One / Escoge Uno</option>
                                 <option value="1" <?php if ($_SESSION['signup']['gender']==1){?>selected="selected"<?php }?>>Male/Masculino</option>
                                 <option value="2" <?php if ($_SESSION['signup']['gender']==2){?>selected="selected"<?php }?>>Female/Femenino</option>
                              </select>                       
                            </div>
                            
                    <!--  <div class="form-group">
                                <label class="control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['skype'];?>
</label>
                                <input type="text" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['skype'];?>
" name="skype" id="skype" value="<?php echo $_SESSION['signup']['skype'];?>
" class="form-control" />                     
                            </div>-->
                            <div class="form-group">
                                <label class="control-label"><font size="3">Cellphone Number*<br><font size="2">No. De Mobil*</font></label>
                            <input type="text" placeholder="" name="phone" id="phone" value="<?php echo $_SESSION['signup']['phone'];?>
" class="form-control" />                       
                            </div>
                            <div class="form-group">
                                <label class="control-label"><font size="3">Email*<br><font size="2">Correo Electronico*</font></label>
                                <input type="text" placeholder="" required name="email" id="email" value="<?php echo $_SESSION['signup']['email'];?>
" class="form-control" />                         
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">Create Member ID*<br><font size="2">Crear ID de Miembro</font></label>
                                <input type="text" placeholder="" required name="username" id="username" value="<?php echo $_SESSION['signup']['username'];?>
" class="form-control" />                         
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">Create Password*<br><font size="2">Crear Contrase&ntilde;a*</font></label>
                                <input type="password" placeholder="" required name="password" id="password" value="" class="form-control" />                         
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">Confirm Password*<br><font size="2">Confirmar Contrase&ntilde;a*</font></label>
                                <input type="password" placeholder="" required name="password2" id="password2" value="" class="form-control" />                         
                            </div>
                            
                  <!--<label class="control-label"><font size="3"> Select your membership*</font><br>Selecciona tu membresia*</label>
                            	<div class="form-group">
                              <label for="username"><?php echo $_smarty_tpl->getVariable('lang')->value['membership'];?>
: </label> 
                                    <select name="membership" id="select" class="form-control">
                                    <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('memberships')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>            
                                        <?php ob_start(); ?><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
_signup_fee<?php  $_smarty_tpl->assign('comm', ob_get_contents()); Smarty::$_smarty_vars['capture']['default']=ob_get_clean();?>    
                                       						
                                        	<option value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
">            
                                        		<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['name']->value,"_"," ");?>
 ($<?php echo sprintf("%.2f",$_smarty_tpl->getVariable('settings')->value[$_smarty_tpl->getVariable('comm')->value]);?>
)          
                                        	</option>
                                      
                                    <?php }} ?>
                                    </select>
                                
                                </div>-->
                        
                            
                           
                            
                            <button class="btn btn-success btn-block"><font size="3">Sign Up<br><font size="2">Registrate</font></button>
                        </form><p> <center><font size="3">Please check your email for account confimation.<br><font size="2">Entra a tu correo electronico para verificar tu cuenta. </font></center>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center"><br><br><br><br><br><br><br><br><br>
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