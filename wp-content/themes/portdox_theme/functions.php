<?php
/**
 * Portdox theme setup and asset loading.
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTDOX_THEME_VERSION', '1.0.3' );

require_once get_template_directory() . '/inc/portdox-acf-theme-options.php';
require_once get_template_directory() . '/inc/portdox-testimonials-carousel-one.php';
require_once get_template_directory() . '/inc/portdox-blog-one-cards.php';
require_once get_template_directory() . '/inc/portdox-service-listing-image.php';

/**
 * @return string Theme root URI for assets.
 */
function portdox_theme_uri() {
	return get_template_directory_uri();
}

/**
 * Permalink for a published Page by slug, or a sensible URL under the site home.
 *
 * @param string $slug Page post_name (e.g. about).
 */
function portdox_url_for_page_slug( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}
	return home_url( '/' . trim( $slug, '/' ) . '/' );
}

/**
 * Public social profile URLs (header, footer, contact). No Twitter/X.
 * Facebook may stay as '#' until the page URL is ready — override via filter.
 *
 * @return array{facebook:string,instagram:string,linkedin:string}
 */
function portdox_get_social_profile_urls() {
	$urls = array(
		'facebook'  => 'https://www.facebook.com/people/Portdox-US/61573344627160/',
		'instagram' => 'https://www.instagram.com/7port.dox/',
		'linkedin'  => 'https://www.linkedin.com/in/portdox-us-41a0a63bb/?trk=public-profile-join-page',
	);
	return apply_filters( 'portdox_social_profile_urls', $urls );
}

/**
 * Theme defaults.
 */
