﻿{include file='views/admin/header.tpl'}
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
           Verified Members
         </h2>
         <small>Verified Members</small>
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
                        <h3>Verified Members</h3>
                              <table id="log" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th>ID</th>
                                       <th>Username</th>
                                       <th>Personal Document</th>
                                       <th>Proof Of Address</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    {if !$verified}
                                    <tr>
                                       <td colspan="5">No Results Found</td>
                                    </tr>
                                    {else}
                                    {foreach key=obj item=row from=$verified}  
                                    <tr>
                                       <td></td>
                                       <td>{$row.id}</td>
                                       <td><a href="/admin/editmember/&id={$row.member_id}" target="_blank">{$row.username}</td>
                                       <td><a href="/media/files/{$row.document}" target="_blank">Open</a></td>
                                       <td><a href="/media/files/{$row.address_proof}" target="_blank">Open</a></td>
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
   	{if $verified}$('#log').dataTable();{/if}  
   }); 
});
</script>
{include file='views/admin/footer.tpl'}
