<?php
/**
 * Template Name: Portdox Open API
 * Description: Portdox Open API — integrate and extend the platform.
 * Assign to the Page whose slug is "portdox-open-api".
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
        .sec_heading{ font-size:36px !important }
        .fix_marge{ margin-top:45px !important;margin-bottom:45px !important }
        .sec_heading_small{ font-size:26px; margin-top:15px; margin-bottom:15px }
        .inner_feature{ margin-top:25px; }
</style>
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_a ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
            </div>
            <div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
            <div class="container" >
                <div class="page-header__inner" style="max-width: 500px;">
                    <h2><?php echo esc_html( get_the_title() ?: __( 'Portdox Open API', 'portdox_theme' ) ); ?></h2>
                </div>
                <div style="max-width: 500px; color: #fff; padding: 10px;">
                   <?php esc_html_e( 'The Portdox Open API serves as your bridge to a unified, efficient, and integrated logistics technology ecosystem.', 'portdox_theme' ); ?>
                </div>
                <div style="max-width: 500px; color: #fff; padding: 10px;">
                   <?php esc_html_e( 'It’s more than just connecting different technologies; it’s about building a supply chain that’s faster, more agile, highly collaborative, and dedicated to delivering exceptional value to your customers.', 'portdox_theme' ); ?>
                </div>
            </div>
        </section>

        <section class="about-one" style="padding-top:15px">

                <div class="container">
                    <div class="row fix_marge ">
                        <div class="col-xl-8 container">
                            <div class="team-details__top-content">
                                <div class="title-box">
                                    <h2 class="sec_heading"><?php esc_html_e( 'Unify Your Systems with the Portdox Open API', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p>
                                    <?php esc_html_e( 'Seamlessly integrate your systems and more with the Portdox Open API.', 'portdox_theme' ); ?>
                                    </p><p>
                                    <?php esc_html_e( 'Built as a collection of web services, the API is compatible with all major programming languages, empowering you to synchronize your tech stack and ensure all stakeholders stay aligned and informed.', 'portdox_theme' ); ?>
                                     </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="team-details__top-img">
                                <div class="inner">
                                    <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/805.jpg" alt="" style="width:100%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" dark_row_padding" >
                    <div class="container">
                        <div class="row fix_marge">
                            <div class="col-xl-4">
                                <div class="title-box">
                                    <div class="inner"></div>
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Connect Your Ecosystem', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p style="text-align: justify;">
                                    <?php esc_html_e( 'Link carriers, customs, accounting, e-commerce, and internal tools through documented endpoints so data flows consistently across your operation.', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="title-box">
                                    <div class="inner"></div>
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Developer-Friendly', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p style="text-align: justify;">
                                    <?php esc_html_e( 'Use the languages and frameworks your team already knows. Standard web-service patterns make it straightforward to build, test, and maintain integrations.', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="title-box">
                                    <div class="inner"></div>
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Secure, Controlled Access', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p style="text-align: justify;">
                                    <?php esc_html_e( 'Authenticated access and consistent contracts help partners and systems exchange data safely while you stay in control of what is shared.', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </section>
<?php
get_footer();
