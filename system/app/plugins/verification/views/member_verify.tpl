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
               {$plugin_lang.verify_your_account}
            </h2>
            <small>{$plugin_lang.verify_your_account}</small>
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
                              <h4>{$plugin_lang.verification_status}: <strong>
                                 {if $status == "require_all_document"}{$plugin_lang.require_all}
                                 {elseif $status == "require_personal_identity_document"}{$plugin_lang.require_document}
                                 {elseif $status == "require_addreess_proof_document"}{$plugin_lang.require_proof}
                                 {elseif $status == "processing_verification"}{$plugin_lang.processing}
                                 {elseif $status == "verified"}{$plugin_lang.verified}
                                 {/if}
                                 </strong>
                              </h4><br /><br />
                             {if $status != "verified"}
                              <form id="verification" action="" method="post" enctype="multipart/form-data">
                                 <div class="form-group">
                                    <label>{$plugin_lang.upload_scanned_personal_document}</label>	
                                    (Gif, Png, Jpg)
                                    <div class="form_input">
                                       <input type="file" name="document" id="document" />
                                    </div>
                                 </div>
                                 <br />
                                 <div class="form-group">
                                    <label>{$plugin_lang.upload_scanned_bill_address}</label>	
                                    (Gif, Png, Jpg)
                                    <div class="form_input">
                                       <input type="file" name="proof" id="proof" />
                                    </div>
                                 </div>                                 
                           </div>
                           <i class="fa"></i>	
                           <div class="form-actions">
                           <button type="submit" class="btn btn-sm btn-primary m-t-n-xs">{$plugin_lang.send_for_verification}</button>											
                           </div>
                           </form>	 
                           {/if}                    
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
   	{if $log}$('#log').dataTable();{/if}  
   });
</script>
{include file='views/members/footer.tpl'}