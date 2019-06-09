<?php /* Smarty version Smarty-3.0.8, created on 2019-06-04 20:50:04
         compiled from "system/app/views/admin/cache.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10719312435cf73bec1fe618-23386675%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6ac0c12c1c1454d9fd5a52d7593980eddd7f8e58' => 
    array (
      0 => 'system/app/views/admin/cache.tpl',
      1 => 1503704412,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10719312435cf73bec1fe618-23386675',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
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
               <h2 class="font-light m-b-xs">
                  Cache Manager
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
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
                     <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
                     <div class="alert alert-success">
                        
                        <p><strong><?php echo $_smarty_tpl->tpl_vars['error']->key;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
                     </div>
                     <?php }} ?>    
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <div class="columns clear bt-space15">
                                 <div class="col2-3">
                                 <br />
                                 <table id="transaction" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Cached Objects</th>
                                                <th>Cached Templates</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <td><?php echo $_smarty_tpl->getVariable('cache_data')->value;?>
 files</td>
                                        <td><?php echo $_smarty_tpl->getVariable('cache_template')->value;?>
 files</td>
                                        <td><a href="/admin/cache/&reset=1">reset cache</a></td>
                                        </tbody>
                                        </table>    
                                 </div>
                              </div>
                              <!-- /.form-field -->	
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
