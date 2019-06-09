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
					FAQ
				</h2>
				<div class="main pagesize">
					<!-- *** mainpage layout *** -->
					<div class="main-wrap">
						{if $faq_saved eq 'y'}
						<div class="alert alert-success">
							<p><strong>FAQ Saved:</strong> Your FAQ was saved succesfully on database.</p>
						</div>
						{/if}  
						{if $faq_deleted eq 'y'}
						<div class="alert alert-success">
							<p><strong>FAQ Email Deleted:</strong> FAQ was deleted succesfully from database.</p>
						</div>
						{/if}  
						{foreach $errors as $error}
						<div class="alert alert-success">
							<p><strong>{$error@key}</strong> {$error}</p>
						</div>
						{/foreach}    
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
												{foreach key=obj item=name from=$faq}
												<div class="modal fade" id="myModal{$name.id}" tabindex="-1" role="dialog" aria-hidden="true">
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
																	<input name="question" type="text" size="25" maxlength="35" value="{$name.question}" class="form-control" />
																	<br />
																	<label for="textarea"></label>
																	Answer:
																	<textarea name="answer" id="textarea" cols="65" rows="15" class="form-control">{$name.answer}</textarea>
																	<br /><input name="id" type="hidden" value="{$name.id}" />
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
												{/foreach}  
												<br>
												<table id="transaction" class="table table-striped table-bordered table-hover">
													<thead>
														<tr>
															<th>Question</th>
															<th>Actions</th>
														</tr>
													</thead>
													<tbody>
														{foreach key=obj item=name from=$faq}  
														<tr>
															<td>{$name.question}</td>
															<td><button class="btn btn-info " type="button" data-toggle="modal" data-target="#myModal{$name.id}"><i class="fa fa-paste"></i> Edit</button> <a href="/admin/faq/&del={$name.id}" onClick="return confirm ('Do you really want to delete this banner?');"><button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i> <span class="bold"> Delete</span></button></td>
														</tr>
														{/foreach}
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