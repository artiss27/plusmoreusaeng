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
                  Edit Member
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     {if $member_edited eq 'y'}
                     <div class="alert alert-success">
                        <p><strong>Member Edited:</strong> Member was edited succesfully to database.</p>
                     </div>
                     {/if}  
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <table width="100%" border="0" cellspacing="1" cellpadding="1" class="m-t m-b">
                                 <tr>
                                    <td>Member ID</td>
                                    <td><a href="#">{$member_id}</a></td>
                                    <td>Total Sponsored</td>
                                    <td><a href="#">{$total_sponsored}</a></td>
                                    <td>Sponsored Today</td>
                                    <td><a href="#">{$sponsored_today}</a></td>
                                 </tr>
                                 <tr>
                                    <td>Username</td>
                                    <td><a href="#">{$username}</a></td>
                                    <td></td>
                                    <td></td>
                                    <td>Sponsored This Week</td>
                                    <td><a href="#">{$sponsored_this_week}</a></td>
                                 </tr>
                                 <tr>
                                    <td>Membership</td>
                                    <td><a href="#">{$membership|replace:"_":" "}</a></td>
                                    <td>Total Pending</td>
                                    <td><a href="#">{$total_pending}</a></td>
                                    <td>Sponsored Last Week</td>
                                    <td><a href="#">{$sponsored_last_week}</a></td>
                                 </tr>
                                 <tr>
                                    <td>Reg. Date</td>
                                    <td><a href="#">{$reg_date}</a></td>
                                    <td>Money Available</td>
                                    <td><a href="#">{$money_available}</a></td>
                                    <td>Sponsored This Month</td>
                                    <td><a href="#">{$sponsored_this_month}</a></td>
                                 </tr>
                                 <tr>
                                    <td>Total Money Earned</td>
                                    <td><a href="#">{$money_earned}</a></td>
                                    <td>Referral Url Hits</td>
                                    <td><a href="#">{$referal_hits}</a></td>
                                 </tr>
                              </table>
                              <div id="table">
                                 <div class="box-wrap clear">
                                    <form action="#" method="post" >
                                       <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center" class="style1">
                                          <tbody>
                                             <tr>
                                                <td class="w_border">&nbsp;</td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <h3>Main Settings</h3>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="w_border">
                                                   <table border="0" align="left" width="100%">
                                                      <tbody>
                                                         <tr>
                                                            <td width="30%"><b>First name :</b></td>
                                                            <td><input type="text" name="firstName" value="{$member.first_name}" maxlength="120" class="form-control" />
                                                               &nbsp; <span class="error"></span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Last name :</b></td>
                                                            <td><input type="text" name="lastName" value="{$member.last_name}" maxlength="120" class="form-control" />
                                                               &nbsp; <span class="error"></span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>E-mail :</b></td>
                                                            <td><input type="text" name="email" value="{$member.email}" maxlength="120" class="form-control" />
                                                               &nbsp; <span class="error"></span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Sponsor ID : </b></td>
                                                            <td><input type="text" name="sponsor" value="{$member.sponsor_id}" maxlength="12" class="form-control" />
                                                            <small>Sponsor ID must always be a lower ID than Member ID (Only change if using Unilevel system)</small>
                                                               &nbsp; <span class="error"></span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                           <td><b>Agent ID : </b></td>
                                                           <td><input type="text" name="agent" value="{$member.agent_id}" maxlength="12" class="form-control" />
                                                             &nbsp; <span class="error"></span>
                                                           </td>
                                                         </tr>
                                                         <tr>
                                                           <td><b>Manager ID : </b></td>
                                                           <td><input type="text" name="manager" value="{$member.manager_id}" maxlength="12" class="form-control" />
                                                             &nbsp; <span class="error"></span>
                                                           </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Membership :</b></td>
                                                            <td><input type="text" name="membership" value="{$member.membership|replace:"_":" "}" maxlength="12" class="form-control" />
                                                               &nbsp; <span class="error"></span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                         </tr>
                                                         <tr>
                                                            <td>
                                                               <h3>Login Info</h3>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Username :</b></td>
                                                            <td><input type="text" name="username" value="{$member.username}" maxlength="120" class="form-control" />
                                                               &nbsp; <span class="error"></span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Password :</b></td>
                                                            <td><input type="text" name="password" value="" maxlength="12" class="form-control" placeholder="If set, will change password to new one" />
                                                               &nbsp; <span class="error"></span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td colspan="2"></td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <h3>Address Settings</h3>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="w_border">
                                                   <table border="0" cellspacing="0" cellpadding="2" align="left" width="100%">
                                                      <tbody>
                                                         <tr>
                                                            <td width="30%"><b>Address :</b></td>
                                                            <td><input type="text" name="street" value="{$member.street}" class="form-control m-b" maxlength="50" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>City :</b></td>
                                                            <td><input type="text" name="city" value="{$member.city}" class="form-control m-b" maxlength="50" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>State :</b></td>
                                                            <td><input type="text" name="state" value="{$member.state}" class="form-control m-b" maxlength="50" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Country Code:</b></td>
                                                            <td><input type="text" name="country" value="{$member.country}" class="form-control m-b" maxlength="50" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Postal Code :</b></td>
                                                            <td><input type="text" name="postal" value="{$member.postal}" class="form-control m-b" maxlength="50" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Phone :</b></td>
                                                            <td><input type="text" name="phone" value="{$member.phone}" class="form-control m-b" maxlength="50" /></td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <h3>Commission Processor</h3>
                                                </td>
                                             </tr>
                                           <tr>
                                                <td class="w_border">
                                                   <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                                      <tbody>
                                                         <tr>
                                                            <td width="30%"><b> Deposit Account:</b></td>
                                                       <td>
                                                                <select name="processor" class="form-control m-b">
                                                                 <option value="0">Select processor</option>
                                       {foreach key=obj item=name from=$processors}
                                                                  <option value="{$name.processor_id}" {if $member.processor eq "{$name.processor_id}"}selected="selected"{/if}>{$name.name}</option>{/foreach}


  <option value="Zelle">Zelle App</option>
  <option value="Cash">Cash App</option>
  
                                                     
                                                               </select>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b> Account Email :</b></td>
                                                            <td><input type="text" name="account_id" value="{$member.account_id}" class="form-control m-b" maxlength="150" /></td>       




