<?php
/**
 * The Header for our theme.
 */

global $THEMEREX_GLOBALS;

// Theme init - don't remove next row! Load custom options
themerex_core_init_theme();
$theme_skin = sanitize_file_name(themerex_get_custom_option('theme_skin'));
$blog_style = themerex_get_custom_option(is_singular() && !themerex_get_global('blog_streampage') ? 'single_style' : 'blog_style');
$body_style  = themerex_get_custom_option('body_style');
$article_style = 'stretch';
$top_panel_opacity = themerex_get_custom_option('top_panel_opacity');
$padding_content = themerex_get_custom_option('padding_content');
$top_panel_position = themerex_get_custom_option('top_panel_position');
$video_bg_show  = themerex_get_custom_option('show_video_bg')=='yes' && (themerex_get_custom_option('video_bg_youtube_code')!='' || themerex_get_custom_option('video_bg_url')!='');
$top_panel_image = themerex_get_custom_option('single_style') == 'single-fullscreen' ? true : false;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php
	wp_head();
	?>
</head>

<?php
	$class = $style = '';
	if ($body_style=='boxed' || themerex_get_custom_option('load_bg_image')=='always') {
		$customizer = themerex_get_theme_option('show_theme_customizer') == 'yes';
		if ($customizer && ($img = (int) themerex_get_value_gpc('bg_image', 0)) > 0)
			$class = 'bg_image_'.($img);
		else if ($customizer && ($img = (int) themerex_get_value_gpc('bg_pattern', 0)) > 0)
			$class = 'bg_pattern_'.($img);
		else if ($customizer && ($img = themerex_get_value_gpc('bg_color', '')) != '')
			$style = 'background-color: '.($img).';';
		else {
			if (($img = themerex_get_custom_option('bg_custom_image')) != '')
				$style = 'background: url('.esc_url($img).') ' . str_replace('_', ' ', themerex_get_custom_option('bg_custom_image_position')) . ' no-repeat fixed;';
			else if (($img = themerex_get_custom_option('bg_custom_pattern')) != '')
				$style = 'background: url('.esc_url($img).') 0 0 repeat fixed;';
			else if (($img = themerex_get_custom_option('bg_image')) > 0)
				$class = 'bg_image_'.($img);
			else if (($img = themerex_get_custom_option('bg_pattern')) > 0)
				$class = 'bg_pattern_'.($img);
			if (($img = themerex_get_custom_option('bg_color')) != '')
				$style .= 'background-color: '.($img).';';
		}
	}
?>

<body <?php 
	body_class('themerex_body body_style_' . esc_attr($body_style) 
		. ' body_' . (themerex_get_custom_option('body_filled')=='yes' ? 'filled' : 'transparent')
		. ' theme_skin_' . esc_attr($theme_skin)
		. ' article_style_' . esc_attr($article_style)
		. ' layout_' . esc_attr($blog_style)
		. ' template_' . esc_attr(themerex_get_template_name($blog_style))
		. ' top_panel_opacity_' . esc_attr($top_panel_opacity)
		. ' padding_content_' . esc_attr($padding_content)
		. ($top_panel_position  != 'hide' ? ' top_panel_show top_panel_' . esc_attr($top_panel_position) : '')
		. ' user_menu_' . (themerex_get_custom_option('show_menu_user')=='yes' ? 'show' : 'hide')
		. ' ' . esc_attr(themerex_get_sidebar_class(themerex_get_custom_option('show_sidebar_main'), themerex_get_custom_option('sidebar_main_position')))
		. ($video_bg_show ? ' video_bg_show' : '')
		. ($top_panel_image ? ' top_image_show' : '')
		. ($class!='' ? ' ' . esc_attr($class) : '')
	);
	if ($style!='') echo ' style="'.esc_attr($style).'"';
	?>
