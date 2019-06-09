<?php


class Unimember_Controller extends iMVC_Controller
{
    public function anyTree()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/';
        $this->load->plugin_model('Unilevel_Model', 'unilevel');
        $lang = CoreHelp::getLang('members');
        $plugin_lang = CoreHelp::getLangPlugin('members', 'unilevel');
        $memberId = CoreHelp::getMemberId();
        $profile = $this->member->getProfile($memberId);
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
        CoreHelp::setSession('menu', array(
            'main' => 'my_network',
            'sub' => 'unilevel_levels',
        ));
        $this->smarty->display('plugins/unilevel/views/member_levels.tpl');
    }
	
	public function anyChilds()
    {
		$cached_seconds = 1;
		$id = CoreHelp::GetQuery('id') == '#' ? (isset($_SESSION['admin_tree']) ? $_SESSION['admin_tree'] : $_SESSION['member_id']) : CoreHelp::GetQuery('id');
		unset($_SESSION['admin_tree']);
		$cached = $this->cache->get(md5('tree_'.$id));
		if ($cached == null) {	
			$rows = $this->core->db->query("SELECT * FROM members WHERE sponsor_id = %d", $id);
			$tree = '<ul>';
			foreach ($rows as $refer) {
				$referrals = $this->core->db->queryFirstField("SELECT count(*) FROM members WHERE sponsor_id = %d", $refer['member_id']);
				$class = $referrals > 0 ? 'class="jstree-closed"' : '';
				$membership = $memberData['membership'] == '0' ? 'FREE' : $refer['membership'];
				$skype = strlen($memberData['skype']) > 0 ? 'Skype: '.$refer['skype']."<br>" : '';
				$direct = $this->core->db->queryFirstField("SELECT COUNT(*) FROM members WHERE sponsor_id = %d", $refer['member_id']);
				$paid = $this->core->db->queryFirstField("SELECT COUNT(*) FROM members WHERE sponsor_id = %d AND membership != '0'", $refer['member_id']);
				$sponsor = $this->core->db->queryFirstField("SELECT username FROM members WHERE member_id = %d", $refer['sponsor_id']);
				$memberData = $this->core->db->queryFirstRow("SELECT * FROM members WHERE member_id = %d", $refer['member_id']);
				$tree .= '<li  data-html="true" '.$class.' id="'.$refer['member_id'].'" data-toggle="popover" title="Member Information"
			data-content="Name: '.$memberData['first_name'].' '.$memberData['last_name']."<br>".'Membership: '.$membership."<br>".'Sponsor: '.$sponsor."<br>".'Referrals: '.$direct."<br>".'Paid Referrals: '.$paid."<br>".'Email: '.$memberData['email']."<br>".$skype.'Country: '.$memberData['country'].'" ><img class="profilepic" src="'.CoreHelp::getMemberProfilePic($memberData['member_id'], $memberData['gender']).'"> '.$refer['username'].' ('.$referrals.' Referrals)</li>';
			}
			$tree .= '</ul>';	
			$this->cache->set(md5('tree_'.$id), $tree, $cached_seconds);
			echo $tree;
		}
		else {
			echo $cached;
		}
    }

}
