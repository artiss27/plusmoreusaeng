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
               {if $download_saved eq 'y'}
               <div class="alert alert-success">
                  <p><strong>Download Saved:</strong> Your Download was saved succesfully on database.</p>
               </div>
               {/if}  
               {if $download_saved eq 'error'}
               <div class="alert alert-success">
                  <p><strong>Download Error:</strong> There was an error uploading the download, check files/ directory permission.</p>
               </div>
               {/if} 
               {if $download_deleted eq 'y'}
               <div class="alert alert-success">
                  <p><strong>Download Deleted:</strong> Download was deleted succesfully from database.</p>
               </div>
               {/if}    
               {foreach $errors as $error}
               <div class="alert alert-danger">
                  <p><strong>{$error@key}</strong> {$error}</p>
               </div>
               {/foreach}
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
               <br />
               <h2 class="font-light m-b-xs">
                  Member Document
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <form action="/admin/myvault/" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                          <div class="color-line"></div>
                                          <div class="modal-header text-center">
                                             <h4 class="modal-title" id="myModalLabel1">Add New Vault Document</h4>
                                             <i class="pe-7s-mouse"></i> <small class="font-bold">Scroll down with mouse wheel to see all the options.</small> <i class="pe-7s-mouse"></i>
                                          </div>
                                          <div class="modal-body">
                                             <label for="Download"></label>
                                             Add New Download 
                                             : 
                                             <label for="fileField"></label>
                                             <input type="file" name="uploaddownload" class="form-control"/>
                                             <br />
                                  <!--     Or Select from &quot;files/&quot; Web Folder<br />
                                             <label for="select"></label>
                                             <select name="from_directory" id="select" class="form-control">
                                                <option value="">Select File From Directory</option>
                                                {foreach key=obj item=name from=$files}
                                                <option value="{$name}">{$name}</option>
                                                {/foreach}                          
                                             </select>
                                             <br />-->
                                             File Title: 
                                             <label for="textfield"></label>
                                             <input name="title" type="text" id="textfield" size="40" class="form-control" />
                                             <br />
                                             Download Description
                                             : 
                                             <br />
                                             <label for="textarea"></label>
                                             <textarea name="description" id="textarea" cols="45" rows="5" class="form-control"></textarea>
                                             <br />
                                             Important File? 
                                             <label for="featured"></label>
                                             <select name="important" id="select2" class="form-control">
                                                <option value="yes">Yes</option>
                                                <option value="no" selected="selected">No</option>
                                             </select>
                                             <br />
                                   <!--       Minimum Membership Required : 
                                             <label for="select3"></label>
                                             <select name="membership" id="select3" class="form-control">
                                                {foreach key=obj item=name from=$memberships}
                                                <option value="{$obj}">{$name|replace:"_":" "}</option>
                                                {/foreach}  
                                             </select>
                                             <br />-->
                                             select member: 
                                             <label for="select3"></label>
                                             <select name="memberid" id="select3" class="form-control">
                                                {foreach key=ob item=username from=$members12} 
                                                <option value="{$username.member_id}">{$username.username}</option>
                                                {/foreach}  
                                             </select>
                                             <br />
                                             Select Category 
                                             <label for="select4"></label>
                                             <select name="category" id="select4" class="form-control">
                                                <option value="">Select Category</option>
                                                {foreach key=objx item=namex from=$category}
                                                {if $namex.category ne ""}
                                                <option value="{$namex.category}">{$namex.category}</option>
                                                {/if}
                                                {/foreach}                   
                                             </select>
                                             <br />
                                             Or Create New Category : 
                                             <label for="textfield2"></label>
                                             <input name="new_category" type="text" id="textfield2" size="30" class="form-control" />
                                             <br /><br /><input type="hidden" class="button red fr" name="upload" value="Upload" />
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                             <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                              <div class="columns clear bt-space15">
                                 <div class="col2-3">
                                    <br>
                                    <div class="form-field">
                                       <button class="btn btn-success " type="button" data-toggle="modal" data-target="#myModal"><i class="fa fa-download"></i> <span class="bold">Add New Download</span></button>
                                    </div>
                                    <br />
                                    <form id="form1" name="form1" method="post" action="">
                                       Filter By Category: 
                                       <select name='category' onChange='this.form.submit();' class="form-control">
                                          <option value="all">ALL</option>
                                          {foreach key=objx item=namex from=$category}
                                          {if $namex.category ne ""}<option value="{$namex.category}" {if $namex.category eq $smarty.request.category}selected="selected"{/if}>{$namex.category}</option>{/if}
                                          {/foreach}   
                                       </select>
                                       <br />
                                       <br />
                                    </form>
                                    <table width="60%" class="table">                                    
                                          {foreach key=obj item=name from=$downloads}                                          
                                          <tr>                                             
                                              <td>
                                                <table class="table">
                                                   <tr>
                                                      <td style="width:50%;">File Title:</td>
                                                      <td style="width:50%;">{$name.title}</td>
                                                   </tr>
                                                   <tr>
                                                      <td style="width:50%;">File Name:</td>
                                                      <td style="width:50%;">{$name.filename}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>ID:</td>
                                                      <td>{$name.id}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>File Size:</td>
                                                      <td>{$name.size} Bytes</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Description:</td>
                                                      <td>{$name.description|replace:"\n":"<br>"}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Featured:</td>
                                                      <td>{$name.featured}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Date Uploaded:</td>
                                                      <td>{$name.date}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Minium Membership to Download:</td>
                                                      <td>
                                                         {capture assign=comm}{$name.minium_membership}{/capture}                                      
                                                         {$memberships.$comm|replace:"_":" "}
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td>Category:</td>
                                                      <td>{$name.category}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Downloaded Counter:</td>
                                                      <td>{$name.download_counter}</td>
                                                   </tr>
                                                </table>
                                              </td>                                             
                                             <td><a href="#myModal{$name.id}" data-toggle="modal" data-target="#myModal{$name.id}">edit</a> | <a href="/admin/myvault/&del={$name.id}" onClick="return confirm ('Do you really want to delete this download?');">delete</a></td>
                                          </tr>
                                          	<div class="modal fade" id="myModal{$name.id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
                                             <div class="modal-dialog">
                                                <div class="modal-content">
                                                   <form action="/admin/downloads/" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                                      <div class="color-line"></div>
                                                      <div class="modal-header text-center">
                                                         <h4 class="modal-title" id="myModalLabel2">Update Download</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                         <label for="Download">File Name: {$name.filename}</label><br /><br />
                                                         Upload New File
                                                         : 
                                                         <label for="fileField"></label>
                                                         <input type="file" name="uploaddownload"  class="form-control" />
                                                         <br />
                                                         <br />
                                                         Or Select from &quot;files/&quot; Directory<br />
                                                         <br />
                                                         <label for="select"></label>
                                                         <select name="from_directory" id="select" class="form-control">
                                                            <option value="">Select File From Directory</option>
                                                            {foreach key=objy item=namey from=$files}
                                                            <option value="{$namey}">{$namey}</option>
                                                            {/foreach}                          
                                                         </select>
                                                         <br />
                                                         <br />
                                                         File Title: 
                                                         <label for="textfield"></label>
                                                         <input name="title" type="text" id="textfield" size="40" value="{$name.title}" class="form-control" />
                                                         <br />
                                                         <br />
                                                         Download Description
                                                         : 
                                                         <br />
                                                         <label for="textarea"></label>
                                                         <textarea name="description" id="textarea" cols="45" rows="5" class="form-control">{$name.description}</textarea>
                                                         <br />
                                                         <br />
                                                         Make Featured ? 
                                                         <label for="select2"></label>
                                                         <select name="featured" id="select2" class="form-control">
                                                         <option value="yes" {if $name.featured eq 'yes'}selected="selected"{/if}>Yes</option>
                                                         <option value="no" {if $name.featured eq 'no'}selected="selected"{/if}>No</option>
                                                         </select>
                                                         <br />
                                                         <br />
                                                         Minium Membership Required : 
                                                         <label for="select3"></label>
                                                         <select name="membership" id="select3" class="form-control">
                                                         {foreach key=objx item=namex from=$memberships}
                                                         <option value="{$objx}" {if $name.minium_membership eq "{$objx}"}selected="selected"{/if}>{$namex|replace:"_":" "}</option>
                                                         {/foreach}  
                                                         </select>
                                                         <br /><br />
                                                         Select Category 
                                                         <label for="select4"></label>
                                                         <select name="category" id="select4" class="form-control">
                                                            <option value="">Select Category</option>
                                                            {foreach key=objx item=namex from=$category}
                                                            {if $namex.category ne ""}<option value="{$namex.category}" {if $namex.category eq $name.category}selected="selected"{/if}>{$namex.category}</option>{/if}
                                                            {/foreach}            
                                                         </select>
                                                         <br />
                                                         <br />
                                                         Or Create New Category : 
                                                         <label for="textfield2"></label>
                                                         <input name="new_category" type="text" id="textfield2" size="30" class="form-control" />
                                                         <br /><br />
                                                         <input name="download_id" type="hidden" value="{$name.id}" class="form-control" />                          
                                                         <input type="hidden" class="button red fr" name="uploadupdate" value="Modify" />
                                                      </div>
                                                      <div class="modal-footer">
                                                         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                         <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button>
                                                      </div>
                                                   </form>
                                                </div>
                                             </div>
                                          </div>
                                          {/foreach}                            
                                     
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