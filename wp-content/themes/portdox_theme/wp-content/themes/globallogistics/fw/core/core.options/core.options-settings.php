<?php

/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_options_settings_theme_setup2' ) ) {
	add_action( 'themerex_action_after_init_theme', 'themerex_options_settings_theme_setup2', 1 );
	function themerex_options_settings_theme_setup2() {
		if (themerex_options_is_used()) {
			global $THEMEREX_GLOBALS;
			// Replace arrays with actual parameters
			$lists = array();
			foreach ($THEMEREX_GLOBALS['options'] as $k=>$v) {
				if (isset($v['options']) && is_array($v['options'])) {
					foreach ($v['options'] as $k1=>$v1) {
						if (themerex_substr($k1, 0, 10) == '$themerex_' || themerex_substr($v1, 0, 10) == '$themerex_') {
							$list_func = themerex_substr(themerex_substr($k1, 0, 10) == '$themerex_' ? $k1 : $v1, 1);
							unset($THEMEREX_GLOBALS['options'][$k]['options'][$k1]);
							if (isset($lists[$list_func]))
								$THEMEREX_GLOBALS['options'][$k]['options'] = themerex_array_merge($THEMEREX_GLOBALS['options'][$k]['options'], $lists[$list_func]);
							else {
								if (function_exists($list_func)) {
									$THEMEREX_GLOBALS['options'][$k]['options'] = $lists[$list_func] = themerex_array_merge($THEMEREX_GLOBALS['options'][$k]['options'], $list_func == 'themerex_get_list_menus' ? $list_func(true) : $list_func());
							   	} else
							   		echo sprintf(esc_html__('Wrong function name %s in the theme options array', 'globallogistics'), $list_func);
							}
						}
					}
				}
			}
		}
	}
}

// Reset old Theme Options on theme first run
if ( !function_exists( 'themerex_options_reset' ) ) {
	function themerex_options_reset($clear=true) {
		$theme_data = wp_get_theme();
		$slug = str_replace(' ', '_', trim(themerex_strtolower((string) $theme_data->get('Name'))));
		$option_name = 'themerex_'.strip_tags($slug).'_options_reset';
		if ( get_option($option_name, false) === false ) {
			if ($clear) {
				global $wpdb;
				$wpdb->query('delete from '.esc_sql($wpdb->options).' where option_name like "themerex_options%"');
			}
			add_option($option_name, 1, '', 'yes');
		}
	}
}

