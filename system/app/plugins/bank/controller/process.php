<?php


class Process_Controller extends iMVC_Controller
{	

	public function anyDeposit()
	{
		$this->smarty->template_dir = 'system/app/';
		$lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'banners');
		$this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'deposit'
        ));
        $this->smarty->display('plugins/bank/views/member_deposit.tpl');
	}
	
	
}
