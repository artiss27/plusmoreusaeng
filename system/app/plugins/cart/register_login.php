<?php
	$mainUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/";
   require_once "ShoppingCart/config.php";                // load settings file
   require_once "ShoppingCart/_ShoppingCart.php";     // load class ShoppingCart
   
	if(isset($_POST['type'])) {
		if($_POST['type'] == "register") {
			$first_name = $_POST['first_name'];
    		$last_name = $_POST['last_name'];
    		$address_name = $_POST['first_name'] . ' ' . $_POST['last_name'];
			$address_country = get_country_by_code($_POST['address_country_code']);
    		$address_country_code = $_POST['address_country_code'];
    		$address_zip = $_POST['address_zip'];
    		$address_state = $_POST['address_state'];
    		$address_city = $_POST['address_city'];
    		$address_street = $_POST['address_street'];
			$password = $_POST['password'];
			$payer_email = $_POST['payer_email'];
			$checkUser = CheckUser($payer_email, $password, $first_name, $last_name, $address_name, $address_country, $address_country_code, $address_zip, $address_state, $address_city, $address_street);
			if($checkUser == false) {
				$_SESSION['alert']['type'] = "danger";
				$_SESSION['alert']['message'] = "Email already registered on the system, please login.";
			}
			else {
				$_SESSION['alert']['type'] = "success";
				$_SESSION['alert']['message'] = "Your account was successfully created.";				
				redirect("/system/app/plugins/cart/login.php");		
	
			}
		}
		elseif ($_POST['type'] == "login") {
			if(CheckLogin($_POST['email'], $_POST['password'])){
				if(count($_SESSION['my_shop']) > 0){
					redirect("/system/app/plugins/cart/shoppingcart_checkout.php");	
				}
				else {
					redirect("/store/".$_SESSION['enroller']."/");	
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
                           <div class="col-md-8">
                              <table class="ShoppingCartHead" width="100%" height="40" border="0" cellspacing="0" cellpadding="0" >
                                 <tr>
                                    <td align="left">&nbsp;&nbsp;Registration</td>
                                 </tr>
                              </table>
                              <div style="margin-top: 20px;">
                                 Please fill the form
                              </div>
                              <div style="margin-top: 20px;">
                                   <form action="" method="post" id="form" name="form">
                                    <div class="row">
                                       <div class="col-md-4">
                                          <label><span class="control-label">First name*</span></label>
                                          <input type="text" value="<?=isset($_POST['first_name']) ? htmlentities($_POST['first_name']) : ''?>" class="form-control validate[required]" name="first_name"  id="first_name"   placeholder="First name">
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px;">Your first name</div>
                                          <label><span class="control-label">Last name*</span></label>
                                          <input type="text" value="<?=isset($_POST['last_name']) ? htmlentities($_POST['last_name']) : ''?>" class="form-control validate[required]" name="last_name"  id="last_name"   placeholder="Last name">
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px;">Your last name</div>
                                          <label><span class="control-label">Email*</span></label>
                                          <input type="text" value="<?=isset($_POST['payer_email']) ? htmlentities($_POST['payer_email']) : ''?>" class="form-control validate[required,custom[email]]" name="payer_email"  id="payer_email"   placeholder="Email">
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px;">Your email</div>
                                          <label><span class="control-label">Password*</span></label>
                                          <input type="password" value="" class="form-control validate[required]" name="password"  id="password"   placeholder="Password">
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px;">Your password</div>
                                       </div>
                                       <div class="col-md-4">
                                          <label><span class="control-label">Street Address*</span></label>
                                          <input type="text" value="<?=isset($_POST['address_street']) ? htmlentities($_POST['address_street']) : ''?>" class="form-control validate[required]" name="address_street"  id="address_street"   placeholder="Address">
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px;">Street Name and/or apartment number</div>
                                          <label><span class="control-label">Zip Code*</span></label>
                                          <input type="text" value="<?=isset($_POST['address_zip']) ? htmlentities($_POST['address_zip']) : ''?>" class="form-control validate[required]" name="address_zip" id="address_zip" placeholder="Zip Code">
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px;">Please provide your zip code</div>
                                          <label><span class="control-label">Confirm Email*</span></label>
                                          <input type="text" value="<?=isset($_POST['confirm_payer_email']) ? htmlentities($_POST['confirm_payer_email']) : ''?>" class="form-control validate[required,equals[payer_email]]" name="confirm_payer_email"  id="confirm_payer_email"   placeholder="Confirm Email">
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px;">Confirm your email</div>
                                          <label><span class="control-label">Confirm Password*</span></label>
                                          <input type="password" value="" class="form-control validate[required,equals[password]]" name="confirm_password"  id="confirm_password"   placeholder="Confirm Password">
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px;">Confirm your password</div>
                                       </div>
                                       <div class="col-md-4">
                                          <label><span class="control-label">State*</span></label>
                                          <input type="text" value="<?=isset($_POST['address_state']) ? htmlentities($_POST['address_state']) : ''?>" class="form-control validate[required]" name="address_state" id="address_state" placeholder="State">
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px;">Your state/county</div>
                                          <label>Country*</label>
                                          <select name="address_country_code" id="address_country_code" class="form-control validate[required]" onchange="$('#address_country').val($('#address_country_code').find('option:selected').text());">
                                           <option value="" selected="selected">Select</option>
                                             <?php
												countries_options();
											 ?>
                                          </select>
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px;">Select your country</div>
                                          <label><span class="control-label">City*</span></label>
                                          <input type="text" value="<?=isset($_POST['address_city']) ? htmlentities($_POST['address_city']) : ''?>" class="form-control validate[required]" name="address_city" id="address_city" placeholder="City">
                                          <div style="color:#999; font-size:10px; line-height: 10px; padding-bottom: 10px;">Your city or town</div>
                                          <div style="margin-top: 25px; text-align: right;">
                                          	 <input type="hidden" name="type" value="register">
                                             <button class="btn btn-success" type="submit" >Register</button>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                              </div>
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