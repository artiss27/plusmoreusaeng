{include file='header.tpl'}
{include file='menu.tpl'}
<div id="wrapper">
<div class="content animate-panel">
   <div class="row">
      <div class="normalheader transition animated fadeIn">
         <div class="hpanel">
            <div class="panel-body">
               <a class="small-header-action" href="">
                  <div class="clip-header">
                     <i class="fa fa-arrow-up"></i>
                  </div>
               </a>
               <div id="hbreadcrumb" class="pull-right m-t-lg">
                  <ol class="hbreadcrumb breadcrumb">
                  </ol>
               </div>
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
               {if $errors}
               {foreach $errors as $error}
               <p class="alert alert-danger">
                  {$error}
               </p>
               {/foreach}
               {/if}
               {if $banner_saved eq 'y'}
               <div class="alert alert-success">
                  <p><strong>Banner Saved:</strong> Your Banner name was saved succesfully on database.</p>
               </div>
               {/if}  
               {if $banner_saved eq 'error'}
               <div class="alert alert-success">
                  <p><strong>Banner Error:</strong> There was an error uploading the banner, check banners/ directory permission.</p>
               </div>
               {/if} 
               {if $banner_deleted eq 'y'}
               <div class="alert alert-success">
                  <p><strong>Banner Deleted:</strong> Banner was deleted succesfully from database.</p>
               </div>
               {/if} 
               {foreach $errors as $error}
               <div class="alert alert-danger">
                  <p><strong>{$error@key}</strong> {$error}</p>
               </div>
               {/foreach}  
               <br />
               <h2 class="font-light m-b-xs">
                  Promoting Banners
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <form action="/admin/banners/" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                          <div class="color-line"></div>
                                          <div class="modal-header text-center">
                                             <h4 class="modal-title">Add new Banner</h4>
                                          </div>
                                          <div class="modal-body">
                                             <label for="Banner"></label>
                                             Add New Banner Image
                                             : 
                                             <label for="fileField"></label>
                                             <input type="file" name="uploadbanner" class="form-control" />
                                             <br /><br />
                                             Banner ImageAlt
                                             : 
                                             <input type="text" name="banner_alt" class="form-control" />
                                             <br /><br /><input type="hidden" class="button red fr" name="upload" value="Upload" />
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                             <button type="button" class="btn btn-primary" onclick = 'this.form.submit();'>Upload</button>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                              <div class="columns clear bt-space15">
                                 <div class="col2-3">
                                    <div class="form-field clear">
                                       <button type="button" class="btn btn-success m-t" data-toggle="modal" data-target="#myModal">
                                       Add New Banner
                                       </button>
                                    </div>
                                    <br />
                                    {foreach key=obj item=name from=$banners}
                                    <div class="modal fade" id="myModal{$name.banner_id}" tabindex="-1" role="dialog" aria-hidden="true">
                                       <div class="modal-dialog">
                                          <div class="modal-content">
                                             <form action="/admin/banners/" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                                <div class="color-line"></div>
                                                <div class="modal-header text-center">
                                                   <h4 class="modal-title">Update Banner</h4>
                                                </div>
                                                <div class="modal-body">
                                                   <img src="/media/images/{$name.banner_name}" /><br />
                                                   <label for="Banner"></label>
                                                   Upload New Banner Image
                                                   : 
                                                   <label for="fileField"></label>
                                                   <input type="file" name="uploadbanner" class="form-control" />
                                                   <br /><br />
                                                   Banner ImageAlt
                                                   : 
                                                   <input type="text" name="banner_alt" value="{$name.banner_alt}" class="form-control" />
                                                   <input type="hidden" name="banner_id" value="{$name.banner_id}" class="form-control" />
                                                   <br /><br /><input type="hidden" class="button red fr" name="uploadupdate" value="Update" />
                                                </div>
                                                <div class="modal-footer">
                                                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                   <button type="button" class="btn btn-primary" onclick = 'this.form.submit();'>Upload</button>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                    {/foreach} 
                                    <table id="transaction" class="table table-striped table-bordered table-hover">
                                       <thead>
                                          <tr>
                                             <th>ID</th>
                                             <th>Size</th>
                                             <th>Alt Name</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          {foreach key=obj item=name from=$banners}
                                          <tr>
                                             <td>{$name.banner_id}</td>
                                             <td>{$name.banner_size}</td>
                                             <td><img src="/media/images/{$name.banner_name}" /></td>
                                             <td>{$name.banner_alt}</td>
                                             <td><button class="btn btn-info " type="button" data-toggle="modal" data-target="#myModal{$name.banner_id}"><i class="fa fa-paste"></i> Edit</button> <a href="/admin/banners/&del={$name.banner_id}" onClick="return confirm ('Do you really want to delete this banner?');"><button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i> <span class="bold"> Delete</span></button></td>
                                          </tr>
                                          {/foreach}
                                       </tbody>
                                    </table>
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
   </div>
</div>
{include file='footer_scripts.tpl'}
{include file='footer.tpl'}