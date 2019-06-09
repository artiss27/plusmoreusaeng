<?php
class Textads_Model extends iMVC_Model
{	
	
	public function updateTableById($table, $id, $values) {
		$this->db->update($table, $values, "id=%d", $id);
	}
	
	public function insertCreditLog($memberId, $amount, $type, $description) {
		$this->db->insert('ad_credit_log', array(
  			'member_id' => $memberId,
  			'amount' => $amount,
			'type' => $type,
			'description' => $description
		));		
	}
	
	public function getTextadId($id) {
		return $this->db->queryFirstRow("SELECT * FROM ad_textads WHERE id = %d", $id);	
	}
	
	public function deleteTextadId($id) {
		$this->db->query('DELETE FROM ad_textads WHERE id=%d', $id);
	}
	
	public function getCampaigns($id) {
		return $this->db->query("SELECT * FROM ad_textads WHERE member_id = %d", $id);			
	}
	
	public function getMaxBid($min) {
		return number_format($this->db->queryFirstField("SELECT ad_credit_bid FROM ad_textads WHERE approved = 1 AND status = 1 AND ad_credit_placed > ad_credit_used + ad_credit_bid ORDER BY -LOG(RAND())/ad_credit_bid LIMIT 1") + $min, 3, '.', '');			
	}
	
	public function getTextadPending() {
		return $this->db->query("SELECT * FROM ad_textads WHERE approved = 0");	
	}
	
	public function getTextadActive() {
		return $this->db->query("SELECT * FROM ad_textads WHERE approved = 1");	
	}
	
	public function getTextadClicks($id) {
		return $this->db->query("SELECT * FROM ad_textad_clicks WHERE id=%d", $id);	
	}
	
}
?>