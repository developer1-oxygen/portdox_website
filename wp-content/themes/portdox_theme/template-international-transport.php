<?php
/**
 * Template Name: Portdox International Transport
 * Description: International transport service page (all markup in this file).
 * Assign to the Page whose slug is "international-transport" (or any title you prefer).
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
        <!--Start Page Header-->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_a ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
            </div>
            <div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
            <div class="container" >
                <div class="page-header__inner" style="max-width: 500px;">
                    <h2><?php echo esc_html( get_the_title() ?: __( 'International Transport', 'portdox_theme' ) ); ?></h2>
                </div>
                <div style="max-width: 500px; color: #fff; padding: 10px;">
                    <?php esc_html_e( 'Cross-border freight and logistics with the reliability your global customers expect.', 'portdox_theme' ); ?>
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
                                        <li><a class="active" href="<?php echo esc_url( portdox_url_for_page_slug( 'international-transport' ) ); ?>"><?php esc_html_e( 'International Transport', 'portdox_theme' ); ?> <span
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
                                    <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/services/service-details-img5.jpg" alt="">
                                </div>
                            </div>

                            <div class="service-details__content-text1">
                                <h2><?php esc_html_e( 'International Transport', 'portdox_theme' ); ?></h2>
                                <p><?php esc_html_e( 'As a premier international transport service provider, we specialize in seamlessly connecting businesses and individuals with efficient and reliable transportation solutions across borders. Whether it\'s shipping goods or facilitating the travel of individuals.', 'portdox_theme' ); ?></p>
                            </div>

                            <div class="service-details__content-text2">
                                <h2><?php esc_html_e( 'Why You Choose This Effective Service', 'portdox_theme' ); ?></h2>
                                <p><?php esc_html_e( 'With a focus on safety, efficiency, and cost-effectiveness, we offer a range of tailored services to meet the unique needs of our clients, from air and sea freight to road transportation. Our dedicated team of professionals is committed to delivering excellence at every stage of the journey, providing peace of mind and ensuring that your cargo arrives at its destination securely and on schedule. Entrust your international transport needs to us, and experience the difference of our trusted and proven services.', 'portdox_theme' ); ?></p>
                            </div>

                            <div class="service-details__content-img2">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="single-img">
                                            <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/services/service-details-img2.jpg" alt="">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="single-img">
                                            <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/services/service-details-img3.jpg" alt="">
                                        </div>
                                    </div>
                                </div>

                                <p><?php esc_html_e( 'This business idea leverages the growing demand for virtual experiences and the need for professional support in navigating the virtual event landscape. It\'s a service that can cater to businesses, organizations, and individuals looking to make their virtual events stand out and be successful.', 'portdox_theme' ); ?></p>
                            </div>

                            <div class="service-details__content-img3">
                                <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/services/service-details-img4.jpg" alt="">
                            </div>

                            <div class="service-details__faq">
                                <div class="accrodion-grp faq-one-accrodion" data-grp-name="faq-one-accrodion-international-transport">
                                    <div class="accrodion active">
                                        <div class="accrodion-title">
                                            <h4><?php esc_html_e( 'Is my technology allowed on tech?', 'portdox_theme' ); ?></h4>
                                        </div>

                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p><?php esc_html_e( 'As a premier international transport service provider, we specialize in seamlessly connecting businesses and individuals with efficient and reliable transportation solutions across borders. Whether it\'s shipping goods or facilitating the travel of individuals.', 'portdox_theme' ); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accrodion">
                                        <div class="accrodion-title">
                                            <h4><?php esc_html_e( 'What types of cargo can your service handle?', 'portdox_theme' ); ?></h4>
                                        </div>

                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p><?php esc_html_e( 'As a premier international transport service provider, we specialize in seamlessly connecting businesses and individuals with efficient and reliable transportation solutions across borders. Whether it\'s shipping goods or facilitating the travel of individuals.', 'portdox_theme' ); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accrodion">
                                        <div class="accrodion-title">
                                            <h4><?php esc_html_e( 'What are the typical stages of a logistic project?', 'portdox_theme' ); ?></h4>
                                        </div>

                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p><?php esc_html_e( 'As a premier international transport service provider, we specialize in seamlessly connecting businesses and individuals with efficient and reliable transportation solutions across borders. Whether it\'s shipping goods or facilitating the travel of individuals.', 'portdox_theme' ); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accrodion">
                                        <div class="accrodion-title">
                                            <h4><?php esc_html_e( 'Is my technology allowed on tech?', 'portdox_theme' ); ?></h4>
                                        </div>

                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p><?php esc_html_e( 'As a premier international transport service provider, we specialize in seamlessly connecting businesses and individuals with efficient and reliable transportation solutions across borders. Whether it\'s shipping goods or facilitating the travel of individuals.', 'portdox_theme' ); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accrodion mb0">
                                        <div class="accrodion-title">
                                            <h4><?php esc_html_e( 'Can you assist with customs clearance procedures?', 'portdox_theme' ); ?></h4>
                                        </div>

                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p><?php esc_html_e( 'As a premier international transport service provider, we specialize in seamlessly connecting businesses and individuals with efficient and reliable transportation solutions across borders. Whether it\'s shipping goods or facilitating the travel of individuals.', 'portdox_theme' ); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Service Details Content-->
                </div>
            </div>
        </section>
        <!--End Service Details-->
<?php
get_footer();
