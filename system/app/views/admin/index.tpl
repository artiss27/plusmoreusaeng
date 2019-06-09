{include file='header.tpl'}
{include file='menu.tpl'}
<!-- Main Wrapper -->
<div id="wrapper">
	<div class="content animate-panel">
		<div class="row">
        	 {foreach $errors as $error}
                     <div class="alert alert-success">
                        <p><strong>{$error@key}</strong> {$error}</p>
                     </div>
                     {/foreach} 
                     {if $smarty.session.message}
                    <p class="alert alert-success">
                       {assign var=message_var value=CoreHelp::flash('message')}
                       {$message_var}
                    </p>
                    <br /><br />
                    {/if} 
                    {if $smarty.session.error}
                    <p class="alert alert-danger">
                       {assign var=message_var value=CoreHelp::flash('error')}
                       {$message_var}
                    </p>
                    <br /><br />
                    {/if}                     
			<div class="col-lg-12 text-center m-t-md">
				<img src="/media/images/PMUhighlighted.png" alt="PlusMoreUsa" style="width:150px;height:125px;"><h2>
					Welcome Back Admin
				</h2>
				<p>
					<strong>Let's Take Care Of All - One Member At A Time!!!</strong><br><small>So, Let's Get Busy Helping.</small>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="hpanel">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						PlusMoreUsa Information and Statistics
					</div>
					<div class="panel-body">
						<div class="row" style="border: 1px solid #ddd;margin-bottom:10px;">
							<div class="col-md-3 text-center">
								
								<div>
									<h1 class="font-extra-bold m-b-xs">
										{$data.visits_total|number_format:0}
									</h1>
									<small>Total Visitors</small>
								</div>
							</div>
							<div class="col-md-3 text-center">
								
								<div>
									<h1 class="font-extra-bold m-b-xs">
										{$data.visits_yesterday|number_format:0}
									</h1>
									<small>Visitors Yesterday</small>
								</div>

							</div>
                            <div class="col-md-3 text-center">
								
								<div>
									<h1 class="font-extra-bold m-b-xs">
										{$data.visits_this_month|number_format:0}
									</h1>
									<small>Visitors This Month</small>
								</div>

							</div>
                            
                            
							<div class="col-md-3 text-center">								
								<div>
									<h1 class="font-extra-bold m-b-xs">
										{$data.visits_last_month|number_format:0}
									</h1>
									<small>Visitors Last Month</small>
								</div>

							</div>
						</div>
                        
                        
                        
                        <div class="row" style="background-color: #f9f9f9;border: 1px solid #ddd;margin-bottom:10px;">
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold" >
										{$data.registered_total|number_format:0}
									</h1>
									<small>Registered Members</small>
								</div>
							</div>
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										{$data.registered_yesterday|number_format:0}
									</h1>
									<small>Registered Members Yesterday</small>
								</div>
							</div>
                            <div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										{$data.registered_this_month|number_format:0}
									</h1>
									<small>Registered Members This Month</small>
								</div>
							</div>                            
                 
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										{$data.registered_last_month|number_format:0}
									</h1>
									<small>Registered Members Last Month</small>
								</div>
							</div>
						</div>                        
                    
                        
                        <div class="row" style="border: 1px solid #ddd;margin-bottom:10px;">
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										{$data.total_paid_members|number_format:0}
									</h1>
									<small>Paid Members</small>
								</div>
							</div>
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										{$data.paid_members_yesterday|number_format:0}
									</h1>
									<small>Paid Members Yesterday</small>
								</div>

							</div>
                            <div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										{$data.paid_members_this_month|number_format:0}
									</h1>
									<small>Paid Members This Month</small>
								</div>
							</div>               
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										{$data.paid_members_last_month|number_format:0}
									</h1>
									<small>Paid Members Last Month</small>
								</div>

							</div>
						</div>
                        
					</div>
					<div class="panel-footer">
						<span class="pull-right">
						
						</span>
						Last update: {$smarty.now|date_format}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="hpanel hgreen">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Members
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									<tr>
										<td>
											<span class="text-info font-bold">Visitors Today</span>
										</td>
										<td> <span class="badge badge-danger">{$data.visits_today|number_format:0}</span></td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Registered Members Today</span>
										</td>
										<td><span class="badge badge-primary">{$data.new_members_today}</span></td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Paid Members Today</span>
										</td>
										<td><span class="badge badge-info">{$data.paid_members_today}</span></td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Total Members</span>
										</td>
										<td><span class="badge badge-success">{$data.total_members}</span></td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Total Paid Members</span>
										</td>
										<td><span class="badge badge-warning">{$data.total_paid_members}</span></td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Active Recruiters</span>
										</td>
										<td><span class="badge badge-violet">{$data.total_sponsors}</span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="hpanel hviolet">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Transactions (Total)
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money</span>
										</td>
										<td>${$data.total_money_processed}</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Completed Withdrawals</span>
										</td>
										<td>${$data.total_commisions_paid}</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Pending Withdrawals</span>
										</td>
										<td>${$data.pending_withdrawals}</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Payout Wallet Balance</span>
										</td>
										<td>${$data.pending_commisions}</td>
									</tr>
                                    <tr>
										<td>
											<span class="text-info font-bold">Deposit Transactions</span>
										</td>
										<td>{$data.deposit_completed}</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Withdrawal Transactions</span>
										</td>
										<td>{$data.withdrawals_completed}</td>
									</tr>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="hpanel hred">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Deposit Stats
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money Today</span>
										</td>
										<td>${$data.money_deposited_today}</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money Yesterday</span>
										</td>
										<td>${$data.money_deposited_yesterday}</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money this Week</span>
										</td>
										<td>${$data.money_deposited_this_week}</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money past Week</span>
										</td>
										<td>${$data.money_deposited_last_week}</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money this Month </span>
										</td>
										<td>${$data.money_deposited_this_month}</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money past Month </span>
										</td>
										<td>${$data.money_deposited_last_month}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="hpanel hblue">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Memberships
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									{foreach key=obj item=name from=$memberships}
									{capture assign=comm}{$name}_count{/capture}                             
									<tr>
										<th>{$name|replace:"_":" "}</th>
										<td class="value right">{$mem.$comm}</td>
										<td>&nbsp;</td>
									</tr>
									{/foreach} 
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3">
				<div class="hpanel hyellow">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Admin Tasks
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									<tr>
										<th>{$data.today}</th>
										<td ><a href="/admin/messages/" {if $total_messages>0}class="blink"{/if}>({$total_messages|intval}) Private Messages</a></td>
										<td><a href="/admin/messages/">Go</a></td>
									</tr>
									<tr>
										<th>{$data.today}</th>
										<td><a href="/admin/withdrawals/" {if $data.totalw>0}class="blink"{/if}>({$data.totalw}) Pending Withdrawals</a></td>
										<td><a href="/admin/withdrawals/">Go</a></td>
									</tr>
                                    {$hooks->do_action('admin_task')}									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			
            <div class="col-lg-3">
				<div class="hpanel hgreen">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Top 5 Recruiters
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									{foreach key=obj item=namex from=$topsponsor}                          
									<tr>
										<td>
											{insert name=GetMember assign=name id=$namex.sponsor_id}
											<span class="font-bold"><span class="badge badge-success">{$namex.b}</span> &nbsp;&nbsp;{$name.username}</span>
											<div class="pull-right">
												<table>
													<tr>
														<td style="padding: 4px;">                   
															<a href="/admin/viewnetwork/&id={$name.member_id}"><i class="pe-7s-network" title="View network"></i></a>
														</td>
														<td style="padding: 4px;">
															<a href="/admin/editmember/&id={$name.member_id}"><i class="fa fa-edit" title="Edit"></i></a>
														</td>
														<td style="padding: 4px;"> 
															<a href="/admin/transactions/&member_id={$name.member_id}"><i class="fa fa-money" title="View transactions"></i></a>
														</td>
														<td style="padding: 4px;">
															<a href="/admin/loginmember/&id={$name.member_id}" target="_blank"><i class="fa fa-unlock-alt" title="Login to member panel"></i></a>  
														</td>
													</tr>
												</table>
											</div>
											<p class="info"><small>registered: {$name.reg_date|date_format:"%B %e, %Y"}</small></p>
										</td>
									</tr>
									{/foreach}	
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
            
            <div class="col-lg-3">
				<div class="hpanel hred">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Last 5 Paid Members
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									{foreach key=obj item=name from=$lastmembers}                            
									<tr>
										<td>
											<span class="font-bold">{$name.username} ({$name.email})</span>
											<div class="pull-right">
												<table>
													<tbody>
														<tr>
															<td style="padding: 4px;">   <a href="/admin/editmember/&id={$name.member_id}"><i class="fa fa-edit" title="Edit"></i></a></td>
															<td style="padding: 4px;">
																<a href="/admin/loginmember/&id={$name.member_id}" target="_blank"><i class="fa fa-unlock-alt" title="Login to member panel"></i></a>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<p class="info"><b>{$name.membership}</b> <small>date: {$name.reg_date|date_format:"%B %e, %Y %H:%M:%S"}</small></p>
										</td>
									</tr>
									{/foreach}	
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
            
            <div class="col-lg-3">
				<div class="hpanel hyellow">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Last 5 Registered Members
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									{foreach key=obj item=name from=$lastregister}                            
									<tr>
										<td>
											<span class="font-bold">{$name.username} ({$name.email})</span>
											<div class="pull-right">
												<table>
													<tbody>
														<tr>
															<td style="padding: 4px;">   <a href="/admin/editmember/&id={$name.member_id}"><i class="fa fa-edit" title="Edit"></i></a></td>
															<td style="padding: 4px;">
																<a href="/admin/loginmember/&id={$name.member_id}" target="_blank"><i class="fa fa-unlock-alt" title="Login to member panel"></i></a>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<p class="info"><b>{if $name.membership == 0}Free{else}{$name.membership}{/if}</b> <small>date: {$name.reg_date|date_format:"%B %e, %Y %H:%M:%S"}</small></p>
										</td>
									</tr>
									{/foreach}	
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<div class="row">
        
        <div class="col-lg-6">
				<div class="hpanel">
					<div class="panel-heading">
						<div class="panel-tools">
							<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							<a class="closebox"><i class="fa fa-times"></i></a>
						</div>
						Admin Login History
					</div>
					<div class="panel-body list">
						<div class="table-responsive project-list">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Admin Username</th>
										<th>Ip Address</th>
										<th>Date</th>
                                        <th>Country</th>
										<th>Description</th>
									</tr>
								</thead>
								<tbody>
                                {foreach key=obj item=name from=$last_admin_logs}
									<tr>
										<td>{$name.admin_username}</td>
										<td>{$name.ip_address}</td>
										<td>{$name.date}</td>
                                        <td>{insert name=getFlag assign=flag country=$name.country}<img src="{$flag.flag}" title="{$flag.country_name}" /> {$flag.country_name}</td>
										<td>{$name.description}</td>									
									</tr>
                                {/foreach}     
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>


{include file='footer_scripts.tpl'}
{include file='footer_dashboard.tpl'}
{include file='footer.tpl'}