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
           Edit admin user
         </h2>
         <small>Edit admin user</small>
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
                       		<form id="admin_form" action="" method="post" class="form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <h2>Edit Admin User</h2>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Username:</label>
                                          <input name="username" type="text" id="textfield" value="{$user.username}" size="5" class="form-control validate[required]"  />
                                       </div>
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Email:</label>
                                          <input name="email" type="text" id="textfield" value="{$user.email}" size="5" class="form-control validate[required,custom[email]]"  />
                                       </div>
                                       <div class="clear">
                                          <label for="textfield" class="form-label size-120 fl-space2">Password:</label>
                                          <input name="password" type="text" id="textfield" placeholder="change password" size="5" class="form-control"  />
                                       </div>
                                       <br /><br />
                                       <h3>Allowed Areas On Admin Panel</h3>
                                       <br />
                                       {foreach key=obj item=name from=$smarty.session.available_roles}
                                       <div class="form-field clear">
                                          <label for="textfield" class="fl-space size-300">{$name} :</label> 
                                          <input name="roles[]" type="checkbox" class="form-control" value="{$obj}" {if $user.roles.$obj == 1}checked{/if} />
                                       </div>
                                       {/foreach}
                                       <div class="form-field clear"></div>
                                    </div>
                                 </div>
                                 <br>
                                 <div class="form-field clear">
                                    <input type="hidden" name="id" value="{$smarty.request.id}" />                                    
                                    <button type="submit" class="btn btn-primary">Edit Admin User</button> 
                                 </div>
                                 <!-- /.form-field -->																								
                              </form>  
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
   	{if $log}$('#log').dataTable();{/if}  
   }); 
});
</script>
{include file='views/admin/footer.tpl'}
