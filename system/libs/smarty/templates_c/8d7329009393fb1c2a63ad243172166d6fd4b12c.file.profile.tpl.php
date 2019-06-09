<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 11:00:00
         compiled from "system/app/views/members/profile.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8409083795cf80320566ad9-78406408%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d7329009393fb1c2a63ad243172166d6fd4b12c' => 
    array (
      0 => 'system/app/views/members/profile.tpl',
      1 => 1549758060,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8409083795cf80320566ad9-78406408',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<style>
#imgContainer {
	width: 100%;
	text-align: center;
	position: relative;
}
#imgArea {
	display: inline-block;
	margin: 0 auto;
	width: 150px;
	height: 150px;
	position: relative;
	background-color: #eee;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
}
#imgArea img {
	outline: medium none;
	vertical-align: middle;
	width: 100%;
}
#imgChange {
	background: url("/assets/members/images/overlay.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
	bottom: 0;
	color: #FFFFFF;
	display: block;
	height: 30px;
	left: 0;
	line-height: 32px;
	position: absolute;
	text-align: center;
	width: 100%;
}
#imgChange input[type="file"] {
	bottom: 0;
	cursor: pointer;
	height: 100%;
	left: 0;
	margin: 0;
	opacity: 0;
	padding: 0;
	position: absolute;
	width: 100%;
	z-index: 0;
}

/* Progressbar */
.progressBar {
	background: none repeat scroll 0 0 #E0E0E0;
	left: 0;
	padding: 3px 0;
	position: absolute;
	top: 50%;
	width: 100%;
	display: none;
}
.progressBar .bar {
	background-color: #FF6C67;
	width: 0%;
	height: 14px;
}
.progressBar .percent {
	display: inline-block;
	left: 0;
	position: absolute;
	text-align: center;
	top: 2px;
	width: 100%;
}
</style>
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
            Mi Perfil / <font color="green">My Profile</font></h2>
         <small>Edit my profile. /  <font size="2" color="green">Edita tu Informacion Personal.</font></small>
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
            <?php if ($_smarty_tpl->getVariable('member_edited')->value=='y'){?>
            <p class="alert alert-success">
               <strong><?php echo $_smarty_tpl->getVariable('lang')->value['settings_edited'];?>
:</strong> <?php echo $_smarty_tpl->getVariable('lang')->value['settings_edited_succesfully_to_database'];?>

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
                     <div id="imgContainer">
                      <form enctype="multipart/form-data" action="/members/uploadpic" method="post" name="image_upload_form" id="image_upload_form">
                      	<?php $_smarty_tpl->tpl_vars['pic'] = new Smarty_variable(CoreHelp::getProfileUploadPic(), null, null);?>
                        <div id="imgArea"><img src="<?php echo $_smarty_tpl->getVariable('pic')->value;?>
">
                          <div class="progressBar">
                            <div class="bar"></div>
                            <div class="percent">0%</div>
                          </div>
                          <div id="imgChange"><span>Change/<font color="yellow">Cambiar</font></span>
                            <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
                          </div>
                        </div>
                      </form>					  
                    </div>
					<div class="box-wrap clear">
					<?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('show_webcam_form');?>
	
					</div>
                        <div class="box-wrap clear">
                           <form role="form" id="form" method="post">
                              <fieldset>
                                 <legend>Contacto Personal / <font color="green">Personal Information</font></legend>
                                 <div class="form-group">                                      
                                    <label for="name">Primer Nombre / <font color="green">First Name</font></label>
                                    <input type="text" name="firstName" value="<?php echo $_smarty_tpl->getVariable('profile')->value['first_name'];?>
" class="form-control form-half" />
                                 </div>
                                 <div class="form-group">  
                                    <label for="name"><br>Apellido / <font color="green">Last Name</font></label>
                                    <input type="text" name="lastName" value="<?php echo $_smarty_tpl->getVariable('profile')->value['last_name'];?>
"  class="form-control form-half" />
                                 </div>
                                 <div class="form-group">  
                                    <label for="name">Correo Electronico / <font color="green">Email</font></label>
                                    <input type="text" name="email" value="<?php echo $_smarty_tpl->getVariable('profile')->value['email'];?>
"  class="form-control form-half" />
                                 </div>
                              </fieldset>
                              <fieldset>
                                 <legend>Acceso a tu Cuenta / <font color="green">Account Access</font>
                                 </legend>
                                 <div class="form-group">
                                    <div class="form-group">  
                                       <label for="name">Usuario: / <font color="green">User: </font></label>
                                       <?php echo $_smarty_tpl->getVariable('profile')->value['username'];?>

                                    </div>
                                    <div class="form-group">  <label for="name"></label>
                                       &nbsp;&nbsp;&nbsp;<a href="/members/resetpassword" class="btn btn-sm btn-primary m-t-n-xs">Cambiar Contrase&ntilde;a /</font> <font color="yellow">Change Password</font></a>
                                    </div>
                                 </div>
                              </fieldset>
                              <fieldset>
                                 <legend>Direccion / <font color="green">Address</font></legend>
                                 <div class="form-group">
                                    <div class="form-group">  
                                       <label for="name">Calle / <font color="green">Street</font></label>
                                       <input type="text" name="street" value="<?php echo $_smarty_tpl->getVariable('profile')->value['street'];?>
" class="form-control form-half" />
                                    </div>
                                    <div class="form-group">  
                                       <label for="name">Ciudad / <font color="green">City</font></label>
                                       <input type="text" name="city" value="<?php echo $_smarty_tpl->getVariable('profile')->value['city'];?>
"  class="form-control form-half" />
                                    </div>
                                    <div class="form-group">  
                                       <label for="name">Estado / <font color="green">State </font></label>
                                       <input type="text" name="state" value="<?php echo $_smarty_tpl->getVariable('profile')->value['state'];?>
"  class="form-control form-half" />
                                    </div>
                                      
                                    <div class="form-group">  
                                       <label for="name">Apartado Postal / <font color="green">Zip Code</font></label>
                                       <input type="text" name="postal" value="<?php echo $_smarty_tpl->getVariable('profile')->value['postal'];?>
"  class="form-control form-half" />
                                    </div><div class="form-group">  
                                        <label for="select1">Pais / <font color="green"><?php echo $_smarty_tpl->getVariable('lang')->value['country'];?>
</font></label> 
                                        <select name="country" class="form-control form-half">
                                        <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('countries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value['code'];?>
" <?php if ($_smarty_tpl->getVariable('profile')->value['country']==($_smarty_tpl->tpl_vars['name']->value['code'])){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['name']->value['country'];?>
</option>
                                        <?php }} ?>
                                        </select>
                                 	</div>
                                    <div class="form-group">  
                                       <label for="name">Numero de Contacto / <font color="green">Contact Number </font></label>
                                       <input type="text" name="phone" value="<?php echo $_smarty_tpl->getVariable('profile')->value['phone'];?>
