<?php
/**
 * ACF options: service sidebar banner, phone, download block (Theme Settings).
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register options page and fields when ACF is available.
 */
function portdox_acf_register_theme_options() {
	if ( ! function_exists( 'acf_add_options_page' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => __( 'Portdox Theme Settings', 'portdox_theme' ),
			'menu_title' => __( 'Theme Settings', 'portdox_theme' ),
			'menu_slug'  => 'portdox-theme-settings',
			'capability' => 'edit_theme_options',
			'redirect'   => false,
			'position'   => 61,
			'icon_url'   => 'dashicons-admin-customizer',
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_portdox_theme_service_sidebar',
			'title'                 => __( 'Service pages — left sidebar', 'portdox_theme' ),
			'fields'                => array(
				array(
					'key'           => 'field_portdox_service_banner',
					'label'         => __( 'Contact box image (banner)', 'portdox_theme' ),
					'name'          => 'portdox_service_sidebar_banner',
					'type'          => 'image',
					'instructions'  => __( 'Image above the phone number on service-style templates (Track Transport, Ocean, etc.).', 'portdox_theme' ),
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'          => 'field_portdox_service_phone',
					'label'        => __( 'Phone number (display text)', 'portdox_theme' ),
					'name'         => 'portdox_service_sidebar_phone',
					'type'         => 'text',
					'default_value' => '180 123 456 789',
					'placeholder'  => '180 123 456 789',
				),
				array(
					'key'             => 'field_portdox_service_phone_tel',
					'label'           => __( 'Phone (tap-to-call / tel: link)', 'portdox_theme' ),
					'name'            => 'portdox_service_sidebar_phone_tel',
					'type'            => 'text',
					'instructions'    => __( 'Optional. Digits and + only, e.g. +180123456789. If empty, numbers are taken from the display text above.', 'portdox_theme' ),
					'placeholder'     => '+180123456789',
				),
				array(
					'key'   => 'field_portdox_dl_tab',
					'label' => __( 'Download box', 'portdox_theme' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_portdox_download_heading',
					'label'         => __( 'Section title', 'portdox_theme' ),
					'name'          => 'portdox_download_heading',
					'type'          => 'text',
					'default_value' => 'Download',
				),
				array(
					'key'           => 'field_portdox_download_title',
					'label'         => __( 'Main link text', 'portdox_theme' ),
					'name'          => 'portdox_download_title',
					'type'          => 'text',
					'default_value' => 'Pdf Download',
				),
				array(
					'key'           => 'field_portdox_download_subtitle',
					'label'         => __( 'Secondary link text', 'portdox_theme' ),
					'name'          => 'portdox_download_subtitle',
					'type'          => 'text',
					'default_value' => 'Download',
				),
				array(
					'key'           => 'field_portdox_download_file',
					'label'         => __( 'PDF or file URL', 'portdox_theme' ),
					'name'          => 'portdox_download_file',
					'type'          => 'url',
					'instructions'  => __( 'Used for all download links in the sidebar. Leave empty to use #.', 'portdox_theme' ),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/portdox-about.php',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_portdox_theme_site_contact',
			'title'                 => __( 'Header & footer — email & address', 'portdox_theme' ),
			'fields'                => array(
				array(
					'key'           => 'field_portdox_contact_email',
					'label'         => __( 'Contact email', 'portdox_theme' ),
					'name'          => 'portdox_contact_email',
					'type'          => 'email',
					'default_value' => 'info2@portdox.com',
					'instructions'  => __( 'Shown in the header, footer, and contact page.', 'portdox_theme' ),
				),
				array(
					'key'           => 'field_portdox_contact_address',
					'label'         => __( 'Address', 'portdox_theme' ),
					'name'          => 'portdox_contact_address',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => "3060 Commercial Street Road\nFratton, USA",
					'instructions'  => __( 'Use line breaks between lines (e.g. street, then city/country).', 'portdox_theme' ),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'portdox-theme-settings',
					),
				),
			),
			'menu_order'            => 1,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_portdox_theme_logos',
			'title'                 => __( 'Brand logos', 'portdox_theme' ),
			'fields'                => array(
				array(
					'key'           => 'field_portdox_logo_header_white',
					'label'         => __( 'Header logo (white)', 'portdox_theme' ),
					'name'          => 'portdox_logo_header_white',
					'type'          => 'image',
					'instructions'  => __( 'Used in top header and mobile menu.', 'portdox_theme' ),
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'           => 'field_portdox_logo_footer_colored',
					'label'         => __( 'Footer logo (colored)', 'portdox_theme' ),
					'name'          => 'portdox_logo_footer_colored',
					'type'          => 'image',
					'instructions'  => __( 'Used in footer logo area.', 'portdox_theme' ),
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'portdox-theme-settings',
					),
				),
			),
			'menu_order'            => 2,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_portdox_theme_about_section',
			'title'                 => __( 'About page — “Our Expertise” block', 'portdox_theme' ),
			'fields'                => array(
				array(
					'key'           => 'field_portdox_about_tagline',
					'label'         => __( 'Small heading (tagline)', 'portdox_theme' ),
					'name'          => 'portdox_about_tagline',
					'type'          => 'text',
					'default_value' => 'Our Company',
				),
				array(
					'key'           => 'field_portdox_about_title_line1',
					'label'         => __( 'Main heading – first line', 'portdox_theme' ),
					'name'          => 'portdox_about_title_line1',
					'type'          => 'text',
					'default_value' => 'Our Expertise Stands in',
				),
				array(
					'key'           => 'field_portdox_about_title_highlight',
					'label'         => __( 'Main heading – highlighted text', 'portdox_theme' ),
					'name'          => 'portdox_about_title_highlight',
					'type'          => 'text',
					'default_value' => 'Logistics Solutions',
				),
				array(
					'key'           => 'field_portdox_about_intro',
					'label'         => __( 'Intro paragraph', 'portdox_theme' ),
					'name'          => 'portdox_about_intro',
					'type'          => 'textarea',
					'rows'          => 4,
					'default_value' => "Logistic service provider company plays a pivotal role in the global supply\nchain ecosystem by efficiently managing the movement of goods from origin to final\ndestination. These companies offer a diverse.",
				),
				array(
					'key'   => 'field_portdox_about_features_tab',
					'label' => __( 'Feature columns', 'portdox_theme' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_portdox_about_feature1_title',
					'label'         => __( 'Left feature title', 'portdox_theme' ),
					'name'          => 'portdox_about_feature1_title',
					'type'          => 'text',
					'default_value' => 'Worldwide Service',
				),
				array(
					'key'           => 'field_portdox_about_feature1_text',
					'label'         => __( 'Left feature text', 'portdox_theme' ),
					'name'          => 'portdox_about_feature1_text',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Logistic service provider company plays a pivotal role in the global',
				),
				array(
					'key'           => 'field_portdox_about_feature2_title',
					'label'         => __( 'Right feature title', 'portdox_theme' ),
					'name'          => 'portdox_about_feature2_title',
					'type'          => 'text',
					'default_value' => '24/7 Online Support',
				),
				array(
					'key'           => 'field_portdox_about_feature2_text',
					'label'         => __( 'Right feature text', 'portdox_theme' ),
					'name'          => 'portdox_about_feature2_text',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Logistic service provider company plays a pivotal role in the global',
				),
				array(
					'key'   => 'field_portdox_about_images_tab',
					'label' => __( 'Images', 'portdox_theme' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_portdox_about_image_main',
					'label'         => __( 'Main image', 'portdox_theme' ),
					'name'          => 'portdox_about_image_main',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'           => 'field_portdox_about_image_secondary',
					'label'         => __( 'Secondary image', 'portdox_theme' ),
					'name'          => 'portdox_about_image_secondary',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'portdox-theme-settings',
					),
				),
			),
			'menu_order'            => 3,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}
add_action( 'acf/init', 'portdox_acf_register_theme_options' );

/**
 * @return string Banner image URL or empty to use theme default.
 */
function portdox_get_service_sidebar_banner_url() {
	if ( function_exists( 'get_field' ) ) {
		$img = get_field( 'portdox_service_sidebar_banner', 'option' );
		if ( is_array( $img ) && ! empty( $img['url'] ) ) {
			return (string) $img['url'];
		}
		if ( is_numeric( $img ) ) {
			$url = wp_get_attachment_image_url( (int) $img, 'full' );
			return $url ? (string) $url : '';
		}
	}
	return '';
}

/**
 * @return string
 */
function portdox_get_service_sidebar_phone_display() {
	if ( function_exists( 'get_field' ) ) {
		$t = get_field( 'portdox_service_sidebar_phone', 'option' );
		if ( is_string( $t ) && '' !== trim( $t ) ) {
			return $t;
		}
	}
	return '180 123 456 789';
}

/**
 * Digits and leading + for tel: href.
 *
 * @return string
 */
function portdox_get_service_sidebar_phone_tel() {
	if ( function_exists( 'get_field' ) ) {
		$tel = get_field( 'portdox_service_sidebar_phone_tel', 'option' );
		if ( is_string( $tel ) && '' !== trim( $tel ) ) {
			return portdox_sanitize_tel_href( $tel );
		}
	}
	return portdox_sanitize_tel_href( portdox_get_service_sidebar_phone_display() );
}

/**
 * @param string $raw User-entered phone.
 * @return string
 */
function portdox_sanitize_tel_href( $raw ) {
	$raw = (string) $raw;
	if ( '' === $raw ) {
		return '';
	}
	$out   = '';
	$len   = strlen( $raw );
	$start = 0;
	if ( '+' === $raw[0] ) {
		$out  = '+';
		$start = 1;
	}
	for ( $i = $start; $i < $len; $i++ ) {
		$c = $raw[ $i ];
		if ( $c >= '0' && $c <= '9' ) {
			$out .= $c;
		}
	}
	return $out;
}

/**
 * @return string
 */
function portdox_get_download_heading() {
	if ( function_exists( 'get_field' ) ) {
		$t = get_field( 'portdox_download_heading', 'option' );
		if ( is_string( $t ) && '' !== trim( $t ) ) {
			return $t;
		}
	}
	return 'Download';
}

/**
 * @return string
 */
function portdox_get_download_title_text() {
	if ( function_exists( 'get_field' ) ) {
		$t = get_field( 'portdox_download_title', 'option' );
		if ( is_string( $t ) && '' !== trim( $t ) ) {
			return $t;
		}
	}
	return 'Pdf Download';
}

/**
 * @return string
 */
function portdox_get_download_subtitle_text() {
	if ( function_exists( 'get_field' ) ) {
		$t = get_field( 'portdox_download_subtitle', 'option' );
		if ( is_string( $t ) && '' !== trim( $t ) ) {
			return $t;
		}
	}
	return 'Download';
}

/**
 * @return string URL or "#".
 */
function portdox_get_download_file_url() {
	if ( function_exists( 'get_field' ) ) {
		$url = get_field( 'portdox_download_file', 'option' );
		if ( is_string( $url ) && '' !== trim( $url ) ) {
			return $url;
		}
	}
	return '#';
}

/**
 * Contact email (header, footer, contact page).
 *
 * @return string
 */
function portdox_get_contact_email() {
	$fallback = 'info2@portdox.com';
	if ( function_exists( 'get_field' ) ) {
		$e = get_field( 'portdox_contact_email', 'option' );
		if ( is_string( $e ) && '' !== trim( $e ) ) {
			$san = sanitize_email( trim( $e ) );
			return '' !== $san ? $san : $fallback;
		}
	}
	return $fallback;
}

/**
 * Plain-text address with line breaks from Theme Settings.
 *
 * @return string
 */
function portdox_get_contact_address() {
	$fallback = "3060 Commercial Street Road\nFratton, USA";
	if ( function_exists( 'get_field' ) ) {
		$a = get_field( 'portdox_contact_address', 'option' );
		if ( is_string( $a ) && '' !== trim( $a ) ) {
			return $a;
		}
	}
	return $fallback;
}

/**
 * Address safe for output inside a block (br between lines).
 *
 * @return string
 */
function portdox_get_contact_address_html() {
	return wp_kses_post( nl2br( esc_html( portdox_get_contact_address() ) ) );
}

/**
 * Logo URL from options image field (array/id/url). Falls back to default asset.
 *
 * @param string $field_name ACF options field name.
 * @param string $fallback   Relative fallback path in theme.
 * @return string
 */
function portdox_get_logo_url_from_option( $field_name, $fallback ) {
	if ( function_exists( 'get_field' ) ) {
		$img = get_field( $field_name, 'option' );
		if ( is_array( $img ) && ! empty( $img['url'] ) ) {
			return (string) $img['url'];
		}
		if ( is_numeric( $img ) ) {
			$url = wp_get_attachment_image_url( (int) $img, 'full' );
			if ( $url ) {
				return (string) $url;
			}
		}
		if ( is_string( $img ) && '' !== trim( $img ) ) {
			return $img;
		}
	}
	return get_template_directory_uri() . '/' . ltrim( $fallback, '/' );
}

/**
 * @return string Header white logo URL.
 */
function portdox_get_header_logo_url() {
	return portdox_get_logo_url_from_option( 'portdox_logo_header_white', 'assets/images/resources/logo-1.png' );
}

/**
 * @return string Footer colored logo URL.
 */
function portdox_get_footer_logo_url() {
	return portdox_get_logo_url_from_option( 'portdox_logo_footer_colored', 'assets/images/resources/footer-logo.png' );
}

/**
 * Warn when ACF is active without Pro options (Theme Settings screen is ACF Pro).
 */
function portdox_acf_theme_settings_admin_notice() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	if ( function_exists( 'acf_add_options_page' ) ) {
		return;
	}
	if ( ! function_exists( 'acf_get_setting' ) ) {
		return;
	}
	printf(
		'<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
		esc_html__( 'Portdox: sidebar Theme Settings need ACF PRO (Options Page). Without it, service sidebars use built-in defaults until you activate ACF Pro.', 'portdox_theme' )
	);
}
add_action( 'admin_notices', 'portdox_acf_theme_settings_admin_notice' );
