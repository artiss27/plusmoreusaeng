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
							{foreach $errors as $error}
							<div class="alert alert-danger">
								<p><strong>{$error@key}</strong> {$error}</p>
							</div>
							{/foreach} <br />
					<h2 class="font-light m-b-xs">
						PIF Startup Settings
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">
							   
							<div class="content-box">
								<div class="box-body">
									<div class="box-wrap clear">
										<form action="/admin/pifstartup/" method="post" class="validate-form form bt-space15">
											<div class="columns clear bt-space15">
												<div class="col2-3">
													<div class="form-field clear"></div>
													Select how many PIF will get the member on start up.<br />
													<table width="100%" cellspacing="0" class="basic">
														<tbody>
															{foreach key=obj item=name from=$memberships}                             
															<tr>
																<td>
																	<p><strong>{$name|replace:"_":" "}</strong> <span class="clear">
																		</span>
																	</p>
																</td>
																<td>
																	{capture assign=comm}{$name}_pif_startup{/capture}             
																	<label for="textfield"></label>
																	<input name="{$name}_pif_startup" type="text" id="textfield" size="6" class="form-control" value="{$settings.$comm}" />
																</td>
															</tr>
															{/foreach}                            
														</tbody>
													</table>
													<br />
												</div>
											</div>
											<div class="form-field clear">
												<br />
												<button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
												<br />
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