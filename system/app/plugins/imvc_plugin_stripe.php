<?php

namespace processor\stripe;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('stripe', '\processor\stripe\setActionstripe');
$hooks->add_filter('api_send_money_stripe', '\processor\stripe\setFilterstripeSendMoney');

function setActionstripe($amount)
{
session_start();
	
	$lang = \CoreHelp::getLang('members');
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='stripe'");
	$extra_code = unserialize($processor['extra_code']);
	$hash 		= md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() .'|' . $amount, 60*60*24);
	$_SESSION['m_orderid']=$hash ;
$_SESSION['stripe_amount']=str_replace(".", "", $amount);
	echo '

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$("iframe").ready(function(){ 
jQuery(".stripe-button-el").trigger("click")
});
</script>
<style>
.stripe_checkout_app{
	display:block !important;
}
.stripe-button-el{
	display:none !important;
}
</style>
	<form action="'.\CoreHelp::getSiteUrl().'plugins/stripe/process/Ipn" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js"
    class="stripe-button"
    data-key="'.$extra_code['api_key'].'"
    data-image="/site/wp-content/uploads/2017/09/PMUhighlighted-1-300x224.png"
    data-name="PlusMoreUsa"
    data-description=""
    data-amount="'.str_replace(".", "", $amount).'">
  </script>
</form>';	
}

function setFilterstripeSendMoney($account, $amount, $id) {
	
	
	$accountNumber = $account_number;
	$apiId = $api_id;
	$apiKey = $api_key;
	$stripe = new \Cstripe($accountNumber, $apiId, $apiKey);
	if ($stripe->isAuth())
	{
		$initOutput = $stripe->initOutput(array(
			'ps' => '1136053',
			//'sumIn' => 1,
			'curIn' => $currency,
			'sumOut' => $amount,
			'curOut' => $currency,
			'param_ACCOUNT_NUMBER' => $account
		));
	
		if ($initOutput)
		{
			$historyId = $stripe->output();
			if ($historyId > 0)
			{
				\CoreHelp::setSession('message', 'Transaction to stripe proceed succesfully!');
				return true; 	
			}
			else
			{
				\CoreHelp::setSession('error', 'Error provided by stripe API: ' . '<pre>'.print_r($stripe->getErrors(), true).'</pre>');
				return false;
			}
		}
		else
		{
			\CoreHelp::setSession('error', 'Error provided by stripe API: ' . '<pre>'.print_r($stripe->getErrors(), true).'</pre>');
			return false;
		}
	}
	else
	{
		\CoreHelp::setSession('error', 'Error provided by stripe API: ' . '<pre>'.print_r($stripe->getErrors(), true).'</pre>');
		return false;
	}
	
}

function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'stripe'");
    	if ($db->count() === 0) {
        	$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('stripe', 'stripe', 'name@domain.com', 'https://stripe.com/merchant/', '0.00', '0.00', 1, 1, 'a:3:{s:8:\"currency\";s:3:\"USD\";s:7:\"api_key\";s:0:\"\";s:14:\"api_secret_key\";s:0:\"\";}', 'https://stripe.com/merchant/');
");	
		}
    }
	
}




?>