>
	<?php themerex_show_layout(themerex_get_custom_option('gtm_code')); ?>

	<?php do_action( 'before' ); ?>

	<?php
    if (shortcode_exists('trx_anchor')) {
        if (themerex_get_custom_option('menu_toc_home')=='yes') echo do_shortcode( '[trx_anchor id="toc_home" title="'.esc_attr__('Home', 'globallogistics').'" description="'.esc_attr__('{Return to Home} - |navigate to home page of the site', 'globallogistics').'" icon="icon-home-1" separator="yes" url="'.esc_url(home_url('/')).'"]' );
        if (themerex_get_custom_option('menu_toc_top')=='yes') echo do_shortcode( '[trx_anchor id="toc_top" title="'.esc_attr__('To Top', 'globallogistics').'" description="'.esc_attr__('{Back to top} - |scroll to top of the page', 'globallogistics').'" icon="icon-angle-double-up" separator="yes"]' );
    }
	?>

	<div class="body_wrap">

		<?php
		if ($video_bg_show) {
			$youtube = themerex_get_custom_option('video_bg_youtube_code');
			$video   = themerex_get_custom_option('video_bg_url');
			$overlay = themerex_get_custom_option('video_bg_overlay')=='yes';
			if (!empty($youtube)) {
				?>
				<div class="video_bg<?php themerex_show_layout($overlay ? ' video_bg_overlay' : ''); ?>" data-youtube-code="<?php echo esc_attr($youtube); ?>"></div>
				<?php
			} else if (!empty($video)) {
				$info = pathinfo($video);
				$ext = !empty($info['extension']) ? $info['extension'] : 'src';
				?>
				<div class="video_bg<?php echo esc_attr($overlay) ? ' video_bg_overlay' : ''; ?>"><video class="video_bg_tag" width="1280" height="720" data-width="1280" data-height="720" data-ratio="16:9" preload="metadata" autoplay loop src="<?php echo esc_url($video); ?>"><source src="<?php echo esc_url($video); ?>" type="video/<?php echo esc_attr($ext); ?>"></source></video></div>
				<?php
			}
		}
		?>

		<div class="page_wrap">

			<?php
			// Top panel and Slider
			if (in_array($top_panel_position, array('above', 'over'))) { require_once( themerex_get_file_dir('templates/parts/top-panel.php') ); }
			require_once( themerex_get_file_dir('templates/parts/slider.php') );
			if ($top_panel_position == 'below') { require_once( themerex_get_file_dir('templates/parts/top-panel.php') ); }

			// User custom header
			if (themerex_get_custom_option('show_user_header') == 'yes') {
				$user_header = themerex_strclear(themerex_get_custom_option('user_header_content'), 'p');
				if (!empty($user_header)) {
					$user_header = themerex_substitute_all($user_header);
					?>
					<div class="user_header_wrap"><?php themerex_show_layout($user_header); ?></div>
					<?php
				}
			}


			// Get custom image (for blog) or featured image (for single)
			if($top_panel_image) {
				$header_css = '';
				$show_title = themerex_get_custom_option('show_page_title')=='yes';
				$show_breadcrumbs = themerex_get_custom_option('show_breadcrumbs')=='yes';
				if (is_singular()) {
					$post_id = get_the_ID();
					$post_format = get_post_format();
					$header_image = wp_get_attachment_url(get_post_thumbnail_id($post_id));
				}
				if (empty($header_image))
					$header_image = themerex_get_custom_option('top_panel_image');
				if (empty($header_image))
					$header_image = get_header_image();
				if (!empty($header_image)) {
					$header_image = themerex_get_resized_image_url($header_image, null, null, null, false, false, true);
					$header_css = ' style="background-image: url(' . esc_url($header_image) . ')"';
				}
				?>
				<section class="top_panel_image" <?php themerex_show_layout($header_css); ?>>
					<div class="top_panel_image_hover"></div>
					<div class="top_panel_image_header">
						<?php if (!empty($post_icon)) { ?>
							<div class="top_panel_image_icon <?php echo esc_attr($post_icon); ?>"></div>
						<?php } ?>

						<?php if ($show_title) { ?>
						<h1 itemprop="name"
						    class="top_panel_image_title entry-title"><?php echo strip_tags(themerex_get_blog_title()); ?></h1>
						<?php } ?>

						<?php if ($show_breadcrumbs) { ?>
							<div class="breadcrumbs">
								<?php if (!is_404()) {
									echo '<span class="breadcrumbs_item_first">'.esc_html__('You Are Here:', 'globallogistics').'</span>';
									themerex_show_breadcrumbs();
								}
								?>
							</div>
						<?php } ?>

					</div>
				</section>
			<?php
			}
			?>

			<?php
			// Top of page section: page title and breadcrumbs
			$header_style = '';
			
			if (themerex_get_custom_option('show_page_top') == 'yes') {
				$show_title = themerex_get_custom_option('show_page_title')=='yes';
				$show_breadcrumbs = themerex_get_custom_option('show_breadcrumbs')=='yes';
				$show_title_desc = themerex_get_custom_option('show_page_title_desc')=='yes';
				?>

				<div class="page_top_wrap<?php themerex_show_layout(($show_title ? ' page_top_title' : '') . ($show_breadcrumbs ? ' page_top_breadcrumbs' : '')); ?>"<?php themerex_show_layout($header_style); ?>>
					<div class="content_wrap">
						<?php if ($show_breadcrumbs) { ?>
							<div class="breadcrumbs">
								<?php if (!is_404()) themerex_show_breadcrumbs(); ?>
							</div>
						<?php } ?>
						<?php if ($show_title) { ?>
							<h1 class="page_title"><?php echo strip_tags(themerex_get_blog_title()); ?></h1>
						<?php } ?>
					</div>
				</div>
			<?php
			}
			?>

			<div class="page_content_wrap">

				<?php
				// Content and sidebar wrapper
				if ($body_style!='fullscreen') themerex_open_wrapper('<div class="content_wrap">');
				
				// Main content wrapper
				themerex_open_wrapper('<div class="content">');
				?>