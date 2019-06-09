<?php

namespace transfer;

$hooks = \voku\helper\Hooks::getInstance();

$hooks->add_action('settingslinks', '\transfer\setActionExtraAdminMenu');
$hooks->add_filter('menu_extra_wallets', '\transfer\setActionTransferMoney');

function setActionExtraAdminMenu()
{
	$class = ($_SESSION['menu']['sub'] == "transfer_settings") ? ' class="active"' : '';
	echo '<li' . $class . '><a href="/plugins/transfer/admin/settings">Money Transfer Settings</a></li>' . "\n";
}

function setActionTransferMoney()
{
	$db    = \tmvc::instance()->controller->load->database();
	$row = $db->queryFirstRow("SELECT * FROM settings WHERE keyname = 'money_trasnfer_active'");
	if(isset($row['value']) && $row['value'] == 'yes') {
		$class = ($_SESSION['menu']['sub'] == "transfer") ? ' class="active"' : '';
		echo '<li' . $class . '><a href="/plugins/transfer/member/transfer">Money Transfer</a></li>' . "\n";
	}
}


?>