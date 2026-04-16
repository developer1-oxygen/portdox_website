<?php
/**
 * Service template sidebar: contact image + phone (values from Theme Settings / ACF options).
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portdox_phone  = portdox_get_service_sidebar_phone_display();
$portdox_tel    = portdox_get_service_sidebar_phone_tel();
$portdox_href   = '' !== $portdox_tel ? 'tel:' . $portdox_tel : '#';
?>
                            <div class="service-details__sidebar-contact text-center">
                                <?php include get_template_directory() . '/__service-sidebar-contact-img.php'; ?>

                                <div class="service-details__sidebar-contact-content">
                                    <div class="icon">
                                        <span class="icon-phone"></span>
                                    </div>
                                    <h2><a href="<?php echo esc_url( $portdox_href ); ?>"><?php echo esc_html( $portdox_phone ); ?></a></h2>
                                    <h3><?php esc_html_e( 'If You Need Any Help', 'portdox_theme' ); ?> <br>
                                        <?php esc_html_e( 'Contact With Us', 'portdox_theme' ); ?></h3>
                                </div>
                            </div>
