<?php

namespace banners;

define('ADVERTISING', 1);

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('advertising', '\banners\setActionMenu');
$hooks->add_action('main_admin', '\banners\setActionAdminMain');
$hooks->add_action('admin_task', '\banners\setActionAdminTask');
$hooks->add_filter('banner_links', '\banners\setFilterAdminBannerSizes');
$hooks->add_filter('banner_links', '\banners\setFilterAdminBannerPending');
$hooks->add_filter('banner_links', '\banners\setFilterAdminBannerActive');
$hooks->add_filter('banner_links', '\banners\setFilterAdminBannerNetwork');
$hooks->add_filter('banner_links', '\banners\setFilterAdminBannerSettings');


function setActionMenu()
{
	$lang_plugin = \CoreHelp::getLangPlugin('members', 'banners');
	$class = ($_SESSION['menu']['sub'] == "banners") ? ' class="active"' : '';
    echo '<li'.$class.'><a href="/plugins/banners/manager/banners"> '.$lang_plugin['banners'].'</a></li>' . "\n";
}

function setActionAdminTask()
{
	$db    = \tmvc::instance()->controller->load->database();
	$pending  = $db->queryFirstField("SELECT COUNT(*) FROM ad_banners WHERE approved='0'");
	$class = ($pending > 0) ? ' class="blink"' : '';
    echo '<tr>
			<th>'.date('m/d/y').'</th>
			<td><a href="/plugins/banners/badmin/pending" '.$class.'>('.intval($pending).') Banner Approvals</a></td>
			<td><a href="/plugins/banners/badmin/pending">Go</a></td>
		 </tr>' . "\n";
}

function setFilterAdminBannerSizes($links)
{
	$class = ($_SESSION['menu']['sub'] == "banner_sizes") ? ' class="active"' : '';
    return  $links . '<li'.$class.'><a href="/plugins/banners/badmin/sizes"> Banner Sizes</a></li>' . "\n";
}

function setFilterAdminBannerPending($links)
{
	$class = ($_SESSION['menu']['sub'] == "banner_pending") ? ' class="active"' : '';
    return  $links . '<li'.$class.'><a href="/plugins/banners/badmin/pending"> Pending Banners</a></li>' . "\n";
}

function setFilterAdminBannerActive($links)
{
	$class = ($_SESSION['menu']['sub'] == "banner_active") ? ' class="active"' : '';
    return  $links . '<li'.$class.'><a href="/plugins/banners/badmin/active"> Active Banners</a></li>' . "\n";
}

function setFilterAdminBannerNetwork($links)
{
	$class = ($_SESSION['menu']['sub'] == "banner_network") ? ' class="active"' : '';
    return  $links . '<li'.$class.'><a href="/plugins/banners/badmin/network"> Banners Network</a></li>' . "\n";
}

function setFilterAdminBannerSettings($links)
{
	$class = ($_SESSION['menu']['sub'] == "banner_settings") ? ' class="active"' : '';
    return  $links . '<li'.$class.'><a href="/plugins/banners/badmin/settings"> Banners Settings</a></li>' . "\n";
}

function setActionAdminMain()
{
	$class = ($_SESSION['menu']['main'] == "banner_system") ? ' class="active"' : '';
    echo '<li'.$class.'>
                <a href="#"><span class="nav-label">Banner Ads</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                '.\voku\helper\Hooks::getInstance()->apply_filters('banner_links', '').'   
                </ul>
            </li>';
}

function setTable()
{
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
		$db    = \tmvc::instance()->controller->load->database();
		$check = $db->query("SHOW TABLES LIKE 'ad_banners'");
		if ($db->count() === 0) {
			$db->query("
			CREATE TABLE IF NOT EXISTS `ad_banners` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `member_id` int(11) NOT NULL,
			  `campaign_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `banner_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `target_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `countries` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `banner_size` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
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
			CREATE TABLE IF NOT EXISTS `ad_banner_clicks` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `banner_id` int(11) NOT NULL,
			  `ip_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `click_value` decimal(12,3) NOT NULL,
			  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;
			");
			$db->query("
			CREATE TABLE IF NOT EXISTS `ad_banner_networks` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `size` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
			  `banner_code` text COLLATE utf8_unicode_ci NOT NULL,
			  `impressions` int(11) NOT NULL,
			  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;
			");
			$db->query("
			CREATE TABLE IF NOT EXISTS `ad_banner_sizes` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `width` int(11) NOT NULL,
			  `height` int(11) NOT NULL,
			  `default_banner_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `default_banner_target_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;
			");
			
			$db->query("
			CREATE TABLE IF NOT EXISTS `ad_credit_log` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `member_id` int(11) NOT NULL,
			  `type` varchar(20) NOT NULL,
			  `amount` decimal(12,3) NOT NULL,
			  `description` text NOT NULL,
			  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;
			");
			
			$db->query("
			ALTER TABLE `ad_banners`
			 ADD KEY `member_id` (`member_id`), ADD KEY `countries` (`countries`), ADD KEY `banner_size` (`banner_size`), ADD KEY `ad_credit_placed` (`ad_credit_placed`), ADD KEY `ad_credit_used` (`ad_credit_used`), ADD KEY `ad_credit_bid` (`ad_credit_bid`), ADD KEY `approved` (`approved`), ADD KEY `status` (`status`);
			");
			$db->query("
			ALTER TABLE `ad_banner_networks`
			 ADD KEY `size` (`size`);
			");
			$db->query("
			ALTER TABLE `ad_banner_sizes`
			 ADD KEY `width` (`width`), ADD KEY `height` (`height`);
			");
	   }
	}
}




?>