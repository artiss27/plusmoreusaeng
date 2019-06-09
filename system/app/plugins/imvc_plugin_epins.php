<?php

namespace epins;

setTable();

function setTable()
{
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
		$db    = \tmvc::instance()->controller->load->database();
		$check = $db->query("SHOW TABLES LIKE 'epins'");
		if ($db->count() === 0) {
			$db->query("
			CREATE TABLE IF NOT EXISTS `epins` (
			  `id` int(10) NOT NULL,
			  `code` varchar(64) NOT NULL,
			  `member_id` int(11) NOT NULL,
			  `used_by_member_id` int(11) NOT NULL DEFAULT '0',
			  `membership_id` int(11) NOT NULL DEFAULT '0',
			  `amount_paid` decimal(12,2) NOT NULL DEFAULT '0.00',
			  `date_purchased` int(11) NOT NULL DEFAULT '0',
			  `date_used` int(11) NOT NULL DEFAULT '0'
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			");
			$db->query("
			ALTER TABLE `epins`
			 ADD PRIMARY KEY (`id`), ADD KEY (`used_by_member_id`), ADD KEY (`member_id`);
			");
			
			$db->query("
			ALTER TABLE `epins`
			MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
			");
			
			$db->query("
			ALTER TABLE `epins` ADD UNIQUE(`code`);
			");
	   }
	}
}




?>