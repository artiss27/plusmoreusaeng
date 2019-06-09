<?php /* Smarty version Smarty-3.0.8, created on 2019-05-25 10:17:06
         compiled from "system/app/views/members/pending_referrals.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16620662815ce978928ab3f4-57111128%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '441c3da43cdb1f3ab68524953fac1570def435f8' => 
    array (
      0 => 'system/app/views/members/pending_referrals.tpl',
      1 => 1518843544,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16620662815ce978928ab3f4-57111128',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/hermes/walnaweb10a/b1543/pow.plusmoreusaengcom/htdocs/system/libs/smarty/plugins/modifier.date_format.php';
?>﻿<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
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
            Pending Guests / <font color="green">Invitados Pendientes
         </font></h2>
      
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
            <?php if ($_smarty_tpl->getVariable('settings_edited')->value=='y'){?>
            <p class="alert alert-success">
               <strong><?php echo $_smarty_tpl->getVariable('lang')->value['settings_edited'];?>
/<font color="green">Configuracion Editada</font></strong> <?php echo $_smarty_tpl->getVariable('lang')->value['settings_edited_succesfully_to_database'];?>
/<font size="2" color="green">configuración editada con éxito a la base de datos</font>
            </p>
            <br />
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
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <table id="pending_referrers" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                   <th>Date Invited / <font color="green">Fecha de Invitación</th>
                                    <!--<th>User / <font color="green">Usuario (No. de ID)</font></th>-->
                                    <th>Name / <font color="green">Nombre</font></th>
                                    <!--<th>E-mail</th>
                                    <th>Skype</th>-->
                                    <th>Results / <font color="green">Resultados</font></th>
                                 </tr>
                              </thead>
                              <tbody>
                              <?php if (!$_smarty_tpl->getVariable('data')->value){?>
                              <tr>
                                    <td colspan="6"><?php echo $_smarty_tpl->getVariable('lang')->value['no_result_found'];?>
/<font color="green">No Resultados Encontrados</font></td>
                                 </tr>
                              <?php }else{ ?>
                                 <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>   
                                 <tr>
                                  <td>&nbsp;<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['name']->value['reg_date']);?>
</td>
                                   <!-- <td>&nbsp;<?php echo $_smarty_tpl->tpl_vars['name']->value['username'];?>
 (#<?php echo $_smarty_tpl->tpl_vars['name']->value['member_id'];?>
)</td>-->
                                    <td>&nbsp;<?php echo $_smarty_tpl->tpl_vars['name']->value['first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['name']->value['last_name'];?>
</td>
                                   <!--<td>&nbsp;<?php echo $_smarty_tpl->tpl_vars['name']->value['email'];?>
</td>
                                    <td>&nbsp;<?php echo $_smarty_tpl->tpl_vars['name']->value['skype'];?>
</td>-->
                                    <td>&nbsp;Pending / <font color="green">Pendientes</font></td>
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
    	<?php if ($_smarty_tpl->getVariable('data')->value){?>$('#pending_referrers').dataTable();<?php }?>    
   });
   
   
</script>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
