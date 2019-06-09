<?php

namespace processor\advcash;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('advcash', '\processor\advcash\setActionAdvcash');
$hooks->add_filter('api_send_money_advcash', '\processor\advcash\setFilterAdvcashSendMoney');

function setActionAdvcash($amount)
{
	$lang = \CoreHelp::getLang('members');
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='advcash'");
	$extra_code = unserialize($processor['extra_code']);
	$hash 		= md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() .'|' . $amount, 60*60*24);
	$site_name  = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
	$sign = hash('sha256', $processor['account_id'].':'.$extra_code['sci_name'].':'.number_format($amount, 2, '.', '').':'.$extra_code['currency'].':'.$extra_code['secondary_password'].':'. $hash);
	$processor_form = '
<form action="'.$processor['processor_url'].'" method="post" id="'.$processor['code'].'">
<input type="hidden" name="ac_account_email" value="'.$processor['account_id'].'">
<input type="hidden" name="ac_sci_name" value="'.$extra_code['sci_name'].'">
<input type="hidden" name="ac_amount" value="'.number_format($amount, 2, '.', '').'">
<input type="hidden" name="ac_currency" value="'.$extra_code['currency'].'">
<input type="hidden" name="ac_order_id" value="'.$hash.'">
<input type="hidden" name="ac_sign" value="'.$sign.'">
<input type="hidden" name="ac_comments" value="">
<!-- Merchant custom fields -->
<input type="hidden" name="custom" value="'.\CoreHelp::getMemberId().'|'.number_format($amount, 2, '.', '').'|'.\CoreHelp::getIp().'">
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

function setFilterAdvcashSendMoney($account, $amount, $id) {
	
	ini_set('max_execution_time', 0);
	require_once(__DIR__."/advacash/api/MerchantWebService.php");
	include(__DIR__."/advacash/api/details.php");
	$merchantWebService = new \MerchantWebService();
	
	$arg0 = new \authDTO();
	$arg0->apiName = $api_name;
	$arg0->accountEmail = $api_email;
	$arg0->authenticationToken = $merchantWebService->getAuthenticationToken($api_password);
	
	$arg1 = new \sendMoneyRequest();
	$arg1->amount = number_format($amount, 2, '.', '');
	$arg1->currency = $currency;
	if(filter_var($account, FILTER_VALIDATE_EMAIL) !== false) {
		$arg1->email = $account;
	}
	else {
		$arg1->walletId = $account;
	}
	$arg1->note = $note;
	$arg1->savePaymentTemplate = false;
	
	$validationSendMoney = new \validationSendMoney();
	$validationSendMoney->arg0 = $arg0;
	$validationSendMoney->arg1 = $arg1;
	
	$sendMoney = new \sendMoney();
	$sendMoney->arg0 = $arg0;
	$sendMoney->arg1 = $arg1;
	
	try {
		$merchantWebService->validationSendMoney($validationSendMoney);
		$sendMoneyResponse = $merchantWebService->sendMoney($sendMoney);	
		//echo print_r($sendMoneyResponse, true)."<br/><br/>";
		//echo $sendMoneyResponse->return."<br/><br/>";
		\CoreHelp::setSession('message', 'Transaction to Advcash proceed succesfully!');
		return true;
	} catch (\Exception $e) {
		//echo "ERROR MESSAGE => " . $e->getMessage() . "<br/>";
		//echo $e->getTraceAsString();
		\CoreHelp::setSession('error', 'Transaction to Advcash have error: ' . $e->getTraceAsString());
		return false;
	}
		
}


function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'advcash'");
    	if ($db->count() === 0) {
        	$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('advcash', 'Advcash', 'name@domain.com', 'https://wallet.advcash.com/sci/', '0.00', '0.00', 1, 1, 'a:3:{s:8:\"currency\";s:3:\"USD\";s:8:\"sci_name\";s:0:\"\";s:18:\"secondary_password\";s:0:\"\";}', 'https://wallet.advcash.com/sci/');
");	
		}
    }
	
}




?>