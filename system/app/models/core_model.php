<?php
class Core_Model extends iMVC_Model
{
	public function SetSetting($keyname, $default_value = "")
    {
        if ($default_value === "") {
            return;
        }
        $result = $this->db->replace('settings', array(
            'keyname' => $keyname,
            'value' => $default_value
        ));
        return;
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
	public function GetMemberships()
	{
		$result = $this->db->query("SELECT id, membership FROM memberships");
		if (isset($result)) {
			foreach ($result as $row) {
				$kname         = $row['id'];
				$ret["$kname"] = $row['membership'];
			}
			return $ret;
		}
	}
	public function FirstField($sql, $default_value = "")
	{
		$this_return = $default_value;
		$result      = $this->db->queryFirstField($sql);
		if ($result != false) {
			$this_return = $result;
		}
		if ($this_return == NULL)
			$this_return = $default_value;
		return $this_return;
	}
	public function getPayFormCode($member_id, $amount, $aditional, $processor_id, $product, $membership)
	{
		$lang = CoreHelp::getLang('members');
        $this->smarty->assign("lang", $lang);
		$row = $this->db->queryFirstRow("select * From payment_processors where processor_id='$processor_id' and active=1");
		if (count($row)) {
			$procKeyname = $row["code"];
			$accountId   = $row["account_id"];
			$routineUrl  = $row["processor_url"];
		} else {
			return "error";
		}
		$siteTitle   = $this->GetSiteSetting("site_name");
		$siteUrl     = CoreHelp::getSiteUrl();
		$badUrl      = $SiteUrl . "payment/&code=no";
		$returnUrl   = $SiteUrl . "payment/&code=ok";
		$description = "$siteTitle $membership " . $lang['deposit'];
		$data        = array(
			'procKeyname' => $procKeyname,
			'accountId' => $accountId,
			'routineUrl' => $badUrl,
			'cancelUrl' => $procKeyname,
			'returnUrl' => $returnUrl,
			'description' => $description,
			'amount' => $amount,
			'product' => $product,
			'aditional' => $aditional,
			'memberId' => $member_id
		);
		$pClass      = "iMVC_Library_Processor_" . ucfirst($procKeyname);
		$processor   = new $pClass();
		$code        = $processor->getCode($data);
		return $code;
	}
	
	public function getMessages($memberId) {		
		return $this->FirstField("SELECT count(*) FROM messages WHERE `to` = '" . $memberId . "' && `to_viewed` = '0' && `to_deleted` = '0' && `alert` = '0'", "0");	
	}
	
	public function haveDeposit($memberId) {		
		$ypayment = $this->FirstField("SELECT membership FROM members WHERE member_id='$memberId'", 0);
		return $ypayment != 0 ? true : false;	
	}
	
	public function getCountries() {
		return $this->db->query("SELECT * FROM countries ORDER BY name ASC");	
	}
	
	public function saveVisitor($id) {
		if(!$this->db->query("SELECT * FROM visitors WHERE ip_address = %s AND date > DATE_SUB( NOW(), INTERVAL 1 DAY )", CoreHelp::getIp())) {
			return $this->db->insert('visitors', array('ip_address' => CoreHelp::getIp(), 'country' => CoreHelp::getCountryName(CoreHelp::getIp()), 'date' => date("Y-m-d"), 'referrer' => CoreHelp::getReferrer()));
		}			
	}
	
	public function insertPifLog($from, $to, $amount) {
		$this->db->insert('pif_log', array('to_id' => $to, 'from_id' => $from, 'amount' => $amount));	
	}	
	
	public function insertAdCreditLog($member_id, $type, $amount, $description) {
		$this->db->insert('ad_credit_log', array('member_id' => $member_id, 'type' => $type, 'amount' => $amount, 'description' => $description));	
	}
}
?>