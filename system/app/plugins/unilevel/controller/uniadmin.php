<?php

class Uniadmin_Controller extends iMVC_Controller
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
            'main' => 'settings',
            'sub' => 'unilevelsettings'
        ));
        $this->smarty->display('plugins/unilevel/views/admin_unilevel_settings.tpl');
    }
	
	public function postSettings()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';   
        $umessages = $this->core->getMessages(1);
		$memberships = $this->admin->GetMemberships();
		$levels = CoreHelp::GetQuery('setting_membership_unilevel_levels');
		for ($i = 1; $i<= $levels; $i++) {
			$this->admin->SetSetting('setting_membership_unilevel_unqualified_commision_'.$i, number_format(CoreHelp::GetQuery('setting_membership_unilevel_unqualified_commision_'.$i), 2, '.', ''));	
			$this->admin->SetSetting('setting_membership_unilevel_qualified_commision_'.$i, number_format(CoreHelp::GetQuery('setting_membership_unilevel_qualified_commision_'.$i), 2, '.', ''));	
			$this->admin->SetSetting('setting_membership_unilevel_frontline_commision_'.$i, CoreHelp::GetQuery('setting_membership_unilevel_frontline_commision_'.$i));	
			$this->admin->SetSetting('setting_membership_unilevel_pv_commision_'.$i, CoreHelp::GetQuery('setting_membership_unilevel_pv_commision_'.$i));
			$this->admin->SetSetting('setting_membership_unilevel_gv_commision_'.$i, CoreHelp::GetQuery('setting_membership_unilevel_gv_commision_'.$i));	
		}
		$this->admin->SetSetting('setting_unilevel_round_type', CoreHelp::GetQuery('setting_unilevel_round_type'));
		$this->admin->SetSetting('setting_unilevel_pv_days', intval(CoreHelp::GetQuery('setting_unilevel_pv_days')));
		$this->admin->SetSetting('setting_unilevel_gv_days', intval(CoreHelp::GetQuery('setting_unilevel_gv_days')));
		$this->admin->SetSetting('setting_unilevel_gv_depth', intval(CoreHelp::GetQuery('setting_unilevel_gv_depth')));
		$this->admin->SetSetting('setting_unilevel_dynamic_compression', CoreHelp::GetQuery('setting_unilevel_dynamic_compression'));
		$this->admin->SetSetting('setting_membership_unilevel_levels', intval(CoreHelp::GetQuery('setting_membership_unilevel_levels')));
		$this->admin->SetSetting('settings_qualification_required', CoreHelp::GetQuery('settings_qualification_required'));	
		$this->admin->SetSetting('settings_qualification_required_members', CoreHelp::GetQuery('settings_qualification_required_members'));		
		CoreHelp::setSession('message', 'Unilevel settings saved successfully');
        CoreHelp::redirect('back');
    }
	
	public function anyViewtree()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
        $memberId = CoreHelp::GetQuery('id');
		CoreHelp::setSession('admin_tree', $memberId);
        CoreHelp::setSession('menu', array(
            'main' => 'members',
            'sub' => 'memberlist',
        ));
        $this->smarty->display('plugins/unilevel/views/admin_member_levels.tpl');
    }
    
  
}
