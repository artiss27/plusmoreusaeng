<?php

namespace processor\perfectmoney;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('perfect_money', '\processor\perfectmoney\setActionPerfectmoney');
$hooks->add_filter('api_send_money_perfect_money', '\processor\perfectmoney\setFilterPerfectmoneySendMoney');

function setActionPerfectmoney($amount)
{
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='perfect_money'");
	$extra_code = unserialize($processor['extra_code']);
	$hash 		= md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() .'|' . $amount, 60*60*24);
	$processor_form = '
<form action="'.$processor['processor_url'].'" method="POST" id="'.$processor['code'].'" >
<input type="hidden" name="PAYEE_ACCOUNT" value="'.$processor['account_id'].'">
<input type="hidden" name="PAYEE_NAME" value="'.$extra_code['company_name'].'">
<input type="hidden" name="PAYMENT_ID" value="'.uniqid().'">
<input type="hidden" name="PAYMENT_AMOUNT" value="'.number_format($amount, 2, '.', '').'"/>
<input type="hidden" name="PAYMENT_UNITS" value="'.$extra_code['currency'].'"/>
<input type="hidden" name="STATUS_URL" value="'.\CoreHelp::getSiteUrl().'plugins/perfectmoney/process/ipn">
<input type="hidden" name="PAYMENT_URL" value="'.\CoreHelp::getSiteUrl().'plugins/perfectmoney/process/success/">
<input type="hidden" name="PAYMENT_URL_METHOD" value="GET">
<input type="hidden" name="NOPAYMENT_URL_METHOD" value="GET">
<input type="hidden" name="NOPAYMENT_URL" value="'.\CoreHelp::getSiteUrl().'plugins/perfectmoney/process/cancel/">
<input type="hidden" name="BAGGAGE_FIELDS" value="HASH">
<input type="hidden" name="HASH" value="'.$hash.'">
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

function setFilterOkpaySendMoney($account, $amount, $id) {
	
	ini_set('max_execution_time', 0);
	include(__DIR__."/perfectmoney/api/details.php");
	
	$f=fopen('https://perfectmoney.is/acct/confirm.asp?AccountID='.$account_login.'&PassPhrase='.$password.'&Payer_Account='.$payer_account.'Payee_Account='.$account.'&Amount='.$amount.'&PAY_IN=1&PAYMENT_ID=' . $id . '&Memo=' . $note, 'rb');

	if($f===false){
	  	\CoreHelp::setSession('error', 'Error connecting to Perfect Money API, try again later or contact your sysadmin to check fopen is available to call external urls.');
		return false;
	}
	
	$out=array(); $out="";
	while(!feof($f)) $out.=fgets($f);
	
	fclose($f);
	
	if(!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $out, $result, PREG_SET_ORDER)){
	   \CoreHelp::setSession('error', 'Invalid data provided by Perfect Money API, Try again in few minutes');
		return false;
	}
	
	$ar="";
	foreach($result as $item){
	   $key 		 = strtolower($item[1]);
	   $ar[$key]	 = $item[2];
	}
	
	if(isset($ar['error'])) {
		\CoreHelp::setSession('error', 'Error provided by Perfect Money API: ' . $ar['error']);
		return false;	
	}	
    \CoreHelp::setSession('message', 'Transaction to Perfect Money proceed succesfully!');
	return true;  		
}

function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'perfect_money'");
    	if ($db->count() === 0) {
        	$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('perfect_money', 'Perfect Money', 'Uxxxxxxx', 'https://perfectmoney.is/api/step1.asp', '0.00', '0.00', 1, 1, 'a:3:{s:12:\"company_name\";s:0:\"\";s:16:\"pass_phrase_hash\";s:0:\"\";s:8:\"currency\";s:3:\"USD\";}', 'https://perfectmoney.is/api/step1.asp');
");	
		}
    }
	
}




?>