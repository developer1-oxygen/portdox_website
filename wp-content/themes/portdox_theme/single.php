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
					<div class="col-12 col-xl-4 order-2">
						<div class="sidebar">
							<div class="sidebar__single sidebar__search wow fadeInUp" data-wow-delay=".1s">
								<form role="search" method="get" class="sidebar__search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
									<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search...', 'portdox_theme' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
									<button type="submit"><i class="fa fa-search"></i></button>
								</form>
							</div>

							<div class="sidebar__single sidebar__category wow fadeInUp" data-wow-delay=".1s">
								<h3 class="sidebar__title"><?php esc_html_e( 'Categories', 'portdox_theme' ); ?></h3>
								<ul class="sidebar__category-list">
									<?php
									$portdox_cats = get_categories(
										array(
											'orderby'    => 'name',
											'hide_empty' => true,
										)
									);
									foreach ( $portdox_cats as $portdox_cat ) {
										$portdox_cat_link = get_category_link( $portdox_cat->term_id );
										echo '<li><a href="' . esc_url( $portdox_cat_link ) . '">' . esc_html( $portdox_cat->name ) . ' <span>(' . absint( $portdox_cat->count ) . ')</span></a></li>';
									}
									?>
								</ul>
							</div>

							<?php
							$portdox_recent = new WP_Query(
								array(
									'post_type'           => 'post',
									'posts_per_page'      => 3,
									'post__not_in'        => array( get_the_ID() ),
									'ignore_sticky_posts' => true,
									'no_found_rows'       => true,
								)
							);
							if ( $portdox_recent->have_posts() ) :
								?>
							<div class="sidebar__single sidebar__post wow fadeInUp" data-wow-delay=".1s">
								<h3 class="sidebar__title"><?php esc_html_e( 'Recent Post', 'portdox_theme' ); ?></h3>
								<div class="sidebar__post-box">
									<?php
									while ( $portdox_recent->have_posts() ) :
										$portdox_recent->the_post();
										$rthumb = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
										if ( ! $rthumb ) {
											$rthumb = $portdox_assets . '/assets/images/blog/blog-v1-img1.jpg';
										}
										?>
										<div class="sidebar__post-single">
											<div class="sidebar-post__img">
												<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $rthumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"></a>
											</div>
											<div class="sidebar__post-content-box">
												<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											</div>
										</div>
										<?php
									endwhile;
									wp_reset_postdata();
									?>
								</div>
							</div>
							<?php endif; ?>
						</div>
					</div>

					<div class="col-12 col-xl-8 order-1">
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
								<h2><?php the_title(); ?></h2>
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
											<h2><?php esc_html_e( 'Tags:', 'portdox_theme' ); ?></h2>
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
