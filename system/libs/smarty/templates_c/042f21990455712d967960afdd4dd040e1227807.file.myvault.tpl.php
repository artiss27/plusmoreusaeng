<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 11:32:35
         compiled from "system/app/views/admin/myvault.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18023005725cf80ac3afa9d8-82341049%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '042f21990455712d967960afdd4dd040e1227807' => 
    array (
      0 => 'system/app/views/admin/myvault.tpl',
      1 => 1518385886,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18023005725cf80ac3afa9d8-82341049',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/hermes/walnaweb10a/b1543/pow.plusmoreusaengcom/htdocs/system/libs/smarty/plugins/modifier.replace.php';
?><?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
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
               <?php if ($_smarty_tpl->getVariable('download_saved')->value=='y'){?>
               <div class="alert alert-success">
                  <p><strong>Download Saved:</strong> Your Download was saved succesfully on database.</p>
               </div>
               <?php }?>  
               <?php if ($_smarty_tpl->getVariable('download_saved')->value=='error'){?>
               <div class="alert alert-success">
                  <p><strong>Download Error:</strong> There was an error uploading the download, check files/ directory permission.</p>
               </div>
               <?php }?> 
               <?php if ($_smarty_tpl->getVariable('download_deleted')->value=='y'){?>
               <div class="alert alert-success">
                  <p><strong>Download Deleted:</strong> Download was deleted succesfully from database.</p>
               </div>
               <?php }?>    
               <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
               <div class="alert alert-danger">
                  <p><strong><?php echo $_smarty_tpl->tpl_vars['error']->key;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
               </div>
               <?php }} ?>
               <?php if ($_SESSION['message']){?>
               <p class="alert alert-success">
                  <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('message'), null, null);?>
                  <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

               </p>
               <br />
               <?php }?> 
               <?php if ($_SESSION['error']){?>
               <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('error'), null, null);?>            	
               <?php if (is_array($_smarty_tpl->getVariable('message_var')->value)){?>
               <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('message_var')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
               <p class="alert alert-danger">
                  <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

               </p>
               <br />
               <?php }} ?> 
               <?php }else{ ?>
               <p class="alert alert-danger">
                  <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

               </p>
               <br />
               <?php }?>
               <?php }?>    
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
                                                <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('files')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</option>
                                                <?php }} ?>                          
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
                                                <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('memberships')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['obj']->value;?>
"><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['name']->value,"_"," ");?>
</option>
                                                <?php }} ?>  
                                             </select>
                                             <br />-->
                                             select member: 
                                             <label for="select3"></label>
                                             <select name="memberid" id="select3" class="form-control">
                                                <?php  $_smarty_tpl->tpl_vars['username'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['ob'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('members12')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['username']->key => $_smarty_tpl->tpl_vars['username']->value){
 $_smarty_tpl->tpl_vars['ob']->value = $_smarty_tpl->tpl_vars['username']->key;
?> 
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['username']->value['member_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['username']->value['username'];?>
</option>
                                                <?php }} ?>  
                                             </select>
                                             <br />
                                             Select Category 
                                             <label for="select4"></label>
                                             <select name="category" id="select4" class="form-control">
                                                <option value="">Select Category</option>
                                                <?php  $_smarty_tpl->tpl_vars['namex'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['objx'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('category')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['namex']->key => $_smarty_tpl->tpl_vars['namex']->value){
 $_smarty_tpl->tpl_vars['objx']->value = $_smarty_tpl->tpl_vars['namex']->key;
?>
                                                <?php if ($_smarty_tpl->tpl_vars['namex']->value['category']!=''){?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['namex']->value['category'];?>
"><?php echo $_smarty_tpl->tpl_vars['namex']->value['category'];?>
</option>
                                                <?php }?>
                                                <?php }} ?>                   
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
                                          <?php  $_smarty_tpl->tpl_vars['namex'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['objx'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('category')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['namex']->key => $_smarty_tpl->tpl_vars['namex']->value){
 $_smarty_tpl->tpl_vars['objx']->value = $_smarty_tpl->tpl_vars['namex']->key;
?>
                                          <?php if ($_smarty_tpl->tpl_vars['namex']->value['category']!=''){?><option value="<?php echo $_smarty_tpl->tpl_vars['namex']->value['category'];?>
" <?php if ($_smarty_tpl->tpl_vars['namex']->value['category']==$_REQUEST['category']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['namex']->value['category'];?>
</option><?php }?>
                                          <?php }} ?>   
                                       </select>
                                       <br />
                                       <br />
                                    </form>
                                    <table width="60%" class="table">                                    
                                          <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('downloads')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>                                          
                                          <tr>                                             
                                              <td>
                                                <table class="table">
                                                   <tr>
                                                      <td style="width:50%;">File Title:</td>
                                                      <td style="width:50%;"><?php echo $_smarty_tpl->tpl_vars['name']->value['title'];?>
</td>
                                                   </tr>
                                                   <tr>
                                                      <td style="width:50%;">File Name:</td>
                                                      <td style="width:50%;"><?php echo $_smarty_tpl->tpl_vars['name']->value['filename'];?>
</td>
                                                   </tr>
                                                   <tr>
                                                      <td>ID:</td>
                                                      <td><?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
</td>
                                                   </tr>
                                                   <tr>
                                                      <td>File Size:</td>
                                                      <td><?php echo $_smarty_tpl->tpl_vars['name']->value['size'];?>
 Bytes</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Description:</td>
                                                      <td><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['name']->value['description'],"\n","<br>");?>
