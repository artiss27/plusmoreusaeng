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
            Social Network Ads
         </h2>
         <h5>Use these ads as pictures on your social network.</small><br><br><br><h5>Instructions</h5><small>• Right-click on the image with your mouse to open menu.<br>• Copy or save the image in your computer as a photo. <br>• Open your social network account.<br>• Download the picture into your Facebook/Instagram/Twitter account as you would do a normal photo.<br>• Add your referral link together with your member's name or ID.<br> • Share these ads on your network.
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
                           <table id="banners" class="table table-striped table-bordered table-hover">
                           <tbody>
                           {if $banners}
                              {foreach key=obj item=name from=$banners}
                              <tr>
                                 <td>
                                    <img src="/media/images/{$name.banner_name}" /><br />
                                    {$lang.size}: {$name.banner_size} <br />
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <textarea class="form-control" name="textarea" id="textarea" cols="85" rows="2"> {$site_url}?u={$username} </textarea>
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
    	$('#banners').dataTable();    
   });
   
</script>
{include file='footer.tpl'}