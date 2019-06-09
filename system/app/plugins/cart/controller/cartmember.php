<?php

class Cartmember_Controller extends iMVC_Controller
{
    
  	
	public function getCustomers()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
		$this->load->plugin_model('Cart_Model', 'cart');
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'cart');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
		$this->smarty->assign('customers', $this->cart->getCustomers($profile['username']));
		$this->smarty->assignByRef('cart', $this->cart);		
        CoreHelp::setSession('menu', array(
            'main' => 'store',
            'sub' => 'customers'
        ));
        $this->smarty->display('plugins/cart/views/member_customers.tpl');
    }
    
	public function getStoresales()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
		$this->load->plugin_model('Cart_Model', 'cart');
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'cart');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
		$this->smarty->assign('sales', $this->cart->getSales($profile['username']));
		$this->smarty->assignByRef('cart', $this->cart);		
        CoreHelp::setSession('menu', array(
            'main' => 'store',
            'sub' => 'sales'
        ));
        $this->smarty->display('plugins/cart/views/member_sales.tpl');
    }
	
	public function getStorecommissions()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
		$this->load->plugin_model('Cart_Model', 'cart');
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'cart');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
		$this->smarty->assign('commissions', $this->cart->getCommissions());
		$this->smarty->assignByRef('cart', $this->cart);		
        CoreHelp::setSession('menu', array(
            'main' => 'store',
            'sub' => 'commissions'
        ));
        $this->smarty->display('plugins/cart/views/member_commissions.tpl');
    }
	
	public function getPurchase()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
		$this->load->plugin_model('Cart_Model', 'cart');
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'cart');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);		
		$required = array('first_name', 'last_name', 'street', 'city', 'state', 'country', 'postal');
		foreach ($required as $part) {
			if($profile[$part] == "") {
				CoreHelp::setSession("error", "There are missing information on your profile, please complete your profile address information to be able to purchase on the store.");
				CoreHelp::redirect('/members/profile');	
			}
		}		
		if(!$_SESSION['customer']){
			$_SESSION['customer'] = $profile['email'];
		}
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
		$this->smarty->assign('customers', $this->cart->getCustomers($profile['username']));
		$this->smarty->assignByRef('cart', $this->cart);		
        CoreHelp::setSession('menu', array(
            'main' => 'store',
            'sub' => 'purchase'
        ));
        $this->smarty->display('plugins/cart/views/member_purchase.tpl');
    }
  
}
