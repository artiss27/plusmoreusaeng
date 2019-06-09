<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<?php $main_title = get_theme_mod('main_title');
if($main_title == 1) : ?>
	<h1 itemprop="name" class="product_title"><?php the_title(); ?></h1>
<?php else : ?>
	<h2 itemprop="name" class="product_title"><?php the_title(); ?></h2>
<?php endif; ?>