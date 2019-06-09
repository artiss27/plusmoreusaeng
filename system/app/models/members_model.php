<?php
class Members_Model extends iMVC_Model
{
	public function memberLogin($user, $password)
	{
		$member_id = $this->db->queryFirstField("SELECT member_id FROM members WHERE username=%s AND password=%s", $user, hash('sha256', $password));
		if ($member_id > 0) {
			$_SESSION['Username'] = $user;
			$_SESSION['MemberID'] = $member_id;
			$_SESSION['member_id'] = $member_id;
			return true;
		} else {
			return false;
		}
	}
	
	public function getProfile($id)
	{
		$result = $this->db->queryFirstRow("SELECT * FROM members WHERE member_id = %d", $id);
		return $result;
	}
	
	public function getUsername($userid)
	{
		$username = $this->db->queryFirstField("SELECT username FROM members WHERE member_id = %d LIMIT 1", $userid);
		return strlen($username) > 0 ? $username : '';
	}
	
	public function getUserId($username)
	{
		$meid = $this->db->queryFirstField("SELECT member_id FROM members WHERE username = %s LIMIT 1", $username);
		return strlen($meid) > 0 ? $meid : false;
	}
	
	public function updateMemberCredit($memberId, $left)
	{
		$this->db->query("UPDATE members SET ad_credits = $left WHERE member_id = %d", $memberId);	
	}
	
	public function getMembershipById($id)
	{
		return $this->db->queryFirstField("SELECT membership FROM memberships WHERE id = %d", $id);	
	}
	
	public function getUsernameById($id)
	{
		return $this->db->queryFirstField("SELECT username FROM members WHERE member_id = %d", $id);	
	}

}
?>