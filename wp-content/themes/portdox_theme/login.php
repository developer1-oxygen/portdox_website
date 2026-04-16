<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Account || portdox</title>
    <!-- favicons Icons -->
   
    <meta name="description" content="Logistiq HTML 5 Template " />

    <?php include_once("__head.php");?>
</head>

<body>

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
                    <h2>Login Here</h2>
                    <ul class="thm-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><span class="icon-right-arrow21"></span></li>
                        <li>Login Here</li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Header-->


        <!--Start Login One-->
        <section class="login-one">
            <div class="container">
                <div class="login-one__form">
                    <div class="inner-title text-center">
                        <h2>Login Here</h2>
                    </div>
                    <form id="login-one__form" name="Login-one_form" action="#" method="post">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <div class="input-box">
                                        <input type="email" name="form_email" id="formEmail" placeholder="Email..."
                                            required="" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <div class="input-box">
                                        <input type="text" name="form_password" id="formPassword"
                                            placeholder="Password..." required="" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <button class="thm-btn" type="submit" data-loading-text="Please wait...">
                                        Login Here
                                        <span class="hover-btn hover-bx"></span>
                                        <span class="hover-btn hover-bx2"></span>
                                        <span class="hover-btn hover-bx3"></span>
                                        <span class="hover-btn hover-bx4"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="remember-forget">
                                <div class="checked-box1">
                                    <input type="checkbox" name="saveMyInfo" id="saveinfo" checked="">
                                    <label for="saveinfo">
                                        <span></span>
                                        Remember me
                                    </label>
                                </div>
                                <div class="forget">
                                    <a href="#">Forget password?</a>
                                </div>
                            </div>

                            <div class="create-account text-center">
                                <p>Not registered yet? <a href="sign-up.php">Create an Account</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!--End Login One-->


        <!--Start Footer Two-->
        <footer class="footer-one footer-one--two">
            <div class="footer-one__pattern">
                <img src="assets/images/pattern/footer-v1-pattern.png" alt="#">
            </div>
            <div class="shape3 float-bob-y">
                <img src="assets/images/shapes/footer-v2-shape3.png" alt="">
            </div>
            <div class="footer-one__top">
                <div class="container">

                    <div class="footer-one--two__cta">
                        <div class="shape1">
                            <img class="float-bob-x3" src="assets/images/shapes/footer-v2-shape2.png" alt="">
                        </div>
                        <div class="shape2">
                            <img class="float-bob-y" src="assets/images/shapes/footer-v2-shape1.png" alt="">
                        </div>
                        <div class="footer-one--two__cta-inner">
                            <div class="text-box">
                                <h2>Efficient, Safe, & Swift Logistics Solution!</h2>
                            </div>

                            <div class="btn-box">
                                <a class="thm-btn" href="contact.php">Contact with Us
                                    <i class="icon-right-arrow21"></i>
                                    <span class="hover-btn hover-bx"></span>
                                    <span class="hover-btn hover-bx2"></span>
                                    <span class="hover-btn hover-bx3"></span>
                                    <span class="hover-btn hover-bx4"></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="footer-one__top-inner">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                                <div class="footer-widget__single footer-one__about">
                                    <div class="footer-one__about-logo">
                                        <a href="index.php"><img src="assets/images/resources/footer-logo.png"
                                                alt=""></a>
                                    </div>
                                    <p class="footer-one__about-text">Logistic service provider company plays a
                                        pivotal role in the global supply chain logistic service provider.</p>

                                    <div class="footer-one__about-contact-info">
                                        <div class="icon">
                                            <span class="icon-support"></span>
                                        </div>

                                        <div class="text-box">
                                            <p>Make a Call</p>
                                            <h4><a href="tel:+1234567890">+880 123 456 789</a></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                                <div class="footer-widget__single footer-one__quick-links">
                                    <div class="title">
                                        <h2>Quick Links <span class="icon-plane3"></span></h2>
                                    </div>

                                    <ul class="footer-one__quick-links-list">
                                        <li><a href="index.php"><span class="icon-right-arrow1"></span> Home</a></li>
                                        <li><a href="about.php"><span class="icon-right-arrow1"></span> About Us</a>
                                        </li>
                                        <li><a href="service.php"><span class="icon-right-arrow1"></span> Service</a>
                                        </li>
                                        <li><a href="project.php"><span class="icon-right-arrow1"></span> Latest
                                                Project</a></li>
                                        <li><a href="contact.php"><span class="icon-right-arrow1"></span> Contact
                                                Us</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                                <div class="footer-widget__single footer-one__contact">
                                    <div class="title">
                                        <h2>Get In Touch <span class="icon-plane3"></span></h2>
                                    </div>

                                    <div class="footer-one__contact-box">
                                        <ul>
                                            <?php include __DIR__ . '/__legacy-footer-address-email-items.php'; ?>

                                            <li>
                                                <div class="icon">
                                                    <span class="icon-phone"></span>
                                                </div>
                                                <div class="text-box">
                                                    <p><a href="tel:1234567890">+880 123 456 789 </a></p>
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

                                    <div class="footer-one__subscribe-form">
                                        <form class="subscribe-form" action="#">
                                            <input type="email" name="email" placeholder="Your E-mail">
                                            <button type="submit" class="thm-btn">Subcribe
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
                            <p>© Copyright 2024 <a href="index.php">Logistiq.</a> All Rights Reserved</p>
                        </div>

                        <div class="footer-one__social-links">
                            <ul>
                                <li>
                                    <a href="#"><span class="icon-facebook-f"></span></a>
                                </li>

                                <li>
                                    <a href="#"><span class="icon-instagram"></span></a>
                                </li>

                                <li>
                                    <a href="#"><span class="icon-twitter1"></span></a>
                                </li>
                                <li>
                                    <a href="#"><span class="icon-linkedin"></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
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