<?php

namespace processor\paypal;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('paypal', '\processor\paypal\setActionPaypal');
$hooks->add_filter('api_send_money_paypal', '\processor\paypal\setFilterPaypalSendMoney');

function setActionPaypal($amount)
{
	$lang = \CoreHelp::getLang('members');
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='paypal'");
	$extra_code = unserialize($processor['extra_code']);
	$hash 		= md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() .'|' . $amount, 60*60*24);
	$site_name  = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
	$processor_form = '
<form method="post" action="'.$processor['processor_url'].'" id="'.$processor['code'].'" >
		<input type="hidden" name="cmd" value="_xclick" />
		<input type="hidden" name="cbt" value="Return to '.$site_name.'" />
		<input type="hidden" name="business" value="'.$processor['account_id'].'" />
		<input type="hidden" name="item_name" value="'.$lang['deposit_on'].' '.$site_name.'" />
		<input type="hidden" name="amount" value="'.number_format($amount, 2, '.', '').'">
		<input type="hidden" name="button_subtype" value="services" />
		<input type="hidden" name="no_shipping" value="1">
		<input type="hidden" name="return" value="'.\CoreHelp::getSiteUrl().'plugins/paypal/process/success/" />
		<input type="hidden" name="notify_url" value="'.\CoreHelp::getSiteUrl().'plugins/paypal/process/ipn/"/>
		<input type="hidden" name="cancel_return" value="'.\CoreHelp::getSiteUrl().'plugins/paypal/process/cancel/" />
		<input type="hidden" name="currency_code" value="'.$extra_code['currency'].'"/>
		<input type="hidden" name="image_url" value="" />
		<input type="hidden" id="custom" name="custom" value="'.$hash.'"/>
 		<input type="hidden" class="btn btn-primary" style="width:100%" alt="PayPal - The safer, easier way to pay online!"/>
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

function setFilterPaypalSendMoney($account, $amount, $id) {
	\CoreHelp::setSession('error', 'Paypal is not active for single API payout, Mass payment can be available on command line if you purchased the mass payment plugin on mlmsoftware.one');
	return false;	
}

function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'paypal'");
    	if ($db->count() === 0) {
        	$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('paypal', 'Paypal', 'name@domain.com', 'https://www.paypal.com/cgi-bin/webscr', '0.00', '0.00', 1, 1, 'a:1:{s:8:\"currency\";s:3:\"USD\";}', 'https://www.paypal.com/cgi-bin/webscr');
");	
		}
    }
	
}




?>