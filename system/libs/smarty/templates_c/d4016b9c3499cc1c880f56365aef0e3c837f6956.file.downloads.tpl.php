<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 21:38:29
         compiled from "system/app/views/members/downloads.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19419908125cf898c590b408-78065180%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd4016b9c3499cc1c880f56365aef0e3c837f6956' => 
    array (
      0 => 'system/app/views/members/downloads.tpl',
      1 => 1517335145,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19419908125cf898c590b408-78065180',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
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
         <?php $_template = new Smarty_Internal_Template('breadcrumb.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>            
         <h2 class="font-light m-b-xs">
            Download Information
         </h2>
         <small>Click on The Filename to Download the Visual Content.</small>
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
            <?php if ($_SESSION['message']){?>
            <p class="alert alert-success">
               <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('message'), null, null);?>
               <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

            </p>
            <br />
            <?php }?> 
            <?php if ($_SESSION['error']){?>
            <p class="alert alert-danger">
               <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('error'), null, null);?>
               <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

            </p>
            <br />
            <?php }?> 
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <form method="post" action="">
                              <?php echo $_smarty_tpl->getVariable('lang')->value['category'];?>
: 
                              <select name='category' onChange='this.form.submit();' class="form-control form-half">
                                 <option value="all"><?php echo $_smarty_tpl->getVariable('lang')->value['all'];?>
</option>
                                 <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['objx'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('category')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['objx']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                                 	<?php if ($_smarty_tpl->tpl_vars['name']->value['category']!=''){?>
                                 		<option value="<?php echo $_smarty_tpl->tpl_vars['name']->value['category'];?>
" <?php if ($_smarty_tpl->tpl_vars['name']->value['category']==$_REQUEST['category']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['name']->value['category'];?>
</option>
                                 	<?php }?>
                                 <?php }} ?>   
                              </select>
                              <br />
                              <br />
                           </form>
                           <table id="downloads" class="table table-striped table-bordered table-hover">
                           	  <thead>
                              	<tr>
                              		<td><?php echo $_smarty_tpl->getVariable('lang')->value['filename'];?>
</td>
                                    <td><?php echo $_smarty_tpl->getVariable('lang')->value['category'];?>
</td>
                                    <td><?php echo $_smarty_tpl->getVariable('lang')->value['description'];?>
</td>
                                    <td><?php echo $_smarty_tpl->getVariable('lang')->value['size'];?>
</td>                                    
                                    <td>Posted By</td>
                                    <td><?php echo $_smarty_tpl->getVariable('lang')->value['upload_date'];?>
</td>
                              	</tr>
                              </thead>
                              <?php if (!$_smarty_tpl->getVariable('files')->value){?>
                              	 <tr>
                                    <td colspan="6"><?php echo $_smarty_tpl->getVariable('lang')->value['no_result_found'];?>
</td>
                                 </tr>
                              <?php }else{ ?>
                              <tbody>
                                 <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('files')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                                 <tr>
                                    <td>
                                       <?php ob_start(); ?><?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
<?php  $_smarty_tpl->assign('comm', ob_get_contents()); Smarty::$_smarty_vars['capture']['default']=ob_get_clean();?>                                
                                       <a href="<?php if ($_smarty_tpl->getVariable('membershipId')->value>=$_smarty_tpl->tpl_vars['name']->value['minium_membership']){?>/members/myvault/&file=<?php echo $_smarty_tpl->getVariable('encoded')->value[$_smarty_tpl->getVariable('comm')->value];?>
<?php }else{ ?>#"onClick="return confirm ('<?php echo $_smarty_tpl->getVariable('lang')->value['you_need_to_upgrade_your_membership_to_download_this_file'];?>
');<?php }?>"><strong><?php echo $_smarty_tpl->tpl_vars['name']->value['title'];?>
</strong></a><?php if ($_smarty_tpl->tpl_vars['name']->value['featured']=="yes"){?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/assets/members/images/featured.png" /><?php }?>                                    </td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['name']->value['category'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['name']->value['description'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['name']->value['size'];?>
 Bytes</td>                                    
                                    <td>PlusMoreUsa</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['name']->value['date'];?>
</td>
                                 </tr>
                                 <?php }} ?>
                               <?php }?>                              
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
<?php $_template = new Smarty_Internal_Template('right_sidebar.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>   
<!-- Vendor scrits -->
<?php $_template = new Smarty_Internal_Template('vendor_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?> 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
    
    
   });
   
</script>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>