"  class="form-control form-half"  />
                                    </div>
                                 </div>
                              </fieldset>
                              <fieldset>
                                <!-- <legend>Cuenta  / <font color="green">Informacion Para Pagos Y Depositos </font>
                                 </legend>
                                 <div class="form-group">  
                                    <label for="select1">Withdrawal Processor / <font color="green">Procesador de Pagos y Retiros</font></label> 
                                    <select size="1" id="select1" name="processor" class="form-control form-half">
                                    <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('processors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value['processor_id'];?>
" <?php if ($_smarty_tpl->getVariable('profile')->value['processor']==($_smarty_tpl->tpl_vars['name']->value['processor_id'])){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['name']->value['name'];?>
</option>
                                    <?php }} ?>
                                    </select>
                                 </div>-->
                          <div class="form-group">  
                                    <label for="name">Cuenta de Zelle (Numero de Celular/Email) / <font color="green">Zelle Account (Cellphone Number/Email)</font></label> 
                                    <input type="text" name="account_id" value="<?php echo $_smarty_tpl->getVariable('profile')->value['account_id'];?>
" class="form-control form-half" />
                                 </div>
                                 
                               <!--<div class="form-group">  
                                    <label for="name">Security Token / <font color="green">Codigo de Seguridad</font></label> 
                                    <input type="text" name="token" value="" class="form-control form-half" /> <div id="modal"><a id="get_token" class="btn btn-sm m-r-5">Request Security Token to Email</a></div>-->
                                    
                                 </div>
                                 
                                 <div class="buttons">
                                    <button name="save" type="submit" class="btn btn-sm btn-primary m-t-n-xs" value="submit">Guardar /</font> <font color="yellow">Save</font></button>
                                 </div>
                              </fieldset>
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
<!-- Right sidebar -->
<?php $_template = new Smarty_Internal_Template('right_sidebar.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>   
<!-- Vendor scrits -->
<?php $_template = new Smarty_Internal_Template('vendor_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?> 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script src="/assets/members/js/jquery.form.js"></script>
<script>

   $(function () {
    	jQuery('#get_token').click(function(event){
			id = 1;
			jQuery('#modal').html('processing...');
			jQuery.post("/members/sendtoken", {id: id}, function(result) { 
				jQuery('#modal').html('');
         		if (result == "done") 
         		{
					alert('Token sent to <?php echo $_smarty_tpl->getVariable('profile')->value['email'];?>
');
					return false;
				}
				else 
         		{
					alert(result);
					return false;
				}
			});
    
  	 	});
   		$(document).on('change', '#image_upload_file', function () {
		var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');
		
		$('#image_upload_form').ajaxForm({
			beforeSend: function() {
				progressBar.fadeIn();
				var percentVal = '0%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			success: function(html, statusText, xhr, $form) {		
				obj = $.parseJSON(html);	
				if(obj.status){		
					var percentVal = '100%';
					bar.width(percentVal)
					percent.html(percentVal);
					$("#imgArea>img").prop('src',obj.image_medium);		
					$("#avatar").prop('src',obj.image_small);		
				}else{
					alert(obj.error);
				}
			},
			complete: function(xhr) {
				progressBar.fadeOut();			
			}	
		}).submit();		
		
		});
   });
   
</script>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>