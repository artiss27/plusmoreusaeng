<?php
//
//      fields guide to send  -> https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/
//
require_once "config.php"; // load settings file
require_once "_ShoppingCart.php"; // load class ShoppingCart
if (isset($_POST['make_purchase']) || $_SESSION['paypal']) {
    // Create a new order header in bsc_order_header
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    if (!isset($_SESSION['customer_data']['payer_email'])) {
        die("Session expired, please login again");
    }
    $customerData = $Db->getRow('bsc_customers', 'payer_email', $_SESSION['customer_data']['payer_email']);
    $customer_region = $customerData['address_state'];
    $settingsMain = $Db->getRow('settings', 'keyname', 'settings_cart_tax_percent');
    $tax_percent = $settingsMain['value'];

    $shopcart = new shoppingcart(); // init shoppingcart
    $shopcart->init('my_shop');
    if (!$shopcart->get_cart()) {  //checking if the cart is empty or not
        echo "<h3>Shopping cart is empty</h3>";
        echo "<a href='shoppingcart_main_inside.php'>Go back</a>";
        die();
    }
    $list = array();
    $result = $Db->query("SELECT * FROM wallet_deposit WHERE 1  AND member_id='" . $_SESSION['member_id'] . "' ORDER BY transaction_date DESC");
    foreach ($result as $row) {
        $amount = $row['amount'];
        $date = date("d M Y H:i", $row['transaction_date']);
        $description = $row['descr'];
        array_push($list, array(
            "id" => $row['id'],
            "date" => $date,
            "amount" => $amount,
            "description" => $description
        ));
    }
    //var_dump($list);
    $sp1 = $Db->query("SELECT SUM(amount) as total FROM wallet_payout WHERE to_id = " . $_SESSION['member_id']);
    $sp2 = $Db->query("SELECT SUM(amount) as total FROM wallet_deposit WHERE member_id = " . $_SESSION['member_id']);
    $bsc = $shopcart->get_cart(); // get shoppingcart
    $render = new renderchartshop($bsc); // render shoppingcart
    $shoppingcart = $render->get(); // get render
    $price = 0;
    $invoice = uniqid();
    $from_payout = abs(number_format(0, 2, '.', ''));
    $from_deposit = abs(number_format($list[0]['amount'], 2, '.', ''));
    $_SESSION['invoicer'] = array();
    foreach ($shoppingcart as $cart) {
        $pinfo = array('name' => $cart['name'] . ' ' . $cart['name_type'], 'quantity' => $cart['quantity']);
        if ($cart['price_offer'] > 0) {
            $price += $cart['price_offer'] * $cart['quantity'];
            $pinfo['price'] = $cart['price'] * $cart['quantity'];
            $pinfo['discount'] = ($cart['price'] - $cart['price_offer']) * $cart['quantity'];
        } else {
            $price += $cart['price'] * $cart['quantity'];
            $pinfo['price'] = $cart['price'] * $cart['quantity'];
            $pinfo['discount'] = 0;
        }
        //shipping per product
        $shipping_subtotal = GetShippingAmount($cart['id_product'], $customer_region) * $cart['quantity'];
        $shipping_total += $shipping_subtotal;
        $_SESSION['invoicer']['products'][] = $pinfo;
    }
    $_SESSION['invoicer']['coupon_discount'] = 0;
    if ($_SESSION['discount'] > 0) {
        $price -= $_SESSION['discount'];
        $_SESSION['invoicer']['coupon_discount'] = $_SESSION['discount'];
    }
    $tax_amount = $price * $tax_percent / 100;
    $total = $price + $shipping_total + $tax_amount;

    $_SESSION['invoicer']['shipping'] = $shipping_total;
    $_SESSION['invoicer']['tax'] = $tax_amount;
    $_SESSION['invoicer']['total'] = $total;

    if ($from_payout + $from_deposit != number_format($total, 2, '.', '')) {
        $error = "Sum from both wallets must be equal $" . number_format($total, 2, '.', '');
    }
    if ($from_payout > $sp1[0]['total']) {
        $error = "You have not enough balance on your Payout Wallet to complete your transaction";
    }
    if ($from_deposit > $sp2[0]['total']) {
        $error = "You have not enough balance on your Deposit Wallet to complete your transaction";
    }
    if ($from_payout < 0 || $from_deposit < 0) {
        $error = "You can not use negative numbers as amounts";
    }
    if (!isset($error)) {
        if ($from_payout > 0) {
            $Db->query("INSERT INTO wallet_payout (amount, transaction_type, to_id, transaction_date, descr) 
				VALUES ('-$from_payout', 2, '" . $_SESSION['member_id'] . "', '" . time() . "', 'Product Purchase for Invoice: " . $invoice . "')");
        }
        if ($from_deposit > 0) {
            $Db->query("INSERT INTO wallet_deposit (amount, member_id, transaction_date, descr) 
				VALUES ('-$from_deposit', '" . $_SESSION['member_id'] . "', '" . time() . "', 'Product Purchase for Invoice: " . $invoice . "')");
        }

        // Buyer information
        $row = $Db->getRow('bsc_customers', 'payer_email', $_SESSION['customer_data']['payer_email']);
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $address_name = $row['address_name'];
        $address_country_code = $row['address_country_code'];
        $address_zip = $row['address_zip'];
        $address_state = $row['address_state'];
        $address_city = $row['address_city'];
        $address_street = $row['address_street'];

        $commissionable = $price;  //take out shipping and tax
        PayCommissions($_SESSION['customer_data']['payer_email'], $commissionable, $invoice);

        $settings = array(
            'dateorder' => date('Y-m-d H:i:s'),
            'payer_email' => $_SESSION['customer_data']['payer_email'],
            'first_name' => $first_name,
            'last_name' => $last_name,
            'address_name' => $address_name,
            'address_country_code' => $address_country_code,
            'address_zip' => $address_zip,
            'address_state' => $address_state,
            'address_city' => $address_city,
            'address_street' => $address_street,
            'payment_type' => 'Internal Payment',
            'payment_status' => 'Completed',
            'payment_currency' => 'USD',
            'payment_amount' => $price,
            'custom' => $_SESSION['cart']['comments'],
            'invoice' => $invoice
        );
        $Db->insertRow('bsc_order_header', $settings);

        $bsc = $shopcart->get_cart(); // get shoppingcart
        $render = new renderchartshop($bsc);  // render shoppingcart
        $shoppingcart = $render->get();   // get render
        $i = 1;
        foreach ($shoppingcart as $cart) {
            if ($cart['price_offer'] > 0) {
                $amount = $cart['price_offer'];
            } else {
                $amount = $cart['price'];
            }
            $item_price = $amount / $cart['quantity'];
            $settings = array(
                'dateorder' => date('Y-m-d H:i:s'),
                'item_name' => $cart['name'] . ' ' . $cart['name_type'],
                'item_number' => $cart['productCode'],
                'quantity' => $cart['quantity'],
                'mc_gross' => $amount,
                'item_price' => $item_price,
                'shipping_price' => $shipping_total,
                'tax_amount' => $tax_amount,
                'payment_status' => 'Completed',
                'payment_amount' => $price,
                'payment_currency' => 'USD',
                'payer_email' => $_SESSION['customer_data']['payer_email'],
                'payment_type' => 'Internal Payment',
                'custom' => $_SESSION['cart']['comments'],
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
        $shopcart->removeall_cart();
        $_SESSION['discount'] = 0;
        $_SESSION['paypal'] = false;
        header("location: processing_order.php");
        exit;
    }
    unset($_SESSION['invoicer']);

}

UpdateCreateUser();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9">
<![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="../vendor/bootstrap-3.1.1-dist/css/bootstrap.css">
  <link rel="stylesheet" href="../vendor/bootstrap-3.1.1-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../ShoppingCart/ShoppingCart.css">
</head>
<body>
<?php
if (isset($error)):
    ?>
  <p class="alert alert-danger">
      <?= $error ?>
  </p>
<?php
endif;
?>


<div class="container">
  <!-- Real environment or SandBox-->
    <?php
    if (!isset($_SESSION['customer_data']['payer_email'])) {
        die("Session expired, please login again");
    }
    $customerData = $Db->getRow('bsc_customers', 'payer_email', $_SESSION['customer_data']['payer_email']);
    $customer_region = $customerData['address_state'];
    $settingsMain = $Db->getRow('settings', 'keyname', 'settings_cart_tax_percent');
    $tax_percent = $settingsMain['value'];
    $shopcart = new shoppingcart(); // init shoppingcart
    $shopcart->init('my_shop');
    if (!$shopcart->get_cart()) { //checking if the cart is empty or not
        echo "<h4>Shopping cart is empty</h4>";
        echo "<a href='shoppingcart_main_inside.php'>Go back</a>";
        die();
    } else {

        // Create a new order header in bsc_order_header
        $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
        $Db->query("SET NAMES 'utf8'"); // formating to utf8

        $sp1 = $Db->query("SELECT SUM(amount) as total FROM wallet_payout WHERE to_id = " . $_SESSION['member_id']);
        $sp2 = $Db->query("SELECT SUM(amount) as total FROM wallet_deposit WHERE member_id = " . $_SESSION['member_id']);
        $bsc = $shopcart->get_cart(); // get shoppingcart
        $render = new renderchartshop($bsc); // render shoppingcart
        $shoppingcart = $render->get(); // get render
        $price = 0;
        $total = 0;
        $shipping_total = 0;
        foreach ($shoppingcart as $cart) {
            if ($cart['price_offer'] > 0) {
                $price += $cart['price_offer'] * $cart['quantity'];
            } else {
                $price += $cart['price'] * $cart['quantity'];
            }
            //shipping per product
            $shipping_subtotal = GetShippingAmount($cart['id_product'], $customer_region) * $cart['quantity'];
            $shipping_total += $shipping_subtotal;
        }
        if ($_SESSION['discount'] > 0) {
            $price -= $_SESSION['discount'];
        }
        $tax_amount = $price * $tax_percent / 100;
        $total = $price + $shipping_total + $tax_amount;

        if (isset($_POST['comments'])) {
            $_SESSION['cart']['comments'] = $_POST['comments'];
        }
        ?>
      <h4>Deposit Wallet Balance: $<?= number_format($sp2[0]['total'], 2, '.', '') ?> - <a href="/members/depositwallet"
                                                                                           class="btn btn-primary"
                                                                                           target="_parent">Make a
          Deposit</a></h4>
      <h4>Payout Wallet Balance: $<?= number_format($sp1[0]['total'], 2, '.', '') ?></h4>
      <br>
      <h4>Purchase Amount: $<?= number_format($total, 2, '.', '') ?></h4>
      <br>
      <form id="form1" method="post" action="">
        <p>From Deposit Wallet : </p>
        <input class="form-control" name="sp2" placeholder="Amount from your Deposit Wallet">
        <br/>
        <p>From Payout Wallet : </p>
        <input class="form-control" name="sp1" placeholder="Amount from your Payout Wallet">
        <br/>

        <input type="submit" name="make_purchase" id="button" class="btn btn-sm btn-primary m-t-n-xs" value=" Pay "/>
      </form>
        <?php
    } // the shoppingcart has content
    ?>
</div>
</body>
</html>