<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <div class="stats-label text-color">
                <div id="sparkline1" class="small-chart m-t-sm"></div>
                <div>
                    <h4 class="font-extra-bold m-b-xs">
                        ${$smarty.session.balance}
                    </h4>
                    <small class="text-muted">Total Deposits</small>
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
                <a href="/admin/"> <span class="nav-label">Dashboard</span></a>
            </li>
            {$hooks->do_action('main_admin')}
			{if $smarty.session.roles.master == 1 or $smarty.session.roles.cms == 1}
			<li{if $smarty.session.menu.main eq 'cms'} class="active"{/if}>
                <a href="#"><span class="nav-label">CMS</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li{if $smarty.session.menu.sub eq 'cmsmail'} class="active"{/if}><a href="/admin/cmsmail">Email Templates</a></li>
                    <li><a href="/admin/openwordpress" target="_blank">Manage Wordpress</a></li>
                    {$hooks->do_action('cmslinks')}
                </ul>
            </li>
            {/if}
            {if $smarty.session.roles.master == 1 or $smarty.session.roles.financial == 1}
			<li{if $smarty.session.menu.main eq 'financial'} class="active"{/if}>
                <a href="#"><span class="nav-label">Finances</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
					<li{if $smarty.session.menu.sub eq 'addtransaction'} class="active"{/if}><a href="/admin/addtransaction">Add Transaction</a></li>
					<li{if $smarty.session.menu.sub eq 'searchtransaction'} class="active"{/if}><a href="/admin/transactions">Search Transactions</a></li>
					<li{if $smarty.session.menu.sub eq 'viewtransaction'} class="active"{/if}><a href="/admin/viewtransactions">View Transactions</a></li>
                   <!-- <li{if $smarty.session.menu.sub eq 'epins'} class="active"{/if}><a href="/admin/viewepins">View Epins</a></li>-->
					<li{if $smarty.session.menu.sub eq 'withdrawalrequest'} class="active"{/if}><a href="/admin/withdrawals">Withdrawal Request</a>
<li><a href="/admin/checkout">Checkout</a>
                    {$hooks->do_action('financiallinks')}
                </ul>
            </li>
            {/if}
            




{if $smarty.session.roles.master == 1 or $smarty.session.roles.members == 1}
            <li{if $smarty.session.menu.main eq 'members'} class="active"{/if}>
                <a href="#"><span class="nav-label">Members</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li{if $smarty.session.menu.sub eq 'addmember'} class="active"{/if}><a href="/admin/addmember/">Add New Member</a></li>
					<li{if $smarty.session.menu.sub eq 'memberlist'} class="active"{/if}><a href="/admin/members/">Member List</a></li>		
                    {$hooks->do_action('memberslinks')}			
                </ul>
            </li>
            {/if}




<li>
                <a href="#"><span class="nav-label">THE VAULT</span><span class="fa arrow"></span> </a>
                
