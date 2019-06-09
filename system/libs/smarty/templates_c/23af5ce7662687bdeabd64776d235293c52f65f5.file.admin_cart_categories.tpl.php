<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 13:40:36
         compiled from "system/app/plugins/cart/views/admin_cart_categories.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20061128385cf828c4505556-24409721%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23af5ce7662687bdeabd64776d235293c52f65f5' => 
    array (
      0 => 'system/app/plugins/cart/views/admin_cart_categories.tpl',
      1 => 1503704994,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20061128385cf828c4505556-24409721',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('views/admin/header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('views/admin/menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<!-- Main Wrapper -->
<div id="wrapper">
<div class="normalheader transition animated fadeIn">
   <div class="hpanel">
      <div class="panel-body">
         <a class="small-header-action" href="">
            <div class="clip-header">
               <i class="fa fa-arrow-up"></i>
            </div>
         </a>  
         <h2 class="font-light m-b-xs">
            Store Manager
         </h2>
         <small>Manage your MLM Store</small>
      </div>
   </div>
</div>
<div class="row">
   <div class="normalheader transition animated fadeIn">
      <div class="hpanel">
         <div class="panel-body">
            <a class="small-header-action" href="">
               <div class="clip-header">
                  <i class="fa fa-arrow-up"></i>
               </div>
            </a>
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
            <div class="main pagesize" id="iframed">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           	<iframe src="/system/app/plugins/cart/admin/<?php echo $_REQUEST['page'];?>
.php" id="iframe1" width="0px" height="0px" marginheight="0" frameborder="0" onLoad="autoResize('iframe1');"></iframe>                           
                        </div>
                     </div>
                     <!-- end of box-wrap -->
                  </div>
                  <!-- end of box-body -->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END -->       
<!-- Vendor scrits -->
<?php $_template = new Smarty_Internal_Template('views/admin/footer_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?> 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
   
   });
</script>

<script language="JavaScript">
<!--
function autoResize(id){
    var newheight;
    var newwidth;
	
	iframed = $('#iframed').width();
	document.getElementById(id).width = (iframed-105) + "px";
    newheight = document.getElementById(id).contentWindow.document.body.scrollHeight;       
    document.getElementById(id).height = (newheight+100) + "px";
	scroll(0,0);
    
}
//-->
</script>
<?php $_template = new Smarty_Internal_Template('views/admin/footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>