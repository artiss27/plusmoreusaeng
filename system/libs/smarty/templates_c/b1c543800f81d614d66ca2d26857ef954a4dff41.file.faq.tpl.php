<?php /* Smarty version Smarty-3.0.8, created on 2019-06-05 02:44:50
         compiled from "system/app/views/admin/faq.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13777038465cf78f121d6eb9-52393806%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1c543800f81d614d66ca2d26857ef954a4dff41' => 
    array (
      0 => 'system/app/views/admin/faq.tpl',
      1 => 1503704413,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13777038465cf78f121d6eb9-52393806',
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
					FAQ
				</h2>
				<div class="main pagesize">
					<!-- *** mainpage layout *** -->
					<div class="main-wrap">
						<?php if ($_smarty_tpl->getVariable('faq_saved')->value=='y'){?>
						<div class="alert alert-success">
							<p><strong>FAQ Saved:</strong> Your FAQ was saved succesfully on database.</p>
						</div>
						<?php }?>  
						<?php if ($_smarty_tpl->getVariable('faq_deleted')->value=='y'){?>
						<div class="alert alert-success">
							<p><strong>FAQ Email Deleted:</strong> FAQ was deleted succesfully from database.</p>
						</div>
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
									<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<form action="/admin/faq/" method="post" name="form1" id="form1">
													<div class="color-line"></div>
													<div class="modal-header text-center">
														<h4 class="modal-title">Add New FAQ</h4>
													</div>
													<div class="modal-body">                                   
														<label for="FAQ"></label>
														Question
														:
														<label for="fileField2"></label>
														<input name="question" type="text" size="25" class="form-control" />
														<br />
														<br />
														<label for="textarea">Answer:</label>
														<textarea name="answer" id="textarea" cols="65" rows="15" class="form-control"></textarea>
														<br />
														<br />
														<input type="hidden" class="button red fr" name="addnew" value="Submit" />
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
											<div class="form-field clear">
												<br>
												<button class="btn btn-success " type="button" data-toggle="modal" data-target="#myModal"><i class="fa fa-question-circle"></i> <span class="bold">Add New FAQ</span></button>
												<br />
												<?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('faq')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
												<div class="modal fade" id="myModal<?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<form action="/admin/faq/" method="post" name="form1" id="form1">
																<div class="color-line"></div>
																<div class="modal-header text-center">
																	<h4 class="modal-title">Update FAQ</h4>
																</div>
																<div class="modal-body">
																	<label for="FAQ Email"></label>
																	Question
																	:
																	<label for="fileField2"></label>
																	<input name="question" type="text" size="25" maxlength="35" value="<?php echo $_smarty_tpl->tpl_vars['name']->value['question'];?>
" class="form-control" />
																	<br />
																	<label for="textarea"></label>
																	Answer:
																	<textarea name="answer" id="textarea" cols="65" rows="15" class="form-control"><?php echo $_smarty_tpl->tpl_vars['name']->value['answer'];?>
</textarea>
																	<br /><input name="id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
" />
																	<input type="hidden" class="button red fr" name="update" value="Update" />
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
												<br>
												<table id="transaction" class="table table-striped table-bordered table-hover">
													<thead>
														<tr>
															<th>Question</th>
															<th>Actions</th>
														</tr>
													</thead>
													<tbody>
														<?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('faq')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>  
														<tr>
															<td><?php echo $_smarty_tpl->tpl_vars['name']->value['question'];?>
</td>
															<td><button class="btn btn-info " type="button" data-toggle="modal" data-target="#myModal<?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
"><i class="fa fa-paste"></i> Edit</button> <a href="/admin/faq/&del=<?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
" onClick="return confirm ('Do you really want to delete this banner?');"><button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i> <span class="bold"> Delete</span></button></td>
														</tr>
														<?php }} ?>
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
<?php $_template = new Smarty_Internal_Template('footer_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>