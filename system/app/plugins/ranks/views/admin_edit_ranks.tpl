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
            Edit Rank
         </h2>
         <small>Edit Rank</small>
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
                              <form action="" method="post" enctype="multipart/form-data" class="validate-form form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <div class="form-field clear"></div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Rank Name :</label>
                                          <input name="name" type="text" value="{$rank.name}" size="5" class="form-control" />
                                       </div>
                                       <br />
                                       <div class="clear">
                                       	 <img width="30" src="/media/images/{$rank.image}" />
                                          <label>Rank Badge Image: </label> <label class="btn btn-primary btn-xs" for="my-file-selector"> 
                                          <input name="rank_image" id="my-file-selector" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
                                          Browse
                                          </label>
                                          <span class='label label-info' id="upload-file-info"></span>
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Required Paid Direct Referrals :</label>
                                          <input name="direct_required" type="text" value="{$rank.direct_required}" size="5" class="form-control" />
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Required Personal Volume :</label>
                                          <input name="pv_required" type="text" value="{$rank.pv_required}" size="5" class="form-control" />
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield" class="fl-space size-300">Required Group Volume :</label>
                                          <input name="gv_required" type="text" value="{$rank.gv_required}" size="5" class="form-control" />
                                       </div>
                                       <br />
                                    </div>
                                 </div>
                                 <div class="form-field clear">
                                    <br />
                                    <input type="hidden" name="id" value="{$rank.id}" />
                                    <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
                                    <br />
                                    </p> 
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
	   
   });
</script>
{include file='views/admin/footer.tpl'}