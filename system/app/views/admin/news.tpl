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
						News
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">
							{if $news_saved eq 'y'}
							<div class="alert alert-success>
								<p><strong>News Saved:</strong> Your News data was saved succesfully on database.</p>
								</div>
								{/if}  
								{if $news_deleted eq 'y'}
								<div class="alert alert-success">
								<p><strong>News Deleted:</strong> News selected was deleted succesfully from database.</p>
							</div>
							{/if}  
							{foreach $errors as $error}
							<div class="alert alert-danger">
								<p><strong>{$error@key}</strong> {$error}</p>
							</div>
							{/foreach}    
							<div class="content-box">
								<div class="box-body">
									<div class="box-wrap clear">
										<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<form action="/admin/news/" method="post" name="form1" id="form1">
														<div class="color-line"></div>
														<div class="modal-header text-center">
															<h4 class="modal-title">Add News</h4>
														</div>
														<div class="modal-body">
															<label for="News"></label>
															Title
															:
															<label for="fileField2"></label>
															<input name="title" type="text" size="35" maxlength="35" class="form-control" />
															<br />
															<br />
															<label for="textarea">Body:</label>
															<textarea name="body" id="textarea" cols="65" rows="15" class="form-control"></textarea>
															<br />
															<br />
															<input type="hidden" class="button red fr" name="addnew" value="Submit" />
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="button" class="btn btn-primary" onclick = 'this.form.submit();'>Save changes</button>
														</div>
												</div>
												</form>
											</div>
										</div>
										<div class="columns clear bt-space15">
											<div class="col2-3">
												<div class="form-field clear">
													<button type="button" class="btn btn-success m-t" data-toggle="modal" data-target="#myModal">
													<i class="fa fa-newspaper-o"></i> Add News
													</button>
												</div>
												<br />
												<table width="50%" cellspacing="0" class="basic">
													<tbody>
														{foreach key=obj item=name from=$news}
														<div class="modal fade" id="myModal{$name.id}" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<form action="/admin/news/" method="post" name="form1" id="form1">
																		<div class="color-line"></div>
																		<div class="modal-header text-center">
																			<h4 class="modal-title">Update News</h4>
																		</div>
																		<div class="modal-body">
																			<label for="News Email"></label>
																			Title:
																			<label for="fileField2"></label>
																			<input name="title" type="text" size="25" maxlength="35" value="{$name.title}" class="form-control" />
																			<br />
																			<label for="textarea"></label>
																			Body:
																			<textarea name="body" id="textarea" cols="65" rows="15" class="form-control">{$name.body}</textarea>
																			<br /><input name="id" type="hidden" value="{$name.id}" />
																			<input type="hidden" class="button red fr" name="update" value="Update" />
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																			<button type="button" class="btn btn-primary" onclick = 'this.form.submit();'>Save changes</button>
																		</div>
																	</form>
																</div>
															</div>
														</div>
														{/foreach}                 
														<tr>
															<td>
																<table id="transaction" class="table table-striped table-bordered table-hover">
																	<thead>
																		<tr>
																			<th>News</th>
																			<th>Date</th>
																			<th>Actions</th>
																		</tr>
																	</thead>
																	<tbody>
																		{foreach key=obj item=name from=$news}
																		<tr>
																			<td>{$name.title}</td>
																			<td>{$name.date}</td>
																			<td><button class="btn btn-info " type="button" data-toggle="modal" data-target="#myModal{$name.id}"><i class="fa fa-paste"></i> Edit</button> <a href="/admin/news/&del={$name.id}" onClick="return confirm ('Do you really want to delete this banner?');"><button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i> <span class="bold"> Delete</span></button></td>
																		</tr>
																		{/foreach}
																	</tbody>
																</table>
															</td>
														</tr>
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