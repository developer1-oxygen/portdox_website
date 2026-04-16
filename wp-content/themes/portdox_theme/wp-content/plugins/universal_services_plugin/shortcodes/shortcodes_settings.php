<?php

// Check if shortcodes settings are now used
if ( !function_exists( 'themerex_shortcodes_is_used' ) ) {
	function themerex_shortcodes_is_used() {
		return themerex_options_is_used() 															// All modes when Theme Options are used
			|| (is_admin() && isset($_POST['action']) 
					&& in_array($_POST['action'], array('vc_edit_form', 'wpb_show_edit_form')))		// AJAX query when save post/page
			|| themerex_vc_is_frontend();															// VC Frontend editor mode
	}
}

// Width and height params
if ( !function_exists( 'themerex_shortcodes_width' ) ) {
	function themerex_shortcodes_width($w="") {
		return array(
			"title" => __("Width", "trx_addons"),
			"divider" => true,
			"value" => $w,
			"type" => "text"
		);
	}
}
if ( !function_exists( 'themerex_shortcodes_height' ) ) {
	function themerex_shortcodes_height($h='') {
		return array(
			"title" => __("Height", "trx_addons"),
			"desc" => __("Width (in pixels or percent) and height (only in pixels) of element", "trx_addons"),
			"value" => $h,
			"type" => "text"
		);
	}
}

