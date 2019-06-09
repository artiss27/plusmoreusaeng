<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 07:06:24
         compiled from "system/app/views/admin/transactions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2268674585cf7cc601a4b96-22130027%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9ef34f0630f0adcd712a451d30d0ccd9b9099caa' => 
    array (
      0 => 'system/app/views/admin/transactions.tpl',
      1 => 1503704417,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2268674585cf7cc601a4b96-22130027',
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
                  View Member Transactions
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
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
                              <form action="#" method="post" class="validate-form form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                    <br />
                                       <div class="form-group">
                                          <label for="select" class="col-sm-2 control-label">Wallet Type</label>
                                          <select name="type" id="select" class="form-control">
                                             <option value="deposit">Desposit Wallet</option>
                                             <option value="payout">Payout Wallet</option>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label for="textfield" class="col-sm-2 control-label">Member ID or Username:</label>
                                          <input name="member_id" type="text" class="form-control" id="textfield" size="10" value='<?php echo $_REQUEST['member_id'];?>
' />
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <button type="button" class="btn btn-primary m-t" onclick='this.form.submit();'>Search</button>
                                 </div>
																						
                              </form>
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
