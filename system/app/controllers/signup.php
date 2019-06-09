<?php
class Signup_Controller extends iMVC_Controller
{
    public function getIndex()
    {
        $this->smarty->template_dir = 'system/app/views/members/';
        $this->load->model('Main_Model', 'main');
		$lang  = CoreHelp::getLang('members');
		$this->smarty->assign("lang", $lang);
		if ($this->main->GetSiteSetting('signup_active') == 'no') {
			CoreHelp::setSession('error', $lang['registration_is_currently_disabled_please_try_again_later']);
		}
        $memberships = $this->main->GetMemberships();
		$settings 	 = $this->core->GetSiteSettings();
		$this->smarty->assign("settings", $settings);
		$this->smarty->assign("memberships", $memberships);
        if (CoreHelp::GetQuery('sponsor_username')) {
            $sponsor = CoreHelp::GetQuery('sponsor_username');
            $check   = $this->main->FirstField("SELECT member_id FROM members WHERE username='$sponsor'", 0);
            if ($check == 0) {
                $this->main->SetError('Sponsor username', $lang['invalid_sponsor_username']);
                $this->smarty->assign('errors', $this->main->errors);
            } else {
                $_SESSION['enroller'] = $sponsor;
                setcookie('enroller', $sponsor, time() + 60 * 60 * 24 * 360, '/');
                $_COOKIE['enroller'] = $sponsor;
            }
        }
		
        if (!$_COOKIE['enroller'] || $_COOKIE['enroller'] == 1) {
			if ($this->main->GetSiteSetting('signup_sponsor_required') == 'no') {
            	$_SESSION['enroller'] = $this->main->FirstField("SELECT username FROM members WHERE membership != '0' ORDER BY RAND() LIMIT 1", 1);
            	setcookie('enroller', $_SESSION['enroller'], time() + 60 * 60 * 24 * 360, '/');
            	$_COOKIE['enroller'] = $_SESSION['enroller'];
			}
        } else {
            $_SESSION['enroller'] = $_COOKIE['enroller'];
        }
        $this->smarty->display('signup.tpl');
    }
	
	 public function getJoin()
    {        		
		CoreHelp::redirect('/signup/');		
	}
	
