{include file='views/admin/header.tpl'}
{include file='views/admin/menu.tpl'}
<style>
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
</style>
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
            Manage Ranks
         </h2>
         <small>Manage Ranks</small>
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
                           <button class="btn btn-success" id="create">Create New Rank</button>
                           <div id="form" style="display: none">
                              <br />
                              <form action="" method="post" enctype="multipart/form-data" class="validate-form form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <div class="form-field clear"></div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Rank Name :</label>
                                          <input name="name" type="text" value="" size="5" class="form-control" />
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label>Rank Badge Image: </label> <label class="btn btn-primary btn-xs" for="my-file-selector"> 
                                          <input name="rank_image" id="my-file-selector" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
                                          Browse
                                          </label>
                                          <span class='label label-info' id="upload-file-info"></span>
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Required Paid Direct Referrals :</label>
                                          <input name="direct_required" type="text" value="" size="5" class="form-control" />
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Required Personal Volume :</label>
                                          <input name="pv_required" type="text" value="" size="5" class="form-control" />
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Required Group Volume :</label>
                                          <input name="gv_required" type="text" value="" size="5" class="form-control" />
                                       </div>
                                       <br />
                                    </div>
                                 </div>
                                 <div class="form-field clear">
                                    <br />
                                    <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
                                    <br />
                                    </p> 
                                 </div>
                                 <!-- /.form-field -->																								
                              </form>
                           </div>
                           <br /><br />
                           <table id="ranks" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th>Order Index</th>
                                    <th>Name</th>
                                    <th>Required Paid Direct Referrals</th>
                                    <th>Required Personal Volume</th>
                                    <th>Required Group Volume</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 {if !$ranks}
                                 <tr>
                                    <td colspan="7">No Results Found</td>
                                 </tr>
                                 {else}
                                 {foreach key=obj item=rank from=$ranks}  
                                 <tr>
                                    <td>
                                    {if $rank.order_index != 1}<a href="/plugins/ranks/admin/rankup/&id={$rank.id}"><i class="fa fa-arrow-up"></i></a>&nbsp;&nbsp;{/if}
									{if $highest_order != $rank.order_index}<a href="/plugins/ranks/admin/rankdown/&id={$rank.id}"><i class="fa fa-arrow-down"></i></a>{/if}
                                    </td>
                                    <td>{$rank.name}</td>
                                    <td>{$rank.direct_required}</td>
                                    <td>{$rank.pv_required}</td>
                                    <td>{$rank.gv_required}</td>
                                    <td><img width="30" src="/media/images/{$rank.image}" /></td>
                                    <td><a href="/plugins/ranks/admin/rankedit/&id={$rank.id}">edit</a> | 
                                       <a href="/plugins/ranks/admin/rankdelete/&id={$rank.id}" onclick="return confirm('Are you sure you want to delete this rank?');">delete</a>
                                    </td>
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
   });
</script>
{include file='views/admin/footer.tpl'}