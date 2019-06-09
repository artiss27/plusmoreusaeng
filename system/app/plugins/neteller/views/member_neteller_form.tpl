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
            {$plugin_lang.neteller_deposit}
         </h2>
         <small>{$plugin_lang.neteller_deposit}</small>
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
                         
                         <form id="neteller" action="" method="post">
  										<div class="form-body">
											<div class="note tile-title">
                                            	<img src="/system/app/plugins/neteller/views/neteller-logo.png" />
												<h4>{$plugin_lang.amount}: {$lang.monetary}{$amount|number_format:"2":".":""}</h4>
											</div><br />
                                           
											<div class="form-group">
												<label>{$plugin_lang.neteller_account}</label>
                                                 <div class="input">																								
													 <input type="text" class="form-control" placeholder="{$plugin_lang.neteller_account}" name="net_account" value="">	
                                                 </div>   											
											</div>
											 
											<div class="form-group">
												<label>{$plugin_lang.neteller_secure_id}</label>	
                                                <div class="input">																						
													 <input type="text" class="form-control" placeholder="{$plugin_lang.neteller_secure_id}" name="secure_id" value="">												
                                                 </div>    
											</div>
                                            
                                         </div>
										  <i class="fa"></i>	
										<div class="form-actions">
                                        	<input type="hidden" class="form-control" name="amount" value="{$amount}">	
											<button type="submit" class="btn btn-sm btn-primary m-t-n-xs">{$plugin_lang.deposit}</button>											
										</div>
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
<!-- Right sidebar -->
{include file='views/members/right_sidebar.tpl'}   
<!-- Vendor scrits -->
{include file='views/members/vendor_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
   
   });
</script>
{include file='views/members/footer.tpl'}