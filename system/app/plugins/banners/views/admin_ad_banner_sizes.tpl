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
            Add New Banner Size
         </h2>
         <small>Setup the allowed banner sizes on your banner system</small>
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
                           <form role="form" action="" method="post" enctype="multipart/form-data">
                              <div class="form-body">
                                 <div class="form-group">
                                    <label>Width</label>
                                    <div class="input-icon right">
                                       <i class="fa"></i>	
                                       <input type="text" class="form-control"	placeholder="Width" name="width" value="{$smarty.session.old.width}">
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label>Height</label>
                                    <div class="input-icon right">
                                       <i class="fa"></i>	
                                       <input type="text" class="form-control"	placeholder="Height" name="height" value="{$smarty.session.old.height}">
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label>Default Target Url</label>
                                    <div class="input-icon right">
                                       <i class="fa"></i>	
                                       <input type="text" class="form-control"	placeholder="http://" name="target_url" value="{$smarty.session.old.target_url}">
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label>Upload default banner image</label>	
                                    (Gif, Png, Jpg)
                                    <div class="form_input">
                                       <input type="file" name="banner_image" id="banner_image" />
                                    </div>
                                 </div>
                              </div>
                              <div class="form-actions">
                                 <button type="submit" class="btn btn-sm btn-primary m-t-n-xs">Submit</button>
                              </div>
                           </form>
                           <br /><br /> 
                           <table id="banner_sizes" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th>ID</th>
                                    <th>Size</th>
                                    <th>Default Banner</th>
                                    <th>Target Url</th>
                                    <th>Banner Code</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 {if !$list}
                                 <tr>
                                    <td colspan="6">No Results Found</td>
                                 </tr>
                                 {else}
                                 {foreach key=obj item=banner_sizes from=$list}  
                                 <tr>
                                    <td>{$banner_sizes.id}</td>
                                    <td>{$banner_sizes.width}x{$banner_sizes.height}</td>
                                    <td><a href="{$banner_sizes.default_banner_url}" target="_blank">view</a></td>
                                    <td>{$banner_sizes.default_banner_target_url}</td>
                                    <td>
                                       <textarea name="textarea" cols="80" rows="9" readonly style="COLOR: #808080; BACKGROUND-COLOR: #eeeeee"><!-- BEGIN BANNER CODE -->
<SCRIPT type="text/javascript">
                                          document.write('<SCR'+'IPT src="{$site_url}plugins/banners/banner/banner/&size={$banner_sizes.width}x{$banner_sizes.height}&random='+Math.floor(89999999*Math.random()+10000000)+'&millis='+new Date().getTime()+'&referrer='+escape(document.location)+'" type="text/javascript"></SCR'+'IPT>');
                                       </SCRIPT>
<!-- END BANNER CODE --></textarea>
                                    </td>
                                    <td><a href="/plugins/banners/badmin/deletesize/&id={$banner_sizes.id}" onclick="return confirm('Are you sure you want to delete this banner size');">delete</a></td>
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
<!-- Vendor scrits -->
{include file='views/admin/footer_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
   	{if $list}$('#banner_sizes').dataTable();{/if}  
   });
</script>
{include file='views/admin/footer.tpl'}