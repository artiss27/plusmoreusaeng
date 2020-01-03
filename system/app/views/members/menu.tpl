<!-- Navigation -->
<aside id="menu">
   <div id="navigation">
      <div class="profile-picture">
         <a href="/members">{assign var=pic value=CoreHelp::getProfilePic($smarty.session.gender)}<img alt="logo" id="avatar" class="img-circle m-b" src="{$pic}"></a>
         <div class="stats-label text-color">
           <span class="font-extra-bold font-uppercase">{$smarty.session.name}</span>
           <div class="dropdown">
             <a class="dropdown-toggle" href="#" data-toggle="dropdown">
               <small class="text-muted">Rapido/<font color="green">Quick</font><b class="caret"></b></small>
             </a>
             <ul class="dropdown-menu animated fadeInRight m-t-xs">
               <li {if $smarty.session.menu.sub eq 'inbox'} class="active"{/if}><a href="/members/messages">Buz&oacuten/<font color="green">Inbox</a></font></li>{$hooks->do_action('menu_messaging')}</li>
               <li {if $smarty.session.menu.sub eq 'tell_friend'} class="active"{/if}><a href="/members/tellafriend">Comparte/<font color="green">Share</font></a></li>
               <li {if $smarty.session.menu.sub eq 'myvault'} class="active"{/if}><a href="/members/myvault">Tu B&oacuteveda/<font color="green">My Vault</font></a></li>
               <li><a href="/members/logout">Salir/<font color="green">Logout</font></a></li>
             </ul>
           </div>

            <div id="sparkline1" class="small-chart m-t-sm"></div>
            <div>
               <h4 class="font-extra-bold m-b-xs">{$lang.monetary} {$smarty.session.payout_balance}</h4>
               <small class="text-muted">Fondos Para TAD<br><font size="1" color="green">TAD Funds</font></a></small>
            </div>
           <div>
             <h4 class="font-extra-bold m-b-xs">$ {$balance15percent}</h4>
           </div>
         </div>
      </div>
      {if $hooks->apply_filters('get_setting', 'google_translator_admin') == 1}
            <center>
            &nbsp;&nbsp;<div id="google_translate_element"></div><script type="text/javascript">
            function googleTranslateElementInit() {
              new google.translate.TranslateElement({
                  pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
            }
            </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            </center>
        	<br />
		{/if}
      <ul class="nav" id="side-menu">
         <li{if $smarty.session.menu.main eq 'dashboard'} class="active"{/if}>
            <a href="/members/">Tu Panel<br><font size="1" color="green">Your Dashboard</font></a>
         </li>
         <li{if $smarty.session.menu.main eq 'my_account'} class="active"{/if}>
            <a href="#"><span class="nav-label">Tu Membresia<br><font size="1" color="green">Your Membership</font></span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">
              <li {if $smarty.session.menu.sub eq 'profile'} class="active"{/if}><a href="/members/profile">Tu Perfil<br><font color="green">Your Profile</font></a></li>
             <!--<li{if $smarty.session.menu.sub eq 'settings'} class="active"{/if}><a href="/members/accountsettings">Communication Settings<br><font color="green">Ajustes de Comunicacion</font></a></li>-->

<li{if $smarty.session.menu.sub eq 'myvault'} class="active"{/if}><a href="/members/myvault">Tu B&oacuteveda<br><font color="green">Your Vault</font></a></li>
<!--<li{if $smarty.session.menu.sub eq 'myvault'} class="active"{/if}>
<a href="https://plusmoreusaeng.com/site/upgrades" target="_blank">Upgrade IT<br>
<font color="green">Mejora Tu IT</font></a></li> -->
               {$hooks->do_action('menu_')}
            </ul>
         </li> 
        <li{if $smarty.session.menu.main eq 'my_network'} class="active"{/if}>
            <a href="#"><span class="nav-label"><br>Tus Referidos <br><font size="1" color="green">Your Referrals</font></span><span class="fa arrow"></span> </a><ul class="nav nav-second-level">

<li{if $smarty.session.menu.sub eq 'referrers'} class="active"{/if}><a href="/members/referrers">Con Servicios<br><font color="green">With Services</font></a></li>
<!--{$hooks->do_action('menu_network')}-->
           
 <li{if $smarty.session.menu.sub eq 'pending'} class="active"{/if}><a href="/members/pendingreferrers">Sin Servicios<br><font color="green">Without Services</font> </a> </ul></li>
           
            
         <!-- <li{if $smarty.session.menu.sub eq 'levels'} class="active"{/if}><a href="/members/myphases">{$lang.my_phases}</a></li>
               <li{if $smarty.session.menu.sub eq 'pendings'} class="active"{/if}><a href="/members/mypendings">{$lang.my_pendings}</a></li>
            </ul>
         </li>-->

  <!--<li{if $smarty.session.menu.main eq 'financial'} class="active"{/if}>
            <a href="#"><span class="nav-label">TUS TRANSACCIONES<br><font size="1" color="green">YOUR TRANSACTIONS</font></span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">
               <li{if $smarty.session.menu.sub eq 'deposit_wallet'} class="active"{/if}><a href="/members/depositwallet">Member Account<br><br><font  color="green">Cuenta de Miembro</a></font></li>
               <li{if $smarty.session.menu.sub eq 'payout_wallet'} class="active"{/if}><a href="/members/payoutwallet">Transacciones<br><font color="green">Transactions</font></a></li>
              {$hooks->do_action('menu_extra_wallets')}
               <li{if $smarty.session.menu.sub eq 'ad_credits'} class="active"{/if}><a href="/members/adcredits">Adcredits</a></li>
              <li{if $smarty.session.menu.sub eq 'my_membership'} class="active"{/if}><a href="/members/upgrademembership">{$lang.upgrade_membership}</a></li>
             <li{if $smarty.session.menu.sub eq 'epin'} class="active"{/if}><a href="/members/epinsystem">{$lang.pif}</a></li>
                
<li{if $smarty.session.menu.sub eq 'request_withdrawal'} class="active"{/if}><a href="/members/requestwithdrawal">Retirar<br><font color="green">Withdraw</font></a></li>           
 <li{if $smarty.session.menu.sub eq 'withdrawal'} class="active"{/if}><a href="/members/withdrawals">Mis Retiros<br><font color="green">My Withdrawals</font></a></li>
                                          
             {$hooks->do_action('menu_financial')}
            </ul>
         </li>-->

        <!--{if $hooks->apply_filters('get_setting', 'show_digital_menu_member') == 1}
             <li{if $smarty.session.menu.main eq 'products'} class="active"{/if}>
                <a href="#"><span class="nav-label">INFOBANCO<br><font size="1" color="green">INFOBANK</FONT></span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                   <li{if $smarty.session.menu.sub eq 'products'} class="active"{/if}><a href="/members/downloads">Guias Digitales<br><font color="green">Digital Guides</font></a></li>               
                {$hooks->do_action('menu_products')}
                </ul>
             </li>
         {/if}-->
         <!--{if $smarty.const.ADVERTISING eq 1 && $hooks->apply_filters('get_setting', 'show_adverting_menu_member') == 1}
         <li{if $smarty.session.menu.main eq 'advertising'} class="active"{/if}>
            <a href="#"><span class="nav-label">Comprar Servicios</span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">         
               {$hooks->do_action('advertising')}
            </ul>
         </li>  
         {/if}   --> 
         
       {$hooks->do_action('extra_member_menus')}
            
        <!--<li{if $smarty.session.menu.main eq 'messaging'} class="active"{/if}>
            <a href="#"><span class="nav-label"> Email</span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">
               <li{if $smarty.session.menu.sub eq 'inbox'} class="active"{/if}><a href="/members/messages">Internal Inbox</a></li>
                <li><a href="https://email.powweb.com/roundcube/">PlusMoreUsa Email Access</a></li>
               {$hooks->do_action('menu_messaging')}
            </ul>
         </li>-->
        <li{if $smarty.session.menu.main eq 'promotional'} class="active"{/if}>
            <a href="#"><span class="nav-label">PROMUEVE<br><font size="1" color="green">PROMOTE</font></span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">
 <li{if $smarty.session.menu.sub eq 'tell_friend'} class="active"{/if}><a href="/members/tellafriend">Invita Amigos<br><font color="green">Tell Friends</font></a></li>
               <li{if $smarty.session.menu.sub eq 'banners'} class="active"{/if}><a href="/members/banners"><br>Avisos Para Redes Sociales<br><font color="green">Social Media Ads</font></a></li>
              <!--<li{if $smarty.session.menu.sub eq 'text_ads'} class="active"{/if}><a href="/members/textads">Frases Geniales<br><font color="green">Catchy Phrases </font></li>
             <!--<li{if $smarty.session.menu.sub eq 'optin'} class="active"{/if}><a href="/members/optin">{$lang.email_ads_optin}</a>-->
             
               {$hooks->do_action('menu_promotion')}
            <!-- <li><a href="/members/asubmitter">Article Submitter</a></li>
                  <li><a href="/members/dsubmitter">Directory Submitter</a></li>-->
<li><a href="https://www.facebook.com/TuPlusMoreUsa/" target="_blank">Ir a Facebook<br><font color="green">Go to Facebook</font></a></li>

                  <li><a href="https://www.instagram.com/plusmoreusa/"target="_blank">Ir a Instagram<br><font color="green">Go to Instagram</font></a></li>
                  <li><a href="https://twitter.com/PlusMoreUsa"target="_blank">Ir a Twitter <br><font color="green">Go to Twitter</font></a></li>
                  
            </ul>
         </li>
         <li{if $smarty.session.menu.main eq 'contact_support'} class="active"{/if}>
            <a href="#"><span class="nav-label">AYUDA<br><font size="1" color="green">SUPPORT</FONT></span><span class="fa arrow"></span> </a>
            <ul class="nav nav-second-level">
        	   {if $hooks->apply_filters('get_setting', 'show_faq_menu_member') == 1}<li{if $smarty.session.menu.sub eq 'faq'} class="active"{/if}><a href="/members/faq">Preguntas Frequentes<br><font color="green">Asked Questions</font></a></li>{/if}
               <li{if $smarty.session.menu.sub eq 'contact_admin'} class="active"{/if}><a href="/members/messages/&admin=1">Contactanos<br><font color="green">Contact Us</font></a></li>
          <!--  <li{if $smarty.session.menu.sub eq 'contact_sponsor'} class="active"{/if}><a href="/members/messages/&sponsor=1">Contacta a tu Promotor</a></li>-->
               {$hooks->do_action('menu_support')}
            </ul>
         </li>
      </ul>
   </div>
</aside>