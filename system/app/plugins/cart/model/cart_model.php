<?php
class Cart_Model extends iMVC_Model
{	
	
	public function updateTableById($table, $id, $values) {
		$this->db->update($table, $values, "id=%d", $id);
	}

	
	public function getCustomers($username) {
		return $this->db->query("SELECT * FROM bsc_customers WHERE store_owner = %s", $username);	
	}
	
	public function getSales($username) {
		return $this->db->query("SELECT b.* FROM bsc_customers as a, bsc_order_detail as b WHERE a.store_owner = %s AND a.payer_email = b.payer_email", $username);	
	}
	
	public function getTotalPurchases($email) {
		$row  = $this->db->queryFirstRow("SELECT SUM(payment_amount) as total FROM bsc_order_header WHERE payer_email = %s", $email);	
		return isset($row['total']) ? number_format($row['total'], 2, '.', '') : '0.00';
	}
	
	public function getProductImage($productCode) {
		$row  = $this->db->queryFirstRow("SELECT img FROM bsc_products WHERE productCode = %s", $productCode);	
		return isset($row['img']) ? $row['img'] : '';
	}
	
	public function getCommissions() {
		return $this->db->query("SELECT * FROM wallet_payout WHERE to_id = %d AND transaction_type = 5", $_SESSION['member_id']);	
	}
}
?>