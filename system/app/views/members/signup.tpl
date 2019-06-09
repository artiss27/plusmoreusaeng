<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>{$lang.registration}</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="/assets/common/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="/assets/common/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="/assets/common/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="/assets/common/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="/assets/common/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="/assets/common/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="/assets/common/styles/style.css">
	<style>
		body #canvas-wrapper {
		  position: fixed;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  width: 100%;
		  height: 100%;
		}
		body {
		  /*overflow: hidden;*/
		  background: url("/assets/common/images/1.jpg") no-repeat top center #2d494d;
		}
		h1, h3, small {
				color: white;
		}
		.login-container {
			max-width: 700px;
			margin: auto;
			padding-top: 6%;
		}
	</style>

</head>
<body class="blank">

<div class="color-line"></div>
<!-- begin canvas animation bg -->
        <div id="canvas-wrapper">
			<canvas id="demo-canvas"></canvas>
        </div>
<div class="login-container">
	
    <div class="row">
        <div class="col-md-12"><a href="/members" class="btn btn-primary"><font size="4">Accede Tu Cuenta</font><br>Access Your Account</a><br>
            <div class="text-center m-b-md">
				
				<br><br>
<img src="/media/images/PMUhighlighted.png" alt="PlusMoreUsa" style="width:135px;height:90px;">                

            </div>
            <div class="hpanel">
                <div class="panel-body">
                {if $smarty.session.message}
               <p class="alert alert-success">
                  {assign var=message_var value=CoreHelp::flash('message')}
                  {$message_var}
               </p>
               <br />
               {/if} 
               {if $smarty.session.error}
               {assign var=message_var value=CoreHelp::flash('error')}            	
               {if $message_var|is_array}
               {foreach $message_var as $error}
               <p class="alert alert-danger">
                  {$error}
               </p>
               <br />
               {/foreach} 
               {else}
               <p class="alert alert-danger">
                  {$message_var}
               </p>
               <br />
               {/if}
               {/if} 
               {if $errors}
                  {foreach $errors as $error}
                  <p class="alert alert-danger">
                     {$error}
                  </p>
                  {/foreach}
               {/if}
                        <form action="" method="post"> 

 <div class="form-group"> <center><font size="6" color="#6a6c6f">Formulario de Registracion</font><br><font size="5" color="#6a6c6f">Sign Up Form</font><br><br><input type="checkbox" name="agree" required value="1" class="form-control">
                                <label class="control-label"><font size="3">Por favor marcar le cuadro para aceptar los<a class="link_left" href="/site/membresia-terminos/" target="_blank"> Terminos De La Membresia.*</a></font><br><font size="2">Please click the box to accept the <a class="link_left" href="/site/terms/" target="_blank"> Membership Terms.*</a></font></label> </center><br>          
                                                    
                            </div>


                            <div class="form-group">
                                <label class="control-label" for="username"><font size="3">Invited By*</font><br><font size="2">Invitado Por*</font></label>
                                <input type="text" placeholder="{$lang.your_sponsor_username}" {if $hooks->apply_filters('get_setting', 'signup_sponsor_required') == 'yes'}required{/if} value="{if isset($smarty.session.signup.sponsor)}{$smarty.session.signup.sponsor}{else}{$smarty.session.enroller}{/if}" name="sponsor" class="form-control" >                                
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">First Name*</font><br>Primer Nombre*</label>
                                <input type="text" placeholder="" required name="firstName" id="firstname" value="{$smarty.session.signup.firstName}" class="form-control" />                       
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">Last Name*</font><br>Apellido*</label>
                                <input type="text" placeholder="" required name="lastName" id="lastname" value="{$smarty.session.signup.lastName}" class="form-control" />                       
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">Gender*</font><br>G&eacutenero*</label>
                                 <select name="gender" id="gender" class="form-control">
                                 <option value="0">Select One / Escoge Uno</option>
                                 <option value="1" {if $smarty.session.signup.gender == 1}selected="selected"{/if}>Male/Masculino</option>
                                 <option value="2" {if $smarty.session.signup.gender == 2}selected="selected"{/if}>Female/Femenino</option>
                              </select>                       
                            </div>
                            
                    <!--  <div class="form-group">
                                <label class="control-label">{$lang.skype}</label>
                                <input type="text" placeholder="{$lang.skype}" name="skype" id="skype" value="{$smarty.session.signup.skype}" class="form-control" />                     
                            </div>-->
                            <div class="form-group">
                                <label class="control-label"><font size="3">Cellphone Number*<br><font size="2">No. De Mobil*</font></label>
                            <input type="text" placeholder="" name="phone" id="phone" value="{$smarty.session.signup.phone}" class="form-control" />                       
                            </div>
                            <div class="form-group">
                                <label class="control-label"><font size="3">Email*<br><font size="2">Correo Electronico*</font></label>
                                <input type="text" placeholder="" required name="email" id="email" value="{$smarty.session.signup.email}" class="form-control" />                         
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">Create Member ID*<br><font size="2">Crear ID de Miembro</font></label>
                                <input type="text" placeholder="" required name="username" id="username" value="{$smarty.session.signup.username}" class="form-control" />                         
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">Create Password*<br><font size="2">Crear Contrase&ntilde;a*</font></label>
                                <input type="password" placeholder="" required name="password" id="password" value="" class="form-control" />                         
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label"><font size="3">Confirm Password*<br><font size="2">Confirmar Contrase&ntilde;a*</font></label>
                                <input type="password" placeholder="" required name="password2" id="password2" value="" class="form-control" />                         
                            </div>
                            
                  <!--<label class="control-label"><font size="3"> Select your membership*</font><br>Selecciona tu membresia*</label>
                            	<div class="form-group">
                              <label for="username">{$lang.membership}: </label> 
                                    <select name="membership" id="select" class="form-control">
                                    {foreach key=obj item=name from=$memberships}            
                                        {capture assign=comm}{$name}_signup_fee{/capture}    
                                       						
                                        	<option value="{$name}">            
                                        		{$name|replace:"_":" "} (${$settings.$comm|string_format:"%.2f"})          
                                        	</option>
                                      
                                    {/foreach}
                                    </select>
                                
                                </div>-->
                        
                            
                           
                            
                            <button class="btn btn-success btn-block"><font size="3">Sign Up<br><font size="2">Registrate</font></button>
                        </form><p> <center><font size="3">Please check your email for account confimation.<br><font size="2">Entra a tu correo electronico para verificar tu cuenta. </font></center>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center"><br><br><br><br><br><br><br><br><br>
        </div>
    </div>
</div>


<!-- Vendor scripts -->
<script src="/assets/common/vendor/jquery/dist/jquery.min.js"></script>
<script src="/assets/common/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/common/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/assets/common/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets/common/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="/assets/common/vendor/iCheck/icheck.min.js"></script>
<script src="/assets/common/vendor/sparkline/index.js"></script>
<script type="text/javascript" src="/assets/common/vendor/login/EasePack.min.js"></script>
<script type="text/javascript" src="/assets/common/vendor/login/rAF.js"></script>
<script type="text/javascript" src="/assets/common/vendor/login/TweenLite.min.js"></script>
<script type="text/javascript" src="/assets/common/vendor/login/login.js"></script>

<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>

<!-- Page Javascript -->
    <script type="text/javascript">
        jQuery(document).ready(function() {

            // Init CanvasBG and pass target starting location
            CanvasBG.init({
                Loc: {
                    x: window.innerWidth / 2,
                    y: window.innerHeight / 3.3
                },
            });


        });
    </script>

</body>
</html>