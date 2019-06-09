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
               {$plugin_lang.store_sales}
            </h2>
            <small>{$plugin_lang.store_sales}</small>
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
                             
							<table id="store_sales" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th>{$plugin_lang.sale_date}</th>
                                    <th>{$plugin_lang.email}</th>
                                    <th>{$plugin_lang.product_code}</th>
                                    <th>{$plugin_lang.product_name}</th>
                                    <th>{$plugin_lang.quantity}</th>
                                    <th>{$plugin_lang.image}</th>
                                    <th>{$plugin_lang.total_amount}</th>
                                 </tr>
                              </thead>
                              <tbody>
                              {if !$sales}
                              <tr>
                                    <td colspan="7">{$plugin_lang.no_result_found}</td>
                                 </tr>
                              {else}
                                 {foreach key=obj item=name from=$sales}   
                                 <tr>
                                    <td>{$name.dateorder}</td>
                                    <td>{$name.payer_email}</td>
                                    <td>{$name.item_number}</td>
                                    <td>{$name.item_name}</td>
                                    <td>{$name.quantity}</td>
                                    <td>{if $cart->getProductImage($name.item_number)} <img src="/system/app/plugins/cart/assets/{$cart->getProductImage($name.item_number)}" width="100" />{/if}</td>
                                    <td>${$name.mc_gross|number_format:2:".":","}</td>
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
   	{if $sales}$('#store_sales').dataTable({
  		 "order": [[ 0, "desc" ]]
   		});{/if}  
   });
</script>
{include file='views/members/footer.tpl'}
