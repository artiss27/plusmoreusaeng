<?php


class Process_Controller extends iMVC_Controller
{
	
	public function anyCc()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'authorize');
		$processor   = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='authorize'");
		$extra_code  = unserialize($processor['extra_code']);
		
		$ap_itemname = CoreHelp::GetQuery("ap_itemname");
		$ap_description = CoreHelp::GetQuery("ap_description");
		$ap_returnurl = CoreHelp::GetQuery("ap_returnurl");
		$ap_cancelurl = CoreHelp::GetQuery("ap_cancelurl");
	
		$first_name = CoreHelp::GetQuery("first_name");
		$last_name = CoreHelp::GetQuery("last_name");
		$cc_card_num= CoreHelp::GetQuery("cc_card_num");
		$cc_exp_date = CoreHelp::GetQuery("cc_exp_date");
		$cc_cvv2 = CoreHelp::GetQuery("cc_cvv2");	
		list($memberId, $amount) = explode('|', $this->cache->get(CoreHelp::GetQuery('apc_1')));
		
		if ($amount > 0 && $memberId) {
			$api_id = $processor['account_id'];
			$securitycode = $extra_code['authKey'];	
	
			require("system/app/plugins/authorize/api/AuthnetAIM.class.php");	

			$payment = new AuthnetAIM($api_id, $securitycode);
			$payment->setTransaction($first_name, $last_name, $cc_card_num, $cc_exp_date, $amount, $cc_cvv2);
			$payment->process();			
			
			if ($payment->isApproved())	{				
				$this->cache->set(CoreHelp::GetQuery('apc_1'), '', 1);
				
				if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
					$amount = round(($amount - $processor['fee_flat']) / (1 + $processor['fee_percent'] / 100), 2);
				}
				$this->core->db->insert('wallet_deposit', array(
					'member_id' => $memberId,
					'amount' => number_format($amount, 2, '.', ''),
					'processor_id' => $processor['processor_id'],
					'transaction_id' => uniqid(),
					'transaction_date' => time(),
					'descr' => $ap_description
				));
				
				$f = fopen(PATH_TO_LOG . "storage/logs/authorize_success.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($_POST) . ";\n\n");
				fclose($f);
				
			} else {
				$f = fopen(PATH_TO_LOG . "storage/logs/authorize_error.log", "ab+");
				fwrite($f, date("d.m.Y H:i") . "; REASON: error in data; POST: " . $payment->getResponseText() . ";\n\n");
				fclose($f);
				$merror = $payment->getResponseText();
				CoreHelp::setSession('error', $merror);
				CoreHelp::redirect('/members/depositwallet');
			}
						
		} else {
			$f = fopen("storage/logs/authorize_error.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "; REASON: INVALID MEMBERID AND AMOUNT; POST: " . serialize($_POST) . ";\n\n");
			fclose($f);
			CoreHelp::redirect($ap_cancelurl);
			
		}
	}
	
	 public function getDeposit()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }

        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'authorize');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
		$site_name  = $this->core->GetSiteSetting("site_name");
		$amount = number_format($_SESSION['am_amount'], 2, '.', '');		
		$data = array(
            'description' => $lang['deposit_on'].' '.$site_name.' using Authorize.net',
            'amount' => $amount,
            'success_url' => \CoreHelp::getSiteUrl().'plugins/authorize/process/success',
            'cancel_url' => \CoreHelp::getSiteUrl().'plugins/authorize/process/cancel',
			'hash' => $_SESSION['am_hash']
        );
        $this->smarty->assign('data', $data);
		$this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
        $this->smarty->display('plugins/authorize/views/member_authorize.tpl');
		
	}
	
	public function anySuccess()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'authorize');
		CoreHelp::setSession('message', $plugin_lang['your_authorize_deposit_will_appear_shortly_in_your_account']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
	public function anyCancel()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'authorize');
		CoreHelp::setSession('error', $plugin_lang['your_authorize_deposit_was_cancelled']);
		CoreHelp::redirect('/members/depositwallet');
	}
	
}
