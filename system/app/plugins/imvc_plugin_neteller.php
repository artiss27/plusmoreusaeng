<?php

namespace processor\neteller;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('neteller', '\processor\neteller\setActionNeteller');
$hooks->add_filter('api_send_money_neteller', '\processor\neteller\setFilterNetellerSendMoney');

function setActionNeteller($amount)
{
	$lang      = \CoreHelp::getLang('members');
	$processor = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='neteller'");
	$extra_code = unserialize($processor['extra_code']);
	$hash      = md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() . '|' . $amount, 60 * 60 * 24);
	$site_name = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
	
	$processor_form = '
<form method="post" action="/plugins/neteller/process/form" id="' . $processor['code'] . '" >
		<input type="hidden" name="item_name" value="' . $lang['deposit_on'] . ' ' . $site_name . '" />
		<input type="hidden" name="amount" value="' . number_format($amount, 2, '.', '') . '">
</form>
';
	$processor_form .= "
<script type='text/javascript'>
	function formSubmit () {
		var frm = document.getElementById('" . $processor['code'] . "');
		frm.submit();
	}
	window.onload = formSubmit;
</script>	";
	echo $processor_form;
}

function setFilterNetellerSendMoney($account, $amount, $id) {
	
	ini_set('max_execution_time', 0);
	include(__DIR__."/neteller/api/NetellerAPI.php");
	include(__DIR__."/neteller/api/details.php");
	
	define('NETELLER_BASE_URL', 'https://api.neteller.com/');
	define('NETELLER_CLIENT_ID', $neteller_client_id);
	define('NETELLER_CLIENT_SECRET', $neteller_client_secret);
	
	$withdrawal = new \CreatePayment();
	$withdrawal->setPayeeProfileEmail($account)
			   ->setTransactionAmount($amount * 100)
			   ->setTransactionCurrency($currency)
			   ->setTransactionMerchantRefId($id)
			   ->setMessage($note);
	$result = $withdrawal->doRequest();
	
	if($result === false) {
		$error = $withdrawal->getExecutionErrors();
		\CoreHelp::setSession('error', 'Error provided by Neteller API: ' . $error['api_error_message']);
		return false;	
	}
	else {
		\CoreHelp::setSession('message', 'Transaction to Neteller proceed succesfully!');
		return true; 	
	}     	
}

function setTable()
{
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60 * 60 * 24);
		$db    = \tmvc::instance()->controller->load->database();
		$check = $db->query("SELECT * FROM payment_processors WHERE code = 'neteller'");
		if ($db->count() === 0) {
			$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('neteller', 'Neteller', 'account_number', 'https://api.neteller.com/v1/transferIns', '0.00', '0.00', 1, 1, 'a:3:{s:6:\"api_id\";s:0:\"\";s:10:\"api_secret\";s:0:\"\";s:8:\"currency\";s:3:\"USD\";}', 'https://api.neteller.com/v1/transferIn');
");
		}
	}
	
}




?>