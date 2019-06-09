<?php

class Member_Controller extends iMVC_Controller
{
	
	public function getTransfer()
	{
		if (!CoreHelp::memberIsLoggedIn()) {
			CoreHelp::redirect('/members/login/');
		}
		$this->smarty->template_dir = 'system/app/';
		$lang        = CoreHelp::getLang('members');
		$plugin_lang = CoreHelp::getLangPlugin('members', 'transfer');
		$memberId    = CoreHelp::getMemberId();
		$profile     = $this->member->getProfile($memberId);
		$total_payout     = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $total_deposit    = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
		$this->smarty->assign("total_deposit", $total_deposit);
        $this->smarty->assign("total_payout", $total_payout);
		$this->smarty->assign('settings', $this->core->GetSiteSettings());
		$this->smarty->assign('lang', $lang);
		$this->smarty->assign('plugin_lang', $plugin_lang);
		CoreHelp::setSession('menu', array(
			'main' => 'financial',
			'sub' => 'tranfer'
		));
		$this->smarty->display('plugins/transfer/views/member_transfer.tpl');
	}
	
	public function postTransfer()
	{
		if (!CoreHelp::memberIsLoggedIn()) {
			CoreHelp::redirect('/members/login/');
		}		
		$this->smarty->template_dir = 'system/app/';
		$lang        = CoreHelp::getLang('members');
		$plugin_lang = CoreHelp::getLangPlugin('members', 'transfer');
		$memberId    = CoreHelp::getMemberId();
		$lock = new iMVC_Library_Lock('TRANSFERMONEY_' . $memberId);
        if ($lock->lock() == false) {
        	CoreHelp::redirect('back');
        }
		$settings 			 = $this->core->GetSiteSettings();
		$total['payout']     = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $total['deposit']    = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
		$amount = abs(number_format(CoreHelp::GetQuery('amount'), 2, '.', ''));
		$sender = $this->core->db->queryFirstRow("SELECT * FROM members WHERE member_id = %d", $memberId);
		$target = $this->core->db->queryFirstRow("SELECT * FROM members WHERE username = %s", CoreHelp::GetQuery("username"));
		if(!isset($target['member_id'])) {
			CoreHelp::setSession('error', 'Username does not exist in the system.');
            CoreHelp::redirect('back');			
		}
		elseif($amount < $settings['transfer_min_amount']) {
			CoreHelp::setSession('error', 'The min amount to transfer is: '. $lang['monetary'] . number_format($settings['transfer_min_amount'], 2, '.', ''));
            CoreHelp::redirect('back');	
		}
		elseif($amount > $settings['transfer_max_amount']) {
			CoreHelp::setSession('error', 'The max amount to transfer is: '. $lang['monetary'] . number_format($settings['transfer_max_amount'], 2, '.', ''));
            CoreHelp::redirect('back');	
		}
		elseif(isset($total[CoreHelp::GetQuery('from_wallet')]) && $total[CoreHelp::GetQuery('from_wallet')] < $amount) {
			CoreHelp::setSession('error', 'You dont have enough balance for this transfer');
            CoreHelp::redirect('back');	
		}		
		else {
			if(CoreHelp::GetQuery('from_wallet') == 'payout') {
				$this->member->db->query("INSERT INTO wallet_payout (amount, transaction_type, to_id, transaction_date, descr) 
				VALUES ('-$amount', 2, '" . CoreHelp::sanitizeSQL($memberId) . "', '" . time() . "', 'Transfer From ".ucfirst(CoreHelp::GetQuery('from_wallet'))." To ".CoreHelp::sanitizeSQL(CoreHelp::GetQuery("username"))."  Deposit Wallet')");	
			}
			elseif(CoreHelp::GetQuery('from_wallet') == 'deposit') {
				$this->member->db->query("INSERT INTO wallet_deposit (amount, member_id, transaction_date, descr) 
				VALUES ('-$amount', '" . CoreHelp::sanitizeSQL($memberId) . "', '" . time() . "', 'Transfer From ".ucfirst(CoreHelp::GetQuery('from_wallet'))." Wallet To ".CoreHelp::sanitizeSQL(CoreHelp::GetQuery("username"))."  Deposit Wallet')");
			}
			else {
				CoreHelp::setSession('error', 'Please select a valid wallet to transfer from');
            	CoreHelp::redirect('back');	
			}
			$amount = $amount - $amount * $settings['transfer_fee_percent']	/ 100;
			$this->member->db->query("INSERT INTO wallet_deposit (amount, member_id, transaction_date, descr) 
				VALUES ('$amount', '" . CoreHelp::sanitizeSQL($target['member_id']) . "', '" . time() . "', 'Transfer From ".$sender['username']."')");
			
			CoreHelp::setSession('message', 'Transfer transaction proceed successfully');
            CoreHelp::redirect('back');	
			
		}
		
		
	}
	
}
?>