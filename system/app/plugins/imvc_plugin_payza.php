<?php

namespace processor\payza;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('payza', '\processor\payza\setActionPayza');
$hooks->add_filter('api_send_money_payza', '\processor\payza\setFilterPayzaSendMoney');

function setActionPayza($amount)
{
	$lang = \CoreHelp::getLang('members');
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='payza'");
	$extra_code = unserialize($processor['extra_code']);
	$hash 		= md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() .'|' . $amount, 60*60*24);
	$site_name  = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
	$processor_form = '
<form method="post" action="'.$processor['processor_url'].'" id="'.$processor['code'].'" >
<input type="hidden" name="ap_purchasetype" value="service"/>
<input type="hidden" name="ap_merchant" value="'.$processor['account_id'].'"/>
<input type="hidden" name="ap_itemname" value="'.$lang['deposit_on'].' '.$site_name.'"/>
<input type="hidden" name="ap_currency" value="'.$extra_code['currency'].'"/>
<input type="hidden" name="ap_returnurl" value="'.\CoreHelp::getSiteUrl().'plugins/payza/process/success"/>
<input type="hidden" name="ap_quantity" value="1"/>
<input type="hidden" name="ap_description" value="'.$lang['deposit_on'].' '.$site_name.'"/>
<input type="hidden" name="ap_amount" value="'.number_format($amount, 2, '.', '').'"/>
<input type="hidden" name="ap_cancelurl" value="'.\CoreHelp::getSiteUrl().'plugins/payza/process/cancel"/>
<input type="hidden" name="ap_ipnversion" value="2"/>
<input type="hidden" name="apc_1" value="'.$hash.'"/>
</form>
';
	$processor_form .= "
<script type='text/javascript'>
	function formSubmit () {
		var frm = document.getElementById('".$processor['code']."');
		frm.submit();
	}
	window.onload = formSubmit;
</script>	";
	echo $processor_form;	
}

function setFilterPayzaSendMoney($account, $amount, $id) {
	
	ini_set('max_execution_time', 0);
	include(__DIR__."/payza/api/SendMoneyClient.php");
	include(__DIR__."/payza/api/details.php");
	
	$do = new \SendMoneyClient($username, $api_password);
	$do->setServer("api.payza.com");
	$do->setUrl("/api/api.svc/sendmoney");
	
	$do->BuildPostVariables($amount, $currency,$account,$sender_email);
	
	$output = $do->send();
	$do->parseResponse($output);
	$result = $do->getResponse();
	
	if($result['RETURNCODE'] == 100) {
		\CoreHelp::setSession('message', 'Transaction to Payza proceed succesfully!');
		return true;
	}
	else {
		\CoreHelp::setSession('error', 'Error provided by Payza API: ' . $result['DESCRIPTION']);
		return false;
	}
}

function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'payza'");
    	if ($db->count() === 0) {
        	$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('payza', 'Payza', 'name@domain.com', 'https://secure.payza.com/checkout', '0.00', '0.00', 1, 1, 'a:2:{s:12:\"api_password\";s:0:\"\";s:8:\"currency\";s:3:\"USD\";}', 'https://secure.payza.com/checkout');
");	
		}
    }
	
}




?>