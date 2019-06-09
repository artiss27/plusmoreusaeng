<?php

class Admin_Controller extends iMVC_Controller
{	
	public function getManage() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
		$this->load->plugin_model('Ranks_Model', 'ranks');
        $this->smarty->assign('settings', $this->core->GetSiteSettings());
		$this->smarty->assign('ranks', $this->ranks->getRanks());
		$this->smarty->assign('highest_order', $this->ranks->maxRankOrder());
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'manage_ranks'
        ));
        $this->smarty->display('plugins/ranks/views/admin_manage_ranks.tpl');
	}
	
	public function postManage() {
		$this->admin->CheckLogin();
		$this->load->plugin_model('Ranks_Model', 'ranks');
		if ($_FILES['rank_image']) {
			$target_path              = 'media/images/';					
			$image_extensions_allowed = array(
				'jpg',
				'jpeg',
				'png',
				'gif',
				'bmp'
			);
			$ext         = strtolower(substr(strrchr($_FILES['rank_image']['name'], '.'), 1));
			if (!in_array($ext, $image_extensions_allowed)) {
				$exts = implode(', ', $image_extensions_allowed);
				CoreHelp::setSession('error', 'You must upload a file with one of the following extensions: ' . $exts);
				Corehelp::redirect('back');
			}
			$filename    =  rand(10000, 500000) . '_' . time() . '.' . $ext;
			$target_path = $target_path . $filename;
			if (!move_uploaded_file($_FILES['rank_image']['tmp_name'], $target_path)) {
				CoreHelp::setSession('error', 'Error uploading image to media directory.');
				Corehelp::redirect('back');
			} 
		}else {
			CoreHelp::setSession('error', 'Please upload an image for your rank.');
			Corehelp::redirect('back');	
		}
		$this->ranks->createRank(CoreHelp::GetQuery('name'), CoreHelp::GetQuery('direct_required'), CoreHelp::GetQuery('pv_required'), CoreHelp::GetQuery('gv_required'), $filename);
		CoreHelp::setSession('message', 'Rank saved successfully.');
        CoreHelp::redirect('back');
			
	}
	
	public function getRankedit() {
		$this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/';
		$this->load->plugin_model('Ranks_Model', 'ranks');
		$this->smarty->assign('rank', $this->ranks->getRank(CoreHelp::GetQuery('id')));
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'manage_ranks'
        ));
        $this->smarty->display('plugins/ranks/views/admin_edit_ranks.tpl');
	}
	
	public function postRankedit() {
		$this->admin->CheckLogin();
		$this->load->plugin_model('Ranks_Model', 'ranks');
		if ($_FILES['rank_image']) {
			$target_path              = 'media/images/';					
			$image_extensions_allowed = array(
				'jpg',
				'jpeg',
				'png',
				'gif',
				'bmp'
			);
			$ext         = strtolower(substr(strrchr($_FILES['rank_image']['name'], '.'), 1));
			if (!in_array($ext, $image_extensions_allowed)) {
				$exts = implode(', ', $image_extensions_allowed);
				CoreHelp::setSession('error', 'You must upload a file with one of the following extensions: ' . $exts);
				Corehelp::redirect('back');
			}
			$filename    =  rand(10000, 500000) . '_' . time() . '.' . $ext;
			$target_path = $target_path . $filename;
			if (!move_uploaded_file($_FILES['rank_image']['tmp_name'], $target_path)) {
				CoreHelp::setSession('error', 'Error uploading image to media directory.');
				Corehelp::redirect('back');
			} 
		}	
		$update['name'] = CoreHelp::GetQuery('name');
		$update['direct_required'] = CoreHelp::GetQuery('direct_required');
		$update['pv_required'] = CoreHelp::GetQuery('pv_required');
		$update['gv_required'] = CoreHelp::GetQuery('gv_required');
		if(isset($filename )) {
			$update['image'] = $filename;	
		}
		$this->ranks->updateTableById('ranks', CoreHelp::GetQuery('id'), $update);
		CoreHelp::setSession('message', 'Rank edited successfully.');
        CoreHelp::redirect('back');
			
	}
    
    public function getRankdelete() {
		$this->admin->CheckLogin();
		$this->load->plugin_model('Ranks_Model', 'ranks');
		$this->ranks->deleteById(CoreHelp::GetQuery('id'));
		CoreHelp::setSession('message', 'Rank deleted successfully.');
        CoreHelp::redirect('back');
	}
    
	public function getRankup() {
		$this->admin->CheckLogin();
		$this->load->plugin_model('Ranks_Model', 'ranks');
		$this->ranks->rankUp(CoreHelp::GetQuery('id'));
		CoreHelp::setSession('message', 'Rank order changed successfully.');
        CoreHelp::redirect('back');
	}
	
	public function getRankdown() {
		$this->admin->CheckLogin();
		$this->load->plugin_model('Ranks_Model', 'ranks');
		$this->ranks->rankDown(CoreHelp::GetQuery('id'));
		CoreHelp::setSession('message', 'Rank order changed successfully.');
        CoreHelp::redirect('back');
	}
	
}
