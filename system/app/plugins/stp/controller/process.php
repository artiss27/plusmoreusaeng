<?php


class Process_Controller extends iMVC_Controller
{
	
	public function anyIpn()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'stp');
		$processor   = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='stp'");
		$extra_code  = unserialize($processor['extra_code']);
		
		$sci_pwd = $extra_code['sci_password'];
		$sci_pwd = md5($sci_pwd.'s+E_a*');
		$hash_received = md5($_POST['tr_id'].":".md5($sci_pwd).":".$_POST['amount'].":".$_POST['merchantAccount'].":".$_POST['payerAccount']);	
		
		if ($hash_received == $_POST['hash']) {
			
			list($memberId, $amount) = explode('|', \tmvc::instance()->controller->cache->get(CoreHelp::GetQuery('user1')));
			
			if (CoreHelp::GetQuery('status') == "COMPLETE" && CoreHelp::GetQuery('merchantAccount') == $processor['account_id'] && CoreHelp::GetQuery('amount') == $amount && $memberId) {
								
				\tmvc::instance()->controller->cache->set(CoreHelp::GetQuery('user1'), '', 1);
				
				if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
					$amount = round(($amount - $processor['fee_flat']) / (1 + $processor['fee_percent'] / 100), 2);
				}
				$this->core->db->insert('wallet_deposit', array(
					'member_id' => $memberId,
					'amount' => number_format($amount, 2, '.', ''),
					'processor_id' => $processor['processor_id'],
					'transaction_id' => CoreHelp::GetQuery('tr_id'),
					'transaction_date' => time(),
					'descr' => $plugin_lang['from_account'] . ' ' . CoreHelp::GetQuery('payerAccount') . ' ' . $plugin_lang['to_account'] . ' ' . CoreHelp::GetQuery('merchantAccount')
				));
				
				$f = fopen("storage/logs/stp_success.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($_POST) . ";\n\n");
				fclose($f);
				
			} else {
				$f = fopen("storage/logs/stp_error.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; REASON: fake data; POST: " . serialize($_POST) . ";\n\n");
				fclose($f);
			}
						
		} else {
			$f = fopen("storage/logs/stp_error.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "; REASON: INVALID HASH; POST: " . serialize($_POST) . ";\n\n");
			fclose($f);
		}
	}
	
	public function anySuccess()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'stp');
		CoreHelp::setSession('message', $plugin_lang['your_stp_deposit_will_appear_shortly_in_your_account']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
	public function anyCancel()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'stp');
		CoreHelp::setSession('error', $plugin_lang['your_stp_deposit_was_cancelled']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
}
