<?php
class Verification_Model extends iMVC_Model
{	
	
	public function updateTableById($table, $id, $values) {
		$this->db->update($table, $values, "id=%d", $id);
	}
	
	public function giveReward($memberId, $membership) {
		$amount = $this->db->queryFirstField("SELECT value FROM settings WHERE keyname=%s", $membership. '_monthly_reward');
		$months = $this->db->queryFirstField("SELECT value FROM settings WHERE keyname=%s", $membership. '_monthly_reward_months');
		$username = $this->db->queryFirstRow("SELECT * FROM members WHERE member_id=%d", $memberId);
		$this->db->insert('monthly_rewards', array(
  			'member_id' => $memberId,
			'username' => $username,
  			'amount' => $amount,
			'package' => $membership,
			'months_left' => $months,
			'next_reward' => time() + 60*60*24*30
		));		
	}	
	
	public function getPending() {
		return 	$this->db->query("SELECT * FROM verification WHERE verification = 'processing_verification' ORDER BY id ASC");
	}
	
	public function getVerified() {
		return 	$this->db->query("SELECT * FROM verification WHERE verification = 'verified' ORDER BY id ASC");
	}
	
	public function setRequest($memberId, $request) {
		$this->db->query("UPDATE verification set verification = %s WHERE member_id=%d", $request, $memberId);
		$this->db->query("UPDATE members set verification = %s WHERE member_id=%d", $request, $memberId);
	}
	
	public function getStatus($id) {
		return 	$this->db->queryFirstField("SELECT verification FROM members WHERE member_id=%d", $id);
	}
	
	public function setDocument($memberId, $name) {
		$exist = $this->db->queryFirstField("SELECT COUNT(*) FROM verification WHERE member_id = %d", $memberId);
		if($exist) {
			$this->db->query("UPDATE verification SET document = %s WHERE member_id = %d", $name, $memberId);		
		}
		else {
			$this->db->query("INSERT INTO verification (member_id, document, address_proof) VALUES('".$memberId."', '".$name."' ,'')");	
		}
	}
	
	public function setProof($memberId, $name) {
		$exist = $this->db->queryFirstField("SELECT COUNT(*) FROM verification WHERE member_id = %d", $memberId);
		if($exist) {
			$this->db->query("UPDATE verification SET address_proof = %s WHERE member_id = %d", $name, $memberId);		
		}
		else {
			$this->db->query("INSERT INTO verification (member_id, document, address_proof) VALUES('".$memberId."', '' ,'".$name."')");	
		}
	}
	
}
?>
