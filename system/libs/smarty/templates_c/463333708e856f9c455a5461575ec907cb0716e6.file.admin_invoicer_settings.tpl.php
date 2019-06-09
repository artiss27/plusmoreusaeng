<?php /* Smarty version Smarty-3.0.8, created on 2019-05-02 16:42:24
         compiled from "system/app/plugins/invoicer/views/admin_invoicer_settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12671225375ccb80607f0013-42084077%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '463333708e856f9c455a5461575ec907cb0716e6' => 
    array (
      0 => 'system/app/plugins/invoicer/views/admin_invoicer_settings.tpl',
      1 => 1503705006,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12671225375ccb80607f0013-42084077',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/hermes/walnaweb10a/b1543/pow.plusmoreusaengcom/htdocs/system/libs/smarty/plugins/modifier.replace.php';
?>﻿<?php $_template = new Smarty_Internal_Template('views/admin/header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('views/admin/menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
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
         <h2 class="font-light m-b-xs">
            Invoice Settings
         </h2>
         <small>Invoice Settings</small>
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
                           <form action="" method="post" class="validate-form form bt-space15" enctype="multipart/form-data">
                           <?php if ($_smarty_tpl->getVariable('settings')->value['invoice_logo']){?><img width="200" src="/media/images/<?php echo $_smarty_tpl->getVariable('settings')->value['invoice_logo'];?>
" /><br /><br /><?php }?>
                              <div class="columns clear bt-space15">
                                 <div class="col2-3">
                                    <div class="form-field clear"></div>                                    
                                    <div class="form-group">
                                    <label>Upload Invoice Company Logo</label>	
                                    (Gif, Png, Jpg)
                                   	 	<div class="form_input">
                                       		<input type="file" name="invoice_logo" id="invoice_logo" />
                                    	</div>
                                 	</div>
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Email Invoices :</label> 
                                       <select id="email_invoice" class="form-control required" name="email_invoice">
                                       <option value="yes" <?php if ($_smarty_tpl->getVariable('settings')->value['email_invoice']=='yes'){?>selected="selected"<?php }?>>Yes</option>
                                       <option value="no" <?php if ($_smarty_tpl->getVariable('settings')->value['email_invoice']=='no'){?>selected="selected"<?php }?>>No</option>     
                                       </select>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Invoice Language :</label> 
                                       <select id="invoice_language" class="form-control required" name="invoice_language">
                                       <option value="en" <?php if ($_smarty_tpl->getVariable('settings')->value['invoice_language']=='en'){?>selected="selected"<?php }?>>English</option>
                                       <option value="de" <?php if ($_smarty_tpl->getVariable('settings')->value['invoice_language']=='de'){?>selected="selected"<?php }?>>German</option>  
                                       <option value="es" <?php if ($_smarty_tpl->getVariable('settings')->value['invoice_language']=='es'){?>selected="selected"<?php }?>>Spanish</option>  
                                       <option value="fr" <?php if ($_smarty_tpl->getVariable('settings')->value['invoice_language']=='fr'){?>selected="selected"<?php }?>>French</option>  
                                       <option value="it" <?php if ($_smarty_tpl->getVariable('settings')->value['invoice_language']=='it'){?>selected="selected"<?php }?>>Italian</option>     
                                       </select>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Invoice Main Color :</label>
                                       <input name="invoice_color" type="text" size="5" id="custom" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">VAT% (Included in prices, except on Shopping Cart):</label>
                                       <input name="invoice_vat" type="text" value="<?php echo $_smarty_tpl->getVariable('settings')->value['invoice_vat'];?>
" size="5" class="form-control" />
                                    </div>
                                    <br />
                                      <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Company Name :</label>
                                       <input name="invoice_company" type="text" value="<?php echo $_smarty_tpl->getVariable('settings')->value['invoice_company'];?>
" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Company Address :</label>
                                       <input name="invoice_company_address" type="text" value="<?php echo $_smarty_tpl->getVariable('settings')->value['invoice_company_address'];?>
" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Company City :</label>
                                       <input name="invoice_company_city" type="text" value="<?php echo $_smarty_tpl->getVariable('settings')->value['invoice_company_city'];?>
" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Company State :</label>
                                       <input name="invoice_company_state" type="text" value="<?php echo $_smarty_tpl->getVariable('settings')->value['invoice_company_state'];?>
" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Company Country :</label>
                                       <input name="invoice_company_country" type="text" value="<?php echo $_smarty_tpl->getVariable('settings')->value['invoice_company_country'];?>
" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Invoice Footer Title:</label>
                                       <input name="invoice_footer_title" type="text" value="<?php echo $_smarty_tpl->getVariable('settings')->value['invoice_footer_title'];?>
" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Invoice Footer Description:</label>
                                       <textarea name="invoice_footer_description" class="form-control"><?php echo smarty_modifier_replace($_smarty_tpl->getVariable('settings')->value['invoice_footer_description'],'\r\n',"\n");?>
</textarea>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Invoice Footer Company Url:</label>
                                       <input name="invoice_footer_url" type="text" value="<?php echo $_smarty_tpl->getVariable('settings')->value['invoice_footer_url'];?>
" size="5" class="form-control" />
                                    </div>
                                    <br />
                                 </div>
                              </div>
                              <div class="form-field clear">
                                 <br />
                                 <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
                                 <br />
                                 </p> 
                              </div>
                              <!-- /.form-field -->																								
                           </form>
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
<!-- Vendor scrits -->
<?php $_template = new Smarty_Internal_Template('views/admin/footer_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?> 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script src="/assets/common/scripts/spectrum.js"></script>
<link rel='stylesheet' href="/assets/common/styles/spectrum.css" />
<script>
   $(function () {
   		$("#custom").spectrum({
    		color: "<?php echo $_smarty_tpl->getVariable('settings')->value['invoice_color'];?>
",
			preferredFormat: "hex"
		});
   });
</script>
<?php $_template = new Smarty_Internal_Template('views/admin/footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>