<?php


class Process_Controller extends iMVC_Controller
{
	
	public function anyIpn()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'perfectmoney');
		$processor  = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='perfect_money'");
		$extra_code = unserialize($processor['extra_code']);
		
		$string = $_POST['PAYMENT_ID'] . ':' . $_POST['PAYEE_ACCOUNT'] . ':' . $_POST['PAYMENT_AMOUNT'] . ':' . $_POST['PAYMENT_UNITS'] . ':' . $_POST['PAYMENT_BATCH_NUM'] . ':' . $_POST['PAYER_ACCOUNT'] . ':' . $extra_code['pass_phrase_hash'] . ':' . $_POST['TIMESTAMPGMT'];
		
		$hash = strtoupper(md5($string));
		
		if ($hash == $_POST['V2_HASH'] && $_POST['HASH']) {
			
			list($memberId, $amount) = explode('|', \tmvc::instance()->controller->cache->get($_POST['HASH']));
			
			if ($_POST['PAYMENT_AMOUNT'] == $amount && $_POST['PAYEE_ACCOUNT'] == $processor['account_id'] && strtolower($_POST['PAYMENT_UNITS']) == strtolower($extra_code['currency']) && $memberId) {

				\tmvc::instance()->controller->cache->set($_POST['HASH'], '', 1);
				
				if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
					$amount = round(($amount - $processor['fee_flat']) / ( 1 + $processor['fee_percent']/100), 2);
				}				
				$this->core->db->insert('wallet_deposit', array(
				'member_id' => $memberId,
				'amount' => number_format($amount, 2, '.', ''),
				'processor_id' => $processor['processor_id'],
				'transaction_id' => $_POST['PAYMENT_BATCH_NUM'],
				'transaction_date' => time(),
				'descr' => $plugin_lang['from_account'] . ' ' . $_POST['PAYER_ACCOUNT'] . ' ' . $plugin_lang['to_account'] . ' ' . $_POST['PAYEE_ACCOUNT']
				));
				
				$f=fopen("storage/logs/perfect_money_success.log", "ab+");
				fwrite($f, date("d.m.Y H:i")."; POST: ".serialize($_POST)."; HASH: $hash\n\n");
				fclose($f);
				
			} else { 
				$f=fopen("storage/logs/perfect_money_error.log", "ab+");
				fwrite($f, date("d.m.Y H:i")."; REASON: fake data; POST: ".serialize($_POST)."; HASH: $hash\n\n");
				fclose($f);				
			}						
		} else { 
			$f=fopen("storage/logs/perfect_money_error.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "; REASON: bad hash; POST: " . serialize($_POST) . "; HASH: $hash | ". $string  ."\n\n");
			fclose($f);			
		}		
	}
	
	public function anySuccess()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'perfectmoney');
		CoreHelp::setSession('message', $plugin_lang['your_perfect_money_deposit_will_appear_shortly_in_your_account']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
	public function anyCancel()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'perfectmoney');
		CoreHelp::setSession('error', $plugin_lang['your_perfect_money_deposit_was_cancelled']);
		CoreHelp::redirect('/members/depositwallet');
	}

}
