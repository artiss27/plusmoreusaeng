<?php
get_header(); 
?>
	<div class="page-portfolio">
		
		<?php
		$options = array('hierarchical' => false);
		$categories = get_terms('project-categories', $options);
		if (count($categories)) :
		?>
		
		<div class="head">
			<div class="filters">
				<ul>
					<?php foreach ($categories as $cat) : ?>
						<li><a href="<?php echo esc_url(get_term_link($cat)) ?>"><?php echo esc_attr($cat->name); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<?php endif; ?>

	<section class="content <?php echo esc_attr($converio_sidebar_class); ?>">
		<section class="columns portfolio masonry animation-enabled">	
		
		<?php  
			$ppp = get_theme_mod('projects_per_page3') ? get_theme_mod('projects_per_page3') : 9;
			$item_col_class = 'col3';
			if ( get_query_var('paged') ) {
			    $paged = get_query_var('paged');
			} else if ( get_query_var('page') ) {
			    $paged = get_query_var('page');
			} else {
			    $paged = 1;
			}
			$cat_name = single_cat_title('',false);
			$args = array(
				'post_type' => 'project',
				'post_status' => 'publish',
				'posts_per_page' => $ppp,
				'paged' => $paged,
				'meta_key' => '_thumbnail_id',
				'project-categories' => $cat_name
			);
			$projects_query = new WP_Query($args);
			if($projects_query->have_posts()) while($projects_query->have_posts()) {
				$projects_query->the_post();

				$cats = wp_get_post_terms($post->ID, 'project-categories', array());
				$category_classes = '';
				foreach($cats as $cat) {
					$category_classes .= " ".$cat->slug;
				}
				?><article class="col <?php echo esc_attr($item_col_class) .' item ' . esc_attr($category_classes); ?>"><div>
					<?php 
					if(has_post_thumbnail()) :
						$th_file = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'project-thumbnail');
					?>
					<div class="img"><a href="<?php the_permalink();?>"><?php the_post_thumbnail('project-thumbnail-masonry'); ?></a>
						<div>
							<ul>
								<?php 
								$project_image_link_hidden = get_post_meta($post->ID, 'project_image_link_hidden', true);
								if (!$project_image_link_hidden) : ?>
								<li><a href="<?php echo esc_url($th_file[0]); ?>" title="<?php the_title(); ?>" class="action view"><?php esc_attr_e('View', 'converio'); ?></a></li>
								<?php endif; ?>
							</ul>
						</div>
					</div><?php endif; ?>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?><br><span>
							<?php 
								$categories = get_the_terms($post->ID, 'project-categories');
								if (is_array($categories)) {
									$num_items = count($categories);
									$i = 0;
									foreach ($categories as $category) {
							  			if(++$i === $num_items) {
											echo esc_attr($category->name);
							  			} else {
											echo esc_attr($category->name).', ';
										}
									}
								}
								else {
									if (is_object ($categories))
										echo esc_attr($categories->name);
								}
							?></span></a></h3>
				</div></article><?php
			}
		?>
		</section>
	<?php if($projects_query->max_num_pages > 1) { ?>
	<div class='wp-pagenavi'>
	<?php 
	global $wp_query;
	$big = 999999999;
	echo paginate_links(array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),  
    	'format' => '/page/%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'prev_text' => __('Previous page', 'converio'),
		'next_text' => __('Next page', 'converio'),
	));
	 ?> 
</div>
	<?php } ?>

	
	</section>
	</div>
<?php get_template_part('call-to-action');?>
<?php get_footer(); ?>