<?php /* Smarty version Smarty-3.0.8, created on 2019-06-07 10:56:41
         compiled from "system/app/views/admin/members.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14602320495cfaa559c171a6-32375683%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2bfbc88870a808e3fb6781590ec63aa26c46a157' => 
    array (
      0 => 'system/app/views/admin/members.tpl',
      1 => 1517587831,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14602320495cfaa559c171a6-32375683',
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
                  <?php if ($_smarty_tpl->getVariable('welcome_sent')->value=='y'){?>
                  <div class="alert alert-success m-t">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                     <p><strong>Email Sent.</strong> Welcome email was sent to member.</p>
                  </div>
                  <?php }?>  
                  <?php if ($_REQUEST['msg']=='10'){?>
                  <div class="alert alert-success m-t">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                     <p><strong>Update Succesfully.</strong> User Information was saved in database.</p>
                  </div>
                  <?php }?>  
                  <?php if ($_smarty_tpl->getVariable('member_deleted')->value=='y'){?>
                  <div class="alert alert-success m-t">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                     <p><strong>Member Deleted.</strong> Member Deleted.</p>
                  </div>
                  <?php }?>
                  <?php if ($_smarty_tpl->getVariable('member_dissabled')->value=='y'){?>
                  <div class="alert alert-success m-t">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                     <p><strong>Member Dissabled.</strong> Member Disabled.</p>
                  </div>
                  <?php }?>
                  <div class="actions">
                     <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
                        <tr>
                           <td align='right'>
                              <form action="#" method="post" class="validate-form form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <div class="form-field clear">                    
                                          <strong>Filter:</strong> <?php echo $_smarty_tpl->getVariable('select')->value;?>
&nbsp;&nbsp;&nbsp;&nbsp; <strong>Search:</strong>
                                          <input type="text" name="s_line" value="<?php echo $_REQUEST['s_line'];?>
" style="width:200px;" class='form-select form-control b-m'>
                                          <br /> <br />
                                       </div>
                                       <div class="form-field clear">                    
                                          <strong><?php echo $_smarty_tpl->getVariable('dates')->value;?>
</strong>&nbsp;
                                          <input type="submit" name="submit" value=" Search ">
                                       </div>
                                       <input type="hidden" name="filter" value="1">
                                    </div>
                                 </div>
                              </form>
                           </td>
                        </tr>
                     </table>
                  </div>
                  <table id="transaction" class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_MEMBER_ID'];?>
</th>
                           <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_USERNAME'];?>
</th>
                           <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_FIRST_NAME'];?>
</th>
                           <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_LAST_NAME'];?>
</th>
                           <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_EMAIL'];?>
</th>
                           <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_SPONSOR'];?>
</th>
                           <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_LEVEL'];?>
</th>
                           <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_EARNINGS'];?>
</th>
                           <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_MEMBERSHIP'];?>
</th>
                           <th><?php echo $_smarty_tpl->getVariable('header')->value['HEAD_ACTIVE'];?>
</th>
                           <th align="center"><b>Actions</b></th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('members')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>                        
                        <tr>
                           <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
</td>
                           <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_USERNAME'];?>
</td>
                           <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_FIRST_NAME'];?>
</td>
                           <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_LAST_NAME'];?>
</td>
                           <td><a href="<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_EMAIL'];?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_EMAIL'];?>
</a>&nbsp;</td>
                           <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_SPONSOR'];?>
</td>
                           <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_LEVEL'];?>
</td>
                           <td>$<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_EARNINGS'];?>
</td>
                           <td><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['name']->value['MEMBERSHIP'],"_"," ");?>
</td>
                           <td><?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_ACTIVE'];?>
</td>
                           <td>
                              <!--  <?php if ($_smarty_tpl->tpl_vars['name']->value['ROW_LEVEL']=="Unpaid"){?>
                                 <a href="#myModal<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
" data-toggle="modal" data-target="#myModal<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
" class="label modal-link"><img src="/assets/admin/images/ico_shopping_16_off.png" class="icon16 fl-space1" alt="pay" title="pay" /></a>
                                 <?php }else{ ?>
                                 <a href="#myModalup<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
" data-toggle="modal" data-target="#myModalup<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
" class="label modal-link"><img src="/assets/admin/images/ico_shopping_16_disabled.png" class="icon16 fl-space1" /></a>
                                 <?php }?> -->
                              <a href="<?php if (count($_SESSION['plan'])>1){?>#<?php }else{ ?>/admin/viewnetwork/&id=<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
<?php }?>" <?php if (count($_SESSION['plan'])>1){?>data-toggle="modal" data-target="#myModal<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
"<?php }else{ ?><?php }?>><i class="pe-7s-network" title="View network"></i></a>
                              <a href="/admin/editmember/&id=<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
"><i class="fa fa-edit" title="Edit" style="padding: 4px;"></i></a>
                              <a href="/admin/messages/&member=<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
"><i class="fa pe-7s-mail" title="Message this member" style="padding: 4px;"></i></a>
                              <a href="/admin/transactions/&member_id=<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
"><i class="fa fa-money" title="View transactions" style="padding: 4px;"></i></a>
                              <a href="/admin/loginmember/&id=<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
" target="_blank"><i class="fa fa-unlock-alt" title="Login to member panel" style="padding: 4px;"></i></a>
                              <a href="/admin/members/&banid=<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
" onClick="return confirm ('Do you really want to ban this member?');"><i class="fa pe-7s-delete-user" title="Ban member" style="padding: 4px;"></i></a>
                           </td>
                        </tr>
                        <div class="modal fade" id="myModal<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="color-line"></div>
                                    <div class="modal-header text-center">
                                        <h4 class="modal-title">Network Selection</h4>
                                        <small class="font-bold">Select which network you like to view from member.</small>
                                    </div>
                                    <div class="modal-body">
                                    <?php $_smarty_tpl->tpl_vars['plans'] = new Smarty_variable($_smarty_tpl->getVariable('hooks')->value->apply_filters('view_network'), null, null);?>
                                    <center>
                                        <p>
                                        	<?php  $_smarty_tpl->tpl_vars['plan'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('plans')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['plan']->key => $_smarty_tpl->tpl_vars['plan']->value){
?>
                                            	<a href="<?php echo $_smarty_tpl->tpl_vars['plan']->value['url'];?>
/&id=<?php echo $_smarty_tpl->tpl_vars['name']->value['ROW_MEMBER_ID'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['plan']->value['name'];?>
</a> &nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php }} ?>
                                        	
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
                        <?php }} ?>
                        <?php echo $_smarty_tpl->getVariable('header')->value['PAGINATION'];?>

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
<?php $_template = new Smarty_Internal_Template('footer_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>