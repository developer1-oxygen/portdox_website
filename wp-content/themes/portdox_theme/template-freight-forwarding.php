<?php
/**
 * Template Name: Portdox Freight Forwarding
 * Description: Freight forwarding software / digital freight platform page (all markup in this file).
 * Assign to the Page whose slug is "freight-forwarding" (or any title you prefer).
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
        .sec_heading_small{ font-size:26px; }
        .inner_feature{ margin-top:25px; }
</style>
        <!--Start Page Header-->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_a ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
            </div>
            <div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
            <div class="container" >
                <div class="page-header__inner" style="max-width: 500px;">
                    <h2><?php echo esc_html( get_the_title() ?: __( 'Freight Forwarding Software', 'portdox_theme' ) ); ?></h2>

                </div>
                <div style="max-width: 500px; color: #fff; padding: 10px;">
                	<?php esc_html_e( 'Drive your growth with our Digital Freight Platform—a versatile and scalable suite of automation tools tailored to meet the dynamic demands of freight forwarders.', 'portdox_theme' ); ?>
                </div>
            </div>
        </section>
        <!--End Page Header-->

        <!--Start Coming Soon-->
        <section class="about-one">

                <div class="container">
                   	<div class="row ">
                        <div class="col-xl-12 container">
                            <div class="team-details__top-content">
                                <div class="title-box">

                                    <h2 class="sec_heading">The freight forwarding industry is  <span style="color: #09a1ff;">transforming at an unprecedented pace.</span></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p>
                                    Customers today demand interactive online experiences, real-time visibility, and exceptional value—similar to what they experience in the B2C space. With competition growing from every direction and challenges like port delays, rising costs, and container shortages, staying ahead has never been more critical.
                                    </p><p>
                                    However, this evolving landscape also presents exciting opportunities to scale your business, optimize costs and time with modern technology, and exceed customer expectations.
                                     </p><p>
                                    As the global economy expands, the need for fast, efficient, and cost-effective logistics solutions continues to grow. Our technology empowers you to operate efficiently, deliver exceptional customer service, and stay ahead of the competition, all while accelerating your growth.
                                     </p><p>
                                    Tailored to various freight forwarding workflows, our solutions are designed to meet your specific needs:
                                     </p><p>
                                    For exports: Leverage a comprehensive suite of tools to drive efficiency throughout the export process, from the first quote to the final mile.
                                     </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!------/row------>

                <div class="dark_row dark_row_padding" >
                    <div class=" container">
                        <div class="row fix_marge ">
                            <div class="col-xl-8 container">
                                <div class="team-details__top-content">
                                    <div class="title-box">

                                        <h2 class="sec_heading">A Comprehensive Digital Solution for<span style="color: #09a1ff;"> Modern Freight Forwarding</span></h2>
                                    </div>
                                    <div class="team-details__top-content-text">
                                        <p>
                                        Start small, scale gradually, or implement a complete solution from day one—the choice is yours! Freight forwarding businesses are diverse, and that’s why we offer a suite of flexible, modular, and interoperable solutions.
                                        </p><p>
                                        Whether you're looking to modernize and automate a specific area of your operations or lay a robust technological foundation across your entire business, our team will collaborate with you to provide the ideal solution tailored to your unique requirements.
                                         </p>





                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="team-details__top-img">
                                    <div class="inner">
                                        <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/software_stack2.png" alt="" style="width:100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!------/row------>
                <div class="container">
                    <div class="row fix_marge">
                        <div class="col-xl-6">
                            <div class="title-box">
                                <div class="inner">
                                    <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/ff_wms.png" alt="" style="width:95%">
                                </div>
                                <h2 class="sec_heading">A Comprehensive Digital Solution for<span style="color: #09a1ff;"> Modern Freight Forwarding</span></h2>
                            </div>
                            <div class="team-details__top-content-text">
                                <p>
                                Start small, scale gradually, or implement a complete solution from day one—the choice is yours! Freight forwarding businesses are diverse, and that’s why we offer a suite of flexible, modular, and interoperable solutions.
                                </p><p>
                                Whether you're looking to modernize and automate a specific area of your operations or lay a robust technological foundation across your entire business, our team will collaborate with you to provide the ideal solution tailored to your unique requirements.
                                 </p>





                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="title-box">
                                <div class="inner">
                                    <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/digital_customer.png" alt="" style="width:95%">
                                </div>
                                <h2 class="sec_heading">Revolutionize the <span style="color: #09a1ff;">Digital Customer Experience</span></h2>
                            </div>
                            <div class="team-details__top-content-text">
                                <p>
                                In today’s fast-paced world, customers expect convenience, speed, and control at their fingertips. Our digital solutions empower them to request quotes, track shipments, review rates, and manage their logistics with ease.
                                </p>
                                <p>
                               Deliver a seamless, branded online experience that sets your business apart. From schedules and bookings to reporting and purchase orders, our forwarder portal ensures your customers stay engaged and satisfied.
                                 </p>



                            </div>
                        </div>


                    
                    </div>
                </div>



                <div class="dark_row dark_row_padding" >
                    <div class="container">


                        <div class="row fix_marge">
                            <div class="col-xl-4">
                                <div class="title-box">
                                    <div class="inner">
                                        <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/customer_compliance.jpg" alt="" style="width:95%">
                                    </div>
                                    <h2 class="sec_heading_small">Customs Compliance</h2>
                                </div>
                                <div class="team-details__top-content-text">

                                    <p style="text-align: justify;">
                                    Portdox Customs Compliance, an ACE-certified ABI solution, equips freight forwarders with the tools needed to automate compliance workflows and maximize operational efficiency.

                                    </p>

                                    <p style="text-align: justify; margin-top:10px ;">
                                    Receive real-time alerts to stay informed about critical shipment updates, ensuring your cargo keeps moving without delays. The solution seamlessly integrates with Portdox Supply Chain or any transportation management system you prefer.
                                    </p>
                                </div>
                            </div>
                            <!----/col4---->

                            <div class="col-xl-4">
                                <div class="title-box">
                                    <div class="inner">
                                        <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/560.png" alt="" style="width:95%">
                                    </div>
                                    <h2 class="sec_heading_small">Rate Management</h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p style="text-align: justify; ">
                                    Portdox Rate Management offers a cutting-edge solution for rating and quoting, simplifying complex data so you can efficiently manage margins, surcharges, spot rates, file tariffs, respond to RFQs, and provide accurate quotes—all from a centralized platform.


                                    </p>
                                    <p style="text-align: justify; margin-top:10px ;">
                                    Fully configurable to meet your unique requirements, this solution seamlessly integrates with Portdox Supply Chain or the logistics system of your choice for enhanced flexibility and ease of use.
                                     </p>
                                </div>
                            </div>
                            <!----/col4---->

                            <div class="col-xl-4">
                                <div class="title-box">
                                    <div class="inner">
                                        <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/crm_2.jpg" alt="" style="width:95%">
                                    </div>
                                    <h2 class="sec_heading_small"> CRM </h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p>
                                    Portdox CRM ensures all teams involved in customer acquisition, retention, and management have unified access to accurate and up-to-date information on contacts, accounts, opportunities, and more.


                                    </p><p>
                                   This efficient solution saves time by eliminating redundancies and promoting customer-focused collaboration. With enhanced visibility, streamlined quoting processes, and integrated business intelligence, your teams can work smarter and deliver exceptional results.
                                     </p>
                                </div>
                            </div>
                            <!----/col4---->
                        </div>

                    </div>
                </div>

                <!------/row------>

                <div class="" >
                    <div class="container">
                        <div class="row fix_marge">

                            <div class="col-xl-6 ">
                                <div class="title-box">
                                    <div class="inner inner_feature">
                                        <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/cloud_base_solution_icon.png"  style="width:100px;opacity: 0.5;">
                                    </div>
                                    <h2 class="sec_heading_small">A Reliable Cloud-Based Freight Software Solution</h2>
                                </div>
                                <div class="team-details__top-content-text">

                                    <p style="text-align: justify;">
                                    The Portdox Digital Freight Platform combines Portdox Supply Chain, Portdox Customs Compliance, Portdox Rate Management, the Portdox Digital Freight Portal, Portdox CRM, and a suite of extensions. Together, they form a flexible, modular, and interoperable cloud-based solution that can be used as a fully integrated logistics platform or independently alongside your existing systems.
                                    </p>

                                    <p style="text-align: justify;">
                                   With the Portdox Cloud, you can eliminate the hassle of IT maintenance, allowing you to focus on your core business operations. Additionally, the Portdox Cloud ensures a fast start with minimal upfront costs and robust security features to safeguard your business against potential risks.
                                    </p>
                                </div>
                            </div>




                            <div class="col-xl-6 ">
                                <div class="title-box">
                                    <div class="inner inner_feature">
                                        <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/network_icon.png"  style="width:100px;opacity: 0.5;">
                                    </div>
                                    <h2 class="sec_heading_small">Accelerate Your Agent Workflows with the Portdox Network</h2>
                                </div>
                                <div class="team-details__top-content-text">

                                    <p style="text-align: justify;">
                                    Expanding your network of partners is crucial for building a resilient business, especially when faced with challenges like limited capacity and rising rates.
                                    </p>

                                    <p style="text-align: justify;">
                                    As a Portdox customer, you gain immediate access to a global community of over 2,300 supply chain companies spanning more than 100 countries.
                                    </p>

                                    <p style="text-align: justify;">
                                    The Portdox Network enables seamless document and data exchanges with partners and agents already using Portdox, providing a more efficient, secure, and streamlined way to collaborate and conduct business.
                                    </p>
                                </div>
                            </div>



                            <div class="col-xl-6 ">
                                <div class="title-box">
                                    <div class="inner inner_feature">
                                        <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/wholesale_icon.png"  style="width:100px;opacity: 0.5;">
                                    </div>
                                    <h2 class="sec_heading_small">Smart Warehouse Solutions Designed for Freight Forwarders</h2>
                                </div>
                                <div class="team-details__top-content-text">

                                    <p style="text-align: justify;">
                                    Not all warehouses operate the same way, so why settle for software built for retail or wholesale when your freight forwarding warehouse requires speed and precision? You need a WMS tailored to your needs, seamlessly integrating with your freight forwarding software. That’s why we built an advanced warehouse management system directly into the core of our Portdox Supply Chain platform.
                                    </p>

                                   <p style="text-align: justify;">
                                   Take your warehouse operations to the next level with cutting-edge mobile and automation technology. Use Flow WMS by Portdox on your Android or iOS device for on-the-go efficiency, or streamline package handling with the Dimensioner by Portdox, delivering instant and accurate parcel measurements. This powerful combination enables high-volume, small-parcel handling with ease—operators can even measure packages without leaving the forklift!
                                    </p>


                                </div>
                            </div>




                            <div class="col-xl-6 ">
                                <div class="title-box">
                                    <div class="inner inner_feature">
                                        <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/settings_icon.png"  style="width:100px;opacity: 0.5;">
                                    </div>
                                    <h2 class="sec_heading_small">Expand Your Capabilities With Extensions and Integrations</h2>
                                </div>
                                <div class="team-details__top-content-text">

                                    <p style="text-align: justify;">
                                   As supply chains grow increasingly complex, freight forwarders require smarter, more efficient ways to connect systems and streamline operations. The Portdox Digital Freight Platform is designed for flexibility and extensibility, offering a suite of powerful extensions and an open API that connects seamlessly with virtually any third-party solution, unifying your supply chain management processes.
                                    </p>

                                   <p style="text-align: justify;">
                                  Whether you need to integrate an e-commerce platform, maintain your existing accounting software, or consolidate carrier tracking data into your freight forwarding system, Portdox has the tools to make it happen. Our solutions enhance centralized visibility, minimize duplicate data entry, reduce errors, and save you valuable time, ensuring you stay ahead in a competitive market
                                    </p>


                                </div>
                            </div>


                        </div>

                    </div>
                </div>



        </section>
        <!--End Coming Soon-->
<?php
get_footer();
