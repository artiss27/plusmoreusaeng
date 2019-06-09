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
           MIS PAGOS/<font color="green">MY PAYMENTS</FONT>
         </h2>
         <small>Historial de mis pagos de comisiones/<font color="green">my commission payment history</font></small>
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
                           <table id="withdrawals" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th>Fecha/<font color="green">date</font></th>
                                    <th>Cantidad/<font color="green">{$lang.amount}</font></th>
                                    
                                    <th>{$lang.withdrawal_account_id}</th>
                                    <th>Estatus/<font color="green">{$lang.status}</font></th>
                                 </tr>
                              </thead>
                              <tbody>
                              {if !$list}
                              <tr>
                                    <td colspan="6">No Hay Resultados / <font color="green">{$lang.no_result_found}</font></td>
                                 </tr>
                              {else}
                                 {foreach key=obj item=name from=$list}                
                                 <tr>
                                    <td>{$name.date}</td>
                                    <td>{$lang.monetary}{$name.amount}</td>
                                    <td>{$lang.monetary}{$name.fee}</td>
                                    <td>{$name.processor}</td>
                                    <td>{$name.processorid}</td>
                                    <td>{$name.status} {$name.cancel}</td>
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
    	{if $list}$('#withdrawals').dataTable({
			"order": [[ 0, "desc" ]]
			});{/if}    
   });
   
</script>
{include file='footer.tpl'}