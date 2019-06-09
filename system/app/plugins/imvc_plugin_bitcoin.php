<?php

namespace processor\bitcoin;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('bitcoin', '\processor\bitcoin\setActionBitcoin');

function setActionBitcoin($amount)
{
	$lang = \CoreHelp::getLang('members');
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='bitcoin'");
	$extra_code = unserialize($processor['extra_code']);
	$hash 		= md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() .'|' . $amount, 60*60*24);
	$site_name  = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
	$processor_form = '
<form action="'.$processor['processor_url'].'" method="post" id="'.$processor['code'].'">
	<input type="hidden" name="cmd" value="_pay">
	<input type="hidden" name="reset" value="1">
	<input type="hidden" name="merchant" value="'.$processor['account_id'].'">
	<input type="hidden" name="item_name" value="'.$lang['deposit_on'].' '.$site_name.'">
	<input type="hidden" name="item_number" value="1">
	<input type="hidden" name="invoice" value="'.$hash.'">
	<input type="hidden" name="currency" value="'.$extra_code['currency'].'">
	<input type="hidden" name="amount" value="'.number_format($amount, 2, '.', '').'">
	<input type="hidden" name="amountf" value="'.number_format($amount, 2, '.', '').'">
	<input type="hidden" name="quantity" value="1">
	<input type="hidden" name="allow_quantity" value="0">
	<input type="hidden" name="want_shipping" value="0">
	<input type="hidden" name="success_url" value="'.\CoreHelp::getSiteUrl().'plugins/bitcoin/process/success">
	<input type="hidden" name="cancel_url" value="'.\CoreHelp::getSiteUrl().'plugins/bitcoin/process/cancel">
	<input type="hidden" name="allow_extra" value="0">
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

function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'bitcoin'");
    	if ($db->count() === 0) {
$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('bitcoin', 'Bitcoin', 'merchant_id', 'https://www.coinpayments.net/index.php', '0.00', '0.00', 1, 1, 'a:2:{s:10:\"ipn_secret\";s:0:\"\";s:8:\"currency\";s:3:\"USD\";}', 'https://www.coinpayments.net/index.php');
");	
$db->query("
CREATE TABLE IF NOT EXISTS `btc_confirmations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `txnid` varchar(255) NOT NULL,
  `confirmation` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `log` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
");
		}
    }
	
}




?>