// Prepare default Theme Options
if ( !function_exists( 'themerex_options_settings_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_options_settings_theme_setup', 2 );	// Priority 1 for add themerex_filter handlers
	function themerex_options_settings_theme_setup() {
		global $THEMEREX_GLOBALS;
		
		// Remove 'false' to clear all saved Theme Options on next run.
		// Attention! Use this way only on new theme installation, not in updates!
		themerex_options_reset(false);
		
		// Prepare arrays 
		$THEMEREX_GLOBALS['options_params'] = array(
			'list_fonts'		=> array('$themerex_get_list_fonts' => ''),
			'list_fonts_styles'	=> array('$themerex_get_list_fonts_styles' => ''),
			'list_socials' 		=> array('$themerex_get_list_socials' => ''),
			'list_icons' 		=> array('$themerex_get_list_icons' => ''),
			'list_posts_types' 	=> array('$themerex_get_list_posts_types' => ''),
			'list_categories' 	=> array('$themerex_get_list_categories' => ''),
			'list_menus'		=> array('$themerex_get_list_menus' => ''),
			'list_sidebars'		=> array('$themerex_get_list_sidebars' => ''),
			'list_positions' 	=> array('$themerex_get_list_sidebars_positions' => ''),
			'list_tints'	 	=> array('$themerex_get_list_bg_tints' => ''),
			'list_sidebar_styles' => array('$themerex_get_list_sidebar_styles' => ''),
			'list_sidebar_footer_styles' => array('$themerex_get_list_sidebar_footer_styles' => ''),
			'list_skins'		=> array('$themerex_get_list_skins' => ''),
			'list_body_styles'	=> array('$themerex_get_list_body_styles' => ''),
			'list_blog_styles'	=> array('$themerex_get_list_templates_blog' => ''),
			'list_single_styles'=> array('$themerex_get_list_templates_single' => ''),
			'list_portfolio_image_style'=> array('$themerex_get_list_portfolio_image_style' => ''),
			'list_article_styles'=> array('$themerex_get_list_article_styles' => ''),
			'list_animations_in' => array('$themerex_get_list_animations_in' => ''),
			'list_animations_out'=> array('$themerex_get_list_animations_out' => ''),
			'list_filters'		=> array('$themerex_get_list_portfolio_filters' => ''),
			'list_hovers'		=> array('$themerex_get_list_hovers' => ''),
			'list_hovers_dir'	=> array('$themerex_get_list_hovers_directions' => ''),
			'list_sliders' 		=> array('$themerex_get_list_sliders' => ''),
			'list_popups' 		=> array('$themerex_get_list_popup_engines' => ''),
			'list_gmap_styles' 	=> array('$themerex_get_list_googlemap_styles' => ''),
			'list_yes_no' 		=> array('$themerex_get_list_yesno' => ''),
			'list_on_off' 		=> array('$themerex_get_list_onoff' => ''),
			'list_show_hide' 	=> array('$themerex_get_list_showhide' => ''),
			'list_sorting' 		=> array('$themerex_get_list_sortings' => ''),
			'list_ordering' 	=> array('$themerex_get_list_orderings' => ''),
			'list_locations' 	=> array('$themerex_get_list_dedicated_locations' => '')
			);


		// Theme options array
		$THEMEREX_GLOBALS['options'] = array(

		
		//###############################
		//#### Customization         #### 
		//###############################
		'partition_customization' => array(
					"title" => esc_html__('Customization', 'globallogistics'),
					"start" => "partitions",
					"override" => "category,page,post",
					"icon" => "iconadmin-cog-alt",
					"type" => "partition"
					),
		
		
		// Customization -> General
		//-------------------------------------------------
		
		'customization_general' => array(
					"title" => esc_html__('General', 'globallogistics'),
					"override" => "category,page,post",
					"icon" => 'iconadmin-cog',
					"start" => "customization_tabs",
					"type" => "tab"
					),
		
		'info_custom_1' => array(
					"title" => esc_html__('Theme customization general parameters', 'globallogistics'),
					"desc" => esc_html__('Select main theme skin, customize colors and enable responsive layouts for the small screens', 'globallogistics'),
					"override" => "category,page,post",
					"type" => "info"
					),
		
		'theme_skin' => array(
					"title" => esc_html__('Select theme skin', 'globallogistics'),
					"desc" => esc_html__('Select skin for the theme decoration', 'globallogistics'),
					"divider" => false,
					"override" => "category,post,page",
					"std" => "globallogistics",
					"options" => $THEMEREX_GLOBALS['options_params']['list_skins'],
					"type" => "select"
					),

		"main_color" => array(
					"title" => esc_html__('Main color', 'globallogistics'),
					"desc" => esc_html__('Select main theme color', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"type" => "color"),

		"accent_color" => array(
					"title" => esc_html__('Accent color', 'globallogistics'),
					"desc" => esc_html__('Select accent theme color', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"type" => "color"),

		'show_theme_customizer' => array(
					"title" => esc_html__('Show Theme customizer', 'globallogistics'),
					"desc" => esc_html__('Do you want to show theme customizer in the right panel? Your website visitors will be able to customise it yourself.', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		"customizer_demo" => array(
					"title" => esc_html__('Theme customizer panel demo time', 'globallogistics'),
					"desc" => esc_html__('Timer for demo mode for the customizer panel (in milliseconds: 1000ms = 1s). If 0 - no demo.', 'globallogistics'),
					"divider" => false,
					"std" => "0",
					"min" => 0,
					"max" => 10000,
					"step" => 500,
					"type" => "spinner"),
		
		'css_animation' => array(
					"title" => esc_html__('Extended CSS animations', 'globallogistics'),
					"desc" => esc_html__('Do you want use extended animations effects on your site?', 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		'remember_visitors_settings' => array(
					"title" => esc_html__('Remember visitor\'s settings', 'globallogistics'),
					"desc" => esc_html__('To remember the settings that were made by the visitor, when navigating to other pages or to limit their effect only within the current page', 'globallogistics'),
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
					
		'responsive_layouts' => array(
					"title" => esc_html__('Responsive Layouts', 'globallogistics'),
					"desc" => esc_html__('Do you want use responsive layouts on small screen or still use main layout?', 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'globallogistics'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'globallogistics') ),
                "std"   => wp_kses_post( __( 'I agree that my submitted data is being collected and stored.', 'globallogistics') ),
                "type"  => "text"
            ),
		'info_custom_2' => array(
					"title" => esc_html__('Additional CSS code', 'globallogistics'),
					"desc" => esc_html__('Put here your custom CSS code', 'globallogistics'),
					"override" => "category,page,post",
					"type" => "info"
					),
		
		'custom_css' => array(
					"title" => esc_html__('Your CSS code',  'globallogistics'),
					"desc" => esc_html__('Put here your css code to correct main theme styles',  'globallogistics'),
					"override" => "category,post,page",
					"divider" => false,
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"
					),

		
		// Customization -> Body Style
		//-------------------------------------------------
		
		'customization_body' => array(
					"title" => esc_html__('Body style', 'globallogistics'),
					"override" => "category,post,page",
					"icon" => 'iconadmin-picture-1',
					"type" => "tab"
					),
		
		'info_custom_3' => array(
					"title" => esc_html__('Body parameters', 'globallogistics'),
					"desc" => esc_html__('Background color, pattern and image used only for fixed body style.', 'globallogistics'),
					"override" => "category,post,page",
					"type" => "info"
					),
					
		'body_style' => array(
					"title" => esc_html__('Body style', 'globallogistics'),
					"desc" => wp_kses_data(__('Select body style:<br><b>boxed</b> - if you want use background color and/or image,<br><b>wide</b> - page fill whole window with centered content,<br><b>fullscreen</b> - page content fill whole window without any paddings', 'globallogistics')),
					"divider" => false,
					"override" => "category,post,page",
					"std" => "wide",
					"options" => $THEMEREX_GLOBALS['options_params']['list_body_styles'],
					"dir" => "horizontal",
					"type" => "radio"
					),

		'padding_content' => array(
					"title" => esc_html__('Padding content', 'globallogistics'),
					"desc" => esc_html__('Padding content above and below (body style: boxed,wide,fullwide)', 'globallogistics'),
					"override" => "category,post,page",
					"divider" => false,
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
			),
		
		'body_filled' => array(
					"title" => esc_html__('Fill body', 'globallogistics'),
					"desc" => esc_html__('Fill the body background with the solid color (white or grey) or leave it transparend to show background image (or video)', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
		
		'load_bg_image' => array(
					"title" => esc_html__('Load background image', 'globallogistics'),
					"desc" => esc_html__('Always load background images or only for boxed body style', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "boxed",
					"size" => "medium",
					"options" => array(
						'boxed' => esc_html__('Boxed', 'globallogistics'),
						'always' => esc_html__('Always', 'globallogistics')
					),
					"type" => "switch"
					),
		
		'bg_color' => array(
					"title" => esc_html__('Background color',  'globallogistics'),
					"desc" => esc_html__('Body background color',  'globallogistics'),
					"override" => "category,post,page",
					"std" => "#bfbfbf",
					"type" => "color"
					),
		
		'bg_pattern' => array(
					"title" => esc_html__('Background predefined pattern',  'globallogistics'),
					"desc" => esc_html__('Select theme background pattern (first case - without pattern)',  'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"options" => array(
						0 => themerex_get_file_url('/images/spacer.png'),
						1 => themerex_get_file_url('/images/bg/pattern_1.png'),
						2 => themerex_get_file_url('/images/bg/pattern_2.png'),
						3 => themerex_get_file_url('/images/bg/pattern_3.png'),
						4 => themerex_get_file_url('/images/bg/pattern_4.png'),
						5 => themerex_get_file_url('/images/bg/pattern_5.png'),
						6 => themerex_get_file_url('/images/bg/pattern_6.png'),
						7 => themerex_get_file_url('/images/bg/pattern_7.png'),
						8 => themerex_get_file_url('/images/bg/pattern_8.png'),
						9 => themerex_get_file_url('/images/bg/pattern_9.png')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_custom_pattern' => array(
					"title" => esc_html__('Background custom pattern',  'globallogistics'),
					"desc" => esc_html__('Select or upload background custom pattern. If selected - use it instead the theme predefined pattern (selected in the field above)',  'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"type" => "media"
					),
		
		'bg_image' => array(
					"title" => esc_html__('Background predefined image',  'globallogistics'),
					"desc" => esc_html__('Select theme background image (first case - without image)',  'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"options" => array(
						0 => themerex_get_file_url('/images/spacer.png'),
						1 => themerex_get_file_url('/images/bg/image_1_thumb.jpg'),
						2 => themerex_get_file_url('/images/bg/image_2_thumb.jpg'),
						3 => themerex_get_file_url('/images/bg/image_3_thumb.jpg'),
						4 => themerex_get_file_url('/images/bg/image_4_thumb.jpg'),
						5 => themerex_get_file_url('/images/bg/image_5_thumb.jpg'),
						6 => themerex_get_file_url('/images/bg/image_6_thumb.jpg')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_custom_image' => array(
					"title" => esc_html__('Background custom image',  'globallogistics'),
					"desc" => esc_html__('Select or upload background custom image. If selected - use it instead the theme predefined image (selected in the field above)',  'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"type" => "media"
					),
		
		'bg_custom_image_position' => array( 
					"title" => esc_html__('Background custom image position',  'globallogistics'),
					"desc" => esc_html__('Select custom image position',  'globallogistics'),
					"override" => "category,post,page",
					"std" => "left_top",
					"options" => array(
						'left_top' => "Left Top",
						'center_top' => "Center Top",
						'right_top' => "Right Top",
						'left_center' => "Left Center",
						'center_center' => "Center Center",
						'right_center' => "Right Center",
						'left_bottom' => "Left Bottom",
						'center_bottom' => "Center Bottom",
						'right_bottom' => "Right Bottom",
					),
					"type" => "select"
					),
		
		'show_video_bg' => array(
					"title" => esc_html__('Show video background',  'globallogistics'),
					"desc" => esc_html__("Show video on the site background (only for Fullscreen body style)", 'globallogistics'),
					"override" => "category,post,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
		
		'video_bg_youtube_code' => array(
					"title" => esc_html__('Youtube code for video bg',  'globallogistics'),
					"desc" => esc_html__("Youtube code of video", 'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"type" => "text"
					),
		
		'video_bg_url' => array(
					"title" => esc_html__('Local video for video bg',  'globallogistics'),
					"desc" => esc_html__("URL to video-file (uploaded on your site)", 'globallogistics'),
					"readonly" =>false,
					"override" => "category,post,page",
					"before" => array(	'title' => esc_html__('Choose video', 'globallogistics'),
										'action' => 'media_upload',
										'multiple' => false,
										'linked_field' => '',
										'type' => 'video',
										'captions' => array('choose' => esc_html__( 'Choose Video', 'globallogistics'),
															'update' => esc_html__( 'Select Video', 'globallogistics')
														)
								),
					"std" => "",
					"type" => "media"
					),
		
		'video_bg_overlay' => array(
					"title" => esc_html__('Use overlay for video bg', 'globallogistics'),
					"desc" => esc_html__('Use overlay texture for the video background', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
		
		
		
		// Customization -> Logo
		//-------------------------------------------------
		
		'customization_logo' => array(
					"title" => esc_html__('Logo', 'globallogistics'),
					"override" => "category,post,page",
					"icon" => 'iconadmin-heart-1',
					"type" => "tab"
					),
		
		'info_custom_4' => array(
					"title" => esc_html__('Main logo', 'globallogistics'),
					"desc" => esc_html__('Select or upload logos for the site\'s header and select it position', 'globallogistics'),
					"override" => "category,post,page",
					"type" => "info"
					),

		'favicon' => array(
					"title" => esc_html__('Favicon', 'globallogistics'),
					"desc" => wp_kses_data(__('Upload a 16px x 16px image that will represent your website\'s favicon.<br /><em>To ensure cross-browser compatibility, we recommend converting the favicon into .ico format before uploading. (<a href="http://www.favicon.cc/">www.favicon.cc</a>)</em>', 'globallogistics')),
					"divider" => false,
					"std" => "",
					"type" => "media"
					),

		'logo' => array(
					"title" => esc_html__('Logo image', 'globallogistics'),
					"desc" => esc_html__('Main logo image', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"type" => "media"
					),

		'logo_text' => array(
					"title" => esc_html__('Logo text', 'globallogistics'),
					"desc" => esc_html__('Logo text - display it after logo image', 'globallogistics'),
					"override" => "category,post,page",
					"std" => '',
					"type" => "text"
					),

		'logo_height' => array(
					"title" => esc_html__('Logo height', 'globallogistics'),
					"desc" => esc_html__('Height for the logo in the header area', 'globallogistics'),
					"override" => "category,post,page",
					"step" => 1,
					"std" => '',
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),

		'logo_offset' => array(
					"title" => esc_html__('Logo top offset', 'globallogistics'),
					"desc" => esc_html__('Top offset for the logo in the header area', 'globallogistics'),
					"override" => "category,post,page",
					"step" => 1,
					"std" => '',
					"min" => 0,
					"max" => 99,
					"mask" => "?99",
					"type" => "spinner"
					),

		'iinfo_custom_5' => array(
					"title" => esc_html__('Logo for footer', 'globallogistics'),
					"desc" => esc_html__('Select or upload logos for the site\'s footer and set it height', 'globallogistics'),
					"override" => "category,post,page",
					"type" => "info"
					),

		'logo_footer' => array(
					"title" => esc_html__('Logo image for footer', 'globallogistics'),
					"desc" => esc_html__('Logo image for the footer', 'globallogistics'),
					"override" => "category,post,page",
					"divider" => false,
					"std" => "",
					"type" => "media"
					),
		
		'logo_footer_height' => array(
					"title" => esc_html__('Logo height', 'globallogistics'),
					"desc" => esc_html__('Height for the logo in the footer area (in contacts)', 'globallogistics'),
					"override" => "category,post,page",
					"step" => 1,
					"std" => 30,
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),
		
		
		
		// Customization -> Menus
		//-------------------------------------------------
		
		"customization_menus" => array(
					"title" => esc_html__('Menus', 'globallogistics'),
					"override" => "category,post,page",
					"icon" => 'iconadmin-menu',
					"type" => "tab"),
		
		"info_custom_6" => array(
					"title" => esc_html__('Top panel', 'globallogistics'),
					"desc" => esc_html__('Top panel settings. It include user menu area (with contact info, cart button, language selector, login/logout menu and user menu) and main menu area (with logo and main menu).', 'globallogistics'),
					"override" => "category,post,page",
					"type" => "info"),
		
		"top_panel_position" => array( 
					"title" => esc_html__('Top panel position', 'globallogistics'),
					"desc" => esc_html__('Select position for the top panel with logo and main menu', 'globallogistics'),
					"override" => "category,post,page",
					"divider" => false,
					"std" => "above",
					"options" => array(
						'hide'  => esc_html__('Hide', 'globallogistics'),
						'above' => esc_html__('Above slider', 'globallogistics'),
						'below' => esc_html__('Below slider', 'globallogistics'),
						'over'  => esc_html__('Over slider', 'globallogistics')
					),
					"type" => "checklist"),

		
		"top_panel_opacity" => array( 
					"title" => esc_html__('Top panel opacity', 'globallogistics'),
					"desc" => esc_html__('Select background opacity for the top panel with logo and main menu', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "solid",
					"options" => array(
						'solid' => esc_html__('Solid', 'globallogistics'),
						'transparent' => esc_html__('Transparent', 'globallogistics')
					),
					"type" => "checklist"),
		
		'top_panel_bg_color' => array(
					"title" => esc_html__('Top panel bg color',  'globallogistics'),
					"desc" => esc_html__('Background color for the top panel',  'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"type" => "color"
					),
		
		"top_panel_bg_image" => array( 
					"title" => esc_html__('Top panel bg image', 'globallogistics'),
					"desc" => esc_html__('Upload top panel background image', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"type" => "media"),
		
		
		"info_custom_7" => array( 
					"title" => esc_html__('Main menu style and position', 'globallogistics'),
					"desc" => esc_html__('Select the Main menu style and position', 'globallogistics'),
					"override" => "category,post,page",
					"type" => "info"),
		
		"menu_main" => array( 
					"title" => esc_html__('Select main menu',  'globallogistics'),
					"desc" => esc_html__('Select main menu for the current page',  'globallogistics'),
					"override" => "category,post,page",
					"divider" => false,
					"std" => "default",
					"options" => $THEMEREX_GLOBALS['options_params']['list_menus'],
					"type" => "select"),
		
		"menu_position" => array( 
					"title" => esc_html__('Main menu position', 'globallogistics'),
					"desc" => esc_html__('Attach main menu to top of window then page scroll down', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "fixed",
					"options" => array("fixed"=>esc_html__("Fix menu position", 'globallogistics'), "none"=>esc_html__("Don't fix menu position", 'globallogistics')),
					"dir" => "vertical",
					"type" => "radio"),
		
		"menu_animation_in" => array(
					"title" => esc_html__('Submenu show animation', 'globallogistics'),
					"desc" => esc_html__('Select animation to show submenu ', 'globallogistics'),
					"std" => "fadeInUp",
					"type" => "select",
					"options" => $THEMEREX_GLOBALS['options_params']['list_animations_in']),

		"menu_animation_out" => array( 
					"title" => esc_html__('Submenu hide animation', 'globallogistics'),
					"desc" => esc_html__('Select animation to hide submenu ', 'globallogistics'),
					"std" => "fadeOut",
					"type" => "select",
					"options" => $THEMEREX_GLOBALS['options_params']['list_animations_out']),
		
		"menu_relayout" => array( 
					"title" => esc_html__('Main menu relayout', 'globallogistics'),
					"desc" => esc_html__('Allow relayout main menu if window width less then this value', 'globallogistics'),
					"std" => 960,
					"min" => 320,
					"max" => 1024,
					"type" => "spinner"),
		
		"menu_responsive" => array( 
					"title" => esc_html__('Main menu responsive', 'globallogistics'),
					"desc" => esc_html__('Allow responsive version for the main menu if window width less then this value', 'globallogistics'),
					"std" => 640,
					"min" => 320,
					"max" => 1024,
					"type" => "spinner"),
		
		"menu_width" => array( 
					"title" => esc_html__('Submenu width', 'globallogistics'),
					"desc" => esc_html__('Width for dropdown menus in main menu', 'globallogistics'),
					"override" => "category,post,page",
					"step" => 5,
					"std" => "",
					"min" => 180,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"),











		
		"info_custom_8" => array(
					"title" => esc_html__("User's menu area components", 'globallogistics'),
					"desc" => esc_html__("Select parts for the user's menu area", 'globallogistics'),
					"override" => "category,page,post",
					"type" => "info"),
		
		"show_menu_user" => array(
					"title" => esc_html__('Show user menu area', 'globallogistics'),
					"desc" => esc_html__('Show user menu area on top of page', 'globallogistics'),
					"divider" => false,
					"override" => "category,post,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"menu_user" => array(
					"title" => esc_html__('Select user menu',  'globallogistics'),
					"desc" => esc_html__('Select user menu for the current page',  'globallogistics'),
					"override" => "category,post,page",
					"std" => "default",
					"options" => $THEMEREX_GLOBALS['options_params']['list_menus'],
					"type" => "select"),
		
		"show_contact_info" => array(
					"title" => esc_html__('Show contact info', 'globallogistics'),
					"desc" => esc_html__("Show the contact details for the owner of the site at the top left corner of the page", 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_languages" => array(
					"title" => esc_html__('Show language selector', 'globallogistics'),
					"desc" => esc_html__('Show language selector in the user menu (if WPML plugin installed and current page/post has multilanguage version)', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),


		"show_login" => array(
					"title" => esc_html__('Show Login/Logout buttons', 'globallogistics'),
					"desc" => esc_html__('Show Login and Logout buttons in the user menu area', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),


		"show_bookmarks" => array(
					"title" => esc_html__('Show bookmarks', 'globallogistics'),
					"desc" => esc_html__('Show bookmarks selector in the user menu', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"info_custom_9" => array( 
					"title" => esc_html__("Table of Contents (TOC)", 'globallogistics'),
					"desc" => esc_html__("Table of Contents for the current page. Automatically created if the page contains objects with id starting with 'toc_'", 'globallogistics'),
					"override" => "category,page,post",
					"type" => "info"),
		
		"menu_toc" => array( 
					"title" => esc_html__('TOC position', 'globallogistics'),
					"desc" => esc_html__('Show TOC for the current page', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "fixed",
					"options" => array(
						'hide'  => esc_html__('Hide', 'globallogistics'),
						'fixed' => esc_html__('Fixed', 'globallogistics'),
						'float' => esc_html__('Float', 'globallogistics')
					),
					"type" => "checklist"),
		
		"menu_toc_home" => array(
					"title" => esc_html__('Add "Home" into TOC', 'globallogistics'),
					"desc" => esc_html__('Automatically add "Home" item into table of contents - return to home page of the site', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"menu_toc_top" => array( 
					"title" => esc_html__('Add "To Top" into TOC', 'globallogistics'),
					"desc" => esc_html__('Automatically add "To Top" item into table of contents - scroll to top of the page', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		
		
		
		// Customization -> Sidebars
		//-------------------------------------------------
		
		"customization_sidebars" => array( 
					"title" => esc_html__('Sidebars', 'globallogistics'),
					"icon" => "iconadmin-indent-right",
					"override" => "category,post,page",
					"type" => "tab"),
		
		"info_custom_10" => array( 
					"title" => esc_html__('Custom sidebars', 'globallogistics'),
					"desc" => esc_html__('In this section you can create unlimited sidebars. You can fill them with widgets in the menu Appearance - Widgets', 'globallogistics'),
					"type" => "info"),
		
		"custom_sidebars" => array(
					"title" => esc_html__('Custom sidebars',  'globallogistics'),
					"desc" => esc_html__('Manage custom sidebars. You can use it with each category (page, post) independently',  'globallogistics'),
					"divider" => false,
					"std" => "",
					"cloneable" => true,
					"type" => "text"),
		
		"info_custom_11" => array(
					"title" => esc_html__('Sidebars settings', 'globallogistics'),
					"desc" => esc_html__('Show / Hide and Select sidebar in each location', 'globallogistics'),
					"override" => "category,post,page",
					"type" => "info"),
		
		'show_sidebar_main' => array( 
					"title" => esc_html__('Show main sidebar',  'globallogistics'),
					"desc" => esc_html__('Select style for the main sidebar or hide it',  'globallogistics'),
					"override" => "category,post,page",
					"std" => "light",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sidebar_styles'],
					"dir" => "horizontal",
					"type" => "checklist"),
		
		'sidebar_main_position' => array( 
					"title" => esc_html__('Main sidebar position',  'globallogistics'),
					"desc" => esc_html__('Select main sidebar position on blog page',  'globallogistics'),
					"override" => "category,post,page",
					"std" => "right",
					"options" => $THEMEREX_GLOBALS['options_params']['list_positions'],
					"size" => "medium",
					"type" => "switch"),
		
		"sidebar_main" => array( 
					"title" => esc_html__('Select main sidebar',  'globallogistics'),
					"desc" => esc_html__('Select main sidebar for the blog page',  'globallogistics'),
					"override" => "category,post,page",
					"divider" => false,
					"std" => "sidebar_main",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sidebars'],
					"type" => "select"),
		
		"show_sidebar_footer" => array(
					"title" => esc_html__('Show footer sidebar', 'globallogistics'),
					"desc" => esc_html__('Select style for the footer sidebar or hide it', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "light",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sidebar_footer_styles'],
					"dir" => "horizontal",
					"type" => "checklist"),
		
		"sidebar_footer" => array( 
					"title" => esc_html__('Select footer sidebar',  'globallogistics'),
					"desc" => esc_html__('Select footer sidebar for the blog page',  'globallogistics'),
					"override" => "category,post,page",
					"divider" => false,
					"std" => "sidebar_footer",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sidebars'],
					"type" => "select"),
		
		"sidebar_footer_columns" => array( 
					"title" => esc_html__('Footer sidebar columns',  'globallogistics'),
					"desc" => esc_html__('Select columns number for the footer sidebar',  'globallogistics'),
					"override" => "category,post,page",
					"divider" => false,
					"std" => 3,
					"min" => 1,
					"max" => 6,
					"type" => "spinner"),
		
		
		
		
		
		
		
		// Customization -> Slider
		//-------------------------------------------------
		
		"customization_slider" => array( 
					"title" => esc_html__('Slider', 'globallogistics'),
					"icon" => "iconadmin-picture",
					"override" => "category,page,post",
					"type" => "tab"),
		
		"info_custom_13" => array(
					"title" => esc_html__('Main slider parameters', 'globallogistics'),
					"desc" => esc_html__('Select parameters for main slider (you can override it in each category and page)', 'globallogistics'),
					"override" => "category,page,post",
					"type" => "info"),
					
		"show_slider" => array(
					"title" => esc_html__('Show Slider', 'globallogistics'),
					"desc" => esc_html__('Do you want to show slider on each page (post)', 'globallogistics'),
					"divider" => false,
					"override" => "category,page,post",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
					
		"slider_display" => array(
					"title" => esc_html__('Slider display', 'globallogistics'),
					"desc" => esc_html__('How display slider: boxed (fixed width and height), fullwide (fixed height) or fullscreen', 'globallogistics'),
					"override" => "category,page,post",
					"std" => "none",
					"options" => array(
						"boxed"=>esc_html__("Boxed", 'globallogistics'),
						"fullwide"=>esc_html__("Fullwide", 'globallogistics'),
						"fullscreen"=>esc_html__("Fullscreen", 'globallogistics')
					),
					"type" => "checklist"),
		
		"slider_height" => array(
					"title" => esc_html__("Height (in pixels)", 'globallogistics'),
					"desc" => esc_html__("Slider height (in pixels) - only if slider display with fixed height.", 'globallogistics'),
					"override" => "category,page,post",
					"std" => '',
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),
		
		"slider_engine" => array(
					"title" => esc_html__('Slider engine', 'globallogistics'),
					"desc" => esc_html__('What engine use to show slider?', 'globallogistics'),
					"override" => "category,page,post",
					"std" => "flex",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sliders'],
					"type" => "radio"),
		
		"slider_alias" => array(
					"title" => esc_html__('Layer Slider: Alias (for Revolution) or ID (for Royal)',  'globallogistics'),
					"desc" => esc_html__("Revolution Slider alias or Royal Slider ID (see in slider settings on plugin page)", 'globallogistics'),
					"override" => "category,page",
					"std" => "",
					"type" => "text"),
		
		"slider_category" => array(
					"title" => esc_html__('Posts Slider: Category to show', 'globallogistics'),
					"desc" => esc_html__('Select category to show in Flexslider (ignored for Revolution and Royal sliders)', 'globallogistics'),
					"override" => "category,page,post",
					"std" => "",
					"options" => themerex_array_merge(array(0 => esc_html__('- Select category -', 'globallogistics')), $THEMEREX_GLOBALS['options_params']['list_categories']),
					"type" => "select",
					"multiple" => true,
					"style" => "list"),
		
		"slider_posts" => array(
					"title" => esc_html__('Posts Slider: Number posts or comma separated posts list',  'globallogistics'),
					"desc" => esc_html__("How many recent posts display in slider or comma separated list of posts ID (in this case selected category ignored)", 'globallogistics'),
					"override" => "category,page,post",
					"std" => "5",
					"type" => "text"),
		
		"slider_orderby" => array(
					"title" => esc_html__("Posts Slider: Posts order by",  'globallogistics'),
					"desc" => esc_html__("Posts in slider ordered by date (default), comments, views, author rating, users rating, random or alphabetically", 'globallogistics'),
					"override" => "category,page,post",
					"std" => "date",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sorting'],
					"type" => "select"),
		
		"slider_order" => array(
					"title" => esc_html__("Posts Slider: Posts order", 'globallogistics'),
					"desc" => esc_html__('Select the desired ordering method for posts', 'globallogistics'),
					"override" => "category,page,post",
					"std" => "desc",
					"options" => $THEMEREX_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),
					
		"slider_interval" => array(
					"title" => esc_html__("Posts Slider: Slide change interval", 'globallogistics'),
					"desc" => esc_html__("Interval (in ms) for slides change in slider", 'globallogistics'),
					"override" => "category,page,post",
					"std" => 7000,
					"min" => 100,
					"step" => 100,
					"type" => "spinner"),
		
		"slider_pagination" => array(
					"title" => esc_html__("Posts Slider: Pagination", 'globallogistics'),
					"desc" => esc_html__("Choose pagination style for the slider", 'globallogistics'),
					"override" => "category,page,post",
					"std" => "no",
					"options" => array(
						'no'   => esc_html__('None', 'globallogistics'),
						'yes'  => esc_html__('Dots', 'globallogistics'),
						'over' => esc_html__('Titles', 'globallogistics')
					),
					"type" => "checklist"),
		
		"slider_infobox" => array(
					"title" => esc_html__("Posts Slider: Show infobox", 'globallogistics'),
					"desc" => esc_html__("Do you want to show post's title, reviews rating and description on slides in slider", 'globallogistics'),
					"override" => "category,page,post",
					"std" => "slide",
					"options" => array(
						'no'    => esc_html__('None',  'globallogistics'),
						'slide' => esc_html__('Slide', 'globallogistics'),
						'fixed' => esc_html__('Fixed', 'globallogistics')
					),
					"type" => "checklist"),
					
		"slider_info_category" => array(
					"title" => esc_html__("Posts Slider: Show post's category", 'globallogistics'),
					"desc" => esc_html__("Do you want to show post's category on slides in slider", 'globallogistics'),
					"override" => "category,page,post",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
					
		"slider_info_reviews" => array(
					"title" => esc_html__("Posts Slider: Show post's reviews rating", 'globallogistics'),
					"desc" => esc_html__("Do you want to show post's reviews rating on slides in slider", 'globallogistics'),
					"override" => "category,page,post",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
					
		"slider_info_descriptions" => array(
					"title" => esc_html__("Posts Slider: Show post's descriptions", 'globallogistics'),
					"desc" => esc_html__("How many characters show in the post's description in slider. 0 - no descriptions", 'globallogistics'),
					"override" => "category,page,post",
					"std" => 0,
					"min" => 0,
					"step" => 10,
					"type" => "spinner"),
		
		
		
		
		// Customization -> Header & Footer
		//-------------------------------------------------
		
		'customization_header_footer' => array(
					"title" => esc_html__("Header &amp; Footer", 'globallogistics'),
					"override" => "category,post,page",
					"icon" => 'iconadmin-window',
					"type" => "tab"),
		
		
		"info_footer_1" => array(
					"title" => esc_html__("Header settings", 'globallogistics'),
					"desc" => esc_html__("Select components of the page header, set style and put the content for the user's header area", 'globallogistics'),
					"override" => "category,page,post",
					"type" => "info"),
		
		"show_user_header" => array(
					"title" => esc_html__("Show user's header", 'globallogistics'),
					"desc" => esc_html__("Show custom user's header", 'globallogistics'),
					"divider" => false,
					"override" => "category,page,post",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"user_header_content" => array(
					"title" => esc_html__("User's header content", 'globallogistics'),
					"desc" => esc_html__('Put header html-code and/or shortcodes here. You can use any html-tags and shortcodes', 'globallogistics'),
					"override" => "category,page,post",
					"std" => "",
					"rows" => "10",
					"type" => "editor"),
		
		"show_page_top" => array(
					"title" => esc_html__('Show Top of page section', 'globallogistics'),
					"desc" => esc_html__('Show top section with post/page/category title and breadcrumbs', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_page_title" => array(
					"title" => esc_html__('Show Page title', 'globallogistics'),
					"desc" => esc_html__('Show post/page/category title', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_breadcrumbs" => array(
					"title" => esc_html__('Show Breadcrumbs', 'globallogistics'),
					"desc" => esc_html__('Show path to current category (post, page)', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"breadcrumbs_max_level" => array(
					"title" => esc_html__('Breadcrumbs max nesting', 'globallogistics'),
					"desc" => esc_html__("Max number of the nested categories in the breadcrumbs (0 - unlimited)", 'globallogistics'),
					"std" => "0",
					"min" => 0,
					"max" => 100,
					"step" => 1,
					"type" => "spinner"),
		
		
		
		
		"info_footer_2" => array(
					"title" => esc_html__("Footer settings", 'globallogistics'),
					"desc" => esc_html__("Select components of the footer, set style and put the content for the user's footer area", 'globallogistics'),
					"override" => "category,page,post",
					"type" => "info"),
		
		"show_user_footer" => array(
					"title" => esc_html__("Show user's footer", 'globallogistics'),
					"desc" => esc_html__("Show custom user's footer", 'globallogistics'),
					"divider" => false,
					"override" => "category,page,post",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"user_footer_content" => array(
					"title" => esc_html__("User's footer content", 'globallogistics'),
					"desc" => esc_html__('Put footer html-code and/or shortcodes here. You can use any html-tags and shortcodes', 'globallogistics'),
					"override" => "category,page,post",
					"std" => "",
					"rows" => "10",
					"type" => "editor"),
		
		"show_contacts_in_footer" => array(
					"title" => esc_html__('Show Contacts in footer', 'globallogistics'),
					"desc" => esc_html__('Show contact information area in footer: site logo, contact info and large social icons', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "dark",
					"options" => array(
						'hide' 	=> esc_html__('Hide', 'globallogistics'),
						'light'	=> esc_html__('Light', 'globallogistics'),
						'dark'	=> esc_html__('Dark', 'globallogistics')
					),
					"dir" => "horizontal",
					"type" => "checklist"),

		"show_copyright_in_footer" => array(
					"title" => esc_html__('Show Copyright area in footer', 'globallogistics'),
					"desc" => esc_html__('Show area with copyright information and small social icons in footer', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"footer_copyright" => array(
					"title" => esc_html__('Footer copyright text',  'globallogistics'),
					"desc" => esc_html__("Copyright text to show in footer area (bottom of site)", 'globallogistics'),
					"override" => "category,page,post",
					"std" => "ThemeREX &copy; {Y} All Rights Reserved ",
					"rows" => "10",
					"type" => "editor"),
		
		
		"info_footer_3" => array(
					"title" => esc_html__('Testimonials in Footer', 'globallogistics'),
					"desc" => esc_html__('Select parameters for Testimonials in the Footer (you can override it in each category and page)', 'globallogistics'),
					"override" => "category,page,post",
					"type" => "info"),

		"show_testimonials_in_footer" => array(
					"title" => esc_html__('Show Testimonials in footer', 'globallogistics'),
					"desc" => esc_html__('Show Testimonials slider in footer. For correct operation of the slider (and shortcode testimonials) you must fill out Testimonials posts on the menu "Testimonials"', 'globallogistics'),
					"override" => "category,post,page",
					"divider" => false,
					"std" => "none",
					"options" => $THEMEREX_GLOBALS['options_params']['list_tints'],
					"type" => "checklist"),

		"testimonials_count" => array( 
					"title" => esc_html__('Testimonials count', 'globallogistics'),
					"desc" => esc_html__('Number testimonials to show', 'globallogistics'),
					"override" => "category,post,page",
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),

		"testimonials_bg_image" => array( 
					"title" => esc_html__('Testimonials bg image', 'globallogistics'),
					"desc" => esc_html__('Select image or put image URL from other site to use it as testimonials block background', 'globallogistics'),
					"override" => "category,post,page",
					"readonly" => false,
					"std" => "",
					"type" => "media"),

		"testimonials_bg_color" => array( 
					"title" => esc_html__('Testimonials bg color', 'globallogistics'),
					"desc" => esc_html__('Select color to use it as testimonials block background', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"type" => "color"),

		"testimonials_bg_overlay" => array( 
					"title" => esc_html__('Testimonials bg overlay', 'globallogistics'),
					"desc" => esc_html__('Select background color opacity to create overlay effect on background', 'globallogistics'),
					"override" => "category,post,page",
					"std" => 0,
					"step" => 0.1,
					"min" => 0,
					"max" => 1,
					"type" => "spinner"),
		
		
		"info_footer_4" => array(
					"title" => esc_html__('Twitter in Footer', 'globallogistics'),
					"desc" => esc_html__('Select parameters for Twitter stream in the Footer (you can override it in each category and page)', 'globallogistics'),
					"override" => "category,page,post",
					"type" => "info"),

		"show_twitter_in_footer" => array(
					"title" => esc_html__('Show Twitter in footer', 'globallogistics'),
					"desc" => esc_html__('Show Twitter slider in footer. For correct operation of the slider (and shortcode twitter) you must fill out the Twitter API keys on the menu "Appearance - Theme Options - Socials"', 'globallogistics'),
					"override" => "category,post,page",
					"divider" => false,
					"std" => "none",
					"options" => $THEMEREX_GLOBALS['options_params']['list_tints'],
					"type" => "checklist"),

		"twitter_count" => array( 
					"title" => esc_html__('Twitter count', 'globallogistics'),
					"desc" => esc_html__('Number twitter to show', 'globallogistics'),
					"override" => "category,post,page",
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),

		"twitter_bg_image" => array( 
					"title" => esc_html__('Twitter bg image', 'globallogistics'),
					"desc" => esc_html__('Select image or put image URL from other site to use it as Twitter block background', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"type" => "media"),

		"twitter_bg_color" => array( 
					"title" => esc_html__('Twitter bg color', 'globallogistics'),
					"desc" => esc_html__('Select color to use it as Twitter block background', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "",
					"type" => "color"),

		"twitter_bg_overlay" => array( 
					"title" => esc_html__('Twitter bg overlay', 'globallogistics'),
					"desc" => esc_html__('Select background color opacity to create overlay effect on background', 'globallogistics'),
					"override" => "category,post,page",
					"std" => 0,
					"step" => 0.1,
					"min" => 0,
					"max" => 1,
					"type" => "spinner"),


		"info_footer_5" => array(
					"title" => esc_html__('Google map parameters', 'globallogistics'),
					"desc" => esc_html__('Select parameters for Google map (you can override it in each category and page)', 'globallogistics'),
					"override" => "category,page,post",
					"type" => "info"),
					
		"show_googlemap" => array(
					"title" => esc_html__('Show Google Map', 'globallogistics'),
					"desc" => esc_html__('Do you want to show Google map on each page (post)', 'globallogistics'),
					"divider" => false,
					"override" => "category,page,post",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"googlemap_height" => array(
					"title" => esc_html__("Map height", 'globallogistics'),
					"desc" => esc_html__("Map height (default - in pixels, allows any CSS units of measure)", 'globallogistics'),
					"override" => "category,page",
					"std" => 400,
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),
		
		"googlemap_address" => array(
					"title" => esc_html__('Address to show on map',  'globallogistics'),
					"desc" => esc_html__("Enter address to show on map center", 'globallogistics'),
					"override" => "category,page,post",
					"std" => "",
					"type" => "text"),
		
		"googlemap_latlng" => array(
					"title" => esc_html__('Latitude and Longtitude to show on map',  'globallogistics'),
					"desc" => esc_html__("Enter coordinates (separated by comma) to show on map center (instead of address)", 'globallogistics'),
					"override" => "category,page,post",
					"std" => "",
					"type" => "text"),

			"googlemap_title" => array(
				"title" => esc_html__('Title to show on map',  'globallogistics'),
				"desc" => esc_html__("Enter title to show on map center", 'globallogistics'),
				"override" => "category,page,post",
				"std" => "",
				"type" => "text"),

			"googlemap_description" => array(
				"title" => esc_html__('Description to show on map',  'globallogistics'),
				"desc" => esc_html__("Enter description to show on map center", 'globallogistics'),
				"override" => "category,page,post",
				"std" => "",
				"type" => "text"),
		
		"googlemap_zoom" => array(
					"title" => esc_html__('Google map initial zoom',  'globallogistics'),
					"desc" => esc_html__("Enter desired initial zoom for Google map", 'globallogistics'),
					"override" => "category,page,post",
					"std" => 16,
					"min" => 1,
					"max" => 20,
					"step" => 1,
					"type" => "spinner"),
		
		"googlemap_style" => array(
					"title" => esc_html__('Google map style',  'globallogistics'),
					"desc" => esc_html__("Select style to show Google map", 'globallogistics'),
					"override" => "category,page,post",
					"std" => 'style1',
					"options" => $THEMEREX_GLOBALS['options_params']['list_gmap_styles'],
					"type" => "select"),

			"googlemap_marker" => array(
				"title" => esc_html__('Google map marker',  'globallogistics'),
				"desc" => esc_html__("Select or upload png-image with Google map marker", 'globallogistics'),
				"std" => '',
				"type" => "media"),
		
		
		
		
		// Customization -> Media
		//-------------------------------------------------
		
		'customization_media' => array(
					"title" => esc_html__('Media', 'globallogistics'),
					"override" => "category,post,page",
					"icon" => 'iconadmin-picture',
					"type" => "tab"),
		
		"info_media_1" => array(
					"title" => esc_html__('Retina ready', 'globallogistics'),
					"desc" => esc_html__("Additional parameters for the Retina displays", 'globallogistics'),
					"type" => "info"),
					
		"retina_ready" => array(
					"title" => esc_html__('Image dimensions', 'globallogistics'),
					"desc" => esc_html__('What dimensions use for uploaded image: Original or "Retina ready" (twice enlarged)', 'globallogistics'),
					"divider" => false,
					"std" => "1",
					"size" => "medium",
					"options" => array("1"=>esc_html__("Original", 'globallogistics'), "2"=>esc_html__("Retina", 'globallogistics')),
					"type" => "switch"),
		
		"info_media_2" => array(
					"title" => esc_html__('Media Substitution parameters', 'globallogistics'),
					"desc" => esc_html__("Set up the media substitution parameters and slider's options", 'globallogistics'),
					"override" => "category,page,post",
					"type" => "info"),
		
		"substitute_gallery" => array(
					"title" => esc_html__('Substitute standard Wordpress gallery', 'globallogistics'),
					"desc" => esc_html__('Substitute standard Wordpress gallery with our slider on the single pages', 'globallogistics'),
					"divider" => false,
					"override" => "category,post,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
					
		"substitute_slider_engine" => array(
					"title" => esc_html__('Substitution Slider engine', 'globallogistics'),
					"desc" => esc_html__('What engine use to show slider instead standard gallery?', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "swiper",
					"options" => array(
						"swiper" => esc_html__("Swiper slider", 'globallogistics')
					),
					"type" => "radio"),
		
		"gallery_instead_image" => array(
					"title" => esc_html__('Show gallery instead featured image', 'globallogistics'),
					"desc" => esc_html__('Show slider with gallery instead featured image on blog streampage and in the related posts section for the gallery posts', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"gallery_max_slides" => array(
					"title" => esc_html__('Max images number in the slider', 'globallogistics'),
					"desc" => esc_html__('Maximum images number from gallery into slider', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "5",
					"min" => 2,
					"max" => 10,
					"type" => "spinner"),
		
		"popup_engine" => array(
					"title" => esc_html__('Gallery popup engine', 'globallogistics'),
					"desc" => esc_html__('Select engine to show popup windows with galleries', 'globallogistics'),
					"std" => "magnific",
					"options" => $THEMEREX_GLOBALS['options_params']['list_popups'],
					"type" => "select"),
		
		"popup_gallery" => array(
					"title" => esc_html__('Enable Gallery mode in the popup', 'globallogistics'),
					"desc" => esc_html__('Enable Gallery mode in the popup or show only single image', 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		"substitute_audio" => array(
					"title" => esc_html__('Substitute audio tags', 'globallogistics'),
					"desc" => esc_html__('Substitute audio tag with source from soundcloud to embed player', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"substitute_video" => array(
					"title" => esc_html__('Substitute video tags', 'globallogistics'),
					"desc" => esc_html__('Substitute video tags with embed players or leave video tags unchanged (if you use third party plugins for the video tags)', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"use_mediaelement" => array(
					"title" => esc_html__('Use Media Element script for audio and video tags', 'globallogistics'),
					"desc" => esc_html__('Do you want use the Media Element script for all audio and video tags on your site or leave standard HTML5 behaviour?', 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		
		
		
		// Customization -> Typography
		//-------------------------------------------------
		
		'customization_typography' => array(
					"title" => esc_html__("Typography", 'globallogistics'),
					"icon" => 'iconadmin-font',
					"type" => "tab"),
		
		"info_typo_1" => array(
					"title" => esc_html__('Typography settings', 'globallogistics'),
					"desc" => wp_kses_data(__('Select fonts, sizes and styles for the headings and paragraphs. You can use Google fonts and custom fonts.<br><br>How to install custom @font-face fonts into the theme?<br>All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!<br>Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.<br>Create your @font-face kit by using <a href="http://www.fontsquirrel.com/fontface/generator">Fontsquirrel @font-face Generator</a> and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install.', 'globallogistics')),
					"type" => "info"),
		
		"typography_custom" => array(
					"title" => esc_html__('Use custom typography', 'globallogistics'),
					"desc" => esc_html__('Use custom font settings or leave theme-styled fonts', 'globallogistics'),
					"divider" => false,
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"typography_h1_font" => array(
					"title" => esc_html__('Heading 1', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h1_size" => array(
					"title" => esc_html__('Size', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "48",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h1_lineheight" => array(
					"title" => esc_html__('Line height', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "60",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h1_weight" => array(
					"title" => esc_html__('Weight', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h1_style" => array(
					"title" => esc_html__('Style', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h1_color" => array(
					"title" => esc_html__('Color', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_h2_font" => array(
					"title" => esc_html__('Heading 2', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h2_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "36",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h2_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "43",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h2_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h2_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h2_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_h3_font" => array(
					"title" => esc_html__('Heading 3', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h3_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "24",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h3_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "28",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h3_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h3_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h3_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_h4_font" => array(
					"title" => esc_html__('Heading 4', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h4_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "20",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h4_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "24",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h4_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h4_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h4_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_h5_font" => array(
					"title" => esc_html__('Heading 5', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h5_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "18",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h5_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "20",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h5_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h5_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h5_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_h6_font" => array(
					"title" => esc_html__('Heading 6', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h6_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "16",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h6_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "18",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h6_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h6_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h6_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_p_font" => array(
					"title" => esc_html__('Paragraph text', 'globallogistics'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Source Sans Pro",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_p_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "14",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_p_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "21",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_p_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "300",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_p_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_p_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8 last",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		
		
		
		
		
		
		
		
		
		
		
		//###############################
		//#### Blog and Single pages #### 
		//###############################
		"partition_blog" => array(
					"title" => esc_html__('Blog &amp; Single', 'globallogistics'),
					"icon" => "iconadmin-docs",
					"override" => "category,post,page",
					"type" => "partition"),
		
		
		
		// Blog -> Stream page
		//-------------------------------------------------
		
		'blog_tab_stream' => array(
					"title" => esc_html__('Stream page', 'globallogistics'),
					"start" => 'blog_tabs',
					"icon" => "iconadmin-docs",
					"override" => "category,post,page",
					"type" => "tab"),
		
		"info_blog_1" => array(
					"title" => esc_html__('Blog streampage parameters', 'globallogistics'),
					"desc" => esc_html__('Select desired blog streampage parameters (you can override it in each category)', 'globallogistics'),
					"override" => "category,post,page",
					"type" => "info"),
		
		"blog_style" => array(
					"title" => esc_html__('Blog style', 'globallogistics'),
					"desc" => esc_html__('Select desired blog style', 'globallogistics'),
					"divider" => false,
					"override" => "category,page",
					"std" => "excerpt",
					"options" => $THEMEREX_GLOBALS['options_params']['list_blog_styles'],
					"type" => "select"),

		"dedicated_location" => array(
					"title" => esc_html__('Dedicated location', 'globallogistics'),
					"desc" => esc_html__('Select location for the dedicated content or featured image in the "excerpt" blog style', 'globallogistics'),
					"override" => "category,page,post",
					"std" => "default",
					"options" => $THEMEREX_GLOBALS['options_params']['list_locations'],
					"type" => "select"),
		
		"show_filters" => array(
					"title" => esc_html__('Show filters', 'globallogistics'),
					"desc" => esc_html__('Show filter buttons (only for Blog style = Portfolio, Masonry, Classic)', 'globallogistics'),
					"override" => "category,page",
					"std" => "hide",
					"options" => $THEMEREX_GLOBALS['options_params']['list_filters'],
					"type" => "checklist"),
		
		"blog_sort" => array(
					"title" => esc_html__('Blog posts sorted by', 'globallogistics'),
					"desc" => esc_html__('Select the desired sorting method for posts', 'globallogistics'),
					"override" => "category,page",
					"std" => "date",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sorting'],
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_order" => array(
					"title" => esc_html__('Blog posts order', 'globallogistics'),
					"desc" => esc_html__('Select the desired ordering method for posts', 'globallogistics'),
					"override" => "category,page",
					"std" => "desc",
					"options" => $THEMEREX_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),
		
		"posts_per_page" => array(
					"title" => esc_html__('Blog posts per page',  'globallogistics'),
					"desc" => esc_html__('How many posts display on blog pages for selected style. If empty or 0 - inherit system wordpress settings',  'globallogistics'),
					"override" => "category,page",
					"std" => "12",
					"mask" => "?99",
					"type" => "text"),
		
		"post_excerpt_maxlength" => array(
					"title" => esc_html__('Excerpt maxlength for streampage',  'globallogistics'),
					"desc" => esc_html__('How many characters from post excerpt are display in blog streampage (only for Blog style = Excerpt). 0 - do not trim excerpt.',  'globallogistics'),
					"override" => "category,page",
					"std" => "250",
					"mask" => "?9999",
					"type" => "text"),
		
		"post_excerpt_maxlength_masonry" => array(
					"title" => esc_html__('Excerpt maxlength for classic and masonry',  'globallogistics'),
					"desc" => esc_html__('How many characters from post excerpt are display in blog streampage (only for Blog style = Classic or Masonry). 0 - do not trim excerpt.',  'globallogistics'),
					"override" => "category,page",
					"std" => "150",
					"mask" => "?9999",
					"type" => "text"),
		
		
		
		
		// Blog -> Single page
		//-------------------------------------------------
		
		'blog_tab_single' => array(
					"title" => esc_html__('Single page', 'globallogistics'),
					"icon" => "iconadmin-doc",
					"override" => "category,post,page",
					"type" => "tab"),
		
		
		"info_blog_2" => array(
					"title" => esc_html__('Single (detail) pages parameters', 'globallogistics'),
					"desc" => esc_html__('Select desired parameters for single (detail) pages (you can override it in each category and single post (page))', 'globallogistics'),
					"override" => "category,post,page",
					"type" => "info"),
		
		"single_style" => array(
					"title" => esc_html__('Single page style', 'globallogistics'),
					"desc" => esc_html__('Select desired style for single page', 'globallogistics'),
					"divider" => false,
					"override" => "category,page,post",
					"std" => "single-standard",
					"options" => $THEMEREX_GLOBALS['options_params']['list_single_styles'],
					"dir" => "horizontal",
					"type" => "radio"),

		"top_panel_image" => array(
					"title" => esc_html__('Top panel image', 'globallogistics'),
					"desc" => esc_html__('Select default background image of the page header for Single fullscreen (if not single post or featured image for current post is not specified)', 'globallogistics'),
					"override" => "category,services_group,post,page",
					"std" => "",
					"type" => "media"),

		"portfolio_image_style" => array(
					"title" => esc_html__('Style display images in a portfolio (alternative)', 'globallogistics'),
					"desc" => esc_html__('Select style of the images in the portfolio (only for Blog style = Alternative)', 'globallogistics'),
					"divider" => true,
					"override" => "category,post",
					"std" => "image-square-1",
					"options" => $THEMEREX_GLOBALS['options_params']['list_portfolio_image_style'],
					"dir" => "horizontal",
					"type" => "radio"),



		
		"show_featured_image" => array(
					"title" => esc_html__('Show featured image before post',  'globallogistics'),
					"desc" => esc_html__("Show featured image (if selected) before post content on single pages", 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_title" => array(
					"title" => esc_html__('Show post title', 'globallogistics'),
					"desc" => esc_html__('Show area with post title on single pages', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_title_on_quotes" => array(
					"title" => esc_html__('Show post title on links, chat, quote, status', 'globallogistics'),
					"desc" => esc_html__('Show area with post title on single and blog pages in specific post formats: links, chat, quote, status', 'globallogistics'),
					"override" => "category,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_info" => array(
					"title" => esc_html__('Show post info', 'globallogistics'),
					"desc" => esc_html__('Show area with post info on single pages', 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_text_before_readmore" => array(
					"title" => esc_html__('Show text before "Read more" tag', 'globallogistics'),
					"desc" => esc_html__('Show text before "Read more" tag on single pages', 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
					
		"show_post_author" => array(
					"title" => esc_html__('Show post author details',  'globallogistics'),
					"desc" => esc_html__("Show post author information block on single post page", 'globallogistics'),
					"override" => "category,post,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_tags" => array(
					"title" => esc_html__('Show post tags and categories',  'globallogistics'),
					"desc" => esc_html__("Show tags block and categories on single post page", 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_counters" => array(
					"title" => esc_html__('Show post counters',  'globallogistics'),
					"desc" => esc_html__("Show counters block on single post page", 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_related" => array(
					"title" => esc_html__('Show related posts',  'globallogistics'),
					"desc" => esc_html__("Show related posts block on single post page", 'globallogistics'),
					"override" => "category,post,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"post_related_count" => array(
					"title" => esc_html__('Related posts number',  'globallogistics'),
					"desc" => esc_html__("How many related posts showed on single post page", 'globallogistics'),
					"override" => "category,post,page",
					"std" => "2",
					"step" => 1,
					"min" => 2,
					"max" => 8,
					"type" => "spinner"),

		"post_related_columns" => array(
					"title" => esc_html__('Related posts columns',  'globallogistics'),
					"desc" => esc_html__("How many columns used to show related posts on single post page. 1 - use scrolling to show all related posts", 'globallogistics'),
					"override" => "category,post,page",
					"std" => "2",
					"step" => 1,
					"min" => 1,
					"max" => 4,
					"type" => "spinner"),
		
		"post_related_sort" => array(
					"title" => esc_html__('Related posts sorted by', 'globallogistics'),
					"desc" => esc_html__('Select the desired sorting method for related posts', 'globallogistics'),
					"std" => "date",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sorting'],
					"type" => "select"),
		
		"post_related_order" => array(
					"title" => esc_html__('Related posts order', 'globallogistics'),
					"desc" => esc_html__('Select the desired ordering method for related posts', 'globallogistics'),
					"std" => "desc",
					"options" => $THEMEREX_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),
		
		"show_post_comments" => array(
					"title" => esc_html__('Show comments',  'globallogistics'),
					"desc" => esc_html__("Show comments block on single post page", 'globallogistics'),
					"override" => "category,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		
		// Blog -> Other parameters
		//-------------------------------------------------
		
		'blog_tab_general' => array(
					"title" => esc_html__('Other parameters', 'globallogistics'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,page",
					"type" => "tab"),
		
		"info_blog_3" => array(
					"title" => esc_html__('Other Blog parameters', 'globallogistics'),
					"desc" => esc_html__('Select excluded categories, substitute parameters, etc.', 'globallogistics'),
					"type" => "info"),
		
		"exclude_cats" => array(
					"title" => esc_html__('Exclude categories', 'globallogistics'),
					"desc" => esc_html__('Select categories, which posts are exclude from blog page', 'globallogistics'),
					"divider" => false,
					"std" => "",
					"options" => $THEMEREX_GLOBALS['options_params']['list_categories'],
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"blog_pagination" => array(
					"title" => esc_html__('Blog pagination', 'globallogistics'),
					"desc" => esc_html__('Select type of the pagination on blog streampages', 'globallogistics'),
					"std" => "pages",
					"override" => "category,page",
					"options" => array(
						'pages'    => esc_html__('Standard page numbers', 'globallogistics'),
						'viewmore' => esc_html__("\"View more\" button", 'globallogistics')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_counters" => array(
					"title" => esc_html__('Blog counters', 'globallogistics'),
					"desc" => esc_html__('Select counters, displayed near the post title', 'globallogistics'),
					"std" => "views",
					"override" => "category,page",
					"options" => array(
						'views' => esc_html__('Views', 'globallogistics'),
						'likes' => esc_html__('Likes', 'globallogistics'),
						'rating' => esc_html__('Rating', 'globallogistics'),
						'comments' => esc_html__('Comments', 'globallogistics')
					),
					"dir" => "vertical",
					"multiple" => true,
					"type" => "checklist"),
		
		"close_category" => array(
					"title" => esc_html__("Post's category announce", 'globallogistics'),
					"desc" => esc_html__('What category display in announce block (over posts thumb) - original or nearest parental', 'globallogistics'),
					"std" => "parental",
					"override" => "category,page",
					"options" => array(
						'parental' => esc_html__('Nearest parental category', 'globallogistics'),
						'original' => esc_html__("Original post's category", 'globallogistics')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"show_date_after" => array(
					"title" => esc_html__('Show post date after', 'globallogistics'),
					"desc" => esc_html__('Show post date after N days (before - show post age)', 'globallogistics'),
					"override" => "category,page",
					"std" => "30",
					"mask" => "?99",
					"type" => "text"),
		

		//###############################
		//#### Reviews               #### 
		//###############################
		"partition_reviews" => array(
					"title" => esc_html__('Reviews', 'globallogistics'),
					"icon" => "iconadmin-newspaper",
					"override" => "category",
					"type" => "partition"),
		
		"info_reviews_1" => array(
					"title" => esc_html__('Reviews criterias', 'globallogistics'),
					"desc" => esc_html__('Set up list of reviews criterias. You can override it in any category.', 'globallogistics'),
					"override" => "category",
					"type" => "info"),
		
		"show_reviews" => array(
					"title" => esc_html__('Show reviews block',  'globallogistics'),
					"desc" => esc_html__("Show reviews block on single post page and average reviews rating after post's title in stream pages", 'globallogistics'),
					"divider" => false,
					"override" => "category",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"reviews_max_level" => array(
					"title" => esc_html__('Max reviews level',  'globallogistics'),
					"desc" => esc_html__("Maximum level for reviews marks", 'globallogistics'),
					"std" => "100",
					"options" => array(
						'5'=>esc_html__('5 stars', 'globallogistics'),
						'10'=>esc_html__('10 stars', 'globallogistics'),
						'100'=>esc_html__('100%', 'globallogistics')
					),
					"type" => "radio",
					),
		
		"reviews_style" => array(
					"title" => esc_html__('Show rating as',  'globallogistics'),
					"desc" => esc_html__("Show rating marks as text or as stars/progress bars.", 'globallogistics'),
					"std" => "stars",
					"options" => array(
						'text' => esc_html__('As text (for example: 7.5 / 10)', 'globallogistics'),
						'stars' => esc_html__('As stars or bars', 'globallogistics')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"reviews_criterias_levels" => array(
					"title" => esc_html__('Reviews Criterias Levels', 'globallogistics'),
					"desc" => esc_html__('Words to mark criterials levels. Just write the word and press "Enter". Also you can arrange words.', 'globallogistics'),
					"std" => esc_html__("bad,poor,normal,good,great", 'globallogistics'),
					"type" => "tags"),
		
		"reviews_first" => array(
					"title" => esc_html__('Show first reviews',  'globallogistics'),
					"desc" => esc_html__("What reviews will be displayed first: by author or by visitors. Also this type of reviews will display under post's title.", 'globallogistics'),
					"std" => "author",
					"options" => array(
						'author' => esc_html__('By author', 'globallogistics'),
						'users' => esc_html__('By visitors', 'globallogistics')
						),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_second" => array(
					"title" => esc_html__('Hide second reviews',  'globallogistics'),
					"desc" => esc_html__("Do you want hide second reviews tab in widgets and single posts?", 'globallogistics'),
					"std" => "hide",
					"options" => $THEMEREX_GLOBALS['options_params']['list_show_hide'],
					"size" => "medium",
					"type" => "switch"),
		
		"reviews_can_vote" => array(
					"title" => esc_html__('What visitors can vote',  'globallogistics'),
					"desc" => esc_html__("What visitors can vote: all or only registered", 'globallogistics'),
					"std" => "all",
					"options" => array(
						'all'=>esc_html__('All visitors', 'globallogistics'),
						'registered'=>esc_html__('Only registered', 'globallogistics')
					),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_criterias" => array(
					"title" => esc_html__('Reviews criterias',  'globallogistics'),
					"desc" => esc_html__('Add default reviews criterias.',  'globallogistics'),
					"override" => "category",
					"std" => "",
					"cloneable" => true,
					"type" => "text"),

		"reviews_marks" => array(
					"std" => "",
					"type" => "hidden"),
		
		
		
		
		
		//###############################
		//#### Contact info          #### 
		//###############################
		"partition_contacts" => array(
					"title" => esc_html__('Contact info', 'globallogistics'),
					"icon" => "iconadmin-mail-1",
					"type" => "partition"),
		
		"info_contact_1" => array(
					"title" => esc_html__('Contact information', 'globallogistics'),
					"desc" => esc_html__('Company address, phones and e-mail', 'globallogistics'),
					"type" => "info"),
		
		"contact_email" => array(
					"title" => esc_html__('Contact form email', 'globallogistics'),
					"desc" => esc_html__('E-mail for send contact form and user registration data', 'globallogistics'),
					"divider" => false,
					"std" => "",
					"before" => array('icon'=>'iconadmin-mail-1'),
					"type" => "text"),
		
		"contact_address_1" => array(
					"title" => esc_html__('Company address (part 1)', 'globallogistics'),
					"desc" => esc_html__('Company country, post code and city', 'globallogistics'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_address_2" => array(
					"title" => esc_html__('Company address (part 2)', 'globallogistics'),
					"desc" => esc_html__('Street and house number', 'globallogistics'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_phone" => array(
					"title" => esc_html__('Phone', 'globallogistics'),
					"desc" => esc_html__('Phone number', 'globallogistics'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"type" => "text"),
		
		"contact_fax" => array(
					"title" => esc_html__('Fax', 'globallogistics'),
					"desc" => esc_html__('Fax number', 'globallogistics'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"type" => "text"),
		
		"contact_info" => array(
					"title" => esc_html__('Contacts in top panel', 'globallogistics'),
					"desc" => esc_html__('String with contact info in the site header', 'globallogistics'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),




		"info_contact_2" => array(
					"title" => esc_html__('Contact and Comments form', 'globallogistics'),
					"desc" => esc_html__('Maximum length of the messages in the contact form shortcode and in the comments form', 'globallogistics'),
					"type" => "info"),

		"message_maxlength_contacts" => array(
					"title" => esc_html__('Contact form message', 'globallogistics'),
					"desc" => esc_html__("Message's maxlength in the contact form shortcode", 'globallogistics'),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"message_maxlength_comments" => array(
					"title" => esc_html__('Comments form message', 'globallogistics'),
					"desc" => esc_html__("Message's maxlength in the comments form", 'globallogistics'),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"info_contact_3" => array(
					"title" => esc_html__('Default mail function', 'globallogistics'),
					"desc" => esc_html__('What function you want to use for sending mail: the built-in Wordpress or standard PHP function? Attention! Some plugins may not work with one of them and you always have the ability to switch to alternative.', 'globallogistics'),
					"type" => "info"),
		
		"mail_function" => array(
					"title" => esc_html__("Mail function", 'globallogistics'),
					"desc" => esc_html__("What function you want to use for sending mail?", 'globallogistics'),
					"std" => "wp_mail",
					"size" => "medium",
					"options" => array(
						'wp_mail' => esc_html__('WP mail', 'globallogistics'),
						'mail' => esc_html__('PHP mail', 'globallogistics')
					),
					"type" => "switch"),
		
		
		
		
		//###############################
		//#### Socials               #### 
		//###############################
		"partition_socials" => array(
					"title" => esc_html__('Socials', 'globallogistics'),
					"icon" => "iconadmin-users-1",
					"override" => "category,page",
					"type" => "partition"),
		
		"info_socials_1" => array(
					"title" => esc_html__('Social networks', 'globallogistics'),
					"desc" => esc_html__("Social networks list for site footer and Social widget", 'globallogistics'),
					"type" => "info"),
		
		"social_icons" => array(
					"title" => esc_html__('Social networks',  'globallogistics'),
					"desc" => esc_html__('Select icon and write URL to your profile in desired social networks.',  'globallogistics'),
					"divider" => false,
					"std" => array(array('url'=>'', 'icon'=>'')),
					"options" => $THEMEREX_GLOBALS['options_params']['list_icons'],
					"cloneable" => true,
					"size" => "small",
					"style" => 'icons',
					"type" => "socials"),



		"top_social_icons" => array(
					"title" => esc_html__('Show Social networks', 'globallogistics'),
					"desc" => esc_html__('Show Social networks in top of page', 'globallogistics'),
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),



		
		"info_socials_2" => array(
					"title" => esc_html__('Share buttons', 'globallogistics'),
					"override" => "category,page",
					"desc" => wp_kses_data(__("Add button's code for each social share network.<br>
					In share url you can use next macro:<br>
					<b>{url}</b> - share post (page) URL,<br>
					<b>{title}</b> - post title,<br>
					<b>{image}</b> - post image,<br>
					<b>{descr}</b> - post description (if supported)<br>
					For example:<br>
					<b>Facebook</b> share string: <em>http://www.facebook.com/sharer.php?u={link}&amp;t={title}</em><br>
					<b>Delicious</b> share string: <em>http://delicious.com/save?url={link}&amp;title={title}&amp;note={descr}</em>", 'globallogistics')),
					"type" => "info"),
		
		"show_share" => array(
					"title" => esc_html__('Show social share buttons',  'globallogistics'),
					"override" => "category,page",
					"desc" => esc_html__("Show social share buttons block", 'globallogistics'),
					"std" => "horizontal",
					"options" => array(
						'hide'		=> esc_html__('Hide', 'globallogistics'),
						'vertical'	=> esc_html__('Vertical', 'globallogistics'),
						'horizontal'=> esc_html__('Horizontal', 'globallogistics')
					),
					"type" => "checklist"),

		"show_share_counters" => array(
					"title" => esc_html__('Show share counters',  'globallogistics'),
					"override" => "category,page",
					"desc" => esc_html__("Show share counters after social buttons", 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"share_caption" => array(
					"title" => esc_html__('Share block caption',  'globallogistics'),
					"override" => "category,page",
					"desc" => esc_html__('Caption for the block with social share buttons',  'globallogistics'),
					"std" => esc_html__('Share:', 'globallogistics'),
					"type" => "text"),
		
		"share_buttons" => array(
					"title" => esc_html__('Share buttons',  'globallogistics'),
					"desc" => wp_kses_data(__('Select icon and write share URL for desired social networks.<br><b>Important!</b> If you leave text field empty - internal theme link will be used (if present).',  'globallogistics')),
					"std" => array(array('url'=>'', 'icon'=>'')),
					"options" => $THEMEREX_GLOBALS['options_params']['list_icons'],
					"cloneable" => true,
					"size" => "small",
					"style" => 'icons',
					"type" => "socials"),
		
		
		"info_socials_3" => array(
					"title" => esc_html__('Twitter API keys', 'globallogistics'),
					"desc" => wp_kses_data(__("Put to this section Twitter API 1.1 keys.<br>
					You can take them after registration your application in <strong>https://apps.twitter.com/</strong>", 'globallogistics')),
					"type" => "info"),
		
		"twitter_username" => array(
					"title" => esc_html__('Twitter username',  'globallogistics'),
					"desc" => esc_html__('Your login (username) in Twitter',  'globallogistics'),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_consumer_key" => array(
					"title" => esc_html__('Consumer Key',  'globallogistics'),
					"desc" => esc_html__('Twitter API Consumer key',  'globallogistics'),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_consumer_secret" => array(
					"title" => esc_html__('Consumer Secret',  'globallogistics'),
					"desc" => esc_html__('Twitter API Consumer secret',  'globallogistics'),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_token_key" => array(
					"title" => esc_html__('Token Key',  'globallogistics'),
					"desc" => esc_html__('Twitter API Token key',  'globallogistics'),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_token_secret" => array(
					"title" => esc_html__('Token Secret',  'globallogistics'),
					"desc" => esc_html__('Twitter API Token secret',  'globallogistics'),
					"divider" => false,
					"std" => "",
					"type" => "text"),

		"info_socials_4" => array(
					"title" => esc_html__('Login via Social network', 'globallogistics'),
					"desc" => esc_html__("Settings for the Login via Social networks", 'globallogistics'),
					"type" => "info"),

		"social_login" => array(
					"title" => esc_html__('Social plugin shortcode',  'globallogistics'),
					"desc" => esc_html__('Social plugin shortcode like [plugin_shortcode]',  'globallogistics'),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		
		
		
		
		//###############################
		//#### Search parameters     #### 
		//###############################
		"partition_search" => array(
					"title" => esc_html__('Search', 'globallogistics'),
					"icon" => "iconadmin-search-1",
					"type" => "partition"),
		
		"info_search_1" => array(
					"title" => esc_html__('Search parameters', 'globallogistics'),
					"desc" => esc_html__('Enable/disable AJAX search and output settings for it', 'globallogistics'),
					"type" => "info"),
		
		"show_search" => array(
					"title" => esc_html__('Show search field', 'globallogistics'),
					"desc" => esc_html__('Show search field in the top area(user menu)', 'globallogistics'),
					"divider" => false,
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"use_ajax_search" => array(
					"title" => esc_html__('Enable AJAX search', 'globallogistics'),
					"desc" => esc_html__('Use incremental AJAX search for the search field in top of page', 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_min_length" => array(
					"title" => esc_html__('Min search string length',  'globallogistics'),
					"desc" => esc_html__('The minimum length of the search string',  'globallogistics'),
					"std" => 4,
					"min" => 3,
					"type" => "spinner"),
		
		"ajax_search_delay" => array(
					"title" => esc_html__('Delay before search (in ms)',  'globallogistics'),
					"desc" => esc_html__('How much time (in milliseconds, 1000 ms = 1 second) must pass after the last character before the start search',  'globallogistics'),
					"std" => 500,
					"min" => 300,
					"max" => 1000,
					"step" => 100,
					"type" => "spinner"),
		
		"ajax_search_types" => array(
					"title" => esc_html__('Search area', 'globallogistics'),
					"desc" => esc_html__('Select post types, what will be include in search results. If not selected - use all types.', 'globallogistics'),
					"std" => "",
					"options" => $THEMEREX_GLOBALS['options_params']['list_posts_types'],
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"ajax_search_posts_count" => array(
					"title" => esc_html__('Posts number in output',  'globallogistics'),
					"desc" => esc_html__('Number of the posts to show in search results',  'globallogistics'),
					"std" => 5,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),
		
		"ajax_search_posts_image" => array(
					"title" => esc_html__("Show post's image", 'globallogistics'),
					"desc" => esc_html__("Show post's thumbnail in the search results", 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_posts_date" => array(
					"title" => esc_html__("Show post's date", 'globallogistics'),
					"desc" => esc_html__("Show post's publish date in the search results", 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_posts_author" => array(
					"title" => esc_html__("Show post's author", 'globallogistics'),
					"desc" => esc_html__("Show post's author in the search results", 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_posts_counters" => array(
					"title" => esc_html__("Show post's counters", 'globallogistics'),
					"desc" => esc_html__("Show post's counters (views, comments, likes) in the search results", 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		
		
		
		//###############################
		//#### Service               #### 
		//###############################
		
		"partition_service" => array(
					"title" => esc_html__('Service', 'globallogistics'),
					"icon" => "iconadmin-wrench",
					"type" => "partition"),
		
		"info_service_1" => array(
					"title" => esc_html__('Theme functionality', 'globallogistics'),
					"desc" => esc_html__('Basic theme functionality settings', 'globallogistics'),
					"type" => "info"),
				
		"use_ajax_views_counter" => array(
					"title" => esc_html__('Use AJAX post views counter', 'globallogistics'),
					"desc" => esc_html__('Use javascript for post views count (if site work under the caching plugin) or increment views count in single page template', 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"admin_add_filters" => array(
					"title" => esc_html__('Additional filters in the admin panel', 'globallogistics'),
					"desc" => wp_kses_data(__('Show additional filters (on post formats, tags and categories) in admin panel page "Posts". <br>Attention! If you have more than 2.000-3.000 posts, enabling this option may cause slow load of the "Posts" page! If you encounter such slow down, simply open Appearance - Theme Options - Service and set "No" for this option.', 'globallogistics')),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_overriden_taxonomies" => array(
					"title" => esc_html__('Show overriden options for taxonomies', 'globallogistics'),
					"desc" => esc_html__('Show extra column in categories list, where changed (overriden) theme options are displayed.', 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_overriden_posts" => array(
					"title" => esc_html__('Show overriden options for posts and pages', 'globallogistics'),
					"desc" => esc_html__('Show extra column in posts and pages list, where changed (overriden) theme options are displayed.', 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"admin_dummy_data" => array(
					"title" => esc_html__('Enable Dummy Data Installer', 'globallogistics'),
					"desc" => wp_kses_data(__('Show "Install Dummy Data" in the menu "Appearance". <b>Attention!</b> When you install dummy data all content of your site will be replaced!', 'globallogistics')),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"admin_dummy_timeout" => array(
					"title" => esc_html__('Dummy Data Installer Timeout',  'globallogistics'),
					"desc" => esc_html__('Web-servers set the time limit for the execution of php-scripts. By default, this is 30 sec. Therefore, the import process will be split into parts. Upon completion of each part - the import will resume automatically! The import process will try to increase this limit to the time, specified in this field.',  'globallogistics'),
					"std" => 500,
					"min" => 10,
					"max" => 600,
					"type" => "spinner"),
		
		"admin_update_notifier" => array(
					"title" => esc_html__('Enable Update Notifier', 'globallogistics'),
					"desc" => wp_kses_data(__('Show update notifier in admin panel. <b>Attention!</b> When this option is enabled, the theme periodically (every few hours) will communicate with our server, to check the current version. When the connection is slow, it may slow down Dashboard.', 'globallogistics')),
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"admin_emailer" => array(
					"title" => esc_html__('Enable Emailer in the admin panel', 'globallogistics'),
					"desc" => esc_html__('Allow to use ThemeREX Emailer for mass-volume e-mail distribution and management of mailing lists in "Appearance - Emailer"', 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"clear_shortcodes" => array(
					"title" => esc_html__('Remove line breaks around shortcodes', 'globallogistics'),
					"desc" => wp_kses_data(__('Do you want remove spaces and line breaks around shortcodes? <b>Be attentive!</b> This option thoroughly tested on our theme, but may affect third party plugins.', 'globallogistics')),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"packed_scripts" => array(
					"title" => esc_html__('Use packed css and js files', 'globallogistics'),
					"desc" => esc_html__('Do you want to use one packed css and one js file with most theme scripts and styles instead many separate files (for speed up page loading). This reduces the number of HTTP requests when loading pages.', 'globallogistics'),
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"gtm_code" => array(
					"title" => esc_html__('Google tags manager or Google analitics code',  'globallogistics'),
					"desc" => esc_html__('Put here Google Tags Manager (GTM) code from your account: Google analitics, remarketing, etc. This code will be placed after open body tag.',  'globallogistics'),
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"),
		
		"gtm_code2" => array(
					"title" => esc_html__('Google remarketing code',  'globallogistics'),
					"desc" => esc_html__('Put here Google Remarketing code from your account. This code will be placed before close body tag.',  'globallogistics'),
					"divider" => false,
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"),
		
		"info_service_2" => array(
					"title" => esc_html__('API Keys', 'globallogistics'),
					"desc" => wp_kses_data( esc_html__('API Keys for some Web services', 'globallogistics') ),
					"type" => "info"),

		"api_google" => array(
					"title" => esc_html__('Google API Key', 'globallogistics'),
					"desc" => wp_kses_data( __("Insert Google API Key for browsers into the field above to generate Google Maps", 'globallogistics') ),
					"std" => "",
					"type" => "text")
		);


		// Woocommerce
		if (themerex_exists_woocommerce()) {
			$THEMEREX_GLOBALS['options']["partition_woocommerce"] = array(
					"title" => esc_html__('WooCommerce', 'globallogistics'),
					"icon" => "iconadmin-basket-1",
					"type" => "partition");
		
			$THEMEREX_GLOBALS['options']["info_wooc_1"] = array(
					"title" => esc_html__('WooCommerce products list parameters', 'globallogistics'),
					"desc" => esc_html__("Select WooCommerce products list's style and crop parameters", 'globallogistics'),
					"type" => "info");
		
			$THEMEREX_GLOBALS['options']["shop_mode"] = array(
					"title" => esc_html__('Shop list style',  'globallogistics'),
					"desc" => esc_html__("WooCommerce products list's style: thumbs or list with description", 'globallogistics'),
					"std" => "thumbs",
					"divider" => false,
					"options" => array(
						'thumbs' => esc_html__('Thumbs', 'globallogistics'),
						'list' => esc_html__('List', 'globallogistics')
					),
					"type" => "checklist");
		
			$THEMEREX_GLOBALS['options']["show_mode_buttons"] = array(
					"title" => esc_html__('Show style buttons',  'globallogistics'),
					"desc" => esc_html__("Show buttons to allow visitors change list style", 'globallogistics'),
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch");

			$THEMEREX_GLOBALS['options']["crop_product_thumb"] = array(
					"title" => esc_html__('Crop product thumbnail',  'globallogistics'),
					"desc" => esc_html__("Crop product's thumbnails on search results page", 'globallogistics'),
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch");
		
			$THEMEREX_GLOBALS['options']["show_category_bg"] = array(
					"title" => esc_html__('Show category background',  'globallogistics'),
					"desc" => esc_html__("Show background under thumbnails for the product's categories", 'globallogistics'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch");
		}
	}
}
?>