<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];
    $country = $_POST['country'];

    // Email details
    $to = "f.gill1024@gmail.com"; // Replace with your email
    $subject = "New Demo Request";
    $message = "
        <html>
        <head>
            <title>Demo Request</title>
        </head>
        <body>
            <p><strong>First Name:</strong> $first_name</p>
            <p><strong>Last Name:</strong> $last_name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Company:</strong> $company</p>
            <p><strong>Country:</strong> $country</p>
        </body>
        </html>
    ";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: <$email>" . "\r\n";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Home One || Portdox </title>
    <!-- favicons Icons -->
   
    <meta name="description" content="Logistiq HTML 5 Template " />

    <?php include_once("__head.php");?>

    <style>
        .error-border {
            border: 2px solid red !important;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
    </style>


</head>

<body>

    <!-- Start Preloader -->
    <?php include_once("__loader_icon.php");?>
   
    <!-- End Preloader -->

    <div class="page-wrapper">

        <?php include_once("__nav.php");?>
        
        <!--End Main Header One-->

        <div class="stricky-header stricky-header--style1 stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->

        <!--Start Banner One-->
        <section class="banner-one">
            <div class="banner-one__pattern"
                style="background-image: url(assets/images/pattern/banner-v1-pattern.png);"></div>
            <div class="banner-one__pattern2"><img src="assets/images/pattern/banner-v1-pattern2.png" alt="#"></div>

            <div class="banner-one__img1"><img class="float-bob-x" src="assets/images/banner/banner-v1-img1.png"
                    alt="#"></div>
            <div class="banner-one__img5"><img class="float-bob-y" src="assets/images/banner/banner-v1-img5.png"
                    alt="#"></div>
            <div class="shape1 rotate-me"><img src="assets/images/shapes/banner-v1-shape1.png?v=12" alt="#"></div>
            <div class="container">
                <div class="banner-one__location clearfix">

                    <!-- Start Banner One Location single -->
                    <div class="banner-one__location-single style1">
                        <div class="round-box">
                            <div class="bdr"></div>
                        </div>
                        <div class="content-box">
                            <div class="img-box">
                                <img src="assets/images/banner/banner-v1-flag1.png" alt="">
                            </div>
                            <div class="text-box">
                                <h4>London</h4>
                                <p>Logistic service <br> provider </p>
                            </div>
                        </div>
                    </div>
                    <!-- Start Banner One Location single -->

                    <!-- Start Banner One Location single -->
                    <div class="banner-one__location-single style2">
                        <div class="round-box">
                            <div class="bdr"></div>
                        </div>
                        <div class="content-box">
                            <div class="img-box">
                                <img src="assets/images/banner/banner-v1-flag1.png" alt="">
                            </div>
                            <div class="text-box">
                                <h4>Alexander City</h4>
                                <p>Logistic service <br> provider </p>
                            </div>
                        </div>
                    </div>
                    <!--End Banner One Location single -->

                    <!-- Start Banner One Location single -->
                    <div class="banner-one__location-single style3">
                        <div class="round-box">
                            <div class="bdr"></div>
                        </div>
                        <div class="content-box">
                            <div class="img-box">
                                <img src="assets/images/banner/banner-v1-flag1.png" alt="">
                            </div>
                            <div class="text-box">
                                <h4>Birmingham</h4>
                                <p>Logistic service <br> provider </p>
                            </div>
                        </div>
                    </div>
                    <!-- End Banner One Location single -->

                    <!-- Start Banner One Location single -->
                    <div class="banner-one__location-single style4">
                        <div class="round-box">
                            <div class="bdr"></div>
                        </div>
                        <div class="content-box">
                            <div class="img-box">
                                <img src="assets/images/banner/banner-v1-flag1.png" alt="">
                            </div>
                            <div class="text-box">
                                <h4>Guntersville</h4>
                                <p>Logistic service <br> provider </p>
                            </div>
                        </div>
                    </div>
                    <!-- End Banner One Location single -->

                    <!-- Start Banner One Location single -->
                    <div class="banner-one__location-single style5">
                        <div class="round-box">
                            <div class="bdr"></div>
                        </div>
                        <div class="content-box">
                            <div class="img-box">
                                <img src="assets/images/banner/banner-v1-flag1.png" alt="">
                            </div>
                            <div class="text-box">
                                <h4>Montgomery</h4>
                                <p>Logistic service <br> provider </p>
                            </div>
                        </div>
                    </div>
                    <!-- End Banner One Location single -->

                    <!-- Start Banner One Location single -->
                    <div class="banner-one__location-single style6">
                        <div class="round-box">
                            <div class="bdr"></div>
                        </div>

                        <div class="content-box">
                            <div class="img-box">
                                <img src="assets/images/banner/banner-v1-flag1.png" alt="">
                            </div>
                            <div class="text-box">
                                <h4>California</h4>
                                <p>Logistic service <br> provider </p>
                            </div>
                        </div>
                    </div>
                    <!-- End Banner One Location single -->

                    <!-- Start Banner One Location single -->
                    <div class="banner-one__location-single style7">
                        <div class="round-box">
                            <div class="bdr"></div>
                        </div>
                        <div class="content-box">
                            <div class="img-box">
                                <img src="assets/images/banner/banner-v1-flag1.png" alt="">
                            </div>
                            <div class="text-box">
                                <h4>Colorado</h4>
                                <p>Logistic service <br> provider </p>
                            </div>
                        </div>
                    </div>
                    <!-- End Banner One Location single -->

                    <!-- Start Banner One Location single -->
                    <div class="banner-one__location-single style8">
                        <div class="round-box">
                            <div class="bdr"></div>
                        </div>
                        <div class="content-box">
                            <div class="img-box">
                                <img src="assets/images/banner/banner-v1-flag1.png" alt="">
                            </div>
                            <div class="text-box">
                                <h4>Berlin</h4>
                                <p>Logistic service <br> provider </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Banner One Location single -->

                <div class="banner-one__content">
                    <div class="banner-one__content-left wow fadeInLeft" data-wow-delay="0ms"
                        data-wow-duration="1500ms">
                        <h2>DRIVING CARGO  <br>
                            <span>AHEAD</span></h2>
                        <p>Specialist In Modern <br> Transportation and warehousing </p>
                    </div>

                    <div class="banner-one__content-right wow fadeInRight" data-wow-delay="0ms"
                        data-wow-duration="1500ms">
                        <div class="banner-one__content-right-text">
                            <p>Logistic service provider company plays a pivotal role <br>
                                in the global supply chain ecosystem managing.</p>
                        </div>

                        <div class="banner-one__content-right-middle">
                            <ul class="clearfix">
                                <li>
                                    <div class="img-box"><img src="assets/images/banner/banner-v1-img2.jpg" alt="#">
                                    </div>
                                </li>
                                <li>
                                    <div class="img-box"><img src="assets/images/banner/banner-v1-img3.jpg" alt="#">
                                    </div>
                                </li>
                                <li>
                                    <div class="img-box"><img src="assets/images/banner/banner-v1-img4.jpg" alt="#">
                                    </div>
                                </li>
                            </ul>

                            <div class="text-box">
                                <h2>Customer Satisfied</h2>
                                <p>4.8 (15k Reviews)</p>
                            </div>
                        </div>

                        <div class="banner-one__content-right-btn">
                            <a class="thm-btn" href="about.php">About Us
                                <i class="icon-right-arrow21"></i>
                                <span class="hover-btn hover-bx"></span>
                                <span class="hover-btn hover-bx2"></span>
                                <span class="hover-btn hover-bx3"></span>
                                <span class="hover-btn hover-bx4"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Banner One-->

        

        <!--Start Project One-->
        <section class="project-one">
            <div class="container">
              
            </div>
        </section>
       

     
        <?php include_once("__book_a_demo.php");?>
       

        <!--Start Skill One-->
        <section class="skill-one">
            <div class="container">
                <div class="row">
                    <!--Start Skill One Img-->
                    <div class="col-xl-5">
                        <div class="skill-one__img">
                            <div class="shape1 float-bob-y"><img src="assets/images/shapes/skill-v1-shape1.png" alt="">
                            </div>
                            <div class="shape2 float-bob-y"><img src="assets/images/shapes/skill-v1-shape2.png" alt="">
                            </div>
                            <div class="skill-one__img1 wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <img src="assets/images/resources/skill-v1-img1.jpg" alt="">
                            </div>
                            <div class="skill-one__img2 wow fadeInRight" data-wow-delay="0ms"
                                data-wow-duration="1500ms">
                                <div class="inner">
                                    <img src="assets/images/resources/skill-v1-img2.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Skill One Img-->

                    <!--Start Skill One Content-->
                    <div class="col-xl-7">
                        <div class="skill-one__content">
                            <div class="sec-title tg-heading-subheading animation-style2">
                                <div class="sec-title__tagline">
                                    <div class="line"></div>
                                    <div class="text tg-element-title">
                                        <h4>Our Skills</h4>
                                    </div>
                                    <div class="icon">
                                        <span class="icon-plane2 float-bob-x3"></span>
                                    </div>
                                </div>
                                <h2 class="sec-title__title tg-element-title">Innovative Solutions for <br> Warehouse and Logistics
                                    <span>Management</span>
                                </h2>
                            </div>

                            <div class="skill-one__content-text">
                                <p>Revolutionize warehouse and logistics management with innovative software solutions. Enhance visibility, automate tasks, and deliver exceptional service with our user-friendly, cloud-based platform.</p>
                            </div>

                            <ul class="skill-one__progress">
                                <li>
                                    <div class="skill-one__progress-single">
                                        <div class="title-box">
                                            <p>Shipping</p>
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
                                            <p>Management</p>
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
                                            <p>Warehousing</p>
                                        </div>

                                        <div class="bar">
                                            <div class="bar-inner count-bar" data-percent="70%">
                                                <div class="count-text">70%</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <div class="skill-one__content-btn">
                                <a class="thm-btn" href="about.php">Book Your Parcel
                                    <i class="icon-right-arrow21"></i>
                                    <span class="hover-btn hover-bx"></span>
                                    <span class="hover-btn hover-bx2"></span>
                                    <span class="hover-btn hover-bx3"></span>
                                    <span class="hover-btn hover-bx4"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--End Skill One Content-->
                </div>
            </div>
        </section>
        <!--End Skill One-->

     


        <?php include_once("__footer.php");?>
        <!--End Footer One-->

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