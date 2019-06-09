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
					PIF Settings
				</h2>
				<br>
				<div class="main pagesize">
					<!-- *** mainpage layout *** -->
					<div class="main-wrap">
						{if $settings_saved eq 'y'}
						<div class="alert alert-success">
							<p><strong>Settings Saved:</strong> Your membership settings were saved succesfully on database.</p>
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
										<form action="/admin/pifsettings/" method="post" class="validate-form form bt-space15">
											<div class="columns clear bt-space15">
												<div class="col2-3">
													<div class="form-field clear"></div>
													Select which membership will be the one selected on PIF placements.<br /><br>
													<table width="100%" cellspacing="0" class="basic">
														<tbody>
															{foreach key=obj item=name from=$memberships}                  
															<tr>
																<td>
																	<p><strong>
																		<input name="pif_membership" type="radio" id="radio" value="{$name}" {if $settings.pif_membership eq $name}checked="checked"{/if} />
																		<label for="radio"></label>
																		{$name|replace:"_":" "}</strong> <span class="clear">
																		</span>
																	</p>
																</td>
																<td>
																</td>
															</tr>
															{/foreach}                            
														</tbody>
													</table>
													<br />
												</div>
											</div>
											<div class="form-field clear">
												<input type="hidden" class="button red fr" name="bnsubmit" value="Save" />
												<button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
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