</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Featured:</td>
                                                      <td><?php echo $_smarty_tpl->tpl_vars['name']->value['featured'];?>
</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Date Uploaded:</td>
                                                      <td><?php echo $_smarty_tpl->tpl_vars['name']->value['date'];?>
</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Minium Membership to Download:</td>
                                                      <td>
                                                         <?php ob_start(); ?><?php echo $_smarty_tpl->tpl_vars['name']->value['minium_membership'];?>
<?php  $_smarty_tpl->assign('comm', ob_get_contents()); Smarty::$_smarty_vars['capture']['default']=ob_get_clean();?>                                      
                                                         <?php echo smarty_modifier_replace($_smarty_tpl->getVariable('memberships')->value[$_smarty_tpl->getVariable('comm')->value],"_"," ");?>

                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td>Category:</td>
                                                      <td><?php echo $_smarty_tpl->tpl_vars['name']->value['category'];?>
</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Downloaded Counter:</td>
                                                      <td><?php echo $_smarty_tpl->tpl_vars['name']->value['download_counter'];?>
</td>
                                                   </tr>
                                                </table>
                                              </td>                                             
                                             <td><a href="#myModal<?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
" data-toggle="modal" data-target="#myModal<?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
">edit</a> | <a href="/admin/myvault/&del=<?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
" onClick="return confirm ('Do you really want to delete this download?');">delete</a></td>
                                          </tr>
                                          	<div class="modal fade" id="myModal<?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
                                             <div class="modal-dialog">
                                                <div class="modal-content">
                                                   <form action="/admin/downloads/" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                                      <div class="color-line"></div>
                                                      <div class="modal-header text-center">
                                                         <h4 class="modal-title" id="myModalLabel2">Update Download</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                         <label for="Download">File Name: <?php echo $_smarty_tpl->tpl_vars['name']->value['filename'];?>
</label><br /><br />
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
                                                            <?php  $_smarty_tpl->tpl_vars['namey'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['objy'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('files')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['namey']->key => $_smarty_tpl->tpl_vars['namey']->value){
 $_smarty_tpl->tpl_vars['objy']->value = $_smarty_tpl->tpl_vars['namey']->key;
?>
                                                            <option value="<?php echo $_smarty_tpl->tpl_vars['namey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['namey']->value;?>
</option>
                                                            <?php }} ?>                          
                                                         </select>
                                                         <br />
                                                         <br />
                                                         File Title: 
                                                         <label for="textfield"></label>
                                                         <input name="title" type="text" id="textfield" size="40" value="<?php echo $_smarty_tpl->tpl_vars['name']->value['title'];?>
" class="form-control" />
                                                         <br />
                                                         <br />
                                                         Download Description
                                                         : 
                                                         <br />
                                                         <label for="textarea"></label>
                                                         <textarea name="description" id="textarea" cols="45" rows="5" class="form-control"><?php echo $_smarty_tpl->tpl_vars['name']->value['description'];?>
</textarea>
                                                         <br />
                                                         <br />
                                                         Make Featured ? 
                                                         <label for="select2"></label>
                                                         <select name="featured" id="select2" class="form-control">
                                                         <option value="yes" <?php if ($_smarty_tpl->tpl_vars['name']->value['featured']=='yes'){?>selected="selected"<?php }?>>Yes</option>
                                                         <option value="no" <?php if ($_smarty_tpl->tpl_vars['name']->value['featured']=='no'){?>selected="selected"<?php }?>>No</option>
                                                         </select>
                                                         <br />
                                                         <br />
                                                         Minium Membership Required : 
                                                         <label for="select3"></label>
                                                         <select name="membership" id="select3" class="form-control">
                                                         <?php  $_smarty_tpl->tpl_vars['namex'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['objx'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('memberships')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['namex']->key => $_smarty_tpl->tpl_vars['namex']->value){
 $_smarty_tpl->tpl_vars['objx']->value = $_smarty_tpl->tpl_vars['namex']->key;
?>
                                                         <option value="<?php echo $_smarty_tpl->tpl_vars['objx']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['name']->value['minium_membership']==($_smarty_tpl->tpl_vars['objx']->value)){?>selected="selected"<?php }?>><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['namex']->value,"_"," ");?>
</option>
                                                         <?php }} ?>  
                                                         </select>
                                                         <br /><br />
                                                         Select Category 
                                                         <label for="select4"></label>
                                                         <select name="category" id="select4" class="form-control">
                                                            <option value="">Select Category</option>
                                                            <?php  $_smarty_tpl->tpl_vars['namex'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['objx'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('category')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['namex']->key => $_smarty_tpl->tpl_vars['namex']->value){
 $_smarty_tpl->tpl_vars['objx']->value = $_smarty_tpl->tpl_vars['namex']->key;
?>
                                                            <?php if ($_smarty_tpl->tpl_vars['namex']->value['category']!=''){?><option value="<?php echo $_smarty_tpl->tpl_vars['namex']->value['category'];?>
" <?php if ($_smarty_tpl->tpl_vars['namex']->value['category']==$_smarty_tpl->tpl_vars['name']->value['category']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['namex']->value['category'];?>
</option><?php }?>
                                                            <?php }} ?>            
                                                         </select>
                                                         <br />
                                                         <br />
                                                         Or Create New Category : 
                                                         <label for="textfield2"></label>
                                                         <input name="new_category" type="text" id="textfield2" size="30" class="form-control" />
                                                         <br /><br />
                                                         <input name="download_id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
" class="form-control" />                          
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
                                          <?php }} ?>                            
                                     
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
<?php $_template = new Smarty_Internal_Template('footer_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>