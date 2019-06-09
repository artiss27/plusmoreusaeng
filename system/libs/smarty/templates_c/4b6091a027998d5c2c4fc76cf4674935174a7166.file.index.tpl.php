<?php /* Smarty version Smarty-3.0.8, created on 2019-06-07 10:37:50
         compiled from "system/app/views/members/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18345543345cfaa0eec434f4-73933452%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4b6091a027998d5c2c4fc76cf4674935174a7166' => 
    array (
      0 => 'system/app/views/members/index.tpl',
      1 => 1549757076,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18345543345cfaa0eec434f4-73933452',
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
<!-- Main Wrapper -->
<div id="wrapper">
<div class="content animate-panel">
   <!-- START -->
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
   <div class="row">
      <div class="col-lg-12 text-center m-t-md"><img src="/media/images/PMUhighlighted.png" alt="PlusMoreUsa" style="width:200px;height:150px;"><br><br>
       
         <p><font size="6" color="#1a51b6">Bienvenido A Tu BackOffice</font> <br> <font size="5" color="green">Welcome To Your BackOffice</font> <br> <font size="6" color="black"><?php echo $_SESSION['name'];?>
</font>
         </p>
      </div>
      
      <div class="row" >
         <div class="col-lg-12">
            <div class="hpanel">
               <div class="panel-body">
                  <div class="text-muted">
                     <div class="form-inline">
                        <?php if ($_SESSION['plan']['cycler']==1&&$_smarty_tpl->getVariable('membership')->value==$_smarty_tpl->getVariable('lang')->value['free_membership']){?><strong>Upgrade your membership to earn more!</strong><?php }else{ ?><BR><center><input type="text" class="form-control" value="<?php echo $_SESSION['local_url'];?>
?u=<?php echo $_SESSION['username'];?>
" style="width:60%"><br><font size="4">Invita a otros usando tu enlace directo:</font><BR>
<font size="2" color="green">INVITE OTHERS USING YOUR DIRECT LINK:</font></center><br>

<!--<font style=with:60%"><center>PARA SER EL PROMOTOR DE OTROS QUE SE REGISTREN GRATIS Y OBTENER COMISIONES CUANDO ESTOS OBTIENEN SERVICIOS DE PLUSMOREUSA<br> COPIA Y PEGA ESTE ENLACE EN TUS COMUNICACIONES Y APARECERAS COMO QUIEN LOS INVITO</font><br><BR></font><br><center><font size="4" color="black">SI QUIERES SABER MÁS CÓMO CONVERTIR TU MEMBRESÍA EN UN NEGOCIO LUCRATIVO</center></font><BR><font size="4" color="black">Click </font><a href="https://www.plusmoreusaeng.com/site/business"><font size="3" color="red">Here </font></a><font size="4" color="black"> to Learn More </center></font>--><?php }?>
                     </strong></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
  <!-- <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('extra_dashboard_head');?>
-->
      
      <div class="hpanel forum-box">
         <div class="panel-heading">
            <span class="pull-right">
            <i class="fa fa-clock-o"> </i> Ver Todos Los Anuncios: <?php echo $_smarty_tpl->getVariable('news')->value[0]['date'];?>

            </span>
            NOTICIAS IMPORTANTES - <a href="/members/announcements">Ver Las Ultimas <br> <font size="2" color="green">Important News- <a href="/members/announcements">View The Lattest</font></a>
         </div>
         <?php if (!$_smarty_tpl->getVariable('news')->value){?>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-10 forum-heading">
                  No Se Han Hechos Anuncios.
               </div>
            </div>
         </div>
         <?php }else{ ?>
         <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('news')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-10 forum-heading">
                  <?php if (strtotime($_smarty_tpl->tpl_vars['name']->value['date'])>time()-60*60*24){?><span class="label label-warning pull-left">New</span><?php }?>
                  <a href="/members/announcement/&id=<?php echo $_smarty_tpl->tpl_vars['name']->value['id'];?>
" >
                     <h4><?php echo $_smarty_tpl->tpl_vars['name']->value['title'];?>
</h4>
                  </a>
                  <div class="desc"><?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::shortDescription($_smarty_tpl->tpl_vars['name']->value['body'],100), null, null);?>
                     <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

                  </div>
               </div>
            </div>
         </div>
         <?php }} ?>
         <?php }?>
      </div>
      <div class="row">
         <div class="col-md-4">
            <div class="hpanel hyellow">
               <div class="panel-heading">
                  <div class="panel-tools">
                     <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  </div>
                 TU INFORMACION <br> <font size="2" color="green">Your Information</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Tu ID de Miembro <br>  <font size="2" color="green">Your Member ID</font></span>
                              </td>
                              <td><a href="/members/profile"><?php echo $_SESSION['member_id'];?>
</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Tu Usuario<br><font size="2" color="green">Your Username</font></span>
                              </td>
                              <td><a href="/members/profile"><?php echo $_SESSION['username'];?>
</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Tu Membresia<br><font size="2" color="green">Your Membership</font></span>
                              </td>
                              <td><a href="/members/upgrademembership"><?php echo smarty_modifier_replace($_smarty_tpl->getVariable('membership')->value,"_"," ");?>
</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Fecha de Registro<br><font size="2" color="green">Your Signup Date</font></span>
                              </td>
                              <td><?php echo $_SESSION['reg_date'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Tu Promotor<br><font size="2" color="green">Your SponsorTu Promotor</font></span>
                              </td>
                              <td><a href="/members/messages/&sponsor=1"><?php echo $_SESSION['sponsor'];?>
</a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="hpanel hgreen">
               <div class="panel-heading">
                 <div class="panel-tools">
                     <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  </div>
                 ESTADISTICAS DE INVITACION <br><font size="2" color="green"> Guests Statistics</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Tus Invitados<br><font size="2" color="green">Your Guests</font></span>
                              </td>
                              <td><a href="/members/referrers"><?php echo $_smarty_tpl->getVariable('total_sponsored')->value;?>
</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Invitados Pagados<br><font size="2" color="green">Paid Guests</font></span>
                              </td>
                              <td><a href="/members/referrers"><?php echo $_smarty_tpl->getVariable('total_paid')->value;?>
</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Invitados Pendientes <br><font size="2" color="green">Pending Guests</font></span>
                              </td>
                              <td><a href="/members/pendingreferrers"><?php echo $_smarty_tpl->getVariable('total_sponsored')->value-$_smarty_tpl->getVariable('total_paid')->value;?>
</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Visitas a tu URL<br><font size="2" color="green">Hits to Your URL</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('referral_hits')->value;?>
</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="hpanel hred">
               <div class="panel-heading">
                  <div class="panel-tools">
                     <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  </div>
                TU DINERO <br> <font size="2" color="green">Your Money</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Comisiones<br><font size="2" color="green">Comissions</font></span>
                              </td>
                              <td><a href="/members/depositwallet"><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
 <?php echo $_smarty_tpl->getVariable('wallet_deposit')->value;?>
</a></td>
                           </tr>
                          <!-- <tr>
                              <td>
                                 <span class="text-info font-bold">Referral Account</span>
                              </td>
                              <td><a href="/members/payoutwallet"><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
 <?php echo number_format($_smarty_tpl->getVariable('wallet_payout')->value,2,'.','');?>
</a></td>
                           </tr>-->                           
                           <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('extra_wallets_dashboard');?>

                           <tr>
                              <td>
                                 <span class="text-info font-bold">Retiros Pendientes <br><font size="2" color="green">Pending Withdrawals</font></span>
                              </td>
                              <td><a href="/members/withdrawals"><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
 <?php echo $_smarty_tpl->getVariable('pending_withdrawal')->value;?>
</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Retiros Completados<br><font size="2" color="green">Completed Withdrawals</font></span>
                              </td>
                              <td><a href="/members/withdrawals"><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
 <?php echo $_smarty_tpl->getVariable('money_withdrawed')->value;?>
</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold"> Commisiones Ganadas Total<br><font size="2" color="green">Total Earned Comissions</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
 <?php echo number_format($_smarty_tpl->getVariable('money_earned')->value,2,'.','');?>
</td>
                           </tr>
                        <!--   <tr>
                              <td>
                                 <span class="text-info font-bold"><?php echo $_smarty_tpl->getVariable('lang')->value['total_ad_credits'];?>
</span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('ad_credits')->value;?>
</td>
                           </tr>-->
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-3">
            <div class="hpanel hblue">
               <div class="panel-heading">
                  <div class="panel-tools">
                     <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  </div>
                  Numeros de Hoy<br><font size="2" color="green">Today Stats</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Invitados Pagados<br><font size="2" color="green">Paid Guests</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('today')->value['paid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('today')->value['unpaid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('today')->value['referral_url_hits'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Money Earned <br><font size="2" color="green">Dinero Ganado</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
  <?php echo $_smarty_tpl->getVariable('today')->value['money_earned'];?>
</td>
                           </tr>
                           <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('today_stats');?>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="hpanel hyellow">
               <div class="panel-heading">
                  <div class="panel-tools">
                     <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  </div>
                  Numeros de Ayer<br><font size="2" color="green"><?php echo $_smarty_tpl->getVariable('lang')->value['yesterday_stats'];?>
</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Invitados Pagados<br><font size="2" color="green">Paid Guests</font>
</span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('yesterday')->value['paid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('yesterday')->value['unpaid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('yesterday')->value['referral_url_hits'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
  <?php echo $_smarty_tpl->getVariable('yesterday')->value['money_earned'];?>
</td>
                           </tr>
                           <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('yesterday_stats');?>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="hpanel hviolet">
               <div class="panel-heading">
                  <div class="panel-tools">
                     <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  </div>
                  <?php echo $_smarty_tpl->getVariable('lang')->value['this_week_stats'];?>
<br><font size="2" color="green">Numeros esta Semana</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Paid Guests<br><font size="2" color="green">Invitados Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('this_week')->value['paid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('this_week')->value['unpaid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('this_week')->value['referral_url_hits'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
  <?php echo $_smarty_tpl->getVariable('this_week')->value['money_earned'];?>
</td>
                           </tr>
                           <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('this_week_stats');?>

                        </tbody>
        </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="hpanel hreddeep">
               <div class="panel-heading">
                  <div class="panel-tools">
                     <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  </div>
                  Last Week Stats <br><font size="2" color="green">Numeros de la Semana Pasada</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Paid Guests<br><font size="2" color="green">Invitados Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_week')->value['paid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_week')->value['unpaid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_week')->value['referral_url_hits'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
  <?php echo $_smarty_tpl->getVariable('last_week')->value['money_earned'];?>
</td>
                           </tr>
                           <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('last_week_stats');?>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
    <div class="row">
         <div class="col-md-3">
            <div class="hpanel hblue">
               <div class="panel-heading">
                  <div class="panel-tools">
                     <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  </div>
                  <?php echo $_smarty_tpl->getVariable('lang')->value['this_month_stats'];?>
<br><font size="2" color="green">Numeros este Mes</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Paid Guests<br><font size="2" color="green">Invitados Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('this_month')->value['paid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('this_month')->value['unpaid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('this_month')->value['referral_url_hits'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
  <?php echo $_smarty_tpl->getVariable('this_month')->value['money_earned'];?>
</td>
                           </tr>
                           <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('this_month_stats');?>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="hpanel hyellow">
               <div class="panel-heading">
                  <div class="panel-tools">
                     <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  </div>
                  <?php echo $_smarty_tpl->getVariable('lang')->value['last_month_stats'];?>
<br><font size="2" color="green">Numero el Pasado Mes</font></font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Paid Guests<br><font size="2" color="green">Invitados Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_month')->value['paid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_month')->value['unpaid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_month')->value['referral_url_hits'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
  <?php echo $_smarty_tpl->getVariable('last_month')->value['money_earned'];?>
</td>
                           </tr>
                           <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('last_month_stats');?>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="hpanel hviolet">
               <div class="panel-heading">
                  <div class="panel-tools">
                     <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  </div>
                  <?php echo $_smarty_tpl->getVariable('lang')->value['last_six_months_stats'];?>
<br><font size="2" color="green">Numeros en los Ultimos 6 Meses</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Paid Guests<br><font size="2" color="green">Invitados Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_six_months')->value['paid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_six_months')->value['unpaid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_six_months')->value['referral_url_hits'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
  <?php echo $_smarty_tpl->getVariable('last_six_months')->value['money_earned'];?>
</td>
                           </tr>
                           <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('last_six_months_stats');?>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="hpanel hreddeep">
               <div class="panel-heading">
                  <div class="panel-tools">
                     <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                  </div>
                  <?php echo $_smarty_tpl->getVariable('lang')->value['last_year_stats'];?>
<br><font size="2" color="green">Numeros el A&ntilde;o Pasado</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Paid Guests<br><font size="2" color="green">Invitados Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_year')->value['paid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_year')->value['unpaid_referrers'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('last_year')->value['referral_url_hits'];?>
</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td><?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
  <?php echo $_smarty_tpl->getVariable('last_year')->value['money_earned'];?>
</td>
                           </tr>
                           <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('last_year_stats');?>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>  
      
      
   </div>
   <!-- END -->       
</div>
<!-- Right sidebar -->
<?php $_template = new Smarty_Internal_Template('right_sidebar.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>   
<!-- Vendor scrits -->
<?php $_template = new Smarty_Internal_Template('vendor_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?> 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>

<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>