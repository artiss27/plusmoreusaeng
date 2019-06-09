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
            Membership Subscription Settings
         </h2>
         <small>Membership Subscription Settings</small>
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
                                       <label for="textfield" class="fl-space size-300">Subscription System Active :</label> 
                                       <select id="subscription_active" class="form-control required" name="subscription_active">
                                       <option value="yes" {if $settings.subscription_active eq 'yes'}selected="selected"{/if}>Yes</option>
                                       <option value="no" {if $settings.subscription_active eq 'no'}selected="selected"{/if}>No</option>     
                                       </select>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Expired Member :</label>
                                       <select id="subscription_expired_behaviour" class="form-control required" name="subscription_expired_behaviour">
                                       <option value="can_earn_cant_withdraw" {if $settings.subscription_expired_behaviour eq 'can_earn_cant_withdraw'}selected="selected"{/if}>Can earn commissions, but can't withdraw money</option>
                                       <option value="can_earn_can_withdraw" {if $settings.subscription_expired_behaviour eq 'can_earn_can_withdraw'}selected="selected"{/if}>Can't earn commissions, but can withdraw money</option>
                                       <option value="cant_earn_cant_withdraw" {if $settings.subscription_expired_behaviour eq 'cant_earn_cant_withdraw'}selected="selected"{/if}>Can't earn commissions, and can't withdraw money</option>
                                       </select>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Rollup Commissions for Expired Members :</label> 
                                       <select id="subscription_expired_rollup" class="form-control required" name="subscription_expired_rollup">
                                       <option value="yes" {if $settings.subscription_active eq 'yes'}selected="selected"{/if}>Yes</option>
                                       <option value="no" {if $settings.subscription_active eq 'no'}selected="selected"{/if}>No</option>     
                                       </select>
                                    </div>
                                    <br />
                                    
                                    <br />
                                    <strong>Membership Subscription Days:</strong><br />
                                    <br />
                                    {foreach key=obj item=name from=$memberships}
                                    <div class="form-field clear">
                                       <label for="textfieldx" class="fl-space size-300">{$name|replace:"_":" "} :</label>
                                       {capture assign=comm}{$name}_subscription_days{/capture}
                                       <input name="{$name}_subscription_days" type="text" value="{$settings.$comm}" size="5" class="form-control" />
                                    </div>
                                    {/foreach}
                                    <div class="clear"></div>
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
   
   });
</script>
{include file='views/admin/footer.tpl'}