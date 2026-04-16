<?php
/**
 * globallogistics skin file for theme.
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('themerex_skin_theme_setup_globallogistics')) {
	add_action( 'themerex_action_init_theme', 'themerex_skin_theme_setup_globallogistics', 1 );
	function themerex_skin_theme_setup_globallogistics() {

		// Add skin fonts in the used fonts list
		add_filter('themerex_filter_used_fonts',			'themerex_filter_used_fonts_globallogistics');
		// Add skin fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('themerex_filter_list_fonts',			'themerex_filter_list_fonts_globallogistics');

		// Add skin stylesheets
		add_action('themerex_action_add_styles',			'themerex_action_add_styles_globallogistics');
		// Add skin inline styles
		add_filter('themerex_filter_add_styles_inline',		'themerex_filter_add_styles_inline_globallogistics');
		// Add skin responsive styles
		add_action('themerex_action_add_responsive',		'themerex_action_add_responsive_globallogistics');
		// Add skin responsive inline styles
		add_filter('themerex_filter_add_responsive_inline',	'themerex_filter_add_responsive_inline_globallogistics');

		// Add skin scripts
		add_action('themerex_action_add_scripts',			'themerex_action_add_scripts_globallogistics');
		// Add skin scripts inline
		add_filter('themerex_action_add_scripts_inline',	'themerex_action_add_scripts_inline_globallogistics');

		// Return main color (if not set in the theme options)
		add_filter('themerex_filter_get_main_color',		'themerex_filter_get_main_color_globallogistics', 10, 1);
		// Return accent color (if not set in the theme options)
		add_filter('themerex_filter_get_accent_color',			'themerex_filter_get_accent_color_globallogistics',  10, 1);
	}
}




//------------------------------------------------------------------------------
// Skin's fonts
//------------------------------------------------------------------------------

// Add skin fonts in the used fonts list
if (!function_exists('themerex_filter_used_fonts_globallogistics')) {
	//Handler of add_filter('themerex_filter_used_fonts', 'themerex_filter_used_fonts_globallogistics');
	function themerex_filter_used_fonts_globallogistics($theme_fonts) {
		$theme_fonts['Hind'] = 1;
		$theme_fonts['Ubuntu'] = 1;
		$theme_fonts['Roboto'] = 1;
		return $theme_fonts;
	}
}

// Add skin fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('themerex_filter_list_fonts_globallogistics')) {
	//Handler of add_filter('themerex_filter_list_fonts', 'themerex_filter_list_fonts_globallogistics');
	function themerex_filter_list_fonts_globallogistics($list) {
		if (!isset($list['Hind']))				$list['Hind'] = array('family'=>'sans-serif');
		if (!isset($list['Ubuntu']))				$list['Ubuntu'] = array('family'=>'sans-serif');
		if (!isset($list['Roboto']))				$list['Roboto'] = array('family'=>'sans-serif');
		if (!isset($list['Love Ya Like A Sister']))	$list['Love Ya Like A Sister'] = array('family'=>'cursive', 'link'=>'Love+Ya+Like+A+Sister:400&subset=latin');
		return $list;
	}
}


//------------------------------------------------------------------------------
// Skin's stylesheets
//------------------------------------------------------------------------------
// Add skin stylesheets
if (!function_exists('themerex_action_add_styles_globallogistics')) {
	//Handler of add_action('themerex_action_add_styles', 'themerex_action_add_styles_globallogistics');
	function themerex_action_add_styles_globallogistics() {
		// Add stylesheet files
		wp_enqueue_style( 'themerex-skin-style', themerex_get_file_url('skins/globallogistics/skin.css'), array(), null );
	}
}

// Add skin inline styles
if (!function_exists('themerex_filter_add_styles_inline_globallogistics')) {
	//Handler of add_filter('themerex_filter_add_styles_inline', 'themerex_filter_add_styles_inline_globallogistics');
	function themerex_filter_add_styles_inline_globallogistics($custom_style) {

		// Main color
		$clr = themerex_get_custom_option('main_color');
		if (!empty($clr)) {
			$rgb = themerex_hex2rgb($clr);
			$custom_style .= '
				.main_color,
				.hover_wrap .hover_link,
				.hover_wrap .hover_view,
				.isotope_wrap .isotope_item_grid .post_item .hover_wrap .hover_content a.hover,
				.isotope_wrap .isotope_item_square .post_item .hover_wrap .hover_content a.hover,
				.isotope_wrap .isotope_item_portfolio .post_item .hover_wrap .hover_content a.hover,
				.isotope_wrap .isotope_item_alternative .post_item .hover_wrap .hover_content a.hover,
				.hover_icon:before,
				.post_format_link .post_descr a,
				.pagination_viewmore > a,
				.reviews_block .reviews_item .reviews_stars_hover,
				.post_item .post_rating .reviews_stars_bg,
				.post_item .post_rating .reviews_stars_hover,
				.post_item .post_rating .reviews_value,
				.widget_area ul li:before,
				.widget_area.bg_tint_dark ul li:before,
				.widget_area.bg_tint_dark button:before,
				.widget_area .widget_search .search_button:hover:before,
				.sc_accordion.sc_accordion_style_1 .sc_accordion_item .sc_accordion_title.ui-state-active,
				.sc_accordion.sc_accordion_style_1 .sc_accordion_item .sc_accordion_title.ui-state-active .sc_accordion_icon:before,
				.sc_accordion.sc_accordion_style_1 .sc_accordion_item .sc_accordion_title:hover .sc_accordion_icon:before,
				.sc_accordion.sc_accordion_style_2 .sc_accordion_item .sc_accordion_title.ui-state-active .sc_accordion_icon:before,
				.sc_accordion.sc_accordion_style_2 .sc_accordion_item .sc_accordion_title:hover .sc_accordion_icon:before,
				input[type="submit"],
				input[type="button"],
				button,
				.sc_button,
				.sc_dropcaps.sc_dropcaps_style_1 .sc_dropcaps_item,
				.sc_socials a span,
				.sc_emailer .sc_emailer_button:hover,
				blockquote.sc_quote.style_1:before,
				.sc_icon,
				.sc_list_style_iconed li:before,
				.sc_list_style_iconed .sc_list_icon,
				.sc_testimonials .sc_slider_controls_wrap a,
				.sc_tabs.sc_tabs_style_3 .sc_tabs_titles li a:hover,
				.sc_tabs.sc_tabs_style_3 .sc_tabs_titles li.ui-state-active a,
				.sc_title_icon,
				.widget_area .widget_twitter ul li:before,
				.sc_contact_form_topic .sc_contact_form_button button,
				.sc_contact_form .sc_contact_form_button button:hover,
				.sc_contact_form .sc_contact_form_button button:active
				'.(!themerex_exists_woocommerce() ? '' : ',
					/* WooCommerce styles */
					.woocommerce .woocommerce-message:before, .woocommerce-page .woocommerce-message:before,
					.woocommerce div.product span.price, .woocommerce div.product p.price, .woocommerce #content div.product span.price, .woocommerce #content div.product p.price, .woocommerce-page div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page #content div.product p.price,.woocommerce ul.products li.product .price,.woocommerce-page ul.products li.product .price,
					.woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce #content input.button.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page #content input.button.alt:hover,
					.woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce #content input.button:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page #content input.button:hover,
					.woocommerce .quantity input[type="button"]:hover, .woocommerce #content input[type="button"]:hover, .woocommerce-page .quantity input[type="button"]:hover, .woocommerce-page #content .quantity input[type="button"]:hover,
					.woocommerce ul.cart_list li > .amount, .woocommerce ul.product_list_widget li > .amount, .woocommerce-page ul.cart_list li > .amount, .woocommerce-page ul.product_list_widget li > .amount,
					.woocommerce ul.cart_list li span .amount, .woocommerce ul.product_list_widget li span .amount, .woocommerce-page ul.cart_list li span .amount, .woocommerce-page ul.product_list_widget li span .amount,
					.woocommerce ul.cart_list li ins .amount, .woocommerce ul.product_list_widget li ins .amount, .woocommerce-page ul.cart_list li ins .amount, .woocommerce-page ul.product_list_widget li ins .amount,
					.woocommerce.widget_shopping_cart .total .amount, .woocommerce .widget_shopping_cart .total .amount, .woocommerce-page.widget_shopping_cart .total .amount, .woocommerce-page .widget_shopping_cart .total .amount,
					.woocommerce a:hover h3, .woocommerce-page a:hover h3,
					.woocommerce .cart-collaterals .order-total strong, .woocommerce-page .cart-collaterals .order-total strong,
					.woocommerce .checkout #order_review .order-total .amount, .woocommerce-page .checkout #order_review .order-total .amount,
					.woocommerce .star-rating, .woocommerce-page .star-rating, .woocommerce .star-rating:before, .woocommerce-page .star-rating:before,
					.widget_area .widgetWrap ul > li .star-rating span, .woocommerce #review_form #respond .stars a, .woocommerce-page #review_form #respond .stars a,
					.woocommerce .summary .price,
					.woocommerce-page .summary .price,
					.woocommerce ul.products li.product .price,
					.woocommerce-page ul.products li.product .price,
					ul.products li.product .price,
					.products .product_price
				').'
				{
					color:'.esc_attr($clr).';
				}

				.sc_button_bg_underline,
				.sc_button_bg_underline:hover,
				.sc_button_bg_underline:active,
				header .sidebar_cart .widget_shopping_cart_content .cart_list li a.remove:hover
				{
					color:'.esc_attr($clr).' !important;
				}

				.main_color_bgc,
				.hover_wrap .hover_link:hover,
				.hover_wrap .hover_view:hover,
				.post_format_status .post_descr,
				.isotope_wrap .isotope_item_grid .post_item .hover_wrap .hover_content a.hover:hover,
				.isotope_wrap .isotope_item_square .post_item .hover_wrap .hover_content a.hover:hover,
				.isotope_wrap .isotope_item_portfolio .post_item .hover_wrap .hover_content a.hover:hover,
				.isotope_wrap .isotope_item_alternative .post_item .hover_wrap .hover_content a.hover:hover,
				.pagination_viewmore > a:hover,
				.viewmore_loader,
				.mfp-preloader span,
				.sc_video_frame.sc_video_active:before,
				.post_featured .post_nav_item:before,
				.post_featured .post_nav_item .post_nav_info,
				.reviews_block .reviews_max_level_100 .reviews_stars_hover,
				.reviews_block .reviews_item .reviews_slider,
				.scroll_to_top,
				.sc_accordion.sc_accordion_style_1 .sc_accordion_item .sc_accordion_title,
				.sc_accordion.sc_accordion_style_2 .sc_accordion_item .sc_accordion_title .sc_accordion_icon:before,
				input[type="submit"]:hover,
				input[type="button"]:hover,
				button:hover,
				.sc_button:hover,
				.sc_dropcaps.sc_dropcaps_style_2 .sc_dropcaps_item,
				.sc_dropcaps.sc_dropcaps_style_3 .sc_dropcaps_item,
				.sc_highlight_style_1,
				.sc_popup:before,
				.sc_price_block .sc_price_block_head,
				.sc_skills_bar .sc_skills_item .sc_skills_count,
				.sc_skills_counter .sc_skills_item.sc_skills_style_3 .sc_skills_count,
				.sc_skills_counter .sc_skills_item.sc_skills_style_4 .sc_skills_count,
				.sc_skills_counter .sc_skills_item.sc_skills_style_4 .sc_skills_info,
				.sc_testimonials .sc_slider_controls_wrap a:hover,
				.sc_scroll_bar .swiper-scrollbar-drag:before,
				.sc_tabs.sc_tabs_style_2 .sc_tabs_titles li a:hover,
				.sc_tabs.sc_tabs_style_2 .sc_tabs_titles li.ui-state-active a,
				.sc_team .sc_team_item .sc_team_item_info,
				.bg_tint_light .sc_slider_swiper .sc_slider_pagination_wrap span,
				.sc_title_divider .sc_title_divider_before,
				.sc_title_divider .sc_title_divider_after,
				.sc_contact_form_topic .sc_contact_form_button button:hover,
				.sc_contact_form_topic .sc_contact_form_button button:active,
				.contact_info .info_icon:before
				'.(!themerex_exists_woocommerce() ? '' : ',
					/* WooCommerce styles */
					.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
					.woocommerce-page .widget_price_filter .ui-slider .ui-slider-range,
					.woocommerce span.new, .woocommerce-page span.new,
					.woocommerce span.onsale, .woocommerce-page span.onsale
				').'
				{
					background-color: '.esc_attr($clr).';
				}

				.custom_options #co_toggle {
					background-color: '.esc_attr($clr).' !important;
				}

				::selection {
					background-color: '.esc_attr($clr).';
				}
				::-moz-selection {
					background-color: '.esc_attr($clr).';
				}

				.main_color_bg,
				.photostack nav span:hover,
				.photostack nav span.current,
				.sc_contact_form .sc_contact_form_button button
				{
					background: '.esc_attr($clr).';
				}

				.main_color_border,
				td, th,
				pre.code,
				#toc .toc_item.current,
				#toc .toc_item:hover,
				.hover_wrap .hover_link,
				.hover_wrap .hover_view,
				.isotope_wrap .isotope_item_grid .post_item .hover_wrap .hover_content a.hover,
				.isotope_wrap .isotope_item_square .post_item .hover_wrap .hover_content a.hover,
				.isotope_wrap .isotope_item_portfolio .post_item .hover_wrap .hover_content a.hover,
				.isotope_wrap .isotope_item_alternative .post_item .hover_wrap .hover_content a.hover,
				.post_format_link .post_descr a:hover,
				.pagination_viewmore > a,
				.widget_area .widget_calendar td a,
				.widget_area .widget_calendar .today .day_wrap,
				.widget_area .widget_product_tag_cloud a,
				.widget_area .widget_tag_cloud a,
				.sc_accordion.sc_accordion_style_2 .sc_accordion_item .sc_accordion_title .sc_accordion_icon:before,
				input[type="submit"],
				input[type="button"],
				button,
				.sc_button,
				input[type="submit"]:hover,
				input[type="button"]:hover,
				button:hover,
				.sc_button:hover,
				.sc_dropcaps.sc_dropcaps_style_1 .sc_dropcaps_item,
				.sc_socials a,
				.sc_icon_shape_square,
				.sc_icon_shape_round,
				.sc_skills_bar .sc_skills_item .sc_skills_count,
				.sc_testimonials .sc_slider_controls_wrap a,
				.widget_area .sc_tabs.sc_tabs_style_2 .sc_tabs_titles li a,
				.sc_tabs.sc_tabs_style_2 .sc_tabs_titles li a:hover,
				.sc_tabs.sc_tabs_style_2 .sc_tabs_titles li.ui-state-active a,
				.bg_tint_light .sc_slider_swiper .sc_slider_pagination_wrap span:hover,
				.bg_tint_light .sc_slider_swiper .sc_slider_pagination_wrap .swiper-active-switch,
				.bg_tint_dark .sc_slider_swiper .sc_slider_pagination_wrap span:hover,
				.bg_tint_dark .sc_slider_swiper .sc_slider_pagination_wrap .swiper-active-switch,
				.sc_title_underline:after,
				.sc_contact_form .sc_contact_form_button button,
				.sc_contact_form_topic .sc_contact_form_button button,
				.sc_contact_form .sc_contact_form_button button:hover,
				.sc_contact_form .sc_contact_form_button button:active,
				.sc_contact_form_topic .sc_contact_form_button button:hover,
				.sc_contact_form_topic .sc_contact_form_button button:active
				{
					border-color: '.esc_attr($clr).'; 
				}

				.sc_button_bg_underline:hover,
				.sc_button_bg_underline:active
				{
					border-color: '.esc_attr($clr).' !important;
				}

				.sc_tabs.sc_tabs_style_1 .sc_tabs_titles li.ui-state-active a,
				.sc_tabs.sc_tabs_style_1 .sc_tabs_titles li a:hover {
					border-bottom-color: '.esc_attr($clr).';
				}
			';
		}



		// Accent color
		$clr = themerex_get_custom_option('accent_color');
		if (!empty($clr)) {
			$rgb = themerex_hex2rgb($clr);
			$custom_style .= '
				a,
				a:hover,
				.accent_color,
				a.accent_color:hover,
				.menu_user_wrap,
				.menu_user_wrap .menu_user_nav li > a,
				.isotope_wrap .isotope_item_grid .post_item .hover_wrap .hover_content .info,
				.isotope_wrap .isotope_item_square .post_item .hover_wrap .hover_content .info,
				.isotope_wrap .isotope_item_portfolio .post_item .hover_wrap .hover_content .info,
				.isotope_wrap .isotope_item_alternative .post_item .hover_wrap .hover_content .info,
				.isotope_wrap .isotope_item_grid .post_item .hover_wrap .hover_content .info a,
				.isotope_wrap .isotope_item_square .post_item .hover_wrap .hover_content .info a,
				.isotope_wrap .isotope_item_portfolio .post_item .hover_wrap .hover_content .info a,
				.isotope_wrap .isotope_item_alternative .post_item .hover_wrap .hover_content .info a,
				.content .post_info .post_info_counters span,
				.content .post_info a.post_counters_views,
				.widget_area .post_info .post_info_counters .post_counters_item:before,
				.widget_area .post_info .post_info_counters .post_counters_likes.disabled,
				.post_info .post_info_counters .post_counters_item:before,
				.post_info .post_info_counters .post_counters_likes.disabled,
				.widget_area .post_item .post_info .post_info_author,
				.widget_area .post_item .post_info .post_info_posted_by,
				.post_info .post_info_posted_by,
				.post_info .post_info_posted_by a,
				.top_socials .sc_socials a > span,
				.sc_image_wrap figcaption,
				.sc_image_wrap figcaption a,
				.sc_tabs.sc_tabs_style_1 .sc_tabs_titles li a
				'.(!themerex_exists_woocommerce() ? '' : ',
					/* WooCommerce styles */
					.woocommerce nav.woocommerce-pagination ul li a:focus,
					.woocommerce nav.woocommerce-pagination ul li a:hover,
					.woocommerce nav.woocommerce-pagination ul li span.current
				').'
				{
					color:'.esc_attr($clr).';
				}

				.timeline.flatLine #t_line_left:hover,
				.timeline.flatLine #t_line_right:hover,
				#content .timeline.flatLine #t_line_left:hover,
				#content .timeline.flatLine #t_line_right:hover
				{
					color:'.esc_attr($clr).' !important;
				}

				.accent_color_bgc,
				.pagination_single a:hover,
				.pagination_slider .pager_cur:hover,
				.pagination_slider .pager_cur:focus,
				.pagination_pages > .active,
				.pagination_pages > a:hover,
				.pagination_wrap .pager_next:hover,
				.pagination_wrap .pager_prev:hover,
				.pagination_wrap .pager_last:hover,
				.pagination_wrap .pager_first:hover,
				.tribe-events-calendar thead th,
				a.tribe-events-read-more,
				.tribe-events-button,
				.tribe-events-nav-previous a,
				.tribe-events-nav-next a,
				.tribe-events-widget-link a,
				.tribe-events-viewmore a,
				.sc_blogger.layout_date .sc_blogger_item .sc_blogger_date,
				.sc_skills_counter .sc_skills_item.sc_skills_style_2 .sc_skills_info
				'.(!themerex_exists_woocommerce() ? '' : ',
					/* WooCommerce styles */
					.woocommerce nav.woocommerce-pagination ul li a,
					.woocommerce nav.woocommerce-pagination ul li span.current
				').'
				{
					background-color: '.esc_attr($clr).';
				}

				.accent_color_bg
				{
					background: '.esc_attr($clr).';
				}

				.timeline.flatLine a.t_line_node:after,
				#content .timeline.flatLine a.t_line_node:after,
				.timeline.flatLine .t_node_desc span,
				#content .timeline.flatLine .t_node_desc span
				{
					background: '.esc_attr($clr).' !important;
				}

				.accent_color_border,
				a:hover,
				.search_wrap .search_results a:hover,
				.pagination > a,
				.sc_blogger.layout_date .sc_blogger_item .sc_blogger_date
				'.(!themerex_exists_woocommerce() ? '' : ',
					/* WooCommerce styles */
					.woocommerce nav.woocommerce-pagination ul li a,
					.woocommerce nav.woocommerce-pagination ul li span.current
				').'
				{
					border-color: '.esc_attr($clr).';
				}

				.timeline.flatLine .t_node_desc span:after,
				#content .timeline.flatLine .t_node_desc span:after {
					border-top-color: '.esc_attr($clr).' !important;
				}

				.top_panel_image_hover {
					background-color: rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].', 0.8);
				}
			';
		}

		return $custom_style;
	}
}

