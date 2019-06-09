{include file='header.tpl'}

<div class="breadcrumb">
	<div class="bread-links pagesize">
		<ul class="clear">
		<li class="first">You are here:</li>
		<li><a href="#">Plugin List</a></li>
		</ul>
	</div>
</div>

 <div class="main pagesize"> <!-- *** mainpage layout *** -->
	<div class="main-wrap">
		<div class="page clear">
			
			<div class="content-box">
			<div class="box-body">
				<div class="box-header clear">
										
					<h2>Plugins Installed</h2>
				</div>
				
				<div class="box-wrap clear">
					
					<!-- TABLE -->
					<div id="data-table">
						<p>Here you can activate, deactivate or delete an installed plugin. Mysql Tables related to any plugin are keeped always in case you deleted the plugin by mistake.</p> 
					
						<form method="post" action="#">
						
						<table class="style1 datatable">
						<thead>
							<tr>
								<th class="bSortable"><input type="checkbox" class="checkbox select-all" /></th>
								<th>Plugin Name</th>
								<th>Author</th>
								<th>Date Installed</th>
								<th>Plugin Version</th>
								<th>Action</th>
                                <th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Paypal Payment Processor Plugin</td>
								<td><a href="#">John</a></td>
								<td>5/6/2011</td>
								<td>1.0.0.1</td>
								<td><a href="#">Activate</a> | <a href="#">Delete</a></td>
                                <td>&nbsp;</td>
							</tr>
                                                        
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td>Messages System</td>
								<td><a href="#">Admin</a></td>
								<td>5/6/2011</td>
								<td>2.1</td>
								<td><a href="#">Activate</a> | <a href="#">Delete</a></td>
                                <td>&nbsp;</td>
							</tr>
						</tbody>
						</table>
						
						<div class="tab-footer clear fl">
							<div class="fl">
								<select name="dropdown" class="fl-space">
									<option value="option1">choose action...</option>
									<option value="option2">Activate</option>
                                    <option value="option4">Deactivate</option>
									<option value="option3">Delete</option>
								</select>
								<input type="submit" value="Apply" id="submit1" class="button fl-space" />
						  </div>
						</div>
					  </form>
					</div><!-- /#table -->
					

					
				</div><!-- end of box-wrap -->
			</div> <!-- end of box-body -->
			</div>
		</div><!-- end of page -->
	</div>
</div>         

 <p>{include file='footer.tpl'} </p>
