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
            {$lang.ad_credits}
         </h2>
         <small>{$lang.ad_credits}</small>
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
            {/if} <br /> 
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                        
                        <form id="form1" method="post" action="">
                              <p>{$lang.purchase_credits} : </p>
                              <select class="form-control form-half" name="credits" id="select">
                                 {for $credits=10 to 2000 step 10}
      
                                 <option value="{$credits}">{$credits} {$lang.ad_credits} ({$lang.monetary}{$credits|number_format:2:".":","})</option>
                                 {/for}              
                              </select><br />
                              <p>{$lang.using_this_wallet} :</p>
                              <select class="form-control form-half" name="wallet" id="select">
                                <option value="deposit">{$lang.deposit_wallet} ({$lang.monetary}{$total_deposit})</option>
                                <option value="payout">{$lang.payout_wallet} ({$lang.monetary}{$total_payout})</option>        
                              </select>
                              <input type="submit" name="form1" id="button" class="btn btn-sm btn-primary m-t-n-xs" value=" {$lang.pay} " />
                           </form>
                        	<br />
                           <p>{$lang.total_ad_credits}: <strong>{$ad_credits}</strong></p>
                           <table id="ad_credits" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>{$lang.amount}</th>
                                    <th>{$lang.description}</th>
                                    <th>{$lang.date}</th>
                                 </tr>
                              </thead>
                              <tbody>
                              {if !$log}
                              <tr>
                                    <td colspan="4">{$lang.no_result_found}</td>
                                 </tr>
                              {else}
                                 {foreach key=obj item=name from=$log}   
                                 <tr>
                                    <td>{$name.id}</td>
                                    <td>{$name.amount}</td>
                                    <td>{$name.description}</td>
                                    <td>{$name.created_at}</td>
                                 </tr>
                                 {/foreach}
                              {/if}   
                              </tbody>
                           </table>
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
     $(document).ready( function() {  
    	{if $log}$('#ad_credits').dataTable({
  		 "order": [[ 0, "desc" ]]
   		});{/if}    
   });
   
   
</script>
{include file='footer.tpl'}
