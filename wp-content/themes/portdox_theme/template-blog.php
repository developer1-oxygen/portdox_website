<?php
/**
 * Blog listing markup (used by Portdox Blog page template).
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portdox_assets = get_template_directory_uri();
$blog_page_id   = get_queried_object_id();
$paged          = max(
	1,
	get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : (int) get_query_var( 'page' )
);

$blog_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => (int) get_option( 'posts_per_page', 9 ),
		'paged'               => $paged,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	)
);

$page_title = $blog_page_id ? get_the_title( $blog_page_id ) : __( 'Blog & News', 'portdox_theme' );
?>
		<style>
			.blog-page .row {
				align-items: stretch;
			}
			.blog-page .col-xl-4,
			.blog-page .col-lg-6 {
				display: flex;
			}
			.blog-page .blog-one__single {
				width: 100%;
				height: 100%;
				display: flex;
				flex-direction: column;
			}
			.blog-page .blog-one__single-content,
			.blog-page .blog-one__single-content-inner {
				flex: 1 1 auto;
				display: flex;
				flex-direction: column;
			}
			.blog-page .blog-one__single-content-inner .btn-box {
				margin-top: auto;
			}
		</style>
		<!--Start Page Header-->
		<section class="page-header">
			<div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_assets ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
			</div>
			<div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
			<div class="container">
				<div class="page-header__inner">
					<h2><?php echo esc_html( $page_title ); ?></h2>
					<ul class="thm-breadcrumb">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'portdox_theme' ); ?></a></li>
						<li><span class="icon-right-arrow21"></span></li>
						<li><?php echo esc_html( $page_title ); ?></li>
					</ul>
				</div>
			</div>
		</section>
		<!--End Page Header-->

		<!--Start Blog Page-->
		<section class="blog-page">
			<div class="container">
				<div class="row">
					<?php
					if ( function_exists( 'portdox_render_blog_one_cards' ) ) {
						portdox_render_blog_one_cards( $blog_query, $portdox_assets );
					}
					?>
				</div>

				<?php if ( $blog_query->max_num_pages > 1 ) : ?>
				<ul class="styled-pagination text-center clearfix">
					<?php
					$total = (int) $blog_query->max_num_pages;
					$page_url = get_permalink( $blog_page_id );
					if ( get_option( 'permalink_structure' ) ) {
						$base = trailingslashit( untrailingslashit( $page_url ) ) . '/page/%#%/';
					} else {
						$base = add_query_arg( 'paged', '%#%', $page_url );
					}

					if ( $paged > 1 ) :
						$prev = $paged - 1;
						$prev_url = 1 === $prev ? $page_url : ( get_option( 'permalink_structure' )
							? trailingslashit( untrailingslashit( $page_url ) ) . '/page/' . $prev . '/'
							: add_query_arg( 'paged', $prev, $page_url ) );
						?>
					<li class="arrow prev"><a href="<?php echo esc_url( $prev_url ); ?>"><span class="icon-right-arrow3"></span></a></li>
					<?php endif; ?>

					<?php
					for ( $i = 1; $i <= $total; $i++ ) :
						$link = 1 === $i ? $page_url : ( get_option( 'permalink_structure' )
							? trailingslashit( untrailingslashit( $page_url ) ) . '/page/' . $i . '/'
							: add_query_arg( 'paged', $i, $page_url ) );
						?>
					<li class="<?php echo $i === $paged ? 'active' : ''; ?>"><a href="<?php echo esc_url( $link ); ?>"><?php echo (int) $i; ?></a></li>
					<?php endfor; ?>

					<?php if ( $paged < $total ) : ?>
						<?php
						$next_url = get_option( 'permalink_structure' )
							? trailingslashit( untrailingslashit( $page_url ) ) . '/page/' . ( $paged + 1 ) . '/'
							: add_query_arg( 'paged', $paged + 1, $page_url );
						?>
					<li class="arrow next"><a href="<?php echo esc_url( $next_url ); ?>"><span class="icon-right-arrow31"></span></a></li>
					<?php endif; ?>
				</ul>
				<?php endif; ?>
			</div>
		</section>
		<!--End Blog Page-->
