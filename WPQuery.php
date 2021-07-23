<?php // Custom functions

/* Featured Post Slider */
function cr_featured_posts_slider_shortcode( $atts ) {
	ob_start();
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field'	=> 'slug',
				'terms'	=> 'featured-primary',
			),
		),
	);
	$query = new WP_Query( $args );
	if ($query->have_posts()) : ?>
		<div class="cr-featured-posts-slider-container">
			<div class="row">
				<div class="col">
					<div id="cr-featured-posts-slider" class="cr-featured-post-sliders owl-carousel owl-theme">
						<?php $post_counter = 1;
						while ($query->have_posts()) : $query->the_post(); ?>
						<div class="item cr-featured-post-slider-item">
							<div class="row">
								<div class="col-lg-7 p-0">
									<?php if (get_the_post_thumbnail_url(get_the_ID(),'full')) {
										$post_image = get_the_post_thumbnail_url(get_the_ID(),'full');
									}
									else {
										$post_image ="/wp-content/uploads/2021/07/cr-no-image-placeholder.jpg";
									} ?>
									<div class="cr-featured-post-slider-item-image" style="background-image: url(<?php echo $post_image; ?>);"></div>
								</div>
								<div class="col-lg-5 p-0">
									<div class="cr-featured-post-slider-item-content">
										<h2 class="cr-featured-post-slider-item-title">
											<a href="<?php echo get_the_permalink(); ?>">
												<?php echo get_the_title(); ?>
											</a>
										</h2>
										<div class="cr-featured-post-slider-item-excerpt">
											<?php echo get_the_excerpt(); ?>
										</div>
										<div class="cr-featured-post-slider-item-read-more">
											<a href="<?php echo get_the_permalink(); ?>">
												[ Read more ]
											</a>
										</div>
									</div>
									<div class="cr-featured-post-slider-navigation">
										<div class="cr-featured-post-slider-left">
											<i class="fa fa-chevron-left"></i>
										</div>
										<span class="cr-featured-post-slider-page">
											<?php echo $post_counter.' of '.$query->post_count ?>
										</span>
										<div class="cr-featured-post-slider-right">
											<i class="fa fa-chevron-right"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php $post_counter += 1;
						endwhile;
						wp_reset_postdata();  ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif;
	return ob_get_clean();
}
add_shortcode( 'cr-featured-posts-slider', 'cr_featured_posts_slider_shortcode' );

function cr_posts_shortcode( $atts ) {
	ob_start();
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => 9,
		'paged' =>	$paged,
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field'	=> 'slug',
				'terms'	=> 'featured-primary',
				'operator' => 'NOT IN',
			),
		),
	);
	$query = new WP_Query( $args );
	if ($query->have_posts()) : ?>
		<div class="cr-posts-container">
			<div class="row cr-posts m-0">
				<?php while ($query->have_posts()) : $query->the_post(); ?>
				<div class="col-md-4 cr-post-item">
					<?php if (get_the_post_thumbnail_url(get_the_ID(),'full')) {
						$post_image = get_the_post_thumbnail_url(get_the_ID(),'full');
					}
					else {
						$post_image ="/wp-content/uploads/2021/07/cr-no-image-placeholder.jpg";
					} ?>
					<a href="<?php echo get_the_permalink(); ?>">
						<div class="cr-post-item-image" style="background-image: url(<?php echo $post_image; ?>);">
							<div class="cr-post-item-title">
								<h2>
									<?php echo get_the_title(); ?>
								</h2>
							</div>
						</div>
					</a>
					<div class="cr-post-item-content">
						<div class="cr-post-item-excerpt">
							<?php echo wp_trim_words(get_the_excerpt(), 20); ?>
						</div>
						<div class="cr-post-item-read-more">
							<a href="<?php echo get_the_permalink(); ?>">
								[ Read more ]
							</a>
						</div>
					</div>
				</div>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</div>
			<?php pagination_bar( $query ); ?>	
		</div>
	<?php endif;
	return ob_get_clean();
}
add_shortcode( 'cr-posts', 'cr_posts_shortcode' );

/* This is a function for displaying paginations */
function pagination_bar( $custom_query ) {

	$total_pages = $custom_query->max_num_pages;
	$big = 999999999; // need an unlikely integer

	if ($total_pages > 1) :
		$current_page = max(1, get_query_var('paged')); ?>
		<div class="row">
			<nav class="pagination">
			<?php echo paginate_links(array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => $current_page,
				'total' => $total_pages,
				'prev_text' => '<i aria-hidden="true" class="fa fa-chevron-left"></i>',
				'next_text' => '<i aria-hidden="true" class="fa fa-chevron-right"></i>',
			)); ?>
			</nav>
		</div>
	<?php endif;
}