<?php

namespace processor\payeer;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('payeer', '\processor\payeer\setActionPayeer');
$hooks->add_filter('api_send_money_payeer', '\processor\payeer\setFilterPayeerSendMoney');

function setActionPayeer($amount)
{
	$lang = \CoreHelp::getLang('members');
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='payeer'");
	$extra_code = unserialize($processor['extra_code']);
	$hash 		= md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() .'|' . $amount, 60*60*24);
	$site_name  = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
	 $arHash = array(
            $processor['account_id'],
            $hash,
            number_format($amount, 2, '.', ''),
            $extra_code['currency'],
            base64_encode($lang['deposit_on'].' '.$site_name),
            $extra_code['merchant_key']
        );
        $sign = strtoupper(hash('sha256', implode(':', $arHash)));
	$processor_form = '
<form action="'.$processor['processor_url'].'" method="post" id="'.$processor['code'].'">
<input type="hidden" name="m_shop" value="'.$processor['account_id'].'">
<input type="hidden" name="m_orderid" value="'.$hash.'">
<input type="hidden" name="m_amount" value="'.number_format($amount, 2, '.', '').'">
<input type="hidden" name="m_curr" value="'.$extra_code['currency'].'">
<input type="hidden" name="m_desc" value="'.base64_encode($lang['deposit_on'].' '.$site_name).'">
<input type="hidden" name="m_sign" value="'.$sign.'"> 
<input type="hidden" name="m_process" value="send" />
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

function setFilterPayeerSendMoney($account, $amount, $id) {
	
	ini_set('max_execution_time', 0);
	include(__DIR__."/payeer/api/cpayeer.php");
	include(__DIR__."/payeer/api/details.php");
	
	$accountNumber = $account_number;
	$apiId = $api_id;
	$apiKey = $api_key;
	$payeer = new \CPayeer($accountNumber, $apiId, $apiKey);
	if ($payeer->isAuth())
	{
		$initOutput = $payeer->initOutput(array(
			'ps' => '1136053',
			//'sumIn' => 1,
			'curIn' => $currency,
			'sumOut' => $amount,
			'curOut' => $currency,
			'param_ACCOUNT_NUMBER' => $account
		));
	
		if ($initOutput)
		{
			$historyId = $payeer->output();
			if ($historyId > 0)
			{
				\CoreHelp::setSession('message', 'Transaction to Payeer proceed succesfully!');
				return true; 	
			}
			else
			{
				\CoreHelp::setSession('error', 'Error provided by Payeer API: ' . '<pre>'.print_r($payeer->getErrors(), true).'</pre>');
				return false;
			}
		}
		else
		{
			\CoreHelp::setSession('error', 'Error provided by Payeer API: ' . '<pre>'.print_r($payeer->getErrors(), true).'</pre>');
			return false;
		}
	}
	else
	{
		\CoreHelp::setSession('error', 'Error provided by Payeer API: ' . '<pre>'.print_r($payeer->getErrors(), true).'</pre>');
		return false;
	}
	
}

function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'payeer'");
    	if ($db->count() === 0) {
        	$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('payeer', 'Payeer', 'name@domain.com', 'https://payeer.com/merchant/', '0.00', '0.00', 1, 1, 'a:2:{s:8:\"currency\";s:3:\"USD\";s:12:\"merchant_key\";s:0:\"\";}', 'https://payeer.com/merchant/');
");	
		}
    }
	
}




?>