/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_shortcodes_settings_theme_setup' ) ) {
//	if ( themerex_vc_is_frontend() )
	if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') || (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline') )
		add_action( 'themerex_action_before_init_theme', 'themerex_shortcodes_settings_theme_setup', 20 );
	else
		add_action( 'themerex_action_after_init_theme', 'themerex_shortcodes_settings_theme_setup' );
	function themerex_shortcodes_settings_theme_setup() {
		if (themerex_shortcodes_is_used()) {
			global $THEMEREX_GLOBALS;

			// Prepare arrays 
			$THEMEREX_GLOBALS['sc_params'] = array(
			
				// Current element id
				'id' => array(
					"title" => __("Element ID", "trx_addons"),
					"desc" => __("ID for current element", "trx_addons"),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
			
				// Current element class
				'class' => array(
					"title" => __("Element CSS class", "trx_addons"),
					"desc" => __("CSS class for current element (optional)", "trx_addons"),
					"value" => "",
					"type" => "text"
				),
			
				// Current element style
				'css' => array(
					"title" => __("CSS styles", "trx_addons"),
					"desc" => __("Any additional CSS rules (if need)", "trx_addons"),
					"value" => "",
					"type" => "text"
				),
			
				// Margins params
				'top' => array(
					"title" => __("Top margin", "trx_addons"),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
			
				'bottom' => array(
					"title" => __("Bottom margin", "trx_addons"),
					"value" => "",
					"type" => "text"
				),
			
				'left' => array(
					"title" => __("Left margin", "trx_addons"),
					"value" => "",
					"type" => "text"
				),
			
				'right' => array(
					"title" => __("Right margin", "trx_addons"),
					"desc" => __("Margins around list (in pixels).", "trx_addons"),
					"value" => "",
					"type" => "text"
				),
			
				// Switcher choises
				'list_styles' => array(
					'ul'	=> __('Unordered', 'trx_addons'),
					'ol'	=> __('Ordered', 'trx_addons'),
					'iconed'=> __('Iconed', 'trx_addons')
				),
				'yes_no'	=> themerex_get_list_yesno(),
				'on_off'	=> themerex_get_list_onoff(),
				'dir' 		=> themerex_get_list_directions(),
				'align'		=> themerex_get_list_alignments(),
				'float'		=> themerex_get_list_floats(),
				'show_hide'	=> themerex_get_list_showhide(),
				'sorting' 	=> themerex_get_list_sortings(),
				'ordering' 	=> themerex_get_list_orderings(),
				'sliders'	=> themerex_get_list_sliders(),
				'users'		=> themerex_get_list_users(),
				'members'	=> themerex_get_list_posts(false, array('post_type'=>'team', 'orderby'=>'title', 'order'=>'asc', 'return'=>'title')),
                'categories'=> is_admin() && themerex_get_value_gp('action')=='vc_edit_form' && substr(themerex_get_value_gp('tag'), 0, 4)=='trx_' && isset($_POST['params']['post_type']) && $_POST['params']['post_type']!='post'
                    ? themerex_get_list_terms(false, themerex_get_taxonomy_categories_by_post_type($_POST['params']['post_type']))
                    : themerex_get_list_categories(),
				'testimonials_groups'=> themerex_get_list_terms(false, 'testimonial_group'),
				'team_groups'=> themerex_get_list_terms(false, 'team_group'),
				'columns'	=> themerex_get_list_columns(),
				'images'	=> array_merge(array('none'=>"none"), themerex_get_list_files("images/icons", "png")),
				'icons'		=> array_merge(array("inherit", "none"), themerex_get_list_icons()),
				'locations'	=> themerex_get_list_dedicated_locations(),
				'filters'	=> themerex_get_list_portfolio_filters(),
				'formats'	=> themerex_get_list_post_formats_filters(),
				'hovers'	=> themerex_get_list_hovers(),
				'hovers_dir'=> themerex_get_list_hovers_directions(),
				'tint'		=> themerex_get_list_bg_tints(),
				'animations'=> themerex_get_list_animations_in(),
				'blogger_styles'	=> themerex_get_list_templates_blogger(),
				'posts_types'		=> themerex_get_list_posts_types(),
				'button_styles'		=> themerex_get_list_button_styles(),
				'googlemap_styles'	=> themerex_get_list_googlemap_styles(),
				'field_types'		=> themerex_get_list_field_types(),
				'label_positions'	=> themerex_get_list_label_positions(),
				'sidebar'	=> themerex_get_list_sidebars()
			);
			$THEMEREX_GLOBALS['sc_params']['animation'] = array(
				"title" => __("Animation",  'trx_addons'),
				"desc" => __('Select animation while object enter in the visible area of page',  'trx_addons'),
				"value" => "none",
				"type" => "select",
				"options" => $THEMEREX_GLOBALS['sc_params']['animations']
			);
	
			// Shortcodes list
			//------------------------------------------------------------------
			$THEMEREX_GLOBALS['shortcodes'] = array(
			
				// Accordion
				"trx_accordion" => array(
					"title" => __("Accordion", "trx_addons"),
					"desc" => __("Accordion items", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Accordion style", "trx_addons"),
							"desc" => __("Select style for display accordion", "trx_addons"),
							"value" => 1,
							"options" => array(
								1 => __('Style 1', 'trx_addons'),
								2 => __('Style 2', 'trx_addons')
							),
							"type" => "radio"
						),
						"initial" => array(
							"title" => __("Initially opened item", "trx_addons"),
							"desc" => __("Number of initially opened item", "trx_addons"),
							"value" => 1,
							"min" => 0,
							"type" => "spinner"
						),
						"icon_closed" => array(
							"title" => __("Icon while closed",  'trx_addons'),
							"desc" => __('Select icon for the closed accordion item from Fontello icons set',  'trx_addons'),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"icon_opened" => array(
							"title" => __("Icon while opened",  'trx_addons'),
							"desc" => __('Select icon for the opened accordion item from Fontello icons set',  'trx_addons'),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_accordion_item",
						"title" => __("Item", "trx_addons"),
						"desc" => __("Accordion item", "trx_addons"),
						"container" => true,
						"params" => array(
							"title" => array(
								"title" => __("Accordion item title", "trx_addons"),
								"desc" => __("Title for current accordion item", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"icon_closed" => array(
								"title" => __("Icon while closed",  'trx_addons'),
								"desc" => __('Select icon for the closed accordion item from Fontello icons set',  'trx_addons'),
								"value" => "",
								"type" => "icons",
								"options" => $THEMEREX_GLOBALS['sc_params']['icons']
							),
							"icon_opened" => array(
								"title" => __("Icon while opened",  'trx_addons'),
								"desc" => __('Select icon for the opened accordion item from Fontello icons set',  'trx_addons'),
								"value" => "",
								"type" => "icons",
								"options" => $THEMEREX_GLOBALS['sc_params']['icons']
							),
							"_content_" => array(
								"title" => __("Accordion item content", "trx_addons"),
								"desc" => __("Current accordion item content", "trx_addons"),
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $THEMEREX_GLOBALS['sc_params']['id'],
							"class" => $THEMEREX_GLOBALS['sc_params']['class'],
							"css" => $THEMEREX_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Anchor
				"trx_anchor" => array(
					"title" => __("Anchor", "trx_addons"),
					"desc" => __("Insert anchor for the TOC (table of content)", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"icon" => array(
							"title" => __("Anchor's icon",  'trx_addons'),
							"desc" => __('Select icon for the anchor from Fontello icons set',  'trx_addons'),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"title" => array(
							"title" => __("Short title", "trx_addons"),
							"desc" => __("Short title of the anchor (for the table of content)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => __("Long description", "trx_addons"),
							"desc" => __("Description for the popup (then hover on the icon). You can use '{' and '}' - make the text italic, '|' - insert line break", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"url" => array(
							"title" => __("External URL", "trx_addons"),
							"desc" => __("External URL for this TOC item", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"separator" => array(
							"title" => __("Add separator", "trx_addons"),
							"desc" => __("Add separator under item in the TOC", "trx_addons"),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"id" => $THEMEREX_GLOBALS['sc_params']['id']
					)
				),
			
			
				// Audio
				"trx_audio" => array(
					"title" => __("Audio", "trx_addons"),
					"desc" => __("Insert audio player", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"url" => array(
							"title" => __("URL for audio file", "trx_addons"),
							"desc" => __("URL for audio file", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media",
							"before" => array(
								'title' => __('Choose audio', 'trx_addons'),
								'action' => 'media_upload',
								'type' => 'audio',
								'multiple' => false,
								'linked_field' => '',
								'captions' => array( 	
									'choose' => __('Choose audio file', 'trx_addons'),
									'update' => __('Select audio file', 'trx_addons')
								)
							),
							"after" => array(
								'icon' => 'icon-cancel',
								'action' => 'media_reset'
							)
						),
						"image" => array(
							"title" => __("Cover image", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site for audio cover", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"title" => array(
							"title" => __("Title", "trx_addons"),
							"desc" => __("Title of the audio file", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"author" => array(
							"title" => __("Author", "trx_addons"),
							"desc" => __("Author of the audio file", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"controls" => array(
							"title" => __("Show controls", "trx_addons"),
							"desc" => __("Show controls in audio player", "trx_addons"),
							"divider" => true,
							"size" => "medium",
							"value" => "show",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['show_hide']
						),
						"autoplay" => array(
							"title" => __("Autoplay audio", "trx_addons"),
							"desc" => __("Autoplay audio on page load", "trx_addons"),
							"value" => "off",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['on_off']
						),
						"align" => array(
							"title" => __("Align", "trx_addons"),
							"desc" => __("Select block alignment", "trx_addons"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Block
				"trx_block" => array(
					"title" => __("Block container", "trx_addons"),
					"desc" => __("Container for any block ([section] analog - to enable nesting)", "trx_addons"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"dedicated" => array(
							"title" => __("Dedicated", "trx_addons"),
							"desc" => __("Use this block as dedicated content - show it before post title on single page", "trx_addons"),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"align" => array(
							"title" => __("Align", "trx_addons"),
							"desc" => __("Select block alignment", "trx_addons"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						),
						"columns" => array(
							"title" => __("Columns emulation", "trx_addons"),
							"desc" => __("Select width for columns emulation", "trx_addons"),
							"value" => "none",
							"type" => "checklist",
							"options" => $THEMEREX_GLOBALS['sc_params']['columns']
						), 
						"pan" => array(
							"title" => __("Use pan effect", "trx_addons"),
							"desc" => __("Use pan effect to show section content", "trx_addons"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"scroll" => array(
							"title" => __("Use scroller", "trx_addons"),
							"desc" => __("Use scroller to show section content", "trx_addons"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"scroll_dir" => array(
							"title" => __("Scroll direction", "trx_addons"),
							"desc" => __("Scroll direction (if Use scroller = yes)", "trx_addons"),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "horizontal",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['dir']
						),
						"scroll_controls" => array(
							"title" => __("Scroll controls", "trx_addons"),
							"desc" => __("Show scroll controls (if Use scroller = yes)", "trx_addons"),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"color" => array(
							"title" => __("Fore color", "trx_addons"),
							"desc" => __("Any color for objects in this section", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_tint" => array(
							"title" => __("Background tint", "trx_addons"),
							"desc" => __("Main background tint: dark or light", "trx_addons"),
							"value" => "",
							"type" => "checklist",
							"options" => $THEMEREX_GLOBALS['sc_params']['tint']
						),
						"bg_color" => array(
							"title" => __("Background color", "trx_addons"),
							"desc" => __("Any background color for this section", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => __("Background image URL", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site for the background", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => __("Overlay", "trx_addons"),
							"desc" => __("Overlay color opacity (from 0.0 to 1.0)", "trx_addons"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => __("Texture", "trx_addons"),
							"desc" => __("Predefined texture style from 1 to 11. 0 - without texture.", "trx_addons"),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"font_size" => array(
							"title" => __("Font size", "trx_addons"),
							"desc" => __("Font size of the text (default - in pixels, allows any CSS units of measure)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"font_weight" => array(
							"title" => __("Font weight", "trx_addons"),
							"desc" => __("Font weight of the text", "trx_addons"),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'100' => __('Thin (100)', 'trx_addons'),
								'300' => __('Light (300)', 'trx_addons'),
								'400' => __('Normal (400)', 'trx_addons'),
								'700' => __('Bold (700)', 'trx_addons')
							)
						),
						"_content_" => array(
							"title" => __("Container content", "trx_addons"),
							"desc" => __("Content for section container", "trx_addons"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Blogger
				"trx_blogger" => array(
					"title" => __("Blogger", "trx_addons"),
					"desc" => __("Insert posts (pages) in many styles from desired categories or directly from ids", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Posts output style", "trx_addons"),
							"desc" => __("Select desired style for posts output", "trx_addons"),
							"value" => "regular",
							"type" => "select",
							"options" => $THEMEREX_GLOBALS['sc_params']['blogger_styles']
						),
						"filters" => array(
							"title" => __("Show filters", "trx_addons"),
							"desc" => __("Use post's tags or categories as filter buttons", "trx_addons"),
							"value" => "no",
							"dir" => "horizontal",
							"type" => "checklist",
							"options" => $THEMEREX_GLOBALS['sc_params']['filters']
						),
						"dir" => array(
							"title" => __("Posts direction", "trx_addons"),
							"desc" => __("Display posts in horizontal or vertical direction", "trx_addons"),
							"value" => "horizontal",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['dir']
						),
						"post_type" => array(
							"title" => __("Post type", "trx_addons"),
							"desc" => __("Select post type to show", "trx_addons"),
							"value" => "post",
							"type" => "select",
							"options" => $THEMEREX_GLOBALS['sc_params']['posts_types']
						),
						"ids" => array(
							"title" => __("Post IDs list", "trx_addons"),
							"desc" => __("Comma separated list of posts ID. If set - parameters above are ignored!", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"cat" => array(
							"title" => __("Categories list", "trx_addons"),
							"desc" => __("Select the desired categories. If not selected - show posts from any category or from IDs list", "trx_addons"),
							"dependency" => array(
								'ids' => array('is_empty'),
								'post_type' => array('refresh')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => $THEMEREX_GLOBALS['sc_params']['categories']
						),
						"count" => array(
							"title" => __("Total posts to show", "trx_addons"),
							"desc" => __("How many posts will be displayed? If used IDs - this parameter ignored.", "trx_addons"),
							"dependency" => array(
								'ids' => array('is_empty')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns number", "trx_addons"),
							"desc" => __("How many columns used to show posts? If empty or 0 - equal to posts number", "trx_addons"),
							"dependency" => array(
								'dir' => array('horizontal')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => __("Offset before select posts", "trx_addons"),
							"desc" => __("Skip posts before select next part.", "trx_addons"),
							"dependency" => array(
								'ids' => array('is_empty')
							),
							"value" => 0,
							"min" => 0,
							"max" => 100,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Post order by", "trx_addons"),
							"desc" => __("Select desired posts sorting method", "trx_addons"),
							"value" => "date",
							"type" => "select",
							"options" => $THEMEREX_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => __("Post order", "trx_addons"),
							"desc" => __("Select desired posts order", "trx_addons"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						),
						"only" => array(
							"title" => __("Select posts only", "trx_addons"),
							"desc" => __("Select posts only with reviews, videos, audios, thumbs or galleries", "trx_addons"),
							"value" => "no",
							"type" => "select",
							"options" => $THEMEREX_GLOBALS['sc_params']['formats']
						),
						"scroll" => array(
							"title" => __("Use scroller", "trx_addons"),
							"desc" => __("Use scroller to show all posts", "trx_addons"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"controls" => array(
							"title" => __("Show slider controls", "trx_addons"),
							"desc" => __("Show arrows to control scroll slider", "trx_addons"),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"location" => array(
							"title" => __("Dedicated content location", "trx_addons"),
							"desc" => __("Select position for dedicated content (only for style=excerpt)", "trx_addons"),
							"divider" => true,
							"dependency" => array(
								'style' => array('excerpt')
							),
							"value" => "default",
							"type" => "select",
							"options" => $THEMEREX_GLOBALS['sc_params']['locations']
						),
						"rating" => array(
							"title" => __("Show rating stars", "trx_addons"),
							"desc" => __("Show rating stars under post's header", "trx_addons"),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"info" => array(
							"title" => __("Show post info block", "trx_addons"),
							"desc" => __("Show post info block (author, date, tags, etc.)", "trx_addons"),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"links" => array(
							"title" => __("Allow links on the post", "trx_addons"),
							"desc" => __("Allow links on the post from each blogger item", "trx_addons"),
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"descr" => array(
							"title" => __("Description length", "trx_addons"),
							"desc" => __("How many characters are displayed from post excerpt? If 0 - don't show description", "trx_addons"),
							"value" => 0,
							"min" => 0,
							"step" => 10,
							"type" => "spinner"
						),
						"readmore" => array(
							"title" => __("More link text", "trx_addons"),
							"desc" => __("Read more link text. If empty - show 'More', else - used as link text", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Br
				"trx_br" => array(
					"title" => __("Break", "trx_addons"),
					"desc" => __("Line break with clear floating (if need)", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"clear" => 	array(
							"title" => __("Clear floating", "trx_addons"),
							"desc" => __("Clear floating (if need)", "trx_addons"),
							"value" => "",
							"type" => "checklist",
							"options" => array(
								'none' => __('None', 'trx_addons'),
								'left' => __('Left', 'trx_addons'),
								'right' => __('Right', 'trx_addons'),
								'both' => __('Both', 'trx_addons')
							)
						)
					)
				),
			
			
			
			
				// Button
				"trx_button" => array(
					"title" => __("Button", "trx_addons"),
					"desc" => __("Button with link", "trx_addons"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => __("Caption", "trx_addons"),
							"desc" => __("Button caption", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"type" => array(
							"title" => __("Button's shape", "trx_addons"),
							"desc" => __("Select button's shape", "trx_addons"),
							"value" => "square",
							"size" => "medium",
							"options" => array(
								'square' => __('Square', 'trx_addons'),
								'round' => __('Round', 'trx_addons')
							),
							"type" => "switch"
						),
						"icon" => array(
							"title" => __("Button's icon",  'trx_addons'),
							"desc" => __('Select icon for the title from Fontello icons set',  'trx_addons'),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"bg_style" => array(
							"title" => __("Button's color scheme", "trx_addons"),
							"desc" => __("Select button's color scheme", "trx_addons"),
							"value" => "custom",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['button_styles']
						), 
						"color" => array(
							"title" => __("Button's text color", "trx_addons"),
							"desc" => __("Any color for button's caption", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => __("Button's backcolor", "trx_addons"),
							"desc" => __("Any color for button's background", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"align" => array(
							"title" => __("Button's alignment", "trx_addons"),
							"desc" => __("Align button to left, center or right", "trx_addons"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						), 
						"link" => array(
							"title" => __("Link URL", "trx_addons"),
							"desc" => __("URL for link on button click", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"target" => array(
							"title" => __("Link target", "trx_addons"),
							"desc" => __("Target for link on button click", "trx_addons"),
							"dependency" => array(
								'link' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"popup" => array(
							"title" => __("Open link in popup", "trx_addons"),
							"desc" => __("Open link target in popup window", "trx_addons"),
							"dependency" => array(
								'link' => array('not_empty')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						), 
						"rel" => array(
							"title" => __("Rel attribute", "trx_addons"),
							"desc" => __("Rel attribute for button's link (if need)", "trx_addons"),
							"dependency" => array(
								'link' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Chat
				"trx_chat" => array(
					"title" => __("Chat", "trx_addons"),
					"desc" => __("Chat message", "trx_addons"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"title" => array(
							"title" => __("Item title", "trx_addons"),
							"desc" => __("Chat item title", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"photo" => array(
							"title" => __("Item photo", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site for the item photo (avatar)", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"link" => array(
							"title" => __("Item link", "trx_addons"),
							"desc" => __("Chat item link", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"_content_" => array(
							"title" => __("Chat item content", "trx_addons"),
							"desc" => __("Current chat item content", "trx_addons"),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
				// Columns
				"trx_columns" => array(
					"title" => __("Columns", "trx_addons"),
					"desc" => __("Insert up to 5 columns in your page (post)", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"autoheight" => array(
							"title" => __("Auto Height", "trx_addons"),
							"desc" => __("Fit height to the larger value of child elements (for background images)", "trx_addons"),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"indentation" => array(
							"title" => __("Indentation", "trx_addons"),
							"desc" => __("Column is indented", "trx_addons"),
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"fluid" => array(
							"title" => __("Fluid columns", "trx_addons"),
							"desc" => __("To squeeze the columns when reducing the size of the window (fluid=yes) or to rebuild them (fluid=no)", "trx_addons"),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						), 
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_column_item",
						"title" => __("Column", "trx_addons"),
						"desc" => __("Column item", "trx_addons"),
						"container" => true,
						"params" => array(
							"span" => array(
								"title" => __("Merge columns", "trx_addons"),
								"desc" => __("Count merged columns from current", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"align" => array(
								"title" => __("Alignment", "trx_addons"),
								"desc" => __("Alignment text in the column", "trx_addons"),
								"value" => "",
								"type" => "checklist",
								"dir" => "horizontal",
								"options" => $THEMEREX_GLOBALS['sc_params']['align']
							),
							"color" => array(
								"title" => __("Fore color", "trx_addons"),
								"desc" => __("Any color for objects in this column", "trx_addons"),
								"value" => "",
								"type" => "color"
							),
							"bg_color" => array(
								"title" => __("Background color", "trx_addons"),
								"desc" => __("Any background color for this column", "trx_addons"),
								"value" => "",
								"type" => "color"
							),
							"bg_image" => array(
								"title" => __("URL for background image file", "trx_addons"),
								"desc" => __("Select or upload image or write URL from other site for the background", "trx_addons"),
								"readonly" => false,
								"value" => "",
								"type" => "media"
							),
							"_content_" => array(
								"title" => __("Column item content", "trx_addons"),
								"desc" => __("Current column item content", "trx_addons"),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $THEMEREX_GLOBALS['sc_params']['id'],
							"class" => $THEMEREX_GLOBALS['sc_params']['class'],
							"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
							"css" => $THEMEREX_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Contact form
				"trx_contact_form" => array(
					"title" => __("Contact form", "trx_addons"),
					"desc" => __("Insert contact form", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"custom" => array(
							"title" => __("Custom", "trx_addons"),
							"desc" => __("Use custom fields or create standard contact form (ignore info from 'Field' tabs)", "trx_addons"),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"style" => array(
							"title" => __("Style", "trx_addons"),
							"desc" => __("Contact form style", "trx_addons"),
							"value" => "standard",
							"type" => "checklist",
							"options" => array(
								'standard_light' => __('Standard (light)', 'trx_addons'),
								'standard' => __('Standard (dark)', 'trx_addons'),
								'topic' => __('Topic', 'trx_addons')
							)
						),
						"action" => array(
							"title" => __("Action", "trx_addons"),
							"desc" => __("Contact form action (URL to handle form data). If empty - use internal action", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => __("Align", "trx_addons"),
							"desc" => __("Select form alignment", "trx_addons"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						),
						"title" => array(
							"title" => __("Title", "trx_addons"),
							"desc" => __("Title for the block", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => __("Subtitle", "trx_addons"),
							"desc" => __("Subtitle for the block", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => __("Description", "trx_addons"),
							"desc" => __("Short description for contact form", "trx_addons"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => themerex_shortcodes_width(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_form_item",
						"title" => __("Field", "trx_addons"),
						"desc" => __("Custom field", "trx_addons"),
						"container" => false,
						"params" => array(
							"type" => array(
								"title" => __("Type", "trx_addons"),
								"desc" => __("Type of the custom field", "trx_addons"),
								"value" => "text",
								"type" => "checklist",
								"dir" => "horizontal",
								"options" => $THEMEREX_GLOBALS['sc_params']['field_types']
							), 
							"name" => array(
								"title" => __("Name", "trx_addons"),
								"desc" => __("Name of the custom field", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"value" => array(
								"title" => __("Default value", "trx_addons"),
								"desc" => __("Default value of the custom field", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"label" => array(
								"title" => __("Label", "trx_addons"),
								"desc" => __("Label for the custom field", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"label_position" => array(
								"title" => __("Label position", "trx_addons"),
								"desc" => __("Label position relative to the field", "trx_addons"),
								"value" => "top",
								"type" => "checklist",
								"dir" => "horizontal",
								"options" => $THEMEREX_GLOBALS['sc_params']['label_positions']
							), 
							"top" => $THEMEREX_GLOBALS['sc_params']['top'],
							"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
							"left" => $THEMEREX_GLOBALS['sc_params']['left'],
							"right" => $THEMEREX_GLOBALS['sc_params']['right'],
							"id" => $THEMEREX_GLOBALS['sc_params']['id'],
							"class" => $THEMEREX_GLOBALS['sc_params']['class'],
							"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
							"css" => $THEMEREX_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Content block on fullscreen page
				"trx_content" => array(
					"title" => __("Content block", "trx_addons"),
					"desc" => __("Container for main content block with desired class and style (use it only on fullscreen pages)", "trx_addons"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"font_size" => array(
							"title" => __("Font size", "trx_addons"),
							"desc" => __("Font size of the text (default - in pixels, allows any CSS units of measure)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"font_weight" => array(
							"title" => __("Font weight", "trx_addons"),
							"desc" => __("Font weight of the text", "trx_addons"),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'100' => __('Thin (100)', 'trx_addons'),
								'300' => __('Light (300)', 'trx_addons'),
								'400' => __('Normal (400)', 'trx_addons'),
								'700' => __('Bold (700)', 'trx_addons')
							)
						),
						"title" => array(
							"title" => __("Title", "trx_addons"),
							"desc" => __("Container title", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"color" => array(
							"title" => __("Color", "trx_addons"),
							"desc" => __("Title color", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"_content_" => array(
							"title" => __("Container content", "trx_addons"),
							"desc" => __("Content for section container", "trx_addons"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Countdown
				"trx_countdown" => array(
					"title" => __("Countdown", "trx_addons"),
					"desc" => __("Insert countdown object", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"date" => array(
							"title" => __("Date", "trx_addons"),
							"desc" => __("Upcoming date (format: yyyy-mm-dd)", "trx_addons"),
							"value" => "",
							"format" => "yy-mm-dd",
							"type" => "date"
						),
						"time" => array(
							"title" => __("Time", "trx_addons"),
							"desc" => __("Upcoming time (format: HH:mm:ss)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"style" => array(
							"title" => __("Style", "trx_addons"),
							"desc" => __("Countdown style", "trx_addons"),
							"value" => "1",
							"type" => "checklist",
							"options" => array(
								1 => __('Style 1', 'trx_addons'),
								2 => __('Style 2', 'trx_addons')
							)
						),
						"align" => array(
							"title" => __("Alignment", "trx_addons"),
							"desc" => __("Align counter to left, center or right", "trx_addons"),
							"divider" => true,
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						), 
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Dropcaps
				"trx_dropcaps" => array(
					"title" => __("Dropcaps", "trx_addons"),
					"desc" => __("Make first letter as dropcaps", "trx_addons"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"style" => array(
							"title" => __("Style", "trx_addons"),
							"desc" => __("Dropcaps style", "trx_addons"),
							"value" => "1",
							"type" => "checklist",
							"options" => array(
								1 => __('Style 1', 'trx_addons'),
								2 => __('Style 2', 'trx_addons'),
								3 => __('Style 3', 'trx_addons'),
								4 => __('Style 4', 'trx_addons')
							)
						),
						"_content_" => array(
							"title" => __("Paragraph content", "trx_addons"),
							"desc" => __("Paragraph with dropcaps content", "trx_addons"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Emailer
				"trx_emailer" => array(
					"title" => __("E-mail collector", "trx_addons"),
					"desc" => __("Collect the e-mail address into specified group", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"group" => array(
							"title" => __("Group", "trx_addons"),
							"desc" => __("The name of group to collect e-mail address", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"open" => array(
							"title" => __("Open", "trx_addons"),
							"desc" => __("Initially open the input field on show object", "trx_addons"),
							"divider" => true,
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"align" => array(
							"title" => __("Alignment", "trx_addons"),
							"desc" => __("Align object to left, center or right", "trx_addons"),
							"divider" => true,
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),




				// Gallery
				"trx_gallery" => array(
					"title" => __("Gallery", "trx_addons"),
					"desc" => __("Insert gallery into your post (page)", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"cat" => array(
							"title" => __("Category list", "trx_addons"),
							"desc" => __("Comma separated list of category slugs. If empty - select posts from any category or from IDs list", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => $THEMEREX_GLOBALS['sc_params']['categories']
						),
						"count" => array(
							"title" => __("Number of posts", "trx_addons"),
							"desc" => __("How many posts will be displayed? If used IDs - this parameter ignored.", "trx_addons"),
							"value" => 10,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => __("Offset before select posts", "trx_addons"),
							"desc" => __("Skip posts before select next part.", "trx_addons"),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Post order by", "trx_addons"),
							"desc" => __("Select desired posts sorting method", "trx_addons"),
							"value" => "date",
							"type" => "select",
							"options" => $THEMEREX_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => __("Post order", "trx_addons"),
							"desc" => __("Select desired posts order", "trx_addons"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						),
						"ids" => array(
							"title" => __("Post IDs list", "trx_addons"),
							"desc" => __("Comma separated list of posts ID. If set - parameters above are ignored!", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"descriptions" => array(
							"title" => __("Post descriptions", "trx_addons"),
							"desc" => __("Show post's excerpt max length (characters)", "trx_addons"),
							"value" => 100,
							"min" => 0,
							"max" => 1000,
							"step" => 10,
							"type" => "spinner"
						),
						"bg_color" => array(
							"title" => __("Background color", "trx_addons"),
							"desc" => __("Select color for gallery background", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => __("Background image", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site for the gallery background", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation']
					)
				),



			
				// Gap
				"trx_gap" => array(
					"title" => __("Gap", "trx_addons"),
					"desc" => __("Insert gap (fullwidth area) in the post content. Attention! Use the gap only in the posts (pages) without left or right sidebar", "trx_addons"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => __("Gap content", "trx_addons"),
							"desc" => __("Gap inner content", "trx_addons"),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						)
					)
				),
			





				// Google map
				"trx_googlemap" => array(
					"title" => __("Google map", "trx_addons"),
					"desc" => __("Insert Google map with specified markers", "trx_addons"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"zoom" => array(
							"title" => __("Zoom", "trx_addons"),
							"desc" => __("Map zoom factor", "trx_addons"),
							"divider" => true,
							"value" => 16,
							"min" => 1,
							"max" => 20,
							"type" => "spinner"
						),
						"style" => array(
							"title" => __("Map style", "trx_addons"),
							"desc" => __("Select map style", "trx_addons"),
							"value" => "default",
							"type" => "checklist",
							"options" => $THEMEREX_GLOBALS['sc_params']['googlemap_styles']
						),
						"width" => themerex_shortcodes_width('100%'),
						"height" => themerex_shortcodes_height(240),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_googlemap_marker",
						"title" => __("Google map marker", "trx_addons"),
						"desc" => __("Google map marker", "trx_addons"),
						"decorate" => false,
						"container" => true,
						"params" => array(
							"address" => array(
								"title" => __("Address", "trx_addons"),
								"desc" => __("Address of this marker", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"latlng" => array(
								"title" => __("Latitude and Longtitude", "trx_addons"),
								"desc" => __("Comma separated marker's coorditanes (instead Address)", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"point" => array(
								"title" => __("URL for marker image file", "trx_addons"),
								"desc" => __("Select or upload image or write URL from other site for this marker. If empty - use default marker", "trx_addons"),
								"readonly" => false,
								"value" => "",
								"type" => "media"
							),
							"title" => array(
								"title" => __("Title", "trx_addons"),
								"desc" => __("Title for this marker", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"_content_" => array(
								"title" => __("Description", "trx_addons"),
								"desc" => __("Description for this marker", "trx_addons"),
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $THEMEREX_GLOBALS['sc_params']['id']
						)
					)
				),
			
			
			
				// Hide or show any block
				"trx_hide" => array(
					"title" => __("Hide/Show any block", "trx_addons"),
					"desc" => __("Hide or Show any block with desired CSS-selector", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"selector" => array(
							"title" => __("Selector", "trx_addons"),
							"desc" => __("Any block's CSS-selector", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"hide" => array(
							"title" => __("Hide or Show", "trx_addons"),
							"desc" => __("New state for the block: hide or show", "trx_addons"),
							"value" => "yes",
							"size" => "small",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no'],
							"type" => "switch"
						)
					)
				),
			
			
			
				// Highlght text
				"trx_highlight" => array(
					"title" => __("Highlight text", "trx_addons"),
					"desc" => __("Highlight text with selected color, background color and other styles", "trx_addons"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"type" => array(
							"title" => __("Type", "trx_addons"),
							"desc" => __("Highlight type", "trx_addons"),
							"value" => "1",
							"type" => "checklist",
							"options" => array(
								0 => __('Custom', 'trx_addons'),
								1 => __('Type 1', 'trx_addons'),
								2 => __('Type 2', 'trx_addons'),
								3 => __('Type 3', 'trx_addons')
							)
						),
						"color" => array(
							"title" => __("Color", "trx_addons"),
							"desc" => __("Color for the highlighted text", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => __("Background color", "trx_addons"),
							"desc" => __("Background color for the highlighted text", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"font_size" => array(
							"title" => __("Font size", "trx_addons"),
							"desc" => __("Font size of the highlighted text (default - in pixels, allows any CSS units of measure)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"_content_" => array(
							"title" => __("Highlighting content", "trx_addons"),
							"desc" => __("Content for highlight", "trx_addons"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Icon
				"trx_icon" => array(
					"title" => __("Icon", "trx_addons"),
					"desc" => __("Insert icon", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"icon" => array(
							"title" => __('Icon',  'trx_addons'),
							"desc" => __('Select font icon from the Fontello icons set',  'trx_addons'),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"color" => array(
							"title" => __("Icon's color", "trx_addons"),
							"desc" => __("Icon's color", "trx_addons"),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "color"
						),
						"bg_shape" => array(
							"title" => __("Background shape", "trx_addons"),
							"desc" => __("Shape of the icon background", "trx_addons"),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "none",
							"type" => "radio",
							"options" => array(
								'none' => __('None', 'trx_addons'),
								'round' => __('Round', 'trx_addons'),
								'square' => __('Square', 'trx_addons')
							)
						),
						/*
						"bg_color" => array(
							"title" => __("Icon's background color", "trx_addons"),
							"desc" => __("Icon's background color", "trx_addons"),
							"dependency" => array(
								'icon' => array('not_empty'),
								'background' => array('round','square')
							),
							"value" => "",
							"type" => "color"
						),
						*/
						"title" => array(
							"title" => __("Icon title", "trx_addons"),
							"desc" => __("Icon title (for large size)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"font_size" => array(
							"title" => __("Font size", "trx_addons"),
							"desc" => __("Icon's font size", "trx_addons"),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "spinner",
							"min" => 8,
							"max" => 240
						),
						"font_weight" => array(
							"title" => __("Font weight", "trx_addons"),
							"desc" => __("Icon font weight", "trx_addons"),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'100' => __('Thin (100)', 'trx_addons'),
								'300' => __('Light (300)', 'trx_addons'),
								'400' => __('Normal (400)', 'trx_addons'),
								'700' => __('Bold (700)', 'trx_addons')
							)
						),
						"align" => array(
							"title" => __("Alignment", "trx_addons"),
							"desc" => __("Icon text alignment", "trx_addons"),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						), 
						"link" => array(
							"title" => __("Link URL", "trx_addons"),
							"desc" => __("Link URL from this icon (if not empty)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Image
				"trx_image" => array(
					"title" => __("Image", "trx_addons"),
					"desc" => __("Insert image into your post (page)", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"url" => array(
							"title" => __("URL for image file", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"title" => array(
							"title" => __("Title", "trx_addons"),
							"desc" => __("Image title (if need)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"icon" => array(
							"title" => __("Icon before title",  'trx_addons'),
							"desc" => __('Select icon for the title from Fontello icons set',  'trx_addons'),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"align" => array(
							"title" => __("Float image", "trx_addons"),
							"desc" => __("Float image to left or right side", "trx_addons"),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['float']
						), 
						"shape" => array(
							"title" => __("Image Shape", "trx_addons"),
							"desc" => __("Shape of the image: square (rectangle) or round", "trx_addons"),
							"value" => "square",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								"square" => __('Square', 'trx_addons'),
								"round" => __('Round', 'trx_addons')
							)
						),
						"link" => array(
							"title" => __("Link URL", "trx_addons"),
							"desc" => __("Link URL for the title", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Infobox
				"trx_infobox" => array(
					"title" => __("Infobox", "trx_addons"),
					"desc" => __("Insert infobox into your post (page)", "trx_addons"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"style" => array(
							"title" => __("Style", "trx_addons"),
							"desc" => __("Infobox style", "trx_addons"),
							"value" => "regular",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'regular' => __('Regular', 'trx_addons'),
								'info' => __('Info', 'trx_addons'),
								'success' => __('Success', 'trx_addons'),
								'error' => __('Error', 'trx_addons')
							)
						),
						"closeable" => array(
							"title" => __("Closeable box", "trx_addons"),
							"desc" => __("Create closeable box (with close button)", "trx_addons"),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"icon" => array(
							"title" => __("Custom icon",  'trx_addons'),
							"desc" => __('Select icon for the infobox from Fontello icons set. If empty - use default icon',  'trx_addons'),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"color" => array(
							"title" => __("Text color", "trx_addons"),
							"desc" => __("Any color for text and headers", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => __("Background color", "trx_addons"),
							"desc" => __("Any background color for this infobox", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"_content_" => array(
							"title" => __("Infobox content", "trx_addons"),
							"desc" => __("Content for infobox", "trx_addons"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Line
				"trx_line" => array(
					"title" => __("Line", "trx_addons"),
					"desc" => __("Insert Line into your post (page)", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Style", "trx_addons"),
							"desc" => __("Line style", "trx_addons"),
							"value" => "solid",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'solid' => __('Solid', 'trx_addons'),
								'dashed' => __('Dashed', 'trx_addons'),
								'dotted' => __('Dotted', 'trx_addons'),
								'double' => __('Double', 'trx_addons'),
								'styling' => __('styling', 'trx_addons')
							)
						),
						"color" => array(
							"title" => __("Color", "trx_addons"),
							"desc" => __("Line color", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// List
				"trx_list" => array(
					"title" => __("List", "trx_addons"),
					"desc" => __("List items with specific bullets", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Bullet's style", "trx_addons"),
							"desc" => __("Bullet's style for each list item", "trx_addons"),
							"value" => "ul",
							"type" => "checklist",
							"options" => $THEMEREX_GLOBALS['sc_params']['list_styles']
						), 
						"color" => array(
							"title" => __("Color", "trx_addons"),
							"desc" => __("List items color", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"icon" => array(
							"title" => __('List icon',  'trx_addons'),
							"desc" => __("Select list icon from Fontello icons set (only for style=Iconed)",  'trx_addons'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"icon_color" => array(
							"title" => __("Icon color", "trx_addons"),
							"desc" => __("List icons color", "trx_addons"),
							"value" => "",
							"dependency" => array(
								'style' => array('iconed')
							),
							"type" => "color"
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_list_item",
						"title" => __("Item", "trx_addons"),
						"desc" => __("List item with specific bullet", "trx_addons"),
						"decorate" => false,
						"container" => true,
						"params" => array(
							"_content_" => array(
								"title" => __("List item content", "trx_addons"),
								"desc" => __("Current list item content", "trx_addons"),
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"title" => array(
								"title" => __("List item title", "trx_addons"),
								"desc" => __("Current list item title (show it as tooltip)", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"color" => array(
								"title" => __("Color", "trx_addons"),
								"desc" => __("Text color for this item", "trx_addons"),
								"value" => "",
								"type" => "color"
							),
							"icon" => array(
								"title" => __('List icon',  'trx_addons'),
								"desc" => __("Select list item icon from Fontello icons set (only for style=Iconed)",  'trx_addons'),
								"value" => "",
								"type" => "icons",
								"options" => $THEMEREX_GLOBALS['sc_params']['icons']
							),
							"icon_color" => array(
								"title" => __("Icon color", "trx_addons"),
								"desc" => __("Icon color for this item", "trx_addons"),
								"value" => "",
								"type" => "color"
							),
							"link" => array(
								"title" => __("Link URL", "trx_addons"),
								"desc" => __("Link URL for the current list item", "trx_addons"),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"target" => array(
								"title" => __("Link target", "trx_addons"),
								"desc" => __("Link target for the current list item", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"id" => $THEMEREX_GLOBALS['sc_params']['id'],
							"class" => $THEMEREX_GLOBALS['sc_params']['class'],
							"css" => $THEMEREX_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
				// Number
				"trx_number" => array(
					"title" => __("Number", "trx_addons"),
					"desc" => __("Insert number or any word as set separate characters", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"value" => array(
							"title" => __("Value", "trx_addons"),
							"desc" => __("Number or any word", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => __("Align", "trx_addons"),
							"desc" => __("Select block alignment", "trx_addons"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Parallax
				"trx_parallax" => array(
					"title" => __("Parallax", "trx_addons"),
					"desc" => __("Create the parallax container (with asinc background image)", "trx_addons"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"gap" => array(
							"title" => __("Create gap", "trx_addons"),
							"desc" => __("Create gap around parallax container", "trx_addons"),
							"value" => "no",
							"size" => "small",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no'],
							"type" => "switch"
						), 
						"dir" => array(
							"title" => __("Dir", "trx_addons"),
							"desc" => __("Scroll direction for the parallax background", "trx_addons"),
							"value" => "up",
							"size" => "medium",
							"options" => array(
								'up' => __('Up', 'trx_addons'),
								'down' => __('Down', 'trx_addons')
							),
							"type" => "switch"
						), 
						"speed" => array(
							"title" => __("Speed", "trx_addons"),
							"desc" => __("Image motion speed (from 0.0 to 1.0)", "trx_addons"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0.3",
							"type" => "spinner"
						),
						"color" => array(
							"title" => __("Text color", "trx_addons"),
							"desc" => __("Select color for text object inside parallax block", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_tint" => array(
							"title" => __("Bg tint", "trx_addons"),
							"desc" => __("Select tint of the parallax background (for correct font color choise)", "trx_addons"),
							"value" => "light",
							"size" => "medium",
							"options" => array(
								'light' => __('Light', 'trx_addons'),
								'dark' => __('Dark', 'trx_addons')
							),
							"type" => "switch"
						), 
						"bg_color" => array(
							"title" => __("Background color", "trx_addons"),
							"desc" => __("Select color for parallax background", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => __("Background image", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site for the parallax background", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_image_x" => array(
							"title" => __("Image X position", "trx_addons"),
							"desc" => __("Image horizontal position (as background of the parallax block) - in percent", "trx_addons"),
							"min" => "0",
							"max" => "100",
							"value" => "50",
							"type" => "spinner"
						),
						"bg_video" => array(
							"title" => __("Video background", "trx_addons"),
							"desc" => __("Select video from media library or paste URL for video file from other site to show it as parallax background", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media",
							"before" => array(
								'title' => __('Choose video', 'trx_addons'),
								'action' => 'media_upload',
								'type' => 'video',
								'multiple' => false,
								'linked_field' => '',
								'captions' => array( 	
									'choose' => __('Choose video file', 'trx_addons'),
									'update' => __('Select video file', 'trx_addons')
								)
							),
							"after" => array(
								'icon' => 'icon-cancel',
								'action' => 'media_reset'
							)
						),
						"bg_video_ratio" => array(
							"title" => __("Video ratio", "trx_addons"),
							"desc" => __("Specify ratio of the video background. For example: 16:9 (default), 4:3, etc.", "trx_addons"),
							"value" => "16:9",
							"type" => "text"
						),
						"bg_overlay" => array(
							"title" => __("Overlay", "trx_addons"),
							"desc" => __("Overlay color opacity (from 0.0 to 1.0)", "trx_addons"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => __("Texture", "trx_addons"),
							"desc" => __("Predefined texture style from 1 to 11. 0 - without texture.", "trx_addons"),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"_content_" => array(
							"title" => __("Content", "trx_addons"),
							"desc" => __("Content for the parallax container", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Popup
				"trx_popup" => array(
					"title" => __("Popup window", "trx_addons"),
					"desc" => __("Container for any html-block with desired class and style for popup window", "trx_addons"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => __("Container content", "trx_addons"),
							"desc" => __("Content for section container", "trx_addons"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Price
				"trx_price" => array(
					"title" => __("Price", "trx_addons"),
					"desc" => __("Insert price with decoration", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"money" => array(
							"title" => __("Money", "trx_addons"),
							"desc" => __("Money value (dot or comma separated)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"currency" => array(
							"title" => __("Currency", "trx_addons"),
							"desc" => __("Currency character", "trx_addons"),
							"value" => "$",
							"type" => "text"
						),
						"period" => array(
							"title" => __("Period", "trx_addons"),
							"desc" => __("Period text (if need). For example: monthly, daily, etc.", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => __("Alignment", "trx_addons"),
							"desc" => __("Align price to left or right side", "trx_addons"),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['float']
						), 
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Price block
				"trx_price_block" => array(
					"title" => __("Price block", "trx_addons"),
					"desc" => __("Insert price block with title, price and description", "trx_addons"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"style" => array(
							"title" => __("Price block style", "trx_addons"),
							"desc" => __("Select style of Price block", "trx_addons"),
							"value" => "1",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'1' => __('Style 1', 'trx_addons'),
								'2' => __('Style 2', 'trx_addons')
							)
						),
						"title" => array(
							"title" => __("Title", "trx_addons"),
							"desc" => __("Block title", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"link" => array(
							"title" => __("Link URL", "trx_addons"),
							"desc" => __("URL for link from button (at bottom of the block)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"link_text" => array(
							"title" => __("Link text", "trx_addons"),
							"desc" => __("Text (caption) for the link button (at bottom of the block). If empty - button not showed", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"icon" => array(
							"title" => __("Icon",  'trx_addons'),
							"desc" => __('Select icon from Fontello icons set (placed before/instead price)',  'trx_addons'),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"money" => array(
							"title" => __("Money", "trx_addons"),
							"desc" => __("Money value (dot or comma separated)", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"currency" => array(
							"title" => __("Currency", "trx_addons"),
							"desc" => __("Currency character", "trx_addons"),
							"value" => "$",
							"type" => "text"
						),
						"period" => array(
							"title" => __("Period", "trx_addons"),
							"desc" => __("Period text (if need). For example: monthly, daily, etc.", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => __("Alignment", "trx_addons"),
							"desc" => __("Align price to left or right side", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['float']
						), 
						"_content_" => array(
							"title" => __("Description", "trx_addons"),
							"desc" => __("Description for this price block", "trx_addons"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Quote
				"trx_quote" => array(
					"title" => __("Quote", "trx_addons"),
					"desc" => __("Quote text", "trx_addons"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"cite" => array(
							"title" => __("Quote cite", "trx_addons"),
							"desc" => __("URL for quote cite", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"title" => array(
							"title" => __("Title (author)", "trx_addons"),
							"desc" => __("Quote title (author name)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"style" => array(
							"title" => __("Quote style", "trx_addons"),
							"desc" => __("Select style of Quote block", "trx_addons"),
							"value" => "1",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'1' => __('Style 1', 'trx_addons'),
								'2' => __('Style 2', 'trx_addons')
							)
						),
						"_content_" => array(
							"title" => __("Quote content", "trx_addons"),
							"desc" => __("Quote content", "trx_addons"),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => themerex_shortcodes_width(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Reviews
				"trx_reviews" => array(
					"title" => __("Reviews", "trx_addons"),
					"desc" => __("Insert reviews block in the single post", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"align" => array(
							"title" => __("Alignment", "trx_addons"),
							"desc" => __("Align counter to left, center or right", "trx_addons"),
							"divider" => true,
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						), 
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Search
				"trx_search" => array(
					"title" => __("Search", "trx_addons"),
					"desc" => __("Show search form", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"title" => array(
							"title" => __("Title", "trx_addons"),
							"desc" => __("Title (placeholder) for the search field", "trx_addons"),
							"value" => __("Search &hellip;", 'trx_addons'),
							"divider" => true,
							"type" => "text"
						),
						"ajax" => array(
							"title" => __("AJAX", "trx_addons"),
							"desc" => __("Search via AJAX or reload page", "trx_addons"),
							"value" => "yes",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no'],
							"type" => "switch"
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Section
				"trx_section" => array(
					"title" => __("Section container", "trx_addons"),
					"desc" => __("Container for any block with desired class and style", "trx_addons"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"dedicated" => array(
							"title" => __("Dedicated", "trx_addons"),
							"desc" => __("Use this block as dedicated content - show it before post title on single page", "trx_addons"),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"title" => array(
							"title" => __("Title", "trx_addons"),
							"desc" => __("Container title", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => __("Align", "trx_addons"),
							"desc" => __("Select block alignment", "trx_addons"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						),
						"columns" => array(
							"title" => __("Columns emulation", "trx_addons"),
							"desc" => __("Select width for columns emulation", "trx_addons"),
							"value" => "none",
							"type" => "checklist",
							"options" => $THEMEREX_GLOBALS['sc_params']['columns']
						), 
						"pan" => array(
							"title" => __("Use pan effect", "trx_addons"),
							"desc" => __("Use pan effect to show section content", "trx_addons"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"scroll" => array(
							"title" => __("Use scroller", "trx_addons"),
							"desc" => __("Use scroller to show section content", "trx_addons"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"scroll_dir" => array(
							"title" => __("Scroll and Pan direction", "trx_addons"),
							"desc" => __("Scroll and Pan direction (if Use scroller = yes or Pan = yes)", "trx_addons"),
							"dependency" => array(
								'pan' => array('yes'),
								'scroll' => array('yes')
							),
							"value" => "horizontal",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['dir']
						),
						"scroll_controls" => array(
							"title" => __("Scroll controls", "trx_addons"),
							"desc" => __("Show scroll controls (if Use scroller = yes)", "trx_addons"),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"color" => array(
							"title" => __("Fore color", "trx_addons"),
							"desc" => __("Any color for objects in this section", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_tint" => array(
							"title" => __("Background tint", "trx_addons"),
							"desc" => __("Main background tint: dark or light", "trx_addons"),
							"value" => "",
							"type" => "checklist",
							"options" => $THEMEREX_GLOBALS['sc_params']['tint']
						),
						"bg_color" => array(
							"title" => __("Background color", "trx_addons"),
							"desc" => __("Any background color for this section", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => __("Background image URL", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site for the background", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => __("Overlay", "trx_addons"),
							"desc" => __("Overlay color opacity (from 0.0 to 1.0)", "trx_addons"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => __("Texture", "trx_addons"),
							"desc" => __("Predefined texture style from 1 to 11. 0 - without texture.", "trx_addons"),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"font_size" => array(
							"title" => __("Font size", "trx_addons"),
							"desc" => __("Font size of the text (default - in pixels, allows any CSS units of measure)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"font_weight" => array(
							"title" => __("Font weight", "trx_addons"),
							"desc" => __("Font weight of the text", "trx_addons"),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'100' => __('Thin (100)', 'trx_addons'),
								'300' => __('Light (300)', 'trx_addons'),
								'400' => __('Normal (400)', 'trx_addons'),
								'700' => __('Bold (700)', 'trx_addons')
							)
						),
						"_content_" => array(
							"title" => __("Container content", "trx_addons"),
							"desc" => __("Content for section container", "trx_addons"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
				// Skills
				"trx_skills" => array(
					"title" => __("Skills", "trx_addons"),
					"desc" => __("Insert skills diagramm in your page (post)", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"max_value" => array(
							"title" => __("Max value", "trx_addons"),
							"desc" => __("Max value for skills items", "trx_addons"),
							"value" => 100,
							"min" => 1,
							"type" => "spinner"
						),
						"type" => array(
							"title" => __("Skills type", "trx_addons"),
							"desc" => __("Select type of skills block", "trx_addons"),
							"value" => "bar",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'bar' => __('Bar', 'trx_addons'),
								'bar2' => __('Bar 2', 'trx_addons'),
								'bar3' => __('Bar 3', 'trx_addons'),
								'pie' => __('Pie chart', 'trx_addons'),
								'pie_2' => __('Pie chart 2', 'trx_addons'),
								'counter' => __('Counter', 'trx_addons'),
								'arc' => __('Arc', 'trx_addons')
							)
						), 
						"layout" => array(
							"title" => __("Skills layout", "trx_addons"),
							"desc" => __("Select layout of skills block", "trx_addons"),
							"dependency" => array(
								'type' => array('counter','pie','bar')
							),
							"value" => "rows",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'rows' => __('Rows', 'trx_addons'),
								'columns' => __('Columns', 'trx_addons')
							)
						),
						"dir" => array(
							"title" => __("Direction", "trx_addons"),
							"desc" => __("Select direction of skills block", "trx_addons"),
							"dependency" => array(
								'type' => array('counter','pie','bar','bar3')
							),
							"value" => "horizontal",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['dir']
						), 
						"style" => array(
							"title" => __("Counters style", "trx_addons"),
							"desc" => __("Select style of skills items (only for type=counter)", "trx_addons"),
							"dependency" => array(
								'type' => array('counter')
							),
							"value" => 1,
							"min" => 1,
							"max" => 4,
							"type" => "spinner"
						), 
						// "columns" - autodetect, not set manual
						"color" => array(
							"title" => __("Skills items color", "trx_addons"),
							"desc" => __("Color for all skills items", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => __("Background color", "trx_addons"),
							"desc" => __("Background color for all skills items (only for type=pie)", "trx_addons"),
							"dependency" => array(
								'type' => array('pie')
							),
							"value" => "",
							"type" => "color"
						),
						"border_color" => array(
							"title" => __("Border color", "trx_addons"),
							"desc" => __("Border color for all skills items (only for type=pie)", "trx_addons"),
							"dependency" => array(
								'type' => array('pie')
							),
							"value" => "",
							"type" => "color"
						),
						"title" => array(
							"title" => __("Skills title", "trx_addons"),
							"desc" => __("Skills block title", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => __("Skills subtitle", "trx_addons"),
							"desc" => __("Skills block subtitle - text in the center (only for type=arc)", "trx_addons"),
							"dependency" => array(
								'type' => array('arc')
							),
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => __("Align skills block", "trx_addons"),
							"desc" => __("Align skills block to left or right side", "trx_addons"),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['float']
						), 
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_skills_item",
						"title" => __("Skill", "trx_addons"),
						"desc" => __("Skills item", "trx_addons"),
						"container" => false,
						"params" => array(
							"title" => array(
								"title" => __("Title", "trx_addons"),
								"desc" => __("Current skills item title", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"value" => array(
								"title" => __("Value", "trx_addons"),
								"desc" => __("Current skills level", "trx_addons"),
								"value" => 50,
								"min" => 0,
								"step" => 1,
								"type" => "spinner"
							),
							"color" => array(
								"title" => __("Color", "trx_addons"),
								"desc" => __("Current skills item color", "trx_addons"),
								"value" => "",
								"type" => "color"
							),
							"bg_color" => array(
								"title" => __("Background color", "trx_addons"),
								"desc" => __("Current skills item background color (only for type=pie)", "trx_addons"),
								"value" => "",
								"type" => "color"
							),
							"border_color" => array(
								"title" => __("Border color", "trx_addons"),
								"desc" => __("Current skills item border color (only for type=pie)", "trx_addons"),
								"value" => "",
								"type" => "color"
							),
							"icon" => array(
								"title" => __('Skills font icon',  'trx_addons'),
								"desc" => __("Select font icon for the skills from Fontello icons set (if style=Bar 3)",  'trx_addons'),
								"value" => "",
								"type" => "icons",
								"options" => $THEMEREX_GLOBALS['sc_params']['icons']
							),
							"color_icon" => array(
								"title" => __("Icon color", "trx_addons"),
								"desc" => __("Current skills icon color (if style=Bar 3)", "trx_addons"),
								"value" => "",
								"type" => "color"
							),
							"style" => array(
								"title" => __("Counter tyle", "trx_addons"),
								"desc" => __("Select style for the current skills item (only for type=counter)", "trx_addons"),
								"value" => 1,
								"min" => 1,
								"max" => 4,
								"type" => "spinner"
							), 
							"id" => $THEMEREX_GLOBALS['sc_params']['id'],
							"class" => $THEMEREX_GLOBALS['sc_params']['class'],
							"css" => $THEMEREX_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Slider
				"trx_slider" => array(
					"title" => __("Slider", "trx_addons"),
					"desc" => __("Insert slider into your post (page)", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array_merge(array(
						"engine" => array(
							"title" => __("Slider engine", "trx_addons"),
							"desc" => __("Select engine for slider. Attention! Swiper is built-in engine, all other engines appears only if corresponding plugings are installed", "trx_addons"),
							"value" => "swiper",
							"type" => "checklist",
							"options" => $THEMEREX_GLOBALS['sc_params']['sliders']
						),
						"align" => array(
							"title" => __("Float slider", "trx_addons"),
							"desc" => __("Float slider to left or right side", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['float']
						),
						"custom" => array(
							"title" => __("Custom slides", "trx_addons"),
							"desc" => __("Make custom slides from inner shortcodes (prepare it on tabs) or prepare slides from posts thumbnails", "trx_addons"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						)
						),
						themerex_exists_revslider() || themerex_exists_royalslider() ? array(
						"alias" => array(
							"title" => __("Revolution slider alias or Royal Slider ID", "trx_addons"),
							"desc" => __("Alias for Revolution slider or Royal slider ID", "trx_addons"),
							"dependency" => array(
								'engine' => array('revo','royal')
							),
							"divider" => true,
							"value" => "",
							"type" => "text"
						)) : array(), array(
						"cat" => array(
							"title" => __("Swiper: Category list", "trx_addons"),
							"desc" => __("Comma separated list of category slugs. If empty - select posts from any category or from IDs list", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => $THEMEREX_GLOBALS['sc_params']['categories']
						),
						"count" => array(
							"title" => __("Swiper: Number of posts", "trx_addons"),
							"desc" => __("How many posts will be displayed? If used IDs - this parameter ignored.", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => __("Swiper: Offset before select posts", "trx_addons"),
							"desc" => __("Skip posts before select next part.", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Swiper: Post order by", "trx_addons"),
							"desc" => __("Select desired posts sorting method", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "date",
							"type" => "select",
							"options" => $THEMEREX_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => __("Swiper: Post order", "trx_addons"),
							"desc" => __("Select desired posts order", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						),
						"ids" => array(
							"title" => __("Swiper: Post IDs list", "trx_addons"),
							"desc" => __("Comma separated list of posts ID. If set - parameters above are ignored!", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "",
							"type" => "text"
						),
						"controls" => array(
							"title" => __("Swiper: Show slider controls", "trx_addons"),
							"desc" => __("Show arrows inside slider", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"divider" => true,
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"pagination" => array(
							"title" => __("Swiper: Show slider pagination", "trx_addons"),
							"desc" => __("Show bullets for switch slides", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "checklist",
							"options" => array(
								'yes'  => __('Dots', 'trx_addons'),
								'full' => __('Side Titles', 'trx_addons'),
								'over' => __('Over Titles', 'trx_addons'),
								'no'   => __('None', 'trx_addons')
							)
						),
						"titles" => array(
							"title" => __("Swiper: Show titles section", "trx_addons"),
							"desc" => __("Show section with post's title and short post's description", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"divider" => true,
							"value" => "no",
							"type" => "checklist",
							"options" => array(
								"no"    => __('Not show', 'trx_addons'),
								"slide" => __('Show/Hide info', 'trx_addons'),
								"fixed" => __('Fixed info', 'trx_addons')
							)
						),
						"descriptions" => array(
							"title" => __("Swiper: Post descriptions", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"desc" => __("Show post's excerpt max length (characters)", "trx_addons"),
							"value" => 0,
							"min" => 0,
							"max" => 1000,
							"step" => 10,
							"type" => "spinner"
						),
						"links" => array(
							"title" => __("Swiper: Post's title as link", "trx_addons"),
							"desc" => __("Make links from post's titles", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"crop" => array(
							"title" => __("Swiper: Crop images", "trx_addons"),
							"desc" => __("Crop images in each slide or live it unchanged", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"autoheight" => array(
							"title" => __("Swiper: Autoheight", "trx_addons"),
							"desc" => __("Change whole slider's height (make it equal current slide's height)", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"interval" => array(
							"title" => __("Swiper: Slides change interval", "trx_addons"),
							"desc" => __("Slides change interval (in milliseconds: 1000ms = 1s)", "trx_addons"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => 5000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)),
					"children" => array(
						"name" => "trx_slider_item",
						"title" => __("Slide", "trx_addons"),
						"desc" => __("Slider item", "trx_addons"),
						"container" => false,
						"params" => array(
							"src" => array(
								"title" => __("URL (source) for image file", "trx_addons"),
								"desc" => __("Select or upload image or write URL from other site for the current slide", "trx_addons"),
								"readonly" => false,
								"value" => "",
								"type" => "media"
							),
							"id" => $THEMEREX_GLOBALS['sc_params']['id'],
							"class" => $THEMEREX_GLOBALS['sc_params']['class'],
							"css" => $THEMEREX_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Socials
				"trx_socials" => array(
					"title" => __("Social icons", "trx_addons"),
					"desc" => __("List of social icons (with hovers)", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"size" => array(
							"title" => __("Icon's size", "trx_addons"),
							"desc" => __("Size of the icons", "trx_addons"),
							"value" => "small",
							"type" => "checklist",
							"options" => array(
								"tiny" => __('Tiny', 'trx_addons'),
								"small" => __('Small', 'trx_addons'),
								"large" => __('Large', 'trx_addons')
							)
						), 
						"socials" => array(
							"title" => __("Manual socials list", "trx_addons"),
							"desc" => __("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebooc.com/my_profile. If empty - use socials from Theme options.", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"custom" => array(
							"title" => __("Custom socials", "trx_addons"),
							"desc" => __("Make custom icons from inner shortcodes (prepare it on tabs)", "trx_addons"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"style" => array(
							"title" => __("Socials style", "trx_addons"),
							"desc" => __("Socials style", "trx_addons"),
							"value" => "main",
							"type" => "select",
							"options" => array(
								'main' => __('Regular', 'trx_addons'),
								'color' => __('Color', 'trx_addons')
							)
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_social_item",
						"title" => __("Custom social item", "trx_addons"),
						"desc" => __("Custom social item: name, profile url and icon url", "trx_addons"),
						"decorate" => false,
						"container" => false,
						"params" => array(
							"url" => array(
								"title" => __("Your profile URL", "trx_addons"),
								"desc" => __("URL of your profile in specified social network", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"icon" => array(
								"title" => __('Icon',  'trx_addons'),
								"desc" => __("Select font icon from Fontello icons set (if style=iconed)",  'trx_addons'),
								"value" => "",
								"type" => "icons",
								"options" => $THEMEREX_GLOBALS['sc_params']['icons']
							)
						)
					)
				),





				// Sidebar
				"trx_sidebar" => array(
					"title" => __("Sidebar", "trx_addons"),
					"desc" => __("Insert Sidebar into the page/post content. ", "trx_addons"),
					"id" => "trx_sidebar",
					"decorate" => false,
					"container" => false,
					"params" => array(
						"name" => array(
							"title" => __("Select sidebar", "trx_addons"),
							"options" => $THEMEREX_GLOBALS['sc_params']['sidebar'],
							"type" => "select",
							"divider" => true,
							"value" => ""
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right']
					)
				),



			
				// Table
				"trx_table" => array(
					"title" => __("Table", "trx_addons"),
					"desc" => __("Insert a table into post (page). ", "trx_addons"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"align" => array(
							"title" => __("Content alignment", "trx_addons"),
							"desc" => __("Select alignment for each table cell", "trx_addons"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						),
						"_content_" => array(
							"title" => __("Table content", "trx_addons"),
							"desc" => __("Content, created with any table-generator", "trx_addons"),
							"divider" => true,
							"rows" => 8,
							"value" => "Paste here table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/",
							"type" => "textarea"
						),
						"width" => themerex_shortcodes_width(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Tabs
				"trx_tabs" => array(
					"title" => __("Tabs", "trx_addons"),
					"desc" => __("Insert tabs in your page (post)", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Tabs style", "trx_addons"),
							"desc" => __("Select style for tabs items", "trx_addons"),
							"value" => 2,
							"options" => array(
								1 => __('Style 1(fullscreen)', 'trx_addons'),
								2 => __('Style 2', 'trx_addons'),
								3 => __('Style 3', 'trx_addons')
							),
							"type" => "radio"
						),
						"initial" => array(
							"title" => __("Initially opened tab", "trx_addons"),
							"desc" => __("Number of initially opened tab", "trx_addons"),
							"divider" => true,
							"value" => 1,
							"min" => 0,
							"type" => "spinner"
						),
						"scroll" => array(
							"title" => __("Use scroller", "trx_addons"),
							"desc" => __("Use scroller to show tab content (height parameter required)", "trx_addons"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"title" => array(
							"title" => __("Title", "trx_addons"),
							"desc" => __("Title for the Tabs (Style 2)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => __("Subtitle", "trx_addons"),
							"desc" => __("Subtitle for the Tabs (Style 2)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => __("Description", "trx_addons"),
							"desc" => __("Short description for the Tabs (Style 2)", "trx_addons"),
							"value" => "",
							"type" => "textarea"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_tab",
						"title" => __("Tab", "trx_addons"),
						"desc" => __("Tab item", "trx_addons"),
						"container" => true,
						"params" => array(
							"title" => array(
								"title" => __("Tab title", "trx_addons"),
								"desc" => __("Current tab title", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"icon" => array(
								"title" => __('Title font icon (style 1)',  'trx_addons'),
								"desc" => __("Select font icon for the tab from Fontello icons set (if style 1)",  'trx_addons'),
								"value" => "",
								"type" => "icons",
								"options" => $THEMEREX_GLOBALS['sc_params']['icons']
							),
							"_content_" => array(
								"title" => __("Tab content", "trx_addons"),
								"desc" => __("Current tab content", "trx_addons"),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $THEMEREX_GLOBALS['sc_params']['id'],
							"class" => $THEMEREX_GLOBALS['sc_params']['class'],
							"css" => $THEMEREX_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
			
				// Team
				"trx_team" => array(
					"title" => __("Team", "trx_addons"),
					"desc" => __("Insert team in your page (post)", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns use to show team members", "trx_addons"),
							"value" => 3,
							"min" => 2,
							"max" => 5,
							"step" => 1,
							"type" => "spinner"
						),
						"custom" => array(
							"title" => __("Custom", "trx_addons"),
							"desc" => __("Allow get team members from inner shortcodes (custom) or get it from specified group (cat)", "trx_addons"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"cat" => array(
							"title" => __("Categories", "trx_addons"),
							"desc" => __("Select categories (groups) to show team members. If empty - select team members from any category (group) or from IDs list", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => $THEMEREX_GLOBALS['sc_params']['team_groups']
						),
						"count" => array(
							"title" => __("Number of posts", "trx_addons"),
							"desc" => __("How many posts will be displayed? If used IDs - this parameter ignored.", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => __("Offset before select posts", "trx_addons"),
							"desc" => __("Skip posts before select next part.", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Post order by", "trx_addons"),
							"desc" => __("Select desired posts sorting method", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => "title",
							"type" => "select",
							"options" => $THEMEREX_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => __("Post order", "trx_addons"),
							"desc" => __("Select desired posts order", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => "asc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						),
						"ids" => array(
							"title" => __("Post IDs list", "trx_addons"),
							"desc" => __("Comma separated list of posts ID. If set - parameters above are ignored!", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => "",
							"type" => "text"
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_team_item",
						"title" => __("Member", "trx_addons"),
						"desc" => __("Team member", "trx_addons"),
						"container" => true,
						"params" => array(
							"user" => array(
								"title" => __("Registerd user", "trx_addons"),
								"desc" => __("Select one of registered users (if present) or put name, position, etc. in fields below", "trx_addons"),
								"value" => "",
								"type" => "select",
								"options" => $THEMEREX_GLOBALS['sc_params']['users']
							),
							"member" => array(
								"title" => __("Team member", "trx_addons"),
								"desc" => __("Select one of team members (if present) or put name, position, etc. in fields below", "trx_addons"),
								"value" => "",
								"type" => "select",
								"options" => $THEMEREX_GLOBALS['sc_params']['members']
							),
							"link" => array(
								"title" => __("Link", "trx_addons"),
								"desc" => __("Link on team member's personal page", "trx_addons"),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"name" => array(
								"title" => __("Name", "trx_addons"),
								"desc" => __("Team member's name", "trx_addons"),
								"divider" => true,
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"position" => array(
								"title" => __("Position", "trx_addons"),
								"desc" => __("Team member's position", "trx_addons"),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"email" => array(
								"title" => __("E-mail", "trx_addons"),
								"desc" => __("Team member's e-mail", "trx_addons"),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"photo" => array(
								"title" => __("Photo", "trx_addons"),
								"desc" => __("Team member's photo (avatar)", "trx_addons"),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"readonly" => false,
								"type" => "media"
							),
							"socials" => array(
								"title" => __("Socials", "trx_addons"),
								"desc" => __("Team member's socials icons: name=url|name=url... For example: facebook=http://facebook.com/myaccount|twitter=http://twitter.com/myaccount", "trx_addons"),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"_content_" => array(
								"title" => __("Description", "trx_addons"),
								"desc" => __("Team member's short description", "trx_addons"),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $THEMEREX_GLOBALS['sc_params']['id'],
							"class" => $THEMEREX_GLOBALS['sc_params']['class'],
							"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
							"css" => $THEMEREX_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Testimonials
				"trx_testimonials" => array(
					"title" => __("Testimonials", "trx_addons"),
					"desc" => __("Insert testimonials into post (page)", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Testimonials style", "trx_addons"),
							"desc" => __("Select style to display testimonials members", "trx_addons"),
							"value" => "1",
							"type" => "select",
							"options" => array(
								1 => __('Style 1', 'trx_addons'),
								2 => __('Style 2', 'trx_addons')
							)
						),
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns use to show team members", "trx_addons"),
							"value" => 2,
							"min" => 2,
							"max" => 4,
							"step" => 1,
							"type" => "spinner",
							"dependency" => array(
								'style' => array('2')
							),
						),
						"controls" => array(
							"title" => __("Show arrows", "trx_addons"),
							"desc" => __("Show control buttons", "trx_addons"),
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no'],
							"dependency" => array(
								'style' => array('1')
							),
						),
						"interval" => array(
							"title" => __("Testimonials change interval", "trx_addons"),
							"desc" => __("Testimonials change interval (in milliseconds: 1000ms = 1s)", "trx_addons"),
							"value" => 7000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner",
							"dependency" => array(
								'style' => array('1')
							)
						),
						"align" => array(
							"title" => __("Alignment", "trx_addons"),
							"desc" => __("Alignment of the testimonials block", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						),
						"autoheight" => array(
							"title" => __("Autoheight", "trx_addons"),
							"desc" => __("Change whole slider's height (make it equal current slide's height)", "trx_addons"),
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no'],
							"dependency" => array(
								'style' => array('1')
							)
						),
						"custom" => array(
							"title" => __("Custom", "trx_addons"),
							"desc" => __("Allow get testimonials from inner shortcodes (custom) or get it from specified group (cat)", "trx_addons"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"cat" => array(
							"title" => __("Categories", "trx_addons"),
							"desc" => __("Select categories (groups) to show testimonials. If empty - select testimonials from any category (group) or from IDs list", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => $THEMEREX_GLOBALS['sc_params']['testimonials_groups']
						),
						"count" => array(
							"title" => __("Number of posts", "trx_addons"),
							"desc" => __("How many posts will be displayed? If used IDs - this parameter ignored.", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => __("Offset before select posts", "trx_addons"),
							"desc" => __("Skip posts before select next part.", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Post order by", "trx_addons"),
							"desc" => __("Select desired posts sorting method", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => "date",
							"type" => "select",
							"options" => $THEMEREX_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => __("Post order", "trx_addons"),
							"desc" => __("Select desired posts order", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						),
						"ids" => array(
							"title" => __("Post IDs list", "trx_addons"),
							"desc" => __("Comma separated list of posts ID. If set - parameters above are ignored!", "trx_addons"),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_tint" => array(
							"title" => __("Background tint", "trx_addons"),
							"desc" => __("Main background tint: dark or light", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"options" => $THEMEREX_GLOBALS['sc_params']['tint']
						),
						"bg_color" => array(
							"title" => __("Background color", "trx_addons"),
							"desc" => __("Any background color for this section", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => __("Background image URL", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site for the background", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => __("Overlay", "trx_addons"),
							"desc" => __("Overlay color opacity (from 0.0 to 1.0)", "trx_addons"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => __("Texture", "trx_addons"),
							"desc" => __("Predefined texture style from 1 to 11. 0 - without texture.", "trx_addons"),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_testimonials_item",
						"title" => __("Item", "trx_addons"),
						"desc" => __("Testimonials item", "trx_addons"),
						"container" => true,
						"params" => array(
							"author" => array(
								"title" => __("Author", "trx_addons"),
								"desc" => __("Name of the testimonmials author", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"link" => array(
								"title" => __("Link", "trx_addons"),
								"desc" => __("Link URL to the testimonmials author page", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"email" => array(
								"title" => __("E-mail", "trx_addons"),
								"desc" => __("E-mail of the testimonmials author (to get gravatar)", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"photo" => array(
								"title" => __("Photo", "trx_addons"),
								"desc" => __("Select or upload photo of testimonmials author or write URL of photo from other site", "trx_addons"),
								"value" => "",
								"type" => "media"
							),
							"field" => array(
								"title" => __("Field", "trx_addons"),
								"desc" => __("Additional field", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"_content_" => array(
								"title" => __("Testimonials text", "trx_addons"),
								"desc" => __("Current testimonials text", "trx_addons"),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $THEMEREX_GLOBALS['sc_params']['id'],
							"class" => $THEMEREX_GLOBALS['sc_params']['class'],
							"css" => $THEMEREX_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Title
				"trx_title" => array(
					"title" => __("Title", "trx_addons"),
					"desc" => __("Create header tag (1-6 level) with many styles", "trx_addons"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => __("Title content", "trx_addons"),
							"desc" => __("Title content", "trx_addons"),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"type" => array(
							"title" => __("Title type", "trx_addons"),
							"desc" => __("Title type (header level)", "trx_addons"),
							"divider" => true,
							"value" => "1",
							"type" => "select",
							"options" => array(
								'1' => __('Header 1', 'trx_addons'),
								'2' => __('Header 2', 'trx_addons'),
								'3' => __('Header 3', 'trx_addons'),
								'4' => __('Header 4', 'trx_addons'),
								'5' => __('Header 5', 'trx_addons'),
								'6' => __('Header 6', 'trx_addons'),
							)
						),
						"style" => array(
							"title" => __("Title style", "trx_addons"),
							"desc" => __("Title style", "trx_addons"),
							"value" => "regular",
							"type" => "select",
							"options" => array(
								'regular' => __('Regular', 'trx_addons'),
								'underline' => __('Underline', 'trx_addons'),
								'divider' => __('Divider', 'trx_addons'),
								'iconed' => __('With icon (image)', 'trx_addons')
							)
						),
						"align" => array(
							"title" => __("Alignment", "trx_addons"),
							"desc" => __("Title text alignment", "trx_addons"),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						), 
						"font_size" => array(
							"title" => __("Font_size", "trx_addons"),
							"desc" => __("Custom font size. If empty - use theme default", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"font_weight" => array(
							"title" => __("Font weight", "trx_addons"),
							"desc" => __("Custom font weight. If empty or inherit - use theme default", "trx_addons"),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'inherit' => __('Default', 'trx_addons'),
								'100' => __('Thin (100)', 'trx_addons'),
								'300' => __('Light (300)', 'trx_addons'),
								'400' => __('Normal (400)', 'trx_addons'),
								'600' => __('Semibold (600)', 'trx_addons'),
								'700' => __('Bold (700)', 'trx_addons'),
								'900' => __('Black (900)', 'trx_addons')
							)
						),
						"color" => array(
							"title" => __("Title color", "trx_addons"),
							"desc" => __("Select color for the title", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"icon" => array(
							"title" => __('Title font icon',  'trx_addons'),
							"desc" => __("Select font icon for the title from Fontello icons set (if style=iconed)",  'trx_addons'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"image" => array(
							"title" => __('or image icon',  'trx_addons'),
							"desc" => __("Select image icon for the title instead icon above (if style=iconed)",  'trx_addons'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "",
							"type" => "images",
							"size" => "small",
							"options" => $THEMEREX_GLOBALS['sc_params']['images']
						),
						"picture" => array(
							"title" => __('or URL for image file', "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site (if style=iconed)", "trx_addons"),
							"dependency" => array(
								'style' => array('iconed')
							),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"image_size" => array(
							"title" => __('Image (picture) size', "trx_addons"),
							"desc" => __("Select image (picture) size (if style='iconed')", "trx_addons"),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "small",
							"type" => "checklist",
							"options" => array(
								'small' => __('Small', 'trx_addons'),
								'medium' => __('Medium', 'trx_addons'),
								'large' => __('Large', 'trx_addons')
							)
						),
						"position" => array(
							"title" => __('Icon (image) position', "trx_addons"),
							"desc" => __("Select icon (image) position (if style=iconed)", "trx_addons"),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "left",
							"type" => "checklist",
							"options" => array(
								'top' => __('Top', 'trx_addons'),
								'left' => __('Left', 'trx_addons')
							)
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Toggles
				"trx_toggles" => array(
					"title" => __("Toggles", "trx_addons"),
					"desc" => __("Toggles items", "trx_addons"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Toggles style", "trx_addons"),
							"desc" => __("Select style for display toggles", "trx_addons"),
							"value" => 1,
							"options" => array(
								1 => __('Style 1', 'trx_addons'),
								2 => __('Style 2', 'trx_addons')
							),
							"type" => "radio"
						),
						"icon_closed" => array(
							"title" => __("Icon while closed",  'trx_addons'),
							"desc" => __('Select icon for the closed toggles item from Fontello icons set',  'trx_addons'),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"icon_opened" => array(
							"title" => __("Icon while opened",  'trx_addons'),
							"desc" => __('Select icon for the opened toggles item from Fontello icons set',  'trx_addons'),
							"value" => "",
							"type" => "icons",
							"options" => $THEMEREX_GLOBALS['sc_params']['icons']
						),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_toggles_item",
						"title" => __("Toggles item", "trx_addons"),
						"desc" => __("Toggles item", "trx_addons"),
						"container" => true,
						"params" => array(
							"title" => array(
								"title" => __("Toggles item title", "trx_addons"),
								"desc" => __("Title for current toggles item", "trx_addons"),
								"value" => "",
								"type" => "text"
							),
							"open" => array(
								"title" => __("Open on show", "trx_addons"),
								"desc" => __("Open current toggles item on show", "trx_addons"),
								"value" => "no",
								"type" => "switch",
								"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
							),
							"icon_closed" => array(
								"title" => __("Icon while closed",  'trx_addons'),
								"desc" => __('Select icon for the closed toggles item from Fontello icons set',  'trx_addons'),
								"value" => "",
								"type" => "icons",
								"options" => $THEMEREX_GLOBALS['sc_params']['icons']
							),
							"icon_opened" => array(
								"title" => __("Icon while opened",  'trx_addons'),
								"desc" => __('Select icon for the opened toggles item from Fontello icons set',  'trx_addons'),
								"value" => "",
								"type" => "icons",
								"options" => $THEMEREX_GLOBALS['sc_params']['icons']
							),
							"_content_" => array(
								"title" => __("Toggles item content", "trx_addons"),
								"desc" => __("Current toggles item content", "trx_addons"),
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $THEMEREX_GLOBALS['sc_params']['id'],
							"class" => $THEMEREX_GLOBALS['sc_params']['class'],
							"css" => $THEMEREX_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
			
				// Tooltip
				"trx_tooltip" => array(
					"title" => __("Tooltip", "trx_addons"),
					"desc" => __("Create tooltip for selected text", "trx_addons"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"title" => array(
							"title" => __("Title", "trx_addons"),
							"desc" => __("Tooltip title (required)", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"_content_" => array(
							"title" => __("Tipped content", "trx_addons"),
							"desc" => __("Highlighted content with tooltip", "trx_addons"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Twitter
				"trx_twitter" => array(
					"title" => __("Twitter", "trx_addons"),
					"desc" => __("Insert twitter feed into post (page)", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"user" => array(
							"title" => __("Twitter Username", "trx_addons"),
							"desc" => __("Your username in the twitter account. If empty - get it from Theme Options.", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"consumer_key" => array(
							"title" => __("Consumer Key", "trx_addons"),
							"desc" => __("Consumer Key from the twitter account", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"consumer_secret" => array(
							"title" => __("Consumer Secret", "trx_addons"),
							"desc" => __("Consumer Secret from the twitter account", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"token_key" => array(
							"title" => __("Token Key", "trx_addons"),
							"desc" => __("Token Key from the twitter account", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"token_secret" => array(
							"title" => __("Token Secret", "trx_addons"),
							"desc" => __("Token Secret from the twitter account", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"count" => array(
							"title" => __("Tweets number", "trx_addons"),
							"desc" => __("Tweets number to show", "trx_addons"),
							"divider" => true,
							"value" => 3,
							"max" => 20,
							"min" => 1,
							"type" => "spinner"
						),
						"controls" => array(
							"title" => __("Show arrows", "trx_addons"),
							"desc" => __("Show control buttons", "trx_addons"),
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"interval" => array(
							"title" => __("Tweets change interval", "trx_addons"),
							"desc" => __("Tweets change interval (in milliseconds: 1000ms = 1s)", "trx_addons"),
							"value" => 7000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"align" => array(
							"title" => __("Alignment", "trx_addons"),
							"desc" => __("Alignment of the tweets block", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						),
						"autoheight" => array(
							"title" => __("Autoheight", "trx_addons"),
							"desc" => __("Change whole slider's height (make it equal current slide's height)", "trx_addons"),
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						),
						"bg_tint" => array(
							"title" => __("Background tint", "trx_addons"),
							"desc" => __("Main background tint: dark or light", "trx_addons"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"options" => $THEMEREX_GLOBALS['sc_params']['tint']
						),
						"bg_color" => array(
							"title" => __("Background color", "trx_addons"),
							"desc" => __("Any background color for this section", "trx_addons"),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => __("Background image URL", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site for the background", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => __("Overlay", "trx_addons"),
							"desc" => __("Overlay color opacity (from 0.0 to 1.0)", "trx_addons"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => __("Texture", "trx_addons"),
							"desc" => __("Predefined texture style from 1 to 11. 0 - without texture.", "trx_addons"),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),
			
			
				// Video
				"trx_video" => array(
					"title" => __("Video", "trx_addons"),
					"desc" => __("Insert video player", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"url" => array(
							"title" => __("URL for video file", "trx_addons"),
							"desc" => __("Select video from media library or paste URL for video file from other site", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media",
							"before" => array(
								'title' => __('Choose video', 'trx_addons'),
								'action' => 'media_upload',
								'type' => 'video',
								'multiple' => false,
								'linked_field' => '',
								'captions' => array( 	
									'choose' => __('Choose video file', 'trx_addons'),
									'update' => __('Select video file', 'trx_addons')
								)
							),
							"after" => array(
								'icon' => 'icon-cancel',
								'action' => 'media_reset'
							)
						),
						"ratio" => array(
							"title" => __("Ratio", "trx_addons"),
							"desc" => __("Ratio of the video", "trx_addons"),
							"value" => "16:9",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								"16:9" => __("16:9", 'trx_addons'),
								"4:3" => __("4:3", 'trx_addons')
							)
						),
						"autoplay" => array(
							"title" => __("Autoplay video", "trx_addons"),
							"desc" => __("Autoplay video on page load", "trx_addons"),
							"value" => "off",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['on_off']
						),
						"align" => array(
							"title" => __("Align", "trx_addons"),
							"desc" => __("Select block alignment", "trx_addons"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['align']
						),
						"image" => array(
							"title" => __("Cover image", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site for video preview", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_image" => array(
							"title" => __("Background image", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site for video background. Attention! If you use background image - specify paddings below from background margins to video block in percents!", "trx_addons"),
							"divider" => true,
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_top" => array(
							"title" => __("Top offset", "trx_addons"),
							"desc" => __("Top offset (padding) inside background image to video block (in percent). For example: 3%", "trx_addons"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_bottom" => array(
							"title" => __("Bottom offset", "trx_addons"),
							"desc" => __("Bottom offset (padding) inside background image to video block (in percent). For example: 3%", "trx_addons"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_left" => array(
							"title" => __("Left offset", "trx_addons"),
							"desc" => __("Left offset (padding) inside background image to video block (in percent). For example: 20%", "trx_addons"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_right" => array(
							"title" => __("Right offset", "trx_addons"),
							"desc" => __("Right offset (padding) inside background image to video block (in percent). For example: 12%", "trx_addons"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				),





				// Zoom
				"trx_zoom" => array(
					"title" => __("Zoom", "trx_addons"),
					"desc" => __("Insert the image with zoom/lens effect", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"effect" => array(
							"title" => __("Effect", "trx_addons"),
							"desc" => __("Select effect to display overlapping image", "trx_addons"),
							"value" => "lens",
							"size" => "medium",
							"type" => "switch",
							"options" => array(
								"lens" => __('Lens', 'trx_addons'),
								"zoom" => __('Zoom', 'trx_addons')
							)
						),
						"url" => array(
							"title" => __("Main image", "trx_addons"),
							"desc" => __("Select or upload main image", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"over" => array(
							"title" => __("Overlaping image", "trx_addons"),
							"desc" => __("Select or upload overlaping image", "trx_addons"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"align" => array(
							"title" => __("Float zoom", "trx_addons"),
							"desc" => __("Float zoom to left or right side", "trx_addons"),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $THEMEREX_GLOBALS['sc_params']['float']
						), 
						"bg_image" => array(
							"title" => __("Background image", "trx_addons"),
							"desc" => __("Select or upload image or write URL from other site for zoom block background. Attention! If you use background image - specify paddings below from background margins to zoom block in percents!", "trx_addons"),
							"divider" => true,
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_top" => array(
							"title" => __("Top offset", "trx_addons"),
							"desc" => __("Top offset (padding) inside background image to zoom block (in percent). For example: 3%", "trx_addons"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_bottom" => array(
							"title" => __("Bottom offset", "trx_addons"),
							"desc" => __("Bottom offset (padding) inside background image to zoom block (in percent). For example: 3%", "trx_addons"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_left" => array(
							"title" => __("Left offset", "trx_addons"),
							"desc" => __("Left offset (padding) inside background image to zoom block (in percent). For example: 20%", "trx_addons"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_right" => array(
							"title" => __("Right offset", "trx_addons"),
							"desc" => __("Right offset (padding) inside background image to zoom block (in percent). For example: 12%", "trx_addons"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"width" => themerex_shortcodes_width(),
						"height" => themerex_shortcodes_height(),
						"top" => $THEMEREX_GLOBALS['sc_params']['top'],
						"bottom" => $THEMEREX_GLOBALS['sc_params']['bottom'],
						"left" => $THEMEREX_GLOBALS['sc_params']['left'],
						"right" => $THEMEREX_GLOBALS['sc_params']['right'],
						"id" => $THEMEREX_GLOBALS['sc_params']['id'],
						"class" => $THEMEREX_GLOBALS['sc_params']['class'],
						"animation" => $THEMEREX_GLOBALS['sc_params']['animation'],
						"css" => $THEMEREX_GLOBALS['sc_params']['css']
					)
				)
			);


	
			// Woocommerce Shortcodes list
			//------------------------------------------------------------------
			if (themerex_exists_woocommerce()) {
				
				// WooCommerce - Cart
				$THEMEREX_GLOBALS['shortcodes']["woocommerce_cart"] = array(
					"title" => __("Woocommerce: Cart", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show Cart page", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Checkout
				$THEMEREX_GLOBALS['shortcodes']["woocommerce_checkout"] = array(
					"title" => __("Woocommerce: Checkout", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show Checkout page", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - My Account
				$THEMEREX_GLOBALS['shortcodes']["woocommerce_my_account"] = array(
					"title" => __("Woocommerce: My Account", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show My Account page", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Order Tracking
				$THEMEREX_GLOBALS['shortcodes']["woocommerce_order_tracking"] = array(
					"title" => __("Woocommerce: Order Tracking", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show Order Tracking page", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Shop Messages
				$THEMEREX_GLOBALS['shortcodes']["shop_messages"] = array(
					"title" => __("Woocommerce: Shop Messages", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show shop messages", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Product Page
				$THEMEREX_GLOBALS['shortcodes']["product_page"] = array(
					"title" => __("Woocommerce: Product Page", "trx_addons"),
					"desc" => __("WooCommerce shortcode: display single product page", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"sku" => array(
							"title" => __("SKU", "trx_addons"),
							"desc" => __("SKU code of displayed product", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"id" => array(
							"title" => __("ID", "trx_addons"),
							"desc" => __("ID of displayed product", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"posts_per_page" => array(
							"title" => __("Number", "trx_addons"),
							"desc" => __("How many products showed", "trx_addons"),
							"value" => "1",
							"min" => 1,
							"type" => "spinner"
						),
						"post_type" => array(
							"title" => __("Post type", "trx_addons"),
							"desc" => __("Post type for the WP query (leave 'product')", "trx_addons"),
							"value" => "product",
							"type" => "text"
						),
						"post_status" => array(
							"title" => __("Post status", "trx_addons"),
							"desc" => __("Display posts only with this status", "trx_addons"),
							"value" => "publish",
							"type" => "select",
							"options" => array(
								"publish" => __('Publish', 'trx_addons'),
								"protected" => __('Protected', 'trx_addons'),
								"private" => __('Private', 'trx_addons'),
								"pending" => __('Pending', 'trx_addons'),
								"draft" => __('Draft', 'trx_addons')
							)
						)
					)
				);
				
				// WooCommerce - Product
				$THEMEREX_GLOBALS['shortcodes']["product"] = array(
					"title" => __("Woocommerce: Product", "trx_addons"),
					"desc" => __("WooCommerce shortcode: display one product", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"sku" => array(
							"title" => __("SKU", "trx_addons"),
							"desc" => __("SKU code of displayed product", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"id" => array(
							"title" => __("ID", "trx_addons"),
							"desc" => __("ID of displayed product", "trx_addons"),
							"value" => "",
							"type" => "text"
						)
					)
				);
				
				// WooCommerce - Best Selling Products
				$THEMEREX_GLOBALS['shortcodes']["best_selling_products"] = array(
					"title" => __("Woocommerce: Best Selling Products", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show best selling products", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", "trx_addons"),
							"desc" => __("How many products showed", "trx_addons"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns per row use for products output", "trx_addons"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						)
					)
				);
				
				// WooCommerce - Recent Products
				$THEMEREX_GLOBALS['shortcodes']["recent_products"] = array(
					"title" => __("Woocommerce: Recent Products", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show recent products", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", "trx_addons"),
							"desc" => __("How many products showed", "trx_addons"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns per row use for products output", "trx_addons"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'trx_addons'),
								"title" => __('Title', 'trx_addons')
							)
						),
						"order" => array(
							"title" => __("Order", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Related Products
				$THEMEREX_GLOBALS['shortcodes']["related_products"] = array(
					"title" => __("Woocommerce: Related Products", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show related products", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"posts_per_page" => array(
							"title" => __("Number", "trx_addons"),
							"desc" => __("How many products showed", "trx_addons"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns per row use for products output", "trx_addons"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'trx_addons'),
								"title" => __('Title', 'trx_addons')
							)
						)
					)
				);
				
				// WooCommerce - Featured Products
				$THEMEREX_GLOBALS['shortcodes']["featured_products"] = array(
					"title" => __("Woocommerce: Featured Products", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show featured products", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", "trx_addons"),
							"desc" => __("How many products showed", "trx_addons"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns per row use for products output", "trx_addons"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'trx_addons'),
								"title" => __('Title', 'trx_addons')
							)
						),
						"order" => array(
							"title" => __("Order", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Top Rated Products
				$THEMEREX_GLOBALS['shortcodes']["featured_products"] = array(
					"title" => __("Woocommerce: Top Rated Products", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show top rated products", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", "trx_addons"),
							"desc" => __("How many products showed", "trx_addons"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns per row use for products output", "trx_addons"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'trx_addons'),
								"title" => __('Title', 'trx_addons')
							)
						),
						"order" => array(
							"title" => __("Order", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Sale Products
				$THEMEREX_GLOBALS['shortcodes']["featured_products"] = array(
					"title" => __("Woocommerce: Sale Products", "trx_addons"),
					"desc" => __("WooCommerce shortcode: list products on sale", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", "trx_addons"),
							"desc" => __("How many products showed", "trx_addons"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns per row use for products output", "trx_addons"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'trx_addons'),
								"title" => __('Title', 'trx_addons')
							)
						),
						"order" => array(
							"title" => __("Order", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Product Category
				$THEMEREX_GLOBALS['shortcodes']["product_category"] = array(
					"title" => __("Woocommerce: Products from category", "trx_addons"),
					"desc" => __("WooCommerce shortcode: list products in specified category(-ies)", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", "trx_addons"),
							"desc" => __("How many products showed", "trx_addons"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns per row use for products output", "trx_addons"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'trx_addons'),
								"title" => __('Title', 'trx_addons')
							)
						),
						"order" => array(
							"title" => __("Order", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						),
						"category" => array(
							"title" => __("Categories", "trx_addons"),
							"desc" => __("Comma separated category slugs", "trx_addons"),
							"value" => '',
							"type" => "text"
						),
						"operator" => array(
							"title" => __("Operator", "trx_addons"),
							"desc" => __("Categories operator", "trx_addons"),
							"value" => "IN",
							"type" => "checklist",
							"size" => "medium",
							"options" => array(
								"IN" => __('IN', 'trx_addons'),
								"NOT IN" => __('NOT IN', 'trx_addons'),
								"AND" => __('AND', 'trx_addons')
							)
						)
					)
				);
				
				// WooCommerce - Products
				$THEMEREX_GLOBALS['shortcodes']["products"] = array(
					"title" => __("Woocommerce: Products", "trx_addons"),
					"desc" => __("WooCommerce shortcode: list all products", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"skus" => array(
							"title" => __("SKUs", "trx_addons"),
							"desc" => __("Comma separated SKU codes of products", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"ids" => array(
							"title" => __("IDs", "trx_addons"),
							"desc" => __("Comma separated ID of products", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns per row use for products output", "trx_addons"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'trx_addons'),
								"title" => __('Title', 'trx_addons')
							)
						),
						"order" => array(
							"title" => __("Order", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Product attribute
				$THEMEREX_GLOBALS['shortcodes']["product_attribute"] = array(
					"title" => __("Woocommerce: Products by Attribute", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show products with specified attribute", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", "trx_addons"),
							"desc" => __("How many products showed", "trx_addons"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns per row use for products output", "trx_addons"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'trx_addons'),
								"title" => __('Title', 'trx_addons')
							)
						),
						"order" => array(
							"title" => __("Order", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						),
						"attribute" => array(
							"title" => __("Attribute", "trx_addons"),
							"desc" => __("Attribute name", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"filter" => array(
							"title" => __("Filter", "trx_addons"),
							"desc" => __("Attribute value", "trx_addons"),
							"value" => "",
							"type" => "text"
						)
					)
				);
				
				// WooCommerce - Products Categories
				$THEMEREX_GLOBALS['shortcodes']["product_categories"] = array(
					"title" => __("Woocommerce: Product Categories", "trx_addons"),
					"desc" => __("WooCommerce shortcode: show categories with products", "trx_addons"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"number" => array(
							"title" => __("Number", "trx_addons"),
							"desc" => __("How many categories showed", "trx_addons"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", "trx_addons"),
							"desc" => __("How many columns per row use for categories output", "trx_addons"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'trx_addons'),
								"title" => __('Title', 'trx_addons')
							)
						),
						"order" => array(
							"title" => __("Order", "trx_addons"),
							"desc" => __("Sorting order for products output", "trx_addons"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $THEMEREX_GLOBALS['sc_params']['ordering']
						),
						"parent" => array(
							"title" => __("Parent", "trx_addons"),
							"desc" => __("Parent category slug", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"ids" => array(
							"title" => __("IDs", "trx_addons"),
							"desc" => __("Comma separated ID of products", "trx_addons"),
							"value" => "",
							"type" => "text"
						),
						"hide_empty" => array(
							"title" => __("Hide empty", "trx_addons"),
							"desc" => __("Hide empty categories", "trx_addons"),
							"value" => "yes",
							"type" => "switch",
							"options" => $THEMEREX_GLOBALS['sc_params']['yes_no']
						)
					)
				);

			}
			
			do_action('themerex_action_shortcodes_list');

		}
	}
}
?>