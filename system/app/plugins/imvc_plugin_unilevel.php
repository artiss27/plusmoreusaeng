<?php

namespace unilevel;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('menu_network', '\unilevel\setActionMenu');
$hooks->add_action('affiliate_setting', '\unilevel\setActionAffiliateSetting');
$hooks->add_action('pay_upline', '\unilevel\payUpline');
$hooks->add_action('payplanlinks', '\unilevel\setActionPayPlan');
$hooks->add_action('in_matrix', '\unilevel\inMatrix');
$hooks->add_filter('payplan', '\unilevel\setFilterPayPlan');
$hooks->add_filter('view_network', '\unilevel\setFilterViewNetwork');
$hooks->add_filter('extra_dashboard_head', '\unilevel\setActionExtraDashboardHead');

function setActionMenu()
{
	$lang_plugin = \CoreHelp::getLangPlugin('members', 'unilevel');
	$class = ($_SESSION['menu']['sub'] == "unilevel_levels") ? ' class="active"' : '';
    echo '<li'.$class.'><a href="/plugins/unilevel/unimember/tree"> '.$lang_plugin['geneaology'].'</a></li>' . "\n";
}

function setActionAffiliateSetting()
{
    echo '<option value="unilevel" selected>Unilevel</option>' . "\n";
}

function setActionPayPlan()
{
	$class = ($_SESSION['menu']['sub'] == "unilevelsettings") ? ' class="active"' : '';
    echo '<li'.$class.'><a href="/plugins/unilevel/uniadmin/settings">Unilevel</a></li>' . "\n";
}

function setFilterViewNetwork($array)
{
	if(!is_array($array)) {
		$array = array();	
	}
    $array[] = array('name' => 'Unilevel', 'url' => "/plugins/unilevel/uniadmin/viewtree");
	return  $array;
}

function setFilterPayPlan($array)
{	
	$array[] = 'unilevelsettings';
    return  $array;
}

function payUpline($memberId, $amount, $membership) {
	$controller = \tmvc::instance(null,'controller');
	$controller->load->plugin_model('Unilevel_Model', 'unilevel');
	$member = $controller->unilevel->getMember($memberId);
	$controller->unilevel->payUpline($member, $amount, $membership);
}


function setActionExtraDashboardHead()
{
	$lang = \CoreHelp::getLangPlugin('members', 'unilevel');
	$db    = \tmvc::instance()->controller->load->database();
	$row = $db->queryFirstRow("SELECT * FROM settings WHERE keyname = 'settings_qualification_required'");
	if(isset($row['value']) && $row['value'] == 'yes') {
		$row = $db->queryFirstRow("SELECT * FROM settings WHERE keyname = 'settings_qualification_required_members'");
		$required = $row['value'];
		$row = $db->queryFirstRow("SELECT COUNT(*) as total FROM members WHERE sponsor_id = %d AND membership != '0'", $_SESSION['member_id']);
		if($row['total'] >= $required) {
			$message = $lang['qualified'];	
		}
		else {
			$left = $required - $row['total'];
			$message = $lang['you_require'] . ' '.$left.' '.$lang['more_direct_paid_members'];	
		}
		echo '<div class="row" >
         <div class="col-lg-12">
            <div class="hpanel">
               <div class="panel-body">
                  <div class="text-muted">
                     <div class="form-inline">
                        Qualification status: <strong>'.$message.'</strong>
                 	    </div>
               	   </div>
              	 </div>
          	  </div>
        	 </div>
     	 </div>';
	  
	}
	
}

function setTable()
{
	$_SESSION['plan']['unilevel'] = 1;
	
}




?>