<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 10:37:54
         compiled from "system/app/plugins/adminusers/views/admin_adminusers.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6747838985cf7fdf290f388-36042541%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c1473ca67e01197df7d6d2ce5742e4dde3798b0b' => 
    array (
      0 => 'system/app/plugins/adminusers/views/admin_adminusers.tpl',
      1 => 1503704810,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6747838985cf7fdf290f388-36042541',
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
            Admin Users
         </h2>
         <small>Admin Users</small>
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
                           <button id="create">Add new Admin User</button>
                           <div id="form" style="display: none">
                              <br />
                              <form id="admin_form" action="" method="post" class="form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <h2>Add new Admin User</h2>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Username:</label>
                                          <input name="username" type="text" id="textfield" placeholder="username" size="5" class="form-control validate[required]"  />
                                       </div>
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Email:</label>
                                          <input name="email" type="text" id="textfield" placeholder="email" size="5" class="form-control validate[required,custom[email]]"  />
                                       </div>
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Password:</label>
                                          <input name="password" type="text" id="textfield" placeholder="password" size="5" class="form-control validate[required]"  />
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
" />
                                       </div>
                                       <?php }} ?>
                                       <div class="form-field clear"></div>
                                    </div>
                                 </div>
                                 <br>
                                 <div class="form-field clear">
                                    <input type="hidden" class="button red fr" name="bnsubmit" value="Save" />
                                    <button type="submit" class="btn btn-primary">Create Admin User</button> 
                                 </div>
                                 <!-- /.form-field -->																								
                              </form>                             
                              
                           </div>
                           <br /><br /> 
                           <h3>Admin Users</h3>
                              <table id="adminusers" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th>ID</th>
                                       <th>Username</th>
                                       <th>Email</th>
                                       <th>Roles</th>
                                       <th>Last Ip</th>
                                       <th>Last Login</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if (!$_smarty_tpl->getVariable('adminusers')->value){?>
                                    <tr>
                                       <td colspan="6">No Results Found</td>
                                    </tr>
                                    <?php }else{ ?>
                                    <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('adminusers')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['row']->key;
?>  
                                    <tr>
                                       <td><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
                                       <td><?php echo $_smarty_tpl->tpl_vars['row']->value['username'];?>
</td>
                                       <td><?php if ($_smarty_tpl->tpl_vars['row']->value['id']==1){?>-<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
<?php }?></td>
                                       <td><?php if ($_smarty_tpl->tpl_vars['row']->value['id']==1){?>Super Admin<?php }else{ ?><?php echo $_smarty_tpl->getVariable('adminmodel')->value->getRoles($_smarty_tpl->tpl_vars['row']->value['username']);?>
<?php }?></td>
                                       <td><?php echo $_smarty_tpl->getVariable('adminmodel')->value->getLastIp($_smarty_tpl->tpl_vars['row']->value['username']);?>
</td>
                                       <td><?php echo $_smarty_tpl->getVariable('adminmodel')->value->getLastDate($_smarty_tpl->tpl_vars['row']->value['username']);?>
</td>
                                       <td><?php if ($_smarty_tpl->tpl_vars['row']->value['id']!=1){?><a href="/plugins/adminusers/admin/edituser/&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">edit</a><?php }else{ ?>-<?php }?></td>
                                    </tr>
                                    <?php }} ?>   	
                                    <?php }?>							
                                 </tbody>
                              </table>
                              
                              <br /><br />
                              <h3>Log</h3>
                              <table id="log" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th>ID</th>
                                       <th>Username</th>
                                       <th>IP</th>
                                       <th>Description</th>
                                       <th>Date</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if (!$_smarty_tpl->getVariable('log')->value){?>
                                    <tr>
                                       <td colspan="5">No Results Found</td>
                                    </tr>
                                    <?php }else{ ?>
                                    <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('log')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['row']->key;
?>  
                                    <tr>
                                       <td><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
                                       <td><?php echo $_smarty_tpl->tpl_vars['row']->value['admin_username'];?>
</td>
                                       <td><?php echo $_smarty_tpl->tpl_vars['row']->value['ip_address'];?>
</td>
                                       <td><?php echo $_smarty_tpl->tpl_vars['row']->value['description'];?>
</td>
                                       <td><?php echo $_smarty_tpl->tpl_vars['row']->value['date'];?>
</td>
                                    </tr>
                                    <?php }} ?>   	
                                    <?php }?>							
                                 </tbody>
                              </table>
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
   		$("#create").click(function() {
   			$("#form").toggle();
   		});
		$("#admin_form").validationEngine();
		<?php if ($_smarty_tpl->getVariable('log')->value){?>$('#log').dataTable({
        	"order": [[ 1, "desc" ]]
    	});<?php }?>  
   });
</script>
<?php $_template = new Smarty_Internal_Template('views/admin/footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>