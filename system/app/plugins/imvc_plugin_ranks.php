<?php

namespace ranks;

setTable();
$hooks = \voku\helper\Hooks::getInstance();

$hooks->add_action('payplanlinks', '\ranks\setActionExtraAdminMenu'); 
$hooks->add_action('extra_dashboard_head', '\ranks\setActionExtraDashboardHead');
$hooks->add_filter('payplan', '\ranks\setFilterPayPlan');


function setActionExtraAdminMenu()
{
	$class = ($_SESSION['menu']['sub'] == "manage_ranks") ? ' class="active"' : '';
    echo '<li'.$class.'><a href="/plugins/ranks/admin/manage">Manage Ranks</a></li>' . "\n";

}

function setFilterPayPlan($array)
{	
	$array[] = 'manage_ranks';
    return  $array;
}

function setActionExtraDashboardHead()
{	
		\tmvc::instance()->controller->load->plugin_model('Ranks_Model', 'ranks');
		$rank_data = \tmvc::instance()->controller->ranks->getRankData($_SESSION['member_id']);		
		echo '<div class="row" >
			 <div class="col-lg-12">
				<div class="hpanel">
				   <div class="panel-body">
					  <div class="text-muted">
						 <div class="form-inline">
							<strong>Your Rank is: &nbsp;&nbsp;<button class="btn btn-warning" style="margin-top: 0px; margin-bottom: 0px;"><strong>' . $rank_data['current_rank']. '</strong></button> &nbsp;&nbsp;&nbsp;<img style="margin-bottom:5px;" width="40" src="/media/images/'.$rank_data['current_rank_image'].'" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Paid Referrals: &nbsp;&nbsp;<button class="btn btn-warning" style="margin-top: 0px; margin-bottom: 0px;"><strong>'.$rank_data['paid_referrals'].'</strong></button>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Personal Volume: &nbsp;&nbsp;<button class="btn btn-warning" style="margin-top: 0px; margin-bottom: 0px;"><strong>'.$rank_data['personal_volume'].'</strong></button>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Group Volume: &nbsp;&nbsp;<button class="btn btn-warning" style="margin-top: 0px; margin-bottom: 0px;"><strong>'.$rank_data['group_volume'].'</strong></button> </strong>
						 </div>
					  </div>
				   </div>
				</div>
			 </div>
		  </div>';
}


function setTable()
{
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
		$db    = \tmvc::instance()->controller->load->database();
		$check = $db->query("SHOW TABLES LIKE 'ranks'");
		if ($db->count() === 0) {	
			$db->query("
			CREATE TABLE IF NOT EXISTS `ranks` (
			`id` int(11) NOT NULL,
			  `order_index` int(2) NOT NULL,
			  `name` varchar(200) NOT NULL,
			  `direct_required` int(11) NOT NULL,
			  `pv_required` int(11) NOT NULL,
			  `gv_required` int(11) NOT NULL,
			  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
			");	
			
			$db->query("
			ALTER TABLE `ranks`
			 ADD PRIMARY KEY (`id`), ADD KEY `direct_required` (`direct_required`), ADD KEY `pv_required` (`pv_required`), ADD KEY `gv_required` (`gv_required`);
			");	
			
			$db->query("
			ALTER TABLE `ranks`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");	
			
			$db->query("
			ALTER TABLE `ranks` ADD `image` VARCHAR(200) NOT NULL AFTER `gv_required`;
			");	
		}		
	}
}

?>