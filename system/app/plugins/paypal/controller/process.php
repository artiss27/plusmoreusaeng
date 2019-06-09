<?php


class Process_Controller extends iMVC_Controller
{
	
	public function anyIpn()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'paypal');
		$processor   = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='paypal'");
		$extra_code  = unserialize($processor['extra_code']);
		// Assign payment notification values to local variables
		$item_name        = $_POST['item_name'];
		$item_number      = $_POST['item_number'];
		$payment_status   = $_POST['payment_status'];
		$payment_amount   = $_POST['mc_gross'];
		$payment_currency = $_POST['mc_currency'];
		$txn_id           = $_POST['txn_id'];
		$receiver_email   = $_POST['receiver_email'];
		$payer_email      = $_POST['payer_email'];
		
		// Build the required acknowledgement message out of the notification just received
		$req = 'cmd=_notify-validate'; // Add 'cmd=_notify-validate' to beginning of the acknowledgement
		foreach ($_POST as $key => $value) { // Loop through the notification NV pairs
			$value = urlencode(stripslashes($value)); // Encode these values
			$req .= "&$key=$value"; // Add the NV pairs to the acknowledgement
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.paypal.com/cgi-bin/webscr');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Host: www.paypal.com'
		));
		$res = curl_exec($ch);
		curl_close($ch);		
		
		if (strcmp ($res, "VERIFIED") == 0) {
			
			list($memberId, $amount) = explode('|', \tmvc::instance()->controller->cache->get(CoreHelp::GetQuery('custom')));
			
			if (CoreHelp::GetQuery('mc_gross') == $amount && CoreHelp::GetQuery('receiver_email') == $processor['account_id'] && strtolower(CoreHelp::GetQuery('mc_currency')) == strtolower($extra_code['currency']) && $memberId) {
				\tmvc::instance()->controller->cache->set(CoreHelp::GetQuery('custom'), '', 1);
				
				if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
					$amount = round(($amount - $processor['fee_flat']) / (1 + $processor['fee_percent'] / 100), 2);
				}
				$this->core->db->insert('wallet_deposit', array(
					'member_id' => $memberId,
					'amount' => number_format($amount, 2, '.', ''),
					'processor_id' => $processor['processor_id'],
					'transaction_id' => CoreHelp::GetQuery('txn_id'),
					'transaction_date' => time(),
					'descr' => $plugin_lang['from_account'] . ' ' . CoreHelp::GetQuery('payer_email') . ' ' . $plugin_lang['to_account'] . ' ' . CoreHelp::GetQuery('receiver_email')
				));
				
				$f = fopen("storage/logs/paypal_success.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($_POST) . ";\n\n");
				fclose($f);
				
			} else {
				$f = fopen("storage/logs/paypal_error.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; REASON: fake data; POST: " . serialize($_POST) . ";\n\n");
				fclose($f);
			}
			
		} else {
			// IPN not verified or connection errors
			// If status != 200 IPN will be repeated later
			$f = fopen("storage/logs/paypal_error.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "; REASON: INVALID TOKEN; POST: " . serialize($_POST) . ";\n\n");
			fclose($f);
		}
	}
	
	public function anySuccess()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'paypal');
		CoreHelp::setSession('message', $plugin_lang['your_paypal_deposit_will_appear_shortly_in_your_account']);	
		CoreHelp::setSession('paypal', true);
		CoreHelp::redirect('/system/app/plugins/cart/ShoppingCart/dopayment.php');
	}
	
	public function anyCancel()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'paypal');
		CoreHelp::setSession('error', $plugin_lang['your_paypal_deposit_was_cancelled']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
}
