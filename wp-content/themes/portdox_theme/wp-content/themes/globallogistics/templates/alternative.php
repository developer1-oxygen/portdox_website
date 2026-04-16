<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_template_alternative_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_template_alternative_theme_setup', 1 );
	function themerex_template_alternative_theme_setup() {
		themerex_add_template(array(
			'layout' => 'alternative',
			'template' => 'alternative',
			'mode'   => 'blog',
			'need_isotope' => true,
			'title'  => esc_html__('Alternative tile (with hovers, different sizes)', 'globallogistics'),
			'thumb_title'  => esc_html__('Large image', 'globallogistics'),
			'w'		 => 750,
			'h_crop' => 422,
			'h'		 => null
		));
		// Add template specific scripts
		add_action('themerex_action_blog_scripts', 'themerex_template_alternative_add_scripts');
	}
}

// Add template specific scripts
if (!function_exists('themerex_template_alternative_add_scripts')) {
	function themerex_template_alternative_add_scripts($style) {
		if (themerex_substr($style, 0, 11) == 'alternative') {
			wp_enqueue_script( 'isotope', themerex_get_file_url('js/jquery.isotope.min.js'), array(), null, true );
		}
	}
}

// Return image dimensions for Portfolio Alternative
function getPortfolioThumbSizes($opt) {
	$opt = themerex_array_merge(array(
		'thumb_crop' => true,
		'thumb_size' => 'image-square-1'
	), $opt);
	$thumb_sizes = array(
		'image-square-1'          => array('w' => 420,'h' => $opt['thumb_crop'] ? 420 : null, 'h_crop' => 420),
		'image-square-2'          => array('w' => 840,'h' => $opt['thumb_crop'] ? 840 : null, 'h_crop' => 840),
		'image-rectangle'       => array('w' => 840,'h' => $opt['thumb_crop'] ? 420 : null, 'h_crop' => 420)
	);
	return isset($thumb_sizes[$opt['thumb_size']]) ? $thumb_sizes[$opt['thumb_size']] : '';
}


// Template output
if ( !function_exists( 'themerex_template_alternative_output' ) ) {
	function themerex_template_alternative_output($post_options, $post_data) {

		$style_image = themerex_get_custom_option('portfolio_image_style', null, $post_data['post_id']);
		$thumb_sizes = getPortfolioThumbSizes(array(
			'thumb_crop' => true,
			'thumb_size' => $style_image
		));

		$post_data['post_thumb'] = themerex_get_resized_image_tag($post_data['post_id'], $thumb_sizes['w'], $thumb_sizes['h']); //for new image

		$isotopeWidth = 1;
		$isotopeHeight = 1;

		switch ($style_image) {
			case 'image-square-2':
				$isotopeWidth = 2;
				$isotopeHeight = 2;
				break;
			case 'image-rectangle':
				$isotopeWidth = 2;
				$isotopeHeight = 1;
				break;
		}

		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$tag = 'article';
		$link_start = !isset($post_options['links']) || $post_options['links'] ? '<a href="'.esc_url($post_data['post_link']).'">' : '';
		$link_start_hover = !isset($post_options['links']) || $post_options['links'] ? '<a class="hover" href="'.esc_url($post_data['post_attachment']).'" title="'.esc_attr($post_data['post_title']).'">' : '';
		$link_end = !isset($post_options['links']) || $post_options['links'] ? '</a>' : '';

		// Alternative style
		?>
	<div data-width="<?php echo esc_attr($isotopeWidth); ?>" data-height="<?php echo esc_attr($isotopeHeight); ?>" class="isotope_item isotope_item_<?php echo esc_attr($style); ?>
						<?php
	if ($post_options['filters'] != '') {
		if ($post_options['filters']=='categories' && !empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids))
			echo ' flt_' . join(' flt_', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids);
		else if ($post_options['filters']=='tags' && !empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_ids))
			echo ' flt_' . join(' flt_', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_ids);
	}
	?>">
		<<?php themerex_show_layout($tag); ?> class="post_item post_item_<?php echo esc_attr($style); ?>
		<?php echo 'post_format_'.esc_attr($post_data['post_format'])
			. ($post_options['number']%2==0 ? ' even' : ' odd')
			. ($post_options['number']==0 ? ' first' : '')
			. ($post_options['number']==$post_options['posts_on_page'] ? ' last' : '');
		?>">

		<div class="post_content isotope_item_content">
			<div class="post_featured img">
				<?php
				themerex_show_layout($post_data['post_thumb']);
				?>


				<div class="hover_wrap">
					<div class="hover_content">

						<?php
						themerex_enqueue_popup();
						themerex_show_layout(($link_start_hover) . ($link_end)); ?>

						<div class="post_info">

							<h4 class="post_title"><?php themerex_show_layout(($link_start) . ($post_data['post_title']) . ($link_end)); ?></h4>

							<?php if ($post_options['filters'] != '' && $post_options['filters']=='tags') { ?>
								<?php if(!empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links)) { ?>
									<span class="info"><?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links); ?></span>
								<?php }
							} else {
								if (!empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_links)) {
									?>
									<span class="info"><?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_links); ?></span>
								<?php
								}
							} ?>

						</div>



					</div>
				</div>


			</div>
		</div>				<!-- /.post_content -->
		</<?php themerex_show_layout($tag); ?>>	<!-- /.post_item -->
		</div>						<!-- /.isotope_item -->
	<?php
	}
}
?>