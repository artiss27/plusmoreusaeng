<?php

namespace processor\okpay;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('okpay', '\processor\okpay\setActionOkpay');
$hooks->add_filter('api_send_money_okpay', '\processor\okpay\setFilterOkpaySendMoney');

function setActionOkpay($amount)
{
	$lang = \CoreHelp::getLang('members');
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='okpay'");
	$extra_code = unserialize($processor['extra_code']);
	$hash 		= md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() .'|' . $amount, 60*60*24);
	$site_name  = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
	$processor_form = '
<form action="'.$processor['processor_url'].'" method="post" id="'.$processor['code'].'">
<input type="hidden" name="ok_receiver" value="'.$processor['account_id'].'">
<input type="hidden" name="ok_item_1_name" value="'.$lang['deposit_on'].' '.$site_name.'">
<input type="hidden" name="ok_item_1_article" value="'.$hash.'">
<input type="hidden" name="ok_item_1_price" value="'.number_format($amount, 2, '.', '').'">
<input type="hidden" name="ok_currency" value="'.$extra_code['currency'].'">
<input type="hidden" name="ok_return_success" value="'.\CoreHelp::getSiteUrl().'plugins/okpay/process/success">
<input type="hidden" name="ok_return_fail" value="'.\CoreHelp::getSiteUrl().'plugins/okpay/process/cancel">
<input type="hidden" name="ok_ipn" value="'.\CoreHelp::getSiteUrl().'plugins/okpay/process/ipn">
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
	include(__DIR__."/okpay/api/details.php");	
	try
    {
       $secWord  = $api_password; // wallet API password
       $WalletID = $wallet_id; // wallet ID
  
       $datePart = gmdate("Ymd:H");
       $authString = $secWord.":".$datePart;
  
       $secToken = hash('sha256', $authString);
       $secToken = strtoupper($secToken);  

       // Connecting to SOAP
       $opts = array(
           'http'=>array(
               'user_agent' => 'PHPSoapClient'
           )
       );
       $context = stream_context_create($opts);
       $client = new \SoapClient("https://api.okpay.com/OkPayAPI?wsdl",
                                   array(
                                       'stream_context' => $context,
                                       'cache_wsdl' => WSDL_CACHE_NONE)
                               );  
       $obj->WalletID = $WalletID;
       $obj->SecurityToken = $secToken;
       $obj->Currency = $currency;
       $obj->Receiver = $account; // can be WalletID, E-mail or cellphone number
       $obj->Amount = number_format($amount, 2, '.', '');
       $obj->Comment = $note;
       $obj->IsReceiverPaysFees = FALSE;
       $webService = $client->Send_Money($obj);
       $wsResult = $webService->Send_MoneyResult;
       \CoreHelp::setSession('message', 'Transaction to Okpay proceed succesfully!');
		return true;  
   }
   catch (\Exception $e)
   {
	   \CoreHelp::setSession('error', 'Transaction to Okpay have error: ' . $e->getMessage());
		return false;
   }
		
}

function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'okpay'");
    	if ($db->count() === 0) {
        	$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('okpay', 'Okpay', 'account', 'https://www.okpay.com/process.html', '0.00', '0.00', 1, 1, 'a:1:{s:8:\"currency\";s:3:\"USD\";}', 'https://www.okpay.com/process.html');
");	
		}
    }
	
}




?>