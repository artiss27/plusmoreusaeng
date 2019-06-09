<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 07:06:52
         compiled from "system/app/views/admin/transactions_id.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3379786205cf7cc7c307e87-69788390%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '738a1e18ef656a0b891fc0e3f1c55da69481168c' => 
    array (
      0 => 'system/app/views/admin/transactions_id.tpl',
      1 => 1503704417,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3379786205cf7cc7c307e87-69788390',
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
<div class="alert alert-success">
   
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
               Transaction for <?php echo $_REQUEST['type'];?>
 wallet
            </div>
            <div class="panel-body">
               <div class="actions">
                  <form id="form1" name="form1" method="post" action=""><?php echo $_smarty_tpl->getVariable('filter')->value;?>
 <span style="margin-left:4px;"><input type='submit' class="button small" value=" Apply "></span>
                  <input type='hidden' name='filter' value=1>
                  <input type='hidden' name='member_id' value='<?php echo $_smarty_tpl->getVariable('traid')->value;?>
'>
                  <input type='hidden' name='type' value='<?php echo $_REQUEST['type'];?>
'>
                  </form>
               </div>
               <table id="transaction" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
	                     <th>ID</th>
                        <th>Date</th>
                        <th>Amount</th>
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
                     	<td><?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['date'];?>
</td>
                        <td>$<?php echo $_smarty_tpl->tpl_vars['name']->value['amount'];?>
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