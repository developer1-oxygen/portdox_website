<?php
/**
 * Search results template.
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$portdox_assets = get_template_directory_uri();
$portdox_search  = get_search_query();
$paged          = max(
	1,
	get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : (int) get_query_var( 'page' )
);

if ( '' !== $portdox_search ) {
	/* translators: %s: search query */
	$page_heading = sprintf( __( 'Search results for "%s"', 'portdox_theme' ), $portdox_search );
} else {
	$page_heading = __( 'Search', 'portdox_theme' );
}
?>
		<!--Start Page Header-->
		<section class="page-header">
			<div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_assets ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
			</div>
			<div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
			<div class="container">
				<div class="page-header__inner">
					<h2><?php echo esc_html( $page_heading ); ?></h2>
					<ul class="thm-breadcrumb">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'portdox_theme' ); ?></a></li>
						<li><span class="icon-right-arrow21"></span></li>
						<li><?php esc_html_e( 'Search', 'portdox_theme' ); ?></li>
					</ul>
				</div>
			</div>
		</section>
		<!--End Page Header-->

		<!--Start Blog Page-->
		<section class="blog-page">
			<div class="container">
				<div class="row justify-content-center mb-4">
					<div class="col-xl-8 col-lg-10">
						<div class="sidebar__single sidebar__search wow fadeInUp" data-wow-delay=".1s">
							<form role="search" method="get" class="sidebar__search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search…', 'portdox_theme' ); ?>" value="<?php echo esc_attr( $portdox_search ); ?>">
								<button type="submit"><i class="fa fa-search"></i></button>
							</form>
						</div>
					</div>
				</div>

				<div class="row">
					<?php
					if ( have_posts() ) :
						$delay = 0.3;
						while ( have_posts() ) :
							the_post();
							$thumb = get_the_post_thumbnail_url( get_the_ID(), 'large' );
							if ( ! $thumb ) {
								$thumb = $portdox_assets . '/assets/images/blog/blog-v1-img1.jpg';
							}
							$excerpt = get_the_excerpt();
							if ( '' === trim( $excerpt ) ) {
								$excerpt = wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) ), 22, '…' );
							}
							?>
					<div class="col-xl-4 col-lg-6 wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
						<div class="blog-one__single">
							<div class="blog-one__single-img">
								<a href="<?php the_permalink(); ?>">
									<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
								</a>
							</div>
							<div class="blog-one__single-content">
								<?php if ( 'post' === get_post_type() ) : ?>
								<div class="date-box">
									<h2><?php echo esc_html( get_the_date( 'd' ) ); ?></h2>
									<p><?php echo esc_html( get_the_date( 'M' ) ); ?></p>
								</div>
								<?php else : ?>
									<?php
									$portdox_pt = get_post_type_object( get_post_type() );
									$portdox_pt_label = $portdox_pt && isset( $portdox_pt->labels->singular_name ) ? $portdox_pt->labels->singular_name : get_post_type();
									?>
								<div class="date-box">
									<h2>—</h2>
									<p><?php echo esc_html( $portdox_pt_label ); ?></p>
								</div>
								<?php endif; ?>
								<div class="blog-one__single-content-inner">
									<ul class="meta-box">
										<?php if ( 'post' === get_post_type() ) : ?>
										<li>
											<div class="icon">
												<span class="icon-user"></span>
											</div>
											<div class="text-box">
												<p><?php the_author_posts_link(); ?></p>
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
										<?php else : ?>
										<li>
											<div class="icon">
												<span class="icon-right-arrow21"></span>
											</div>
											<div class="text-box">
												<p>
													<?php
													$portdox_pt = get_post_type_object( get_post_type() );
													echo esc_html( $portdox_pt && isset( $portdox_pt->labels->singular_name ) ? $portdox_pt->labels->singular_name : get_post_type() );
													?>
												</p>
											</div>
										</li>
										<?php endif; ?>
									</ul>
									<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<p><?php echo esc_html( wp_strip_all_tags( $excerpt ) ); ?></p>
									<div class="btn-box">
										<a class="thm-btn" href="<?php the_permalink(); ?>">
											<?php esc_html_e( 'Read More', 'portdox_theme' ); ?>
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
					</div>
							<?php
							$delay += 0.1;
						endwhile;
					else :
						?>
					<div class="col-12">
						<p class="text-center py-5">
							<?php
							if ( '' !== $portdox_search ) {
								esc_html_e( 'Sorry, no results matched your search. Try different keywords.', 'portdox_theme' );
							} else {
								esc_html_e( 'Enter a search term above.', 'portdox_theme' );
							}
							?>
						</p>
					</div>
					<?php endif; ?>
				</div>

				<?php
				global $wp_query;
				if ( $wp_query->max_num_pages > 1 ) :
					$total = (int) $wp_query->max_num_pages;
					$portdox_s = get_query_var( 's' );
					?>
				<ul class="styled-pagination text-center clearfix">
					<?php
					if ( $paged > 1 ) :
						$prev = $paged - 1;
						$prev_url = 1 === $prev
							? add_query_arg( 's', $portdox_s, home_url( '/' ) )
							: add_query_arg( array( 's' => $portdox_s, 'paged' => $prev ), home_url( '/' ) );
						?>
					<li class="arrow prev"><a href="<?php echo esc_url( $prev_url ); ?>"><span class="icon-right-arrow3"></span></a></li>
					<?php endif; ?>

					<?php
					for ( $i = 1; $i <= $total; $i++ ) :
						$link = 1 === $i
							? add_query_arg( 's', $portdox_s, home_url( '/' ) )
							: add_query_arg( array( 's' => $portdox_s, 'paged' => $i ), home_url( '/' ) );
						?>
					<li class="<?php echo $i === $paged ? 'active' : ''; ?>"><a href="<?php echo esc_url( $link ); ?>"><?php echo (int) $i; ?></a></li>
					<?php endfor; ?>

					<?php if ( $paged < $total ) : ?>
						<?php
						$next_url = add_query_arg(
							array(
								's'     => $portdox_s,
								'paged' => $paged + 1,
							),
							home_url( '/' )
						);
						?>
					<li class="arrow next"><a href="<?php echo esc_url( $next_url ); ?>"><span class="icon-right-arrow31"></span></a></li>
					<?php endif; ?>
				</ul>
				<?php endif; ?>
			</div>
		</section>
		<!--End Blog Page-->
<?php
get_footer();
