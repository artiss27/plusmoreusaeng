<?php

namespace textads;

define('TEXTAD', 1);

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('advertising', '\textads\setActionMenu');
$hooks->add_action('main_admin', '\textads\setActionAdminMain');
$hooks->add_action('admin_task', '\textads\setActionAdminTask');
$hooks->add_filter('textads_links', '\textads\setFilterAdminTextAdsPending');
$hooks->add_filter('textads_links', '\textads\setFilterAdminTextAdsActive');
$hooks->add_filter('textads_links', '\textads\setFilterAdmintextadsettings');


function setActionMenu()
{
	$lang_plugin = \CoreHelp::getLangPlugin('members', 'textads');
	$class = ($_SESSION['menu']['sub'] == "textads") ? ' class="active"' : '';
    echo '<li'.$class.'><a href="/plugins/textads/manager/textads"> '.$lang_plugin['textads'].'</a></li>' . "\n";
}

function setActionAdminTask()
{
	$db    = \tmvc::instance()->controller->load->database();
	$pending  = $db->queryFirstField("SELECT COUNT(*) FROM ad_textads WHERE approved='0'");
	$class = ($pending > 0) ? ' class="blink"' : '';
    echo '<tr>
			<th>'.date('m/d/y').'</th>
			<td><a href="/plugins/textads/admin/pending" '.$class.'>('.intval($pending).') TextAds Approvals</a></td>
			<td><a href="/plugins/textads/admin/pending">Go</a></td>
		 </tr>' . "\n";
}

function setFilterAdminTextAdsPending($links)
{
	$class = ($_SESSION['menu']['sub'] == "textad_pending") ? ' class="active"' : '';
    return  $links . '<li'.$class.'><a href="/plugins/textads/admin/pending"> Pending TextAds</a></li>' . "\n";
}

function setFilterAdminTextAdsActive($links)
{
	$class = ($_SESSION['menu']['sub'] == "textad_active") ? ' class="active"' : '';
    return  $links . '<li'.$class.'><a href="/plugins/textads/admin/active"> Active TextAds</a></li>' . "\n";
}

function setFilterAdmintextadsettings($links)
{
	$class = ($_SESSION['menu']['sub'] == "textad_settings") ? ' class="active"' : '';
    return  $links . '<li'.$class.'><a href="/plugins/textads/admin/settings"> TextAds Settings</a></li>' . "\n";
}

function setActionAdminMain()
{
	$class = ($_SESSION['menu']['main'] == "textad_system") ? ' class="active"' : '';
    echo '<li'.$class.'>
                <a href="#"><span class="nav-label">TextAds</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                '.\voku\helper\Hooks::getInstance()->apply_filters('textads_links', '').'   
                </ul>
            </li>';
}

function setTable()
{
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);		
			$db    = \tmvc::instance()->controller->load->database();
			$check = $db->query("SHOW TABLES LIKE 'ad_textads'");
			if ($db->count() === 0) {
				$db->query("
				CREATE TABLE IF NOT EXISTS `ad_textads` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `member_id` int(11) NOT NULL,
				  `campaign_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				  `headline` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				  `description1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				  `description2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				  `target_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				  `countries` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
				  `ad_credit_placed` decimal(12,3) NOT NULL DEFAULT '0.000',
				  `ad_credit_used` decimal(12,3) NOT NULL DEFAULT '0.000',
				  `ad_credit_bid` decimal(12,3) NOT NULL,
				  `total_views` int(11) NOT NULL DEFAULT '0',
				  `total_clicks` int(11) NOT NULL DEFAULT '0',
				  `approved` int(11) NOT NULL DEFAULT '0',
				  `status` int(11) NOT NULL DEFAULT '0',
				  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				   PRIMARY KEY (`id`)
				)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;
				");
				$db->query("
				CREATE TABLE IF NOT EXISTS `ad_textads_clicks` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `textads_id` int(11) NOT NULL,
				  `ip_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
				  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				  `click_value` decimal(12,3) NOT NULL,
				  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`)
				)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;
				");
				
				$db->query("
				ALTER TABLE `ad_textads`
				 ADD KEY `member_id` (`member_id`), ADD KEY `countries` (`countries`), ADD KEY `ad_credit_placed` (`ad_credit_placed`), ADD KEY `ad_credit_used` (`ad_credit_used`), ADD KEY `ad_credit_bid` (`ad_credit_bid`), ADD KEY `approved` (`approved`), ADD KEY `status` (`status`);
				");		
		   }	
	}
}




?>