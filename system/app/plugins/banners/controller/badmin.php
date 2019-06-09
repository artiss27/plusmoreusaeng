<?php

class Badmin_Controller extends iMVC_Controller
{
    
    public function getSizes()
    {
        $this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
        $this->smarty->template_dir = 'system/app/';
        $this->smarty->assign('list', $this->banners->getBannerSizes());
        $this->smarty->assign('id', $id);
        CoreHelp::setSession('menu', array(
            'main' => 'banner_system',
            'sub' => 'banner_sizes'
        ));
        $this->smarty->display('plugins/banners/views/admin_ad_banner_sizes.tpl');
    }
    
    public function postSizes()
    {
        $this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
        Validator\LIVR::defaultAutoTrim(true);
        $validator = new Validator\LIVR(array(
            'width' => array(
                'required',
                'integer'
            ),
            'height' => array(
                'required',
                'integer'
            ),
            'target_url' => array(
                'required',
                'url'
            )
        ));
        $validData = $validator->validate(CoreHelp::GetQueryAll());
        $chk       = $this->banners->getBannerSize(CoreHelp::GetQuery('width'), CoreHelp::GetQuery('height'));
        if (!$validData) {
            CoreHelp::setSession('error', $validator->getErrors());
            CoreHelp::setSessionOld();
            CoreHelp::redirect('back');
        }
        
        elseif ($chk != null) {
            CoreHelp::setSession('error', 'This banner size already exist.');
            CoreHelp::setSessionOld();
            CoreHelp::redirect('back');
        } else {
            $processBanner                       = $this->processBannerUpload(CoreHelp::GetQuery('width') . 'x' . CoreHelp::GetQuery('height'));
            $bannerPath                          = SITE_URL . 'media/images/' . $processBanner;
            $insert['width']                     = CoreHelp::GetQuery('width');
            $insert['height']                    = CoreHelp::GetQuery('height');
            $insert['default_banner_target_url'] = CoreHelp::GetQuery('target_url');
            $insert['default_banner_url']        = $bannerPath;
            $this->banners->db->insert('ad_banner_sizes', $insert);
            CoreHelp::setSession('message', 'Banner size created successfully.');
            CoreHelp::unsetSessionOld();
            CoreHelp::redirect('back');
        }
        
    }
    
    public function getDeletesize()
    {
        $this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
        $banner = $this->banners->getBannerSizeById(CoreHelp::GetQuery('id'));
        if (file_exists('media/images/' . basename($banner['default_banner_url'])))
            unlink('media/images/' . basename($banner['default_banner_url']));
        $this->banners->deleteBannerSizeById($banner['id']);
        CoreHelp::setSession('message', 'Banner size deleted successfully.');
        CoreHelp::redirect('back');
    }
    
    public function getPending()
    {
        $this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
        $this->smarty->template_dir = 'system/app/';
        $this->smarty->assign('list', $this->banners->getBannerPending());
        CoreHelp::setSession('menu', array(
            'main' => 'banner_system',
            'sub' => 'banner_pending'
        ));
        $this->smarty->display('plugins/banners/views/admin_ad_banner_pending.tpl');
    }
    
    public function getPendingaction()
    {
        $this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
        $this->smarty->template_dir = 'system/app/';
        $id                         = CoreHelp::GetQuery('approve') ? CoreHelp::GetQuery('approve') : CoreHelp::GetQuery('disapprove');
        $value                      = CoreHelp::GetQuery('approve') ? 1 : 2;
        $type                       = CoreHelp::GetQuery('approve') ? 'Approved' : 'Disapproved';
        $banner                     = $this->banners->getBannerId($id);
        $this->banners->updateTableById('ad_banners', $id, array(
            'approved' => $value
        ));
        $from    = 1;
        $subject = 'Banner Ad ' . $type;
        $content = 'Dear Member,

Your Banner Ad with campaign Id: ' . $id . ', was ' . $type . ' by our staff.

Support Team
';
        $this->messages->sendmessage($banner['member_id'], 1, $subject, $content, 1, "normal", md5(uniqid()));
        CoreHelp::setSession('message', 'Banner successfully ' . $type);
        CoreHelp::redirect('back');
    }
    
	public function getActive() {
		$this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
        $this->smarty->template_dir = 'system/app/';
        $this->smarty->assign('list', $this->banners->getBannerActive());
        CoreHelp::setSession('menu', array(
            'main' => 'banner_system',
            'sub' => 'banner_active'
        ));
        $this->smarty->display('plugins/banners/views/admin_ad_banner_active.tpl');
	}
	
