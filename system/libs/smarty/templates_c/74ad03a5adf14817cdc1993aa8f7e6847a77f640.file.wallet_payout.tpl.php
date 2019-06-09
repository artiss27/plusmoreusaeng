<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 10:25:49
         compiled from "system/app/views/members/wallet_payout.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7131583515cf7fb1d0a7817-80566366%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '74ad03a5adf14817cdc1993aa8f7e6847a77f640' => 
    array (
      0 => 'system/app/views/members/wallet_payout.tpl',
      1 => 1549755316,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7131583515cf7fb1d0a7817-80566366',
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
          Commissions Account / <font color="green">Cuenta de Comisiones </font>
         </h2>
         <small>Account balance from earned commissions / <font color="green">Balance de tus comisiones ganada</font></small>
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
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
<h3>Balance Disponible / <font color="green">Available Balance</font> <strong><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
 <?php echo $_smarty_tpl->getVariable('balance')->value;?>
</strong></h3> <br />
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <div class="actions">
                              <form id="form1" name="form1" method="post" action=""> <?php echo $_smarty_tpl->getVariable('filter')->value;?>
 <input type='submit' class="btn btn-sm btn-primary m-t-n-xs" value=" Buscar "><input type='hidden' name='filter' value=1>
                              </form>
                           </div>
                           <br />
                           
                           <table id="wallet_payout" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
	                                 <th>Trasaction ID/ <font color="green">Codigo de Transaccion</font></th>
                                    <th> Fecha / <font color="green">Date</font></th>
                                    <th>Pago /<font color="green">Payment</font></th>
                                    <th>Servicio Obtenido /<font color="green">Serviced Received</font></th>
                                 </tr>
                              </thead>
                              <tbody>
                              <?php if (!$_smarty_tpl->getVariable('list')->value){?>
                              <tr>
                                    <td colspan="4">No se encontro comisiones / <font color="green">No commissions found</font></td>
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
                                 	<td>
transaction ID
14/5000
Codigo de transacción/<font color="green"><?php echo $_smarty_tpl->tpl_vars['name']->value['transaction_id'];?>
</font></td>
                                    <td>Fecha/<font color="green"><?php echo $_smarty_tpl->tpl_vars['name']->value['date'];?>
</font></td>
                                    <td>Cantidad/<font color="green"><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
 <?php echo $_smarty_tpl->tpl_vars['name']->value['amount'];?>
</font></td>
                                    <td>Descripcion/<font color="green"><?php echo $_smarty_tpl->tpl_vars['name']->value['description'];?>
</font></td>
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
    	<?php if ($_smarty_tpl->getVariable('list')->value){?>$('#wallet_payout').dataTable({
			"order": [[ 0, "desc" ]]
			});<?php }?>    
   });
   
</script>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>