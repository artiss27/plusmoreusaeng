<?php
// 
//      fields guide to send  -> https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/
//
require_once "config.php"; // load settings file
require_once "_ShoppingCart.php"; // load class ShoppingCart
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?=$_SESSION['settings']['site_name']?> Store - Sponsored By <?=$_SESSION['enroller']?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="../vendor/bootstrap-3.1.1-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../vendor/bootstrap-3.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../ShoppingCart/ShoppingCart.css">
        <script>
           setTimeout('document.paypalform.submit()', 100); // auto submit form
        </script>
    </head>

    <body>

        <div class="centerdiv">
            <!-- Real environment or SandBox-->
            <?php
			$customerData			  = $Db->getRow('bsc_customers', 'payer_email', $_SESSION['customer_data']['payer_email']);
			$customer_region 		  = $customerData['address_state'];
			$settingsMain	          = $Db->getRow('settings', 'keyname', 'settings_cart_tax_percent');
			$tax_percent 		      = $settingsMain['value'];
            $shopcart = new shoppingcart(); // init shoppingcart
            $shopcart->init('my_shop');
            if (!$shopcart->get_cart()) {  //checking if the cart is empty or not
                echo "<h3>Shopping cart is empty</h3>";
                echo "<a href='javascript:history.go(-1)'>Go back</a>"; 
                die();
            } else { // the shoppingcart has content
                echo '<h3>Connecting to Paypal ... <img src="../images/loader.gif" /></h3>';
                if ($_SESSION['settings']['settings_cart_paypal_sandbox'] == "yes") {
                    // SandBox
                    $action = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                } else {
                    // Real environment
                    $action = "https://www.paypal.com/cgi-bin/webscr";
                }
				
				$custom = urlencode(json_encode(array($_POST['comments'], $_SESSION['customer_data']['payer_email'])));
                ?>

                <form action="<?php echo($action) ?>" method="post" name="paypalform">
                    <input type="hidden" name="cmd"				value="_cart"> <!-- Define we send a cart to Paypal -->
                    <input type="hidden" name="upload"				value="1"> <!-- Upload the contents of a third-party shopping cart or a custom shopping cart. -->
                    <input type="hidden" name="business"			value="<?php echo (EW_PAYPAL_REGISTERED_EMAIL); ?>"> <!-- Your paypal email account --> 
                    <input type="hidden" name="return"				value="<?php echo (EW_WEB_PATH); ?>shoppingcart_thanks_purchase.php"> <!-- if payment complete then show "Thanks !" -->
                    <input type="hidden" name="notify_url"			value="<?php echo (EW_WEB_PATH); ?>ShoppingCart/paypal_paymentpaypalipn.php"> <!-- The URL to which PayPal posts information about the payment, notification messages.  -->  
                    <input type="hidden" name="currency_code"			value="<?php echo (EW_CURRENCY_CODE) ?>"> <!-- Currency code / setup config.php -->
                    <input type="hidden" name="rm"				value="2"> <!-- Return method 2-are POST -->  
                    <input type="hidden" name="custom"                          value="<?php echo $custom ?>"> <!-- Comments from checkout -->
                    <input type="hidden" name="invoice"                         value="<?php echo date("YmdHis"); ?>"> <!-- My num invoice its inverted date -->
                    <?php
                    //////////////////////////////////////////////////////////////////////////////////////
                    // Make form products
                    //////////////////////////////////////////////////////////////////////////////////////
                    $bsc = $shopcart->get_cart(); // get shoppingcart
                    $render = new renderchartshop($bsc);  // render shoppingcart
                    $shoppingcart = $render->get();   // get render 
                    $i = 1;
                    foreach ($shoppingcart as $cart) {
                        if ($cart['price_offer'] > 0) { $price = $cart['price_offer']; } else { $price = $cart['price']; }
						if ($cart['price_offer'] > 0) {
                     		$price += $cart['price_offer'] * $cart['quantity'];
                     	} else {
                     		$price += $cart['price'] * $cart['quantity'];
                     	}
                        ?>
                        <input type="hidden" name="item_number_<?php echo($i) ?>"   value="<?php if (isset($cart['productCode'])) { echo $cart['productCode']; } else { echo "";} ?>"> <!-- Number item code, like a id for identificate your product --> 
                        <input type="hidden" name="item_name_<?php echo($i) ?>"     value="<?php echo $cart['name'] . ' ' . $cart['name_type']; ?>">	<!-- Name item -->
                        <input type="hidden" name="quantity_<?php echo($i) ?>"      value="<?php echo $cart['quantity']; ?>"> <!-- Quantity items -->
                        <input type="hidden" name="amount_<?php echo($i) ?>"        value="<?php echo $price; ?>"> <!-- Amount -->
                        <?php
                        $i++;
						$shipping_subtotal = GetShippingAmount($cart['id_product'], $customer_region) * $cart['quantity'];
						$shipping_total += $shipping_subtotal;
                    } // foreach product
                    
                    //////////////////////////////////////////////////////////////////////////////////////
                    // Discount Coupon ? 
                    //////////////////////////////////////////////////////////////////////////////////////
                    if ($_SESSION['discount'] > 0) {
                        ?>   
                        <input id="discount_amount_cart" name="discount_amount_cart" type="hidden" value="<?php echo ($_SESSION['discount']); ?>"><!-- Amount -->
                        <?php
                    }
                    //////////////////////////////////////////////////////////////////////////////////////
                    // Add shipping, the last row 
                    //////////////////////////////////////////////////////////////////////////////////////
					//shipping per product
					
                    if ($shipping_total > 0) {
                        ?>
                        <input type="hidden" name="item_name_<?php echo($i) ?>"		value="Shipping"><!-- Name item -->
                        <input type="hidden" name="quantity_<?php echo($i) ?>"		value="1"><!-- Quantity items -->
                        <input type="hidden" name="amount_<?php echo($i) ?>"		value="<?php echo $shipping_total ?>"><!-- Amount -->
                    <?php
                	}
					$tax_amount = $price  * $tax_percent / 100;
					if ($shipping_total > 0) {
                        ?>
                        <input type="hidden" name="item_name_<?php echo($i) ?>"		value="Tax"><!-- Name item -->
                        <input type="hidden" name="quantity_<?php echo($i) ?>"		value="1"><!-- Quantity items -->
                        <input type="hidden" name="amount_<?php echo($i) ?>"		value="<?php echo $tax_amount ?>"><!-- Amount -->
                    <?php
                	}
                ?>
                </form>
                <?php
                $shopcart->removeall_cart();
                $_SESSION['discount'] = 0;
            } // the shoppingcart has content 
            ?>
        </div>

    </body>
</html>