<?php
/**
 * Footer “Get in touch”: address + email list items (Theme Settings when WordPress is loaded).
 *
 * @package Portdox_Theme
 */

$portdox_fe    = function_exists( 'portdox_get_contact_email' ) ? portdox_get_contact_email() : 'info2@portdox.com';
$portdox_fa    = function_exists( 'portdox_get_contact_address_html' ) ? portdox_get_contact_address_html() : '3060 Commercial Street Road <br> Fratton, USA';
$portdox_mhref = 'mailto:' . $portdox_fe;
$portdox_h     = function_exists( 'esc_html' ) ? esc_html( $portdox_fe ) : htmlspecialchars( $portdox_fe, ENT_QUOTES, 'UTF-8' );
$portdox_u     = function_exists( 'esc_url' )
	? esc_url( $portdox_mhref )
	: htmlspecialchars( $portdox_mhref, ENT_QUOTES, 'UTF-8' );
?>
                                            <li>
                                                <div class="icon">
                                                    <span class="icon-address"></span>
                                                </div>
                                                <div class="text-box">
                                                    <p><?php echo $portdox_fa; ?></p>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="icon">
                                                    <span class="icon-email"></span>
                                                </div>
                                                <div class="text-box">
                                                    <p><a href="<?php echo $portdox_u; ?>"><?php echo $portdox_h; ?></a></p>
                                                </div>
                                            </li>
