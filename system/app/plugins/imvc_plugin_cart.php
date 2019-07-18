<?php

namespace cart;

setTable();
$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_filter('main_admin', '\cart\setActionExtraAdminMenus');
$hooks->add_filter('extra_member_menus', '\cart\setActionExtraMemberMenus');
$hooks->add_filter('extra_dashboard_head', '\cart\setActionExtraDashboardHead');
$hooks->add_action('head_nav', '\cart\setActionPendingCart');


function setActionPendingCart()
{
	if(isset($_SESSION['my_shop']) && count($_SESSION['my_shop']) > 0) {
		//echo '<a id="cart_notification" href="/plugins/cart/cartmember/purchase/&page=shoppingcart_view_inside" class="btn btn-success blink" style="margin-top:10px;">Have Products On Cart<font color="green">/Hay Servicios en el Carrito</font></a>';	
	}
	else {
		//echo '<a id="cart_notification" href="/plugins/cart/cartmember/purchase/&page=shoppingcart_main_inside" class="btn btn-success" style="margin-top:10px;">Purchase Services<font color="green">/Comprar Servicios</font></a>';		
	}
}

function setActionExtraAdminMenus()
{
	$class1 = ($_SESSION['menu']['main'] == "store") ? ' class="active"' : '';
	$class2 = ($_SESSION['menu']['sub'] == "settings") ? ' class="active"' : '';
	$class3 = ($_SESSION['menu']['sub'] == "categories") ? ' class="active"' : '';
	$class4 = ($_SESSION['menu']['sub'] == "catalog") ? ' class="active"' : '';
	$class5 = ($_SESSION['menu']['sub'] == "orders") ? ' class="active"' : '';
	$class6 = ($_SESSION['menu']['sub'] == "customers") ? ' class="active"' : '';
	$class7 = ($_SESSION['menu']['sub'] == "coupons") ? ' class="active"' : '';
	echo '<li'.$class1.'>
                <a href="#"><span class="nav-label">Store</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li'.$class2.'><a href="/plugins/cart/cartadmin/settings">Settings</a></li>
					<li'.$class3.'><a href="/plugins/cart/cartadmin/page/&page=bsc_categorylist">Categories</a></li>
					<li'.$class4.'><a href="/plugins/cart/cartadmin/page/&page=bsc_productslist">Products</a></li>
					<li'.$class5.'><a href="/plugins/cart/cartadmin/page/&page=bsc_order_headerlist">Orders</a></li>
					<li'.$class6.'><a href="/plugins/cart/cartadmin/page/&page=bsc_customerslist">Customers</a></li>
					<li'.$class7.'><a href="/plugins/cart/cartadmin/page/&page=bsc_couponslist">Coupons</a></li>
                </ul>
            </li>';
	
}

function setActionExtraMemberMenus()
{
	$class1 = ($_SESSION['menu']['main'] == "store") ? ' class="active"' : '';
	$class2 = ($_SESSION['menu']['sub'] == "customers") ? ' class="active"' : '';
	$class3 = ($_SESSION['menu']['sub'] == "sales") ? ' class="active"' : '';
	$class4 = ($_SESSION['menu']['sub'] == "commissions") ? ' class="active"' : '';
	$class5 = ($_SESSION['menu']['sub'] == "purchase") ? ' class="active"' : '';
	$cart_type = \tmvc::instance()->controller->core->GetSiteSetting('settings_cart_type');
	$inside = '';
	if($cart_type == 'inside' || $cart_type == 'both') {
		//$inside = '<li'.$class5.'><a href="/plugins/cart/cartmember/purchase/&page=shoppingcart_main_inside">Order Here<br><font color="green">Ordenar Aqui</font></a></li><li'.$class5.'><a href="/plugins/cart/cartmember/purchase/&page=orders_inside">Your Orders<br><font color="green">Tus Ordenes</font></a></li>';	

		$inside = '
					<li'.$class5.'><a href="/plugins/cart/cartmember/purchase/&page=orders_inside">Your Orders<br><font color="green">Tus Ordenes</font></a></li>';	
	}
	echo '<li'.$class1.'>
                <a href="#"><span class="nav-label">Ordenes<br><font color="green" size="1">Orders</font></span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
					<!--<li'.$class3.'><a href="/plugins/cart/cartmember/storesales">Sales</a></li>
					<li'.$class2.'><a href="/plugins/cart/cartmember/customers">Customers</a></li>
					<li'.$class4.'><a href="/plugins/cart/cartmember/storecommissions">Commissions</a></li>--!>
					'.$inside.'

                </ul>
            </li>';
	
}

