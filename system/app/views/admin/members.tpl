{include file='header.tpl'}
{include file='menu.tpl'}
<script language="javascript"> 
   <!--    
      function iFrameWrite(par_ID_iFrame, par_URL){
         document.getElementById(par_ID_iFrame).src = par_URL;
      }
      -->
</script> 
<div id="wrapper">
   <div class="content animate-panel">
      <div class="row">
         <div class="col-lg-12">
            <div class="hpanel">               
               <div class="panel-body">
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
                  {if $welcome_sent eq 'y'}
                  <div class="alert alert-success m-t">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                     <p><strong>Email Sent.</strong> Welcome email was sent to member.</p>
                  </div>
                  {/if}  
                  {if $smarty.request.msg eq '10'}
                  <div class="alert alert-success m-t">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                     <p><strong>Update Succesfully.</strong> User Information was saved in database.</p>
                  </div>
                  {/if}  
                  {if $member_deleted eq 'y'}
                  <div class="alert alert-success m-t">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                     <p><strong>Member Deleted.</strong> Member Deleted.</p>
                  </div>
                  {/if}
                  {if $member_dissabled eq 'y'}
                  <div class="alert alert-success m-t">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                     <p><strong>Member Dissabled.</strong> Member Disabled.</p>
                  </div>
                  {/if}
                  <div class="actions">
                     <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
                        <tr>
                           <td align='right'>
                              <form action="#" method="post" class="validate-form form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <div class="form-field clear">                    
                                          <strong>Filter:</strong> {$select}&nbsp;&nbsp;&nbsp;&nbsp; <strong>Search:</strong>
                                          <input type="text" name="s_line" value="{$smarty.request.s_line}" style="width:200px;" class='form-select form-control b-m'>
                                          <br /> <br />
                                       </div>
                                       <div class="form-field clear">                    
                                          <strong>{$dates}</strong>&nbsp;
                                          <input type="submit" name="submit" value=" Search ">
                                       </div>
                                       <input type="hidden" name="filter" value="1">
                                    </div>
                                 </div>
                              </form>
