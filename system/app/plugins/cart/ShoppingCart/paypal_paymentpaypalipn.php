<?php

//	
//
//      The way to inform the user about the status of your payment
//      for all $_POST -> https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/

require_once "config.php"; // load settings file
require_once "_ShoppingCart.php"; // load class ShoppingCart
// Examines all the IPN and turns it into a string

function Array2Str($kvsep, $entrysep, $a)
{
	$str = "";
	foreach ($a as $k => $v) {
		$str .= "{$k}{$kvsep}{$v}{$entrysep}";
	}
	return $str;
}

//
// Verifying paypal message - Using POST vars rm=2 in html form 
//

$req      = 'cmd=_notify-validate';
$fullipnA = array();

foreach ($_POST as $key => $value) {
	$fullipnA[$key] = $value;
	$encodedvalue   = urlencode(stripslashes($value));
	$req .= "&$key=$encodedvalue";
}

$fullipn = Array2Str(" : ", "\n", $fullipnA);


if ($_SESSION['settings']['settings_cart_paypal_sandbox'] != "yes") {
	$url = 'https://www.paypal.com/cgi-bin/webscr';
} else {
	$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
}

$curl_result = $curl_err = '';
$fp          = curl_init();
curl_setopt($fp, CURLOPT_URL, $url);
curl_setopt($fp, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($fp, CURLOPT_POST, 1);
curl_setopt($fp, CURLOPT_POSTFIELDS, $req);
curl_setopt($fp, CURLOPT_HTTPHEADER, array(
	"Content-Type: application/x-www-form-urlencoded",
	"Content-Length: " . strlen($req)
));
curl_setopt($fp, CURLOPT_HEADER, 0);
curl_setopt($fp, CURLOPT_VERBOSE, 1);
curl_setopt($fp, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($fp, CURLOPT_TIMEOUT, 30);

$response = curl_exec($fp);
$curl_err = curl_error($fp);
curl_close($fp);

// Vars received by Paypal

if (strcmp($response, "VERIFIED") == 0) {
	// Check the status of the order
	$payment_status = $_POST['payment_status'];
	if ($payment_status != "Completed") {
		echo "Invalid payment";
		$subject      = "Invalid payment";
		$msg          = "Invalid payment " . $payment_status;
		$address_name = $_POST['address_name'];

		sendMail($_SESSION['settings']['admin_email'], $subject, $msg . "\n\n" . print_r($_POST, true));		
		exit;
	}
	
	// Create a new order header in bsc_order_header 
	$Db   = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
	$Db->query("SET NAMES 'utf8'"); // formating to utf8
	
	$payment_status   = $_POST['payment_status'];
	$payment_amount   = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$txn_id           = $_POST['txn_id'];
	$receiver_email   = $_POST['receiver_email'];
	$txn_type         = $_POST['txn_type'];
	$pending_reason   = $_POST['pending_reason'];
	$payment_type     = $_POST['payment_type'];
	$custom           = json_decode(urldecode($_POST['custom']), true)[0];
	$invoice          = $_POST['invoice'];
	$member_email 	  = json_decode(urldecode($_POST['custom']), true)[1];
	
	// Buyer information
	$row 				  = $Db->getRow('bsc_customers', 'payer_email', $member_email);
	$first_name           = $row['first_name'];
	$last_name            = $row['last_name'];
	$address_name         = $row['address_name'];
	$address_country_code = $row['address_country_code'];
	$address_zip          = $row['address_zip'];
	$address_state        = $row['address_state'];
	$address_city         = $row['address_city'];
	$address_street       = $row['address_street'];

	$commissionable = $payment_amount - EW_SHIPPING;
	
	PayCommissions($member_email, $commissionable, $invoice);	
	
	$settings = array(
		'dateorder' => date('Y-m-d H:i:s'),
		'payer_email' => $member_email,
		'first_name' => $first_name,
		'last_name' => $last_name,
		'address_name' => $address_name,
		'address_country_code' => $address_country_code,
		'address_zip' => $address_zip,
		'address_state' => $address_state,
		'address_city' => $address_city,
		'address_street' => $address_street,
		'payment_status' => $payment_status,
		'payment_type' => $payment_type,
		'payment_currency' => $payment_currency,
		'payment_amount' => $payment_amount,
		'custom' => $custom,
		'invoice' => $invoice
	);
	$Db->insertRow('bsc_order_header', $settings);
	
	// now register the order detail
	for ($i = 1; $i <= $_POST['num_cart_items']; $i++) {
		
		// Vars received by Paypal
		$item_name   = $_POST['item_name' . $i];
		$item_number = $_POST['item_number' . $i];
		$quantity    = $_POST['quantity' . $i];
		
		$mc_gross   = $_POST['mc_gross_' . $i];
		$item_price = $mc_gross / $quantity;

		$settings = array(
			'dateorder' => date('Y-m-d H:i:s'),
			'item_name' => $item_name,
			'item_number' => $item_number,
			'quantity' => $quantity,
			'mc_gross' => $mc_gross,
			'item_price' => $item_price,
			'payment_status' => $payment_status,
			'payment_amount' => $payment_amount,
			'payment_currency' => $payment_currency,
			'payer_email' => $member_email,
			'payment_type' => $payment_type,
			'custom' => $custom,
			'invoice' => $invoice,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'address_name' => $address_name,
			'address_country_code' => $address_country_code,
			'address_zip' => $address_zip,
			'address_state' => $address_state,
			'address_city' => $address_city,
			'address_street' => $address_street
		);
		$Db->insertRow('bsc_order_detail', $settings); // inserts row into 'bsc_order' table
	} // cart
	
	// Add new Shipping
	if (EW_SHIPPING > 0) {
		$Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
		$Db->query("SET NAMES 'utf8'"); // formating to utf8
		$settings = array(
			'dateorder' => date('Y-m-d H:i:s'),
			'item_name' => 'Shipping',
			'item_number' => "",
			'quantity' => 1,
			'mc_gross' => EW_SHIPPING,
			
			'payment_status' => $payment_status,
			'payment_amount' => $payment_amount,
			'payment_currency' => $payment_currency,
			'payer_email' => $member_email,
			'payment_type' => $payment_type,
			'custom' => $custom,
			'invoice' => $invoice,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'address_name' => $address_name,
			'address_country_code' => $address_country_code,
			'address_zip' => $address_zip,
			'address_state' => $address_state,
			'address_city' => $address_city,
			'address_street' => $address_street
		);
		$Db->insertRow('bsc_order_detail', $settings); // inserts row into 'bsc_order' table
	}
	

	$message .= "<h2>ticket purchase " . $_POST['invoice'] . "</h2>";
	$message .= "<br>";
	$message .= $address_name . "<br>";
	$message .= $address_street . "<br>";
	$message .= $address_city . " " . $address_zip . "<br>";
	$message .= $address_state . "<br>";
	$message .= $address_country;
	$message .= "<br><br>";
	$message .= "<table border='0'>";
	// order detail
	for ($i = 1; $i <= $_POST['num_cart_items']; $i++) {
		$message .= "<tr>";
		$message .= "<td width='250'>" . $_POST['item_number_' . $i] . " - " . $_POST['item_name_' . $i] . "</td>"; // display product name
		$message .= "<td width='50'>" . $_POST['quantity_' . $i] . "</td>"; // Quantity
		$message .= "<td width='100'><b>" . $_POST['mc_gross_' . $i] . "</b></td>"; // gross        
		$message .= "</tr>";
	}
	
	// Shipping //
	if (EW_SHIPPING > 0) {
		$message .= "<td width='250'>" . "Shipping" . "</td>"; // display product name
		$message .= "<td width='50'>1</td>"; // Quantity
		$message .= "<td width='100'><b>" . EW_SHIPPING . "</b></td>"; // gross        
		$message .= "</tr>";
	}
	
	$message .= "</table>";
	$message .= "<h2>Total: " . $_POST['mc_gross'] . " " . $payment_currency . "</h2>";
	$message .= "<br>";
	$message .= $custom;
	
	$msg = "<html><body>" . $message . "</body></html>";
	
	// email to Buyer //////////////////////////////////////////////////////////////
	$subject = "Ticket " . $_POST['invoice'];
	
	sendMail($member_email, $subject, $msg, 'html');
	
	// email to Shop //////////////////////////////////////////////////////////////
	$message .= "<br><br>";
	// i take all $_POST parameters email notification
	foreach ($_POST as $name => $value) {
		$message .= $name . ": " . $value . "<br>";
	}
	$msg     = "<html><body>" . $message . "</body></html>";
	$subject = "New payment was successfully recieved from " . $member_email;
	
	sendMail($_SESSION['settings']['admin_email'], $subject, $msg, 'html');
	
} else {
	
	//the transaction is invalid I can NOT charge the client. 
	foreach ($_POST as $name => $value) {
		$message .= $name . ": " . $value . "<br>";
	}
	$msg = "<html><body>" . $message . "</body></html>";
	
	$subject = "Invalid payment ";
	$message = "Invalid payment from " . $member_email . " Status:" . $payment_status;
	
	sendMail($_SESSION['settings']['admin_email'], $subject, $message, 'text');
}
