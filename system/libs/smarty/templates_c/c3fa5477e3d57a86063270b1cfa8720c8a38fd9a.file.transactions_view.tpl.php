<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 14:09:25
         compiled from "system/app/views/admin/transactions_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11289163335cf82f850d01b9-20142013%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c3fa5477e3d57a86063270b1cfa8720c8a38fd9a' => 
    array (
      0 => 'system/app/views/admin/transactions_view.tpl',
      1 => 1503704417,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11289163335cf82f850d01b9-20142013',
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
<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
<div class="alert alert-danger m-t">
   <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
   <p><strong><?php echo $_smarty_tpl->tpl_vars['error']->key;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
</div>
<?php }} ?>   
<div class="content animate-panel">
   <div class="row">
      <div class="col-lg-12">
         <div class="hpanel">
            <div class="panel-heading">
               <div class="panel-tools">
                  <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  <a class="closebox"><i class="fa fa-times"></i></a>
               </div>
               Transaction Results
            </div>
            <div class="panel-body">
               <div class="actions">
                  <form id="form1" name="form1" method="post" action="">
                     <br />
                     <div class="form-group">
                        <label for="select" class="col-sm-2 control-label">Wallet Type</label>
                        <select name="type" id="select" class="form-control" onChange='this.form.submit();' >
                           <option value="deposit" <?php if ($_REQUEST['type']=="deposit"||$_REQUEST['type']==''){?>selected<?php }?>>Desposit Wallet</option>
                           <option value="payout" <?php if ($_REQUEST['type']=="payout"){?>selected<?php }?>>Payout Wallet</option>
                        </select>
                     </div>
                     <?php echo $_smarty_tpl->getVariable('filter')->value;?>
 <span style="margin-left:4px;"><input type='submit' class="button small" value=" Apply "></span><input type='hidden' name='filter' value=1><input type='hidden' name='transaction_id' value='<?php echo $_smarty_tpl->getVariable('traid')->value;?>
'>
                  </form>
               </div>
               <table id="transaction" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                     	<th>ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Description</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>                
                     <tr>
                     	<td><?php if ($_smarty_tpl->tpl_vars['name']->value['id']){?><?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['name']->value['transaction_id']){?><?php echo $_smarty_tpl->tpl_vars['name']->value['transaction_id'];?>
<?php }?></td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['date'];?>
</td>
                        <td>$<?php echo $_smarty_tpl->tpl_vars['name']->value['amount'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['from'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['to'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['description'];?>
</td>
                     </tr>
                     <?php }} ?>	
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $_template = new Smarty_Internal_Template('footer_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('footer_datatable.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>