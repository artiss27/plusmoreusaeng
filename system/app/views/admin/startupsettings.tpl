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
						Startup Settings
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">							 
							<div class="content-box">
								<div class="box-body">
									<div class="box-wrap clear">
										<form action="/admin/bonussettings/" method="post" class="validate-form form bt-space15">
											<div class="columns clear bt-space15">
												<div class="col2-3">
                                                {if $smarty.session.plan.unilevel}<br />Unilevel plan detected! Select your direct selling membership commission behaviour <br /><br />
                                                	 <div class="clear">               
                                                       <select id="settings_unilevel_direct_behaviour" class="form-control required" name="settings_unilevel_direct_behaviour">
                                                       <option value="start_up_bonus" {if $settings.settings_unilevel_direct_behaviour eq 'start_up_bonus'}selected="selected"{/if}>Pay start up bonus</option>
                                                       <option value="level_plan" {if $settings.settings_unilevel_direct_behaviour eq 'level_plan'}selected="selected"{/if}>Pay level 1 percent as setup on plan structure</option>     
                                                       </select>
                                                    </div>
                                                    <br />                                                 
                                                {/if}
                                                <br />
													<div class="form-field clear"></div>
													<br />
													{foreach key=obj item=name from=$memberships}						  
													<b>{$name|replace:"_":" "}</b> Fast Startup Settings (If this member type refers another member this is what they receive)<br />
													<table width="100%" cellspacing="0" class="basic">
														<tr>
															{foreach key=objx item=namex from=$memberships}				
															<td align="center"><strong>{$namex|replace:"_":" "}</strong>
															</td>
															{/foreach}
														</tr>
														<tr>
															{foreach key=objx item=namex from=$memberships}	    
															<td align="center">    
																{capture assign=comm}{$name}_{$namex}_startup_bonus{/capture}             
																$<label for="textfield"></label>
																<input name="{$name}_{$namex}_startup_bonus" type="text" id="textfield" class="form-control" size="6" style="width: 100px;" value="{$settings.$comm}" />            
															</td>
															{/foreach}					
														</tr>
													</table>
													<br /><br />
													<hr>
													{/foreach}                    <br />        
												</div>
											</div>
											<div class="form-field clear">
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