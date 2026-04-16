<?php
/**
 * Service sidebar: contact banner image (ACF Theme Settings when WordPress helpers exist).
 *
 * @package Portdox_Theme
 */

$portdox_fallback_rel = 'assets/images/resources/service-details-sidebar-img3.png';
$portdox_img_src      = $portdox_fallback_rel;

if ( function_exists( 'portdox_get_service_sidebar_banner_url' ) ) {
	$portdox_banner = portdox_get_service_sidebar_banner_url();
	if ( '' !== $portdox_banner ) {
		$portdox_img_src = $portdox_banner;
	} elseif ( function_exists( 'get_template_directory_uri' ) ) {
		$portdox_img_src = get_template_directory_uri() . '/' . $portdox_fallback_rel;
	}
} elseif ( function_exists( 'get_template_directory_uri' ) ) {
	$portdox_img_src = get_template_directory_uri() . '/' . $portdox_fallback_rel;
}

$portdox_img_style = 'width: 300px;';

if ( function_exists( 'esc_attr' ) ) {
	$portdox_img_esc   = esc_attr( $portdox_img_src );
	$portdox_style_esc = esc_attr( $portdox_img_style );
} else {
	$portdox_img_esc   = htmlspecialchars( (string) $portdox_img_src, ENT_QUOTES, 'UTF-8' );
	$portdox_style_esc = htmlspecialchars( $portdox_img_style, ENT_QUOTES, 'UTF-8' );
}
?>
                                <div class="service-details__sidebar-contact-img">
                                    <div class="inner">
                                        <img src="<?php echo $portdox_img_esc; ?>" style="<?php echo $portdox_style_esc; ?>" alt="">
                                    </div>
                                </div>
