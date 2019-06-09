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
            Pending Approval TextAd Campaigns
         </h2>
         <small>Approve member submitted textad campaigns</small>
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
                           <form id="" role="form" action="massupdate" method="post">
                              <table id="textad_pending" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th><input type="checkbox" name="select_all" id="select_all" /></th>
                                       <th>ID</th>
                                       <th>TextAd</th>
                                       <th>Target Url</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    {if !$list}
                                    <tr>
                                       <td colspan="6">No Results Found</td>
                                    </tr>
                                    {else}
                                    {foreach key=obj item=textad from=$list}  
                                    <tr>
                                       <td><input id="id_{$smarty.foreach.textad.iteration}" type="checkbox" name="ids[]" value="{$textad.id}" /></td>
                                       <td>{$textad.id}</td>
                                       <td><a href="{$textad.target_url}" target="_blank">{$textad.headline}</a><br />{$textad.description1}<br />{$textad.description2}</td>
                                       <td><a href="{$textad.target_url}" target="_blank">{$textad.target_url}</a></td>
                                       <td><a href="/plugins/textads/admin/pendingaction/&approve={$textad.id}" onclick="return confirm('Are you sure you want to approve this textad campaign');">approve</a> | 
                                          <a href="/plugins/textads/admin/pendingaction/&disapprove={$textad.id}" onclick="return confirm('Are you sure you want to disapprove this textad campaign');">disapprove</a>
                                       </td>
                                    </tr>
                                    {/foreach}   	
                                    {/if}							
                                 </tbody>
                              </table>
                              <div class="form-actions">  
                                 <button type="submit" name="do" value="approve" class="btn btn-sm btn-primary m-t-n-xs">Approve Selected</button> 
                                 <button type="submit" name="do" value="dissaprove" class="btn btn-sm btn-primary m-t-n-xs" onclick="return confirm('Are you sure you want to dissaprove selected campaigns ?');">Dissaprove Selected</button>											
                              </div>
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
   	{if $list}$('#textad_pending').dataTable();{/if}  
   });
   $('#select_all').change(function() {
    var checkboxes = $(this).closest('form').find(':checkbox');
    if($(this).is(':checked')) {
        checkboxes.prop('checked', true);
    } else {
        checkboxes.prop('checked', false);
    }
});
</script>
{include file='views/admin/footer.tpl'}
