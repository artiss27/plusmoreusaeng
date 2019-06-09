{include file='views/admin/header.tpl'}
{include file='views/admin/menu.tpl'}
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
            Unilevel Settings
         </h2>
         <small>Setup your Unilevel levels</small>
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
            <p class="alert alert-danger">
               {$error}
            </p>
            <br />
            {/foreach}  
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <form action="#" method="post" class="validate-form form bt-space5">
                              <div class="columns clear bt-space5">
                                 <div class="col2-3">
                                    <div class="clear"></div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Qualification Required To Withdraw Money:</label> 
                                       <select id="settings_qualification_required" class="form-control required" name="settings_qualification_required">
                                       <option value="yes" {if $settings.settings_qualification_required eq 'yes'}selected="selected"{/if}>Yes</option>
                                       <option value="no" {if $settings.settings_qualification_required eq 'no'}selected="selected"{/if}>No</option>     
                                       </select>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">If Qualification is Required, Setup The Required Amount of Paid Members:</label>
										<input name="settings_qualification_required_members" type="text" value="{if $settings.settings_qualification_required_members}{$settings.settings_qualification_required_members}{else}0{/if}" size="5" class="form-control" />
                                    </div>
                                    <br /><br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Sales Points Volume Round Mode:</label> 
                                       <select id="setting_unilevel_round_type" class="form-control required" name="setting_unilevel_round_type">
                                       <option value="ceil" {if $settings.setting_unilevel_round_type eq 'ceil'}selected="selected"{/if}>Ceil</option>
                                       <option value="floor" {if $settings.setting_unilevel_round_type eq 'floor'}selected="selected"{/if}>Floor</option>     
                                       </select>
                                    </div>
                                    <br />
                                    <div class="form-field clear">
                                       <label for="textfieldx" class="fl-space size-300">Trace Personal Volume From The Last "x" Days :</label>
                                         <input name="setting_unilevel_pv_days" type="text" value="{if $settings.setting_unilevel_pv_days}{$settings.setting_unilevel_pv_days}{else}60{/if}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="form-field clear">
                                       <label for="textfieldx" class="fl-space size-300">Trace Group Volume From The Last "x" Days :</label>
                                         <input name="setting_unilevel_gv_days" type="text" value="{if $settings.setting_unilevel_gv_days}{$settings.setting_unilevel_gv_days}{else}60{/if}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="form-field clear">
                                       <label for="textfieldx" class="fl-space size-300">Trace Group Volume Levels Depth:</label>
                                         <input name="setting_unilevel_gv_depth" type="text" value="{$settings.setting_unilevel_gv_depth}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Use Dynamic Compression For Commissions:</label> 
                                       <select id="setting_unilevel_dynamic_compression" class="form-control required" name="setting_unilevel_dynamic_compression">
                                       <option value="yes" {if $settings.setting_unilevel_dynamic_compression eq 'yes'}selected="selected"{/if}>Yes</option>
                                       <option value="no" {if $settings.setting_unilevel_dynamic_compression eq 'no'}selected="selected"{/if}>No</option>     
                                       </select>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label class="fl-space size-300">Number Of Levels On your Unilevel Plan</label>        
                                       <input id="level_number" name="setting_membership_unilevel_levels" type="text" value="{if $settings.setting_membership_unilevel_levels}{$settings.setting_membership_unilevel_levels}{else}2{/if}" size="5" class="form-control" />
                                    </div>
                                    
                                    <a href="#" onclick="refresh_levels();return false;" class="btn btn-primary btn-xs">refresh levels</a>
                                    <br /><br />
                                    <table class="table">
	                                    <thead>
                                    		<th>Level</th>
                                            <th>Unqualified Commission %</th>
                                            <th>Qualified Commission %</th>
                                            <th>Qualified Required Front Line Members</th>
                                            <th>Qualified Required Personal Volume</th>
                                            <th>Qualified Required Group Volume</th>
          	                                </thead>
                                        <tbody id="levels" tabindex='1'>
                                        </tbody>
                                        </table>                                    
                                 </div>
                              </div>
                              <div class="clear">
                                 <br><br>
                                 <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
                                 <p class="clean-padding">
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
{include file='views/admin/footer_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
	   upercent = new Array();
	   qpercent = new Array();
	   front = new Array();
	   pv = new Array();
	   gv = new Array();
	   {for $foo=1 to 50}
 		{capture assign=level}setting_membership_unilevel_unqualified_commision_{$foo}{/capture}
		upercent[{$foo}] = {if $settings.$level}{$settings.$level}{else}0.00{/if}; 		
		{capture assign=level}setting_membership_unilevel_qualified_commision_{$foo}{/capture}
		qpercent[{$foo}] = {if $settings.$level}{$settings.$level}{else}0.00{/if};
		{capture assign=level}setting_membership_unilevel_frontline_commision_{$foo}{/capture}
		front[{$foo}] = {if $settings.$level}{$settings.$level}{else}0.00{/if}; 
		{capture assign=level}setting_membership_unilevel_pv_commision_{$foo}{/capture}
		pv[{$foo}] = {if $settings.$level}{$settings.$level}{else}0.00{/if}; 	
		{capture assign=level}setting_membership_unilevel_gv_commision_{$foo}{/capture}
		gv[{$foo}] = {if $settings.$level}{$settings.$level}{else}0.00{/if}; 						
		{/for}
   		var levels = $('#level_number').val();
		for (i = 1; i <= levels; i++) { 
    		$("#levels").append( '<tr>\
									<td>'+i+'</td>\
									<td><input name="setting_membership_unilevel_unqualified_commision_'+ i +'" type="text" value="'+ upercent[i].toFixed(2) +'" size="5" class="form-control" /></td>\
									<td><input name="setting_membership_unilevel_qualified_commision_'+ i +'" type="text" value="'+ qpercent[i].toFixed(2) +'" size="5" class="form-control" /></td>\
									<td><input name="setting_membership_unilevel_frontline_commision_'+ i +'" type="text" value="'+ front[i] +'" size="5" class="form-control" /></td>\
									<td><input name="setting_membership_unilevel_pv_commision_'+ i +'" type="text" value="'+ pv[i] +'" size="5" class="form-control" /></td>\
									<td><input name="setting_membership_unilevel_gv_commision_'+ i +'" type="text" value="'+ gv[i] +'" size="5" class="form-control" /></td>\
								</tr>');
		}
		
		
   });
   function refresh_levels() {	   
		$("#levels").html('');
		var levels = $('#level_number').val();
		for (i = 1; i <= levels; i++) { 
    		$("#levels").append( '<tr>\
									<td>'+i+'</td>\
									<td><input name="setting_membership_unilevel_unqualified_commision_'+ i +'" type="text" value="'+ upercent[i].toFixed(2) +'" size="5" class="form-control" /></td>\
									<td><input name="setting_membership_unilevel_qualified_commision_'+ i +'" type="text" value="'+ qpercent[i].toFixed(2) +'" size="5" class="form-control" /></td>\
									<td><input name="setting_membership_unilevel_frontline_commision_'+ i +'" type="text" value="'+ front[i] +'" size="5" class="form-control" /></td>\
									<td><input name="setting_membership_unilevel_pv_commision_'+ i +'" type="text" value="'+ pv[i] +'" size="5" class="form-control" /></td>\
									<td><input name="setting_membership_unilevel_gv_commision_'+ i +'" type="text" value="'+ gv[i] +'" size="5" class="form-control" /></td>\
								</tr>');
		}
		 var scrollPos =  $("#levels").offset().top;
		 	$(window).scrollTop(scrollPos);
		}
   
</script>
{include file='views/admin/footer.tpl'}
