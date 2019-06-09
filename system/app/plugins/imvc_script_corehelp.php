<?php
class CoreHelp
{
	public static function redirect($location)
	{
		if ($location == 'back') {
			if ($_SERVER['HTTP_REFERER']) {				
				if (headers_sent()) {
					die("<script>window.location = '".$_SERVER['HTTP_REFERER']."'</script>");
				}
				else{
					exit(header('Location: ' . $_SERVER['HTTP_REFERER']));
				}
			} else {
				if (headers_sent()) {
					die("<script>window.location = '/'</script>");
				}
				else{
					exit(header('Location: /'));
				}				
			}
			exit;
		} else {
			if (headers_sent()) {
					die("<script>window.location = '".$location."'</script>");
				}
				else{
					exit(header('Location: ' . $location));
				}	
		}
	}
	public static function getLang($location)
	{
		if ($location == 'members') {
			include("system/languages/lang.php");
			$core          = new Core_Model;
			$lang_selected = $core->GetSiteSetting("backoffice_lang");
			if ($languages[$lang_selected] && file_exists('system/languages/' . $languages[$lang_selected]['file'])) {
				include("system/languages/" . $languages[$lang_selected]['file']);
			} else {
				include("system/languages/en.lang.php");
			}
		} elseif ($location == 'admin') {
			include("system/languages/lang.php");
			$core          = new Core_Model;
			$lang_selected = $core->GetSiteSetting("admin_lang");
			if ($languages[$lang_selected] && file_exists('system/languages/' . $languages[$lang_selected]['file'])) {
				include("system/languages/" . $languages[$lang_selected]['file']);
			} else {
				include("system/languages/en.lang.php");
			}
		} else {
			include("system/languages/en.lang.php");
		}
		return $lang;
	}
	public static function getLangPlugin($location, $plugin)
	{
		if ($location == 'members') {
			include("system/languages/lang.php");
			$core          = new Core_Model;
			$lang_selected = $core->GetSiteSetting("backoffice_lang");
			if ($languages[$lang_selected] && file_exists('system/app/plugins/' . $plugin . '/languages/' . $languages[$lang_selected]['file'])) {
				include('system/app/plugins/' . $plugin . '/languages/' . $languages[$lang_selected]['file']);
			} else {
				include('system/app/plugins/' . $plugin . '/languages/en.lang.php');
			}
		} elseif ($location == 'admin') {
			include("system/languages/lang.php");
			$core          = new Core_Model;
			$lang_selected = $core->GetSiteSetting("admin_lang");
			if ($languages[$lang_selected] && file_exists('system/app/plugins/' . $plugin . '/languages/' . $languages[$lang_selected]['file'])) {
				include('system/app/plugins/' . $plugin . '/languages/' . $languages[$lang_selected]['file']);
			} else {
				include('system/app/plugins/' . $plugin . '/languages/en.lang.php');
			}
		} else {
		}
		return $lang;
	}
	public static function getIp()
	{
		return $_SERVER['REMOTE_ADDR'];
	}
	public static function getCountryName($ip)
	{
		$country_code = \TabGeo\country($ip);
		$converter    = new \ChibiFR\CountryConverter\Converter();
		try{
			$converted = $converter->getCountryName($country_code);
		}
		catch(Exception $e){
			$country_code = "AA";		
		}
		return $country_code == "AA" || $country_code == "EU"   ? 'Europe' : $converted;
	}
	public static function getCountryCode($ip)
	{
		return \TabGeo\country($ip);
	}
	public static function getReferrer()
	{
		return strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) ? '' : $_SERVER['HTTP_REFERER'];
	}
	public static function GetValidQuery($key, $name, $type = VALIDATE_NOT_EMPTY, $default_value = "")
	{
		$lang  = CoreHelp::getLang(tmvc::instance()->url_segments[1]);
		$value = $default_value;
		if (array_key_exists($key, $_GET))
			$value = strip_tags(trim($_GET[$key], "\x00..\x20"));
		elseif (array_key_exists($key, $_POST))
			$value = strip_tags(trim($_POST[$key], "\x00..\x20"));
		switch ($type) {
			case VALIDATE_NOT_EMPTY:
				if ($value == "") {
					self::setError($key, $lang['you_should_specify'] . " '$name'.");
				}
				break;
			case VALIDATE_USERNAME:
				if (preg_match("/^[\w]{2,20}\$/i", $value) == 0) {
					self::setError($key, "'$name' " . $lang['has_to_consist_of_from__up_to__symbols']);
				}
				break;
			case VALIDATE_PASSWORD:
				if (preg_match("/^[\w]{8,20}\$/i", $value) == 0) {
					self::setError($key, "'$name' " . $lang['has_consist_of_from__up_to__symbols']);
				}
				break;
			case VALIDATE_PASS_CONFIRM:
				if ($value != $name) {
					self::setError($key, $lang['passwords_dont_match']);
				}
				break;
			case VALIDATE_EMAIL:
				if (preg_match("/^[-_\.0-9a-z]+@[-_\.0-9a-z]+\.+[a-z]{2,4}\$/i", $value) == 0) {
					self::setError($key, "'$name' " . $lang['is_wrong']);
				}
				break;
			case VALIDATE_INT_POSITIVE:
				if (!is_numeric($value) or (preg_match("/^\d+\$/i", $value) == 0)) {
					self::setError($key, $lang['field'] . " '$name' " . $lang['has_to_be_integerpositive_and_numerical']);
				}
				break;
			case VALIDATE_FLOAT_POSITIVE:
				if (!is_numeric($value) or (preg_match("/^[\d]+\.+[\d]+\$/i", $value) == 0)) {
					self::setError($key, "Field '$name' should be a positive float (format:12.34).");
				}
				break;
			case VALIDATE_CHECKBOX:
				if ($value == $default_valueue) {
					self::setError($key, $lang['you_have_to_take'] . " '$name'.");
				}
				break;
			case VALIDATE_NUMERIC:
				if (!is_numeric($value)) {
					self::setError($key, "'$name' " . $lang['should_be_a_numeric']);
				}
				break;
			case VALIDATE_NUMERIC_POSITIVE:
				if (!is_numeric($value) Or $value < 0) {
					self::setError($key, "'$name' " . $lang['should_be_a_numeric']);
				}
				break;
		}
		return $value;
	}
	public static function GetQuery($key, $default_value = "")
	{
		$getval = $default_value;
		if (array_key_exists($key, $_REQUEST))
			$getval = (is_array($_REQUEST[$key])) ? $_REQUEST[$key] : trim($_REQUEST[$key]);
		elseif (array_key_exists($key, $_POST))
			$getval = (is_array($_POST[$key])) ? $_POST[$key] : trim($_POST[$key]);
		elseif (array_key_exists($key, $_GET))
			$getval = (is_array($_GET[$key])) ? $_GET[$key] : trim($_GET[$key]);
		return (get_magic_quotes_gpc()) ? stripslashes($getval) : $getval;
	}
	public static function getSession($str, $default_valueue = "")
	{
		$getval = $default_valueue;
		if (array_key_exists($str, $_SESSION))
			$getval = trim($_SESSION[$str]);
		return $getval;
	}
	public static function enc($value)
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
	public static function dec($value)
	{
		$search  = array(
			"/&lt;/",
			"/&gt;/",
			"/&#039;/"
		);
		$replace = array(
			"<",
			">",
			"'"
		);
		return preg_replace($search, $replace, $value);
	}
	public static function sendMail($email, $subject, $message, $header, $attach)
	{
		if (DEMO) {
			CoreHelp::setSession('error', 'Cannot send emails in demo mode');
			return false;
		}
		$is_html = 0;
		if(md5($message) != md5(strip_tags($message))) {
   			$is_html = 1;
		}		
		$settings = \tmvc::instance()->controller->admin->GetSiteSettings();
		if ($settings['mailgate'] == 'php') {
			if($attach) {
				self::mailAttachment($email, $subject, $message, $settings['admin_email'], $attach);
			}
			else {
				if ($is_html) {
					$header  = "From: " . $settings['admin_email'] . "\r\n";
					$header .= "Reply-To: ". $settings['admin_email'] . "\r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";	
				}
				@mail($email, $subject, $message, $header);
			}
		} else {
			try {
				
				$is_ssl      = $settings['mailgate'] == 'smtp_ssl' ? 'ssl' : '';
				$transporter = Swift_SmtpTransport::newInstance($settings['smtp_host'], $settings['smtp_port'], "$is_ssl")->setUsername($settings['smtp_login'])->setPassword($settings['smtp_password']);
				$mailer      = Swift_Mailer::newInstance($transporter);
				$content     = Swift_Message::newInstance($subject)->setFrom(array(
					$settings['admin_email'] => $settings['site_name']
				))->setTo(array(
					$email
				));
				if($is_html){ 
					$content->setBody(str_replace("\n", '<br>', $message));
					$content->setContentType("text/html");	
				}
				else {
					$content->setBody(strip_tags(str_replace('<br>', "\n", $message)));	
				}
				if($attach) {
				$content->attach(
					Swift_Attachment::fromPath($attach)->setFilename(basename($attach))
				);
				}
				$result      = $mailer->send($content);
			}
			catch (\Exception $e) {				
			}
		}
		return true;
	}
	
	public static function mailAttachment($to, $subject, $message, $from, $file) 
	{
	  $filename = basename($file);
	  $file_size = filesize($file);
	  $content = chunk_split(base64_encode(file_get_contents($file))); 
	  $uid = md5(uniqid(time()));
	  $from = str_replace(array("\r", "\n"), '', $from); // to prevent email injection
	  $header = "From: ".$from."\r\n"
		  ."MIME-Version: 1.0\r\n"
		  ."Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n"
		  ."This is a multi-part message in MIME format.\r\n" 
		  ."--".$uid."\r\n"
		  ."Content-type:text/plain; charset=iso-8859-1\r\n"
		  ."Content-Transfer-Encoding: 7bit\r\n\r\n"
		  .strip_tags(str_replace('<br>', "\n", $message))."\r\n\r\n"
		  ."--".$uid."\r\n"
		  ."Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"
		  ."Content-Transfer-Encoding: base64\r\n"
		  ."Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n"
		  .$content."\r\n\r\n"
		  ."--".$uid."--"; 
	  return mail($to, $subject, "", $header);
 	}
	
	public static function memberIsLoggedIn()
	{
		if (!isset($_SESSION)) {
			return false;
		}
		return isset($_SESSION['MemberID']) ? true : false;
	}
	public static function getMemberId()
	{
		if (!isset($_SESSION)) {
			return false;
		}
		return isset($_SESSION['MemberID']) ? $_SESSION['MemberID'] : false;
	}
	public static function setError($key, $text)
	{
		$_SESSION['errors']['err_count']++;
		$_SESSION['errors'][$key] = $text;
	}
	public static function getCountErrors()
	{
		return (isset($_SESSION['errors']['err_count'])) ? $_SESSION['errors']['err_count'] : 0;
	}
	public static function getErrors()
	{
		$errors             = $_SESSION['errors'];
		$_SESSION['errors'] = array();
		unset($errors['err_count']);
		return $errors;
	}
	public static function getMonthSelect($value = "", $name = "dateMonth", $straif = 0)
	{
		$lang = CoreHelp::getLang(tmvc::instance()->url_segments[1]);
		if ($value == "" Or $value == 0)
			$value = date("m") + $straif;
		if ($value > 12)
			$value = $value - 12;
		if ($value < 1)
			$value = $value + 12;
		$getval = "<select class='form-control' style='width:150px;display:inline' name='$name'>";
		if ($value == 1)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='1' $check>" . $lang['january'] . "</option>";
		if ($value == 2)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='2' $check>" . $lang['february'] . "</option>";
		if ($value == 3)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='3' $check>" . $lang['march'] . "</option>";
		if ($value == 4)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='4' $check>" . $lang['april'] . "</option>";
		if ($value == 5)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='5' $check>" . $lang['may'] . "</option>";
		if ($value == 6)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='6' $check>" . $lang['june'] . "</option>";
		if ($value == 7)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='7' $check>" . $lang['july'] . "</option>";
		if ($value == 8)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='8' $check>" . $lang['august'] . "</option>";
		if ($value == 9)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='9' $check>" . $lang['september'] . "</option>";
		if ($value == 10)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='10' $check>" . $lang['october'] . "</option>";
		if ($value == 11)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='11' $check>" . $lang['november'] . "</option>";
		if ($value == 12)
			$check = "selected";
		else
			$check = "";
		$getval .= "<option value='12' $check>" . $lang['december'] . "</option>";
		return $getval . "</select>&nbsp;&nbsp;";
	}
	public static function getYearSelect($value = "", $name = "dateYear")
	{
		$getval = "<select class='form-control' style='width:80px;display:inline' name='$name'>";
		if ($value == "" Or $value == 0)
			$value = date("Y");
		$start = date("Y") - 3;
		if ($value < $start)
			$start = $value - 1;
		for ($i = $start; $i <= (date("Y") + 3); $i++) {
			if ($value == $i)
				$check = "selected";
			else
				$check = "";
			$getval .= "<option value='$i' $check> $i </option>";
		}
		return $getval . "</select>&nbsp;&nbsp;";
	}
	public static function getDays($month, $year)
	{
		switch ($month) {
			case 1:
				$days = 31;
				break;
			case 2:
				$days = (floor($year / 4) == $year / 4) ? 29 : 28;
				break;
			case 3:
				$days = 31;
				break;
			case 4:
				$days = 30;
				break;
			case 5:
				$days = 31;
				break;
			case 6:
				$days = 30;
				break;
			case 7:
				$days = 31;
				break;
			case 8:
				$days = 31;
				break;
			case 9:
				$days = 30;
				break;
			case 10:
				$days = 31;
				break;
			case 11:
				$days = 30;
				break;
			case 12:
				$days = 31;
				break;
			default:
				$days = 30;
		}
		return $days;
	}
	public static function getDaySelect($value = "", $name = "dateDay")
	{
		if ($value == "" Or $value == 0)
			$value = date("d");
		$getval = "<select class='form-control' style='width:80px;display:inline' name='$name'>";
		for ($i = 1; $i < 32; $i++) {
			if ($value == $i)
				$check = "selected";
			else
				$check = "";
			if (strlen($i) == 1)
				$i = "0" . $i;
			$getval .= "<option value='$i' $check> $i </option>";
		}
		return $getval . "</select>&nbsp;&nbsp;";
	}
	public static function getStatusSelect($value = "")
	{
		$lang        = CoreHelp::getLang(tmvc::instance()->url_segments[1]);
		$statusList  = array(
			"0" => $lang['pending'],
			"1" => $lang['completed'],
			"2" => $lang['declined']
		);
		$this_return = "<select class='form-control' style='width:80px;display:inline' name='status' id='status' >";
		foreach ($statusList as $k => $v)
			$this_return .= ($value == $k) ? "<option value='$k' selected>$v</option>" : "<option value='$k'>$v</option>";
		$this_return .= "</select>";
		return $this_return;
	}
	public static function getSiteUrl()
	{
		return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/";
	}
	public static function stripAll($message)
	{
		$message = strip_tags($message, '');
		$message = stripslashes($message);
		$message = nl2br($message);
		return $message;
	}
	public static function getSessionKey()
	{
		if (isset($_SESSION['ckey'])) {
			$ckey = $_SESSION['ckey'];
		} else {
			$_SESSION['ckey'] = uniqid();
			$ckey             = $_SESSION['ckey'];
		}
		return $ckey;
	}
	public static function setSession($name, $value)
	{
		$_SESSION[$name] = $value;
	}
	public static function generateRandomString($length, $type = null)
	{
		switch ($type) {
			case "uc":
				$characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				break;
			case "lc":
				$characters = "abcdefghijklmnopqrstuvwxyz";
				break;
			case "number":
				$characters = "0123456789";
				break;
			case "uc_number":
				$characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				break;
			case "lc_number":
				$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
				break;
			case "uc_lc":
				$characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
				break;
			default:
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
		}
		$charactersLength = strlen($characters);
		$randomString     = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	public static function generateToken()
	{
		$token = array(
			self::generateRandomString(8, 'lc_number'),
			self::generateRandomString(4, 'lc_number'),
			self::generateRandomString(4, 'lc_number'),
			self::generateRandomString(4, 'lc_number'),
			self::generateRandomString(12, 'lc_number')
		);
		return implode('-', $token);
	}
	public static function formatDecimal($num)
	{
		return number_format($num, 2, '.', '');
	}
	public static function dateDiffNowDaysHoursMins($date, $time = 0)
	{
		if ($time == 0) {
			$all = round((strtotime($date) - time()) / 60);
		} else {
			$all = round(($date - time()) / 60);
		}
		$d = floor($all / 1440);
		$h = floor(($all - $d * 1440) / 60);
		$m = $all - ($d * 1440) - ($h * 60);
		return array(
			'd' => $d,
			'h' => $h,
			'm' => $m
		);
	}
	public static function flash($var)
	{
		$answer = $_SESSION[$var];
		unset($_SESSION[$var]);
		return $answer;
	}
	public static function replaceMail($message, $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $id, $username)
	{
		return str_replace(array(
			"[FirstName]",
			"[LastName]",
			"[SiteTitle]",
			"[SiteName]",
			"[SiteUrl]",
			"[AdminMail]",
			"[SponsorUsername]",
			"[SponsorID]",
			"[UserID]",
			"[MemberUsername]",
			"[Username]"
		), array(
			$firstName,
			$lastName,
			$siteTitle,
			$siteTitle,
			$siteUrl,
			$adminEmail,
			$sponsorUsername,
			$sponsorId,
			$id,
			$username,
			$username
		), $message);
	}
	public static function sanitizeSQL($var)
	{
		return iMVC_DB::escape($var);
	}
	public static function GetQueryAll()
	{
		return $_REQUEST;
	}
	public static function encrypt($data)
	{
		$key = CoreHelp::getSessionKey();
		return strtr(base64_encode(addslashes(gzcompress(serialize(\tmvc::instance()->controller->crypt->encrypt($key, $data)), 9))), '+/=', '-_,');
	}
	public static function decrypt($data)
	{
		$key = CoreHelp::getSessionKey();
		return \tmvc::instance()->controller->crypt->decrypt($key, unserialize(gzuncompress(stripslashes(base64_decode(strtr($data, '-_,', '+/='))))));
	}
	public static function setSessionOld()
	{
		$_SESSION['old']          = array_map('strip_tags', $_POST);
		$_SESSION['old']['timer'] = time() + 60;
	}
	public static function unsetSessionOld()
	{
		unset($_SESSION['old']);
	}
	public static function resetSessionOld()
	{
		if (isset($_SESSION['old'])) {
			if ($_SESSION['old']['timer'] < time()) {
				unset($_SESSION['old']);
			}
		}
	}
	public static function arrayToPDOParams($array)
	{
		$temp = array();
		foreach (array_keys($array) as $name) {
			$temp[] = "`$name` = ?";
		}
		return implode(', ', $temp);
	}
	public static function trackRetries($name, $ajax = 0)
	{
		if (isset($_SESSION['retries'][$name])) {
			if ($_SESSION['retries'][$name]['counter'] >= 3 && $_SESSION['retries'][$name]['last_time'] > time() - 60) {
				$lang = self::getLang('members');
				CoreHelp::setSession('error', $lang['retries_limit_reached_wait_one_minute_and_try_again']);
				if($ajax) {
					echo $lang['retries_limit_reached_wait_one_minute_and_try_again'];
					exit;
				}
				else {
					CoreHelp::redirect('back');
				}
			} elseif ($_SESSION['retries'][$name]['counter'] >= 3 && $_SESSION['retries'][$name]['last_time'] < time() - 60) {
				$_SESSION['retries'][$name]['counter']   = 1;
				$_SESSION['retries'][$name]['last_time'] = time();
			} else {
				$_SESSION['retries'][$name]['counter']++;
				$_SESSION['retries'][$name]['last_time'] = time();
			}
		} else {
			$_SESSION['retries'][$name]['counter']   = 1;
			$_SESSION['retries'][$name]['last_time'] = time();
		}
	}
	public static function emailCommission($memberId, $amount, $description)
	{
		$lang = self::getLang('members');
		if (\tmvc::instance()->controller->core->GetSiteSetting("alert_commission") == "yes") {
			$adminEmail  = \tmvc::instance()->controller->core->GetSiteSetting("admin_email");
			$siteUrl     = \tmvc::instance()->controller->core->GetSiteSetting('site_url');
			$siteTitle   = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
			$emailHeader = "From: " . $adminEmail . "\r\n";
			list($email, $firstName, $lastName, $sponsorId, $username) = array_values(\tmvc::instance()->controller->core->db->queryFirstRow("SELECT email,first_name,last_name,sponsor_id,username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'"));
			$sponsorUsername = \tmvc::instance()->controller->core->db->queryFirstField("SELECT username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsorId) . "'");
			$sponsorEmail = \tmvc::instance()->controller->core->db->queryFirstField("SELECT email FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsorId) . "'");
			list($message, $subject) = array_values(\tmvc::instance()->controller->core->db->queryFirstRow("SELECT message,subject FROM emailtemplates WHERE code='NotifyMemberCommision'"));
			$message = CoreHelp::replaceMail($message, $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
			$subject = CoreHelp::replaceMail($subject, $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
			$message = str_replace('[Description]', '$' . number_format($amount, 2, '.', '') . ' ' . strtolower($lang['for']) . ' ' . $description . ' ' . strtolower($lang['from']) . ' ' . $username, $message);
			CoreHelp::sendMail($sponsorEmail, $subject, $message, $emailHeader);
		}
	}
	
	public static function emailNewReferral($memberId)
	{
		$lang = self::getLang('members');
		if (\tmvc::instance()->controller->core->GetSiteSetting("alert_downline") == "yes") {
			$adminEmail  = \tmvc::instance()->controller->core->GetSiteSetting("admin_email");
			$siteUrl     = \tmvc::instance()->controller->core->GetSiteSetting('site_url');
			$siteTitle   = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
			$emailHeader = "From: " . $adminEmail . "\r\n";
			list($sponsorId, $username) = array_values(\tmvc::instance()->controller->core->db->queryFirstRow("SELECT sponsor_id,username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'"));
			list($email, $firstName, $lastName) = array_values(\tmvc::instance()->controller->core->db->queryFirstRow("SELECT email,first_name,last_name,sponsor_id,username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsorId) . "'"));
			list($message, $subject) = array_values(\tmvc::instance()->controller->core->db->queryFirstRow("SELECT message,subject FROM emailtemplates WHERE code='NotifyNewReferral'"));
			$message = CoreHelp::replaceMail($message, $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
			$subject = CoreHelp::replaceMail($subject, $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
			CoreHelp::sendMail($email, $subject, $message, $emailHeader);
		}
	}
	
	public static function emailWelcome($memberId)
	{
		$lang        = self::getLang('members');
		$adminEmail  = \tmvc::instance()->controller->core->GetSiteSetting("admin_email");
		$siteUrl     = \tmvc::instance()->controller->core->GetSiteSetting('site_url');
		$siteTitle   = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
		$emailHeader = "From: " . $adminEmail . "\r\n";
		list($email, $firstName, $lastName, $sponsorId, $username) = array_values(\tmvc::instance()->controller->core->db->queryFirstRow("SELECT email,first_name,last_name,sponsor_id,username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'"));
		$sponsorUsername = \tmvc::instance()->controller->core->db->queryFirstField("SELECT username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsorId) . "'");
		list($message, $subject) = array_values(\tmvc::instance()->controller->core->db->queryFirstRow("SELECT message,subject FROM emailtemplates WHERE code='SendWelcomeEmail'"));
		$message = CoreHelp::replaceMail($message, $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
		$subject = CoreHelp::replaceMail($subject, $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
		CoreHelp::sendMail($email, $subject, $message, $emailHeader);
	}
	
	public static function emailActivation($memberId)
	{
		$lang        = self::getLang('members');
		$adminEmail  = \tmvc::instance()->controller->core->GetSiteSetting("admin_email");
		$siteUrl     = \tmvc::instance()->controller->core->GetSiteSetting('site_url');
		$siteTitle   = \tmvc::instance()->controller->core->GetSiteSetting("site_name");
		$emailHeader = "From: " . $adminEmail . "\r\n";
		list($email, $firstName, $lastName, $sponsorId, $username) = array_values(\tmvc::instance()->controller->core->db->queryFirstRow("SELECT email,first_name,last_name,sponsor_id,username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'"));
		$sponsorUsername = \tmvc::instance()->controller->core->db->queryFirstField("SELECT username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsorId) . "'");
		list($message, $subject) = array_values(\tmvc::instance()->controller->core->db->queryFirstRow("SELECT message,subject FROM emailtemplates WHERE code='ActivationLetter'"));
		$message = CoreHelp::replaceMail($message, $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
		$subject = CoreHelp::replaceMail($subject, $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
		$token   = \tmvc::instance()->controller->core->db->queryFirstField("SELECT activation_token FROM members WHERE member_id = %d", $memberId);
		if (!$token) {
			$token = uniqid();
			\tmvc::instance()->controller->core->db->query("UPDATE members SET activation_token = %s WHERE member_id = %d", $token, $memberId);
		}
		$activationUrl = CoreHelp::getSiteUrl() . 'members/activation/&hash=' . $token;
		$message       = str_replace('[ActivationUrl]', $activationUrl, $message);
		CoreHelp::sendMail($email, $subject, $message, $emailHeader);
	}
	
	/**
	 * shortens the supplied text after last word
	 * @param string $string
	 * @param int $max_length
	 * @param string $end_substitute text to append, for example "..."
	 * @param boolean $html_linebreaks if LF entities should be converted to <br />
	 * @return string
	 */
	public static function shortDescription($string, $max_length, $end_substitute = '...', $html_linebreaks = false)
	{
		
		if ($html_linebreaks)
			$string = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
		$string = strip_tags($string); //gets rid of the HTML
		
		if (empty($string) || mb_strlen($string) <= $max_length) {
			if ($html_linebreaks)
				$string = nl2br($string);
			return $string;
		}
		
		if ($end_substitute)
			$max_length -= mb_strlen($end_substitute, 'UTF-8');
		
		$stack_count = 0;
		while ($max_length > 0) {
			$char = mb_substr($string, --$max_length, 1, 'UTF-8');
			if (preg_match('#[^\p{L}\p{N}]#iu', $char))
				$stack_count++; //only alnum characters
			elseif ($stack_count > 0) {
				$max_length++;
				break;
			}
		}
		$string = mb_substr($string, 0, $max_length, 'UTF-8') . $end_substitute;
		if ($html_linebreaks)
			$string = nl2br($string);
		
		return $string;
	}
	
	public static function isAjax() 
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	public static function createThumb($path1, $path2, $file_type, $new_w, $new_h, $squareSize = ''){
		/* read the source image */
		$source_image = FALSE;
		
		if (preg_match("/jpg|JPG|jpeg|JPEG/", $file_type)) {
			$source_image = imagecreatefromjpeg($path1);
		}
		elseif (preg_match("/png|PNG/", $file_type)) {
			
			if (!$source_image = @imagecreatefrompng($path1)) {
				$source_image = imagecreatefromjpeg($path1);
			}
		}
		elseif (preg_match("/gif|GIF/", $file_type)) {
			$source_image = imagecreatefromgif($path1);
		}		
		if ($source_image == FALSE) {
			$source_image = imagecreatefromjpeg($path1);
		}
	
		$orig_w = imageSX($source_image);
		$orig_h = imageSY($source_image);
		
		if ($orig_w < $new_w && $orig_h < $new_h) {
			$desired_width = $orig_w;
			$desired_height = $orig_h;
		} else {
			$scale = min($new_w / $orig_w, $new_h / $orig_h);
			$desired_width = ceil($scale * $orig_w);
			$desired_height = ceil($scale * $orig_h);
		}
				
		if ($squareSize != '') {
			$desired_width = $desired_height = $squareSize;
		}
	
		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		// for PNG background white-----------
		$kek = imagecolorallocate($virtual_image, 255, 255, 255);
		imagefill($virtual_image, 0, 0, $kek);
		
		if ($squareSize == '') {
			/* copy source image at a resized size */
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $orig_w, $orig_h);
		} else {
			$wm = $orig_w / $squareSize;
			$hm = $orig_h / $squareSize;
			$h_height = $squareSize / 2;
			$w_height = $squareSize / 2;
			
			if ($orig_w > $orig_h) {
				$adjusted_width = $orig_w / $hm;
				$half_width = $adjusted_width / 2;
				$int_width = $half_width - $w_height;
				imagecopyresampled($virtual_image, $source_image, -$int_width, 0, 0, 0, $adjusted_width, $squareSize, $orig_w, $orig_h);
			}
	
			elseif (($orig_w <= $orig_h)) {
				$adjusted_height = $orig_h / $wm;
				$half_height = $adjusted_height / 2;
				imagecopyresampled($virtual_image, $source_image, 0,0, 0, 0, $squareSize, $adjusted_height, $orig_w, $orig_h);
			} else {
				imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $squareSize, $squareSize, $orig_w, $orig_h);
			}
		}
		
		if (@imagejpeg($virtual_image, $path2, 90)) {
			imagedestroy($virtual_image);
			imagedestroy($source_image);
			return TRUE;
		} else {
			return FALSE;
		}
	}	
	
	public static function getProfileUploadPic() {
		if (file_exists(__DIR__ . '/../../../media/avatars/normal/'.self::getMemberId().'.jpg')) {
			return '/media/avatars/normal/'.self::getMemberId().'.jpg?'.rand(100,1000);;
		}
		else {
			return '/assets/members/images/default.jpg';
		}
	}
	
	public static function getProfilePic($gender) {
		if (file_exists(__DIR__ . '/../../../media/avatars/thumb/'.self::getMemberId().'.jpg')) {
			return '/media/avatars/thumb/'.self::getMemberId().'.jpg?'.rand(100,1000);;
		}
		else {
			$g = $gender == 1 ? 'man' : 'woman';
			return '/assets/common/images/no_avatar_'.$g.'.jpg';
		}
	}
	
	public static function getMemberProfilePic($memberId, $gender) {
		if (file_exists(__DIR__ . '/../../../media/avatars/thumb/'.$memberId.'.jpg')) {
			return '/media/avatars/thumb/'.$memberId.'.jpg?'.rand(100,1000);;
		}
		else {
			$g = $gender == 1 || $gender == 'Man' ? 'man' : 'woman';
			return '/assets/common/images/no_avatar_'.$g.'.jpg';
		}
	}
	
	public static function xcurl($url,$ref=null,$post=array(),$ua="Mozilla/5.0 (X11; Linux x86_64; rv:2.2a1pre) Gecko/20110324 Firefox/4.2a1pre",$print=false) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		if(!empty($ref)) {
			curl_setopt($ch, CURLOPT_REFERER, $ref);
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if(!empty($ua)) {
			curl_setopt($ch, CURLOPT_USERAGENT, $ua);
		}
		if(count($post) > 0){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);	
		}
		$output = curl_exec($ch);
		curl_close($ch);
		if($print) {
			print($output);
		} else {
			return $output;
		}
	}
}
?>