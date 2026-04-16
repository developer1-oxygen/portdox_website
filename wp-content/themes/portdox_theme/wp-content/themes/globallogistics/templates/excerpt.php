<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_template_excerpt_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_template_excerpt_theme_setup', 1 );
	function themerex_template_excerpt_theme_setup() {
		themerex_add_template(array(
			'layout' => 'excerpt',
			'mode'   => 'blog',
			'title'  => esc_html__('Excerpt', 'globallogistics'),
			'thumb_title'  => esc_html__('Large image (crop)', 'globallogistics'),
			'w'		 => 1150,
			'h'		 => 547
		));
	}
	// Add template specific scripts
	add_action('themerex_action_blog_scripts', 'themerex_template_popup_add_scripts');
}

// Add template specific scripts
if (!function_exists('themerex_template_popup_add_scripts')) {
	function themerex_template_popup_add_scripts() {
			themerex_enqueue_popup();
		}
	}


// Template output
if ( !function_exists( 'themerex_template_excerpt_output' ) ) {
	function themerex_template_excerpt_output($post_options, $post_data) {
		$show_title = !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote'));
        $tag = function_exists('themerex_sc_in_shortcode_blogger') && themerex_sc_in_shortcode_blogger(true) ? 'div' : 'article';
		?>
		<<?php themerex_show_layout($tag); ?> <?php post_class('post_item post_item_excerpt post_featured_' . esc_attr($post_options['post_class']) . ' post_format_'.esc_attr($post_data['post_format']) . ($post_options['number']%2==0 ? ' even' : ' odd') . ($post_options['number']==0 ? ' first' : '') . ($post_options['number']==$post_options['posts_on_page']? ' last' : '') . ($post_options['add_view_more'] ? ' viewmore' : '')); ?>>
			<?php
			if ($post_data['post_flags']['sticky']) {
				?><span class="sticky_label"></span><?php
			}

			if (!$post_data['post_protected'] && (!empty($post_options['dedicated']) || $post_data['post_thumb'] || $post_data['post_gallery'] || $post_data['post_video'] || $post_data['post_audio'])) {
				?>
				<div class="post_featured">
				<?php
				if (!empty($post_options['dedicated'])) {
					themerex_show_layout($post_options['dedicated']);
				} else if ($post_data['post_thumb'] || $post_data['post_gallery'] || $post_data['post_video'] || $post_data['post_audio']) {
					require(themerex_get_file_dir('templates/parts/post-featured.php'));
				}
				?>
				</div>
			<?php
			}
			?>

			<div class="post_content clearfix">

				<?php
				if ($show_title && !empty($post_data['post_title']) && $post_options['location'] == 'right') {
					?><h3 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php themerex_show_layout($post_data['post_title']); ?></a></h3><?php
				}
				?>

				<?php
				if ($show_title && !empty($post_data['post_title']) && $post_options['location'] != 'right') {
					?><h3 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php themerex_show_layout($post_data['post_title']); ?></a></h3><?php
				}

				if (!$post_data['post_protected'] && $post_options['info'] && !in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status'))) {
					require(themerex_get_file_dir('templates/parts/post-info.php'));
				}
				?>

				<div class="post_descr">
				<?php
					if ($post_data['post_protected']) {
						themerex_show_layout($post_data['post_excerpt']);
					} else {
						if ($post_data['post_excerpt']) {
							if (in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status'))){
								themerex_show_layout($post_data['post_excerpt']);
							} else if (themerex_get_custom_option('post_excerpt_maxlength') != 0) {
								echo '<p>'.trim(themerex_strshort($post_data['post_excerpt'], isset($post_options['descr']) ? $post_options['descr'] : themerex_get_custom_option('post_excerpt_maxlength'))).'</p>';
							}
						}
					}
					if (empty($post_options['readmore'])) $post_options['readmore'] = esc_html__('READ MORE', 'globallogistics');
					if (!themerex_param_is_off($post_options['readmore']) && !in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status'))) {
					    if (shortcode_exists('trx_button')) {
                            echo do_shortcode('[trx_button align="right" icon="icon-right" bg_style="underline" link="'.esc_url($post_data['post_link']).'"]'.($post_options['readmore']).'[/trx_button]');
                        } else {
                            echo '<a href="'.esc_url($post_data['post_link']).'">'.($post_options['readmore']).'</a>';
                        }
					}?></div>

			</div>	<!-- /.post_content -->

		</<?php themerex_show_layout($tag); ?>>	<!-- /.post_item -->

	<?php
	}
}
?>