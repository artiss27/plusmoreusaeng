<?php
class Adminusers_Model extends iMVC_Model
{	
	
	public function updateTableById($table, $id, $values) {
		$this->db->update($table, $values, "id=%d", $id);
	}
	
	public function saveAdminUser($username, $email, $password, $roles) {
		$this->db->insert('admin_users', array(
  			'username' => $username,
			'email' => $email,
  			'password' => hash('sha256', $password),
			'roles' => $roles			
		));		
	}	
	
	public function getAdminUsers() {
		return 	$this->db->query("SELECT * FROM admin_users ORDER BY id DESC");
	}
	
	public function getAdminUser($username) {
		return 	$this->db->query("SELECT * FROM admin_users WHERE username=%s", $username) ? true : false;
	}
	
	public function getAdminUserById($id) {
		return 	$this->db->queryFirstRow("SELECT * FROM admin_users WHERE id=%d", $id);
	}
	
	public function getAdminEmail($email) {
		return 	$this->db->query("SELECT * FROM admin_users WHERE email=%s", $email) ? true : false;
	}
	
	public function getLastIp($username) {
		return 	$this->db->queryFirstField("SELECT ip_address FROM admin_log WHERE admin_username=%s ORDER BY id DESC LIMIT 1", $username);
	}
	
	public function getLastDate($username) {
		return 	$this->db->queryFirstField("SELECT date FROM admin_log WHERE admin_username=%s ORDER BY id DESC LIMIT 1", $username);
	}
	
	public function getRoles($username) {
		$roles = unserialize($this->db->queryFirstField("SELECT roles FROM admin_users WHERE username=%s", $username));
		foreach ($roles as $key => $value) {
			$urole[] = $key;	
		}
		return 	implode(', ', $urole);
	}
	
	public function saveLog($username, $description) {
		$this->db->query("INSERT INTO admin_log (admin_username, ip_address, country, date, description, flag) VALUES ('".$username."', '".CoreHelp::getIp()."', '".CoreHelp::getCountryCode(CoreHelp::getIp())."', NOW(), '".$description."', 1)");	
	}
	
	public function getLog($email) {
		return 	$this->db->query("SELECT * FROM admin_log ORDER BY id DESC");
	}
	
	public function updateAdminUser($id, $username, $email, $password, $roles) {
		$this->db->query("UPDATE admin_users SET username=%s, email=%s, roles=%s WHERE id=%d", $username, $email, $roles, $id);
		if(strlen($password) > 0) {
			$this->db->query("UPDATE admin_users SET password=%s WHERE id=%d", hash('sha256', $password), $id);		
		}
	}

	
}
?>
