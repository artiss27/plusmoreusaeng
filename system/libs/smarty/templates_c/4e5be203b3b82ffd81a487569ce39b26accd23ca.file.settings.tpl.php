<?php /* Smarty version Smarty-3.0.8, created on 2019-06-04 21:46:54
         compiled from "system/app/views/admin/settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20124903635cf7493e9983f7-69376801%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4e5be203b3b82ffd81a487569ce39b26accd23ca' => 
    array (
      0 => 'system/app/views/admin/settings.tpl',
      1 => 1503704417,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20124903635cf7493e9983f7-69376801',
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
               <?php if ($_smarty_tpl->getVariable('settings_saved')->value=='y'){?>
                     <div class="alert alert-success">
                        <p><strong>Settings Saved:</strong> Your settings were saved succesfully on database.</p>
                     </div>
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
                     <?php }} ?> 
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
                    <br />
               <h2 class="font-light m-b-xs">
                  Main Settings
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     
                     
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <form action="#" method="post" class="validate-form form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Web Site Title: <span class="required">*</span></label>
                                          <input name="site_name" type="text" class="required text form-control" id="textfield" size="35" value='<?php echo $_smarty_tpl->getVariable('settings')->value['site_name'];?>
' />
                                       </div>
                                       <!-- /.form-field -->
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield2" class="form-label size-120 fl-space2">Script  URL: <span class="required">*</span></label>
                                          <input name="site_url" type="text" class="required text form-control" id="textfield2" size="35" value='<?php echo $_smarty_tpl->getVariable('settings')->value['site_url'];?>
' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield3" class="form-label size-120 fl-space2">Script  Full Path: <span class="required">*</span></label>
                                          <input name="site_path" type="text" class="required text form-control" id="textfield3" size="35" value='<?php echo $_smarty_tpl->getVariable('settings')->value['site_path'];?>
' />
                                       </div>
                                       <br>						
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Mail Gateway: <span class="required">*</span></label> <button type="button" class="btn btn-primary" onclick='AjaxFunction();'>Test with <?php echo $_smarty_tpl->getVariable('settings')->value['mailgate'];?>
</button>
                                          <select id="select" name="mailgate" class="form-control">
                                          <?php echo $_smarty_tpl->getVariable('settings')->value['mailgate'];?>
<option value="php" <?php if ($_smarty_tpl->getVariable('settings')->value['mailgate']=='php'){?>selected="selected"<?php }?>>PHP</option>
                                          <option value="smtp" <?php if ($_smarty_tpl->getVariable('settings')->value['mailgate']=='smtp'){?>selected="selected"<?php }?>>SMTP</option>
                                          <option value="smtp_ssl" <?php if ($_smarty_tpl->getVariable('settings')->value['mailgate']=='smtp_ssl'){?>selected="selected"<?php }?>>SMTP with SSL</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield4" class="form-label size-120 fl-space2">SMTP Host: </label>
                                          <input name="smtp_host" type="text" class="text form-control" id="textfield4" size="35" value='<?php echo $_smarty_tpl->getVariable('settings')->value['smtp_host'];?>
' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield5" class="form-label size-120 fl-space2">SMTP  Port: </label>
                                          <input name="smtp_port" type="text" class="text form-control" id="textfield5" size="35" value='<?php echo $_smarty_tpl->getVariable('settings')->value['smtp_port'];?>
' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield5" class="form-label size-120 fl-space2">SMTP  Login: </label>
                                          <input name="smtp_login" type="text" class="text form-control" id="textfield5" size="35" value='<?php echo $_smarty_tpl->getVariable('settings')->value['smtp_login'];?>
' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield6" class="form-label size-120 fl-space2">SMTP  Password: </label>
                                          <input name="smtp_password" type="password" class="text form-control" id="textfield6" size="35" value='<?php echo $_smarty_tpl->getVariable('settings')->value['smtp_password'];?>
' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">BackOffice Language: <span class="required">*</span></label>
                                          <select id="select" name="backoffice_lang" class="form-control">
                                          <?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('languages')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['language']->key;
?>
                                          <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->getVariable('settings')->value['backoffice_lang']==$_smarty_tpl->tpl_vars['key']->value){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</option>
                                          <?php }} ?>
                                          </select>
                                       </div>
                                       <br />
                                       <br />
                                       <p>Admin & Backoffice Menu Settings</p>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Activate Google Translator Widget on Admin Panel: </label>
                                          <select id="select" name="google_translator_admin" class="form-control">
                                            <option value="1" <?php if ($_smarty_tpl->getVariable('settings')->value['google_translator_admin']=='1'){?>selected="selected"<?php }?>>Yes</option>
                                          	<option value="0" <?php if ($_smarty_tpl->getVariable('settings')->value['google_translator_admin']=='0'){?>selected="selected"<?php }?>>No</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Activate Google Translator Widget on Members BackOffice: </label>
                                          <select id="select" name="google_translator_member" class="form-control">
                                            <option value="1" <?php if ($_smarty_tpl->getVariable('settings')->value['google_translator_member']=='1'){?>selected="selected"<?php }?>>Yes</option>
                                          	<option value="0" <?php if ($_smarty_tpl->getVariable('settings')->value['google_translator_member']=='0'){?>selected="selected"<?php }?>>No</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Show Advertising Menu on Members BackOffice: </label>
                                          <select id="select" name="show_adverting_menu_member" class="form-control">
                                            <option value="1" <?php if ($_smarty_tpl->getVariable('settings')->value['show_adverting_menu_member']=='1'){?>selected="selected"<?php }?>>Yes</option>
                                          	<option value="0" <?php if ($_smarty_tpl->getVariable('settings')->value['show_adverting_menu_member']=='0'){?>selected="selected"<?php }?>>No</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Show Digital Products Menu on Members BackOffice: </label>
                                          <select id="select" name="show_digital_menu_member" class="form-control">
                                            <option value="1" <?php if ($_smarty_tpl->getVariable('settings')->value['show_digital_menu_member']=='1'){?>selected="selected"<?php }?>>Yes</option>
                                          	<option value="0" <?php if ($_smarty_tpl->getVariable('settings')->value['show_digital_menu_member']=='0'){?>selected="selected"<?php }?>>No</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Show FAQ Menu on Members BackOffice: </label>
                                          <select id="select" name="show_faq_menu_member" class="form-control">
                                            <option value="1" <?php if ($_smarty_tpl->getVariable('settings')->value['show_faq_menu_member']=='1'){?>selected="selected"<?php }?>>Yes</option>
                                          	<option value="0" <?php if ($_smarty_tpl->getVariable('settings')->value['show_faq_menu_member']=='0'){?>selected="selected"<?php }?>>No</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <p>Wordpress Settings</p>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Use Included Wordpress Installation for Frontpage: </label>
                                          <select id="select" name="use_wordpress_bundle" class="form-control">
                                            <option value="yes" <?php if ($_smarty_tpl->getVariable('settings')->value['use_wordpress_bundle']=='yes'){?>selected="selected"<?php }?>>Use bundled wordpress installation</option>
                                          	<option value="no" <?php if ($_smarty_tpl->getVariable('settings')->value['use_wordpress_bundle']=='no'){?>selected="selected"<?php }?>>Redirect to other URL for frontpage</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield6" class="form-label size-120 fl-space2">If Redirect to External URL for Frontpage, use this URL: </label>
                                          <input name="front_page_redirect_url" type="text" class="text form-control" id="textfield6" size="35" value='<?php echo $_smarty_tpl->getVariable('settings')->value['front_page_redirect_url'];?>
' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield6" class="form-label size-120 fl-space2">Wordpress Username for autologin: </label>
                                          <input name="wordpress_admin_username" type="text" class="text form-control" id="textfield6" size="35" value='<?php if ($_smarty_tpl->getVariable('settings')->value['wordpress_admin_username']){?><?php echo $_smarty_tpl->getVariable('settings')->value['wordpress_admin_username'];?>
<?php }else{ ?>admin<?php }?>' />
                                       </div>
                                       <br>
                                       <br>
                                    </div>
                                 </div>
                                 <div class="form-field clear">
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
<script type="text/javascript">
   function AjaxFunction()
   {
   var httpxml;
   try
     {
     // Firefox, Opera 8.0+, Safari
     httpxml=new XMLHttpRequest();
     }
   catch (e)
     {
     // Internet Explorer
   try
    		{
   httpxml=new ActiveXObject("Msxml2.XMLHTTP");
   		}
   catch (e)
   	{
   try
   		{
   	httpxml=new ActiveXObject("Microsoft.XMLHTTP");
   		 }
   		catch (e)
   	{
   alert("Your browser does not support AJAX!");
   return false;
     		}
   		}
   }
   function stateck() 
      {
      if(httpxml.readyState==4)
      {
   		//alert(''+httpxml.responseText+'');
		swal("Response", ''+httpxml.responseText+'', "success");
        }
      }
   //email =  prompt ("Enter the email to send the test", "");
   swal({   
   title: "",
   text: "Enter the email to send the test:",   
   type: "input",   
   showCancelButton: true,   
   closeOnConfirm: false,   
   animation: "slide-from-top",   
   inputPlaceholder: "Email Address" }, 
   function(inputValue){   
   if (inputValue === false) return false;      
   if (inputValue === "") {     
   	swal.showInputError("You need to write the email!");     
	return false   
	}  
	var url="/admin/testmail/";
   	url=url+"&email="+inputValue;
  	httpxml.onreadystatechange=stateck;
   	httpxml.open("GET",url,true);
   	httpxml.send(null);
	
	 });
   
     }
</script>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>