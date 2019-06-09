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
               {foreach $errors as $error}
               <div class="alert alert-success">
                  
                  <p><strong>{$error@key}</strong> {$error}</p>
               </div>
               {/foreach}  
               <h2 class="font-light m-b-xs">
                  Add Transaction
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <div class="columns clear bt-space15">
                                 <div class="col2-3">
                                    <form action="#" method="POST" name="form1" id="form1">
                                       <br />
                                       <div class="form-group">
                                          <label for="select" class="col-sm-2 control-label">Wallet Type</label>
                                          <select name="type" id="select" class="form-control">
                                             <option value="deposit">Deposit Wallet</option>
                                             <option value="payout">Payout Wallet</option>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label for="textfield" class="col-sm-2 control-label">Member ID:</label>
                                             <select name="member_id" id="select3" class="form-control">
                                                {foreach key=ob item=username from=$members12} 
                                                <option value="{$username.member_id}">{$username.username}</option>
                                                {/foreach}  
                                             </select>
                                       </div>
                                       <div class="form-group">
                                          <label for="textfield" class="col-sm-2 control-label">Amount: ($)</label>
                                          <input name="amount" type="text" class="form-control" id="textfield" size="10" value='' />
                                          <small>Positive will add, Negative will substract.</small>
                                       </div>
                                       <div class="form-group">
                                          <label for="textfield" class="col-sm-2 control-label">Description:</label>
                                          <input name="description" type="text" class="form-control" id="textfield" size="50" value='' />
                                       </div>
                                       
                                       <div class="form-group">
                                          <label for="textfield" class="col-sm-2 control-label">service ID:</label>
                                             <select name="service_id" id="select4" class="form-control">
                                                <option value="no">No Service Selected</option>
                                                
                                                {foreach key=ob item=username from=$products12} 
                                                <option value="{$username.id}">{$username.name} ({$username.price}$)</option>
                                                {/foreach}  
                                             </select>
                                       </div>
                                       <button type="button" class="btn btn-primary m-t" onclick='this.form.submit();'>Save changes</button>
                                    </form>
                                 </div>
                              </div>
                              <!-- /.form-field -->	
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
