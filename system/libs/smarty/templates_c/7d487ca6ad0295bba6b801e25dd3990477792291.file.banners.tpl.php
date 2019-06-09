<?php /* Smarty version Smarty-3.0.8, created on 2019-06-08 23:19:52
         compiled from "system/app/views/members/banners.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14924241635cfca508e0f0a3-73445512%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d487ca6ad0295bba6b801e25dd3990477792291' => 
    array (
      0 => 'system/app/views/members/banners.tpl',
      1 => 1560061191,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14924241635cfca508e0f0a3-73445512',
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
            Publicidades Para Tus Redes Sociales
         </h2>
         <h5>Utiliza estos anuncios o imágenes en tu red sociales e incrementa tus referidos.</small><br><br><br><h5>Instrucciones</h5><small>• Haga clic derecho en la imagen con el mouse para abrir el menú.<br>• Copia o guarda la imagen en tu computadora como una foto. <br>• Entra a tu cuenta de red social favorita.<br>• Descarga la imagen en tu cuenta de Facebook / Instagram como si fuera una foto normal.<br>• Agregue tu URL de referir junto con tu nombre o ID de su miembro.<br> • Comparte y ganas ayudando a tus referidos a conseguir mas.
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
                           <table id="banners" class="table table-striped table-bordered table-hover">
                           <tbody>
                           <?php if ($_smarty_tpl->getVariable('banners')->value){?>
                              <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('banners')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                              <tr>
                                 <td>
                                    <img src="/media/images/<?php echo $_smarty_tpl->tpl_vars['name']->value['banner_name'];?>
" /><br />
                                    <?php echo $_smarty_tpl->getVariable('lang')->value['size'];?>
: <?php echo $_smarty_tpl->tpl_vars['name']->value['banner_size'];?>
 <br />
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <textarea class="form-control" name="textarea" id="textarea" cols="85" rows="2"> <?php echo $_smarty_tpl->getVariable('site_url')->value;?>
?u=<?php echo $_smarty_tpl->getVariable('username')->value;?>
 </textarea>
                                 </td>
                              </tr>
                              <tr>
                                 <td>&nbsp;</td>
                              </tr>
                              <?php }} ?>    
                            <?php }else{ ?>
                            	<tr><td><?php echo $_smarty_tpl->getVariable('lang')->value['no_result_found'];?>
</td></tr>
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
   $(function () {
    	$('#banners').dataTable();    
   });
   
</script>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>