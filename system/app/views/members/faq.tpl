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
            {$lang.faq}
         </h2>
         <small>{$lang.faq}</small>
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
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        {foreach key=obj item=name from=$faq}
                           <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="heading{$name@iteration}">
                                 <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{$name@iteration}" aria-expanded="true" aria-controls="collapse{$name@iteration}">
                                    {$name.question}
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapse{$name@iteration}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{$name@iteration}">
                                 <div class="panel-body">
                                    {$name.answer|replace:"\n":"<br>"}
                                 </div>
                              </div>
                           </div>
                          {/foreach}  
                        </div>                        
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
   $(function () {
    
    
   });
   
</script>
{include file='footer.tpl'}