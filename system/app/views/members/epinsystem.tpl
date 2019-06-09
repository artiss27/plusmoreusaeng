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
            {$lang.pif_system}
         </h2>
         <small>{$lang.pif_system}</small>
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
                        
                        <table id="epins" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                 	<th>ID</th>
                                    <th>{$lang.code}</th>
                                    <th>{$lang.pifs_membership}</th>
                                    <th>{$lang.amount}</th>
                                    <th>{$lang.used}</th>
                                    <th>{$lang.used_by}</th>
                                    <th>{$lang.date_purchased}</th>
                                    <th>{$lang.date_used}</th>
                                 </tr>
                              </thead>
                              <tbody>
            					{if !$epins}
                                 <tr>
                                    <td colspan="8">{$lang.no_result_found}</td>
                                 </tr>
                                 {else}
                                 {foreach key=obj item=epin from=$epins}
                                 <tr>
                                 	<td>{$epin.id}</td>
                                    <td>{$epin.code}</td>
                                    <th>{$member->getMembershipById($epin.membership_id)}</th>
                                    <td>{$lang.monetary} {$epin.amount_paid}</td>
                                    <td>{if $epin.used_by_member_id > 0}{$lang.yes}{else}{$lang.no}{/if}</td>
                                    <th>{if $epin.used_by_member_id > 0}{$member->getUsernameById($epin.used_by_member_id)}{else}-{/if}</th>
                                    <td>{$epin.date_purchased|date_format}</td>
                                    <td>{if $epin.date_used > 0}{$epin.date_used|date_format}{else}-{/if}</td>
                                 </tr>
                                 {/foreach}
                                 {/if}
                              </tbody>
                           </table>
                          <!-- <p><a href="/members/pendingreferrers">{$lang.view_my_pending_members}</a></p><br />-->
                           <form id="form1" method="post" action="">
                              <p>{$lang.purchase_pif} : </p>
                              <select class="form-control form-half" name="membership" id="select">
                                 {foreach key=obj item=name from=$memberships}
                                 		{capture assign=fee}{$name}_signup_fee{/capture}
                                        {capture assign=sub}{$name}_subscription_days{/capture}
                                 {if $settings.$fee > 0}<option value="{$name}">{$name} {if $settings.$sub}{$lang.for} {$settings.$sub} {$lang.days} {/if}({$lang.monetary} {$settings.$fee|number_format:"2":".":""})</option>{/if}
                                 {/foreach}              
                              </select><br /><br />
                              <p>Using this wallet :</p>
                              <select class="form-control form-half" name="wallet" id="select">
                                <option value="deposit">{$lang.deposit_wallet} ({$lang.monetary} {$total_deposit})</option>
                                <option value="payout">{$lang.payout_wallet} ({$lang.monetary} {$total_payout})</option>        
                              </select>
                              <input type="submit" name="form1" id="button" class="btn btn-sm btn-primary m-t-n-xs" value=" {$lang.pay} " />
                           </form>
                           </p>
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
<script>
   $(function () {
   	{if $epins}$('#epins').dataTable({
  		 "order": [[ 0, "desc" ]]
   		});{/if}    
    
   });
   
</script>
{include file='footer.tpl'}