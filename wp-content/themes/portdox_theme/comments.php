<?php
/**
 * Comments template (single posts and pages that support comments).
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="comments" class="comments-area portdox-comments-area">
	<?php if ( have_comments() ) : ?>
		<div class="comment-one">
			<div class="title-box">
				<h2>
					<?php
					$portdox_c_count = get_comments_number();
					printf(
						esc_html( _n( '%s Comment', '%s Comments', $portdox_c_count, 'portdox_theme' ) ),
						esc_html( number_format_i18n( $portdox_c_count ) )
					);
					?>
				</h2>
			</div>

			<ol class="comment-list">
				<?php
				wp_list_comments(
					array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 100,
						'callback'    => 'portdox_comment_callback',
					)
				);
				?>
			</ol>

			<?php the_comments_navigation(); ?>
		</div>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'portdox_theme' ); ?></p>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
		<div class="comment-form portdox-comment-form-shell">
			<?php portdox_render_comment_form(); ?>
		</div>
	<?php endif; ?>
</div>
