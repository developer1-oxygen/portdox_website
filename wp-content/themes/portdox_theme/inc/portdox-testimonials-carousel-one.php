<?php
/**
 * Shared data + helpers for the testimonial-one carousel (About, Home, etc.).
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Built-in carousel rows (merged into `portdox_get_testimonial_one_carousel_items()`; replace via that filter).
 *
 * @return array<int, array{name:string, role:string, quote:string, avatar_file:string, rating:int}>
 */
function portdox_testimonial_one_carousel_default_items() {
	return array(
		array(
			'name'        => 'Ronald Richards',
			'role'        => __( 'LOGISTICS MANAGER', 'portdox_theme' ),
			'quote'       => __( 'We switched our freight coordination to Portdox and could not be happier—end-to-end visibility, fewer delays, and a support team that actually answers. Fully satisfied as a customer.', 'portdox_theme' ),
			'avatar_file' => 'testimonial-v1-img1.png',
			'rating'      => 5,
		),
		array(
			'name'        => 'Leslie Alexander',
			'role'        => __( 'OPERATIONS LEAD', 'portdox_theme' ),
			'quote'       => __( 'Portdox has streamlined how we book and track shipments. Our operations team trusts the platform daily; we are very satisfied and recommend Portdox to peers in the industry.', 'portdox_theme' ),
			'avatar_file' => 'testimonial-v2-img1.png',
			'rating'      => 5,
		),
		array(
			'name'        => 'Jacob Jones',
			'role'        => __( 'SUPPLY CHAIN DIRECTOR', 'portdox_theme' ),
			'quote'       => __( 'From onboarding to go-live, Portdox exceeded our expectations. Transparent tracking and reliable updates—we are completely satisfied and glad we chose Portdox.', 'portdox_theme' ),
			'avatar_file' => 'testimonial-v2-img2.png',
			'rating'      => 5,
		),
		array(
			'name'        => 'Sarah Chen',
			'role'        => __( 'FREIGHT COORDINATOR', 'portdox_theme' ),
			'quote'       => __( 'Portdox gives us one place to manage documentation and shipment status. As a long-term customer we remain highly satisfied with both the product and the people behind it.', 'portdox_theme' ),
			'avatar_file' => 'testimonial-v2-img3.png',
			'rating'      => 5,
		),
	);
}

/**
 * @param int $limit Max items (0 = no limit).
 * @return array<int, array{name:string, role:string, quote:string, avatar_file:string, rating:int}>
 */
function portdox_get_testimonial_one_carousel_items( $limit = 0 ) {
	static $portdox_testimonial_one_prepared = null;
	if ( null === $portdox_testimonial_one_prepared ) {
		$items = portdox_testimonial_one_carousel_default_items();
		$items = apply_filters( 'portdox_testimonial_one_carousel_items', $items );
		$items = array_values( $items );
		if ( apply_filters( 'portdox_testimonial_one_carousel_shuffle', true ) && count( $items ) > 1 ) {
			shuffle( $items );
		}
		$portdox_testimonial_one_prepared = $items;
	}
	$items = $portdox_testimonial_one_prepared;
	if ( $limit > 0 ) {
		$items = array_slice( $items, 0, $limit );
	}
	return $items;
}

/**
 * Full URL for an avatar filename under assets/images/testimonial/.
 *
 * @param string           $avatar_file e.g. testimonial-v1-img1.png
 * @param string|null      $theme_uri   get_template_directory_uri() if null.
 */
function portdox_testimonial_one_avatar_url( $avatar_file, $theme_uri = null ) {
	$file = ltrim( (string) $avatar_file, '/' );
	if ( '' === $file ) {
		$file = 'testimonial-v1-img1.png';
	}
	if ( null === $theme_uri ) {
		$theme_uri = get_template_directory_uri();
	}
	return trailingslashit( (string) $theme_uri ) . 'assets/images/testimonial/' . $file;
}

/**
 * Echo testimonial-one__single blocks for the owl carousel.
 *
 * @param string $theme_assets_uri Same as template $portdox_assets (theme root URI).
 * @param int    $limit            Number of slides (default 4).
 */
function portdox_render_testimonial_one_carousel_singles( $theme_assets_uri, $limit = 4 ) {
	$items = portdox_get_testimonial_one_carousel_items( $limit );
	foreach ( $items as $item ) {
		$name   = isset( $item['name'] ) ? (string) $item['name'] : '';
		$role   = isset( $item['role'] ) ? (string) $item['role'] : '';
		$quote  = isset( $item['quote'] ) ? (string) $item['quote'] : '';
		$avatar = isset( $item['avatar_file'] ) ? (string) $item['avatar_file'] : 'testimonial-v1-img1.png';
		$rating = isset( $item['rating'] ) ? (int) $item['rating'] : 5;
		$rating = min( 5, max( 0, $rating ) );
		$img    = esc_url( portdox_testimonial_one_avatar_url( $avatar, $theme_assets_uri ) );
		?>
		<div class="testimonial-one__single">
			<div class="icon">
				<span class="icon-quote1"></span>
			</div>
			<div class="testimonial-one__single-inner">
				<div class="shape1"><img src="<?php echo esc_url( $theme_assets_uri ); ?>/assets/images/shapes/testimonial-v1-shape1.png" alt=""></div>
				<div class="author-box">
					<div class="img-box">
						<img src="<?php echo $img; ?>" alt="<?php echo esc_attr( $name ); ?>">
					</div>
					<div class="author-info">
						<h2><?php echo esc_html( $name ); ?></h2>
						<div class="bottom-text">
							<p><?php echo esc_html( $role ); ?></p>
							<div class="rating-box">
								<?php
								for ( $i = 1; $i <= 5; $i++ ) {
									if ( $i <= $rating ) {
										echo '<i class="icon-star"></i>';
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="text-box">
					<p><?php echo esc_html( $quote ); ?></p>
				</div>
			</div>
		</div>
		<?php
	}
}
