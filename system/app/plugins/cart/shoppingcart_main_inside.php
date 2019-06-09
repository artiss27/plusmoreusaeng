<?php
$mainUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/";
require_once "ShoppingCart/config.php";                // load settings file
require_once "ShoppingCart/_ShoppingCart.php";     // load class ShoppingCart


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
        <link rel="stylesheet" href="ShoppingCart/animation.css">
        <script src="vendor/jquery-2.1.0.min.js"></script>
        <script src="vendor/jquery-ui-1.10.4.custom.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		<!-- header menu -->

        <!-- Product categories -->
        <div class="container">
            <div class="row" id="animation_slideDown">
                <div class="col-md-12">
                    <?php
                    //
                    // List categories
                    //
                    include "ShoppingCart/categories_list_inside.php";
                    //
                    // List categories
                    //
                    ?>
                </div>
            </div>
        </div>

        <!-- Shopping cart -->
        <div class="container">
            <div class="row">
                <div class="col-md-2 hidden-sm hidden-xs">
                    <div class="nav-list" id="cartbox"> 
                        <?php
                        //
                        // Show Shopping Cart
                        //
                        ?>
                        <div id="BSCart" class="collections">
                            <div class="BSCart_list">                               

                            </div>
                        </div>
                        <?php
                        //
                        // /Show Shopping Cart
                        //
                        ?>
                    </div> 
                </div>

                <!-- Products --> 
                <div class="col-md-10">
                    <div class="row"> 
                        <section class="products">
                            <?php 
                            //
                            // Show Product Grid 
                            //
                            if (isset($_GET['category'])) {
                                $category = $_GET['category'];
                            } else {
                                $category = 0;
                            } // list category from table bsc_category
                            $shoppingcart_vertical = 1; // if the is vertical shoppingcart_vertical=1 / is top or bottom are horitzontal -> shoppingcart_vertical=0
                            $_SESSION['LastProductPage'] = $_SERVER["REQUEST_URI"]; // take the name of this page for return
                            include "ShoppingCart/products_grid_inside.php";  // list products 
                            //
                            // Show Product Grid 
                            //
                            ?>
                        </section>   
                    </div>

                </div>
            </div>
        </div>
        <?php include "ShoppingCart/inc.pagination_inside.php";  // list products  ?>
        <!-- /container --> 

        
        <script src="vendor/bootstrap-3.1.1-dist/js/bootstrap.min.js"></script> 
        <!-- BootsrapShoppingCart.js -->
        <script src="ShoppingCart/ShoppingCart_inside.js"></script>  
        <script>
            $(document).ready(function() {
                // show current shoppingcart
                $("#BSCart").load("ShoppingCart/addproduct_vertical_inside.php");
                // anim buttons categories 
                $('#animation_slideDown').addClass("slideDown");	
				
            });            
        </script>
    </body>
</html>
