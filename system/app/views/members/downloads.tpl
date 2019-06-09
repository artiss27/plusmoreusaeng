{include file='header.tpl'}
{include file='menu.tpl'}
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
         {include file='breadcrumb.tpl'}            
         <h2 class="font-light m-b-xs">
            Download Information
         </h2>
         <small>Click on The Filename to Download the Visual Content.</small>
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
            <p class="alert alert-danger">
               {assign var=message_var value=CoreHelp::flash('error')}
               {$message_var}
            </p>
            <br />
            {/if} 
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <form method="post" action="">
                              {$lang.category}: 
                              <select name='category' onChange='this.form.submit();' class="form-control form-half">
                                 <option value="all">{$lang.all}</option>
                                 {foreach key=objx item=name from=$category}
                                 	{if $name.category ne ""}
                                 		<option value="{$name.category}" {if $name.category eq $smarty.request.category}selected="selected"{/if}>{$name.category}</option>
                                 	{/if}
                                 {/foreach}   
                              </select>
                              <br />
                              <br />
                           </form>
                           <table id="downloads" class="table table-striped table-bordered table-hover">
                           	  <thead>
                              	<tr>
                              		<td>{$lang.filename}</td>
                                    <td>{$lang.category}</td>
                                    <td>{$lang.description}</td>
                                    <td>{$lang.size}</td>                                    
                                    <td>Posted By</td>
                                    <td>{$lang.upload_date}</td>
                              	</tr>
                              </thead>
                              {if !$files}
                              	 <tr>
                                    <td colspan="6">{$lang.no_result_found}</td>
                                 </tr>
                              {else}
                              <tbody>
                                 {foreach key=obj item=name from=$files}
                                 <tr>
                                    <td>
                                       {capture assign=comm}{$name.id}{/capture}                                
                                       <a href="{if $membershipId >= $name.minium_membership}/members/myvault/&file={$encoded.$comm}{else}#"onClick="return confirm ('{$lang.you_need_to_upgrade_your_membership_to_download_this_file}');{/if}"><strong>{$name.title}</strong></a>{if $name.featured eq "yes"}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/assets/members/images/featured.png" />{/if}                                    </td>
                                    <td>{$name.category}</td>
                                    <td>{$name.description}</td>
                                    <td>{$name.size} Bytes</td>                                    
                                    <td>PlusMoreUsa</td>
                                    <td>{$name.date}</td>
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
<!-- Right sidebar -->
{include file='right_sidebar.tpl'}   
<!-- Vendor scrits -->
{include file='vendor_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
    
    
   });
   
</script>
{include file='footer.tpl'}