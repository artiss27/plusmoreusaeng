<?php


class Unilevel_Model extends iMVC_Model
{	
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
	
	public function GetSiteSettings()
	{
		$result = $this->db->query("SELECT keyname, value FROM settings");
		if (isset($result)) {
			foreach ($result as $row) {
				$kname       = $row['keyname'];
				$ret[$kname] = $row['value'];
			}
			return $ret;
		}
	}
	
	public function SetSetting($keyname, $default_value = "")
    {
        if ($default_value == "") {
            return;
        }
        $result = $this->db->replace('settings', array(
            'keyname' => $keyname,
            'value' => $default_value
        ));
        return;
    }

	public function payUpline($member, $amount, $membership)
	{
		$lang = CoreHelp::getLangPlugin('members', 'unilevel');
		set_time_limit(120);
		ignore_user_abort(1);		
		$depthCounter = 0;
		$referrerId = $member['sponsor_id'];
		$i            = 0;
		$commissionable = $amount;
		$settings = $this->GetSiteSettings();
		$depth        = $settings['setting_membership_unilevel_levels'];
		$this->insertPersonalVolume($member['member_id'], $member['member_id'], $amount, 'Volume added from own purchase', $settings);
		$this->insertPersonalVolume($member['sponsor_id'], $member['member_id'], $amount, 'Volume added from direct referral ('.$member['username'].') purchase', $settings);		
		while ($depthCounter < $depth) {
			$i++;
			if ($i > 100) {
				break;
			}
			if ($referrerId == 0) {
				break;
			}
			if($i == 1){
				if(isset($_SESSION['paid_start_up'])) {
					unset($_SESSION['paid_start_up']);	
					continue;
				}
			}
			$uplineMember = $this->db->queryFirstRow("SELECT * FROM members WHERE member_id = '".CoreHelp::sanitizeSQL($referrerId)."'");		
			$is_expired = ($uplineMember['membership_expiration'] > 0 && $uplineMember['membership_expiration'] < time()) ? 1 : 0;	
			if ($uplineMember['membership'] != '0'  && $is_expired == 0) { //free / customer dont earn, roll up						
				//if (Member::isQualified($uplineMember)) {
				//$uplineLevels = $this->GetSiteSetting($uplineMember['membership'].'_unilevel_levels', 0);
				//if ($uplineLevels > $depthCounter) {
					$depthCounter++;
					$this->insertGroupVolume($uplineMember['member_id'], $member['member_id'], $amount, 'Volume added from downline referral ('.$member['username'].') purchase', $settings);
					if ($settings['setting_membership_unilevel_unqualified_commision_' . $depthCounter] == 0 && $settings['setting_membership_unilevel_qualified_commision_' . $depthCounter] == 0) {
						$referrerId = $uplineMember['sponsor_id'];
						continue;					
						}
						$commission = $this->getCommission($uplineMember['member_id'], $commissionable, $depthCounter, $settings);										
						//$commision = number_format($this->GetSiteSetting('setting_membership_unilevel_commision_' . $depthCounter, 0) * $commissionable / 100, 2, '.', '');				
						if($commission > 0) {						
							$this->db->query("INSERT INTO wallet_payout (amount, transaction_type, from_id, to_id, transaction_date, descr) 
					VALUES ('" . $commission . "', '2', '" . $member['member_id'] . "', '" . $uplineMember['member_id'] . "', '" . time() . "', '".$lang['commission_downline']." (" . $member['username'] . ") ".$member['purchase']."' )");
						}
				//}
				//}
			}
			else {			
					if($this->GetSiteSetting('setting_unilevel_dynamic_compression', 0) == 'no') {
						//no rollup
						$depthCounter++;	
					}				
				}
			$referrerId = $uplineMember['sponsor_id'];
	}
}

	public function getMember($memberId) {
		return 	$this->db->queryFirstRow("SELECT * FROM members WHERE member_id = '".CoreHelp::sanitizeSQL($memberId)."'");
	}
	
	public function insertPersonalVolume($memberId, $fromId, $amount, $description, $settings) {
		$type = $settings['setting_unilevel_round_type'];
		$volume = $type == 'ceil' ? ceil($amount) : floor($amount);
		$this->db->insert('personal_volume', array(
			'member_id' => $memberId,
  			'from_member_id' => $fromId,
  			'amount' => $volume,
			'description' =>  $description
		));	
	}
	
	public function insertGroupVolume($memberId, $fromId, $amount, $description, $settings) {
		$type = $settings['setting_unilevel_round_type'];
		$volume = $type == 'ceil' ? ceil($amount) : floor($amount);
		$this->db->insert('group_volume', array(
			'member_id' => $memberId,
  			'from_member_id' => $fromId,
  			'amount' => $volume,
			'description' =>  $description
		));	
	}
	
	private function getCommission($memberId, $commissionable, $depthCounter, $settings) {
		$trace_pv_days = $settings['setting_unilevel_pv_days'];
		$trace_gv_days = $settings['setting_unilevel_gv_days'];
		
		$unqualified_percent 	= $settings['setting_membership_unilevel_unqualified_commision_' . $depthCounter];
		$qualified_percent 		= $settings['setting_membership_unilevel_qualified_commision_' . $depthCounter];	
		$qualified_direct		= $settings['setting_membership_unilevel_frontline_commision_' . $depthCounter];
		$qualified_pv 			= $settings['setting_membership_unilevel_pv_commision_' . $depthCounter];
		$qualified_gv 			= $settings['setting_membership_unilevel_gv_commision_' . $depthCounter];
		
		$paid_referrals =  intval($this->db->queryFirstField("SELECT count(*) FROM members WHERE sponsor_id = %d AND membership != '0'", $memberId));
		$pv				=  intval($this->db->queryFirstField("SELECT sum(amount) FROM personal_volume WHERE member_id = %d AND date > NOW() - INTERVAL $trace_pv_days day", $memberId)); 
		$gv				=  intval($this->db->queryFirstField("SELECT sum(amount) FROM group_volume WHERE member_id = %d AND date > NOW() - INTERVAL $trace_gv_days day", $memberId));
		
		if ($paid_referrals >= $qualified_direct && $pv >= $qualified_pv && $gv >= $qualified_gv) {
			return 	number_format($qualified_percent * $commissionable / 100, 2, '.', '');
		}
		else {
			return 	number_format($unqualified_percent * $commissionable / 100, 2, '.', '');
		}		
	}
	
}