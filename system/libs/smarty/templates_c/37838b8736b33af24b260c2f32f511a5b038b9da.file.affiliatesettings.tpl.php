<?php /* Smarty version Smarty-3.0.8, created on 2019-06-04 21:26:16
         compiled from "system/app/views/admin/affiliatesettings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12925081065cf744687eaec5-26660596%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '37838b8736b33af24b260c2f32f511a5b038b9da' => 
    array (
      0 => 'system/app/views/admin/affiliatesettings.tpl',
      1 => 1503704412,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12925081065cf744687eaec5-26660596',
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
               <?php }} ?> <br />
               <h2 class="font-light m-b-xs">
                  Affiliate Settings
               </h2>
               <br>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <form action="#" method="post" class="validate-form form bt-space5">
                                 <div class="columns clear bt-space5">
                                    <div class="col2-3">
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Affiliate Site Type :</label> 
                                          <select id="affiliate_type" class="form-control required" name="affiliate_type">                                 
                                          <?php if ($_smarty_tpl->getVariable('is_hybrid')->value==1){?>
                                          	<?php echo $_smarty_tpl->getVariable('hybrid')->value;?>

                                          <?php }else{ ?>
                                          	<?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('affiliate_setting');?>

                                          <?php }?>				      
                                          </select>
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Email Affiliate On New Commission :</label> 
                                          <select id="alert_commision" class="form-control required" name="alert_commission">
                                          <option value="yes" <?php if ($_smarty_tpl->getVariable('settings')->value['alert_commission']=='yes'){?>selected="selected"<?php }?>>Yes</option>
                                          <option value="no" <?php if ($_smarty_tpl->getVariable('settings')->value['alert_commission']=='no'){?>selected="selected"<?php }?>>No</option>     
                                          </select>
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Email Affiliate on Referral Signup :</label>
                                          <select id="alert_downline" class="form-control required" name="alert_downline">
                                          <option value="yes" <?php if ($_smarty_tpl->getVariable('settings')->value['alert_downline']=='yes'){?>selected="selected"<?php }?>>Yes</option>
                                          <option value="no" <?php if ($_smarty_tpl->getVariable('settings')->value['alert_downline']=='no'){?>selected="selected"<?php }?>>No</option>
                                          </select>
                                       </div>
                                       <br />
                                       <div class="clear">
										<label for="textfield" class="fl-space size-300">Processors Fee Paid By :</label>
										<select id="processor_fee_by" class="form-control required" name="processor_fee_by">
										<option value="owner" <?php if ($_smarty_tpl->getVariable('settings')->value['processor_fee_by']=='owner'){?>selected="selected"<?php }?>>Owner</option>
										<option value="member" <?php if ($_smarty_tpl->getVariable('settings')->value['processor_fee_by']=='member'){?>selected="selected"<?php }?>>Member</option>
										</select>
										</div>
										<br />
                                         <div class="clear">
                                          <label for="textfield2" class="fl-space size-300">Min Amount for Deposit :</label>
                                          $
                                          <input name="min_deposit" type="text" value="<?php echo $_smarty_tpl->getVariable('settings')->value['min_deposit'];?>
" class="form-control" size="5" />
                                       </div>
                                       <br />                                       
                                       <div class="clear"></div>
                                    </div>
                                 </div>
                                 <div class="clear">
                                    <input type="hidden" class="button red fr" name="bnsubmit" value="Save" />
                                    <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
                                 </div>
                                 <!-- /.form-field -->																								
                              </form>
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