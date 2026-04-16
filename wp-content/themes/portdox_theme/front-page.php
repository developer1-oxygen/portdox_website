<?php
/**
 * Site front page. WordPress prefers this file for the homepage whenever it exists
 * (Reading: “Your latest posts” or a static front page).
 *
 * @package Portdox_Theme
 */

get_header();
get_template_part( 'template', 'home' );
get_footer();
