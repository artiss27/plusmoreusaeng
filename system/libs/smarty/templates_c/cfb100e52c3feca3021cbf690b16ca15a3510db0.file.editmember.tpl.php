<?php /* Smarty version Smarty-3.0.8, created on 2019-06-07 10:03:18
         compiled from "system/app/views/admin/editmember.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20567892195cfa98d62031b5-63858459%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfb100e52c3feca3021cbf690b16ca15a3510db0' => 
    array (
      0 => 'system/app/views/admin/editmember.tpl',
      1 => 1552970172,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20567892195cfa98d62031b5-63858459',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/hermes/walnaweb10a/b1543/pow.plusmoreusaengcom/htdocs/system/libs/smarty/plugins/modifier.replace.php';
?>﻿<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
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
               <?php if ($_SESSION['message']){?>
               <p class="alert alert-success">
                  <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('message'), null, null);?>
                  <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

               </p>
               <br />
               <?php }?> 
               <?php if ($_SESSION['error']){?>
               <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('error'), null, null);?>            	
               <?php if (is_array($_smarty_tpl->getVariable('message_var')->value)){?>
               <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('message_var')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
               <p class="alert alert-danger">
                  <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

               </p>
               <br />
               <?php }} ?> 
               <?php }else{ ?>
               <p class="alert alert-danger">
                  <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

               </p>
               <br />
               <?php }?>
               <?php }?>  
               <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
               <div class="alert alert-success">
                  <p><strong><?php echo $_smarty_tpl->tpl_vars['error']->key;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
               </div>
               <?php }} ?> 
               <h2 class="font-light m-b-xs">
                  Edit Member
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                     <?php if ($_smarty_tpl->getVariable('member_edited')->value=='y'){?>
                     <div class="alert alert-success">
                        <p><strong>Member Edited:</strong> Member was edited succesfully to database.</p>
                     </div>
                     <?php }?>  
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <table width="100%" border="0" cellspacing="1" cellpadding="1" class="m-t m-b">
                                 <tr>
                                    <td>Member ID</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('member_id')->value;?>
</a></td>
                                    <td>Total Sponsored</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('total_sponsored')->value;?>
</a></td>
                                    <td>Sponsored Today</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('sponsored_today')->value;?>
</a></td>
                                 </tr>
                                 <tr>
                                    <td>Username</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('username')->value;?>
</a></td>
                                    <td></td>
                                    <td></td>
                                    <td>Sponsored This Week</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('sponsored_this_week')->value;?>
</a></td>
                                 </tr>
                                 <tr>
                                    <td>Membership</td>
                                    <td><a href="#"><?php echo smarty_modifier_replace($_smarty_tpl->getVariable('membership')->value,"_"," ");?>
</a></td>
                                    <td>Total Pending</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('total_pending')->value;?>
</a></td>
                                    <td>Sponsored Last Week</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('sponsored_last_week')->value;?>
</a></td>
                                 </tr>
                                 <tr>
                                    <td>Reg. Date</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('reg_date')->value;?>
</a></td>
                                    <td>Money Available</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('money_available')->value;?>
</a></td>
                                    <td>Sponsored This Month</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('sponsored_this_month')->value;?>
</a></td>
                                 </tr>
                                 <tr>
                                    <td>Total Money Earned</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('money_earned')->value;?>
</a></td>
                                    <td>Referral Url Hits</td>
                                    <td><a href="#"><?php echo $_smarty_tpl->getVariable('referal_hits')->value;?>
</a></td>
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
                                                            <td><input type="text" name="firstName" value="<?php echo $_smarty_tpl->getVariable('member')->value['first_name'];?>
" maxlength="120" class="form-control" />
                                                               &nbsp; <span class="error"></span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Last name :</b></td>
                                                            <td><input type="text" name="lastName" value="<?php echo $_smarty_tpl->getVariable('member')->value['last_name'];?>
" maxlength="120" class="form-control" />
                                                               &nbsp; <span class="error"></span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>E-mail :</b></td>
                                                            <td><input type="text" name="email" value="<?php echo $_smarty_tpl->getVariable('member')->value['email'];?>
" maxlength="120" class="form-control" />
                                                               &nbsp; <span class="error"></span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Sponsor ID : </b></td>
                                                            <td><input type="text" name="sponsor" value="<?php echo $_smarty_tpl->getVariable('member')->value['sponsor_id'];?>
" maxlength="12" class="form-control" />
                                                            <small>Sponsor ID must always be a lower ID than Member ID (Only change if using Unilevel system)</small>
                                                               &nbsp; <span class="error"></span>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Membership :</b></td>
                                                            <td><input type="text" name="membership" value="<?php echo smarty_modifier_replace($_smarty_tpl->getVariable('member')->value['membership'],"_"," ");?>
" maxlength="12" class="form-control" />
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
                                                            <td><input type="text" name="username" value="<?php echo $_smarty_tpl->getVariable('member')->value['username'];?>
" maxlength="120" class="form-control" />
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
                                                            <td><input type="text" name="street" value="<?php echo $_smarty_tpl->getVariable('member')->value['street'];?>
" class="form-control m-b" maxlength="50" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>City :</b></td>
                                                            <td><input type="text" name="city" value="<?php echo $_smarty_tpl->getVariable('member')->value['city'];?>
" class="form-control m-b" maxlength="50" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>State :</b></td>
                                                            <td><input type="text" name="state" value="<?php echo $_smarty_tpl->getVariable('member')->value['state'];?>
" class="form-control m-b" maxlength="50" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Country Code:</b></td>
                                                            <td><input type="text" name="country" value="<?php echo $_smarty_tpl->getVariable('member')->value['country'];?>
" class="form-control m-b" maxlength="50" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Postal Code :</b></td>
                                                            <td><input type="text" name="postal" value="<?php echo $_smarty_tpl->getVariable('member')->value['postal'];?>
" class="form-control m-b" maxlength="50" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Phone :</b></td>
                                                            <td><input type="text" name="phone" value="<?php echo $_smarty_tpl->getVariable('member')->value['phone'];?>
" class="form-control m-b" maxlength="50" /></td>
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
                                       <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('processors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                                                                  <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value['processor_id'];?>
" <?php if ($_smarty_tpl->getVariable('member')->value['processor']==($_smarty_tpl->tpl_vars['name']->value['processor_id'])){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['name']->value['name'];?>
</option><?php }} ?>


  <option value="Zelle">Zelle App</option>
  <option value="Cash">Cash App</option>
  
                                                     
                                                               </select>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td><b> Account Email :</b></td>
                                                            <td><input type="text" name="account_id" value="<?php echo $_smarty_tpl->getVariable('member')->value['account_id'];?>
" class="form-control m-b" maxlength="150" /></td>       




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
                                                            <td><input type="text" name="Tax_User" value="<?php echo $_smarty_tpl->getVariable('member')->value['Tax_User'];?>
" class="form-control m-b" maxlength="30" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Tax Pass :</b></td>
                                                            <td><input type="text" name="Tax_Pass" value="<?php echo $_smarty_tpl->getVariable('member')->value['Tax_Pass'];?>
" class="form-control m-b" maxlength="30" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Tax email :</b></td>
                                                            <td><input type="text" name="Tax_email" value="<?php echo $_smarty_tpl->getVariable('member')->value['Tax_email'];?>
" class="form-control m-b" maxlength="30" /></td>
                                                         </tr>
                                                         <tr>
                                                            <td><b>Tax Agency :</b></td>
                                                            <td><input type="text" name="Tax_Agency" value="<?php echo $_smarty_tpl->getVariable('member')->value['Tax_Agency'];?>
" class="form-control m-b" maxlength="30" /></td>
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
                                                      <?php  $_smarty_tpl->tpl_vars['note'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('notes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['note']->key => $_smarty_tpl->tpl_vars['note']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['note']->key;
?>
                                                        <li class="list-group-item"><?php echo $_smarty_tpl->tpl_vars['note']->value['note'];?>
 <a class="deletenote" notid="<?php echo $_smarty_tpl->tpl_vars['note']->value['id'];?>
" href="#" style="float: right;">X</a></li>
                                                      <?php }} ?> 

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
                                                               <input type="hidden"  name="member_id" value="<?php echo $_smarty_tpl->getVariable('member')->value['member_id'];?>
" />
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
         
<?php $_template = new Smarty_Internal_Template('footer_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
       <script >
   $(document).ready(function(){
      $('#savenote').click(function(event) {
         /* Act on the event */
               memberid = <?php echo $_smarty_tpl->getVariable('member_id')->value;?>
 ;
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
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>