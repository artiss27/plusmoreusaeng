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
                   
         <h1 class="font-light m-b-xs">
            Payout Account / <font color="green">Cuenta Para Pagar</font></h1><br><H5>This account lets you add funds from an exterior account into your membership to make payment for services. You could use Paypal, or upload via debit/credit or bank transfer via zelle.*<br><br><font color="green">Esta cuenta le permite agregar fondos de una cuenta exterior a su membresía para realizar el pago de los servicios. Puede usar Paypal o cargar mediante débito/crédito o transferencia bancaria a través de zelle.*</font></h5>
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
                        <div class="box-wrap clear"><h2>Current Balance / <font color="green">Balance Actual</font> <strong></strong></h2> <br />
	                        
                        	<form method="post" action="depositmoney">
                            <div class="form-group">
                            <label><h5>Amount To Be Transfered / <font color="green">Cantidad para transferir. </font></h5></label>
                            <input type="text" name="amount" value="" class="form-control form-half" />
                            </div>
                            <div class="form-group">
                            <label><h5>Trasaction Processor / <font color="green">Procesador de Transacion</font></h5></label>
                            <select name="processor" class="form-control form-half">
                            	{foreach key=key item=name from=$processors}   
                                	<option value="{$name.processor_id}">Use With {$name.name}</option>
                                {/foreach}
                            </select><br><p>Use Your Debit/Credit  Card.*</p>
<ul>
<li><a href="https://link.waveapps.com/suqrdh-ekrs6e">Deposit $99</a></li>
<li><a href="https://link.waveapps.com/n3z8xy-mcznvh">Deposit $199</a></li>
<li><a href="https://link.waveapps.com/6x8hth-xfnx6e">Deposit $299</a></li>
<li><a href="https://link.waveapps.com/ynunj7-fp4ht6">Deposit $399</a></li>
<li><a href="https://link.waveapps.com/fy5p9h-z5zhfj">Deposit $499</a></li>
<li><a href="https://link.waveapps.com/yufmt7-xu4jyq">Deposit $599</a></li>
<li><a href="https://link.waveapps.com/drjb5r-m9tpj7">Deposit $699</a></li>


</ul><br>* 3.5% Convenience Fee Applies to all debit/credit card or paypal transaction. Transfer via Zelle is free and post within 24 hours on your membership account.
                            </div>
                            <input type='submit' class="btn btn-sm btn-primary m-t-n-xs" value=" Add Funds ">
                            </form>
                        
                        	<br />
                            <h2>Member Account Activity</h2><br />
                           <div class="actions">
                              <form id="form1" name="form1" method="post" action="">{$filter} <input type='submit' class="btn btn-sm btn-primary m-t-n-xs" value=" Search "><input type='hidden' name='filter' value=1>
                              </form>
                           </div>
                           <br />
                           
                           <table id="wallet_deposit" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
	                                <th>ID</th>
                                    <th>{$lang.date}</th>
                                    <th>{$lang.amount}</th>
                                    <th>{$lang.description}</th>
                                 </tr>
                              </thead>
                              <tbody>
                              {if !$list}
                              <tr>
                                    <td colspan="4">{$lang.no_result_found}</td>
                                 </tr>
                              {else}
                                 {foreach key=obj item=name from=$list}                
                                 <tr>
	                                 <td>{$name.id}</td>
                                    <td>{$name.date}</td>
                                    <td>{$lang.monetary} {$name.amount}</td>
                                    <td>{$name.description}</td>
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
    	{if $list}$('#wallet_deposit').dataTable({
			"order": [[ 0, "desc" ]]
			});{/if} 
   });
   
</script>
{include file='footer.tpl'}