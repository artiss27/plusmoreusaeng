<?php

class Cartadmin_Controller extends iMVC_Controller
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
		$logo = file_exists('media/images/store-logo.png') ? '/media/images/store-logo.png' : '/system/app/plugins/cart/images/store-logo.png';
		$this->smarty->assign('logo', $logo);
		$this->smarty->assign('settings', $settings);
        CoreHelp::setSession('menu', array(
            'main' => 'store',
            'sub' => 'settings'
        ));
        $this->smarty->display('plugins/cart/views/admin_cart_settings.tpl');
    }
	
	public function postSettings()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';   
        $umessages = $this->core->getMessages(1);
		$memberships = $this->admin->GetMemberships();
        foreach ($memberships as $membership) {
			$setting = $membership . '_cart_levels';
			$this->admin->SetSetting($setting, CoreHelp::GetQuery($setting));
		
		for ($i = 1; $i<= 3; $i++) {
			$setting = 'settings_cart_level_'.$membership .'_'. $i;
			$this->admin->SetSetting($setting, number_format(CoreHelp::GetQuery($setting), 2, '.', ''));	
		}
	}
		$this->admin->SetSetting('replicated_cart_type', CoreHelp::GetQuery('replicated_cart_type'));
		$this->admin->SetSetting('settings_cart_type', CoreHelp::GetQuery('settings_cart_type'));
		$this->admin->SetSetting('settings_cart_affiliate_type', CoreHelp::GetQuery('settings_cart_affiliate_type'));
		$this->admin->SetSetting('settings_cart_currency_symbol', CoreHelp::GetQuery('settings_cart_currency_symbol'));
		$this->admin->SetSetting('settings_cart_currency_code', CoreHelp::GetQuery('settings_cart_currency_code'));
		$this->admin->SetSetting('settings_cart_tax_percent', number_format(CoreHelp::GetQuery('settings_cart_tax_percent'), 2, '.', ''));
		$this->admin->SetSetting('settings_cart_paypal_email', CoreHelp::GetQuery('settings_cart_paypal_email'));
		$this->admin->SetSetting('settings_cart_paypal_sandbox', CoreHelp::GetQuery('settings_cart_paypal_sandbox'));
		$this->admin->SetSetting('settings_cart_direct_commission', number_format(CoreHelp::GetQuery('settings_cart_direct_commission'), 2, '.', ''));
		CoreHelp::setSession('message', 'Store settings saved successfully');
        CoreHelp::redirect('back');
    }
	
	public function getPage()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
        $umessages                  = $this->core->getMessages(1);        
        $this->smarty->assign('total_messages', $umessages);
		
		$settings = $this->admin->GetSiteSettings();
		if (!$settings['settings_cart_type'] || !$settings['settings_cart_affiliate_type']) {
			CoreHelp::setSession('error', 'Please configure the store settings to you manage your store.');
        	CoreHelp::redirect('/plugins/cart/cartadmin/settings');	
		}		
        CoreHelp::setSession('menu', array(
            'main' => 'store',
            'sub' => 'categories'
        ));
        $this->smarty->display('plugins/cart/views/admin_cart_categories.tpl');
    }
    
	public function anyUploadpic()
	{
		$this->admin->CheckLogin();

		if(isset($_FILES['image_upload_file'])){
			$output['status']=FALSE;
			set_time_limit(0);
			$allowedImageType = array("image/png",   "image/x-png"  );
			
			if ($_FILES['image_upload_file']["error"] > 0) {
				$output['error']= "Error in File";
			}
			elseif (!in_array($_FILES['image_upload_file']["type"], $allowedImageType)) {
				$output['error']= "You can only upload PNG for store logo";
			}
			elseif (round($_FILES['image_upload_file']["size"] / 1024) > 1024) {
				$output['error']= "You can upload file size up to 1 MB";
			} else {
				$path[0] = $_FILES['image_upload_file']['tmp_name'];
				$file = pathinfo($_FILES['image_upload_file']['name']);
				$fileType = $file["extension"];
				$desiredExt='png';
				$path = 'media/images/store-logo.png';					
				move_uploaded_file($_FILES["image_upload_file"]["tmp_name"], $path);	
				$output['image'] = '/'.$path .'?'.rand(100,100000);
				$output['status']=TRUE;			
			}
			echo json_encode($output);
		}		

	}
  
}
