<?php /* Smarty version Smarty-3.0.8, created on 2019-06-03 09:53:46
         compiled from "system/app/views/members/withdrawals.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9759939325cf5509a3198c0-83869045%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b9330f0cf3022d717adbd1609bcffab88280d0a' => 
    array (
      0 => 'system/app/views/members/withdrawals.tpl',
      1 => 1549754276,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9759939325cf5509a3198c0-83869045',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
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
         <?php $_template = new Smarty_Internal_Template('breadcrumb.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>            
         <h2 class="font-light m-b-xs">
           MIS PAGOS/<font color="green">MY PAYMENTS</FONT>
         </h2>
         <small>Historial de mis pagos de comisiones/<font color="green">my commission payment history</font></small>
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
            <p class="alert alert-danger">
               <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('error'), null, null);?>
               <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

            </p>
            <br />
            <?php }?> 
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <table id="withdrawals" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th>Fecha/<font color="green">date</font></th>
                                    <th>Cantidad/<font color="green"><?php echo $_smarty_tpl->getVariable('lang')->value['amount'];?>
</font></th>
                                    
                                    <th><?php echo $_smarty_tpl->getVariable('lang')->value['withdrawal_account_id'];?>
</th>
                                    <th>Estatus/<font color="green"><?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
</font></th>
                                 </tr>
                              </thead>
                              <tbody>
                              <?php if (!$_smarty_tpl->getVariable('list')->value){?>
                              <tr>
                                    <td colspan="6">No Hay Resultados / <font color="green"><?php echo $_smarty_tpl->getVariable('lang')->value['no_result_found'];?>
</font></td>
                                 </tr>
                              <?php }else{ ?>
                                 <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>                
                                 <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['name']->value['date'];?>
</td>
                                    <td><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
<?php echo $_smarty_tpl->tpl_vars['name']->value['amount'];?>
</td>
                                    <td><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
<?php echo $_smarty_tpl->tpl_vars['name']->value['fee'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['name']->value['processor'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['name']->value['processorid'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['name']->value['status'];?>
 <?php echo $_smarty_tpl->tpl_vars['name']->value['cancel'];?>
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
<!-- Right sidebar -->
<?php $_template = new Smarty_Internal_Template('right_sidebar.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>   
<!-- Vendor scrits -->
<?php $_template = new Smarty_Internal_Template('vendor_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?> 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(document).ready( function() {  
    	<?php if ($_smarty_tpl->getVariable('list')->value){?>$('#withdrawals').dataTable({
			"order": [[ 0, "desc" ]]
			});<?php }?>    
   });
   
</script>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>