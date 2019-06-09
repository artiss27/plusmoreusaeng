<?php

namespace invoicer;

setTable();
$hooks = \voku\helper\Hooks::getInstance();

$hooks->add_action('settingslinks', '\invoicer\setActionExtraAdminMenu');
$hooks->add_action('menu_financial', '\invoicer\setActionExtraMemberMenu');
$hooks->add_action('extra_dashboard_head', '\invoicer\setActionExtraDashboardHead');
$hooks->add_action('create_invoice', '\invoicer\setActionCreateInvoice');


function setActionExtraAdminMenu()
{
	$class = ($_SESSION['menu']['sub'] == "invoicer_settings") ? ' class="active"' : '';
	echo '<li' . $class . '><a href="/plugins/invoicer/admin/settings">Invoice Settings</a></li>' . "\n";
}

function setActionExtraMemberMenu()
{
	$lang_plugin = \CoreHelp::getLangPlugin('members', 'invoicer');
	$class       = ($_SESSION['menu']['sub'] == "invoicer") ? ' class="active"' : '';
	echo '<li' . $class . '><a href="/plugins/invoicer/member/invoices"> ' . $lang_plugin['invoices'] . '</a></li>' . "\n";
}

function setActionCreateInvoice($memberId, $item)
{
	$reference = date('Y', time()) . time();
	$controller = \tmvc::instance(null, 'controller');
	$controller->load->plugin_model('Invoicer_Model', 'invoicer');
	$controller->load->model('Members_Model', 'member');
	$profile = $controller->member->getProfile($_SESSION['member_id']);	
	$settings = $controller->core->GetSiteSettings();
	$lang_plugin = \CoreHelp::getLangPlugin('members', 'invoicer');
	$lang = \CoreHelp::getLang('members');
	include 'system/app/plugins/invoicer/invoicr.php';
	date_default_timezone_set('America/Los_Angeles');
	$invoice = new \invoicr("A4", $settings['monetary'], $settings['invoice_language']);
	$invoice->setNumberFormat('.', ',');
	$invoice->setLogo("media/images/" . $settings['invoice_logo']);
	$invoice->setColor($settings['invoice_color']);
	$invoice->setType("Invoice");
	$invoice->setReference($reference);
	$invoice->setDate(date('m.d.Y', time()));
	$invoice->setDue(date('m.d.Y', time()));
	$invoice->setFrom(array(
		$settings['invoice_company'],
		$settings['invoice_company_address'],
		$settings['invoice_company_city'] .", ". $settings['invoice_company_state'],
		$settings['invoice_company_country'],
		""
	));
	$invoice->setTo(array(
		$profile['first_name'] . " " . $profile['last_name'],
		$profile['street'],
		$profile['city'] . ", " . $profile['state'],
		$profile['country'],
		""
	));
	$vatDecimal = (float) 1 + ($settings['invoice_vat'] / 100);
	$priceExclVAT = ($item['amount'] / $vatDecimal);
	$priceDisplay = round($priceExclVAT, 2);
	$vat_amount = round($priceDisplay * $settings['invoice_vat'] / 100, 2);
	$priceDisplay = number_format($item['amount'] - $vat_amount, 2, '.', '');
	$invoice->addItem($item['name'], $item['description'], 1, $vat_amount, $priceDisplay, false, $item['amount']);
		$invoice->addTotal("VAT ".$settings['invoice_vat']."%", $vat_amount);
	$invoice->addTotal("Total", $item['amount']);
	$invoice->addTotal("Total due", $item['amount'], true);	
	$invoice->addBadge("paid");
	$invoice->addTitle($settings['invoice_footer_title']);
	$invoice->addParagraph(str_replace('\r\n', '<br>', $settings['invoice_footer_description']));
	$invoice->setFooternote($settings['invoice_footer_url']);
	if(!is_dir("files/invoices")) {
		mkdir("files/invoices");
		copy("files/index.php", "files/invoices/index.php");
	}
	$invoice->render('files/invoices/'.$reference.'.pdf', 'F');
	$controller->invoicer->saveInvoice($memberId, $reference, $item['name'], $item['description'], $item['amount'], $vat_amount);
	\CoreHelp::sendMail($profile['email'], $settings['site_name'] . ' Invoice', "Please find attached the invoice from your purchase.", '', 'files/invoices/'.$reference.'.pdf');
}

function setTable()
{
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);	
		$db    = \tmvc::instance()->controller->load->database();
		$check = $db->query("SHOW TABLES LIKE 'invoices'");
		if ($db->count() === 0) {
			
			$db->query("
			CREATE TABLE IF NOT EXISTS `invoices` (
			`id` int(11) NOT NULL,
			  `member_id` int(11) NOT NULL,
			  `reference_number` bigint(20) NOT NULL,
			  `item_name` varchar(200) NOT NULL,
			  `item_description` text NOT NULL,
			  `amount` decimal(12,2) NOT NULL,
			  `vat` decimal(12,2) NOT NULL,
			  `total_amount` decimal(12,2) NOT NULL,
			  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
			");
					
					$db->query("
			ALTER TABLE `invoices`
			 ADD PRIMARY KEY (`id`);
			");
					
					$db->query("
			ALTER TABLE `invoices`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");			
		}	
	}	
}

?>