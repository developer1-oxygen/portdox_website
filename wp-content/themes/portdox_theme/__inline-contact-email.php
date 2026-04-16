<?php
/**
 * Inline mailto link for current Theme Settings email (optional [brackets] around label).
 * Set $portdox_mailto_brackets = true before include for [email] style.
 *
 * @package Portdox_Theme
 */

$portdox_em = function_exists( 'portdox_get_contact_email' ) ? portdox_get_contact_email() : 'info2@portdox.com';
$portdox_mailto_href = 'mailto:' . $portdox_em;
$portdox_href_out    = function_exists( 'esc_url' )
	? esc_url( $portdox_mailto_href )
	: htmlspecialchars( $portdox_mailto_href, ENT_QUOTES, 'UTF-8' );
$portdox_em_out      = function_exists( 'esc_html' ) ? esc_html( $portdox_em ) : htmlspecialchars( $portdox_em, ENT_QUOTES, 'UTF-8' );
$portdox_bracket     = ! empty( $portdox_mailto_brackets );

if ( $portdox_bracket ) {
	printf( '<a href="%s">[%s]</a>', $portdox_href_out, $portdox_em_out );
} else {
	printf( '<a href="%s">%s</a>', $portdox_href_out, $portdox_em_out );
}

unset( $portdox_mailto_brackets );
