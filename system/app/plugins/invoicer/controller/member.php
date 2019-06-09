<?php

class Member_Controller extends iMVC_Controller
{
    
    public function getInvoices()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/';
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'invoicer');
		$this->load->plugin_model('Invoicer_Model', 'invoicer');
        $memberId                   = CoreHelp::getMemberId();
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
		$this->smarty->assign('invoices', $this->invoicer->getInvoices($memberId));
        CoreHelp::setSession('menu', array(
            'main' => 'financial',
            'sub' => 'invoicer'
        ));
        $this->smarty->display('plugins/invoicer/views/member_invoices.tpl');
    }
	
	public function getGenerateinvoice()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
		if(!$_SESSION['invoicer']) {
			exit;	
		}
        $lang                       = CoreHelp::getLang('members');
        $plugin_lang                = CoreHelp::getLangPlugin('members', 'invoicer');
		$this->load->plugin_model('Invoicer_Model', 'invoicer');
		$this->load->model('Members_Model', 'member');
        $memberId                   = CoreHelp::getMemberId();
		$profile = $this->member->getProfile($_SESSION['member_id']);	
		$settings = $this->core->GetSiteSettings();
		$reference = date('Y', time()) . time();
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
		
		foreach ($_SESSION['invoicer']['products'] as $item) {
			$taxed_amount = number_format(($item['price'] - $item['discount']) + ($item['price'] - $item['discount']) * $settings['invoice_vat'] / 100, 2, '.', '');
			$vat_amount = round($item['price'] * $settings['invoice_vat'] / 100, 2);
			$invoice->addItem($item['name'], '', $item['quantity'], $vat_amount, $item['price'], false, $taxed_amount);			
		}
		if($_SESSION['invoicer']['coupon_discount'] > 0) {
			$invoice->addTotal("Coupon Discount", -number_format($_SESSION['invoicer']['coupon_discount'], 2, '.', ''));
		}
		$invoice->addTotal("VAT ".$settings['invoice_vat']."%", number_format($_SESSION['invoicer']['tax'], 2, '.', ''));	
		$invoice->addTotal("Shipping", number_format($_SESSION['invoicer']['shipping'], 2, '.', ''));
		$invoice->addTotal("Total", $_SESSION['invoicer']['total']);
		$invoice->addTotal("Total due", $_SESSION['invoicer']['total'], true);
		$invoice->addBadge("paid");
		$invoice->addTitle($settings['invoice_footer_title']);
		$invoice->addParagraph(str_replace('\r\n', '<br>', $settings['invoice_footer_description']));
		$invoice->setFooternote($settings['invoice_footer_url']);
		if(!is_dir("files/invoices")) {
			mkdir("files/invoices");
			copy("files/index.php", "files/invoices/index.php");
		}
		$invoice->render('files/invoices/'.$reference.'.pdf', 'F');
		$this->invoicer->saveInvoice($memberId, $reference, 'Merchandise Purchase', 'Merchandise Purchase', $_SESSION['invoicer']['total'], $_SESSION['invoicer']['tax']);
		\CoreHelp::sendMail($profile['email'], $settings['site_name'] . ' Invoice', "Please find attached the invoice from your purchase.", '', 'files/invoices/'.$reference.'.pdf');		
		//unset($_SESSION['invoicer']);
    }

   
}
