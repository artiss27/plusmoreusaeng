{include file='views/admin/header.tpl'}
{include file='views/admin/menu.tpl'}
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
         <h2 class="font-light m-b-xs">
            P2P Money Lending Settings
         </h2>
         <small>Activate P2P Money Lending Settings</small>
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
                             <form action="#" method="post" class="validate-form form bt-space15">
											<div class="columns clear bt-space15">
												<div class="col2-3">
													<div class="clear">
														<label for="textfield" class="fl-space size-300">Activate money lending between members ?</label> 
														<select id="money_trasnfer_active" class="form-control required" name="money_trasnfer_active">
														<option value="yes" {if $settings.money_trasnfer_active eq 'yes'}selected="selected"{/if}>Yes</option>
														<option value="no" {if $settings.money_trasnfer_active eq 'no'}selected="selected"{/if}>No</option>     
														</select>
													</div>
                                                    <br />
                                                    <div class="clear">
														<label for="textfield" class="form-label size-120 fl-space2">Min amount to transfer:</label>													
														<input name="transfer_min_amount" type="text" id="textfield" placeholder="10" size="5" value='{$settings.transfer_min_amount}' class="form-control" />
													</div> 
                                                    <br />
                                                    <div class="clear">
														<label for="textfield" class="form-label size-120 fl-space2">Max amount to transfer:</label>													
														<input name="transfer_max_amount" type="text" id="textfield" placeholder="10" size="5" value='{$settings.transfer_max_amount}' class="form-control" />
													</div>    
                                                    <br />
                                                    <div class="clear">
														<label for="textfield" class="form-label size-120 fl-space2">Transfer Fee</label>													
														<input name="transfer_fee_percent" type="text" id="textfield" placeholder="10" size="5" value='0.5' class="form-control" />
													</div>                                              
													<div class="form-field clear"></div>
												</div>
											</div>
											<br>
											<div class="form-field clear">
												<input type="hidden" class="button red fr" name="bnsubmit" value="Save" />
												<button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
											</div>
											<!-- /.form-field -->																								
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
<!-- Vendor scrits -->
{include file='views/admin/footer_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
   
   });
</script>
{include file='views/admin/footer.tpl'}