﻿{include file='header.tpl'}
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
          Ordenes de tus Referidos / <font color="green">Referral Orders </font>
         </h2>
         <small>Comisiones Ganadas / <font color="green">Earned Commissions</font></small>
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
            {foreach $errors as $error}
            <p class="alert alert-danger">
               {$error}
            </p>
            <br />
            {/foreach}  
            <div class="main pagesize">
               <!-- *** mainpage layout *** 
<h3>Balance Disponible / <font color="green">Available Balance</font> <strong>{$lang.monetary} {$balance}</strong></h3> --><br />
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <div class="actions">
                              <form id="form1" name="form1" method="post" action=""> {$filter} <input type='submit' class="btn btn-sm btn-primary m-t-n-xs" value=" Buscar "><input type='hidden' name='filter' value=1>
                              </form>
                           </div>
                           <br />
                           
                           <table id="wallet_payout" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
	                                 <th>Trasaction ID/ <font color="green">Codigo de Transaccion</font></th>
                                    <th> Fecha / <font color="green">Date</font></th>
                                    <th>Comision/<font color="green">Commission</font></th>
                                    <th>Numero de Recibo/<font color="green">Invoice Number</font></th>
                                 </tr>
                              </thead>
                              <tbody>
                              {if !$list}
                              <tr>
                                    <td colspan="4">No se encontro comisiones / <font color="green">No commissions found</font></td>
                                 </tr>
                              {else}
                                 {foreach key=obj item=name from=$list}                
                                 <tr>
                                 	<td>
<font color="green">{$name.transaction_id}</font></td>
                                    <td>{$name.date}</td>
                                    <td><font color="green">{$lang.monetary} {$name.amount}</font></td>
                                    <td><font color="green">{$name.description}</font></td>
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
    	{if $list}$('#wallet_payout').dataTable({
			"order": [[ 0, "desc" ]]
			});{/if}    
   });
   
</script>
{include file='footer.tpl'}