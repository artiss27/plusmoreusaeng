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
            Banner Settings
         </h2>
         <small>Banner Settings</small>
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
														<label for="textfield" class="form-label size-120 fl-space2">Minimum Ad credit bid per click:</label>
														
														<input name="min_banner_bid" type="text" id="textfield" placeholder="0.005" size="5" value='{$settings.min_banner_bid}' class="form-control" />
													</div>
													<div class="clear">
														<label for="textfield" class="form-label size-120 fl-space2">Max countries per banner campaigns:</label>
													
														<input name="max_banner_countries" type="text" id="textfield" placeholder="10" size="5" value='{$settings.max_banner_countries}' class="form-control" />
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