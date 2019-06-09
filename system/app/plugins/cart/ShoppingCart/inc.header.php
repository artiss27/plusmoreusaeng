<style>
.logo {
    float: left;
    line-height: 40px;
    margin: 0 0 0 60px;
}

</style>

<header class="header-two-bars">
	<div class="header-first-bar">
		<div class="header-limiter">
			<div class="logo"><a href="/store/<?=$_SESSION['enroller']?>/"><img width="120" height="40" src="<?=file_exists(__DIR__ . '/../../../../../media/images/store-logo.png') ? '/media/images/store-logo.png' : '/system/app/plugins/cart/images/store-logo.png'?>" /></a></div>
			<nav>
				<a href="/store/<?=$_SESSION['enroller']?>/" <?=!isset($menu) ? 'class="selected"' : ''?>>Home</a>
				<a href="/store/<?=$_SESSION['enroller']?>/cart/" <?=isset($menu) && $menu == 'cart' ? 'class="selected"' : ''?>>Cart</a>
				<a href="/store/<?=$_SESSION['enroller']?>/checkout/" <?=isset($menu) && $menu == 'checkout' ? 'class="selected"' : ''?>>Checkout</a>
			</nav>
			<?php if(isset($_SESSION['customer']) && isset($_SESSION['customer_data'])): ?>
            <a href="/store/<?=$_SESSION['enroller']?>/logout" class="logout-button">Logout</a>
            
            <?php 
			else:
			?>
            <!-- <a href="/store/<?=$_SESSION['enroller']?>/register" class="logout-button">Signup</a>
            <a href="/store/<?=$_SESSION['enroller']?>/login" class="logout-button">Login</a> -->
            
            <a href="/signup" class="logout-button">Signup</a>
            <a href="/members" class="logout-button">Login</a>
			<?php
			endif;?>
            
		</div>

	</div>
	<?php if(isset($_SESSION['customer']) && isset($_SESSION['customer_data'])): ?>
	<div class="header-second-bar">
		<div class="header-limiter">
			<h2><a href="#">Welcome <?=$_SESSION['customer_data']['first_name']?> <?=$_SESSION['customer_data']['last_name']?> (<?=$_SESSION['customer']?>)</a></h2>
			<nav>
				<!-- <a href="#"><i class="fa fa-comments-o"></i> Questions</a>-->
				<a href="/store/<?=$_SESSION['enroller']?>/orders"><i class="fa fa-file-text"></i> Orders</a>
				<!--<a href="#"><i class="fa fa-group"></i> Participants</a>-->
				<!--<a href="/store/<?=$_SESSION['enroller']?>/profile"><i class="fa fa-cogs"></i> Profile</a>-->
			</nav>
		</div>
	</div>
   <?php endif; ?> 
</header>