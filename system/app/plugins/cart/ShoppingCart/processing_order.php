<?php
   // 
   //      fields guide to send  -> https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/
   //
   require_once "config.php"; // load settings file
   require_once "_ShoppingCart.php"; // load class ShoppingCart
   
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
               <title><?=$_SESSION['settings']['site_name']?> Store - Sponsored By <?=$_SESSION['enroller']?></title>
               <meta name="description" content="">
               <meta name="viewport" content="width=device-width">
               <link rel="stylesheet" href="../vendor/bootstrap-3.1.1-dist/css/bootstrap.css">
               <link rel="stylesheet" href="../vendor/bootstrap-3.1.1-dist/css/bootstrap.min.css">
               <link rel="stylesheet" href="../ShoppingCart/ShoppingCart.css">
                <script src="/assets/common/vendor/jquery/dist/jquery.min.js"></script>
            </head>
            <body>
            <?php
				if(isset($error)):
			?>
            		<p class="alert alert-danger">
               			<?=$error?>
            		</p>
            <?php
				endif;
			?>	
				
			
               <div class="container">
                  <!-- Real environment or SandBox-->
                 	<h3>Thank you for your order, will be processed shortly.</h3>
                    <img src="/plugins/invoicer/member/generateinvoice" width="0" height="0" />
               </div>
               <script>
			   $(document).ready(function(){ 
			   		$('#cart_notification', window.parent.document).hide();
				});

			   </script>
            </body>
         </html>