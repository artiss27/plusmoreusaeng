<?php
class Members_Controller extends iMVC_Controller
{
    static $flag_dir = 'assets/common/images/flags/';
    public function getIndex()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        
        $m_level                    = $profile['m_level'];
        $total_sponsored            = $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "'", 0);
		$total_paid		            = $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership !='0'", 0);
        $total_pending              = $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND m_level=0", 0);
        $wallet_deposit	            = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
		$wallet_payout	            = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $money_withdrawed           = $this->core->FirstField("SELECT SUM(amount) FROM money_out WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND status = 1", "0.00");
		$pending_withdrawal         = $this->core->FirstField("SELECT SUM(amount) FROM money_out WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND status = 0", "0.00");
        $money_earned               = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND amount > 0", "0.00");
		
		/* today */
        $paid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership !='0' AND reg_date > UNIX_TIMESTAMP(DATE_SUB( NOW(), INTERVAL 1 DAY ))", 0); 
		$unpaid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership ='0' AND reg_date > UNIX_TIMESTAMP(DATE_SUB( NOW(), INTERVAL 1 DAY ))", 0); 
		$referral_url_hits	= $this->core->FirstField("SELECT SUM(hit_counter) FROM hits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND date > DATE_SUB( NOW(), INTERVAL 1 DAY )", "0");
		$money_earned			=  $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND amount > 0 AND transaction_date > UNIX_TIMESTAMP(DATE_SUB( NOW(), INTERVAL 1 DAY ))", "0.00");
        $today = array('paid_referrers' => $paid_referrers, 'unpaid_referrers' => $unpaid_referrers, 'referral_url_hits' => $referral_url_hits, 'money_earned' => $money_earned);
		/* end today */
		
		/* yesterday */
        $paid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership !='0' AND reg_date BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 DAY)) AND UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))", 0); 
		$unpaid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership ='0' AND reg_date BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 DAY)) AND UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))", 0); 
		$referral_url_hits	= $this->core->FirstField("SELECT SUM(hit_counter) FROM hits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND date BETWEEN DATE_SUB(NOW(), INTERVAL 2 DAY) AND DATE_SUB(NOW(), INTERVAL 1 DAY)", "0");
		$money_earned			=  $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND amount > 0 AND transaction_date BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 DAY)) AND UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))", "0.00");
        $yesterday = array('paid_referrers' => $paid_referrers, 'unpaid_referrers' => $unpaid_referrers, 'referral_url_hits' => $referral_url_hits, 'money_earned' => $money_earned);
		/* end yesterday */
		
		/* this week */
        $paid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership !='0' AND WEEK(FROM_UNIXTIME(reg_date)) = WEEK(NOW()) AND YEAR(FROM_UNIXTIME(reg_date)) = YEAR(NOW())", 0); 
		$unpaid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership ='0' AND WEEK(FROM_UNIXTIME(reg_date)) = WEEK(NOW()) AND YEAR(FROM_UNIXTIME(reg_date)) = YEAR(NOW())", 0); 
		$referral_url_hits	= $this->core->FirstField("SELECT SUM(hit_counter) FROM hits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND WEEK(date) = WEEK(NOW()) AND YEAR(date) = YEAR(NOW())", "0");
		$money_earned			=  $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND amount > 0 AND WEEK(FROM_UNIXTIME(transaction_date)) = WEEK(NOW()) AND YEAR(FROM_UNIXTIME(transaction_date)) = YEAR(NOW())", "0.00");
        $this_week = array('paid_referrers' => $paid_referrers, 'unpaid_referrers' => $unpaid_referrers, 'referral_url_hits' => $referral_url_hits, 'money_earned' => $money_earned);
		/* end this week */
		
		/* last week */
        $paid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership !='0' AND WEEK(FROM_UNIXTIME(reg_date)) = WEEK(NOW()) - 1 AND YEAR(FROM_UNIXTIME(reg_date)) = YEAR(NOW())", 0); 
		$unpaid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership ='0' AND WEEK(FROM_UNIXTIME(reg_date)) = WEEK(NOW()) - 1 AND YEAR(FROM_UNIXTIME(reg_date)) = YEAR(NOW())", 0); 
		$referral_url_hits	= $this->core->FirstField("SELECT SUM(hit_counter) FROM hits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND WEEK(date) = WEEK(NOW()) - 1 AND YEAR(date) = YEAR(NOW())", "0");
		$money_earned			=  $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND amount > 0 AND WEEK(FROM_UNIXTIME(transaction_date)) = WEEK(NOW()) - 1 AND YEAR(FROM_UNIXTIME(transaction_date)) = YEAR(NOW())", "0.00");
        $last_week = array('paid_referrers' => $paid_referrers, 'unpaid_referrers' => $unpaid_referrers, 'referral_url_hits' => $referral_url_hits, 'money_earned' => $money_earned);
		/* end last week */
		
		/* this month */
        $paid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership !='0' AND YEAR(FROM_UNIXTIME(reg_date)) = YEAR(CURRENT_DATE) AND MONTH(FROM_UNIXTIME(reg_date)) = MONTH(CURRENT_DATE)", 0); 
		$unpaid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership ='0' AND YEAR(FROM_UNIXTIME(reg_date)) = YEAR(CURRENT_DATE) AND MONTH(FROM_UNIXTIME(reg_date)) = MONTH(CURRENT_DATE)", 0); 
		$referral_url_hits	= $this->core->FirstField("SELECT SUM(hit_counter) FROM hits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND YEAR(date) = YEAR(CURRENT_DATE) AND MONTH(date) = MONTH(CURRENT_DATE)", "0");
		$money_earned			=  $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND amount > 0 AND YEAR(FROM_UNIXTIME(transaction_date)) = YEAR(CURRENT_DATE) AND MONTH(FROM_UNIXTIME(transaction_date)) = MONTH(CURRENT_DATE)", "0.00");
        $this_month = array('paid_referrers' => $paid_referrers, 'unpaid_referrers' => $unpaid_referrers, 'referral_url_hits' => $referral_url_hits, 'money_earned' => $money_earned);
		/* this month */
		
		/* last month */
        $paid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership !='0' AND YEAR(FROM_UNIXTIME(reg_date)) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(FROM_UNIXTIME(reg_date)) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)", 0); 
		$unpaid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership ='0' AND YEAR(FROM_UNIXTIME(reg_date)) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(FROM_UNIXTIME(reg_date)) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)", 0); 
		$referral_url_hits	= $this->core->FirstField("SELECT SUM(hit_counter) FROM hits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)", "0");
		$money_earned			=  $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND amount > 0 AND YEAR(FROM_UNIXTIME(transaction_date)) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(FROM_UNIXTIME(transaction_date)) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)", "0.00");
        $last_month = array('paid_referrers' => $paid_referrers, 'unpaid_referrers' => $unpaid_referrers, 'referral_url_hits' => $referral_url_hits, 'money_earned' => $money_earned);
		/* last month */
		
		/* last six months */
        $paid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership !='0' AND reg_date > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 6 MONTH))", 0); 
		$unpaid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership ='0' AND reg_date > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 6 MONTH))", 0); 
		$referral_url_hits	= $this->core->FirstField("SELECT SUM(hit_counter) FROM hits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND date > DATE_SUB(NOW(), INTERVAL 6 MONTH)", "0");
		$money_earned			=  $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND amount > 0 AND transaction_date > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 6 MONTH))", "0.00");
        $last_six_months = array('paid_referrers' => $paid_referrers, 'unpaid_referrers' => $unpaid_referrers, 'referral_url_hits' => $referral_url_hits, 'money_earned' => $money_earned);
		/* last six months */
		
		/* last year */
        $paid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership !='0' AND reg_date > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 12 MONTH))", 0); 
		$unpaid_referrers		= $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership ='0' AND reg_date > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 12 MONTH))", 0); 
		$referral_url_hits	= $this->core->FirstField("SELECT SUM(hit_counter) FROM hits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND date > DATE_SUB(NOW(), INTERVAL 12 MONTH)", "0");
		$money_earned			=  $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND amount > 0 AND transaction_date > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 12 MONTH))", "0.00");
        $last_year = array('paid_referrers' => $paid_referrers, 'unpaid_referrers' => $unpaid_referrers, 'referral_url_hits' => $referral_url_hits, 'money_earned' => $money_earned);
		/* last year */
		
		$referral_hits              = $this->core->FirstField("SELECT hit_counter FROM hits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0");
        $memberships                = $this->core->GetMemberships();
        foreach ($memberships as $membership) {
            $setting          = $membership . '_signup_fee';
            $sett["$setting"] = $this->core->GetSiteSetting("$setting");
        }
        $processing_fee1 = "signup_fee";
        $signupfee       = $this->core->GetSiteSetting($processing_fee1);
        if ($this->core->haveDeposit($memberId) == true) {
            $status = $lang['unpaid'];
        } else {
            $status = $lang['paid'];
        }
        $isSecure = false;
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $isSecure = true;
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
            $isSecure = true;
        }
        $request_protocol = $isSecure ? 'https://' : 'http://';
        $local_url        = $request_protocol . $_SERVER['HTTP_HOST'] . '/';
        $sponsor_username = $this->core->FirstField("SELECT username FROM members WHERE member_id = " . $profile['sponsor_id'], "System");
        $result           = $this->member->db->query("SELECT * FROM news ORDER BY id DESC LIMIT 3");
        $this->smarty->assign("news", $result);
        $this->smarty->assign("membership", $profile['membership'] != '0' ? $profile['membership'] : $lang['free_membership']);
        
        $this->smarty->assign("sponsor", $profile['sponsor_id']);
        $this->smarty->assign("status", $status);
        $this->smarty->assign("cycle", $cycle);
        $this->smarty->assign("total_sponsored", $total_sponsored);
		$this->smarty->assign("total_paid", $total_paid);
        $this->smarty->assign("total_pending", $total_pending);
		$this->smarty->assign("wallet_deposit", $wallet_deposit);
        $this->smarty->assign("wallet_payout", $wallet_payout);
        $this->smarty->assign("money_earned", $money_earned);
		$this->smarty->assign("ad_credits", number_format($profile['ad_credits'],2,'.',''));
		$this->smarty->assign("money_withdrawed", $money_withdrawed);
		$this->smarty->assign("pending_withdrawal", $pending_withdrawal);		
        $this->smarty->assign("today", $today);
		$this->smarty->assign("yesterday", $yesterday);
		$this->smarty->assign("this_week", $this_week);
		$this->smarty->assign("last_week", $last_week);
		$this->smarty->assign("this_month", $this_month);
		$this->smarty->assign("last_month", $last_month);
		$this->smarty->assign("last_six_months", $last_six_months);
		$this->smarty->assign("last_year", $last_year);
        $this->smarty->assign("referral_hits", $referral_hits);
        $this->smarty->assign("signupfee", $signupfee);
        $this->smarty->assign("sett", $sett);
        $this->smarty->assign("memberships", $memberships);
        $this->smarty->assign("lang", $lang);
		CoreHelp::setSession('payout_balance', $wallet_payout);
        CoreHelp::setSession('name', $profile['first_name'] . ' ' . $profile['last_name']);
        CoreHelp::setSession('username', $profile['username']);
        CoreHelp::setSession('member_id', $profile['member_id']);
		CoreHelp::setSession('gender', $profile['gender']);
        CoreHelp::setSession('domain', $_SERVER['HTTP_HOST']);
        CoreHelp::setSession('local_url', $local_url);
        CoreHelp::setSession('sponsor', $sponsor_username ? $sponsor_username : 'System');
        CoreHelp::setSession('year', date("Y", time()));
        CoreHelp::setSession('reg_date', date("M j Y", $profile['reg_date']));
        CoreHelp::setSession('menu', array(
            'main' => 'dashboard',
            'sub' => ''
        ));
        $this->smarty->display('index.tpl');
    }
    public function getLogin()
    {
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        if (isset($_GET['err'])) {
            $this->smarty->assign("login_error", 1);
        }
        $this->smarty->assign("lang", $lang);
        $this->smarty->display('login.tpl');
    }
    public function postLogin()
    {
		CoreHelp::trackRetries('member_login');
		$lang  = CoreHelp::getLang('members');
		$is_active = $this->member->db->queryFirstField("SELECT is_active FROM members WHERE username = %s", CoreHelp::GetQuery("username"));
		if($is_active == 0) {
			CoreHelp::setSession('error', $lang['please_follow_the_activation_link_in_your_email'] . ' <br><a href="sendactivation/&hash='.CoreHelp::encrypt(CoreHelp::GetQuery("username")).'">'.$lang['send_activation_email_again'].'</a>');
			CoreHelp::redirect('/members/login');
		}
        if ($this->member->memberLogin(CoreHelp::GetQuery("username"), CoreHelp::GetQuery("password"))) {			
            $this->member->db->query("UPDATE members SET last_access='" . time(). "',ip_address='" . CoreHelp::getIp() . "' WHERE username='" . CoreHelp::sanitizeSQL(CoreHelp::GetQuery("username")) . "'");
			$this->hooks->do_action('after_login');
            CoreHelp::redirect('/members');
        } else {
			CoreHelp::setSession('error', $lang['invalid_username_or_password']);
            CoreHelp::redirect('/members/login');
        }
    }
	
	public function getSendactivation()
    {
		CoreHelp::trackRetries('send_activation');
		$lang  = CoreHelp::getLang('members');
		$username = CoreHelp::decrypt(CoreHelp::GetQuery('hash'));		
		$id = $this->member->db->queryFirstField("SELECT member_id FROM members WHERE username = %s", $username);
        CoreHelp::emailActivation($id);
        CoreHelp::setSession('message', $lang['check_your_email']);
		CoreHelp::redirect('/members/login');		
	}
	
	public function getResetpassword()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        
        $this->smarty->assign("profile", $profile);
        $this->smarty->assign("lang", $lang);
        
        CoreHelp::setSession('menu', array(
            'main' => 'my_account',
            'sub' => 'profile'
        ));
        $this->smarty->display('reset_password.tpl');
    }
	
	public function postResetpassword()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
		$password 			 		= CoreHelp::GetValidQuery('password', 'Password', VALIDATE_PASSWORD);
        $password2 					= CoreHelp::GetValidQuery('password2', $password, VALIDATE_PASS_CONFIRM);
		if(CoreHelp::GetQuery("token") != CoreHelp::getSession('security_token')) {
			CoreHelp::setSession('error', 'Invalid security token, request to your email again');
			CoreHelp::redirect('back');		
		}
		
		if(hash('sha256', CoreHelp::getQuery('current_password')) != $profile['password']) {
			CoreHelp::setError('current_password', $lang['current_password']. ' ' . $lang['is_wrong']);	
		}
		if (CoreHelp::getCountErrors() > 0) {
            CoreHelp::setSession("errors", CoreHelp::getErrors());
			CoreHelp::redirect('back');
        } else {
            $this->member->db->update('members', array(
                'password' => hash('sha256', $password)
            ), "member_id=%d", $memberId);
            $this->smarty->assign("member_edited", "y");
        }
		
		
		CoreHelp::setSession('message', $lang['settings_edited_succesfully_to_database']);
        CoreHelp::redirect('/members/profile');
    }
	
    public function getProfile()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        
        $processors                 = $this->member->db->query("SELECT * FROM payment_processors WHERE active_withdrawal='1'");
        $this->smarty->assign("processors", $processors);
        $this->smarty->assign("profile", $profile);
		$this->smarty->assign("countries", $this->member->db->query("SELECT code,name AS country FROM countries ORDER BY name ASC"));
        $this->smarty->assign("lang", $lang);
        
        CoreHelp::setSession('menu', array(
            'main' => 'my_account',
            'sub' => 'profile'
        ));
        $this->smarty->display('profile.tpl');
    }
    public function postProfile()
    {
		if (DEMO) {
			CoreHelp::setSession('error', 'Cannot save this setting in demo mode');
			CoreHelp::redirect('back');		
		}
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
		if(CoreHelp::GetQuery("token") != CoreHelp::getSession('security_token')) {
			CoreHelp::setSession('error', 'Invalid security token, request to your email again');
			CoreHelp::redirect('back');		
		}
		
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $lastName                   = CoreHelp::sanitizeSQL(CoreHelp::GetValidQuery("lastName", $lang['last_name'], VALIDATE_NOT_EMPTY));
        $firstName                  = CoreHelp::sanitizeSQL(CoreHelp::GetValidQuery("firstName", $lang['first_name'], VALIDATE_NOT_EMPTY));
        $email                      = CoreHelp::GetValidQuery("email", $lang['email'], VALIDATE_EMAIL);
        $street                     = CoreHelp::sanitizeSQL(CoreHelp::GetValidQuery("street", $lang['address'], VALIDATE_NOT_EMPTY));
        $city                       = CoreHelp::sanitizeSQL(CoreHelp::GetValidQuery("city", $lang['city'], VALIDATE_NOT_EMPTY));
        $state                      = CoreHelp::sanitizeSQL(CoreHelp::GetValidQuery("state", $lang['state'], VALIDATE_NOT_EMPTY));
        $country                    = CoreHelp::sanitizeSQL(CoreHelp::GetValidQuery("country", $lang['country'], VALIDATE_NOT_EMPTY));
        $postal                     = CoreHelp::sanitizeSQL(CoreHelp::GetValidQuery("postal", $lang['postal_code'], VALIDATE_NOT_EMPTY));
        $phone                      = CoreHelp::sanitizeSQL(CoreHelp::GetValidQuery("phone", $lang['phone'], VALIDATE_NOT_EMPTY));
        $processor                  = CoreHelp::sanitizeSQL(CoreHelp::GetQuery("processor", 0));
        $accountid                  = CoreHelp::sanitizeSQL(CoreHelp::GetQuery("account_id"));
        if (CoreHelp::getCountErrors() > 0) {
			CoreHelp::setSession('error', CoreHelp::getErrors());
			CoreHelp::redirect('back');
            //$this->smarty->assign("errors", CoreHelp::getErrors());
        } else {
            $this->member->db->update('members', array(
                'email' => $email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'street' => $street,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'postal' => $postal,
                'phone' => $phone,
                'processor' => $processor,
                'account_id' => $accountid
            ), "member_id=%d", $memberId);   
			CoreHelp::setSession('message', $lang['settings_edited_succesfully_to_database']);
			CoreHelp::redirect('back');
        }
        
    }
    public function getAccountsettings()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        
        $profile                    = $this->member->getProfile($memberId);
        $this->smarty->assign("settings", $profile);
        $this->smarty->assign("lang", $lang);
        
        CoreHelp::setSession('menu', array(
            'main' => 'my_account',
            'sub' => 'settings'
        ));
        $this->smarty->display('accountsettings.tpl');
    }
    public function postAccountsettings()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        
        $member_id                  = CoreHelp::getMemberId();
        $email_from_company         = (CoreHelp::GetQuery("email_from_company") == "on") ? "1" : "0";
        $email_from_upline          = (CoreHelp::GetQuery("email_from_upline") == "on") ? "1" : "0";
        $log_ip                     = (CoreHelp::GetQuery("log_ip") == "on") ? "1" : "0";
        $display_name               = (CoreHelp::GetQuery("display_name") == "on") ? "1" : "0";
        $display_email              = (CoreHelp::GetQuery("display_email") == "on") ? "1" : "0";
        $notify_changes             = (CoreHelp::GetQuery("notify_changes") == "on") ? "1" : "0";
        if (CoreHelp::getCountErrors() > 0) {
            $this->smarty->assign("errors", CoreHelp::getErrors());
        } else {
            $this->member->db->update('members', array(
                'email_from_company' => $email_from_company,
                'email_from_upline' => $email_from_upline,
                'log_ip' => $log_ip,
                'display_name' => $display_name,
                'display_email' => $display_email,
                'notify_changes' => $notify_changes
            ), "member_id=%d", $member_id);
            $this->smarty->assign("settings_edited", "y");
        }
        $profile = $this->member->getProfile($memberId);
        $this->smarty->assign("settings", $profile);
        $this->smarty->assign("lang", $lang);
        
        CoreHelp::setSession('menu', array(
            'main' => 'my_account',
            'sub' => 'settings'
        ));
        $this->smarty->display('accountsettings.tpl');
    }
    public function anyReferrers()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $memberId                   = CoreHelp::getMemberId();
        $lang                       = CoreHelp::getLang('members');
        
        if (CoreHelp::GetQuery('id')) {            
            $checkId = CoreHelp::decrypt(CoreHelp::GetQuery('id'));
        } else {
            $checkId = $memberId;
        }
        $total = $this->core->FirstField("SELECT Count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($checkId) . "'", 0);
        if ($total > 0) {
            $result = $this->member->db->query("SELECT * FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($checkId) . "' ORDER BY member_id asc");
            foreach ($result as $row) {
                $memb_id       = $row['member_id'];
                $username      = $row['username'];
                $m_level       = $row['m_level'];
                $first_name    = $row['first_name'];
                $last_name     = $row['last_name'];
                $membership    = $row['membership'];
				$skype		   = $row['skype'];
                $reg_date      = date("d M Y H:i", $row['reg_date']);
                $sponsors      = $this->core->FirstField("SELECT Count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memb_id) . "'", 0);
                
                $ctid = CoreHelp::encrypt($memb_id);
                if ($sponsors != 0) {
                    $sponsored = "<a href=\"/members/referrers/&id=$ctid\">$sponsored</a>";
                }
                $country_code              = \TabGeo\country($row['ip_address']);
                $converter                 = new \ChibiFR\CountryConverter\Converter();
                $flag                      = file_exists(self::$flag_dir . strtolower($country_code) . '.png') ? '/' . self::$flag_dir . strtolower($country_code) . '.png' : '/' . self::$flag_dir . 'europeanunion.png';
				$referrers_today		   = $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memb_id) . "' AND reg_date > UNIX_TIMESTAMP(DATE_SUB( NOW(), INTERVAL 1 DAY ))", 0);
				$referrers_yesterday	   = $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memb_id) . "' AND reg_date BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 DAY)) AND UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))", 0); 
				$referrers_total		   = $this->core->FirstField("SELECT count(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memb_id) . "'", 0);
				try{
					$converted = $converter->getCountryName($country_code);					
				}
				catch(Exception $e) {
					$converted = $lang['europe'];	
				}
                $this->data['TABLE_ROW'][] = array(
                    "ROW_MEMBER_ID" => $memb_id,
                    "ROW_USERNAME" => $username,
                    "ROW_MEMBERSHIP" => $membership != '0' ? $membership : $lang['free_membership'],
                    "ROW_FNAME" => $first_name,
                    "ROW_LNAME" => $last_name,
                    "ROW_ePin" => $epin,
                    "ROW_REG" => $reg_date,
                    "ROW_SPONSORS" => $sponsors,
                    "ROW_COUNTRY_NAME" => $country_code == "AA"  || $country_code == "EU" ? $lang['europe'] : $converted,
                    "ROW_COUNTRY_FLAG" => $flag,
					"ROW_SKYPE" => $skype,
					"ROW_REFERRER_TODAY" => $referrers_today,
					"ROW_REFERRER_YESTERDAY" => $referrers_yesterday,
					"ROW_REFERRER_TOTAL" => $referrers_total,
					"ROW_GENDER" => $row['gender'] == 1 ? 'Man' : 'Woman'
                );
            }
        }
        $this->smarty->assign("data", $this->data['TABLE_ROW']);
        $this->smarty->assign("lang", $lang);
        
        CoreHelp::setSession('menu', array(
            'main' => 'my_network',
            'sub' => 'referrers'
        ));
        $this->smarty->display('referrers.tpl');
    }
    public function anyPayoutwallet()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->load->library('Saved_State', 'savedState');
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');        
        $this->savedState->obj          = "wallet_payout";
        $this->savedState->orderDefault = "transaction_id";
        $this->savedState->RestoreState();
        $memberId  = CoreHelp::getMemberId();
        $profile   = $this->member->getProfile($memberId);
        
        
		$this->smarty->assign("lang", $lang);
        if (CoreHelp::GetQuery('filter')) {
            $memberId             = CoreHelp::getMemberId();
            $filterDateDayBegin   = CoreHelp::GetQuery("filterDateDayBegin");
            $filterDateMonthBegin = CoreHelp::GetQuery("filterDateMonthBegin");
            $filterDateYearBegin  = CoreHelp::GetQuery("filterDateYearBegin");
            $filterDateDayEnd     = CoreHelp::GetQuery("filterDateDayEnd");
            $filterDateMonthEnd   = CoreHelp::GetQuery("filterDateMonthEnd");
            $filterDateYearEnd    = CoreHelp::GetQuery("filterDateYearEnd");
            $this->savedState->saveStateValue("filterDateBegin", mktime(0, 0, 0, $filterDateMonthBegin, $filterDateDayBegin, $filterDateYearBegin));
            $this->savedState->saveStateValue("filterDateEnd", mktime(23, 59, 59, $filterDateMonthEnd, $filterDateDayEnd, $filterDateYearEnd));
            $this->savedState->saveStateValue("member_id", $memberId);
        }
        $filterDateBegin      = $this->savedState->GetStateValue("filterDateBegin", 0);
        $filterDateEnd        = $this->savedState->GetStateValue("filterDateEnd", 0);
        $filterDateDayBegin   = ($filterDateBegin != 0) ? date("d", $filterDateBegin) : "";
        $filterDateMonthBegin = ($filterDateBegin != 0) ? date("m", $filterDateBegin) : "";
        $filterDateYearBegin  = ($filterDateBegin != 0) ? date("Y", $filterDateBegin) : date("Y", time()) - 1;
        $filterDateDayEnd     = ($filterDateEnd != 0) ? date("d", $filterDateEnd) : "";
        $filterDateMonthEnd   = ($filterDateEnd != 0) ? date("m", $filterDateEnd) : "";
        $filterDateYearEnd    = ($filterDateEnd != 0) ? date("Y", $filterDateEnd) : "";
        $sql_select           = "";
        if ($filterDateBegin != 0)
            $sql_select .= " AND transaction_date>$filterDateBegin AND transaction_date<$filterDateEnd";
        $filter = "";
        $filter .= "<b>" . $lang['date_from'] . " </b>";
        $filter .= CoreHelp::getDaySelect($filterDateDayBegin, "filterDateDayBegin");
        $filter .= CoreHelp::getMonthSelect($filterDateMonthBegin, "filterDateMonthBegin");
        $filter .= CoreHelp::getYearSelect($filterDateYearBegin, "filterDateYearBegin");
        $filter .= " <b>" . $lang['to'] . "</b> ";
        $filter .= CoreHelp::getDaySelect($filterDateDayEnd, "filterDateDayEnd");
        $filter .= CoreHelp::getMonthSelect($filterDateMonthEnd, "filterDateMonthEnd");
        $filter .= CoreHelp::getYearSelect($filterDateYearEnd, "filterDateYearEnd");
        $total_cash = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $total      = $this->core->FirstField("SELECT Count(*) FROM wallet_payout WHERE 1 $sql_select AND to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", 0);
        if ($total > 0) {
            $list   = array();
            $result = $this->member->db->query("SELECT * FROM wallet_payout WHERE 1 $sql_select AND to_id='" . CoreHelp::sanitizeSQL($memberId) . "' ORDER BY {$this->savedState->orderBy} {$this->savedState->orderDir}");
            foreach ($result as $row) {
                $from_id     = $row['from_id'];
                $amount      = $row['amount'];
                $date        = date("d M Y H:i", $row['transaction_date']);
                $type        = $row['transaction_type'];
                $description = $row['descr'];
                array_push($list, array(
					"transaction_id" => $row['transaction_id'],
                    "date" => $date,
                    "amount" => $amount,
                    "description" => $description
                ));
            }
            $this->smarty->assign("list", $list);
        }
        $this->smarty->assign("filter", $filter);
        $this->smarty->assign("cashselect", $total_tab);
        $this->smarty->assign("total", $total);
        $this->smarty->assign("balance", $total_cash);
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'payout_wallet'
        ));
        $this->smarty->display('wallet_payout.tpl');
    }
    public function anyDepositwallet()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->load->library('Saved_State', 'savedState');
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');        
        $this->savedState->obj          = "transaction";
        $this->savedState->orderDefault = "id";
        $this->savedState->RestoreState();
        $memberId  = CoreHelp::getMemberId();
        $profile   = $this->member->getProfile($memberId);
        
        
		$this->smarty->assign("lang", $lang);
        if (CoreHelp::GetQuery('filter')) {
            $memberId             = CoreHelp::getMemberId();
            $filterDateDayBegin   = CoreHelp::GetQuery("filterDateDayBegin");
            $filterDateMonthBegin = CoreHelp::GetQuery("filterDateMonthBegin");
            $filterDateYearBegin  = CoreHelp::GetQuery("filterDateYearBegin");
            $filterDateDayEnd     = CoreHelp::GetQuery("filterDateDayEnd");
            $filterDateMonthEnd   = CoreHelp::GetQuery("filterDateMonthEnd");
            $filterDateYearEnd    = CoreHelp::GetQuery("filterDateYearEnd");
            $this->savedState->saveStateValue("filterDateBegin", mktime(0, 0, 0, $filterDateMonthBegin, $filterDateDayBegin, $filterDateYearBegin));
            $this->savedState->saveStateValue("filterDateEnd", mktime(23, 59, 59, $filterDateMonthEnd, $filterDateDayEnd, $filterDateYearEnd));
            $this->savedState->saveStateValue("member_id", $memberId);
        }
        $filterDateBegin      = $this->savedState->GetStateValue("filterDateBegin", 0);
        $filterDateEnd        = $this->savedState->GetStateValue("filterDateEnd", 0);
        $filterDateDayBegin   = ($filterDateBegin != 0) ? date("d", $filterDateBegin) : "";
        $filterDateMonthBegin = ($filterDateBegin != 0) ? date("m", $filterDateBegin) : "";
        $filterDateYearBegin  = ($filterDateBegin != 0) ? date("Y", $filterDateBegin) : date("Y", time()) - 1;
        $filterDateDayEnd     = ($filterDateEnd != 0) ? date("d", $filterDateEnd) : "";
        $filterDateMonthEnd   = ($filterDateEnd != 0) ? date("m", $filterDateEnd) : "";
        $filterDateYearEnd    = ($filterDateEnd != 0) ? date("Y", $filterDateEnd) : "";
        $sql_select           = "";
        if ($filterDateBegin != 0)
            $sql_select .= " AND transaction_date>$filterDateBegin AND transaction_date<$filterDateEnd";
        $filter = "";
        $filter .= "<b>" . $lang['date_from'] . " </b>";
        $filter .= CoreHelp::getDaySelect($filterDateDayBegin, "filterDateDayBegin");
        $filter .= CoreHelp::getMonthSelect($filterDateMonthBegin, "filterDateMonthBegin");
        $filter .= CoreHelp::getYearSelect($filterDateYearBegin, "filterDateYearBegin");
        $filter .= " <b>" . $lang['to'] . "</b> ";
        $filter .= CoreHelp::getDaySelect($filterDateDayEnd, "filterDateDayEnd");
        $filter .= CoreHelp::getMonthSelect($filterDateMonthEnd, "filterDateMonthEnd");
        $filter .= CoreHelp::getYearSelect($filterDateYearEnd, "filterDateYearEnd");
        $total_cash = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $total      = $this->core->FirstField("SELECT Count(*) FROM wallet_deposit WHERE 1 $sql_select AND member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", 0);
        if ($total > 0) {
            $list   = array();
            $result = $this->member->db->query("SELECT * FROM wallet_deposit WHERE 1 $sql_select AND member_id='" . CoreHelp::sanitizeSQL($memberId) . "' ORDER BY {$this->savedState->orderBy} {$this->savedState->orderDir}");
            foreach ($result as $row) {
                $amount      = $row['amount'];
                $date        = date("d M Y H:i", $row['transaction_date']);
                $description = $row['descr'];
                array_push($list, array(
					"id" => $row['id'],
                    "date" => $date,
                    "amount" => $amount,
                    "description" => $description
                ));
            }
            $this->smarty->assign("list", $list);
        }
		$processors = $this->member->db->query("SELECT * FROM payment_processors WHERE active = 1");
		$this->smarty->assign("processors", $processors);
        $this->smarty->assign("filter", $filter);
        $this->smarty->assign("cashselect", $total_tab);
        $this->smarty->assign("total", $total);
        $this->smarty->assign("balance", $total_cash);
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'deposit_wallet'
        ));
        $this->smarty->display('wallet_deposit.tpl');
    }
    public function getUpgrademembership()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        
        $total_payout               = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $total_deposit              = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $membership                 = $this->core->FirstField("SELECT membership FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", 0);
        $membership_id              = $this->core->FirstField("SELECT id FROM memberships WHERE membership='" . CoreHelp::sanitizeSQL($membership) . "'", 0);
        $availmemberships           = $this->member->db->query("SELECT membership FROM memberships WHERE id>0");
        $membership_expiration_time = $this->core->FirstField("SELECT membership_expiration FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", 0);
        $this->smarty->assign("lang", $lang);
        function insert_GetMemPrice($mem)
        {
			$memberId                   = CoreHelp::getMemberId();
        	$profile                    = \tmvc::instance()->controller->member->getProfile($memberId);
			if (\tmvc::instance()->controller->core->GetSiteSetting("subscription_active") == 'yes' && $profile['membership'] != '0') {
            	$key    = $mem['mem'] . "_signup_fee";	
			}
			else{
				$key    = $mem['mem'] . "_signup_fee";	
			}
            $result = iMVC_DB::queryFirstRow("SELECT value FROM settings WHERE keyname=%s", $key);
            return $result;
        }
        $membership_expiration = ($membership_expiration_time == 0) ? $lang['never'] : ($membership_expiration_time < time() ? $lang['expired'] : CoreHelp::dateDiffNowDaysHoursMins($membership_expiration_time, 1));
        if (is_array($membership_expiration)) {
            $membership_expiration = $membership_expiration['d'] . ' ' . $lang['days'] . ' ' . $membership_expiration['h'] . ' ' . $lang['hours'] . ' ' . $membership_expiration['m'] . ' ' . $lang['minutes'];
        }
		if ($membership == '0') {$membership = $lang['free_membership']; }
		$settings = $this->admin->GetSiteSettings();
		$this->smarty->assign('settings', $settings);
        $this->smarty->assign("availmemberships", $availmemberships);
        $this->smarty->assign("total_deposit", $total_deposit);
        $this->smarty->assign("total_payout", $total_payout);
        $this->smarty->assign("membership", $membership);
        
        $this->smarty->assign("membership_expiration", $membership_expiration);
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'my_membership'
        ));
        $this->smarty->display('upgrade_membership.tpl');
    }
    public function postUpgrademembership()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        
        $membership                 = CoreHelp::GetQuery("membership", "");
        $wallet                     = CoreHelp::GetQuery("wallet", "");		

			if ($this->core->GetSiteSetting("subscription_active") == 'yes' && $profile['membership'] != '0') {
            	$key    = $membership  . "_signup_fee";	
				$is_renewal = 1;
			}
			else{
				$key    = $membership  . "_signup_fee";	
				$is_renewal = 0;
			}
		
        $m_price                    = $this->core->GetSiteSetting($key);
        $lock                       = new iMVC_Library_Lock('UPGRADE_' . $memberId);
        if ($lock->lock() == false) {
            CoreHelp::redirect('back');
        }
        if (!$m_price || $m_price == 0) {
            CoreHelp::setSession('message', $lang['temporary_error_try_later']);
            CoreHelp::redirect('back');
        }
        $total_payout  = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $total_deposit = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $descr         = $lang['bought'] . " $membership " . $lang['upgrade_for'] . " " . $lang['monetary'] . "$m_price";
        if ($total_payout >= $m_price && $wallet == 'payout') {
            $this->member->db->query("INSERT INTO wallet_payout (amount, transaction_type, to_id, transaction_date, descr) 
			VALUES ('-$m_price', 2, '" . CoreHelp::sanitizeSQL($memberId) . "', '" . time() . "', '" . CoreHelp::sanitizeSQL($descr) . "')");
            $paid = 1;
        } elseif ($total_deposit >= $m_price && $wallet == 'deposit') {
            $this->member->db->query("INSERT INTO wallet_deposit (amount, member_id, transaction_date, descr) 
			VALUES ('-$m_price', '" . CoreHelp::sanitizeSQL($memberId) . "', '" . time() . "', '" . CoreHelp::sanitizeSQL($descr) . "')");
            $paid = 1;
        }
        if ($paid) {
			$this->hooks->do_action('in_matrix', $memberId);
			$ad_credits = $this->core->GetSiteSetting($membership . "_adcredit_startup");
            if ($ad_credits > 0) {
                $this->member->db->query("UPDATE members SET ad_credits=ad_credits+$ad_credits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'");
				$this->core->insertAdCreditLog($memberId, 'start_up_bonus', $ad_credits, $lang['start_up_bonus']);
            }
            if ($this->core->GetSiteSetting("subscription_active") == 'yes') {
                $mExpiration = time() + 60 * 60 * 24 * $this->core->GetSiteSetting($membership . "_subscription_days");
                $this->member->db->query("UPDATE members SET membership_expiration='" . $mExpiration . "' WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'");
            }
            $this->member->db->query("UPDATE members SET membership='" . CoreHelp::sanitizeSQL($membership) . "' WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'");
            $enroller_id    = $this->core->FirstField("SELECT sponsor_id FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", 0);
            $enroller_mem   = $this->core->FirstField("SELECT membership FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($enroller_id) . "'", 0);
			$enroller_exp   = $this->core->FirstField("SELECT membership_expiration FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($enroller_id) . "'", 0);
            $amount         = $this->core->GetSiteSetting($membership . "_signup_fee", 0);
			$pay_start_up = 1;
			$f = fopen("storage/logs/startupbonus.log", "ab+");
            if(isset($_SESSION['plan']['unilevel'])) {
				$behaviour =  $this->core->GetSiteSetting("settings_unilevel_direct_behaviour");
				$pay_start_up = $behaviour == 'start_up_bonus' ? 1 : 0;				
			}
			if($pay_start_up == 1) {
				$_SESSION['paid_start_up'] = 1;
				$spnamt         = $enroller_mem . "_" . $membership . "_startup_bonus";
				$sponsor_amount = $this->core->GetSiteSetting($spnamt, 0);
				
				fwrite($f, date("d.m.Y H:i") . " Start Up Bonus\n");				
				if($this->core->GetSiteSetting('subscription_active', 0) == 0 || $this->core->GetSiteSetting('subscription_active', 0) == 'no') {
					$can_earn = 1;	
				}
				else {
					if($enroller_exp > time()) {
						$can_earn = 1;	
					}
					elseif($this->core->GetSiteSetting('subscription_expired_behaviour') == 'can_earn_cant_withdraw' || $this->core->GetSiteSetting('subscription_expired_behaviour') == 'can_earn_can_withdraw') {
						$can_earn = 1;		
					}
					else {
						$can_earn = 0;
					}
				}
				fwrite($f, date("d.m.Y H:i") . " $sponsor_amount  | $enroller_id | $can_earn\n");
				if ($sponsor_amount > 0 && $enroller_id > 0 && $can_earn > 0) {				
					$this->core->db->query("INSERT INTO wallet_payout (amount, transaction_type, from_id, to_id, transaction_date, descr) 
					VALUES ('" . CoreHelp::sanitizeSQL($sponsor_amount) . "', '2', '" . CoreHelp::sanitizeSQL($memberId) . "', '" . CoreHelp::sanitizeSQL($enroller_id) . "', '" . time() . "', '" . $lang['sponsor_startup_bonus'] . "')");
					CoreHelp::emailCommission($memberId, $sponsor_amount, $lang['sponsor_startup_bonus']);
				}
				fclose($f);
			}
            $this->hooks->do_action('pay_upline', $memberId, $amount, $membership);
			$item = array('name' => 'Membership',
						  'description' => 'Purchased ' . $membership . ' Membership',
						  'amount' => number_format($m_price, 2, '.', ''));
			$this->hooks->do_action('create_invoice', $memberId, $item);
            CoreHelp::setSession('message', $lang['your_transaction_proceed_succesfully']);
			
			if ($this->core->GetSiteSetting($membership . "_subscription_initial_products") || $this->core->GetSiteSetting($membership . "_subscription_renewal_products")) {
				$this->hooks->do_action('forced_purchase', $is_renewal, $profile, $m_price, $membership);
				CoreHelp::redirect('/plugins/subscription/smember/requestproduct');
			}
			else {
				CoreHelp::redirect('back');
			}
        } else {
            CoreHelp::setSession('error', $lang['you_dont_have_enough_balance_on_selected_wallet']);
            CoreHelp::redirect('back');
        }       
    }
    public function anyEpinsystem()
    {	
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        
		$memberships                = $this->core->GetMemberships();
		$settings	                = $this->core->GetSiteSettings();
        foreach ($memberships as $membership) {
            $membershipData[$membership] = $this->core->GetSiteSetting($membership . '_signup_fee');
        }
        $this->smarty->assign("lang", $lang);
        if (CoreHelp::GetQuery("wallet")) {
            $lock = new iMVC_Library_Lock('ePin_' . $memberId);
            if ($lock->lock() == false) {
                CoreHelp::redirect('back');
            }
			$epin_price        = number_format($this->core->GetSiteSetting(CoreHelp::GetQuery("membership") . '_signup_fee'),2,'.','');
			if (!$epin_price || $epin_price == 0) {
				CoreHelp::setSession('message', $lang['temporary_error_try_later']);
				CoreHelp::redirect('back');
        	}            
			$wallet           = CoreHelp::GetQuery("wallet");
            $total_buy_amount = $epin_price;
            $total_payout     = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
            $total_deposit    = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
            $descr            = $lang['bought'] . " $membership ePin  for " . $lang['monetary'] . $epin_price;
            if ($total_payout >= $total_buy_amount && $wallet == 'payout') {
                $this->member->db->query("INSERT INTO wallet_payout (amount, transaction_type, to_id, transaction_date, descr) 
				VALUES ('-$total_buy_amount', 2, '" . CoreHelp::sanitizeSQL($memberId) . "', '" . time() . "', '" . CoreHelp::sanitizeSQL($descr) . "')");
                $paid = 1;
            } elseif ($total_deposit >= $total_buy_amount && $wallet == 'deposit') {
                $this->member->db->query("INSERT INTO wallet_deposit (amount, member_id, transaction_date, descr) 
				VALUES ('-$total_buy_amount', '" . CoreHelp::sanitizeSQL($memberId) . "', '" . time() . "', '" . CoreHelp::sanitizeSQL($descr) . "')");
                $paid = 1;
            }
            if ($paid == 1) {
				$code = CoreHelp::generateToken();
				$id = $total_deposit    = $this->core->FirstField("SELECT id FROM memberships WHERE membership='" . CoreHelp::sanitizeSQL(CoreHelp::GetQuery("membership")) . "'");
                $this->member->db->query("INSERT INTO epins (code, member_id, membership_id, amount_paid, date_purchased) VALUES ('".$code."', '".$memberId."', '".$id."', '".$epin_price."', '".time()."')");
                CoreHelp::setSession('message', $lang['your_transaction_proceed_succesfully']);
                CoreHelp::redirect('back');
            } else {
                CoreHelp::setSession('error', $lang['you_dont_have_enough_balance_on_selected_wallet']);
                CoreHelp::redirect('back');
            }
            $lock->unlock();
        }
        $total_payout  = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $total_deposit = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
		$epins = $this->core->db->query("SELECT * FROM epins WHERE member_id = %d", $memberId);
		$this->smarty->assignByRef('member', $this->member);	
        
        $this->smarty->assign("total_deposit", $total_deposit);
        $this->smarty->assign("total_payout", $total_payout);
        $this->smarty->assign("memberships", $memberships);
		$this->smarty->assign("settings", $settings);
		$this->smarty->assign("epins", $epins);
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'epin'
        ));
        $this->smarty->display('epinsystem.tpl');
    }
    public function getPendingreferrers()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        
        $result = $this->member->db->query("SELECT * FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership='0' ORDER BY member_id asc");
		$this->smarty->assign("data", $result);
        $this->smarty->assign("lang", $lang);
        
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'pending'
        ));
        $this->smarty->display('pending_referrals.tpl');
    }
    public function anyWithdrawals()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        
        $fee                        = $this->core->GetSiteSetting("commission_cashout_fee");
        if (CoreHelp::GetQuery("cancel")) {
			if (DEMO) {
			CoreHelp::setSession('error', 'Cannot cancel a withdrawal in demo mode');
			CoreHelp::redirect('back');
		}
            $lock = new iMVC_Library_Lock('CANCEL_WITHDRAWAL_' . $memberId);
            if ($lock->lock() == false) {
                CoreHelp::redirect('back');
            }
            $id      = CoreHelp::GetQuery("id");
            $checkId = $this->core->FirstField("SELECT member_id FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($id) . "' AND status='0'");
            if ($memberId == $checkId) {
                $this->member->db->query("UPDATE money_out SET status=2 WHERE money_out_id='" . CoreHelp::sanitizeSQL($id) . "'");
                $amount = $this->core->FirstField("SELECT amount FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($id) . "'");
                $this->member->db->query("INSERT INTO wallet_payout (amount, transaction_type, to_id, transaction_date, descr) 
				VALUES ('" . CoreHelp::sanitizeSQL($amount) . "', 2, '" . CoreHelp::sanitizeSQL($memberId) . "', '" . time() . "', '" . $lang['cancelled_withdrawal_request'] . "')");
            }
            $lock->unlock();
        }
        $total = $this->core->FirstField("SELECT Count(*) FROM money_out WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'");
        if ($total > 0) {
            $result = $this->member->db->query("SELECT * FROM money_out WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' ORDER BY money_out_id DESC");
            foreach ($result as $row) {
                $id                        = $row['money_out_id'];
                $amount                    = $row['amount'];
                $processor                 = $row['processor'];
                $account_id                = $row['account_id'];
                $processor                 = $this->core->FirstField("SELECT name FROM payment_processors WHERE processor_id=$processor");
                $pay_cash_out              = "&nbsp;";
                $date                      = date("d M Y H:i", $row['transfer_date']);
                $status_d                  = $row['status'];
                $this->statusList          = array(
                    "0" => $lang['pending'],
                    "1" => $lang['completed'],
                    "2" => $lang['declined']
                );
                $status                    = $this->statusList[$status_d];
                $cancelLink                = ($status_d == 0) ? " / <small><a href='/members/withdrawals/&cancel=request&id=$id' onClick=\"return confirm ('" . $lang['do_you_really_want_to_cancel_this_withdrawal_request'] . "');\">" . $lang['cancel'] . "</a></small>" : "&nbsp;";
                $this->data['TABLE_ROW'][] = array(
                    "amount" => $amount,
                    "fee" => $fee,
                    "date" => $date,
                    "status" => $status,
                    "processor" => $processor,
                    "processorid" => $account_id,
                    "cancel" => $cancelLink
                );
            }
        }
        $this->smarty->assign("list", $this->data['TABLE_ROW']);
        
        $this->smarty->assign("lang", $lang);
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'withdrawal'
        ));
        $this->smarty->display('withdrawals.tpl');
    }
    
    public function getRequestwithdrawal()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
		$is_active 					= 0;
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        
        $total_cash                 = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $min_cash_out               = $this->core->GetSiteSetting("commission_cashout_sum", 0);
        $fee                        = $this->core->GetSiteSetting("commission_cashout_fee", "0.00");
        $processor                  = $this->core->FirstField("SELECT name FROM payment_processors WHERE processor_id='" . CoreHelp::sanitizeSQL($profile['processor']) . "'", "");
		$processors                 = $this->core->db->query("SELECT * FROM payment_processors WHERE active_withdrawal='1'");
		foreach ($processors as $proc) {
			$active[] = $proc['name'];
			if($proc['processor_id'] == $profile['processor']) {
				$is_active = 1;	
			}
		}
		$active_processors = implode(', ', $active);
		$this->smarty->assign("is_active", $is_active);
		$this->smarty->assign("active_processors", $active_processors);
		$this->smarty->assign("wirhdrawal_is_open", $this->core->GetSiteSetting("withdrawal_open_" . date(D)));
        $this->smarty->assign("requestfee", $fee);
        $this->smarty->assign("processor", $processor);
        $this->smarty->assign("total_cash", $total_cash);
        $this->smarty->assign("min_cash_out", $min_cash_out);
        $this->smarty->assign("paymethod", $profile['account_id']);
        $this->smarty->assign("lang", $lang);
        
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'request_withdrawal'
        ));
        $this->smarty->display('requestwithdrawal.tpl');
    }
    
    public function postRequestwithdrawal()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
		        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
		$lock = new iMVC_Library_Lock('WITHDRAWAL_' . $memberId);
        if ($lock->lock() == false) {
            CoreHelp::redirect('back');
        }
        $profile                    = $this->member->getProfile($memberId);
        
        $total_cash                  = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $min_cash_out                 = $this->core->GetSiteSetting("commission_cashout_sum", 0);
        $fee                        = $this->core->GetSiteSetting("commission_cashout_fee", "0.00");
        $processor                  = $this->core->FirstField("SELECT name FROM payment_processors WHERE processor_id='" . CoreHelp::sanitizeSQL($profile['processor']) . "'", "");
        $amount                     = number_format(CoreHelp::GetQuery("amount"),2 ,'.', '');
		if ($amount <= 0) {
            CoreHelp::redirect('back');
        }
        if ($amount > $total_cash) {
            CoreHelp::setSession('error', $lang['unsufficient_balance'] . ': ' . $lang['you_have_not_this_amount_please_enter_correct']);
            CoreHelp::redirect('back');
        }
        if ($amount < $min_cash_out) {
            CoreHelp::setSession('error', $lang['correct_the_amount'], $lang['min_amount_for_cash_out_is'] . " " . $lang['monetary'] . "$min_cash_out. " . $lang['please_correct_the_amount']);
            CoreHelp::redirect('back');
        }
		if($profile['membership'] == '0' && ($this->core->GetSiteSetting('subscription_expired_behaviour') == 'can_earn_cant_withdraw' || $this->core->GetSiteSetting('subscription_expired_behaviour') == 'cant_earn_cant_withdraw')){
			CoreHelp::setSession('error', $lang['expired_members_cannot_withdraw']);
            CoreHelp::redirect('back');			
		}
		
		if($this->core->GetSiteSetting('settings_qualification_required') == 'yes'){
			$required = $this->core->GetSiteSetting("settings_qualification_required_members", 0);
			$row = $this->core->db->queryFirstRow("SELECT COUNT(*) as total FROM members WHERE sponsor_id = %d AND membership != '0'", $_SESSION['member_id']);
			if($row['total'] < $required) {
				$left = $required - $row['total'];
				CoreHelp::setSession('error', $lang['unqualified_members_cannot_withdraw'] . ' ' . $left .' ' . $lang['more_members']);
            	CoreHelp::redirect('back');	
			}
					
		}	
				
        $this->member->db->query("INSERT INTO money_out (member_id, processor, account_id, transfer_date, amount, status) 
		VALUES ('$memberId', '" . $profile['processor'] . "', '" . $profile['account_id'] . "','" . time() . "', $amount, 0)");
        $this->member->db->query("INSERT INTO wallet_payout (transaction_type, to_id, from_id, amount, descr, transaction_date) 
		VALUES (-1, '" . CoreHelp::sanitizeSQL($memberId) . "', 0, -$amount, 'Withdrawal Request', '" . time() . "')");
		$lock->unlock();
		$wallet_payout	            = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
		CoreHelp::setSession('payout_balance', $wallet_payout);
        CoreHelp::setSession('message', $lang['withdrawal_was_succesfully_requested']);
        CoreHelp::redirect('back');
    }

    public function anyDownloads()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        $memMembership              = $profile['membership'];
        $membershipId               = $this->core->FirstField("SELECT id FROM memberships WHERE membership='" . CoreHelp::sanitizeSQL($memMembership) . "'");
        $umessages                  = $this->core->FirstField("SELECT count(*) FROM messages WHERE `to` = '" . $memberId . "' && `to_viewed` = '0' && `to_deleted` = '0' && `alert` = '0'", "0");
        if (CoreHelp::GetQuery("file")) {
            $file_id  = CoreHelp::decrypt(CoreHelp::GetQuery('file'));
            $filename = $this->core->FirstField("SELECT filename FROM infobank WHERE id='" . CoreHelp::sanitizeSQL($file_id) . "'");
            $file     = __DIR__ . "/../../../files/" . $filename;
            $this->member->db->query("UPDATE infobank SET download_counter=download_counter+1 WHERE id='" . CoreHelp::sanitizeSQL($file_id) . "'");
            set_time_limit(0);
            $s = new \diversen\sendfile();
            $s->contentDisposition($filename);
            try {
                $s->send($file);
            }
            catch (\Exception $e) {
                CoreHelp::setSession('error', $lang['error_downloading_file_try_again_later_or_contact_admin']);
                CoreHelp::redirect('back');
            }
        }
        $category = CoreHelp::GetQuery("category");
        if ($category != "all" && $category != "") {
            $moresql = " WHERE category='" . CoreHelp::sanitizeSQL($category) . "' ";
        }
        $downloads   = $this->member->db->query("SELECT * FROM bsc_products WHERE idCategory=7");
        $memberships = $this->core->GetMemberships();
        
        foreach ($downloads as $row) {
            $file_id             = $row['id'];
            $ctid                = CoreHelp::encrypt($file_id);
            $filecoded[$file_id] = $ctid;
        }

   //           $this->member->Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
   //   $this->member->Db->query("SET NAMES 'utf8'"); // formating to utf8
   //  $sort['id'] = 'DESC';
   //  $filter[]   = array(
   //      'payer_email = %s',
   //      $_SESSION['customer']
   //  ); 
        $email= $profile['email'];
   $orders = $this->member->db->query("SELECT * FROM bsc_order_detail WHERE payment_status='Completed' AND payer_email='$email'");
        foreach ($orders as $key => $value) {
            # code...
            $orders1[$key]=$value["item_number"];
        }
        $categories = $this->member->db->query("SELECT distinct category FROM infobank");
        $this->smarty->assign("orders", $orders1);
        $this->smarty->assign("memberships", $memberships);
        $this->smarty->assign("encoded", $filecoded);
        $this->smarty->assign("membershipId", $membershipId);
        $this->smarty->assign("category", $categories);
        $this->smarty->assign("lang", $lang);
        $this->smarty->assign("files", $downloads);
        
        CoreHelp::setSession('menu', array(
            'main' => 'products',
            'sub' => 'products'
        ));
        $this->smarty->display('infobank.tpl');
    }  

    public function anyMyvault()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        $memMembership              = $profile['membership'];
        $membershipId               = $this->core->FirstField("SELECT id FROM memberships WHERE membership='" . CoreHelp::sanitizeSQL($memMembership) . "'");
        $umessages                  = $this->core->FirstField("SELECT count(*) FROM messages WHERE `to` = '" . $memberId . "' && `to_viewed` = '0' && `to_deleted` = '0' && `alert` = '0'", "0");
        if (CoreHelp::GetQuery("file")) {
            $file_id  = CoreHelp::decrypt(CoreHelp::GetQuery('file'));
            $filename = $this->core->FirstField("SELECT filename FROM downloader WHERE id='" . CoreHelp::sanitizeSQL($file_id) . "'");
            $file     = __DIR__ . "/../../../files/" . $filename;
            $this->member->db->query("UPDATE downloader SET download_counter=download_counter+1 WHERE id='" . CoreHelp::sanitizeSQL($file_id) . "'");
            set_time_limit(0);
            $s = new \diversen\sendfile();
            $s->contentDisposition($filename);
            try {
                $s->send($file);
            }
            catch (\Exception $e) {
                CoreHelp::setSession('error', $lang['error_downloading_file_try_again_later_or_contact_admin']);
                CoreHelp::redirect('back');
            }
        }
        $category = CoreHelp::GetQuery("category");
        if ($category != "all" && $category != "") {
            $moresql = " AND   category='" . CoreHelp::sanitizeSQL($category) . "' ";
        }
        $downloads   = $this->member->db->query("SELECT * FROM downloader WHERE memberid=$memberId $moresql ORDER BY featured desc, date desc");
        $memberships = $this->core->GetMemberships();
        
        foreach ($downloads as $row) {
            $file_id             = $row['id'];
            $ctid                = CoreHelp::encrypt($file_id);
            $filecoded[$file_id] = $ctid;
        }
        $categories = $this->member->db->query("SELECT distinct category FROM downloader");
        $this->smarty->assign("memberships", $memberships);
        $this->smarty->assign("encoded", $filecoded);
        $this->smarty->assign("membershipId", $membershipId);
        $this->smarty->assign("category", $categories);
        $this->smarty->assign("lang", $lang);
        $this->smarty->assign("files", $downloads);
        
        CoreHelp::setSession('menu', array(
            'main' => 'my_account',
            'sub' => 'myvault'
        ));
        $this->smarty->display('downloads.tpl');
    }
    
    public function anyMessages()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);        
        $msgid                      = md5(uniqid());
        if (CoreHelp::GetQuery('subject')) {
            if (CoreHelp::GetQuery('to') == "all") {
                $res = $this->member->db->query("SELECT member_id,username FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' ORDER BY username ASC");
                if (count($res) > 0) {
                    foreach ($res as $row) {
                        $this->messages->sendmessage($row[member_id], $memberId, CoreHelp::GetQuery('subject'), CoreHelp::GetQuery('message'), CoreHelp::GetQuery('priority'), "all_referrals", $msgid);
                    }
                    CoreHelp::setSession('message', $lang['your_messages_proceed_succesfully']);
                    CoreHelp::redirect('back');
                } else {
                    CoreHelp::setSession('error', $lang['your_have_not_referrals']);
                    CoreHelp::redirect('back');
                }
            } elseif (CoreHelp::GetQuery('to') == "free") {
                $query    = "SELECT member_id,username FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND membership='0' ORDER BY username asc";
                $res      = $this->member->db->query($query);
                $num_rows = count($res);
                if ($num_rows > 0) {
                    foreach ($res as $row) {
                        $this->messages->sendmessage($row[member_id], $memberId, CoreHelp::GetQuery('subject'), CoreHelp::GetQuery('message'), CoreHelp::GetQuery('priority'), "free_referrals", $msgid);
                    }
                    CoreHelp::setSession('message', $lang['your_messages_proceed_succesfully']);
                    CoreHelp::redirect('back');
                } else {
                    CoreHelp::setSession('error', $lang['your_have_not_free_referrals']);
                    CoreHelp::redirect('back');
                }
            } elseif (CoreHelp::GetQuery('to') == "paid") {
                $query    = "SELECT member_id,username FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' AND AND membership!='0' ORDER BY username asc";
                $res      = $this->member->db->query($query);
                $num_rows = count($res);
                if ($num_rows > 0) {
                    foreach ($res as $row) {
                        $this->messages->sendmessage($row[member_id], $memberId, CoreHelp::GetQuery('subject'), CoreHelp::GetQuery('message'), CoreHelp::GetQuery('priority'), "paid_referrals", $msgid);
                    }
                    CoreHelp::setSession('message', $lang['your_messages_proceed_succesfully']);
                    CoreHelp::redirect('back');
                } else {
                    CoreHelp::setSession('error', $lang['your_have_not_paid_referrals']);
                    CoreHelp::redirect('back');
                }
            } elseif (CoreHelp::GetQuery('to') == "sponsor") {
                $sponsor = $this->core->FirstField("SELECT sponsor_id FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' LIMIT 1", "0");
                if ($sponsor) {
                    $this->messages->sendmessage($sponsor, $memberId, CoreHelp::GetQuery('subject'), CoreHelp::GetQuery('message'), CoreHelp::GetQuery('priority'), "normal", $msgid);
                    CoreHelp::setSession('message', $lang['your_message_sent_succesfully']);
                    CoreHelp::redirect('back');
                } else {
                    CoreHelp::setSession('error', $lang['you_havent_sponsor_referers']);
                    CoreHelp::redirect('back');
                }
            } elseif (CoreHelp::GetQuery('to') == "admin") {
                $admin = $this->core->FirstField("SELECT username FROM members WHERE member_id='1' LIMIT 1", "0");
                if ($admin) {
                    $this->messages->sendmessage($admin, $memberId, CoreHelp::GetQuery('subject'), CoreHelp::GetQuery('message'), CoreHelp::GetQuery('priority'), "normal", $msgid);
                    CoreHelp::setSession('message', $lang['your_message_sent_succesfully']);
                    CoreHelp::redirect('/members/messages');
                } else {
                    CoreHelp::setSession('error', $lang['you_havent_sponsor_referers']);
                    CoreHelp::redirect('back');
                }
            } else {
               // if ($this->core->FirstField("SELECT member_id FROM members WHERE username='" . CoreHelp::sanitizeSQL(CoreHelp::GetQuery('to')) . "' AND sponsor_id = '" . CoreHelp::sanitizeSQL($memberId) . "' LIMIT 1", false)) {
                    $this->messages->sendmessage(CoreHelp::GetQuery('to'), $memberId, CoreHelp::GetQuery('subject'), CoreHelp::GetQuery('message'), CoreHelp::GetQuery('priority'), "normal", $msgid);
                    CoreHelp::setSession('message', $lang['your_message_sent_succesfully']);
                    CoreHelp::redirect('back');
                /*} else {
                    CoreHelp::setSession('error', $lang['error_couldnt_send_pm_maybe_wrong_user']);
                    CoreHelp::redirect('back');
                }*/
            }
        }
        if (CoreHelp::GetQuery('delete')) {
            if ($this->messages->deleted(CoreHelp::GetQuery('did'))) {
                CoreHelp::setSession('message', $lang['your_message_deleted_succesfully']);
                CoreHelp::redirect('back');
            } else {
                CoreHelp::setSession('message', $lang['error_couldnt_delete_message']);
                CoreHelp::redirect('back');
            }
        }
        
        if (CoreHelp::GetQuery('p')) {
            switch (CoreHelp::GetQuery('p')) {
                case 'new':
                    $messages = $this->messages->getmessages(0, $memberId);
                    break;
                case 'send':
                    $messages = $this->messages->getmessages(2, $memberId);
                    break;
                case 'read':
                    $messages = $this->messages->getmessages(1, $memberId);
                    break;
                case 'deleted':
                    $messages = $this->messages->getmessages(3, $memberId);
                    break;
                case 'view':
                    $messages = $this->messages->getmessage(CoreHelp::GetQuery('mid'), $memberId);
                    break;
                default:
                    $messages = $this->messages->getmessages(0, $memberId);
                    break;
            }
        } else {
            $messages = $this->messages->getmessages(0, $memberId);
        }
        if ($memberId == $messages[0]['toid'] && !$messages[0]['to_viewed'] && CoreHelp::GetQuery('p') == 'view' && CoreHelp::GetQuery('mid')) {
            $this->messages->viewed($messages[0]['id']);
        }
        
        $directsData = $this->messages->db->query("SELECT member_id,username FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberId) . "' ORDER BY username ASC");
		
        $this->smarty->assignByRef('msgObj', $this->messages);
        $this->smarty->assign("directs_data", $directsData);
        $this->smarty->assign("messages", $messages);
        $this->smarty->assign("content", $content);
        $this->smarty->assign("lang", $lang);
        
        CoreHelp::setSession('menu', array(
            'main' => 'messaging',
            'sub' => 'inbox'
        ));
        $this->smarty->display('messages.tpl');
    }
    
    public function anyBanners()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        
        $result                     = $this->member->db->query("SELECT * FROM banners");
		$profile  = $this->member->getProfile($memberId);
		$this->smarty->assign("username", $profile['username']);
        $this->smarty->assign("lang", $lang);
        
        $this->smarty->assign("banners", $result);
        CoreHelp::setSession('menu', array(
            'main' => 'promotional',
            'sub' => 'banners'
        ));
        $this->smarty->display('banners.tpl');
    }
	
	public function anyTextads()
	{
		if (!CoreHelp::memberIsLoggedIn()) {
			CoreHelp::redirect('/members/login/');
		}
		$this->smarty->template_dir = 'system/app/views/members/';
		$lang                       = CoreHelp::getLang('members');		
		$memberId = CoreHelp::getMemberId();
		$profile  = $this->member->getProfile($memberId);		
		
		$result = $this->member->db->query("SELECT * FROM textads");
		
		$this->smarty->assign("sponsor", $profile['sponsor_id']);
		$this->smarty->assign("username", $profile['username']);
		$this->smarty->assign("textads", $result);
		$this->smarty->assign("lang", $lang);
		 CoreHelp::setSession('menu', array(
            'main' => 'promotional',
            'sub' => 'text_ads'
        ));
		$this->smarty->display('textads.tpl');
	}
	public function anyOptin()
	{
		if (!CoreHelp::memberIsLoggedIn()) {
			CoreHelp::redirect('/members/login/');
		}
		$this->smarty->template_dir = 'system/app/views/members/';
		$lang                       = CoreHelp::getLang('members');
		$memberId = CoreHelp::getMemberId();
		$profile  = $this->member->getProfile($memberId);	
				
		$result = $this->member->db->query("SELECT * FROM optin");
		$this->smarty->assign("username", $profile['username']);
		$this->smarty->assign("optin", $result);
		$this->smarty->assign("lang", $lang);
		
		 CoreHelp::setSession('menu', array(
            'main' => 'promotional',
            'sub' => 'optin'
        ));
		$this->smarty->display('optin.tpl');
	}
	public function anyTellafriend()
	{
		if (!CoreHelp::memberIsLoggedIn()) {
			CoreHelp::redirect('/members/login/');
		}
		$this->smarty->template_dir = 'system/app/views/members/';
		$lang                       = CoreHelp::getLang('members');
		$memberId = CoreHelp::getMemberId();
		$profile  = $this->member->getProfile($memberId);
		
		if (isset($_POST['submit'])) {
			$subject = CoreHelp::GetQuery("subject", "");
			$message = CoreHelp::GetQuery("email_body", "");
			for ($i = 0; $i < 6; $i++) {
				$names  = CoreHelp::GetQuery("name$i", "");
				$emails = CoreHelp::GetQuery("email$i", "");
				if ($names != "" AND $emails != "") {
					list($firstName, $lastName, $sponsorId, $username) = array_values($this->core->db->queryFirstRow("SELECT first_name,last_name,sponsor_id,username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'"));
       			 	$sponsorUsername = $this->core->FirstField("SELECT username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsorId) . "'");
					$adminEmail       = $this->core->GetSiteSetting("admin_email");
					$siteUrl          = $this->core->GetSiteSetting("site_url");
					$siteTitle       = $this->core->GetSiteSetting("site_name");
					$emailHeader      = "From: " . $adminEmail . "\r\n";
					$message = CoreHelp::replaceMail($message, $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
        			$subject = CoreHelp::replaceMail($subject, $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
					CoreHelp::sendMail($emails, $subject, $message, $emailHeader);
				}
			}
			CoreHelp::setSession('message', $lang['your_message_sent_succesfully']);
            CoreHelp::redirect('back');
		}		
		$siteUrl       = $this->core->GetSiteSetting("site_url");
		$siteTitle     = $this->core->GetSiteSetting("site_name");
		list($firstName, $lastName, $sponsorId, $username) = array_values($this->core->db->queryFirstRow("SELECT first_name,last_name,sponsor_id,username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'"));
        $sponsorUsername = $this->core->FirstField("SELECT username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsorId) . "'");
        $result = $this->member->db->queryFirstRow("SELECT * FROM emailtemplates WHERE code='TellaFriend'");
        $result['message'] = CoreHelp::replaceMail($result['message'], $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
        $result['subject'] = CoreHelp::replaceMail($result['subject'], $firstName, $lastName, $siteTitle, $siteUrl, $adminEmail, $sponsorUsername, $sponsorId, $memberId, $username);
		$this->smarty->assign("email", $result);		
		$this->smarty->assign("lang", $lang);
		
		 CoreHelp::setSession('menu', array(
            'main' => 'promotional',
            'sub' => 'tell_friend'
        ));
		$this->smarty->display('tellafriend.tpl');
	}
	
	public function anyLogout()
	{
		if (!CoreHelp::memberIsLoggedIn()) {
			CoreHelp::redirect('/members/login/');
		}
		session_destroy();
		CoreHelp::redirect('/');
	}
	
	public function anyForgotpassword()
	{
		$this->smarty->template_dir = 'system/app/views/members/';
		$lang                       = CoreHelp::getLang('members');
		$this->smarty->assign("lang", $lang);
		if (CoreHelp::GetQuery("forgot")) {
			CoreHelp::trackRetries('forgot_password');
			$email = CoreHelp::GetQuery("email");
			$count = $this->core->FirstField("SELECT Count(*) FROM members WHERE email='" . CoreHelp::sanitizeSQL($email) . "'", 0);
			if ($count > 0) {
				$result = $this->member->db->queryFirstRow("SELECT * FROM members WHERE email='" . CoreHelp::sanitizeSQL($email) . "' limit 1");
				$username  = $result['username'];
				$firstName = $result['first_name'];
				$lastName  = $result['last_name'];

				$siteTitle    = $this->core->GetSiteSetting("site_name");
				$contactEmail = $this->core->GetSiteSetting("admin_email");
				$token = md5(uniqid());
				$this->member->db->query("UPDATE members SET forgot_token = %s WHERE email = %s", $token, $email);
				$reset_url = CoreHelp::getSiteUrl() . 'members/resetforgotpassword/&token=' . $token;
				$emailHeader  = "From: " . $contactEmail . "\r\n";
				$message = $this->core->FirstField("SELECT message FROM emailtemplates WHERE code='ForgotPassword'");
				$message = CoreHelp::dec($message);
				$message = str_replace("[FirstName]", $firstName, $message);
				$message = str_replace("[LastName]", $lastName, $message);
				$message = str_replace("[SiteName]", $siteTitle, $message);
				$message = str_replace("[Username]", $username, $message);
				$message = str_replace("[ResetUrl]", $reset_url, $message);
				$subject = $this->core->FirstField("SELECT subject FROM emailtemplates WHERE code='ForgotPassword'");
				$subject = CoreHelp::dec($subject);
				$subject = str_replace("[SiteName]", $siteTitle, $subject);
				$subject = str_replace("[FirstName]", $firstName, $subject);
				$subject = str_replace("[LastName]", $lastName, $subject);
				$subject = str_replace("[Username]", $username, $subject);
				$adminEmail  = $this->core->GetSiteSetting("admin_email");
              	$emailHeader = "From: " . $adminEmail . "\r\n";
				if (CoreHelp::sendMail($email, $subject, $message, $emailHeader)) {
					CoreHelp::setSession('message', $lang['check_your_email']);
            		CoreHelp::redirect('back');				
				}
			} else {
				CoreHelp::setSession('error', $lang['email_is_not_registered_on_database']);
            	CoreHelp::redirect('back');		
			}			
		}
		$this->smarty->display('forgotpassword.tpl');
	}
	
	public function anyResetforgotpassword()
	{
		$this->smarty->template_dir = 'system/app/views/members/';
		$lang                       = CoreHelp::getLang('members');
		$this->smarty->assign("lang", $lang);
		if (CoreHelp::GetQuery("token") && !CoreHelp::GetQuery("reset_token")) {
			$member_id = $this->core->db->queryFirstField("SELECT member_id FROM members WHERE forgot_token = %s", CoreHelp::GetQuery("token"));
			if (!$member_id) {
				CoreHelp::setSession('error', $lang['invalid_token']);
            	CoreHelp::redirect('/members/login');		
			}
			$this->smarty->assign("reset_token", CoreHelp::GetQuery("token"));			
		}
		elseif(CoreHelp::GetQuery("reset_token")) {
			$member_id = $this->core->db->queryFirstField("SELECT member_id FROM members WHERE forgot_token = %s", CoreHelp::GetQuery("reset_token"));
			if (!$member_id) {
				CoreHelp::setSession('error', $lang['invalid_token']);
            	CoreHelp::redirect('back');		
			}
			elseif(strlen(CoreHelp::GetQuery("password")) < 8){
				CoreHelp::setSession('error', $lang['password_too_short']);
            	CoreHelp::redirect('back');		
			}
			elseif(CoreHelp::GetQuery("password") != CoreHelp::GetQuery("confirm_password")){
				CoreHelp::setSession('error', $lang['passwords_does_not_match']);
            	CoreHelp::redirect('back');		
			}
			else {
				$this->core->db->query("UPDATE members SET forgot_token = '', password = %s WHERE member_id = %s", hash('sha256', CoreHelp::GetQuery("password")), $member_id);
				CoreHelp::setSession('message', $lang['password_set_succesfully']);
            	CoreHelp::redirect('/members/login');		
			}	
		}
		else{
			CoreHelp::redirect('/');		
		}
		$this->smarty->display('resetpassword.tpl');
	}
	
	function anyActivation()
	{
		$lang  = CoreHelp::getLang('members');
		if (CoreHelp::GetQuery("hash")) {
			$member_id = $this->core->db->queryFirstField("SELECT member_id FROM members WHERE activation_token = %s", CoreHelp::GetQuery("hash"));	
			if (!$member_id) {
				CoreHelp::setSession('error', $lang['account_is_already_activated_or_doesnt_exist']);
            	CoreHelp::redirect('/members/login');	
			}
			else {
				$this->core->db->query("UPDATE members SET is_active = 1, activation_token='' WHERE member_id = %d", $member_id);	
				CoreHelp::setSession('message', $lang['your_account_is_now_verified']);
            	CoreHelp::redirect('/members/login');	
			}
		}
		CoreHelp::redirect('/members/login');	
	}
	
	public function anyDepositmoney()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $processor                  = $this->member->db->queryFirstRow("SELECT * FROM payment_processors WHERE processor_id = %s", CoreHelp::GetQuery("processor"));
		$amount						= number_format(CoreHelp::GetQuery("amount"),2, '.', '');
		if ($amount < $this->core->GetSiteSetting("min_deposit")) {
			CoreHelp::setSession('error', $lang['min_amount_deposit_is'] .' '. $lang['monetary'] . $this->core->GetSiteSetting("min_deposit"));
            CoreHelp::redirect('back');		
		}
		if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
			$amount = number_format($amount + ($amount * $processor['fee_percent'] / 100) + $processor['fee_flat'], 2, '.', '');
		}
		$this->hooks->do_action($processor['code'], $amount);
    }
	
	public function getAnnouncement()
	{
		$this->smarty->template_dir = 'system/app/views/members/';
		$lang                       = CoreHelp::getLang('members');
		$announcement               = $this->member->db->queryFirstRow("SELECT * FROM news WHERE id = %d", CoreHelp::GetQuery("id"));
		$this->smarty->assign("announcement", $announcement);
		$this->smarty->assign("lang", $lang);
		$this->smarty->display('announcement.tpl');
	}
	
	public function getAnnouncements()
	{
		$this->smarty->template_dir = 'system/app/views/members/';
		$lang                       = CoreHelp::getLang('members');
		$announcements              = $this->member->db->query("SELECT * FROM news ORDER BY id DESC");
		$this->smarty->assign("list", $announcements);
		$this->smarty->assign("lang", $lang);
		$this->smarty->display('announcements.tpl');
	}
	
	 public function anyAdcredits()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        
        $this->smarty->assign("lang", $lang);
        if (CoreHelp::GetQuery("credits")) {
            $lock = new iMVC_Library_Lock('AD_CREDITS_' . $memberId);
            if ($lock->lock() == false) {
                CoreHelp::redirect('back');
            }
            $credits          = number_format(abs(CoreHelp::GetQuery("credits")),2,'.','');
            $total_buy_amount = $credits;
			$wallet           = CoreHelp::GetQuery("wallet");
            $total_payout     = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
            $total_deposit    = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
            $descr            = $lang['bought'] . " $credits " . $lang['ad_credits'] . " " . $lang['monetary'] . "$total_buy_amount";
            if ($total_payout >= $total_buy_amount && $wallet == 'payout') {
                $this->member->db->query("INSERT INTO wallet_payout (amount, transaction_type, to_id, transaction_date, descr) 
				VALUES ('-$total_buy_amount', 2, '" . CoreHelp::sanitizeSQL($memberId) . "', '" . time() . "', '" . CoreHelp::sanitizeSQL($descr) . "')");
                $paid = 1;
            } elseif ($total_deposit >= $total_buy_amount && $wallet == 'deposit') {
                $this->member->db->query("INSERT INTO wallet_deposit (amount, member_id, transaction_date, descr) 
				VALUES ('-$total_buy_amount', '" . CoreHelp::sanitizeSQL($memberId) . "', '" . time() . "', '" . CoreHelp::sanitizeSQL($descr) . "')");
                $paid = 1;
            }
            if ($paid == 1) {
				$this->load->plugin_model('Banners_Model', 'banners');
                $this->member->db->query("UPDATE members SET ad_credits=ad_credits+$credits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'");
				$this->banners->insertCreditLog($memberId, $credits, 'purchase', $descr);
                CoreHelp::setSession('message', $lang['your_transaction_proceed_succesfully']);
                CoreHelp::redirect('back');
            } else {
                CoreHelp::setSession('error', $lang['you_dont_have_enough_balance_on_selected_wallet']);
                CoreHelp::redirect('back');
            }
            $lock->unlock();
        }
        $ad_credits    = $this->core->FirstField("SELECT ad_credits FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", 0);
		$total_payout  = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
        $total_deposit = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", "0.00");
		$log		   = $this->core->db->query("SELECT * FROM ad_credit_log WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "' ORDER BY id DESC LIMIT 200");
        
		$this->smarty->assign("log", $log);
        $this->smarty->assign("ad_credits", $ad_credits);
        $this->smarty->assign("total_deposit", $total_deposit);
        $this->smarty->assign("total_payout", $total_payout);
        $this->smarty->assign("membership", $membership);
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'ad_credits'
        ));
        $this->smarty->display('ad_credits.tpl');
    }
	
	function anyFaq()
	{
		if (!CoreHelp::memberIsLoggedIn()) {
			CoreHelp::redirect('/members/login/');
		}
		$this->smarty->template_dir = 'system/app/views/members/';
		$lang                       = CoreHelp::getLang('members');
		$this->smarty->assign("lang", $lang);		
		$memberId = CoreHelp::getMemberId();
		$profile  = $this->member->GetProfile($memberId);
		
		
		$result = $this->member->db->query("SELECT * FROM faq");
		$this->smarty->assign("faq", $result);
		$this->smarty->display('faq.tpl');
	}
	
	public function anySendtoken()
	{
		if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
		CoreHelp::trackRetries('send_token');
		$memberId = CoreHelp::getMemberId();
		$profile  = $this->member->GetProfile($memberId);
		$adminEmail  = $this->core->GetSiteSetting("admin_email");
		$siteTitle   = $this->core->GetSiteSetting("site_name");
       	$emailHeader = "From: " . $adminEmail . "\r\n";
		$token = CoreHelp::getSession('security_token') ? CoreHelp::getSession('security_token') : md5(uniqid());
		CoreHelp::setSession('security_token', $token);
		$email = $profile['email'];
		$subject = 'Security Token For ' . $siteTitle;
		$message = 'Dear ' . $profile['first_name'] . ' ' . $profile['last_name'] .'

Your temporary Security Token is: '.$token.'

'.$siteTitle.'		
		
		';
		if (CoreHelp::sendMail($email, $subject, $message, $emailHeader)) {
			echo "done";
		} else {
			echo "There was an error sending the email, please try again in few minutes or contact the company support team";
		}			

	}
	
	public function postRedeempin()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/views/members/';
        $lang                       = CoreHelp::getLang('members');
        $memberId                   = CoreHelp::getMemberId();
        $profile                    = $this->member->getProfile($memberId);
        
        $code                 		= CoreHelp::GetQuery("code", "");
        $lock                       = new iMVC_Library_Lock('UPGRADE_' . $memberId);
        if ($lock->lock() == false) {
            CoreHelp::redirect('back');
        }
       	$epin = $this->member->db->queryFirstRow("SELECT * FROM epins WHERE code = %s AND used_by_member_id = 0", $code);		
        if ($epin['id'] > 0) {
			$this->member->db->query("UPDATE epins set used_by_member_id = %d, date_used = %d WHERE code = %s", $memberId, time(), $code);
			$membership = $this->member->db->queryFirstField("SELECT membership FROM memberships WHERE id = %d", $epin['membership_id']);
			$this->hooks->do_action('in_matrix', $memberId);
			$ad_credits = $this->core->GetSiteSetting($membership . "_adcredit_startup");
            if ($ad_credits > 0) {
                $this->member->db->query("UPDATE members SET ad_credits=ad_credits+$ad_credits WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'");
				$this->core->insertAdCreditLog($memberId, 'start_up_bonus', $ad_credits, $lang['start_up_bonus']);
            }
            if ($this->core->GetSiteSetting("subscription_active") == 'yes') {
                $mExpiration = time() + 60 * 60 * 24 * $this->core->GetSiteSetting($membership . "_subscription_days");
                $this->member->db->query("UPDATE members SET membership_expiration='" . $mExpiration . "' WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'");
            }
            $this->member->db->query("UPDATE members SET membership='" . CoreHelp::sanitizeSQL($membership) . "' WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'");
            $enroller_id    = $this->core->FirstField("SELECT sponsor_id FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($memberId) . "'", 0);
            $enroller_mem   = $this->core->FirstField("SELECT membership FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($enroller_id) . "'", 0);
			$enroller_exp   = $this->core->FirstField("SELECT membership_expiration FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($enroller_id) . "'", 0);
            $amount         = $this->core->GetSiteSetting($membership . "_signup_fee", 0);
			$pay_start_up = 1;
            if(isset($_SESSION['plan']['unilevel'])) {
				$behaviour =  $this->core->GetSiteSetting("settings_unilevel_direct_behaviour");
				$pay_start_up = $behaviour == 'start_up_bonus' ? 1 : 0;
				$_SESSION['paid_start_up'] = 1;
			}
			if($pay_start_up == 1) {
				$spnamt         = $enroller_mem . "_" . $membership . "_startup_bonus";
				$sponsor_amount = $this->core->GetSiteSetting($spnamt, 0);
				if($this->core->GetSiteSetting('subscription_active', 0) == 0 || $this->core->GetSiteSetting('subscription_active', 0) == 'no') {
					$can_earn = 1;	
				}
				else {
					if($enroller_exp > time()) {
						$can_earn = 1;	
					}
					elseif($this->core->GetSiteSetting('subscription_expired_behaviour') == 'can_earn_cant_withdraw' || $this->core->GetSiteSetting('subscription_expired_behaviour') == 'can_earn_can_withdraw') {
						$can_earn = 1;		
					}
					else {
						$can_earn = 0;
					}
				}
				if ($sponsor_amount > 0 && $enroller_id > 0 && $can_earn > 0) {				
					$this->core->db->query("INSERT INTO wallet_payout (amount, transaction_type, from_id, to_id, transaction_date, descr) 
					VALUES ('" . CoreHelp::sanitizeSQL($sponsor_amount) . "', '2', '" . CoreHelp::sanitizeSQL($memberId) . "', '" . CoreHelp::sanitizeSQL($enroller_id) . "', '" . time() . "', '" . $lang['sponsor_startup_bonus'] . "')");
					CoreHelp::emailCommission($memberId, $sponsor_amount, $lang['sponsor_startup_bonus']);
				}
			}
            $this->hooks->do_action('pay_upline', $memberId, $amount, $membership);
			$item = array('name' => 'Membership',
						  'description' => 'Purchased ' . $membership . ' Membership',
						  'amount' => number_format($amount, 2, '.', ''));
			$this->hooks->do_action('create_invoice', $memberId, $item);
            CoreHelp::setSession('message', $lang['your_transaction_proceed_succesfully']);
			CoreHelp::redirect('back');
        } else {
            CoreHelp::setSession('error', $lang['invalid_epin_selected']);
            CoreHelp::redirect('back');
        }       
    }
    
	public function anyUploadpic()
	{
		if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
		$memberId = CoreHelp::getMemberId();
		$profile  = $this->member->GetProfile($memberId);

		if(isset($_FILES['image_upload_file'])){
			$output['status']=FALSE;
			set_time_limit(0);
			$allowedImageType = array("image/gif",   "image/jpeg",   "image/pjpeg",   "image/png",   "image/x-png"  );
			$file = pathinfo($_FILES['image_upload_file']['name']);
			if ($_FILES['image_upload_file']["error"] > 0) {
				$output['error']= "Error in File";
			}
			elseif (!in_array($_FILES['image_upload_file']["type"], $allowedImageType)) {
				$output['error']= "You can only upload JPG, PNG and GIF file";
			}			
			elseif($file["extension"] != "jpg" && $file["extension"] != "png" && $file["extension"] != "jpeg" && $file["extension"] != "gif" ) {
				$output['error']= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";				
			}
			elseif (round($_FILES['image_upload_file']["size"] / 1024) > 1024) {
				$output['error']= "You can upload file size up to 1 MB";
			} else {
				$path[0] = $_FILES['image_upload_file']['tmp_name'];
				$file = pathinfo($_FILES['image_upload_file']['name']);
				$fileType = $file["extension"];
				$desiredExt='jpg';
				$fileNameNew = $memberId . ".$desiredExt";
				$path[1] = 'media/avatars/normal/'. $fileNameNew;
				$path[2] = 'media/avatars/thumb/'. $fileNameNew;
				
				if (CoreHelp::createThumb($path[0], $path[1], $fileType, 250, 250, 250)) {
					
					if (CoreHelp::createThumb($path[1], $path[2],"$desiredExt", 50, 50, 50)) {
						$output['status']=TRUE;
						$output['image_medium']= '/media/avatars/normal/'. $fileNameNew .'?'.rand(100,1000);
						$output['image_small']= '/media/avatars/thumb/'. $fileNameNew .'?'.rand(100,1000);
					}
				}
			}
			echo json_encode($output);
		}		

	}
	
}
?>