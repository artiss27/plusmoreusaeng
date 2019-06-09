<?php


class Process_Controller extends iMVC_Controller
{
	
	public function anyIpn()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'payza');
		$processor   = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='payza'");
		$extra_code  = unserialize($processor['extra_code']);
		
		$response = '';
		$token    = 'token=' . urlencode(CoreHelp::GetQuery('token'));
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, 'https://secure.payza.com/ipn2.ashx');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $token);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$response = curl_exec($ch);
		
		curl_close($ch);
		
		$response = urldecode($response);
		
		//split the response string by the delimeter "&"
		$aps = explode("&", $response);
		
		//define an array to put the IPN information
		$info = array();
		
		foreach ($aps as $ap) {
			//put the IPN information into an associative array $info
			$ele           = explode("=", $ap);
			$info[$ele[0]] = $ele[1];
		}		
		
		if (strlen($response) > 0 && urldecode($response) != "INVALID TOKEN") {
			
			list($memberId, $amount) = explode('|', \tmvc::instance()->controller->cache->get($info['apc_1']));
			
			if ($info['ap_status'] == "Success" && $info['ap_merchant'] == $processor['account_id'] && $info['ap_totalamount'] == $amount && strtolower($info['ap_currency']) == strtolower($extra_code['currency']) && $memberId) {				
				\tmvc::instance()->controller->cache->set(CoreHelp::GetQuery('apc_1'), '', 1);
				
				if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
					$amount = round(($amount - $processor['fee_flat']) / (1 + $processor['fee_percent'] / 100), 2);
				}
				$this->core->db->insert('wallet_deposit', array(
					'member_id' => $memberId,
					'amount' => number_format($amount, 2, '.', ''),
					'processor_id' => $processor['processor_id'],
					'transaction_id' => $info['ap_referencenumber'],
					'transaction_date' => time(),
					'descr' => $plugin_lang['from_account'] . ' ' . $info['ap_custemailaddress'] . ' ' . $plugin_lang['to_account'] . ' ' . $info['ap_merchant']
				));
				
				$f = fopen("storage/logs/payza_success.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($_POST) . ";\n\n");
				fclose($f);
				
			} else {
				$f = fopen("storage/logs/payza_error.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; REASON: fake data; POST: " . serialize($_POST) . ";\n\n");
				fclose($f);
			}
						
		} else {
			// IPN not verified or connection errors
			// If status != 200 IPN will be repeated later
			$f = fopen("storage/logs/payza_error.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "; REASON: INVALID TOKEN; POST: " . serialize($_POST) . ";\n\n");
			fclose($f);
		}
	}
	
	public function anySuccess()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'payza');
		CoreHelp::setSession('message', $plugin_lang['your_payza_deposit_will_appear_shortly_in_your_account']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
	public function anyCancel()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'payza');
		CoreHelp::setSession('error', $plugin_lang['your_payza_deposit_was_cancelled']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
}
