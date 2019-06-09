-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2016 at 01:27 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mlm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_log`
--

CREATE TABLE IF NOT EXISTS `admin_log` (
`id` int(11) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `flag` int(1) NOT NULL,
  `admin_username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
`id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(128) NOT NULL,
  `roles` text NOT NULL,
  `is_master_admin` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password`, `roles`, `is_master_admin`) VALUES
(1, '<USERNAME>', 'admin@null', '<PASSWORD>', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ad_banners`
--

CREATE TABLE IF NOT EXISTS `ad_banners` (
`id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `campaign_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `banner_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `target_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `countries` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner_size` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ad_credit_placed` decimal(12,3) NOT NULL DEFAULT '0.000',
  `ad_credit_used` decimal(12,3) NOT NULL DEFAULT '0.000',
  `ad_credit_bid` decimal(12,3) NOT NULL,
  `total_views` int(11) NOT NULL DEFAULT '0',
  `total_clicks` int(11) NOT NULL DEFAULT '0',
  `approved` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ad_banner_clicks`
--

CREATE TABLE IF NOT EXISTS `ad_banner_clicks` (
`id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `click_value` decimal(12,3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ad_banner_networks`
--

CREATE TABLE IF NOT EXISTS `ad_banner_networks` (
`id` int(11) NOT NULL,
  `size` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `banner_code` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `impressions` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ad_banner_sizes`
--

CREATE TABLE IF NOT EXISTS `ad_banner_sizes` (
`id` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `default_banner_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `default_banner_target_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ad_credit_log`
--

CREATE TABLE IF NOT EXISTS `ad_credit_log` (
`id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(12,3) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `banners` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_name` varchar(50) NOT NULL,
  `banner_alt` varchar(100) NOT NULL,
  `banner_size` varchar(20) NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
`country_id` int(10) unsigned NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `code` char(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=243 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `name`, `code`) VALUES
(1, 'United States', 'US'),
(2, 'Andorra', 'AD'),
(3, 'United Arab Emirates', 'AE'),
(4, 'Afghanistan', 'AF'),
(5, 'Antigua and Barbuda', 'AG'),
(6, 'Anguilla', 'AI'),
(7, 'Albania', 'AL'),
(8, 'Armenia', 'AM'),
(9, 'Angola', 'AO'),
(10, 'Argentina', 'AR'),
(11, 'American Samoa', 'AS'),
(12, 'Austria', 'AT'),
(13, 'Australia', 'AU'),
(14, 'Aruba', 'AW'),
(15, 'Aland Islands', 'AX'),
(16, 'Azerbaijan', 'AZ'),
(17, 'Bosnia and Herzegovina', 'BA'),
(18, 'Barbados', 'BB'),
(19, 'Bangladesh', 'BD'),
(20, 'Belgium', 'BE'),
(21, 'Burkina Faso', 'BF'),
(22, 'Bulgaria', 'BG'),
(23, 'Bahrain', 'BH'),
(24, 'Burundi', 'BI'),
(25, 'Benin', 'BJ'),
(26, 'Saint Bartelemey', 'BL'),
(27, 'Bermuda', 'BM'),
(28, 'Brunei Darussalam', 'BN'),
(29, 'Bolivia', 'BO'),
(30, 'Bonaire, Saint Eustatius and Saba', 'BQ'),
(31, 'Brazil', 'BR'),
(32, 'Bahamas', 'BS'),
(33, 'Bhutan', 'BT'),
(34, 'Botswana', 'BW'),
(35, 'Belarus', 'BY'),
(36, 'Belize', 'BZ'),
(37, 'Canada', 'CA'),
(38, 'Cocos (Keeling) Islands', 'CC'),
(39, 'Congo, The Democratic Republic of the', 'CD'),
(40, 'Central African Republic', 'CF'),
(41, 'Congo', 'CG'),
(42, 'Switzerland', 'CH'),
(43, 'Cote d''Ivoire', 'CI'),
(44, 'Cook Islands', 'CK'),
(45, 'Chile', 'CL'),
(46, 'Cameroon', 'CM'),
(47, 'China', 'CN'),
(48, 'Colombia', 'CO'),
(49, 'Costa Rica', 'CR'),
(50, 'Cuba', 'CU'),
(51, 'Cape Verde', 'CV'),
(52, 'Curacao', 'CW'),
(53, 'Christmas Island', 'CX'),
(54, 'Cyprus', 'CY'),
(55, 'Czech Republic', 'CZ'),
(56, 'Germany', 'DE'),
(57, 'Djibouti', 'DJ'),
(58, 'Denmark', 'DK'),
(59, 'Dominica', 'DM'),
(60, 'Dominican Republic', 'DO'),
(61, 'Algeria', 'DZ'),
(62, 'Ecuador', 'EC'),
(63, 'Estonia', 'EE'),
(64, 'Egypt', 'EG'),
(65, 'Western Sahara', 'EH'),
(66, 'Eritrea', 'ER'),
(67, 'Spain', 'ES'),
(68, 'Ethiopia', 'ET'),
(69, 'Finland', 'FI'),
(70, 'Fiji', 'FJ'),
(71, 'Falkland Islands (Malvinas)', 'FK'),
(72, 'Micronesia, Federated States of', 'FM'),
(73, 'Faroe Islands', 'FO'),
(74, 'France', 'FR'),
(75, 'Gabon', 'GA'),
(76, 'United Kingdom', 'GB'),
(77, 'Grenada', 'GD'),
(78, 'Georgia', 'GE'),
(79, 'French Guiana', 'GF'),
(80, 'Guernsey', 'GG'),
(81, 'Ghana', 'GH'),
(82, 'Gibraltar', 'GI'),
(83, 'Greenland', 'GL'),
(84, 'Gambia', 'GM'),
(85, 'Guinea', 'GN'),
(86, 'Guadeloupe', 'GP'),
(87, 'Equatorial Guinea', 'GQ'),
(88, 'Greece', 'GR'),
(89, 'Guatemala', 'GT'),
(90, 'Guam', 'GU'),
(91, 'Guinea-Bissau', 'GW'),
(92, 'Guyana', 'GY'),
(93, 'Hong Kong', 'HK'),
(94, 'Honduras', 'HN'),
(95, 'Croatia', 'HR'),
(96, 'Haiti', 'HT'),
(97, 'Hungary', 'HU'),
(98, 'Indonesia', 'ID'),
(99, 'Ireland', 'IE'),
(100, 'Israel', 'IL'),
(101, 'Isle of Man', 'IM'),
(102, 'India', 'IN'),
(103, 'British Indian Ocean Territory', 'IO'),
(104, 'Iraq', 'IQ'),
(105, 'Iran, Islamic Republic of', 'IR'),
(106, 'Iceland', 'IS'),
(107, 'Italy', 'IT'),
(108, 'Jersey', 'JE'),
(109, 'Jamaica', 'JM'),
(110, 'Jordan', 'JO'),
(111, 'Japan', 'JP'),
(112, 'Kenya', 'KE'),
(113, 'Kyrgyzstan', 'KG'),
(114, 'Cambodia', 'KH'),
(115, 'Kiribati', 'KI'),
(116, 'Comoros', 'KM'),
(117, 'Saint Kitts and Nevis', 'KN'),
(118, 'Korea, Democratic People''s Republic of', 'KP'),
(119, 'Korea, Republic of', 'KR'),
(120, 'Kuwait', 'KW'),
(121, 'Cayman Islands', 'KY'),
(122, 'Kazakhstan', 'KZ'),
(123, 'Lao People''s Democratic Republic', 'LA'),
(124, 'Lebanon', 'LB'),
(125, 'Saint Lucia', 'LC'),
(126, 'Liechtenstein', 'LI'),
(127, 'Sri Lanka', 'LK'),
(128, 'Liberia', 'LR'),
(129, 'Lesotho', 'LS'),
(130, 'Lithuania', 'LT'),
(131, 'Luxembourg', 'LU'),
(132, 'Latvia', 'LV'),
(133, 'Libyan Arab Jamahiriya', 'LY'),
(134, 'Morocco', 'MA'),
(135, 'Monaco', 'MC'),
(136, 'Moldova, Republic of', 'MD'),
(137, 'Montenegro', 'ME'),
(138, 'Saint Martin', 'MF'),
(139, 'Madagascar', 'MG'),
(140, 'Marshall Islands', 'MH'),
(141, 'Macedonia', 'MK'),
(142, 'Mali', 'ML'),
(143, 'Myanmar', 'MM'),
(144, 'Mongolia', 'MN'),
(145, 'Macao', 'MO'),
(146, 'Northern Mariana Islands', 'MP'),
(147, 'Martinique', 'MQ'),
(148, 'Mauritania', 'MR'),
(149, 'Montserrat', 'MS'),
(150, 'Malta', 'MT'),
(151, 'Mauritius', 'MU'),
(152, 'Maldives', 'MV'),
(153, 'Malawi', 'MW'),
(154, 'Mexico', 'MX'),
(155, 'Malaysia', 'MY'),
(156, 'Mozambique', 'MZ'),
(157, 'Namibia', 'NA'),
(158, 'New Caledonia', 'NC'),
(159, 'Niger', 'NE'),
(160, 'Norfolk Island', 'NF'),
(161, 'Nigeria', 'NG'),
(162, 'Nicaragua', 'NI'),
(163, 'Netherlands', 'NL'),
(164, 'Norway', 'NO'),
(165, 'Nepal', 'NP'),
(166, 'Nauru', 'NR'),
(167, 'Niue', 'NU'),
(168, 'New Zealand', 'NZ'),
(169, 'Oman', 'OM'),
(170, 'Panama', 'PA'),
(171, 'Peru', 'PE'),
(172, 'French Polynesia', 'PF'),
(173, 'Papua New Guinea', 'PG'),
(174, 'Philippines', 'PH'),
(175, 'Pakistan', 'PK'),
(176, 'Poland', 'PL'),
(177, 'Saint Pierre and Miquelon', 'PM'),
(178, 'Puerto Rico', 'PR'),
(179, 'Palestinian Territory', 'PS'),
(180, 'Portugal', 'PT'),
(181, 'Palau', 'PW'),
(182, 'Paraguay', 'PY'),
(183, 'Qatar', 'QA'),
(184, 'Reunion', 'RE'),
(185, 'Romania', 'RO'),
(186, 'Serbia', 'RS'),
(187, 'Russian Federation', 'RU'),
(188, 'Rwanda', 'RW'),
(189, 'Saudi Arabia', 'SA'),
(190, 'Solomon Islands', 'SB'),
(191, 'Seychelles', 'SC'),
(192, 'Sudan', 'SD'),
(193, 'Sweden', 'SE'),
(194, 'Singapore', 'SG'),
(195, 'Saint Helena', 'SH'),
(196, 'Slovenia', 'SI'),
(197, 'Svalbard and Jan Mayen', 'SJ'),
(198, 'Slovakia', 'SK'),
(199, 'Sierra Leone', 'SL'),
(200, 'San Marino', 'SM'),
(201, 'Senegal', 'SN'),
(202, 'Somalia', 'SO'),
(203, 'Suriname', 'SR'),
(204, 'South Sudan', 'SS'),
(205, 'Sao Tome and Principe', 'ST'),
(206, 'El Salvador', 'SV'),
(207, 'Sint Maarten', 'SX'),
(208, 'Syrian Arab Republic', 'SY'),
(209, 'Swaziland', 'SZ'),
(210, 'Turks and Caicos Islands', 'TC'),
(211, 'Chad', 'TD'),
(212, 'Togo', 'TG'),
(213, 'Thailand', 'TH'),
(214, 'Tajikistan', 'TJ'),
(215, 'Tokelau', 'TK'),
(216, 'Timor-Leste', 'TL'),
(217, 'Turkmenistan', 'TM'),
(218, 'Tunisia', 'TN'),
(219, 'Tonga', 'TO'),
(220, 'Turkey', 'TR'),
(221, 'Trinidad and Tobago', 'TT'),
(222, 'Tuvalu', 'TV'),
(223, 'Taiwan', 'TW'),
(224, 'Tanzania, United Republic of', 'TZ'),
(225, 'Ukraine', 'UA'),
(226, 'Uganda', 'UG'),
(227, 'Uruguay', 'UY'),
(228, 'Uzbekistan', 'UZ'),
(229, 'Holy See (Vatican City State)', 'VA'),
(230, 'Saint Vincent and the Grenadines', 'VC'),
(231, 'Venezuela', 'VE'),
(232, 'Virgin Islands, British', 'VG'),
(233, 'Virgin Islands, U.S.', 'VI'),
(234, 'Vietnam', 'VN'),
(235, 'Vanuatu', 'VU'),
(236, 'Wallis and Futuna', 'WF'),
(237, 'Samoa', 'WS'),
(238, 'Yemen', 'YE'),
(239, 'Mayotte', 'YT'),
(240, 'South Africa', 'ZA'),
(241, 'Zambia', 'ZM'),
(242, 'Zimbabwe', 'ZW');


--
-- Table structure for table `downloader`
--

CREATE TABLE IF NOT EXISTS `downloader` (
`id` int(11) NOT NULL,
  `filename` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `size` int(11) NOT NULL,
  `minium_membership` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `download_counter` int(11) NOT NULL DEFAULT '0',
  `featured` varchar(3) NOT NULL DEFAULT 'no',
  `category` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `emailtemplates`
--

CREATE TABLE IF NOT EXISTS `emailtemplates` (
`emailtempl_id` int(11) NOT NULL,
  `code` varchar(120) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `subject` varchar(250) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `tag_descr` text NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=158 ;

--
-- Dumping data for table `emailtemplates`
--

INSERT INTO `emailtemplates` (`emailtempl_id`, `code`, `description`, `subject`, `message`, `tag_descr`) VALUES
(4, 'SuccessWithdrawal', 'Success withdrawal email to member', '[SiteName]  Withdrawal Completed', 'Dear [FirstName] [LastName], \r\n\r\nYour [SiteName] Withdrawal was just completed and should show up in your [Processor] account shortly.\r\n\r\n$[Amount] was paid to your account.\r\n\r\n[SiteName]', '[<a href="#">SiteName</a>] - Title of your site<br>\r\n[<a href="#">AdminMail</a>] - Admin email address<br>\r\n[<a href="#">FirstName</a>] - First name of the member<br>\r\n[<a href="#">LastName</a>] - Last name of themember<br>\r\n[<a href="#">Username</a>] - Username of the member<br>\r\n[<a href="#">SiteUrl</a>] - Your site url<br>\r\n[<a href="#">Processor/a>] - Processor received the money<br>\r\n[<a href="#">Amount/a>] - Amount paid<br>'),
(5, 'ForgotPassword', 'Forgot Password email to member', '[SiteName]  Password Instructions', 'Dear [FirstName] [LastName], \r\n\r\nTo reset your password for [SiteName] : \r\n\r\nFollow this Url:\r\n\r\n[ResetUrl]\r\n\r\n\r\n[SiteName]', '[<a href="#">SiteName</a>] - Title of your site<br>\r\n[<a href="#">AdminMail</a>] - Admin email address<br>\r\n[<a href="#">FirstName</a>] - First name of the member<br>\r\n[<a href="#">LastName</a>] - Last name of the member<br>\r\n[<a href="#">Username</a>] - Username of the member<br>\r\n[<a href="#">ResetUrl</a>] - Url needed to follow to reset the password<br>'),
(148, 'NotifyMemberCommision', 'Commission notification to member', '[SiteName] New Commission!', 'Dear [FirstName] [LastName],\r\n\r\nHave a new commission on [SiteName] !\r\n\r\n[Description]\r\n\r\n[SiteUrl]\r\n\r\n[SiteName]', '[<a href="#">SiteName</a>] - Title of your site<br>\r\n[<a href="#">AdminMail</a>] - Admin email address<br>\r\n[<a href="#">FirstName</a>] - First name of the member<br>\r\n[<a href="#">LastName</a>] - Last name of themember<br>\r\n[<a href="#">Username</a>] - Username of the member<br>\r\n[<a href="#">Description</a>] - Commission description<br>'),
(149, 'NotifyNewReferral', 'Notify Member on New Referral Registration', '[SiteName] , New Direct Referral', 'Dear [FirstName] [LastName],\r\n\r\nThe following member just register and and is now part of your group.\r\n\r\nUsername: [MemberUsername]\r\n\r\n[SiteName]', '[<a href="#">SiteName</a>] - Title of your site<br>\r\n[<a href="#">AdminMail</a>] - Admin email address<br>\r\n[<a href="#">FirstName</a>] - First name of the member<br>\r\n[<a href="#">LastName</a>] - Last name of themember<br>\r\n[<a href="#">Username</a>] - Username of the member<br>\r\n[<a href="#">MemberUsername</a>] - Username of the referral<br>\r\n'),
(150, 'SendWelcomeEmail', 'Send Welcome Email to the New Member', '[SiteName] Welcome Notification', 'Dear [FirstName] [LastName],\r\n\r\nWelcome to [SiteName]\r\n\r\nLogin and see your complete Backoffice Area.\r\n\r\nYour username is [Username]\r\n\r\nTo Login to Your Members Area:[SiteUrl]\r\n\r\nWelcome to [SiteName]', '[<a href="#">SiteName</a>] - Title of your site<br>\r\n[<a href="#">AdminMail</a>] - Admin email address<br>\r\n[<a href="#">FirstName</a>] - First name of the member<br>\r\n[<a href="#">LastName</a>] - Last name of themember<br>\r\n[<a href="#">Username</a>] - Username of the member<br>\r\n'),
(153, 'ActivationLetter', 'Activation Email Sent to User after Registration', 'Activation letter from [SiteName]', 'Dear [FirstName] [LastName],\r\n\r\nYour username is [Username]\r\n\r\nTo activate your account (for this you have 24 hours) follow this activation link please:\r\n\r\n[ActivationUrl]\r\n\r\n[SiteName]', '[<a href="#">SiteName</a>] - Title of your site<br>\r\n[<a href="#">AdminMail</a>] - Admin email address<br>\r\n[<a href="#">FirstName</a>] - First name of the member<br>\r\n[<a href="#">LastName</a>] - Last name of themember<br>\r\n[<a href="#">Username</a>] - Username of the member<br>\r\n[<a href="#">ActivationUrl</a>] - Url to follow by the user to verify their email<br>\r\n[<a href="#">UserID</a>] - Paying user ID<br>\r\n[<a href="#">SponsorID</a>] - Sponsor <br>\r\n[<a href="#">SiteUrl</a>] - Site Url<br>'),
(157, 'TellaFriend', 'Tell a Friend Mail', '[SiteName] ..NEW LAUNCH!', 'Hi,\r\n\r\nNEW LAUNCH...Only $xx.xx to Make $10,000!\r\n\r\nCheck Out This Great New Site...This Will Really Open Your Eyes and Make You money FAST!\r\n\r\n[SiteUrl]/?[Username]\r\n\r\nRegards,\r\n\r\n[FirstName] [LastName]', '[<a href="#">SiteName</a>] - Title of the site<br>\r\n[<a href="#">AdminMail</a>] - Admin email address<br>\r\n[<a href="#">FirstName</a>] - First name of the member<br>\r\n[<a href="#">LastName</a>] - Last name of the member<br>\r\n[<a href="#">Username</a>] - Username of the referer member<br>\r\n');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `textads` (
  `textad_id` int(11) NOT NULL AUTO_INCREMENT,
  `textad_heading` varchar(50) NOT NULL,
  `textad_line1` varchar(50) NOT NULL,
  `textad_line2` varchar(50) NOT NULL,
  `textad_domain` varchar(50) NOT NULL,
  PRIMARY KEY (`textad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Table structure for table `entrypayment`
--

CREATE TABLE IF NOT EXISTS `entrypayment` (
`payment_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL DEFAULT '0',
  `transaction_id` varchar(50) NOT NULL DEFAULT '',
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `processor` varchar(100) NOT NULL DEFAULT '',
  `date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
`id` int(11) NOT NULL,
  `order_index` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hits`
--

CREATE TABLE IF NOT EXISTS `hits` (
`id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `hit_counter` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
`member_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `gender` int(1) NOT NULL DEFAULT '0',
  `skype` varchar(200) NOT NULL,
  `street` varchar(50) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `state` varchar(50) NOT NULL DEFAULT '',
  `country` varchar(50) NOT NULL DEFAULT '',
  `postal` varchar(50) NOT NULL DEFAULT '',
  `phone` varchar(50) NOT NULL DEFAULT '',
  `sponsor_id` int(11) NOT NULL DEFAULT '0',
  `reg_date` int(11) NOT NULL DEFAULT '0',
  `last_access` int(11) NOT NULL DEFAULT '0',
  `ip_address` varchar(20) NOT NULL DEFAULT '',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `membership` varchar(50) NOT NULL,
  `membership_expiration` int(11) NOT NULL,
  `matrix_level` int(5) NOT NULL DEFAULT '0',
  `processor` int(1) NOT NULL,
  `account_id` varchar(60) NOT NULL,
  `email_from_company` int(11) NOT NULL DEFAULT '1',
  `email_from_upline` int(11) NOT NULL DEFAULT '1',
  `notify_changes` int(11) NOT NULL DEFAULT '0',
  `display_name` int(11) NOT NULL,
  `display_email` int(11) NOT NULL,
  `log_ip` int(11) NOT NULL DEFAULT '1',
  `m_level` int(11) NOT NULL DEFAULT '0',
  `ad_credits` decimal(12,3) NOT NULL,
  `forgot_token` varchar(128) NOT NULL,
  `activation_token` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE IF NOT EXISTS `memberships` (
`id` int(11) NOT NULL,
  `order_index` int(11) NOT NULL,
  `membership` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
`id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `from_viewed` tinyint(1) NOT NULL DEFAULT '0',
  `to_viewed` tinyint(1) NOT NULL DEFAULT '0',
  `from_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `to_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `from_vdate` datetime DEFAULT NULL,
  `to_vdate` datetime DEFAULT NULL,
  `from_ddate` datetime DEFAULT NULL,
  `to_ddate` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `priority` int(1) NOT NULL DEFAULT '1',
  `message_type` varchar(20) NOT NULL,
  `alert` int(1) NOT NULL DEFAULT '0',
  `message_id` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `money_out`
--

CREATE TABLE IF NOT EXISTS `money_out` (
`money_out_id` int(11) NOT NULL,
  `transfer_date` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `member_id` int(11) NOT NULL DEFAULT '0',
  `processor` int(5) NOT NULL,
  `account_id` varchar(250) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
`id` int(11) NOT NULL,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `optin`
--

CREATE TABLE IF NOT EXISTS `optin` (
`optin_id` int(11) NOT NULL,
  `optin_title` varchar(100) NOT NULL,
  `optin_body` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_processors`
--

CREATE TABLE IF NOT EXISTS `payment_processors` (
`processor_id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(120) NOT NULL DEFAULT '',
  `account_id` varchar(120) NOT NULL DEFAULT '',
  `processor_url` varchar(250) NOT NULL DEFAULT '',
  `fee_flat` decimal(12,2) NOT NULL DEFAULT '0.00',
  `fee_percent` decimal(12,2) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `active_withdrawal` tinyint(1) NOT NULL DEFAULT '0',
  `extra_code` text NOT NULL,
  `sandbox_url` varchar(100) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
`id` int(11) NOT NULL,
  `keyname` varchar(120) NOT NULL DEFAULT '',
  `value` text NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=503 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `keyname`, `value`) VALUES
(284, 'smtp_host', ''),
(288, 'backoffice_lang', 'en'),
(89, 'admin_lang', 'en'),
(283, 'mailgate', 'smtp_ssl'),
(282, 'site_path', ''),
(281, 'site_url', ''),
(280, 'site_name', 'Your MLM Company'),
(463, 'affiliate_type', ''),
(451, 'admin_inactivity', '60'),
(450, 'admin_email', 'admin@domain.com'),
(64, 'alert_commision', 'yes'),
(65, 'alert_downline', 'yes'),
(66, 'view_downline', 'yes'),
(67, 'email_downline', 'yes'),
(68, 'email_pending', 'yes'),
(466, 'commission_cashout_sum', '10.00'),
(467, 'commission_cashout_fee', '0.00'),
(470, 'signup_email_confirmation', 'yes'),
(20, 'signup_admin_aproval', 'no'),
(471, 'signup_active', 'yes'),
(30, 'signup_fee', '0.00'),
(25, 'banner_auto', '1'),
(26, 'banner_notify_admin', '1'),
(27, 'banner_notify_member', '1'),
(285, 'smtp_port', ''),
(286, 'smtp_login', ''),
(287, 'smtp_password', ''),
(392, 'withdrawal_fee', '1.00'),
(469, 'processor_fee_by', 'member'),
(464, 'alert_commission', 'yes'),
(468, 'min_deposit', '5.00');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE IF NOT EXISTS `visitors` (
`id` int(11) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `referrer` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_deposit`
--

CREATE TABLE IF NOT EXISTS `wallet_deposit` (
`id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `processor_id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `transaction_date` int(11) NOT NULL,
  `descr` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_payout`
--

CREATE TABLE IF NOT EXISTS `wallet_payout` (
`transaction_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `transaction_type` varchar(150) NOT NULL DEFAULT '',
  `from_id` int(11) NOT NULL DEFAULT '0',
  `to_id` int(11) NOT NULL DEFAULT '0',
  `transaction_date` int(11) NOT NULL DEFAULT '0',
  `descr` varchar(250) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_log`
--
ALTER TABLE `admin_log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_banners`
--
ALTER TABLE `ad_banners`
 ADD PRIMARY KEY (`id`), ADD KEY `member_id` (`member_id`), ADD KEY `countries` (`countries`), ADD KEY `banner_size` (`banner_size`), ADD KEY `ad_credit_placed` (`ad_credit_placed`), ADD KEY `ad_credit_used` (`ad_credit_used`), ADD KEY `ad_credit_bid` (`ad_credit_bid`), ADD KEY `approved` (`approved`), ADD KEY `status` (`status`);

--
-- Indexes for table `ad_banner_clicks`
--
ALTER TABLE `ad_banner_clicks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_banner_networks`
--
ALTER TABLE `ad_banner_networks`
 ADD PRIMARY KEY (`id`), ADD KEY `size` (`size`);

--
-- Indexes for table `ad_banner_sizes`
--
ALTER TABLE `ad_banner_sizes`
 ADD PRIMARY KEY (`id`), ADD KEY `width` (`width`), ADD KEY `height` (`height`);

--
-- Indexes for table `ad_credit_log`
--
ALTER TABLE `ad_credit_log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
 ADD PRIMARY KEY (`country_id`);


--
-- Indexes for table `downloader`
--
ALTER TABLE `downloader`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emailtemplates`
--
ALTER TABLE `emailtemplates`
 ADD PRIMARY KEY (`emailtempl_id`), ADD KEY `code_idx` (`code`);

--
-- Indexes for table `entrypayment`
--
ALTER TABLE `entrypayment`
 ADD PRIMARY KEY (`payment_id`), ADD KEY `transaction_id_idx` (`transaction_id`), ADD KEY `date` (`date`), ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hits`
--
ALTER TABLE `hits`
 ADD PRIMARY KEY (`id`), ADD KEY `hit_counter` (`hit_counter`), ADD KEY `date` (`date`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
 ADD PRIMARY KEY (`member_id`), ADD KEY `enroller_id` (`sponsor_id`), ADD KEY `membership` (`membership`), ADD KEY `membership_expiration` (`membership_expiration`), ADD KEY `username` (`username`), ADD KEY `reg_date` (`reg_date`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
 ADD PRIMARY KEY (`id`), ADD KEY `from` (`from`), ADD KEY `to` (`to`);

--
-- Indexes for table `money_out`
--
ALTER TABLE `money_out`
 ADD PRIMARY KEY (`money_out_id`), ADD KEY `transfer_date_idx` (`transfer_date`), ADD KEY `member_id_idx` (`member_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `optin`
--
ALTER TABLE `optin`
 ADD PRIMARY KEY (`optin_id`);

--
-- Indexes for table `payment_processors`
--
ALTER TABLE `payment_processors`
 ADD PRIMARY KEY (`processor_id`), ADD KEY `code_idx` (`code`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `keyname` (`keyname`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
 ADD PRIMARY KEY (`id`), ADD KEY `ip_address` (`ip_address`), ADD KEY `date` (`date`);

--
-- Indexes for table `wallet_deposit`
--
ALTER TABLE `wallet_deposit`
 ADD PRIMARY KEY (`id`), ADD KEY `member_id` (`member_id`), ADD KEY `amount` (`amount`), ADD KEY `processor_id` (`processor_id`), ADD KEY `transaction_date` (`transaction_date`);

--
-- Indexes for table `wallet_payout`
--
ALTER TABLE `wallet_payout`
 ADD PRIMARY KEY (`transaction_id`), ADD KEY `to_id` (`to_id`), ADD KEY `from_id` (`from_id`), ADD KEY `amount` (`amount`), ADD KEY `transaction_type` (`transaction_type`), ADD KEY `transaction_date` (`transaction_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_log`
--
ALTER TABLE `admin_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ad_banners`
--
ALTER TABLE `ad_banners`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ad_banner_clicks`
--
ALTER TABLE `ad_banner_clicks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ad_banner_networks`
--
ALTER TABLE `ad_banner_networks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ad_banner_sizes`
--
ALTER TABLE `ad_banner_sizes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ad_credit_log`
--
ALTER TABLE `ad_credit_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
MODIFY `country_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `downloader`
--
ALTER TABLE `downloader`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emailtemplates`
--
ALTER TABLE `emailtemplates`
MODIFY `emailtempl_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=158;
--
-- AUTO_INCREMENT for table `entrypayment`
--
ALTER TABLE `entrypayment`
MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hits`
--
ALTER TABLE `hits`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `money_out`
--
ALTER TABLE `money_out`
MODIFY `money_out_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `optin`
--
ALTER TABLE `optin`
MODIFY `optin_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_processors`
--
ALTER TABLE `payment_processors`
MODIFY `processor_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=503;
--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wallet_deposit`
--
ALTER TABLE `wallet_deposit`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wallet_payout`
--
ALTER TABLE `wallet_payout`
MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE  `members` ADD UNIQUE (
`username`
);

ALTER TABLE  `members` ADD UNIQUE (
`email`
);
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
