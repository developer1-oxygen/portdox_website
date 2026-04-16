<?php
/**
 * Template Name: Portdox Network
 * Description: Portdox Network — partner connectivity and data exchange.
 * Assign to the Page whose slug is "portdox-network".
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
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_a ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
            </div>
            <div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
            <div class="container" >
                <div class="page-header__inner" style="max-width: 500px;">
                    <h2><?php echo esc_html( get_the_title() ?: __( 'Portdox Network', 'portdox_theme' ) ); ?></h2>
                </div>
                <div style="max-width: 500px; color: #fff; padding: 10px;">
                   <?php esc_html_e( 'The global supply chain thrives on connectivity, and so does our award-winning communication platform, enabling seamless electronic data exchange and collaboration for customers worldwide.', 'portdox_theme' ); ?>
                </div>
            </div>
        </section>

        <section class="about-one" style="padding-top:15px">

                <div class="container">
                    <div class="row fix_marge ">
                        <div class="col-xl-8 container">
                            <div class="team-details__top-content">
                                <div class="title-box">
                                    <h2 class="sec_heading"><?php esc_html_e( 'A Global Network of Supply Chain Partners at Your Fingertips', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p>
                                    <?php esc_html_e( 'Showcase your profile on the Portdox Network and reach hundreds of potential supply chain partners. Gain the ability to connect and seamlessly exchange transactions, complete with attached documentation, across Portdox databases.', 'portdox_theme' ); ?>
                                    </p><p>
                                    <?php esc_html_e( 'Streamline operations by eliminating redundant tasks and duplicate data entry. Outbound shipments sent through the network automatically convert into inbound shipments in the destination database, enhancing efficiency across the supply chain.', 'portdox_theme' ); ?>
                                     </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="team-details__top-img">
                                <div class="inner">
                                    <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/801.jpg" alt="" style="width:100%">
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
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Expand Your Connections', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p style="text-align: justify;">
                                    <?php esc_html_e( 'Discover and connect with agents worldwide through the Portdox Network. Effortlessly find potential business partners and explore new opportunities across the globe.', 'portdox_theme' ); ?>
                                    </p>
                                    <p style="text-align: justify;">
                                   <?php esc_html_e( 'Engage in real-time conversations with other network users via live chat—without ever leaving the Portdox system.', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="title-box">
                                    <div class="inner"></div>
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Effortless Data Sharing', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p style="text-align: justify; ">
                                    <?php esc_html_e( 'Leverage the Portdox Network to exchange shipment information seamlessly between agents.', 'portdox_theme' ); ?>
                                    </p>
                                    <p style="text-align: justify; ">
                                    <?php esc_html_e( 'Share essential documents like bills of lading, air waybills, packing lists, commercial invoices, and more—ensuring smooth and efficient communication throughout the supply chain.', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="title-box">
                                    <div class="inner"></div>
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Secure Your Documents', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p>
                                    <?php esc_html_e( 'Say goodbye to less secure methods like EDI, FedEx, email, or fax for sharing documents.', 'portdox_theme' ); ?>
                                    </p>
                                    <p>
                                    <?php esc_html_e( 'With the Portdox Network, all your documents are stored safely and securely within the system, ensuring maximum protection and peace of mind.', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </section>
<?php
get_footer();