function portdox_theme_setup() {
	load_theme_textdomain( 'portdox_theme', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	register_nav_menus(
		array(
			'portdox_primary'            => __( 'Primary menu (header)', 'portdox_theme' ),
			'portdox_footer_quick_links' => __( 'Footer quick links', 'portdox_theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'portdox_theme_setup' );

/**
 * Testimonials shown on the Portdox Testimonials page template.
 */
function portdox_register_testimonial_cpt() {
	register_post_type(
		'portdox_testimonial',
		array(
			'labels'              => array(
				'name'          => __( 'Testimonials', 'portdox_theme' ),
				'singular_name' => __( 'Testimonial', 'portdox_theme' ),
				'add_new_item'  => __( 'Add New Testimonial', 'portdox_theme' ),
				'edit_item'     => __( 'Edit Testimonial', 'portdox_theme' ),
				'menu_name'     => __( 'Testimonials', 'portdox_theme' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-format-quote',
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'hierarchical'        => false,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'has_archive'         => false,
		)
	);

	register_post_meta(
		'portdox_testimonial',
		'portdox_rating',
		array(
			'type'              => 'integer',
			'single'            => true,
			'show_in_rest'      => true,
			'default'           => 5,
			'sanitize_callback' => function ( $val ) {
				$n = (int) $val;
				return min( 5, max( 1, $n ) );
			},
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);

	register_post_meta(
		'portdox_testimonial',
		'portdox_avatar_file',
		array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => function ( $val ) {
				$val = sanitize_file_name( (string) $val );
				return preg_match( '/\.(png|jpe?g|webp)$/i', $val ) ? $val : '';
			},
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'portdox_register_testimonial_cpt' );

/**
 * Services shown on the Services listing template.
 */
function portdox_register_service_cpt() {
	register_post_type(
		'portdox_service',
		array(
			'labels'             => array(
				'name'          => __( 'Services', 'portdox_theme' ),
				'singular_name' => __( 'Service', 'portdox_theme' ),
				'add_new_item'  => __( 'Add New Service', 'portdox_theme' ),
				'edit_item'     => __( 'Edit Service', 'portdox_theme' ),
				'menu_name'     => __( 'Services', 'portdox_theme' ),
			),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-portfolio',
			'capability_type'    => 'post',
			'map_meta_cap'       => true,
			'hierarchical'       => false,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'has_archive'        => false,
			'rewrite'            => array(
				'slug'       => 'services',
				'with_front' => false,
			),
		)
	);
}
add_action( 'init', 'portdox_register_service_cpt' );

/**
 * Newsletter subscribers from footer form (admin-only UI, not public).
 */
function portdox_register_subscriber_cpt() {
	register_post_type(
		'portdox_subscriber',
		array(
			'labels'             => array(
				'name'          => __( 'Subscribers', 'portdox_theme' ),
				'singular_name' => __( 'Subscriber', 'portdox_theme' ),
				'add_new_item'  => __( 'Add New Subscriber', 'portdox_theme' ),
				'edit_item'     => __( 'Edit Subscriber', 'portdox_theme' ),
				'menu_name'     => __( 'Subscribers', 'portdox_theme' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-email-alt',
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'hierarchical'        => false,
			'supports'            => array( 'title' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
		)
	);

	register_post_meta(
		'portdox_subscriber',
		'portdox_subscriber_email',
		array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => false,
			'sanitize_callback' => 'sanitize_email',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'portdox_register_subscriber_cpt' );

/**
 * @param string $email Normalized email.
 * @return bool Whether a published subscriber with this title exists.
 */
function portdox_subscriber_exists( $email ) {
	global $wpdb;
	$email = strtolower( trim( (string) $email ) );
	if ( '' === $email ) {
		return false;
	}
	$id = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type = %s AND post_status = 'publish' AND post_title = %s LIMIT 1",
			'portdox_subscriber',
			$email
		)
	);
	return (bool) $id;
}

/**
 * Default rows (formerly static on the testimonials page). Filterable.
 *
 * @return array<int, array{title:string, excerpt:string, content:string, menu_order:int, avatar_file:string}>
 */
function portdox_default_testimonial_seed_rows() {
	$body = __( 'A logistic service provider company plays a pivotal role in the global supply chain A logistic service provider companyA logistic service provider.', 'portdox_theme' );
	return apply_filters(
		'portdox_default_testimonial_seed_rows',
		array(
			array(
				'title'       => 'Leslie Alexander',
				'excerpt'     => 'MANAGER',
				'content'     => $body,
				'menu_order'  => 0,
				'avatar_file' => 'testimonial-v2-img3.png',
			),
			array(
				'title'       => 'Ronald Richards',
				'excerpt'     => 'MANAGER',
				'content'     => $body,
				'menu_order'  => 1,
				'avatar_file' => 'testimonial-v2-img2.png',
			),
			array(
				'title'       => 'Ronald Richards',
				'excerpt'     => 'MANAGER',
				'content'     => $body,
				'menu_order'  => 2,
				'avatar_file' => 'testimonial-v2-img4.png',
			),
			array(
				'title'       => 'Leslie Alexander',
				'excerpt'     => 'MANAGER',
				'content'     => $body,
				'menu_order'  => 3,
				'avatar_file' => 'testimonial-v2-img1.png',
			),
			array(
				'title'       => 'Ronald Richards',
				'excerpt'     => 'MANAGER',
				'content'     => $body,
				'menu_order'  => 4,
				'avatar_file' => 'testimonial-v2-img5.png',
			),
			array(
				'title'       => 'Ronald Richards',
				'excerpt'     => 'MANAGER',
				'content'     => $body,
				'menu_order'  => 5,
				'avatar_file' => 'testimonial-v2-img6.png',
			),
		)
	);
}

/**
 * Insert default testimonial posts. Must run in a context where wp_insert_post is allowed (e.g. admin).
 *
 * @return int Number of posts successfully created.
 */
function portdox_run_testimonial_seed() {
	$author_ids = get_users(
		array(
			'role'   => 'administrator',
			'number' => 1,
			'fields' => 'ID',
		)
	);
	$author_id  = ! empty( $author_ids ) ? (int) $author_ids[0] : 1;

	$created = 0;
	foreach ( portdox_default_testimonial_seed_rows() as $row ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'portdox_testimonial',
				'post_status'  => 'publish',
				'post_title'   => $row['title'],
				'post_excerpt' => $row['excerpt'],
				'post_content' => $row['content'],
				'menu_order'   => isset( $row['menu_order'] ) ? (int) $row['menu_order'] : 0,
				'post_author'  => $author_id,
			),
			true
		);
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}
		++$created;
		if ( ! empty( $row['avatar_file'] ) ) {
			update_post_meta( $post_id, 'portdox_avatar_file', sanitize_file_name( $row['avatar_file'] ) );
		}
	}
	return $created;
}

/**
 * Create starter testimonials when none exist (runs in admin only — front-end init cannot insert posts).
 */
function portdox_maybe_seed_default_testimonials() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$counts = wp_count_posts( 'portdox_testimonial' );
	$pub    = isset( $counts->publish ) ? (int) $counts->publish : 0;

	if ( $pub > 0 ) {
		update_option( 'portdox_testimonials_seeded', '1' );
		return;
	}

	// Published count is 0 but flag was set (e.g. old bug: inserts failed on front-end).
	if ( get_option( 'portdox_testimonials_seeded' ) ) {
		delete_option( 'portdox_testimonials_seeded' );
	}

	$created = portdox_run_testimonial_seed();
	if ( $created > 0 ) {
		update_option( 'portdox_testimonials_seeded', '1' );
	}
}
add_action( 'admin_init', 'portdox_maybe_seed_default_testimonials', 20 );

/**
 * Add theme dropdown class for items with children (all depths — flyout submenus).
 *
 * @param string[] $classes CSS classes.
 * @param WP_Post  $item    Menu item.
 * @param stdClass $args    Menu args.
 * @param int      $depth   Nesting depth.
 * @return string[]
 */
function portdox_nav_menu_css_class( $classes, $item, $args, $depth = 0 ) {
	if ( empty( $args->theme_location ) || 'portdox_primary' !== $args->theme_location ) {
		return $classes;
	}
	if ( in_array( 'menu-item-has-children', $classes, true ) ) {
		$classes[] = 'dropdown';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'portdox_nav_menu_css_class', 10, 4 );

/**
 * Parent items with # or empty URL behave like the old static menu (no navigation).
 *
 * @param array    $atts  HTML attributes for the anchor.
 * @param WP_Post  $item  Menu item.
 * @param stdClass $args  Menu args.
 * @param int      $depth Nesting depth.
 * @return array
 */
function portdox_nav_menu_link_attributes( $atts, $item, $args, $depth = 0 ) {
	if ( empty( $args->theme_location ) || 'portdox_primary' !== $args->theme_location ) {
		return $atts;
	}
	if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
		$url = isset( $item->url ) ? $item->url : '';
		if ( '' === $url || '#' === $url || 'javascript:void(0);' === $url ) {
			$atts['href'] = 'javascript:void(0);';
		}
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'portdox_nav_menu_link_attributes', 10, 4 );

/**
 * When no menu is assigned, show a small default list (edit in Appearance → Menus).
 */
function portdox_primary_menu_fallback() {
	$posts_page = (int) get_option( 'page_for_posts' );
	$blog_url   = $posts_page ? get_permalink( $posts_page ) : home_url( '/blog/' );
	?>
	<ul class="main-menu__list">
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'portdox_theme' ); ?></a></li>
		<li><a href="<?php echo esc_url( portdox_url_for_page_slug( 'about' ) ); ?>"><?php esc_html_e( 'About Us', 'portdox_theme' ); ?></a></li>
		<li><a href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'Blog', 'portdox_theme' ); ?></a></li>
		<li><a href="<?php echo esc_url( portdox_url_for_page_slug( 'contact' ) ); ?>"><?php esc_html_e( 'Contact', 'portdox_theme' ); ?></a></li>
	</ul>
	<?php
}

/**
 * Footer quick links when no menu is assigned (Appearance → Menus → Footer quick links).
 */
function portdox_footer_quick_links_fallback() {
	$links = array(
		array(
			'url'   => home_url( '/' ),
			'label' => __( 'Home', 'portdox_theme' ),
		),
		array(
			'url'   => portdox_url_for_page_slug( 'about' ),
			'label' => __( 'About Us', 'portdox_theme' ),
		),
		array(
			'url'   => portdox_url_for_page_slug( 'service' ),
			'label' => __( 'Service', 'portdox_theme' ),
		),
		array(
			'url'   => portdox_url_for_page_slug( 'book-a-demo' ),
			'label' => __( 'Request a Demo', 'portdox_theme' ),
		),
		array(
			'url'   => portdox_url_for_page_slug( 'contact' ),
			'label' => __( 'Contact Us', 'portdox_theme' ),
		),
	);
	?>
	<ul class="footer-one__quick-links-list">
		<?php foreach ( $links as $row ) : ?>
			<li>
				<a href="<?php echo esc_url( $row['url'] ); ?>">
					<span class="icon-right-arrow1"></span>
					<?php echo esc_html( $row['label'] ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
}

/**
 * Nested submenu position (matches former inline flyout under Industries).
 */
function portdox_nav_nested_submenu_css() {
	?>
	<style id="portdox-nav-submenu">
		@media (min-width: 1200px) {
			.main-menu .main-menu__list .sub-menu .sub-menu {
				top: -18px;
				left: 95%;
				padding: 10px;
			}
			.main-menu .main-menu__list .sub-menu .sub-menu > li {
				padding: 10px;
			}
		}
	</style>
	<?php
}
add_action( 'wp_head', 'portdox_nav_nested_submenu_css', 50 );

/**
 * Footer subscribe form feedback (query arg ?subscribe=).
 */
function portdox_subscribe_notice_css() {
	?>
	<style id="portdox-subscribe-notice">
		.portdox-subscribe-notice { font-size: 14px; margin: 0 0 10px; line-height: 1.4; }
		.portdox-subscribe-notice[hidden] { display: none !important; }
		.portdox-subscribe-notice.is-success { color: #0a7a0a; }
		.portdox-subscribe-notice.is-info { color: #888; }
		.portdox-subscribe-notice.is-error { color: #b00020; }
	</style>
	<?php
}
add_action( 'wp_head', 'portdox_subscribe_notice_css', 51 );

/**
 * Enqueue styles (mirrors __head.php order).
 */
function portdox_theme_styles() {
	$u   = portdox_theme_uri();
	$ver = PORTDOX_THEME_VERSION;

	wp_enqueue_style( 'portdox-theme', get_stylesheet_uri(), array(), $ver );

	wp_enqueue_style( 'portdox-fonts', 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap', array(), null );

	$css = array(
		'01-bootstrap.min.css',
		'02-animate.min.css',
		'03-custom-animate.css',
		'05-flaticon.css',
		'06-font-awesome-all.css',
		'07-jarallax.css',
		'08-jquery.magnific-popup.css',
		'09-nice-select.css',
		'11-owl.carousel.min.css',
		'12-owl.theme.default.min.css',
		'13-jquery-ui.css',
	);

	$dep = 'portdox-theme';
	foreach ( $css as $file ) {
		$h = 'portdox-' . sanitize_title( $file );
		wp_enqueue_style( $h, $u . '/assets/css/' . $file, array( $dep ), $ver );
		$dep = $h;
	}

	$modules = array(
		'module-css/01-slider.css',
		'module-css/02-about.css',
		'module-css/03-services.css',
		'module-css/04-testimonial.css',
		'module-css/05-team.css',
		'module-css/06-blog.css',
		'module-css/07-brand.css',
		'module-css/08-contact.css',
		'module-css/09-counter.css',
		'module-css/10-error.css',
		'module-css/11-faq.css',
		'module-css/12-footer.css',
		'module-css/13-page-header.css',
		'module-css/14-shop.css',
		'module-css/15-video.css',
		'module-css/awards.css',
		'module-css/banner.css',
		'module-css/cta.css',
		'module-css/design-interior.css',
		'module-css/feature.css',
		'module-css/pricing.css',
		'module-css/projects.css',
		'module-css/quote.css',
		'module-css/skill.css',
		'module-css/sliding-text.css',
		'module-css/why-choose.css',
		'module-css/working-process.css',
	);

	foreach ( $modules as $file ) {
		$h = 'portdox-mod-' . sanitize_title( str_replace( '/', '-', $file ) );
		wp_enqueue_style( $h, $u . '/assets/css/' . $file, array( $dep ), $ver );
		$dep = $h;
	}

	wp_enqueue_style( 'portdox-swiper', $u . '/assets/css/swiper.min.css', array( $dep ), $ver );
	$dep = 'portdox-swiper';

	wp_enqueue_style( 'portdox-logistiq-style', $u . '/assets/css/style.css', array( $dep ), $ver );
	wp_enqueue_style( 'portdox-responsive', $u . '/assets/css/responsive.css', array( 'portdox-logistiq-style' ), $ver );
}
add_action( 'wp_enqueue_scripts', 'portdox_theme_styles' );

/**
 * Enqueue scripts (footer; preserves original load order via dependency chain).
 */
function portdox_theme_scripts() {
	$u   = portdox_theme_uri();
	$ver = PORTDOX_THEME_VERSION;

	/* Head: jQuery must load before body markup / inline scripts that use `$`. */
	if ( ! is_admin() ) {
		wp_scripts()->add_data( 'jquery', 'group', 0 );
		wp_scripts()->add_data( 'jquery-core', 'group', 0 );
		wp_scripts()->add_data( 'jquery-migrate', 'group', 0 );
	}

	wp_enqueue_script( 'jquery' );

	/*
	 * WordPress runs jQuery in noConflict mode — `$` is not global. This theme’s
	 * vendor files (circleType, script.js, etc.) expect `$`. Load a tiny inline
	 * script in the head right after jQuery, then chain all theme scripts off it.
	 */
	wp_register_script(
		'portdox-jquery-compat',
		false,
		array( 'jquery' ),
		$ver,
		false
	);
	wp_enqueue_script( 'portdox-jquery-compat' );
	wp_add_inline_script(
		'portdox-jquery-compat',
		'window.$ = window.jQuery;',
		'after'
	);

	$files = array(
		'jquery.ajaxchimp.min.js',
		'jquery.validate.min.js',
		'swiper.min.js',
		'wNumb.min.js',
		'curved-text/jquery.circleType.js',
		'curved-text/jquery.fittext.js',
		'curved-text/jquery.lettering.min.js',
		'gsap/gsap.js',
		'gsap/ScrollTrigger.js',
		'gsap/SplitText.js',
		'01-bootstrap.bundle.min.js',
		'02-countdown.min.js',
		'03-jquery.appear.min.js',
		'04-jquery.nice-select.min.js',
		'05-jquery-sidebar-content.js',
		'06-marquee.min.js',
		'07-owl.carousel.min.js',
		'08-jarallax.min.js',
		'09-odometer.min.js',
		'10-jquery-ui.js',
		'11-jquery.magnific-popup.min.js',
		'12-wow.js',
		'13-isotope.js',
		'script.js',
	);

	$dep = 'portdox-jquery-compat';
	foreach ( $files as $i => $file ) {
		$h = 'portdox-js-' . ( $i + 1 );
		wp_enqueue_script( $h, $u . '/assets/js/' . $file, array( $dep ), $ver, true );
		$dep = $h;
	}
}
add_action( 'wp_enqueue_scripts', 'portdox_theme_scripts' );

/**
 * Prevent defer/async on jQuery (some optimization plugins break plugin load order).
 *
 * @param string $tag    Full script HTML.
 * @param string $handle Script handle.
 * @return string
 */
function portdox_theme_jquery_no_defer_async( $tag, $handle ) {
	$jquery_handles = array( 'jquery', 'jquery-core', 'jquery-migrate', 'portdox-jquery-compat' );
	if ( in_array( $handle, $jquery_handles, true ) ) {
		$tag = preg_replace( '/\s(defer|async)(=[\'"][^\'"]*[\'"])?/i', '', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'portdox_theme_jquery_no_defer_async', 99, 2 );

/**
 * Favicon / site icon links (previously in __head.php).
 */
function portdox_theme_favicons() {
	$u   = portdox_theme_uri();
	$ico = $u . '/assets/images/favicon.png';
	echo '<link rel="icon" href="' . esc_url( $ico ) . '" type="image/png" />' . "\n";
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( $ico ) . '" />' . "\n";
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( $ico ) . '" />' . "\n";
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url( $ico ) . '" />' . "\n";
	$manifest = get_template_directory() . '/assets/images/favicons/site.webmanifest';
	if ( is_readable( $manifest ) ) {
		echo '<link rel="manifest" href="' . esc_url( $u . '/assets/images/favicons/site.webmanifest' ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'portdox_theme_favicons', 1 );

/**
 * Handle contact form from Portdox Contact page template (admin-post.php).
 */
function portdox_contact_form_handler() {
	if ( ! isset( $_POST['portdox_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portdox_contact_nonce'] ) ), 'portdox_contact' ) ) {
		wp_die( esc_html__( 'Security check failed.', 'portdox_theme' ), '', array( 'response' => 403 ) );
	}

	$name    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
	$email   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
	$phone   = isset( $_POST['contact_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_phone'] ) ) : '';
	$subject = isset( $_POST['contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) ) : '';
	$message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

	$redirect = wp_get_referer();
	if ( ! $redirect ) {
		$redirect = home_url( '/' );
	}

	if ( '' === $email || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'invalid', $redirect ) );
		exit;
	}

	$to       = apply_filters( 'portdox_contact_recipient', get_option( 'admin_email' ) );
	$mail_sub = $subject ? $subject : __( 'Website contact', 'portdox_theme' );
	$body     = sprintf(
		"Name: %s\nEmail: %s\nPhone: %s\n\n%s",
		$name,
		$email,
		$phone,
		$message
	);
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		sprintf( 'Reply-To: %s <%s>', $name ? $name : 'Contact', $email ),
	);

	$sent = wp_mail( $to, '[' . wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . '] ' . $mail_sub, $body, $headers );

	wp_safe_redirect( add_query_arg( 'contact', $sent ? 'sent' : 'failed', $redirect ) );
	exit;
}
add_action( 'admin_post_nopriv_portdox_contact_submit', 'portdox_contact_form_handler' );
add_action( 'admin_post_portdox_contact_submit', 'portdox_contact_form_handler' );

/**
 * Validate + send Request a Demo email request.
 *
 * @param array<string,mixed> $src Request source (typically $_POST).
 * @return array<string,string>|WP_Error
 */
function portdox_demo_process_submission( $src ) {
	$first   = isset( $src['demo_first_name'] ) ? sanitize_text_field( wp_unslash( $src['demo_first_name'] ) ) : '';
	$last    = isset( $src['demo_last_name'] ) ? sanitize_text_field( wp_unslash( $src['demo_last_name'] ) ) : '';
	$email   = isset( $src['demo_email'] ) ? sanitize_email( wp_unslash( $src['demo_email'] ) ) : '';
	$phone   = isset( $src['demo_phone'] ) ? sanitize_text_field( wp_unslash( $src['demo_phone'] ) ) : '';
	$company = isset( $src['demo_company'] ) ? sanitize_text_field( wp_unslash( $src['demo_company'] ) ) : '';
	$country = isset( $src['demo_country'] ) ? sanitize_text_field( wp_unslash( $src['demo_country'] ) ) : '';

	if ( '' === $email || ! is_email( $email ) || '' === $first || '' === $last || '' === $phone || '' === $company || '' === $country ) {
		return new WP_Error( 'invalid', __( 'Please fill all required fields with a valid email.', 'portdox_theme' ) );
	}

	// Demo request email goes to Settings → General → Administration Email unless overridden.
	$to = apply_filters( 'portdox_demo_recipient', get_option( 'admin_email' ) );
	$display_name = trim( $first . ' ' . $last );
	$body         = sprintf(
		"First name: %s\nLast name: %s\nEmail: %s\nPhone: %s\nCompany: %s\nCountry: %s\n",
		$first,
		$last,
		$email,
		$phone,
		$company,
		$country
	);
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		sprintf( 'Reply-To: %s <%s>', $display_name ? $display_name : __( 'Demo request', 'portdox_theme' ), $email ),
	);

	$mail_sub = __( 'Demo request', 'portdox_theme' );
	$sent     = wp_mail( $to, '[' . wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . '] ' . $mail_sub, $body, $headers );
	if ( ! $sent ) {
		return new WP_Error( 'failed', __( 'Could not send request. Please try again.', 'portdox_theme' ) );
	}

	return array(
		'code'    => 'sent',
		'message' => __( 'Thank you — we received your request and will be in touch shortly.', 'portdox_theme' ),
	);
}

/**
 * Handle Request a Demo form (fallback non-JS submit via admin-post.php).
 */
function portdox_demo_form_handler() {
	if ( ! isset( $_POST['portdox_demo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portdox_demo_nonce'] ) ), 'portdox_demo' ) ) {
		wp_die( esc_html__( 'Security check failed.', 'portdox_theme' ), '', array( 'response' => 403 ) );
	}

	$redirect = wp_get_referer();
	if ( ! $redirect ) {
		$redirect = home_url( '/' );
	}

	$result = portdox_demo_process_submission( $_POST );
	if ( is_wp_error( $result ) ) {
		$code = $result->get_error_code();
		wp_safe_redirect( add_query_arg( 'demo', 'invalid' === $code ? 'invalid' : 'failed', $redirect ) );
		exit;
	}

	wp_safe_redirect( add_query_arg( 'demo', 'sent', $redirect ) );
	exit;
}
add_action( 'admin_post_nopriv_portdox_demo_submit', 'portdox_demo_form_handler' );
add_action( 'admin_post_portdox_demo_submit', 'portdox_demo_form_handler' );

/**
 * AJAX handler: Request a Demo.
 */
function portdox_demo_ajax_handler() {
	check_ajax_referer( 'portdox_demo', 'nonce' );

	$result = portdox_demo_process_submission( $_POST );
	if ( is_wp_error( $result ) ) {
		$code = $result->get_error_code();
		$http = ( 'failed' === $code ) ? 500 : 400;
		wp_send_json_error(
			array(
				'code'    => $code,
				'message' => $result->get_error_message(),
			),
			$http
		);
	}

	wp_send_json_success( $result );
}
add_action( 'wp_ajax_nopriv_portdox_demo_submit', 'portdox_demo_ajax_handler' );
add_action( 'wp_ajax_portdox_demo_submit', 'portdox_demo_ajax_handler' );

/**
 * Process footer subscribe email: validate, dedupe, create portdox_subscriber.
 *
 * @param string $raw Raw email from request.
 * @return array<string,string>|WP_Error Success array keys: code (sent|duplicate), message — or WP_Error.
 */
function portdox_subscribe_process_email( $raw ) {
	$email = strtolower( trim( sanitize_email( (string) $raw ) ) );

	if ( '' === $email || ! is_email( $email ) ) {
		return new WP_Error( 'invalid', __( 'Please enter a valid email address.', 'portdox_theme' ) );
	}

	if ( portdox_subscriber_exists( $email ) ) {
		return array(
			'code'    => 'duplicate',
			'message' => __( 'This email is already on our list.', 'portdox_theme' ),
		);
	}

	$post_id = wp_insert_post(
		array(
			'post_type'    => 'portdox_subscriber',
			'post_title'   => $email,
			'post_status'  => 'publish',
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		return new WP_Error( 'error', __( 'Something went wrong. Please try again.', 'portdox_theme' ) );
	}

	update_post_meta( $post_id, 'portdox_subscriber_email', $email );

	/**
	 * After a new footer subscriber is saved.
	 *
	 * @param int    $post_id Subscriber post ID.
	 * @param string $email   Subscriber email.
	 */
	do_action( 'portdox_subscriber_created', (int) $post_id, $email );

	return array(
		'code'    => 'sent',
		'message' => __( 'Thank you — you are subscribed.', 'portdox_theme' ),
	);
}

/**
 * AJAX: footer newsletter subscribe (JSON).
 */
function portdox_ajax_subscribe_handler() {
	check_ajax_referer( 'portdox_subscribe', 'nonce' );

	$raw    = isset( $_POST['email'] ) ? wp_unslash( $_POST['email'] ) : '';
	$result = portdox_subscribe_process_email( $raw );

	if ( is_wp_error( $result ) ) {
		$code = $result->get_error_code();
		$http = ( 'error' === $code ) ? 500 : 400;
		wp_send_json_error(
			array(
				'code'    => $code,
				'message' => $result->get_error_message(),
			),
			$http
		);
	}

	wp_send_json_success(
		array(
			'code'    => $result['code'],
			'message' => $result['message'],
		)
	);
}
add_action( 'wp_ajax_nopriv_portdox_subscribe', 'portdox_ajax_subscribe_handler' );
add_action( 'wp_ajax_portdox_subscribe', 'portdox_ajax_subscribe_handler' );

/**
 * Footer subscribe: fetch() to admin-ajax.php (runs after footer markup; wp_footer).
 */
function portdox_enqueue_subscribe_ajax() {
	if ( is_admin() ) {
		return;
	}

	$ver = PORTDOX_THEME_VERSION;
	wp_register_script(
		'portdox-subscribe-ajax',
		false,
		array(),
		$ver,
		true
	);
	wp_enqueue_script( 'portdox-subscribe-ajax' );

	wp_localize_script(
		'portdox-subscribe-ajax',
		'PortdoxSubscribe',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'portdox_subscribe' ),
			'strings' => array(
				'required' => __( 'Please enter your email address.', 'portdox_theme' ),
				'network'  => __( 'Connection failed. Please try again.', 'portdox_theme' ),
			),
		)
	);

	$inline = <<<'JS'
(function(){document.addEventListener("DOMContentLoaded",function(){var form=document.querySelector(".footer-one__subscribe .portdox-subscribe-form");if(!form||typeof PortdoxSubscribe==="undefined")return;var msg=document.getElementById("portdox-subscribe-message");var emailI=form.querySelector('input[name="email"]');var btn=form.querySelector('button[type="submit"]');function show(t,c){if(!msg)return;msg.textContent=t;msg.hidden=false;msg.className="portdox-subscribe-notice is-"+c;msg.setAttribute("role","status");}form.addEventListener("submit",function(e){e.preventDefault();e.stopImmediatePropagation();var email=emailI?String(emailI.value).trim():"";if(!email){show(PortdoxSubscribe.strings.required,"error");return;}btn.disabled=true;var fd=new FormData();fd.append("action","portdox_subscribe");fd.append("nonce",PortdoxSubscribe.nonce);fd.append("email",email);fetch(PortdoxSubscribe.ajaxUrl,{method:"POST",body:fd,credentials:"same-origin"}).then(function(r){return r.json().then(function(j){return{ok:r.ok,j:j};});}).then(function(o){btn.disabled=false;var j=o.j;if(!j.success){var em=j.data&&j.data.message?j.data.message:PortdoxSubscribe.strings.network;show(em,"error");return;}var d=j.data||{};show(d.message||"",d.code==="sent"?"success":"info");if(d.code==="sent"&&emailI)emailI.value="";}).catch(function(){btn.disabled=false;show(PortdoxSubscribe.strings.network,"error");});},true);});})();
JS;

	wp_add_inline_script( 'portdox-subscribe-ajax', $inline, 'after' );
}
add_action( 'wp_enqueue_scripts', 'portdox_enqueue_subscribe_ajax', 100 );

/**
 * Whether the current view includes the shared `.portdox-demo-form` (home, demo page, about section).
 *
 * @return bool
 */
function portdox_needs_demo_form_assets() {
	if ( is_admin() ) {
		return false;
	}
	if ( is_page_template( 'page-templates/portdox-book-a-demo.php' ) ) {
		return true;
	}
	if ( is_front_page() ) {
		return true;
	}
	if ( is_page_template( 'page-templates/portdox-about.php' ) ) {
		return true;
	}
	if ( is_page_template( 'template-service.php' ) ) {
		return true;
	}
	return false;
}

/**
 * Request a Demo AJAX + SweetAlert2 where the demo form is shown.
 */
function portdox_enqueue_demo_ajax_script() {
	if ( ! portdox_needs_demo_form_assets() ) {
		return;
	}

	$ver = PORTDOX_THEME_VERSION;
	wp_enqueue_script(
		'portdox-sweetalert2',
		'https://cdn.jsdelivr.net/npm/sweetalert2@11',
		array(),
		'11',
		true
	);

	wp_register_script(
		'portdox-demo-ajax',
		false,
		array( 'portdox-sweetalert2' ),
		$ver,
		true
	);
	wp_enqueue_script( 'portdox-demo-ajax' );

	wp_localize_script(
		'portdox-demo-ajax',
		'PortdoxDemo',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'portdox_demo' ),
			'strings' => array(
				'submitting'   => __( 'Submitting...', 'portdox_theme' ),
				'titleSuccess' => __( 'Submitted', 'portdox_theme' ),
				'titleError'   => __( 'Error', 'portdox_theme' ),
				'network'      => __( 'Connection failed. Please try again.', 'portdox_theme' ),
			),
		)
	);

	$inline = <<<'JS'
(function(){document.addEventListener("DOMContentLoaded",function(){var form=document.querySelector(".portdox-demo-form");if(!form||typeof PortdoxDemo==="undefined")return;var btn=form.querySelector('button[type="submit"]');form.addEventListener("submit",function(e){e.preventDefault();e.stopImmediatePropagation();var btnHtml=btn?btn.innerHTML:"";if(btn){btn.disabled=true;btn.innerHTML=PortdoxDemo.strings.submitting;}var fd=new FormData(form);fd.append("action","portdox_demo_submit");fd.append("nonce",PortdoxDemo.nonce);fetch(PortdoxDemo.ajaxUrl,{method:"POST",body:fd,credentials:"same-origin"}).then(function(r){return r.json().then(function(j){return{ok:r.ok,j:j};});}).then(function(o){if(btn){btn.disabled=false;btn.innerHTML=btnHtml;}var j=o.j||{};if(!j.success){var em=(j.data&&j.data.message)?j.data.message:PortdoxDemo.strings.network;if(typeof Swal!=="undefined"){Swal.fire({icon:"error",title:PortdoxDemo.strings.titleError,text:em});}else{alert(em);}return;}var d=j.data||{};if(typeof Swal!=="undefined"){Swal.fire({icon:"success",title:PortdoxDemo.strings.titleSuccess,text:d.message||"",confirmButtonText:"OK"});}else{alert(d.message||"Success");}form.reset();}).catch(function(){if(btn){btn.disabled=false;btn.innerHTML=btnHtml;}if(typeof Swal!=="undefined"){Swal.fire({icon:"error",title:PortdoxDemo.strings.titleError,text:PortdoxDemo.strings.network});}else{alert(PortdoxDemo.strings.network);}});},true);});})();
JS;

	wp_add_inline_script( 'portdox-demo-ajax', $inline, 'after' );
}
add_action( 'wp_enqueue_scripts', 'portdox_enqueue_demo_ajax_script', 110 );

/**
 * Page tree mirroring the old static nav (commented demo + active items). Home / About are never created.
 *
 * @return array<int, array<string, mixed>>
 */
function portdox_migration_menu_page_tree() {
	return array(
		array(
			'title'    => __( 'Industries', 'portdox_theme' ),
			'slug'     => 'industries',
			'children' => array(
				array(
					'title'    => __( 'Freight Forwarding', 'portdox_theme' ),
					'slug'     => 'freight-forwarding',
					'children' => array(
						array(
							'title' => __( 'Export', 'portdox_theme' ),
							'slug'  => 'freight-forwarding-export',
						),
					),
				),
				array(
					'title' => __( '3PL', 'portdox_theme' ),
					'slug'  => '3pl',
				),
				array(
					'title' => __( 'Warehouse', 'portdox_theme' ),
					'slug'  => 'warehouse',
				),
				array(
					'title' => __( 'Courier', 'portdox_theme' ),
					'slug'  => 'courier',
				),
				array(
					'title' => __( 'Customs Brokerage', 'portdox_theme' ),
					'slug'  => 'customs-brokerage',
				),
			),
		),
		array(
			'title'    => __( 'Services', 'portdox_theme' ),
			'slug'     => 'services',
			'children' => array(
				array(
					'title'          => __( 'Service', 'portdox_theme' ),
					'slug'           => 'service',
					'page_template'  => 'template-service.php',
				),
				array(
					'title' => __( 'International Transport', 'portdox_theme' ),
					'slug'  => 'international-transport',
				),
				array(
					'title' => __( 'Track Transport', 'portdox_theme' ),
					'slug'  => 'track-transport',
				),
				array(
					'title' => __( 'Ocean Transport', 'portdox_theme' ),
					'slug'  => 'ocean-transport',
				),
				array(
					'title' => __( 'Warehouse Facility', 'portdox_theme' ),
					'slug'  => 'warehouse-facility',
				),
				array(
					'title' => __( 'Portdox Cloud', 'portdox_theme' ),
					'slug'  => 'portdox-cloud',
				),
				array(
					'title' => __( 'Portdox Network', 'portdox_theme' ),
					'slug'  => 'portdox-network',
				),
				array(
					'title' => __( 'Portdox Open API', 'portdox_theme' ),
					'slug'  => 'portdox-open-api',
				),
				array(
					'title' => __( 'Professional Services', 'portdox_theme' ),
					'slug'  => 'professional-services',
				),
				array(
					'title' => __( 'Support', 'portdox_theme' ),
					'slug'  => 'support',
				),
			),
		),
		array(
			'title'    => __( 'Pages', 'portdox_theme' ),
			'slug'     => 'site-pages',
			'children' => array(
				array(
					'title' => __( 'Team', 'portdox_theme' ),
					'slug'  => 'team',
				),
				array(
					'title' => __( 'Team Details', 'portdox_theme' ),
					'slug'  => 'team-details',
				),
				array(
					'title' => __( 'Projects', 'portdox_theme' ),
					'slug'  => 'project',
				),
				array(
					'title' => __( 'Project Details', 'portdox_theme' ),
					'slug'  => 'project-details',
				),
				array(
					'title' => __( 'Testimonials', 'portdox_theme' ),
					'slug'  => 'testimonial',
				),
				array(
					'title' => __( 'Pricing', 'portdox_theme' ),
					'slug'  => 'pricing',
				),
				array(
					'title' => __( 'FAQ', 'portdox_theme' ),
					'slug'  => 'faq',
				),
			),
		),
		array(
			'title'    => __( 'Shop', 'portdox_theme' ),
			'slug'     => 'shop',
			'children' => array(
				array(
					'title' => __( 'Products', 'portdox_theme' ),
					'slug'  => 'products',
				),
				array(
					'title' => __( 'Product Details', 'portdox_theme' ),
					'slug'  => 'product-details',
				),
				array(
					'title' => __( 'Cart', 'portdox_theme' ),
					'slug'  => 'cart',
				),
				array(
					'title' => __( 'Checkout', 'portdox_theme' ),
					'slug'  => 'checkout',
				),
				array(
					'title' => __( 'Wishlist', 'portdox_theme' ),
					'slug'  => 'wishlist',
				),
				array(
					'title' => __( 'Sign up', 'portdox_theme' ),
					'slug'  => 'sign-up',
				),
				array(
					'title' => __( 'Login', 'portdox_theme' ),
					'slug'  => 'login',
				),
			),
		),
		array(
			'title'    => __( 'Blog', 'portdox_theme' ),
			'slug'     => 'blog',
			'children' => array(
				array(
					'title' => __( 'Blog Standard', 'portdox_theme' ),
					'slug'  => 'blog-standard',
				),
				array(
					'title' => __( 'Blog Left Sidebar', 'portdox_theme' ),
					'slug'  => 'blog-left-sidebar',
				),
				array(
					'title' => __( 'Blog Right Sidebar', 'portdox_theme' ),
					'slug'  => 'blog-right-sidebar',
				),
				array(
					'title' => __( 'Blog Details', 'portdox_theme' ),
					'slug'  => 'blog-details',
				),
			),
		),
		array(
			'title' => __( 'Contact', 'portdox_theme' ),
			'slug'  => 'contact',
		),
	);
}

/**
 * Slugs that must never be auto-created (Home / About stay yours).
 *
 * @param string $slug Post slug.
 */
function portdox_migration_skip_slug( $slug ) {
	$slug = sanitize_title( $slug );
	$skip = array( 'home', 'about' );
	return in_array( $slug, $skip, true );
}

/**
 * Create or reuse a page; returns post ID, or 0 on skip / failure.
 *
 * @param string $title     Page title.
 * @param string $slug      Desired slug.
 * @param int    $parent_id Parent page ID.
 */
function portdox_migration_ensure_page( $title, $slug, $parent_id = 0 ) {
	$slug = sanitize_title( $slug );
	if ( portdox_migration_skip_slug( $slug ) ) {
		return 0;
	}
	$parent_id = (int) $parent_id;
	$existing  = get_posts(
		array(
			'name'             => $slug,
			'post_type'        => 'page',
			'post_parent'      => $parent_id,
			'posts_per_page'   => 1,
			'post_status'      => array( 'publish', 'draft', 'pending', 'private', 'future' ),
			'suppress_filters' => true,
			'fields'           => 'ids',
		)
	);
	if ( ! empty( $existing ) ) {
		return (int) $existing[0];
	}
	$post_id = wp_insert_post(
		array(
			'post_title'  => $title,
			'post_name'   => $slug,
			'post_status' => 'publish',
			'post_type'   => 'page',
			'post_parent' => $parent_id,
		),
		true
	);
	if ( is_wp_error( $post_id ) ) {
		return 0;
	}
	return (int) $post_id;
}

/**
 * @param array<int, array<string, mixed>> $nodes     Tree nodes.
 * @param int                              $parent_id Parent page ID.
 * @return array{created:int, reused:int}
 */
function portdox_migration_walk_tree( $nodes, $parent_id = 0 ) {
	$created = 0;
	$reused  = 0;
	foreach ( $nodes as $node ) {
		if ( ! is_array( $node ) || empty( $node['slug'] ) || empty( $node['title'] ) ) {
			continue;
		}
		$slug = sanitize_title( $node['slug'] );
		if ( portdox_migration_skip_slug( $slug ) ) {
			continue;
		}
		$before = get_posts(
			array(
				'name'             => $slug,
				'post_type'        => 'page',
				'post_parent'      => (int) $parent_id,
				'posts_per_page'   => 1,
				'post_status'      => array( 'publish', 'draft', 'pending', 'private', 'future' ),
				'suppress_filters' => true,
				'fields'           => 'ids',
			)
		);
		$pid = portdox_migration_ensure_page( $node['title'], $slug, $parent_id );
		if ( ! $pid ) {
			continue;
		}
		if ( ! empty( $node['page_template'] ) && is_string( $node['page_template'] ) ) {
			$tpl = $node['page_template'];
			if ( locate_template( array( $tpl ) ) ) {
				update_post_meta( $pid, '_wp_page_template', $tpl );
			}
		}
		if ( ! empty( $before ) ) {
			$reused++;
		} else {
			$created++;
		}
		if ( ! empty( $node['children'] ) && is_array( $node['children'] ) ) {
			$sub = portdox_migration_walk_tree( $node['children'], $pid );
			$created += $sub['created'];
			$reused  += $sub['reused'];
		}
	}
	return array(
		'created' => $created,
		'reused'  => $reused,
	);
}

/**
 * One-time style migration: ?action22=create_pages (must be logged in as administrator).
 */
add_action(
	'init',
	function () {
		if ( ! isset( $_GET['action22'] ) || 'create_pages' !== $_GET['action22'] ) {
			return;
		}
		if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to run this action.', 'portdox_theme' ), '', array( 'response' => 403 ) );
		}

		$tree = portdox_migration_menu_page_tree();
		$stat = portdox_migration_walk_tree( $tree, 0 );

		set_transient(
			'portdox_migration_notice',
			sprintf(
				/* translators: 1: new pages count, 2: existing pages matched count */
				__( 'Portdox migration: %1$d new pages created, %2$d already existed (skipped). Assign templates under Pages → Edit.', 'portdox_theme' ),
				(int) $stat['created'],
				(int) $stat['reused']
			),
			120
		);

		wp_safe_redirect( admin_url( 'edit.php?post_type=page' ) );
		exit;
	},
	1
);

add_action(
	'admin_notices',
	function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$msg = get_transient( 'portdox_migration_notice' );
		if ( ! is_string( $msg ) || '' === $msg ) {
			return;
		}
		delete_transient( 'portdox_migration_notice' );
		printf(
			'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
			esc_html( $msg )
		);
	}
);

/**
 * Comment reply script when threading is enabled.
 */
function portdox_enqueue_comment_reply() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'portdox_enqueue_comment_reply' );

/**
 * Markup for each comment (matches static blog-details "comment-one" blocks).
 *
 * @param WP_Comment $comment Comment object.
 * @param array      $args    Arguments.
 * @param int        $depth   Nesting depth.
 */
function portdox_comment_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( in_array( $comment->comment_type, array( 'pingback', 'trackback' ), true ) ) {
		?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
		<div class="comment-one__single">
			<div class="comment-one__single-inner">
				<p class="portdox-pingback"><?php echo get_comment_author_link( $comment ); ?></p>
			</div>
		</div>
	</li>
		<?php
		return;
	}
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent', $comment ); ?>>
		<div class="comment-one__single<?php echo (int) $depth > 1 ? ' style2' : ''; ?>">
			<div class="comment-one__single-inner">
				<div class="comment-one__img">
					<?php echo get_avatar( $comment, (int) $args['avatar_size'] ); ?>
				</div>
				<div class="comment-one__content">
					<div class="comment-one__content-title">
						<h2><?php echo get_comment_author_link( $comment ); ?></h2>
						<p><?php echo esc_html( get_comment_date( '', $comment ) ); ?></p>
					</div>
					<div class="comment-text entry-content">
						<?php comment_text(); ?>
					</div>
					<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'    => '<div class="btn-box">',
								'after'     => '</div>',
							)
						),
						$comment
					);
					?>
				</div>
			</div>
		</div>
	</li>
	<?php
}

