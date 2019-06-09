<?php
class Invoicer_Model extends iMVC_Model
{	
	
	public function updateTableById($table, $id, $values) {
		$this->db->update($table, $values, "id=%d", $id);
	}
	
	public function saveInvoice($memberId, $reference, $name, $description, $amount, $vat) {
		$this->db->insert('invoices', array(
  			'member_id' => $memberId,
			'reference_number' => $reference,
  			'item_name' => $name,
			'item_description' => $description,
			'amount' => $amount,
			'vat' => $vat,
			'total_amount' => $amount
		));		
	}	
	
	public function getInvoices($memberId) {
		return 	$this->db->query("SELECT * FROM invoices WHERE member_id = %d ORDER BY id DESC", $memberId);
	}
	
	
	
}
?>
