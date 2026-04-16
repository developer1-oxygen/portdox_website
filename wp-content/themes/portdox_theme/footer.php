<?php
/**
 * Theme footer: site footer, mobile nav, search popup, scroll top, scripts.
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portdox_social = portdox_get_social_profile_urls();

?>

		<!--Start Footer One-->
		<?php load_template( get_template_directory() . '/__footer.php', false ); ?>
		<!--End Footer One-->

	</div><!-- /.page-wrapper -->


	<div class="mobile-nav__wrapper">
		<div class="mobile-nav__overlay mobile-nav__toggler"></div>
		<!-- /.mobile-nav__overlay -->
		<div class="mobile-nav__content">
			<span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

			<div class="logo-box">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="logo image"><img src="<?php echo esc_url( portdox_get_header_logo_url() ); ?>" width="150"
						alt="" /></a>
			</div>
			<!-- /.logo-box -->
			<div class="mobile-nav__container"></div>
			<!-- /.mobile-nav__container -->

			<ul class="mobile-nav__contact list-unstyled">
				<li>
					<i class="fa fa-envelope"></i>
					<a href="mailto:needhelp@logistiq.com">needhelp@logistiq.com</a>
				</li>
				<li>
					<i class="icon-phone"></i>
					<a href="tel:666-888-0000">666 888 0000</a>
				</li>
			</ul><!-- /.mobile-nav__contact -->
			<div class="mobile-nav__top">
				<div class="mobile-nav__social">
					<a href="<?php echo esc_url( $portdox_social['facebook'] ); ?>" class="fab fa-facebook-square" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'portdox_theme' ); ?>"></a>
					<a href="<?php echo esc_url( $portdox_social['instagram'] ); ?>" class="fab fa-instagram" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'portdox_theme' ); ?>"></a>
					<a href="<?php echo esc_url( $portdox_social['linkedin'] ); ?>" class="fab fa-linkedin-in" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'LinkedIn', 'portdox_theme' ); ?>"></a>
				</div><!-- /.mobile-nav__social -->
			</div><!-- /.mobile-nav__top -->



		</div>
		<!-- /.mobile-nav__content -->
	</div>
	<!-- /.mobile-nav__wrapper -->

	<div class="search-popup">
		<div class="search-popup__overlay search-toggler"></div>
		<!-- /.search-popup__overlay -->
		<div class="search-popup__content">
			<form action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label for="search" class="sr-only">search here</label><!-- /.sr-only -->
				<input type="text" id="search" name="s" placeholder="Search Here..." />
				<button type="submit" aria-label="search submit" class="thm-btn">
					<i class="fas fa-search"></i>
					<span class="hover-btn hover-bx"></span>
					<span class="hover-btn hover-bx2"></span>
					<span class="hover-btn hover-bx3"></span>
					<span class="hover-btn hover-bx4"></span>
				</button>
			</form>
		</div>
		<!-- /.search-popup__content -->
	</div>
	<!-- /.search-popup -->

	<a href="#" data-target="html" class="scroll-to-target scroll-to-top">
		<span class="scroll-to-top__wrapper"><span class="scroll-to-top__inner"></span></span>
		<span class="scroll-to-top__text"> Go Back Top</span>
	</a>

	<?php wp_footer(); ?>
</body>
</html>
