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
            {$lang.payout_wallet}
         </h2>
         <small>{$lang.showing_earnings_transactions_and_balance}</small>
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
            {foreach $errors as $error}
            <p class="alert alert-danger">
               {$error}
            </p>
            <br />
            {/foreach}  
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <div class="actions">
                              <form id="form1" name="form1" method="post" action="">{$filter} <input type='submit' class="btn btn-sm btn-primary m-t-n-xs" value=" Search "><input type='hidden' name='filter' value=1>
                              </form>
                           </div>
                           <br />
                           {$lang.curent_balance}: <br />
                           <table id="transactions" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th>{$lang.date}</th>
                                    <th>{$lang.amount}</th>
                                    <th>{$lang.description}</th>
                                 </tr>
                              </thead>
                              <tbody>
                              {if !$list}
                              <tr>
                                    <td colspan="3">{$lang.no_result_found}</td>
                                 </tr>
                              {else}
                                 {foreach key=obj item=name from=$list}                
                                 <tr>
                                    <td>{$name.date}</td>
                                    <td>{$lang.monetary}{$name.amount}</td>
                                    <td>{$name.description}</td>
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
    	('#transactions').dataTable();    
   });
   
</script>
{include file='footer.tpl'}