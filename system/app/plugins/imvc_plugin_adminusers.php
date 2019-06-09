<?php

namespace adminusers;

$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('settingslinks', '\adminusers\setActionExtraAdminMenu');
$hooks->add_action('logout', '\adminusers\setActionLogout');

if($_SESSION['LoggedIn']) {
	$_SESSION['available_roles'] = array('cms' => 'CMS',
					'financial' => 'Financial',
					'members' => 'Members',
					'memberships' => 'Memberships',
					'settings' => 'Settings',
					'system' => 'System',
					'digital_products' => 'Digital Products',
					'tools' => 'Tools'
					);
   if(!$_SESSION['roles']) {
		$db    = \tmvc::instance()->controller->load->database();
		$row   = $db->queryFirstRow("SELECT roles,is_master_admin FROM admin_users WHERE username = %s", $_SESSION['userName']);
		if($row['is_master_admin'] == 1) {
			$_SESSION['roles']['master'] = 1;
		}
		else {
			$roles = unserialize($row['roles']);
			foreach ($roles as $key=>$value) {
				$_SESSION['roles'][$key] = 1;
			}
		}
   }
}

function setActionExtraAdminMenu()
{
	$class = ($_SESSION['menu']['sub'] == "admin_users") ? ' class="active"' : '';
    echo '<li'.$class.'><a href="/plugins/adminusers/admin/users">Admin Users</a></li>' . "\n";
}

function setActionLogout()
{	
	unset($_SESSION['roles']);
}

?>