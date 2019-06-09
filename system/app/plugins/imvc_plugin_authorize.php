<?php

namespace processor\authorize;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('authorize', '\processor\authorize\setActionAuthorize');


function setActionAuthorize($amount)
{
	$lang = \CoreHelp::getLang('members');
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='authorize'");
	$extra_code = unserialize($processor['extra_code']);
	$hash 		= md5(uniqid());
	\tmvc::instance()->controller->cache->set($hash, \CoreHelp::getMemberId() .'|' . $amount, 60*60*24);
	$_SESSION['am_hash'] = $hash;
	$_SESSION['am_amount'] = $amount;
	\CoreHelp::redirect('/plugins/authorize/process/deposit');
}


function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'authorize'");
    	if ($db->count() === 0) {
        	$db->query("
			INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
			('authorize', 'Authorize.net', 'apikey', 'https://secure.authorize.net/gateway/transact.dll', '0.00', '0.00', 1, 0, 'a:1:{s:7:\"authKey\";s:0:\"\";} ', 'https://test.authorize.net/gateway/transact.dll');
");	
		}
    }
	
}




?>