    public function postIndex()
    {
        $this->load->library('Smarty_Wrapper', 'smarty');
        $this->smarty->template_dir = 'system/app/views/members/';
        $this->load->model('Main_Model', 'main');
		$lang  = CoreHelp::getLang('members');
		if ($this->main->GetSiteSetting('signup_active') == 'no') {
			CoreHelp::setSession('error', $lang['registration_is_currently_disabled_please_try_again_later']);
			CoreHelp::redirect('back');
		}		
        $lastName  = $this->main->enc($this->main->GetValidQuery('lastName', 'Last name', VALIDATE_NOT_EMPTY));
        $firstName = $this->main->enc($this->main->GetValidQuery('firstName', 'First Name', VALIDATE_NOT_EMPTY));
        $email     = $this->main->GetValidQuery('email', 'Email', VALIDATE_EMAIL);
        $username  = $this->main->enc($this->main->GetValidQuery('username', 'Username', VALIDATE_USERNAME));
        $password  = $this->main->GetValidQuery('password', 'Password', VALIDATE_PASSWORD);
        $password2 = $this->main->GetValidQuery('password2', $password, VALIDATE_PASS_CONFIRM);
        $agree     = $this->main->GetValidQuery('agree', 'You must agree to Terms of service', VALIDATE_CHECKBOX);
		$phone 	   = $this->main->enc($this->main->GetValidQuery("phone", "Phone", VALIDATE_NOT_EMPTY));
		$enroller  = $this->main->GetValidQuery('sponsor', 'Sponsor');
        $enroller = $this->main->db->queryFirstField("SELECT member_id FROM members WHERE username= %s", $enroller);
		if(!$enroller) {
			if ($this->main->GetSiteSetting('signup_sponsor_required') == 'no') {
				$enroller = $this->main->db->queryFirstField("SELECT member_id FROM members ORDER BY member_id ASC LIMIT 1");
				if(!$enroller) {
					$enroller = 0;	
				}
			}
			else {
				$this->main->SetError('sponsor', $lang['check_sponsor_username']);	
			}
		}
        /*$street = $this->main->enc($this->main->GetValidQuery("street", "Address", VALIDATE_NOT_EMPTY));
        $city = $this->main->enc($this->main->GetValidQuery("city", "City", VALIDATE_NOT_EMPTY));
        $state = $this->main->enc($this->main->GetValidQuery("state", "State", VALIDATE_NOT_EMPTY));
        $country = $this->main->enc($this->main->GetValidQuery("country", "Country", VALIDATE_NOT_EMPTY));
        $postal = $this->main->enc($this->main->GetValidQuery("postal", "Postal Code", VALIDATE_NOT_EMPTY));
        $phone = $this->main->enc($this->main->GetValidQuery("phone", "Phone", VALIDATE_NOT_EMPTY));
        */
		if(isset($_SESSION['plan']['cycler'])) {
			$enroller_membership = $this->main->db->queryFirstField("SELECT membership FROM members WHERE username= %s", $enroller);
			if($enroller_membership == '0') {
				$this->main->SetError('sponsor', 'Your sponsor is not active on the system yet');	
			}	
		}
        if ($this->errors['err_count'] == 0) {
            $count = $this->main->db->queryFirstField('SELECT Count(*) FROM `members` WHERE username=%s', $username);
            if ($count > 0) {
                $this->main->SetError('username', $lang['username_already_used']);
            }
			$count = $this->main->db->queryFirstField('SELECT Count(*) FROM `members` WHERE email=%s', $email);
            if ($count > 0) {
                $this->main->SetError('username', $lang['email_already_used']);
            }
        }
        if ($this->main->errors['err_count'] > 0) {
			unset($this->main->errors['err_count']);
            $site_url = $this->main->GetSiteSetting('site_url');
            $this->smarty->assign('site_url', $site_url);
            $this->smarty->assign('errors', $this->main->errors);
			$this->smarty->assign("lang", $lang);
			$_SESSION['signup'] = $_REQUEST;
			$memberships = $this->main->GetMemberships();
			$settings 	 = $this->core->GetSiteSettings();
			$this->smarty->assign("settings", $settings);
			$this->smarty->assign("memberships", $memberships);
            $this->smarty->display('signup.tpl');
        } else {
			if(PAYPAL_SUBSCRIPTIONS == 1) {
				$this->hooks->do_action('paypal_subscription');	
			}
			else {
				$contactEmail  = $this->main->GetSiteSetting('admin_email');
				$thisSiteUrl   = $this->main->GetSiteSetting('site_url');
				$thisSiteTitle = $this->main->GetSiteSetting('site_name');
				$regdate       = time();
				$phone		   = str_replace('+', '', $phone);
				$phone		   = str_replace(' ', '', $phone);
				$this->main->db->insert('members', array(
					'username' => $username,
					'email' => $email,
					'password' => hash('sha256', $password),
					'first_name' => $firstName,
					'last_name' => $lastName,
					'sponsor_id' => $enroller,
					'reg_date' => $regdate,
					'gender' => $this->main->GetQuery('gender') == 1 ? 1 : 2,
					'skype'  => $this->main->GetQuery('skype'),
					'is_active' => $this->main->GetSiteSetting('signup_email_confirmation') == 'yes' ? '0' : '1',
					'street' => $street,
					'city' => $city,
					'state' => $state,
					'country' => $country,
					'postal' => $postal,
					'phone' => $phone,
					'membership' => '0'
				));
				$id     = $this->main->db->insertId();
				$this->hooks->do_action('after_signup', $id);	
				$message = $thisSiteTitle . " username: $username, password: $password";
				$this->hooks->do_action('send_welcome_sms', $phone, $message);	
				if($this->main->GetSiteSetting('settings_matrix_allow_free') == 'yes' || isset($_SESSION['plan']['binary'])){
					$this->hooks->do_action('in_matrix', $id);		
				}	
				if ($this->main->GetSiteSetting('signup_email_confirmation') == 'yes') {
					CoreHelp::emailActivation($id);
				} else {
					CoreHelp::emailWelcome($id);				
				}    
				CoreHelp::emailNewReferral($id);        
				CoreHelp::setSession('message', $lang['registration_succesfully']);
				CoreHelp::redirect('/members/login');
			}
        }
    }	

