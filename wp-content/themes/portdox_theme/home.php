<?php
/**
 * Blog posts index (e.g. when “Posts page” is set to a separate URL like /blog/).
 * Not used for the site front when front-page.php exists.
 *
 * @package Portdox_Theme
 */

get_header();
get_template_part( 'template', 'blog' );
get_footer();
