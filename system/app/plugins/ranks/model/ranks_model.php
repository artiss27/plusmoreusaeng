<?php
class Ranks_Model extends iMVC_Model
{	
	
	public function updateTableById($table, $id, $values) {
		$this->db->update($table, $values, "id=%d", $id);
	}	
	
	public function deleteById($id) {
		$this->db->query("DELETE FROM ranks WHERE id = %d", $id);
	}	
	
	public function getRanks() {
		return 	$this->db->query("SELECT * FROM ranks ORDER BY order_index ASC");
	}
	
	public function getRank($id) {
		return 	$this->db->queryFirstRow("SELECT * FROM ranks WHERE id = %d", $id);
	}
	
	public function GetSiteSetting($keyname, $default_value = "")
	{
		$this_return = $default_value;
		$result      = $this->db->queryFirstField('select value from settings where keyname=%s', $keyname);
		if ($result != false) {
			$this_return = $result;
		}
		if ($this_return == NULL)
			$this_return = $default_value;
		return $this_return;
	}
	
	public function createRank($name, $required_direct, $required_pv, $required_gv, $image) {
		$max = $this->maxRankOrder();
		$order_index = $max > 0 ? $max + 1 : 1;
		$this->db->insert('ranks', array(
			'order_index' => $order_index,
  			'name' => $name,
  			'image' => $image,
			'direct_required' =>  $required_direct,
			'pv_required' =>  $required_pv,
			'gv_required' =>  $required_gv,
		));	
		return $this->db->insertId();	
	}
	
	public function maxRankOrder() {		
	   return $this->db->queryFirstField("SELECT max(order_index) FROM ranks");
   }
   
   public function rankUp($id) {		
		$order_index = $this->db->queryFirstField("SELECT order_index FROM ranks WHERE id=%d", $id);
		$next_order_index = ($order_index-1);
		$this->db->query("UPDATE ranks SET order_index = (order_index+1) WHERE order_index=%d", $next_order_index);
		$this->db->query("UPDATE ranks SET order_index = (order_index-1) WHERE id=%d", $id);
   }
   
    public function rankDown($id) {		
		$order_index = $this->db->queryFirstField("SELECT order_index FROM ranks WHERE id=%d", $id);
		$next_order_index = ($order_index+1);
		$this->db->query("UPDATE ranks SET order_index = (order_index-1) WHERE order_index=%d", $next_order_index);
		$this->db->query("UPDATE ranks SET order_index = (order_index+1) WHERE id=%d", $id);
   }
   
   public function getRankData($memberId) {
	   if($_SESSION['plan']['unilevel'] == 1) {
			$trace_pv_days = $this->GetSiteSetting('setting_unilevel_pv_days');
			$trace_gv_days = $this->GetSiteSetting('setting_unilevel_gv_days');
	   }
	   elseif($_SESSION['plan']['forced'] == 1) {
			$trace_pv_days = $this->GetSiteSetting('setting_forced_pv_days');
			$trace_gv_days = $this->GetSiteSetting('setting_forced_gv_days');   
	   }
	   elseif($_SESSION['plan']['binary'] == 1) {
			$trace_pv_days = $this->GetSiteSetting('setting_binary_pv_days');
			$trace_gv_days = $this->GetSiteSetting('setting_binary_gv_days');   
	   }
	   else {
			return;   
	   }
		$paid_referrals =  intval($this->db->queryFirstField("SELECT count(*) FROM members WHERE sponsor_id = %d AND membership != '0'", $memberId));
		$pv				=  intval($this->db->queryFirstField("SELECT sum(amount) FROM personal_volume WHERE member_id = %d AND date > NOW() - INTERVAL $trace_pv_days day", $memberId)); 
		$gv				=  intval($this->db->queryFirstField("SELECT sum(amount) FROM group_volume WHERE member_id = %d AND date > NOW() - INTERVAL $trace_gv_days day", $memberId)); 
		$rank			=  $this->db->queryFirstRow("SELECT * FROM ranks WHERE direct_required <= $paid_referrals AND pv_required <= $pv AND gv_required <= $gv ORDER BY order_index DESC LIMIT 1"); 
		
		return array('current_rank' => $rank['name'],
					'current_rank_image' => $rank['image'],
					'paid_referrals' => $paid_referrals,
					'personal_volume' => number_format($pv, 0, ' ', ' '),
					'group_volume' =>  number_format($gv, 0, ' ', ' '));
   }
	
}
?>
