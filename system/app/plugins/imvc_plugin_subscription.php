<?php

namespace subscription;

setFakeCron();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('membershiplinks', '\subscription\setActionMembershipLink');
$hooks->add_filter('extra_dashboard_head', '\subscription\setActionExtraDashboardHead');

function setActionMembershipLink()
{
	$class = ($_SESSION['menu']['sub'] == "subscription") ? ' class="active"' : '';
    echo '<li'.$class.'><a href="/plugins/subscription/sadmin/settings">Subscription Settings</a></li>' . "\n";
}


function setFakeCron()
{
    $db    = \tmvc::instance()->controller->load->database();
	if (\tmvc::instance()->controller->cache->get(md5('fake_cron')) == null) {		
		\tmvc::instance()->controller->cache->set(md5('fake_cron'), filemtime(__FILE__), 60);
		$db->query("UPDATE members SET membership_expiration = 0, membership = '0' WHERE membership_expiration > 0 AND membership_expiration < " . time());		
	}
}

function setActionExtraDashboardHead()
{
    return; // disabled
	$lang = \CoreHelp::getLang('members');
	$lang_plugin = \CoreHelp::getLangPlugin('members', 'subscription');
	$db    = \tmvc::instance()->controller->load->database();
	$row = $db->queryFirstRow("SELECT * FROM members WHERE member_id = %d", $_SESSION['member_id']);
	$membership = ($row['membership'] == '0') ? $lang['free_membership'] : $row['membership'];
	$membership_expiration = ($row['membership_expiration'] == 0) ? $lang['never'] : ($row['membership_expiration'] < time() ? $lang['expired'] : \CoreHelp::dateDiffNowDaysHoursMins($row['membership_expiration'], 1));
	if (is_array($membership_expiration)) {
		$membership_expiration = $membership_expiration['d'] . ' ' . $lang['days'] . ' ' . $membership_expiration['h'] . ' ' . $lang['hours'] . ' ' . $membership_expiration['m'] . ' ' . $lang['minutes'];
		}
	$action_text = '';	
	if($row['membership_expiration'] < time())	{
		$action_text = ' - <a href="/members/upgrademembership">'.$lang_plugin['renew_membership'].'</a>';		
	}
	if($row['membership'] == '0') {
		$action_text = '- <a href="/members/upgrademembership">'.$lang_plugin['upgrade_membership'].'</a>';
	}
	$membership = str_replace('_', ' ', $membership);
	echo '<div class="row" >
         <div class="col-lg-12">
            <div class="hpanel">
               <div class="panel-body">
                  <div class="text-muted">
                     <div class="form-inline">
                        Your <strong>'.$membership.'</strong> '.$lang['membership'].' expire: <span class="btn btn-warning" style="margin-top: 0px; margin-bottom: 0px;"><strong>'.$membership_expiration.'</strong></span>  '.$action_text.'
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>';
	
}





?>