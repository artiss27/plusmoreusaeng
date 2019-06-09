<?php

setTable();

function setTable()
{
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);	
		$db    = \tmvc::instance()->controller->load->database();
		$check = $db->query("SHOW TABLES LIKE 'personal_volume'");
		if ($db->count() === 0) {
	
			$db->query("
			CREATE TABLE IF NOT EXISTS `personal_volume` (
			`id` int(11) NOT NULL,
			  `member_id` int(11) NOT NULL,
			  `from_member_id` int(11) NOT NULL,
			  `amount` int(11) NOT NULL,
			  `description` varchar(250) NOT NULL,
			  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
			");	
			
			$db->query("
			ALTER TABLE `personal_volume`
			 ADD PRIMARY KEY (`id`), ADD KEY `member_id` (`member_id`), ADD KEY `date` (`date`);
			");	
			
			$db->query("
			ALTER TABLE `personal_volume`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");	
	
		}	
		
		$check = $db->query("SHOW TABLES LIKE 'group_volume'");
		if ($db->count() === 0) {
	
			$db->query("
			CREATE TABLE IF NOT EXISTS `group_volume` (
			`id` int(11) NOT NULL,
			  `member_id` int(11) NOT NULL,
			  `from_member_id` int(11) NOT NULL,
			  `amount` int(11) NOT NULL,
			  `description` varchar(250) NOT NULL,
			  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
			");	
			
			$db->query("
			ALTER TABLE `group_volume`
			 ADD PRIMARY KEY (`id`), ADD KEY `member_id` (`member_id`), ADD KEY `date` (`date`);
			");	
			
			$db->query("
			ALTER TABLE `group_volume`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");	
	
		}	
		
	}
	
}



?>