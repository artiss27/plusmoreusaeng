{include file='header.tpl'}
{include file='menu.tpl'}
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
            {$lang.upgrade_system}
         </h2>
         <small>{$lang.upgrade_your_membership}</small>
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
            <p class="alert alert-danger">
               {assign var=message_var value=CoreHelp::flash('error')}
            	{$message_var}
            </p>
            <br />
            {/if}  
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           {if $topmem eq "yes" && $membership_expiration eq $lang.never}
                           {$lang.you_have_already_the_top_membership_on_the_system_came_back_later} 
                           {else}
                           <form id="form1" method="post" action="">
                           <h5>{$lang.membership}: <strong>{$membership}</strong></h5>
                                                 
                            <h5>{$lang.membership_expiration}: <strong>{$membership_expiration}</strong></h5>
                            <br />
                              <p>{$lang.upgrade_to_this_membership} : </p>
                              <select class="form-control form-half" name="membership" id="select">
                                 {foreach key=obj item=name from=$availmemberships}
                                 {insert name=GetMemPrice assign=price mem=$name.membership}
                                 {capture assign=sub}{$name.membership}_subscription_days{/capture}
                                 {if $price.value > 0}<option value="{$name.membership}">{$name.membership} {if $settings.$sub}{$lang.for} {$settings.$sub} {$lang.days} {/if}({$lang.monetary} {$price.value|number_format:"2":".":""}) {if $name.membership eq $membership and $membership_expiration ne $lang.never}{$lang.renew_membership}{/if}</option>{/if}
                                 {/foreach}              
                              </select><br />
                              <p>Pay upgrade with this Account:</p>
                              <select class="form-control form-half" name="wallet" id="select">
                                <option value="deposit">Personal PlusMoreUsa Account ({$lang.monetary} {$total_deposit})</option>
                                <option value="payout">Business Membership Account ({$lang.monetary} {$total_payout})</option>        
                              </select><br />
                              <a href="/members/depositwallet">Fund Personal Account</a><br />
                              <input type="submit" name="form1" id="button" class="btn btn-sm btn-primary m-t-n-xs" value=" Upgrade Now " />
                           </form>           
                           {/if}
                           
                          <!-- <br />{$lang.or}<br /><br />
                           <form id="form1" method="post" action="redeempin">
                           <div class="form-group">
							<label>{$lang.redeem_epin_code}</label>	
                             <div class="input">																								
								<input type="text" class="form-control" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" name="code" value="" maxlength="36">												
                             </div>
						   </div>  -->
                   <!--        <input type="submit" name="form1" id="button" class="btn btn-sm btn-primary m-t-n-xs" value=" {$lang.redeem} " />
                           </form>  
                        </div>
                     </div>-->
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
<script>
   $(function () {
    
    
   });
   
</script>
{include file='footer.tpl'}