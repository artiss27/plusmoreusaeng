<?php 
/*
Template name: Blank page - no header, no footer
*/
?>
<!DOCTYPE html> 
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<?php
		$favicon = get_theme_mod('favicon') ? get_theme_mod('favicon') : false;
		if($favicon) : ?>
		<link rel="Shortcut icon" href="<?php echo esc_url($favicon) ?>">
	<?php endif; ?>
	
	<?php wp_head(); ?>
	
	<?php 
		$primary_font = get_theme_mod('primary_font') ? get_theme_mod('primary_font') : false;
		if ($primary_font == 'google') {
			$primary_google_font = get_theme_mod('primary_google_font');
			if (!$primary_google_font) $primary_font = false;
		}
	?>
	<?php 
		$secondary_font = get_theme_mod('secondary_font') ? get_theme_mod('secondary_font') : false;
		if ($secondary_font == 'google') {
			$secondary_google_font = get_theme_mod('secondary_google_font');
			if (!$secondary_google_font) $secondary_font = false;
		}
	?>	
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php if($primary_font || $secondary_font) : ?>
		<style type="text/css">
			<?php 
			if ($primary_font):
				if($primary_font == 'google') $primary_font = $primary_google_font;
			?>
				body,
				h1, h2, h3, h4, h5, h6,
				.col,
				ul.tabs li a,
				ul.accordion li>a,
				ul.accordion li>a:before,
				.main .content-slider.big article,
				.hp-quote p,
				.hp-intro p.slogan,
				.cat-archive ul li,
				.single h1,
				.product .price span,
				.events .rss-link a,
				.calendar th,
				.calendar td span.day, .calendar td a.day,
				.content>aside section.menu>ul,
				blockquote.quote p,
				p.progress,
				.box h4,
				.pricing-plan p.subtitle,
				.pricing-plan p.price,
				table.pricing th,
				.e404 p,
				.e404 article form+p,
				a.play {font-family: <?php echo esc_attr($primary_font); ?>;}
			<?php endif; ?>
			<?php 
			if ($secondary_font): 
				if($secondary_font == 'google') $secondary_font = $secondary_google_font;
			?>
				h1, h2, h3, h4, h5, h6,
				nav.mainmenu,
				header p.title,
				ul.tabs li a,
				ul.accordion li>a,
				ul.accordion li>a:before {font-family: <?php echo $secondary_font; ?>;}
			<?php endif; ?>
		</style>
	<?php endif; ?>
	<?php
	$color_scheme = get_theme_mod('color_scheme');
	if($color_scheme == 'custom') {
		$custom_external_stylesheet = get_theme_mod('custom_external_stylesheet');
		if(!$custom_external_stylesheet) { ?>
			<style type="text/css">
				<?php get_template_part('styles/colors/custom');?>
			</style>
		<?php } ?>
	<?php } ?>
	<?php 
	$custom_css = get_theme_mod('custom_css');
	if($custom_css) :
	?>
	<style type="text/css">
		<?php echo converio_sanitize_text_decode($custom_css); ?>
	</style>
	<?php endif; ?>
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri();?>/js/html5.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/styles/style-ie.css" media="screen"></script>
	<![endif]-->
</head>

<?php

//Needed to detect plugin. For use on Front End only.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

$body_classes = array();

$color_scheme = get_theme_mod('color_scheme') ? 'color-' . get_theme_mod('color_scheme') : false;
if($color_scheme) $body_classes[] = $color_scheme;

$boxed = get_theme_mod('layout_type') ? 'boxed' : false;
if($boxed) {
	$body_classes[] = $boxed;

	$pattern = get_theme_mod('layout_bg_pattern');
	if($pattern != 0)  {
		if ($pattern < 10) {
            $pattern = "0" . $pattern;
        }
        $pattern_class = "p".$pattern;
        $body_classes[] = $pattern_class;
	}

	$border = get_theme_mod('layout_border');
	if($border != 0)  {
		if ($border < 10) {
            $border = "0" . $border;
        }
        $border_class = "f".$border;
        $body_classes[] = $border_class;
	}
}

