<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 11:39:32
         compiled from "system/app/views/members/referrers.tpl" */ ?>
<?php /*%%SmartyHeaderCode:437577605cf80c64380217-07793175%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '194bd11ae42b5f3a53f363a1d006ad1be4eb7eee' => 
    array (
      0 => 'system/app/views/members/referrers.tpl',
      1 => 1518455991,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '437577605cf80c64380217-07793175',
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
            Mis Referidos Directos
         </h2>
         <small>Invitados por mi directamente</small>
      </div>
   </div>
</div>
<div class="content animate-panel">
   <?php if (!$_smarty_tpl->getVariable('data')->value){?>
   No referidos aun
   <?php }else{ ?>
   <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['name']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['name']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['obj']['iteration']=0;
if ($_smarty_tpl->tpl_vars['name']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['name']->iteration++;
 $_smarty_tpl->tpl_vars['name']->last = $_smarty_tpl->tpl_vars['name']->iteration === $_smarty_tpl->tpl_vars['name']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['obj']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['obj']['last'] = $_smarty_tpl->tpl_vars['name']->last;
?>  
   <?php if (($_smarty_tpl->getVariable('smarty')->value['foreach']['obj']['iteration']-1)%4==0){?>
   <div class="row">
      <?php }?>
      <div class="col-lg-3">
         <div class="hpanel hgreen contact-panel">
            <div class="panel-body">
	            <span class="label label-success pull-right">Nuevo</span>	
                <?php $_smarty_tpl->tpl_vars['pic'] = new Smarty_variable(CoreHelp::getMemberProfilePic($_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'],$_smarty_tpl->tpl_vars['name']->value['ROW_GENDER']), null, null);?>
               <img alt="logo" class="img-circle m-b" src="<?php echo $_smarty_tpl->getVariable('pic')->value;?>
">
               <h3><a href=""><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_FNAME'];?>
 <?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_LNAME'];?>
</a></h3>
              <!-- <div class="text-muted font-bold m-b-xs"><img src="<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_COUNTRY_FLAG'];?>
" style="width:16px;height:11px" /> <?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_COUNTRY_NAME'];?>
</div>-->
               <p>Usuario: <strong><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_USERNAME'];?>
 </strong><br />
                 Membresia: <strong><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBERSHIP'];?>
 </strong><br />
                 Fecha de Registro: <strong><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_REG'];?>
 </strong><br />
                 <?php if ($_smarty_tpl->tpl_vars['name']->value['ROW_SKYPE']){?><?php echo $_smarty_tpl->getVariable('lang')->value['skype'];?>
: <strong><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_SKYPE'];?>
 </strong><br /><?php }?>
                 Genero: <strong><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_GENDER'];?>
 </strong><br />
               </p>
            </div>
           <div class="panel-footer contact-footer">
               <div class="row">
                 <div class="col-md-4 border-right">
                      <!-- <div class="contact-stat"><span>Numero de Referidos : </span> <strong><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_REFERRER_YESTERDAY'];?>
</strong></div>
                  </div>
                  <div class="col-md-4 border-right">
                     <div class="contact-stat"><span><?php echo $_smarty_tpl->getVariable('lang')->value['referrals_today'];?>
: </span> <strong><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_REFERRER_TODAY'];?>
</strong></div>
                  </div>
                  <div class="col-md-4">
                     <div class="contact-stat"><span><?php echo $_smarty_tpl->getVariable('lang')->value['referrals_total'];?>
: </span> <strong><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_REFERRER_TOTAL'];?>
</strong></div>-->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php if (($_smarty_tpl->getVariable('smarty')->value['foreach']['obj']['iteration'])%4==0||$_smarty_tpl->getVariable('smarty')->value['foreach']['obj']['last']){?>
   </div>
   <?php }?>
   <?php }} ?>
   <?php }?>                                                             
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