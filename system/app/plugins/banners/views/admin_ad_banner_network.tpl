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
            Add Banner Networks
         </h2>
         <small>Banners from other networks that run on your site when there isn't members banners available</small>
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
                        <form role="form" action="" method="post">
										<div class="form-body">	
												<div class="form-group">
												<label>Select a banner size</label>	
                                            <div class="form_input"><select class="form-control" name="banner_size">
													{foreach key=obj item=size from=$sizes}
															<option value="{$size.width}x{$size.height}">{$size.width}x{$size.height}</option>
													{/foreach}
															</select>
                                            </div>    
                                            </div>

                                                <div class="form-group">
													<label>Banner Code</label>
													<div class="input-icon right">
														<i class="fa"></i>	
                                                    	<textarea rows=9 cols=90 name="banner_code" class="form-control"></textarea>
													</div>
												</div>                                                   
  
										</div>
                                        
										<div class="form-actions">
											<button type="submit" class="btn btn-sm btn-primary m-t-n-xs">Submit</button>

										</div>
									</form>
                                    <br /><br />
                        
                              <table id="banner_active" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th>ID</th>
                                       <th>Size</th>
                                       <th>Impressions</th>
                                       <th>Banner Code</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    {if !$list}
                                    <tr>
                                       <td colspan="5">No Results Found</td>
                                    </tr>
                                    {else}
                                    {foreach key=obj item=banner from=$list}  
                                    <tr>
                                       <td>{$banner.id}</td>
                                       <td>{$banner.size}</td>
                                       <td>{$banner.impressions}</td>
                                       <td>{$banner.banner_code}</td>
                                       <td><a href="/plugins/banners/badmin/deletenetwork/&id={$banner.id}" onclick="return confirm('Are you sure you want to delete this banner network code?');">delete</a>
                                       </td>
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
   	{if $list}$('#banner_active').dataTable();{/if}  
   });

</script>
{include file='views/admin/footer.tpl'}