</tr>
                                                      </tbody>
                                                   </table>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <h3>Tax Processing</h3>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="w_border">
                                                   <table cellpadding="2" cellspacing="0" border="0" width="90%">
                                                      <tbody>
                                                         <tr>


                                                  
                                                         <tr>
                                                            <td><b>Tax User :</b></td>
                                                            <td><input type="text" name="Tax_User" value="{$member.Tax_User }" class="form-control m-b" maxlength="30" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Tax Pass :</b></td>
                                                            <td><input type="text" name="Tax_Pass" value="{$member.Tax_Pass}" class="form-control m-b" maxlength="30" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Tax email :</b></td>
                                                            <td><input type="text" name="Tax_email" value="{$member.Tax_email}" class="form-control m-b" maxlength="30" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Tax Agency :</b></td>
                                                            <td><input type="text" name="Tax_Agency" value="{$member.Tax_Agency}" class="form-control m-b" maxlength="30" /></td>
                                                         </tr>
<tr>
                                                            <td><b>Link to Agencies:</b></td>
                                                            <td><a href="https://www.freetaxusa.com" target="_blank">FreeTaxUsa</a>&nbsp;&nbsp;   -&nbsp;&nbsp;   <a href="https://www.myfreetaxes.com/leaving">HRBlock</a>&nbsp;&nbsp;   -&nbsp;&nbsp;   <a href="https://www.turtotax.com"  target="_blank">TurboTax</a><br><br><a href="http://www.plusmoreusaeng.com/admin/members/"><font color="red">Back To  List</a></a></td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                </td>
                                             </tr>   
                                                   
                                             <tr>
                                                <td>
                                                   <h3>Comments</h3></center>
                                                </td>
                                             </tr>                                          
                                             <tr>
                                             <td class="w_border">
                                                <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                                   <tr>
                                                      <td  width="30%">
                                                      
                                                </td>
                                                <td id="notes">
                                                      <ol id="notelist" class="list-group">
                                                      {foreach key=obj item=note from=$notes }
                                                        <li class="list-group-item">{$note.note} <a class="deletenote" notid="{$note.id}" href="#" style="float: right;">X</a></li>
                                                      {/foreach} 

                                                      </ol>
                                                      <textarea id="textnote" class="form-control m-b"  ></textarea> 
                                                      <button id="savenote" type="button" class="btn btn-primary">Save Comments</button>
                                                </td> 
                                                   </tr>
                                                </table>
                                             </td>
                                               
                                             </tr>
                                             <tr>
                                                <td class="w_border">&nbsp;</td>
                                             </tr>                                            
                                             
                                             <tr>
                                                <td class="w_border">
                                                   <table border="0" cellspacing="0" cellpadding="2" align="center" width="100%">
                                                      <tbody>
                                                         <tr>
                                                            <td width="30%">&nbsp;</td>
                                                            <td align="left">
                                                               <input type="hidden"  name="member_id" value="{$member.member_id}" />
                                                               <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> <button type="button" class="btn btn-default" onclick="window.location.href='/admin/members'">Cancel</button>
                                                            </td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </form>
                                 </div>
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
   </div>
</div> 
         
{include file='footer_scripts.tpl'}
       <script >
   $(document).ready(function(){
      $('#savenote').click(function(event) {
         /* Act on the event */
               memberid = {$member_id} ;
               note=$('#textnote').val();
               url='/admin/memberlog/&memberid='+memberid+'&note='+note;
               $.get(url, function(data) {
                if (data=='ok') {
                  $('#notelist').append('<li class="list-group-item">'+note+'</li>').fadeIn('slow');
                  $('#textnote').val('');
                }
               });
      });

      $('.deletenote').click(function(event) {
         /* Act on the event */
         event.preventDefault()
               noteid = $(this).attr('notid') ;
               param={}
                param["noteid"] = noteid;
               url='/admin/memberlog/';
               parent=$(this).parent();
               $.post(url, param, function(data) {
                if (data=='ok') {
                  parent.remove()
                  $('#textnote').val('');
                }
               });
      });
     
   })
</script>
{include file='footer.tpl'}