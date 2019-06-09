<?php

class Sadmin_Controller extends iMVC_Controller
{
    
    public function getSettings()
    {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
        $umessages                  = $this->core->getMessages(1);        
        $this->smarty->assign('total_messages', $umessages);
		$memberships = $this->admin->GetMemberships();
		$this->smarty->assign('memberships', $memberships);
		$settings = $this->admin->GetSiteSettings();
		$this->smarty->assign('settings', $settings);
        CoreHelp::setSession('menu', array(
            'main' => 'memberships',
            'sub' => 'subscription'
        ));
        $this->smarty->display('plugins/subscription/views/admin_subscription_settings.tpl');
		
	}
	
	public function postSettings()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';   
        $umessages = $this->core->getMessages(1);
		$memberships = $this->admin->GetMemberships();
        foreach ($memberships as $membership) {
			$setting = $membership . '_subscription_days';
			$this->admin->SetSetting($setting, CoreHelp::GetQuery($setting));
		}

		$this->admin->SetSetting('subscription_active', CoreHelp::GetQuery('subscription_active'));
		$this->admin->SetSetting('subscription_expired_behaviour', CoreHelp::GetQuery('subscription_expired_behaviour'));
		$this->admin->SetSetting('subscription_expired_rollup', CoreHelp::GetQuery('subscription_expired_rollup'));
		CoreHelp::setSession('message', 'Subscription settings saved successfully');
        CoreHelp::redirect('back');
    }

  
}
