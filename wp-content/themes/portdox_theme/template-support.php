<?php
/**
 * Template Name: Portdox Support
 * Description: Support page (placeholder content; replace when ready).
 * Assign to the Page whose slug is "support".
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
$portdox_a = get_template_directory_uri();
?>
<style type="text/css">
		.page-header__inner h2{ font-size:40px !important }
</style>
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_a ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
            </div>
            <div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
            <div class="container">
                <div class="page-header__inner" style="max-width: 500px;">
                    <h2><?php echo esc_html( get_the_title() ?: __( 'Support', 'portdox_theme' ) ); ?></h2>
                </div>
                <div style="max-width: 500px; color: #fff; padding: 10px;">
                    <?php esc_html_e( 'We are preparing dedicated support resources for you. For immediate help, please reach out through our contact page.', 'portdox_theme' ); ?>
                </div>
            </div>
        </section>

        <section class="about-one">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="about-one__content">
                            <div class="sec-title tg-heading-subheading animation-style2">
                                <div class="sec-title__tagline">
                                    <div class="line"></div>
                                    <div class="icon">
                                        <span class="icon-plane2 float-bob-x3"></span>
                                    </div>
                                </div>
                                <h2 class="sec-title__title tg-element-title"><?php esc_html_e( 'Coming Soon', 'portdox_theme' ); ?></h2>
                                <p class="mt-4" style="max-width: 640px; margin-left: auto; margin-right: auto;">
                                    <a class="thm-btn" href="<?php echo esc_url( portdox_url_for_page_slug( 'contact' ) ); ?>">
                                        <?php esc_html_e( 'Contact us', 'portdox_theme' ); ?>
                                        <i class="icon-right-arrow21"></i>
                                        <span class="hover-btn hover-bx"></span>
                                        <span class="hover-btn hover-bx2"></span>
                                        <span class="hover-btn hover-bx3"></span>
                                        <span class="hover-btn hover-bx4"></span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php
get_footer();
