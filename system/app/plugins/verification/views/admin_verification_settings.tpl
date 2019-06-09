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
            Member Veification Settings
         </h2>
         <small>Member Veification Settings</small>
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
                             <form action="" method="post" class="validate-form form bt-space15">
											<div class="columns clear bt-space15">
												<div class="col2-3">
													<div class="form-field clear"></div>
													 <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Force Verification :</label> 
                                       <select id="verification_is_forced" class="form-control required" name="verification_is_forced">
                                       <option value="yes" {if $settings.verification_is_forced eq 'yes'}selected="selected"{/if}>Yes</option>
                                       <option value="no" {if $settings.verification_is_forced eq 'no'}selected="selected"{/if}>No</option>     
                                       </select>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Max days until force verification :</label>
                                       <input name="verification_max_days" type="text" value="{$settings.verification_max_days}" size="5" class="form-control" />
                                    </div>
                                    <br />
												</div>
											</div>
											<div class="form-field clear">
												<br />
												<button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
                                                
												<br />
												</p> 
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