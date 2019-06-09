<?php

require_once "../ShoppingCart/config.php"; // load settings file
require_once "../ShoppingCart/_ShoppingCart.php"; // load class ShoppingCart

file_put_contents('debug.txt', print_r($_POST, true));

if (isset($_POST['selectData'])) {
    $Db      = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
	$Db->query("SET NAMES 'utf8'"); // formating to utf8
	
	$data     = array(
			'shipping_status' => $_POST['selectData']
		);
		$filter[] = array(
			'id=%d',
			$_POST['id']
		);
	$Db->updateRows('bsc_order_header', $data, $filter);
	
}

?>
