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
                  <div class="main pagesize">
                     <!-- *** mainpage layout *** -->
                     <div class="main-wrap">
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
                        <div class="content-box">
                           <div class="box-body">
                              <div class="box-wrap clear">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <div class="row">
                                          <div class="col-md-2">
                                             <div class="hpanel">
                                                <div class="panel-body">
                                                   <ul class="mailbox-list">
                                                   <li {if $smarty.request.p == '' || $smarty.request.p == 'new'}class="active{/if}">
                                                   <a href="/admin/messages/&p=new">
                                                   <span class="pull-right">{if $smarty.request.p == '' || $smarty.request.p == 'new'}{if $messages}{$messages|count}{/if}{/if}</span>
                                                   <i class="fa fa-envelope"></i> {$lang.new_messages}
                                                   </a>
                                                   </li>
                                                   <li {if $smarty.request.p == 'send'}class="active"{/if}>
                                                   <a href="/admin/messages/&p=send"><i class="fa fa-paper-plane"></i> {$lang.sent_messages}</a>
                                                   </li>
                                                   <li {if $smarty.request.p == 'read'}class="active"{/if}>
                                                   <a href="/admin/messages/&p=read"><i class="fa fa-paper-plane"></i> {$lang.read_messages}</a>
                                                   </li>
                                                   <li {if $smarty.request.p == 'deleted'}class="active"{/if}>
                                                   <a href="/admin/messages/&p=deleted"><i class="fa fa-trash"></i> {$lang.deleted_messages}</a>
                                                   </li>
                                                   <!-- </ul>
                                                      <ul class="mailbox-list">
                                                         <li>
                                                            <a href="#"><i class="fa fa-gears"></i> Settings</a>
                                                         </li>
                                                      </ul> -->
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-10">
                                             <div class="hpanel">
                                                <div class="panel-body">
                                                   <div class="row">
                                                      <div class="col-md-6 m-b-md">
                                                         <div class="btn-group">
                                                            <button class="btn btn-default btn-sm" onclick="window.location=''"><i class="fa fa-refresh"></i> Refresh</button>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <form id="new" name="new" method="post" action="">
                                                      <p><strong><a href="#" onClick="toggle_visibility('send');">{$lang.send_new_message}</a></strong></p>
                                                      <div id="send" {if !$smarty.post.reply && !$smarty.request.member && $smarty.request.admin != 1}style='display:none;'{/if}>
                                                      <table id="table6" class="table table-striped table-hover" style="width:50%">
                                                         <tr>
                                                            <td><strong>{$lang.to}</strong></td>
                                                            <td>
                                                               {if $smarty.post.reply}
                                                               <input type='text' name='to' value='{$smarty.post.rfrom}' READONLY class="form-control">
                                                               {else}
                                                               <select name="to" class="form-control">
                                                                  <option value="all">All Members</option>            
                                                                  {foreach from=$directs_data item=row}
                                                                  <option value="{$row.member_id}" {if $smarty.request.member == $row.member_id}selected="selected"{/if}>{$row.username}</option>
                                                                  {/foreach}
                                                               </select>
                                                               {/if}
                                                            </td>
                                                         <tr>
                                                            <td>
                                                               <strong>{$lang.subject}</strong>
                                                            </td>
                                                            <td>
                                                               <input id='subject' name='subject' type='text' value='{if $smarty.post.reply}{$smarty.post.rsubject}{/if}' size="50" class="form-control" />
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td>
                                                               <strong>
                                                               {$lang.priority} </strong>
                                                            </td>
                                                            <td>
                                                               <select name="priority" class="form-control">
                                                                  <option value="1">{$lang.normal}</option>
                                                                  <option value="2">{$lang.high}</option>
                                                               </select>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td>  <strong>{$lang.message}</strong></td>
                                                            <td> <textarea name='message' cols="50" rows="10" class="form-control">{if $smarty.post.reply}{$smarty.post.rmessage|urldecode}{/if}</textarea>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td>
                                                               <input type='button' name='newmessage' value='{$lang.send}' onClick="javascript:verifyy();" class="btn btn-sm btn-primary m-t-n-xs" />
                                                            </td>
                                                            <td>&nbsp;</td>
                                                         </tr>
                                                      </table>
                                                </div>
                                                </form>
                                                <br>
                                                {if !$smarty.request.p || $smarty.request.p == 'new'}
                                                <table id="msg" class="table table-striped table-bordered table-hover">
                                                   <thead>
                                                      <tr>
                                                         <th>{$lang.from}</th>
                                                         <th>{$lang.title}</th>
                                                         <th>{$lang.date}</th>
                                                      </tr>
                                                   </thead>
                                                   {if $messages}
                                                   {foreach from=$messages item=message}
                                                   <tr>
                                                      <td>{$message.from}</td>
                                                      <td><a href='/admin/messages/&p=view&mid={$message.id}'>
                                                         {if $message.priority == 2}
                                                         <b>
                                                         {/if}
                                                         {$message.title}
                                                         {if $message.priority == 2}
                                                         </b>
                                                         {/if}
                                                         </a>
                                                      </td>
                                                      <td>{$message.created}</td>
                                                   </tr>
                                                   {/foreach}
                                                   {else}
                                                   <tr>
                                                      <td colspan='3'><br><strong>{$lang.no_new_messages_found}</strong></td>
                                                   </tr>
                                                   {/if}
                                                </table>
                                                {elseif $smarty.request.p == 'send'}
                                                <table id="msg" class="table table-striped table-bordered table-hover">
                                                   <thead>
                                                      <tr>
                                                         <th>{$lang.to}</th>
                                                         <th>{$lang.title}</th>
                                                         <th>{$lang.status}</th>
                                                         <th>{$lang.date}</th>
                                                      </tr>
                                                   </thead>
                                                   {if $messages}
                                                   {foreach from=$messages item=message}
                                                   <tr>
                                                      <td>{$message.to}</td>
                                                      <td><a href='/admin/messages/&p=view&mid={$message.id}'>{$message.title}</a></td>
                                                      <td>
                                                         {if $message.to_deleted && !$message.to_viewed}
                                                         {$lang.deleted_without_reading};
                                                         {elseif $message.to_deleted && $message.to_viewed}
                                                         {$lang.deleted_after_reading};
                                                         {elseif !$message.to_deleted && $message.to_viewed}
                                                         {$lang.read}
                                                         {else}
                                                         {$lang.not_read_yet}
                                                         {/if}
                                                      </td>
                                                      <td>{$message.created}</td>
                                                   </tr>
                                                   {/foreach}
                                                   {else}
                                                   <tr>
                                                      <td colspan='4'><br><strong>{$lang.no_sent_messages_found}</strong></td>
                                                   </tr>
                                                   {/if}
                                                </table>
                                                {elseif $smarty.request.p == 'read'}
                                                <table id="msg" class="table table-striped table-bordered table-hover">
                                                   <thead>
                                                      <tr>
                                                         <th>{$lang.from}</th>
                                                         <th>{$lang.title}</th>
                                                         <th>{$lang.date}</th>
                                                      </tr>
                                                   </thead>
                                                   {if $messages}
                                                   {foreach from=$messages item=message}
                                                   <tr>
                                                      <td>{$message.from}</td>
                                                      <td><a href='/admin/messages/&p=view&mid={$message.id}'>{$message.title}</a></td>
                                                      <td>{$message.to_vdate}</td>
                                                   </tr>
                                                   {/foreach}
                                                   {else}
                                                   <tr>
                                                      <td colspan='4'><br><strong>{$lang.no_read_messages_found}</strong></td>
                                                   </tr>
                                                   {/if}
                                                </table>
                                                {elseif $smarty.request.p == 'deleted'}
                                                <table id="msg" class="table table-striped table-bordered table-hover">
                                                   <thead>
                                                      <tr>
                                                         <th>{$lang.from}</th>
                                                         <th>{$lang.title}</th>
                                                         <th>{$lang.date}</th>
                                                      </tr>
                                                   </thead>
                                                   {if $messages}
                                                   {foreach from=$messages item=message}
                                                   <tr>
                                                      <td>{$message.from}</td>
                                                      <td><a href='/admin/messages/&p=view&mid={$message.id}'>{$message.title}</a></td>
                                                      <td>{$message.to_ddate}</td>
                                                   </tr>
                                                   {/foreach}
                                                   {else}
                                                   <tr>
                                                      <td colspan='4'><strong>{$lang.no_deleted_messages_found}</strong></td>
                                                   </tr>
                                                   {/if}
                                                </table>
                                                {elseif $smarty.request.p == 'view' && $smarty.request.mid}
                                                <table class="table table-striped table-hover">
                                                   <tr>
                                                      <td>{$lang.from}:</td>
                                                      <td>{$messages.0.from}</td>
                                                      <td colspan="2"></td>
                                                   </tr>
                                                   <tr>
                                                      <td>{$lang.date}:</td>
                                                      <td>{$messages.0.created}</td>
                                                      <td colspan="2"></td>
                                                   </tr>
                                                   <tr>
                                                      <td>{$lang.subject}</td>
                                                      <td colspan="3">{$messages.0.title}</td>
                                                   </tr>
                                                   <tr>
                                                      {assign var=message_var value=CoreHelp::stripAll($messages.0.message)}
                                                      <td colspan="4"><br>{$message_var}</td>
                                                   </tr>
                                                </table>
                                                <br>
                                                <table style="width:200px">
                                                   <tr>
                                                      <td>
                                                         <form name='reply' method='post' action=''>
                                                            <input type='hidden' name='rfrom' value='{$messages.0.from}' />
                                                            <input type='hidden' name='rsubject' value='Re: {$messages.0.title}' />
                                                            <input type='hidden' name='rmessage' value='[quote]{$messages.0.message|urlencode}[/quote]' />
                                                            <input type='submit' name='reply' value='{$lang.reply}' class="btn btn-sm btn-primary m-t-n-xs" />
                                                         </form>
                                                      </td>
                                                      <td>
                                                         <form name='delete' method='post' action=''>
                                                            <input type='hidden' name='did' value='{$messages.0.id}' />
                                                            <input type='submit' name='delete' value='{$lang.delete}' class="btn btn-sm btn-primary m-t-n-xs" />
                                                         </form>
                                                      </td>
                                                   </tr>
                                                </table>
                                                {/if}
                                             </div>
                                             {if $smarty.request.p == '' || $smarty.request.p == 'new'}
                                             <div class="panel-footer">
                                                <i class="fa fa-eye"> </i> {if $messages}{$messages|count}{/if} unread
                                             </div>
                                             {/if}
                                          </div>
                                       </div>
                                    </div>
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
<script>
   $(function () {
    	{if $messages}$('#msg').dataTable();{/if}     
   });
   
   
   function verifyy() {
   	var themessage = "{$lang.you_are_required_to_complete}: ";
   	var g = document.getElementById("new");
   	if (g.subject.value=="") {
   		themessage = themessage + " - Subject";
   	}
   
   	if (themessage == "{$lang.you_are_required_to_complete}: ") {
   	g.submit();
   	}
   	else {
   	alert(themessage);
   	return false;
   }   
   }
   
   
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
   
   
</script>
{include file='footer.tpl'}