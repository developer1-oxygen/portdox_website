<?php

// Width and height params
if ( !function_exists( 'themerex_vc_width' ) ) {
	function themerex_vc_width($w='') {
		return array(
			"param_name" => "width",
			"heading" => __("Width", "trx_addons"),
			"description" => __("Width (in pixels or percent) of the current element", "trx_addons"),
			"group" => __('Size &amp; Margins', 'trx_addons'),
			"value" => $w,
			"type" => "textfield"
		);
	}
}
if ( !function_exists( 'themerex_vc_height' ) ) {
	function themerex_vc_height($h='') {
		return array(
			"param_name" => "height",
			"heading" => __("Height", "trx_addons"),
			"description" => __("Height (only in pixels) of the current element", "trx_addons"),
			"group" => __('Size &amp; Margins', 'trx_addons'),
			"value" => $h,
			"type" => "textfield"
		);
	}
}

// Load scripts and styles for VC support
if ( !function_exists( 'themerex_shortcodes_vc_scripts_admin' ) ) {
	//add_action( 'admin_enqueue_scripts', 'themerex_shortcodes_vc_scripts_admin' );
	function themerex_shortcodes_vc_scripts_admin() {
		// Include CSS 
		wp_enqueue_style ( 'shortcodes_vc-style', trx_addons_get_file_url('shortcodes/shortcodes_vc_admin.css'), array(), null );
		// Include JS
		wp_enqueue_script( 'shortcodes_vc-script', trx_addons_get_file_url('shortcodes/shortcodes_vc_admin.js'), array(), null, true );
	}
}

// Load scripts and styles for VC support
if ( !function_exists( 'themerex_shortcodes_vc_scripts_front' ) ) {
	//add_action( 'wp_enqueue_scripts', 'themerex_shortcodes_vc_scripts_front' );
	function themerex_shortcodes_vc_scripts_front() {
		if (themerex_vc_is_frontend()) {
			// Include CSS 
			wp_enqueue_style ( 'shortcodes_vc-style', trx_addons_get_file_url('shortcodes/shortcodes_vc_front.css'), array(), null );
		}
	}
}

