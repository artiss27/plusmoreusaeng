<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Page title -->
      <title>{$lang.forgot_password}</title>
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
   </head>
   <body class="blank">
      <div class="color-line"></div>
      <div class="login-container">
         <div class="row">
            <div class="col-md-12">
               <div class="text-center m-b-md">
                  <h3>{$lang.forgot_password}</h3>
              
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
                     <form action="" method="post">
                        <dl>
                           <dt>
                              <label for="username">{$lang.email_address}</label>
                           </dt>
                           <dd><input name="email" type="text" id="email" size="40" class="form-control" /></dd>
                           <dt>&nbsp;</dt>
                        </dl>
                        <p>
                           <button type="submit" name="forgot" value="send" class="btn btn-success btn-block" id="loginbtn">{$lang.send}</button>
                        </p>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12 text-center">
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
      <!-- App scripts -->
      <script src="/assets/common/scripts/homer.js"></script>
   </body>
</html>