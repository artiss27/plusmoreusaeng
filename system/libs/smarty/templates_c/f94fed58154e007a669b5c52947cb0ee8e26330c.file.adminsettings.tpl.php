<?php /* Smarty version Smarty-3.0.8, created on 2019-06-06 13:19:20
         compiled from "system/app/views/admin/adminsettings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13028094745cf975482e8c52-55959070%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f94fed58154e007a669b5c52947cb0ee8e26330c' => 
    array (
      0 => 'system/app/views/admin/adminsettings.tpl',
      1 => 1503704412,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13028094745cf975482e8c52-55959070',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<div id="wrapper">
<div class="content animate-panel">
   <div class="row">
      <div class="normalheader transition animated fadeIn">
         <div class="hpanel">
            <div class="panel-body">
               <a class="small-header-action" href="">
                  <div class="clip-header">
                     <i class="fa fa-arrow-up"></i>
                  </div>
               </a>
               <div id="hbreadcrumb" class="pull-right m-t-lg">
                  <ol class="hbreadcrumb breadcrumb">
                  </ol>
               </div>
               <?php if ($_smarty_tpl->getVariable('settings_saved')->value=='y'){?>
               <div class="alert alert-success">
                  <p><strong>Admin Settings Saved:</strong> Your Admin settings were saved succesfully on database.</p>
               </div>
               <?php }?>  
               <?php if ($_smarty_tpl->getVariable('error_current_password')->value=='1'){?>
               <div class="alert alert-danger">
                  <p><strong>Error notification:</strong> Current password didn't match the one on database, try again.</p>
               </div>
               <?php }?>
               <?php if ($_smarty_tpl->getVariable('error_new_password')->value=='1'){?>
               <div class="alert alert-danger">
                  <p><strong>Couldn't save new password:</strong> New password is not matching the confirmation password, try again.</p>
               </div>
               <?php }?>
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
               <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
               <div class="alert alert-danger">
                  <p><strong><?php echo $_smarty_tpl->tpl_vars['error']->key;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
               </div>
               <?php }} ?>  <br />
               <h2 class="font-light m-b-xs">
                  Admin Settings
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <form action="#" method="post" class="validate-form form bt-space15"  autocomplete="off">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Admin Login: <span class="required">*</span></label>
                                          <input name="adminuser" type="text" class="required text form-control" id="textfield" size="35" value="<?php echo $_smarty_tpl->getVariable('admin_username')->value;?>
" />
                                       </div>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield2" class="form-label size-120 fl-space2">New  Password: </label>
                                          <input name="newadminpassword" type="password" class="text form-control" id="textfield2" size="35" value=""  />
                                       </div>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield2" class="form-label size-120 fl-space2">Confirm Password: </label>
                                          <input name="confirmadminpassword" type="password" class="text form-control" id="textfield3" size="35" value=""  />
                                       </div>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Contact E-Mail: <span class="required">*</span></label>
                                          <input name="admin_email" type="text" class="required text form-control" id="textfield4" size="35" value='<?php echo $_smarty_tpl->getVariable('settings')->value['admin_email'];?>
' />
                                       </div>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Inactivity Logout: </label>
                                          <select id="select" class="form-control required" name="admin_inactivity">
                                          <option value="5" <?php if ($_smarty_tpl->getVariable('settings')->value['admin_inactivity']=='5'){?>selected="selected"<?php }?>>5 minutes</option>
                                          <option value="15" <?php if ($_smarty_tpl->getVariable('settings')->value['admin_inactivity']=='15'){?>selected="selected"<?php }?>>15 minutes</option>
                                          <option value="30" <?php if ($_smarty_tpl->getVariable('settings')->value['admin_inactivity']=='30'){?>selected="selected"<?php }?>>30 minutes</option>
                                          <option value="60" <?php if ($_smarty_tpl->getVariable('settings')->value['admin_inactivity']=='60'){?>selected="selected"<?php }?>>60 minutes</option>
                                          </select>
                                       </div>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Current  Password: <span class="required">*</span></label>
                                          <input name="currentadminpassword" type="password" class="required text form-control" id="textfield5" size="35"  />
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-field clear">
                                    <br /><br />
                                    <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
                                 </div>
                                 <!-- /.form-field -->																								
                              </form>
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
   </div>
</div>
<?php $_template = new Smarty_Internal_Template('footer_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
