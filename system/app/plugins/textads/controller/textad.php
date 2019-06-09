<?php

class Textad_Controller extends iMVC_Controller
{
	
	
	public function getClick()
	{
		$this->load->plugin_model('Textads_Model', 'textads');
		$hash    = CoreHelp::decrypt(CoreHelp::GetQuery('hash'));
		$country = CoreHelp::getCountryCode();
		list($textadId, $time) = explode('|', $hash);
		if ($textadId > 0 && time() - $time < 60 * 60 * 8) {
			$textad = $this->textads->db->queryFirstRow("SELECT * FROM  ad_textads WHERE id = %d ", $textadId);
			if (CoreHelp::getSession('clicked_today', false)) {
				if (in_array($textadId, unserialize(CoreHelp::getSession('clicked_today')))) {
					CoreHelp::redirect($textad['target_url']);
				}
			}
			$this->textads->db->query("UPDATE ad_textads SET total_clicks = total_clicks + 1, ad_credit_used = ad_credit_used + %d WHERE id = %d ", $textad['ad_credit_bid'], $textadId);
			$this->textads->db->insert('ad_textads_clicks', 
			array('textads_id' => $textadId, 'ip_address' => CoreHelp::getIp(), 'country' => $country));
			$session = CoreHelp::getSession('clicked_today', false) ? unserialize(CoreHelp::getSession('clicked_today')) : array();
			array_push($session, $textadId);
			CoreHelp::setSession('clicked_today', serialize($session));
			return CoreHelp::redirect($textad['target_url']);
		} else {
			die('Wrong session click');
		}
	}
	

}
