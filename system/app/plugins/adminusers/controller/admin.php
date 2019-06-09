<?php

class Admin_Controller extends iMVC_Controller
{	
	

	public function getUsers() {
		$this->admin->CheckLogin();
		if(!isset($_SESSION['roles']['master'])) {
			CoreHelp::redirect('back');		
		}
        $this->smarty->template_dir = 'system/app/';
		$this->load->plugin_model('Adminusers_Model', 'adminusers');
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
		$this->smarty->assign('adminusers', $this->adminusers->getAdminUsers());
		$this->smarty->assign('log', $this->adminusers->getLog());
		$this->smarty->assignByRef('adminmodel', $this->adminusers);	
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'admin_users'
        ));
        $this->smarty->display('plugins/adminusers/views/admin_adminusers.tpl');
	}
	
	public function postUsers() {
		$this->admin->CheckLogin();
		if(!isset($_SESSION['roles']['master'])) {
			CoreHelp::redirect('back');		
		}
		$memberships = $this->core->GetMemberships();
		$this->load->plugin_model('Adminusers_Model', 'adminusers');
		if($this->adminusers->getAdminUser(CoreHelp::GetValidQuery('username'))) {
			CoreHelp::setSession('message', 'This admin username already exists.');
        	CoreHelp::redirect('back');			
		}
		if($this->adminusers->getAdminEmail(CoreHelp::GetValidQuery('email'))) {
			CoreHelp::setSession('message', 'This admin email already exists.');
        	CoreHelp::redirect('back');			
		}
		foreach($_REQUEST['roles'] as $role) {
			$roles[$role] = 1;	
		}
		$roles = serialize($roles);
		$this->adminusers->saveAdminUser(CoreHelp::GetValidQuery('username'), CoreHelp::GetValidQuery('email'), CoreHelp::GetValidQuery('password'), $roles);
		CoreHelp::setSession('message', 'Admin user created successfully.');
        CoreHelp::redirect('back');
			
	}
	
	public function getEdituser() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
		if(CoreHelp::GetValidQuery('id') == 1 || !isset($_SESSION['roles']['master'])) {
			CoreHelp::redirect('back');		
		}
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'adminusers');		
		$this->load->plugin_model('Adminusers_Model', 'adminusers');		
		$user = $this->adminusers->getAdminUserById(CoreHelp::GetValidQuery('id'));
		if($user['roles']) {
			$user['roles'] = unserialize($user['roles']);
		}
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
		$this->smarty->assign('user', $user);
		$this->smarty->assignByRef('adminmodel', $this->adminusers);	
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'admin_users'
        ));
        $this->smarty->display('plugins/adminusers/views/admin_adminusers_edit.tpl');
	}
	
	public function postEdituser() {
		$this->admin->CheckLogin();
		if(CoreHelp::GetValidQuery('id') == 1 || !isset($_SESSION['roles']['master'])) {
			CoreHelp::redirect('back');		
		}
		$memberships = $this->core->GetMemberships();
		$this->load->plugin_model('Adminusers_Model', 'adminusers');
		foreach($_REQUEST['roles'] as $role) {
			$roles[$role] = 1;	
		}
		$roles = serialize($roles);
		$this->adminusers->updateAdminUser(CoreHelp::GetValidQuery('id'), CoreHelp::GetValidQuery('username'), CoreHelp::GetValidQuery('email'), CoreHelp::GetValidQuery('password'), $roles);
		CoreHelp::setSession('message', 'Admin user edited successfully.');
        CoreHelp::redirect('back');
			
	}
	
	public function getLog() {
		$this->admin->CheckLogin();
		if(CoreHelp::GetValidQuery('id') == 1 || !isset($_SESSION['roles']['master'])) {
			CoreHelp::redirect('back');		
		}
        $this->smarty->template_dir = 'system/app/';
		$this->load->plugin_model('Adminusers_Model', 'adminusers');
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
		$this->smarty->assign('memberships', $this->core->GetMemberships());
		$this->smarty->assign('log', $this->adminusers->getLog());
		$this->smarty->assign('total_paid', $this->adminusers->getTotalPaid());
        CoreHelp::setSession('menu', array(
            'main' => 'memberships',
            'sub' => 'monthly_rewards_log'
        ));
        $this->smarty->display('plugins/adminusers/views/admin_adminusers_log.tpl');
	}
    
    
    
}
