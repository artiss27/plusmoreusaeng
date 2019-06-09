<?php
class Main_Model extends iMVC_Model
{
	function GetSiteSetting($keyname, $default_value = "")
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
	function GetSiteSettings()
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
	function GetValidQuery($key, $name, $type = VALIDATE_NOT_EMPTY, $default_valueue = "")
	{
		$value = $default_valueue;
		if (array_key_exists($key, $_GET))
			$value = trim($_GET[$key], "\x00..\x20");
		elseif (array_key_exists($key, $_POST))
			$value = trim($_POST[$key], "\x00..\x20");
		switch ($type) {
			case VALIDATE_NOT_EMPTY:
				if ($value == "") {
					$this->SetError($key, "You should specify '$name'.");
				}
				break;
			case VALIDATE_USERNAME:
				if (preg_match("/^[\w]{4,20}\$/i", $value) == 0) {
					$this->SetError($key, "'$name' must consist of 4 up to 20 symbols.");
				}
				break;
			case VALIDATE_PASSWORD:
				if (preg_match("/^[\w]{8,20}\$/i", $value) == 0) {
					$this->SetError($key, "'$name' must consist of 8 up to 20 symbols.");
				}
				break;
			case VALIDATE_PASS_CONFIRM:
				if ($value != $name) {
					$this->SetError($key, "Passwords don't match.");
				}
				break;
			case VALIDATE_EMAIL:
				if (preg_match("/^[-_\.0-9a-z]+@[-_\.0-9a-z]+\.+[a-z]{2,4}\$/i", $value) == 0) {
					$this->SetError($key, "'$name' is wrong.");
				}
				break;
			case VALIDATE_INT_POSITIVE:
				if (!is_numeric($value) or (preg_match("/^\d+\$/i", $value) == 0)) {
					$this->SetError($key, "Field '$name' must be integer,positive and numerical.");
				}
				break;
			case VALIDATE_FLOAT_POSITIVE:
				if (!is_numeric($value) or (preg_match("/^[\d]+\.+[\d]+\$/i", $value) == 0)) {
					$this->SetError($key, "Field '$name' should be a positive float (format:12.34).");
				}
				break;
			case VALIDATE_CHECKBOX:
				if ($value == $default_valueue) {
					$this->SetError($key, "'$name'.");
				}
				break;
			case VALIDATE_NUMERIC:
				if (!is_numeric($value)) {
					$this->SetError($key, "'$name' should be a numeric.");
				}
				break;
			case VALIDATE_NUMERIC_POSITIVE:
				if (!is_numeric($value) Or $value < 0) {
					$this->SetError($key, "'$name' should be a numeric.");
				}
				break;
		}
		return $value;
	}
	function enc($value)
	{
		$search  = array(
			"/</",
			"/>/",
			"/'/"
		);
		$replace = array(
			"&lt;",
			"&gt;",
			"&#039;"
		);
		return preg_replace($search, $replace, $value);
	}
	function SetError($key, $text)
	{
		$this->errors['err_count']++;
		$this->errors[$key] = $text;
	}
	function GetQuery($key, $default_valueue = "")
	{
		$this_return = $default_valueue;
		if (array_key_exists($key, $_GET))
			$this_return = (is_array($_GET[$key])) ? $_GET[$key] : trim($_GET[$key]);
		elseif (array_key_exists($key, $_POST))
			$this_return = (is_array($_POST[$key])) ? $_POST[$key] : trim($_POST[$key]);
		return (get_magic_quotes_gpc()) ? stripslashes($this_return) : $this_return;
	}
	function GetSession($str, $default_valueue = "")
	{
		if (!isset($_SESSION)) {
			session_start();
		}
		global $_SESSION;
		$this_return = $default_valueue;
		if (array_key_exists($str, $_SESSION))
			$this_return = trim($_SESSION[$str]);
		return $this_return;
	}
	function Redirect($targetURL)
	{
		header("Location: $targetURL");
		exit();
	}
	function sendMail($email, $subject, $message, $header)
	{
		@mail($email, $subject, $message, $header);
		return true;
	}
	function memberIsLoggedIn()
	{
		if (!isset($_SESSION)) {
			session_start();
		}
		global $_SESSION;
		if (!isset($_SESSION['MemberID'])) {
			return false;
		}
		return true;
	}
	function memberLogin($user, $password)
	{
		if (!isset($_SESSION)) {
			session_start();
		}
		global $_SESSION;
		$member_id = $this->db->queryFirstField("Select member_id from members Where username=%s And password=%s And is_active=1", $user, $password);
		if ($member_id > 0) {
			$_SESSION['Username'] = $user;
			$_SESSION['MemberID'] = $member_id;
			return true;
		} else {
			return false;
		}
	}
	function GetMemberships()
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
	function FirstField($sql, $default_value = "")
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

}
?>