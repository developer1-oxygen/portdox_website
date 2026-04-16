<?php
/**
 * Shared blog card grid markup (home “Latest News”, blog archive, etc.).
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Echo `blog-one__single` columns from a WP_Query (same structure as template-blog.php).
 *
 * @param WP_Query $query        Query with posts to show.
 * @param string   $assets_uri   Theme root URI (e.g. get_template_directory_uri()).
 * @param array    $args {
 *     Optional. @type bool   $alternate_animation Use fadeInUp / fadeInDown alternating (home style).
 *     @type float $start_delay Initial wow data-wow-delay in seconds.
 *     @type float $delay_step  Added per card.
 * }
 */
function portdox_render_blog_one_cards( WP_Query $query, $assets_uri, array $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'alternate_animation' => false,
			'start_delay'         => 0.3,
			'delay_step'          => 0.1,
		)
	);

	if ( ! $query->have_posts() ) {
		?>
		<div class="col-12">
			<p class="text-center py-5"><?php esc_html_e( 'No posts found.', 'portdox_theme' ); ?></p>
		</div>
		<?php
		return;
	}

	$i = 0;
	while ( $query->have_posts() ) {
		$query->the_post();
		$thumb = get_the_post_thumbnail_url( get_the_ID(), 'large' );
		if ( ! $thumb ) {
			$thumb = trailingslashit( $assets_uri ) . 'assets/images/blog/blog-v1-img1.jpg';
		}
		$excerpt = get_the_excerpt();
		if ( '' === trim( wp_strip_all_tags( $excerpt ) ) ) {
			$excerpt = wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) ), 22, '…' );
		}

		$delay = $args['start_delay'] + ( $i * $args['delay_step'] );
		if ( ! empty( $args['alternate_animation'] ) ) {
			$wow = ( 0 === $i % 2 ) ? 'fadeInUp' : 'fadeInDown';
		} else {
			$wow = 'fadeInUp';
		}
		?>
					<div class="col-xl-4 col-lg-6 wow <?php echo esc_attr( $wow ); ?>" data-wow-delay="<?php echo esc_attr( (string) $delay ); ?>s">
						<div class="blog-one__single">
							<div class="blog-one__single-img">
								<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
							</div>
							<div class="blog-one__single-content">
								<div class="date-box">
									<h2><?php echo esc_html( get_the_date( 'd' ) ); ?></h2>
									<p><?php echo esc_html( get_the_date( 'M' ) ); ?></p>
								</div>
								<div class="blog-one__single-content-inner">
									<ul class="meta-box">
										<li>
											<div class="icon">
												<span class="icon-user"></span>
											</div>
											<div class="text-box">
												<p><?php the_author_posts_link(); ?></p>
											</div>
										</li>
										<li>
											<div class="icon">
												<span class="icon-chat"></span>
											</div>
											<div class="text-box">
												<p>
													<a href="<?php echo esc_url( get_comments_link() ); ?>">
														<?php
														printf(
															/* translators: %s: comment count */
															esc_html( _n( '%s Comment', '%s Comments', (int) get_comments_number(), 'portdox_theme' ) ),
															esc_html( number_format_i18n( get_comments_number() ) )
														);
														?>
													</a>
												</p>
											</div>
										</li>
									</ul>
									<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<p><?php echo esc_html( wp_strip_all_tags( $excerpt ) ); ?></p>
									<div class="btn-box">
										<a class="thm-btn" href="<?php the_permalink(); ?>">
											<?php esc_html_e( 'Read More', 'portdox_theme' ); ?>
											<i class="icon-right-arrow21"></i>
											<span class="hover-btn hover-bx"></span>
											<span class="hover-btn hover-bx2"></span>
											<span class="hover-btn hover-bx3"></span>
											<span class="hover-btn hover-bx4"></span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
		<?php
		++$i;
	}
	wp_reset_postdata();
}
