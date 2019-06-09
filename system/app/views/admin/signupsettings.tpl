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
								<p><strong>Admin Settings Saved:</strong> Your Admin settings were saved succesfully on database.</p>
							</div>
							{/if}  
							{foreach $errors as $error}
							<div class="alert alert-danger">
								<p><strong>{$error@key}</strong> {$error}</p>
							</div>
							{/foreach}  <br />
					<h2 class="font-light m-b-xs">
						Signup Settings
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">
							  
							<div class="content-box">
								<div class="box-body">
									<div class="box-wrap clear">
										<form action="#" method="post" class="validate-form form bt-space5">
											<div class="columns clear bt-space5">
												<div class="col2-3">
													<div class="clear"></div>
													<br />
													<div class="clear">
														<label for="textfield" class="fl-space size-300">Registration Email Confirmation :</label> 
														<select id="signup_email_confirmation" class="form-control required" name="signup_email_confirmation">
														<option value="yes" {if $settings.signup_email_confirmation eq 'yes'}selected="selected"{/if}>Yes</option>
														<option value="no" {if $settings.signup_email_confirmation eq 'no'}selected="selected"{/if}>No</option>     
														</select>
													</div>
														<br />
													<div class="clear">
														<label for="textfield" class="fl-space size-300">Allow New Member Registration :</label>
														<select id="signup_active" class="form-control required" name="signup_active">
														<option value="yes" {if $settings.signup_active eq 'yes'}selected="selected"{/if}>Yes</option>
														<option value="no" {if $settings.signup_active eq 'no'}selected="selected"{/if}>No</option>
														</select>
													</div>
                                                    <div class="clear">
														<label for="textfield" class="fl-space size-300">Sponsor is required :</label>
														<select id="signup_sponsor_required" class="form-control required" name="signup_sponsor_required">
														<option value="yes" {if $settings.signup_sponsor_required eq 'yes'}selected="selected"{/if}>Yes</option>
														<option value="no" {if $settings.signup_sponsor_required eq 'no'}selected="selected"{/if}>No (If not Sponsor filled use Admin account as Sponsor)</option>
														</select>
													</div>
													<br />
													<br /><br />
													<strong>Annual Membership Signup Prices:</strong><br />
													<br />
													{foreach key=obj item=name from=$memberships}
													<div class="form-field clear">
														<label for="textfieldx" class="fl-space size-300">{$name|replace:"_":" "} :</label>
														{capture assign=comm}{$name}_signup_fee{/capture}                          
														$                                
														<input name="{$name}_signup_fee" type="text" value="{$settings.$comm}" size="5" class="form-control" />
													</div>
													{/foreach}
													<div class="clear"></div>
												</div>
											</div>
											<div class="clear">
												<br><br>
												<button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
												<p class="clean-padding">
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