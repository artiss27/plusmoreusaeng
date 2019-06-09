﻿{include file='header.tpl'}
{include file='menu.tpl'}
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
         {include file='breadcrumb.tpl'}            
         <h2 class="font-light m-b-xs">
            My Profile / <font color="green">Mi Perfil</font></h2>
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
            {if $smarty.session.message}
            <p class="alert alert-success">
               {assign var=message_var value=CoreHelp::flash('message')}
               {$message_var}
            </p>
            <br />
            {/if} 
            {if $member_edited eq 'y'}
            <p class="alert alert-success">
               <strong>{$lang.settings_edited}:</strong> {$lang.settings_edited_succesfully_to_database}
            </p>
            <br />
            {/if}  
            {foreach $errors as $error}
            <p class="alert alert-danger">
               {$error}
            </p>
            <br />
            {/foreach} 
            {if $smarty.session.error}
           {assign var=message_var value=CoreHelp::flash('error')}            	
           {if $message_var|is_array}
           {foreach $message_var as $error}
           <p class="alert alert-danger">
              {$error}
           </p>
           <br />
           {/foreach} 
           {else}
           <p class="alert alert-danger">
              {$message_var}
           </p>
           <br />
           {/if}
           {/if} 
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                     <div id="imgContainer">
                      <form enctype="multipart/form-data" action="/members/uploadpic" method="post" name="image_upload_form" id="image_upload_form">
                      	{assign var=pic value=CoreHelp::getProfileUploadPic()}
                        <div id="imgArea"><img src="{$pic}">
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
					{$hooks->do_action('show_webcam_form')}	
					</div>
                        <div class="box-wrap clear">
                           <form role="form" id="form" method="post">
                              <fieldset>
                                 <legend>Personal Information / <font color="green">Contacto Personal</font></legend>
                                 <div class="form-group">                                      
                                    <label for="name">First Name / <font color="green">Primer Nombre</font></label>
                                    <input type="text" name="firstName" value="{$profile.first_name}" class="form-control form-half" />
                                 </div>
                                 <div class="form-group">  
                                    <label for="name"><br>Last Name / <font color="green">Apellido</font></label>
                                    <input type="text" name="lastName" value="{$profile.last_name}"  class="form-control form-half" />
                                 </div>
                                 <div class="form-group">  
                                    <label for="name">Email / <font color="green">Correo Electronico</font></label>
                                    <input type="text" name="email" value="{$profile.email}"  class="form-control form-half" />
                                 </div>
                              </fieldset>
                              <fieldset>
                                 <legend>Account Access / <font color="green">Acceso a tu Cuenta</font>
                                 </legend>
                                 <div class="form-group">
                                    <div class="form-group">  
                                       <label for="name">User / <font color="green">Usuario: </font></label>
                                       {$profile.username}
                                    </div>
                                    <div class="form-group">  <label for="name"></label>
                                       &nbsp;&nbsp;&nbsp;<a href="/members/resetpassword" class="btn btn-sm btn-primary m-t-n-xs">Change Password /</font> <font color="yellow">Cambiar Contrase&ntilde;a</font></a>
                                    </div>
                                 </div>
                              </fieldset>
                              <fieldset>
                                 <legend>Address / <font color="green">Direccion</font></legend>
                                 <div class="form-group">
                                    <div class="form-group">  
                                       <label for="name">Street / <font color="green">Calle</font></label>
                                       <input type="text" name="street" value="{$profile.street}" class="form-control form-half" />
                                    </div>
                                    <div class="form-group">  
                                       <label for="name">City / <font color="green">Ciudad</font></label>
                                       <input type="text" name="city" value="{$profile.city}"  class="form-control form-half" />
                                    </div>
                                    <div class="form-group">  
                                       <label for="name">State / <font color="green">Estado </font></label>
                                       <input type="text" name="state" value="{$profile.state}"  class="form-control form-half" />
                                    </div>
                                      
                                    <div class="form-group">  
                                       <label for="name">Zip Code / <font color="green">Apartado Postal</font></label>
                                       <input type="text" name="postal" value="{$profile.postal}"  class="form-control form-half" />
                                    </div><div class="form-group">  
                                        <label for="select1">{$lang.country} / <font color="green">Pais</font></label> 
                                        <select name="country" class="form-control form-half">
                                        {foreach key=obj item=name from=$countries}
                                        <option value="{$name.code}" {if $profile.country eq "{$name.code}"}selected="selected"{/if}>{$name.country}</option>
                                        {/foreach}
                                        </select>
                                 	</div>
                                    <div class="form-group">  
                                       <label for="name">Contact Number / <font color="green">Numero de Contacto </font></label>
                                       <input type="text" name="phone" value="{$profile.phone}"  class="form-control form-half"  />
                                    </div>
                                 </div>
                              </fieldset>
                              <fieldset>
                                 <legend>Payments and Deposit Information / <font color="green">Informacion Para Pagos Y Depositos </font>
                                 </legend>
                                 <div class="form-group">  
                                    <label for="select1">Withdrawal Processor / <font color="green">Procesador de Pagos y Retiros</font></label> 
                                    <select size="1" id="select1" name="processor" class="form-control form-half">
                                    {foreach key=obj item=name from=$processors}
                                    <option value="{$name.processor_id}" {if $profile.processor eq "{$name.processor_id}"}selected="selected"{/if}>{$name.name}</option>
                                    {/foreach}
                                    </select>
                                 </div>
                         <!-- <div class="form-group">  
                                    <label for="name">Id Para Retiros :</label> 
                                    <input type="text" name="account_id" value="{$profile.account_id}" class="form-control form-half" />
                                 </div>
                                 
                               <div class="form-group">  
                                    <label for="name">Security Token / <font color="green">Codigo de Seguridad</font></label> 
                                    <input type="text" name="token" value="" class="form-control form-half" /> <div id="modal"><a id="get_token" class="btn btn-sm m-r-5">Request Security Token to Email</a></div>-->
                                    
                                 </div>
                                 
                                 <div class="buttons">
                                    <button name="save" type="submit" class="btn btn-sm btn-primary m-t-n-xs" value="submit">Save /</font> <font color="yellow">Guardar</font></button>
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
{include file='right_sidebar.tpl'}   
<!-- Vendor scrits -->
{include file='vendor_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script src="/assets/members/js/jquery.form.js"></script>
<script>
{literal}
   $(function () {
    	jQuery('#get_token').click(function(event){
			id = 1;
			jQuery('#modal').html('processing...');
			jQuery.post("/members/sendtoken", {id: id}, function(result) { 
				jQuery('#modal').html('');
         		if (result == "done") 
         		{
					alert('Token sent to {/literal}{$profile.email}{literal}');
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
{/literal}   
</script>
{include file='footer.tpl'}