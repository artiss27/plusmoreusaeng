<?php


class Process_Controller extends iMVC_Controller
{
	
	public function anyIpn()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'skrill');
		$processor   = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='skrill'");
		$extra_code  = unserialize($processor['extra_code']);
		
		$checknumber=strtoupper(md5($_POST['merchant_id'].$_POST['transaction_id'].strtoupper(md5($extra_code['secret_word'])).$_POST['amount'].$_POST['currency'].$_POST['status']));
		
		
		if ($checknumber == $_POST['md5sig']) {
			
			list($memberId, $amount) = explode('|', \tmvc::instance()->controller->cache->get(CoreHelp::GetQuery('transaction_id')));
			$status = CoreHelp::GetQuery('status');	
						
			if ($status == 2 && CoreHelp::GetQuery('pay_to_email') == $processor['account_id'] && CoreHelp::GetQuery('amount') == $amount && strtolower(CoreHelp::GetQuery('currency')) == strtolower($extra_code['currency']) && $memberId) {
				
				\tmvc::instance()->controller->cache->set(CoreHelp::GetQuery('transaction_id'), '', 1);
				
				if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
					$amount = round(($amount - $processor['fee_flat']) / (1 + $processor['fee_percent'] / 100), 2);
				}
				$this->core->db->insert('wallet_deposit', array(
					'member_id' => $memberId,
					'amount' => number_format($amount, 2, '.', ''),
					'processor_id' => $processor['processor_id'],
					'transaction_id' => CoreHelp::GetQuery('mb_transaction_id'),
					'transaction_date' => time(),
					'descr' => $plugin_lang['from_account'] . ' ' . CoreHelp::GetQuery('pay_from_email') . ' ' . $plugin_lang['to_account'] . ' ' . CoreHelp::GetQuery('pay_to_email')
				));
				
				$f = fopen("storage/logs/skrill_success.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($_POST) . ";\n\n");
				fclose($f);				
				
			} else {
				$f = fopen("storage/logs/skrill_error.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; REASON: fake data; POST: " . serialize($_POST) . ";\n\n");
				fclose($f);
			}
			
		} elseif ($result == 'INVALID') {
			$f = fopen("storage/logs/skrill_error.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "; REASON: INVALID; POST: " . serialize($_POST) . ";\n\n");
			fclose($f);
			
		} elseif ($result == 'TEST') {
			$f = fopen("storage/logs/skrill_error.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "; REASON: TEST; POST: " . serialize($_POST) . ";\n\n");
			fclose($f);
		} else {
			// IPN not verified or connection errors
			// If status != 200 IPN will be repeated later
			$f = fopen("storage/logs/skrill_error.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "; REASON: CONNECTION TO IPN ERROR; POST: " . serialize($_POST) . ";\n\n");
			fclose($f);
			header("HTTP/1.1 404 Not Found");
			exit;
		}
	}
	
	public function anySuccess()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'skrill');
		CoreHelp::setSession('message', $plugin_lang['your_skrill_deposit_will_appear_shortly_in_your_account']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
	public function anyCancel()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'skrill');
		CoreHelp::setSession('error', $plugin_lang['your_skrill_deposit_was_cancelled']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
}
