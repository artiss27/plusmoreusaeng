<?php /* Smarty version Smarty-3.0.8, created on 2019-06-07 10:37:51
         compiled from "system/app/views/members/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3715764765cfaa0ef1e68e0-07930929%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '454ab10992afa01f0e70ceeaaa5113cb524310ea' => 
    array (
      0 => 'system/app/views/members/menu.tpl',
      1 => 1557999070,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3715764765cfaa0ef1e68e0-07930929',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- Navigation -->
<aside id="menu">
   <div id="navigation">
      <div class="profile-picture">
         <a href="/members">
         <?php $_smarty_tpl->tpl_vars['pic'] = new Smarty_variable(CoreHelp::getProfilePic($_SESSION['gender']), null, null);?>
         <img alt="logo" id="avatar" class="img-circle m-b" src="<?php echo $_smarty_tpl->getVariable('pic')->value;?>
">
         </a>
         <div class="stats-label text-color">
            <span class="font-extra-bold font-uppercase"><?php echo $_SESSION['name'];?>
</span>



            <div class="dropdown">
               <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                   <small class="text-muted">Quick/Rapidos<b class="caret"></b></small>
               </a>
               <ul class="dropdown-menu animated fadeInRight m-t-xs">
                 
                  <!-- <li<?php if ($_SESSION['menu']['sub']=='inbox'){?> class="active"<?php }?>><a href="/members/messages">Email</a></li>
               <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('menu_messaging');?>
</li>-->

<li<?php if ($_SESSION['menu']['sub']=='tell_friend'){?> class="active"<?php }?>><a href="/members/tellafriend">Share/Comparte</a></li>

<li><a href="/plugins/cart/cartmember/purchase/&page=shoppingcart_main_inside">Ver Servicios</a></li><li><a href="/plugins/cart/cartmember/purchase/&page=shoppingcart_main_inside">Ver Servicios</a></li>
                            
                 
                 <li<?php if ($_SESSION['menu']['sub']=='my_membership'){?> class="active"<?php }?>><a href="/members/upgrademembership">Upgrade Membership</a></li>
  <li class="divider"></li>
                   <li> <a href="/members/logout">Salir</a></li>
               

</ul>
               </div>
              



            <div id="sparkline1" class="small-chart m-t-sm"></div>
            <div>
               <h4 class="font-extra-bold m-b-xs">
                  <?php echo $_smarty_tpl->getVariable('lang')->value['monetary'];?>
 <?php echo $_SESSION['payout_balance'];?>

               </h4>
               <small class="text-muted">Comision Ganada</small>
            </div>
         </div>
      </div>
      <?php if ($_smarty_tpl->getVariable('hooks')->value->apply_filters('get_setting','google_translator_admin')==1){?>
            <center>
            &nbsp;&nbsp;<div id="google_translate_element"></div><script type="text/javascript">
            function googleTranslateElementInit() {
              new google.translate.TranslateElement({
                  pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
            }
            </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            </center>
        	<br />
		<?php }?>
      <ul class="nav" id="side-menu">
         <li<?php if ($_SESSION['menu']['main']=='dashboard'){?> class="active"<?php }?>>
            <a href="/members/">Mi Panel<br><font size="1" color="green">My Dashboard</font></a>
         </li>
         <li<?php if ($_SESSION['menu']['main']=='my_account'){?> class="active"<?php }?>>
            <a href="#"><span class="nav-label">Mi Membresia<br><font size="1" color="green">My Membership</font></span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">
              <li <?php if ($_SESSION['menu']['sub']=='profile'){?> class="active"<?php }?>><a href="/members/profile">Mi Perfil<br><font color="green">My Profile</font></a></li>
              <!-- <li<?php if ($_SESSION['menu']['sub']=='settings'){?> class="active"<?php }?>><a href="/members/accountsettings">Communication Settings<br><font color="green">Ajustes de Comunicacion</font></a></li>-->

<li<?php if ($_SESSION['menu']['sub']=='myvault'){?> class="active"<?php }?>><a href="/members/myvault">Mi B&oacuteveda<br><font color="green">My Vault</font></a></li>
<!--<li<?php if ($_SESSION['menu']['sub']=='myvault'){?> class="active"<?php }?>>
<a href="https://plusmoreusaeng.com/site/upgrades" target="_blank">Upgrade IT<br>
<font color="green">Mejora Tu IT</font></a></li> -->
               <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('menu_');?>

            </ul>
         </li> 
         <li<?php if ($_SESSION['menu']['main']=='my_network'){?> class="active"<?php }?>>
            <a href="#"><span class="nav-label"><br>Mis Referidos <br><font size="1" color="green">My Referrals</font></span><span class="fa arrow"></span> </a><ul class="nav nav-second-level">
           
<!--<li><a href="/members/404">Add a Guest (Soon)<br><font color="green">Agregar Invitado (Pronto)</font> </a></li>-->
               
<li<?php if ($_SESSION['menu']['sub']=='pending'){?> class="active"<?php }?>><a href="/members/pendingreferrers">Pendientes<br><font color="green">Pending </font> </a></li>
           
<li<?php if ($_SESSION['menu']['sub']=='referrers'){?> class="active"<?php }?>><a href="/members/referrers">Con Servicios<br><font color="green">With Services</font></a></li>
<?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('menu_network');?>

 </ul>
</li>
             
         <!-- <li<?php if ($_SESSION['menu']['sub']=='levels'){?> class="active"<?php }?>><a href="/members/myphases"><?php echo $_smarty_tpl->getVariable('lang')->value['my_phases'];?>
</a></li>
               <li<?php if ($_SESSION['menu']['sub']=='pendings'){?> class="active"<?php }?>><a href="/members/mypendings"><?php echo $_smarty_tpl->getVariable('lang')->value['my_pendings'];?>
</a></li>
            </ul>
         </li>-->
         <li<?php if ($_SESSION['menu']['main']=='financial'){?> class="active"<?php }?>>
            <a href="#"><span class="nav-label">Transacciones <br><font size="1" color="green">Transactions</font></span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">
              <!-- <li<?php if ($_SESSION['menu']['sub']=='deposit_wallet'){?> class="active"<?php }?>><a href="/members/depositwallet">Member Account<br><br><font  color="green">Cuenta de Miembro</a></font></li>-->
               <li<?php if ($_SESSION['menu']['sub']=='payout_wallet'){?> class="active"<?php }?>><a href="/members/payoutwallet">Comisiones<br><font color="green">Commissions</font></a></li>
              <!-- <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('menu_extra_wallets');?>
-->
               <!--<li<?php if ($_SESSION['menu']['sub']=='ad_credits'){?> class="active"<?php }?>><a href="/members/adcredits">Adcredits</a></li>-->
               <!--<li<?php if ($_SESSION['menu']['sub']=='my_membership'){?> class="active"<?php }?>><a href="/members/upgrademembership"><?php echo $_smarty_tpl->getVariable('lang')->value['upgrade_membership'];?>
</a></li>-->
             <!--<li<?php if ($_SESSION['menu']['sub']=='epin'){?> class="active"<?php }?>><a href="/members/epinsystem"><?php echo $_smarty_tpl->getVariable('lang')->value['pif'];?>
</a></li>-->
                
<!--<li<?php if ($_SESSION['menu']['sub']=='request_withdrawal'){?> class="active"<?php }?>><a href="/members/requestwithdrawal">Withdraw<br><font color="green">Retirar</font></a></li> -->             
 <li<?php if ($_SESSION['menu']['sub']=='withdrawal'){?> class="active"<?php }?>><a href="/members/withdrawals">Mis pagos<br><font color="green">My payments</font></a></li>
                                          
              <!--<?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('menu_financial');?>
-->
            </ul>
         </li>
         <?php if ($_smarty_tpl->getVariable('hooks')->value->apply_filters('get_setting','show_digital_menu_member')==1){?>
             <li<?php if ($_SESSION['menu']['main']=='products'){?> class="active"<?php }?>>
                <a href="#"><span class="nav-label">INFOBANCO<br><font size="1" color="green">INFOBANK</FONT></span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                   <li<?php if ($_SESSION['menu']['sub']=='products'){?> class="active"<?php }?>><a href="/members/downloads">Guias Digitales<br><font color="green">Digital Guides</font></a></li>               
                 <!--<?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('menu_products');?>
-->
                </ul>
             </li>
         <?php }?>
         <?php if (@ADVERTISING==1&&$_smarty_tpl->getVariable('hooks')->value->apply_filters('get_setting','show_adverting_menu_member')==1){?>
         <li<?php if ($_SESSION['menu']['main']=='advertising'){?> class="active"<?php }?>>
            <a href="#"><span class="nav-label">Comprar Servicios</span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">         
               <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('advertising');?>

            </ul>
         </li>  
         <?php }?>    
         
         <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('extra_member_menus');?>

            
        <!--<li<?php if ($_SESSION['menu']['main']=='messaging'){?> class="active"<?php }?>>
            <a href="#"><span class="nav-label"> Email</span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">
               <li<?php if ($_SESSION['menu']['sub']=='inbox'){?> class="active"<?php }?>><a href="/members/messages">Internal Inbox</a></li>
                <li><a href="https://email.powweb.com/roundcube/">PlusMoreUsa Email Access</a></li>
               <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('menu_messaging');?>

            </ul>
         </li>-->
        <li<?php if ($_SESSION['menu']['main']=='promotional'){?> class="active"<?php }?>>
            <a href="#"><span class="nav-label">PROMUEVE<br><font size="1" color="green">PROMOTE</font></span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">
 <li<?php if ($_SESSION['menu']['sub']=='tell_friend'){?> class="active"<?php }?>><a href="/members/tellafriend">Invita Amigos<br><font color="green">Tell Friends</font></a></li>
               <li<?php if ($_SESSION['menu']['sub']=='banners'){?> class="active"<?php }?>><a href="/members/banners"><br>Avisos Para Redes Sociales<br><font color="green">Social Media Ads</font></a></li>
              <!--<li<?php if ($_SESSION['menu']['sub']=='text_ads'){?> class="active"<?php }?>><a href="/members/textads">Frases Geniales<br><font color="green">Catchy Phrases </font></li>
             <!--<li<?php if ($_SESSION['menu']['sub']=='optin'){?> class="active"<?php }?>><a href="/members/optin"><?php echo $_smarty_tpl->getVariable('lang')->value['email_ads_optin'];?>
</a>-->
             
               <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('menu_promotion');?>

            <!-- <li><a href="/members/asubmitter">Article Submitter</a></li>
                  <li><a href="/members/dsubmitter">Directory Submitter</a></li>-->
<li><a href="https://www.facebook.com/TuPlusMoreUsa/" target="_blank">Ir a Facebook<br><font color="green">Go to Facebook</font></a></li>

                  <li><a href="https://www.instagram.com/plusmoreusa/"target="_blank">Ir a Instagram<br><font color="green">Go to Instagram</font></a></li>
                  <li><a href="https://twitter.com/PlusMoreUsa"target="_blank">Ir a Twitter <br><font color="green">Go to Twitter</font></a></li>
                  
            </ul>
         </li>
         <li<?php if ($_SESSION['menu']['main']=='contact_support'){?> class="active"<?php }?>>
            <a href="#"><span class="nav-label">AYUDA<br><font size="1" color="green">SUPPORT</FONT></span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">
        	   <?php if ($_smarty_tpl->getVariable('hooks')->value->apply_filters('get_setting','show_faq_menu_member')==1){?><li<?php if ($_SESSION['menu']['sub']=='faq'){?> class="active"<?php }?>><a href="/members/faq">Preguntas Frequentes<br><font color="green">Asked Questions</font></a></li><?php }?>
               <li<?php if ($_SESSION['menu']['sub']=='contact_admin'){?> class="active"<?php }?>><a href="/members/messages/&admin=1">Contactanos<br><font color="green">Contact Us</font></a></li>
          <!--  <li<?php if ($_SESSION['menu']['sub']=='contact_sponsor'){?> class="active"<?php }?>><a href="/members/messages/&sponsor=1">Contacta a tu Promotor</a></li>-->
               <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('menu_support');?>

            </ul>
         </li>
      </ul>
   </div>
</aside>