/**
 * Put the comment textarea after name/email (WordPress defaults to textarea first).
 *
 * @param array $fields Field HTML keyed by field name.
 * @return array
 */
function portdox_comment_form_fields_order( $fields ) {
	if ( isset( $fields['comment'] ) ) {
		$c = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $c;
	}
	return $fields;
}

/**
 * Theme field markup for the comment form.
 *
 * @param array $fields Default fields.
 * @return array
 */
function portdox_comment_form_default_fields( $fields ) {
	$req       = get_option( 'require_name_email' );
	$commenter = wp_get_current_commenter();
	$html5     = current_theme_supports( 'html5', 'comment-form' );
	$req_attr = $html5 ? ' required="required"' : ' required="required"';

	$label_name = __( 'Name', 'portdox_theme' );
	if ( $req ) {
		$label_name .= ' ' . wp_required_field_indicator();
	}
	$label_email = __( 'Email', 'portdox_theme' );
	if ( $req ) {
		$label_email .= ' ' . wp_required_field_indicator();
	}

	$fields['author'] = sprintf(
		'<div class="col-xl-6 col-lg-6 col-md-6"><div class="comment-form-author input-box"><label for="author" class="screen-reader-text">%1$s</label><input id="author" name="author" type="text" value="%2$s" size="30" placeholder="%3$s"%4$s /><div class="icon"><span class="icon-user"></span></div></div></div>',
		wp_kses_post( $label_name ),
		esc_attr( $commenter['comment_author'] ),
		esc_attr( $req ? __( 'Name *', 'portdox_theme' ) : __( 'Name', 'portdox_theme' ) ),
		$req ? $req_attr : ''
	);

	$fields['email'] = sprintf(
		'<div class="col-xl-6 col-lg-6 col-md-6"><div class="comment-form-email input-box"><label for="email" class="screen-reader-text">%1$s</label><input id="email" name="email" type="email" value="%2$s" size="30" placeholder="%3$s"%4$s /><div class="icon"><span class="icon-email"></span></div></div></div>',
		wp_kses_post( $label_email ),
		esc_attr( $commenter['comment_author_email'] ),
		esc_attr( $req ? __( 'Email *', 'portdox_theme' ) : __( 'Email', 'portdox_theme' ) ),
		$req ? $req_attr : ''
	);

	unset( $fields['url'] );

	if ( isset( $fields['cookies'] ) ) {
		$fields['cookies'] = '<div class="col-xl-12 portdox-comment-cookies">' . $fields['cookies'] . '</div>';
	}

	return $fields;
}

