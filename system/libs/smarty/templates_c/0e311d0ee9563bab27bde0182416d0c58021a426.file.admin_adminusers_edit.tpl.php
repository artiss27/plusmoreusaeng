<?php /* Smarty version Smarty-3.0.8, created on 2019-06-04 00:03:27
         compiled from "system/app/plugins/adminusers/views/admin_adminusers_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9551191495cf617bf296c30-86003284%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e311d0ee9563bab27bde0182416d0c58021a426' => 
    array (
      0 => 'system/app/plugins/adminusers/views/admin_adminusers_edit.tpl',
      1 => 1503704810,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9551191495cf617bf296c30-86003284',
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
           Edit admin user
         </h2>
         <small>Edit admin user</small>
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
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                       		<form id="admin_form" action="" method="post" class="form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <h2>Edit Admin User</h2>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Username:</label>
                                          <input name="username" type="text" id="textfield" value="<?php echo $_smarty_tpl->getVariable('user')->value['username'];?>
" size="5" class="form-control validate[required]"  />
                                       </div>
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Email:</label>
                                          <input name="email" type="text" id="textfield" value="<?php echo $_smarty_tpl->getVariable('user')->value['email'];?>
" size="5" class="form-control validate[required,custom[email]]"  />
                                       </div>
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Password:</label>
                                          <input name="password" type="text" id="textfield" placeholder="change password" size="5" class="form-control"  />
                                       </div>
                                       <br /><br />
                                       <h3>Allowed Areas On Admin Panel</h3>
                                       <br />
                                       <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_SESSION['available_roles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                                       <div class="form-field clear">
                                          <label for="textfield" class="fl-space size-300"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
 :</label> 
                                          <input name="roles[]" type="checkbox" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['obj']->value;?>
" <?php if ($_smarty_tpl->getVariable('user')->value['roles'][$_smarty_tpl->getVariable('obj')->value]==1){?>checked<?php }?> />
                                       </div>
                                       <?php }} ?>
                                       <div class="form-field clear"></div>
                                    </div>
                                 </div>
                                 <br>
                                 <div class="form-field clear">
                                    <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>
" />                                    
                                    <button type="submit" class="btn btn-primary">Edit Admin User</button> 
                                 </div>
                                 <!-- /.form-field -->																								
                              </form>  
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
   	<?php if ($_smarty_tpl->getVariable('log')->value){?>$('#log').dataTable();<?php }?>  
   }); 
});
</script>
<?php $_template = new Smarty_Internal_Template('views/admin/footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
