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
						Add Member
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">
							{if $member_added eq 'y'}
							<div class="alert alert-success">
								<p><strong>Member Added:</strong> New member was added succesfully to database.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://plusmoreusaeng.com/admin/addmember/">Add New Member</a></p>
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
																		<td><input type="text" name="firstName" value="{$smarty.request.firstName}" maxlength="120" class="form-control" />
																			&nbsp; <span class="error"></span>
																		</td>
																	</tr>
																	<tr>
																		<td><b>Last name :</b></td>
																		<td><input type="text" name="lastName" value="{$smarty.request.lastName}" maxlength="120" class="form-control" />
																			&nbsp; <span class="error"></span>
																		</td>
																	</tr>
																	<tr>
																		<td><b>E-mail :</b></td>
																		<td><input type="text" name="email" value="{$smarty.request.email}" maxlength="120" class="form-control" />
																			&nbsp; <span class="error"></span>
																		</td>
																	</tr>
																	<tr>
																		<td><b>Sponsor ID :</b></td>
																		<td><input type="text" name="sponsor" value="{$smarty.request.sponsor}" maxlength="12" class="form-control" />
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
																		<td><input type="text" name="username" value="{$smarty.request.username}" maxlength="120" class="form-control" />
																			&nbsp; <span class="error"></span>
																		</td>
																	</tr>
																	<tr>
																		<td><b>Password :</b></td>
																		<td><input type="text" name="password" value="{$smarty.request.password}" maxlength="12" class="form-control" />
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
																		<td><input type="text" name="street" value="{$smarty.request.street}" class="form-control m-b" maxlength="50" /></td>
																	</tr>
																	<tr>
																		<td><b>City :</b></td>
																		<td><input type="text" name="city" value="{$smarty.request.city}" class="form-control m-b" maxlength="50" /></td>
																	</tr>
																	<tr>
																		<td><b>State :</b></td>
																		<td><input type="text" name="state" value="{$smarty.request.state}" class="form-control m-b" maxlength="50" /></td>
																	</tr>
																	<tr>
																		<td><b>Country :</b></td>
																		<td>
                                                                        <select name="country" class="form-control m-b">
                                                                        {foreach key=obj item=name from=$countries}
                                                                        <option value="{$name.code}" {if $smarty.request.country eq "{$name.code}"}selected="selected"{/if}>{$name.country}</option>
                                                                        {/foreach}
                                                                        </select>                                                                
                                    								</td>
																	</tr>
																	<tr>
																		<td><b>Postal Code :</b></td>
																		<td><input type="text" name="postal" value="{$smarty.request.postal}" class="form-control m-b" maxlength="50" /></td>
																	</tr>
																	<tr>
																		<td><b>Phone :</b></td>
																		<td><input type="text" placeholder="+1918762251" name="phone" value="{$smarty.request.phone}" class="form-control m-b" maxlength="50" /></td>
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
																				{foreach key=obj item=name from=$processors}
																				<option value="{$name.processor_id}" {if $smarty.request.processor eq "{$name.processor_id}"}selected="selected"{/if}>{$name.name}</option>
																				{/foreach}
																			</select>
																		</td>
																	</tr>
																	<tr>
																		<td><b> Account ID :</b></td>
																		<td><input type="text" name="account_id" value="{$smarty.request.account_id}" class="form-control m-b" maxlength="150" /></td>
																	</tr><tr>
														<td>
															<h3>Tax Account Information</h3>
														</td>
													</tr>
																	<tr>
			                                                            <td><b>Tax User :</b></td>
			                                                            <td><input type="text" name="Tax_User" value="{$smarty.request.Tax_User }" class="form-control m-b" maxlength="30" /></td>
			                                                         </tr>
			                                                         <tr>
			                                                            <td><b>Tax Pass :</b></td>
			                                                            <td><input type="text" name="Tax_Pass" value="{$smarty.request.Tax_Pass}" class="form-control m-b" maxlength="30" /></td>
			                                                         </tr>
			                                                         <tr>
			                                                            <td><b>Tax email :</b></td>
			                                                            <td><input type="text" name="Tax_email" value="{$smarty.request.Tax_email}" class="form-control m-b" maxlength="30" /></td>
			                                                         </tr>
			                                                         <tr>
			                                                            <td><b>Tax Agency :</b></td>
			                                                            <td><input type="text" name="Tax_Agency" value="{$smarty.request.Tax_Agency}" class="form-control m-b" maxlength="30" /></td>
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
{include file='footer_scripts.tpl'}
{include file='footer.tpl'}