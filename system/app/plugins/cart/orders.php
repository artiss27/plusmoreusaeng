<?php
   $mainUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/";
   require_once "ShoppingCart/config.php";                // load settings file
   require_once "ShoppingCart/_ShoppingCart.php";     // load class ShoppingCart
     
   if(!isset($_SESSION['customer'])) {
   	redirect("/store/".$_COOKIE['enroller']."/login");	
   }    
     
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
               <base href="<?=$mainUrl?>system/app/plugins/cart/">
               <meta charset="utf-8">
               <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
               <title><?=$_SESSION['settings']['site_name']?> Store - Sponsored By <?=$_SESSION['enroller']?></title>
               <meta name="description" content="">
               <meta name="viewport" content="width=device-width">
               <link rel="stylesheet" href="vendor/bootstrap-3.1.1-dist/css/bootstrap.min.css">
               <link rel="stylesheet" href="ShoppingCart/ShoppingCart.css">
               <script src="vendor/jquery-2.1.0.min.js"></script>
               <script src="vendor/jquery-ui-1.10.4.custom.min.js"></script>
               <!-- validate form -->
               <link rel="stylesheet" href="vendor/jQuery-Validation-Engine-master/css/validationEngine.jquery.css" type="text/css"/>
               <script src="vendor/jQuery-Validation-Engine-master/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
               <script src="vendor/jQuery-Validation-Engine-master/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
            </head>
            <body>
               <!--[if lt IE 7]>
               <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
               <![endif]--> 
               <!-- header menu -->
               <?php include("ShoppingCart/inc.menu.php"); ?>
               <div class="container">
                  <div class="row">
                     <!-- Shopping cart -->
                     <div class="col-md-12">
                        <!--form-->
                        <div class="container">
                           <?php if(isset($_SESSION['alert'])):?>
                           <div class="alert alert-<?=$_SESSION['alert']['type']?>">
                              <?=$_SESSION['alert']['message']?>
                           </div>
                           <?php endif; ?><br><br>
                           <div class="col-md-12">
                              <div class="table-responsive">
                                 <table summary="Product Purchases" class="table table-bordered table-hover">
                                    <thead>
                                       <tr>
                                          <th>Ordate Date</th>
                                          <th>Invoice</th>
                                          <th>Payment Status</th>
                                          <th>Amount</th>
                                          <th>Shipping Status</th>
                                          <th>Notes</th>
                                          <th>Information</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                    	<?php 
										
										$orders = GetOrders();
										if(!$orders):
											echo '<tr><td colspan="7">No purchases found for your account.</td></tr>';	
										else:
											foreach ($orders as $order):
										?>
                                        <tr>
                                       	<td>
                                        <?=$order['dateorder']?>
                                        </td>
                                        <td>
                                        <?=$order['invoice']?>
                                        </td> 
                                        <td>
                                        <?=$order['payment_status']?>
                                        </td> 
                                        <td>
                                         <?=EW_CURRENCY_SYMBOL . number_format($order['payment_amount'], 2, '.', '')?>
                                        </td>
                                        <td>
                                        <?=$order['shipping_status']?>
                                        </td> 
                                         <td>
                                        <?=$order['custom']?>
                                        </td> 
                                        <td>
                                        <a href="view_order.php?invoice=<?=$order['invoice']?>">View Order</a>
                                        </td> 
                                        </tr>
                                        <?php endforeach;
										endif;
										 ?>
                                       
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/form-->
                  </div>
               </div>
               </div>
               <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
               <?php include("ShoppingCart/inc.foot.php"); ?>
               <!-- /container --> 
               <script src="vendor/bootstrap-3.1.1-dist/js/bootstrap.min.js"></script> 
               <!-- BootsrapShoppingCart.js -->
               <script src="ShoppingCart/ShoppingCart.js"></script>  
               <script>
                  $(document).ready(function () {
                  });
               </script>
            </body>
         </html>