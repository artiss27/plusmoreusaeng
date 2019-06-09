{include file='views/admin/header.tpl'}
{include file='views/admin/menu.tpl'}
<!-- Main Wrapper -->
<div id="wrapper">
<div class="normalheader transition animated fadeIn">
   <div class="hpanel">
      <div class="panel-body">
         <a class="small-header-action" href="">
            <div class="clip-header">
               <i class="fa fa-arrow-up"></i>
            </div>
         </a>
         <h2 class="font-light m-b-xs">
            Admin Users
         </h2>
         <small>Admin Users</small>
      </div>
   </div>
</div>
<div class="row">
   <div class="normalheader transition animated fadeIn">
      <div class="hpanel">
         <div class="panel-body">
            <a class="small-header-action" href="">
               <div class="clip-header">
                  <i class="fa fa-arrow-up"></i>
               </div>
            </a>
            {if $smarty.session.message}
            <p class="alert alert-success">
               {assign var=message_var value=CoreHelp::flash('message')}
               {$message_var}
            </p>
            <br />
            {/if} 
            {if $smarty.session.error}
            {assign var=message_var value=CoreHelp::flash('error')}            	
            {if $message_var|is_array}
            {foreach $message_var as $error}
            <p class="alert alert-danger">
               {$error}
            </p>
            <br />
            {/foreach} 
            {else}
            <p class="alert alert-danger">
               {$message_var}
            </p>
            <br />
            {/if}
            {/if}  
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <button id="create">Add new Admin User</button>
                           <div id="form" style="display: none">
                              <br />
                              <form id="admin_form" action="" method="post" class="form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <h2>Add new Admin User</h2>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Username:</label>
                                          <input name="username" type="text" id="textfield" placeholder="username" size="5" class="form-control validate[required]"  />
                                       </div>
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Email:</label>
                                          <input name="email" type="text" id="textfield" placeholder="email" size="5" class="form-control validate[required,custom[email]]"  />
                                       </div>
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Password:</label>
                                          <input name="password" type="text" id="textfield" placeholder="password" size="5" class="form-control validate[required]"  />
                                       </div>
                                       <br /><br />
                                       <h3>Allowed Areas On Admin Panel</h3>
                                       <br />
                                       {foreach key=obj item=name from=$smarty.session.available_roles}
                                       <div class="form-field clear">
                                          <label for="textfield" class="fl-space size-300">{$name} :</label> 
                                          <input name="roles[]" type="checkbox" class="form-control" value="{$obj}" />
                                       </div>
                                       {/foreach}
                                       <div class="form-field clear"></div>
                                    </div>
                                 </div>
                                 <br>
                                 <div class="form-field clear">
                                    <input type="hidden" class="button red fr" name="bnsubmit" value="Save" />
                                    <button type="submit" class="btn btn-primary">Create Admin User</button> 
                                 </div>
                                 <!-- /.form-field -->																								
                              </form>                             
                              
                           </div>
                           <br /><br /> 
                           <h3>Admin Users</h3>
                              <table id="adminusers" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th>ID</th>
                                       <th>Username</th>
                                       <th>Email</th>
                                       <th>Roles</th>
                                       <th>Last Ip</th>
                                       <th>Last Login</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    {if !$adminusers}
                                    <tr>
                                       <td colspan="6">No Results Found</td>
                                    </tr>
                                    {else}
                                    {foreach key=obj item=row from=$adminusers}  
                                    <tr>
                                       <td>{$row.id}</td>
                                       <td>{$row.username}</td>
                                       <td>{if $row.id == 1}-{else}{$row.email}{/if}</td>
                                       <td>{if $row.id == 1}Super Admin{else}{$adminmodel->getRoles($row.username)}{/if}</td>
                                       <td>{$adminmodel->getLastIp($row.username)}</td>
                                       <td>{$adminmodel->getLastDate($row.username)}</td>
                                       <td>{if $row.id != 1}<a href="/plugins/adminusers/admin/edituser/&id={$row.id}">edit</a>{else}-{/if}</td>
                                    </tr>
                                    {/foreach}   	
                                    {/if}							
                                 </tbody>
                              </table>
                              
                              <br /><br />
                              <h3>Log</h3>
                              <table id="log" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th>ID</th>
                                       <th>Username</th>
                                       <th>IP</th>
                                       <th>Description</th>
                                       <th>Date</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    {if !$log}
                                    <tr>
                                       <td colspan="5">No Results Found</td>
                                    </tr>
                                    {else}
                                    {foreach key=obj item=row from=$log}  
                                    <tr>
                                       <td>{$row.id}</td>
                                       <td>{$row.admin_username}</td>
                                       <td>{$row.ip_address}</td>
                                       <td>{$row.description}</td>
                                       <td>{$row.date}</td>
                                    </tr>
                                    {/foreach}   	
                                    {/if}							
                                 </tbody>
                              </table>
                        </div>
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
<!-- END -->       
<!-- Vendor scrits -->
{include file='views/admin/footer_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
   		$("#create").click(function() {
   			$("#form").toggle();
   		});
		$("#admin_form").validationEngine();
		{if $log}$('#log').dataTable({
        	"order": [[ 1, "desc" ]]
    	});{/if}  
   });
</script>
{include file='views/admin/footer.tpl'}