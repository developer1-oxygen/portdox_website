<?php
/**
 * Service CPT: Featured Image = single page; optional Listing / card image = grids & carousels only.
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Cropped size for service cards (home carousel, services listing). Regenerate thumbnails after deploy.
 */
function portdox_register_service_card_image_size() {
	add_image_size( 'portdox-service-card', 800, 520, true );
}
add_action( 'after_setup_theme', 'portdox_register_service_card_image_size' );

/**
 * Image URL for service cards only. Uses ACF "Listing / card image" if set, else Featured Image.
 *
 * @param int|null $post_id Post ID; default current post in loop.
 * @param string   $size    Registered size; prefer portdox-service-card for listings.
 * @return string URL or empty.
 */
function portdox_get_service_listing_image_url( $post_id = null, $size = 'portdox-service-card' ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	if ( ! $post_id ) {
		return '';
	}

	$attachment_id = 0;

	if ( function_exists( 'get_field' ) ) {
		$val = get_field( 'portdox_service_listing_image', $post_id );
		if ( is_numeric( $val ) ) {
			$attachment_id = (int) $val;
		} elseif ( is_array( $val ) && ! empty( $val['ID'] ) ) {
			$attachment_id = (int) $val['ID'];
		}
	}

	if ( ! $attachment_id ) {
		$raw = get_post_meta( $post_id, 'portdox_service_listing_image', true );
		if ( is_numeric( $raw ) ) {
			$attachment_id = (int) $raw;
		}
	}

	if ( $attachment_id && wp_attachment_is_image( $attachment_id ) ) {
		$url = wp_get_attachment_image_url( $attachment_id, $size );
		if ( $url ) {
			return $url;
		}
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );
		if ( $url ) {
			return $url;
		}
	}

	$url = get_the_post_thumbnail_url( $post_id, $size );
	if ( $url ) {
		return $url;
	}
	$url = get_the_post_thumbnail_url( $post_id, 'large' );

	return $url ? (string) $url : '';
}

/**
 * ACF field: listing image on Service edit screen.
 */
function portdox_acf_register_service_listing_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_portdox_service_images',
			'title'                 => __( 'Service images', 'portdox_theme' ),
			'fields'                => array(
				array(
					'key'           => 'field_portdox_service_listing_image',
					'label'         => __( 'Listing / card image', 'portdox_theme' ),
					'name'          => 'portdox_service_listing_image',
					'type'          => 'image',
					'instructions'  => __( 'Used only on home service carousel and services grid. Recommended wide crop (~800×520). Leave empty to fall back to the Featured Image there. Featured Image is used on the single service page.', 'portdox_theme' ),
					'required'      => 0,
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'portdox_service',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'side',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}
add_action( 'acf/init', 'portdox_acf_register_service_listing_field_group' );
