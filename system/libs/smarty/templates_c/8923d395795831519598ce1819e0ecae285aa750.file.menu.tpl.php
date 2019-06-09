<?php /* Smarty version Smarty-3.0.8, created on 2019-06-07 10:56:46
         compiled from "system/app/views/admin/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16023987915cfaa55e204587-18913698%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8923d395795831519598ce1819e0ecae285aa750' => 
    array (
      0 => 'system/app/views/admin/menu.tpl',
      1 => 1541136295,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16023987915cfaa55e204587-18913698',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <div class="stats-label text-color">
                <div id="sparkline1" class="small-chart m-t-sm"></div>
                <div>
                    <h4 class="font-extra-bold m-b-xs">
                        $<?php echo $_SESSION['balance'];?>

                    </h4>
                    <small class="text-muted">Total Deposits</small>
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
                <a href="/admin/"> <span class="nav-label">Dashboard</span></a>
            </li>
            <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('main_admin');?>

			<?php if ($_SESSION['roles']['master']==1||$_SESSION['roles']['cms']==1){?>
			<li<?php if ($_SESSION['menu']['main']=='cms'){?> class="active"<?php }?>>
                <a href="#"><span class="nav-label">CMS</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li<?php if ($_SESSION['menu']['sub']=='cmsmail'){?> class="active"<?php }?>><a href="/admin/cmsmail">Email Templates</a></li>
                    <li><a href="/admin/openwordpress" target="_blank">Manage Wordpress</a></li>
                    <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('cmslinks');?>

                </ul>
            </li>
            <?php }?>
            <?php if ($_SESSION['roles']['master']==1||$_SESSION['roles']['financial']==1){?>
			<li<?php if ($_SESSION['menu']['main']=='financial'){?> class="active"<?php }?>>
                <a href="#"><span class="nav-label">Finances</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
					<li<?php if ($_SESSION['menu']['sub']=='addtransaction'){?> class="active"<?php }?>><a href="/admin/addtransaction">Add Transaction</a></li>
					<li<?php if ($_SESSION['menu']['sub']=='searchtransaction'){?> class="active"<?php }?>><a href="/admin/transactions">Search Transactions</a></li>
					<li<?php if ($_SESSION['menu']['sub']=='viewtransaction'){?> class="active"<?php }?>><a href="/admin/viewtransactions">View Transactions</a></li>
                   <!-- <li<?php if ($_SESSION['menu']['sub']=='epins'){?> class="active"<?php }?>><a href="/admin/viewepins">View Epins</a></li>-->
					<li<?php if ($_SESSION['menu']['sub']=='withdrawalrequest'){?> class="active"<?php }?>><a href="/admin/withdrawals">Withdrawal Request</a>
<li><a href="/admin/checkout">Checkout</a>
                    <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('financiallinks');?>

                </ul>
            </li>
            <?php }?>
            




<?php if ($_SESSION['roles']['master']==1||$_SESSION['roles']['members']==1){?>
            <li<?php if ($_SESSION['menu']['main']=='members'){?> class="active"<?php }?>>
                <a href="#"><span class="nav-label">Members</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li<?php if ($_SESSION['menu']['sub']=='addmember'){?> class="active"<?php }?>><a href="/admin/addmember/">Add New Member</a></li>
					<li<?php if ($_SESSION['menu']['sub']=='memberlist'){?> class="active"<?php }?>><a href="/admin/members/">Member List</a></li>		
                    <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('memberslinks');?>
			
                </ul>
            </li>
            <?php }?>




<li>
                <a href="#"><span class="nav-label">THE VAULT</span><span class="fa arrow"></span> </a>
                
<ul class="nav nav-second-level">
                    <li><a href="/admin/myvault/">Upload Docs</a></li>
                    <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('digitalproductslinks');?>

                </ul>
                   
		   		
                    		
             
            </li>

            <li>
                <a href="#"><span class="nav-label">M2MXCHANGE</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li><a href="/admin/addmember/">New Loan Settings</a></li>
                    <li><a href="/admin/addmember/">Available M2M Loans</a></li>
                    <li><a href="/admin/addmember/">M2M Loan Status</a></li>
                    <li><a href="/admin/addmember/">M2M Loans Transactions</a></li>
		   		
                    		
                </ul>
            </li>
            


            <?php if ($_SESSION['roles']['master']==1||$_SESSION['roles']['memberships']==1){?>
            <li<?php if ($_SESSION['menu']['main']=='memberships'){?> class="active"<?php }?>>
                <a href="#"><span class="nav-label">Memberships</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">                    
					<li<?php if ($_SESSION['menu']['sub']=='membershipsettings'){?> class="active"<?php }?>><a href="/admin/membershipsettings">Manage</a></li>
                    <li<?php if ($_SESSION['menu']['sub']=='membershipsign'){?> class="active"<?php }?>><a href="/admin/signupsettings">Signup Settings</a></li>
                    <!--<li<?php if ($_SESSION['menu']['sub']=='adcreditstartup'){?> class="active"<?php }?>><a href="/admin/adcreditstartup">Ad Credits Startup</a></li> 
					<li<?php if ($_SESSION['menu']['sub']=='membershipbonus'){?> class="active"<?php }?>><a href="/admin/bonussettings">Referral Startup Bonus</a></li>-->
                    <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('membershiplinks');?>
					
                </ul>
            </li>
            <?php }?>
            <?php ob_start();?><?php if ($_SESSION['roles']['master']==1||$_SESSION['roles']['settings']==1){?><?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>

			<li<?php if ($_SESSION['menu']['main']=='settings'){?> class="active"<?php }?>>
                <a href="#"><span class="nav-label">Settings</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li<?php if ($_SESSION['menu']['sub']=='adminsettings'){?> class="active"<?php }?>><a href="/admin/adminsettings">Administrator</a></li>
					<li<?php if (in_array($_SESSION['menu']['sub'],$_smarty_tpl->getVariable('hooks')->value->apply_filters('payplan'))||$_SESSION['menu']['sub']=='affiliatesettings'){?> class="active"<?php }?>><a href="#">Pay Plan<span class="fa arrow"></span> </a>
						<ul class="nav nav-third-level">
                        	<li<?php if ($_SESSION['menu']['sub']=='affiliatesettings'){?> class="active"<?php }?>><a href="/admin/affiliatesettings">Settings</a></li>					
                            <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('payplanlinks');?>

						</ul>              
					</li> 
					<li<?php if ($_SESSION['menu']['sub']=='processors'){?> class="active"<?php }?>><a href="/admin/processors">Processors</a></li>
					<li<?php if ($_SESSION['menu']['sub']=='settings'){?> class="active"<?php }?>><a href="/admin/settings/">Site Settings</a></li>
                    <li<?php if ($_SESSION['menu']['sub']=='withdrawalsettings'){?> class="active"<?php }?>><a href="/admin/withdrawalsettings/">Withdrawal Settings</a></li>
                    <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('settingslinks');?>

                </ul>
            </li>
            <?php }?>
            <?php if ($_SESSION['roles']['master']==1||$_SESSION['roles']['system']==1){?>
			<li<?php if ($_SESSION['menu']['main']=='system'){?> class="active"<?php }?>>
                <a href="#"><span class="nav-label">System</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li<?php if ($_SESSION['menu']['sub']=='cache'){?> class="active"<?php }?>><a href="/admin/cache">Flush Cache</a></li>
					<li<?php if ($_SESSION['menu']['sub']=='optimize'){?> class="active"<?php }?>><a href="/admin/optimize">Optimize Mysql</a></li>
                    <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('systemlinks');?>

                </ul>
            </li>
            <?php }?>
            <?php if ($_SESSION['roles']['master']==1||$_SESSION['roles']['digital_products']==1){?>
            <li<?php if ($_SESSION['menu']['main']=='digital_products'){?> class="active"<?php }?>>
                <a href="#"><span class="nav-label">InfoBank</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li<?php if ($_SESSION['menu']['sub']=='downloads'){?> class="active"<?php }?>><a href="/admin/downloads/">Step-by-Step Financial Guides</a></li>
                    <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('digitalproductslinks');?>

                </ul>
            </li>
            <?php }?>
            <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('admin_menu_foot');?>

            <?php if ($_SESSION['roles']['master']==1||$_SESSION['roles']['tools']==1){?>
			<li<?php if ($_SESSION['menu']['main']=='tools'){?> class="active"<?php }?>>
                <a href="#"><span class="nav-label">Tools</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
					<li<?php if ($_SESSION['menu']['sub']=='faq'){?> class="active"<?php }?>><a href="/admin/faq/">FAQ</a></li>
					<li<?php if ($_SESSION['menu']['sub']=='massmail'){?> class="active"<?php }?>><a href="/admin/massmail">Mass Mail</a></li>
					<li<?php if ($_SESSION['menu']['sub']=='news'){?> class="active"<?php }?>><a href="/admin/news/">News</a></li>					
					<li<?php if ($_SESSION['menu']['sub']=='banners'){?> class="active"<?php }?>><a href="/admin/banners">Promoting Banners</a></li>
					<li<?php if ($_SESSION['menu']['sub']=='optin'){?> class="active"<?php }?>><a href="/admin/optin">Promoting Opt-in Emails</a></li>
					<li<?php if ($_SESSION['menu']['sub']=='textads'){?> class="active"<?php }?>><a href="/admin/textads">Promoting TextAds</a></li>
                    <?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('toolslinks');?>

                </ul>
            </li>
            <?php }?>
        </ul>
    </div>
</aside>