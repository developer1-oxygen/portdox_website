<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Team Details || portdox</title>
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
                    <h2>Team Details</h2>
                    <ul class="thm-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><span class="icon-right-arrow21"></span></li>
                        <li>Team Details</li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Header-->

        <!--Start Team Details-->
        <section class="team-details">
            <div class="container">
                <div class="team-details__top">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="team-details__top-img">
                                <div class="inner">
                                    <img src="assets/images/team/team-details-img1.jpg" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="team-details__top-content">
                                <div class="title-box">
                                    <div class="tagline">
                                        <div class="text">
                                            <p>CONSULTANT</p>
                                        </div>
                                        <div class="line"></div>
                                    </div>
                                    <h2>Esther Howard</h2>
                                </div>
                                <div class="team-details__top-content-text">
                                    <p>With a passion for innovation, we stay abreast of the latest industry trends to
                                        ensure our clients benefit from cutting-edge insurance solutions. At ABC
                                        Insurance Services, </p>
                                </div>

                                <div class="team-details__top-content-contact">
                                    <ul>
                                        <li>
                                            <h4>Make A Call</h4>
                                            <p><a href="tel:1234567890">680 123 456 789</a></p>
                                        </li>

                                        <li>
                                            <h4>Send Us Mail</h4>
                                            <p><a href="mailto:info@portdox.com">info@portdox.com</a></p>
                                        </li>

                                        <li>
                                            <h4>Web Address</h4>
                                            <p><a href="https://www.google.com/">www.google.com</a></p>
                                        </li>
                                    </ul>
                                </div>

                                <div class="team-details__top-social-links">
                                    <a href="#"><span class="icon-facebook-f"></span></a>
                                    <a href="#"><span class="icon-instagram"></span></a>
                                    <a href="#"><span class="icon-twitter"></span></a>
                                    <a href="#"><span class="icon-linkedin"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="team-details__bottom">
                <div class="team-details__bottom-pattern"
                    style="background-image: url(assets/images/pattern/team-details__bottom-pattern.png);"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="team-details__bottom-progress">
                                <h2>My Skills</h2>
                                <p>With a passion for innovation, we stay abreast of the latest industry trends to
                                    ensure our clients benefit from cutting-edge insurance solutions. At ABC Insurance
                                    Services, </p>

                                <ul class="skill-one__progress">
                                    <li>
                                        <div class="skill-one__progress-single">
                                            <div class="title-box">
                                                <p>Product Delivery</p>
                                            </div>

                                            <div class="bar">
                                                <div class="bar-inner count-bar" data-percent="85%">
                                                    <div class="count-text">85%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="skill-one__progress-single">
                                            <div class="title-box">
                                                <p>Quick Response</p>
                                            </div>

                                            <div class="bar">
                                                <div class="bar-inner count-bar" data-percent="90%">
                                                    <div class="count-text">90%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="skill-one__progress-single">
                                            <div class="title-box">
                                                <p>Customer Satisfaction</p>
                                            </div>

                                            <div class="bar">
                                                <div class="bar-inner count-bar" data-percent="70%">
                                                    <div class="count-text">70%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>



                        <div class="col-xl-6">
                            <div class="team-details__bottom-contact">
                                <div class="title-box">
                                    <h2>Give Us A Message</h2>
                                    <p>Our dedicated team of experts is here to guide you through every step of the
                                        insurance journey, ensuring you make informed choices tailored to your unique
                                        needs. </p>
                                </div>




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
                                                    <select class="selectmenu wide">
                                                        <option selected="selected">Subject</option>
                                                        <option>Freight Type 01</option>
                                                        <option>Freight Type 02</option>
                                                        <option>Freight Type 03</option>
                                                        <option>Freight Type 04</option>
                                                        <option>Freight Type 05</option>
                                                    </select>
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
                    </div>
                </div>
            </div>
        </section>
        <!--End Team Details-->

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