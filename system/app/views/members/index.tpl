{include file='header.tpl'}
{include file='menu.tpl'}
<!-- Main Wrapper -->
<div id="wrapper">
<div class="content animate-panel">
   <!-- START -->
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
   <div class="row">
      <div class="col-lg-12 text-center m-t-md"><img src="/media/images/PMUhighlighted.png" alt="PlusMoreUsa" style="width:200px;height:150px;"><br><br>
       
         <p><font size="6" color="#1a51b6">Bienvenido A Tu BackOffice</font> <br> <font size="5" color="green">Welcome To Your BackOffice</font> <br> <font size="6" color="black">{$smarty.session.name}</font>
         </p>
      </div>
      
      <div class="row" >
         <div class="col-lg-12">
            <div class="hpanel">
               <div class="panel-body">
                  <div class="text-muted">
                     <div class="form-inline">
                        {if $smarty.session.plan.cycler == 1 && $membership == $lang.free_membership}<strong>Upgrade your membership to earn more!</strong>{else}<BR><center>
                         <input type="text" class="form-control" value="{$smarty.session.local_url}site/{$smarty.session.username}" style="width:60%">
<!--                         <input type="text" class="form-control" value="{$smarty.session.local_url}?u={$smarty.session.username}" style="width:60%">-->
                         <br><font size="4">Invita a otros usando tu enlace directo:</font><BR>
<font size="2" color="green">INVITE OTHERS USING YOUR DIRECT LINK:</font></center><br>

