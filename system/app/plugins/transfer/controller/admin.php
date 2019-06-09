<?php

class Admin_Controller extends iMVC_Controller
{
	
	public function getSettings() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'transfer_settings'
        ));
        $this->smarty->display('plugins/transfer/views/admin_transfer_settings.tpl');
	}
	
	public function postSettings() {
		$this->admin->CheckLogin();
		$this->admin->SetSetting('money_trasnfer_active', CoreHelp::GetQuery('money_trasnfer_active'));
		$this->admin->SetSetting('transfer_min_amount', intval(CoreHelp::GetQuery('transfer_min_amount')));
		$this->admin->SetSetting('transfer_max_amount', intval(CoreHelp::GetQuery('transfer_max_amount')));
		$this->admin->SetSetting('transfer_fee_percent', intval(CoreHelp::GetQuery('transfer_fee_percent')));
		CoreHelp::setSession('message', 'Transfer settings saved successfully.');
        CoreHelp::redirect('back');
	
	}

}
