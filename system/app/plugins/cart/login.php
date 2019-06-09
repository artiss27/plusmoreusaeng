<?php
	$mainUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/";
   require_once "ShoppingCart/config.php";                // load settings file
   require_once "ShoppingCart/_ShoppingCart.php";     // load class ShoppingCart
	if(isset($_POST['type'])) {
		if ($_POST['type'] == "login") {
			trackRetries('login');
			if(CheckLogin($_POST['email'], $_POST['password'])){
				if(count($_SESSION['my_shop']) > 0){
					header("location: /system/app/plugins/cart/shoppingcart_checkout.php");	
				}
				else {
					$store = isset($_COOKIE['enroller']) ? $_COOKIE['enroller'] : (isset($_SESSION['enroller']) ? $_SESSION['enroller'] : 'admin');
					redirect("/store/".$store."/");	
				}
			}
			else {
				$_SESSION['alert']['type'] = "danger";
				$_SESSION['alert']['message'] = "Wrong email or password.";	
			}
		}
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
                         <?php endif; ?>
                         <br><br>
                           <div class="col-md-4">
                           </div>
                           <div class="col-md-4">
                              <table class="ShoppingCartHead" width="100%" height="40" border="0" cellspacing="0" cellpadding="0" >
                                 <tr>
                                    <td align="left">&nbsp;&nbsp;Login</td>
                                 </tr>
                              </table>
                              <div style="margin-top: 20px;">
                                 Please fill the form
                              </div>
                              <div style="margin-top: 20px;">
                                 <form action="" method="post" id="login_form" name="login_form">
                                    <div class="row">
                                       <div class="col-md-12">
                                          <label><span class="control-label">Email*</span></label>
                                          <input type="text" value="<?=isset($_POST['email']) ? htmlentities($_POST['email']) : ''?>" class="form-control validate[required,custom[email]]" name="email"  id="email"   placeholder="Email">                         
                                          <label><span class="control-label">Password*</span></label>
                                          <input type="password" value="" class="form-control validate[required]" name="password"  id="password"   placeholder="Password">
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px; margin-top:10px;"><a href="forgot.php">Forgot Password</a></div>
                                          <div style="margin-top: 25px; text-align: right;">
                                          	 <input type="hidden" name="type" value="login">
                                             <button class="btn btn-success" type="submit" >Login</button>
                                          </div>
                                                                                 </div>
                                    </div>
                                 </form>
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
                      // show current shoppingcart
                      $("#BSCart").load("ShoppingCart/addproduct_vertical.php");
                  
                      $("#form").validationEngine(); // init form validator
					  $("#login_form").validationEngine(); // init form validator
                  });
               </script>
            </body>
         </html>