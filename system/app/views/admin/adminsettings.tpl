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
                  <p><strong>Admin Settings Saved:</strong> Your Admin settings were saved succesfully on database.</p>
               </div>
               {/if}  
               {if $error_current_password eq '1'}
               <div class="alert alert-danger">
                  <p><strong>Error notification:</strong> Current password didn't match the one on database, try again.</p>
               </div>
               {/if}
               {if $error_new_password eq '1'}
               <div class="alert alert-danger">
                  <p><strong>Couldn't save new password:</strong> New password is not matching the confirmation password, try again.</p>
               </div>
               {/if}
               {if $smarty.session.message}
               <p class="alert alert-success">
                  {assign var=message_var value=CoreHelp::flash('message')}
                  {$message_var}
               </p>
               <br />
               {/if} 
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
               {foreach $errors as $error}
               <div class="alert alert-danger">
                  <p><strong>{$error@key}</strong> {$error}</p>
               </div>
               {/foreach}  <br />
               <h2 class="font-light m-b-xs">
                  Admin Settings
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <form action="#" method="post" class="validate-form form bt-space15"  autocomplete="off">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Admin Login: <span class="required">*</span></label>
                                          <input name="adminuser" type="text" class="required text form-control" id="textfield" size="35" value="{$admin_username}" />
                                       </div>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield2" class="form-label size-120 fl-space2">New  Password: </label>
                                          <input name="newadminpassword" type="password" class="text form-control" id="textfield2" size="35" value=""  />
                                       </div>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield2" class="form-label size-120 fl-space2">Confirm Password: </label>
                                          <input name="confirmadminpassword" type="password" class="text form-control" id="textfield3" size="35" value=""  />
                                       </div>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Contact E-Mail: <span class="required">*</span></label>
                                          <input name="admin_email" type="text" class="required text form-control" id="textfield4" size="35" value='{$settings.admin_email}' />
                                       </div>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="select" class="form-label size-120 fl-space2">Inactivity Logout: </label>
                                          <select id="select" class="form-control required" name="admin_inactivity">
                                          <option value="5" {if $settings.admin_inactivity eq '5'}selected="selected"{/if}>5 minutes</option>
                                          <option value="15" {if $settings.admin_inactivity eq '15'}selected="selected"{/if}>15 minutes</option>
                                          <option value="30" {if $settings.admin_inactivity eq '30'}selected="selected"{/if}>30 minutes</option>
                                          <option value="60" {if $settings.admin_inactivity eq '60'}selected="selected"{/if}>60 minutes</option>
                                          </select>
                                       </div>
                                       <br />
                                       <div class="form-field clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Current  Password: <span class="required">*</span></label>
                                          <input name="currentadminpassword" type="password" class="required text form-control" id="textfield5" size="35"  />
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-field clear">
                                    <br /><br />
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
{include file='footer.tpl'}
