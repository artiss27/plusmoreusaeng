<?php /* Smarty version Smarty-3.0.8, created on 2019-06-06 11:00:53
         compiled from "system/app/views/members/forgotpassword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6397110275cf954d558dc44-63387637%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a088421b0677f660d44b9ed4d492a9a82f29c2e' => 
    array (
      0 => 'system/app/views/members/forgotpassword.tpl',
      1 => 1503704422,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6397110275cf954d558dc44-63387637',
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
      <title><?php echo $_smarty_tpl->getVariable('lang')->value['forgot_password'];?>
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
   </head>
   <body class="blank">
      <div class="color-line"></div>
      <div class="login-container">
         <div class="row">
            <div class="col-md-12">
               <div class="text-center m-b-md">
                  <h3><?php echo $_smarty_tpl->getVariable('lang')->value['forgot_password'];?>
</h3>
              
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
                        <dl>
                           <dt>
                              <label for="username"><?php echo $_smarty_tpl->getVariable('lang')->value['email_address'];?>
</label>
                           </dt>
                           <dd><input name="email" type="text" id="email" size="40" class="form-control" /></dd>
                           <dt>&nbsp;</dt>
                        </dl>
                        <p>
                           <button type="submit" name="forgot" value="send" class="btn btn-success btn-block" id="loginbtn"><?php echo $_smarty_tpl->getVariable('lang')->value['send'];?>
</button>
                        </p>
                     </form>
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
      <!-- App scripts -->
      <script src="/assets/common/scripts/homer.js"></script>
   </body>
</html>