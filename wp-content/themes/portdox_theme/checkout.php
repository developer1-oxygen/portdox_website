<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Checkout || portdox</title>
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
                    <h2>Checkout</h2>
                    <ul class="thm-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><span class="icon-right-arrow21"></span></li>
                        <li>Checkout</li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Header-->

        <!--Start Checkout Page-->
        <section class="checkout-page">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="billing_details">
                            <div class="billing_title">
                                <p>Returning Customer? <span>Click here to Login</span></p>
                                <h2>Billing details</h2>
                            </div>
                            <form class="billing_details_form">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="billing_input_box">
                                            <div class="select-box">
                                                <select class="wide">
                                                    <option data-display="Select a country">Select a country</option>
                                                    <option value="1">Canada</option>
                                                    <option value="2">England</option>
                                                    <option value="3">Australia</option>
                                                    <option value="3">USA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row bs-gutter-x-20">
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input type="text" name="first_name" value="" placeholder="First name"
                                                required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input type="text" name="last_name" value="" placeholder="Last name"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="billing_input_box">
                                            <input type="text" name="company_name" value="" placeholder="Company">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="billing_input_box">
                                            <input type="text" name="Address" value="" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="billing_input_box">
                                            <input type="text" name="company_name" value=""
                                                placeholder="Appartment, unit, etc. (optional)">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="billing_input_box">
                                            <input type="text" name="Town/City" value="" placeholder="Town / City"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row bs-gutter-x-20">
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input type="text" name="State" value="" placeholder="State" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input name="form_zip" type="text" pattern="[0-9]*" placeholder="Zip code">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input name="email" type="email" placeholder="Email address">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input type="tel" name="form_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                                required="" placeholder="Phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="checked-box">
                                            <input type="checkbox" name="skipper1" id="skipper" checked="">
                                            <label for="skipper"><span></span>Create an account?</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6">
                        <div class="billing_details ship_different_address">
                            <div class="billing_title ship_different_address_title">
                                <h2>Ship to a different address <span class="fa fa-check-circle"></span></h2>
                            </div>
                            <form class="billing_details_form ship_different_address_form">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="billing_input_box">
                                            <div class="select-box">
                                                <select class="wide">
                                                    <option data-display="Select a country">Select a country</option>
                                                    <option value="1">Canada</option>
                                                    <option value="2">England</option>
                                                    <option value="3">Australia</option>
                                                    <option value="3">USA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row bs-gutter-x-20">
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input type="text" name="first_name" value="" placeholder="First name"
                                                required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input type="text" name="last_name" value="" placeholder="Last name"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="billing_input_box">
                                            <input type="text" name="company_name" value="" placeholder="Company">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="billing_input_box">
                                            <input type="text" name="Address" value="" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="billing_input_box">
                                            <input type="text" name="company_name" value=""
                                                placeholder="Appartment, unit, etc. (optional)">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="billing_input_box">
                                            <input type="text" name="Town/City" value="" placeholder="Town / City"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row bs-gutter-x-20">
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input type="text" name="State" value="" placeholder="State" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input name="form_zip" type="text" pattern="[0-9]*" placeholder="Zip code">
                                        </div>
                                    </div>
                                </div>

                                <div class="row bs-gutter-x-20">
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input name="email" type="email" placeholder="Email address">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="billing_input_box">
                                            <input type="tel" name="form_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                                required="" placeholder="Phone">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="ship_different_input">
                                            <textarea placeholder="Notes about order"
                                                name="form_order_notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="your_order">
                    <h2>Your order</h2>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <div class="order_table_box">
                                <table class="order_table_detail">
                                    <thead class="order_table_head">
                                        <tr>
                                            <th>Product</th>
                                            <th class="right">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="pro__title">Product Name</td>
                                            <td class="pro__price">$10.99 USD</td>
                                        </tr>
                                        <tr>
                                            <td class="pro__title">Subtotal</td>
                                            <td class="pro__price">$10.99 USD</td>
                                        </tr>
                                        <tr>
                                            <td class="pro__title">Shipping</td>
                                            <td class="pro__price">$0.00 USD</td>
                                        </tr>
                                        <tr>
                                            <td class="pro__title">Total</td>
                                            <td class="pro__price">$20.98 USD</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="checkout__payment">
                                <div class="checkout__payment__item checkout__payment__item--active">
                                    <h3 class="checkout__payment__title">Direct bank transfer</h3>
                                    <div class="checkout__payment__content">
                                        Make your payment directly into our bank account. Please
                                        use your Order ID as the payment reference. Your order
                                        wont be shipped until the funds have cleared.
                                    </div><!-- /.checkout__payment__content -->
                                </div><!-- /.checkout__payment__item -->
                                <div class="checkout__payment__item">
                                    <h3 class="checkout__payment__title">Paypal payment <img
                                            src="assets/images/shop/paypal-1.jpg" alt=""></h3>
                                    <div class="checkout__payment__content">
                                        Make your payment directly into our bank account. Please
                                        use your Order ID as the payment reference. Your order
                                        wont be shipped until the funds have cleared.
                                    </div><!-- /.checkout__payment__content -->
                                </div><!-- /.checkout__payment__item -->
                            </div><!-- /.checkout__payment -->
                            <div class="text-right d-flex justify-content-end">
                                <a class="thm-btn" href="checkout.php">Place your order
                                    <i class="icon-right-arrow21"></i>
                                    <span class="hover-btn hover-bx"></span>
                                    <span class="hover-btn hover-bx2"></span>
                                    <span class="hover-btn hover-bx3"></span>
                                    <span class="hover-btn hover-bx4"></span>
                                </a>
                            </div><!-- /.text-right -->

                        </div><!-- /.col-lg-6 -->
                    </div>
                </div>
            </div>
        </section>
        <!--End Checkout Page-->

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