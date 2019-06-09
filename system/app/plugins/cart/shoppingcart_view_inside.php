<?php

$mainUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/";
require_once "ShoppingCart/config.php";                // load settings file
require_once "ShoppingCart/_ShoppingCart.php";     // load class ShoppingCart
$menu = 'cart';
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

    <head>
    	<base href="<?=$mainUrl?>system/app/plugins/cart/">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="vendor/bootstrap-3.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="ShoppingCart/ShoppingCart.css">
        <script src="vendor/jquery-2.1.0.min.js"></script>
        <script src="vendor/jquery-ui-1.10.4.custom.min.js"></script>

    </head>
    <body>
        <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]--> 

        <!-- header menu -->

        <div class="container">
            <div class="row">
                <div class="col-md-2 hidden-xs">
                    <div class="nav-list" id="cartbox">

                        <div class="ShoppingCartHead"><div style="padding:10px;" >Shopping Cart</div></div><br />
                        This is all right?<br /><br />
                        <a class="btn btn-success checkout_button" >Proceed to checkout<i class="icon-chevron-right"></i></a>
                    </div> 
                </div>

                <div class="col-md-10">
                    <!--Products-->
                    <div class="container"> 
                        <div class="col-md-10">
                            <?php
                            //
                            // Show Shopping Cart 
                            //
                            $cart = new shoppingcart(); // init shoppingcart
                            $cart->init('my_shop');
                            if (!$cart->get_cart()) {  //checking if the cart is empty or not
                                echo "<h3>ShoppingCart is empty</h3>";
                                echo "<a href='shoppingcart_main_inside.php'>Go back</a>";  // return to last product page
								echo "<script>
								   $(document).ready(function(){ 
										$('#cart_notification', window.parent.document).hide();
									});					
								   </script>";
                            } else { // the shoppingcart has content
                                include("ShoppingCart/shoppingcart_inside.php"); //show shoppingcart                            
                            }  // the shoppingcart has content 
                            //
                        // Show Shopping Cart 
                            //
                        ?>
                        </div>
                    </div> 
                </div>
            </div>


        </div>
		<br><br><br><br><br><br><br>
        <!-- /container --> 
        
        <script src="vendor/bootstrap-3.1.1-dist/js/bootstrap.min.js"></script> 
        <!-- BootsrapShoppingCart.js -->
        <script src="ShoppingCart/ShoppingCart_inside.js"></script>  
        <script>
            $(document).ready(function() {
                // show current shoppingcart
                $("#BSCart").load("ShoppingCart/addproduct_vertical.php");
            });
        </script>
    </body>
</html>
