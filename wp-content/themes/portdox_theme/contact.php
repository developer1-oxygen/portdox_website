<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Contact || portdox</title>
    <!-- favicons Icons -->
   
    <meta name="description" content="Logistiq HTML 5 Template " />

    <?php include_once("__head.php");?>
    <style type="text/css">
        .error{ color:red; }
        .success{ color:green; }
        .success{ top: 26px !important; }
    </style>

</head>

<body>
    <!----
        --->
    <!-- Start Preloader -->
    <?php include_once("__loader_icon.php");?>
    <!-- End Preloader -->

    <div class="page-wrapper">

        <!--Start Main Header One-->
        <?php include_once("__nav.php");?>
        <!--End Main Header One-->

        <div class="stricky-header stricky-header--style1 stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->

        <!--Start Page Header-->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg.jpg)">
            </div>
            <div class="page-header__pattern"><img src="assets/images/pattern/page-header-pattern.png" alt=""></div>
            <div class="container">
                <div class="page-header__inner">
                    <h2>Contact Us</h2>
                    <ul class="thm-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><span class="icon-right-arrow21"></span></li>
                        <li>Contact Us</li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Header-->

        <!--Start Contact Page-->
        <section class="contact-page">
            <!--Start Contact Page Top-->
            <div class="contact-page__top">
                <div class="contact-page__top-pattern"
                    style="background-image: url(assets/images/pattern/contact-page-top-pattern.png);"></div>
                <div class="container">
                    <div class="row">
                        <!--Start Contact Page Top Content-->
                        <div class="col-xl-6">
                            <div class="contact-page__top-content">
                                <div class="sec-title tg-heading-subheading animation-style2">
                                    <div class="sec-title__tagline">
                                        <div class="line"></div>
                                        <div class="text tg-element-title">
                                            <h4>Contact us</h4>
                                        </div>
                                        <div class="icon">
                                            <span class="icon-plane2 float-bob-x3"></span>
                                        </div>
                                    </div>
                                    <h2 class="sec-title__title tg-element-title">Get in Touch And We’ll <br> Help Your
                                        Business
                                    </h2>
                                </div>

                                <div class="contact-page__top-content-text1">
                                    <p>Our dedicated team of experts is here to guide you through every step of the
                                        insurance journey, ensuring you make informed choices tailored to your uniq
                                        needs choices tailored to your unique needs. </p>
                                </div>

                                <div class="social-links">
                                    <a href="#"><span class="icon-facebook-f"></span></a>
                                    <a href="#"><span class="icon-instagram"></span></a>
                                    <a href="#"><span class="icon-twitter"></span></a>
                                    <a href="#"><span class="icon-linkedin"></span></a>
                                </div>
                            </div>
                        </div>
                        <!--End Contact Page Top Content-->

                        <!--Start Contact Page Top Form-->
                        <div class="col-xl-6">
                            <div class="contact-page__top-form">
                                <form class="contact-form-validated why-choose-one__form"
                                    action="assets/inc/sendemail.php" method="post" novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="input-box">
                                                <input type="text" name="name" placeholder="Name" required="">
                                                <div class="icon"><span class="icon-user"></span></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="input-box">
                                                <input type="email" name="email" placeholder="Email" required="">
                                                <div class="icon"><span class="icon-email"></span></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="input-box">
                                                <input type="text" name="Phone" placeholder="Phone" required="">
                                                <div class="icon"><span class="icon-phone2"></span></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="input-box">
                                                <div class="select-box">
                                                    <input type="text" name="subject" placeholder="Subject" required="">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-xl-12">
                                            <div class="input-box">
                                                <textarea name="message" placeholder="Message"></textarea>
                                                <div class="icon style2"><span class="icon-pen"></span></div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="why-choose-one__form-btn">
                                                <button type="submit" class="thm-btn">
                                                    Submit Now
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
                                <div class="result"></div>
                            </div>
                        </div>
                        <!--End Contact Page Top Form-->
                    </div>
                </div>
            </div>
            <!--End Contact Page Top-->

            <!--Start Contact Page Bottom-->
            <div class="contact-page__bottom">
                <div class="container">
                    <div class="contact-page__bottom-inner">
                        <ul class="list-unstyled">
                            <li class="contact-page__bottom-single">
                                <div class="icon">
                                    <span class="icon-address"></span>
                                </div>
                                <div class="content">
                                    <h2>Location</h2>
                                    <p>280 Granite Run Drive <br> SuiteHobert, LA 90010, USA.</p>
                                </div>
                            </li>

                            <li class="contact-page__bottom-single">
                                <div class="icon">
                                    <span class="icon-clock2"></span>
                                </div>
                                <div class="content">
                                    <h2>Working Hours</h2>
                                    <p>Wednesday - Sunday <br> 7:00 AM - 5:00 PM</p>
                                </div>
                            </li>

                            <li class="contact-page__bottom-single">
                                <div class="icon">
                                    <span class="icon-email"></span>
                                </div>
                                <div class="content">
                                    <h2>Email</h2>
                                    <p>
                                        <?php include __DIR__ . '/__inline-contact-email.php'; ?>
                                    </p>
                                </div>
                            </li>

                            <li class="contact-page__bottom-single">
                                <div class="icon">
                                    <span class="icon-phone"></span>
                                </div>
                                <div class="content">
                                    <h2>Phones</h2>
                                    <p>
                                       
                                        <a href="tel:880123456789">+880 123 456 789</a>
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--End Contact Page Bottom-->
        </section>
        <!--End Contact Page-->

        <!--Start Google Map One-->
        aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
        <section class="google-map-one">
           
        </section>
        <!--End Google Map One-->

        <!--Start Footer Two-->
        <?php include_once("__footer.php");?>
        <!--End Footer Two-->

    </div><!-- /.page-wrapper -->


    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <!-- /.mobile-nav__overlay -->
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

            <div class="logo-box">
                <a href="index.php" aria-label="logo image"><img src="assets/images/resources/logo-1.png" width="150"
                        alt="" /></a>
            </div>
            <!-- /.logo-box -->
            <div class="mobile-nav__container"></div>
            <!-- /.mobile-nav__container -->

            <ul class="mobile-nav__contact list-unstyled">
                <li>
                    <i class="fa fa-envelope"></i>
                    <a href="mailto:needhelp@logistiq.com">needhelp@logistiq.com</a>
                </li>
                <li>
                    <i class="icon-phone"></i>
                    <a href="tel:666-888-0000">666 888 0000</a>
                </li>
            </ul><!-- /.mobile-nav__contact -->
            <div class="mobile-nav__top">
                <div class="mobile-nav__social">
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-facebook-square"></a>
                    <a href="#" class="fab fa-pinterest-p"></a>
                    <a href="#" class="fab fa-instagram"></a>
                </div><!-- /.mobile-nav__social -->
            </div><!-- /.mobile-nav__top -->



        </div>
        <!-- /.mobile-nav__content -->
    </div>
    <!-- /.mobile-nav__wrapper -->

    <div class="search-popup">
        <div class="search-popup__overlay search-toggler"></div>
        <!-- /.search-popup__overlay -->
        <div class="search-popup__content">
            <form action="#">
                <label for="search" class="sr-only">search here</label><!-- /.sr-only -->
                <input type="text" id="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="thm-btn">
                    <i class="fas fa-search"></i>
                    <span class="hover-btn hover-bx"></span>
                    <span class="hover-btn hover-bx2"></span>
                    <span class="hover-btn hover-bx3"></span>
                    <span class="hover-btn hover-bx4"></span>
                </button>
            </form>
        </div>
        <!-- /.search-popup__content -->
    </div>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
        <span class="scroll-to-top__wrapper"><span class="scroll-to-top__inner"></span></span>
        <span class="scroll-to-top__text"> Go Back Top</span>
    </a>


    
    <script src="assets/js/jquery.ajaxchimp.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>

    <script src="assets/js/swiper.min.js"></script>
    <script src="assets/js/wNumb.min.js"></script>
    <script src="assets/js/curved-text/jquery.circleType.js"></script>
    <script src="assets/js/curved-text/jquery.fittext.js"></script>
    <script src="assets/js/curved-text/jquery.lettering.min.js"></script>
    <script src="assets/js/gsap/gsap.js"></script>
    <script src="assets/js/gsap/ScrollTrigger.js"></script>
    <script src="assets/js/gsap/SplitText.js"></script>


    <script src="assets/js/01-bootstrap.bundle.min.js"></script>
    <script src="assets/js/02-countdown.min.js"></script>
    <script src="assets/js/03-jquery.appear.min.js"></script>
    <script src="assets/js/04-jquery.nice-select.min.js"></script>
    <script src="assets/js/05-jquery-sidebar-content.js"></script>
    <script src="assets/js/06-marquee.min.js"></script>
    <script src="assets/js/07-owl.carousel.min.js"></script>
    <script src="assets/js/08-jarallax.min.js"></script>
    <script src="assets/js/09-odometer.min.js"></script>
    <script src="assets/js/10-jquery-ui.js"></script>
    <script src="assets/js/11-jquery.magnific-popup.min.js"></script>
    <script src="assets/js/12-wow.js"></script>
    <script src="assets/js/13-isotope.js"></script>

    <!-- template js -->
    <script src="assets/js/script.js"></script>
</body>

</html>