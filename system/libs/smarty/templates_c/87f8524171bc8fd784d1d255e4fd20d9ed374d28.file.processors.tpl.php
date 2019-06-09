<?php /* Smarty version Smarty-3.0.8, created on 2019-05-02 16:41:38
         compiled from "system/app/views/admin/processors.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6492122725ccb80324ac4e2-74197995%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87f8524171bc8fd784d1d255e4fd20d9ed374d28' => 
    array (
      0 => 'system/app/views/admin/processors.tpl',
      1 => 1503704417,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6492122725ccb80324ac4e2-74197995',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/hermes/walnaweb10a/b1543/pow.plusmoreusaengcom/htdocs/system/libs/smarty/plugins/modifier.replace.php';
?>﻿<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
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
                    <?php if ($_smarty_tpl->getVariable('processor_updated')->value=='y'){?>
							<div class="alert alert-success">
								<p><strong>Processor Updated:</strong> Your Payment Processor settings were saved succesfully on database.</p>
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
							<?php }} ?> <br />
					<h2 class="font-light m-b-xs">
						Payment Processors Settings
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">							
							<div class="content-box">
								<div class="box-body">
									<?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('processors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>  
									<div class="modal fade" id="myModal<?php echo $_smarty_tpl->tpl_vars['name']->value['processor_id'];?>
" tabindex="-1" role="dialog" aria-hidden="true">
										<form id="form1" name="form1" method="post" action="/admin/processors/">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="color-line"></div>
													<div class="modal-header text-center">
														<h4 class="modal-title">Update <?php echo $_smarty_tpl->tpl_vars['name']->value['name'];?>
</h4>
													</div>
													<div class="modal-body">
														Account/Payee/Store ID : <input name="account_id" type="text" size="25" value="<?php echo $_smarty_tpl->tpl_vars['name']->value['account_id'];?>
" class="form-control" />
														<br />                                                        
                                                        <?php  $_smarty_tpl->tpl_vars['extra'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = unserialize($_smarty_tpl->tpl_vars['name']->value['extra_code']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['extra']->key => $_smarty_tpl->tpl_vars['extra']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['extra']->key;
?> 
														<?php echo ucwords(smarty_modifier_replace($_smarty_tpl->tpl_vars['key']->value,"_"," "));?>
 : <input name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" type="text" size="20" value="<?php echo $_smarty_tpl->tpl_vars['extra']->value;?>
" class="form-control" />
														<br />
                                                        <?php }} ?>
                                                        Fee Flat : <input name="fee_flat" type="text" size="20" maxlength="35" value="<?php echo $_smarty_tpl->tpl_vars['name']->value['fee_flat'];?>
" class="form-control" />
														<br />
                                                        Fee Percent : <input name="fee_percent" type="text" size="20" maxlength="35" value="<?php echo $_smarty_tpl->tpl_vars['name']->value['fee_percent'];?>
" class="form-control" />
														<br />
														Active for Payment : <input type="checkbox" name="active" <?php if ($_smarty_tpl->tpl_vars['name']->value['active']==1){?>checked="checked"<?php }?> />
														<br />
														Active for Withdrawal : <input type="checkbox" name="active_withdrawal" <?php if ($_smarty_tpl->tpl_vars['name']->value['active_withdrawal']==1){?>checked="checked"<?php }?> />
														<br /><input name="processor_id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['name']->value['processor_id'];?>
" class="form-control" />
														<input type="hidden" class="button red fr" name="bnupdate" value="Update" />
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button>
													</div>
												</div>
											</div>
										</form>
									</div>
									<?php }} ?>  
									<div class="form-field clear"></div>
									<br />
									<table id="transaction" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Processor</th>
                                                <th>Account ID</th>
                                                <th>Fee Flat</th>
                                                <th>Fee Percent</th>
												<th>Active for payment</th>
												<th>Active for withdraw</th>												
												<th>Options</th>
											</tr>
										</thead>
										<tbody>
											<?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('processors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>    
											<tr>
												<td><?php echo $_smarty_tpl->tpl_vars['name']->value['name'];?>
</td>
                                                <td><?php echo $_smarty_tpl->tpl_vars['name']->value['account_id'];?>
</td>
												<td><?php echo $_smarty_tpl->tpl_vars['name']->value['fee_flat'];?>
</td>
												<td><?php echo $_smarty_tpl->tpl_vars['name']->value['fee_percent'];?>
</td>                                                                                                
												<td><?php echo $_smarty_tpl->tpl_vars['name']->value['active'];?>
</td>
												<td><?php echo $_smarty_tpl->tpl_vars['name']->value['active_withdrawal'];?>
</td>												
												<td><button class="btn btn-info " type="button" data-toggle="modal" data-target="#myModal<?php echo $_smarty_tpl->tpl_vars['name']->value['processor_id'];?>
"><i class="fa fa-paste"></i> Edit</button></td>
											</tr>
											<?php }} ?>
										</tbody>
									</table>
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
<?php $_template = new Smarty_Internal_Template('footer_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>