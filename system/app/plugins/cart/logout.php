<?php
   require_once "ShoppingCart/config.php";                // load settings file
   require_once "ShoppingCart/_ShoppingCart.php";     // load class ShoppingCart

	unset($_SESSION['customer']);
	redirect("/store/".$_COOKIE['enroller']."/");	   
   
?>
