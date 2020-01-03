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
            Retiro de Fondos</h2></font><font size="h4">Funds Withdrawal</h4></font>
         
        
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
                           <h4>Fondos Disponibles Por Referidos<br></h4></h6>Available Funds From Referrals:</h6><br><br><h2> <strong>{$lang.monetary} {$total_cash}</h2></strong><br/>
                           <!--{$lang.withdrawal_fee}: <strong>{$requestfee}%</strong><br />-->
                           Metodo de Pago/<font color="green">Payment Method</font>: <br><strong>{$processor}: {$paymethod}</strong><br /><br />
                           {if $total_cash >= $min_cash_out}
                               {if $paymethod}
                                	{if $wirhdrawal_is_open == 1}
                                    	{if $is_active == 1}
                                           <form action='/members/requestwithdrawal' name='cash_o' method='POST'>
                                                <div class="form-group">
                                                <label>Cantidad/<font color="green">Amount</font> :</label>
                                                 <input type="text" name="amount" value="10.00"  class="form-control form-half" />
                                                </div>
                                                <div class="form-group">
                                                    <input type='submit' class='btn btn-sm btn-primary m-t-n-xs' value='Pide el Retiro/Request a Withdrawal'>
                                                </div>
                                           </form>
                                           {else}
                                           		<table>
                                                  <tr>
                                                     <td align='center'><b>{$lang.your_selected_processor_is_not_available} {$active_processors}</b></td>
                                                  </tr>
                                               </table> 
                                        {/if}    
                                    {else}
                                    	<table>
                                          <tr>
                                             <td align='center'><b>{$lang.withdrawal_is_not_open_today}</b></td>
                                          </tr>
                                       </table>                                    
                                    {/if}   
                               {else}
                               <table>
                                  <tr>
                                     <td align='center'><font color=red><b>{$lang.register_your_withdrawal_method_on_your_profile_first}</b></font></td>
                                  </tr>
                               </table>
                               {/if}
                           {else}
                           <table>
                              <tr>
                                 <td align='center'>{$lang.you_need} <strong>{$lang.monetary} {$min_cash_out}</strong> {$lang.at_least_to_be_able_to_request_a_withdrawal}</td>
                              </tr>
                           </table>
                           {/if}
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
    
    
   });
   
</script>
{include file='footer.tpl'}