// add class for avatar
if(!get_theme_mod('avatar_shape')) {
	$body_classes[] = 'avatar-circle';
} else if (get_theme_mod('avatar_shape') == 1) {
	$body_classes[] = 'avatar-rounded-square';
} else if (get_theme_mod('avatar_shape') == 2) {
	$body_classes[] = 'avatar-square';
} 

?>

<?php 

function converio_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return $rgb; // returns an array with the rgb values
}

$boxed = get_theme_mod('layout_type') ? 'boxed' : false;
if($boxed) {
	$body_classes[] = $boxed;

	$layout_border_width = get_theme_mod('layout_border_width') ? get_theme_mod('layout_border_width') : 0;
	$layout_border_color = get_theme_mod('layout_border_color') ? get_theme_mod('layout_border_color') : 0;
	$layout_border_opacity = get_theme_mod('layout_border_opacity') ? get_theme_mod('layout_border_opacity') : 0;
	
	$layout_shadow_size = get_theme_mod('layout_shadow_size') ? get_theme_mod('layout_shadow_size') : 0;
	$layout_shadow_color = get_theme_mod('layout_shadow_color') ? get_theme_mod('layout_shadow_color') : 0;
	$layout_shadow_opacity = get_theme_mod('layout_shadow_opacity') ? get_theme_mod('layout_shadow_opacity') : 0;

	/* Customize boxed version */

	$boxed_style_output='';
	
	//boxed version - border styles
	if ($layout_border_width & $layout_border_color & $layout_border_opacity) {
		$layout_border_color_rgb = converio_hex2rgb($layout_border_color);
		$boxed_style_output.= 'body.boxed .root { ';	
		$boxed_style_output.= 'border-width: 0 '. $layout_border_width .'px;';
		$boxed_style_output.= 'border-style: solid;';
		$boxed_style_output.= 'border-color: rgb(' . $layout_border_color_rgb[0] . ', ' . $layout_border_color_rgb[1] . ', ' . $layout_border_color_rgb[2] . ');';
		$boxed_style_output.= 'border-color: rgba(' . $layout_border_color_rgb[0] . ', ' . $layout_border_color_rgb[1] . ', ' . $layout_border_color_rgb[2] . ',  '.$layout_border_opacity.');';
		$boxed_style_output.= '-webkit-background-clip: padding-box;';
		$boxed_style_output.= 'background-clip: padding-box;';
		$boxed_style_output.= ' }';
	
	}

	//boxed version - shadow styles
	if ($layout_shadow_size & $layout_shadow_color & $layout_shadow_opacity) {
		$layout_shadow_color_rgb = converio_hex2rgb($layout_shadow_color);
		
		$boxed_style_output.= 'body.boxed .root { ';
    	$boxed_style_output.= 'box-shadow: 0 0 ' . $layout_shadow_size . 'px rgba(' . $layout_shadow_color_rgb[0] . ', ' . $layout_shadow_color_rgb[1] . ', ' . 		$layout_shadow_color_rgb[2] . ', ' .$layout_shadow_opacity. '); }';
	}
}

if(get_theme_mod('header_type') && (get_theme_mod('header_type') == 11 || get_theme_mod('header_type') == 12)) {
	if(get_theme_mod('header_type') == 11) {
		$body_classes[] = 'boxed-header';
	} else {
		$body_classes[] = 'boxed-header-rounded';
	}
}


?>
<body <?php body_class($body_classes); ?>><div class="root">

	<?php

	if($boxed && $boxed_style_output != '') { 
		echo '<style type="text/css">'.esc_attr($boxed_style_output).'</style>';
	}	
	?>


<?php do_action('multipurpose_sliders');?>

