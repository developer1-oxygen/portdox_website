<?php
/**
 * Template Name: Portdox Service (listing)
 * Description: Services grid overview — assign to the Page with slug "service" under parent "services".
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$portdox_a    = get_template_directory_uri();
$services_url = portdox_url_for_page_slug( 'services' );
?>

<?php
while ( have_posts() ) :
	the_post();
	$portdox_title = get_the_title() ?: __( 'Service', 'portdox_theme' );
	?>
		<!--Start Page Header-->
		<section class="page-header">
			<div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_a ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
			</div>
			<div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
			<div class="container">
				<div class="page-header__inner">
					<h2><?php echo esc_html( $portdox_title ); ?></h2>
					<ul class="thm-breadcrumb">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'portdox_theme' ); ?></a></li>
						<li><span class="icon-right-arrow21"></span></li>
						<li><a href="<?php echo esc_url( $services_url ); ?>"><?php esc_html_e( 'Services', 'portdox_theme' ); ?></a></li>
						<li><span class="icon-right-arrow21"></span></li>
						<li><?php echo esc_html( $portdox_title ); ?></li>
					</ul>
				</div>
			</div>
		</section>
		<!--End Page Header-->

	<?php
	$content = get_post_field( 'post_content', get_the_ID() );
	if ( '' !== trim( wp_strip_all_tags( $content ) ) ) :
		?>
		<section class="about-one" style="padding-top: 40px; padding-bottom: 0;">
			<div class="container">
				<div class="row">
					<div class="col-xl-12">
						<div class="blog-details__content-text1 entry-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	endif;
endwhile;
?>

		<!--Start Service One-->
		<section class="service-one service-one--service">
			<div class="container">
				<div class="row">
					<?php
					$portdox_services = new WP_Query(
						array(
							'post_type'      => 'portdox_service',
							'post_status'    => 'publish',
							'posts_per_page' => -1,
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
						)
					);

					if ( $portdox_services->have_posts() ) :
						$portdox_anim_classes = array( 'fadeInLeft', 'fadeInRight' );
						$portdox_index        = 0;

						while ( $portdox_services->have_posts() ) :
							$portdox_services->the_post();
							$portdox_link = get_permalink();
							$portdox_img  = function_exists( 'portdox_get_service_listing_image_url' )
								? portdox_get_service_listing_image_url( get_the_ID(), 'portdox-service-card' )
								: get_the_post_thumbnail_url( get_the_ID(), 'large' );
							$portdox_img  = $portdox_img ? $portdox_img : $portdox_a . '/assets/images/services/services-v1-img1.jpg';
							$portdox_anim = $portdox_anim_classes[ $portdox_index % count( $portdox_anim_classes ) ];
							$portdox_index++;
							?>
							<div class="col-xl-4 col-lg-6 col-md-6 wow <?php echo esc_attr( $portdox_anim ); ?>" data-wow-delay="0ms" data-wow-duration="1500ms">
								<div class="service-one__single">
									<div class="service-one__single-inner">
										<div class="service-one__single-img">
											<img src="<?php echo esc_url( $portdox_img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" style="width:100%; height:260px; object-fit:cover;">
										</div>
										<div class="service-one__single-content">
											<h2><a href="<?php echo esc_url( $portdox_link ); ?>"><?php the_title(); ?></a></h2>
											<p>
												<?php
												if ( has_excerpt() ) {
													the_excerpt();
												} else {
													echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_content() ), 20 ) );
												}
												?>
											</p>
											<div class="btn-box">
												<a href="<?php echo esc_url( $portdox_link ); ?>">
													<?php esc_html_e( 'Read More', 'portdox_theme' ); ?>
													<span class="icon-right-arrow21"></span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						endwhile;
						wp_reset_postdata();
					else :
						?>
						<div class="col-12">
							<p><?php esc_html_e( 'No services found yet. Please add Services in the admin.', 'portdox_theme' ); ?></p>
						</div>
						<?php
					endif;
					?>
				</div>
			</div>
		</section>
		<!--End Service One-->

		<?php include get_template_directory() . '/__book_a_demo.php'; ?>

<?php
get_footer();
