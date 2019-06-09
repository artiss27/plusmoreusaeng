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
					<div id="hbreadcrumb" class="pull-right-lg">
						<ol class="hbreadcrumb breadcrumb">
						</ol>
					</div>
					<h2 class="font-light-xs">
						Unilevel Membership Settings
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">
							{if $settings_saved eq 'y'}
							<div class="alert alert-success">
								<p><strong>Settings Saved:</strong> Your membership settings were saved succesfully on database.</p>
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
										<form action="/admin/unilevelsettings/" method="post" class="validate-form form bt-space15">
											<div class="columns clear bt-space15">
												<div class="col2-3">
													<div class="form-field clear"></div>
													<br />
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
																	<select id="{$name}_unilevel_type" class="form-control required" name="{$name}_unilevel_type" style="width:100px;;">
																	{capture assign=comm}{$name}_unilevel_type{/capture}             
																	<option value="percent" {if $settings.$comm eq 'percent'}selected="selected"{/if}>percent</option>
																	<option value="flat" {if $settings.$comm eq 'flat'}selected="selected"{/if}>flat</option>
																	</select>
																</td>
															</tr>
															<tr>
																<td colspan="5">
																	<p>&nbsp;</p>
																	<p>* For Percent Commissions, make sure to enter a decimal equivalent of the percent. For example: (0.50 for 50%). </p>
																	<p>* Flat-Fee Commissions can be any number. Do not include any currency characters ($, &euro;, &pound;)</p>
																	<p>&nbsp;</p>
																</td>
															</tr>
															<tr>
																<td><span>Level 1</span>
																	{capture assign=comm}{$name}_commission_level_1{/capture}
																	<input name="{$name}_commission_level_1" type="text" value="{$settings.$comm}" size="5" class="form-control form-select" style="width:100px;" />
																</td>
																<td><span>Level 2</span>
																	{capture assign=comm}{$name}_commission_level_2{/capture}
																	<input name="{$name}_commission_level_2" type="text" value="{$settings.$comm}" size="5" class="form-control form-select" style="width:100px;" />
																</td>
																<td><span>Level 3</span>
																	{capture assign=comm}{$name}_commission_level_3{/capture}
																	<input name="{$name}_commission_level_3" type="text" value="{$settings.$comm}" size="5" class="form-control form-select" style="width:100px;" />
																</td>
																<td><span>Level 4</span>
																	{capture assign=comm}{$name}_commission_level_4{/capture}
																	<input name="{$name}_commission_level_4" type="text" value="{$settings.$comm}" size="5" class="form-control form-select" style="width:100px;" />
																</td>
																<td><span>Level 5</span>&nbsp;&nbsp;
																	{capture assign=comm}{$name}_commission_level_5{/capture}
																	<input name="{$name}_commission_level_5" type="text" value="{$settings.$comm}" size="5" class="form-control form-select" style="width:100px;" />
																</td>
															</tr>
															<tr><td><p>&nbsp;</p></td></tr>
															<tr>
																<td><span>Level 6</span>
																	{capture assign=comm}{$name}_commission_level_6{/capture}
																	<input name="{$name}_commission_level_6" type="text" value="{$settings.$comm}" size="5" class="form-control form-select" style="width:100px;" />
																</td>
																<td><span>Level 7</span>
																	{capture assign=comm}{$name}_commission_level_7{/capture}
																	<input name="{$name}_commission_level_7" type="text" value="{$settings.$comm}" size="5" class="form-control form-select" style="width:100px;" />
																</td>
																<td><span>Level 8</span>
																	{capture assign=comm}{$name}_commission_level_8{/capture}
																	<input name="{$name}_commission_level_8" type="text" value="{$settings.$comm}" size="5" class="form-control form-select" style="width:100px;" />
																</td>
																<td><span>Level 9</span>
																	{capture assign=comm}{$name}_commission_level_9{/capture}
																	<input name="{$name}_commission_level_9" type="text" value="{$settings.$comm}" size="5" class="form-control form-select" style="width:100px;" />
																</td>
																<td><span>Level 10</span>
																	{capture assign=comm}{$name}_commission_level_10{/capture}
																	<input name="{$name}_commission_level_10" type="text" value="{$settings.$comm}" size="5" class="form-control form-select" style="width:100px;" />
																</td>
															</tr>
															<tr>
																<td colspan="5">&nbsp;</td>
															</tr>
															<tr>
																<td colspan="5">&nbsp;</td>
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