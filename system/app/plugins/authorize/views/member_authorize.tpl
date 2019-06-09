{include file='views/members/header.tpl'}
{include file='views/members/menu.tpl'}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/css/bootstrap-select.min.css">
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
            {$lang.deposit}
         </h2>
         <small>{$lang.deposit}</small>
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
            {foreach key=obj item=error from=$message_var} 
            <p class="alert alert-danger">
               {$plugin_lang.$obj} : {$lang.$error}
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
                        <form name="payment" action="/plugins/authorize/process/cc" method="post" onsubmit="document.getElementById(\'submit_button\').disabled = 1;" id="'.$processor['code'].'">							
						<label><img src="/system/app/plugins/authorize/images/authorizenet_logo.png" height="34" /><br />
						<br />
						<div class="form-group"><label class="col-sm-4 control-label">First Name</label>
						<div class="col-lg-10"><input type="text" class="form-control" name="first_name"></div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group"><label class="col-sm-4 control-label">Last Name</label>
						<div class="col-lg-10"><input type="text" class="form-control" name="last_name"></div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group"><label class="col-sm-4 control-label">Card Number</label>
						<div class="col-lg-10"><input type="text" class="form-control" name="cc_card_num"></div>
						</div>
						<div class="hr-line-dashed"></div>					
						<div style="padding-top: 120px; margin-bottom: 30px;"><img src="/system/app/plugins/authorize/images/card_types.png" height="44"></div>
						<div class="form-group"><label class="col-sm-7 control-label">Expiration Date (mm/yyyy)</label>
						<div class="col-lg-10"><input type="text" class="form-control" name="cc_exp_date"></div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group"><label class="col-sm-7 control-label">CVV2 From Back of Your Card</label>
						<div class="col-lg-10"><input type="text" class="form-control" name="cc_cvv2"></div>
						</div>
						<div class="hr-line-dashed"></div>
						<br />
						<div class="form-group"><label class="col-sm-7 control-label">Total Amount: <strong>${$data.amount}</label>
						</div>
						<div class="hr-line-dashed"></div>
						<input type="hidden" name="ap_itemname" value="{$data.description}">
						<input type="hidden" name="ap_description" value="{$data.description}">
						<input type="hidden" name="ap_returnurl" value="{$data.success_url}"> 
						<input type="hidden" name="ap_cancelurl" value="{$data.cancel_url}"> 
						<input type="hidden" name="ap_currency" value="USD"> 
						<input type="hidden" name="apc_1" value="{$data.hash}"/>
	
						<div class="form-group" style="padding-top: 50px;">
						<div class="col-sm-8 col-sm-offset-2">
                        <input name="submit" id="submit_button" type="submit" vale="Deposit">
						</div>
						</div>
						<input type="hidden" name="run" value="true">	
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/js/bootstrap-select.min.js"></script>
<script>
   $(document).ready( function() {  
   		{if $banners}$('#banners').dataTable();{/if}   
	 	$('.selectpicker').selectpicker();
   });
</script>

{include file='views/members/footer.tpl'}