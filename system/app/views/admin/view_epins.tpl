{include file='header.tpl'}
{include file='menu.tpl'}
<div id="wrapper">
{foreach $errors as $error}
<div class="alert alert-danger m-t">
   <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
   <p><strong>{$error@key}</strong> {$error}</p>
</div>
{/foreach}   
<div class="content animate-panel">
   <div class="row">
      <div class="col-lg-12">
         <div class="hpanel">
            <div class="panel-heading">
               <div class="panel-tools">
                  <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  <a class="closebox"><i class="fa fa-times"></i></a>
               </div>
               View ePins
            </div>
            <div class="panel-body">
               <div class="actions">
                  	<table id="epins" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                 	<th>ID</th>
                                    <th>Code</th>
                                    <th>Purchased By</th>
                                    <th>Membership</th>
                                    <th>Amount</th>
                                    <th>Used</th>
                                    <th>Used By</th>
                                    <th>Date Purchased</th>
                                    <th>Date Used</th>
                                 </tr>
                              </thead>
                              <tbody>
            					{if !$epins}
                                 <tr>
                                    <td colspan="9">No result found</td>
                                 </tr>
                                 {else}
                                 {foreach key=obj item=epin from=$epins}
                                 <tr>
                                 	<td>{$epin.id}</td>
                                    <td>{$epin.code}</td>
                                    <td>{$member->getUsernameById($epin.member_id)}</td>                                    
                                    <th>{$member->getMembershipById($epin.membership_id)}</th>
                                    <td>{$lang.monetary} {$epin.amount_paid}</td>
                                    <td>{if $epin.used_by_member_id > 0}yes{else}no{/if}</td>
                                    <th>{if $epin.used_by_member_id > 0}{$member->getUsernameById($epin.used_by_member_id)}{else}-{/if}</th>
                                    <td>{$epin.date_purchased|date_format}</td>
                                    <td>{if $epin.date_used > 0}{$epin.date_used|date_format}{else}-{/if}</td>
                                 </tr>
                                 {/foreach}
                                 {/if}
                              </tbody>
                           </table>
               </div>
               
            </div>
         </div>
      </div>
   </div>
</div>
{include file='footer_scripts.tpl'}
{include file='footer_datatable.tpl'}

<script>
   $(function () {
   {if $epins}$('#epins').dataTable({
  		 "order": [[ 0, "desc" ]]
   		});{/if}    
    
   });
   
</script>
{include file='footer.tpl'}