<?php

class Default_Controller extends iMVC_Controller
{
	public function getIndex()
	{		
		$this->load->model('Main_Model', 'main');

		if (CoreHelp::GetQuery('u')) {
			$memberId = $this->main->db->queryFirstField("SELECT member_id FROM members WHERE username = %s", CoreHelp::GetQuery('u'));		
			if ($memberId) {
				setcookie('enroller', CoreHelp::GetQuery('u'), time() + 60 * 60 * 24 * 360, '/');
			}
			else {
				$sponsor = $this->main->db->queryFirstField("SELECT username FROM members WHERE member_id = 1");
				setcookie('enroller', $sponsor, time() + 60 * 60 * 24 * 360, '/');
			}
			$haveToday = $this->main->db->queryFirstField("SELECT id FROM hits WHERE member_id = %d AND date = '".date("Y-m-d")."'", $memberId);
			if ($haveToday) {
				$this->main->db->queryFirstField("UPDATE hits SET hit_counter= hit_counter + 1 WHERE member_id = %d AND date = '".date("Y-m-d")."'", $memberId);	
			}
			else {
				$this->main->db->insert('hits', array(
        		'member_id' => $memberId,
        		'hit_counter' => 1,
        		'date' => date("Y-m-d"),
        		));
			}
		}
		$settings = $this->main->GetSiteSettings();
		
		if($settings['use_wordpress_bundle'] == 'yes') {
			CoreHelp::redirect('/site');		
		}
		else {
			if($settings['front_page_redirect_url']) {
				CoreHelp::redirect($settings['front_page_redirect_url']);	
			}else {
				CoreHelp::redirect('/site');
			}
		}

		/*if (!empty($_SERVER['PATH_INFO'])) {
			$this->smarty->display('404.tpl');
			exit;
		}
		$this->smarty->display('index.tpl');*/
	}
}
