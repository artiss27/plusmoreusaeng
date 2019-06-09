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
                {if $settings_saved eq 'y'}
						<div class="alert alert-success">
							
							<p><strong>Settings Saved:</strong> Your membership settings were saved succesfully on database.</p>
						</div>
						{/if}  
						{if $membership_saved eq 'y'}
						<div class="alert alert-success">
							
							<p><strong>Membership Saved:</strong> Your membership name was saved succesfully on database.</p>
						</div>
						{/if}  
						{if $membership_deleted eq 'y'}
						<div class="alert alert-success">
							
							<p><strong>Membership Deleted:</strong> Your membership name was deleted succesfully from database.</p>
						</div>
						{/if}  
						{if $membership_updated eq 'y'}
						<div class="alert alert-success">
							
							<p><strong>Memberships Updated:</strong> Your memberships names were updated succesfully to database.</p>
						</div>
						{/if} 
						{foreach $errors as $error}
						<div class="alert alert-success">
							
							<p><strong>{$error@key}</strong> {$error}</p>
						</div>
						{/foreach}  <br />
				<h2 class="font-light m-b-xs">
					Memberships
				</h2>
				<div class="main pagesize">
					<!-- *** mainpage layout *** -->
					<div class="main-wrap">
						  
						<div class="content-box">
							<div class="box-body">
								<div class="box-wrap clear">
									<div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<form id="form1" name="form1" method="post" action="/admin/membershipsettings/">
													<div class="color-line"></div>
													<div class="modal-header">
														<h4 class="modal-title">Add new Membership</h4>
													</div>
													<div class="modal-body text-center">
														<label for="Membership Name">Membership Name (Allowed Characters: a-zA-Z/space/underscore)</label>
														<br /> 
														<input type="text" name="addmembership" class="form-control m-t" id="Membership" />
														<br />
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-primary" onclick = 'this.form.submit();'>Save changes</button>
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<form action="/admin/membershipsettings/" method="post" class="validate-form form bt-space15">
										<div class="columns clear bt-space15">
											<div class="col2-3">
												<div class="form-field clear">
													<br />						  
													<table width="50%" cellspacing="0" class="basic">
														<tbody>
															{foreach key=obj item=name from=$memberships}                             
															<tr>
																<th class="full"><input name="membership[{$obj}]" type="text" id="Membership" class="form-control m-b" size="25" value="{$name|replace:"_":" "}" /></th>
																<td><a href="/admin/membershipsettings/&del={$obj}" onClick="return confirm ('Do you really want to delete this membership?');"><button class="btn btn-danger m-l m-b" type="button"><i class="fa fa-trash-o"></i> <span class="bold">Delete</span></button></a></td>
															</tr>
															{/foreach}                            
														</tbody>
													</table>
												</div>
											</div>
											<div class="form-field clear">
												<button type="button" class="btn btn-primary m-b" onclick = 'this.form.submit();'>Save changes</button> <button class="btn btn-success m-b" type="button" data-toggle="modal" data-target="#myModal"><i class="fa pe-7s-share"></i> <span class="bold">Add New Membership</span></button>
												<p class="clean-padding"><strong>Click on the Save</strong> button will rename memberships.<br />
													<br />
													* We <strong>strongly</strong> recommend to <strong>DON'T</strong> delete or rename any membership <strong>in use</strong>, unless you know what are you doing.<br />
                                                    * Membership Name Allowed Characters: a-zA-Z/space/underscore
												</p>
											</div>
											<!-- /.form-field -->																								
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
{include file='footer_scripts.tpl'}
{include file='footer.tpl'}