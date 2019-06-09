<?php /* Smarty version Smarty-3.0.8, created on 2019-06-03 09:54:07
         compiled from "system/app/views/members/faq.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3869191465cf550af2ae5b1-86531707%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ecf8ef11c4b43ae397d9da816c9afc5683c34c46' => 
    array (
      0 => 'system/app/views/members/faq.tpl',
      1 => 1503704422,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3869191465cf550af2ae5b1-86531707',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/hermes/walnaweb10a/b1543/pow.plusmoreusaengcom/htdocs/system/libs/smarty/plugins/modifier.replace.php';
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
            <?php echo $_smarty_tpl->getVariable('lang')->value['faq'];?>

         </h2>
         <small><?php echo $_smarty_tpl->getVariable('lang')->value['faq'];?>
</small>
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
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('faq')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['name']->iteration=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
 $_smarty_tpl->tpl_vars['name']->iteration++;
?>
                           <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="heading<?php echo $_smarty_tpl->tpl_vars['name']->iteration;?>
">
                                 <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $_smarty_tpl->tpl_vars['name']->iteration;?>
" aria-expanded="true" aria-controls="collapse<?php echo $_smarty_tpl->tpl_vars['name']->iteration;?>
">
                                    <?php echo $_smarty_tpl->tpl_vars['name']->value['question'];?>

                                    </a>
                                 </h4>
                              </div>
                              <div id="collapse<?php echo $_smarty_tpl->tpl_vars['name']->iteration;?>
" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $_smarty_tpl->tpl_vars['name']->iteration;?>
">
                                 <div class="panel-body">
                                    <?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['name']->value['answer'],"\n","<br>");?>

                                 </div>
                              </div>
                           </div>
                          <?php }} ?>  
                        </div>                        
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
    
    
   });
   
</script>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>