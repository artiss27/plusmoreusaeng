{include file='header.tpl'}
{include file='menu.tpl'}
<div id="wrapper">
<div class="content animate-panel">
   <div class="row">
      <div class="normalheader transition animated fadeIn">
         <div class="hpanel">
            <div class="panel-body">
               <a class="small-header-action" href="">
                  <div class="clip-header">
                     <i class="fa fa-arrow-up"></i>
                  </div>
               </a>
               <div id="hbreadcrumb" class="pull-right m-t-lg">
                  <ol class="hbreadcrumb breadcrumb">
                  </ol>
               </div>
               <h2 class="font-light m-b-xs">
                  View Member Transactions
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     {foreach $errors as $error}
                     <div class="alert alert-success">
                        
                        <p><strong>{$error@key}</strong> {$error}</p>
                     </div>
                     {/foreach}    
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <form action="#" method="post" class="validate-form form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                    <br />
                                       <div class="form-group">
                                          <label for="select" class="col-sm-2 control-label">Wallet Type</label>
                                          <select name="type" id="select" class="form-control">
                                             <option value="deposit">Desposit Wallet</option>
                                             <option value="payout">Payout Wallet</option>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label for="textfield" class="col-sm-2 control-label">Member ID or Username:</label>
                                          <input name="member_id" type="text" class="form-control" id="textfield" size="10" value='{$smarty.request.member_id}' />
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <button type="button" class="btn btn-primary m-t" onclick='this.form.submit();'>Search</button>
                                 </div>
																						
                              </form>
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
   </div>
</div>
{include file='footer_scripts.tpl'}
{include file='footer.tpl'}
