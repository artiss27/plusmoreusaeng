<?php /* Smarty version Smarty-3.0.8, created on 2019-06-07 10:33:37
         compiled from "system/app/views/admin/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8523327115cfa9ff1ccbe09-44626184%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '53daa36de591dd8903d325f6ff0d7af6a24f5b70' => 
    array (
      0 => 'system/app/views/admin/index.tpl',
      1 => 1518404184,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8523327115cfa9ff1ccbe09-44626184',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/hermes/walnaweb10a/b1543/pow.plusmoreusaengcom/htdocs/system/libs/smarty/plugins/modifier.date_format.php';
if (!is_callable('smarty_modifier_replace')) include '/hermes/walnaweb10a/b1543/pow.plusmoreusaengcom/htdocs/system/libs/smarty/plugins/modifier.replace.php';
?>﻿<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<!-- Main Wrapper -->
<div id="wrapper">
	<div class="content animate-panel">
		<div class="row">
        	 <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
                     <div class="alert alert-success">
                        <p><strong><?php echo $_smarty_tpl->tpl_vars['error']->key;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
                     </div>
                     <?php }} ?> 
                     <?php if ($_SESSION['message']){?>
                    <p class="alert alert-success">
                       <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('message'), null, null);?>
                       <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

                    </p>
                    <br /><br />
                    <?php }?> 
                    <?php if ($_SESSION['error']){?>
                    <p class="alert alert-danger">
                       <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('error'), null, null);?>
                       <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

                    </p>
                    <br /><br />
                    <?php }?>                     
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
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['visits_total'],0);?>

									</h1>
									<small>Total Visitors</small>
								</div>
							</div>
							<div class="col-md-3 text-center">
								
								<div>
									<h1 class="font-extra-bold m-b-xs">
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['visits_yesterday'],0);?>

									</h1>
									<small>Visitors Yesterday</small>
								</div>

							</div>
                            <div class="col-md-3 text-center">
								
								<div>
									<h1 class="font-extra-bold m-b-xs">
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['visits_this_month'],0);?>

									</h1>
									<small>Visitors This Month</small>
								</div>

							</div>
                            
                            
							<div class="col-md-3 text-center">								
								<div>
									<h1 class="font-extra-bold m-b-xs">
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['visits_last_month'],0);?>

									</h1>
									<small>Visitors Last Month</small>
								</div>

							</div>
						</div>
                        
                        
                        
                        <div class="row" style="background-color: #f9f9f9;border: 1px solid #ddd;margin-bottom:10px;">
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold" >
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['registered_total'],0);?>

									</h1>
									<small>Registered Members</small>
								</div>
							</div>
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['registered_yesterday'],0);?>

									</h1>
									<small>Registered Members Yesterday</small>
								</div>
							</div>
                            <div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['registered_this_month'],0);?>

									</h1>
									<small>Registered Members This Month</small>
								</div>
							</div>                            
                 
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['registered_last_month'],0);?>

									</h1>
									<small>Registered Members Last Month</small>
								</div>
							</div>
						</div>                        
                    
                        
                        <div class="row" style="border: 1px solid #ddd;margin-bottom:10px;">
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['total_paid_members'],0);?>

									</h1>
									<small>Paid Members</small>
								</div>
							</div>
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['paid_members_yesterday'],0);?>

									</h1>
									<small>Paid Members Yesterday</small>
								</div>

							</div>
                            <div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['paid_members_this_month'],0);?>

									</h1>
									<small>Paid Members This Month</small>
								</div>
							</div>               
							<div class="col-md-3 text-center">
								<div>
									<h1 class="font-extra-bold m-b-xs">
										<?php echo number_format($_smarty_tpl->getVariable('data')->value['paid_members_last_month'],0);?>

									</h1>
									<small>Paid Members Last Month</small>
								</div>

							</div>
						</div>
                        
					</div>
					<div class="panel-footer">
						<span class="pull-right">
						
						</span>
						Last update: <?php echo smarty_modifier_date_format(time());?>

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
										<td> <span class="badge badge-danger"><?php echo number_format($_smarty_tpl->getVariable('data')->value['visits_today'],0);?>
</span></td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Registered Members Today</span>
										</td>
										<td><span class="badge badge-primary"><?php echo $_smarty_tpl->getVariable('data')->value['new_members_today'];?>
</span></td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Paid Members Today</span>
										</td>
										<td><span class="badge badge-info"><?php echo $_smarty_tpl->getVariable('data')->value['paid_members_today'];?>
</span></td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Total Members</span>
										</td>
										<td><span class="badge badge-success"><?php echo $_smarty_tpl->getVariable('data')->value['total_members'];?>
</span></td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Total Paid Members</span>
										</td>
										<td><span class="badge badge-warning"><?php echo $_smarty_tpl->getVariable('data')->value['total_paid_members'];?>
</span></td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Active Recruiters</span>
										</td>
										<td><span class="badge badge-violet"><?php echo $_smarty_tpl->getVariable('data')->value['total_sponsors'];?>
</span></td>
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
										<td>$<?php echo $_smarty_tpl->getVariable('data')->value['total_money_processed'];?>
</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Completed Withdrawals</span>
										</td>
										<td>$<?php echo $_smarty_tpl->getVariable('data')->value['total_commisions_paid'];?>
</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Pending Withdrawals</span>
										</td>
										<td>$<?php echo $_smarty_tpl->getVariable('data')->value['pending_withdrawals'];?>
</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Payout Wallet Balance</span>
										</td>
										<td>$<?php echo $_smarty_tpl->getVariable('data')->value['pending_commisions'];?>
</td>
									</tr>
                                    <tr>
										<td>
											<span class="text-info font-bold">Deposit Transactions</span>
										</td>
										<td><?php echo $_smarty_tpl->getVariable('data')->value['deposit_completed'];?>
</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Withdrawal Transactions</span>
										</td>
										<td><?php echo $_smarty_tpl->getVariable('data')->value['withdrawals_completed'];?>
</td>
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
										<td>$<?php echo $_smarty_tpl->getVariable('data')->value['money_deposited_today'];?>
</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money Yesterday</span>
										</td>
										<td>$<?php echo $_smarty_tpl->getVariable('data')->value['money_deposited_yesterday'];?>
</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money this Week</span>
										</td>
										<td>$<?php echo $_smarty_tpl->getVariable('data')->value['money_deposited_this_week'];?>
</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money past Week</span>
										</td>
										<td>$<?php echo $_smarty_tpl->getVariable('data')->value['money_deposited_last_week'];?>
</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money this Month </span>
										</td>
										<td>$<?php echo $_smarty_tpl->getVariable('data')->value['money_deposited_this_month'];?>
</td>
									</tr>
									<tr>
										<td>
											<span class="text-info font-bold">Deposited Money past Month </span>
										</td>
										<td>$<?php echo $_smarty_tpl->getVariable('data')->value['money_deposited_last_month'];?>
</td>
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
									<?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('memberships')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
									<?php ob_start(); ?><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
_count<?php  $_smarty_tpl->assign('comm', ob_get_contents()); Smarty::$_smarty_vars['capture']['default']=ob_get_clean();?>                             
									<tr>
										<th><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['name']->value,"_"," ");?>
</th>
										<td class="value right"><?php echo $_smarty_tpl->getVariable('mem')->value[$_smarty_tpl->getVariable('comm')->value];?>
</td>
										<td>&nbsp;</td>
									</tr>
									<?php }} ?> 
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
										<th><?php echo $_smarty_tpl->getVariable('data')->value['today'];?>
</th>
										<td ><a href="/admin/messages/" <?php if ($_smarty_tpl->getVariable('total_messages')->value>0){?>class="blink"<?php }?>>(<?php echo intval($_smarty_tpl->getVariable('total_messages')->value);?>
) Private Messages</a></td>
										<td><a href="/admin/messages/">Go</a></td>
									</tr>
									<tr>
										<th><?php echo $_smarty_tpl->getVariable('data')->value['today'];?>
</th>
										<td><a href="/admin/withdrawals/" <?php if ($_smarty_tpl->getVariable('data')->value['totalw']>0){?>class="blink"<?php }?>>(<?php echo $_smarty_tpl->getVariable('data')->value['totalw'];?>
) Pending Withdrawals</a></td>
										<td><a href="/admin/withdrawals/">Go</a></td>
									</tr>
                                    <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('admin_task');?>
									
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
									<?php  $_smarty_tpl->tpl_vars['namex'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('topsponsor')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['namex']->key => $_smarty_tpl->tpl_vars['namex']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['namex']->key;
?>                          
									<tr>
										<td>
											<?php $_smarty_tpl->assign('name' , insert_GetMember (array('id' => $_smarty_tpl->tpl_vars['namex']->value['sponsor_id']),$_smarty_tpl), true);?>
											<span class="font-bold"><span class="badge badge-success"><?php echo $_smarty_tpl->tpl_vars['namex']->value['b'];?>
</span> &nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('name')->value['username'];?>
</span>
											<div class="pull-right">
												<table>
													<tr>
														<td style="padding: 4px;">                   
															<a href="/admin/viewnetwork/&id=<?php echo $_smarty_tpl->getVariable('name')->value['member_id'];?>
"><i class="pe-7s-network" title="View network"></i></a>
														</td>
														<td style="padding: 4px;">
															<a href="/admin/editmember/&id=<?php echo $_smarty_tpl->getVariable('name')->value['member_id'];?>
"><i class="fa fa-edit" title="Edit"></i></a>
														</td>
														<td style="padding: 4px;"> 
															<a href="/admin/transactions/&member_id=<?php echo $_smarty_tpl->getVariable('name')->value['member_id'];?>
"><i class="fa fa-money" title="View transactions"></i></a>
														</td>
														<td style="padding: 4px;">
															<a href="/admin/loginmember/&id=<?php echo $_smarty_tpl->getVariable('name')->value['member_id'];?>
" target="_blank"><i class="fa fa-unlock-alt" title="Login to member panel"></i></a>  
														</td>
													</tr>
												</table>
											</div>
											<p class="info"><small>registered: <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('name')->value['reg_date'],"%B %e, %Y");?>
</small></p>
										</td>
									</tr>
									<?php }} ?>	
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
									<?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('lastmembers')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>                            
									<tr>
										<td>
											<span class="font-bold"><?php echo $_smarty_tpl->tpl_vars['name']->value['username'];?>
 (<?php echo $_smarty_tpl->tpl_vars['name']->value['email'];?>
)</span>
											<div class="pull-right">
												<table>
													<tbody>
														<tr>
															<td style="padding: 4px;">   <a href="/admin/editmember/&id=<?php echo $_smarty_tpl->tpl_vars['name']->value['member_id'];?>
"><i class="fa fa-edit" title="Edit"></i></a></td>
															<td style="padding: 4px;">
																<a href="/admin/loginmember/&id=<?php echo $_smarty_tpl->tpl_vars['name']->value['member_id'];?>
" target="_blank"><i class="fa fa-unlock-alt" title="Login to member panel"></i></a>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<p class="info"><b><?php echo $_smarty_tpl->tpl_vars['name']->value['membership'];?>
</b> <small>date: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['name']->value['reg_date'],"%B %e, %Y %H:%M:%S");?>
</small></p>
										</td>
									</tr>
									<?php }} ?>	
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
									<?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('lastregister')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>                            
									<tr>
										<td>
											<span class="font-bold"><?php echo $_smarty_tpl->tpl_vars['name']->value['username'];?>
 (<?php echo $_smarty_tpl->tpl_vars['name']->value['email'];?>
)</span>
											<div class="pull-right">
												<table>
													<tbody>
														<tr>
															<td style="padding: 4px;">   <a href="/admin/editmember/&id=<?php echo $_smarty_tpl->tpl_vars['name']->value['member_id'];?>
"><i class="fa fa-edit" title="Edit"></i></a></td>
															<td style="padding: 4px;">
																<a href="/admin/loginmember/&id=<?php echo $_smarty_tpl->tpl_vars['name']->value['member_id'];?>
" target="_blank"><i class="fa fa-unlock-alt" title="Login to member panel"></i></a>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<p class="info"><b><?php if ($_smarty_tpl->tpl_vars['name']->value['membership']==0){?>Free<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['name']->value['membership'];?>
<?php }?></b> <small>date: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['name']->value['reg_date'],"%B %e, %Y %H:%M:%S");?>
</small></p>
										</td>
									</tr>
									<?php }} ?>	
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
                                <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('last_admin_logs')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
									<tr>
										<td><?php echo $_smarty_tpl->tpl_vars['name']->value['admin_username'];?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['name']->value['ip_address'];?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['name']->value['date'];?>
</td>
                                        <td><?php $_smarty_tpl->assign('flag' , insert_getFlag (array('country' => $_smarty_tpl->tpl_vars['name']->value['country']),$_smarty_tpl), true);?><img src="<?php echo $_smarty_tpl->getVariable('flag')->value['flag'];?>
" title="<?php echo $_smarty_tpl->getVariable('flag')->value['country_name'];?>
" /> <?php echo $_smarty_tpl->getVariable('flag')->value['country_name'];?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['name']->value['description'];?>
</td>									
									</tr>
                                <?php }} ?>     
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>


<?php $_template = new Smarty_Internal_Template('footer_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('footer_dashboard.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>