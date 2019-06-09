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
                                    <td>{$lang.description}</td>                                    
                                    <td>Price</td>
                                    <td>Posted By</td>
                                    <td>Action</td>
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
                                       {$file=$name.download}    

                                       {if $name.productCode|in_array:$orders}<a target="_blank" href="https://plusmoreusaeng.com/system/app/plugins/cart/assets/{$file}"onClick="return confirm ('{$lang.you_need_to_upgrade_your_membership_to_download_this_file}');"><strong>{$name.name}</strong></a>{else}{if $name.price == 0.00 }<a  target="_blank" href="https://plusmoreusaeng.com/system/app/plugins/cart/assets/{$file}"onClick="return confirm ('{$lang.you_need_to_upgrade_your_membership_to_download_this_file}');"><strong>{$name.name}</strong></a>{else}<strong>{$name.name}</strong>{/if}{/if}{if $name.featured eq "yes"}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/assets/members/images/featured.png" />{/if}                                  
                                    </td>
                                    <td>{$name.description}</td>                                    
                                    <td>{$name.price} $</td>                                    
                                    <td>PlusMoreUsa</td>
                                    <td>{if $name.price == 0.00 }{else}{if $name.productCode|in_array:$orders}{else} <a prid="{$name.id}" href="#" class="btn btn-success addproduct" style="margin:0px !important;"><i class="icon-shopping-cart"></i>add to cart </a>{/if}{/if}
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
<!-- Right sidebar -->
{include file='right_sidebar.tpl'}   
<!-- Vendor scrits -->
{include file='vendor_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
window.confirm = function() {};

// or simply
confirm = function() {};
   $(function () {
    $('.addproduct').each(function(){
      $(this).click(function(event) {
      /* Act on the event */
      $(this).hide();
      var param={};
      $.get("//"+window.location.hostname+"/system/app/plugins/cart/ShoppingCart/addproduct_vertical_inside.php?id="+$(this).attr("prid")+"&type=&size=undefined&quantity=1",function(result){
        
        window.location.replace("//"+window.location.hostname+"/plugins/cart/cartmember/purchase/&page=shoppingcart_view_inside");
      })
    });
    })
    
   });
   
</script>
        
{include file='footer.tpl'}