    public function anyUser()
    {
        $this->load->library('Smarty_Wrapper', 'smarty');
        $this->smarty->template_dir = 'public/';
        $this->load->model('Main_Model', 'main');
        $site_url = $this->main->GetSiteSetting('site_url');
        $this->smarty->assign('site_url', $site_url);
        $member_user = CoreHelp::GetQuery('uname');
        $firstName   = $this->main->FirstField("SELECT first_name FROM members WHERE username='$member_user'");
        $lastName    = $this->main->FirstField("SELECT last_name FROM members WHERE username='$member_user'");
        echo "document.writeln(\"$firstName $lastName\");";
    }
    public function anyCount()
    {
        $this->load->library('Smarty_Wrapper', 'smarty');
        $this->smarty->template_dir = 'public/';
        $this->load->model('Main_Model', 'main');
        $site_url = $this->main->GetSiteSetting('site_url');
        $this->smarty->assign('site_url', $site_url);
        $count = $this->main->FirstField('SELECT count(*) FROM members', '0');
        echo "document.writeln(\"$count\");";
    }
    public function anyLastweek()
    {
        $today    = time();
        $lastweek = $today - 604800;
        $this->load->library('Smarty_Wrapper', 'smarty');
        $this->smarty->template_dir = 'public/';
        $this->load->model('Main_Model', 'main');
        $site_url = $this->main->GetSiteSetting('site_url');
        $this->smarty->assign('site_url', $site_url);
        $count = $this->main->FirstField("SELECT count(*) FROM members WHERE reg_date>$lastweek", '0');
        echo "document.writeln(\"$count\");";
    }
    public function anyOnline()
    {
        $online = time() - 10800; // 3h
        $this->load->library('Smarty_Wrapper', 'smarty');
        $this->smarty->template_dir = 'public/';
        $this->load->model('Main_Model', 'main');
        $site_url = $this->main->GetSiteSetting('site_url');
        $this->smarty->assign('site_url', $site_url);
        $count = $this->main->FirstField("SELECT count(*) FROM members WHERE last_access > $online", '0');
        echo "document.writeln(\"$count\");";
    }
    public function anyProof()
    {
        $this->load->library('Smarty_Wrapper', 'smarty');
        $this->smarty->template_dir = 'public/';
        $this->load->model('Main_Model', 'main');
        $site_url = $this->main->GetSiteSetting('site_url');
        $this->smarty->assign('site_url', $site_url);
        $rows = $this->main->db->query('SELECT * FROM money_out WHERE status=1 ORDER BY transfer_date desc limit 50');
        foreach ($rows as $row) {
            $member_id     = $row['member_id'];
            $transfer_date = $row['transfer_date'];
            $amount        = $row['amount'];
            $processor_id     = $row['processor'];
            $firstName     = $this->main->FirstField("SELECT first_name FROM members WHERE member_id='$member_id'");
            $lastName      = $this->main->FirstField("SELECT last_name FROM members WHERE member_id='$member_id'");
            $date          = date('m-d H:i:s', $transfer_date);
			$processor     = $this->main->FirstField("SELECT name FROM payment_processors WHERE processor_id='$processor_id'");
            $line .= "$firstName $lastName (\$$amount) - $date - <small".$processor['name']."</small> &nbsp;&nbsp;";
        }
        echo "document.writeln(\"$line\");";
    }

    public function anyNewmembers()
    {
        $this->load->library('Smarty_Wrapper', 'smarty');
        $this->smarty->template_dir = 'public/';
        $this->load->model('Main_Model', 'main');
        $rows = $this->main->db->query('SELECT * FROM members ORDER BY reg_date desc limit 100');
        $line .= '<table width="350" border="0" align="center">
		<tr>
			<td height="30">
			<marquee behavior="scroll" onmouseover="this.stop();" onmouseout="this.start();" scrollamount="2" height="350" direction="up" scrolldelay=5>';
        	foreach ($rows as $row) {
            	$line .= '<font face=verdana size=-1>' . $row['first_name'] . '&nbsp;' . $row['last_name'] . '&nbsp;</font>
	  					 <font face=verdana size=-2>' . date('m-d H:i:s', $row['reg_date']) . '</font>
    					 <br /><br />';
        	}
        $line .= '	</marquee>	</td>
		</tr>
  		<tr>
    		<td height="30">&nbsp;</td>
  		</tr>
		</table>';
        echo $line;
    }
}
