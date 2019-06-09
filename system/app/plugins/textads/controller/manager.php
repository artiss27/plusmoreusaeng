<?php

class Manager_Controller extends iMVC_Controller
{
    public function getTextads()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->load->plugin_model('Textads_Model', 'textads');
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'textads');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
        CoreHelp::setSession('menu', array(
            'main' => 'advertising',
            'sub' => 'textads'
        ));
        if (CoreHelp::GetQuery('activate') != null || CoreHelp::GetQuery('pause') != null) {
            $this->textadActivation($plugin_lang);
        }
        if (CoreHelp::GetQuery('edit') != null) {
            $id                = CoreHelp::decrypt(CoreHelp::GetQuery('edit'));
            $textad            = $this->textads->getTextadId($id);
            $selectedCountries = explode('|', $textad['countries']);
            $data              = array(
                'min_textad_bid' => $this->core->GetSiteSetting('min_textad_bid'),
                'ad_credit_balance' => $profile['ad_credits'],
                'countries' => $this->core->getCountries(),
				'recommended_bid' => $this->textads->getmaxBid($this->core->GetSiteSetting('min_textad_bid')),
                'max_textad_countries' => $this->core->GetSiteSetting('max_textad_countries'),
                'selected_countries' => $selectedCountries
            );
            $this->smarty->assign('textad', $textad);
            $this->smarty->assign('textadId', CoreHelp::encrypt($id));
            $this->smarty->assign('data', $data);
            $this->smarty->display('plugins/textads/views/member_ad_textad_edit.tpl');
            exit;
        } elseif (CoreHelp::GetQuery('delete') != null) {
            $lock = new iMVC_Library_Lock('TEXTAD_DELETE_' . $memberId);
            if ($lock->lock() == false) {
                CoreHelp::redirect('back');
            }
            $id     = CoreHelp::decrypt(CoreHelp::GetQuery('delete'));
            $textad = $this->textads->getTextadId($id);
            $left = $profile['ad_credits'] + $textad['ad_credit_placed'] - $textad['ad_credit_used'];
            if ($left > 0) {
                $this->textads->insertCreditLog($memberId, $left, 'textad', $plugin_lang['ad_credit_refunded_after_deletion_textad_campaing_id'] . ': ' . $textad['id']);
                $this->member->updateMemberCredit($memberId, $left);
            }
            $this->textads->deleteTextadId($id);
            $lock->unlock();
            CoreHelp::setSession('message', $lang['textad_deleted_succesfully']);
            CoreHelp::redirect('back');
        }
        $data = array(
            'min_textad_bid' => $this->core->GetSiteSetting('min_textad_bid'),
            'ad_credit_balance' => $profile['ad_credits'],
            'countries' => $this->core->getCountries(),
			'recommended_bid' => $this->textads->getmaxBid($this->core->GetSiteSetting('min_textad_bid')),
            'max_textad_countries' => $this->core->GetSiteSetting('max_textad_countries')
        );
        $this->smarty->assign('textads', $this->textads->getCampaigns($memberId));
        $this->smarty->assign('data', $data);
        $this->smarty->display('plugins/textads/views/member_ad_textads.tpl');
    }
    public function getTextadtrack()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->load->plugin_model('Textads_Model', 'textads');        
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'textads');
        $memberId                   = CoreHelp::getMemberId();
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
        $id = CoreHelp::decrypt(CoreHelp::GetQuery('hash'));
        $this->smarty->assign('clicks', $this->textads->getTextadClicks($id));
        $this->smarty->assign('id', $id);
        CoreHelp::setSession('menu', array(
            'main' => 'advertising',
            'sub' => 'textads'
        ));
        $this->smarty->display('plugins/textads/views/member_ad_textads_track.tpl');
    }
    public function postTextads()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->load->plugin_model('Textads_Model', 'textads');        
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'textads');
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
                ),
                'headline' => 'required',
				'description1' => 'required',
				'description2' => 'required'
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
                'headline' => 'required',
				'description1' => 'required',
				'description2' => 'required'
            ));
        }
        $validData = $validator->validate(CoreHelp::GetQueryAll());
        if (!$validData) {
            CoreHelp::setSession('error', $validator->getErrors());
            CoreHelp::setSessionOld();
            CoreHelp::redirect('back');
        } else {
            $minBid = $this->core->GetSiteSetting('min_textad_bid');
            if (CoreHelp::GetQuery('ad_credit_bid') < $minBid || CoreHelp::GetQuery('ad_credit_bid') == null) {
                CoreHelp::setSession('error', $plugin_lang['the_minimum_ad_credit_bid_is'] . ': ' . $minBid);
                CoreHelp::redirect('back');
            }
            $lock = new iMVC_Library_Lock('TEXTAD_ADD_' . $memberId);
            if ($lock->lock() == false) {
                CoreHelp::redirect('back');
            }
            $amount          = abs(CoreHelp::GetQuery('ad_credits_for_this_campaign'));
            $memberAdCredits = $profile['ad_credits'];
            if ($memberAdCredits >= $amount) {
                if (CoreHelp::GetQuery('edit') && $id) {
                    $textad = $this->textads->getTextadId($id);
                    if ($amount > 0) {
                        $update['ad_credit_placed'] = $textad['ad_credit_placed'] + $amount;
                    }
                    $update['campaign_title'] = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('campaign_title'));
					$update['headline']         = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('headline'));
					$update['description1']     = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('description1'));
					$update['description2']     = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('description2'));
					 if (CoreHelp::GetQuery('headline') != $textad['headline'] || CoreHelp::GetQuery('description1') != $textad['description1'] || CoreHelp::GetQuery('description2') != $textad['description2']) {
                        $update['approved']   = 0;
                    }
                    if (CoreHelp::GetQuery('target_url') != $textad['target_url']) {
                        $update['target_url'] = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('target_url'));
                        $update['approved']   = 0;
                    }
                    if (count(CoreHelp::GetQuery('countries')) > 0) {
                        $update['countries'] = implode('|', CoreHelp::GetQuery('countries'));
                    }
                    $update['ad_credit_bid'] = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('ad_credit_bid'));
                    $this->textads->db->update('ad_textads', $update, 'id=%d', $id);
                    CoreHelp::setSession('message', $plugin_lang['campaign_edited_successfully']);
                } else {
                    if ($amount > 0) {                       
                        $insert['headline']         = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('headline'));
						$insert['description1']     = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('description1'));
						$insert['description2']     = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('description2'));
                        $insert['member_id']        = $memberId;
                        $insert['ad_credit_placed'] = $amount;
                        if (count(CoreHelp::GetQuery('countries')) > 0) {
                            $insert['countries'] = implode('|', CoreHelp::GetQuery('countries'));
                        }
                        $insert['ad_credit_bid']  = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('ad_credit_bid'));
                        $insert['target_url']     = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('target_url'));
                        $insert['campaign_title'] = CoreHelp::sanitizeSQL(CoreHelp::GetQuery('campaign_title'));
                        $insert['approved']       = 0;
                        $insert['status']         = 1;
                        $this->textads->db->insert('ad_textads', $insert);
                        $id = $this->textads->db->insertId();
                        CoreHelp::setSession('message', $plugin_lang['campaign_added_successfully']);
                    } else {
                        CoreHelp::setSession('error', $plugin_lang['ad_credits_need_to_be_positive_number']);
                    }
                }
                if ($amount > 0) {
                    $left = $profile['ad_credits'] - $amount;
                    $this->member->updateMemberCredit($memberId, $left);
                    $this->textads->insertCreditLog($memberId, -$amount, 'textad', $plugin_lang['ad_credits_placed_on_textad_campaign_id'] . ': ' . $id);
                }
            } else {
                CoreHelp::setSession('error', $plugin_lang['insuficient_ad_credits_for_this_transaction']);
            }
            $lock->unlock();
            CoreHelp::unsetSessionOld();
            CoreHelp::redirect('back');
        }
    }
    private function textadActivation($lang)
    {
        $memberId = CoreHelp::getMemberId();
        $id       = CoreHelp::decrypt(CoreHelp::GetQuery('activate') ? CoreHelp::GetQuery('activate') : CoreHelp::GetQuery('pause'));
        $textad   = $this->textads->getTextadId($id);
        if ($textad['member_id'] != $memberId) {
            CoreHelp::setSession('error', $lang['invalid_textad_activation_request']);
            CoreHelp::redirect('back');
        } else {
            $status = CoreHelp::GetQuery('activate') ? 1 : 0;
            $this->textads->db->query("UPDATE ad_textads SET status='" . $status . "' WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
            CoreHelp::setSession('message', CoreHelp::GetQuery('activate') ? $lang['textad_activated_as_request'] : $lang['textad_paused_as_request']);
            CoreHelp::redirect('back');
        }
    }
}
