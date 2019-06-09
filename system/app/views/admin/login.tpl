<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Admin Login</title>

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
		  overflow: hidden;
		  background: url("/assets/common/images/1.jpg") no-repeat top center #2d494d;
		}
		h1, h3, small {
				color: white;
		}
	</style>
</head>
<body class="blank">

<div class="color-line"></div>

<div class="login-container">

	<!-- begin canvas animation bg -->
        <div id="canvas-wrapper">
			<canvas id="demo-canvas"></canvas>
        </div>

    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
				<img src="/media/images/PMUhighlighted.png" alt="PlusMoreUsa" style="width:200px;height:150px;"><br><br>
                
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
                            <div class="form-group"><center><font size="4" color="#6a6c6f">Acceso Para Admin</font><br>
              <font size="2" color="#6a6c6f">Area Privada</font></center><br>
                                <label class="control-label" for="username">Usuario</label>
                                <input type="text" title="Please enter you username" required value="{if $smarty.const.DEMO == 1}admin{/if}" name="user" id="user" class="form-control">
                                <span class="help-block small">Tu Usuario de Administrador</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Contrase&ntildea</label>
                                <input type="password" title="Please enter your password" required value="{if $smarty.const.DEMO == 1}admin{/if}" name="password" id="password" class="form-control">
                                <span class="help-block small">Tu contrase&ntildea dificil</span>
                            </div>                            
                            <button class="btn btn-success btn-block">Acceder</button>
                        </form>
						{if $smarty.const.DEMO == 1}Demo is reseted every 20 minutes{/if}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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