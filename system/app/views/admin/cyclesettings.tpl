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
						<h2 class="font-light m-b-xs">
							Cycle Membership Settings
						</h2>
						<div class="main pagesize">
							<!-- *** mainpage layout *** -->
							<div class="main-wrap">
								{if $cycle_saved eq 'y'}
								<div class="alert alert-success">
									<p><strong>Cycle Data Saved:</strong> Cycle data was saved succesfully to database.</p>
								</div>
								{/if}  
								{if $cycle_deleted eq 'y'}
								<div class="alert alert-success">
									<p><strong>Cycle Data Deleted:</strong> Cycle data was deleted succesfully to database.</p>
								</div>
								{/if}  
								{foreach $errors as $error}
								<div class="alert alert-success">
									<p><strong>{$error@key}</strong> {$error}</p>
								</div>
								{/foreach}  
								{foreach $errors as $error}
								<div class="alert alert-success">
									<p><strong>{$error@key}</strong> {$error}</p>
								</div>
								{/foreach}    
								<div class="content-box">
									<div class="box-body">
										<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
											<form id="form1" name="form1" method="post" action="/admin/cyclesettings/">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="color-line"></div>
														<div class="modal-header text-center">
															<h4 class="modal-title">Add New Cycle</h4>
														</div>
														<div class="modal-body">
															<label for="textfield" class="form-label size-120 fl-space2">Title: <span class="required">*</span></label>
															<input type="text" name="title" class="form-control" />
															<br /><br />
															<label for="textfield" class="form-label size-120 fl-space2">Hoster Reward: <span class="required">*</span></label>
															$ 
															<input name="host_reward" type="text" value="0.00" size="6" class="form-control" />
															<br /><br />
															<label for="textfield" class="form-label size-120 fl-space2">Enroller Reward: <span class="required">*</span></label>
															$ 
															<input name="enr_reward" type="text" value="0.00" size="6" class="form-control" />
															<br /><br />
															<label for="textfield" class="form-label size-120 fl-space2">Hoster PIF Reward: <span class="required">*</span></label>
															<input name="host_pif" type="text" value="0" size="6" class="form-control" />
															<br /><br />
															<label for="textfield" class="form-label size-120 fl-space2">Enroller  PIF Reward: <span class="required">*</span></label>
															<input name="enr_pif" type="text" value="0" size="6" class="form-control" />
															<br /><br />
															<label for="textfield" class="form-label size-120 fl-space2">Width: <span class="required">*</span></label>
															<input name="width" type="text" size="6" class="form-control" />
															<br /><br />
															<label for="textfield" class="form-label size-120 fl-space2">Depth: <span class="required">*</span></label>
															<input name="depth" type="text" size="6"class="form-control" />
															<br /><br /><input type="hidden" class="button red fr" name="bnsubmit" value="Save" />
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button>
														</div>
													</div>
												</div>
											</form>
										</div>
										<div class="form-field clear"></div>
										<div class="form-field clear">
											<button type="button" class="btn btn-success m-t" data-toggle="modal" data-target="#myModal">
											Add Cycle
											</button>
										</div>
										<br />
										<table id="transaction" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<th>ID</th>
													<th>Position</th>
													<th>Title</th>
													<th>Hoster Reward</th>
													<th>Enroller Reward</th>
													<th>Hoster PIF Reward</th>
													<th>Enroller PIF Reward</th>
													<th>With</th>
													<th>Depth</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												{foreach key=obj item=data from=$lines}  
												<tr>
													<td>{$data.ROW_NUMBER}</td>
													<td>{$data.ROW_ORDERLINK}</td>
													<td>{$data.ROW_TITLE}</td>
													<td>${$data.ROW_HOST_REWARD}</td>
													<td>${$data.ROW_ENR_REWARD}</td>
													<td>{$data.ROW_HOST_PIF}</td>
													<td>{$data.ROW_ENR_PIF}</td>
													<td>{$data.ROW_WIDTH}</td>
													<td>{$data.ROW_DEPTH}</td>
													<td>{$data.ROW_EDITLINK} {$data.ROW_DELLINK}</td>
												</tr>
												{/foreach}
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

{include file='footer_scripts.tpl'}
{include file='footer.tpl'}