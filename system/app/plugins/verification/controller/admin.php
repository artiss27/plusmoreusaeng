<?php

class Admin_Controller extends iMVC_Controller
{	
	public function getSettings() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
		$this->smarty->assign('memberships', $this->core->GetMemberships());
        CoreHelp::setSession('menu', array(
            'main' => 'members',
            'sub' => 'verification_settings'
        ));
        $this->smarty->display('plugins/verification/views/admin_verification_settings.tpl');
	}
	
	public function postSettings() {
		$this->admin->CheckLogin();
		$this->admin->SetSetting('verification_is_forced', CoreHelp::GetValidQuery('verification_is_forced'));
		$this->admin->SetSetting('verification_max_days', intval(CoreHelp::GetValidQuery('verification_max_days')));
		CoreHelp::setSession('message', 'Member verification settings saved successfully.');
        CoreHelp::redirect('back');
			
	}
	
	public function getPending() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
		$this->load->plugin_model('Verification_Model', 'verification');
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
		$this->smarty->assign('pending', $this->verification->getPending());
        CoreHelp::setSession('menu', array(
            'main' => 'members',
            'sub' => 'verification_pending'
        ));
        $this->smarty->display('plugins/verification/views/admin_verification_pending.tpl');
	}
	
	public function getVerified() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
		$this->load->plugin_model('Verification_Model', 'verification');
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
		$this->smarty->assign('verified', $this->verification->getVerified());
        CoreHelp::setSession('menu', array(
            'main' => 'members',
            'sub' => 'verification_verified'
        ));
        $this->smarty->display('plugins/verification/views/admin_verification_pending.tpl');
	}
	
	public function getRequest() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'verification');
		$this->load->plugin_model('Verification_Model', 'verification');
        $this->verification->setRequest(CoreHelp::GetValidQuery('member_id'), CoreHelp::GetValidQuery('request'));
		$message = $plugin_lang['your_verification_status'] . $plugin_lang[CoreHelp::GetValidQuery('request')];
		$this->messages->sendmessage(CoreHelp::GetValidQuery('member_id'), 1, $plugin_lang['verification_status'], $message, 1, "normal", $msgid);
		CoreHelp::setSession('message', 'Status changed successfully.');
        CoreHelp::redirect('back');
	}
    
    
    
}
