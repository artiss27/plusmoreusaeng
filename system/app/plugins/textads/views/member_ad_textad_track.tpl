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
            {$lang.textads}
         </h2>
         <small>{$lang.textads}</small>
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
                        
                        	<table id="textads" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th>{$plugin_lang.date}</th>
                                    <th>{$plugin_lang.ip_address}</th>
                                    <th>{$plugin_lang.country}</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 {if !$clicks}
                                 <tr>
                                    <td colspan="3">{$lang.no_result_found}</td>
                                 </tr>
                                 {else}
                                 {foreach key=obj item=textad from=$clicks} 
                                 <tr>
                                    <td>{$textad.created_at}</td>
                                    <td>{$textad.ip_address}</td>
                                    <td>{$textad.country}</td>                                
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
   
   });
</script>
{include file='views/members/footer.tpl'}