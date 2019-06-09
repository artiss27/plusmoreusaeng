<?php /* Smarty version Smarty-3.0.8, created on 2019-06-04 21:31:04
         compiled from "system/app/views/admin/withdrawals.tpl" */ ?>
<?php /*%%SmartyHeaderCode:993294095cf7458890f528-77065848%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3da8d4ba3fd64fc590b72dce87acfc24521302e6' => 
    array (
      0 => 'system/app/views/admin/withdrawals.tpl',
      1 => 1503704418,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '993294095cf7458890f528-77065848',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_math')) include '/hermes/walnaweb10a/b1543/pow.plusmoreusaengcom/htdocs/system/libs/smarty/plugins/function.math.php';
?>﻿<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<div id="wrapper">
<!--<div class="normalheader transition animated fadeIn">
   <div class="hpanel">
      <div class="panel-body">
         <a class="small-header-action" href="">
            <div class="clip-header">
               <i class="fa fa-arrow-up"></i>
            </div>
         </a>
     
   
      </div>
   </div>
   </div>
   -->

<div class="content animate-panel">
   <div class="row">
      <div class="col-lg-12">
         <div class="hpanel">
            <div class="panel-heading">
               <div class="panel-tools">               
                  <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  <a class="closebox"><i class="fa fa-times"></i></a>
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
                    <p class="alert alert-danger">
                       <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

                    </p>
                    <br />
                    <?php }} ?>  
                    <?php if ($_smarty_tpl->getVariable('declined_saved')->value=='y'){?>
                    <div class="alert alert-success m-t">
                       <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                       <p><strong>Withdrawal Declined:</strong> Request was saved to database.</p>
                    </div>
                    <?php }?>  
                    <?php if ($_smarty_tpl->getVariable('complete_saved')->value=='y'){?>
                    <div class="alert alert-success m-t">
                       <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                       <p><strong>Withdrawal Completed:</strong> Withdrawal was marked as completed succesfully.</p>
                    </div>
                    <?php }?> 
               
              <br />
               Withdrawal Requests
            </div>
            <div class="panel-body">
               <div class="actions">
                  <div class="columns clear bt-space5">
                     <div class="col2-3">
                        <div class="clear"></div>
                        <div class="clear">
                           <form action='' method='POST'>
                              <label class="fl-space size-300">Member Id</label>
                              <?php echo $_smarty_tpl->getVariable('header')->value['MAIN_FILTER'];?>

                              <input type='submit' class='some_btn' value=" Filter ">
                              <input type='hidden' name='filter1' value=1>
                           </form>
                        </div>
                        <br />
                        <div class="clear">
                           <form action='' method='POST'>
                              <label class="fl-space size-300">Status:</label>
                              <?php echo $_smarty_tpl->getVariable('header')->value['STATUS'];?>

                              <input type='hidden' name='filter2' value=1>
                           </form>
                        </div>
                        <br />
                        <div class="clear">
                           <form action='' method='POST'>
                              <label class="fl-space size-300">Processor:</label>
                              <?php echo $_smarty_tpl->getVariable('header')->value['PROCESSOR'];?>

                              <input type='hidden' name='filter3' value=1>
                           </form>
                        </div>
                        <br />
                        <h3>Total Amount : $<?php echo $_smarty_tpl->getVariable('total_amount')->value;?>
</h3>
                     </div>
                  </div>
               </div>
               <table id="transaction" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                     	<th>ID</th>
                        <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_DATE'];?>
</th>
                        <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_USERNAME'];?>
</th>
                        <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_AMOUNT'];?>
</th>
                        <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_FEE'];?>
</th>
                        <th>Amount To Pay</th>
                        <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_PROCESSOR'];?>
</th>
                        <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_ACCOUNT_ID'];?>
</th>
                        <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_STATUS'];?>
</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                     <tr>
                     	<td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_ID'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_DATE'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_USERNAME'];?>
</td>
                        <td>$<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_AMOUNT'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_FEE'];?>
%</td>
                        <td>$<?php echo smarty_function_math(array('equation'=>"x * (1 - y/100)",'x'=>$_smarty_tpl->tpl_vars['name']->value['ROW_AMOUNT'],'y'=>$_smarty_tpl->tpl_vars['name']->value['ROW_FEE'],'format'=>"%.2f"),$_smarty_tpl);?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_PROCESSOR'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_ACCOUNT_ID'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_STATUS'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_ACTIONS'];?>
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