// Add init script into shortcodes output in VC frontend editor
if ( !function_exists( 'themerex_shortcodes_vc_add_init_script' ) ) {
	//add_filter('themerex_shortcode_output', 'themerex_shortcodes_vc_add_init_script', 10, 4);
	function themerex_shortcodes_vc_add_init_script($output, $tag='', $atts=array(), $content='') {
		if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') && (isset($_POST['action']) && $_POST['action']=='vc_load_shortcode')
				&& ( isset($_POST['shortcodes'][0]['tag']) && $_POST['shortcodes'][0]['tag']==$tag )
		) {
			if (themerex_strpos($output, 'themerex_vc_init_shortcodes')===false) {
				$id = "themerex_vc_init_shortcodes_".str_replace('.', '', mt_rand());
				$output .= '
					<script id="'.esc_attr($id).'">
						try {
							themerex_init_post_formats();
							themerex_init_shortcodes(jQuery("body").eq(0));
							themerex_scroll_actions();
						} catch (e) { };
					</script>
				';
			}
		}
		return $output;
	}
}


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_shortcodes_vc_theme_setup' ) ) {
	//if ( themerex_vc_is_frontend() )
	if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') || (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline') )
		add_action( 'themerex_action_before_init_theme', 'themerex_shortcodes_vc_theme_setup', 20 );
	else
		add_action( 'themerex_action_after_init_theme', 'themerex_shortcodes_vc_theme_setup' );
	function themerex_shortcodes_vc_theme_setup() {
		if (themerex_shortcodes_is_used()) {
			// Set VC as main editor for the theme
			vc_set_as_theme( true );
			
			// Enable VC on follow post types
			vc_set_default_editor_post_types( array('page', 'team') );
			
			// Disable frontend editor
			//vc_disable_frontend();

			// Load scripts and styles for VC support
			add_action( 'wp_enqueue_scripts',		'themerex_shortcodes_vc_scripts_front');
			add_action( 'admin_enqueue_scripts',	'themerex_shortcodes_vc_scripts_admin' );

			// Add init script into shortcodes output in VC frontend editor
			add_filter('themerex_shortcode_output', 'themerex_shortcodes_vc_add_init_script', 10, 4);

			// Remove standard VC shortcodes
//			vc_remove_element("vc_button");
//			vc_remove_element("vc_posts_slider");
//			vc_remove_element("vc_gmaps");
//			vc_remove_element("vc_teaser_grid");
//			vc_remove_element("vc_progress_bar");
//			vc_remove_element("vc_facebook");
//			vc_remove_element("vc_tweetmeme");
//			vc_remove_element("vc_googleplus");
//			vc_remove_element("vc_facebook");
//			vc_remove_element("vc_pinterest");
//			vc_remove_element("vc_message");
//			vc_remove_element("vc_posts_grid");
//			vc_remove_element("vc_carousel");
//			vc_remove_element("vc_flickr");
//			vc_remove_element("vc_tour");
//			vc_remove_element("vc_separator");
//			vc_remove_element("vc_single_image");
//			vc_remove_element("vc_cta_button");
//			vc_remove_element("vc_accordion");
//			vc_remove_element("vc_accordion_tab");
//			vc_remove_element("vc_toggle");
//			vc_remove_element("vc_tabs");
//			vc_remove_element("vc_tab");
//			vc_remove_element("vc_images_carousel");
			
			// Remove standard WP widgets
			vc_remove_element("vc_wp_archives");
			vc_remove_element("vc_wp_calendar");
			vc_remove_element("vc_wp_categories");
			vc_remove_element("vc_wp_custommenu");
			vc_remove_element("vc_wp_links");
			vc_remove_element("vc_wp_meta");
			vc_remove_element("vc_wp_pages");
			vc_remove_element("vc_wp_posts");
			vc_remove_element("vc_wp_recentcomments");
			vc_remove_element("vc_wp_rss");
			vc_remove_element("vc_wp_search");
			vc_remove_element("vc_wp_tagcloud");
			vc_remove_element("vc_wp_text");
			
			global $THEMEREX_GLOBALS;
			
			$THEMEREX_GLOBALS['vc_params'] = array(
				
				// Common arrays and strings
				'category' => __("ThemeREX shortcodes", "trx_addons"),
			
				// Current element id
				'id' => array(
					"param_name" => "id",
					"heading" => __("Element ID", "trx_addons"),
					"description" => __("ID for current element", "trx_addons"),
					"group" => __('Size &amp; Margins', 'trx_addons'),
					"value" => "",
					"type" => "textfield"
				),
			
				// Current element class
				'class' => array(
					"param_name" => "class",
					"heading" => __("Element CSS class", "trx_addons"),
					"description" => __("CSS class for current element", "trx_addons"),
					"group" => __('Size &amp; Margins', 'trx_addons'),
					"value" => "",
					"type" => "textfield"
				),

				// Current element animation
				'animation' => array(
					"param_name" => "animation",
					"heading" => __("Animation", "trx_addons"),
					"description" => __("Select animation while object enter in the visible area of page", "trx_addons"),
					"class" => "",
					"value" => array_flip($THEMEREX_GLOBALS['sc_params']['animations']),
					"type" => "dropdown"
				),
			
				// Current element style
				'css' => array(
					"param_name" => "css",
					"heading" => __("CSS styles", "trx_addons"),
					"description" => __("Any additional CSS rules (if need)", "trx_addons"),
					"group" => __('Size &amp; Margins', 'trx_addons'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
			
				// Margins params
				'margin_top' => array(
					"param_name" => "top",
					"heading" => __("Top margin", "trx_addons"),
					"description" => __("Top margin (in pixels).", "trx_addons"),
					"group" => __('Size &amp; Margins', 'trx_addons'),
					"value" => "",
					"type" => "textfield"
				),
			
				'margin_bottom' => array(
					"param_name" => "bottom",
					"heading" => __("Bottom margin", "trx_addons"),
					"description" => __("Bottom margin (in pixels).", "trx_addons"),
					"group" => __('Size &amp; Margins', 'trx_addons'),
					"value" => "",
					"type" => "textfield"
				),
			
				'margin_left' => array(
					"param_name" => "left",
					"heading" => __("Left margin", "trx_addons"),
					"description" => __("Left margin (in pixels).", "trx_addons"),
					"group" => __('Size &amp; Margins', 'trx_addons'),
					"value" => "",
					"type" => "textfield"
				),
				
				'margin_right' => array(
					"param_name" => "right",
					"heading" => __("Right margin", "trx_addons"),
					"description" => __("Right margin (in pixels).", "trx_addons"),
					"group" => __('Size &amp; Margins', 'trx_addons'),
					"value" => "",
					"type" => "textfield"
				)
			);
	
	
	
			// Accordion
			//-------------------------------------------------------------------------------------
			vc_map( array(
				"base" => "trx_accordion",
				"name" => __("Accordion", "trx_addons"),
				"description" => __("Accordion items", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_accordion',
				"class" => "trx_sc_collection trx_sc_accordion",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"as_parent" => array('only' => 'trx_accordion_item'),	// Use only|except attributes to limit child shortcodes (separate multiple values with comma)
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => __("Accordion style", "trx_addons"),
						"description" => __("Select style for display accordion", "trx_addons"),
						"class" => "",
						"admin_label" => true,
						"value" => array(
							__('Style 1', 'trx_addons') => 1,
							__('Style 2', 'trx_addons') => 2
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "initial",
						"heading" => __("Initially opened item", "trx_addons"),
						"description" => __("Number of initially opened item", "trx_addons"),
						"class" => "",
						"value" => 1,
						"type" => "textfield"
					),
					array(
						"param_name" => "icon_closed",
						"heading" => __("Icon while closed", "trx_addons"),
						"description" => __("Select icon for the closed accordion item from Fontello icons set", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_opened",
						"heading" => __("Icon while opened", "trx_addons"),
						"description" => __("Select icon for the opened accordion item from Fontello icons set", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'default_content' => '
					[trx_accordion_item title="' . __( 'Item 1 title', 'trx_addons' ) . '"][/trx_accordion_item]
					[trx_accordion_item title="' . __( 'Item 2 title', 'trx_addons' ) . '"][/trx_accordion_item]
				',
				"custom_markup" => '
					<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
						%content%
					</div>
					<div class="tab_controls">
						<button class="add_tab" title="'.__("Add item", "trx_addons").'">'.__("Add item", "trx_addons").'</button>
					</div>
				',
				'js_view' => 'VcTrxAccordionView'
			) );
			
			
			vc_map( array(
				"base" => "trx_accordion_item",
				"name" => __("Accordion item", "trx_addons"),
				"description" => __("Inner accordion item", "trx_addons"),
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_accordion_item',
				"as_child" => array('only' => 'trx_accordion'), 	// Use only|except attributes to limit parent (separate multiple values with comma)
				"as_parent" => array('except' => 'trx_accordion'),
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Title for current accordion item", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "icon_closed",
						"heading" => __("Icon while closed", "trx_addons"),
						"description" => __("Select icon for the closed accordion item from Fontello icons set", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_opened",
						"heading" => __("Icon while opened", "trx_addons"),
						"description" => __("Select icon for the opened accordion item from Fontello icons set", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
			  'js_view' => 'VcTrxAccordionTabView'
			) );

			class WPBakeryShortCode_Trx_Accordion extends THEMEREX_VC_ShortCodeAccordion {}
			class WPBakeryShortCode_Trx_Accordion_Item extends THEMEREX_VC_ShortCodeAccordionItem {}
			
			
			
			
			
			
			// Anchor
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_anchor",
				"name" => __("Anchor", "trx_addons"),
				"description" => __("Insert anchor for the TOC (table of content)", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_anchor',
				"class" => "trx_sc_single trx_sc_anchor",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "icon",
						"heading" => __("Anchor's icon", "trx_addons"),
						"description" => __("Select icon for the anchor from Fontello icons set", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => __("Short title", "trx_addons"),
						"description" => __("Short title of the anchor (for the table of content)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => __("Long description", "trx_addons"),
						"description" => __("Description for the popup (then hover on the icon). You can use '{' and '}' - make the text italic, '|' - insert line break", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "url",
						"heading" => __("External URL", "trx_addons"),
						"description" => __("External URL for this TOC item", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "separator",
						"heading" => __("Add separator", "trx_addons"),
						"description" => __("Add separator under item in the TOC", "trx_addons"),
						"class" => "",
						"value" => array("Add separator" => "yes" ),
						"type" => "checkbox"
					),
					$THEMEREX_GLOBALS['vc_params']['id']
				),
			) );
			
			class WPBakeryShortCode_Trx_Anchor extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			// Audio
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_audio",
				"name" => __("Audio", "trx_addons"),
				"description" => __("Insert audio player", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_audio',
				"class" => "trx_sc_single trx_sc_audio",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "url",
						"heading" => __("URL for audio file", "trx_addons"),
						"description" => __("Put here URL for audio file", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "image",
						"heading" => __("Cover image", "trx_addons"),
						"description" => __("Select or upload image or write URL from other site for audio cover", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Title of the audio file", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "author",
						"heading" => __("Author", "trx_addons"),
						"description" => __("Author of the audio file", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "controls",
						"heading" => __("Controls", "trx_addons"),
						"description" => __("Show/hide controls", "trx_addons"),
						"class" => "",
						"value" => array("Hide controls" => "hide" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "autoplay",
						"heading" => __("Autoplay", "trx_addons"),
						"description" => __("Autoplay audio on page load", "trx_addons"),
						"class" => "",
						"value" => array("Autoplay" => "on" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Select block alignment", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
			) );
			
			class WPBakeryShortCode_Trx_Audio extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Block
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_block",
				"name" => __("Block container", "trx_addons"),
				"description" => __("Container for any block ([section] analog - to enable nesting)", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_block',
				"class" => "trx_sc_collection trx_sc_block",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "dedicated",
						"heading" => __("Dedicated", "trx_addons"),
						"description" => __("Use this block as dedicated content - show it before post title on single page", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(__('Use as dedicated content', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Select block alignment", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => __("Columns emulation", "trx_addons"),
						"description" => __("Select width for columns emulation", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['columns']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "pan",
						"heading" => __("Use pan effect", "trx_addons"),
						"description" => __("Use pan effect to show section content", "trx_addons"),
						"group" => __('Scroll', 'trx_addons'),
						"class" => "",
						"value" => array(__('Content scroller', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "scroll",
						"heading" => __("Use scroller", "trx_addons"),
						"description" => __("Use scroller to show section content", "trx_addons"),
						"group" => __('Scroll', 'trx_addons'),
						"admin_label" => true,
						"class" => "",
						"value" => array(__('Content scroller', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "scroll_dir",
						"heading" => __("Scroll direction", "trx_addons"),
						"description" => __("Scroll direction (if Use scroller = yes)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"group" => __('Scroll', 'trx_addons'),
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['dir']),
						'dependency' => array(
							'element' => 'scroll',
							'not_empty' => true
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scroll_controls",
						"heading" => __("Scroll controls", "trx_addons"),
						"description" => __("Show scroll controls (if Use scroller = yes)", "trx_addons"),
						"class" => "",
						"group" => __('Scroll', 'trx_addons'),
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['dir']),
						'dependency' => array(
							'element' => 'scroll',
							'not_empty' => true
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => __("Fore color", "trx_addons"),
						"description" => __("Any color for objects in this section", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_tint",
						"heading" => __("Background tint", "trx_addons"),
						"description" => __("Main background tint: dark or light", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['tint']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_color",
						"heading" => __("Background color", "trx_addons"),
						"description" => __("Any background color for this section", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => __("Background image URL", "trx_addons"),
						"description" => __("Select background image from library for this section", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_overlay",
						"heading" => __("Overlay", "trx_addons"),
						"description" => __("Overlay color opacity (from 0.0 to 1.0)", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_texture",
						"heading" => __("Texture", "trx_addons"),
						"description" => __("Texture style from 1 to 11. Empty or 0 - without texture.", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_size",
						"heading" => __("Font size", "trx_addons"),
						"description" => __("Font size of the text (default - in pixels, allows any CSS units of measure)", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_weight",
						"heading" => __("Font weight", "trx_addons"),
						"description" => __("Font weight of the text", "trx_addons"),
						"class" => "",
						"value" => array(
							__('Default', 'trx_addons') => 'inherit',
							__('Thin (100)', 'trx_addons') => '100',
							__('Light (300)', 'trx_addons') => '300',
							__('Normal (400)', 'trx_addons') => '400',
							__('Bold (700)', 'trx_addons') => '700'
						),
						"type" => "dropdown"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => __("Container content", "trx_addons"),
						"description" => __("Content for section container", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Block extends THEMEREX_VC_ShortCodeCollection {}
			
			
			
			
			
			
			// Blogger
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_blogger",
				"name" => __("Blogger", "trx_addons"),
				"description" => __("Insert posts (pages) in many styles from desired categories or directly from ids", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_blogger',
				"class" => "trx_sc_single trx_sc_blogger",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => __("Output style", "trx_addons"),
						"description" => __("Select desired style for posts output", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['blogger_styles']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "filters",
						"heading" => __("Show filters", "trx_addons"),
						"description" => __("Use post's tags or categories as filter buttons", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['filters']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "location",
						"heading" => __("Dedicated content location", "trx_addons"),
						"description" => __("Select position for dedicated content (only for style=excerpt)", "trx_addons"),
						"class" => "",
						'dependency' => array(
							'element' => 'style',
							'value' => array('excerpt')
						),
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['locations']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "dir",
						"heading" => __("Posts direction", "trx_addons"),
						"description" => __("Display posts in horizontal or vertical direction", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['dir']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "rating",
						"heading" => __("Show rating stars", "trx_addons"),
						"description" => __("Show rating stars under post's header", "trx_addons"),
						"group" => __('Details', 'trx_addons'),
						"class" => "",
						"value" => array(__('Show rating', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "info",
						"heading" => __("Do not show post info block", "trx_addons"),
						"description" => __("Do not show post info block (author, date, tags, etc.)", "trx_addons"),
						"class" => "",
						"value" => array(__('Show info', 'trx_addons') => 'no'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "descr",
						"heading" => __("Description length", "trx_addons"),
						"description" => __("How many characters are displayed from post excerpt? If 0 - don't show description", "trx_addons"),
						"group" => __('Details', 'trx_addons'),
						"class" => "",
						"value" => 0,
						"type" => "textfield"
					),
					array(
						"param_name" => "links",
						"heading" => __("Allow links to the post", "trx_addons"),
						"description" => __("Allow links to the post from each blogger item", "trx_addons"),
						"group" => __('Details', 'trx_addons'),
						"class" => "",
						"value" => array(__('Allow links', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "readmore",
						"heading" => __("More link text", "trx_addons"),
						"description" => __("Read more link text. If empty - show 'More', else - used as link text", "trx_addons"),
						"group" => __('Details', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "post_type",
						"heading" => __("Post type", "trx_addons"),
						"description" => __("Select post type to show", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['posts_types']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => __("Post IDs list", "trx_addons"),
						"description" => __("Comma separated list of posts ID. If set - parameters above are ignored!", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "cat",
						"heading" => __("Categories list", "trx_addons"),
						"description" => __("Put here comma separated category slugs or ids. If empty - show posts from any category or from IDs list", "trx_addons"),
						'dependency' => array(
							'element' => 'ids',
							'is_empty' => true
						),
						"group" => __('Query', 'trx_addons'),
						"class" => "",
						"value" => array_flip(themerex_array_merge(array(0 => __('- Select category -', 'trx_addons')), $THEMEREX_GLOBALS['sc_params']['categories'])),
						"type" => "dropdown"
					),
					array(
						"param_name" => "count",
						"heading" => __("Total posts to show", "trx_addons"),
						"description" => __("How many posts will be displayed? If used IDs - this parameter ignored.", "trx_addons"),
						'dependency' => array(
							'element' => 'ids',
							'is_empty' => true
						),
						"admin_label" => true,
						"group" => __('Query', 'trx_addons'),
						"class" => "",
						"value" => 3,
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => __("Columns number", "trx_addons"),
						"description" => __("How many columns used to display posts?", "trx_addons"),
						'dependency' => array(
							'element' => 'dir',
							'value' => 'horizontal'
						),
						"group" => __('Query', 'trx_addons'),
						"class" => "",
						"value" => 3,
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => __("Offset before select posts", "trx_addons"),
						"description" => __("Skip posts before select next part.", "trx_addons"),
						'dependency' => array(
							'element' => 'ids',
							'is_empty' => true
						),
						"group" => __('Query', 'trx_addons'),
						"class" => "",
						"value" => 0,
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => __("Post order by", "trx_addons"),
						"description" => __("Select desired posts sorting method", "trx_addons"),
						"class" => "",
						"group" => __('Query', 'trx_addons'),
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['sorting']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => __("Post order", "trx_addons"),
						"description" => __("Select desired posts order", "trx_addons"),
						"class" => "",
						"group" => __('Query', 'trx_addons'),
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "only",
						"heading" => __("Select posts only", "trx_addons"),
						"description" => __("Select posts only with reviews, videos, audios, thumbs or galleries", "trx_addons"),
						"class" => "",
						"group" => __('Query', 'trx_addons'),
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['formats']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scroll",
						"heading" => __("Use scroller", "trx_addons"),
						"description" => __("Use scroller to show all posts", "trx_addons"),
						"group" => __('Scroll', 'trx_addons'),
						"class" => "",
						"value" => array(__('Use scroller', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "controls",
						"heading" => __("Show slider controls", "trx_addons"),
						"description" => __("Show arrows to control scroll slider", "trx_addons"),
						"group" => __('Scroll', 'trx_addons'),
						"class" => "",
						"value" => array(__('Show controls', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
			) );
			
			class WPBakeryShortCode_Trx_Blogger extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			// Br
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_br",
				"name" => __("Line break", "trx_addons"),
				"description" => __("Line break or Clear Floating", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_br',
				"class" => "trx_sc_single trx_sc_br",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "clear",
						"heading" => __("Clear floating", "trx_addons"),
						"description" => __("Select clear side (if need)", "trx_addons"),
						"class" => "",
						"value" => "",
						"value" => array(
							__('None', 'trx_addons') => 'none',
							__('Left', 'trx_addons') => 'left',
							__('Right', 'trx_addons') => 'right',
							__('Both', 'trx_addons') => 'both'
						),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Trx_Br extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Button
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_button",
				"name" => __("Button", "trx_addons"),
				"description" => __("Button with link", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_button',
				"class" => "trx_sc_single trx_sc_button",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "content",
						"heading" => __("Caption", "trx_addons"),
						"description" => __("Button caption", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "type",
						"heading" => __("Button's shape", "trx_addons"),
						"description" => __("Select button's shape", "trx_addons"),
						"class" => "",
						"admin_label" => true,
						"value" => array(
							__('Square', 'trx_addons') => 'square',
							__('Round', 'trx_addons') => 'round'
						),
						"type" => "dropdown"
					),
					/*
					array(
						"param_name" => "style",
						"heading" => __("Button's style", "trx_addons"),
						"description" => __("Select button's style", "trx_addons"),
						"class" => "",
						"value" => array(
							__('Filled', 'trx_addons') => 'filled',
							__('Simple', 'trx_addons') => 'border'
						),
						"type" => "dropdown"
					),

					array(
						"param_name" => "size",
						"heading" => __("Button's size", "trx_addons"),
						"description" => __("Select button's size", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Small', 'trx_addons') => 'mini',
							__('Medium', 'trx_addons') => 'medium',
							__('Large', 'trx_addons') => 'big'
						),
						"type" => "dropdown"
					),
					*/
					array(
						"param_name" => "icon",
						"heading" => __("Button's icon", "trx_addons"),
						"description" => __("Select icon for the title from Fontello icons set", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_style",
						"heading" => __("Button's color scheme", "trx_addons"),
						"description" => __("Select button's color scheme", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['button_styles']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => __("Button's text color", "trx_addons"),
						"description" => __("Any color for button's caption", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => __("Button's backcolor", "trx_addons"),
						"description" => __("Any color for button's background", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "align",
						"heading" => __("Button's alignment", "trx_addons"),
						"description" => __("Align button to left, center or right", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "link",
						"heading" => __("Link URL", "trx_addons"),
						"description" => __("URL for the link on button click", "trx_addons"),
						"class" => "",
						"group" => __('Link', 'trx_addons'),
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "target",
						"heading" => __("Link target", "trx_addons"),
						"description" => __("Target for the link on button click", "trx_addons"),
						"class" => "",
						"group" => __('Link', 'trx_addons'),
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "popup",
						"heading" => __("Open link in popup", "trx_addons"),
						"description" => __("Open link target in popup window", "trx_addons"),
						"class" => "",
						"group" => __('Link', 'trx_addons'),
						"value" => array(__('Open in popup', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "rel",
						"heading" => __("Rel attribute", "trx_addons"),
						"description" => __("Rel attribute for the button's link (if need", "trx_addons"),
						"class" => "",
						"group" => __('Link', 'trx_addons'),
						"value" => "",
						"type" => "textfield"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
			) );
			
			class WPBakeryShortCode_Trx_Button extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Chat
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_chat",
				"name" => __("Chat", "trx_addons"),
				"description" => __("Chat message", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_chat',
				"class" => "trx_sc_container trx_sc_chat",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => __("Item title", "trx_addons"),
						"description" => __("Title for current chat item", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "photo",
						"heading" => __("Item photo", "trx_addons"),
						"description" => __("Select or upload image or write URL from other site for the item photo (avatar)", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "link",
						"heading" => __("Link URL", "trx_addons"),
						"description" => __("URL for the link on chat title click", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => __("Chat item content", "trx_addons"),
						"description" => __("Current chat item content", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextContainerView'
			
			) );
			
			class WPBakeryShortCode_Trx_Chat extends THEMEREX_VC_ShortCodeContainer {}
			
			
			
			
			
			
			// Columns
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_columns",
				"name" => __("Columns", "trx_addons"),
				"description" => __("Insert columns with margins", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_columns',
				"class" => "trx_sc_columns",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"as_parent" => array('only' => 'trx_column_item'),
				"params" => array(
					array(
						"param_name" => "count",
						"heading" => __("Columns count", "trx_addons"),
						"description" => __("Number of the columns in the container.", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "2",
						"type" => "textfield"
					),
					array(
						"param_name" => "fluid",
						"heading" => __("Fluid columns", "trx_addons"),
						"description" => __("To squeeze the columns when reducing the size of the window (fluid=yes) or to rebuild them (fluid=no)", "trx_addons"),
						"class" => "",
						"value" => array(__('Fluid columns', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "autoheight",
						"heading" => __("Auto Height", "trx_addons"),
						"description" => __("Fit height to the larger value of child elements (for background images)", "trx_addons"),
						"class" => "",
						"value" => array(__('Auto Height', 'trx_addons') => 'yes'),
						"type" => "checkbox",
					),
					array(
						"param_name" => "indentation",
						"heading" => __("Indentation", "trx_addons"),
						"description" => __("Column is indented", "trx_addons"),
						"class" => "",
						"value" => array(__('Indentation', 'trx_addons') => 'yes'),
						"type" => "checkbox",
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'default_content' => '
					[trx_column_item][/trx_column_item]
					[trx_column_item][/trx_column_item]
				',
				'js_view' => 'VcTrxColumnsView'
			) );
			
			
			vc_map( array(
				"base" => "trx_column_item",
				"name" => __("Column", "trx_addons"),
				"description" => __("Column item", "trx_addons"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_collection trx_sc_column_item",
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_column_item',
				"as_child" => array('only' => 'trx_columns'),
				"as_parent" => array('except' => 'trx_columns'),
				"params" => array(
					array(
						"param_name" => "span",
						"heading" => __("Merge columns", "trx_addons"),
						"description" => __("Count merged columns from current", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Alignment text in the column", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => __("Fore color", "trx_addons"),
						"description" => __("Any color for objects in this column", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => __("Background color", "trx_addons"),
						"description" => __("Any background color for this column", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => __("URL for background image file", "trx_addons"),
						"description" => __("Select or upload image or write URL from other site for the background", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => __("Column's content", "trx_addons"),
						"description" => __("Content of the current column", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxColumnItemView'
			) );
			
			class WPBakeryShortCode_Trx_Columns extends THEMEREX_VC_ShortCodeColumns {}
			class WPBakeryShortCode_Trx_Column_Item extends THEMEREX_VC_ShortCodeCollection {}
			
			
			
			
			
			
			
			// Contact form
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_contact_form",
				"name" => __("Contact form", "trx_addons"),
				"description" => __("Insert contact form", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_contact_form',
				"class" => "trx_sc_collection trx_sc_contact_form",
				"content_element" => true,
				"is_container" => true,
				"as_parent" => array('only' => 'trx_form_item'),
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "custom",
						"heading" => __("Custom", "trx_addons"),
						"description" => __("Use custom fields or create standard contact form (ignore info from 'Field' tabs)", "trx_addons"),
						"class" => "",
						"value" => array(__('Create custom form', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "action",
						"heading" => __("Action", "trx_addons"),
						"description" => __("Contact form action (URL to handle form data). If empty - use internal action", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Select form alignment", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Title for the block", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => __("Subtitle", "trx_addons"),
						"description" => __("Subtitle for the block", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => __("Description (under the title)", "trx_addons"),
						"description" => __("Contact form description", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "style",
						"heading" => __("Style", "trx_addons"),
						"description" => __("Contact form style", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Standard (light)', 'trx_addons') => 'standard_light',
							__('Standard (dark)', 'trx_addons') => 'standard',
							__('Topic', 'trx_addons') => 'topic'
						),
						"type" => "dropdown"
					),
					themerex_vc_width(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			
			vc_map( array(
				"base" => "trx_form_item",
				"name" => __("Form item (custom field)", "trx_addons"),
				"description" => __("Custom field for the contact form", "trx_addons"),
				"class" => "trx_sc_item trx_sc_form_item",
				'icon' => 'icon_trx_form_item',
				"allowed_container_element" => 'vc_row',
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => false,
				"as_child" => array('only' => 'trx_contact_form'), // Use only|except attributes to limit parent (separate multiple values with comma)
				"params" => array(
					array(
						"param_name" => "type",
						"heading" => __("Type", "trx_addons"),
						"description" => __("Select type of the custom field", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['field_types']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "name",
						"heading" => __("Name", "trx_addons"),
						"description" => __("Name of the custom field", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "value",
						"heading" => __("Default value", "trx_addons"),
						"description" => __("Default value of the custom field", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "label",
						"heading" => __("Label", "trx_addons"),
						"description" => __("Label for the custom field", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "label_position",
						"heading" => __("Label position", "trx_addons"),
						"description" => __("Label position relative to the field", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['label_positions']),
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Contact_Form extends THEMEREX_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_Form_Item extends THEMEREX_VC_ShortCodeItem {}
			
			
			
			
			
			
			
			// Content block on fullscreen page
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_content",
				"name" => __("Content block", "trx_addons"),
				"description" => __("Container for main content block (use it only on fullscreen pages)", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_content',
				"class" => "trx_sc_collection trx_sc_content",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "font_size",
						"heading" => __("Font size", "trx_addons"),
						"description" => __("Font size of the text (default - in pixels, allows any CSS units of measure)", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_weight",
						"heading" => __("Font weight", "trx_addons"),
						"description" => __("Font weight of the text", "trx_addons"),
						"class" => "",
						"value" => array(
							__('Default', 'trx_addons') => 'inherit',
							__('Thin (100)', 'trx_addons') => '100',
							__('Light (300)', 'trx_addons') => '300',
							__('Normal (400)', 'trx_addons') => '400',
							__('Bold (700)', 'trx_addons') => '700'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Container title", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "color",
						"heading" => __("Color", "trx_addons"),
						"description" => __("Title color", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => __("Container content", "trx_addons"),
						"description" => __("Content for section container", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Content extends THEMEREX_VC_ShortCodeCollection {}
			
			
			
			
			
			
			
			// Countdown
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_countdown",
				"name" => __("Countdown", "trx_addons"),
				"description" => __("Insert countdown object", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_countdown',
				"class" => "trx_sc_single trx_sc_countdown",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "date",
						"heading" => __("Date", "trx_addons"),
						"description" => __("Upcoming date (format: yyyy-mm-dd)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "time",
						"heading" => __("Time", "trx_addons"),
						"description" => __("Upcoming time (format: HH:mm:ss)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "style",
						"heading" => __("Style", "trx_addons"),
						"description" => __("Countdown style", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Style 1', 'trx_addons') => 1,
							__('Style 2', 'trx_addons') => 2
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Align counter to left, center or right", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Countdown extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Dropcaps
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_dropcaps",
				"name" => __("Dropcaps", "trx_addons"),
				"description" => __("Make first letter of the text as dropcaps", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_dropcaps',
				"class" => "trx_sc_single trx_sc_dropcaps",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => __("Style", "trx_addons"),
						"description" => __("Dropcaps style", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Style 1', 'trx_addons') => 1,
							__('Style 2', 'trx_addons') => 2,
							__('Style 3', 'trx_addons') => 3,
							__('Style 4', 'trx_addons') => 4
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "content",
						"heading" => __("Paragraph text", "trx_addons"),
						"description" => __("Paragraph with dropcaps content", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
			
			) );
			
			class WPBakeryShortCode_Trx_Dropcaps extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Emailer
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_emailer",
				"name" => __("E-mail collector", "trx_addons"),
				"description" => __("Collect e-mails into specified group", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_emailer',
				"class" => "trx_sc_single trx_sc_emailer",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "group",
						"heading" => __("Group", "trx_addons"),
						"description" => __("The name of group to collect e-mail address", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "open",
						"heading" => __("Opened", "trx_addons"),
						"description" => __("Initially open the input field on show object", "trx_addons"),
						"class" => "",
						"value" => array(__('Initially opened', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Align field to left, center or right", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Emailer extends THEMEREX_VC_ShortCodeSingle {}





			// Gallery
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "trx_gallery",
				"name" => __("Gallery", "trx_addons"),
				"description" => __("Insert gallery", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_slider',
				"class" => "trx_sc_single trx_sc_gallery",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
						array(
							"param_name" => "cat",
							"heading" => __("Categories list", "trx_addons"),
							"description" => __("Select category. If empty - show posts from any category or from IDs list", "trx_addons"),
							"class" => "",
							"value" => array_flip(themerex_array_merge(array(0 => __('- Select category -', 'trx_addons')), $THEMEREX_GLOBALS['sc_params']['categories'])),
							"type" => "dropdown",
							"admin_label" => true
						),
						array(
							"param_name" => "count",
							"heading" => __("Number of posts", "trx_addons"),
							"description" => __("How many posts will be displayed? If used IDs - this parameter ignored.", "trx_addons"),
							"class" => "",
							"value" => "10",
							"type" => "textfield",
							"admin_label" => true
						),
						array(
							"param_name" => "offset",
							"heading" => __("Offset before select posts", "trx_addons"),
							"description" => __("Skip posts before select next part.", "trx_addons"),
							"class" => "",
							"value" => "0",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => __("Post sorting", "trx_addons"),
							"description" => __("Select desired posts sorting method", "trx_addons"),
							"class" => "",
							"value" => array_flip($THEMEREX_GLOBALS['sc_params']['sorting']),
							"type" => "dropdown",
							"admin_label" => true
						),
						array(
							"param_name" => "order",
							"heading" => __("Post order", "trx_addons"),
							"description" => __("Select desired posts order", "trx_addons"),
							"class" => "",
							"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						),
						array(
							"param_name" => "ids",
							"heading" => __("Post IDs list", "trx_addons"),
							"description" => __("Comma separated list of posts ID. If set - parameters above are ignored!", "trx_addons"),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "descriptions",
							"heading" => __("Post descriptions", "trx_addons"),
							"description" => __("Show post's excerpt max length (characters)", "trx_addons"),
							"group" => __('Details', 'trx_addons'),
							"class" => "",
							"value" => "100",
							"type" => "textfield"
						),
						array(
							"param_name" => "bg_color",
							"heading" => __("Backgroud color", "trx_addons"),
							"description" => __("Select color for Gallery background", "trx_addons"),
							"class" => "",
							"value" => "",
							"type" => "colorpicker",
							"admin_label" => true
						),
						array(
							"param_name" => "bg_image",
							"heading" => __("Background image", "trx_addons"),
							"description" => __("Select or upload image or write URL from other site for the Gallery background", "trx_addons"),
							"class" => "",
							"value" => "",
							"type" => "attach_image",
							"admin_label" => true
						),
						themerex_vc_height(),
						$THEMEREX_GLOBALS['vc_params']['margin_top'],
						$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
						$THEMEREX_GLOBALS['vc_params']['id'],
						$THEMEREX_GLOBALS['vc_params']['class'],
						$THEMEREX_GLOBALS['vc_params']['animation']
					)
			) );

			class WPBakeryShortCode_Trx_Gallery extends THEMEREX_VC_ShortCodeSingle {}



			
			
			// Gap
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_gap",
				"name" => __("Gap", "trx_addons"),
				"description" => __("Insert gap (fullwidth area) in the post content", "trx_addons"),
				"category" => __('Structure', 'trx_addons'),
				'icon' => 'icon_trx_gap',
				"class" => "trx_sc_collection trx_sc_gap",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"params" => array(
					/*
					array(
						"param_name" => "content",
						"heading" => __("Gap content", "trx_addons"),
						"description" => __("Gap inner content", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					)
					*/
				)
			) );
			
			class WPBakeryShortCode_Trx_Gap extends THEMEREX_VC_ShortCodeCollection {}
			
			
			
			
			
			
			
			// Googlemap
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "trx_googlemap",
				"name" => __("Google map", "trx_addons"),
				"description" => __("Insert Google map with desired address or coordinates", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_googlemap',
				"class" => "trx_sc_collection trx_sc_googlemap",
				"content_element" => true,
				"is_container" => true,
				"as_parent" => array('only' => 'trx_googlemap_marker'),
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "zoom",
						"heading" => __("Zoom", "trx_addons"),
						"description" => __("Map zoom factor", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "16",
						"type" => "textfield"
					),
					array(
						"param_name" => "style",
						"heading" => __("Style", "trx_addons"),
						"description" => __("Map custom style", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['googlemap_styles']),
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css'],
					themerex_vc_width('100%'),
					themerex_vc_height(240),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right']
				)
			) );

			vc_map( array(
				"base" => "trx_googlemap_marker",
				"name" => __("Googlemap marker", "trx_addons"),
				"description" => __("Insert new marker into Google map", "trx_addons"),
				"class" => "trx_sc_collection trx_sc_googlemap_marker",
				'icon' => 'icon_trx_googlemap_marker',
				//"allowed_container_element" => 'vc_row',
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => true,
				"as_child" => array('only' => 'trx_googlemap'), // Use only|except attributes to limit parent (separate multiple values with comma)
				"params" => array(
					array(
						"param_name" => "address",
						"heading" => __("Address", "trx_addons"),
						"description" => __("Address of this marker", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "latlng",
						"heading" => __("Latitude and Longtitude", "trx_addons"),
						"description" => __("Comma separated marker's coorditanes (instead Address)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Title for this marker", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "point",
						"heading" => __("URL for marker image file", "trx_addons"),
						"description" => __("Select or upload image or write URL from other site for this marker. If empty - use default marker", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					$THEMEREX_GLOBALS['vc_params']['id']
				)
			) );

			class WPBakeryShortCode_Trx_Googlemap extends THEMEREX_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_Googlemap_Marker extends THEMEREX_VC_ShortCodeCollection {}
			
			
			
			
			
			
			// Highlight
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_highlight",
				"name" => __("Highlight text", "trx_addons"),
				"description" => __("Highlight text with selected color, background color and other styles", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_highlight',
				"class" => "trx_sc_single trx_sc_highlight",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "type",
						"heading" => __("Type", "trx_addons"),
						"description" => __("Highlight type", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
								__('Custom', 'trx_addons') => 0,
								__('Type 1', 'trx_addons') => 1,
								__('Type 2', 'trx_addons') => 2,
								__('Type 3', 'trx_addons') => 3
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => __("Text color", "trx_addons"),
						"description" => __("Color for the highlighted text", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => __("Background color", "trx_addons"),
						"description" => __("Background color for the highlighted text", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "font_size",
						"heading" => __("Font size", "trx_addons"),
						"description" => __("Font size for the highlighted text (default - in pixels, allows any CSS units of measure)", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "content",
						"heading" => __("Highlight text", "trx_addons"),
						"description" => __("Content for highlight", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
			) );
			
			class WPBakeryShortCode_Trx_Highlight extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			// Icon
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_icon",
				"name" => __("Icon", "trx_addons"),
				"description" => __("Insert the icon", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_icon',
				"class" => "trx_sc_single trx_sc_icon",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "icon",
						"heading" => __("Icon", "trx_addons"),
						"description" => __("Select icon class from Fontello icons set", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => __("Text color", "trx_addons"),
						"description" => __("Icon's color", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_shape",
						"heading" => __("Background shape", "trx_addons"),
						"description" => __("Shape of the icon background", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('None', 'trx_addons') => 'none',
							__('Round', 'trx_addons') => 'round',
							__('Square', 'trx_addons') => 'square'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "font_size",
						"heading" => __("Font size", "trx_addons"),
						"description" => __("Icon's font size", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_weight",
						"heading" => __("Font weight", "trx_addons"),
						"description" => __("Icon's font weight", "trx_addons"),
						"class" => "",
						"value" => array(
							__('Default', 'trx_addons') => 'inherit',
							__('Thin (100)', 'trx_addons') => '100',
							__('Light (300)', 'trx_addons') => '300',
							__('Normal (400)', 'trx_addons') => '400',
							__('Bold (700)', 'trx_addons') => '700'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "align",
						"heading" => __("Icon's alignment", "trx_addons"),
						"description" => __("Align icon to left, center or right", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => __("Icon title", "trx_addons"),
						"description" => __("Icon title (for large size)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => __("Link URL", "trx_addons"),
						"description" => __("Link URL from this icon (if not empty)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
			) );
			
			class WPBakeryShortCode_Trx_Icon extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Image
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_image",
				"name" => __("Image", "trx_addons"),
				"description" => __("Insert image", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_image',
				"class" => "trx_sc_single trx_sc_image",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "url",
						"heading" => __("Select image", "trx_addons"),
						"description" => __("Select image from library", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "align",
						"heading" => __("Image alignment", "trx_addons"),
						"description" => __("Align image to left or right side", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "shape",
						"heading" => __("Image shape", "trx_addons"),
						"description" => __("Shape of the image: square or round", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Square', 'trx_addons') => 'square',
							__('Round', 'trx_addons') => 'round'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Image's title", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "icon",
						"heading" => __("Title's icon", "trx_addons"),
						"description" => __("Select icon for the title from Fontello icons set", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "link",
						"heading" => __("Link URL", "trx_addons"),
						"description" => __("Link URL from title", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Image extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Infobox
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_infobox",
				"name" => __("Infobox", "trx_addons"),
				"description" => __("Box with info or error message", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_infobox',
				"class" => "trx_sc_container trx_sc_infobox",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => __("Style", "trx_addons"),
						"description" => __("Infobox style", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
								__('Regular', 'trx_addons') => 'regular',
								__('Info', 'trx_addons') => 'info',
								__('Success', 'trx_addons') => 'success',
								__('Error', 'trx_addons') => 'error',
								__('Result', 'trx_addons') => 'result'
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "closeable",
						"heading" => __("Closeable", "trx_addons"),
						"description" => __("Create closeable box (with close button)", "trx_addons"),
						"class" => "",
						"value" => array(__('Close button', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "icon",
						"heading" => __("Custom icon", "trx_addons"),
						"description" => __("Select icon for the infobox from Fontello icons set. If empty - use default icon", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => __("Text color", "trx_addons"),
						"description" => __("Any color for the text and headers", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => __("Background color", "trx_addons"),
						"description" => __("Any background color for this infobox", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => __("Message text", "trx_addons"),
						"description" => __("Message for the infobox", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextContainerView'
			) );
			
			class WPBakeryShortCode_Trx_Infobox extends THEMEREX_VC_ShortCodeContainer {}
			
			
			
			
			
			
			
			// Line
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_line",
				"name" => __("Line", "trx_addons"),
				"description" => __("Insert line (delimiter)", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				"class" => "trx_sc_single trx_sc_line",
				'icon' => 'icon_trx_line',
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => __("Style", "trx_addons"),
						"description" => __("Line style", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
								__('Solid', 'trx_addons') => 'solid',
								__('Dashed', 'trx_addons') => 'dashed',
								__('Dotted', 'trx_addons') => 'dotted',
								__('Double', 'trx_addons') => 'double',
								__('Styling', 'trx_addons') => 'styling'
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => __("Line color", "trx_addons"),
						"description" => __("Line color", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Line extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// List
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_list",
				"name" => __("List", "trx_addons"),
				"description" => __("List items with specific bullets", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				"class" => "trx_sc_collection trx_sc_list",
				'icon' => 'icon_trx_list',
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"as_parent" => array('only' => 'trx_list_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => __("Bullet's style", "trx_addons"),
						"description" => __("Bullet's style for each list item", "trx_addons"),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['list_styles']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => __("Color", "trx_addons"),
						"description" => __("List items color", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "icon",
						"heading" => __("List icon", "trx_addons"),
						"description" => __("Select list icon from Fontello icons set (only for style=Iconed)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						'dependency' => array(
							'element' => 'style',
							'value' => array('iconed')
						),
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_color",
						"heading" => __("Icon color", "trx_addons"),
						"description" => __("List icons color", "trx_addons"),
						"class" => "",
						'dependency' => array(
							'element' => 'style',
							'value' => array('iconed')
						),
						"value" => "",
						"type" => "colorpicker"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'default_content' => '
					[trx_list_item]' . __( 'Item 1', 'trx_addons' ) . '[/trx_list_item]
					[trx_list_item]' . __( 'Item 2', 'trx_addons' ) . '[/trx_list_item]
				'
			) );
			
			
			vc_map( array(
				"base" => "trx_list_item",
				"name" => __("List item", "trx_addons"),
				"description" => __("List item with specific bullet", "trx_addons"),
				"class" => "trx_sc_single trx_sc_list_item",
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_list_item',
				"as_child" => array('only' => 'trx_list'), // Use only|except attributes to limit parent (separate multiple values with comma)
				"as_parent" => array('except' => 'trx_list'),
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => __("List item title", "trx_addons"),
						"description" => __("Title for the current list item (show it as tooltip)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => __("Link URL", "trx_addons"),
						"description" => __("Link URL for the current list item", "trx_addons"),
						"admin_label" => true,
						"group" => __('Link', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "target",
						"heading" => __("Link target", "trx_addons"),
						"description" => __("Link target for the current list item", "trx_addons"),
						"admin_label" => true,
						"group" => __('Link', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "color",
						"heading" => __("Color", "trx_addons"),
						"description" => __("Text color for this item", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "icon",
						"heading" => __("List item icon", "trx_addons"),
						"description" => __("Select list item icon from Fontello icons set (only for style=Iconed)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_color",
						"heading" => __("Icon color", "trx_addons"),
						"description" => __("Icon color for this item", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "content",
						"heading" => __("List item text", "trx_addons"),
						"description" => __("Current list item content", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
			
			) );
			
			class WPBakeryShortCode_Trx_List extends THEMEREX_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_List_Item extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			
			
			// Number
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_number",
				"name" => __("Number", "trx_addons"),
				"description" => __("Insert number or any word as set of separated characters", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				"class" => "trx_sc_single trx_sc_number",
				'icon' => 'icon_trx_number',
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "value",
						"heading" => __("Value", "trx_addons"),
						"description" => __("Number or any word to separate", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Select block alignment", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Number extends THEMEREX_VC_ShortCodeSingle {}


			
			
			
			
			
			// Parallax
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_parallax",
				"name" => __("Parallax", "trx_addons"),
				"description" => __("Create the parallax container (with asinc background image)", "trx_addons"),
				"category" => __('Structure', 'trx_addons'),
				'icon' => 'icon_trx_parallax',
				"class" => "trx_sc_collection trx_sc_parallax",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "gap",
						"heading" => __("Create gap", "trx_addons"),
						"description" => __("Create gap around parallax container (not need in fullscreen pages)", "trx_addons"),
						"class" => "",
						"value" => array(__('Create gap', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "dir",
						"heading" => __("Direction", "trx_addons"),
						"description" => __("Scroll direction for the parallax background", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
								__('Up', 'trx_addons') => 'up',
								__('Down', 'trx_addons') => 'down'
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "speed",
						"heading" => __("Speed", "trx_addons"),
						"description" => __("Parallax background motion speed (from 0.0 to 1.0)", "trx_addons"),
						"class" => "",
						"value" => "0.3",
						"type" => "textfield"
					),
					array(
						"param_name" => "color",
						"heading" => __("Text color", "trx_addons"),
						"description" => __("Select color for text object inside parallax block", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_tint",
						"heading" => __("Bg tint", "trx_addons"),
						"description" => __("Select tint of the parallax background (for correct font color choise)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
								__('Light', 'trx_addons') => 'light',
								__('Dark', 'trx_addons') => 'dark'
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_color",
						"heading" => __("Backgroud color", "trx_addons"),
						"description" => __("Select color for parallax background", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => __("Background image", "trx_addons"),
						"description" => __("Select or upload image or write URL from other site for the parallax background", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_image_x",
						"heading" => __("Image X position", "trx_addons"),
						"description" => __("Parallax background X position (in percents)", "trx_addons"),
						"class" => "",
						"value" => "50%",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_video",
						"heading" => __("Video background", "trx_addons"),
						"description" => __("Paste URL for video file to show it as parallax background", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_video_ratio",
						"heading" => __("Video ratio", "trx_addons"),
						"description" => __("Specify ratio of the video background. For example: 16:9 (default), 4:3, etc.", "trx_addons"),
						"class" => "",
						"value" => "16:9",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_overlay",
						"heading" => __("Overlay", "trx_addons"),
						"description" => __("Overlay color opacity (from 0.0 to 1.0)", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_texture",
						"heading" => __("Texture", "trx_addons"),
						"description" => __("Texture style from 1 to 11. Empty or 0 - without texture.", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => __("Content", "trx_addons"),
						"description" => __("Content for the parallax container", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Parallax extends THEMEREX_VC_ShortCodeCollection {}
			
			
			
			
			
			
			// Popup
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_popup",
				"name" => __("Popup window", "trx_addons"),
				"description" => __("Container for any html-block with desired class and style for popup window", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_popup',
				"class" => "trx_sc_collection trx_sc_popup",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					/*
					array(
						"param_name" => "content",
						"heading" => __("Container content", "trx_addons"),
						"description" => __("Content for popup container", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Popup extends THEMEREX_VC_ShortCodeCollection {}
			
			
			
			
			
			
			
			// Price
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_price",
				"name" => __("Price", "trx_addons"),
				"description" => __("Insert price with decoration", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_price',
				"class" => "trx_sc_single trx_sc_price",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "money",
						"heading" => __("Money", "trx_addons"),
						"description" => __("Money value (dot or comma separated)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "currency",
						"heading" => __("Currency symbol", "trx_addons"),
						"description" => __("Currency character", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "$",
						"type" => "textfield"
					),
					array(
						"param_name" => "period",
						"heading" => __("Period", "trx_addons"),
						"description" => __("Period text (if need). For example: monthly, daily, etc.", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Align price to left or right side", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Price extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Price block
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_price_block",
				"name" => __("Price block", "trx_addons"),
				"description" => __("Insert price block with title, price and description", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_price_block',
				"class" => "trx_sc_single trx_sc_price_block",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => __("Price block style", "trx_addons"),
						"description" => __("Select style of Price block", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Style 1', 'trx_addons') => '1',
							__('Style 2', 'trx_addons') => '2'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Block title", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => __("Link URL", "trx_addons"),
						"description" => __("URL for link from button (at bottom of the block)", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link_text",
						"heading" => __("Link text", "trx_addons"),
						"description" => __("Text (caption) for the link button (at bottom of the block). If empty - button not showed", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "icon",
						"heading" => __("Icon", "trx_addons"),
						"description" => __("Select icon from Fontello icons set (placed before/instead price)", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "money",
						"heading" => __("Money", "trx_addons"),
						"description" => __("Money value (dot or comma separated)", "trx_addons"),
						"admin_label" => true,
						"group" => __('Money', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "currency",
						"heading" => __("Currency symbol", "trx_addons"),
						"description" => __("Currency character", "trx_addons"),
						"admin_label" => true,
						"group" => __('Money', 'trx_addons'),
						"class" => "",
						"value" => "$",
						"type" => "textfield"
					),
					array(
						"param_name" => "period",
						"heading" => __("Period", "trx_addons"),
						"description" => __("Period text (if need). For example: monthly, daily, etc.", "trx_addons"),
						"admin_label" => true,
						"group" => __('Money', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Align price to left or right side", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "content",
						"heading" => __("Description", "trx_addons"),
						"description" => __("Description for this price block", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
			) );
			
			class WPBakeryShortCode_Trx_PriceBlock extends THEMEREX_VC_ShortCodeSingle {}

			
			
			
			
			// Quote
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_quote",
				"name" => __("Quote", "trx_addons"),
				"description" => __("Quote text", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_quote',
				"class" => "trx_sc_single trx_sc_quote",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "cite",
						"heading" => __("Quote cite", "trx_addons"),
						"description" => __("URL for the quote cite link", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "title",
						"heading" => __("Title (author)", "trx_addons"),
						"description" => __("Quote title (author name)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "style",
						"heading" => __("Quote style", "trx_addons"),
						"description" => __("Select style of Quote block", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Style 1', 'trx_addons') => '1',
							__('Style 2', 'trx_addons') => '2'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "content",
						"heading" => __("Quote content", "trx_addons"),
						"description" => __("Quote content", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					themerex_vc_width(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
			) );
			
			class WPBakeryShortCode_Trx_Quote extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Reviews
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_reviews",
				"name" => __("Reviews", "trx_addons"),
				"description" => __("Insert reviews block in the single post", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_reviews',
				"class" => "trx_sc_single trx_sc_reviews",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Align counter to left, center or right", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Reviews extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Search
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_search",
				"name" => __("Search form", "trx_addons"),
				"description" => __("Insert search form", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_search',
				"class" => "trx_sc_single trx_sc_search",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Title (placeholder) for the search field", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => __("Search &hellip;", 'trx_addons'),
						"type" => "textfield"
					),
					array(
						"param_name" => "ajax",
						"heading" => __("AJAX", "trx_addons"),
						"description" => __("Search via AJAX or reload page", "trx_addons"),
						"class" => "",
						"value" => array(__('Use AJAX search', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Search extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Section
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_section",
				"name" => __("Section container", "trx_addons"),
				"description" => __("Container for any block ([block] analog - to enable nesting)", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				"class" => "trx_sc_collection trx_sc_section",
				'icon' => 'icon_trx_block',
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "dedicated",
						"heading" => __("Dedicated", "trx_addons"),
						"description" => __("Use this block as dedicated content - show it before post title on single page", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(__('Use as dedicated content', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Container title", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Select block alignment", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => __("Columns emulation", "trx_addons"),
						"description" => __("Select width for columns emulation", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['columns']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "pan",
						"heading" => __("Use pan effect", "trx_addons"),
						"description" => __("Use pan effect to show section content", "trx_addons"),
						"group" => __('Scroll', 'trx_addons'),
						"class" => "",
						"value" => array(__('Content scroller', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "scroll",
						"heading" => __("Use scroller", "trx_addons"),
						"description" => __("Use scroller to show section content", "trx_addons"),
						"group" => __('Scroll', 'trx_addons'),
						"admin_label" => true,
						"class" => "",
						"value" => array(__('Content scroller', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "scroll_dir",
						"heading" => __("Scroll and Pan direction", "trx_addons"),
						"description" => __("Scroll and Pan direction (if Use scroller = yes or Pan = yes)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"group" => __('Scroll', 'trx_addons'),
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['dir']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scroll_controls",
						"heading" => __("Scroll controls", "trx_addons"),
						"description" => __("Show scroll controls (if Use scroller = yes)", "trx_addons"),
						"class" => "",
						"group" => __('Scroll', 'trx_addons'),
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['dir']),
						'dependency' => array(
							'element' => 'scroll',
							'not_empty' => true
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => __("Fore color", "trx_addons"),
						"description" => __("Any color for objects in this section", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_tint",
						"heading" => __("Background tint", "trx_addons"),
						"description" => __("Main background tint: dark or light", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['tint']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_color",
						"heading" => __("Background color", "trx_addons"),
						"description" => __("Any background color for this section", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => __("Background image URL", "trx_addons"),
						"description" => __("Select background image from library for this section", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_overlay",
						"heading" => __("Overlay", "trx_addons"),
						"description" => __("Overlay color opacity (from 0.0 to 1.0)", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_texture",
						"heading" => __("Texture", "trx_addons"),
						"description" => __("Texture style from 1 to 11. Empty or 0 - without texture.", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_size",
						"heading" => __("Font size", "trx_addons"),
						"description" => __("Font size of the text (default - in pixels, allows any CSS units of measure)", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_weight",
						"heading" => __("Font weight", "trx_addons"),
						"description" => __("Font weight of the text", "trx_addons"),
						"class" => "",
						"value" => array(
							__('Default', 'trx_addons') => 'inherit',
							__('Thin (100)', 'trx_addons') => '100',
							__('Light (300)', 'trx_addons') => '300',
							__('Normal (400)', 'trx_addons') => '400',
							__('Bold (700)', 'trx_addons') => '700'
						),
						"type" => "dropdown"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => __("Container content", "trx_addons"),
						"description" => __("Content for section container", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Section extends THEMEREX_VC_ShortCodeCollection {}
			
			
			
			
			
			
			
			// Skills
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_skills",
				"name" => __("Skills", "trx_addons"),
				"description" => __("Insert skills diagramm", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_skills',
				"class" => "trx_sc_collection trx_sc_skills",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_skills_item'),
				"params" => array(
					array(
						"param_name" => "max_value",
						"heading" => __("Max value", "trx_addons"),
						"description" => __("Max value for skills items", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "100",
						"type" => "textfield"
					),
					array(
						"param_name" => "type",
						"heading" => __("Skills type", "trx_addons"),
						"description" => __("Select type of skills block", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Bar', 'trx_addons') => 'bar',
							__('Bar 2', 'trx_addons') => 'bar2',
							__('Bar 3', 'trx_addons') => 'bar3',
							__('Pie chart', 'trx_addons') => 'pie',
							__('Pie chart 2', 'trx_addons') => 'pie_2',
							__('Counter', 'trx_addons') => 'counter',
							__('Arc', 'trx_addons') => 'arc'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "layout",
						"heading" => __("Skills layout", "trx_addons"),
						"description" => __("Select layout of skills block", "trx_addons"),
						"admin_label" => true,
						'dependency' => array(
							'element' => 'type',
							'value' => array('counter','bar','pie')
						),
						"class" => "",
						"value" => array(
							__('Columns', 'trx_addons') => 'columns',
							__('Rows', 'trx_addons') => 'rows'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "dir",
						"heading" => __("Direction", "trx_addons"),
						"description" => __("Select direction of skills block", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['dir']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "style",
						"heading" => __("Counters style", "trx_addons"),
						"description" => __("Select style of skills items (only for type=counter)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Style 1', 'trx_addons') => '1',
							__('Style 2', 'trx_addons') => '2',
							__('Style 3', 'trx_addons') => '3',
							__('Style 4', 'trx_addons') => '4'
						),
						'dependency' => array(
							'element' => 'type',
							'value' => array('counter')
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => __("Columns count", "trx_addons"),
						"description" => __("Skills columns count (required)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "2",
						"type" => "textfield"
					),
					array(
						"param_name" => "color",
						"heading" => __("Color", "trx_addons"),
						"description" => __("Color for all skills items", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => __("Background color", "trx_addons"),
						"description" => __("Background color for all skills items (only for type=pie)", "trx_addons"),
						'dependency' => array(
							'element' => 'type',
							'value' => array('pie')
						),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "border_color",
						"heading" => __("Border color", "trx_addons"),
						"description" => __("Border color for all skills items (only for type=pie)", "trx_addons"),
						'dependency' => array(
							'element' => 'type',
							'value' => array('pie')
						),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Title of the skills block", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => __("Subtitle", "trx_addons"),
						"description" => __("Default subtitle of the skills block (only if type=arc)", "trx_addons"),
						'dependency' => array(
							'element' => 'type',
							'value' => array('arc')
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Align skills block to left or right side", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			
			vc_map( array(
				"base" => "trx_skills_item",
				"name" => __("Skill", "trx_addons"),
				"description" => __("Skills item", "trx_addons"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_single trx_sc_skills_item",
				"content_element" => true,
				"is_container" => false,
				"as_child" => array('only' => 'trx_skills'),
				"as_parent" => array('except' => 'trx_skills'),
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Title for the current skills item", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "value",
						"heading" => __("Value", "trx_addons"),
						"description" => __("Value for the current skills item", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "50",
						"type" => "textfield"
					),
					array(
						"param_name" => "color",
						"heading" => __("Color", "trx_addons"),
						"description" => __("Color for current skills item", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => __("Background color", "trx_addons"),
						"description" => __("Background color for current skills item (only for type=pie)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "border_color",
						"heading" => __("Border color", "trx_addons"),
						"description" => __("Border color for current skills item (only for type=pie)", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "icon",
						"heading" => __("Skills font icon", "trx_addons"),
						"description" => __("Select font icon for the skills from Fontello icons set (if style= Bar 3)", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "color_icon",
						"heading" => __("Icon color", "trx_addons"),
						"description" => __("Color for current skills icon (if style= Bar 3)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "style",
						"heading" => __("Item style", "trx_addons"),
						"description" => __("Select style for the current skills item (only for type=counter)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Style 1', 'trx_addons') => '1',
							__('Style 2', 'trx_addons') => '2',
							__('Style 3', 'trx_addons') => '3',
							__('Style 4', 'trx_addons') => '4'
						),
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Skills extends THEMEREX_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_Skills_Item extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Slider
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_slider",
				"name" => __("Slider", "trx_addons"),
				"description" => __("Insert slider", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_slider',
				"class" => "trx_sc_collection trx_sc_slider",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_slider_item'),
				"params" => array_merge(array(
					array(
						"param_name" => "engine",
						"heading" => __("Engine", "trx_addons"),
						"description" => __("Select engine for slider. Attention! Swiper is built-in engine, all other engines appears only if corresponding plugings are installed", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['sliders']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "align",
						"heading" => __("Float slider", "trx_addons"),
						"description" => __("Float slider to left or right side", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "custom",
						"heading" => __("Custom slides", "trx_addons"),
						"description" => __("Make custom slides from inner shortcodes (prepare it on tabs) or prepare slides from posts thumbnails", "trx_addons"),
						"class" => "",
						"value" => array(__('Custom slides', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					)
					),
					themerex_exists_revslider() || themerex_exists_royalslider() ? array(
					array(
						"param_name" => "alias",
						"heading" => __("Revolution slider alias or Royal Slider ID", "trx_addons"),
						"description" => __("Alias for Revolution slider or Royal slider ID", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						'dependency' => array(
							'element' => 'engine',
							'value' => array('revo','royal')
						),
						"value" => "",
						"type" => "textfield"
					)) : array(), array(
					array(
						"param_name" => "cat",
						"heading" => __("Categories list", "trx_addons"),
						"description" => __("Select category. If empty - show posts from any category or from IDs list", "trx_addons"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array_flip(themerex_array_merge(array(0 => __('- Select category -', 'trx_addons')), $THEMEREX_GLOBALS['sc_params']['categories'])),
						"type" => "dropdown"
					),
					array(
						"param_name" => "count",
						"heading" => __("Swiper: Number of posts", "trx_addons"),
						"description" => __("How many posts will be displayed? If used IDs - this parameter ignored.", "trx_addons"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => __("Swiper: Offset before select posts", "trx_addons"),
						"description" => __("Skip posts before select next part.", "trx_addons"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => __("Swiper: Post sorting", "trx_addons"),
						"description" => __("Select desired posts sorting method", "trx_addons"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['sorting']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => __("Swiper: Post order", "trx_addons"),
						"description" => __("Select desired posts order", "trx_addons"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => __("Swiper: Post IDs list", "trx_addons"),
						"description" => __("Comma separated list of posts ID. If set - parameters above are ignored!", "trx_addons"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "controls",
						"heading" => __("Swiper: Show slider controls", "trx_addons"),
						"description" => __("Show arrows inside slider", "trx_addons"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(__('Show controls', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "pagination",
						"heading" => __("Swiper: Show slider pagination", "trx_addons"),
						"description" => __("Show bullets or titles to switch slides", "trx_addons"),
						"group" => __('Details', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(
								__('Dots', 'trx_addons') => 'yes',
								__('Side Titles', 'trx_addons') => 'full',
								__('Over Titles', 'trx_addons') => 'over',
								__('None', 'trx_addons') => 'no'
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "titles",
						"heading" => __("Swiper: Show titles section", "trx_addons"),
						"description" => __("Show section with post's title and short post's description", "trx_addons"),
						"group" => __('Details', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(
								__('Not show', 'trx_addons') => "no",
								__('Show/Hide info', 'trx_addons') => "slide",
								__('Fixed info', 'trx_addons') => "fixed"
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "descriptions",
						"heading" => __("Swiper: Post descriptions", "trx_addons"),
						"description" => __("Show post's excerpt max length (characters)", "trx_addons"),
						"group" => __('Details', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "links",
						"heading" => __("Swiper: Post's title as link", "trx_addons"),
						"description" => __("Make links from post's titles", "trx_addons"),
						"group" => __('Details', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(__('Titles as a links', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "crop",
						"heading" => __("Swiper: Crop images", "trx_addons"),
						"description" => __("Crop images in each slide or live it unchanged", "trx_addons"),
						"group" => __('Details', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(__('Crop images', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "autoheight",
						"heading" => __("Swiper: Autoheight", "trx_addons"),
						"description" => __("Change whole slider's height (make it equal current slide's height)", "trx_addons"),
						"group" => __('Details', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(__('Autoheight', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "interval",
						"heading" => __("Swiper: Slides change interval", "trx_addons"),
						"description" => __("Slides change interval (in milliseconds: 1000ms = 1s)", "trx_addons"),
						"group" => __('Details', 'trx_addons'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => "5000",
						"type" => "textfield"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				))
			) );
			
			
			vc_map( array(
				"base" => "trx_slider_item",
				"name" => __("Slide", "trx_addons"),
				"description" => __("Slider item - single slide", "trx_addons"),
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_slider_item',
				"as_child" => array('only' => 'trx_slider'),
				"as_parent" => array('except' => 'trx_slider'),
				"params" => array(
					array(
						"param_name" => "src",
						"heading" => __("URL (source) for image file", "trx_addons"),
						"description" => __("Select or upload image or write URL from other site for the current slide", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Slider extends THEMEREX_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_Slider_Item extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Socials
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_socials",
				"name" => __("Social icons", "trx_addons"),
				"description" => __("Custom social icons", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_socials',
				"class" => "trx_sc_collection trx_sc_socials",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_social_item'),
				"params" => array_merge(array(
					array(
						"param_name" => "size",
						"heading" => __("Icon's size", "trx_addons"),
						"description" => __("Size of the icons", "trx_addons"),
						"class" => "",
						"value" => array(
							__('Tiny', 'trx_addons') => 'tiny',
							__('Small', 'trx_addons') => 'small',
							__('Large', 'trx_addons') => 'large'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "socials",
						"heading" => __("Manual socials list", "trx_addons"),
						"description" => __("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebooc.com/my_profile. If empty - use socials from Theme options.", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "custom",
						"heading" => __("Custom socials", "trx_addons"),
						"description" => __("Make custom icons from inner shortcodes (prepare it on tabs)", "trx_addons"),
						"class" => "",
						"value" => array(__('Custom socials', 'trx_addons') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "style",
						"heading" => __("Socials style", "trx_addons"),
						"description" => __("Socials style", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Main', 'trx_addons') => 'main',
							__('Color', 'trx_addons') => 'color'
						),
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				))
			) );
			
			
			vc_map( array(
				"base" => "trx_social_item",
				"name" => __("Custom social item", "trx_addons"),
				"description" => __("Custom social item: name, profile url and icon url", "trx_addons"),
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_social_item',
				"as_child" => array('only' => 'trx_socials'),
				"as_parent" => array('except' => 'trx_socials'),
				"params" => array(
					array(
						"param_name" => "url",
						"heading" => __("Your profile URL", "trx_addons"),
						"description" => __("URL of your profile in specified social network", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "icon",
						"heading" => __("Icon", "trx_addons"),
						"description" => __("Select font icon from Fontello icons set (if style=iconed)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Trx_Socials extends THEMEREX_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_Social_Item extends THEMEREX_VC_ShortCodeSingle {}
			

			
			
			
			
			
			// Table
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_table",
				"name" => __("Table", "trx_addons"),
				"description" => __("Insert a table", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_table',
				"class" => "trx_sc_container trx_sc_table",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "align",
						"heading" => __("Cells content alignment", "trx_addons"),
						"description" => __("Select alignment for each table cell", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "content",
						"heading" => __("Table content", "trx_addons"),
						"description" => __("Content, created with any table-generator", "trx_addons"),
						"class" => "",
						"value" => "Paste here table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/",
						"type" => "textarea_html"
					),
					themerex_vc_width(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextContainerView'
			) );
			
			class WPBakeryShortCode_Trx_Table extends THEMEREX_VC_ShortCodeContainer {}
			
			
			
			
			
			
			
			// Tabs
			//-------------------------------------------------------------------------------------
			
			$tab_id_1 = 'sc_tab_'.time() . '_1_' . rand( 0, 100 );
			$tab_id_2 = 'sc_tab_'.time() . '_2_' . rand( 0, 100 );
			vc_map( array(
				"base" => "trx_tabs",
				"name" => __("Tabs", "trx_addons"),
				"description" => __("Tabs", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_tabs',
				"class" => "trx_sc_collection trx_sc_tabs",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"as_parent" => array('only' => 'trx_tab'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => __("Tabs style", "trx_addons"),
						"description" => __("Select style of tabs items", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Style 1 (fullscreen)', 'trx_addons') => '1',
							__('Style 2', 'trx_addons') => '2',
							__('Style 3', 'trx_addons') => '3'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "initial",
						"heading" => __("Initially opened tab", "trx_addons"),
						"description" => __("Number of initially opened tab", "trx_addons"),
						"class" => "",
						"value" => 1,
						"type" => "textfield"
					),
					array(
						"param_name" => "scroll",
						"heading" => __("Scroller", "trx_addons"),
						"description" => __("Use scroller to show tab content (height parameter required)", "trx_addons"),
						"class" => "",
						"value" => array("Use scroller" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Title for the Tabs (Style 2)", "trx_addons"),
						"admin_label" => true,
						"group" => __('Captions', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => __("Subtitle", "trx_addons"),
						"description" => __("Subtitle for the Tabs (Style 2)", "trx_addons"),
						"group" => __('Captions', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => __("Description", "trx_addons"),
						"description" => __("Description for the Tabs (Style 2)", "trx_addons"),
						"group" => __('Captions', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'default_content' => '
					[trx_tab title="' . __( 'Tab 1', 'trx_addons' ) . '" tab_id="'.esc_attr($tab_id_1).'"][/trx_tab]
					[trx_tab title="' . __( 'Tab 2', 'trx_addons' ) . '" tab_id="'.esc_attr($tab_id_2).'"][/trx_tab]
				',
				"custom_markup" => '
					<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
						<ul class="tabs_controls">
						</ul>
						%content%
					</div>
				',
				'js_view' => 'VcTrxTabsView'
			) );
			
			
			vc_map( array(
				"base" => "trx_tab",
				"name" => __("Tab item", "trx_addons"),
				"description" => __("Single tab item", "trx_addons"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_collection trx_sc_tab",
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_tab',
				"as_child" => array('only' => 'trx_tabs'),
				"as_parent" => array('except' => 'trx_tabs'),
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => __("Tab title", "trx_addons"),
						"description" => __("Title for current tab", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "icon",
						"heading" => __("Title font icon (style 1)", "trx_addons"),
						"description" => __("Select font icon for the tab from Fontello icons set (if style 1)", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "tab_id",
						"heading" => __("Tab ID", "trx_addons"),
						"description" => __("ID for current tab (required). Please, start it from letter.", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
			  'js_view' => 'VcTrxTabView'
			) );
			class WPBakeryShortCode_Trx_Tabs extends THEMEREX_VC_ShortCodeTabs {}
			class WPBakeryShortCode_Trx_Tab extends THEMEREX_VC_ShortCodeTab {}
			
			
			
			
			// Team
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_team",
				"name" => __("Team", "trx_addons"),
				"description" => __("Insert team members", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_team',
				"class" => "trx_sc_columns trx_sc_team",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_team_item'),
				"params" => array(
					array(
						"param_name" => "columns",
						"heading" => __("Columns", "trx_addons"),
						"description" => __("How many columns use to show team members", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "custom",
						"heading" => __("Custom", "trx_addons"),
						"description" => __("Allow get team members from inner shortcodes (custom) or get it from specified group (cat)", "trx_addons"),
						"class" => "",
						"value" => array("Custom members" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "cat",
						"heading" => __("Categories", "trx_addons"),
						"description" => __("Put here comma separated categories (ids or slugs) to show team members. If empty - select team members from any category (group) or from IDs list", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "count",
						"heading" => __("Number of posts", "trx_addons"),
						"description" => __("How many posts will be displayed? If used IDs - this parameter ignored.", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => __("Offset before select posts", "trx_addons"),
						"description" => __("Skip posts before select next part.", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => __("Post sorting", "trx_addons"),
						"description" => __("Select desired posts sorting method", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['sorting']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => __("Post order", "trx_addons"),
						"description" => __("Select desired posts order", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => __("Team member's IDs list", "trx_addons"),
						"description" => __("Comma separated list of team members's ID. If set - parameters above (category, count, order, etc.)  are ignored!", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'default_content' => '
					[trx_team_item user="' . __( 'Member 1', 'trx_addons' ) . '"][/trx_team_item]
					[trx_team_item user="' . __( 'Member 2', 'trx_addons' ) . '"][/trx_team_item]
				',
				'js_view' => 'VcTrxColumnsView'
			) );
			
			
			vc_map( array(
				"base" => "trx_team_item",
				"name" => __("Team member", "trx_addons"),
				"description" => __("Team member - all data pull out from it account on your site", "trx_addons"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_item trx_sc_column_item trx_sc_team_item",
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_team_item',
				"as_child" => array('only' => 'trx_team'),
				"as_parent" => array('except' => 'trx_team'),
				"params" => array(
					array(
						"param_name" => "user",
						"heading" => __("Registered user", "trx_addons"),
						"description" => __("Select one of registered users (if present) or put name, position, etc. in fields below", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['users']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "member",
						"heading" => __("Team member", "trx_addons"),
						"description" => __("Select one of team members (if present) or put name, position, etc. in fields below", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['members']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "link",
						"heading" => __("Link", "trx_addons"),
						"description" => __("Link on team member's personal page", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "name",
						"heading" => __("Name", "trx_addons"),
						"description" => __("Team member's name", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "position",
						"heading" => __("Position", "trx_addons"),
						"description" => __("Team member's position", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "email",
						"heading" => __("E-mail", "trx_addons"),
						"description" => __("Team member's e-mail", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "photo",
						"heading" => __("Member's Photo", "trx_addons"),
						"description" => __("Team member's photo (avatar", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "socials",
						"heading" => __("Socials", "trx_addons"),
						"description" => __("Team member's socials icons: name=url|name=url... For example: facebook=http://facebook.com/myaccount|twitter=http://twitter.com/myaccount", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Team extends THEMEREX_VC_ShortCodeColumns {}
			class WPBakeryShortCode_Trx_Team_Item extends THEMEREX_VC_ShortCodeItem {}
			
			
			
			
			
			
			
			// Testimonials
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_testimonials",
				"name" => __("Testimonials", "trx_addons"),
				"description" => __("Insert testimonials slider", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_testimonials',
				"class" => "trx_sc_collection trx_sc_testimonials",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_testimonials_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => __("Testimonials style", "trx_addons"),
						"description" => __("Select style to display testimonials members", "trx_addons"),
						"class" => "",
						"admin_label" => true,
						"value" => array(
							__('Style 1', 'trx_addons') => 1,
							__('Style 2', 'trx_addons') => 2
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => __("Columns", "trx_addons"),
						"description" => __("How many columns use to show team members (for Style 2)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => 2,
						"type" => "textfield"
					),
					array(
						"param_name" => "controls",
						"heading" => __("Show arrows", "trx_addons"),
						"description" => __("Show control buttons", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['yes_no']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "interval",
						"heading" => __("Testimonials change interval", "trx_addons"),
						"description" => __("Testimonials change interval (in milliseconds: 1000ms = 1s)", "trx_addons"),
						"class" => "",
						"value" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Alignment of the testimonials block", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "autoheight",
						"heading" => __("Autoheight", "trx_addons"),
						"description" => __("Change whole slider's height (make it equal current slide's height)", "trx_addons"),
						"class" => "",
						"value" => array("Autoheight" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "custom",
						"heading" => __("Custom", "trx_addons"),
						"description" => __("Allow get testimonials from inner shortcodes (custom) or get it from specified group (cat)", "trx_addons"),
						"class" => "",
						"value" => array("Custom slides" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "cat",
						"heading" => __("Categories", "trx_addons"),
						"description" => __("Select categories (groups) to show testimonials. If empty - select testimonials from any category (group) or from IDs list", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "count",
						"heading" => __("Number of posts", "trx_addons"),
						"description" => __("How many posts will be displayed? If used IDs - this parameter ignored.", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => __("Offset before select posts", "trx_addons"),
						"description" => __("Skip posts before select next part.", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => __("Post sorting", "trx_addons"),
						"description" => __("Select desired posts sorting method", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['sorting']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => __("Post order", "trx_addons"),
						"description" => __("Select desired posts order", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => __("Post IDs list", "trx_addons"),
						"description" => __("Comma separated list of posts ID. If set - parameters above are ignored!", "trx_addons"),
						"group" => __('Query', 'trx_addons'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_tint",
						"heading" => __("Background tint", "trx_addons"),
						"description" => __("Main background tint: dark or light", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['tint']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_color",
						"heading" => __("Background color", "trx_addons"),
						"description" => __("Any background color for this section", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => __("Background image URL", "trx_addons"),
						"description" => __("Select background image from library for this section", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_overlay",
						"heading" => __("Overlay", "trx_addons"),
						"description" => __("Overlay color opacity (from 0.0 to 1.0)", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_texture",
						"heading" => __("Texture", "trx_addons"),
						"description" => __("Texture style from 1 to 11. Empty or 0 - without texture.", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			
			vc_map( array(
				"base" => "trx_testimonials_item",
				"name" => __("Testimonial", "trx_addons"),
				"description" => __("Single testimonials item", "trx_addons"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_single trx_sc_testimonials_item",
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_testimonials_item',
				"as_child" => array('only' => 'trx_testimonials'),
				"as_parent" => array('except' => 'trx_testimonials'),
				"params" => array(
					array(
						"param_name" => "author",
						"heading" => __("Author", "trx_addons"),
						"description" => __("Name of the testimonmials author", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => __("Link", "trx_addons"),
						"description" => __("Link URL to the testimonmials author page", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "email",
						"heading" => __("E-mail", "trx_addons"),
						"description" => __("E-mail of the testimonmials author", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "photo",
						"heading" => __("Photo", "trx_addons"),
						"description" => __("Select or upload photo of testimonmials author or write URL of photo from other site", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "field",
						"heading" => __("Field", "trx_addons"),
						"description" => __("Additional field", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "content",
						"heading" => __("Testimonials text", "trx_addons"),
						"description" => __("Current testimonials text", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
			) );
			
			class WPBakeryShortCode_Trx_Testimonials extends THEMEREX_VC_ShortCodeColumns {}
			class WPBakeryShortCode_Trx_Testimonials_Item extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Title
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_title",
				"name" => __("Title", "trx_addons"),
				"description" => __("Create header tag (1-6 level) with many styles", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_title',
				"class" => "trx_sc_single trx_sc_title",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "content",
						"heading" => __("Title content", "trx_addons"),
						"description" => __("Title content", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					array(
						"param_name" => "type",
						"heading" => __("Title type", "trx_addons"),
						"description" => __("Title type (header level)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Header 1', 'trx_addons') => '1',
							__('Header 2', 'trx_addons') => '2',
							__('Header 3', 'trx_addons') => '3',
							__('Header 4', 'trx_addons') => '4',
							__('Header 5', 'trx_addons') => '5',
							__('Header 6', 'trx_addons') => '6'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "style",
						"heading" => __("Title style", "trx_addons"),
						"description" => __("Title style: only text (regular) or with icon/image (iconed)", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Regular', 'trx_addons') => 'regular',
							__('Underline', 'trx_addons') => 'underline',
							__('Divider', 'trx_addons') => 'divider',
							__('With icon (image)', 'trx_addons') => 'iconed'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Title text alignment", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "font_size",
						"heading" => __("Font size", "trx_addons"),
						"description" => __("Custom font size. If empty - use theme default", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_weight",
						"heading" => __("Font weight", "trx_addons"),
						"description" => __("Custom font weight. If empty or inherit - use theme default", "trx_addons"),
						"class" => "",
						"value" => array(
							__('Default', 'trx_addons') => 'inherit',
							__('Thin (100)', 'trx_addons') => '100',
							__('Light (300)', 'trx_addons') => '300',
							__('Normal (400)', 'trx_addons') => '400',
							__('Semibold (600)', 'trx_addons') => '600',
							__('Bold (700)', 'trx_addons') => '700',
							__('Black (900)', 'trx_addons') => '900'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => __("Title color", "trx_addons"),
						"description" => __("Select color for the title", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "icon",
						"heading" => __("Title font icon", "trx_addons"),
						"description" => __("Select font icon for the title from Fontello icons set (if style=iconed)", "trx_addons"),
						"class" => "",
						"group" => __('Icon &amp; Image', 'trx_addons'),
						'dependency' => array(
							'element' => 'style',
							'value' => array('iconed')
						),
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "image",
						"heading" => __("or image icon", "trx_addons"),
						"description" => __("Select image icon for the title instead icon above (if style=iconed)", "trx_addons"),
						"class" => "",
						"group" => __('Icon &amp; Image', 'trx_addons'),
						'dependency' => array(
							'element' => 'style',
							'value' => array('iconed')
						),
						"value" => $THEMEREX_GLOBALS['sc_params']['images'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "picture",
						"heading" => __("or select uploaded image", "trx_addons"),
						"description" => __("Select or upload image or write URL from other site (if style=iconed)", "trx_addons"),
						"group" => __('Icon &amp; Image', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "image_size",
						"heading" => __("Image (picture) size", "trx_addons"),
						"description" => __("Select image (picture) size (if style=iconed)", "trx_addons"),
						"group" => __('Icon &amp; Image', 'trx_addons'),
						"class" => "",
						"value" => array(
							__('Small', 'trx_addons') => 'small',
							__('Medium', 'trx_addons') => 'medium',
							__('Large', 'trx_addons') => 'large'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "position",
						"heading" => __("Icon (image) position", "trx_addons"),
						"description" => __("Select icon (image) position (if style=iconed)", "trx_addons"),
						"group" => __('Icon &amp; Image', 'trx_addons'),
						"class" => "",
						"value" => array(
							__('Top', 'trx_addons') => 'top',
							__('Left', 'trx_addons') => 'left'
						),
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
			) );
			
			class WPBakeryShortCode_Trx_Title extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Toggles
			//-------------------------------------------------------------------------------------
				
			vc_map( array(
				"base" => "trx_toggles",
				"name" => __("Toggles", "trx_addons"),
				"description" => __("Toggles items", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_toggles',
				"class" => "trx_sc_collection trx_sc_toggles",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"as_parent" => array('only' => 'trx_toggles_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => __("Toggles style", "trx_addons"),
						"description" => __("Select style for display toggles", "trx_addons"),
						"class" => "",
						"admin_label" => true,
						"value" => array(
							__('Style 1', 'trx_addons') => 1,
							__('Style 2', 'trx_addons') => 2
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_closed",
						"heading" => __("Icon while closed", "trx_addons"),
						"description" => __("Select icon for the closed toggles item from Fontello icons set", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_opened",
						"heading" => __("Icon while opened", "trx_addons"),
						"description" => __("Select icon for the opened toggles item from Fontello icons set", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class']
				),
				'default_content' => '
					[trx_toggles_item title="' . __( 'Item 1 title', 'trx_addons' ) . '"][/trx_toggles_item]
					[trx_toggles_item title="' . __( 'Item 2 title', 'trx_addons' ) . '"][/trx_toggles_item]
				',
				"custom_markup" => '
					<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
						%content%
					</div>
					<div class="tab_controls">
						<button class="add_tab" title="'.__("Add item", "trx_addons").'">'.__("Add item", "trx_addons").'</button>
					</div>
				',
				'js_view' => 'VcTrxTogglesView'
			) );
			
			
			vc_map( array(
				"base" => "trx_toggles_item",
				"name" => __("Toggles item", "trx_addons"),
				"description" => __("Single toggles item", "trx_addons"),
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_toggles_item',
				"as_child" => array('only' => 'trx_toggles'),
				"as_parent" => array('except' => 'trx_toggles'),
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => __("Title", "trx_addons"),
						"description" => __("Title for current toggles item", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "open",
						"heading" => __("Open on show", "trx_addons"),
						"description" => __("Open current toggle item on show", "trx_addons"),
						"class" => "",
						"value" => array("Opened" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "icon_closed",
						"heading" => __("Icon while closed", "trx_addons"),
						"description" => __("Select icon for the closed toggles item from Fontello icons set", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_opened",
						"heading" => __("Icon while opened", "trx_addons"),
						"description" => __("Select icon for the opened toggles item from Fontello icons set", "trx_addons"),
						"class" => "",
						"value" => $THEMEREX_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTogglesTabView'
			) );
			class WPBakeryShortCode_Trx_Toggles extends THEMEREX_VC_ShortCodeToggles {}
			class WPBakeryShortCode_Trx_Toggles_Item extends THEMEREX_VC_ShortCodeTogglesItem {}
			
			
			
			
			
			
			// Twitter
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "trx_twitter",
				"name" => __("Twitter", "trx_addons"),
				"description" => __("Insert twitter feed into post (page)", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_twitter',
				"class" => "trx_sc_single trx_sc_twitter",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "user",
						"heading" => __("Twitter Username", "trx_addons"),
						"description" => __("Your username in the twitter account. If empty - get it from Theme Options.", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "consumer_key",
						"heading" => __("Consumer Key", "trx_addons"),
						"description" => __("Consumer Key from the twitter account", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "consumer_secret",
						"heading" => __("Consumer Secret", "trx_addons"),
						"description" => __("Consumer Secret from the twitter account", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "token_key",
						"heading" => __("Token Key", "trx_addons"),
						"description" => __("Token Key from the twitter account", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "token_secret",
						"heading" => __("Token Secret", "trx_addons"),
						"description" => __("Token Secret from the twitter account", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "count",
						"heading" => __("Tweets number", "trx_addons"),
						"description" => __("Number tweets to show", "trx_addons"),
						"class" => "",
						"divider" => true,
						"value" => 3,
						"type" => "textfield"
					),
					array(
						"param_name" => "controls",
						"heading" => __("Show arrows", "trx_addons"),
						"description" => __("Show control buttons", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['yes_no']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "interval",
						"heading" => __("Tweets change interval", "trx_addons"),
						"description" => __("Tweets change interval (in milliseconds: 1000ms = 1s)", "trx_addons"),
						"class" => "",
						"value" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Alignment of the tweets block", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "autoheight",
						"heading" => __("Autoheight", "trx_addons"),
						"description" => __("Change whole slider's height (make it equal current slide's height)", "trx_addons"),
						"class" => "",
						"value" => array("Autoheight" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "bg_tint",
						"heading" => __("Background tint", "trx_addons"),
						"description" => __("Main background tint: dark or light", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['tint']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_color",
						"heading" => __("Background color", "trx_addons"),
						"description" => __("Any background color for this section", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => __("Background image URL", "trx_addons"),
						"description" => __("Select background image from library for this section", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_overlay",
						"heading" => __("Overlay", "trx_addons"),
						"description" => __("Overlay color opacity (from 0.0 to 1.0)", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_texture",
						"heading" => __("Texture", "trx_addons"),
						"description" => __("Texture style from 1 to 11. Empty or 0 - without texture.", "trx_addons"),
						"group" => __('Colors and Images', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				),
			) );
			
			class WPBakeryShortCode_Trx_Twitter extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Video
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_video",
				"name" => __("Video", "trx_addons"),
				"description" => __("Insert video player", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_video',
				"class" => "trx_sc_single trx_sc_video",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "url",
						"heading" => __("URL for video file", "trx_addons"),
						"description" => __("Paste URL for video file", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "ratio",
						"heading" => __("Ratio", "trx_addons"),
						"description" => __("Select ratio for display video", "trx_addons"),
						"class" => "",
						"value" => array(
							__('16:9', 'trx_addons') => "16:9",
							__('4:3', 'trx_addons') => "4:3"
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "autoplay",
						"heading" => __("Autoplay video", "trx_addons"),
						"description" => __("Autoplay video on page load", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array("Autoplay" => "on" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Select block alignment", "trx_addons"),
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "image",
						"heading" => __("Cover image", "trx_addons"),
						"description" => __("Select or upload image or write URL from other site for video preview", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_image",
						"heading" => __("Background image", "trx_addons"),
						"description" => __("Select or upload image or write URL from other site for video background. Attention! If you use background image - specify paddings below from background margins to video block in percents!", "trx_addons"),
						"group" => __('Background', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_top",
						"heading" => __("Top offset", "trx_addons"),
						"description" => __("Top offset (padding) from background image to video block (in percent). For example: 3%", "trx_addons"),
						"group" => __('Background', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_bottom",
						"heading" => __("Bottom offset", "trx_addons"),
						"description" => __("Bottom offset (padding) from background image to video block (in percent). For example: 3%", "trx_addons"),
						"group" => __('Background', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_left",
						"heading" => __("Left offset", "trx_addons"),
						"description" => __("Left offset (padding) from background image to video block (in percent). For example: 20%", "trx_addons"),
						"group" => __('Background', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_right",
						"heading" => __("Right offset", "trx_addons"),
						"description" => __("Right offset (padding) from background image to video block (in percent). For example: 12%", "trx_addons"),
						"group" => __('Background', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Video extends THEMEREX_VC_ShortCodeSingle {}








			// Sidebar
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "trx_sidebar",
				"name" => __("Sidebar", "trx_addons"),
				"description" => __("Insert Sidebar", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_sidebar',
				"class" => "trx_sc_single trx_sc_sidebar",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "name",
						"heading" => __("Select sidebar", "trx_addons"),
						"description" => __("Select sidebar", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['sidebar']),
						"type" => "dropdown"
					),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right']
				),
			) );

			class WPBakeryShortCode_Trx_Sidebar extends THEMEREX_VC_ShortCodeSingle {}








			// Zoom
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_zoom",
				"name" => __("Zoom", "trx_addons"),
				"description" => __("Insert the image with zoom/lens effect", "trx_addons"),
				"category" => __('Content', 'trx_addons'),
				'icon' => 'icon_trx_zoom',
				"class" => "trx_sc_single trx_sc_zoom",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "effect",
						"heading" => __("Effect", "trx_addons"),
						"description" => __("Select effect to display overlapping image", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							__('Lens', 'trx_addons') => 'lens',
							__('Zoom', 'trx_addons') => 'zoom'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "url",
						"heading" => __("Main image", "trx_addons"),
						"description" => __("Select or upload main image", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "over",
						"heading" => __("Overlaping image", "trx_addons"),
						"description" => __("Select or upload overlaping image", "trx_addons"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "align",
						"heading" => __("Alignment", "trx_addons"),
						"description" => __("Float zoom to left or right side", "trx_addons"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($THEMEREX_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_image",
						"heading" => __("Background image", "trx_addons"),
						"description" => __("Select or upload image or write URL from other site for zoom background. Attention! If you use background image - specify paddings below from background margins to video block in percents!", "trx_addons"),
						"group" => __('Background', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_top",
						"heading" => __("Top offset", "trx_addons"),
						"description" => __("Top offset (padding) from background image to zoom block (in percent). For example: 3%", "trx_addons"),
						"group" => __('Background', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_bottom",
						"heading" => __("Bottom offset", "trx_addons"),
						"description" => __("Bottom offset (padding) from background image to zoom block (in percent). For example: 3%", "trx_addons"),
						"group" => __('Background', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_left",
						"heading" => __("Left offset", "trx_addons"),
						"description" => __("Left offset (padding) from background image to zoom block (in percent). For example: 20%", "trx_addons"),
						"group" => __('Background', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_right",
						"heading" => __("Right offset", "trx_addons"),
						"description" => __("Right offset (padding) from background image to zoom block (in percent). For example: 12%", "trx_addons"),
						"group" => __('Background', 'trx_addons'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					themerex_vc_width(),
					themerex_vc_height(),
					$THEMEREX_GLOBALS['vc_params']['margin_top'],
					$THEMEREX_GLOBALS['vc_params']['margin_bottom'],
					$THEMEREX_GLOBALS['vc_params']['margin_left'],
					$THEMEREX_GLOBALS['vc_params']['margin_right'],
					$THEMEREX_GLOBALS['vc_params']['id'],
					$THEMEREX_GLOBALS['vc_params']['class'],
					$THEMEREX_GLOBALS['vc_params']['animation'],
					$THEMEREX_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Zoom extends THEMEREX_VC_ShortCodeSingle {}
			

			do_action('themerex_action_shortcodes_list_vc');
			
			
			if (themerex_exists_woocommerce()) {
			
				// WooCommerce - Cart
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "woocommerce_cart",
					"name" => __("Cart", "trx_addons"),
					"description" => __("WooCommerce shortcode: show cart page", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_wooc_cart',
					"class" => "trx_sc_alone trx_sc_woocommerce_cart",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => false,
					"params" => array()
				) );
				
				class WPBakeryShortCode_Woocommerce_Cart extends THEMEREX_VC_ShortCodeAlone {}
			
			
				// WooCommerce - Checkout
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "woocommerce_checkout",
					"name" => __("Checkout", "trx_addons"),
					"description" => __("WooCommerce shortcode: show checkout page", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_wooc_checkout',
					"class" => "trx_sc_alone trx_sc_woocommerce_checkout",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => false,
					"params" => array()
				) );
				
				class WPBakeryShortCode_Woocommerce_Checkout extends THEMEREX_VC_ShortCodeAlone {}
			
			
				// WooCommerce - My Account
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "woocommerce_my_account",
					"name" => __("My Account", "trx_addons"),
					"description" => __("WooCommerce shortcode: show my account page", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_wooc_my_account',
					"class" => "trx_sc_alone trx_sc_woocommerce_my_account",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => false,
					"params" => array()
				) );
				
				class WPBakeryShortCode_Woocommerce_My_Account extends THEMEREX_VC_ShortCodeAlone {}
			
			
				// WooCommerce - Order Tracking
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "woocommerce_order_tracking",
					"name" => __("Order Tracking", "trx_addons"),
					"description" => __("WooCommerce shortcode: show order tracking page", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_wooc_order_tracking',
					"class" => "trx_sc_alone trx_sc_woocommerce_order_tracking",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => false,
					"params" => array()
				) );
				
				class WPBakeryShortCode_Woocommerce_Order_Tracking extends THEMEREX_VC_ShortCodeAlone {}
			
			
				// WooCommerce - Shop Messages
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "shop_messages",
					"name" => __("Shop Messages", "trx_addons"),
					"description" => __("WooCommerce shortcode: show shop messages", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_wooc_shop_messages',
					"class" => "trx_sc_alone trx_sc_shop_messages",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => false,
					"params" => array()
				) );
				
				class WPBakeryShortCode_Shop_Messages extends THEMEREX_VC_ShortCodeAlone {}
			
			
				// WooCommerce - Product Page
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "product_page",
					"name" => __("Product Page", "trx_addons"),
					"description" => __("WooCommerce shortcode: display single product page", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_product_page',
					"class" => "trx_sc_single trx_sc_product_page",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "sku",
							"heading" => __("SKU", "trx_addons"),
							"description" => __("SKU code of displayed product", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "id",
							"heading" => __("ID", "trx_addons"),
							"description" => __("ID of displayed product", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "posts_per_page",
							"heading" => __("Number", "trx_addons"),
							"description" => __("How many products showed", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "1",
							"type" => "textfield"
						),
						array(
							"param_name" => "post_type",
							"heading" => __("Post type", "trx_addons"),
							"description" => __("Post type for the WP query (leave 'product')", "trx_addons"),
							"class" => "",
							"value" => "product",
							"type" => "textfield"
						),
						array(
							"param_name" => "post_status",
							"heading" => __("Post status", "trx_addons"),
							"description" => __("Display posts only with this status", "trx_addons"),
							"class" => "",
							"value" => array(
								__('Publish', 'trx_addons') => 'publish',
								__('Protected', 'trx_addons') => 'protected',
								__('Private', 'trx_addons') => 'private',
								__('Pending', 'trx_addons') => 'pending',
								__('Draft', 'trx_addons') => 'draft'
							),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Product_Page extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Product
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "product",
					"name" => __("Product", "trx_addons"),
					"description" => __("WooCommerce shortcode: display one product", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_product',
					"class" => "trx_sc_single trx_sc_product",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "sku",
							"heading" => __("SKU", "trx_addons"),
							"description" => __("Product's SKU code", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "id",
							"heading" => __("ID", "trx_addons"),
							"description" => __("Product's ID", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Product extends THEMEREX_VC_ShortCodeSingle {}
			
			
				// WooCommerce - Best Selling Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "best_selling_products",
					"name" => __("Best Selling Products", "trx_addons"),
					"description" => __("WooCommerce shortcode: show best selling products", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_best_selling_products',
					"class" => "trx_sc_single trx_sc_best_selling_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => __("Number", "trx_addons"),
							"description" => __("How many products showed", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => __("Columns", "trx_addons"),
							"description" => __("How many columns per row use for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Best_Selling_Products extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Recent Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "recent_products",
					"name" => __("Recent Products", "trx_addons"),
					"description" => __("WooCommerce shortcode: show recent products", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_recent_products',
					"class" => "trx_sc_single trx_sc_recent_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => __("Number", "trx_addons"),
							"description" => __("How many products showed", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => __("Columns", "trx_addons"),
							"description" => __("How many columns per row use for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => __("Order by", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								__('Date', 'trx_addons') => 'date',
								__('Title', 'trx_addons') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => __("Order", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Recent_Products extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Related Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "related_products",
					"name" => __("Related Products", "trx_addons"),
					"description" => __("WooCommerce shortcode: show related products", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_related_products',
					"class" => "trx_sc_single trx_sc_related_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "posts_per_page",
							"heading" => __("Number", "trx_addons"),
							"description" => __("How many products showed", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => __("Columns", "trx_addons"),
							"description" => __("How many columns per row use for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => __("Order by", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								__('Date', 'trx_addons') => 'date',
								__('Title', 'trx_addons') => 'title'
							),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Related_Products extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Featured Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "featured_products",
					"name" => __("Featured Products", "trx_addons"),
					"description" => __("WooCommerce shortcode: show featured products", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_featured_products',
					"class" => "trx_sc_single trx_sc_featured_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => __("Number", "trx_addons"),
							"description" => __("How many products showed", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => __("Columns", "trx_addons"),
							"description" => __("How many columns per row use for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => __("Order by", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								__('Date', 'trx_addons') => 'date',
								__('Title', 'trx_addons') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => __("Order", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Featured_Products extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Top Rated Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "top_rated_products",
					"name" => __("Top Rated Products", "trx_addons"),
					"description" => __("WooCommerce shortcode: show top rated products", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_top_rated_products',
					"class" => "trx_sc_single trx_sc_top_rated_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => __("Number", "trx_addons"),
							"description" => __("How many products showed", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => __("Columns", "trx_addons"),
							"description" => __("How many columns per row use for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => __("Order by", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								__('Date', 'trx_addons') => 'date',
								__('Title', 'trx_addons') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => __("Order", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Top_Rated_Products extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Sale Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "sale_products",
					"name" => __("Sale Products", "trx_addons"),
					"description" => __("WooCommerce shortcode: list products on sale", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_sale_products',
					"class" => "trx_sc_single trx_sc_sale_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => __("Number", "trx_addons"),
							"description" => __("How many products showed", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => __("Columns", "trx_addons"),
							"description" => __("How many columns per row use for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => __("Order by", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								__('Date', 'trx_addons') => 'date',
								__('Title', 'trx_addons') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => __("Order", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Sale_Products extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Product Category
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "product_category",
					"name" => __("Products from category", "trx_addons"),
					"description" => __("WooCommerce shortcode: list products in specified category(-ies)", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_product_category',
					"class" => "trx_sc_single trx_sc_product_category",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => __("Number", "trx_addons"),
							"description" => __("How many products showed", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => __("Columns", "trx_addons"),
							"description" => __("How many columns per row use for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => __("Order by", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								__('Date', 'trx_addons') => 'date',
								__('Title', 'trx_addons') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => __("Order", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						),
						array(
							"param_name" => "category",
							"heading" => __("Categories", "trx_addons"),
							"description" => __("Comma separated category slugs", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "operator",
							"heading" => __("Operator", "trx_addons"),
							"description" => __("Categories operator", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								__('IN', 'trx_addons') => 'IN',
								__('NOT IN', 'trx_addons') => 'NOT IN',
								__('AND', 'trx_addons') => 'AND'
							),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Product_Category extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "products",
					"name" => __("Products", "trx_addons"),
					"description" => __("WooCommerce shortcode: list all products", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_products',
					"class" => "trx_sc_single trx_sc_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "skus",
							"heading" => __("SKUs", "trx_addons"),
							"description" => __("Comma separated SKU codes of products", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "ids",
							"heading" => __("IDs", "trx_addons"),
							"description" => __("Comma separated ID of products", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => __("Columns", "trx_addons"),
							"description" => __("How many columns per row use for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => __("Order by", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								__('Date', 'trx_addons') => 'date',
								__('Title', 'trx_addons') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => __("Order", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Products extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
			
				// WooCommerce - Product Attribute
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "product_attribute",
					"name" => __("Products by Attribute", "trx_addons"),
					"description" => __("WooCommerce shortcode: show products with specified attribute", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_product_attribute',
					"class" => "trx_sc_single trx_sc_product_attribute",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => __("Number", "trx_addons"),
							"description" => __("How many products showed", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => __("Columns", "trx_addons"),
							"description" => __("How many columns per row use for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => __("Order by", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								__('Date', 'trx_addons') => 'date',
								__('Title', 'trx_addons') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => __("Order", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						),
						array(
							"param_name" => "attribute",
							"heading" => __("Attribute", "trx_addons"),
							"description" => __("Attribute name", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "filter",
							"heading" => __("Filter", "trx_addons"),
							"description" => __("Attribute value", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Product_Attribute extends THEMEREX_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Products Categories
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "product_categories",
					"name" => __("Product Categories", "trx_addons"),
					"description" => __("WooCommerce shortcode: show categories with products", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_product_categories',
					"class" => "trx_sc_single trx_sc_product_categories",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "number",
							"heading" => __("Number", "trx_addons"),
							"description" => __("How many categories showed", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => __("Columns", "trx_addons"),
							"description" => __("How many columns per row use for categories output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => __("Order by", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								__('Date', 'trx_addons') => 'date',
								__('Title', 'trx_addons') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => __("Order", "trx_addons"),
							"description" => __("Sorting order for products output", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($THEMEREX_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						),
						array(
							"param_name" => "parent",
							"heading" => __("Parent", "trx_addons"),
							"description" => __("Parent category slug", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "date",
							"type" => "textfield"
						),
						array(
							"param_name" => "ids",
							"heading" => __("IDs", "trx_addons"),
							"description" => __("Comma separated ID of products", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "hide_empty",
							"heading" => __("Hide empty", "trx_addons"),
							"description" => __("Hide empty categories", "trx_addons"),
							"class" => "",
							"value" => array("Hide empty" => "1" ),
							"type" => "checkbox"
						)
					)
				) );
				
				class WPBakeryShortCode_Products_Categories extends THEMEREX_VC_ShortCodeSingle {}
			
				/*
			
				// WooCommerce - Add to cart
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "add_to_cart",
					"name" => __("Add to cart", "trx_addons"),
					"description" => __("WooCommerce shortcode: Display a single product price + cart button", "trx_addons"),
					"category" => __('WooCommerce', 'trx_addons'),
					'icon' => 'icon_trx_add_to_cart',
					"class" => "trx_sc_single trx_sc_add_to_cart",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "id",
							"heading" => __("ID", "trx_addons"),
							"description" => __("Product's ID", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "sku",
							"heading" => __("SKU", "trx_addons"),
							"description" => __("Product's SKU code", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "quantity",
							"heading" => __("Quantity", "trx_addons"),
							"description" => __("How many item add", "trx_addons"),
							"admin_label" => true,
							"class" => "",
							"value" => "1",
							"type" => "textfield"
						),
						array(
							"param_name" => "show_price",
							"heading" => __("Show price", "trx_addons"),
							"description" => __("Show price near button", "trx_addons"),
							"class" => "",
							"value" => array("Show price" => "true" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "class",
							"heading" => __("Class", "trx_addons"),
							"description" => __("CSS class", "trx_addons"),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "style",
							"heading" => __("CSS style", "trx_addons"),
							"description" => __("CSS style for additional decoration", "trx_addons"),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Add_To_Cart extends THEMEREX_VC_ShortCodeSingle {}
				*/
			}

		}
	}
}
?>