/**
 * Match theme blog comment form: title box, Bootstrap row, submit button style.
 *
 * @param array $defaults Defaults.
 * @return array
 */
function portdox_comment_form_defaults( $defaults ) {
	$defaults['title_reply_before'] = '<div class="title-box"><h3 id="reply-title" class="comment-reply-title">';
	$defaults['title_reply_after']  = '</h3><p>' . esc_html__( 'Your email address will not be published. Required fields are marked *', 'portdox_theme' ) . '</p></div>';

	$defaults['class_form']   = 'why-choose-one__form portdox-wp-comment-form row';
	$defaults['class_submit'] = 'submit';

	$defaults['comment_notes_before'] = '<div class="row">';
	$defaults['comment_notes_after']  = '';
	$label_comment = __( 'Comment', 'portdox_theme' ) . ' ' . wp_required_field_indicator();
	$defaults['comment_field']        = sprintf(
		'<div class="col-xl-12"><div class="comment-form-comment input-box"><label for="comment" class="screen-reader-text">%1$s</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" placeholder="%2$s"></textarea><div class="icon style2"><span class="icon-pen"></span></div></div></div>',
		wp_kses_post( $label_comment ),
		esc_attr__( 'Your comment…', 'portdox_theme' )
	);

	$defaults['submit_field'] = '<div class="col-xl-12"><div class="why-choose-one__form-btn">%1$s</div>%2$s</div></div>';

	return $defaults;
}

