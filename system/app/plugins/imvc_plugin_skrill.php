<?php

namespace processor\skrill;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('skrill', '\processor\skrill\setActionSkrill');
$hooks->add_filter('api_send_money_skrill', '\processor\skrill\setFilterSkrillSendMoney');

function setActionSkrill($amount)
{
	$lang = \CoreHelp::getLang('members');
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='skrill'");
	$extra_code = unserialize($processor['extra_code']);
	$hash 		= md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() .'|' . $amount, 60*60*24);
	$site_name  = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
	$processor_form = '
<form action="'.$processor['processor_url'].'" method="post" id="'.$processor['code'].'">
<input type="hidden" name="pay_to_email" value="'.$processor['account_id'].'">
<input type="hidden" name="transaction_id" value="'.$hash.'">
<input type="hidden" name="return_url" value="'.\CoreHelp::getSiteUrl().'plugins/skrill/process/success">
<input type="hidden" name="cancel_url" value="'.\CoreHelp::getSiteUrl().'plugins/skrill/process/cancel">
<input type="hidden" name="status_url" value="'.\CoreHelp::getSiteUrl().'plugins/skrill/process/ipn">
<input type="hidden" name="language" value="EN">
<input type="hidden" name="amount" value="'.number_format($amount, 2, '.', '').'">
<input type="hidden" name="currency" value="'.$extra_code['currency'].'">
<input type="hidden" name="detail1_description" value="'.$lang['deposit_on'].' '.$site_name.'">
<input type="hidden" name="detail1_text" value=" ">
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

function setFilterSkrillSendMoney($account, $amount, $id) {
	
	ini_set('max_execution_time', 0);
	include(__DIR__."/skrill/api/details.php");
	
	$url = 'https://www.skrill.com/app/pay.pl?action=prepare&email='.$email.'&password='.$md5_mqi_api_password.'&amount='.$amount.'&currency='.$currency.'&bnf_email='.$account.'&subject=Withdrawal&note='.$note.'&frn_trn_id=' . $id;
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
	
	if(substr_count($text, 'sid') > 0) {
		\CoreHelp::setSession('message', 'Transaction to Skrill proceed succesfully!');
		return true;
	}
	else {
		$error = value_in('error_msg', $result);
		\CoreHelp::setSession('error', 'Error provided by Skrill API: ' . $error);
		return false;
	}
}

function value_in($element_name, $xml) {
    if ($xml == false) {
        return false;
    }
    $found = preg_match('#<'.$element_name.'(?:\s+[^>]+)?>(.*?)'.
            '</'.$element_name.'>#s', $xml, $matches);
    if ($found != false) {
		 return $matches[1];
    }
    return false;
}

function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'skrill'");
    	if ($db->count() === 0) {
        	$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('skrill', 'Skrill', 'name@domain.com', 'https://www.moneybookers.com/app/payment.pl', '0.00', '0.00', 1, 1, 'a:2:{s:8:\"currency\";s:3:\"USD\";s:11:\"secret_word\";s:0:\"\";}', 'https://www.moneybookers.com/app/test_payment.pl');
");	
		}
    }
	
}




?>