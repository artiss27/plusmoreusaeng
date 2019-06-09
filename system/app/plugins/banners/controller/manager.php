<?php

class Manager_Controller extends iMVC_Controller
{
    public function getBanners()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->load->plugin_model('Banners_Model', 'banners');
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'banners');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
        CoreHelp::setSession('menu', array(
            'main' => 'advertising',
            'sub' => 'banners'
        ));
        if (CoreHelp::GetQuery('activate') != null || CoreHelp::GetQuery('pause') != null) {
            $this->bannerActivation($plugin_lang);
        }
        if (CoreHelp::GetQuery('edit') != null) {
            $id                = CoreHelp::decrypt(CoreHelp::GetQuery('edit'));
            $banner            = $this->banners->getBannerId($id);
            $selectedCountries = explode('|', $banner['countries']);
            $data              = array(
                'banner_sizes' => $this->banners->getBannerSizes(),
                'min_banner_bid' => $this->core->GetSiteSetting('min_banner_bid'),
                'ad_credit_balance' => $profile['ad_credits'],
                'countries' => $this->core->getCountries(),
				'recommended_bid' => $this->banners->getmaxBid($this->core->GetSiteSetting('min_banner_bid')),
                'max_banner_countries' => $this->core->GetSiteSetting('max_banner_countries'),
                'selected_countries' => $selectedCountries
            );
            $this->smarty->assign('banner', $banner);
            $this->smarty->assign('bannerId', CoreHelp::encrypt($id));
            $this->smarty->assign('data', $data);
            $this->smarty->display('plugins/banners/views/member_ad_banner_edit.tpl');
            exit;
        } elseif (CoreHelp::GetQuery('delete') != null) {
            $lock = new iMVC_Library_Lock('BANNER_DELETE_' . $memberId);
            if ($lock->lock() == false) {
                CoreHelp::redirect('back');
            }
            $id     = CoreHelp::decrypt(CoreHelp::GetQuery('delete'));
            $banner = $this->banners->getBannerId($id);
            if (file_exists('media/images/' . basename($banner['banner_url'])));
            $left = $profile['ad_credits'] + $banner['ad_credit_placed'] - $banner['ad_credit_used'];
            if ($left > 0) {
                $this->banners->insertCreditLog($memberId, $left, 'banner', $plugin_lang['ad_credit_refunded_after_deletion_banner_campaing_id'] . ': ' . $banner['id']);
                $this->member->updateMemberCredit($memberId, $left);
            }
            $this->banners->deleteBannerId($id);
            $lock->unlock();
            CoreHelp::setSession('message', $lang['banner_deleted_succesfully']);
            CoreHelp::redirect('back');
        }
        $data = array(
            'banner_sizes' => $this->banners->getBannerSizes(),
            'min_banner_bid' => $this->core->GetSiteSetting('min_banner_bid'),
            'ad_credit_balance' => $profile['ad_credits'],
            'countries' => $this->core->getCountries(),
			'recommended_bid' => $this->banners->getmaxBid($this->core->GetSiteSetting('min_banner_bid')),
            'max_banner_countries' => $this->core->GetSiteSetting('max_banner_countries')
        );
        $this->smarty->assign('banners', $this->banners->getCampaigns($memberId));
        $this->smarty->assign('data', $data);
        $this->smarty->display('plugins/banners/views/member_ad_banners.tpl');
    }
    public function getBannertrack()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->load->plugin_model('Banners_Model', 'banners');        
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'banners');
        $memberId                   = CoreHelp::getMemberId();
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
        $id = CoreHelp::decrypt(CoreHelp::GetQuery('hash'));
        $this->smarty->assign('clicks', $this->banners->getBannerClicks($id));
        $this->smarty->assign('id', $id);
        CoreHelp::setSession('menu', array(
            'main' => 'advertising',
            'sub' => 'banners'
        ));
        $this->smarty->display('plugins/banners/views/member_ad_banners_track.tpl');
    }
    public function postBanners()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->load->plugin_model('Banners_Model', 'banners');        
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'banners');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        if (CoreHelp::GetQuery('edit')) {
            $id = CoreHelp::decrypt(CoreHelp::GetQuery('edit'));
        }
        Validator\LIVR::defaultAutoTrim(true);
        if (CoreHelp::GetQuery('edit')) {
            $validator = new Validator\LIVR(array(
                'campaign_title' => 'required',
                'ad_credits_for_this_campaign' => 'required',
                'ad_credit_bid' => 'required',
                'target_url' => array(
                    'required',
                    'url'
                )
            ));
        } else {
            $validator = new Validator\LIVR(array(
                'campaign_title' => 'required',
                'ad_credits_for_this_campaign' => array(
                    'required',
                    'positive_decimal'
                ),
                'ad_credit_bid' => array(
                    'required',
                    'positive_decimal'
                ),
                'target_url' => array(
                    'required',
                    'url'
                ),
                'banner_size' => 'required'
            ));
        }
        $validData = $validator->validate(CoreHelp::GetQueryAll());
        if (!$validData) {			
            CoreHelp::setSession('error', $validator->getErrors());
            CoreHelp::setSessionOld();
            CoreHelp::redirect('back');
        } else {
            $minBid = $this->core->GetSiteSetting('min_banner_bid');
            if (CoreHelp::GetQuery('ad_credit_bid') < $minBid || CoreHelp::GetQuery('ad_credit_bid') == null) {
                CoreHelp::setSession('error', $plugin_lang['the_minimum_ad_credit_bid_is'] . ': ' . $minBid);
                CoreHelp::redirect('back');
            }
            $lock = new iMVC_Library_Lock('BANNER_ADD_' . $memberId);
            if ($lock->lock() == false) {
                CoreHelp::redirect('back');
            }
            $amount          = abs(CoreHelp::GetQuery('ad_credits_for_this_campaign'));
            $memberAdCredits = $profile['ad_credits'];
            if ($memberAdCredits >= $amount) {
                if (CoreHelp::GetQuery('edit') && $id) {
                    $banner = $this->banners->getBannerId($id);
                    if (strlen($_FILES['banner_image']['name']) > 0) {
                        list($width, $height) = explode('x', $banner['banner_size']);
                        $uploadHandler = new \Sirius\Upload\Handler('media/images');
                        $uploadHandler->addRule('extension', array(
                            'allowed' => array(
                                'jpg',
                                'jpeg',
                                'png',
                                'gif'
                            )
                        ), $plugin_lang['should_be_a_valid_image'] . ' (jpg, jpeg, png, gif)');
                        $uploadHandler->addRule('size', array(
                            'max' => '1M'
                        ), $plugin_lang['should_have_less_than'] . ' {max}');
                        $uploadHandler->addRule('imagewidth', array(
                            'min' => $width,
                            'max' => $width
                        ), $plugin_lang['banner_width_need_to_be'] . ' {max} px');
                        $uploadHandler->addRule('imageheight', array(
                            'min' => $height,
                            'max' => $height
                        ), $plugin_lang['banner_width_need_to_be'] . ' {max} px');
                        $result = $uploadHandler->process($_FILES['banner_image']);						
                        if (!$result->isValid()) { 
                            CoreHelp::setSession('error', $result->getMessages());
                            CoreHelp::redirect('back');
                        } else {
                            $update['banner_url'] = '/media/images/' . $result->name;
                            $update['approved']   = 0;
                        }
                    }
                    if ($amount > 0) {
                        $update['ad_credit_placed'] = $banner['ad_credit_placed'] + $amount;
                    }
                    $update['campaign_title'] = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('campaign_title'));
                    if (CoreHelp::GetQuery('target_url') != $banner['target_url']) {
                        $update['target_url'] = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('target_url'));
                        $update['approved']   = 0;
                    }
                    if (count(CoreHelp::GetQuery('countries')) > 0) {
                        $update['countries'] = implode('|', CoreHelp::GetQuery('countries'));
                    }
                    $update['ad_credit_bid'] = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('ad_credit_bid'));
                    $this->banners->db->update('ad_banners', $update, 'id=%d', $id);
                    CoreHelp::setSession('message', $plugin_lang['campaign_edited_successfully']);
                } else {
                    if ($amount > 0) {
                        list($width, $height) = explode('x', CoreHelp::GetQuery('banner_size'));
                        $uploadHandler = new \Sirius\Upload\Handler('media/images');
                        $uploadHandler->addRule('extension', array(
                            'allowed' => array(
                                'jpg',
                                'jpeg',
                                'png',
                                'gif'
                            )
                        ), $plugin_lang['should_be_a_valid_image'] . ' (jpg, jpeg, png)');
                        $uploadHandler->addRule('size', array(
                            'max' => '1M'
                        ), $plugin_lang['should_have_less_than'] . ' {max}');
                        $uploadHandler->addRule('imagewidth', array(
                            'min' => $width,
                            'max' => $width
                        ), $plugin_lang['banner_width_need_to_be'] . ' {max} px');
                        $uploadHandler->addRule('imageheight', array(
                            'min' => $height,
                            'max' => $height
                        ), $plugin_lang['banner_width_need_to_be'] . ' {max} px');
                        $result = $uploadHandler->process($_FILES['banner_image']);
                        if (!$result->isValid()) { 
							$error = $result->getMessages();
	                        CoreHelp::setSession('error', $error[0]->__toString());
							CoreHelp::setSessionOld();
                            CoreHelp::redirect('back');
                        }
                        $insert['banner_url']       = '/media/images/' . $result->name;
                        $insert['member_id']        = $memberId;
                        $insert['ad_credit_placed'] = $amount;
                        if (count(CoreHelp::GetQuery('countries')) > 0) {
                            $insert['countries'] = implode('|', CoreHelp::GetQuery('countries'));
                        }
                        $insert['ad_credit_bid']  = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('ad_credit_bid'));
                        $insert['target_url']     = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('target_url'));
                        $insert['campaign_title'] = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('campaign_title'));
                        $insert['banner_size']    = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('banner_size'));
                        $insert['approved']       = 0;
                        $insert['status']         = 1;
                        $this->banners->db->insert('ad_banners', $insert);
                        $id = $this->banners->db->insertId();
                        CoreHelp::setSession('message', $plugin_lang['campaign_added_successfully']);
                    } else {
                        CoreHelp::setSession('error', $plugin_lang['ad_credits_need_to_be_positive_number']);
                    }
                }
                if ($amount > 0) {
                    $left = $profile['ad_credits'] - $amount;
                    $this->member->updateMemberCredit($memberId, $left);
                    $this->banners->insertCreditLog($memberId, -$amount, 'banner', $plugin_lang['ad_credits_placed_on_banner_campaign_id'] . $id);
                }
            } else {
                CoreHelp::setSession('error', $plugin_lang['insuficient_ad_credits_for_this_transaction']);
            }
            $lock->unlock();
            CoreHelp::unsetSessionOld();
            CoreHelp::redirect('back');
        }
    }
    private function bannerActivation($lang)
    {
        $memberId = CoreHelp::getMemberId();
        $id       = CoreHelp::decrypt(CoreHelp::GetQuery('activate') ? CoreHelp::GetQuery('activate') : CoreHelp::GetQuery('pause'));
        $banner   = $this->banners->getBannerId($id);
        if ($banner['member_id'] != $memberId) {
            CoreHelp::setSession('error', $lang['invalid_banner_activation_request']);
            CoreHelp::redirect('back');
        } else {
            $status = CoreHelp::GetQuery('activate') ? 1 : 0;
            $this->banners->db->query("UPDATE ad_banners SET status='" . $status . "' WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
            CoreHelp::setSession('message', CoreHelp::GetQuery('activate') ? $lang['banner_activated_as_request'] : $lang['banner_paused_as_request']);
            CoreHelp::redirect('back');
        }
    }
}
