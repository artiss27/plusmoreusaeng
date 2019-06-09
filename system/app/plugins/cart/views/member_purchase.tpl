{include file='views/members/header.tpl'}
{include file='views/members/menu.tpl'}

<!-- Main Wrapper -->
<div id="wrapper">
<div class="normalheader transition animated fadeIn">
   <div class="hpanel">
      <div class="panel-body">
         <a class="small-header-action" href="">
            <div class="clip-header">
               <i class="fa fa-arrow-up"></i>
            </div>
         </a>  
         <h2 class="font-light m-b-xs">
            Shopping Cart
         </h2>
         <small><font color="green">Carrito de Compras</font></small>
      </div>
   </div>
</div>
<div class="row" id="iframed">
   <div class="normalheader transition animated fadeIn">
      <div class="hpanel">
         <div class="panel-body">
            <a class="small-header-action" href="">
               <div class="clip-header">
                  <i class="fa fa-arrow-up"></i>
               </div>
            </a>
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
            <div class="main pagesize" id="iframed">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                        	<div class="cart-frame" id="cart-frame">
                           		<iframe src="/system/app/plugins/cart/{$smarty.request.page}.php" width="0px" height="0px" class="ifrm" id="iframe1" marginheight="0" frameborder="0" onLoad="autoResize('iframe1');"></iframe>     
                            </div>                      
                        </div>
                     </div>
                     <!-- end of box-wrap -->
                  </div>
                  <!-- end of box-body -->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END -->       
<!-- Vendor scrits -->
{include file='views/members/vendor_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
   $(function () {
   		
   });
</script>

<script language="JavaScript">
<!--
function autoResize(id){
    var newheight;
    var newwidth;
	
	iframed = $('#iframed').width();
	document.getElementById(id).width = (iframed-105) + "px";
    newheight = document.getElementById(id).contentWindow.document.body.scrollHeight;       
    document.getElementById(id).height = (newheight+100) + "px";
	scroll(0,0);
	animatebox();
}
//-->

	function animatebox() {
		var $scrollingDiv = $('#iframe1').contents().find('#cartbox');

	  $(window).scroll(function(){   
		   $scrollingDiv
			.stop()
			.animate({
				"marginTop": ($(window).scrollTop() + 30) + "px"}, "slow" );   
	  });	
	}

</script>
{include file='views/members/footer.tpl'}