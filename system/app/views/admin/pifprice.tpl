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
						Pif Settings
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">
							{if $settings_saved eq 'y'}
							<div class="alert alert-success">
								<p><strong>Settings Saved:</strong> Your settings were saved succesfully on database.</p>
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
										<form action="#" method="post" class="validate-form form bt-space15">
											<div class="columns clear bt-space15">
												<div class="col2-3">
													<div class="clear">
														<label for="textfield" class="form-label size-120 fl-space2">Pif Price:</label>
														$ 
														<input name="pifprice" type="text" id="textfield" size="5" value='{$settings.pifprice}' class="form-control" />
													</div>
													<!-- /.form-field -->
													<div class="form-field clear"></div>
												</div>
											</div>
											<br>
											<div class="form-field clear">
												<input type="hidden" class="button red fr" name="bnsubmit" value="Save" />
												<button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
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