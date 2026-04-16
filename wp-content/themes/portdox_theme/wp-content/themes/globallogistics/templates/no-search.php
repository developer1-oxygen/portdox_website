<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_template_no_search_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_template_no_search_theme_setup', 1 );
	function themerex_template_no_search_theme_setup() {
		themerex_add_template(array(
			'layout' => 'no-search',
			'mode'   => 'internal',
			'title'  => esc_html__('No search results found', 'globallogistics'),
			'w'		 => null,
			'h'		 => null
		));
	}
}

// Template output
if ( !function_exists( 'themerex_template_no_search_output' ) ) {
	function themerex_template_no_search_output($post_options, $post_data) {
		?>
		<article class="post_item">
			<div class="post_content">
				<h2 class="post_title"><?php esc_html_e('Search Results for:', 'globallogistics'); ?></h2>
				<h1 class="post_subtitle"><?php echo get_search_query(); ?></h1>
				<p><?php esc_html_e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'globallogistics' ); ?></p>
				<p><?php echo wp_kses_data(sprintf(__('Go back, or return to <a href="%s">%s</a> home page to choose a new page.', 'globallogistics'), esc_url(home_url('/')), get_bloginfo())); ?>
				<br><?php esc_html_e('Please report any broken links to our team.', 'globallogistics'); ?></p>
				<?php echo do_shortcode('[trx_search class="search_opened" state="opened"]'); ?>
			</div>	<!-- /.post_content -->
		</article>	<!-- /.post_item -->
		<?php
	}
}
?>