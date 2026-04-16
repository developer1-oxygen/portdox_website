<?php
/**
 * Request a Demo page layout (used by Portdox Request a Demo template and page-book-a-demo.php).
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portdox_a = get_template_directory_uri();
?>
<style type="text/css">
	.page-header__inner h2{ font-size:40px !important }
</style>
        <!--Start Page Header-->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_a ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
            </div>
            <div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
            <div class="container" >
                <div class="page-header__inner" style="max-width: 500px;">
                    <h2><?php echo esc_html( get_the_title() ?: __( 'Request a Demo', 'portdox_theme' ) ); ?></h2>
                </div>
                <div style="max-width: 500px; color: #fff; padding: 10px;">
                    <?php esc_html_e( 'See Portdox in action. Share your details and our team will schedule a walkthrough tailored to your operations.', 'portdox_theme' ); ?>
                </div>
            </div>
        </section>
        <!--End Page Header-->

        <!--Start Service Details-->
        <section class="service-details">
            <div class="container">
                <div class="row">
                    <!--Start Service Details Sidebar-->
                    <div class="col-xl-4">
                        <div class="service-details__sidebar">
                            <div class="service-details__sidebar-single">
                                <div class="title-box">
                                    <h2><?php esc_html_e( 'Our Service', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="service-details__sidebar-single-service">
                                    <ul class="clearfix">
                                        <li><a href="<?php echo esc_url( portdox_url_for_page_slug( 'international-transport' ) ); ?>"><?php esc_html_e( 'International Transport', 'portdox_theme' ); ?> <span
                                                    class="icon-right-arrow21"></span></a></li>

                                        <li><a href="<?php echo esc_url( portdox_url_for_page_slug( 'track-transport' ) ); ?>"><?php esc_html_e( 'Local Track Transport', 'portdox_theme' ); ?> <span
                                                    class="icon-right-arrow21"></span></a></li>

                                        <li><a href="<?php echo esc_url( portdox_url_for_page_slug( 'ocean-transport' ) ); ?>"><?php esc_html_e( 'Safe Ocean Transport', 'portdox_theme' ); ?> <span
                                                    class="icon-right-arrow21"></span></a></li>

                                        <li><a href="<?php echo esc_url( portdox_url_for_page_slug( 'warehouse-facility' ) ); ?>"><?php esc_html_e( 'Warehouse Facility', 'portdox_theme' ); ?> <span
                                                    class="icon-right-arrow21"></span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                             <div class="service-details__sidebar-single">
                                <?php include get_template_directory() . '/__download.php'; ?>
                            </div>

                            <?php include get_template_directory() . '/__service-sidebar-contact.php'; ?>
                        </div>
                    </div>
                    <!--End Service Details Sidebar-->

                    <!--Start Service Details Content-->
                    <div class="col-xl-8">
                        <div class="service-details__content">
                            <div class="service-details__content-img1">
                                <div class="inner">
                                    <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/services/service-details-img1.jpg" alt="">
                                </div>
                            </div>

                            <div class="service-details__content-text1">
                                <h2><?php esc_html_e( 'Book a personalized demo', 'portdox_theme' ); ?></h2>
                                <p><?php esc_html_e( 'Whether you run freight, warehousing, or end-to-end logistics, we will show you how Portdox fits your workflows—from quotes and bookings to visibility and billing.', 'portdox_theme' ); ?></p>
                            </div>

                            <div class="service-details__content-text2">
                                <h2><?php esc_html_e( 'Request your demo', 'portdox_theme' ); ?></h2>
                                <form class="contact-form-validated why-choose-one__form portdox-demo-form"
                                    action="#"
                                    method="post"
                                    novalidate="novalidate">

                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="input-box">
                                                <input type="text" name="demo_first_name" placeholder="<?php esc_attr_e( 'First Name', 'portdox_theme' ); ?>" required>
                                                <div class="icon"><span class="icon-user"></span></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="input-box">
                                                <input type="text" name="demo_last_name" placeholder="<?php esc_attr_e( 'Last Name', 'portdox_theme' ); ?>" required>
                                                <div class="icon"><span class="icon-user"></span></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="input-box">
                                                <input type="email" name="demo_email" placeholder="<?php esc_attr_e( 'Work Email', 'portdox_theme' ); ?>" required>
                                                <div class="icon"><span class="icon-email"></span></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="input-box">
                                                <input type="text" name="demo_phone" placeholder="<?php esc_attr_e( 'Phone', 'portdox_theme' ); ?>" required>
                                                <div class="icon"><span class="icon-phone2"></span></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="input-box">
                                                <input type="text" name="demo_company" placeholder="<?php esc_attr_e( 'Company', 'portdox_theme' ); ?>" required>
                                                <div class="icon"><span class="icon-address"></span></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="input-box">
                                                <input type="text" name="demo_country" placeholder="<?php esc_attr_e( 'Country', 'portdox_theme' ); ?>" required>
                                                <div class="icon"><span class="icon-plane2"></span></div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="why-choose-one__form-btn">
                                                <button type="submit" class="thm-btn">
                                                    <?php esc_html_e( 'Request a Demo', 'portdox_theme' ); ?>
                                                    <i class="icon-right-arrow21"></i>
                                                    <span class="hover-btn hover-bx"></span>
                                                    <span class="hover-btn hover-bx2"></span>
                                                    <span class="hover-btn hover-bx3"></span>
                                                    <span class="hover-btn hover-bx4"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Service Details Content-->
                </div>
            </div>
        </section>
        <!--End Service Details-->
