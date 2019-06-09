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
               Transaction Results
            </div>
            <div class="panel-body">
               <div class="actions">
                  <form id="form1" name="form1" method="post" action="">
                     <br />
                     <div class="form-group">
                        <label for="select" class="col-sm-2 control-label">Wallet Type</label>
                        <select name="type" id="select" class="form-control" onChange='this.form.submit();' >
                           <option value="deposit" {if $smarty.request.type == "deposit" || $smarty.request.type == ""}selected{/if}>Desposit Wallet</option>
                           <option value="payout" {if $smarty.request.type == "payout"}selected{/if}>Payout Wallet</option>
                        </select>
                     </div>
                     {$filter} <span style="margin-left:4px;"><input type='submit' class="button small" value=" Apply "></span><input type='hidden' name='filter' value=1><input type='hidden' name='transaction_id' value='{$traid}'>
                  </form>
               </div>
               <table id="transaction" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                     	<th>ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Description</th>
                     </tr>
                  </thead>
                  <tbody>
                     {foreach key=obj item=name from=$list}                
                     <tr>
                     	<td>{if $name.id}{$name.id}{/if}{if $name.transaction_id}{$name.transaction_id}{/if}</td>
                        <td>{$name.date}</td>
                        <td>${$name.amount}</td>
                        <td>{$name.from}</td>
                        <td>{$name.to}</td>
                        <td>{$name.description}</td>
                     </tr>
                     {/foreach}	
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
{include file='footer_scripts.tpl'}
{include file='footer_datatable.tpl'}
{include file='footer.tpl'}