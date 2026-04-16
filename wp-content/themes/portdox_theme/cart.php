<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Cart || portdox</title>
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
                    <h2>Cart</h2>
                    <ul class="thm-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><span class="icon-right-arrow21"></span></li>
                        <li>Cart</li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Header-->

        <!--Start Cart Page-->
        <section class="cart-page">
            <div class="container">
                <div class="table-responsive">
                    <table class="table cart-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>
                                    <div class="product-box">
                                        <div class="img-box">
                                            <img src="assets/images/shop/cart-page-img-1.jpg" alt="">
                                        </div>
                                        <h3><a href="product-details.php">Comfy chair</a></h3>
                                    </div>
                                </td>
                                <td>$10.99</td>
                                <td>
                                    <div class="quantity-box">
                                        <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                                        <input type="number" id="product-1" value="1" />
                                        <button type="button" class="add"><i class="fa fa-plus"></i></button>
                                    </div>
                                </td>
                                <td>
                                    $10.99
                                </td>
                                <td>
                                    <div class="cross-icon">
                                        <i class="fas fa-times"></i>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="product-box">
                                        <div class="img-box">
                                            <img src="assets/images/shop/cart-page-img-2.jpg" alt="">
                                        </div>
                                        <h3><a href="product-details.php">Classic chair</a></h3>
                                    </div>
                                </td>
                                <td>$10.99</td>
                                <td>
                                    <div class="quantity-box">
                                        <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                                        <input type="number" id="product-2" value="1" />
                                        <button type="button" class="add"><i class="fa fa-plus"></i></button>
                                    </div>
                                </td>
                                <td>
                                    $10.99
                                </td>
                                <td>
                                    <div class="cross-icon">
                                        <i class="fas fa-times"></i>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <form action="#" class="default-form cart-cupon__form">
                            <input type="text" placeholder="Enter Coupon Code" class="cart-cupon__input">
                            <button class="thm-btn" type="submit">
                                Apply Coupon
                                <span class="hover-btn hover-bx"></span>
                                <span class="hover-btn hover-bx2"></span>
                                <span class="hover-btn hover-bx3"></span>
                                <span class="hover-btn hover-bx4"></span>
                            </button>
                        </form>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <ul class="cart-total list-unstyled">
                            <li>
                                <span>Subtotal</span>
                                <span>$20.98 USD </span>
                            </li>
                            <li>
                                <span>Shipping Cost</span>
                                <span>$0.00 USD</span>
                            </li>
                            <li>
                                <span>Total</span>
                                <span class="cart-total-amount">$20.98 USD</span>
                            </li>
                        </ul>
                        <div class="cart-page__buttons">
                            <div class="cart-page__buttons-1">
                                <a class="thm-btn" href="#">Update
                                    <span class="hover-btn hover-bx"></span>
                                    <span class="hover-btn hover-bx2"></span>
                                    <span class="hover-btn hover-bx3"></span>
                                    <span class="hover-btn hover-bx4"></span>
                                </a>
                            </div>
                            <div class="cart-page__buttons-2">
                                <a href="checkout.php" class="thm-btn">Checkout
                                    <span class="hover-btn hover-bx"></span>
                                    <span class="hover-btn hover-bx2"></span>
                                    <span class="hover-btn hover-bx3"></span>
                                    <span class="hover-btn hover-bx4"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Cart Page-->

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