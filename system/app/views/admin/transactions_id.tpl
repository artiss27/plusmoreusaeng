{include file='header.tpl'}
{include file='menu.tpl'}
<div id="wrapper">
{foreach $errors as $error}
<div class="alert alert-success">
   
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
               Transaction for {$smarty.request.type} wallet
            </div>
            <div class="panel-body">
               <div class="actions">
                  <form id="form1" name="form1" method="post" action="">{$filter} <span style="margin-left:4px;"><input type='submit' class="button small" value=" Apply "></span>
                  <input type='hidden' name='filter' value=1>
                  <input type='hidden' name='member_id' value='{$traid}'>
                  <input type='hidden' name='type' value='{$smarty.request.type}'>
                  </form>
               </div>
               <table id="transaction" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
	                     <th>ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Description</th>
                     </tr>
                  </thead>
                  <tbody>
                     {foreach key=obj item=name from=$list}                
                     <tr>
                     	<td>{$name.id}</td>
                        <td>{$name.date}</td>
                        <td>${$name.amount}</td>
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