<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 10:40:27
         compiled from "system/app/views/admin/addmember.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11889317505cf7fe8bb98c60-65839386%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dcbd9aca2f42930343e823c9558fc0e513feff65' => 
    array (
      0 => 'system/app/views/admin/addmember.tpl',
      1 => 1518495099,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11889317505cf7fe8bb98c60-65839386',
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
						Add Member
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">
							<?php if ($_smarty_tpl->getVariable('member_added')->value=='y'){?>
							<div class="alert alert-success">
								<p><strong>Member Added:</strong> New member was added succesfully to database.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://plusmoreusaeng.com/admin/addmember/">Add New Member</a></p>
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
							<div class="content-box">
								<div class="box-body">
									<div class="box-wrap clear">
										<form action="#" method="post">
											<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center" class="style1">
												<tbody>
													<tr>
														<td class="w_border">&nbsp;</td>
													</tr>
													<tr>
														<td>
															<h3>Add new member</h3>
														</td>
													</tr>
													<tr>
														<td class="w_border">
															<table border="0" cellspacing="0" cellpadding="2" align="left" width="100%">
																<tbody>
																	<tr>
																		<td width="30%"><b>First name :</b></td>
																		<td><input type="text" name="firstName" value="<?php echo $_REQUEST['firstName'];?>
" maxlength="120" class="form-control" />
																			&nbsp; <span class="error"></span>
																		</td>
																	</tr>
																	<tr>
																		<td><b>Last name :</b></td>
																		<td><input type="text" name="lastName" value="<?php echo $_REQUEST['lastName'];?>
" maxlength="120" class="form-control" />
																			&nbsp; <span class="error"></span>
																		</td>
																	</tr>
																	<tr>
																		<td><b>E-mail :</b></td>
																		<td><input type="text" name="email" value="<?php echo $_REQUEST['email'];?>
" maxlength="120" class="form-control" />
																			&nbsp; <span class="error"></span>
																		</td>
																	</tr>
																	<tr>
																		<td><b>Sponsor ID :</b></td>
																		<td><input type="text" name="sponsor" value="<?php echo $_REQUEST['sponsor'];?>
" maxlength="12" class="form-control" />
																			&nbsp; <span class="error"></span>
																		</td>
																	</tr>
  																	<tr>
																		<td>&nbsp;</td>
																		<td>&nbsp;</td>
																	</tr>
																	<tr>
																		<td>
																			<h3>Login Info</h3>
																		</td>
																	</tr>
																	<tr>
																		<td><b>Username :</b></td>
																		<td><input type="text" name="username" value="<?php echo $_REQUEST['username'];?>
" maxlength="120" class="form-control" />
																			&nbsp; <span class="error"></span>
																		</td>
																	</tr>
																	<tr>
																		<td><b>Password :</b></td>
																		<td><input type="text" name="password" value="<?php echo $_REQUEST['password'];?>
" maxlength="12" class="form-control" />
																			&nbsp; <span class="error"></span>
																		</td>
																	</tr>
																	<tr>
																		<td colspan="2"></td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td>
															<h3>Address Settings</h3>
														</td>
													</tr>
													<tr>
														<td class="w_border">
															<table border="0" cellspacing="0" cellpadding="2" align="left" width="100%">
																<tbody>
																	<tr>
																		<td width="30%"><b>Address :</b></td>
																		<td><input type="text" name="street" value="<?php echo $_REQUEST['street'];?>
" class="form-control m-b" maxlength="50" /></td>
																	</tr>
																	<tr>
																		<td><b>City :</b></td>
																		<td><input type="text" name="city" value="<?php echo $_REQUEST['city'];?>
" class="form-control m-b" maxlength="50" /></td>
																	</tr>
																	<tr>
																		<td><b>State :</b></td>
																		<td><input type="text" name="state" value="<?php echo $_REQUEST['state'];?>
" class="form-control m-b" maxlength="50" /></td>
																	</tr>
																	<tr>
																		<td><b>Country :</b></td>
																		<td>
                                                                        <select name="country" class="form-control m-b">
                                                                        <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('countries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value['code'];?>
" <?php if ($_REQUEST['country']==($_smarty_tpl->tpl_vars['name']->value['code'])){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['name']->value['country'];?>
</option>
                                                                        <?php }} ?>
                                                                        </select>                                                                
                                    								</td>
																	</tr>
																	<tr>
																		<td><b>Postal Code :</b></td>
																		<td><input type="text" name="postal" value="<?php echo $_REQUEST['postal'];?>
" class="form-control m-b" maxlength="50" /></td>
																	</tr>
																	<tr>
																		<td><b>Phone :</b></td>
																		<td><input type="text" placeholder="+1918762251" name="phone" value="<?php echo $_REQUEST['phone'];?>
" class="form-control m-b" maxlength="50" /></td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td>
															<h3>Transaction Processor</h3>
														</td>
													</tr>
													<tr>
														<td class="w_border">
															<table cellpadding="2" cellspacing="0" border="0" width="100%">
																<tbody>
																	<tr>
																		<td width="30%"><b> Money Processor :</b></td>
																		<td>
																			<select name="processor" class="form-control m-b">
																				<option value="0">Select processor</option>
																				<?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('processors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
																				<option value="<?php echo $_smarty_tpl->tpl_vars['name']->value['processor_id'];?>
" <?php if ($_REQUEST['processor']==($_smarty_tpl->tpl_vars['name']->value['processor_id'])){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['name']->value['name'];?>
</option>
																				<?php }} ?>
																			</select>
																		</td>
																	</tr>
																	<tr>
																		<td><b> Account ID :</b></td>
																		<td><input type="text" name="account_id" value="<?php echo $_REQUEST['account_id'];?>
