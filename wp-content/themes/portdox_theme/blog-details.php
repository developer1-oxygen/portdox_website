<?php include_once("admin/db.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Blog Details || portdox</title>
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
                    <h2>Blog Details</h2>
                    <ul class="thm-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><span class="icon-right-arrow21"></span></li>
                        <li>Blog Details</li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Header-->

        <!--Start Blog Details-->
        <section class="blog-details">
            <div class="container">
                <?php 
                if(isset($_GET['id']) and $_GET['id']>0)
                {


                  $id     = $_GET['id'];

                    $query  = " SELECT * FROM articles where id='".$id."' "; 
                    $result = $conn->query($query);

                    // Display each article in a dynamic blog tile
                    while ($row = $result->fetch_assoc()):

                    #print "<pre>";print_r($row);print "</pre>";

                    $article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

                    $comments_count_query = "SELECT COUNT(*) AS total_comments FROM comments WHERE article_id = $article_id AND status = 'approved'";
                    $comments_count_result = $conn->query($comments_count_query);
                    $comments_count = $comments_count_result->fetch_assoc()['total_comments'];

                    // Fetch all 1 comments for the article
                    $comments_query = "SELECT * FROM comments WHERE article_id = $article_id AND status = 'approved' ORDER BY created_at DESC";
                    $comments_result = $conn->query($comments_query);
                    ?>

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="blog-details__content">
                                <div class="blog-details__content-img1">
                                    <div class="inner">
                                        <img src="assets/images/blog/blog-details-img1.jpg" alt="">
                                    </div>
                                </div>

                                <div class="blog-details__content-meta-box">
                                    <ul>
                                        <li>
                                            <div class="img-box">
                                                <img src="assets/images/blog/blog-details-img8.jpg" alt="">
                                            </div>

                                            <div class="text-box">
                                                <p>BY-Admin</p>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="icon">
                                                <span class="icon-calendar"></span>
                                            </div>

                                            <div class="text-box">
                                                <p><?= date("F j, Y", strtotime($row['article_date'])) ?></p>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="icon">
                                                <span class="icon-chat"></span>
                                            </div>

                                            <div class="text-box">
                                                <p>Comment(<?=$comments_count ?>)</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="blog-details__content-text1">
                                    <h2><?=htmlspecialchars($row['title']) ?></h2>
                                    <p><?=nl2br(htmlspecialchars( $row['content'])) ?></p>
                                </div>
                                <?php $tags = !empty($row['tags']) ? explode(',', $row['tags']) : []; ?>
                               

                               

                              


                                <div class="blog-details__content-text5">
                                    <div class="blog-details__content-text5-tag">
                                        <div class="title-box">
                                            <h2>Tags:</h2>
                                        </div>
                                        <ul>
                                            <?php foreach ($tags as $tag): ?>
                                                
                                                <!----search.php?tag=<?= urlencode(trim($tag)) ?>---->

                                                <li><a href="#">#<?= htmlspecialchars(trim($tag)) ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>

                                    
                                    <?php
                                    // Dynamically generate the current URL
                                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                                    $current_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                                    ?>
                                    <div class="blog-details__content-text5-share">
                                        <div class="title-box">
                                            <p>Share Now</p>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode($current_url) ?>" target="_blank">
                                                    <span class="icon-facebook-f"></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.instagram.com/?url=<?=urlencode($current_url) ?>" target="_blank">
                                                    <span class="icon-instagram"></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://twitter.com/intent/tweet?url=<?= urlencode($current_url) ?>&text=<?= urlencode($row['title']) ?>" target="_blank">
                                                    <span class="icon-twitter"></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($current_url) ?>&title=<?= urlencode($row['title']) ?>" target="_blank">
                                                    <span class="icon-linkedin"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                   
                                </div>


                                
                                <div class="comment-one">
                                    <div class="title-box">
                                        <h2><?= $comments_count ?> Comment<?= $comments_count != 1 ? 's' : '' ?></h2>
                                    </div>

                                    <?php while ($comment = $comments_result->fetch_assoc()): ?>
                                        <div class="comment-one__single">
                                            <div class="comment-one__single-inner">
                                                <div class="comment-one__img">
                                                    <!-- Default or user-specific image -->
                                                    <img src="<?= !empty($comment['user_image']) ? 'user_images/' . $comment['user_image'] : 'assets/images/blog/blog-details-img7.jpg' ?>" alt="User Image">
                                                </div>

                                                <div class="comment-one__content">
                                                    <div class="comment-one__content-title">
                                                        <h2><?= htmlspecialchars($comment['name']) ?></h2>
                                                        <p><?= date("d M Y, h:i A", strtotime($comment['created_at'])) ?></p>
                                                    </div>

                                                    <p><?= htmlspecialchars($comment['content']) ?></p>

                                                    <div class="btn-box">
                                                        <a href="#">Reply</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>

                                <div class="comment-form">
                                    <div class="title-box">
                                        <h2>Leave a Reply</h2>
                                        <p>Your email address will not be published. Required fields are marked *</p>
                                    </div>

                                    <form id="commentForm" class="contact-form-validated why-choose-one__form">
                                        <input type="hidden" name="article_id" value="<?= isset($article_id) ? $article_id : 0 ?>">
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

                                            <div class="col-xl-12">
                                                <div class="input-box">
                                                    <textarea name="message" placeholder="Message"></textarea>
                                                    <div class="icon style2"><span class="icon-pen"></span></div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <div class="comment-form__checkbox">
                                                    <input type="checkbox" name="agree" id="agree" checked>
                                                    <label for="agree"><span></span>Save my name, email, and website in this browser for the next time I comment.</label>
                                                </div>

                                                <div class="why-choose-one__form-btn">
                                                    <button type="button" id="commentFormBtn" class="thm-btn">
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

                        <!--Start Sidebar-->
                        <div class="col-xl-4">
                            <div class="sidebar">
                                <!--Start Sidebar Single-->
                                <div class="sidebar__single sidebar__search wow fadeInUp" data-wow-delay=".1s">
                                    <form action="search.php" method="GET" class="sidebar__search-form">
                                        <input type="search" name="keyword" placeholder="Search..." value="">
                                        <button type="submit"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                                <!--End Sidebar Single-->

                                <?php
                                // Fetch categories with the article count
                                $categories_query = "
                                    SELECT c.id, c.name, COUNT(a.id) AS article_count
                                    FROM categories c
                                    LEFT JOIN articles a ON c.id = a.category_id
                                    GROUP BY c.id
                                    ORDER BY c.name ASC";
                                $categories_result = $conn->query($categories_query);
                                ?>
                                <!--Start Sidebar Single-->
                                <div class="sidebar__single sidebar__category wow fadeInUp animated" data-wow-delay=".1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                                    <h3 class="sidebar__title">Categories</h3>
                                    <ul class="sidebar__category-list">
                                        <?php while ($category = $categories_result->fetch_assoc()): ?>
                                            <li>
                                                <a href="search.php?category_id=<?= $category['id'] ?>">
                                                    <?= htmlspecialchars($category['name']) ?> 
                                                    <span>(<?= $category['article_count'] ?>)</span>
                                                </a>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                                <!--End Sidebar Single-->
                                <?php
                                // Fetch recent posts from the database
                                $recent_posts_query = "SELECT id, title, image FROM articles ORDER BY article_date DESC LIMIT 3";
                                $recent_posts_result = $conn->query($recent_posts_query);
                                ?>
                                <!--Start Sidebar Single-->
                                <div class="sidebar__single sidebar__post wow fadeInUp" data-wow-delay=".1s">
                                    <h3 class="sidebar__title">Recent Post</h3>
                                    <div class="sidebar__post-box">
                                        <?php while ($post = $recent_posts_result->fetch_assoc()): ?>
                                            <div class="sidebar__post-single">
                                                <div class="sidebar-post__img">
                                                    <img src="<?= !empty($post['image']) ? 'article_images/' . $post['image'] : 'assets/images/blog/default-recent-post.jpg' ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                                                </div>
                                                <div class="sidebar__post-content-box">
                                                    <h3><a href="article_detail.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h3>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                                <!--End Sidebar Single-->

                                <?php
                                // Fetch all tags and split them into individual unique tags
                                $tags_query = "SELECT GROUP_CONCAT(tags) AS all_tags FROM articles";
                                $tags_result = $conn->query($tags_query);
                                $all_tags = [];

                                if ($tags_result) {
                                    $row = $tags_result->fetch_assoc();
                                    if (!empty($row['all_tags'])) {
                                        // Split all tags by commas and remove duplicates
                                        $all_tags = array_unique(array_map('trim', explode(',', $row['all_tags'])));
                                    }
                                }
                                ?>
                                <div class="sidebar__single sidebar__tags wow fadeInUp" data-wow-delay=".1s">
                                    <h3 class="sidebar__title">Tags Cloud</h3>
                                    <ul class="sidebar__tags-list clearfix">
                                        <?php foreach ($all_tags as $tag): ?>
                                            <li><a href="search.php?tag=<?= urlencode($tag) ?>"><?= htmlspecialchars($tag) ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <!--End Sidebar Single-->

                            </div>
                        </div>
                        <!--End Sidebar-->
                    </div>
                    <?php endwhile; ?>
                <?php 
                }
                ?>
            </div>
        </section>
        <!--End Blog Details-->

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#commentFormBtn').on('click', function (e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    url: 'add_comment.php', // The PHP script to handle the request
                    type: 'POST',
                    data: $('#commentForm').serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Display SweetAlert success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Comment Submitted!',
                                text: 'Your comment has been successfully added.',
                            }).then(() => {
                                // Append the new comment to the comment list
                                $('.comment-list').prepend(`
                                    <div class="comment">
                                        <strong>${response.name}</strong>
                                        <p>${response.message}</p>
                                        <small>${response.created_at}</small>
                                    </div>
                                `);
                                $('#commentForm')[0].reset(); // Reset the form
                            });
                        } else {
                            // Display SweetAlert error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Submission Failed',
                                text: response.error,
                            });
                        }
                    },
                    error: function () {
                        // Display SweetAlert error message for generic errors
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while submitting your comment. Please try again.',
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>