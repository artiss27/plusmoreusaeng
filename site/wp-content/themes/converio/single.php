<?php global $converio_breadcrumb_header;
$breadcrumb_header_single = get_theme_mod('breadcrumb_header_single');
if (empty($breadcrumb_header_single)) $breadcrumb_header_single = 2;
if($breadcrumb_header_single == 2) {$converio_breadcrumb_header = esc_attr__('Blog', 'converio');}
$hide_title = get_post_meta(get_the_id(), 'hide_title', true);
?>
<?php get_header(); ?>
<section class="content <?php echo esc_attr($converio_sidebar_class); ?>">
<section class="main single" itemscope itemtype="http://schema.org/Article">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php
		$thisPostId = get_the_id();
		$hide_featured_image = get_post_meta($thisPostId, "hide_featured_image", true);
		if (!$hide_featured_image) {
			$hide_featured_image = get_theme_mod("hide_featured_image");
		} else {
			if ($hide_featured_image == 1) {
				$hide_featured_image = false;
			}
		}
		?>
		<article class="post">
			<?php if(!$hide_title) :
				$main_title = get_theme_mod('main_title');
				if($main_title == 1) : ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php else : ?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
				<?php endif; ?>
			<?php endif;?>
			<p class="post-meta" itemprop="datePublished" content="<?php the_time('Y-m-d') ?>"><?php the_time(get_option( 'date_format')) ?><span>/</span> <?php esc_attr__('by', 'converio') ?> <span itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name"><?php the_author(); ?></span></span> <span>/</span> <?php the_category(", "); ?><?php if ( comments_open() ) : ?> <span>/</span> <?php comments_popup_link('0 comments', '1 comment', '% comments', ''); ?><?php endif; ?></p>
			<?php 			
			$video_iframe = get_post_meta(get_the_id(), 'single_meta_video_iframe', true);
			$audio_iframe = get_post_meta(get_the_id(), 'single_meta_audio_iframe', true);
			$quote_content = get_post_meta(get_the_id(), 'single_meta_quote_content', true);
			$quote_author = get_post_meta(get_the_id(), 'single_meta_quote_author', true);
			
			if( has_post_thumbnail() && ( converio_ext_get_featured_image_id( 'featured-image-2', get_post_type() ) || converio_ext_get_featured_image_id('featured-image-3', get_post_type() ) ) ) {
?>
		  	  <section class="slider3">
		          <div class="slider">
					  	<article><?php the_post_thumbnail('post-thumbnail');?></article>		  
						<?php if (converio_ext_get_featured_image_id('featured-image-2', get_post_type())) { ?>
						<article><?php converio_ext_the_featured_image('featured-image-2', get_post_type(), 'post-thumbnail')?></article>
						<?php } ?>
						<?php if (converio_ext_get_featured_image_id('featured-image-3', get_post_type())) { ?>
						<article><?php converio_ext_the_featured_image('featured-image-3', get_post_type(), 'post-thumbnail')?></article>
						<?php } ?>
		          </div>
		      </section>
			  
			<?php
			}
			elseif($video_iframe) { 
				echo '<div class="video post-mb10">'.converio_sanitize_text_decode($video_iframe).'</div>';
			}
			elseif($audio_iframe) {
				echo '<div class="add-music">'.converio_sanitize_text_decode($audio_iframe).'</div>';
			}
			elseif($quote_content) {
				echo '<blockquote class="quote-typography">';
				echo '<p>'.esc_attr($quote_content).'</p>';
				echo '<small>&mdash; '.esc_attr($quote_author).'</small>';
				echo '</blockquote>';
			}
			elseif(has_post_thumbnail() && !$hide_featured_image) { ?>
				<p><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('post-thumbnail'); ?></a></p>
			<?php } ?>
			
			<?php the_content(); ?>
			
			<?php if(has_tag()): ?><p class="tags"><span><?php esc_attr_e('Tags', 'converio'); ?></span> <?php the_tags("", ""); ?></p><?php endif; ?>
			
			<?php wp_link_pages(array('before' => '<p class="pages"><strong>'.esc_attr__('Pages', 'converio').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</article>

		<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' );?>
		<?php if ( is_plugin_active( 'share-this/sharethis.php' ) ) { ?>
		<div class="share-post">
			<p class="share-social">
				<?php get_template_part('share-this');?>
			</p>
		</div>
		<?php } else {
			$share_links = get_theme_mod('share_links');
			if (empty($share_links)) $share_links = 2;
			if($share_links == 2) : 
				get_template_part('share');
			endif;
		} ?>
		<?php
		$show_author = get_theme_mod('show_post_author');
		if(!$show_author):
		?>
		<section class="post-author clearfix">
			<?php echo get_avatar(get_the_author_meta( 'ID' ), 90) ?>
			<div>
				<h3><?php esc_attr_e('Author', 'converio')?>: <?php the_author_link(); ?></h3>
				<p><?php echo get_the_author_meta( 'description' ); ?></p>
			</div>
			<?php if(get_the_author_meta('facebook') != '' | get_the_author_meta('twitter') != '' | get_the_author_meta('googleplus') != '' | get_the_author_meta('instagram') != '' | get_the_author_meta('rss') != '') { ?>
				<div class="social01">
					<?php if(get_the_author_posts() > 1 ) { ?>
						<p class="articles"><?php esc_attr_e('More articles', 'converio')?> <?php esc_attr_e('by', 'converio')?> <?php the_author_posts_link(); ?></p>
					<?php } ?>
					<p><?php esc_attr_e('Follow', 'converio')?> <?php the_author(); ?> <?php esc_attr_e('on', 'converio')?></p>
					<ul class="social">
						<?php if(get_the_author_meta('facebook') != '') { ?><li><a class="facebook" href="<?php the_author_meta('facebook') ?>"><?php esc_attr_e('Facebook','converio');?></a></li><?php } ?>
						<?php if(get_the_author_meta('twitter') != '') { ?><li><a class="twitter" href="<?php the_author_meta('twitter') ?>"><?php esc_attr_e('Twitter','converio');?></a></li><?php } ?>
						<?php if(get_the_author_meta('googleplus') != '') { ?><li><a class="googleplus" rel="publisher" href="<?php the_author_meta('googleplus') ?>"><?php esc_attr_e('Google+','converio');?></a></li><?php } ?>
						<?php if(get_the_author_meta('instagram') != '') { ?><li><a class="instagram" href="<?php the_author_meta('instagram') ?>"><?php esc_attr_e('Instagram','converio');?></a></li><?php } ?>
						<?php if(get_the_author_meta('rss') != '') { ?><li><a class="rss" href="<?php the_author_meta('rss') ?>"><?php esc_attr_e('RSS','converio');?></a></li><?php } ?>
					</ul>
				</div>
			<?php } ?>	
		</section>
		<?php endif; ?>
		<?php 
		$show_related = get_theme_mod('show_related');
		if(!$show_related) related_posts($post); 
		
		comments_template(); 
		?>
	<?php endwhile; endif; ?>	
	<meta itemprop="dateModified" content="<?php the_modified_time('c'); ?>">
	<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink();?>"/>
	<meta itemprop="headline" content="<?php the_title(); ?>">
	
	<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
	<span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
	<meta itemprop="url" content="<?php echo esc_url(get_theme_mod( 'logo_upload' ));?>">
	</span>
	<meta itemprop="name" content="<?php bloginfo('name'); ?>">
	</span>
	<?php
	$thumbnail_id = get_post_thumbnail_id( $post->ID );
	$img = wp_get_attachment_image_src( $thumbnail_id, 'post-thumbnail' );
	$src = $img[0];
	$width = $img[1];
	$height = $img[2];
	?>
	<span itemprop="image" itemscope itemtype="https://schema.org/ImageObject">	
	<meta itemprop="url" content="<?php echo $src;?>">
	<meta itemprop="width" content="<?php echo $width;?>">
	<meta itemprop="height" content="<?php echo $height;?>">
	</span>
</section>
<?php 
$sidebar_position = get_post_meta($converio_thisPageId, 'sidebar_position', true);
if($sidebar_position == 3) $sidebar_position = $converio_sidebar_pos_global;
if($sidebar_position != 2) {
	$sidebar = get_post_meta(get_the_id(), 'custom_sidebar', true) ? get_post_meta(get_the_id(), 'custom_sidebar', true) : "default";
	if($sidebar != 'no') {
		if($sidebar && $sidebar != "default") get_sidebar("custom");
		else get_sidebar();	
	}
}
?>
</section>
<?php get_template_part('call-to-action');?>
<?php get_footer(); ?>
