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
                    {if $template_update eq 'y'}
							<div class="alert alert-success">
								
								<p><strong>Template Updated:</strong> Template was succesfully updated to database.</p>
							</div>
							{/if}  
							{foreach $errors as $error}
							<div class="alert alert-danger">
								
								<p><strong>{$error@key}</strong> {$error}</p>
							</div>
							{/foreach}
                            <br />
					<h2 class="font-light m-b-xs">
						Email Templates
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">
							    
							<div class="content-box">
								<div class="box-body">
									<div class="box-wrap clear">
										<table class="topic" border="0" cellpadding="0" cellspacing="0" align='center' width='100%'>
											<tr>
												<td></td>
											</tr>
											<tr>
												<td height='12'></td>
											</tr>
											<tr>
												<td>
													<span class='error'>{$data.MESSAGE}</span>
												<td>
											</tr>
											<tr>
												<td>
													<form action='#' method='POST'>
														<b>Change Template:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														{$data.MAIN_SELECT}
													</form>
												<td>
											</tr>
											<tr>
												<td height='12'></td>
											</tr>
											<tr>
												<td>
													<form action='#' method='POST'>
														{$data.MAIN_SELECT2}
														<input type='hidden' name='filter' value=1>
													</form>
												<td>
											</tr>
											<tr>
												<td height='12'></td>
											</tr>
											<tr>
												<td></td>
											</tr>
											<tr>
												<td height='12'></td>
											</tr>
										</table>
										<form action='#' method='POST' name='form1'>
											<table cellpadding="2" cellspacing="0" border="0" align="center" width='100%'>
												<tr>
													<td>
														<b>Email Subject : </b>
													</td>
													<td>
														{$data.EMAIL_SUBJECT}
													</td>
												</tr>
												<tr>
													<td>&nbsp;
													</td>
													<td>&nbsp;
													</td>
												</tr>
												<tr>
													<td valign='top'>
														<b>Email Body :</b>
													</td>
													<td>
														{$data.EMAIL_MESSAGE}
													</td>
												</tr>
												<tr>
													<td>&nbsp;
													</td>
													<td>&nbsp;
													</td>
												</tr>
												<tr>
													<td>
													</td>
													<td align="left">
														{$data.RADIO_BUTTONS}
													</td>
												</tr>
												<tr>
													<td align="center" colspan='2'>
														<br />
														
														<input type='hidden' name="save" value="Save">
														<button type="button" name="save" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button>
													</td>
												</tr>
												<tr>
													<td align="left" colspan='2'>
														<hr>
														<b>Replacements</b>:
													</td>
												</tr>
												<tr>
													<td align="left" colspan='2'>
														<hr>
														&nbsp;
													</td>
												</tr>
												</tr>
												<td align="left" colspan='2'>
													{$data.CHANGE_TEMPLATE}
												</td>
												</tr>
											</table>
											<input type='hidden' name='order' value='update'>
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