	public function getNetwork() {
		$this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
        $this->smarty->template_dir = 'system/app/';
        $this->smarty->assign('list', $this->banners->getBannerNetwork());
		$this->smarty->assign('sizes', $this->banners->getBannerSizes());
        CoreHelp::setSession('menu', array(
            'main' => 'banner_system',
            'sub' => 'banner_network'
        ));
        $this->smarty->display('plugins/banners/views/admin_ad_banner_network.tpl');
	}
	
	public function postNetwork() {
		$this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
		Validator\LIVR::defaultAutoTrim(true);
        $validator = new Validator\LIVR(array(
            'banner_size' => 'required',
            'banner_code' => 'required'
        ));
        $validData = $validator->validate(CoreHelp::GetQueryAll());
			if (!$validData)
			{
				CoreHelp::setSession('error', $validator->getErrors());
            	CoreHelp::redirect('back');
			}
			else
			{
				$insert['size'] = CoreHelp::GetQuery('banner_size');
				$insert['banner_code'] = CoreHelp::GetQuery('banner_code');
				$this->banners->db->insert('ad_banner_networks', $insert);
				CoreHelp::setSession('message', 'Banner saved successfully.');
            	CoreHelp::redirect('back');
			}				
	}
	
	public function getSettings() {
		$this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
        $this->smarty->template_dir = 'system/app/';
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
        CoreHelp::setSession('menu', array(
            'main' => 'banner_system',
            'sub' => 'banner_settings'
        ));
        $this->smarty->display('plugins/banners/views/admin_ad_banner_settings.tpl');
	}
	
	public function postSettings() {
		$this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
		Validator\LIVR::defaultAutoTrim(true);
        $validator = new Validator\LIVR(array(
            'max_banner_countries' => 'required',
            'min_banner_bid' => 'required'
        ));
        $validData = $validator->validate(CoreHelp::GetQueryAll());
			if (!$validData)
			{
				CoreHelp::setSession('error', $validator->getErrors());
            	CoreHelp::redirect('back');
			}
			else
			{
				$this->admin->SetSetting('max_banner_countries', CoreHelp::GetQuery('max_banner_countries'));
				$this->admin->SetSetting('min_banner_bid', CoreHelp::GetQuery('min_banner_bid'));
				CoreHelp::setSession('message', 'Banner settings saved successfully.');
            	CoreHelp::redirect('back');
			}				
	}
	
	public function getDeletenetwork() {
		$this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
		$this->banners->deleteBannerNetworkById(CoreHelp::GetQuery('id'));
		CoreHelp::setSession('message', 'Banner deleted successfully.');
        CoreHelp::redirect('back');				
	}
	
    public function postMassupdate()
    {
        $this->admin->CheckLogin();
        $this->load->plugin_model('Banners_Model', 'banners');
        $this->smarty->template_dir = 'system/app/';
        $value                      = CoreHelp::GetQuery('do') == "approve" ? 1 : 2;
        $type                       = CoreHelp::GetQuery('do') == "approve" ? 'Approved' : 'Disapproved';
        foreach (CoreHelp::GetQuery('ids') as $id) {
            $ad = $this->banners->getBannerId($id);
            $this->banners->updateTableById('ad_banners', $id, array(
                'approved' => $value
            ));
            $from    = 1;
            $subject = 'Banner Ad ' . $type;
            $content = 'Dear Member,

Your Banner Ad with campaign Id: ' . $id . ', was ' . $type . ' by our staff.

Support Team
';
            $this->messages->sendmessage($banner['member_id'], 1, $subject, $content, 1, "normal", md5(uniqid()));
            
        }
        CoreHelp::setSession('message', 'Selected Campaigns where ' . $type . ' successfully.');
        CoreHelp::redirect('back');
    }
    
    private function processBannerUpload($bannerSize)
    {
        list($width, $height) = explode('x', $bannerSize);
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
        $uploadHandler->addRule('imagewidth', array(
            'min' => $width,
            'max' => $width
        ), 'Banner width need to be {max} px');
        $uploadHandler->addRule('imageheight', array(
            'min' => $height,
            'max' => $height
        ), 'Banner heigh need to be {max} px');
        $result = $uploadHandler->process($_FILES['banner_image']);
        if (!$result->isValid()) {
            $error = $result->getMessages();
	        CoreHelp::setSession('error', $error[0]->__toString());
            CoreHelp::setSessionOld();
            CoreHelp::redirect('back');
        }
        return $result->name;
        
    }
    
    
    
}
