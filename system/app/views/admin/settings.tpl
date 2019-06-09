{include file='header.tpl'}
{include file='menu.tpl'}
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
               {if $settings_saved eq 'y'}
                     <div class="alert alert-success">
                        <p><strong>Settings Saved:</strong> Your settings were saved succesfully on database.</p>
                     </div>
                     {/if}  
                     {foreach $errors as $error}
                     <div class="alert alert-success">
                        <p><strong>{$error@key}</strong> {$error}</p>
                     </div>
                     {/foreach} 
                     {if $smarty.session.message}
                    <p class="alert alert-success">
                       {assign var=message_var value=CoreHelp::flash('message')}
                       {$message_var}
                    </p>
                    <br />
                    {/if} 
                    {if $smarty.session.error}
                    <p class="alert alert-danger">
                       {assign var=message_var value=CoreHelp::flash('error')}
                       {$message_var}
                    </p>
                    <br />
                    {/if} 
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
                                          <input name="site_name" type="text" class="required text form-control" id="textfield" size="35" value='{$settings.site_name}' />
                                       </div>
                                       <!-- /.form-field -->
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield2" class="form-label size-120 fl-space2">Script  URL: <span class="required">*</span></label>
                                          <input name="site_url" type="text" class="required text form-control" id="textfield2" size="35" value='{$settings.site_url}' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield3" class="form-label size-120 fl-space2">Script  Full Path: <span class="required">*</span></label>
                                          <input name="site_path" type="text" class="required text form-control" id="textfield3" size="35" value='{$settings.site_path}' />
                                       </div>
                                       <br>						
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Mail Gateway: <span class="required">*</span></label> <button type="button" class="btn btn-primary" onclick='AjaxFunction();'>Test with {$settings.mailgate}</button>
                                          <select id="select" name="mailgate" class="form-control">
                                          {$settings.mailgate}<option value="php" {if $settings.mailgate eq 'php'}selected="selected"{/if}>PHP</option>
                                          <option value="smtp" {if $settings.mailgate eq 'smtp'}selected="selected"{/if}>SMTP</option>
                                          <option value="smtp_ssl" {if $settings.mailgate eq 'smtp_ssl'}selected="selected"{/if}>SMTP with SSL</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield4" class="form-label size-120 fl-space2">SMTP Host: </label>
                                          <input name="smtp_host" type="text" class="text form-control" id="textfield4" size="35" value='{$settings.smtp_host}' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield5" class="form-label size-120 fl-space2">SMTP  Port: </label>
                                          <input name="smtp_port" type="text" class="text form-control" id="textfield5" size="35" value='{$settings.smtp_port}' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield5" class="form-label size-120 fl-space2">SMTP  Login: </label>
                                          <input name="smtp_login" type="text" class="text form-control" id="textfield5" size="35" value='{$settings.smtp_login}' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield6" class="form-label size-120 fl-space2">SMTP  Password: </label>
                                          <input name="smtp_password" type="password" class="text form-control" id="textfield6" size="35" value='{$settings.smtp_password}' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">BackOffice Language: <span class="required">*</span></label>
                                          <select id="select" name="backoffice_lang" class="form-control">
                                          {foreach key=key item=language from=$languages}
                                          <option value="{$key}" {if $settings.backoffice_lang eq $key}selected="selected"{/if}>{$language.name}</option>
                                          {/foreach}
                                          </select>
                                       </div>
                                       <br />
                                       <br />
                                       <p>Admin & Backoffice Menu Settings</p>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Activate Google Translator Widget on Admin Panel: </label>
                                          <select id="select" name="google_translator_admin" class="form-control">
                                            <option value="1" {if $settings.google_translator_admin eq '1'}selected="selected"{/if}>Yes</option>
                                          	<option value="0" {if $settings.google_translator_admin eq '0'}selected="selected"{/if}>No</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Activate Google Translator Widget on Members BackOffice: </label>
                                          <select id="select" name="google_translator_member" class="form-control">
                                            <option value="1" {if $settings.google_translator_member eq '1'}selected="selected"{/if}>Yes</option>
                                          	<option value="0" {if $settings.google_translator_member eq '0'}selected="selected"{/if}>No</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Show Advertising Menu on Members BackOffice: </label>
                                          <select id="select" name="show_adverting_menu_member" class="form-control">
                                            <option value="1" {if $settings.show_adverting_menu_member eq '1'}selected="selected"{/if}>Yes</option>
                                          	<option value="0" {if $settings.show_adverting_menu_member eq '0'}selected="selected"{/if}>No</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Show Digital Products Menu on Members BackOffice: </label>
                                          <select id="select" name="show_digital_menu_member" class="form-control">
                                            <option value="1" {if $settings.show_digital_menu_member eq '1'}selected="selected"{/if}>Yes</option>
                                          	<option value="0" {if $settings.show_digital_menu_member eq '0'}selected="selected"{/if}>No</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Show FAQ Menu on Members BackOffice: </label>
                                          <select id="select" name="show_faq_menu_member" class="form-control">
                                            <option value="1" {if $settings.show_faq_menu_member eq '1'}selected="selected"{/if}>Yes</option>
                                          	<option value="0" {if $settings.show_faq_menu_member eq '0'}selected="selected"{/if}>No</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <p>Wordpress Settings</p>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Use Included Wordpress Installation for Frontpage: </label>
                                          <select id="select" name="use_wordpress_bundle" class="form-control">
                                            <option value="yes" {if $settings.use_wordpress_bundle eq 'yes'}selected="selected"{/if}>Use bundled wordpress installation</option>
                                          	<option value="no" {if $settings.use_wordpress_bundle eq 'no'}selected="selected"{/if}>Redirect to other URL for frontpage</option>
                                          </select>
                                       </div>                                		
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield6" class="form-label size-120 fl-space2">If Redirect to External URL for Frontpage, use this URL: </label>
                                          <input name="front_page_redirect_url" type="text" class="text form-control" id="textfield6" size="35" value='{$settings.front_page_redirect_url}' />
                                       </div>
                                       <br>
                                       <div class="form-field clear">
                                          <label for="textfield6" class="form-label size-120 fl-space2">Wordpress Username for autologin: </label>
                                          <input name="wordpress_admin_username" type="text" class="text form-control" id="textfield6" size="35" value='{if $settings.wordpress_admin_username}{$settings.wordpress_admin_username}{else}admin{/if}' />
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
{include file='footer_scripts.tpl'}
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
{include file='footer.tpl'}