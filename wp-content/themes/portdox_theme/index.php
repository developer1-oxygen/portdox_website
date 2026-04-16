<?php
/**
 * Main template file.
 *
 * @package Portdox_Theme
 */

get_header();
echo '<div style="max-width:1300px; margin:50px auto;">';
if ( is_front_page() ) {
	get_template_part( 'template', 'home' );
} elseif ( have_posts() ) {
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
}
echo '</div>';

get_footer();
