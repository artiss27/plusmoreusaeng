{include file='views/members/header.tpl'}
{include file='views/members/menu.tpl'}
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
         {include file='views/members/breadcrumb.tpl'}            
         <h2 class="font-light m-b-xs">
            Lend Money
         </h2>
         <small>Lend up to $1,000 per member and earn up to 18% annually, plus a gift.</small>
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
                           <form id="form1" method="post" action="">
                              <h3>Available Balance on Accounts</h3>
                              <table class="table" style="width:50%">
                                 <tr>
                                    <td>Personal Account</td>
                                    <td>{$lang.monetary}{$total_deposit|number_format:2:'.':' '}</td>
                                 </tr>
                                 <tr>
                                    <td>Business Account</td>
                                    <td>{$lang.monetary}{$total_payout|number_format:2:'.':' '}</td>
                                 </tr>
                              </table>                              
                              Transfer Fee: 0.5%
                              <br /><br />
                              <h3>Make a Transfer</h3>
                              <div class="form-group">
                                 <label>Amount to Lend{$lang.monetary}</label>
                                 <div class="input">																								
                                    <input type="text" class="form-control" placeholder="amount" name="amount" value="">	
                                 </div>
                              </div>
                                                   
                              <label>From Account :</label>
                              <select class="form-control form-half" name="from_wallet" id="select">
                                 <option value="deposit">Personal Account</option>
                                 <option value="payout">Business Account</option>
                              </select>
                              <br />   
                              <div class="form-group">
                                 <label>To Member</label>
                                 <div class="input">																								
                                    <input type="text" class="form-control" placeholder="username" name="username" value="">	
                                 </div>
                              </div>
                              <input type="submit" name="form1" id="button" class="btn btn-sm btn-primary m-t-n-xs" value=" Transfer " />
                           </form>
                           <br />                                                      
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
{include file='views/members/right_sidebar.tpl'}   
<!-- Vendor scrits -->
{include file='views/members/vendor_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
   
   });
</script>
{include file='views/members/footer.tpl'}