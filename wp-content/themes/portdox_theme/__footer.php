<?php
/**
 * Footer: phone, subscribe (AJAX → Subscribers CPT).
 *
 * @package Portdox_Theme
 */
$portdox_footer_phone = portdox_get_service_sidebar_phone_display();
$portdox_footer_tel   = portdox_get_service_sidebar_phone_tel();
$portdox_footer_href  = '' !== $portdox_footer_tel ? 'tel:' . $portdox_footer_tel : '#';
$portdox_social       = portdox_get_social_profile_urls();
?>
<!--Start Footer One-->
<footer class="footer-one">
    <div class="footer-one__pattern"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pattern/footer-v1-pattern.png' ); ?>" alt="#"></div>
    <div class="footer-one__top">
        <div class="container">
            <div class="footer-one__top-inner">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                        <div class="footer-widget__single footer-one__about">
                            <div class="footer-one__about-logo">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( portdox_get_footer_logo_url() ); ?>"
                                        alt=""></a>
                            </div>
                            <p class="footer-one__about-text">Portdox is an all-in-one Freight Forwarding, Shipment Management & Document Handling Software designed to streamline logistics operations, vehicle tracking, and warehouse workflows.</p>

                            <div class="footer-one__about-contact-info">
                                <div class="icon">
                                    <span class="icon-support"></span>
                                </div>

                                <div class="text-box">
                                    <p><?php esc_html_e( 'Make a Call', 'portdox_theme' ); ?></p>
                                    <h4><a href="<?php echo esc_url( $portdox_footer_href ); ?>"><?php echo esc_html( $portdox_footer_phone ); ?></a></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                        <div class="footer-widget__single footer-one__quick-links">
                            <div class="title">
                                <h2>Quick Links <span class="icon-plane3"></span></h2>
                            </div>

                            <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'portdox_footer_quick_links',
                                    'container'      => false,
                                    'menu_class'     => 'footer-one__quick-links-list',
                                    'menu_id'        => '',
                                    'fallback_cb'    => 'portdox_footer_quick_links_fallback',
                                    'depth'          => 1,
                                    'link_before'    => '<span class="icon-right-arrow1"></span> ',
                                )
                            );
                            ?>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                        <div class="footer-widget__single footer-one__contact">
                            <div class="title">
                                <h2>Get In Touch <span class="icon-plane3"></span></h2>
                            </div>

                            <div class="footer-one__contact-box">
                                <ul>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-address"></span>
                                        </div>
                                        <div class="text-box">
                                            <p><?php echo portdox_get_contact_address_html(); ?></p>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="icon">
                                            <span class="icon-email"></span>
                                        </div>
                                        <div class="text-box">
                                            <p><a href="mailto:<?php echo esc_attr( portdox_get_contact_email() ); ?>"><?php echo esc_html( portdox_get_contact_email() ); ?></a></p>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="icon">
                                            <span class="icon-phone"></span>
                                        </div>
                                        <div class="text-box">
                                            <p><a href="<?php echo esc_url( $portdox_footer_href ); ?>"><?php echo esc_html( $portdox_footer_phone ); ?></a></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                        <div class="footer-widget__single footer-one__subscribe">
                            <div class="title">
                                <h2>Subscribe Us <span class="icon-plane3"></span></h2>
                            </div>

                            <p class="footer-one__subscribe-text">Sign up for alerts, our latest blogs, <br>
                                thoughts, and insights</p>

                            <p id="portdox-subscribe-message" class="portdox-subscribe-notice" hidden aria-live="polite"></p>

                            <div class="footer-one__subscribe-form">
                                <form class="subscribe-form portdox-subscribe-form" action="#" method="post" novalidate>
                                    <input type="email" name="email" placeholder="<?php esc_attr_e( 'Your E-mail', 'portdox_theme' ); ?>" required autocomplete="email">
                                    <button type="submit" class="thm-btn"><?php esc_html_e( 'Subscribe', 'portdox_theme' ); ?>
                                        <i class="icon-right-arrow21"></i>
                                        <span class="hover-btn hover-bx"></span>
                                        <span class="hover-btn hover-bx2"></span>
                                        <span class="hover-btn hover-bx3"></span>
                                        <span class="hover-btn hover-bx4"></span>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-one__bottom">
        <div class="container">

            <div class="footer-one__bottom-inner">
                <div class="footer-one__bottom-text">
                    <p>© Copyright 2024 <a href="<?php echo esc_url( home_url( '/' ) ); ?>">portdox.com</a> All Rights Reserved</p>
                </div>

                <div class="footer-one__social-links">
                    <ul>
                        <li>
                            <a href="<?php echo esc_url( $portdox_social['facebook'] ); ?>" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'portdox_theme' ); ?>"><span class="icon-facebook-f"></span></a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( $portdox_social['instagram'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'portdox_theme' ); ?>"><span class="icon-instagram"></span></a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( $portdox_social['linkedin'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'LinkedIn', 'portdox_theme' ); ?>"><span class="icon-linkedin"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>