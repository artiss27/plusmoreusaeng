<?php

class Admin_Controller extends iMVC_Controller
{

    public function getIndex()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';

        $parts = parse_url($_SERVER['REQUEST_URI']);
        parse_str($parts['query'], $query);
        $data['start'] = (!empty($query['start']) ? $query['start'] : '');
        $data['end'] = (!empty($query['end']) ? $query['end'] : '');
        $wereDate = (!empty($data['start']) ? " WHERE date >= '" . $data['start'] . "'" : "");
        $wereDate .= (!empty($data['end']) ? (!$wereDate ? ' WHERE' : ' AND') . " date <= '" . $data['end'] . "'" : "");
        $wereDateU = (!empty($data['start']) ? " AND reg_date >= '" . strtotime($data['start']) . "'" : "");
        $wereDateU .= (!empty($data['end']) ? " AND reg_date <= '" . strtotime($data['end']) . "'" : "");
        function str_replace_once($search, $replace, $text)
        {
            $pos = strpos($text, $search);
            return $pos !== false ? substr_replace($text, $replace, $pos, strlen($search)) : $text;
        }

        $data['total_members'] = $this->core->FirstField("SELECT COUNT(*) FROM members", 0);
        $data['new_members_today'] = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE reg_date > UNIX_TIMESTAMP(DATE_SUB( NOW(), INTERVAL 1 DAY ))", 0);
        $data['total_paid_members'] = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE membership != '0'" . $wereDateU, 0);
//        var_dump($data['total_paid_members']);die();
        $data['paid_members_today'] = $this->core->FirstField("SELECT COUNT(*) FROM entrypayment WHERE date > UNIX_TIMESTAMP(DATE_SUB( NOW(), INTERVAL 1 DAY ))", 0);
        $data['paid_members_yesterday'] = $this->core->FirstField("SELECT COUNT(*) FROM entrypayment WHERE date BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 DAY)) AND UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))", 0);
        $data['paid_members_this_month'] = $this->core->FirstField("SELECT COUNT(*) FROM entrypayment WHERE YEAR(FROM_UNIXTIME(date)) = YEAR(CURRENT_DATE) AND MONTH(FROM_UNIXTIME(date)) = MONTH(CURRENT_DATE)", 0);
        $data['paid_members_last_month'] = $this->core->FirstField("SELECT COUNT(*) FROM entrypayment WHERE YEAR(FROM_UNIXTIME(date)) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(FROM_UNIXTIME(date)) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)", 0);
        $data['visits_total'] = $this->core->FirstField("SELECT COUNT(*) FROM visitors" . $wereDate, 0);
        $data['visits_today'] = $this->core->FirstField("SELECT COUNT(*) FROM visitors WHERE date > DATE_SUB( NOW(), INTERVAL 1 DAY )", 0);
        $data['visits_yesterday'] = $this->core->FirstField("SELECT COUNT(*) FROM visitors WHERE date BETWEEN DATE_SUB(NOW(), INTERVAL 2 DAY) AND DATE_SUB(NOW(), INTERVAL 1 DAY)", 0);
        $data['visits_this_month'] = $this->core->FirstField("SELECT COUNT(*) FROM visitors WHERE YEAR(date) = YEAR(CURRENT_DATE) AND MONTH(date) = MONTH(CURRENT_DATE)", 0);
        $data['visits_last_month'] = $this->core->FirstField("SELECT COUNT(*) FROM visitors WHERE YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)", 0);
        $data['registered_total'] = $this->core->FirstField("SELECT COUNT(*) FROM members" . ($wereDateU ? str_replace_once('AND', 'WHERE', $wereDateU) : ''), 0);
        $data['registered_today'] = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE reg_date > UNIX_TIMESTAMP(DATE_SUB( NOW(), INTERVAL 1 DAY ))", 0);
        $data['registered_yesterday'] = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE reg_date BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 DAY)) AND UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))", 0);
        $data['registered_this_month'] = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE YEAR(FROM_UNIXTIME(reg_date)) = YEAR(CURRENT_DATE) AND MONTH(FROM_UNIXTIME(reg_date)) = MONTH(CURRENT_DATE)", 0);
        $data['registered_last_month'] = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE YEAR(FROM_UNIXTIME(reg_date)) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(FROM_UNIXTIME(reg_date)) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)", 0);

        $data['money_deposited_today'] = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE amount > 0 AND transaction_date > UNIX_TIMESTAMP(DATE_SUB( NOW(), INTERVAL 1 DAY ))", '0.00');
        $data['money_deposited_yesterday'] = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE amount > 0 AND  transaction_date BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 DAY)) AND UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))", '0.00');
        $data['money_deposited_this_month'] = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE amount > 0 AND  YEAR(FROM_UNIXTIME(transaction_date)) = YEAR(CURRENT_DATE) AND MONTH(FROM_UNIXTIME(transaction_date)) = MONTH(CURRENT_DATE)", '0.00');
        $data['money_deposited_last_month'] = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE amount > 0 AND  YEAR(FROM_UNIXTIME(transaction_date)) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(FROM_UNIXTIME(transaction_date)) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)", '0.00');
        $data['money_deposited_this_week'] = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE amount > 0 AND WEEK(FROM_UNIXTIME(transaction_date)) = WEEK(NOW()) AND YEAR(FROM_UNIXTIME(transaction_date)) = YEAR(NOW());", '0.00');
        $data['money_deposited_last_week'] = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE amount > 0 AND  WEEK(FROM_UNIXTIME(transaction_date)) = WEEK(NOW()) - 1 AND YEAR(FROM_UNIXTIME(transaction_date)) = YEAR(NOW());", '0.00');

        $data['total_money_processed'] = $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE amount > 0", '0.00');
        $data['total_commisions_paid'] = $this->core->FirstField("SELECT SUM(amount) FROM money_out WHERE status=1", '0.00');
        $data['pending_commisions'] = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout", '0.00');
        $data['pending_withdrawals'] = $this->core->FirstField("SELECT SUM(amount) FROM money_out WHERE status=0", '0.00');
        $data['withdrawals_completed'] = $this->core->FirstField("SELECT COUNT(*) FROM money_out WHERE status=1", 0);
        $data['withdrawals_amount'] = $this->core->FirstField("SELECT SUM(amount) FROM money_out WHERE status=1", 0);
        $data['deposit_completed'] = $this->core->FirstField("SELECT COUNT(*) FROM wallet_deposit WHERE amount > 0", 0);
        $data['today'] = date('m/d/y');
        $data['totalw'] = $this->core->FirstField("SELECT COUNT(*) FROM money_out WHERE status='0'", '0');
        $data['total_sponsors'] = $this->core->FirstField("SELECT COUNT(DISTINCT sponsor_id) FROM `members` WHERE `sponsor_id` > 0", '0');
        $row = $this->admin->db->query("SELECT * FROM members WHERE membership != '0' ORDER BY member_id DESC LIMIT 5");
        CoreHelp::setSession('balance', number_format($data['total_money_processed'] - $data['withdrawals_amount'], '2', '.', ''));
        $this->smarty->assign('lastmembers', $row);
        $row = $this->admin->db->query("SELECT sponsor_id,COUNT(sponsor_id) as b FROM members WHERE sponsor_id>0 group by sponsor_id ORDER BY b DESC LIMIT 5");
        $this->smarty->assign('topsponsor', $row);
        $row = $this->admin->db->query("SELECT * FROM members ORDER BY member_id DESC LIMIT 5");
        $this->smarty->assign('lastregister', $row);
        $row = $this->admin->db->query("SELECT * FROM admin_log ORDER BY id DESC LIMIT 10");
        $this->smarty->assign('last_admin_logs', $row);

        function insert_GetMember($id)
        {
            $key = $id[id];
            $result = iMVC_DB::queryFirstRow("SELECT * FROM members WHERE member_id=%d", $key);
            return $result;
        }

        function insert_getFlag($data)
        {
            $converter = new \ChibiFR\CountryConverter\Converter();
            $return['flag'] = file_exists('assets/common/images/flags/' . strtolower($data['country']) . '.png') ? '/' . 'assets/common/images/flags/' . strtolower($data['country']) . '.png' : '/' . 'assets/common/images/flags/' . 'europeanunion.png';
            $return['country_name'] = $data['country'] == "AA" ? 'Europe' : $converter->getCountryName($data['country']);
            return $return;
        }

        $this->smarty->assign('data', $data);
        $memberships = $this->admin->GetMemberships();
        $this->smarty->assign('memberships', $memberships);
        foreach ($memberships as $membership) {
            $count = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE membership='" . CoreHelp::sanitizeSQL($membership) . "'", 0);
            $mmm = $membership . '_count';
            $mem[$mmm] = $count;
            $this->smarty->assign('mem', $mem);
        }

        CoreHelp::setSession('menu', array(
            'main' => 'dashboard',
            'sub' => ''
        ));
        $this->smarty->display('index.tpl');
    }

    public function getLogin()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';
        if (CoreHelp::GetQuery('err') == 2) {
            $this->smarty->assign('login_error', 1);
        }
        $this->smarty->display('login.tpl');
    }

    public function postLogin()
    {
        CoreHelp::trackRetries('admin_login');
        $this->load->library('LoginSystem', 'loginSystem');
        $site_url = $this->admin->GetSiteSetting('site_url');
        if ($this->loginSystem->doLogin(CoreHelp::GetQuery('user'), CoreHelp::GetQuery('password'))) {
            CoreHelp::setSession('last_activity', time());
            CoreHelp::redirect('/admin/');
        } else {
            CoreHelp::setSession('error', 'Invalid login or password');
            CoreHelp::redirect('/admin/login/');
        }
    }

    public function getLogout()
    {
        $site_url = $this->admin->GetSiteSetting('site_url');
        $this->load->library('LoginSystem', 'loginSystem');
        $this->loginSystem->logout();
        session_destroy();
        CoreHelp::redirect('/admin/');
    }

    public function getSettings()
    {
        $this->admin->CheckLogin();


        $settings = $this->admin->GetSiteSettings();
        $this->smarty->template_dir = 'system/app/views/admin/';
        include("system/languages/lang.php");
        $this->smarty->assign('languages', $languages);
        $this->smarty->assign('site_url', $settings['site_url']);
        $this->smarty->assign('settings', $settings);
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'settings'
        ));
        $this->smarty->display('settings.tpl');
    }

    public function postSettings()
    {
        if (DEMO) {
            CoreHelp::setSession('error', 'Cannot save this setting in demo mode');
            CoreHelp::redirect('back');
        }
        $this->admin->CheckLogin();


        $this->admin->SetSetting('site_name', CoreHelp::GetQuery('site_name'));
        $this->admin->SetSetting('site_url', CoreHelp::GetQuery('site_url'));
        $this->admin->SetSetting('site_path', CoreHelp::GetQuery('site_path'));
        $this->admin->SetSetting('mailgate', CoreHelp::GetQuery('mailgate'));
        $this->admin->SetSetting('smtp_host', CoreHelp::GetQuery('smtp_host'));
        $this->admin->SetSetting('smtp_port', CoreHelp::GetQuery('smtp_port'));
        $this->admin->SetSetting('smtp_login', CoreHelp::GetQuery('smtp_login'));
        $this->admin->SetSetting('smtp_password', CoreHelp::GetQuery('smtp_password'));
        $this->admin->SetSetting('admin_lang', CoreHelp::GetQuery('admin_lang'));
        $this->admin->SetSetting('backoffice_lang', CoreHelp::GetQuery('backoffice_lang'));
        $this->admin->SetSetting('google_translator_admin', CoreHelp::GetQuery('google_translator_admin'));
        $this->admin->SetSetting('google_translator_member', CoreHelp::GetQuery('google_translator_member'));
        $this->admin->SetSetting('show_adverting_menu_member', CoreHelp::GetQuery('show_adverting_menu_member'));
        $this->admin->SetSetting('show_digital_menu_member', CoreHelp::GetQuery('show_digital_menu_member'));
        $this->admin->SetSetting('show_faq_menu_member', CoreHelp::GetQuery('show_faq_menu_member'));
        $this->admin->SetSetting('use_wordpress_bundle', CoreHelp::GetQuery('use_wordpress_bundle'));
        $this->admin->SetSetting('front_page_redirect_url', CoreHelp::GetQuery('front_page_redirect_url'));
        $this->admin->SetSetting('wordpress_admin_username', CoreHelp::GetQuery('wordpress_admin_username'));
        $this->smarty->assign('settings_saved', 'y');
        $settings = $this->admin->GetSiteSettings();
        $this->smarty->template_dir = 'system/app/views/admin/';
        include("system/languages/lang.php");
        $this->smarty->assign('languages', $languages);
        $this->smarty->assign('site_url', $settings['site_url']);
        $this->smarty->assign('settings', $settings);
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'settings'
        ));
        $this->smarty->display('settings.tpl');
    }

    public function getWithdrawalsettings()
    {
        $this->admin->CheckLogin();


        $settings = $this->admin->GetSiteSettings();
        $this->smarty->template_dir = 'system/app/views/admin/';
        include("system/languages/lang.php");
        $this->smarty->assign('languages', $languages);
        $this->smarty->assign('site_url', $settings['site_url']);
        $this->smarty->assign('settings', $settings);
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'withdrawalsettings'
        ));
        $this->smarty->display('withdrawalsettings.tpl');
    }

    public function postWithdrawalsettings()
    {
        $this->admin->CheckLogin();


        $this->admin->SetSetting('withdrawal_open_mon', (CoreHelp::GetQuery("withdrawal_open_mon") == "on") ? "1" : "0");
        $this->admin->SetSetting('withdrawal_open_tue', (CoreHelp::GetQuery("withdrawal_open_tue") == "on") ? "1" : "0");
        $this->admin->SetSetting('withdrawal_open_wed', (CoreHelp::GetQuery("withdrawal_open_wed") == "on") ? "1" : "0");
        $this->admin->SetSetting('withdrawal_open_thu', (CoreHelp::GetQuery("withdrawal_open_thu") == "on") ? "1" : "0");
        $this->admin->SetSetting('withdrawal_open_fri', (CoreHelp::GetQuery("withdrawal_open_fri") == "on") ? "1" : "0");
        $this->admin->SetSetting('withdrawal_open_sat', (CoreHelp::GetQuery("withdrawal_open_sat") == "on") ? "1" : "0");
        $this->admin->SetSetting('withdrawal_open_sun', (CoreHelp::GetQuery("withdrawal_open_sun") == "on") ? "1" : "0");
        $this->admin->SetSetting('commission_cashout_sum', number_format(CoreHelp::GetQuery('commission_cashout_sum'), 2, '.', ''));
        $this->admin->SetSetting('commission_cashout_fee', number_format(CoreHelp::GetQuery('commission_cashout_fee'), 2, '.', ''));
        CoreHelp::setSession('message', 'Withdrawal settings saved successfully');
        CoreHelp::redirect('back');
    }

    public function getAdminsettings()
    {
        $this->admin->CheckLogin();


        $settings = $this->admin->GetSiteSettings();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $admin_username = $this->admin->db->queryFirstField("SELECT username FROM admin_users WHERE id = 1");
        $this->smarty->assign('site_url', $settings['site_url']);
        $this->smarty->assign('admin_username', $admin_username);
        $this->smarty->assign('settings', $settings);
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'adminsettings'
        ));
        $this->smarty->display('adminsettings.tpl');
    }

    public function postAdminsettings()
    {
        if (DEMO) {
            CoreHelp::setSession('error', 'Cannot save this setting in demo mode');
            CoreHelp::redirect('back');
        }
        $this->admin->CheckLogin();


        $currentpassword = $this->admin->db->queryFirstField("SELECT password FROM admin_users WHERE id = 1");
        if ($currentpassword == hash('sha256', CoreHelp::GetQuery('currentadminpassword'))) {
            if (CoreHelp::GetQuery('newadminpassword') && CoreHelp::GetQuery('confirmadminpassword')) {
                if (CoreHelp::GetQuery('newadminpassword') == CoreHelp::GetQuery('confirmadminpassword')) {
                    $this->admin->db->query("UPDATE admin_users SET password = %s WHERE id = 1", hash('sha256', CoreHelp::GetQuery('newadminpassword')));
                } else {
                    $this->smarty->assign('error_new_password', '1');
                }
            }
            if (CoreHelp::GetQuery('adminuser')) {
                $this->admin->db->query("UPDATE admin_users SET username = %s WHERE id = 1", CoreHelp::GetQuery('adminuser'));
            }
            $this->admin->SetSetting('admin_email', CoreHelp::GetQuery('admin_email'));
            $this->admin->SetSetting('admin_inactivity', CoreHelp::GetQuery('admin_inactivity'));
            $this->smarty->assign('settings_saved', 'y');
        } else {
            $this->smarty->assign('error_current_password', '1');
        }
        $settings = $this->admin->GetSiteSettings();
        $admin_username = $this->admin->db->queryFirstField("SELECT username FROM admin_users WHERE id = 1");
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->smarty->assign('admin_username', $admin_username);
        $this->smarty->assign('site_url', $settings['site_url']);
        $this->smarty->assign('settings', $settings);
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'adminsettings'
        ));
        $this->smarty->display('adminsettings.tpl');
    }

    public function getMembershipsettings()
    {
        $this->admin->CheckLogin();
        if (CoreHelp::GetQuery('del', '')) {
            $this->admin->DeleteMembership(CoreHelp::GetQuery('del'));
            $this->smarty->assign('membership_deleted', 'y');
        }
        $memberships = $this->admin->GetMemberships();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'memberships',
            'sub' => 'membershipsettings'
        ));
        $this->smarty->display('membershipsettings.tpl');
    }

    public function postMembershipsettings()
    {
        $this->admin->CheckLogin();
        if (CoreHelp::GetQuery('addmembership', '')) {
            $this->admin->InsertMembership(str_replace(' ', '_', CoreHelp::GetQuery('addmembership')));
            $this->smarty->assign('membership_saved', 'y');
        }
        if (CoreHelp::GetQuery('submit')) {
            foreach (CoreHelp::GetQuery('membership') as $key => $value) {
                $this->admin->SaveMembership($key, $value);
            }
            $this->smarty->assign('membership_updated', 'y');
        }
        $memberships = $this->admin->GetMemberships();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'memberships',
            'sub' => 'membershipsettings'
        ));
        $this->smarty->display('membershipsettings.tpl');
    }

    public function getAffiliatesettings()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';
        $hCode = '';
        $is_hybrid = 0;
        $this->admin->CheckLogin();
        $settings = $this->admin->GetSiteSettings();
        $this->smarty->assign('settings', $settings);

        if (count($_SESSION['plan']) > 1) {
            foreach ($_SESSION['plan'] as $key => $value) {
                $plans[] = $key;
            }
            $hybrid = 'hybrid-' . implode('-', $plans);
            $hCode = '<option value="' . $hybrid . '" selected>' . $hybrid . '</option>';
            $is_hybrid = 1;
        }
        $this->smarty->assign('hybrid', $hCode);
        $this->smarty->assign('is_hybrid', $is_hybrid);
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'affiliatesettings'
        ));
        $this->smarty->display('affiliatesettings.tpl');
    }

    public function postAffiliatesettings()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();
        $this->admin->SetSetting('affiliate_type', CoreHelp::GetQuery('affiliate_type'));
        $this->admin->SetSetting('alert_commission', CoreHelp::GetQuery('alert_commission'));
        $this->admin->SetSetting('alert_downline', CoreHelp::GetQuery('alert_downline'));
        $this->admin->SetSetting('email_pending', CoreHelp::GetQuery('email_pending'));
        $this->admin->SetSetting('min_deposit', number_format(CoreHelp::GetQuery('min_deposit'), 2, '.', ''));
        $this->admin->SetSetting('processor_fee_by', CoreHelp::GetQuery('processor_fee_by'));
        CoreHelp::setSession('message', 'Affiliate settings saved successfully');
        CoreHelp::redirect('back');
    }

    public function getUnilevelsettings()
    {

        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();
        $memberships = $this->admin->GetMemberships();
        $settings = $this->admin->GetSiteSettings();
        $this->smarty->assign('settings', $settings);


        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'unilevelsettings'
        ));
        $this->smarty->display('unilevelsettings.tpl');
    }

    public function postUnilevelsettings()
    {

        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();
        $memberships = $this->admin->GetMemberships();
        foreach ($memberships as $membership) {
            $setting1 = $membership . '_commission_level_1';
            $this->admin->SetSetting($setting1, CoreHelp::GetQuery($setting1));
            $setting2 = $membership . '_commission_level_2';
            $this->admin->SetSetting($setting2, CoreHelp::GetQuery($setting2));
            $setting3 = $membership . '_commission_level_3';
            $this->admin->SetSetting($setting3, CoreHelp::GetQuery($setting3));
            $setting4 = $membership . '_commission_level_4';
            $this->admin->SetSetting("$setting4", CoreHelp::GetQuery($setting4));
            $setting5 = $membership . '_commission_level_5';
            $this->admin->SetSetting("$setting5", CoreHelp::GetQuery($setting5));
            $setting6 = $membership . '_commission_level_6';
            $this->admin->SetSetting("$setting6", CoreHelp::GetQuery($setting6));
            $setting7 = $membership . '_commission_level_7';
            $this->admin->SetSetting("$setting7", CoreHelp::GetQuery($setting7));
            $setting8 = $membership . '_commission_level_8';
            $this->admin->SetSetting("$setting8", CoreHelp::GetQuery($setting8));
            $setting9 = $membership . '_commission_level_9';
            $this->admin->SetSetting("$setting9", CoreHelp::GetQuery($setting9));
            $setting10 = $membership . '_commission_level_10';
            $this->admin->SetSetting("$setting10", CoreHelp::GetQuery($setting10));
            $settingx = $membership . '_unilevel_type';
            $this->admin->SetSetting($settingx, CoreHelp::GetQuery($settingx));
        }
        $this->smarty->assign('settings_saved', 'y');
        $settings = $this->admin->GetSiteSettings();
        $this->smarty->assign('settings', $settings);


        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'unilevelsettings'
        ));
        $this->smarty->display('unilevelsettings.tpl');
    }

    public function getSignupsettings()
    {

        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();
        $memberships = $this->admin->GetMemberships();
        $settings = $this->admin->GetSiteSettings();
        $this->smarty->assign('settings', $settings);


        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'memberships',
            'sub' => 'membershipsign'
        ));
        $this->smarty->display('signupsettings.tpl');
    }

    public function postSignupsettings()
    {

        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();
        $memberships = $this->admin->GetMemberships();
        $this->admin->SetSetting('signup_email_confirmation', CoreHelp::GetQuery('signup_email_confirmation'));
        $this->admin->SetSetting('signup_admin_aproval', CoreHelp::GetQuery('signup_admin_aproval'));
        $this->admin->SetSetting('signup_active', CoreHelp::GetQuery('signup_active'));
        $this->admin->SetSetting('signup_sponsor_required', CoreHelp::GetQuery('signup_sponsor_required'));
        foreach ($memberships as $membership) {
            $setting = $membership . '_signup_fee';
            $this->admin->SetSetting($setting, number_format(CoreHelp::GetQuery($setting), 2, '.', ''));
        }
        $this->smarty->assign('settings_saved', 'y');
        $settings = $this->admin->GetSiteSettings();
        $this->smarty->assign('settings', $settings);


        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'memberships',
            'sub' => 'membershipsign'
        ));
        $this->smarty->display('signupsettings.tpl');
    }

    public function getMembers()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->admin->CheckLogin();
        $this->admin->obj = 'members';
        $this->admin->orderDefault = 'member_id';
        $this->admin->RestoreState();
        $memberships = $this->admin->GetMemberships();
        if (CoreHelp::GetQuery('banid', '')) {
            if (DEMO) {
                CoreHelp::setSession('error', 'Can\'t ban a member in demo mode');
                CoreHelp::redirect('back');
            }
            $id = CoreHelp::GetQuery('banid');
            $this->admin->db->query("UPDATE members SET is_active='0', email='" . uniqid() . "@bannedmember', password = '111111111111' WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
            $this->smarty->assign('member_dissabled', 'y');
        }
        if (CoreHelp::GetQuery('payed') == 'yes') {
            $this->smarty->assign('payed', 'y');
        }
        if (CoreHelp::GetQuery('sendwelcome_id')) {
            $row = $this->admin->db->queryFirstRow('SELECT * FROM members WHERE member_id=%s', CoreHelp::GetQuery('sendwelcome_id'));
            $this->admin->db->queryFirstRow("UPDATE members SET is_active='1' WHERE member_id=%s", CoreHelp::GetQuery('sendwelcome_id'));
            $contactEmail = $this->admin->GetSiteSetting('admin_email');
            $thisSiteUrl = $this->admin->GetSiteSetting('site_url');
            $thisSiteTitle = $this->admin->GetSiteSetting('site_name');
            $emailHeader = 'From: ' . $contactEmail . "\r\n";
            $id = CoreHelp::GetQuery('sendwelcome_id');
            $firstName = $this->core->FirstField("SELECT first_name FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
            $lastName = $this->core->FirstField("SELECT last_name FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
            $sponsor_id = $this->core->FirstField("SELECT sponsor_id FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
            $username = $this->core->FirstField("SELECT username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
            $message = $this->core->FirstField("SELECT message FROM emailtemplates WHERE code='SendWelcomeEmail'");
            $thisSiteUrl = $this->admin->GetSiteSetting('site_url');
            $thisSiteTitle = $this->admin->GetSiteSetting('site_name');
            $message = preg_replace("/\[FirstName\]/", $firstName, $message);
            $message = preg_replace("/\[LastName\]/", $lastName, $message);
            $message = preg_replace("/\[SiteTitle\]/", $siteTitle, $message);
            $message = preg_replace("/\[SiteName\]/", $thisSiteTitle, $message);
            $message = preg_replace("/\[SiteUrl\]/", $thisSiteUrl, $message);
            $message = preg_replace("/\[AdminMail\]/", $this->contactEmai, $message);
            $message = preg_replace("/\[SponsorID\]/", $sponsor_id, $message);
            $message = preg_replace("/\[UserID\]/", $id, $message);
            $message = preg_replace("/\[Username\]/", $username, $message);
            $subject = $this->core->FirstField("SELECT subject FROM emailtemplates WHERE code='SendWelcomeEmail'");
            $subject = preg_replace("/\[FirstName\]/", $firstName, $subject);
            $subject = preg_replace("/\[LastName\]/", $lastName, $subject);
            $subject = preg_replace("/\[SiteTitle\]/", $siteTitle, $subject);
            $subject = preg_replace("/\[SiteName\]/", $thisSiteTitle, $subject);
            $subject = preg_replace("/\[SiteUrl\]/", $thisSiteUrl, $subject);
            $subject = preg_replace("/\[AdminMail\]/", $this->contactEmai, $subject);
            $message = preg_replace("/\[SponsorID\]/", $sponsor_id, $message);
            $message = preg_replace("/\[UserID\]/", $id, $message);
            $message = preg_replace("/\[Username\]/", $username, $message);
            CoreHelp::sendMail($row['email'], $subject, $message, $emailHeader);
            $this->smarty->assign('welcome_sent', 'y');
        }
        $searchList = array(
            'Search parameter..' => '',
            'Membership' => 'membership',
            'Member ID' => 'member_id',
            'Username' => 'username',
            'Email' => 'email',
            'First Name' => 'first_name',
            'Last Name' => 'last_name',
            'Address' => 'street',
            'City' => 'city',
            'State' => 'state',
            'Country' => 'country',
            'Postal Code' => 'postal',
            'Phone' => 'phone',
            'Sponsor ID' => 'sponsor_id',
            'Manager ID' => 'manager_id',
            'Agent ID' => 'agent_id',
        );

        $filterDateBegin = $this->admin->GetStateValue('filterDateBegin', 0);
        $filterDateEnd = $this->admin->GetStateValue('filterDateEnd', 0);
        $s_field = $this->admin->GetStateValue('s_field', '');
        $s_line = $this->admin->GetStateValue('s_line', '');
        if ($s_field != '' AND $s_line != '') {
            if (count($_GET) > 1) {
                $noLike = ['member_id', 'sponsor_id', 'manager_id', 'agent_id'];
                $sql_select .= (!in_array($s_field, $noLike)) ? " AND $s_field LIKE '%$s_line%'" : " AND $s_field='" . CoreHelp::sanitizeSQL($s_line) . "'";
            } else {
                $this->admin->SaveStateValue('s_line', '');
                $this->admin->SaveStateValue('s_field', '');
            }
        }
        $filterDateDayBegin = ($filterDateBegin != 0) ? date('d', $filterDateBegin) : '';
        $filterDateMonthBegin = ($filterDateBegin != 0) ? date('m', $filterDateBegin) : '';
        $filterDateYearBegin = ($filterDateBegin != 0) ? date('Y', $filterDateBegin) : date('Y', time()) - 1;
        $filterDateDayEnd = ($filterDateEnd != 0) ? date('d', $filterDateEnd) : '';
        $filterDateMonthEnd = ($filterDateEnd != 0) ? date('m', $filterDateEnd) : '';
        $filterDateYearEnd = ($filterDateEnd != 0) ? date('Y', $filterDateEnd) : '';
        if ($filterDateBegin != 0) {
            $sql_select .= " AND reg_date>$filterDateBegin AND reg_date<$filterDateEnd";
        }
        $filter = '';
        $filter .= 'Date FROM ';
        $filter .= $this->admin->getDaySelect($filterDateDayBegin, 'filterDateDayBegin');
        $filter .= $this->admin->getMonthSelect($filterDateMonthBegin, 'filterDateMonthBegin');
        $filter .= $this->admin->getYearSelect($filterDateYearBegin, 'filterDateYearBegin');
        $filter .= ' to ';
        $filter .= $this->admin->getDaySelect($filterDateDayEnd, 'filterDateDayEnd');
        $filter .= $this->admin->getMonthSelect($filterDateMonthEnd, 'filterDateMonthEnd');
        $filter .= $this->admin->getYearSelect($filterDateYearEnd, 'filterDateYearEnd');
        echo "<!-- SELECT COUNT(*) FROM members WHERE 1 $sql_select -->\n";
        $total = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE 1 $sql_select", 0);
        $SELECT = $this->admin->selectSearch($searchList, CoreHelp::GetQuery('s_field'));
        $this->admin->pageUrl = '/admin/members/';
        $this->admin->siteUrl = $site_url;
        $this->admin->rowsOptions = array(
            10,
            20,
            30,
            50
        );
        //$this->admin->rowsPerPage = 10;
        $this->headerdata = array(
            'HEAD_MEMBER_ID' => $this->admin->Header_GetSortLink('member_id', 'ID'),
            'HEAD_USERNAME' => $this->admin->Header_GetSortLink('username', 'Username'),
            'HEAD_FIRST_NAME' => $this->admin->Header_GetSortLink('first_name', 'First name'),
            'HEAD_LAST_NAME' => $this->admin->Header_GetSortLink('last_name', 'Last name'),
            'HEAD_REG_DATE' => $this->admin->Header_GetSortLink('reg_date', 'Registration date'),
            'HEAD_EMAIL' => $this->admin->Header_GetSortLink('email', 'E-mail'),
            'HEAD_SPONSOR' => $this->admin->Header_GetSortLink('sponsor_id', "Sponsor's ID"),
            'HEAD_EARNINGS' => $this->admin->Header_GetSortLink('all_cash', 'Earnings'),
            'HEAD_MEMBERSHIP' => $this->admin->Header_GetSortLink('membership', 'Membership'),
            'HEAD_LEVEL' => "<a href='#'><b>Status</b></a>",
            'HEAD_REFERRER' => $this->admin->Header_GetSortLink('referer', 'Referer'),
            'HEAD_ACTIVE' => $this->admin->Header_GetSortLink('is_active', 'Active'),
            'HEAD_MATRIXES' => $h_m,
            'ALL_COL' => $a_c,
            'PAGINATION' => $this->admin->Pages_GetLinks($total, '/admin/members/&')
        );
        if ($total > 0) {
            if (!isset($this->admin->orderBy)) {
                $this->admin->orderBy = $this->admin->orderDefault;
            }
            $limit = $this->admin->rowsPerPage;
            $offset = ($this->admin->currentPage - 1) * $this->admin->rowsPerPage;
            $sql_select2 .= " LIMIT $offset,$limit";
            echo "<!-- SELECT a. * , SUM( b.amount ) all_cash FROM members a LEFT JOIN wallet_payout b ON a.member_id = b.to_id WHERE 1 $sql_select GROUP BY a.member_id ORDER BY {$this->admin->orderBy} {$this->admin->orderDir} $sql_select2 -->\n";
            $result = $this->admin->db->query("SELECT a. * , SUM( b.amount ) all_cash FROM members a LEFT JOIN wallet_payout b ON a.member_id = b.to_id WHERE 1 $sql_select GROUP BY a.member_id ORDER BY {$this->admin->orderBy} {$this->admin->orderDir} $sql_select2");
            foreach ($result as $row) {
                $member_id = $row['member_id'];
                $username = $this->admin->dec($row['username']);
                $firstname = $this->admin->dec($row['first_name']);
                $lastname = $this->admin->dec($row['last_name']);
                $is_active = $this->admin->dec($row['is_active']);
                $membership = $this->admin->dec($row['membership']);
                $earnings = $row['all_cash'];
                if ($earnings == '') {
                    $earnings = '0.00';
                }
                $email = $this->admin->dec($row['email']);
                $sponsor_id = $row['sponsor_id'];
                if ($sponsor_id == 0) {
                    $sponsor_id = 'System';
                }
                if ($member_id == 1) {
                    $referrer_id = '&nbsp;';
                    //  $sponsor_id = "&nbsp;";
                }
                if ($is_active == 1) {
                    $active = 'Yes';
                } else {
                    $active = 'No';
                }
                if ($row['membership'] == '0') {
                    $status = 'Unpaid';
                } else {
                    if ($row['membership_expiration'] > 0 && $row['membership_expiration'] < time()) {
                        $status = 'Unpaid';
                    } else {
                        $status = 'Paid';
                    }
                }
                \tmvc::instance()->controller->load->plugin_model('Ranks_Model', 'ranks');
                $rank_data = \tmvc::instance()->controller->ranks->getRankData($member_id);
                $this->data['TABLE_ROW'][] = array(
                    'ROW_MEMBER_ID' => $member_id,
                    'ROW_FIRST_NAME' => $firstname,
                    'ROW_LAST_NAME' => $lastname,
                    'ROW_EMAIL' => '<a href=mailto:' . $email . '>' . $email . '</a>',
                    'MEMBERSHIP' => $membership,
                    'ROW_SPONSOR' => $sponsor_id,
                    'ROW_EARNINGS' => $earnings,
                    'ROW_LEVEL' => $status,
                    'ROW_ACTIVELINK' => $activeLink,
                    'ROW_EDITLINK' => $editLink,
                    'ROW_DELLINK' => $delLink,
                    'SEND_WELCOME' => $sendwelcome,
                    'ROW_PAYLINK' => $payLink,
                    'ROW_USERNAME' => $username,
                    'ROW_ACTIVE' => $active,
                    'ROW_RANK' => $rank_data['current_rank'],
                );
            }
        }
        $this->smarty->assign('memberships', $memberships);
        $topmem = $this->core->FirstField('SELECT id FROM memberships ORDER BY id DESC', 0);
        $this->smarty->assign('topmem', $topmem);
        $this->smarty->assign('header', $this->headerdata);
        $this->smarty->assign('filter', $select);
        $this->smarty->assign('select', $SELECT);
        $this->smarty->assign('dates', $filter);
        $this->smarty->assign('members', $this->data['TABLE_ROW']);
        function insert_GetMembershipID($id)
        {
            $key = $id[id];
            $result = iMVC_DB::queryFirstRow('SELECT id FROM memberships WHERE membership=%s', $key);

            return $result;
        }

        CoreHelp::setSession('menu', array(
            'main' => 'members',
            'sub' => 'memberlist'
        ));
        $this->smarty->display('members.tpl');
    }

    public function postMembers()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();
        $this->admin->obj = 'members';
        $this->admin->orderDefault = 'member_id';
        $this->admin->RestoreState();

        $memberships = $this->admin->GetMemberships();

        $searchList = array(
            'Search parameter..' => '',
            'Membership' => 'membership',
            'Member ID' => 'member_id',
            'Username' => 'username',
            'Email' => 'email',
            'First Name' => 'first_name',
            'Last Name' => 'last_name',
            'Address' => 'street',
            'City' => 'city',
            'State' => 'state',
            'Country' => 'country',
            'Postal Code' => 'postal',
            'Phone' => 'phone',
            'Sponsor ID' => 'sponsor_id',
            'Manager ID' => 'manager_id',
            'Agent ID' => 'agent_id',
        );

        $s_line = $this->admin->enc(CoreHelp::GetQuery('s_line', ''));
        $s_field = $this->admin->enc(CoreHelp::GetQuery('s_field', ''));
        $filterDateDayBegin = CoreHelp::GetQuery('filterDateDayBegin');
        $filterDateMonthBegin = CoreHelp::GetQuery('filterDateMonthBegin');
        $filterDateYearBegin = CoreHelp::GetQuery('filterDateYearBegin');
        $filterDateDayEnd = CoreHelp::GetQuery('filterDateDayEnd');
        $filterDateMonthEnd = CoreHelp::GetQuery('filterDateMonthEnd');
        $filterDateYearEnd = CoreHelp::GetQuery('filterDateYearEnd');
        $this->admin->SaveStateValue('filterDateBegin', mktime(0, 0, 0, $filterDateMonthBegin, $filterDateDayBegin, $filterDateYearBegin));
        $this->admin->SaveStateValue('filterDateEnd', mktime(23, 59, 59, $filterDateMonthEnd, $filterDateDayEnd, $filterDateYearEnd));
        $this->admin->SaveStateValue('s_line', $s_line);
        $this->admin->SaveStateValue('s_field', $s_field);

        $filterDateBegin = $this->admin->GetStateValue('filterDateBegin', 0);
        $filterDateEnd = $this->admin->GetStateValue('filterDateEnd', 0);
        $s_field = $this->admin->GetStateValue('s_field', '');
        $s_line = $this->admin->GetStateValue('s_line', '');
        if ($s_field != '' AND $s_line != '') {
            $noLike = ['member_id', 'sponsor_id', 'manager_id', 'agent_id'];
            $sql_select .= (!in_array($s_field, $noLike)) ? " AND $s_field LIKE '%$s_line%'" : " AND $s_field='" . CoreHelp::sanitizeSQL($s_line) . "'";
        }
        $filterDateDayBegin = ($filterDateBegin != 0) ? date('d', $filterDateBegin) : '';
        $filterDateMonthBegin = ($filterDateBegin != 0) ? date('m', $filterDateBegin) : '';
        $filterDateYearBegin = ($filterDateBegin != 0) ? date('Y', $filterDateBegin) : date('Y', time()) - 1;
        $filterDateDayEnd = ($filterDateEnd != 0) ? date('d', $filterDateEnd) : '';
        $filterDateMonthEnd = ($filterDateEnd != 0) ? date('m', $filterDateEnd) : '';
        $filterDateYearEnd = ($filterDateEnd != 0) ? date('Y', $filterDateEnd) : '';
        if ($filterDateBegin != 0) {
            $sql_select .= " AND reg_date>$filterDateBegin AND reg_date<$filterDateEnd";
        }
        $filter = '';
        $filter .= 'Date FROM ';
        $filter .= $this->admin->getDaySelect($filterDateDayBegin, 'filterDateDayBegin');
        $filter .= $this->admin->getMonthSelect($filterDateMonthBegin, 'filterDateMonthBegin');
        $filter .= $this->admin->getYearSelect($filterDateYearBegin, 'filterDateYearBegin');
        $filter .= ' to ';
        $filter .= $this->admin->getDaySelect($filterDateDayEnd, 'filterDateDayEnd');
        $filter .= $this->admin->getMonthSelect($filterDateMonthEnd, 'filterDateMonthEnd');
        $filter .= $this->admin->getYearSelect($filterDateYearEnd, 'filterDateYearEnd');
        $total = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE 1 $sql_select", 0);
        $SELECT = $this->admin->selectSearch($searchList, CoreHelp::GetQuery('s_field'));
        $this->admin->pageUrl = $site_url . '/admin/members/';
        $this->admin->siteUrl = $site_url;
        $this->admin->rowsOptions = array(
            10,
            20,
            30,
            50
        );
        //$this->admin->rowsPerPage = 10;
        $this->headerdata = array(
            'HEAD_MEMBER_ID' => $this->admin->Header_GetSortLink('member_id', 'ID'),
            'HEAD_USERNAME' => $this->admin->Header_GetSortLink('username', 'Username'),
            'HEAD_FIRST_NAME' => $this->admin->Header_GetSortLink('first_name', 'First name'),
            'HEAD_LAST_NAME' => $this->admin->Header_GetSortLink('last_name', 'Last name'),
            'HEAD_REG_DATE' => $this->admin->Header_GetSortLink('reg_date', 'Registration date'),
            'HEAD_EMAIL' => $this->admin->Header_GetSortLink('email', 'E-mail'),
            'HEAD_SPONSOR' => $this->admin->Header_GetSortLink('sponsor_id', "Sponsor's ID"),
            'HEAD_EARNINGS' => $this->admin->Header_GetSortLink('all_cash', 'Earnings'),
            'HEAD_MEMBERSHIP' => $this->admin->Header_GetSortLink('membership', 'Membership'),
            'HEAD_LEVEL' => "<a href='#'><b>Status</b></a>",
            'HEAD_REFERRER' => $this->admin->Header_GetSortLink('referer', 'Referer'),
            'HEAD_ACTIVE' => $this->admin->Header_GetSortLink('is_active', 'Active'),
            'HEAD_MATRIXES' => $h_m,
            'ALL_COL' => $a_c,
            'PAGINATION' => $this->admin->Pages_GetLinks($total, $this->admin->siteUrl . 'admin/members/&'),
        );
        if ($total > 0) {
            if (!isset($this->admin->orderBy)) {
                $this->admin->orderBy = $this->admin->orderDefault;
            }
            $limit = $this->admin->rowsPerPage;
            $offset = ($this->admin->currentPage - 1) * $this->admin->rowsPerPage;
            $sql_select2 .= " LIMIT $offset,$limit";
            //echo "SELECT a. * , SUM( b.amount ) all_cash FROM members a LEFT JOIN wallet_payout b ON a.member_id = b.to_id WHERE 1 $sql_select GROUP BY a.member_id ORDER BY {$this->admin->orderBy} {$this->admin->orderDir} $sql_select2"; exit;
            $result = $this->admin->db->query("SELECT a. * , SUM( b.amount ) all_cash FROM members a LEFT JOIN wallet_payout b ON a.member_id = b.to_id WHERE 1 $sql_select GROUP BY a.member_id ORDER BY {$this->admin->orderBy} {$this->admin->orderDir} $sql_select2");
            foreach ($result as $row) {
                $member_id = $row['member_id'];
                $username = $this->admin->dec($row['username']);
                $firstname = $this->admin->dec($row['first_name']);
                $lastname = $this->admin->dec($row['last_name']);
                $is_active = $this->admin->dec($row['is_active']);
                $membership = $this->admin->dec($row['membership']);
                $earnings = $row['all_cash'];
                if ($earnings == '') {
                    $earnings = '0.00';
                }
                $email = $this->admin->dec($row['email']);
                $sponsor_id = $row['sponsor_id'];
                if ($sponsor_id == 0) {
                    $sponsor_id = 'System';
                }
                if ($member_id == 1) {
                    $referrer_id = '&nbsp;';
                }
                if ($is_active == 1) {
                    $active = 'Yes';
                } else {
                    $active = 'No';
                }
                $entrypayment = $this->core->FirstField("SELECT COUNT(*) FROM entrypayment WHERE member_id='" . CoreHelp::sanitizeSQL($member_id) . "'", 0);
                if ($entrypayment == 0) {
                    $status = 'Unpaid';
                } else {
                    $status = 'Paid';
                }
                \tmvc::instance()->controller->load->plugin_model('Ranks_Model', 'ranks');
                $rank_data = \tmvc::instance()->controller->ranks->getRankData($member_id);
                $this->data['TABLE_ROW'][] = array(
                    'ROW_MEMBER_ID' => $member_id,
                    'ROW_FIRST_NAME' => $firstname,
                    'ROW_LAST_NAME' => $lastname,
                    'ROW_EMAIL' => '<a href=mailto:' . $email . '>' . $email . '</a>',
                    'MEMBERSHIP' => $membership,
                    'ROW_SPONSOR' => $sponsor_id,
                    'ROW_EARNINGS' => $earnings,
                    'ROW_LEVEL' => $status,
                    'ROW_ACTIVELINK' => $activeLink,
                    'ROW_EDITLINK' => $editLink,
                    'ROW_DELLINK' => $delLink,
                    'SEND_WELCOME' => $sendwelcome,
                    'ROW_PAYLINK' => $payLink,
                    'ROW_USERNAME' => $username,
                    'ROW_ACTIVE' => $active,
                    'ROW_RANK' => $rank_data['current_rank'],
                );
            }
        }
        $this->smarty->assign('memberships', $memberships);
        $topmem = $this->core->FirstField('SELECT id FROM memberships ORDER BY id DESC', 0);
        $this->smarty->assign('topmem', $topmem);
        $this->smarty->assign('header', $this->headerdata);
        $this->smarty->assign('filter', $select);
        $this->smarty->assign('select', $SELECT);
        $this->smarty->assign('dates', $filter);
        $this->smarty->assign('members', $this->data['TABLE_ROW']);
        function insert_GetMembershipID($id)
        {
            $key = $id[id];
            $result = iMVC_DB::queryFirstRow('SELECT id FROM memberships WHERE membership=%s', $key);

            return $result;
        }

        CoreHelp::setSession('menu', array(
            'main' => 'members',
            'sub' => 'memberlist'
        ));
        $this->smarty->display('members.tpl');
    }

    public function getAddmember()
    {

        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();


        $processors = $this->admin->db->query("SELECT * FROM payment_processors WHERE active_withdrawal='1'");
        $this->smarty->assign('processors', $processors);
        $this->smarty->assign("countries", $this->member->db->query("SELECT code,name AS country FROM countries ORDER BY name ASC"));
        CoreHelp::setSession('menu', array(
            'main' => 'members',
            'sub' => 'addmember'
        ));
        $this->smarty->display('addmember.tpl');
    }

    public function postAddmember()
    {

        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();
        $member_id = null;
        $lastName = $this->admin->enc(CoreHelp::GetValidQuery('lastName', 'Last name', VALIDATE_NOT_EMPTY));
        $firstName = $this->admin->enc(CoreHelp::GetValidQuery('firstName', 'First Name', VALIDATE_NOT_EMPTY));
        $username = $this->admin->enc(CoreHelp::GetValidQuery('username', 'Username', VALIDATE_USERNAME));
        $street = $this->admin->enc(CoreHelp::GetValidQuery('street', 'Address', VALIDATE_NOT_EMPTY));
        $city = $this->admin->enc(CoreHelp::GetValidQuery('city', 'City', VALIDATE_NOT_EMPTY));
        $state = $this->admin->enc(CoreHelp::GetValidQuery('state', 'State', VALIDATE_NOT_EMPTY));
        $country = $this->admin->enc(CoreHelp::GetValidQuery('country', 'Country', VALIDATE_NOT_EMPTY));
        $postal = $this->admin->enc(CoreHelp::GetValidQuery('postal', 'Postal Code', VALIDATE_NOT_EMPTY));
        $phone = $this->admin->enc(CoreHelp::GetValidQuery('phone', 'Phone', VALIDATE_NOT_EMPTY));
        $password = CoreHelp::GetValidQuery('password', 'Password', VALIDATE_PASSWORD);
        $email = CoreHelp::GetValidQuery('email', 'Email', VALIDATE_EMAIL);
        $sponsor = CoreHelp::GetQuery('sponsor', 0);
        $processor = CoreHelp::GetQuery('processor', 0);
        $accountid = CoreHelp::GetQuery('account_id');
        $sponsor = CoreHelp::GetQuery('sponsor');
        $Tax_Pass = CoreHelp::GetQuery('Tax_Pass', '');
        $Tax_User = CoreHelp::GetQuery('Tax_User', '');
        $Tax_email = CoreHelp::GetQuery('Tax_email', '');
        $Tax_Agency = CoreHelp::GetQuery('Tax_Agency', '');

        $total = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsor) . "' AND is_active=1", 0);
        $firstmember = $this->core->FirstField("SELECT member_id FROM members WHERE member_id='1'", 0);
        if ($firstmember != 0) {
            if (CoreHelp::GetQuery('sponsor') != '' && is_numeric(CoreHelp::GetQuery('sponsor')) && $total > 0) {
                $sponsor_id = CoreHelp::GetQuery('enroller');
            } else {
                CoreHelp::setError('enroller', 'Selected sponsor id does not exist or is inactive.');
            }
            if (CoreHelp::getCountErrors() == 0) {
                $this->count = $this->admin->db->queryFirstField('SELECT COUNT(*) FROM members WHERE username=%s', $username);
                if ($this->count > 0) {
                    CoreHelp::setError('username', 'This Username already exists. Please choose another.');
                }
                $this->count = $this->admin->db->queryFirstField('SELECT COUNT(*) FROM members WHERE email=%s', $email);
                if ($this->count > 0) {
                    CoreHelp::setError('email', 'This Email already exists. Please choose another.');
                }
            }
        } else {
            $sponsor = '0';
        }
        if (CoreHelp::getCountErrors() > 0) {
            $this->smarty->assign('errors', CoreHelp::getErrors());
        } else {
            $contactEmail = $this->admin->GetSiteSetting('admin_email');
            $thisSiteUrl = $this->admin->GetSiteSetting('site_url');
            $thisSiteTitle = $this->admin->GetSiteSetting('site_name');
            $regdate = time();
            $phone = str_replace('+', '', $phone);
            $phone = str_replace(' ', '', $phone);
            $this->admin->db->insert('members', array(
                'username' => $username,
                'email' => $email,
                'password' => hash('sha256', $password),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'sponsor_id' => $sponsor,
                'reg_date' => $regdate,
                'is_active' => '1',
                'street' => $street,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'postal' => $postal,
                'phone' => $phone,
                'processor' => $processor,
                'account_id' => $accountid,
                'membership' => '0',
                'Tax_Pass' => $Tax_Pass,
                'Tax_User' => $Tax_User,
                'Tax_email' => $Tax_email,
                'Tax_Agency' => $Tax_Agency
            ));
            $id = $this->admin->db->insertId();
            $this->hooks->do_action('after_signup', $id);
            $message = "Your Seancarempcs username: $username, Your password: $password";
            $this->hooks->do_action('send_welcome_sms', $phone, $message);
            if ($this->admin->GetSiteSetting('settings_matrix_allow_free') == 'yes') {
                $this->hooks->do_action('in_matrix', $id);
            }

            $this->admin->db->query("INSERT INTO admin_log (admin_username, ip_address, country, date, description, flag) VALUES ('" . $_SESSION['userName'] . "', '" . CoreHelp::getIp() . "', '" . CoreHelp::getCountryCode(CoreHelp::getIp()) . "', NOW(), 'Added member into the system with username: " . $username . "', 1)");

            CoreHelp::emailWelcome($id);
            CoreHelp::emailNewReferral($id);
            $this->smarty->assign('member_added', 'y');
        }


        $processors = $this->admin->db->query("SELECT * FROM payment_processors WHERE active_withdrawal='1'");
        $this->smarty->assign('processors', $processors);
        $this->smarty->assign("countries", $this->member->db->query("SELECT code,name AS country FROM countries ORDER BY name ASC"));
        CoreHelp::setSession('menu', array(
            'main' => 'members',
            'sub' => 'addmember'
        ));
        $this->smarty->display('addmember.tpl');
    }

    public function getEditmember()
    {

        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();
        $row = $this->admin->db->queryFirstRow('SELECT * FROM members WHERE member_id=%d', CoreHelp::GetQuery('id'));


        $this->smarty->assign('member', $row);
        $processors = $this->admin->db->query("SELECT * FROM payment_processors WHERE active_withdrawal='1'");
        $this->smarty->assign('processors', $processors);
        $memberID = CoreHelp::GetQuery('id');
        $notes = $this->admin->db->query("SELECT * FROM member_log WHERE  member_id=" . $memberID . "");
        $this->smarty->assign('notes', $notes);
        if (!$memberID) {
            $memberID = CoreHelp::GetQuery('member_id');
        }
        $profile = $this->member->getProfile($memberID);
        $this->smarty->assign('name', $profile['first_name'] . ' ' . $profile['last_name']);
        $this->smarty->assign('year', date('Y', time()));
        $this->smarty->assign('domain', $_SERVER['HTTP_HOST']);
        $this->smarty->assign('member_id', $profile['member_id']);
        $this->smarty->assign('username', $profile['username']);
        $this->smarty->assign('membership', $profile['membership']);
        $this->smarty->assign('reg_date', date('D M j G:i Y', $profile['reg_date']));
        $this->smarty->assign('year', date('Y', time()));
        $this->smarty->assign('domain', $_SERVER['HTTP_HOST']);


        $this->smarty->assign('sponsor', $profile['sponsor_id']);
        //more
        $m_level = $profile['m_level'];
        $total_sponsored = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberID) . "'", 0);
        $this->smarty->assign('total_sponsored', $total_sponsored);
        $total_pending = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberID) . "'", 0);
        $this->smarty->assign('total_pending', $total_pending);
        $money_available = $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($memberID) . "'", '0.00');
        $this->smarty->assign('money_available', '$' . $money_available);
        $money_withdrawed = $this->core->FirstField("SELECT SUM(amount) FROM money_out WHERE member_id='" . CoreHelp::sanitizeSQL($memberID) . "'", '0.00');
        $money_earned = number_format($money_withdrawed + $money_available, 2, '.', '');
        $this->smarty->assign('money_earned', '$' . $money_earned);
        $time = time();
        $date_span = $time - 86400; // 1 day
        $sponsored_today = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberID) . "' AND reg_date>$date_span", 0);
        $this->smarty->assign('sponsored_today', $sponsored_today);
        $date_span = $time - 604800; // 7 day
        $sponsored_this_week = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberID) . "' AND reg_date>$date_span", 0);
        $this->smarty->assign('sponsored_this_week', $sponsored_this_week);
        $date_span = $time - 604800; // 7 day
        $date_span2 = $time - 1205600; // 14 day
        $sponsored_last_week = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberID) . "' AND $date_span>reg_date>$date_span2", 0);
        $this->smarty->assign('sponsored_last_week', $sponsored_last_week);
        $date_span = $time - 2592000; // 30 day
        $sponsored_this_month = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE sponsor_id='" . CoreHelp::sanitizeSQL($memberID) . "' AND reg_date>$date_span", 0);
        $this->smarty->assign('sponsored_this_month', $sponsored_this_month);
        $referal_hits = $this->core->FirstField("SELECT hit_counter FROM hits WHERE member_id='" . CoreHelp::sanitizeSQL($memberID) . "'", '0');
        $this->smarty->assign('referal_hits', $referal_hits);
        CoreHelp::setSession('menu', array(
            'main' => 'members',
            'sub' => 'memberlist'
        ));
        $this->smarty->display('editmember.tpl');
    }

    public function postEditmember()
    {
        if (DEMO) {
            CoreHelp::setSession('error', 'Cannot save this setting in demo mode');
            CoreHelp::redirect('back');
        }
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();
        $member = $this->admin->db->queryFirstRow('SELECT * FROM members WHERE member_id=%d', CoreHelp::GetQuery('member_id'));
        $member_id = $this->admin->enc(CoreHelp::GetValidQuery('member_id', 'Member ID', VALIDATE_NOT_EMPTY));
        $lastName = $this->admin->enc(CoreHelp::GetValidQuery('lastName', 'Last name', VALIDATE_NOT_EMPTY));
        $firstName = $this->admin->enc(CoreHelp::GetValidQuery('firstName', 'First Name', VALIDATE_NOT_EMPTY));
        $email = CoreHelp::GetValidQuery('email', 'Email', VALIDATE_EMAIL);
        $username = $this->admin->enc(CoreHelp::GetValidQuery('username', 'Username', VALIDATE_USERNAME));
        $password = strlen(CoreHelp::GetQuery('password')) > 0 ? CoreHelp::GetValidQuery('password', 'Password', VALIDATE_PASSWORD) : $member['password'];
        $sponsor = CoreHelp::GetQuery('sponsor', 1);
        $agent = CoreHelp::GetQuery('agent', 0);
        $manager = CoreHelp::GetQuery('manager', 0);
        $street = $this->admin->enc(CoreHelp::GetQuery('street', '--'));
        $city = $this->admin->enc(CoreHelp::GetQuery('city', '--'));
        $state = $this->admin->enc(CoreHelp::GetQuery('state', '--'));
        $country = $this->admin->enc(CoreHelp::GetQuery('country', '--'));
        $postal = $this->admin->enc(CoreHelp::GetQuery('postal', '--'));
        $phone = $this->admin->enc(CoreHelp::GetQuery('phone', '--'));
        $membership = $this->admin->enc(CoreHelp::GetValidQuery('membership', 'Membership', VALIDATE_NOT_EMPTY));
        $processor = CoreHelp::GetQuery('processor', 0);
        $Tax_Pass = CoreHelp::GetQuery('Tax_Pass', '');
        $Tax_User = CoreHelp::GetQuery('Tax_User', '');
        $Tax_email = CoreHelp::GetQuery('Tax_email', '');
        $Tax_Agency = CoreHelp::GetQuery('Tax_Agency', '');
        $accountid = CoreHelp::GetQuery('account_id');
        $total = $this->core->FirstField("SELECT COUNT(*) FROM members WHERE member_id='" . $sponsor . "'", 0);
        if ($member_id != '1') {
            if ($sponsor != '' && is_numeric($sponsor) && $total > 0 && $sponsor < $member_id) {
                $sponsor_id = $sponsor;
            } else {
                CoreHelp::setError('enroller', 'Selected sponsor id is not valid. Please choose another.');
            }
        } else {
            $sponsor_id = '0';
        }
        if (CoreHelp::getCountErrors() > 0) {
            CoreHelp::setSession('error', CoreHelp::getErrors());
            CoreHelp::redirect('back');
        } else {
            $contactEmail = $this->admin->GetSiteSetting('admin_email');
            $thisSiteUrl = $this->admin->GetSiteSetting('site_url');
            $thisSiteTitle = $this->admin->GetSiteSetting('site_name');
            $membership = str_replace(' ', '_', $membership);
            $regdate = time();
            $this->admin->db->update('members', array(
                'username' => $username,
                'email' => $email,
                'password' => strlen(CoreHelp::GetQuery('password')) > 0 ? hash('sha256', $password) : $password,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'sponsor_id' => $sponsor_id,
                'agent_id' => (int)$agent,
                'manager_id' => (int)$manager,
//                'reg_date' => $regdate,
                'is_active' => '1',
                'street' => $street,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'postal' => $postal,
                'phone' => $phone,
                'processor' => $processor,
                'account_id' => $accountid,
                'membership' => $membership,
                'Tax_Pass' => $Tax_Pass,
                'Tax_User' => $Tax_User,
                'Tax_email' => $Tax_email,
                'Tax_Agency' => $Tax_Agency
            ), 'member_id=%d', $member_id);
            $this->smarty->assign('member_edited', 'y');
            $this->admin->db->query("INSERT INTO admin_log (admin_username, ip_address, country, date, description, flag) VALUES ('" . $_SESSION['userName'] . "', '" . CoreHelp::getIp() . "', '" . CoreHelp::getCountryCode(CoreHelp::getIp()) . "', NOW(), 'Edited member with username: " . $username . "', 1)");
            CoreHelp::setSession('message', 'Member edited successfully.');
        }

        CoreHelp::setSession('menu', array(
            'main' => 'members',
            'sub' => 'memberlist'
        ));
        CoreHelp::redirect('back');
    }

    public function postMemberlog()
    {
        $noteid = CoreHelp::GetQuery('noteid');
        $this->admin->db->query("DELETE FROM member_log WHERE id=$noteid");
        echo "ok";
    }

    public function getMemberlog()
    {
        $memberid = CoreHelp::GetQuery('memberid');
        $note = CoreHelp::GetQuery('note');
        $this->admin->db->query("INSERT INTO member_log (member_id, note) VALUES ($memberid,'$note')");
        echo "ok";
    }

    public function getPlugins()
    {

        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();


        $this->smarty->display('plugins.tpl');
    }

    public function anyViewtransactions()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();


        $this->admin->obj = 'view_transaction';
        $this->admin->orderDefault = 'transaction_id';
        $this->admin->RestoreState();
        if (CoreHelp::GetQuery('filter')) {
            $filterDateDayBegin = CoreHelp::GetQuery('filterDateDayBegin');
            $filterDateMonthBegin = CoreHelp::GetQuery('filterDateMonthBegin');
            $filterDateYearBegin = CoreHelp::GetQuery('filterDateYearBegin');
            $filterDateDayEnd = CoreHelp::GetQuery('filterDateDayEnd');
            $filterDateMonthEnd = CoreHelp::GetQuery('filterDateMonthEnd');
            $filterDateYearEnd = CoreHelp::GetQuery('filterDateYearEnd');
            $this->admin->SaveStateValue('filterDateBegin', mktime(0, 0, 0, $filterDateMonthBegin, $filterDateDayBegin, $filterDateYearBegin));
            $this->admin->SaveStateValue('filterDateEnd', mktime(23, 59, 59, $filterDateMonthEnd, $filterDateDayEnd, $filterDateYearEnd));
        }
        $filterDateBegin = $this->admin->GetStateValue('filterDateBegin', 0);
        $filterDateEnd = $this->admin->GetStateValue('filterDateEnd', 0);
        $filterDateDayBegin = ($filterDateBegin != 0) ? date('d', $filterDateBegin) : '';
        $filterDateMonthBegin = ($filterDateBegin != 0) ? date('m', $filterDateBegin) : '';
        $filterDateYearBegin = ($filterDateBegin != 0) ? date('Y', $filterDateBegin) : date('Y', time()) - 1;
        $filterDateDayEnd = ($filterDateEnd != 0) ? date('d', $filterDateEnd) : '';
        $filterDateMonthEnd = ($filterDateEnd != 0) ? date('m', $filterDateEnd) : '';
        $filterDateYearEnd = ($filterDateEnd != 0) ? date('Y', $filterDateEnd) : '';
        $sql_select = '';
        if ($filterDateBegin != 0) {
            $sql_select .= " AND transaction_date>$filterDateBegin AND transaction_date<$filterDateEnd";
        } else {
            $sql_select .= ' AND transaction_date >= unix_timestamp(curdate() - interval 15 day)';
        }

        $filter = '';
        $filter .= '<b>Date FROM </b>';
        $filter .= $this->admin->getDaySelect($filterDateDayBegin, 'filterDateDayBegin');
        $filter .= $this->admin->getMonthSelect($filterDateMonthBegin, 'filterDateMonthBegin');
        $filter .= $this->admin->getYearSelect($filterDateYearBegin, 'filterDateYearBegin');
        $filter .= ' <b>To</b> ';
        $filter .= $this->admin->getDaySelect($filterDateDayEnd, 'filterDateDayEnd');
        $filter .= $this->admin->getMonthSelect($filterDateMonthEnd, 'filterDateMonthEnd');
        $filter .= $this->admin->getYearSelect($filterDateYearEnd, 'filterDateYearEnd');
        $total = CoreHelp::GetQuery('type') == 'payout' ? $this->core->FirstField("SELECT COUNT(*) FROM wallet_payout WHERE 1 $sql_select", 0) : $this->core->FirstField("SELECT COUNT(*) FROM wallet_deposit WHERE 1 $sql_select", 0);
        $total_tab = '';
        if ($total > 0) {
            $list = array();
            $result = CoreHelp::GetQuery('type') == 'payout' ? $this->admin->db->query("SELECT * FROM wallet_payout WHERE 1 $sql_select ORDER BY {$this->admin->orderBy} DESC LIMIT 1000") : $this->admin->db->query("SELECT * FROM wallet_deposit WHERE 1 $sql_select ORDER BY id DESC LIMIT 1000");
            foreach ($result as $row) {
                $from_id = $row['from_id'];
                $amount = $row['amount'];
                $from = CoreHelp::GetQuery('type') == 'payout' ? $row['from_id'] : ($row['processor'] == 0 ? 'Admin' : 'Processor');
                $to = CoreHelp::GetQuery('type') == 'payout' ? $row['to_id'] : $row['member_id'];
                $date = date('d M Y H:i', $row['transaction_date']);
                $type = $row['transaction_type'];
                $description = $row['descr'];
                array_push($list, array(
                    'id' => isset($row['id']) ? $row['id'] : $row['transaction_id'],
                    'date' => $date,
                    'amount' => $amount,
                    'from' => CoreHelp::GetQuery('type') == 'payout' ? $this->admin->getusername($from) : $from,
                    'to' => $this->admin->getusername($to),
                    'description' => $description
                ));
            }
            $this->smarty->assign('list', $list);
        }
        $this->smarty->assign('filter', $filter);
        $this->smarty->assign('cashselect', $total_tab);
        $this->smarty->assign('total', $total);
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'viewtransaction'
        ));
        $this->smarty->display('transactions_view.tpl');
    }

    public function getTransactions()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->admin->CheckLogin();


        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'searchtransaction'
        ));
        $this->smarty->display('transactions.tpl');
    }

    public function postTransactions()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();


        if (CoreHelp::GetQuery('member_id')) {
            $this->admin->obj = 'transaction';
            $this->admin->orderDefault = 'transaction_id';
            $this->admin->RestoreState();
            $member_id = !is_numeric(CoreHelp::GetQuery('member_id')) ? $this->admin->db->queryFirstField("SELECT member_id FROM members WHERE username = %s", CoreHelp::GetQuery('member_id')) : CoreHelp::GetQuery('member_id');
            if (CoreHelp::GetQuery('filter')) {
                $filterDateDayBegin = CoreHelp::GetQuery('filterDateDayBegin');
                $filterDateMonthBegin = CoreHelp::GetQuery('filterDateMonthBegin');
                $filterDateYearBegin = CoreHelp::GetQuery('filterDateYearBegin');
                $filterDateDayEnd = CoreHelp::GetQuery('filterDateDayEnd');
                $filterDateMonthEnd = CoreHelp::GetQuery('filterDateMonthEnd');
                $filterDateYearEnd = CoreHelp::GetQuery('filterDateYearEnd');
                $this->admin->SaveStateValue('filterDateBegin', mktime(0, 0, 0, $filterDateMonthBegin, $filterDateDayBegin, $filterDateYearBegin));
                $this->admin->SaveStateValue('filterDateEnd', mktime(23, 59, 59, $filterDateMonthEnd, $filterDateDayEnd, $filterDateYearEnd));
                $this->admin->SaveStateValue('member_id', $member_id);
            }
            $filterDateBegin = $this->admin->GetStateValue('filterDateBegin', 0);
            $filterDateEnd = $this->admin->GetStateValue('filterDateEnd', 0);
            $filterDateDayBegin = ($filterDateBegin != 0) ? date('d', $filterDateBegin) : '';
            $filterDateMonthBegin = ($filterDateBegin != 0) ? date('m', $filterDateBegin) : '';
            $filterDateYearBegin = ($filterDateBegin != 0) ? date('Y', $filterDateBegin) : date('Y', time()) - 1;
            $filterDateDayEnd = ($filterDateEnd != 0) ? date('d', $filterDateEnd) : '';
            $filterDateMonthEnd = ($filterDateEnd != 0) ? date('m', $filterDateEnd) : '';
            $filterDateYearEnd = ($filterDateEnd != 0) ? date('Y', $filterDateEnd) : '';
            $sql_select = '';
            if ($filterDateBegin != 0) {
                $sql_select .= " AND transaction_date>$filterDateBegin AND transaction_date<$filterDateEnd";
            } else {
                $sql_select .= ' AND transaction_date >= unix_timestamp(curdate() - interval 365 day)';
            }
            $filter = '';
            $filter .= '<b>Date FROM </b>';
            $filter .= $this->admin->getDaySelect($filterDateDayBegin, 'filterDateDayBegin');
            $filter .= $this->admin->getMonthSelect($filterDateMonthBegin, 'filterDateMonthBegin');
            $filter .= $this->admin->getYearSelect($filterDateYearBegin, 'filterDateYearBegin');
            $filter .= ' <b>To</b> ';
            $filter .= $this->admin->getDaySelect($filterDateDayEnd, 'filterDateDayEnd');
            $filter .= $this->admin->getMonthSelect($filterDateMonthEnd, 'filterDateMonthEnd');
            $filter .= $this->admin->getYearSelect($filterDateYearEnd, 'filterDateYearEnd');
            $total_cash = CoreHelp::GetQuery('type') == 'payout' ? $this->core->FirstField("SELECT SUM(amount) FROM wallet_payout WHERE to_id='" . CoreHelp::sanitizeSQL($member_id) . "'", '0.00') : $this->core->FirstField("SELECT SUM(amount) FROM wallet_deposit WHERE member_id='" . CoreHelp::sanitizeSQL($member_id) . "'", '0.00');
            $total = CoreHelp::GetQuery('type') == 'payout' ? $this->core->FirstField("SELECT COUNT(*) FROM wallet_payout WHERE 1 $sql_select AND to_id='" . CoreHelp::sanitizeSQL($member_id) . "'", 0) : $this->core->FirstField("SELECT COUNT(*) FROM wallet_deposit WHERE 1 $sql_select AND member_id='" . CoreHelp::sanitizeSQL($member_id) . "'", 0);
            $total_tab = '';
            if ($total > 0) {
                $list = array();
                $result = CoreHelp::GetQuery('type') == 'payout' ? $this->admin->db->query("SELECT * FROM wallet_payout WHERE 1 $sql_select AND to_id='" . CoreHelp::sanitizeSQL($member_id) . "' ORDER BY {$this->admin->orderBy} DESC LIMIT 1000") : $this->admin->db->query("SELECT * FROM wallet_deposit WHERE 1 $sql_select AND member_id='" . CoreHelp::sanitizeSQL($member_id) . "' ORDER BY id DESC LIMIT 1000");
                foreach ($result as $row) {
                    $from_id = $row['from_id'];
                    $amount = $row['amount'];
                    $date = date('d M Y H:i', $row['transaction_date']);
                    $type = $row['transaction_type'];
                    $description = $row['descr'];
                    array_push($list, array(
                        'id' => isset($row['id']) ? $row['id'] : $row['transaction_id'],
                        'date' => $date,
                        'amount' => $amount,
                        'description' => $description
                    ));
                }
                $this->smarty->assign('list', $list);
            }
            $this->smarty->assign('traid', $member_id);
            $this->smarty->assign('filter', $filter);
            $this->smarty->assign('cashselect', $total_tab);
            $this->smarty->assign('total', $total);
            CoreHelp::setSession('menu', array(
                'main' => 'financial',
                'sub' => 'searchtransaction'
            ));
            $this->smarty->display('transactions_id.tpl');
        } else {
            CoreHelp::setSession('menu', array(
                'main' => 'financial',
                'sub' => 'searchtransaction'
            ));
            $this->smarty->display('transactions.tpl');
        }
    }

    public function getAddtransaction()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();

        $result = $this->admin->db->query('SELECT member_id,username FROM members');

        $this->smarty->assign('members12', $result);

        $this->admin->db->query("SET NAMES 'utf8'");
        $data_first = $this->admin->db->query('SELECT * FROM bsc_products WHERE visible=1');


        $this->smarty->assign('products12', $data_first);

        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'addtransaction'
        ));
        $this->smarty->display('addtransaction.tpl');
    }

    public function postAddtransaction()
    {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require_once "system/app/plugins/cart/ShoppingCart/config.php";                // load settings file
        require_once "system/app/plugins/cart/ShoppingCart/_ShoppingCart.php";     // load class ShoppingCart
        $cart1 = new shoppingcart();
        $cart1->init('my_shop');
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();

        if (CoreHelp::GetQuery('member_id', '')) {

            $member_id = CoreHelp::GetQuery('member_id');
            $amount = CoreHelp::GetQuery('amount');
            $descr = CoreHelp::GetQuery('description');
            $type = CoreHelp::GetQuery('type');
            $service_id = CoreHelp::GetQuery('service_id');
            $which = $amount < 0 ? 'Substracted' : 'Added';

            $result1 = $this->admin->db->query('SELECT * FROM members WHERE member_id=' . $member_id);
            $member_email = $result1[0]['email'];
            $result = $this->admin->db->query('SELECT member_id,username FROM members');

            $this->smarty->assign('members12', $result);
            $check = $this->admin->db->queryFirstRow("SELECT username FROM members WHERE member_id = %d", $member_id);
            if (!isset($check['username'])) {
                CoreHelp::setSession('error', 'Wrong member ID, please check it again');
                CoreHelp::redirect('back');
            }
            if ($service_id != 'no') {
                $data_first = $this->admin->db->query('SELECT * FROM bsc_products WHERE visible=1 AND id=' . $service_id);
            }
            if ($type == 'deposit') {
                $this->admin->db->query("INSERT INTO wallet_deposit (amount, processor_id, member_id, transaction_date, descr) VALUES ('$amount', 0, '$member_id', '" . time() . "', '$descr')");
                $this->admin->db->query("INSERT INTO admin_log (admin_username, ip_address, country, date, description, flag) VALUES ('" . $_SESSION['userName'] . "', '" . CoreHelp::getIp() . "', '" . CoreHelp::getCountryCode(CoreHelp::getIp()) . "', NOW(), '" . $which . " $" . $amount . " to member deposit wallet, MemberId: " . $member_id . "', 1)");
                if ($service_id != 'no') {
                    $paymentsource['sp1'] = 0;
                    $paymentsource['sp2'] = $data_first[0]['price'];
                }
            }
            if ($type == 'payout') {
                $this->admin->db->query("INSERT INTO wallet_payout (amount, transaction_type, to_id, transaction_date, descr) VALUES ('$amount', 2, '$member_id', '" . time() . "', '$descr')");
                $this->admin->db->query("INSERT INTO admin_log (admin_username, ip_address, country, date, description, flag) VALUES ('" . $_SESSION['userName'] . "', '" . CoreHelp::getIp() . "', '" . CoreHelp::getCountryCode(CoreHelp::getIp()) . "', NOW(), '" . $which . " $" . $amount . " to member payout wallet, MemberId: " . $member_id . "', 1)");
                if ($service_id != 'no') {
                    $paymentsource['sp1'] = $data_first[0]['price'];
                    $paymentsource['sp2'] = 0;
                }
            }

            $messagehelp = 'This transaction was added succesfully to ' . $type . ' wallet.';
            if ($service_id != 'no') {
                $cart1->add_cart($service_id . ":::", 1);
                $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
                $Db->query("SET NAMES 'utf8'"); // formating to utf8
                if (!isset($member_id)) {
                    die("Session expired, please login again");
                }

                $customerData = $Db->getRow('bsc_customers', 'payer_email', $member_email);

                if (empty($customerData) && !empty($result1[0])) {
                    CheckUser($result1[0]['email'], $result1[0]['password'], $result1[0]['first_name'], $result1[0]['last_name'], $result1[0]['first_name'] . ' ' . $result1[0]['last_name'], '', $result1[0]['country'], $result1[0]['postal'], $result1[0]['state'], $result1[0]['city'], $result1[0]['street']);

                    $customerData = $Db->getRow('bsc_customers', 'payer_email', $member_email);
                }

                $customer_region = $customerData['address_state'];
                $settingsMain = $Db->getRow('settings', 'keyname', 'settings_cart_tax_percent');
                $tax_percent = $settingsMain['value'];


                if (!$cart1->get_cart()) {  //checking if the cart is empty or not
                    echo "<h3>Shopping cart is empty</h3>";
                    echo "<a href='shoppingcart_main_inside.php'>Go back</a>";
                    die();
                }
                $sp1 = $Db->query("SELECT SUM(amount) as total FROM wallet_payout WHERE to_id = " . $member_id);
                $sp2 = $Db->query("SELECT SUM(amount) as total FROM wallet_deposit WHERE member_id = " . $member_id);
                $bsc = $cart1->get_cart(); // get shoppingcart
                $render = new renderchartshop($bsc); // render shoppingcart
                $shoppingcart = $render->get(); // get render
                $price = 0;
                $invoice = uniqid();
                $from_payout = abs(number_format($paymentsource['sp1'], 2, '.', ''));
                $from_deposit = abs(number_format($paymentsource['sp2'], 2, '.', ''));
                $_SESSION['invoicer'] = array();
                $shipping_total = 0;
                foreach ($shoppingcart as $cart) {
                    $pinfo = array('name' => $cart['name'] . ' ' . $cart['name_type'], 'quantity' => $cart['quantity']);
                    if ($cart['price_offer'] > 0) {
                        $price += $cart['price_offer'] * $cart['quantity'];
                        $pinfo['price'] = $cart['price'] * $cart['quantity'];
                        $pinfo['discount'] = ($cart['price'] - $cart['price_offer']) * $cart['quantity'];
                    } else {
                        $price += $cart['price'] * $cart['quantity'];
                        $pinfo['price'] = $cart['price'] * $cart['quantity'];
                        $pinfo['discount'] = 0;
                    }
                    //shipping per product

                    $shipping_subtotal = 0;
                    $shipping_total += $shipping_subtotal;
                    $_SESSION['invoicer']['products'][] = $pinfo;
                }
                $_SESSION['invoicer']['coupon_discount'] = 0;
                //var_dump($_SESSION);
                $_SESSION['discount'] = 0;
                if ($_SESSION['discount'] > 0) {
                    $price -= $_SESSION['discount'];
                    $_SESSION['invoicer']['coupon_discount'] = $_SESSION['discount'];
                }
                $tax_amount = $price * $tax_percent / 100;
                $total = $price + $shipping_total + $tax_amount;

                $_SESSION['invoicer']['shipping'] = $shipping_total;
                $_SESSION['invoicer']['tax'] = $tax_amount;
                $_SESSION['invoicer']['total'] = $total;

                if ($from_payout + $from_deposit != number_format($total, 2, '.', '')) {
                    $error = "Sum from both wallets must be equal $" . number_format($total, 2, '.', '');
                }
                if ($from_payout > $sp1[0]['total']) {
                    $error = "You have not enough balance on your Payout Wallet to complete your transaction";
                }
                if ($from_deposit > $sp2[0]['total']) {
                    $error = "You have not enough balance on your Deposit Wallet to complete your transaction";
                }
                if ($from_payout < 0 || $from_deposit < 0) {
                    $error = "You can not use negative numbers as amounts";
                }

                if (!isset($error)) {
                    if ($from_payout > 0) {
                        $Db->query("INSERT INTO wallet_payout (amount, transaction_type, to_id, transaction_date, descr) 
				VALUES ('-$from_payout', 2, '" . $member_id . "', '" . time() . "', 'Product Purchase for Invoice: " . $invoice . "')");
                    }

                    if ($from_deposit > 0) {
                        $Db->query("INSERT INTO wallet_deposit (amount, member_id, transaction_date, descr) 
				VALUES ('-$from_deposit', '" . $member_id . "', '" . time() . "', 'Product Purchase for Invoice: " . $invoice . "')");
                    }

                    // Buyer information
                    $row = $Db->getRow('bsc_customers', 'payer_email', $customerData['payer_email']);
                    $first_name = $row['first_name'];
                    $last_name = $row['last_name'];
                    $address_name = $row['address_name'];
                    $address_country_code = $row['address_country_code'];
                    $address_zip = $row['address_zip'];
                    $address_state = $row['address_state'];
                    $address_city = $row['address_city'];
                    $address_street = $row['address_street'];
                    if ($_SERVER['REMOTE_ADDR'] == '202.88.243.158') {
                        $reflFunc = new ReflectionFunction('PayCommissions');
                        print $reflFunc->getFileName() . ':' . $reflFunc->getStartLine();
                        die;
                    }
                    $commissionable = $price;    //take out shipping and tax
                    PayCommissions($customerData['payer_email'], $commissionable, $invoice);

                    $settings = array(
                        'dateorder' => date('Y-m-d H:i:s'),
                        'payer_email' => $customerData['payer_email'],
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'address_name' => $address_name,
                        'address_country_code' => $address_country_code,
                        'address_zip' => $address_zip,
                        'address_state' => $address_state,
                        'address_city' => $address_city,
                        'address_street' => $address_street,
                        'payment_type' => 'Internal Payment',
                        'payment_status' => 'Completed',
                        'payment_currency' => 'USD',
                        'payment_amount' => $price,
                        'custom' => 'Autopayment',
                        'invoice' => $invoice
                    );
                    $Db->insertRow('bsc_order_header', $settings);

                    $bsc = $cart1->get_cart(); // get shoppingcart
                    $render = new renderchartshop($bsc);  // render shoppingcart
                    $shoppingcart = $render->get();   // get render
                    $i = 1;
                    foreach ($shoppingcart as $cart) {
                        if ($cart['price_offer'] > 0) {
                            $amount = $cart['price_offer'];
                        } else {
                            $amount = $cart['price'];
                        }
                        $item_price = $amount / $cart['quantity'];
                        $settings = array(
                            'dateorder' => date('Y-m-d H:i:s'),
                            'item_name' => $cart['name'] . ' ' . $cart['name_type'],
                            'item_number' => $cart['productCode'],
                            'quantity' => $cart['quantity'],
                            'mc_gross' => $amount,
                            'item_price' => $item_price,
                            'shipping_price' => $shipping_total,
                            'tax_amount' => $tax_amount,
                            'payment_status' => 'Completed',
                            'payment_amount' => $price,
                            'payment_currency' => 'USD',
                            'payer_email' => $customerData['payer_email'],
                            'payment_type' => 'Internal Payment',
                            'custom' => 'Autopayment',
                            'invoice' => $invoice,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'address_name' => $address_name,
                            'address_country_code' => $address_country_code,
                            'address_zip' => $address_zip,
                            'address_state' => $address_state,
                            'address_city' => $address_city,
                            'address_street' => $address_street
                        );
                        $Db->insertRow('bsc_order_detail', $settings); // inserts row into 'bsc_order' table
                    }
                    $cart1->removeall_cart();
                    $_SESSION['discount'] = 0;
                    //header("location: processing_order.php");


                    $messagehelp = $messagehelp . '<br>The Payment of ' . $price . '$ was taked from the wallet wallet.';
                } else {
                    $cart1->removeall_cart();
                    CoreHelp::setSession('error', $error);
                }
            }
            CoreHelp::setSession('message', $messagehelp);
            CoreHelp::redirect('back');
        }
    }

    public function getWithdrawals()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();
        $this->admin->obj = 'withdrawals';
        $this->admin->orderDefault = 'transfer_date';
        $this->admin->RestoreState();
        $fee = $this->admin->GetSiteSetting('commission_cashout_fee');
        if (CoreHelp::GetQuery('w') == 'decline') {
            if (DEMO) {
                CoreHelp::setSession('error', 'Cannot decline withdrawal in demo mode');
                CoreHelp::redirect('back');
            }
            $xid = CoreHelp::GetQuery('id');
            $this->admin->db->query("UPDATE money_out SET status=2 WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $amount = $this->core->FirstField("SELECT amount FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $member_idx = $this->core->FirstField("SELECT member_id FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $this->admin->db->query("INSERT INTO wallet_payout (amount, transaction_type, to_id, transaction_date, descr) VALUES ('$amount', 2, '$member_idx', '" . time() . "', 'Canceled Withdrawal Request')");
            CoreHelp::setSession('message', 'Transaction saved successfully');
            CoreHelp::redirect('back');
        }
        if (CoreHelp::GetQuery('w') == 'complete') {
            if (DEMO) {
                CoreHelp::setSession('error', 'Cannot complete withdrawal in demo mode');
                CoreHelp::redirect('back');
            }
            $xid = CoreHelp::GetQuery('id');
            $fee = $this->admin->GetSiteSetting('commission_cashout_fee');
            $this->admin->db->query("UPDATE money_out SET status=1, amount=amount-'$fee' WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $amount = $this->core->FirstField("SELECT amount FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $processor_id = $this->core->FirstField("SELECT processor FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $processor = $this->core->FirstField("SELECT name FROM payment_processors WHERE processor_id=$processor_id");
            $member_id = $this->core->FirstField("SELECT member_id FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $firstName = $this->core->FirstField("SELECT first_name FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($member_id) . "'");
            $lastName = $this->core->FirstField("SELECT last_name FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($member_id) . "'");
            $email = $this->core->FirstField("SELECT email FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($member_id) . "'");
            $message = $this->core->FirstField("SELECT message FROM emailtemplates WHERE code='SuccessWithdrawal'");
            $message = $this->admin->dec($message);
            $contactEmail = $this->admin->GetSiteSetting('admin_email');
            $thisSiteUrl = $this->admin->GetSiteSetting('site_url');
            $thisSiteTitle = $this->admin->GetSiteSetting('site_name');
            $message = preg_replace("/\[FirstName\]/", $firstName, $message);
            $message = preg_replace("/\[LastName\]/", $lastName, $message);
            $message = preg_replace("/\[SiteTitle\]/", $siteTitle, $message);
            $message = preg_replace("/\[NumberRequest\]/", $id, $message);
            $message = preg_replace("/\[Amount\]/", $amount, $message);
            $message = preg_replace("/\[SiteName\]/", $thisSiteTitle, $message);
            $message = preg_replace("/\[SiteUrl\]/", $thisSiteUrl, $message);
            $message = preg_replace("/\[AdminMail\]/", $contactEmail, $message);
            $message = preg_replace("/\[Processor\]/", $prcessor, $message);
            $message = preg_replace("/\[Amount\]/", number_format($amount, 2, '.', ''), $message);
            $subject = $this->core->FirstField("SELECT subject FROM emailtemplates WHERE code='SuccessWithdrawal'");
            $subject = $this->admin->dec($subject);
            $subject = preg_replace("/\[SiteTitle\]/", $siteTitle, $subject);
            $subject = preg_replace("/\[SiteName\]/", $thisSiteTitle, $subject);
            $emailHeader = 'From: ' . $contactEmail . "\r\n";
            CoreHelp::sendMail($email, $subject, $message, $emailHeader);
            CoreHelp::setSession('message', 'Transaction saved successfully');
            CoreHelp::redirect('back');
        }
        if (CoreHelp::GetQuery('w') == 'api_pay') {
            if (DEMO) {
                CoreHelp::setSession('error', 'Cannot pay with API in demo mode');
                CoreHelp::redirect('back');
            }
            $lock = new iMVC_Library_Lock('PAY_WITH_API_' . CoreHelp::GetQuery('id'));
            if ($lock->lock() == false) {
                CoreHelp::redirect('back');
            }
            $xid = CoreHelp::GetQuery('id');
            $fee = $this->admin->GetSiteSetting('commission_cashout_fee');
            $status = $this->core->FirstField("SELECT status FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            if ($status > 0) {
                CoreHelp::setSession('error', 'This transaction was processed previously');
                CoreHelp::redirect('back');
            }

            $amount = $this->core->FirstField("SELECT amount FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $processor_id = $this->core->FirstField("SELECT processor FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $account_id = $this->core->FirstField("SELECT account_id FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $processor = $this->core->FirstField("SELECT name FROM payment_processors WHERE processor_id=$processor_id");
            $processor_code = $this->core->FirstField("SELECT code FROM payment_processors WHERE processor_id=$processor_id");
            $member_id = $this->core->FirstField("SELECT member_id FROM money_out WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $pay_amount = $amount * (1 - $fee / 100);
            $transaction = $this->hooks->apply_filters('api_send_money_' . $processor_code, $account_id, $pay_amount, CoreHelp::GetQuery('id'));
            if ($transaction === false) {
                CoreHelp::redirect('back');
            }
            $firstName = $this->core->FirstField("SELECT first_name FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($member_id) . "'");
            $lastName = $this->core->FirstField("SELECT last_name FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($member_id) . "'");
            $email = $this->core->FirstField("SELECT email FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($member_id) . "'");
            $this->admin->db->query("UPDATE money_out SET status=1, amount=amount-'$fee' WHERE money_out_id='" . CoreHelp::sanitizeSQL($xid) . "'");
            $message = $this->core->FirstField("SELECT message FROM emailtemplates WHERE code='SuccessWithdrawal'");
            $message = $this->admin->dec($message);
            $contactEmail = $this->admin->GetSiteSetting('admin_email');
            $thisSiteUrl = $this->admin->GetSiteSetting('site_url');
            $thisSiteTitle = $this->admin->GetSiteSetting('site_name');
            $message = preg_replace("/\[FirstName\]/", $firstName, $message);
            $message = preg_replace("/\[LastName\]/", $lastName, $message);
            $message = preg_replace("/\[SiteTitle\]/", $siteTitle, $message);
            $message = preg_replace("/\[NumberRequest\]/", $id, $message);
            $message = preg_replace("/\[Amount\]/", $amount, $message);
            $message = preg_replace("/\[SiteName\]/", $thisSiteTitle, $message);
            $message = preg_replace("/\[SiteUrl\]/", $thisSiteUrl, $message);
            $message = preg_replace("/\[AdminMail\]/", $contactEmail, $message);
            $message = preg_replace("/\[Processor\]/", $prcessor, $message);
            $message = preg_replace("/\[Amount\]/", number_format($amount, 2, '.', ''), $message);
            $subject = $this->core->FirstField("SELECT subject FROM emailtemplates WHERE code='SuccessWithdrawal'");
            $subject = $this->admin->dec($subject);
            $subject = preg_replace("/\[SiteTitle\]/", $siteTitle, $subject);
            $subject = preg_replace("/\[SiteName\]/", $thisSiteTitle, $subject);
            $emailHeader = 'From: ' . $contactEmail . "\r\n";
            CoreHelp::sendMail($email, $subject, $message, $emailHeader);
            CoreHelp::redirect('back');
        }
        if (count($_GET) == 1) {
            $this->admin->SaveStateValue('member_id', '');
            $this->admin->SaveStateValue('status', '');
            $this->admin->SaveStateValue('processor', '');
        }
        $member_id = $this->admin->GetStateValue('member_id');
        $status = $this->admin->GetStateValue('status');
        $processor = $this->admin->GetStateValue('processor');
        $sql_select = '';
        if ($status == '') {
            $status = 0;
        }
        if ($status < 3) {
            $sql_select .= "AND status='" . CoreHelp::sanitizeSQL($status) . "'";
        }
        if ($member_id != '') {
            $sql_select .= " AND member_id='" . CoreHelp::sanitizeSQL($member_id) . "'";
        }
        if ($processor != '' && $processor != 0) {
            $sql_select .= " AND processor='" . CoreHelp::sanitizeSQL($processor) . "'";
        }
        $select_status = $this->admin->getStatusSelect($status);
        $processor_status = $this->admin->getProcessorStatusSelect($processor);
        $totalAmount = $this->core->FirstField("SELECT SUM(amount) FROM money_out WHERE 1 $sql_select", 0);
        $total = $this->core->FirstField("SELECT COUNT(*) FROM money_out WHERE 1 $sql_select");
        $site_url = $this->admin->GetSiteSetting('site_url');


        $this->admin->siteUrl = $site_url;
        $this->admin->rowsOptions = array(
            10,
            20,
            30,
            50
        );
        $this->data = array(
            'MAIN_DELETEALLDENIED' => "<input type='button' value='Delete all denied Withdrawals' onClick=\"if (confirm ('Are you sure?')) {window.location.href='{$this->pageUrl}?ocd=delalldenied';}\">",
            'MAIN_DOWNLOADMASS' => "<input type='button' value='Download Mass Payment File' onClick=\"window.location.href='{$this->pageUrl}?ocd=downloadmass';\">",
            'HEAD_USERNAME' => $this->admin->Header_GetSortLink('member_id', 'User Name'),
            'HEAD_AMOUNT' => $this->admin->Header_GetSortLink('amount', 'Amount'),
            'HEAD_DATE' => $this->admin->Header_GetSortLink('transfer_date', 'Date'),
            'HEAD_STATUS' => $this->admin->Header_GetSortLink('status', 'Status'),
            'HEAD_PROCESSOR' => $this->admin->Header_GetSortLink('processor', 'Processor'),
            'HEAD_ACCOUNT_ID' => $this->admin->Header_GetSortLink('account_id', 'Account ID'),
            'HEAD_FEE' => $this->admin->Header_GetSortLink('fee', 'Fee'),
            'HEAD_PAY' => 'Make Withdrawal',
            'STATUS' => $select_status,
            'PROCESSOR' => $processor_status,
            'MAIN_FILTER' => "<input type='text' name='member_id' value='" . CoreHelp::sanitizeSQL($member_id) . "' class='form-SELECT form-control m-b' maxlength='6'>",
            'PAGINATION' => $this->admin->Pages_GetLinks($total, $this->admin->siteUrl . 'admin/withdrawals/&')
        );
        if ($total > 0) {
            $limit = $this->admin->rowsPerPage;
            $offset = ($this->admin->currentPage - 1) * $this->admin->rowsPerPage;
            $sql_select2 .= " LIMIT $offset,$limit";
            $result = $this->admin->db->query("SELECT * FROM money_out WHERE 1 $sql_select ORDER BY {$this->admin->orderBy} {$this->admin->orderDir} $sql_select2", true);
            $thisTime = time();
            foreach ($result as $row) {
                $id = $row['money_out_id'];
                $member_id = $row['member_id'];
                $name = $this->core->FirstField("SELECT username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($member_id) . "'", '');
                $user_name = $name . " (#$member_id)";
                $amount = $row['amount'];
                $processor_id = $row['processor'];
                $account_id = $row['account_id'];
                $processor = ($processor_id > 0) ? $this->core->FirstField("SELECT name FROM payment_processors WHERE processor_id=$processor_id") : 'No Processor Selected';
                $account_id = $row['account_id'];
                $with_fee = $amount - $fee;
                $fee_list = ($row['status'] > 0) ? '0.00' : $fee;
                $pay_cash_out = '&nbsp;';
                $date = date('d M Y H:i', $row['transfer_date']);
                if ($row['status'] == 0) {
                    $status = '<b>Status:</b> pending<br>';
                    $actions = "<a href='/admin/withdrawals/&w=decline&id=$id' onClick=\"return confirm ('Want to decline this request?')\">Decline</a><br>";
                    $actions .= "<a href='/admin/withdrawals/&w=complete&id=$id' onClick=\"return confirm ('Want to complete this request?')\">Mark Complete</a><br> ";
                    if ($processor_id > 0) {
                        $actions .= "<a href='/admin/withdrawals/&w=api_pay&id=$id' onClick=\"return confirm ('Want to pay this with the API?')\">Pay with " . $processor . "  API</a> ";
                    }
                }
                if ($row['status'] == 1) {
                    $status = 'Completed';
                }
                if ($row['status'] == 2) {
                    $status = 'Declined';
                }
                if ($row['status'] > 2) {
                    $status = 'Fail';
                }
                $this->datax['TABLE_ROW'][] = array(
                    'ROW_ID' => $row['money_out_id'],
                    'ROW_USERNAME' => $user_name,
                    'ROW_AMOUNT' => $amount,
                    'ROW_FEE' => $fee_list,
                    'ROW_DATE' => $date,
                    'ROW_STATUS' => $status,
                    'ROW_ACTIONS' => $actions,
                    'ROW_PROCESSOR' => $processor,
                    'ROW_ACCOUNT_ID' => $account_id
                );
            }
            $this->smarty->assign('data', $this->datax['TABLE_ROW']);
        }
        $this->smarty->assign('total_amount', number_format($totalAmount, 2, '.', ''));
        $this->smarty->assign('header', $this->data);
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'withdrawalrequest'
        ));
        $this->smarty->display('withdrawals.tpl');
    }

    public function postWithdrawals()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();
        $this->admin->obj = 'withdrawals';
        $this->admin->orderDefault = 'transfer_date';
        $this->admin->RestoreState();
        $fee = $this->admin->GetSiteSetting('commission_cashout_fee');
        if (CoreHelp::GetQuery('filter1') == 1) {
            $member_id = $this->admin->enc(CoreHelp::GetQuery('member_id'));
            $this->admin->SaveStateValue('member_id', $member_id);
        }
        if (CoreHelp::GetQuery('filter2') == 1) {
            $status = $this->admin->enc(CoreHelp::GetQuery('status'));
            $this->admin->SaveStateValue('status', $status);
        }
        if (CoreHelp::GetQuery('filter3') == 1) {
            $processor = $this->admin->enc(CoreHelp::GetQuery('processor'));
            $this->admin->SaveStateValue('processor', $processor);
        }

        $member_id = $this->admin->GetStateValue('member_id');
        $status = $this->admin->GetStateValue('status');
        $processor = $this->admin->GetStateValue('processor');
        $sql_select = '';
        if ($status == '') {
            $status = 0;
        }
        if ($status < 3) {
            $sql_select .= " AND status='" . CoreHelp::sanitizeSQL($status) . "'";
        }
        if ($member_id != '') {
            $sql_select .= " AND member_id='" . CoreHelp::sanitizeSQL($member_id) . "'";
        }
        if ($processor != '' && $processor != 0) {
            $sql_select .= " AND processor='" . CoreHelp::sanitizeSQL($processor) . "'";
        }
        $select_status = $this->admin->getStatusSelect($status);
        $processor_status = $this->admin->getProcessorStatusSelect($processor);
        $totalAmount = $this->core->FirstField("SELECT SUM(amount) FROM money_out WHERE 1 $sql_select", 0);
        $total = $this->core->FirstField("SELECT COUNT(*) FROM money_out WHERE 1 $sql_select");
        $site_url = $this->admin->GetSiteSetting('site_url');


        $this->admin->siteUrl = $site_url;
        $this->admin->rowsOptions = array(
            10,
            20,
            30,
            50
        );
        $this->data = array(
            'MAIN_DELETEALLDENIED' => "<input type='button' value='Delete all denied Withdrawals' onClick=\"if (confirm ('Are you sure?')) {window.location.href='{$this->pageUrl}?ocd=delalldenied';}\">",
            'MAIN_DOWNLOADMASS' => "<input type='button' value='Download Mass Payment File' onClick=\"window.location.href='{$this->pageUrl}?ocd=downloadmass';\">",
            'HEAD_USERNAME' => $this->admin->Header_GetSortLink('member_id', 'User Name'),
            'HEAD_AMOUNT' => $this->admin->Header_GetSortLink('amount', 'Amount'),
            'HEAD_DATE' => $this->admin->Header_GetSortLink('transfer_date', 'Date'),
            'HEAD_STATUS' => $this->admin->Header_GetSortLink('status', 'Status'),
            'HEAD_PROCESSOR' => $this->admin->Header_GetSortLink('processor', 'Processor'),
            'HEAD_ACCOUNT_ID' => $this->admin->Header_GetSortLink('account_id', 'Account ID'),
            'HEAD_FEE' => $this->admin->Header_GetSortLink('fee', 'Fee'),
            'HEAD_PAY' => 'Make Withdrawal',
            'STATUS' => $select_status,
            'PROCESSOR' => $processor_status,
            'MAIN_FILTER' => "<input type='text' name='member_id' value='" . CoreHelp::sanitizeSQL($member_id) . "' class='form-SELECT form-control m-b' maxlength='6'>",
            'PAGINATION' => $this->admin->Pages_GetLinks($total, $this->admin->siteUrl . 'admin/withdrawals/&')
        );
        if ($total > 0) {
            $limit = $this->admin->rowsPerPage;
            $offset = $this->admin->currentPage * $this->admin->rowsPerPage;
            //$sql_select2 .= " LIMIT $offset,$limit";
            $sql_select2 .= ' AND transfer_date >= unix_timestamp(curdate() - interval 30 day)';
            $result = $this->admin->db->query("SELECT * FROM money_out WHERE 1 $sql_select $sql_select2 ORDER BY {$this->admin->orderBy} DESC", true);
            //echo "SELECT * FROM `{$this->object}` WHERE 1 $sql_select ORDER BY {$this->orderBy} {$this->orderDir}";
            $thisTime = time();
            foreach ($result as $row) {
                $id = $row['money_out_id'];
                $member_id = $row['member_id'];
                $name = $this->core->FirstField("SELECT username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($member_id) . "'", '');
                $user_name = $name . " (#$member_id)";
                $amount = $row['amount'];
                $processor_id = $row['processor'];
                $account_id = $row['account_id'];
                $processor = ($processor_id > 0) ? $this->core->FirstField("SELECT name FROM payment_processors WHERE processor_id=$processor_id") : 'No Processor Selected';
                $account_id = $row['account_id'];
                $with_fee = $amount - $fee;
                $fee_list = ($row['status'] > 0) ? '0.00' : $fee;
                $pay_cash_out = '&nbsp;';
                $date = date('d M Y H:i', $row['transfer_date']);
                if ($row['status'] == 0) {
                    $status = '<b>Status:</b> pending<br>';
                    $actions = "<a href='/admin/withdrawals/&w=decline&id=$id' onClick=\"return confirm ('Want to decline this request?')\">Decline</a><br>";
                    $actions .= "<a href='/admin/withdrawals/&w=complete&id=$id' onClick=\"return confirm ('Want to complete this request?')\">Mark Complete</a><br> ";
                    if ($processor_id > 0) {
                        $actions .= "<a href='/admin/withdrawals/&w=api_pay&id=$id' onClick=\"return confirm ('Want to pay this with the API?')\">Pay with " . $processor . "  API</a> ";
                    }
                }
                if ($row['status'] == 1) {
                    $status = 'Completed';
                }
                if ($row['status'] == 2) {
                    $status = 'Declined';
                }
                if ($row['status'] > 2) {
                    $status = 'Fail';
                }
                $this->datax['TABLE_ROW'][] = array(
                    'ROW_ID' => $row['money_out_id'],
                    'ROW_USERNAME' => $user_name,
                    'ROW_AMOUNT' => $amount,
                    'ROW_FEE' => $fee_list,
                    'ROW_DATE' => $date,
                    'ROW_STATUS' => $status,
                    'ROW_ACTIONS' => $actions,
                    'ROW_PROCESSOR' => $processor,
                    'ROW_ACCOUNT_ID' => $account_id
                );
            }
            $this->smarty->assign('data', $this->datax['TABLE_ROW']);
        }
        $this->smarty->assign('total_amount', number_format($totalAmount, 2, '.', ''));
        $this->smarty->assign('header', $this->data);
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'withdrawalrequest'
        ));
        $this->smarty->display('withdrawals.tpl');
    }

    public function getCmsmail()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();


        $this->javaScripts = $this->admin->GetJavaScript();
        $this->admin->obj = 'cmsmail';
        $emailtempl_id = CoreHelp::GetQuery('emailtempl', 0);
        if ($emailtempl_id > 0) {
            $this->admin->SaveStateValue('emailtempl_id', $emailtempl_id);
        }
        $second = '';
        $emailtempl_id = $this->admin->GetStateValue('emailtempl_id', 0);
        $btn = '';
        $subject = $this->core->FirstField("SELECT subject FROM emailtemplates WHERE emailtempl_id='" . CoreHelp::sanitizeSQL($emailtempl_id) . "'");
        $subject = $this->admin->dec($subject);
        $message = $this->core->FirstField("SELECT message FROM emailtemplates WHERE emailtempl_id='" . CoreHelp::sanitizeSQL($emailtempl_id) . "'");
        $message = $this->admin->dec($message);
        $ch_templ = $this->core->FirstField("SELECT tag_descr FROM emailtemplates WHERE emailtempl_id='" . CoreHelp::sanitizeSQL($emailtempl_id) . "'");
        $e_subject = "<input type='text' name='subject' value='" . CoreHelp::sanitizeSQL($subject) . "' maxlength='250' class='form-control b-m'>";
        $e_message = "<textarea name='message' rows='15' class='form-control b-m'>$message</textarea><input type='hidden' name='emailtempl' value='" . $emailtempl_id . "'";
        $this->data = array(
            'EMAIL_SUBJECT' => $e_subject,
            'EMAIL_MESSAGE' => $e_message,
            'CHANGE_TEMPLATE' => $ch_templ,
            'MAIN_SELECT' => $this->admin->getPageSelect($emailtempl_id),
            'MAIN_SELECT2' => $second,
            'RADIO_BUTTONS' => $btn,
            'MESSAGE' => $mess
        );
        $this->smarty->assign('data', $this->data);
        CoreHelp::setSession('menu', array(
            'main' => 'cms',
            'sub' => 'cmsmail'
        ));
        $this->smarty->display('cmsmail.tpl');
    }

    public function postCmsmail()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();


        $this->javaScripts = $this->admin->GetJavaScript();
        $this->admin->obj = 'cmsmail';
        $emailtempl_id = CoreHelp::GetQuery('emailtempl', 0);
        if (CoreHelp::GetQuery('save', '')) {
            $subject = $this->admin->enc(CoreHelp::GetQuery('subject'));
            $message = $this->admin->enc(CoreHelp::GetQuery('message'));
            $this->admin->db->query("UPDATE emailtemplates SET subject='" . CoreHelp::sanitizeSQL($subject) . "', message='" . CoreHelp::sanitizeSQL($message) . "' WHERE emailtempl_id='" . CoreHelp::sanitizeSQL($emailtempl_id) . "'");
            $this->smarty->assign('template_update', 'y');
        }
        if ($emailtempl_id > 0) {
            $this->admin->SaveStateValue('emailtempl_id', $emailtempl_id);
        }
        $second = '';
        $emailtempl_id = $this->admin->GetStateValue('emailtempl_id', 0);
        $btn = '';
        $subject = $this->core->FirstField("SELECT subject FROM emailtemplates WHERE emailtempl_id='" . CoreHelp::sanitizeSQL($emailtempl_id) . "'");
        $subject = $this->admin->dec($subject);
        $message = $this->core->FirstField("SELECT message FROM emailtemplates WHERE emailtempl_id='" . CoreHelp::sanitizeSQL($emailtempl_id) . "'");
        $message = $this->admin->dec($message);
        $ch_templ = $this->core->FirstField("SELECT tag_descr FROM emailtemplates WHERE emailtempl_id='" . CoreHelp::sanitizeSQL($emailtempl_id) . "'");
        $e_subject = "<input type='text' name='subject' value='" . CoreHelp::sanitizeSQL($subject) . "' class='form-control b-m'>";
        $e_message = "<textarea name='message' rows='15' class='form-control b-m'>$message</textarea><input type='hidden' name='emailtempl' value='" . $emailtempl_id . "'";
        $this->data = array(
            'EMAIL_SUBJECT' => $e_subject,
            'EMAIL_MESSAGE' => $e_message,
            'CHANGE_TEMPLATE' => $ch_templ,
            'MAIN_SELECT' => $this->admin->getPageSelect($emailtempl_id),
            'MAIN_SELECT2' => $second,
            'RADIO_BUTTONS' => $btn,
            'MESSAGE' => $mess
        );
        $this->smarty->assign('data', $this->data);
        CoreHelp::setSession('menu', array(
            'main' => 'cms',
            'sub' => 'cmsmail'
        ));
        $this->smarty->display('cmsmail.tpl');
    }


    public function getBonussettings()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->admin->CheckLogin();
        $memberships = $this->admin->GetMemberships();
        $settings = $this->admin->GetSiteSettings();
        $this->smarty->assign('settings', $settings);


        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'memberships',
            'sub' => 'membershipbonus'
        ));
        $this->smarty->display('startupsettings.tpl');
    }

    public function postBonussettings()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->admin->CheckLogin();
        $memberships = $this->admin->GetMemberships();
        foreach ($memberships as $membershipx) {
            foreach ($memberships as $membership) {
                $settingx = $membershipx . '_' . $membership . '_startup_bonus';
                $this->admin->SetSetting($settingx, number_format(CoreHelp::GetValidQuery($settingx), 2, '.', ''));
            }
        }
        if (isset($_SESSION['plan']['unilevel'])) {
            $this->admin->SetSetting('settings_unilevel_direct_behaviour', CoreHelp::GetQuery('settings_unilevel_direct_behaviour'));
        }
        $this->smarty->assign('settings_saved', 'y');
        $settings = $this->admin->GetSiteSettings();
        $this->smarty->assign('settings', $settings);


        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'memberships',
            'sub' => 'membershipbonus'
        ));
        $this->smarty->display('startupsettings.tpl');
    }

    public function getAdcreditstartup()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->admin->CheckLogin();
        $memberships = $this->admin->GetMemberships();
        $settings = $this->admin->GetSiteSettings();
        $this->smarty->assign('settings', $settings);


        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'memberships',
            'sub' => 'adcreditstartup'
        ));
        $this->smarty->display('adcreditstartup.tpl');
    }

    public function postAdcreditstartup()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->admin->CheckLogin();
        $memberships = $this->admin->GetMemberships();
        foreach ($memberships as $membership) {
            $setting = $membership . '_adcredit_startup';
            $this->admin->SetSetting($setting, number_format(CoreHelp::GetValidQuery($setting), 2, '.', ''));
        }
        $this->smarty->assign('settings_saved', 'y');
        $settings = $this->admin->GetSiteSettings();
        $this->smarty->assign('settings', $settings);


        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'memberships',
            'sub' => 'adcreditstartup'
        ));
        $this->smarty->display('adcreditstartup.tpl');
    }

    public function anyPaymember()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';

        $lang = CoreHelp::getLang('members');

        $this->admin->CheckLogin();
        $id = CoreHelp::GetQuery('id');
        $membership = CoreHelp::GetQuery('m');
        $level_id = $this->core->FirstField("SELECT m_level FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
        $sponsor_id = $this->core->FirstField("SELECT sponsor_id FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
        $enr_level = $this->core->FirstField("SELECT m_level FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsor_id) . "'");
        $email1 = $this->core->FirstField("SELECT email FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
        $email2 = $this->core->FirstField("SELECT email FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsor_id) . "'");
        $thisSiteTitle = $this->admin->GetSiteSetting('site_name');
        $adminEmail = $this->admin->GetSiteSetting('admin_email');
        $emailheader = "From: $thisSiteTitle <$adminEmail>\r\n";
        $username = $this->core->FirstField("SELECT username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsor_id) . "'");
        $firstName = $this->core->FirstField("SELECT first_name FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
        $lastName = $this->core->FirstField("SELECT last_name FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
        $message = $this->core->FirstField("SELECT message FROM emailtemplates WHERE code='NotifyMemberPaid'");
        $contactEmail = $this->admin->GetSiteSetting('admin_email');
        $thisSiteUrl = $this->admin->GetSiteSetting('site_url');
        $thisSiteTitle = $this->admin->GetSiteSetting('site_name');
        $message = preg_replace("/\[FirstName\]/", $firstName, $message);
        $message = preg_replace("/\[LastName\]/", $lastName, $message);
        $message = preg_replace("/\[SiteTitle\]/", $siteTitle, $message);
        $message = preg_replace("/\[Username\]/", $username, $message);
        $message = preg_replace("/\[SiteName\]/", $thisSiteTitle, $message);
        $message = preg_replace("/\[SiteUrl\]/", $thisSiteUrl, $message);
        $message = preg_replace("/\[AdminMail\]/", $contactEmail, $message);
        $subject = $this->core->FirstField("SELECT subject FROM emailtemplates WHERE code='NotifyMemberPaid'");
        $subject = preg_replace("/\[FirstName\]/", $firstName, $subject);
        $subject = preg_replace("/\[LastName\]/", $lastName, $subject);
        $subject = preg_replace("/\[SiteTitle\]/", $siteTitle, $subject);
        $subject = preg_replace("/\[SiteName\]/", $thisSiteTitle, $subject);
        $subject = preg_replace("/\[SiteUrl\]/", $thisSiteUrl, $subject);
        $subject = preg_replace("/\[AdminMail\]/", $contactEmail, $subject);
        $subject = preg_replace("/\[Username\]/", $subject, $message);
        CoreHelp::sendMail($email1, $subject, $message, $emailheader);
        if ($email2) {
            $firstName = $this->core->FirstField("SELECT first_name FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsor_id) . "'");
            $lastName = $this->core->FirstField("SELECT last_name FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsor_id) . "'");
            $message = $this->core->FirstField("SELECT message FROM emailtemplates WHERE code='NotifyNewReferral'");
            $contactEmail = $this->admin->GetSiteSetting('admin_email');
            $thisSiteUrl = $this->admin->GetSiteSetting('site_url');
            $thisSiteTitle = $this->admin->GetSiteSetting('site_name');
            $message = preg_replace("/\[FirstName\]/", $firstName, $message);
            $message = preg_replace("/\[LastName\]/", $lastName, $message);
            $message = preg_replace("/\[SiteTitle\]/", $siteTitle, $message);
            $message = preg_replace("/\[SiteName\]/", $thisSiteTitle, $message);
            $message = preg_replace("/\[SiteUrl\]/", $thisSiteUrl, $message);
            $message = preg_replace("/\[AdminMail\]/", $contactEmail, $message);
            $message = preg_replace("/\[SponsorID\]/", $sponsor_id, $message);
            $message = preg_replace("/\[UserID\]/", $id, $message);
            $message = preg_replace("/\[Username\]/", $username, $message);
            $subject = $this->core->FirstField("SELECT subject FROM emailtemplates WHERE code='NotifyNewReferral'");
            $subject = preg_replace("/\[FirstName\]/", $firstName, $subject);
            $subject = preg_replace("/\[LastName\]/", $lastName, $subject);
            $subject = preg_replace("/\[SiteTitle\]/", $siteTitle, $subject);
            $subject = preg_replace("/\[SiteName\]/", $thisSiteTitle, $subject);
            $subject = preg_replace("/\[SiteUrl\]/", $thisSiteUrl, $subject);
            $subject = preg_replace("/\[AdminMail\]/", $contactEmail, $subject);
            $subject = preg_replace("/\[SponsorID\]/", $sponsor_id, $subject);
            $subject = preg_replace("/\[UserID\]/", $id, $subject);
            $subject = preg_replace("/\[Username\]/", $username, $subject);
            CoreHelp::sendMail($email2, $subject, $message, $emailheader);
        }
        $ad_credits = $this->core->GetSiteSetting($membership . "_adcredit_startup");
        if ($ad_credits > 0) {
            $this->member->db->query("UPDATE members SET ad_credits=ad_credits+$ad_credits WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
            $this->core->insertAdCreditLog($id, 'start_up_bonus', $ad_credits, $lang['start_up_bonus']);
        }
        if ($enr_level == 0 AND $id != 1) {
            $new_sponsor_id = $this->core->FirstField('SELECT member_id FROM members WHERE is_active=1 ORDER BY RAND() LIMIT 1', 1);
            $this->admin->db->query("UPDATE members SET sponsor_id='" . CoreHelp::sanitizeSQL($new_sponsor_id) . "' WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
        }
        $sponsor_id = $this->core->FirstField("SELECT sponsor_id FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'", 0);
        $sponsor_mem = $this->core->FirstField("SELECT membership FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($sponsor_id) . "'", 0);
        $amount = $this->core->GetSiteSetting($membership . "_signup_fee", 0);
        $spnamt = $sponsor_mem . "_" . $membership . "_startup_bonus";
        $sponsor_amount = $this->core->GetSiteSetting($spnamt, 0);
        if ($sponsor_amount > 0 && $sponsor_id > 0) {
            $this->core->db->query("INSERT INTO wallet_payout (amount, transaction_type, from_id, to_id, transaction_date, descr) 
			VALUES ('" . CoreHelp::sanitizeSQL($sponsor_amount) . "', '2', '" . CoreHelp::sanitizeSQL($id) . "', '" . CoreHelp::sanitizeSQL($sponsor_id) . "', '" . time() . "', '" . $lang['sponsor_startup_bonus'] . "')");
        }
        $this->hooks->do_action('pay_upline', $id, $amount, $membership);
        CoreHelp::setSession('message', 'Member upgraded successfully');
        CoreHelp::redirect('/admin/members/');
    }

    public function getViewnetwork()
    {
        $plans = $this->hooks->apply_filters('view_network');
        CoreHelp::redirect($plans[0]['url'] . '/&id=' . CoreHelp::GetQuery('id'));
    }

    public function getBanners()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('del', '')) {
            if (DEMO) {
                CoreHelp::setSession('error', 'Cannot delete banners in demo mode');
                CoreHelp::redirect('back');
            }
            $target_path = $site_path . 'media/images/';
            $del = CoreHelp::GetQuery('del');
            $filename = $this->core->FirstField("SELECT banner_name FROM banners WHERE banner_id='" . CoreHelp::sanitizeSQL($del) . "'");
            unlink($target_path . $filename);
            $this->admin->db->query("DELETE FROM banners WHERE banner_id='" . CoreHelp::sanitizeSQL($del) . "'");
            $this->smarty->assign('banner_deleted', 'y');
        }
        $result = $this->admin->db->query('SELECT * FROM banners');
        $this->smarty->assign('banners', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'banners'
        ));
        $this->smarty->display('banners.tpl');
    }

    public function postBanners()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('upload', '')) {
            $target_path = 'media/images/';
            $rand = rand(1, 10000);
            $banner_alt = CoreHelp::GetQuery('banner_alt');
            $file_extensions_allowed = array(
                'jpg',
                'jpeg',
                'png',
                'gif',
                'bmp',
                'swf'
            );
            $ext = strtolower(substr(strrchr($_FILES['uploadbanner']['name'], '.'), 1));
            if (!in_array($ext, $file_extensions_allowed)) {
                $exts = implode(', ', $file_extensions_allowed);
                echo 'You must upload a file with one of the following extensions: ' . $exts;
                exit;
            }
            $filename = $rand . '_' . time() . '_' . rand(100000, 2000000) . '.' . $ext;
            $target_path = $target_path . $filename;
            if (move_uploaded_file($_FILES['uploadbanner']['tmp_name'], $target_path)) {
                list($width, $height, $type, $attr) = getimagesize($target_path);
                $size = $width . 'x' . $height;
                $this->admin->db->query("INSERT INTO banners SET banner_name='" . CoreHelp::sanitizeSQL($filename) . "',banner_alt='" . CoreHelp::sanitizeSQL($banner_alt) . "',banner_size='" . CoreHelp::sanitizeSQL($size) . "'");
                $this->smarty->assign('banner_saved', 'y');
            } else {
                $this->smarty->assign('banner_saved', 'error');
            }
        }
        if (CoreHelp::GetQuery('uploadupdate', '')) {
            $target_path = $site_path . 'media/images/';
            $rand = rand(1, 10000);
            $banner_alt = CoreHelp::GetQuery('banner_alt');
            $banner_id = CoreHelp::GetQuery('banner_id');
            if ($_FILES['uploadbanner']['name']) {
                $filename = $rand . '_' . basename($_FILES['uploadbanner']['name']);
                $target_path = $target_path . $filename;
                $file_extensions_allowed = array(
                    'jpg',
                    'jpeg',
                    'png',
                    'gif',
                    'bmp',
                    'swf'
                );
                $ext = strtolower(substr(strrchr($_FILES['uploadbanner']['name'], '.'), 1));
                if (!in_array($ext, $file_extensions_allowed)) {
                    $exts = implode(', ', $file_extensions_allowed);
                    echo 'You must upload a file with one of the following extensions: ' . $exts;
                    exit;
                }
                if (move_uploaded_file($_FILES['uploadbanner']['tmp_name'], $target_path)) {
                    list($width, $height, $type, $attr) = getimagesize($target_path);
                    $size = $width . 'x' . $height;
                    $this->admin->db->query("UPDATE banners SET banner_name='" . CoreHelp::sanitizeSQL($filename) . "',banner_alt='" . CoreHelp::sanitizeSQL($banner_alt) . "',banner_size='" . CoreHelp::sanitizeSQL($size) . "' WHERE banner_id='" . CoreHelp::sanitizeSQL($banner_id) . "'");
                    $this->smarty->assign('banner_saved', 'y');
                } else {
                    $this->smarty->assign('banner_saved', 'error');
                }
            } else {
                $banner_alt = CoreHelp::GetQuery('banner_alt');
                $banner_id = CoreHelp::GetQuery('banner_id');
                $this->admin->db->query("UPDATE banners SET banner_alt='" . CoreHelp::sanitizeSQL($banner_alt) . "' WHERE banner_id='" . CoreHelp::sanitizeSQL($banner_id) . "'");
                $this->smarty->assign('banner_saved', 'y');
            }
        }
        $result = $this->admin->db->query('SELECT * FROM banners');
        $this->smarty->assign('banners', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'banners'
        ));
        $this->smarty->display('banners.tpl');
    }

    public function getTextads()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        if (CoreHelp::GetQuery('del', '')) {
            if (DEMO) {
                CoreHelp::setSession('error', 'Cannot delete textads in demo mode');
                CoreHelp::redirect('back');
            }
            $del = CoreHelp::GetQuery('del');
            $this->admin->db->query("DELETE FROM textads WHERE textad_id='" . CoreHelp::sanitizeSQL($del) . "'");
            $this->smarty->assign('textads_deleted', 'y');
        }
        $result = $this->admin->db->query('SELECT * FROM textads');
        $this->smarty->assign('textads', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'textads'
        ));
        $this->smarty->display('textads.tpl');
    }

    public function postTextads()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('addnew', '')) {
            $textad_heading = CoreHelp::GetQuery('textad_heading');
            $textad_line1 = CoreHelp::GetQuery('textad_line1');
            $textad_line2 = CoreHelp::GetQuery('textad_line2');
            $textad_domain = CoreHelp::GetQuery('textad_domain');
            $this->admin->db->query("INSERT INTO textads SET textad_heading='" . CoreHelp::sanitizeSQL($textad_heading) . "',textad_line1='" . CoreHelp::sanitizeSQL($textad_line1) . "',textad_line2='" . CoreHelp::sanitizeSQL($textad_line2) . "',textad_domain='" . CoreHelp::sanitizeSQL($textad_domain) . "'");
            $this->smarty->assign('textads_saved', 'y');
        }
        if (CoreHelp::GetQuery('update', '')) {
            $textad_heading = CoreHelp::GetQuery('textad_heading');
            $textad_line1 = CoreHelp::GetQuery('textad_line1');
            $textad_line2 = CoreHelp::GetQuery('textad_line2');
            $textad_domain = CoreHelp::GetQuery('textad_domain');
            $textad_id = CoreHelp::GetQuery('textad_id');
            $this->admin->db->query("UPDATE textads SET textad_heading='" . CoreHelp::sanitizeSQL($textad_heading) . "',textad_line1='" . CoreHelp::sanitizeSQL($textad_line1) . "',textad_line2='" . CoreHelp::sanitizeSQL($textad_line2) . "',textad_domain='" . CoreHelp::sanitizeSQL($textad_domain) . "' WHERE textad_id='" . CoreHelp::sanitizeSQL($textad_id) . "'");
            $this->smarty->assign('textads_saved', 'y');
        }
        $result = $this->admin->db->query('SELECT * FROM textads');
        $this->smarty->assign('textads', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'textads'
        ));
        $this->smarty->display('textads.tpl');
    }

    public function getOptin()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('del', '')) {
            $del = CoreHelp::GetQuery('del');
            $this->admin->db->query("DELETE FROM optin WHERE optin_id='" . CoreHelp::sanitizeSQL($del) . "'");
            $this->smarty->assign('optin_deleted', 'y');
        }
        $result = $this->admin->db->query('SELECT * FROM optin');
        $this->smarty->assign('optin', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'optin'
        ));
        $this->smarty->display('opt-in.tpl');
    }

    public function postOptin()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('addnew', '')) {
            $optin_title = CoreHelp::GetQuery('optin_title');
            $optin_body = CoreHelp::GetQuery('optin_body');
            $this->admin->db->query("INSERT INTO optin SET optin_title='" . CoreHelp::sanitizeSQL($optin_title) . "',optin_body='" . CoreHelp::sanitizeSQL($optin_body) . "'");
            $this->smarty->assign('optin_saved', 'y');
        }
        if (CoreHelp::GetQuery('update', '')) {
            $optin_title = CoreHelp::GetQuery('optin_title');
            $optin_body = CoreHelp::GetQuery('optin_body');
            $optin_id = CoreHelp::GetQuery('optin_id');
            $this->admin->db->query("UPDATE optin SET optin_title='" . CoreHelp::sanitizeSQL($optin_title) . "',optin_body='" . CoreHelp::sanitizeSQL($optin_body) . "' WHERE optin_id='" . CoreHelp::sanitizeSQL($optin_id) . "'");
            $this->smarty->assign('optin_saved', 'y');
        }
        $result = $this->admin->db->query('SELECT * FROM optin');
        $this->smarty->assign('optin', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'optin'
        ));
        $this->smarty->display('opt-in.tpl');
    }

    public function getMassmail()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';

        $this->admin->CheckLogin();


        $memberships = $this->admin->GetMemberships();
        $memberships[] = 'FREE';
        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'massmail'
        ));
        $this->smarty->display('massmail.tpl');
    }

    public function postMassmail()
    {
        if (DEMO) {
            CoreHelp::setSession('error', 'Cannot send mass mailing in demo mode');
            CoreHelp::redirect('back');
        }
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->admin->CheckLogin();

        if (CoreHelp::GetQuery('memberships', '')) {
            foreach (CoreHelp::GetQuery('memberships') as $membership) {
                if ($membership == 'FREE') {
                    $membership = '0';
                }
                $members .= " or membership = '$membership'";
            }
            $mailing = $this->admin->db->query("SELECT * FROM members WHERE membership='xxx' $members AND email_from_company='1'");

            ob_end_clean();
            header("Connection: close");
            ignore_user_abort(1);
            set_time_limit(0);
            ob_start();
            $_SESSION['message'] = 'Emails are being sent in the backgroud.';
            echo('<script>window.location="/admin/massmail"</script>');
            $size = ob_get_length();
            header("Content-Length: $size");
            session_write_close();
            ob_end_flush();
            flush();

            foreach ($mailing as $row) {
                $member_id = $row['member_id'];
                $firstname = $this->admin->dec($row['first_name']);
                $lastname = $this->admin->dec($row['last_name']);
                $email = $this->admin->dec($row['email']);
                $username = $this->admin->dec($row['username']);
                $passwd = $this->admin->dec($row['password']);
                $message = CoreHelp::GetQuery('content');
                $siteTitle = $this->admin->GetSiteSetting('site_name');
                $admin_email = $this->admin->GetSiteSetting('admin_email');
                $message = preg_replace("/\[FirstName\]/", $firstname, $message);
                $message = preg_replace("/\[LastName\]/", $lastname, $message);
                $message = preg_replace("/\[MemberID\]/", $member_id, $message);
                $message = preg_replace("/\[Username\]/", $username, $message);
                $message = preg_replace("/\[Password\]/", $passwd, $message);
                $message = preg_replace("/\[SiteTitle\]/", $siteTitle, $message);
                $subject = CoreHelp::GetQuery('subject');
                $subject = preg_replace("/\[FirstName\]/", $firstname, $subject);
                $subject = preg_replace("/\[LastName\]/", $lastname, $subject);
                $subject = preg_replace("/\[MemberID\]/", $member_id, $subject);
                $subject = preg_replace("/\[Username\]/", $username, $subject);
                $subject = preg_replace("/\[Password\]/", $passwd, $subject);
                $subject = preg_replace("/\[SiteTitle\]/", $siteTitle, $subject);
                $emailHeader = 'From: ' . $admin_email . "\r\n";
                CoreHelp::sendMail($email, $subject, $message, $emailHeader);
            }
            exit;

        } else {
            $this->smarty->assign('select_membership', 'y');
            $this->smarty->assign('subject', CoreHelp::GetQuery('subject'));
            $this->smarty->assign('body', CoreHelp::GetQuery('body'));
        }
        $memberships = $this->admin->GetMemberships();
        $memberships[] = 'FREE';
        $this->smarty->assign('memberships', $memberships);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'massmail'
        ));
        $this->smarty->display('massmail.tpl');
    }

    public function getFaq()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('del', '')) {
            $del = CoreHelp::GetQuery('del');
            $this->admin->db->query("DELETE FROM faq WHERE id='" . CoreHelp::sanitizeSQL($del) . "'");
            $this->smarty->assign('faq_deleted', 'y');
        }
        $result = $this->admin->db->query('SELECT * FROM faq');
        $this->smarty->assign('faq', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'faq'
        ));
        $this->smarty->display('faq.tpl');
    }

    public function postFaq()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('addnew', '')) {
            $question = CoreHelp::GetQuery('question');
            $answer = CoreHelp::GetQuery('answer');
            $this->admin->db->query("INSERT INTO faq SET question='" . CoreHelp::sanitizeSQL($question) . "',answer='" . CoreHelp::sanitizeSQL($answer) . "', order_index = 0");
            $this->smarty->assign('faq_saved', 'y');
        }
        if (CoreHelp::GetQuery('update', '')) {
            $question = CoreHelp::GetQuery('question');
            $answer = CoreHelp::GetQuery('answer');
            $id = CoreHelp::GetQuery('id');
            $this->admin->db->query("UPDATE faq SET question='" . CoreHelp::sanitizeSQL($question) . "',answer='" . CoreHelp::sanitizeSQL($answer) . "' WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
            $this->smarty->assign('faq_saved', 'y');
        }
        $result = $this->admin->db->query('SELECT * FROM faq');
        $this->smarty->assign('faq', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'faq'
        ));
        $this->smarty->display('faq.tpl');
    }

    public function anyMessages()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $lang = CoreHelp::getLang('admin');
        $memberId = 1;
        $msgid = md5(uniqid());
        if (CoreHelp::GetQuery('subject')) {
            if (CoreHelp::GetQuery('to') == "all") {
                $res = $this->member->db->query("SELECT member_id,username FROM members ORDER BY member_id ASC");
                if (count($res) > 0) {
                    foreach ($res as $row) {
                        $this->messages->sendmessage($row[member_id], $memberId, CoreHelp::GetQuery('subject'), CoreHelp::GetQuery('message'), CoreHelp::GetQuery('priority'), "all_members", $msgid);
                    }
                    CoreHelp::setSession('message', $lang['your_messages_proceed_succesfully']);
                    CoreHelp::redirect('back');
                } else {
                    CoreHelp::setSession('error', $lang['your_have_not_referrals']);
                    CoreHelp::redirect('back');
                }
            } else {
                $this->messages->sendmessage(CoreHelp::GetQuery('to'), $memberId, CoreHelp::GetQuery('subject'), CoreHelp::GetQuery('message'), CoreHelp::GetQuery('priority'), "normal", $msgid);
                CoreHelp::setSession('message', $lang['your_message_sent_succesfully']);
                CoreHelp::redirect('back');
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

        $directsData = $this->messages->db->query("SELECT member_id,username FROM members ORDER BY username ASC");

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

    public function getNews()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('del', '')) {
            $del = CoreHelp::GetQuery('del');
            $this->admin->db->query("DELETE FROM news WHERE id='" . CoreHelp::sanitizeSQL($del) . "'");
            $this->smarty->assign('news_deleted', 'y');
        }
        $result = $this->admin->db->query('SELECT * FROM news');
        $this->smarty->assign('news', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'news'
        ));
        $this->smarty->display('news.tpl');
    }

    public function postNews()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('addnew', '')) {
            $title = CoreHelp::GetQuery('title');
            $body = CoreHelp::GetQuery('body');
            $time = time();
            $this->admin->db->query("INSERT INTO news SET title='" . CoreHelp::sanitizeSQL($title) . "',body='" . CoreHelp::sanitizeSQL($body) . "'");
            $this->smarty->assign('news_saved', 'y');
        }
        if (CoreHelp::GetQuery('update', '')) {
            $title = CoreHelp::GetQuery('title');
            $body = CoreHelp::GetQuery('body');
            $id = CoreHelp::GetQuery('id');
            $time = time();
            $this->admin->db->query("UPDATE news SET title='" . CoreHelp::sanitizeSQL($title) . "',body='" . CoreHelp::sanitizeSQL($body) . "' WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
            $this->smarty->assign('news_saved', 'y');
        }
        $result = $this->admin->db->query('SELECT * FROM news');
        $this->smarty->assign('news', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'tools',
            'sub' => 'news'
        ));
        $this->smarty->display('news.tpl');
    }

    public function getProcessors()
    {
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');

        $result = $this->admin->db->query('SELECT * FROM payment_processors');
        $this->smarty->assign('processors', $result);

        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'processors'
        ));
        $this->smarty->display('processors.tpl');
    }

    public function postProcessors()
    {
        $this->admin->CheckLogin();
        $pid = $this->admin->enc(CoreHelp::GetQuery('processor_id', ''));
        $active = ($this->admin->enc(CoreHelp::GetQuery('active', '')) == 'on') ? '1' : '0';
        $active_withdrawal = ($this->admin->enc(CoreHelp::GetQuery('active_withdrawal', '')) == 'on') ? '1' : '0';
        $fee_flat = $this->admin->enc(CoreHelp::GetQuery('fee_flat', ''));
        $fee_percent = $this->admin->enc(CoreHelp::GetQuery('fee_percent', ''));
        $account_id = $this->admin->enc(CoreHelp::GetQuery('account_id', ''));
        $extra_code = $this->admin->db->queryFirstField('SELECT extra_code FROM payment_processors WHERE processor_id = %d', $pid);
        if ($extra_code) {
            $extra_code = unserialize($extra_code);
            foreach ($extra_code as $key => $value) {
                $new_extra_code[$key] = CoreHelp::GetQuery($key, '');
            }
        }
        $extra = $new_extra_code ? serialize($new_extra_code) : '';
        $this->admin->db->query("UPDATE payment_processors SET active='" . CoreHelp::sanitizeSQL($active) . "', active_withdrawal='" . CoreHelp::sanitizeSQL($active_withdrawal) . "', fee_flat='" . CoreHelp::sanitizeSQL($fee_flat) . "', fee_percent='" . CoreHelp::sanitizeSQL($fee_percent) . "', account_id='" . CoreHelp::sanitizeSQL($account_id) . "',extra_code='" . CoreHelp::sanitizeSQL($extra) . "' WHERE processor_id='" . CoreHelp::sanitizeSQL($pid) . "'");
        $this->smarty->assign('processor_updated', 'y');
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $result = $this->admin->db->query('SELECT * FROM payment_processors');
        $this->smarty->assign('processors', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'settings',
            'sub' => 'processors'
        ));
        $this->smarty->display('processors.tpl');
    }

    public function getMyvault()
    {

        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');

        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('del', '')) {
            if (DEMO) {
                CoreHelp::setSession('error', 'Cannot delete a download in demo mode');
                CoreHelp::redirect('back');
            }

            $del = CoreHelp::GetQuery('del');
            $filename = $this->core->FirstField("SELECT filename FROM downloader WHERE id='" . CoreHelp::sanitizeSQL($del) . "'");
            unlink($target_path . $filename);
            $this->admin->db->query("DELETE FROM downloader WHERE id='" . CoreHelp::sanitizeSQL($del) . "'");
            $this->smarty->assign('download_deleted', 'y');
        }

        $category = CoreHelp::GetQuery('category');
        if ($category != 'all' && $category != '') {
            $moresql = " WHERE category='" . CoreHelp::sanitizeSQL($category) . "' ";
        }
        $result = $this->admin->db->query("SELECT * FROM downloader $moresql");
        $this->smarty->assign('downloads', $result);
        $memberships = $this->admin->GetMemberships();
        $this->smarty->assign('memberships', $memberships);
        if ($handle = opendir($target_path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    $filex = $this->core->FirstField("SELECT id FROM downloader WHERE filename='" . addslashes($file) . "'", '');
                    if ($this->admin->file_extension($file) == 'php' or $this->admin->file_extension($file) == 'htaccess' or $filex != '') {
                        continue;
                    }
                    $files[] = $file;
                }
            }
            closedir($handle);
        }
        if ($files) {
            sort($files);
        }
        $this->smarty->assign('files', $files);
        $result = $this->admin->db->query('SELECT distinct category FROM downloader');
        $this->smarty->assign('category', $result);

        $result = $this->admin->db->query('SELECT member_id,username FROM members');

        $this->smarty->assign('members12', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'digital_products',
            'sub' => 'downloads'
        ));
        $this->smarty->display('myvault.tpl');
    }

    public function postMyvault()
    {
// 		ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('upload', '')) {
            $target_path = 'files/';
            // $target_path = '/htdocs/files';


            $rand = rand(1, 10000);
            $description = CoreHelp::GetQuery('description');
            $featured = CoreHelp::GetQuery('featured');
            $title = CoreHelp::GetQuery('title');
            $membership = CoreHelp::GetQuery('membership');
            $category = CoreHelp::GetQuery('category');
            $newcategory = CoreHelp::GetQuery('new_category');
            // $memberid = 0;
            $memberid = CoreHelp::GetQuery('memberid');
            if (!$category) {
                $category = $newcategory;
            }
            if ($_FILES['uploaddownload']['name'] != '') {
                $filename = $rand . '_' . basename($_FILES['uploaddownload']['name']);
                $target_path = $target_path . $filename;
                $file_extensions_allowed = array(
                    'rar',
                    'zip',
                    'exe',
                    '7z',
                    'tgz',
                    'gz',
                    'tar',
                    'avi',
                    'wmv',
                    'mpg',
                    'mpeg',
                    'flv',
                    'mkv',
                    'wav',
                    'mp3',
                    'mp4',
                    'jpg',
                    'jpeg',
                    'gif',
                    'swf',
                    'png',
                    'bmp',
                    'pdf'
                );
                $ext = strtolower(substr(strrchr($_FILES['uploaddownload']['name'], '.'), 1));
                if (!in_array($ext, $file_extensions_allowed)) {
                    $exts = implode(', ', $file_extensions_allowed);
                    echo 'You must upload a file with one of the following extensions: ' . $exts;
                    exit;
                }
                if (move_uploaded_file($_FILES['uploaddownload']['tmp_name'], $target_path)) {
                    $filesize = filesize($target_path);
                    $this->admin->db->query("INSERT INTO downloader SET memberid=" . CoreHelp::sanitizeSQL($memberid) . ",filename='" . addslashes($filename) . "',description='" . CoreHelp::sanitizeSQL($description) . "',title='" . CoreHelp::sanitizeSQL($title) . "',minium_membership='" . CoreHelp::sanitizeSQL($membership) . "',featured='" . CoreHelp::sanitizeSQL($featured) . "',size='" . CoreHelp::sanitizeSQL($filesize) . "',category='" . CoreHelp::sanitizeSQL($category) . "'");
                    $this->smarty->assign('download_saved', 'y');
                } else {
                    $this->smarty->assign('download_saved', 'error');
                }
            }
            if (CoreHelp::GetQuery('from_directory', '')) {
                $filename = CoreHelp::GetQuery('from_directory');
                $target_path = $target_path . $filename;
                $filesize = filesize($target_path);
                $this->admin->db->query("INSERT INTO downloader SET memberid=" . sanitizeSQL($memberid) . ",filename='" . addslashes($filename) . "',description='" . CoreHelp::sanitizeSQL($description) . "',title='" . CoreHelp::sanitizeSQL($title) . "',minium_membership='" . CoreHelp::sanitizeSQL($membership) . "',featured='" . CoreHelp::sanitizeSQL($featured) . "',size='" . CoreHelp::sanitizeSQL($filesize) . "',category='" . CoreHelp::sanitizeSQL($category) . "'");
                $this->smarty->assign('download_saved', 'y');
            }
        }
        if (CoreHelp::GetQuery('uploadupdate', '')) {

            $rand = rand(1, 10000);
            $description = CoreHelp::GetQuery('description');
            $featured = CoreHelp::GetQuery('featured');
            $title = CoreHelp::GetQuery('title');
            $membership = CoreHelp::GetQuery('membership');
            $id = CoreHelp::GetQuery('download_id');
            $category = CoreHelp::GetQuery('category');
            $newcategory = CoreHelp::GetQuery('new_category');
            if (!$category) {
                $category = $newcategory;
            }
            if ($_FILES['uploaddownload']['name']) {
                $filename = $rand . '_' . basename($_FILES['uploaddownload']['name']);
                $target_path = $target_path . $filename;
                $file_extensions_allowed = array(
                    'rar',
                    'zip',
                    'exe',
                    '7z',
                    'tgz',
                    'gz',
                    'tar',
                    'avi',
                    'wmv',
                    'mpg',
                    'mpeg',
                    'flv',
                    'mkv',
                    'wav',
                    'mp3',
                    'mp4',
                    'jpg',
                    'jpeg',
                    'gif',
                    'swf',
                    'png',
                    'bmp',
                    'pdf'
                );
                $ext = strtolower(substr(strrchr($_FILES['uploaddownload']['name'], '.'), 1));
                if (!in_array($ext, $file_extensions_allowed)) {
                    $exts = implode(', ', $file_extensions_allowed);
                    echo 'You must upload a file with one of the following extensions: ' . $exts;
                    exit;
                }
                if (move_uploaded_file($_FILES['uploaddownload']['tmp_name'], $target_path)) {
                    $filesize = filesize($target_path);
                    $this->admin->db->query("UPDATE downloader SET filename='" . CoreHelp::sanitizeSQL($filename) . "',description='" . CoreHelp::sanitizeSQL($description) . "',title='" . CoreHelp::sanitizeSQL($title) . "',minium_membership='" . CoreHelp::sanitizeSQL($membership) . "',featured='" . CoreHelp::sanitizeSQL($featured) . "',size='" . CoreHelp::sanitizeSQL($filesize) . "',category='" . CoreHelp::sanitizeSQL($category) . "' WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
                    $this->smarty->assign('download_saved', 'y');
                } else {
                    $this->smarty->assign('download_saved', 'error');
                }
            } elseif (CoreHelp::GetQuery('from_directory', '')) {
                $filename = CoreHelp::GetQuery('from_directory');
                $target_path = $target_path . $filename;
                $filesize = filesize($target_path);
                $this->admin->db->query("UPDATE downloader SET filename='" . CoreHelp::sanitizeSQL($filename) . "',description='" . CoreHelp::sanitizeSQL($description) . "',title='" . CoreHelp::sanitizeSQL($title) . "',minium_membership='" . CoreHelp::sanitizeSQL($membership) . "',featured='" . CoreHelp::sanitizeSQL($featured) . "',size='" . CoreHelp::sanitizeSQL($filesize) . "',category='" . CoreHelp::sanitizeSQL($category) . "' WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
                $this->smarty->assign('download_saved', 'y');
            } else {
                $this->admin->db->query("UPDATE downloader SET  description='" . CoreHelp::sanitizeSQL($description) . "',title='" . CoreHelp::sanitizeSQL($title) . "',minium_membership='" . CoreHelp::sanitizeSQL($membership) . "',featured='" . CoreHelp::sanitizeSQL($featured) . "',category='" . CoreHelp::sanitizeSQL($category) . "' WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
                $this->smarty->assign('download_saved', 'y');
            }
        }

        $category = CoreHelp::GetQuery('category');
        if ($category != 'all' && $category != '') {
            $moresql = " WHERE category='" . CoreHelp::sanitizeSQL($category) . "' ";
        }
        $result = $this->admin->db->query("SELECT * FROM downloader $moresql");
        $this->smarty->assign('downloads', $result);
        $memberships = $this->admin->GetMemberships();
        $this->smarty->assign('memberships', $memberships);
        if ($handle = opendir($target_path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    $filex = $this->core->FirstField("SELECT id FROM downloader WHERE filename='" . addslashes($file) . "'", '');
                    if ($this->admin->file_extension($file) == 'php' or $this->admin->file_extension($file) == 'htaccess' or $filex != '') {
                        continue;
                    }
                    $files[] = $file;
                }
            }
            closedir($handle);
        }
        if ($files) {
            sort($files);
        }
        $this->smarty->assign('files', $files);
        $result = $this->admin->db->query('SELECT distinct category FROM downloader');
        $this->smarty->assign('category', $result);

        $result = $this->admin->db->query('SELECT member_id,username FROM members');

        $this->smarty->assign('members12', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'digital_products',
            'sub' => 'downloads'
        ));
        $this->smarty->display('myvault.tpl');
    }

    public function getDownloads()
    {

        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');

        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('del', '')) {
            if (DEMO) {
                CoreHelp::setSession('error', 'Cannot delete a download in demo mode');
                CoreHelp::redirect('back');
            }

            $del = CoreHelp::GetQuery('del');
            $filename = $this->core->FirstField("SELECT filename FROM infobank WHERE id='" . CoreHelp::sanitizeSQL($del) . "'");
            unlink($target_path . $filename);
            $this->admin->db->query("DELETE FROM infobank WHERE id='" . CoreHelp::sanitizeSQL($del) . "'");
            $this->smarty->assign('download_deleted', 'y');
        }

        $category = CoreHelp::GetQuery('category');
        if ($category != 'all' && $category != '') {
            $moresql = " WHERE category='" . CoreHelp::sanitizeSQL($category) . "' ";
        }
        $result = $this->admin->db->query("SELECT * FROM infobank $moresql");
        $this->smarty->assign('downloads', $result);
        $memberships = $this->admin->GetMemberships();
        $this->smarty->assign('memberships', $memberships);
        if ($handle = opendir($target_path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    $filex = $this->core->FirstField("SELECT id FROM infobank WHERE filename='" . addslashes($file) . "'", '');
                    if ($this->admin->file_extension($file) == 'php' or $this->admin->file_extension($file) == 'htaccess' or $filex != '') {
                        continue;
                    }
                    $files[] = $file;
                }
            }
            closedir($handle);
        }
        if ($files) {
            sort($files);
        }
        $this->smarty->assign('files', $files);
        $result = $this->admin->db->query('SELECT distinct category FROM infobank');
        $this->smarty->assign('category', $result);

        $result = $this->admin->db->query('SELECT member_id,username FROM members');

        $this->smarty->assign('members12', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'digital_products',
            'sub' => 'downloads'
        ));
        $this->smarty->display('downloads.tpl');
    }

    public function postDownloads()
    {
// 		ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
        $this->admin->CheckLogin();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');


        $site_path = $this->admin->GetSiteSetting('site_path');
        if (CoreHelp::GetQuery('upload', '')) {
            $target_path = 'files/';
            // $target_path = '/htdocs/files';


            $rand = rand(1, 10000);
            $description = CoreHelp::GetQuery('description');
            $featured = CoreHelp::GetQuery('featured');
            $title = CoreHelp::GetQuery('title');
            $membership = CoreHelp::GetQuery('membership');
            $category = CoreHelp::GetQuery('category');
            $newcategory = CoreHelp::GetQuery('new_category');
            $memberid = 0;
            // $memberid = CoreHelp::GetQuery('memberid');
            if (!$category) {
                $category = $newcategory;
            }
            if ($_FILES['uploaddownload']['name'] != '') {
                $filename = $rand . '_' . basename($_FILES['uploaddownload']['name']);
                $target_path = $target_path . $filename;
                $file_extensions_allowed = array(
                    'rar',
                    'zip',
                    'exe',
                    '7z',
                    'tgz',
                    'gz',
                    'tar',
                    'avi',
                    'wmv',
                    'mpg',
                    'mpeg',
                    'flv',
                    'mkv',
                    'wav',
                    'mp3',
                    'mp4',
                    'jpg',
                    'jpeg',
                    'gif',
                    'swf',
                    'png',
                    'bmp',
                    'pdf'
                );
                $ext = strtolower(substr(strrchr($_FILES['uploaddownload']['name'], '.'), 1));
                if (!in_array($ext, $file_extensions_allowed)) {
                    $exts = implode(', ', $file_extensions_allowed);
                    echo 'You must upload a file with one of the following extensions: ' . $exts;
                    exit;
                }
                if (move_uploaded_file($_FILES['uploaddownload']['tmp_name'], $target_path)) {
                    $filesize = filesize($target_path);
                    $this->admin->db->query("INSERT INTO infobank SET memberid=" . CoreHelp::sanitizeSQL($memberid) . ",filename='" . addslashes($filename) . "',description='" . CoreHelp::sanitizeSQL($description) . "',title='" . CoreHelp::sanitizeSQL($title) . "',minium_membership='" . CoreHelp::sanitizeSQL($membership) . "',featured='" . CoreHelp::sanitizeSQL($featured) . "',size='" . CoreHelp::sanitizeSQL($filesize) . "',category='" . CoreHelp::sanitizeSQL($category) . "'");
                    $this->smarty->assign('download_saved', 'y');
                } else {
                    $this->smarty->assign('download_saved', 'error');
                }
            }
            if (CoreHelp::GetQuery('from_directory', '')) {
                $filename = CoreHelp::GetQuery('from_directory');
                $target_path = $target_path . $filename;
                $filesize = filesize($target_path);
                $this->admin->db->query("INSERT INTO infobank SET memberid=" . sanitizeSQL($memberid) . ",filename='" . addslashes($filename) . "',description='" . CoreHelp::sanitizeSQL($description) . "',title='" . CoreHelp::sanitizeSQL($title) . "',minium_membership='" . CoreHelp::sanitizeSQL($membership) . "',featured='" . CoreHelp::sanitizeSQL($featured) . "',size='" . CoreHelp::sanitizeSQL($filesize) . "',category='" . CoreHelp::sanitizeSQL($category) . "'");
                $this->smarty->assign('download_saved', 'y');
            }
        }
        if (CoreHelp::GetQuery('uploadupdate', '')) {

            $rand = rand(1, 10000);
            $description = CoreHelp::GetQuery('description');
            $featured = CoreHelp::GetQuery('featured');
            $title = CoreHelp::GetQuery('title');
            $membership = CoreHelp::GetQuery('membership');
            $id = CoreHelp::GetQuery('download_id');
            $category = CoreHelp::GetQuery('category');
            $newcategory = CoreHelp::GetQuery('new_category');
            if (!$category) {
                $category = $newcategory;
            }
            if ($_FILES['uploaddownload']['name']) {
                $filename = $rand . '_' . basename($_FILES['uploaddownload']['name']);
                $target_path = $target_path . $filename;
                $file_extensions_allowed = array(
                    'rar',
                    'zip',
                    'exe',
                    '7z',
                    'tgz',
                    'gz',
                    'tar',
                    'avi',
                    'wmv',
                    'mpg',
                    'mpeg',
                    'flv',
                    'mkv',
                    'wav',
                    'mp3',
                    'mp4',
                    'jpg',
                    'jpeg',
                    'gif',
                    'swf',
                    'png',
                    'bmp',
                    'pdf'
                );
                $ext = strtolower(substr(strrchr($_FILES['uploaddownload']['name'], '.'), 1));
                if (!in_array($ext, $file_extensions_allowed)) {
                    $exts = implode(', ', $file_extensions_allowed);
                    echo 'You must upload a file with one of the following extensions: ' . $exts;
                    exit;
                }
                if (move_uploaded_file($_FILES['uploaddownload']['tmp_name'], $target_path)) {
                    $filesize = filesize($target_path);
                    $this->admin->db->query("UPDATE infobank SET filename='" . CoreHelp::sanitizeSQL($filename) . "',description='" . CoreHelp::sanitizeSQL($description) . "',title='" . CoreHelp::sanitizeSQL($title) . "',minium_membership='" . CoreHelp::sanitizeSQL($membership) . "',featured='" . CoreHelp::sanitizeSQL($featured) . "',size='" . CoreHelp::sanitizeSQL($filesize) . "',category='" . CoreHelp::sanitizeSQL($category) . "' WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
                    $this->smarty->assign('download_saved', 'y');
                } else {
                    $this->smarty->assign('download_saved', 'error');
                }
            } elseif (CoreHelp::GetQuery('from_directory', '')) {
                $filename = CoreHelp::GetQuery('from_directory');
                $target_path = $target_path . $filename;
                $filesize = filesize($target_path);
                $this->admin->db->query("UPDATE infobank SET filename='" . CoreHelp::sanitizeSQL($filename) . "',description='" . CoreHelp::sanitizeSQL($description) . "',title='" . CoreHelp::sanitizeSQL($title) . "',minium_membership='" . CoreHelp::sanitizeSQL($membership) . "',featured='" . CoreHelp::sanitizeSQL($featured) . "',size='" . CoreHelp::sanitizeSQL($filesize) . "',category='" . CoreHelp::sanitizeSQL($category) . "' WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
                $this->smarty->assign('download_saved', 'y');
            } else {
                $this->admin->db->query("UPDATE infobank SET  description='" . CoreHelp::sanitizeSQL($description) . "',title='" . CoreHelp::sanitizeSQL($title) . "',minium_membership='" . CoreHelp::sanitizeSQL($membership) . "',featured='" . CoreHelp::sanitizeSQL($featured) . "',category='" . CoreHelp::sanitizeSQL($category) . "' WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
                $this->smarty->assign('download_saved', 'y');
            }
        }

        $category = CoreHelp::GetQuery('category');
        if ($category != 'all' && $category != '') {
            $moresql = " WHERE category='" . CoreHelp::sanitizeSQL($category) . "' ";
        }
        $result = $this->admin->db->query("SELECT * FROM infobank $moresql");
        $this->smarty->assign('downloads', $result);
        $memberships = $this->admin->GetMemberships();
        $this->smarty->assign('memberships', $memberships);
        if ($handle = opendir($target_path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    $filex = $this->core->FirstField("SELECT id FROM infobank WHERE filename='" . addslashes($file) . "'", '');
                    if ($this->admin->file_extension($file) == 'php' or $this->admin->file_extension($file) == 'htaccess' or $filex != '') {
                        continue;
                    }
                    $files[] = $file;
                }
            }
            closedir($handle);
        }
        if ($files) {
            sort($files);
        }
        $this->smarty->assign('files', $files);
        $result = $this->admin->db->query('SELECT distinct category FROM infobank');
        $this->smarty->assign('category', $result);

        $result = $this->admin->db->query('SELECT member_id,username FROM members');

        $this->smarty->assign('members12', $result);
        CoreHelp::setSession('menu', array(
            'main' => 'digital_products',
            'sub' => 'downloads'
        ));
        $this->smarty->display('downloads.tpl');
    }

    public function getLoginmember()
    {
        $this->admin->CheckLogin();
        $id = CoreHelp::GetQuery('id');
        $username = $this->core->FirstField("SELECT username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
        CoreHelp::setSession('Username', $username);
        CoreHelp::setSession('MemberID', $id);
        CoreHelp::redirect('/members');
    }

    public function postLoginmember()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->admin->CheckLogin();
        $id = CoreHelp::GetQuery('id');
        $username = $this->core->FirstField("SELECT username FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
        $password = $this->core->FirstField("SELECT password FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
        echo '<form name="myForm" action="' . $site_url . 'index.php/members/login" method="post">
				<input id="username" name="username" type="hidden" value="' . $username . '" />
				<input id="password" name="password" type="hidden" value="' . $password . '" />
				<input type="hidden" name="login" value="LOGIN" >
			</form>
			<script>
		document.myForm.submit();
		</script>

	';
    }

    public function anyUpgrademember()
    {
        $this->smarty->template_dir = 'system/app/views/admin/';


        $this->admin->CheckLogin();
        $id = CoreHelp::GetQuery('id');
        $membership = CoreHelp::GetQuery('m');
        $ad_credits = $this->core->GetSiteSetting($membership . "_adcredit_startup");
        if ($ad_credits > 0) {
            $this->member->db->query("UPDATE members SET ad_credits=ad_credits+$ad_credits WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
            $this->core->insertAdCreditLog($id, 'start_up_bonus', $ad_credits, $lang['start_up_bonus']);
        }
        $this->admin->db->query("UPDATE members SET membership='" . CoreHelp::sanitizeSQL($membership) . "' WHERE member_id='" . CoreHelp::sanitizeSQL($id) . "'");
        CoreHelp::redirect('/admin/members/&payed=yes');
    }

    public function getBackup()
    {
        $this->admin->CheckLogin();


        $settings = $this->admin->GetSiteSettings();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->smarty->assign('site_url', $settings['site_url']);
        $this->smarty->assign('settings', $settings);
        $this->smarty->display('nodemo.tpl');
    }

    public function getOptimize()
    {
        $this->admin->CheckLogin();


        $settings = $this->admin->GetSiteSettings();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->smarty->assign('site_url', $settings['site_url']);
        $tables = $this->admin->db->query("SHOW TABLES");
        foreach ($tables as $key => $table) {
            $rTable = reset($table);
            $aTable[] = $this->admin->db->queryFirstRow("ANALYZE TABLE " . $rTable);
        }
        $this->smarty->assign('analyzed_tables', $aTable);
        $this->smarty->display('optimize.tpl');
    }

    public function postOptimize()
    {
        $this->admin->CheckLogin();


        $settings = $this->admin->GetSiteSettings();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $this->smarty->assign('site_url', $settings['site_url']);
        $tables = $this->admin->db->query("SHOW TABLES");
        foreach ($tables as $key => $table) {
            $rTable = reset($table);
            $this->admin->db->queryFirstRow("OPTIMIZE TABLE " . $rTable);
        }
        CoreHelp::setSession('message', 'All database tables optimized successfully');
        CoreHelp::redirect('back');
    }

    public function getCache()
    {
        $this->admin->CheckLogin();


        $settings = $this->admin->GetSiteSettings();
        $this->smarty->template_dir = 'system/app/views/admin/';

        if (CoreHelp::GetQuery('reset')) {
            $files = glob('storage/cache/' . "*");
            foreach ($files as $file)
                if (is_file($file)) {
                    if (time() - filemtime($file) >= 60 * 20) { // 20 minutes
                        unlink($file);
                    }
                }
            $files = glob('system/libs/smarty/templates_c/' . "*");
            foreach ($files as $file)
                if (is_file($file)) {
                    unlink($file);
                }
            CoreHelp::setSession('message', 'Cache flushed successfully');

        }

        $countDataCache = 0;
        $files = glob('storage/cache/' . "*");
        foreach ($files as $file)
            if (is_file($file)) {
                if (time() - filemtime($file) >= 60 * 20) { // 20 minutes
                    $countDataCache++;
                }
            }
        $countTemplateCache = 0;
        $files = glob('system/libs/smarty/templates_c/' . "*");
        foreach ($files as $file)
            if (is_file($file)) {
                $countTemplateCache++;
            }
        $this->smarty->assign('cache_data', $countDataCache);
        $this->smarty->assign('cache_template', $countTemplateCache);
        CoreHelp::setSession('menu', array(
            'main' => 'system',
            'sub' => 'cache'
        ));
        $this->smarty->display('cache.tpl');
    }


    public function getReminder()
    {
        $this->admin->CheckLogin();


        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');

        if (CoreHelp::GetQuery('submit', '')) {
            $date = str_replace('/', '-', CoreHelp::GetQuery('event-date'));
            $title = CoreHelp::GetQuery('event-title');
            $description = CoreHelp::GetQuery('event-text');
            $priority = CoreHelp::GetQuery('event-priority');
            if (!$date) {
                $sdate = strtotime('today');
            } else {
                $sdate = strtotime("$date");
            }
            $this->admin->db->query("INSERT INTO reminder (title,description,alert_date,priority) VALUES ('$title','$description',$sdate,$priority)");
            CoreHelp::redirect('/admin/&reminded=yes');
        }
        if (CoreHelp::GetQuery('delid', '')) {
            $id = CoreHelp::GetQuery('delid');
            $this->admin->db->query("DELETE FROM reminder WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
            CoreHelp::redirect('/admin/&remind=deleted');
        }
    }

    public function postReminder()
    {
        $this->admin->CheckLogin();


        $this->smarty->template_dir = 'system/app/views/admin/';
        $site_url = $this->admin->GetSiteSetting('site_url');

        if (CoreHelp::GetQuery('submit', '')) {
            $date = str_replace('/', '-', CoreHelp::GetQuery('event-date'));
            $title = CoreHelp::GetQuery('event-title');
            $description = CoreHelp::GetQuery('event-text');
            $priority = CoreHelp::GetQuery('event-priority');
            if (!$date) {
                $sdate = strtotime('today');
            } else {
                $sdate = strtotime("$date");
            }
            $this->admin->db->query("INSERT INTO reminder (title,description,alert_date,priority) VALUES ('$title','$description',$sdate,$priority)");
            CoreHelp::redirect('/admin/&reminded=yes');
        }
        if (CoreHelp::GetQuery('delid', '')) {
            $id = CoreHelp::GetQuery('delid');
            $this->admin->db->query("DELETE FROM reminder WHERE id='" . CoreHelp::sanitizeSQL($id) . "'");
            CoreHelp::redirect('/admin/&remind=deleted');
        }
    }

    public function anyTestmail()
    {
        $this->admin->CheckLogin();
        $email = CoreHelp::GetQuery('email');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $settings = $this->admin->GetSiteSettings();
            if ($settings['mailgate'] == 'php') {
                $emailHeader = "From: " . $settings['admin_email'] . "\r\n";
                CoreHelp::sendMail($email, 'Test Mail Successful!', 'Congratulations', $emailHeader);
                echo "Email sent using internal php mailgate";
            } else {

                try {
                    $is_ssl = $settings['mailgate'] == 'smtp_ssl' ? 'ssl' : '';
                    //echo $settings['mailgate'] . ' ' .$settings['smtp_host'].' '.$settings['smtp_port'].' '.$settings['smtp_login'] .' '.$settings['smtp_password'];
                    $transporter = Swift_SmtpTransport::newInstance($settings['smtp_host'], $settings['smtp_port'], "$is_ssl")->setUsername($settings['smtp_login'])->setPassword($settings['smtp_password']);
                    $mailer = Swift_Mailer::newInstance($transporter);
                    $message = Swift_Message::newInstance('Test Mail Successful!')->setFrom(array(
                        $settings['admin_email'] => 'Admin'
                    ))->setTo(array(
                        $email
                    ))->setBody('Congratulations');
                    $result = $mailer->send($message);
                    echo $result == 1 ? "Email sent using SMTP " . $is_ssl . " mailgate" : "There was an error sending the email, please verify the smtp details";
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }
        } else {
            echo "Please use a valid email!";
        }

    }

    public function generatedemo()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        if (php_sapi_name() != "cli") {
            $this->admin->CheckLogin();
        }
        $truncate = array(
            '`admin_log`',
            '`ad_credit_log`',
            '`entrypayment`',
            '`hits`',
            '`members`',
            '`money_out`',
            '`optin`',
            '`visitors`',
            '`wallet_deposit`',
            '`wallet_payout`',
            '`binary_volume`',
            '`binary_reports`',
            '`cycle_matrix`',
            '`matrix`',
            '`personal_volume`',
            '`group_volume`',
            '`binary_daily_pair_match_report`',
            '`binary_daily_pair_match_track`'
        );
        foreach ($truncate as $table) {
            $check = $this->core->db->query("SHOW TABLES LIKE '" . str_replace('`', '', $table) . "'");
            if ($this->core->db->count() != 0) {
                $this->core->db->query("TRUNCATE TABLE " . $table);
            }
        }

        $lang = CoreHelp::getLang('members');
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Internet($faker));
        $faker->addProvider(new Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new Faker\Provider\en_US\PhoneNumber($faker));
        $RegDate = time() - 20000 * 60 * 15;
        for ($i = 1; $i <= 20000; $i++) {
            $rand = rand(1, 10);
            for ($j = 1; $j <= $rand; $j++) {
                $vip = $faker->ipv4;
                $this->core->db->insert('visitors', array(
                    'ip_address' => $vip,
                    'country' => CoreHelp::getCountryName($vip),
                    'date' => date("Y-m-d", $RegDate - 60 * $rand)
                ));
            }
            if ($i == 1) {
                $username = "admin";
                $password = "admin";
            } elseif ($i == 2) {
                $username = "demo";
                $password = "demo";
            } else {
                $foundUsername = 0;
                while ($foundUsername == 0) {
                    $username = $faker->username;
                    $password = $faker->password;
                    $chkUser = $this->core->db->queryFirstField("SELECT member_id FROM members WHERE username = '$username'");
                    if (!$chkUser) {
                        $foundUsername = 1;
                    }
                }
            }
            $foundEmail = 0;
            while ($foundEmail == 0) {
                $email = $faker->safeEmail;
                $chkEmail = $this->core->db->queryFirstField("SELECT member_id FROM members WHERE email = '$email'");
                if (!$chkEmail) {
                    $foundEmail = 1;
                }
            }
            if (rand(0, 1) == 1) {
                $gender = 1;
                $firstname = $faker->firstNameMale;
            } else {
                $gender = 2;
                $firstname = $faker->firstNameFemale;
            }
            if (rand(0, 1) == 1) {
                $membership = $this->core->db->queryFirstField("SELECT membership FROM memberships ORDER BY RAND() LIMIT 1");
            } else {
                if ($i < 11) {
                    $membership = $this->core->db->queryFirstField("SELECT membership FROM memberships ORDER BY RAND() LIMIT 1");
                } else {
                    $membership = '0';
                }

            }
            $RegDate = $RegDate + rand(600, 1200);
            $sponsorId = $this->core->db->queryFirstField("SELECT member_id FROM members WHERE membership != '0' AND member_id < " . rand(1, 500) . " ORDER BY RAND() LIMIT 1");
            $sponsor = $sponsorId ? $sponsorId : 0;
            $this->core->db->insert('members', array(
                'username' => $username,
                'email' => $email,
                'password' => hash('sha256', $password),
                'first_name' => $firstname,
                'last_name' => $faker->lastName,
                'sponsor_id' => $sponsor,
                'reg_date' => $RegDate,
                'gender' => $gender,
                'skype' => $faker->username,
                'is_active' => 1,
                'street' => $faker->address,
                'city' => $faker->city,
                'state' => $faker->state,
                'country' => 'US',
                'processor' => '7',
                'account_id' => 'name@domain.com',
                'membership_expiration' => time() + 60 * 60 * 24 * 365,
                'postal' => $faker->postcode,
                'phone' => $faker->phoneNumber,
                'ip_address' => $faker->ipv4,
                'membership' => $membership
            ));
            $id = $this->core->db->insertId();
            if ($membership != '0') {
                $depositDate = $RegDate + rand(120, 600);
                $payDate = $RegDate + rand(900, 1200);
                $this->core->db->query("INSERT INTO wallet_deposit (amount, member_id, transaction_date, descr) 
				 VALUES ('150.00', '" . $id . "', '" . $depositDate . "', 'Deposit by Perfect Money')");
                $m_price = $this->core->GetSiteSetting($membership . "_signup_fee");
                $descr = $lang['bought'] . " $membership " . $lang['upgrade_for'] . " " . $lang['monetary'] . "$m_price";
                $this->core->db->query("INSERT INTO wallet_deposit (amount, member_id, transaction_date, descr) 
				 VALUES ('-$m_price', '" . $id . "', '" . $payDate . "', '" . $descr . "')");
                $this->core->db->query("INSERT INTO entrypayment (amount, member_id, date) 
				 VALUES ('$m_price', '" . $id . "', '" . $depositDate . "')");
                $ad_credits = $this->core->GetSiteSetting($membership . "_adcredit_startup");
                if ($ad_credits > 0) {
                    $this->core->db->query("UPDATE members SET ad_credits=ad_credits+$ad_credits WHERE member_id='" . $id . "'");
                    $this->core->insertAdCreditLog($id, 'start_up_bonus', $ad_credits, $lang['start_up_bonus']);
                }
                if ($this->core->GetSiteSetting("expiring_memberships") == 'yes') {
                    $mExpiration = $payDate + 60 * 60 * 24 * 30;
                    $this->core->db->query("UPDATE members SET membership_expiration='" . $mExpiration . "' WHERE member_id='" . $id . "'");
                }
                $this->core->db->query("UPDATE members SET membership='" . CoreHelp::sanitizeSQL($membership) . "' WHERE member_id='" . $id . "'");
            }

            $enroller_id = $this->core->FirstField("SELECT sponsor_id FROM members WHERE member_id='" . $id . "'", 0);
            $enroller_mem = $this->core->FirstField("SELECT membership FROM members WHERE member_id='" . CoreHelp::sanitizeSQL($enroller_id) . "'", 0);
            $amount = $this->core->GetSiteSetting($membership . "_signup_fee", 0);
            $spnamt = $enroller_mem . "_" . $membership . "_startup_bonus";
            $sponsor_amount = $this->core->GetSiteSetting($spnamt, 0);
            if ($sponsor_amount > 0 && $enroller_id > 0) {
                $this->core->db->query("INSERT INTO wallet_payout (amount, transaction_type, from_id, to_id, transaction_date, descr) 
				VALUES ('" . CoreHelp::sanitizeSQL($sponsor_amount) . "', '2', '" . $id . "', '" . CoreHelp::sanitizeSQL($enroller_id) . "', '" . $payDate . "', '" . $lang['sponsor_startup_bonus'] . " (" . $username . ") " . $lang['purchased'] . " " . $membership . " " . $lang['membership'] . ".')");
            }
            echo "a";
            $this->hooks->do_action('in_matrix', $id);
            echo "b";
            if ($membership != '0' && $amount > 0) {
                $this->hooks->do_action('pay_upline', $id, $amount, $membership);
            }
            echo "c";

        }
    }

    public function getViewepins()
    {
        $this->admin->CheckLogin();
        $settings = $this->admin->GetSiteSettings();
        $this->smarty->template_dir = 'system/app/views/admin/';
        $epins = $this->core->db->query("SELECT * FROM epins");
        $this->smarty->assignByRef('member', $this->member);
        $this->smarty->assign("epins", $epins);
        $this->smarty->display('view_epins.tpl');
    }

    public function getOpenwordpress()
    {
        $this->admin->CheckLogin();
        if (DEMO) {
            CoreHelp::setSession('error', 'Auto login to wordpress panel is not available on demo mode, single click auto login will be available on your production site');
            CoreHelp::redirect('/admin');
        }
        $settings = $this->admin->GetSiteSettings();
        $username = isset($settings['wordpress_admin_username']) ? $settings['wordpress_admin_username'] : 'admin';
        include('site/wp-load.php');
        $user = get_userdatabylogin($username);
        $user_id = $user->ID;
        //login
        wp_set_current_user($user_id, $username);
        wp_set_auth_cookie($user_id);
        do_action(‘wp_login’, $user_login);
        CoreHelp::redirect('/site/wp-admin');
    }
}
