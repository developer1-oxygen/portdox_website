<?php
/**
 * Template Name: Portdox About Us
 * Description: About page with page header, company block, services carousel, CTA, testimonials.
 *
 * @package Portdox_Theme
 */

get_header();

/**
 * About Us page main content (page header through testimonial).
 */
$portdox_assets = get_template_directory_uri();
?>
<!--Start Page Header-->
<section class="page-header">
    <div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_assets ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
    </div>
    <div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
    <div class="container">
        <div class="page-header__inner">
            <h2>About us</h2>
            <ul class="thm-breadcrumb">
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                <li><span class="icon-right-arrow21"></span></li>
                <li>About us</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Header-->

<!--Start About One-->
<section class="about-one">
    <div class="container">
        <div class="row">
            <!--Start About One Content-->
            <div class="col-xl-7">
                <div class="about-one__content">
					<?php
					$portdox_about_tagline         = function_exists( 'get_field' ) ? get_field( 'portdox_about_tagline' ) : '';
					$portdox_about_title_line1     = function_exists( 'get_field' ) ? get_field( 'portdox_about_title_line1' ) : '';
					$portdox_about_title_highlight = function_exists( 'get_field' ) ? get_field( 'portdox_about_title_highlight' ) : '';
					$portdox_about_intro           = function_exists( 'get_field' ) ? get_field( 'portdox_about_intro' ) : '';
					$portdox_about_feature1_title  = function_exists( 'get_field' ) ? get_field( 'portdox_about_feature1_title' ) : '';
					$portdox_about_feature1_text   = function_exists( 'get_field' ) ? get_field( 'portdox_about_feature1_text' ) : '';
					$portdox_about_feature2_title  = function_exists( 'get_field' ) ? get_field( 'portdox_about_feature2_title' ) : '';
					$portdox_about_feature2_text   = function_exists( 'get_field' ) ? get_field( 'portdox_about_feature2_text' ) : '';

					if ( ! is_string( $portdox_about_tagline ) || '' === trim( $portdox_about_tagline ) ) {
						$portdox_about_tagline = 'Our Company';
					}
					if ( ! is_string( $portdox_about_title_line1 ) || '' === trim( $portdox_about_title_line1 ) ) {
						$portdox_about_title_line1 = 'Our Expertise Stands in';
					}
					if ( ! is_string( $portdox_about_title_highlight ) || '' === trim( $portdox_about_title_highlight ) ) {
						$portdox_about_title_highlight = 'Logistics Solutions';
					}
					if ( ! is_string( $portdox_about_intro ) || '' === trim( $portdox_about_intro ) ) {
						$portdox_about_intro = "Logistic service provider company plays a pivotal role in the global supply\nchain ecosystem by efficiently managing the movement of goods from origin to final\ndestination. These companies offer a diverse.";
					}
					if ( ! is_string( $portdox_about_feature1_title ) || '' === trim( $portdox_about_feature1_title ) ) {
						$portdox_about_feature1_title = 'Worldwide Service';
					}
					if ( ! is_string( $portdox_about_feature1_text ) || '' === trim( $portdox_about_feature1_text ) ) {
						$portdox_about_feature1_text = 'Logistic service provider company plays a pivotal role in the global';
					}
					if ( ! is_string( $portdox_about_feature2_title ) || '' === trim( $portdox_about_feature2_title ) ) {
						$portdox_about_feature2_title = '24/7 Online Support';
					}
					if ( ! is_string( $portdox_about_feature2_text ) || '' === trim( $portdox_about_feature2_text ) ) {
						$portdox_about_feature2_text = 'Logistic service provider company plays a pivotal role in the global';
					}
					?>
                    <div class="sec-title tg-heading-subheading animation-style2">
                        <div class="sec-title__tagline">
                            <div class="line"></div>
                            <div class="text tg-element-title">
                                <h4><?php echo esc_html( $portdox_about_tagline ); ?></h4>
                            </div>
                            <div class="icon">
                                <span class="icon-plane2 float-bob-x3"></span>
                            </div>
                        </div>
                        <h2 class="sec-title__title tg-element-title">
							<?php echo esc_html( $portdox_about_title_line1 ); ?><br>
                            <span><?php echo esc_html( $portdox_about_title_highlight ); ?></span>
                        </h2>
                    </div>

                    <div class="about-one__content-text1">
                        <p><?php echo nl2br( esc_html( $portdox_about_intro ) ); ?></p>
                    </div>

                    <div class="about-one__content-text2">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="about-one__content-text2-single">
                                    <div class="about-one__content-text2-single-top">
                                        <div class="icon">
                                            <span class="icon-worldwide-shipping-1"></span>
                                        </div>

                                        <div class="title-box">
                                            <h3><?php echo esc_html( $portdox_about_feature1_title ); ?></h3>
                                        </div>
                                    </div>

                                    <p><?php echo esc_html( $portdox_about_feature1_text ); ?></p>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="about-one__content-text2-single">
                                    <div class="about-one__content-text2-single-top">
                                        <div class="icon">
                                            <span class="icon-24-hours-service"></span>
                                        </div>

                                        <div class="title-box">
                                            <h3><?php echo esc_html( $portdox_about_feature2_title ); ?></h3>
                                        </div>
                                    </div>

                                    <p><?php echo esc_html( $portdox_about_feature2_text ); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="about-one__content-bottom">
                        <div class="btn-box">
                            <a class="thm-btn" href="<?php echo esc_url( portdox_url_for_page_slug( 'about' ) ); ?>">More About Us
                                <i class="icon-right-arrow21"></i>
                                <span class="hover-btn hover-bx"></span>
                                <span class="hover-btn hover-bx2"></span>
                                <span class="hover-btn hover-bx3"></span>
                                <span class="hover-btn hover-bx4"></span>
                            </a>
                        </div>

                        <div class="contact-box">
                            <div class="icon">
                                <span class="icon-phone2"></span>
                            </div>

                            <div class="text-box">
								<p>Make A Phone Call</p>
								<?php
								$portdox_about_phone = portdox_get_service_sidebar_phone_display();
								$portdox_about_tel   = portdox_get_service_sidebar_phone_tel();
								$portdox_about_href  = '' !== $portdox_about_tel ? 'tel:' . $portdox_about_tel : '#';
								?>
								<h4><a href="<?php echo esc_url( $portdox_about_href ); ?>"><?php echo esc_html( $portdox_about_phone ); ?></a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End About One Content-->

            <!--Start About One Img-->
            <div class="col-xl-5">
                <div class="about-one__img">
                    <div class="shape1 float-bob-y"><img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/shapes/about-v1-shape1.png" alt="">
                    </div>
                    <div class="shape2 float-bob-y"><img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/shapes/about-v1-shape2.png" alt="">
                    </div>
					<?php
					$portdox_about_image_main      = function_exists( 'get_field' ) ? get_field( 'portdox_about_image_main' ) : null;
					$portdox_about_image_secondary = function_exists( 'get_field' ) ? get_field( 'portdox_about_image_secondary' ) : null;

					$portdox_about_image_main_url = '';
					if ( is_array( $portdox_about_image_main ) && ! empty( $portdox_about_image_main['url'] ) ) {
						$portdox_about_image_main_url = (string) $portdox_about_image_main['url'];
					}
					if ( '' === $portdox_about_image_main_url ) {
						$portdox_about_image_main_url = $portdox_assets . '/assets/images/about/about-v2-main.png';
					}

					$portdox_about_image_secondary_url = '';
					if ( is_array( $portdox_about_image_secondary ) && ! empty( $portdox_about_image_secondary['url'] ) ) {
						$portdox_about_image_secondary_url = (string) $portdox_about_image_secondary['url'];
					}
					if ( '' === $portdox_about_image_secondary_url ) {
						$portdox_about_image_secondary_url = $portdox_assets . '/assets/images/about/about-v2-secondary.png';
					}
					?>
                    <div class="about-one__img1 reveal">
                        <img src="<?php echo esc_url( $portdox_about_image_main_url ); ?>" alt="">
                    </div>

                    <div class="about-one__img2">
                        <div class="about-one__img2-inner reveal">
                            <img src="<?php echo esc_url( $portdox_about_image_secondary_url ); ?>" alt="" style="width:260px;height:340px;object-fit:cover;object-position:center;">
                        </div>

                        <div class="about-one__circle-text">
                            <div class="about-one__round-text-box">
                                <div class="inner">
                                    <div class="about-one__curved-circle rotate-me">
                                        WELCOME TO OUR COMPANY SINCE 2002
                                    </div>
                                </div>
                                <div class="overlay-icon-box">
                                    <a href="#"><i class="icon-location1"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="shape3 float-bob-y">
                            <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/shapes/about-v1-shape3.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <!--End About One Img-->
        </div>
    </div>
