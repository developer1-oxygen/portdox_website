<?php
/**
 * Template Name: Portdox Professional Services
 * Description: Implementation, consulting, and integration services.
 * Assign to the Page whose slug is "professional-services".
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
                    <h2><?php echo esc_html( get_the_title() ?: __( 'Portdox Professional Services', 'portdox_theme' ) ); ?></h2>
                </div>
                <div style="max-width: 500px; color: #fff; padding: 10px;">
                   <?php esc_html_e( 'At Portdox, we are dedicated to delivering exceptional, expert supply chain business services with a personal touch. Your success is our top priority—every customer, every interaction.', 'portdox_theme' ); ?>
                </div>
            </div>
        </section>

        <section class="about-one" style="padding-top:15px">

                <div class="container">
                    <div class="row fix_marge ">
                        <div class="col-xl-8 container">
                            <div class="team-details__top-content">
                                <div class="title-box">
                                    <h2 class="sec_heading"><?php esc_html_e( 'Portdox Professional Services', 'portdox_theme' ); ?></h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p>
                                    <?php esc_html_e( 'At Portdox, we pride ourselves on building partnerships with our clients. Our professional services team comprises industry veterans who have supported thousands of supply chain businesses like yours. Their extensive knowledge of logistics best practices and hands-on experience ensures you receive exceptional guidance and solutions.', 'portdox_theme' ); ?>
                                    </p><p>
                                    <?php esc_html_e( 'We cherish the opportunity to grow alongside our loyal clients and deeply value their input and collaboration. Thanks to their feedback, we’ve enhanced our features and refined our professional services over the years to better serve the entire Portdox community.', 'portdox_theme' ); ?>
                                     </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="team-details__top-img">
                                <div class="inner">
                                    <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/809.jpg" alt="" style="width:100%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dark_row dark_row_padding" >
                    <div class="container">
                        <div class="row fix_marge">
                            <div class="col-xl-12">
                                <div class="team-details__top-content-text">
                                    <img src="<?php echo esc_url( $portdox_a ); ?>/assets/images/703.jpg" alt="" style="width: 380px; float: left; margin: 10px;">
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Implementation Services', 'portdox_theme' ); ?></h2>
                                    <p>
                                    <?php esc_html_e( 'At Portdox, we recognize that every business has unique needs. Our implementation team takes the time to understand your workflows, requirements, and challenges, providing personalized guidance while sharing industry best practices. Implementation isn’t just a one-time process—it’s the foundation of a lasting partnership, and we look forward to supporting you for years to come.', 'portdox_theme' ); ?>
                                    </p>
                                    <p>
                                    <?php esc_html_e( 'We’ve designed a comprehensive onboarding process to ensure you can leverage Portdox from day one to meet your business objectives. Our team provides hands-on guidance during the initial stages and remains committed to your long-term success.', 'portdox_theme' ); ?>
                                    </p>
                                    <br><br>
                                    <p>
                                    <?php esc_html_e( 'Our customer success team begins by crafting your tailored implementation and training plan, followed by installing your software. Once set up, you’ll have access to learning paths in Page One, the Welcome screen in your Portdox software, to help you get started effectively.', 'portdox_theme' ); ?>
                                    </p>
                                    <p>
                                    <?php esc_html_e( 'After onboarding, we’ll work with you on growth strategies, regularly check in to ensure you’re maximizing Portdox’s capabilities, and stay available to discuss how the software can scale alongside your growing business.', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" " >
                    <div class="container">
                        <div class="row ">
                            <div class="col-xl-6">
                                <div class="team-details__top-content-text">
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Consulting Services', 'portdox_theme' ); ?></h2>
                                    <p>
                                    <?php esc_html_e( 'Even after you’ve implemented and mastered the Portdox software, our partnership doesn’t end there.', 'portdox_theme' ); ?>
                                    </p>
                                    <p>
                                    <?php esc_html_e( 'Our expert team remains available to assess your system and provide tailored recommendations to enhance productivity, mitigate risks, and maximize the benefits of Portdox’s capabilities for your business.', 'portdox_theme' ); ?>
                                    </p>
                                    <p>
                                    <?php esc_html_e( 'As your business grows and evolves, so do your needs. We’re here to guide you, demonstrating how Portdox’s versatile tools can adapt to meet your changing requirements and support your continued success.', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="team-details__top-content-text">
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Development and Integration Services', 'portdox_theme' ); ?></h2>
                                    <p>
                                    <?php esc_html_e( 'Portdox software is built to be highly configurable, catering to the diverse needs of logistics and supply chain companies. If your specific workflows or business requirements aren’t fully addressed in the standard software, we’re ready to explore custom development tailored to your needs.', 'portdox_theme' ); ?>
                                    </p>
                                    <p>
                                    <?php esc_html_e( 'We also offer a wide range of pre-built, standard integrations with various agencies, databases, and systems. These integrations save you time and resources, enabling you to get started quickly and efficiently.', 'portdox_theme' ); ?>
                                    </p>
                                    <p>
                                    <?php esc_html_e( 'Need something unique? Portdox provides custom integration development services to seamlessly connect with new systems, ensuring your operations stay optimized as your business grows.', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="team-details__top-content-text">
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Your Success is Our Top Priority', 'portdox_theme' ); ?></h2>
                                    <p>
                                   <?php esc_html_e( 'To ensure a seamless transition and foster strong relationships, Portdox assigns a dedicated customer success manager to every account. This manager serves as your trusted advisor and long-term point of contact at Portdox.', 'portdox_theme' ); ?>
                                    </p>
                                    <p>
                                    <?php esc_html_e( 'Your customer success manager’s primary goal is to understand your unique needs, address questions, resolve issues, and cultivate a partnership that lasts well beyond the initial sale.', 'portdox_theme' ); ?>
                                    </p>
                                    <p>
                                   <?php esc_html_e( 'At Portdox, we’re passionate about delivering exceptional customer experiences. Your dedicated success manager will act as your advocate within Portdox, committed to helping you achieve the highest level of success.', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="team-details__top-content-text">
                                    <h2 class="sec_heading_small"><?php esc_html_e( 'Empowering You with Knowledge', 'portdox_theme' ); ?></h2>
                                    <p>
                                   <?php esc_html_e( 'Portdox equips you and your team with comprehensive training and documentation resources, including personalized live training sessions—either in person or online. From our extensive self-service knowledge base and how-to videos to self-paced online courses and practice activities, we provide the tools needed to turn your team into Portdox experts.', 'portdox_theme' ); ?>
                                    </p>
                                    <p>
                                    <?php esc_html_e( 'New employees can seamlessly onboard with access to training materials, instructional videos, and more, all conveniently available in Page One, the welcome screen within the software. With Portdox, learning and mastery are always within reach.', 'portdox_theme' ); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </section>
<?php
get_footer();
