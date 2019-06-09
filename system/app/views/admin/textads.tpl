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
                {if $smarty.session.message}
               <p class="alert alert-success">
                  {assign var=message_var value=CoreHelp::flash('message')}
                  {$message_var}
               </p>
               <br />
               {/if} 
               {if $smarty.session.error}
               {assign var=message_var value=CoreHelp::flash('error')}            	
               {if $message_var|is_array}
               {foreach $message_var as $error}
               <p class="alert alert-danger">
                  {$error}
               </p>               
               {/foreach} 
               {else}
               <p class="alert alert-danger">
                  {$message_var}
               </p>
               <br />
               {/if}
               {/if} 
               {if $errors}
               {foreach $errors as $error}
               <p class="alert alert-danger">
                  {$error}
               </p>
               {/foreach}
               {/if}
                {if $textads_saved eq 'y'}
						<div class="alert alert-success">
							<p><strong>TextAd Saved:</strong> Your TextAd name was saved succesfully on database.</p>
						</div>
						{/if}  
						{if $textads_deleted eq 'y'}
						<div class="alert alert-success">
							<p><strong>TextAd Deleted:</strong> TextAd was deleted succesfully from database.</p>
						</div>
						{/if}   
						{foreach $errors as $error}
						<div class="alert alert-success">
							<p><strong>{$error@key}</strong> {$error}</p>
						</div>
						{/foreach}  
                        <br />
				<h2 class="font-light m-b-xs">
					Promoting TextAds
				</h2>
				<div class="main pagesize">
					<!-- *** mainpage layout *** -->
					<div class="main-wrap">
                    	
						  
						<div class="content-box">
							<div class="box-body">
								<div class="box-wrap clear">
									<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<form action="/admin/textads/" method="post" name="form1" id="form1">
													<div class="color-line"></div>
													<div class="modal-header text-center">
														<h4 class="modal-title">Add new TextAd</h4>
													</div>
													<div class="modal-body">                                   
														<label for="TextAd"></label>
														Heading
														:
														<label for="fileField2"></label>
														<input name="textad_heading" type="text" size="25" maxlength="35" class="form-control" />
														(max 25 characters)<br />
														<br />
														Line 1
														:
														<input name="textad_line1" type="text" size="25" maxlength="35" class="form-control" />
														(max 35 characters)<br />
														<br />
														Line 2
														:
														<input name="textad_line2" type="text" size="25" maxlength="35" class="form-control" />
														(max 35 characters)<br />
														<br />
														Show Domain
														:
														<input name="textad_domain" type="text" size="25" maxlength="35" class="form-control" />
														(ex. google.com)<br />
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
												<button class="btn btn-success " type="button" data-toggle="modal" data-target="#myModal"><i class="fa fa-text-width"></i><span class="bold"> Add New TextAd</span></button>
												<br />
												{foreach key=obj item=name from=$textads}
												<div class="modal fade" id="myModal{$name.textad_id}" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<form action="/admin/textads/" method="post" name="form1" id="form1">
																<div class="color-line"></div>
																<div class="modal-header text-center">
																	<h4 class="modal-title">Update TextAd</h4>
																</div>
																<div class="modal-body">
																	<label for="TextAd"></label>
																	Heading
																	:
																	<label for="fileField2"></label>
																	<input name="textad_heading" type="text" size="25" maxlength="35" value="{$name.textad_heading}" class="form-control" />
																	(max 25 characters)<br />
																	<br />
																	Line 1
																	:
																	<input name="textad_line1" type="text" size="25" maxlength="35" value="{$name.textad_line1}" class="form-control" />
																	(max 35 characters)<br />
																	<br />
																	Line 2
																	:
																	<input name="textad_line2" type="text" size="25" maxlength="35" value="{$name.textad_line2}" class="form-control" />
																	(max 35 characters)<br />
																	<br />
																	Show Domain
																	:
																	<input name="textad_domain" type="text" size="25" maxlength="35" value="{$name.textad_domain}" class="form-control" />
																	(ex. google.com)<br />
																	<br /><input name="textad_id" type="hidden" value="{$name.textad_id}" />
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
															<th>Heading</th>
															<th>Line 1</th>
															<th>Line 2</th>
															<th>Domain</th>
															<th>Actions</th>
														</tr>
													</thead>
													<tbody>
														{foreach key=obj item=name from=$textads}
														<tr>
															<td>{$name.textad_heading}</td>
															<td>{$name.textad_line1}</td>
															<td>{$name.textad_line2}</td>
															<td>{$name.textad_domain}</td>
															<td><button class="btn btn-info " type="button" data-toggle="modal" data-target="#myModal{$name.textad_id}"><i class="fa fa-paste"></i> Edit</button> <a href="/admin/textads/&del={$name.textad_id}" onClick="return confirm ('Do you really want to delete this banner?');"><button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i> <span class="bold"> Delete</span></button></td>
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