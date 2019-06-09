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
            {/if} <br />          
         <h2 class="font-light m-b-xs">
            {$lang.promoting_optin_emails}
         </h2>
         <small>{$lang.promoting_optin_emails}</small>
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
            
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <form>
                              <table id="optin" class="table table-striped table-bordered table-hover">
                                 <tbody>
                                 {if $optin}
                                    {foreach key=obj item=name from=$optin}
                                    <tr>
                                       <td>
                                          <a href="#">{$name.optin_title}</a>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><label for="textarea"></label>
                                          <textarea cols="85" rows="20">{$name.optin_body|replace:"[ref_url]":"$site_url?u=$username"}</textarea>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>&nbsp;</td>
                                    </tr>
                                    {/foreach}    
                               {else}                         
                                    <tr><td>{$lang.no_result_found}</td></tr>
                               {/if}                         
                                 </tbody>
                              </table>
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
{include file='right_sidebar.tpl'}   
<!-- Vendor scrits -->
{include file='vendor_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
    	$('#optin').dataTable();     
   });
   
</script>
{include file='footer.tpl'}