function setActionExtraDashboardHead()
{
    return; // disable
	$cart_type = \tmvc::instance()->controller->core->GetSiteSetting('settings_cart_type');
	if($cart_type == 'replicated' || $cart_type == 'both') {
		echo '<div class="row" >
			 <div class="col-lg-12">
				<div class="hpanel">
				   <div class="panel-body">
					  <div class="text-muted">
						 <div class="form-inline">
							<strong>Your Store URL:</strong> <input type="text" class="form-control" value="'.$_SESSION['local_url'].'store/'.$_SESSION['username'].'" style="width:80%">
						 </div>
					  </div>
				   </div>
				</div>
			 </div>
		  </div>';
	}
}

function setTable()
{
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);	
		$db    = \tmvc::instance()->controller->load->database();
		$check = $db->query("SHOW TABLES LIKE 'bsc_category'");
		if ($db->count() === 0) {
			$db->query("
			CREATE TABLE IF NOT EXISTS `bsc_category` (
			`id` int(11) NOT NULL,
			  `name` varchar(255) DEFAULT NULL,
			  `description` text,
			  `ordering` int(11) DEFAULT NULL,
			  `visible` int(1) DEFAULT NULL
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
			");
			
			$db->query("
			CREATE TABLE IF NOT EXISTS `bsc_coupons` (
			`id` int(11) NOT NULL,
			  `code` varchar(255) DEFAULT NULL,
			  `text_promotion` varchar(255) DEFAULT NULL,
			  `discount` decimal(11,2) DEFAULT NULL,
			  `visible` int(1) DEFAULT NULL
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
					");	
					
			$db->query("
			CREATE TABLE IF NOT EXISTS `bsc_customers` (
			`id` int(11) NOT NULL,
			  `datelastorder` datetime DEFAULT NULL,
			  `dateregister` datetime DEFAULT NULL,
			  `payer_email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `password` varchar(128) NOT NULL,
			  `reset_hash` varchar(128) NOT NULL,
			  `first_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `last_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `address_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `address_country` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `address_country_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `address_zip` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `address_state` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `address_city` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `address_street` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			  `store_owner` varchar(100) NOT NULL
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
			");
			
			$db->query("
			CREATE TABLE IF NOT EXISTS `bsc_order_detail` (
			`id` int(11) NOT NULL,
			  `dateorder` timestamp NULL DEFAULT NULL,
			  `item_name` varchar(255) DEFAULT NULL,
			  `item_number` varchar(255) DEFAULT NULL,
			  `quantity` int(11) DEFAULT NULL,
			  `item_price` decimal(12,2) DEFAULT NULL,
			  `shipping_price` decimal(12,2) DEFAULT NULL,
			  `tax_amount` decimal(12,2) DEFAULT NULL,
			  `mc_gross` decimal(12,2) DEFAULT NULL,
			  `payment_status` varchar(255) DEFAULT NULL,
			  `payment_amount` varchar(255) DEFAULT NULL,
			  `payment_currency` varchar(255) DEFAULT NULL,
			  `payer_email` varchar(255) DEFAULT NULL,
			  `payment_type` varchar(255) DEFAULT NULL,
			  `custom` varchar(255) DEFAULT NULL,
			  `invoice` varchar(255) DEFAULT NULL,
			  `first_name` varchar(255) DEFAULT NULL,
			  `last_name` varchar(255) DEFAULT NULL,
			  `address_name` varchar(255) DEFAULT NULL,
			  `address_country` varchar(255) DEFAULT NULL,
			  `address_country_code` varchar(255) DEFAULT NULL,
			  `address_zip` varchar(255) DEFAULT NULL,
			  `address_state` varchar(255) DEFAULT NULL,
			  `address_city` varchar(255) DEFAULT NULL,
			  `address_street` varchar(255) DEFAULT NULL
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
					");	
					
			$db->query("
			CREATE TABLE IF NOT EXISTS `bsc_order_header` (
			`id` int(11) NOT NULL,
			  `dateorder` timestamp NULL DEFAULT NULL,
			  `payment_status` varchar(255) DEFAULT NULL,
			  `shipping_status` varchar(100) NOT NULL DEFAULT 'Processing',
			  `payment_amount` varchar(255) DEFAULT NULL,
			  `payment_currency` varchar(255) DEFAULT NULL,
			  `payer_email` varchar(255) DEFAULT NULL,
			  `payment_type` varchar(255) DEFAULT NULL,
			  `custom` varchar(255) DEFAULT NULL,
			  `invoice` varchar(255) DEFAULT NULL,
			  `first_name` varchar(255) DEFAULT NULL,
			  `last_name` varchar(255) DEFAULT NULL,
			  `address_name` varchar(255) DEFAULT NULL,
			  `address_country` varchar(255) DEFAULT NULL,
			  `address_country_code` varchar(255) DEFAULT NULL,
			  `address_zip` varchar(255) DEFAULT NULL,
			  `address_state` varchar(255) DEFAULT NULL,
			  `address_city` varchar(255) DEFAULT NULL,
			  `address_street` varchar(255) DEFAULT NULL
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
					");		
					
			$db->query("
			CREATE TABLE IF NOT EXISTS `bsc_products` (
			`id` int(11) NOT NULL,
			  `idCategory` int(11) DEFAULT NULL,
			  `productCode` varchar(20) DEFAULT NULL COMMENT 'Sku, code ?',
			  `img` varchar(255) DEFAULT NULL COMMENT 'Main image',
			  `img_detail1` varchar(255) DEFAULT NULL COMMENT 'Detail image',
			  `img_detail2` varchar(255) DEFAULT NULL COMMENT 'Detail image',
			  `img_detail3` varchar(255) DEFAULT NULL COMMENT 'Detail image',
			  `name` varchar(255) DEFAULT NULL COMMENT 'Name of product',
			  `description` text COMMENT 'Description',
			  `shipping` text COMMENT 'Shipping',
			  `price` decimal(9,2) DEFAULT '0.00',
			  `price_offer` decimal(9,2) DEFAULT '0.00',
			  `download` varchar(255) DEFAULT NULL COMMENT 'any file for download?',
			  `ordering` int(11) DEFAULT NULL COMMENT 'order ?',
			  `visible` int(11) DEFAULT NULL COMMENT 'The product its hidden or display? '
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
					");				
			
			$db->query("
			CREATE TABLE IF NOT EXISTS `bsc_types` (
			`id` int(11) NOT NULL,
			  `idProduct` int(11) DEFAULT NULL,
			  `name` varchar(255) DEFAULT NULL,
			  `price` decimal(9,2) DEFAULT NULL,
			  `price_offer` decimal(9,2) DEFAULT NULL,
			  `ordering` int(11) DEFAULT NULL
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
					");	
					
					
			$db->query("
			CREATE TABLE IF NOT EXISTS `bsc_sizes` (
			`id` int(11) NOT NULL,
			  `idProduct` int(11) DEFAULT NULL,
			  `name` varchar(255) DEFAULT NULL,
			  `ordering` int(11) DEFAULT NULL
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
					");			
					
			$db->query("
			ALTER TABLE `bsc_category`
			 ADD PRIMARY KEY (`id`);
			 ");	
			$db->query(" 
			ALTER TABLE `bsc_coupons`
			 ADD PRIMARY KEY (`id`);
			 ");	
			 $db->query("
			ALTER TABLE `bsc_customers`
			 ADD PRIMARY KEY (`id`);
			 ");	
			 $db->query("
			ALTER TABLE `bsc_order_detail`
			 ADD PRIMARY KEY (`id`);
			 ");	
			 $db->query("
			ALTER TABLE `bsc_order_header`
			 ADD PRIMARY KEY (`id`);
			 ");	
			 $db->query("
			ALTER TABLE `bsc_products`
			 ADD PRIMARY KEY (`id`);
			 ");	
			 $db->query("
			ALTER TABLE `bsc_sizes`
			 ADD PRIMARY KEY (`id`);
			 ");	
			 $db->query("
			ALTER TABLE `bsc_types`
			 ADD PRIMARY KEY (`id`);
			 ");	
			 $db->query("
			ALTER TABLE `bsc_category`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");	
			$db->query("
			ALTER TABLE `bsc_coupons`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");	
			$db->query("
			ALTER TABLE `bsc_customers`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");	
			$db->query("
			ALTER TABLE `bsc_order_detail`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");	
			$db->query("
			ALTER TABLE `bsc_order_header`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");	
			$db->query("
			ALTER TABLE `bsc_products`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");	
			$db->query("
			ALTER TABLE `bsc_sizes`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");	
			$db->query("
			ALTER TABLE `bsc_types`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
			");						
		}
	}	
}

?>