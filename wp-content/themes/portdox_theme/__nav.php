<header class="main-header main-header-one">
    <nav class="main-menu">
        <div class="main-menu__wrapper">
            <div class="container">
                <div class="main-header-one__inner">
                    <div class="main-header-one__top">
                        <div class="main-header-one__top-inner">
                            <div class="main-header-one__top-left">
                                <div class="header-contact-style1">
                                    <ul>
                                        <li>
                                            <div class="icon">
                                                <span class="icon-phone"></span>
                                            </div>

                                            <div class="text-box">
                                                <p>
                                                    <span><?php esc_html_e( 'Talk to Us', 'portdox_theme' ); ?></span>
                                                    <?php
                                                    $portdox_nav_phone = portdox_get_service_sidebar_phone_display();
                                                    $portdox_nav_tel   = portdox_get_service_sidebar_phone_tel();
                                                    $portdox_nav_href  = '' !== $portdox_nav_tel ? 'tel:' . $portdox_nav_tel : '#';
                                                    ?>
                                                    <a href="<?php echo esc_url( $portdox_nav_href ); ?>"><?php echo esc_html( $portdox_nav_phone ); ?></a>
                                                </p>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="icon">
                                                <span class="icon-email"></span>
                                            </div>

                                            <div class="text-box">
                                                <p>
                                                    <span><?php esc_html_e( 'Mail Us', 'portdox_theme' ); ?></span>
                                                    <?php $portdox_nav_mail = portdox_get_contact_email(); ?>
                                                    <a href="mailto:<?php echo esc_attr( $portdox_nav_mail ); ?>"><?php echo esc_html( $portdox_nav_mail ); ?></a>
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="main-header-one__top-right">
								<?php $portdox_social = portdox_get_social_profile_urls(); ?>
                                <div class="header-social-links">
                                    <a href="<?php echo esc_url( $portdox_social['facebook'] ); ?>" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'portdox_theme' ); ?>"><span class="icon-facebook-f"></span></a>
                                    <a href="<?php echo esc_url( $portdox_social['instagram'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'portdox_theme' ); ?>"><span class="icon-instagram"></span></a>
                                    <a href="<?php echo esc_url( $portdox_social['linkedin'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'LinkedIn', 'portdox_theme' ); ?>"><span class="icon-linkedin"></span></a>
                                </div>

                                <div class="header-search-box">
                                    <a href="#" class="main-menu__search search-toggler">Search
                                        <i class="icon-search"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-header-one__bottom">
                        <div class="main-menu__wrapper-inner">
                            <div class="main-header-one__bottom-inner">
                                <div class="main-header-one__bottom-left">
                                    <div class="logo-box">
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( portdox_get_header_logo_url() ); ?>"
                                                alt=""></a>
                                    </div>

                                    <div class="main-header-one__bottom-menu">
                                        <div class="main-menu__main-menu-box">
                                            <a href="#" class="mobile-nav__toggler"><i
                                                    class="fa fa-bars"></i></a>
											<?php
											wp_nav_menu(
												array(
													'theme_location'  => 'portdox_primary',
													'container'       => false,
													'menu_class'      => 'main-menu__list',
													'fallback_cb'     => 'portdox_primary_menu_fallback',
													'depth'           => 4,
												)
											);
											?>
                                        </div>
                                    </div>
                                </div>

                                <div class="main-header-one__bottom-right">
                                    <div class="main-header-one__bottom-right-btn">
                                        <a href="<?php echo esc_url( portdox_url_for_page_slug( 'book-a-demo' ) ); ?>">Request a Demo
                                            <i class="icon-right-arrow21"></i>
                                        </a>
                                    </div>

                                    <div class="login-box">
                                        <a href="#"><i class="fa fa-sign-in"></i> <span>Member <br>
                                                Login</span> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>