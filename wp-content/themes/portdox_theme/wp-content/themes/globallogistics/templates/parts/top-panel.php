			<?php 
				// WP custom header
				$header_image = $header_color = '';

			if (($header_image = get_header_image()) == '') {
				$header_image = themerex_get_custom_option('top_panel_bg_image');
			}

			$header_color = (themerex_get_custom_option('top_panel_bg_color') ? themerex_get_custom_option('top_panel_bg_color') : '#ffffff');
				$header_style = $top_panel_opacity!='transparent' && ($header_image!='' || $header_color!='')
					? ' style="background: ' 
						. ($header_image!=''  ? 'url('.esc_url($header_image).') no-repeat center top' : '')
						. ($header_color!=''  ? ' '.esc_attr($header_color).';' : '')
						.'"' 
					: '';
			?>

			<div class="top_panel_fixed_wrap"></div>

			<header class="top_panel_wrap" <?php themerex_show_layout($header_style); ?>>
				
				<?php if (themerex_get_custom_option('show_menu_user')=='yes') { ?>
					<div class="menu_user_wrap">
						<div class="content_wrap clearfix">

							<div class="menu_user_area menu_user_right menu_user_nav_area">
								<?php require_once( themerex_get_file_dir('templates/parts/user-panel.php') ); ?>
							</div>
							<?php if (themerex_get_custom_option('show_contact_info')=='yes') { ?>
							<div class="menu_user_area menu_user_left menu_user_contact_area"><?php themerex_show_layout(trim(themerex_get_custom_option('contact_info'))); ?></div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>


				<div class="menu_main_wrap logo_left<?php themerex_show_layout($THEMEREX_GLOBALS['logo_text'] ? ' with_text' : ''); ?>">

					<div class="content_wrap clearfix">

							<div class="logo">
								<a href="<?php echo esc_url(home_url('/')); ?>"><?php themerex_show_layout($THEMEREX_GLOBALS['logo'] ? '<img src="'.esc_url($THEMEREX_GLOBALS['logo']).'" class="logo_main" alt="'.esc_attr__('img', 'globallogistics').'">' : ''); ?>
									<span class="logo_info">
										<?php themerex_show_layout($THEMEREX_GLOBALS['logo_text'] ? '<span class="logo_text">'.($THEMEREX_GLOBALS['logo_text']).'</span>' : ''); ?>
									</span>
								</a>
							</div>

							<div class="menu_main">
								<nav role="navigation" class="menu_main_nav_area">
									<?php
									if (empty($THEMEREX_GLOBALS['menu_main'])) $THEMEREX_GLOBALS['menu_main'] = themerex_get_nav_menu('menu_main');
									if (empty($THEMEREX_GLOBALS['menu_main'])) $THEMEREX_GLOBALS['menu_main'] = themerex_get_nav_menu();
									themerex_show_layout($THEMEREX_GLOBALS['menu_main']);
									?>
								</nav>
								<a href="#" class="menu_main_responsive_button icon-menu"></a>
								<?php if (themerex_get_custom_option('show_search')=='yes' && shortcode_exists('trx_search')) echo do_shortcode('[trx_search]'); ?>
							</div>

					</div>

				</div>

			</header>