<?php // Revolution Slider
if ( is_plugin_active( 'revslider/revslider.php' ) && !is_search() && !is_404()) { 
	if ( get_post() ) {		
    	$revolution_slider = get_post_meta($post->ID, 'revolution_slider', true);
    	if ($revolution_slider) { ?>
      	    <section class="revolution-slider">  
			  <?php 
			  if(is_front_page() ) {
			      putRevSlider($revolution_slider,"Homepage");
			  } else {
			      putRevSlider($revolution_slider, $id);
			  }
			  ?>
      	   </section>
<?php } 
	}
} //end of Revolution Slider ?>

<?php if(!is_404() && !is_page_template('comming-soon.php') ) {
	if (function_exists('converio_breadcrumb')) {
		converio_breadcrumb();
	}	
} ?>

<?php
// getting the sidebar position for current page type
global $converio_sidebar_pos_global;
$converio_sidebar_pos_global = 0;
if(is_search()) $converio_sidebar_pos_global = get_theme_mod('sidebar_pos_search');
if(is_single()) $converio_sidebar_pos_global = get_theme_mod('sidebar_pos_post');
if(is_page()) $converio_sidebar_pos_global = get_theme_mod('sidebar_pos_page');
if(is_archive()) $converio_sidebar_pos_global = get_theme_mod('sidebar_pos_archive');
if(is_home()) $converio_sidebar_pos_global = get_theme_mod('sidebar_pos_blog');

if(!is_search() && !is_404() && !is_archive()) {
	global $converio_thisPageId;
	$converio_thisPageId = get_the_id();
	$sidebar_position = get_post_meta($converio_thisPageId, 'sidebar_position', true);
	if($sidebar_position == 3) $sidebar_position = $converio_sidebar_pos_global;
} else {
	$sidebar_position = $converio_sidebar_pos_global;
}

global $converio_sidebar_class;
$converio_sidebar_class = '';

switch($sidebar_position) {
	case 1: 
		// sidebar on the left
		$converio_sidebar_class = "reverse";
		break;
	case 2:
		// no sidebar
		$converio_sidebar_class = "wide";
		break;
	default: 
		// sidebar on the right (default)
		$converio_sidebar_class = "";
		break;
}
?>



<section class="content <?php echo esc_attr($converio_sidebar_class); ?>">
<?php 
$hide_title = get_post_meta(get_the_id(), 'hide_title', true);

$sidebar_position = get_post_meta($converio_thisPageId, 'sidebar_position', true);
if($sidebar_position == 3) $sidebar_position = $converio_sidebar_pos_global;

//if sidebar is set to "don't show"
if($sidebar_position == 2) {
	if (have_posts()) : 
		while (have_posts()) : the_post();
			if(!$hide_title) : ?>
				<?php $main_title = get_theme_mod('main_title');
				if($main_title == 1) : ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php else : ?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
				<?php endif; ?>
			<?php endif;
			the_content();
			wp_link_pages(array('before' => '<p class="pages"><strong>'.esc_attr__('Pages', 'converio').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
			comments_template();
		endwhile; 
	endif;
} else {
?>
<section class="main single">
	<?php if (have_posts()) : while (have_posts()) : 
		the_post();
	?>
		<article class="page">
			<?php if(!$hide_title) : ?>
				<?php $main_title = get_theme_mod('main_title');
				if($main_title == 1) : ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php else : ?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
				<?php endif; ?>
			<?php endif; ?>
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p class="pages"><strong>'.esc_attr__('Pages', 'converio').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</article>

		<?php comments_template(); ?>
	<?php endwhile; endif; ?>
</section>
<?php 
if($sidebar_position != 2) {
	$sidebar = get_post_meta(get_the_id(), 'custom_sidebar', true) ? get_post_meta(get_the_id(), 'custom_sidebar', true) : "default";
	if($sidebar != 'no') {
		if($sidebar && $sidebar != "default") get_sidebar("custom");
		else get_sidebar();	
	}
}
?>
<?php } ?>
 </section>
<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/ie.js"></script>
<![endif]-->

<?php wp_footer() ?>
</body>