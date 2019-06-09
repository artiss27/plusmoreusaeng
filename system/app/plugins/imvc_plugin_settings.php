<?php

namespace settings;

$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_filter('get_setting', '\settings\setFilterGetSetting');
$hooks->add_filter('get_message_number', '\settings\setFilterGetMessageNumber');

function setFilterGetSetting($setting)
{
	return \tmvc::instance()->controller->core->GetSiteSetting($setting);	
}

function setFilterGetMessageNumber($memberId)
{
	return \tmvc::instance()->controller->core->getMessages($memberId);	
}
?>