</section>
<!--End About One-->

<!--Start Service One-->
<section class="service-one">
    <div class="service-one__pattern"
        style="background-image: url(<?php echo esc_url( $portdox_assets ); ?>/assets/images/pattern/service-v1-pattern.jpg);"></div>
    <div class="container">
        <div class="sec-title center text-center tg-heading-subheading animation-style2">
            <div class="sec-title__tagline">
                <div class="line"></div>
                <div class="text tg-element-title">
                    <h4>Portdox solutions</h4>
                </div>
                <div class="icon">
                    <span class="icon-plane2 float-bob-x3"></span>
                </div>
            </div>
            <h2 class="sec-title__title tg-element-title">Better freight &amp; logistics
                <br> outcomes with <span>Portdox</span></h2>
        </div>

        <div class="row">
            <div class="service-one__carousel owl-carousel owl-theme owl-dot-style1">
                <!--Start Service One Single-->
                <div class="service-one__single">   
                    <div class="service-one__single-inner">
                        <div class="service-one__single-img">
                            <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/services/services-v2-img1.png" alt="#" style="width:100%;height:260px;object-fit:cover;object-position:center;">
                        </div>

                        <div class="service-one__single-content">
                            <h2><a href="<?php echo esc_url( portdox_url_for_page_slug( 'ocean-transport' ) ); ?>"><?php esc_html_e( 'Ocean Transport', 'portdox_theme' ); ?></a></h2>
                            <p>A logistic service provider company plays
                                a pivotal role in the global supply chain logistic service.</p>
                            <div class="btn-box">
                                <a href="<?php echo esc_url( portdox_url_for_page_slug( 'ocean-transport' ) ); ?>">Read More <span
                                        class="icon-right-arrow21"></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="icon">
                        <span class="icon-delivery-man"></span>
                    </div>
                </div>
                <!--End Service One Single-->

                <!--Start Service One Single-->
                <div class="service-one__single">
                    <div class="service-one__single-inner">
                        <div class="service-one__single-img">
                            <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/services/services-v2-img2.png" alt="#" style="width:100%;height:260px;object-fit:cover;object-position:center;">
                        </div>

                        <div class="service-one__single-content">
                            <h2><a href="international-transport.php">Local Truck Transport</a></h2>
                            <p>A logistic service provider company plays
                                a pivotal role in the global supply chain logistic service.</p>
                            <div class="btn-box">
                                <a href="international-transport.php">Read More <span
                                        class="icon-right-arrow21"></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="icon">
                        <span class="icon-shipment"></span>
                    </div>
                </div>
                <!--End Service One Single-->

                <!--Start Service One Single-->
                <div class="service-one__single">
                    <div class="service-one__single-inner">
                        <div class="service-one__single-img">
                            <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/services/services-v2-img3.png" alt="#" style="width:100%;height:260px;object-fit:cover;object-position:center;">
                        </div>

                        <div class="service-one__single-content">
                            <h2><a href="international-transport.php">International Transport</a></h2>
                            <p>A logistic service provider company plays
                                a pivotal role in the global supply chain logistic service.</p>
                            <div class="btn-box">
                                <a href="international-transport.php">Read More <span
                                        class="icon-right-arrow21"></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="icon">
                        <span class="icon-international-shipping"></span>
                    </div>
                </div>
                <!--End Service One Single-->

                <!--Start Service One Single-->
                <div class="service-one__single">
                    <div class="service-one__single-inner">
                        <div class="service-one__single-img">
                            <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/services/services-v2-img4.png" alt="#" style="width:100%;height:260px;object-fit:cover;object-position:center;">
                        </div>

                        <div class="service-one__single-content">
                            <h2><a href="<?php echo esc_url( portdox_url_for_page_slug( 'ocean-transport' ) ); ?>"><?php esc_html_e( 'Ocean Transport', 'portdox_theme' ); ?></a></h2>
                            <p>A logistic service provider company plays
                                a pivotal role in the global supply chain logistic service.</p>
                            <div class="btn-box">
                                <a href="<?php echo esc_url( portdox_url_for_page_slug( 'ocean-transport' ) ); ?>">Read More <span
                                        class="icon-right-arrow21"></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="icon">
                        <span class="icon-delivery-man"></span>
                    </div>
                </div>
                <!--End Service One Single-->

                <!--Start Service One Single-->
                <div class="service-one__single">
                    <div class="service-one__single-inner">
                        <div class="service-one__single-img">
                            <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/services/services-v2-img5.png" alt="#" style="width:100%;height:260px;object-fit:cover;object-position:center;">
                        </div>

                        <div class="service-one__single-content">
                            <h2><a href="international-transport.php">Local Truck Transport</a></h2>
                            <p>A logistic service provider company plays
                                a pivotal role in the global supply chain logistic service.</p>
                            <div class="btn-box">
                                <a href="international-transport.php">Read More <span
                                        class="icon-right-arrow21"></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="icon">
                        <span class="icon-shipment"></span>
                    </div>
                </div>
                <!--End Service One Single-->

                <!--Start Service One Single-->
                <div class="service-one__single">
                    <div class="service-one__single-inner">
                        <div class="service-one__single-img">
                            <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/services/services-v2-img6.png" alt="#" style="width:100%;height:260px;object-fit:cover;object-position:center;">
                        </div>

                        <div class="service-one__single-content">
                            <h2><a href="international-transport.php">International Transport</a></h2>
                            <p>A logistic service provider company plays
                                a pivotal role in the global supply chain logistic service.</p>
                            <div class="btn-box">
                                <a href="international-transport.php">Read More <span
                                        class="icon-right-arrow21"></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="icon">
                        <span class="icon-international-shipping"></span>
                    </div>
                </div>
                <!--End Service One Single-->

                <!--Start Service One Single-->
                <div class="service-one__single">
                    <div class="service-one__single-inner">
                        <div class="service-one__single-img">
                            <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/services/services-v2-img1.png" alt="#" style="width:100%;height:260px;object-fit:cover;object-position:center;">
                        </div>

                        <div class="service-one__single-content">
                            <h2><a href="<?php echo esc_url( portdox_url_for_page_slug( 'ocean-transport' ) ); ?>"><?php esc_html_e( 'Ocean Transport', 'portdox_theme' ); ?></a></h2>
                            <p>A logistic service provider company plays
                                a pivotal role in the global supply chain logistic service.</p>
                            <div class="btn-box">
                                <a href="<?php echo esc_url( portdox_url_for_page_slug( 'ocean-transport' ) ); ?>">Read More <span
                                        class="icon-right-arrow21"></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="icon">
                        <span class="icon-delivery-man"></span>
                    </div>
                </div>
                <!--End Service One Single-->

                <!--Start Service One Single-->
                <div class="service-one__single">
                    <div class="service-one__single-inner">
                        <div class="service-one__single-img">
                            <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/services/services-v2-img2.png" alt="#" style="width:100%;height:260px;object-fit:cover;object-position:center;">
                        </div>

                        <div class="service-one__single-content">
                            <h2><a href="international-transport.php">Local Truck Transport</a></h2>
                            <p>A logistic service provider company plays
                                a pivotal role in the global supply chain logistic service.</p>
                            <div class="btn-box">
                                <a href="international-transport.php">Read More <span
                                        class="icon-right-arrow21"></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="icon">
                        <span class="icon-shipment"></span>
                    </div>
                </div>
                <!--End Service One Single-->

                <!--Start Service One Single-->
                <div class="service-one__single">
                    <div class="service-one__single-inner">
                        <div class="service-one__single-img">
                            <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/services/services-v2-img3.png" alt="#" style="width:100%;height:260px;object-fit:cover;object-position:center;">
                        </div>

                        <div class="service-one__single-content">
                            <h2><a href="international-transport.php">International Transport</a></h2>
                            <p>A logistic service provider company plays
                                a pivotal role in the global supply chain logistic service.</p>
                            <div class="btn-box">
                                <a href="international-transport.php">Read More <span
                                        class="icon-right-arrow21"></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="icon">
                        <span class="icon-international-shipping"></span>
                    </div>
                </div>
                <!--End Service One Single-->
            </div>
        </div>
    </div>