" class="form-control m-b" maxlength="150" /></td>
																	</tr><tr>
														<td>
															<h3>Tax Account Information</h3>
														</td>
													</tr>
																	<tr>
			                                                            <td><b>Tax User :</b></td>
			                                                            <td><input type="text" name="Tax_User" value="<?php echo $_REQUEST['Tax_User'];?>
" class="form-control m-b" maxlength="30" /></td>
			                                                         </tr>
			                                                         <tr>
			                                                            <td><b>Tax Pass :</b></td>
			                                                            <td><input type="text" name="Tax_Pass" value="<?php echo $_REQUEST['Tax_Pass'];?>
" class="form-control m-b" maxlength="30" /></td>
			                                                         </tr>
			                                                         <tr>
			                                                            <td><b>Tax email :</b></td>
			                                                            <td><input type="text" name="Tax_email" value="<?php echo $_REQUEST['Tax_email'];?>
" class="form-control m-b" maxlength="30" /></td>
			                                                         </tr>
			                                                         <tr>
			                                                            <td><b>Tax Agency :</b></td>
			                                                            <td><input type="text" name="Tax_Agency" value="<?php echo $_REQUEST['Tax_Agency'];?>
" class="form-control m-b" maxlength="30" /></td>
			                                                         </tr><tr>
                                                            <td><b>Link to Agencies:</b></td>
                                                            <td><a href="https://www.freetaxusa.com" target="_blank">FreeTaxUsa</a>   -   <a href="https://idp.hrblock.com/idp/profile/SAML2/Redirect/SSO?execution=e2s1"  target="_blank">HRBlock</a>   -   <a href="https://www.turtotax.com"  target="_blank">TurboTax</a></td>
                                                         </tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td class="w_border">&nbsp;</td>
													</tr>

													<tr>
														<td class="w_border">
															<table border="0" cellspacing="0" cellpadding="2" align="center" width="100%">
																<tbody>
																	<tr>
																		<td width="30%">&nbsp;</td>
																		<td align="left">
																			<button type="button" class="btn btn-primary" onclick='this.form.submit();'>Add Member</button> <button type="button" class="btn btn-default" onclick="window.location.href='/admin/members'">Cancel</button>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
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