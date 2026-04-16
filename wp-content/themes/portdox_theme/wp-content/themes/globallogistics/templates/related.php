<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_template_related_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_template_related_theme_setup', 1 );
	function themerex_template_related_theme_setup() {
		themerex_add_template(array(
			'layout' => 'related',
			'mode'   => 'blogger',
			'need_columns' => true,
			'title'  => esc_html__('Related posts /no columns/', 'globallogistics'),
			'thumb_title'  => esc_html__('Default image Related(crop)', 'globallogistics'),
			'w'		 => 400,
			'h'		 => 250
		));
		themerex_add_template(array(
			'layout' => 'related_2',
			'template' => 'related',
			'mode'   => 'blog',
			'need_columns' => true,
			'title'  => esc_html__('Related posts /2 columns/', 'globallogistics'),
			'thumb_title'  => esc_html__('Large image Related(crop)', 'globallogistics'),
			'w'		 => 750,
			'h'		 => 442
		));
		themerex_add_template(array(
			'layout' => 'related_3',
			'template' => 'related',
			'mode'   => 'blog',
			'need_columns' => true,
			'title'  => esc_html__('Related posts /3 columns/', 'globallogistics'),
			'thumb_title'  => esc_html__('Medium image Related(crop)', 'globallogistics'),
			'w'		 => 400,
			'h'		 => 350
		));
		themerex_add_template(array(
			'layout' => 'related_4',
			'template' => 'related',
			'mode'   => 'blog',
			'need_columns' => true,
			'title'  => esc_html__('Related posts /4 columns/', 'globallogistics'),
			'thumb_title'  => esc_html__('Small image Related(crop)', 'globallogistics'),
			'w'		 => 250,
			'h'		 => 200
		));
	}
}

// Template output
if ( !function_exists( 'themerex_template_related_output' ) ) {
	function themerex_template_related_output($post_options, $post_data) {
		$show_title = true;
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(4, empty($parts[1]) ? $post_options['columns_count'] : (int) $parts[1]));
        $tag = function_exists('themerex_sc_in_shortcode_blogger') && themerex_sc_in_shortcode_blogger(true) ? 'div' : 'article';
		if ($columns > 1) {
			?>
			<div class="<?php echo 'column-1_'.esc_attr($columns); ?> column_padding_bottom">
			<?php
		}
		?>
		<<?php themerex_show_layout($tag); ?> class="post_item post_item_<?php echo esc_attr($style); ?> post_item_<?php echo esc_attr($post_options['number']); ?>">

			<div class="post_content">
				<?php if ($post_data['post_video'] || $post_data['post_thumb'] || $post_data['post_gallery']) { ?>
				<div class="post_featured">

					<?php
					if ($post_data['post_thumb'] && ($post_data['post_format']!='gallery' || !$post_data['post_gallery'])) {
						?>
						<div class="post_thumb">
							<?php
							if ($post_data['post_format']=='link' && $post_data['post_url']!='')
								echo '<a href="'.esc_url($post_data['post_url']).'"'.($post_data['post_url_target'] ? ' target="'.esc_attr($post_data['post_url_target']).'"' : '').'>'.($post_data['post_thumb']).'</a>';
							else if ($post_data['post_link']!='') {
								echo '<a href="' . esc_url($post_data['post_link']) . '">' .($post_data['post_thumb']). '</a>';
							}
							else
								themerex_show_layout($post_data['post_thumb']);
							?>
						</div>
					<?php
					} else if ($post_data['post_gallery']) {
						themerex_enqueue_slider();
                        themerex_show_layout($post_data['post_gallery']);
					}
					?>

				</div>
				<?php } ?>

				<?php if ($show_title) { ?>
					<div class="post_content_wrap">
					<?php if (!isset($post_options['links']) || $post_options['links']) { ?>
						<h4 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php themerex_show_layout($post_data['post_title']); ?></a></h4>
					<?php } else { ?>
						<h4 class="post_title"><?php themerex_show_layout($post_data['post_title']); ?></h4>
					<?php }	?>

					<span class="post_info_posted post_info_date" itemprop="datePublished">
						<?php echo esc_html($post_data['post_date']); ?>
					</span>

					</div>
				<?php } ?>
			</div>	<!-- /.post_content -->
		</<?php themerex_show_layout($tag); ?>>	<!-- /.post_item -->
		<?php
		if ($columns > 1) {
			?>
			</div>
			<?php
		}
	}
}
?>