</section>
<!--End Service One-->



<!--Start Why Choose One-->
<?php include_once get_template_directory() . '/__book_a_demo.php'; ?>
<!--End Why Choose One-->

<!--Start Testimonial One-->
<section class="testimonial-one">
    <div class="testimonial-one__pattern"
        style="background-image: url(<?php echo esc_url( $portdox_assets ); ?>/assets/images/pattern/testimonial-v1-pattern.png);"></div>
    <div class="container">
        <div class="row">
            <!--Start Testimonial One Content-->
            <div class="col-xl-6">
                <div class="testimonial-one__content">
                    <div class="big-title">
                        <h2>TESTIMONIALS</h2>
                    </div>
                    <div class="sec-title tg-heading-subheading animation-style2">
                        <div class="sec-title__tagline">
                            <div class="line"></div>
                            <div class="text tg-element-title">
                                <h4>Client Testimonial</h4>
                            </div>
                            <div class="icon">
                                <span class="icon-plane2 float-bob-x3"></span>
                            </div>
                        </div>
                        <h2 class="sec-title__title tg-element-title">What Our Customers <br>
                            Say <span>About Us</span> </h2>
                    </div>

                    <div class="testimonial-one__carousel owl-carousel owl-theme">
						<?php
						if ( function_exists( 'portdox_render_testimonial_one_carousel_singles' ) ) {
							portdox_render_testimonial_one_carousel_singles( $portdox_assets, 4 );
						}
						?>
                    </div>
                </div>
            </div>
            <!--End Testimonial One Content-->


            <!--Start Testimonial One Img-->
            <div class="col-xl-6">
                <div class="testimonial-one__img">
                    <div class="testimonial-one__img1 reveal">
                        <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/testimonial/testimonial-v2-main.png" alt="">
                    </div>

                    <div class="testimonial-one__img-author">
                        <ul>
							<?php
							$portdox_about_testimonial_faces = function_exists( 'portdox_get_testimonial_one_carousel_items' )
								? portdox_get_testimonial_one_carousel_items( 4 )
								: array();
							foreach ( $portdox_about_testimonial_faces as $portdox_t_face ) {
								$portdox_t_av = isset( $portdox_t_face['avatar_file'] ) ? (string) $portdox_t_face['avatar_file'] : 'testimonial-v1-img1.png';
								$portdox_t_nm = isset( $portdox_t_face['name'] ) ? (string) $portdox_t_face['name'] : '';
								?>
                            <li>
                                <div class="img-box"><img src="<?php echo esc_url( portdox_testimonial_one_avatar_url( $portdox_t_av, $portdox_assets ) ); ?>" alt="<?php echo esc_attr( $portdox_t_nm ); ?>">
                                </div>
                            </li>
								<?php
							}
							?>
                        </ul>

                        <div class="text-box">
                            <h2>Customer Satisfied</h2>
                            <p>4.8 (15k Reviews)</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Testimonial One Img-->
        </div>
    </div>
</section>
<!--End Testimonial One-->


<?php
get_footer();
