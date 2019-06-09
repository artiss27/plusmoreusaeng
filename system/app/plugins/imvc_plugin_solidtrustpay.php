<?php

namespace processor\stp;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('stp', '\processor\stp\setActionStp');
$hooks->add_filter('api_send_money_stp', '\processor\stp\setFilterStpSendMoney');

function setActionStp($amount)
{
	$lang = \CoreHelp::getLang('members');
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='stp'");
	$extra_code = unserialize($processor['extra_code']);
	$hash 		= md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() .'|' . $amount, 60*60*24);
	$site_name  = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
	$processor_form = '
<form method="post" action="'.$processor['processor_url'].'" id="'.$processor['code'].'" >
<input type="hidden" name="merchantAccount" value="'.$processor['account_id'].'"/>
<input type="hidden" name="sci_name" value="'.$extra_code['sci_name'].'">
<input type="hidden" name="amount" value="'.number_format($amount, 2, '.', '').'"/>
<input type="hidden" name="currency" value="'.$extra_code['currency'].'"/>
<input type="hidden" name="item_id" value="'.$lang['deposit_on'].' '.$site_name.'"/>
<input type="hidden" name="notify_url" value="'.\CoreHelp::getSiteUrl().'plugins/stp/process/ipn">
<input type="hidden" name="return_url" value="'.\CoreHelp::getSiteUrl().'plugins/stp/process/success"/>
<input type="hidden" name="cancel_url" value="'.\CoreHelp::getSiteUrl().'plugins/stp/process/cancel"/>
<input type="hidden" name="user1" value="'.$hash.'" />
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

function setFilterStpSendMoney($account, $amount, $id) {
	
	ini_set('max_execution_time', 0);
	include(__DIR__."/stp/api/details.php");
	
	$urladdress = "https://solidtrustpay.com/accapi/process.php"; 
	
	$api_pwd = md5($api_pwd.'s+E_a*'); 
	$data = "user=".$account. "&testmode=0&api_id=".$api_id. "&api_pwd=".$api_pwd. "&amount=".$amount."&paycurrency=".$currency."&comments=".$note."&fee=0&udf1=".$id;
	// Call STP API
	
	$ch = curl_init(); curl_setopt($ch, CURLOPT_URL,"$urladdress"); 
	curl_setopt($ch, CURLOPT_POST, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_HEADER, 0); //use this to suppress output 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);// tell cURL to graciously accept an SSL certificate 
	$result = curl_exec ($ch) or die(curl_error($ch)); 
	curl_close ($ch);
	
	if(substr_count($result, 'DECLINED') > 0) {
		\CoreHelp::setSession('error', 'Error provided by Solid Trust Pay API: ' . $result);
		return false;		
	}
	else {
		\CoreHelp::setSession('message', 'Transaction to Solid Trust Pay proceed succesfully!');
		return true;
	}
}

function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'stp'");
    	if ($db->count() === 0) {
        	$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('stp', 'Solid Trust Pay', 'stp_username', 'https://solidtrustpay.com/handle.php', '0.00', '0.00', 1, 1, 'a:3:{s:8:\"sci_name\";s:0:\"\";s:12:\"sci_password\";s:0:\"\";s:8:\"currency\";s:3:\"USD\";}', 'https://solidtrustpay.com/handle.php');
");	
		}
    }
	
}




?>