/**
 * Primary-style submit control (thm-btn + hover spans).
 *
 * @param string $button Markup (unused).
 * @param array  $args   Arguments from comment_form().
 * @return string
 */
function portdox_comment_form_submit_button( $button, $args ) {
	return sprintf(
		'<button type="submit" name="%1$s" id="%2$s" class="%3$s thm-btn portdox-comment-submit" value="1">%4$s<i class="icon-right-arrow21"></i><span class="hover-btn hover-bx"></span><span class="hover-btn hover-bx2"></span><span class="hover-btn hover-bx3"></span><span class="hover-btn hover-bx4"></span></button>',
		esc_attr( $args['name_submit'] ),
		esc_attr( $args['id_submit'] ),
		esc_attr( $args['class_submit'] ),
		esc_html( $args['label_submit'] )
	);
}

/**
 * Registers comment_form filters, prints form, removes filters.
 */
function portdox_render_comment_form() {
	add_filter( 'comment_form_default_fields', 'portdox_comment_form_default_fields' );
	add_filter( 'comment_form_defaults', 'portdox_comment_form_defaults' );
	add_filter( 'comment_form_fields', 'portdox_comment_form_fields_order' );
	add_filter( 'comment_form_submit_button', 'portdox_comment_form_submit_button', 10, 2 );
	comment_form();
	remove_filter( 'comment_form_default_fields', 'portdox_comment_form_default_fields' );
	remove_filter( 'comment_form_defaults', 'portdox_comment_form_defaults' );
	remove_filter( 'comment_form_fields', 'portdox_comment_form_fields_order' );
	remove_filter( 'comment_form_submit_button', 'portdox_comment_form_submit_button', 10, 2 );
}
