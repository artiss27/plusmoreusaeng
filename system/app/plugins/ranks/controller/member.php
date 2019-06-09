<?php

class Member_Controller extends iMVC_Controller
{
    
    public function getVerify()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'verification');
		$this->load->plugin_model('Verification_Model', 'verification');
        $memberId                   = CoreHelp::getMemberId();
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
		$this->smarty->assign('status', $this->verification->getStatus($memberId));
        $this->smarty->assign('id', $id);
        CoreHelp::setSession('menu', array(
            'main' => 'my_account',
            'sub' => 'verification'
        ));
        $this->smarty->display('plugins/verification/views/member_verify.tpl');
    }
	
	public function postVerify()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'verification');
		$this->load->plugin_model('Verification_Model', 'verification');
        $memberId                   = CoreHelp::getMemberId();
		$status = $this->verification->getStatus($memberId);
		if($status == 'require_all_documents') {
        	if (strlen($_FILES['document']['name']) == 0 || strlen($_FILES['proof']['name']) == 0) {
				CoreHelp::setSession('error', $plugin_lang['need_to_upload_both_documents']);
        		CoreHelp::redirect('back');	
			}
		}
		if($status == 'require_personal_identity_document') {
        	if (strlen($_FILES['document']['name']) == 0) {
				CoreHelp::setSession('error', $plugin_lang['need_to_upload_personal_document']);
        		CoreHelp::redirect('back');	
			}
		}
		if($status == 'require_addreess_proof_document') {
        	if (strlen($_FILES['proof']['name']) == 0) {
				CoreHelp::setSession('error', $plugin_lang['need_to_upload_bill_document']);
        		CoreHelp::redirect('back');	
			}
		}
		
		if (strlen($_FILES['document']['name']) > 0) {
                        $uploadHandler = new \Sirius\Upload\Handler('media/files');
                        $uploadHandler->addRule('extension', array(
                            'allowed' => array(
                                'jpg',
                                'jpeg',
                                'png',
                                'gif'
                            )
                        ), $plugin_lang['should_be_a_valid_image'] . ' (jpg, jpeg, png, gif)');
                        $uploadHandler->addRule('size', array(
                            'max' => '5M'
                        ), $plugin_lang['should_have_less_than'] . ' {max}');
                        $result = $uploadHandler->process($_FILES['document']);
                        if (!$result->isValid()) {
                            CoreHelp::setSession('error', $result->getMessages());
                            CoreHelp::redirect('back');
                        } else {
                            $this->verification->setDocument($memberId, $result->name);
                        }
       }
	   
	   if (strlen($_FILES['proof']['name']) > 0) {
                        $uploadHandler = new \Sirius\Upload\Handler('media/files');
                        $uploadHandler->addRule('extension', array(
                            'allowed' => array(
                                'jpg',
                                'jpeg',
                                'png',
                                'gif'
                            )
                        ), $plugin_lang['should_be_a_valid_image'] . ' (jpg, jpeg, png, gif)');
                        $uploadHandler->addRule('size', array(
                            'max' => '5M'
                        ), $plugin_lang['should_have_less_than'] . ' {max}');
                        $result = $uploadHandler->process($_FILES['proof']);
                        if (!$result->isValid()) {
                            CoreHelp::setSession('error', $result->getMessages());
                            CoreHelp::redirect('back');
                        } else {
                            $this->verification->setProof($memberId, $result->name);
                        }
       }
	   
	   $this->verification->setRequest($memberId, 'processing_verification');
	   CoreHelp::setSession('message', $plugin_lang['processing_verification']);
       CoreHelp::redirect('back');	
    }
   
}
