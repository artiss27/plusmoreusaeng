<?php
class Banners_Model extends iMVC_Model
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
	
	public function getBannerId($id) {
		return $this->db->queryFirstRow("SELECT * FROM ad_banners WHERE id = %d", $id);	
	}
	
	public function deleteBannerId($id) {
		$this->db->query('DELETE FROM ad_banners WHERE id=%d', $id);
	}
	
	public function getCampaigns($id) {
		return $this->db->query("SELECT * FROM ad_banners WHERE member_id = %d", $id);			
	}
	
	public function getMaxBid($min) {
		return number_format($this->db->queryFirstField("SELECT ad_credit_bid FROM ad_banners WHERE approved = 1 AND status = 1 AND ad_credit_placed > ad_credit_used + ad_credit_bid ORDER BY -LOG(RAND())/ad_credit_bid LIMIT 1") + $min, 3, '.', '');			
	}
	
	public function getBannerSizes() {
		return $this->db->query("SELECT * FROM ad_banner_sizes");	
	}
	
	public function getBannerSize($width, $height) {
		return $this->db->query("SELECT * FROM ad_banner_sizes WHERE width = %d AND height = %d", $width, $height);	
	}
	
	public function getBannerSizeById($id) {
		return $this->db->queryFirstRow("SELECT * FROM ad_banner_sizes WHERE id = %d", $id);	
	}
	
	public function deleteBannerSizeById($id) {
		return $this->db->query("DELETE FROM ad_banner_sizes WHERE id=%d", $id);	
	}
	
	public function getBannerPending() {
		return $this->db->query("SELECT * FROM ad_banners WHERE approved = 0");	
	}
	
	public function getBannerActive() {
		return $this->db->query("SELECT * FROM ad_banners WHERE approved = 1");	
	}
	
	public function getBannerNetwork() {
		return $this->db->query("SELECT * FROM ad_banner_networks");	
	}
	
	public function deleteBannerNetworkById($id) {
		return $this->db->query("DELETE FROM ad_banner_networks WHERE id=%d", $id);	
	}
	
	public function getBannerClicks($id) {
		return $this->db->query("SELECT * FROM ad_banner_clicks WHERE id=%d", $id);	
	}
	
}
?>