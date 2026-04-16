<?php
/**
 * Service sidebar download box (Theme Settings / ACF options).
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portdox_dl_href = portdox_get_download_file_url();
$portdox_dl_head = portdox_get_download_heading();
$portdox_dl_main = portdox_get_download_title_text();
$portdox_dl_sub  = portdox_get_download_subtitle_text();
?>
<div class="title-box">
    <h2><?php echo esc_html( $portdox_dl_head ); ?></h2>
</div>
<div class="service-details__sidebar-single-download">

    <ul class="clearfix">
        <li>
            <div class="content-box">
                <div class="icon">
                    <span class="icon-pdf"></span>
                </div>
                <div class="text-box">
                    <h2><a href="<?php echo esc_url( $portdox_dl_href ); ?>"><?php echo esc_html( $portdox_dl_main ); ?></a></h2>
                    <p><a href="<?php echo esc_url( $portdox_dl_href ); ?>"><?php echo esc_html( $portdox_dl_sub ); ?></a></p>
                </div>
            </div>

            <div class="btn-box">
                <a href="<?php echo esc_url( $portdox_dl_href ); ?>"><span class="icon-download"></span></a>
            </div>
        </li>

    </ul>
</div>
