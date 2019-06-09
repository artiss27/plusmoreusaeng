<?php

class Admin_Controller extends iMVC_Controller
{	
	public function getSettings() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'invoicer_settings'
        ));
        $this->smarty->display('plugins/invoicer/views/admin_invoicer_settings.tpl');
	}
	
	public function postSettings() {
		$this->admin->CheckLogin();
		if(strlen($_FILES['invoice_logo']['name']) > 0) {
			$invoice_logo   = $this->processImageUpload('invoice_logo');
			$this->admin->SetSetting('invoice_logo', $invoice_logo);
		}
		$this->admin->SetSetting('email_invoice', CoreHelp::GetValidQuery('email_invoice'));
		$this->admin->SetSetting('invoice_color', CoreHelp::GetValidQuery('invoice_color'));
		$this->admin->SetSetting('invoice_vat', number_format(CoreHelp::GetValidQuery('invoice_vat'), 2, '.', ''));
		$this->admin->SetSetting('invoice_company', CoreHelp::GetValidQuery('invoice_company'));
		$this->admin->SetSetting('invoice_language', CoreHelp::GetValidQuery('invoice_language'));
		$this->admin->SetSetting('invoice_company_address', CoreHelp::GetValidQuery('invoice_company_address'));
		$this->admin->SetSetting('invoice_company_city', CoreHelp::GetValidQuery('invoice_company_city'));
		$this->admin->SetSetting('invoice_company_state', CoreHelp::GetValidQuery('invoice_company_state'));
		$this->admin->SetSetting('invoice_company_country', CoreHelp::GetValidQuery('invoice_company_country'));
		$this->admin->SetSetting('invoice_footer_title', CoreHelp::GetValidQuery('invoice_footer_title'));
		$this->admin->SetSetting('invoice_footer_description', CoreHelp::GetValidQuery('invoice_footer_description'));
		$this->admin->SetSetting('invoice_footer_url', CoreHelp::GetValidQuery('invoice_footer_url'));
		CoreHelp::setSession('message', 'Invoice settings saved successfully.');
        CoreHelp::redirect('back');
			
	}
	
	public function getPending() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
		$this->load->plugin_model('Verification_Model', 'invoicer');
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
		$this->smarty->assign('pending', $this->invoicer->getPending());
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'invoicer_pending'
        ));
        $this->smarty->display('plugins/invoicer/views/admin_invoicer_pending.tpl');
	}
	
	public function getVerified() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
		$this->load->plugin_model('Verification_Model', 'invoicer');
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
		$this->smarty->assign('verified', $this->invoicer->getVerified());
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'invoicer_verified'
        ));
        $this->smarty->display('plugins/invoicer/views/admin_invoicer_pending.tpl');
	}
	
	public function getRequest() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'invoicer');
		$this->load->plugin_model('Verification_Model', 'invoicer');
        $this->invoicer->setRequest(CoreHelp::GetValidQuery('member_id'), CoreHelp::GetValidQuery('request'));
		$message = $plugin_lang['your_invoicer_status'] . $plugin_lang[CoreHelp::GetValidQuery('request')];
		$this->messages->sendmessage(CoreHelp::GetValidQuery('member_id'), 1, $plugin_lang['invoicer_status'], $message, 1, "normal", $msgid);
		CoreHelp::setSession('message', 'Status changed successfully.');
        CoreHelp::redirect('back');
	}
	
	private function processImageUpload($name)
    {
        $uploadHandler = new \Sirius\Upload\Handler('media/images');
        $uploadHandler->addRule('extension', array(
            'allowed' => array(
                'jpg',
                'jpeg',
                'png',
                'gif'
            )
        ), 'Should be a valid image' . ' (jpg, jpeg, png)');
        $uploadHandler->addRule('size', array(
            'max' => '1M'
        ), 'Should have less than {max}');
        $result = $uploadHandler->process($_FILES[$name]);
        if (!$result->isValid()) {
            CoreHelp::setSession('error', $result->getMessages());
            CoreHelp::redirect('back');
        }
        return $result->name;        
    }
    
    
    
}
