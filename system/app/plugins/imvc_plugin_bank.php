<?php

namespace processor\bank;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('bank', '\processor\bank\setActionbank');


function setActionbank($amount)
{
	$lang      = \CoreHelp::getLang('members');
	$processor  = \tmvc::instance()->controller->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='bank'");
	$extra_code = unserialize($processor['extra_code']);

	$sign = hash('sha256', $processor['account_id'].':'.$extra_code['sci_name'].':'.number_format($amount, 2, '.', '').':'.$extra_code['currency'].':'.$extra_code['secondary_password'].':'. $hash);
	$processor_form = '
Please make a Bank Deposit for the amount of <strong>'.$lang['monetary'].' '.$amount.'</strong> To:<br><br>
Bank Name: <strong>'.$extra_code['bank_name'].'</strong><br>
Beneficiary Name: <strong>'.$extra_code['beneficiary_name'].'</strong><br>
Bank Account: <strong>'.$processor['account_id'].'</strong><br><br>

Please after your deposit send the voucher scanned to <strong>'.$extra_code['report_to_email'].'</strong> including your username
';
	$_SESSION['bank_content'] = $processor_form;	
	\CoreHelp::redirect('/plugins/bank/process/deposit');
}

function setTable()
{	
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
    	$db    = \tmvc::instance()->controller->load->database();
    	$check = $db->query("SELECT * FROM payment_processors WHERE code = 'bank'");
    	if ($db->count() === 0) {
        	$db->query("
INSERT INTO `payment_processors` (`code`, `name`, `account_id`, `processor_url`, `fee_flat`, `fee_percent`, `active`, `active_withdrawal`, `extra_code`, `sandbox_url`) VALUES
('bank', 'Bank Deposit', 'bank_account_number', 'manual', '0.00', '0.00', 1, 1, 'a:4:{s:8:\"currency\";s:3:\"USD\";s:9:\"bank_name\";s:0:\"\";s:16:\"beneficiary_name\";s:0:\"\";s:15:\"report_to_email\";s:0:\"\";}', 'https://wallet.bank.com/sci/');
");	
		}
    }
	
}




?>