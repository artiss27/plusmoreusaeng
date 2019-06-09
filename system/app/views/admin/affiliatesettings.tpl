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
               <div class="alert alert-success">
                  <p><strong>{$error@key}</strong> {$error}</p>
               </div>
               {/foreach} <br />
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
                                          {if $is_hybrid == 1}
                                          	{$hybrid}
                                          {else}
                                          	{$hooks->do_action('affiliate_setting')}
                                          {/if}				      
                                          </select>
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Email Affiliate On New Commission :</label> 
                                          <select id="alert_commision" class="form-control required" name="alert_commission">
                                          <option value="yes" {if $settings.alert_commission eq 'yes'}selected="selected"{/if}>Yes</option>
                                          <option value="no" {if $settings.alert_commission eq 'no'}selected="selected"{/if}>No</option>     
                                          </select>
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Email Affiliate on Referral Signup :</label>
                                          <select id="alert_downline" class="form-control required" name="alert_downline">
                                          <option value="yes" {if $settings.alert_downline eq 'yes'}selected="selected"{/if}>Yes</option>
                                          <option value="no" {if $settings.alert_downline eq 'no'}selected="selected"{/if}>No</option>
                                          </select>
                                       </div>
                                       <br />
                                       <div class="clear">
										<label for="textfield" class="fl-space size-300">Processors Fee Paid By :</label>
										<select id="processor_fee_by" class="form-control required" name="processor_fee_by">
										<option value="owner" {if $settings.processor_fee_by eq 'owner'}selected="selected"{/if}>Owner</option>
										<option value="member" {if $settings.processor_fee_by eq 'member'}selected="selected"{/if}>Member</option>
										</select>
										</div>
										<br />
                                         <div class="clear">
                                          <label for="textfield2" class="fl-space size-300">Min Amount for Deposit :</label>
                                          $
                                          <input name="min_deposit" type="text" value="{$settings.min_deposit}" class="form-control" size="5" />
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
{include file='footer_scripts.tpl'}
{include file='footer.tpl'}