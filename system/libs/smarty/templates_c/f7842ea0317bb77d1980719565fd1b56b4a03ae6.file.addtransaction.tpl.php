<?php /* Smarty version Smarty-3.0.8, created on 2019-06-07 10:56:45
         compiled from "system/app/views/admin/addtransaction.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4338922905cfaa55df384d0-52679029%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f7842ea0317bb77d1980719565fd1b56b4a03ae6' => 
    array (
      0 => 'system/app/views/admin/addtransaction.tpl',
      1 => 1547142048,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4338922905cfaa55df384d0-52679029',
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
               <div class="alert alert-success">
                  
                  <p><strong><?php echo $_smarty_tpl->tpl_vars['error']->key;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
               </div>
               <?php }} ?>  
               <h2 class="font-light m-b-xs">
                  Add Transaction
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <div class="columns clear bt-space15">
                                 <div class="col2-3">
                                    <form action="#" method="POST" name="form1" id="form1">
                                       <br />
                                       <div class="form-group">
                                          <label for="select" class="col-sm-2 control-label">Wallet Type</label>
                                          <select name="type" id="select" class="form-control">
                                             <option value="deposit">Deposit Wallet</option>
                                             <option value="payout">Payout Wallet</option>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label for="textfield" class="col-sm-2 control-label">Member ID:</label>
                                             <select name="member_id" id="select3" class="form-control">
                                                <?php  $_smarty_tpl->tpl_vars['username'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['ob'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('members12')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['username']->key => $_smarty_tpl->tpl_vars['username']->value){
 $_smarty_tpl->tpl_vars['ob']->value = $_smarty_tpl->tpl_vars['username']->key;
?> 
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['username']->value['member_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['username']->value['username'];?>
</option>
                                                <?php }} ?>  
                                             </select>
                                       </div>
                                       <div class="form-group">
                                          <label for="textfield" class="col-sm-2 control-label">Amount: ($)</label>
                                          <input name="amount" type="text" class="form-control" id="textfield" size="10" value='' />
                                          <small>Positive will add, Negative will substract.</small>
                                       </div>
                                       <div class="form-group">
                                          <label for="textfield" class="col-sm-2 control-label">Description:</label>
                                          <input name="description" type="text" class="form-control" id="textfield" size="50" value='' />
                                       </div>
                                       
                                       <div class="form-group">
                                          <label for="textfield" class="col-sm-2 control-label">service ID:</label>
                                             <select name="service_id" id="select4" class="form-control">
                                                <option value="no">No Service Selected</option>
                                                
                                                <?php  $_smarty_tpl->tpl_vars['username'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['ob'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products12')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['username']->key => $_smarty_tpl->tpl_vars['username']->value){
 $_smarty_tpl->tpl_vars['ob']->value = $_smarty_tpl->tpl_vars['username']->key;
?> 
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['username']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['username']->value['name'];?>
 (<?php echo $_smarty_tpl->tpl_vars['username']->value['price'];?>
$)</option>
                                                <?php }} ?>  
                                             </select>
                                       </div>
                                       <button type="button" class="btn btn-primary m-t" onclick='this.form.submit();'>Save changes</button>
                                    </form>
                                 </div>
                              </div>
                              <!-- /.form-field -->	
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
