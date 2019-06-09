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
            {$lang.promoting_textads}
         </h2>
         <small>{$lang.promoting_textads}</small>
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
                           <form>
                              <table id="textads" class="table table-striped table-bordered table-hover">
                                 <tbody>
                                 {if $textads}
                                    {foreach key=obj item=name from=$textads}
                                    <tr>
                                       <td>
                                          <a href="#">{$name.textad_heading}</a><br />
                                          {$name.textad_line1}<br />
                                          {$name.textad_line2}<br />
                                          {$name.textad_domain}                                
                                          <br /><br />
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><label for="textarea"></label>
                                          <textarea cols="85" rows="5"><a href="{$site_url}?u={$username}">{$name.textad_heading}</a><br />
{$name.textad_line1}<br />
{$name.textad_line2}<br />
{$name.textad_domain}</textarea>
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
    	$('#textads').dataTable();   
    
   });
   
</script>
{include file='footer.tpl'}