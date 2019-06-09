<?php

include(__DIR__ . "/../../../../../vendor/autoload.php");

require_once "eden.php";  // Eden Framework class mysql

//--------------------------------------------------------
// Mysql setup 
//--------------------------------------------------------

include(__DIR__ . "/../../../configs/database.php");

define("EW_CONN_HOST", $config['default']['host'], TRUE); // mysql host
define("EW_CONN_PORT", 3306, TRUE); // mysql port
define("EW_CONN_USER", $config['default']['user'], TRUE); // mysql username
define("EW_CONN_PASS", $config['default']['pass'], TRUE); // mysql password
define("EW_CONN_DB", $config['default']['name'], TRUE); // mysql data base name

$Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate

$rs = $Db->getRows('settings');

foreach ($rs as $row) {
	$kname       = $row['keyname'];
	$setting[$kname] = $row['value'];
}


$session = eden('session')->start();     //instantiate session
date_default_timezone_set('Europe/Paris');

$_SESSION['settings'] = $setting;

//--------------------------------------------------------
// Currency setup 
//--------------------------------------------------------
define("EW_CURRENCY_SYMBOL", $setting['settings_cart_currency_symbol'], TRUE); // Configure the symbol
define("EW_CURRENCY_CODE", $setting['settings_cart_currency_code'], TRUE ); // USD or EUR or CAD or GBP or see all codes https://developer.paypal.com/webapps/developer/docs/classic/api/currency_codes/

//--------------------------------------------------------
// Paypal setup 
//--------------------------------------------------------
$site_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/";
$use_paypal_sandbox = FALSE; // false are real environment / true uses paypal sandbox 
define("EW_WEB_PATH", $site_url . 'system/app/plugins/cart/', TRUE); // Full script location URL  / its very important for put the final '/'  like http://www.mydom.com/ 
define("EW_PAYPAL_REGISTERED_EMAIL", $setting['settings_cart_paypal_email'], TRUE);  // Business email of store owner.
define("EW_EMAIL", $setting['admin_email'], TRUE);// Email for news purchases

//--------------------------------------------------------
// Cash on delivery 
//--------------------------------------------------------
define("EW_CASHONDELIVERY", 10, TRUE); // Extra charge ? for Cash on delivery, no extra charge then 0

//--------------------------------------------------------
// Shipping setup
//--------------------------------------------------------
define("EW_SHIPPING", 0, TRUE); // Shipping flat rate, or if shipping=0 then no shipping 

//--------------------------------------------------------
// Pagination 
//--------------------------------------------------------
define("EW_PAGINATION", 8, TRUE); // 6 products for page