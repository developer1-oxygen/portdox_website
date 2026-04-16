<?php
/**
 * Template Name: Portdox Cloud
 * Description: Portdox cloud hosting page (all markup in this file).
 * Assign to the Page whose slug is "portdox-cloud" (or any title you prefer).
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
        .video_sec{ width:100%; max-width:400px; min-height: 200px; float:left; }
        .customer_remarks{ padding:50px; text-align:center; }

        .customer_remarks_desc{text-align:center;  max-width:900px; margin:0 auto;}
         .customer_remarks_title{ text-align:center; max-width:900px; margin:0 auto; margin-top:30px }
</style>
        <!--Start Page Header-->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_a ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
            </div>
            <div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
            <div class="container" >
                <div class="page-header__inner" style="max-width: 500px;">
                    <h2><?php echo esc_html( get_the_title() ?: __( 'Portdox Cloud', 'portdox_theme' ) ); ?></h2>

                </div>
                <div style="max-width: 500px; color: #fff; padding: 10px;">
                   <?php esc_html_e( 'Portdox cloud hosting services offer boundless opportunities. Manage your business anytime, anywhere, and enjoy enhanced flexibility, robust security, dependable performance, and reduced IT expenses. Discover how our cloud-driven supply chain management software streamlines your operations while cutting costs.', 'portdox_theme' ); ?>
                </div>
            </div>
        </section>
        <!--End Page Header-->

        <!--Start Coming Soon-->
        <section class="about-one" style="padding-top:15px">



                <div class=" dark_row_padding" >
                    <div class="container">


                        <div class="row fix_marge">
                            <div class="col-xl-4">
                                <div class="title-box">
                                    <div class="inner">
                                        <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/701.jpg" alt="" style="width:95%">
                                    </div>
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Reliable and Secure Cloud Hosting', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">

                                    <p style="text-align: justify;">
                                    <?php esc_html_e( 'Count on us for peace of mind. Portdox ensures daily data backups and employs redundancy systems to provide the reliability your business demands. We partner with secure, high-rated data centers, including those with SSAE 16 Type II compliance, housed in Tier III facilities with backup power systems in place.', 'portdox_theme' ); ?>

                                    </p>

                                </div>
                            </div>
                            <!----/col4---->

                            <div class="col-xl-4">
                                <div class="title-box">
                                    <div class="inner">
                                        <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/702.jpg" alt="" style="width:95%">
                                    </div>
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Minimal Upfront Investment', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p style="text-align: justify; ">
                                    <?php esc_html_e( 'A key benefit of the cloud is its ability to significantly lower the initial expenses often tied to purchasing and hosting enterprise software on-site. With Portdox Cloud, you enjoy reduced upfront costs without the hassle of buying or maintaining costly servers and hardware for your IT infrastructure.', 'portdox_theme' ); ?>
                                    </p>

                                </div>
                            </div>
                            <!----/col4---->

                            <div class="col-xl-4">
                                <div class="title-box">
                                    <div class="inner">
                                        <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/703.jpg" alt="" style="width:95%">
                                    </div>
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Seamless Cloud Upgrades', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p>
                                   <?php esc_html_e( 'Beyond enhanced security and reduced IT expenses, the cloud offers effortless software updates, ensuring you access new features as they launch. Eliminate technical chores like system upgrades and server upkeep. You maintain control by choosing when to upgrade to the latest Portdox software version, and we handle the rest. It’s the perfect balance of convenience and control!', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>
                            <!----/col4---->
                        </div>

                    </div>
                </div>

                <!------/row------>





                <div class="dark_row" >
                    <div class="container">
                        <div class="row fix_marge">

                            <div class="col-xl-12">
                                <div class="customer_remarks">
                                    <div class="customer_remarks_desc">
                                        <?php esc_html_e( '“The system is highly intuitive, streamlined, and exceptionally user-friendly compared to other supply chain platforms. I’m impressed with their support team—they consistently deliver solutions promptly and efficiently.”', 'portdox_theme' ); ?>
                                    </div>
                                    <div class="customer_remarks_title">
                                        <?php esc_html_e( '– Portdox Freight Forwarding Customer', 'portdox_theme' ); ?>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>
                </div>


                <div class="container">
                    <div class="row fix_marge">
                        <div class="col-xl-4">
                            <div class="title-box">

                                <h2 class="sec_heading_small"><?php esc_html_e( 'Work From Anywhere', 'portdox_theme' ); ?></h2>
                            </div>
                            <div class="team-details__top-content-text">

                                <p style="text-align: justify;">
                                <?php esc_html_e( 'Logistics companies require the flexibility to adapt to remote operations swiftly to maintain business continuity during natural disasters or other physical disruptions. Cloud-based logistics software empowers you to keep your operations running smoothly from any location—all you need is an internet connection.', 'portdox_theme' ); ?>

                                </p>

                            </div>
                        </div>


                        <div class="col-xl-4">
                            <div class="title-box">

                                <h2 class="sec_heading_small"><?php esc_html_e( 'Scalable to Fuel Growth', 'portdox_theme' ); ?></h2>
                            </div>
                            <div class="team-details__top-content-text">
                                <p style="text-align: justify; ">
                               <?php esc_html_e( 'Your logistics software is built to accelerate your operations, so it’s essential for the system to maintain top performance. As your business expands, Portdox scales seamlessly alongside you, automatically optimizing server bandwidth and settings in the cloud for peak performance—all without additional costs.', 'portdox_theme' ); ?>
                                </p>

                            </div>
                        </div>


                        <div class="col-xl-4">
                            <div class="title-box">

                                <h2 class="sec_heading_small"><?php esc_html_e( 'Quick Start, Quick Benefits', 'portdox_theme' ); ?></h2>
                            </div>
                            <div class="team-details__top-content-text">
                                <p>
                              <?php esc_html_e( 'Maximize the value of your Portdox cloud logistics software in no time with our cloud experts handling the entire setup process for you. Get up and running swiftly to start reaping the benefits of your investment right away. Focus on managing your logistics business while we handle the technology for you.', 'portdox_theme' ); ?>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>



        </section>
        <!--End Coming Soon-->
<?php
get_footer();
