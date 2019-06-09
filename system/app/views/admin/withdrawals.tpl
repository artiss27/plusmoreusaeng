{include file='header.tpl'}
{include file='menu.tpl'}
<div id="wrapper">
<!--<div class="normalheader transition animated fadeIn">
   <div class="hpanel">
      <div class="panel-body">
         <a class="small-header-action" href="">
            <div class="clip-header">
               <i class="fa fa-arrow-up"></i>
            </div>
         </a>
     
   
      </div>
   </div>
   </div>
   -->

<div class="content animate-panel">
   <div class="row">
      <div class="col-lg-12">
         <div class="hpanel">
            <div class="panel-heading">
               <div class="panel-tools">               
                  <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  <a class="closebox"><i class="fa fa-times"></i></a>
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
                    <p class="alert alert-danger">
                       {$error}
                    </p>
                    <br />
                    {/foreach}  
                    {if $declined_saved eq 'y'}
                    <div class="alert alert-success m-t">
                       <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                       <p><strong>Withdrawal Declined:</strong> Request was saved to database.</p>
                    </div>
                    {/if}  
                    {if $complete_saved eq 'y'}
                    <div class="alert alert-success m-t">
                       <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                       <p><strong>Withdrawal Completed:</strong> Withdrawal was marked as completed succesfully.</p>
                    </div>
                    {/if} 
               
              <br />
               Withdrawal Requests
            </div>
            <div class="panel-body">
               <div class="actions">
                  <div class="columns clear bt-space5">
                     <div class="col2-3">
                        <div class="clear"></div>
                        <div class="clear">
                           <form action='' method='POST'>
                              <label class="fl-space size-300">Member Id</label>
                              {$header.MAIN_FILTER}
                              <input type='submit' class='some_btn' value=" Filter ">
                              <input type='hidden' name='filter1' value=1>
                           </form>
                        </div>
                        <br />
                        <div class="clear">
                           <form action='' method='POST'>
                              <label class="fl-space size-300">Status:</label>
                              {$header.STATUS}
                              <input type='hidden' name='filter2' value=1>
                           </form>
                        </div>
                        <br />
                        <div class="clear">
                           <form action='' method='POST'>
                              <label class="fl-space size-300">Processor:</label>
                              {$header.PROCESSOR}
                              <input type='hidden' name='filter3' value=1>
                           </form>
                        </div>
                        <br />
                        <h3>Total Amount : ${$total_amount}</h3>
                     </div>
                  </div>
               </div>
               <table id="transaction" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                     	<th>ID</th>
                        <th>{$header.HEAD_DATE}</th>
                        <th>{$header.HEAD_USERNAME}</th>
                        <th>{$header.HEAD_AMOUNT}</th>
                        <th>{$header.HEAD_FEE}</th>
                        <th>Amount To Pay</th>
                        <th>{$header.HEAD_PROCESSOR}</th>
                        <th>{$header.HEAD_ACCOUNT_ID}</th>
                        <th>{$header.HEAD_STATUS}</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     {foreach key=obj item=name from=$data}
                     <tr>
                     	<td>{$name.ROW_ID}</td>
                        <td>{$name.ROW_DATE}</td>
                        <td>{$name.ROW_USERNAME}</td>
                        <td>${$name.ROW_AMOUNT}</td>
                        <td>{$name.ROW_FEE}%</td>
                        <td>${math equation="x * (1 - y/100)" x=$name.ROW_AMOUNT y=$name.ROW_FEE format="%.2f"}</td>
                        <td>{$name.ROW_PROCESSOR}</td>
                        <td>{$name.ROW_ACCOUNT_ID}</td>
                        <td>{$name.ROW_STATUS}</td>
                        <td>{$name.ROW_ACTIONS}</td>
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