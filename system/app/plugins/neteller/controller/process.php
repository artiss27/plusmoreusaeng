<?php


class Process_Controller extends iMVC_Controller
{
	
	public function anyIpn()
	{
			
	}
	
	public function postForm()
	{
		if (!CoreHelp::memberIsLoggedIn()) {
			CoreHelp::redirect('/members/login/');
		}
		$this->smarty->template_dir = 'system/app/';
		$lang                       = CoreHelp::getLang('members');
		$plugin_lang                = CoreHelp::getLangPlugin('members', 'neteller');
		$memberId                   = CoreHelp::getMemberId();
		$profile                    = $this->member->getProfile($memberId);
		$amount                     = number_format(CoreHelp::GetQuery('amount'));
		if (CoreHelp::GetQuery('net_account')) {
			$processor  = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='neteller'");
			$extra_code = unserialize($processor['extra_code']);
			// get token
			$curl       = curl_init();
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_URL, "https://api.neteller.com/v1/oauth2/token?grant_type=client_credentials");
			curl_setopt($curl, CURLOPT_USERPWD, $extra_code['api_id'] . ":" . $extra_code['api_secret']);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				"Content-Type:application/json",
				"Cache-Control:no-cache"
			));
			curl_setopt($curl, CURLOPT_POSTFIELDS, array(
				"scope" => "default"
			));
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$res          = curl_exec($curl);
			$serverOutput = json_decode($res, true);
			
			$token = $serverOutput['accessToken'];

			$data_string = '{
"paymentMethod": {
"type": "neteller",
 "value": "' . $_REQUEST['net_account'] . '"
	},
"transaction": {
"merchantRefId": "' . uniqid() . '",
"amount": ' . $amount * 100 . ',
"currency": "' . $extra_code['currency'] . '"
 	},
"verificationCode": "' . $_REQUEST['secure_id'] . '"
}';
			
			$ch = curl_init('https://api.neteller.com/v1/transferIn');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				"Authorization: Bearer $token"
			));
			$res = curl_exec($ch);
			
			$result = json_decode($res, true);
			$error  = @$result['error'];
			$status = @$result['transaction']['status'];
			
			if (strlen($error) > 0) {
				CoreHelp::setSession('error', $plugin_lang['payment_failed'] . ':' . $error);
			} elseif ($status == 'accepted') {
				$transaction_id = $result['transaction']['id'];
				CoreHelp::setSession('message', $plugin_lang['payment_successful']);
				if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
					$amount = round(($amount - $processor['fee_flat']) / (1 + $processor['fee_percent'] / 100), 2);
				}
				$this->core->db->insert('wallet_deposit', array(
					'member_id' => $memberId,
					'amount' => number_format($amount, 2, '.', ''),
					'processor_id' => $processor['processor_id'],
					'transaction_id' => $transaction_id,
					'transaction_date' => time(),
					'descr' => $plugin_lang['neteller_deposit']
				));
				
				$f = fopen("storage/logs/neteller_success.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($result) . ";\n\n");
				fclose($f);
				
			} else {
				CoreHelp::setSession('error', $plugin_lang['payment_failed']);
				$f = fopen("storage/logs/neteller_error.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; REASON: unexpected error; POST: " . serialize($result) . ";\n\n");
				fclose($f);				
			}
			
			
		}
		$this->smarty->assign('lang', $lang);
		$this->smarty->assign('plugin_lang', $plugin_lang);
		$this->smarty->assign('amount', $amount);
		CoreHelp::setSession('menu', array(
			'main' => 'financial',
			'sub' => 'deposit_wallet'
		));
		$this->smarty->display('plugins/neteller/views/member_neteller_form.tpl');
	}
	

	public function anySuccess()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'neteller');
		CoreHelp::setSession('message', $plugin_lang['your_neteller_deposit_will_appear_shortly_in_your_account']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
	public function anyCancel()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'neteller');
		CoreHelp::setSession('error', $plugin_lang['your_neteller_deposit_was_cancelled']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
}
