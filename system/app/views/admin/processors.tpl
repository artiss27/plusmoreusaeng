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
                    {if $processor_updated eq 'y'}
							<div class="alert alert-success">
								<p><strong>Processor Updated:</strong> Your Payment Processor settings were saved succesfully on database.</p>
							</div>
							{/if}  
							{foreach $errors as $error}
							<div class="alert alert-danger">
								<p><strong>{$error@key}</strong> {$error}</p>
							</div>
							{/foreach} <br />
					<h2 class="font-light m-b-xs">
						Payment Processors Settings
					</h2>
					<div class="main pagesize">
						<!-- *** mainpage layout *** -->
						<div class="main-wrap">							
							<div class="content-box">
								<div class="box-body">
									{foreach key=obj item=name from=$processors}  
									<div class="modal fade" id="myModal{$name.processor_id}" tabindex="-1" role="dialog" aria-hidden="true">
										<form id="form1" name="form1" method="post" action="/admin/processors/">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="color-line"></div>
													<div class="modal-header text-center">
														<h4 class="modal-title">Update {$name.name}</h4>
													</div>
													<div class="modal-body">
														Account/Payee/Store ID : <input name="account_id" type="text" size="25" value="{$name.account_id}" class="form-control" />
														<br />                                                        
                                                        {foreach from=$name.extra_code|unserialize item=extra key=key} 
														{$key|replace:"_":" "|ucwords} : <input name="{$key}" type="text" size="20" value="{$extra}" class="form-control" />
														<br />
                                                        {/foreach}
                                                        Fee Flat : <input name="fee_flat" type="text" size="20" maxlength="35" value="{$name.fee_flat}" class="form-control" />
														<br />
                                                        Fee Percent : <input name="fee_percent" type="text" size="20" maxlength="35" value="{$name.fee_percent}" class="form-control" />
														<br />
														Active for Payment : <input type="checkbox" name="active" {if $name.active == 1}checked="checked"{/if} />
														<br />
														Active for Withdrawal : <input type="checkbox" name="active_withdrawal" {if $name.active_withdrawal == 1}checked="checked"{/if} />
														<br /><input name="processor_id" type="hidden" value="{$name.processor_id}" class="form-control" />
														<input type="hidden" class="button red fr" name="bnupdate" value="Update" />
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button>
													</div>
												</div>
											</div>
										</form>
									</div>
									{/foreach}  
									<div class="form-field clear"></div>
									<br />
									<table id="transaction" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Processor</th>
                                                <th>Account ID</th>
                                                <th>Fee Flat</th>
                                                <th>Fee Percent</th>
												<th>Active for payment</th>
												<th>Active for withdraw</th>												
												<th>Options</th>
											</tr>
										</thead>
										<tbody>
											{foreach key=obj item=name from=$processors}    
											<tr>
												<td>{$name.name}</td>
                                                <td>{$name.account_id}</td>
												<td>{$name.fee_flat}</td>
												<td>{$name.fee_percent}</td>                                                                                                
												<td>{$name.active}</td>
												<td>{$name.active_withdrawal}</td>												
												<td><button class="btn btn-info " type="button" data-toggle="modal" data-target="#myModal{$name.processor_id}"><i class="fa fa-paste"></i> Edit</button></td>
											</tr>
											{/foreach}
										</tbody>
									</table>
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
{include file='footer_scripts.tpl'}
{include file='footer.tpl'}