// Add skin responsive styles
if (!function_exists('themerex_action_add_responsive_globallogistics')) {
	//Handler of add_action('themerex_action_add_responsive', 'themerex_action_add_responsive_globallogistics');
	function themerex_action_add_responsive_globallogistics() {
		if (file_exists(themerex_get_file_dir('skins/globallogistics/skin-responsive.css')))
			wp_enqueue_style( 'theme-skin-responsive-style', themerex_get_file_url('skins/globallogistics/skin-responsive.css'), array(), null );
	}
}

// Add skin responsive inline styles
if (!function_exists('themerex_filter_add_responsive_inline_globallogistics')) {
	//Handler of add_filter('themerex_filter_add_responsive_inline', 'themerex_filter_add_responsive_inline_globallogistics');
	function themerex_filter_add_responsive_inline_globallogistics($custom_style) {
		return $custom_style;	
	}
}


//------------------------------------------------------------------------------
// Skin's scripts
//------------------------------------------------------------------------------

// Add skin scripts
if (!function_exists('themerex_action_add_scripts_globallogistics')) {
	//Handler of add_action('themerex_action_add_scripts', 'themerex_action_add_scripts_globallogistics');
	function themerex_action_add_scripts_globallogistics() {
		if (file_exists(themerex_get_file_dir('skins/globallogistics/skin.js')))
			wp_enqueue_script( 'themerex-skin-script', themerex_get_file_url('skins/globallogistics/skin.js'), array(), null );
		if (themerex_get_theme_option('show_theme_customizer') == 'yes' && file_exists(themerex_get_file_dir('skins/globallogistics/skin.customizer.js')))
			wp_enqueue_script( 'themerex-skin-customizer-script', themerex_get_file_url('skins/globallogistics/skin.customizer.js'), array(), null );
	}
}

