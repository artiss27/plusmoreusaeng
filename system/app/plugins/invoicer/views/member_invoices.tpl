{include file='views/members/header.tpl'}
{include file='views/members/menu.tpl'}
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
            {include file='views/members/breadcrumb.tpl'}            
            <h2 class="font-light m-b-xs">
               {$plugin_lang.invoices}
            </h2>
            <small>{$plugin_lang.invoices}</small>
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
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                               <h3>History</h3>
                        	<table id="invoices" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th>Reference</th>
                                    <th>Item Name</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Paid Date</th>
                                    <th>Download Invoice</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 {if !$invoices}
                                 <tr>
                                    <td colspan="6">{$lang.no_result_found}</td>
                                 </tr>
                                 {else}
                                 {foreach key=obj item=invoice from=$invoices} 
                                 <tr>
                                    <td>{$invoice.reference_number}</td>
                                    <td>{$invoice.item_name}</td>
                                    <td>{$invoice.item_description}</td>
                                    <td>{$lang.monetary}{$invoice.total_amount}</td>
                                    <td>{$invoice.date}</td>        
                                    <td><a href="/files/invoices/{$invoice.reference_number}.pdf" target="_blank">{$invoice.reference_number}.pdf</a></td>                       
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
{include file='views/members/right_sidebar.tpl'}   
<!-- Vendor scrits -->
{include file='views/members/vendor_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
   	{if $invoices}$('#invoices').dataTable({
        	"order": [[ 0, "desc" ]]
    	});{/if} 
   });
</script>
{include file='views/members/footer.tpl'}