<!--                             <div class="col-sm-12">-->
<!--                               <form class="form-horizontal" action="" method="get" id="date-renge">-->
<!--                                 <div class="form-group row">-->
<!--                                   <label class="col-sm-2 control-label">Date of reg. from</label>-->
<!--                                   <div class="col-sm-3">-->
<!--                                     <input type="date" class="form-control date-range" value="{$header.DATE_START}"-->
<!--                                            name="start">-->
<!--                                   </div>-->
<!--                                   <label class="col-sm-2 control-label">Date of reg. to</label>-->
<!--                                   <div class="col-sm-3">-->
<!--                                     <input type="date" class="form-control date-range" value="{$header.DATE_START}"-->
<!--                                            name="end">-->
<!--                                   </div>-->
<!--                                   <a href="/admin/members/" class="col-sm-2 btn btn-primary" style="margin-top: 0">reset</a>-->
<!--                                 </div>-->
<!--                               </form>-->
<!--                             </div>-->
                           </td>
                        </tr>
                     </table>
                  </div>
                  <table id="transaction" class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>{$header.HEAD_MEMBER_ID}</th>
                           <th>{$header.HEAD_USERNAME}</th>
                           <th>{$header.HEAD_FIRST_NAME}</th>
                           <th>{$header.HEAD_LAST_NAME}</th>
                           <th>{$header.HEAD_EMAIL}</th>
                           <th>{$header.HEAD_SPONSOR}</th>
                           <th>{$header.HEAD_LEVEL}</th>
                           <th>{$header.HEAD_EARNINGS}</th>
                           <th>{$header.HEAD_MEMBERSHIP}</th>
                           <th>{$header.HEAD_ACTIVE}</th>
                           <th align="center"><b>Actions</b></th>
                        </tr>
                     </thead>
                     <tbody>
                        {foreach key=obj item=name from=$members}                        
                        <tr>
                           <td>{$name.ROW_MEMBER_ID}</td>
                           <td>{$name.ROW_USERNAME}</td>
                           <td>{$name.ROW_FIRST_NAME}</td>
                           <td>{$name.ROW_LAST_NAME}</td>
                           <td><a href="{$name.ROW_EMAIL}">{$name.ROW_EMAIL}</a>&nbsp;</td>
                           <td>{$name.ROW_SPONSOR}</td>
                           <td>{$name.ROW_LEVEL}</td>
                           <td>${$name.ROW_EARNINGS}</td>
                           <td>{$name.MEMBERSHIP|replace:"_":" "}</td>
                           <td>{$name.ROW_ACTIVE}</td>
                           <td>
                              <!--  {if $name.ROW_LEVEL eq "Unpaid"}
                                 <a href="#myModal{$name.ROW_MEMBER_ID}" data-toggle="modal" data-target="#myModal{$name.ROW_MEMBER_ID}" class="label modal-link"><img src="/assets/admin/images/ico_shopping_16_off.png" class="icon16 fl-space1" alt="pay" title="pay" /></a>
                                 {else}
                                 <a href="#myModalup{$name.ROW_MEMBER_ID}" data-toggle="modal" data-target="#myModalup{$name.ROW_MEMBER_ID}" class="label modal-link"><img src="/assets/admin/images/ico_shopping_16_disabled.png" class="icon16 fl-space1" /></a>
                                 {/if} -->
                              <a href="{if $smarty.session.plan|@count gt 1}#{else}/admin/viewnetwork/&id={$name.ROW_MEMBER_ID}{/if}" {if $smarty.session.plan|@count gt 1}data-toggle="modal" data-target="#myModal{$name.ROW_MEMBER_ID}"{else}{/if}><i class="pe-7s-network" title="View network"></i></a>
                              <a href="/admin/editmember/&id={$name.ROW_MEMBER_ID}"><i class="fa fa-edit" title="Edit" style="padding: 4px;"></i></a>
                              <a href="/admin/messages/&member={$name.ROW_MEMBER_ID}"><i class="fa pe-7s-mail" title="Message this member" style="padding: 4px;"></i></a>
                              <a href="/admin/transactions/&member_id={$name.ROW_MEMBER_ID}"><i class="fa fa-money" title="View transactions" style="padding: 4px;"></i></a>
                              <a href="/admin/loginmember/&id={$name.ROW_MEMBER_ID}" target="_blank"><i class="fa fa-unlock-alt" title="Login to member panel" style="padding: 4px;"></i></a>
                              <a href="/admin/members/&banid={$name.ROW_MEMBER_ID}" onClick="return confirm ('Do you really want to ban this member?');"><i class="fa pe-7s-delete-user" title="Ban member" style="padding: 4px;"></i></a>
                           </td>
                        </tr>
                        <div class="modal fade" id="myModal{$name.ROW_MEMBER_ID}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="color-line"></div>
                                    <div class="modal-header text-center">
                                        <h4 class="modal-title">Network Selection</h4>
                                        <small class="font-bold">Select which network you like to view from member.</small>
                                    </div>
                                    <div class="modal-body">
                                    {assign var=plans value=$hooks->apply_filters('view_network')}
                                    <center>
                                        <p>
                                        	{foreach $plans as $plan}
                                            	<a href="{$plan.url}/&id={$name.ROW_MEMBER_ID}" target="_blank">{$plan.name}</a> &nbsp;&nbsp;&nbsp;&nbsp;
                                            {/foreach}
                                        	
                                        </p>
                                    </center>    
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        {/foreach}
                        {$header.PAGINATION}
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>


<style>
   body.modal-open {
   padding-right: 0 !important;
   }
</style>
{include file='footer_scripts.tpl'}
{include file='footer.tpl'}