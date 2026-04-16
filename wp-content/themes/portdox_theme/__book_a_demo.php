<?php
/**
 * Home / marketing “Request a Demo” block — same form as template-book-a-demo.php (AJAX + SweetAlert).
 *
 * @package Portdox_Theme
 */

$portdox_assets = get_template_directory_uri();
?>
<section class="why-choose-one">
    <div class="why-choose-one__pattern">
        <img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/pattern/why-choose-v1-pattern.png" alt="">
    </div>
    <div class="shape1 float-bob-y"><img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/shapes/why-choose-v1-shape1.png" alt=""></div>
    <div class="container">
        <div class="row">
            <!--Start Why Choose One Content-->
            <div class="col-xl-6">
                <div class="why-choose-one__content">
                    <div class="sec-title tg-heading-subheading animation-style2">
                        <div class="sec-title__tagline">
                            <div class="line"></div>
                            <div class="text tg-element-title">
                                <h4><?php esc_html_e( 'Why Choose us', 'portdox_theme' ); ?></h4>
                            </div>
                            <div class="icon">
                                <span class="icon-plane2 float-bob-x3"></span>
                            </div>
                        </div>
                        <h2 class="sec-title__title tg-element-title"><?php esc_html_e( 'Efficient, Safe, & Swift', 'portdox_theme' ); ?> <br> <?php esc_html_e( 'Logistics', 'portdox_theme' ); ?>
                            <span><?php esc_html_e( 'Solution!', 'portdox_theme' ); ?></span></h2>
                    </div>

                    <div class="why-choose-one__content-list">
                        <ul>
                            <li>
                                <p><span class="icon-plane2"></span> <?php esc_html_e( 'Make long term business decisions', 'portdox_theme' ); ?></p>
                            </li>
                            <li>
                                <p><span class="icon-plane2"></span> <?php esc_html_e( 'Transparent career journey and support.', 'portdox_theme' ); ?></p>
                            </li>
                            <li>
                                <p><span class="icon-plane2"></span> <?php esc_html_e( 'Be a responsible member of the community', 'portdox_theme' ); ?>
                                </p>
                            </li>
                            <li>
                                <p><span class="icon-plane2"></span> <?php esc_html_e( 'Provide a service we are proud of', 'portdox_theme' ); ?></p>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-box">
                        <a class="thm-btn" href="<?php echo esc_url( portdox_url_for_page_slug( 'contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'portdox_theme' ); ?>
                            <i class="icon-right-arrow21"></i>
                            <span class="hover-btn hover-bx"></span>
                            <span class="hover-btn hover-bx2"></span>
                            <span class="hover-btn hover-bx3"></span>
                            <span class="hover-btn hover-bx4"></span>
                        </a>
                    </div>
                </div>
            </div>
            <!--End Why Choose One Content-->

            <!--Start Why Choose One Form-->
            <div class="col-xl-6">
                <div class="why-choose-one__form-box wow fadeInRight" data-wow-delay="0ms"
                    data-wow-duration="1500ms">
                    <div class="title-box">
                        <h2><?php esc_html_e( 'Request a Demo', 'portdox_theme' ); ?></h2>
                    </div>

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
            <!--End Why Choose One Form-->
        </div>
    </div>
</section>