<ul class="nav nav-second-level">
                    <li><a href="/admin/myvault/">Upload Docs</a></li>
                    {$hooks->do_action('digitalproductslinks')}
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
            


            {if $smarty.session.roles.master == 1 or $smarty.session.roles.memberships == 1}
            <li{if $smarty.session.menu.main eq 'memberships'} class="active"{/if}>
                <a href="#"><span class="nav-label">Memberships</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">                    
					<li{if $smarty.session.menu.sub eq 'membershipsettings'} class="active"{/if}><a href="/admin/membershipsettings">Manage</a></li>
                    <li{if $smarty.session.menu.sub eq 'membershipsign'} class="active"{/if}><a href="/admin/signupsettings">Signup Settings</a></li>
                    <!--<li{if $smarty.session.menu.sub eq 'adcreditstartup'} class="active"{/if}><a href="/admin/adcreditstartup">Ad Credits Startup</a></li> 
					<li{if $smarty.session.menu.sub eq 'membershipbonus'} class="active"{/if}><a href="/admin/bonussettings">Referral Startup Bonus</a></li>-->
                    {$hooks->do_action('membershiplinks')}					
                </ul>
            </li>
            {/if}
            {{if $smarty.session.roles.master == 1 or $smarty.session.roles.settings == 1}}
			<li{if $smarty.session.menu.main eq 'settings'} class="active"{/if}>
                <a href="#"><span class="nav-label">Settings</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li{if $smarty.session.menu.sub eq 'adminsettings'} class="active"{/if}><a href="/admin/adminsettings">Administrator</a></li>
					<li{if $smarty.session.menu.sub|in_array:$hooks->apply_filters('payplan') || $smarty.session.menu.sub eq 'affiliatesettings'} class="active"{/if}><a href="#">Pay Plan<span class="fa arrow"></span> </a>
						<ul class="nav nav-third-level">
                        	<li{if $smarty.session.menu.sub eq 'affiliatesettings'} class="active"{/if}><a href="/admin/affiliatesettings">Settings</a></li>					
                            {$hooks->do_action('payplanlinks')}
						</ul>              
					</li> 
					<li{if $smarty.session.menu.sub eq 'processors'} class="active"{/if}><a href="/admin/processors">Processors</a></li>
					<li{if $smarty.session.menu.sub eq 'settings'} class="active"{/if}><a href="/admin/settings/">Site Settings</a></li>
                    <li{if $smarty.session.menu.sub eq 'withdrawalsettings'} class="active"{/if}><a href="/admin/withdrawalsettings/">Withdrawal Settings</a></li>
                    {$hooks->do_action('settingslinks')}
                </ul>
            </li>
            {/if}
            {if $smarty.session.roles.master == 1 or $smarty.session.roles.system == 1}
			<li{if $smarty.session.menu.main eq 'system'} class="active"{/if}>
                <a href="#"><span class="nav-label">System</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li{if $smarty.session.menu.sub eq 'cache'} class="active"{/if}><a href="/admin/cache">Flush Cache</a></li>
					<li{if $smarty.session.menu.sub eq 'optimize'} class="active"{/if}><a href="/admin/optimize">Optimize Mysql</a></li>
                    {$hooks->do_action('systemlinks')}
                </ul>
            </li>
            {/if}
            {if $smarty.session.roles.master == 1 or $smarty.session.roles.digital_products == 1}
            <li{if $smarty.session.menu.main eq 'digital_products'} class="active"{/if}>
                <a href="#"><span class="nav-label">InfoBank</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li{if $smarty.session.menu.sub eq 'downloads'} class="active"{/if}><a href="/admin/downloads/">Step-by-Step Financial Guides</a></li>
                    {$hooks->do_action('digitalproductslinks')}
                </ul>
            </li>
            {/if}
            {$hooks->do_action('admin_menu_foot')}
            {if $smarty.session.roles.master == 1 or $smarty.session.roles.tools == 1}
			<li{if $smarty.session.menu.main eq 'tools'} class="active"{/if}>
                <a href="#"><span class="nav-label">Tools</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
					<li{if $smarty.session.menu.sub eq 'faq'} class="active"{/if}><a href="/admin/faq/">FAQ</a></li>
					<li{if $smarty.session.menu.sub eq 'massmail'} class="active"{/if}><a href="/admin/massmail">Mass Mail</a></li>
					<li{if $smarty.session.menu.sub eq 'news'} class="active"{/if}><a href="/admin/news/">News</a></li>					
					<li{if $smarty.session.menu.sub eq 'banners'} class="active"{/if}><a href="/admin/banners">Promoting Banners</a></li>
					<li{if $smarty.session.menu.sub eq 'optin'} class="active"{/if}><a href="/admin/optin">Promoting Opt-in Emails</a></li>
					<li{if $smarty.session.menu.sub eq 'textads'} class="active"{/if}><a href="/admin/textads">Promoting TextAds</a></li>
                    {$hooks->do_action('toolslinks')}
                </ul>
            </li>
            {/if}
        </ul>
    </div>
</aside>