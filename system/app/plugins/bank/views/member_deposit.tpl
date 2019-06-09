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
         
            <h2 class="font-light m-b-xs">
               Zelle Deposit
            </h2>
            <small>Bank Deposit via Zelle</small>
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
    						<div class="container-tree">
                            	<div class="wrapper"><br /><br /><br />
                                    <div style="overflow-x:auto;">   
                                    {$smarty.session.bank_content}                       
                                    </div>          
                                </div>
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
