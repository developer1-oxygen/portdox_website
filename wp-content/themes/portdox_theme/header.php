<?php
/**
 * Theme header: head, preloader, primary nav, sticky bar.
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<!-- Start Preloader -->
	<?php load_template( get_template_directory() . '/__loader_icon.php', false ); ?>

	<!-- End Preloader -->

	<div class="page-wrapper">

		<?php load_template( get_template_directory() . '/__nav.php', false ); ?>

		<!--End Main Header One-->

		<div class="stricky-header stricky-header--style1 stricked-menu main-menu">
			<div class="sticky-header__content"></div><!-- /.sticky-header__content -->
		</div><!-- /.stricky-header -->
