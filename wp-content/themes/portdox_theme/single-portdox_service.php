<?php
/**
 * Single blog post (replaces index.php fallback for posts).
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$portdox_assets = get_template_directory_uri();
$posts_page_id  = (int) get_option( 'page_for_posts' );
$blog_url       = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
$blog_label     = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Blog', 'portdox_theme' );

while ( have_posts() ) :
	the_post();
	?>
	<style type="text/css">
		.blog-details__content-img1{ max-width: 100% !important }
		.blog-details__content-meta-box ul li .img-box{ width:100% !important }
		.blog-details__content-text1 h2 {font-size: 36px;margin-bottom: 15px;}
	</style>


		<!--Start Page Header-->
		<section class="page-header">
			<div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_assets ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
			</div>
			<div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
			<div class="container">
				<div class="page-header__inner">
					<h2><?php echo esc_html( get_the_title() ); ?></h2>
					<ul class="thm-breadcrumb">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'portdox_theme' ); ?></a></li>
						<li><span class="icon-right-arrow21"></span></li>
						<li><a href="<?php echo esc_url( $blog_url ); ?>"><?php echo esc_html( $blog_label ); ?></a></li>
						<li><span class="icon-right-arrow21"></span></li>
						<li><?php echo esc_html( wp_trim_words( get_the_title(), 8, '…' ) ); ?></li>
					</ul>
				</div>
			</div>
		</section>
		<!--End Page Header-->

		<!--Start Blog Details-->
		<section class="blog-details">
			<div class="container">
				<div class="row">
					<?php
					/*
					 * Sidebar first in the DOM so stray </div> from the_content() or comments cannot
					 * close the .row before this column is parsed (fixes col-xl-4 dropping below).
					 * order-* restores [ main | sidebar ] on xl screens and main-first on small screens.
					 */
					?>
					

					<div class="col-12 col-xl-12 order-1">
						<div class="blog-details__content">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="blog-details__content-img1">
									<div class="inner">
										<?php
										the_post_thumbnail(
											'large',
											array(
												'alt' => esc_attr( get_the_title() ),
											)
										);
										?>
									</div>
								</div>
							<?php endif; ?>

							<div class="blog-details__content-meta-box">
								<ul>
									<li>
										<div class="img-box">
											<?php echo get_avatar( get_the_author_meta( 'ID' ), 48, '', '', array( 'class' => '' ) ); ?>
										</div>
										<div class="text-box">
											<p><?php the_author_posts_link(); ?></p>
										</div>
									</li>
									<li>
										<div class="icon">
											<span class="icon-calendar"></span>
										</div>
										<div class="text-box">
											<p><?php echo esc_html( get_the_date() ); ?></p>
										</div>
									</li>
									<li>
										<div class="icon">
											<span class="icon-chat"></span>
										</div>
										<div class="text-box">
											<p>
												<a href="<?php echo esc_url( get_comments_link() ); ?>">
													<?php
													printf(
														/* translators: %s: comment count */
														esc_html( _n( '%s Comment', '%s Comments', (int) get_comments_number(), 'portdox_theme' ) ),
														esc_html( number_format_i18n( get_comments_number() ) )
													);
													?>
												</a>
											</p>
										</div>
									</li>
								</ul>
							</div>

							<div class="blog-details__content-text1 entry-content">
								<h2 style=""><?php the_title(); ?></h2>
								<hr>
								<?php the_content(); ?>
								<?php
								wp_link_pages(
									array(
										'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'portdox_theme' ),
										'after'  => '</div>',
									)
								);
								?>
							</div>

							<?php if ( has_tag() ) : ?>
								<div class="blog-details__content-text5">
									<div class="blog-details__content-text5-tag">
										<div class="title-box">
											<h5><?php esc_html_e( 'Tags:', 'portdox_theme' ); ?></h5>
										</div>
										<ul>
											<?php
											$tags = get_the_tags();
											if ( $tags ) {
												foreach ( $tags as $tag ) {
													$link = get_tag_link( $tag->term_id );
													echo '<li><a href="' . esc_url( $link ) . '">#' . esc_html( $tag->name ) . '</a></li>';
												}
											}
											?>
										</ul>
									</div>
								</div>
							<?php endif; ?>

							<?php
							$share_url      = rawurlencode( get_permalink() );
							$portdox_social = portdox_get_social_profile_urls();
							?>
							<div class="blog-details__content-text5">
								<div class="blog-details__content-text5-share">
									<div class="title-box">
										<p><?php esc_html_e( 'Share Now', 'portdox_theme' ); ?></p>
									</div>
									<ul>
										<li>
											<a href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $share_url ); ?>" target="_blank" rel="noopener noreferrer">
												<span class="icon-facebook-f"></span>
											</a>
										</li>
										<li>
											<a href="<?php echo esc_url( $portdox_social['instagram'] ); ?>" target="_blank" rel="noopener noreferrer">
												<span class="icon-instagram"></span>
											</a>
										</li>
										<li>
											<a href="<?php echo esc_url( $portdox_social['linkedin'] ); ?>" target="_blank" rel="noopener noreferrer">
												<span class="icon-linkedin"></span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<?php comments_template(); ?>
					</div>
				</div>
			</div>
		</section>
		<!--End Blog Details-->
	<?php
endwhile;

get_footer();
