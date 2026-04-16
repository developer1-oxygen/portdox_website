<?php
/**
 * Testimonials grid (Portdox Testimonials page template).
 * Uses CPT posts when available; otherwise same copy/layout from portdox_default_testimonial_seed_rows() until admin seeds DB.
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portdox_assets = get_template_directory_uri();
$page_id        = get_queried_object_id();
$page_title     = $page_id ? get_the_title( $page_id ) : __( 'Testimonials', 'portdox_theme' );
$page_content   = $page_id ? get_post_field( 'post_content', $page_id ) : '';

$t_query = new WP_Query(
	array(
		'post_type'      => 'portdox_testimonial',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
	)
);

$fallback_images = array(
	'testimonial-v2-img3.png',
	'testimonial-v2-img2.png',
	'testimonial-v2-img4.png',
	'testimonial-v2-img1.png',
	'testimonial-v2-img5.png',
	'testimonial-v2-img6.png',
);
$wow_delays      = array( '.1s', '.3s', '.5s' );
?>
		<!--Start Page Header-->
		<section class="page-header">
			<div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_assets ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
			</div>
			<div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
			<div class="container">
				<div class="page-header__inner">
					<h2><?php echo esc_html( $page_title ); ?></h2>
					<ul class="thm-breadcrumb">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'portdox_theme' ); ?></a></li>
						<li><span class="icon-right-arrow21"></span></li>
						<li><?php echo esc_html( $page_title ); ?></li>
					</ul>
				</div>
			</div>
		</section>
		<!--End Page Header-->

		<?php if ( trim( (string) $page_content ) ) : ?>
		<section class="testimonial-page-intro py-4">
			<div class="container">
				<div class="entry-content"><?php echo apply_filters( 'the_content', $page_content ); ?></div>
			</div>
		</section>
		<?php endif; ?>

		<!--Start Testimonial Two-->
		<section class="testimonial-two testimonial-two--testimonial">
			<div class="shape1"><img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/pattern/testimonial-page-pattern.png" alt=""></div>
			<div class="container clearfix">
				<div class="row">
					<?php
					$idx = 0;
					if ( $t_query->have_posts() ) :
						while ( $t_query->have_posts() ) :
							$t_query->the_post();
							$thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
							if ( ! $thumb ) {
								$avatar_file = get_post_meta( get_the_ID(), 'portdox_avatar_file', true );
								if ( is_string( $avatar_file ) && $avatar_file !== '' ) {
									$avatar_file = sanitize_file_name( $avatar_file );
									$thumb       = $portdox_assets . '/assets/images/testimonial/' . $avatar_file;
								} else {
									$img_file = $fallback_images[ $idx % count( $fallback_images ) ];
									$thumb    = $portdox_assets . '/assets/images/testimonial/' . $img_file;
								}
							}
							$role = has_excerpt() ? get_the_excerpt() : __( 'Customer', 'portdox_theme' );
							$text = get_the_content();
							$text = apply_filters( 'the_content', $text );
							$text = wp_strip_all_tags( $text );
							$d    = $wow_delays[ $idx % 3 ];
							$idx++;
							?>
					<div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="<?php echo esc_attr( $d ); ?>">
						<div class="testimonial-two__single">
							<div class="testimonial-two__single-inner">
								<div class="testimonial-two__single-top">
									<div class="img-box">
										<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
									</div>
									<div class="title-box">
										<h2><?php the_title(); ?></h2>
										<span><?php echo esc_html( $role ); ?></span>
									</div>
								</div>
								<div class="testimonial-two__single-text">
									<p><?php echo esc_html( wp_trim_words( $text, 55, '…' ) ); ?></p>
								</div>
								<div class="rating-box">
									<?php
									for ( $s = 0; $s < 5; $s++ ) {
										echo '<i class="icon-star"></i>';
									}
									?>
								</div>
							</div>
						</div>
					</div>
							<?php
						endwhile;
						wp_reset_postdata();
					else :
						foreach ( portdox_default_testimonial_seed_rows() as $row ) :
							$img_file = ! empty( $row['avatar_file'] ) ? sanitize_file_name( $row['avatar_file'] ) : $fallback_images[ $idx % count( $fallback_images ) ];
							$thumb    = $portdox_assets . '/assets/images/testimonial/' . $img_file;
							$text     = isset( $row['content'] ) ? wp_strip_all_tags( $row['content'] ) : '';
							$d        = $wow_delays[ $idx % 3 ];
							$idx++;
							?>
					<div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="<?php echo esc_attr( $d ); ?>">
						<div class="testimonial-two__single">
							<div class="testimonial-two__single-inner">
								<div class="testimonial-two__single-top">
									<div class="img-box">
										<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $row['title'] ); ?>">
									</div>
									<div class="title-box">
										<h2><?php echo esc_html( $row['title'] ); ?></h2>
										<span><?php echo esc_html( isset( $row['excerpt'] ) ? $row['excerpt'] : '' ); ?></span>
									</div>
								</div>
								<div class="testimonial-two__single-text">
									<p><?php echo esc_html( wp_trim_words( $text, 55, '…' ) ); ?></p>
								</div>
								<div class="rating-box">
									<?php for ( $s = 0; $s < 5; $s++ ) : ?>
									<i class="icon-star"></i>
									<?php endfor; ?>
								</div>
							</div>
						</div>
					</div>
							<?php
						endforeach;
					endif;
					?>
				</div>
			</div>
		</section>
		<!--End Testimonial Two-->