// Add skin scripts inline
if (!function_exists('themerex_action_add_scripts_inline_globallogistics')) {
	//Handler of add_action('themerex_action_add_scripts_inline', 'themerex_action_add_scripts_inline_globallogistics');
	function themerex_action_add_scripts_inline_globallogistics($vars=array()) {
        $vars['theme_font'] = 'Hind';
        $vars['main_color'] = apply_filters('themerex_filter_get_main_color', themerex_get_custom_option('main_color'));
        $vars['accent_color'] = apply_filters('themerex_filter_get_accent_color', themerex_get_custom_option('accent_color'));
        return $vars;
	}
}


//------------------------------------------------------------------------------
// Get skin's colors
//------------------------------------------------------------------------------


// Return main theme bg color
if (!function_exists('themerex_filter_get_theme_bgcolor_globallogistics')) {
	//Handler of add_filter('themerex_filter_get_theme_bgcolor', 'themerex_filter_get_theme_bgcolor_globallogistics', 10, 1);
	function themerex_filter_get_theme_bgcolor_globallogistics($clr) {
		return empty($clr) ? '#ffffff' : $clr;
	}
}

// Return main color (if not set in the theme options)
if (!function_exists('themerex_filter_get_main_color_globallogistics')) {
	//Handler of add_filter('themerex_filter_get_main_color', 'themerex_filter_get_main_color_globallogistics', 10, 1);
	function themerex_filter_get_main_color_globallogistics($clr) {
		return empty($clr) ? '#eeba00' : $clr;
	}
}

// Return accent color (if not set in the theme options)
if (!function_exists('themerex_filter_get_accent_color_globallogistics')) {
	//Handler of add_filter('themerex_filter_get_accent_color', 'themerex_filter_get_accent_color_globallogistics', 10, 1);
	function themerex_filter_get_accent_color_globallogistics($clr) {
		return empty($clr) ? '#5cb9e2' : $clr;
	}
}
?>