<!--<font style=with:60%"><center>PARA SER EL PROMOTOR DE OTROS QUE SE REGISTREN GRATIS Y OBTENER COMISIONES CUANDO ESTOS OBTIENEN SERVICIOS DE PLUSMOREUSA<br> COPIA Y PEGA ESTE ENLACE EN TUS COMUNICACIONES Y APARECERAS COMO QUIEN LOS INVITO</font><br><BR></font><br><center><font size="4" color="black">SI QUIERES SABER MÁS CÓMO CONVERTIR TU MEMBRESÍA EN UN NEGOCIO LUCRATIVO</center></font><BR><font size="4" color="black">Click </font><a href="https://www.plusmoreusaeng.com/site/business"><font size="3" color="red">Here </font></a><font size="4" color="black"> to Learn More </center></font>-->{/if}
                     </strong></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
   {$hooks->do_action('extra_dashboard_head')}
      
      <div class="hpanel forum-box">
         <div class="panel-heading">
            <span class="pull-right">
            <i class="fa fa-clock-o"> </i> Ver Todos Los Anuncios: {$news.0.date}
            </span>
            NOTICIAS IMPORTANTES - <a href="/members/announcements">Ver Las Ultimas <br> <font size="2" color="green">Important News- <a href="/members/announcements">View The Lattest</font></a>
         </div>
         {if  !$news}
         <div class="panel-body">
            <div class="row">
               <div class="col-md-10 forum-heading">
                  No Se Han Hechos Anuncios.
               </div>
            </div>
         </div>
         {else}
         {foreach key=obj item=name from=$news}
         <div class="panel-body">
            <div class="row">
               <div class="col-md-10 forum-heading">
                  {if $name.date|strtotime > $smarty.now - 60*60*24}<span class="label label-warning pull-left">New</span>{/if}
                  <a href="/members/announcement/&id={$name.id}" >
                     <h4>{$name.title}</h4>
                  </a>
                  <div class="desc">{assign var=message_var value=CoreHelp::shortDescription($name.body, 100)}
                     {$message_var}
                  </div>
               </div>
            </div>
         </div>
         {/foreach}
         {/if}
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
                              <td><a href="/members/profile">{$smarty.session.member_id}</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Tu Usuario<br><font size="2" color="green">Your Username</font></span>
                              </td>
                              <td><a href="/members/profile">{$smarty.session.username}</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Tu Membresia<br><font size="2" color="green">Your Membership</font></span>
                              </td>
                              <td><a href="/members/upgrademembership">{$membership|replace:"_":" "}</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Fecha de Registro<br><font size="2" color="green">Your Signup Date</font></span>
                              </td>
                              <td>{$smarty.session.reg_date}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Tu Promotor<br><font size="2" color="green">Your SponsorTu Promotor</font></span>
                              </td>
                              <td><a href="/members/messages/&sponsor=1">{$smarty.session.sponsor}</a></td>
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
                              <td><a href="/members/referrers">{$total_sponsored}</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Invitados Pagados<br><font size="2" color="green">Paid Guests</font></span>
                              </td>
                              <td><a href="/members/referrers">{$total_paid}</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Invitados Pendientes <br><font size="2" color="green">Pending Guests</font></span>
                              </td>
                              <td><a href="/members/pendingreferrers">{$total_sponsored - $total_paid}</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Visitas a tu URL<br><font size="2" color="green">Hits to Your URL</font></span>
                              </td>
                              <td>{$referral_hits}</td>
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
                              <td><a href="/members/depositwallet">{$lang.monetary} {$wallet_deposit}</a></td>
                           </tr>
                          <!-- <tr>
                              <td>
                                 <span class="text-info font-bold">Referral Account</span>
                              </td>
                              <td><a href="/members/payoutwallet">{$lang.monetary} {$wallet_payout|number_format:2:'.':''}</a></td>
                           </tr>-->                           
                           {$hooks->do_action('extra_wallets_dashboard')}
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Retiros Pendientes <br><font size="2" color="green">Pending Withdrawals</font></span>
                              </td>
                              <td><a href="/members/withdrawals">{$lang.monetary} {$pending_withdrawal}</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Retiros Completados<br><font size="2" color="green">Completed Withdrawals</font></span>
                              </td>
                              <td><a href="/members/withdrawals">{$lang.monetary} {$money_withdrawed}</a></td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold"> Commisiones Ganadas Total<br><font size="2" color="green">Total Earned Comissions</font></span>
                              </td>
                              <td>{$lang.monetary} {$money_earned|number_format:2:'.':''}</td>
                           </tr>
                        <!--   <tr>
                              <td>
                                 <span class="text-info font-bold">{$lang.total_ad_credits}</span>
                              </td>
                              <td>{$ad_credits}</td>
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
                              <td>{$today.paid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td>{$today.unpaid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></font></span>
                              </td>
                              <td>{$today.referral_url_hits}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Money Earned <br><font size="2" color="green">Dinero Ganado</font></span>
                              </td>
                              <td>{$lang.monetary}  {$today.money_earned}</td>
                           </tr>
                           {$hooks->do_action('today_stats')}
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
                  Numeros de Ayer<br><font size="2" color="green">{$lang.yesterday_stats}</font>
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
                              <td>{$yesterday.paid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td>{$yesterday.unpaid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$yesterday.referral_url_hits}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$lang.monetary}  {$yesterday.money_earned}</td>
                           </tr>
                           {$hooks->do_action('yesterday_stats')}
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
                  {$lang.this_week_stats}<br><font size="2" color="green">Numeros esta Semana</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Paid Guests<br><font size="2" color="green">Invitados Pagados</font></span>
                              </td>
                              <td>{$this_week.paid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td>{$this_week.unpaid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$this_week.referral_url_hits}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$lang.monetary}  {$this_week.money_earned}</td>
                           </tr>
                           {$hooks->do_action('this_week_stats')}
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
                              <td>{$last_week.paid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td>{$last_week.unpaid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$last_week.referral_url_hits}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$lang.monetary}  {$last_week.money_earned}</td>
                           </tr>
                           {$hooks->do_action('last_week_stats')}
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
                  {$lang.this_month_stats}<br><font size="2" color="green">Numeros este Mes</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Paid Guests<br><font size="2" color="green">Invitados Pagados</font></span>
                              </td>
                              <td>{$this_month.paid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td>{$this_month.unpaid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$this_month.referral_url_hits}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$lang.monetary}  {$this_month.money_earned}</td>
                           </tr>
                           {$hooks->do_action('this_month_stats')}
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
                  {$lang.last_month_stats}<br><font size="2" color="green">Numero el Pasado Mes</font></font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Paid Guests<br><font size="2" color="green">Invitados Pagados</font></span>
                              </td>
                              <td>{$last_month.paid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td>{$last_month.unpaid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$last_month.referral_url_hits}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$lang.monetary}  {$last_month.money_earned}</td>
                           </tr>
                           {$hooks->do_action('last_month_stats')}
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
                  {$lang.last_six_months_stats}<br><font size="2" color="green">Numeros en los Ultimos 6 Meses</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Paid Guests<br><font size="2" color="green">Invitados Pagados</font></span>
                              </td>
                              <td>{$last_six_months.paid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td>{$last_six_months.unpaid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$last_six_months.referral_url_hits}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$lang.monetary}  {$last_six_months.money_earned}</td>
                           </tr>
                           {$hooks->do_action('last_six_months_stats')}
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
                  {$lang.last_year_stats}<br><font size="2" color="green">Numeros el A&ntilde;o Pasado</font>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Paid Guests<br><font size="2" color="green">Invitados Pagados</font></span>
                              </td>
                              <td>{$last_year.paid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">Unpaid Guests<br><font size="2" color="green">Invitados No Pagados</font></span>
                              </td>
                              <td>{$last_year.unpaid_referrers}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$last_year.referral_url_hits}</td>
                           </tr>
                           <tr>
                              <td>
                                 <span class="text-info font-bold">URS Hits<br><font size="2" color="green">Visitas por tu Enlance</font></span>
                              </td>
                              <td>{$lang.monetary}  {$last_year.money_earned}</td>
                           </tr>
                           {$hooks->do_action('last_year_stats')}
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
{include file='right_sidebar.tpl'}   
<!-- Vendor scrits -->
{include file='vendor_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>

{include file='footer.tpl'}