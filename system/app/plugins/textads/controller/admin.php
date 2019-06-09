<?php

class Admin_Controller extends iMVC_Controller
{
        
    public function getPending()
    {
        $this->admin->CheckLogin();
        $this->load->plugin_model('Textads_Model', 'textads');
        $this->smarty->template_dir = 'system/app/';
        $this->smarty->assign('list', $this->textads->getTextadPending());
        CoreHelp::setSession('menu', array(
            'main' => 'textad_system',
            'sub' => 'textad_pending'
        ));
        $this->smarty->display('plugins/textads/views/admin_ad_textad_pending.tpl');
    }
    
    public function getPendingaction()
    {
        $this->admin->CheckLogin();
        $this->load->plugin_model('Textads_Model', 'textads');
        $this->smarty->template_dir = 'system/app/';
        $id                         = CoreHelp::GetQuery('approve') ? CoreHelp::GetQuery('approve') : CoreHelp::GetQuery('disapprove');
        $value                      = CoreHelp::GetQuery('approve') ? 1 : 2;
        $type                       = CoreHelp::GetQuery('approve') ? 'Approved' : 'Disapproved';
        $textad                     = $this->textads->getTextadId($id);
        $this->textads->updateTableById('ad_textads', $id, array(
            'approved' => $value
        ));
        $from    = 1;
        $subject = 'Textad Ad ' . $type;
        $content = 'Dear Member,

Your Textad with campaign Id: ' . $id . ', was ' . $type . ' by our staff.

Support Team
';
        $this->messages->sendmessage($textad['member_id'], 1, $subject, $content, 1, "normal", md5(uniqid()));
        CoreHelp::setSession('message', 'Textad successfully ' . $type);
        CoreHelp::redirect('back');
    }
    
	public function getActive() {
		$this->admin->CheckLogin();
        $this->load->plugin_model('Textads_Model', 'textads');
        $this->smarty->template_dir = 'system/app/';
        $this->smarty->assign('list', $this->textads->getTextadActive());
        CoreHelp::setSession('menu', array(
            'main' => 'textad_system',
            'sub' => 'textad_active'
        ));
        $this->smarty->display('plugins/textads/views/admin_ad_textad_active.tpl');
	}
	
	public function getSettings() {
		$this->admin->CheckLogin();
        $this->load->plugin_model('Textads_Model', 'textads');
        $this->smarty->template_dir = 'system/app/';
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
        CoreHelp::setSession('menu', array(
            'main' => 'textad_system',
            'sub' => 'textad_settings'
        ));
        $this->smarty->display('plugins/textads/views/admin_ad_textad_settings.tpl');
	}
	
	public function postSettings() {
		$this->admin->CheckLogin();
        $this->load->plugin_model('Textads_Model', 'textads');
		Validator\LIVR::defaultAutoTrim(true);
        $validator = new Validator\LIVR(array(
            'max_textad_countries' => 'required',
            'min_textad_bid' => 'required'
        ));
        $validData = $validator->validate(CoreHelp::GetQueryAll());
			if (!$validData)
			{
				CoreHelp::setSession('error', $validator->getErrors());
            	CoreHelp::redirect('back');
			}
			else
			{
				$this->admin->SetSetting('max_textad_countries', CoreHelp::GetQuery('max_textad_countries'));
				$this->admin->SetSetting('min_textad_bid', CoreHelp::GetQuery('min_textad_bid'));
				CoreHelp::setSession('message', 'Textad settings saved successfully.');
            	CoreHelp::redirect('back');
			}				
	}
	
	public function getDeletenetwork() {
		$this->admin->CheckLogin();
        $this->load->plugin_model('Textads_Model', 'textads');
		$this->textads->deleteTextadNetworkById(CoreHelp::GetQuery('id'));
		CoreHelp::setSession('message', 'Textad deleted successfully.');
        CoreHelp::redirect('back');				
	}
	
    public function postMassupdate()
    {
        $this->admin->CheckLogin();
        $this->load->plugin_model('Textads_Model', 'textads');
        $this->smarty->template_dir = 'system/app/';
        $value                      = CoreHelp::GetQuery('do') == "approve" ? 1 : 2;
        $type                       = CoreHelp::GetQuery('do') == "approve" ? 'Approved' : 'Disapproved';
        foreach (CoreHelp::GetQuery('ids') as $id) {
            $ad = $this->textads->getTextadId($id);
            $this->textads->updateTableById('ad_textads', $id, array(
                'approved' => $value
            ));
            $from    = 1;
            $subject = 'Textad Ad ' . $type;
            $content = 'Dear Member,

Your Textad Ad with campaign Id: ' . $id . ', was ' . $type . ' by our staff.

Support Team
';
            $this->messages->sendmessage($textad['member_id'], 1, $subject, $content, 1, "normal", md5(uniqid()));
            
        }
        CoreHelp::setSession('message', 'Selected Campaigns where ' . $type . ' successfully.');
        CoreHelp::redirect('back');
    }    
    
}
