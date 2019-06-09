<?php
/*
* Template name: Contact page - fullwidth map without form
*/
get_header();
?>

 <?php converio_map_fullwidth::get(get_the_id()); ?>

<section class="content <?php echo esc_attr($converio_sidebar_class); ?>">
	<?php 
		$hide_title = get_post_meta(get_the_id(), 'hide_title', true);
	?>
<div class="contact">
			
	<article class="main single contact">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

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

		<?php endwhile; endif; ?>
	</article>
<?php 
$sidebar_position = get_post_meta($converio_thisPageId, 'sidebar_position', true);
if($sidebar_position == 3) $sidebar_position = $converio_sidebar_pos_global;
if($sidebar_position != 2) {
	$sidebar = get_post_meta(get_the_id(), 'custom_sidebar', true) ? get_post_meta(get_the_id(), 'custom_sidebar', true) : "default";
	if($sidebar != 'no') {
		if($sidebar && $sidebar != "default") get_sidebar('custom');
		else {
			echo '<aside>';
			if (function_exists('dynamic_sidebar')) { dynamic_sidebar('contact-sidebar'); }
			echo '</aside>';
		}	
	}
}
?>
</div>
</section>
<?php get_footer(); ?>