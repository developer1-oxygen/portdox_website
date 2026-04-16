<?php
/*
 * The template for displaying "Page 404"
*/

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_template_404_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_template_404_theme_setup', 1 );
	function themerex_template_404_theme_setup() {
		themerex_add_template(array(
			'layout' => '404',
			'mode'   => 'internal',
			'title'  => 'Page 404',
			'theme_options' => array(
				'article_style' => 'stretch'
			),
			'w'		 => null,
			'h'		 => null
			));
	}
}

// Template output
if ( !function_exists( 'themerex_template_404_output' ) ) {
	function themerex_template_404_output() {
		?>
		<article class="post_item post_item_404">
			<div class="post_content">
				<h1 class="page_title"><?php esc_html_e( '404', 'globallogistics' ); ?></h1>
				<h4 class="page_subtitle"><?php esc_html_e('This Page Could Not Be Found!', 'globallogistics'); ?></h4>
				<p class="page_description"><?php echo wp_kses_data(sprintf( __('Go back, or return to <a href="%s">Global Logistics</a> home page to choose a new page.<br/>Please report any broken links to our team.', 'globallogistics'), esc_url(home_url('/')) )); ?></p>
			</div>
		</article>
		<?php
	}
}
?>