<?php
/* Woocommerce support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('themerex_woocommerce_theme_setup')) {
	add_action( 'themerex_action_before_init_theme', 'themerex_woocommerce_theme_setup', 1 );
	function themerex_woocommerce_theme_setup() {

		if (themerex_exists_woocommerce()) {

            add_theme_support('woocommerce');
			// Next setting from the WooCommerce 3.0+ enable built-in image zoom on the single product page
			add_theme_support( 'wc-product-gallery-zoom' );

			// Next setting from the WooCommerce 3.0+ enable built-in image slider on the single product page
			add_theme_support( 'wc-product-gallery-slider' );

			// Next setting from the WooCommerce 3.0+ enable built-in image lightbox on the single product page
			add_theme_support( 'wc-product-gallery-lightbox' );
			
			add_action('themerex_action_add_styles', 				'themerex_woocommerce_frontend_scripts' );

			// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
			add_filter('themerex_filter_get_blog_type',				'themerex_woocommerce_get_blog_type', 9, 2);
			add_filter('themerex_filter_get_blog_title',			'themerex_woocommerce_get_blog_title', 9, 2);
			add_filter('themerex_filter_get_current_taxonomy',		'themerex_woocommerce_get_current_taxonomy', 9, 2);
			add_filter('themerex_filter_is_taxonomy',				'themerex_woocommerce_is_taxonomy', 9, 2);
			add_filter('themerex_filter_get_stream_page_title',		'themerex_woocommerce_get_stream_page_title', 9, 2);
			add_filter('themerex_filter_get_stream_page_link',		'themerex_woocommerce_get_stream_page_link', 9, 2);
			add_filter('themerex_filter_get_stream_page_id',		'themerex_woocommerce_get_stream_page_id', 9, 2);
			add_filter('themerex_filter_detect_inheritance_key',	'themerex_woocommerce_detect_inheritance_key', 9, 1);
			add_filter('themerex_filter_detect_template_page_id',	'themerex_woocommerce_detect_template_page_id', 9, 2);
			add_filter('themerex_filter_orderby_need',				'themerex_woocommerce_orderby_need', 9, 2);

			add_filter('themerex_filter_list_post_types', 			'themerex_woocommerce_list_post_types', 10, 1);
		}
	}
}

if ( !function_exists( 'themerex_woocommerce_settings_theme_setup2' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_woocommerce_settings_theme_setup2', 3 );
	function themerex_woocommerce_settings_theme_setup2() {
		if (themerex_exists_woocommerce()) {
			themerex_add_theme_inheritance( array( 'woocommerce' => array(
				'stream_template' => '',
				'single_template' => '',
				'taxonomy' => array('product_cat'),
				'taxonomy_tags' => array('product_tag'),
				'post_type' => array('product'),
				'override' => 'post'
				) )
			);
			themerex_add_theme_inheritance( array( 'woocommerce_cart' => array(
				'stream_template' => '',
				'single_template' => '',
				'taxonomy' => '',
				'taxonomy_tags' => '',
				'post_type' => '',
				'override' => 'page'
				) )
			);
			themerex_add_theme_inheritance( array( 'woocommerce_checkout' => array(
				'stream_template' => '',
				'single_template' => '',
				'taxonomy' => '',
				'taxonomy_tags' => '',
				'post_type' => '',
				'override' => 'page'
				) )
			);
			themerex_add_theme_inheritance( array( 'woocommerce_account' => array(
				'stream_template' => '',
				'single_template' => '',
				'taxonomy' => '',
				'taxonomy_tags' => '',
				'post_type' => '',
				'override' => 'page'
				) )
			);
		}
	}
}

// WooCommerce hooks
if (!function_exists('themerex_woocommerce_theme_setup3')) {
	add_action( 'themerex_action_after_init_theme', 'themerex_woocommerce_theme_setup3' );
	function themerex_woocommerce_theme_setup3() {
		if (themerex_exists_woocommerce() ) {
			remove_action( 'woocommerce_sidebar', 						'woocommerce_get_sidebar', 10 );					// Remove WOOC sidebar

			remove_action( 'woocommerce_before_main_content',			'woocommerce_output_content_wrapper', 10);
			add_action(    'woocommerce_before_main_content',			'themerex_woocommerce_wrapper_start', 10);

			remove_action( 'woocommerce_after_main_content',			'woocommerce_output_content_wrapper_end', 10);
			add_action(    'woocommerce_after_main_content',			'themerex_woocommerce_wrapper_end', 10);

			add_action(    'woocommerce_show_page_title',				'themerex_woocommerce_show_page_title', 10);

			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5 );


			remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_title', 5);
			add_action(    'woocommerce_single_product_summary',		'themerex_woocommerce_show_product_title', 5 );


			add_action(    'woocommerce_before_shop_loop', 				'themerex_woocommerce_before_shop_loop', 10 );

			remove_action( 'woocommerce_after_shop_loop',				'woocommerce_pagination', 10 );
			add_action(    'woocommerce_after_shop_loop',				'themerex_woocommerce_pagination', 10 );

			add_action(    'woocommerce_before_subcategory_title',		'themerex_woocommerce_open_thumb_wrapper', 9 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'themerex_woocommerce_open_thumb_wrapper', 9 );

			add_action(    'woocommerce_before_subcategory_title',		'themerex_woocommerce_open_item_wrapper', 20 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'themerex_woocommerce_open_item_wrapper', 20 );
            // Wrap category title into link
            remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
            add_action( 'woocommerce_shop_loop_subcategory_title',  'themerex_woocommerce_shop_loop_subcategory_title', 9, 1);

			add_action(    'woocommerce_after_subcategory',				'themerex_woocommerce_close_item_wrapper', 20 );
			add_action(    'woocommerce_after_shop_loop_item',			'themerex_woocommerce_close_item_wrapper', 20 );

			add_action(    'woocommerce_after_shop_loop_item_title',    'themerex_woocommerce_after_price', 11);
			add_action(    'woocommerce_after_shop_loop_item_title',    'themerex_woocommerce_before_price', 9);

			//Handler of add_action(    'woocommerce_after_shop_loop_item_title',	'themerex_woocommerce_after_shop_loop_item_title', 7);
			add_action(    'woocommerce_before_shop_loop_item_title',	'themerex_woocommerce_after_shop_loop_item_title', 20);

			add_action(    'woocommerce_after_subcategory_title',		'themerex_woocommerce_after_subcategory_title', 10 );

			add_action(    'woocommerce_product_meta_end',				'themerex_woocommerce_show_product_id', 10);

			add_filter(    'woocommerce_output_related_products_args',	'themerex_woocommerce_output_related_products_args' );
			
			add_filter(    'woocommerce_product_thumbnails_columns',	'themerex_woocommerce_product_thumbnails_columns' );

			add_filter(    'loop_shop_columns',							'themerex_woocommerce_loop_shop_columns' );

			if (themerex_is_woocommerce_page()) {

				add_action(    'woocommerce_single_product_summary',    'themerex_woocommerce_after_price', 11);
				add_action(    'woocommerce_single_product_summary',    'themerex_woocommerce_before_price', 9);


				add_filter('woocommerce_output_related_products_args', 'themerex_woocommerce_output_related_products_args');

				add_filter('woocommerce_product_thumbnails_columns', 'themerex_woocommerce_product_thumbnails_columns');

				add_filter('loop_shop_columns', 'themerex_woocommerce_loop_shop_columns');

				add_filter('get_product_search_form', 'themerex_woocommerce_get_product_search_form');

				add_filter(    'post_class',								'themerex_woocommerce_loop_shop_columns_class' );

				themerex_enqueue_formstyler();

			}

			add_action(    'the_title',									'themerex_woocommerce_the_title');
		}
	}
}


// Check if WooCommerce installed and activated
if ( !function_exists( 'themerex_exists_woocommerce' ) ) {
	function themerex_exists_woocommerce() {
		return class_exists('Woocommerce');
	}
}

// Return true, if current page is any woocommerce page
if ( !function_exists( 'themerex_is_woocommerce_page' ) ) {
	function themerex_is_woocommerce_page() {
		return function_exists('is_woocommerce') ? is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() : false;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'themerex_woocommerce_detect_inheritance_key' ) ) {
	//Handler of add_filter('themerex_filter_detect_inheritance_key',	'themerex_woocommerce_detect_inheritance_key', 9, 1);
	function themerex_woocommerce_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		if (is_cart())								$key = 'woocommerce_cart';
		else if (is_checkout())						$key = 'woocommerce_checkout';
		else if (is_account_page())					$key = 'woocommerce_account';
		else if (themerex_is_woocommerce_page())	$key = 'woocommerce';
		return $key;
	}
}

// Filter to detect current template page id
if ( !function_exists( 'themerex_woocommerce_detect_template_page_id' ) ) {
	//Handler of add_filter('themerex_filter_detect_template_page_id',	'themerex_woocommerce_detect_template_page_id', 9, 2);
	function themerex_woocommerce_detect_template_page_id($id, $key) {
		if (!empty($id)) return $id;
		if ($key == 'woocommerce_cart')				$id = get_option('woocommerce_cart_page_id');
		else if ($key == 'woocommerce_checkout')	$id = get_option('woocommerce_checkout_page_id');
		else if ($key == 'woocommerce_account')		$id = get_option('woocommerce_account_page_id');
		else if ($key == 'woocommerce')				$id = get_option('woocommerce_shop_page_id');
		return $id;
	}
}

// Filter to detect current page type (slug)
if ( !function_exists( 'themerex_woocommerce_get_blog_type' ) ) {
	//Handler of add_filter('themerex_filter_get_blog_type',	'themerex_woocommerce_get_blog_type', 9, 2);
	function themerex_woocommerce_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;

		if (is_shop()) 					$page = 'woocommerce_shop';
		else if ($query && $query->get('product_cat')!='' || is_product_category())	$page = 'woocommerce_category';
		else if ($query && $query->get('product_tag')!='' || is_product_tag())		$page = 'woocommerce_tag';
		else if ($query && $query->get('post_type')=='product' || is_product())		$page = 'woocommerce_product';
		else if (is_cart())				$page = 'woocommerce_cart';
		else if (is_checkout())			$page = 'woocommerce_checkout';
		else if (is_account_page())		$page = 'woocommerce_account';
		else if (is_woocommerce())		$page = 'woocommerce';

		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'themerex_woocommerce_get_blog_title' ) ) {
	//Handler of add_filter('themerex_filter_get_blog_title',	'themerex_woocommerce_get_blog_title', 9, 2);
	function themerex_woocommerce_get_blog_title($title, $page) {
		if (!empty($title)) return $title;

		if ( themerex_strpos($page, 'woocommerce')!==false ) {
			if ( $page == 'woocommerce_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'product_cat' ), 'product_cat', OBJECT);
				$title = $term->name;
			} else if ( $page == 'woocommerce_tag' ) {
				$term = get_term_by( 'slug', get_query_var( 'product_tag' ), 'product_tag', OBJECT);
				$title = esc_html__('Tag:', 'globallogistics') . ' ' . esc_html($term->name);
			} else if ( $page == 'woocommerce_cart' ) {
				$title = esc_html__( 'Your cart', 'globallogistics' );
			} else if ( $page == 'woocommerce_checkout' ) {
				$title = esc_html__( 'Checkout', 'globallogistics' );
			} else if ( $page == 'woocommerce_account' ) {
				$title = esc_html__( 'Account', 'globallogistics' );
			} else if ( $page == 'woocommerce_product' ) {
				$title = themerex_get_post_title();
			} else if (($page_id=get_option('woocommerce_shop_page_id')) > 0) {
				$title = themerex_get_post_title($page_id);
			} else {
				$title = esc_html__( 'Shop', 'globallogistics' );
			}
		}

		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'themerex_woocommerce_get_stream_page_title' ) ) {
	//Handler of add_filter('themerex_filter_get_stream_page_title',	'themerex_woocommerce_get_stream_page_title', 9, 2);
	function themerex_woocommerce_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (themerex_strpos($page, 'woocommerce')!==false) {
			if (($page_id = themerex_woocommerce_get_stream_page_id(0, $page)) > 0)
				$title = themerex_get_post_title($page_id);
			else
				$title = esc_html__('Shop', 'globallogistics');
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'themerex_woocommerce_get_stream_page_id' ) ) {
	//Handler of add_filter('themerex_filter_get_stream_page_id',	'themerex_woocommerce_get_stream_page_id', 9, 2);
	function themerex_woocommerce_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (themerex_strpos($page, 'woocommerce')!==false) {
			$id = get_option('woocommerce_shop_page_id');
		}
		return $id;
	}
}

// Filter to detect stream page link
if ( !function_exists( 'themerex_woocommerce_get_stream_page_link' ) ) {
	//Handler of add_filter('themerex_filter_get_stream_page_link',	'themerex_woocommerce_get_stream_page_link', 9, 2);
	function themerex_woocommerce_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (themerex_strpos($page, 'woocommerce')!==false) {
			$id = themerex_woocommerce_get_stream_page_id(0, $page);
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'themerex_woocommerce_get_current_taxonomy' ) ) {
	//Handler of add_filter('themerex_filter_get_current_taxonomy',	'themerex_woocommerce_get_current_taxonomy', 9, 2);
	function themerex_woocommerce_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( themerex_strpos($page, 'woocommerce')!==false ) {
			$tax = 'product_cat';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'themerex_woocommerce_is_taxonomy' ) ) {
	//Handler of add_filter('themerex_filter_is_taxonomy',	'themerex_woocommerce_is_taxonomy', 9, 2);
	function themerex_woocommerce_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query && $query->get('product_cat')!='' || is_product_category() ? 'product_cat' : '';
	}
}

// Return false if current plugin not need theme orderby setting
if ( !function_exists( 'themerex_woocommerce_orderby_need' ) ) {
	//Handler of add_filter('themerex_filter_orderby_need',	'themerex_woocommerce_orderby_need', 9, 2);
	function themerex_woocommerce_orderby_need($need, $query=null) {
		if ($need == false)
			return $need;
		else
			return $query && !($query->get('post_type')=='product' || $query->get('product_cat')!='' || $query->get('product_tag')!='');
	}
}

// Add custom post type into list
if ( !function_exists( 'themerex_woocommerce_list_post_types' ) ) {
	//Handler of add_filter('themerex_filter_list_post_types', 	'themerex_woocommerce_list_post_types', 10, 1);
	function themerex_woocommerce_list_post_types($list) {
		$list['product'] = esc_html__('Products', 'globallogistics');
		return $list;
	}
}



// Enqueue WooCommerce custom styles
if ( !function_exists( 'themerex_woocommerce_frontend_scripts' ) ) {
	//Handler of add_action( 'themerex_action_add_styles', 'themerex_woocommerce_frontend_scripts' );
	function themerex_woocommerce_frontend_scripts() {
			wp_enqueue_style( 'themerex-woo-style',  themerex_get_file_url('css/woo-style.css'), array(), null );
	}
}



// Before main content
if ( !function_exists( 'themerex_woocommerce_wrapper_start' ) ) {
	//Handler of add_action('woocommerce_before_main_content', 'themerex_woocommerce_wrapper_start', 10);
	function themerex_woocommerce_wrapper_start() {
		global $THEMEREX_GLOBALS;
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			<article class="post_item post_item_single post_item_product">
			<?php
		} else {
			?>
			<div class="list_products shop_mode_<?php echo !empty($THEMEREX_GLOBALS['shop_mode']) ? $THEMEREX_GLOBALS['shop_mode'] : 'thumbs'; ?>">
			<?php
		}
	}
}

// After main content
if ( !function_exists( 'themerex_woocommerce_wrapper_end' ) ) {
	//Handler of add_action('woocommerce_after_main_content', 'themerex_woocommerce_wrapper_end', 10);
	function themerex_woocommerce_wrapper_end() {
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			</article>	<!-- .post_item -->
			<?php
		} else {
			?>
			</div>	<!-- .list_products -->
			<?php
		}
	}
}

// Check to show page title
if ( !function_exists( 'themerex_woocommerce_show_page_title' ) ) {
	//Handler of add_action('woocommerce_show_page_title', 'themerex_woocommerce_show_page_title', 10);
	function themerex_woocommerce_show_page_title($defa=true) {
		return themerex_get_custom_option('show_page_title')=='no' || themerex_get_custom_option('show_page_top')=='no';
	}
}

// Check to show product title
if ( !function_exists( 'themerex_woocommerce_show_product_title' ) ) {
	//Handler of add_action( 'woocommerce_single_product_summary', 'themerex_woocommerce_show_product_title', 5 );
	function themerex_woocommerce_show_product_title() {
		if (themerex_get_custom_option('show_post_title')=='yes' || themerex_get_custom_option('show_page_title')=='no' || themerex_get_custom_option('show_page_top')=='no') {
			wc_get_template( 'single-product/title.php' );
		}
	}
}

// Add list mode buttons
if ( !function_exists( 'themerex_woocommerce_before_shop_loop' ) ) {
	//Handler of add_action( 'woocommerce_before_shop_loop', 'themerex_woocommerce_before_shop_loop', 10 );
	function themerex_woocommerce_before_shop_loop() {
		global $THEMEREX_GLOBALS;
		if (themerex_get_custom_option('show_mode_buttons')=='yes') {
			echo '<div class="mode_buttons"><form action="' . esc_url((home_url('/')) . (add_query_arg(array()))).'" method="post">'
				. '<input type="hidden" name="themerex_shop_mode" value="'.esc_attr($THEMEREX_GLOBALS['shop_mode']).'" />'
				. '<a href="#" class="woocommerce_thumbs icon-squares" title="'.esc_attr(__('Show products as thumbs', 'globallogistics')).'"></a>'
				. '<a href="#" class="woocommerce_list icon-credit-card" title="'.esc_attr(__('Show products as list', 'globallogistics')).'"></a>'
				. '</form></div>';
		}
	}
}


// Open thumbs wrapper for categories and products
if ( !function_exists( 'themerex_woocommerce_open_thumb_wrapper' ) ) {
	//Handler of add_action( 'woocommerce_before_subcategory_title', 'themerex_woocommerce_open_thumb_wrapper', 9 );
	//Handler of add_action( 'woocommerce_before_shop_loop_item_title', 'themerex_woocommerce_open_thumb_wrapper', 9 );
	function themerex_woocommerce_open_thumb_wrapper($cat='') {
		themerex_set_global('in_product_item', true);
		?>
		<div class="post_item_wrap">
			<div class="post_featured">
				<div class="post_thumb">
					<a class="" href="<?php echo esc_url(get_permalink()); ?>">

		<?php
	}
}

// Open item wrapper for categories and products
if ( !function_exists( 'themerex_woocommerce_open_item_wrapper' ) ) {
	//Handler of add_action( 'woocommerce_before_subcategory_title', 'themerex_woocommerce_open_item_wrapper', 20 );
	//Handler of add_action( 'woocommerce_before_shop_loop_item_title', 'themerex_woocommerce_open_item_wrapper', 20 );
	function themerex_woocommerce_open_item_wrapper($cat='') {
		?>
				</a>
			</div>
		</div>
		<div class="post_content">

		<?php
	}
}

// Close item wrapper for categories and products
if ( !function_exists( 'themerex_woocommerce_close_item_wrapper' ) ) {
	//Handler of add_action( 'woocommerce_after_subcategory', 'themerex_woocommerce_close_item_wrapper', 20 );
	//Handler of add_action( 'woocommerce_after_shop_loop_item', 'themerex_woocommerce_close_item_wrapper', 20 );
	function themerex_woocommerce_close_item_wrapper($cat='') {
		?>
			</div>
		</div>
		<?php
		themerex_set_global('in_product_item', false);
	}
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'themerex_woocommerce_after_shop_loop_item_title' ) ) {
	//Handler of add_action( 'woocommerce_after_shop_loop_item_title', 'themerex_woocommerce_after_shop_loop_item_title', 7);
	function themerex_woocommerce_after_shop_loop_item_title() {

			// Category //
			global $post;
			$post_id = $post->ID;
			$post_cats = wp_get_post_terms($post_id, 'product_cat');
			$cats_out = '';
			if (!empty($post_cats)) {
				foreach ($post_cats as $term) {
					$term_link = get_term_link($term, 'product_cat');
					$cats_out .= !empty($term_link) ? '<a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a>, ' : '';
				}
			}
			if($cats_out){ ?>
				<div class="product_cats">
					<?php themerex_show_layout($cats_out, ', '); ?>
				</div>
			<?php }
			// End Category //

		global $THEMEREX_GLOBALS;
		if ($THEMEREX_GLOBALS['shop_mode'] == 'list')
			echo '<div class="description">'.apply_filters('the_excerpt', get_the_excerpt()).'</div>';
	}
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'themerex_woocommerce_after_subcategory_title' ) ) {
	//Handler of add_action( 'woocommerce_after_subcategory_title', 'themerex_woocommerce_after_subcategory_title', 10 );
	function themerex_woocommerce_after_subcategory_title($category) {
		global $THEMEREX_GLOBALS;
		if ($THEMEREX_GLOBALS['shop_mode'] == 'list')
			echo '<div class="description">' . ($category->description) . '</div>';
	}
}

// Add Product ID for single product
if ( !function_exists( 'themerex_woocommerce_show_product_id' ) ) {
	//Handler of add_action( 'woocommerce_product_meta_end', 'themerex_woocommerce_show_product_id', 10);
	function themerex_woocommerce_show_product_id() {
		global $post, $product;
		echo '<span class="product_id">'.__('Product ID: ', 'globallogistics') . '<span>' . ($post->ID) . '</span></span>';
	}
}

// Redefine number of related products
if ( !function_exists( 'themerex_woocommerce_output_related_products_args' ) ) {
	//Handler of add_filter( 'woocommerce_output_related_products_args', 'themerex_woocommerce_output_related_products_args' );
	function themerex_woocommerce_output_related_products_args($args) {
		$ppp = $ccc = 0;
		if (themerex_sc_param_is_on(themerex_get_custom_option('show_post_related'))) {
			$ccc_add = in_array(themerex_get_custom_option('body_style'), array('fullwide', 'fullscreen')) ? 1 : 0;
			$ccc =  themerex_get_custom_option('post_related_columns');
			$ccc = $ccc > 0 ? $ccc : (themerex_param_is_off(themerex_get_custom_option('show_sidebar_main')) ? 3+$ccc_add : 2+$ccc_add);
			$ppp = themerex_get_custom_option('post_related_count');
			$ppp = $ppp > 0 ? $ppp : $ccc;
		}
		$args['posts_per_page'] = $ppp;
		$args['columns'] = $ccc;
		return $args;
	}
}

// Number columns for product thumbnails
if ( !function_exists( 'themerex_woocommerce_product_thumbnails_columns' ) ) {
	//Handler of add_filter( 'woocommerce_product_thumbnails_columns', 'themerex_woocommerce_product_thumbnails_columns' );
	function themerex_woocommerce_product_thumbnails_columns($cols) {
		return 5;
	}
}

// Add column class into product item in shop streampage
if ( !function_exists( 'themerex_woocommerce_loop_shop_columns_class' ) ) {
	//Handler of add_filter( 'post_class', 'themerex_woocommerce_loop_shop_columns_class' );
	function themerex_woocommerce_loop_shop_columns_class($class) {
		if (!is_product() && !is_cart() && !is_checkout() && !is_account_page()) {
			$ccc_add = in_array(themerex_get_custom_option('body_style'), array('fullwide', 'fullscreen')) ? 1 : 0;
			$class[] = ' column-1_'.(themerex_param_is_off(themerex_get_custom_option('show_sidebar_main')) ? 3+$ccc_add : 2+$ccc_add);
		}
		return $class;
	}
}

// Number columns for shop streampage
if ( !function_exists( 'themerex_woocommerce_loop_shop_columns' ) ) {
	//Handler of add_filter( 'loop_shop_columns', 'themerex_woocommerce_loop_shop_columns' );
	function themerex_woocommerce_loop_shop_columns($cols) {
		$ccc_add = in_array(themerex_get_custom_option('body_style'), array('fullwide', 'fullscreen')) ? 1 : 0;
		return themerex_param_is_off(themerex_get_custom_option('show_sidebar_main')) ? 3+$ccc_add : 2+$ccc_add;
	}
}

// Search form
if ( !function_exists( 'themerex_woocommerce_get_product_search_form' ) ) {
	//Handler of add_filter( 'get_product_search_form', 'themerex_woocommerce_get_product_search_form' );
	function themerex_woocommerce_get_product_search_form($form) {
		return '
		<form role="search" method="get" class="search_form" action="' . esc_url( home_url( '/'  ) ) . '">
			<input type="text" class="search_field" placeholder="' . esc_attr__('Search for products &hellip;', 'globallogistics') . '" value="' . get_search_query() . '" name="s" title="' . esc_attr__('Search for products:', 'globallogistics') . '" /><button class="search_button icon-search" type="submit"></button>
			<input type="hidden" name="post_type" value="product" />
		</form>
		';
	}
}

// Wrap product title into link
if ( !function_exists( 'themerex_woocommerce_the_title' ) ) {
	//Handler of add_filter( 'the_title', 'themerex_woocommerce_the_title' );
	function themerex_woocommerce_the_title($title) {
		if (themerex_get_global('in_product_item') && get_post_type()=='product') {
			$title = '<a href="'.get_permalink().'">'.($title).'</a>';
		}
		return $title;
	}
}

// Wrap category title into link
if ( !function_exists( 'themerex_woocommerce_shop_loop_subcategory_title' ) ) {
    //Handler of the add_filter( 'woocommerce_shop_loop_subcategory_title', 'themerex_woocommerce_shop_loop_subcategory_title' );
    function themerex_woocommerce_shop_loop_subcategory_title($cat) {

        $cat->name = sprintf('<a href="%s">%s</a>', esc_url(get_term_link($cat->slug, 'product_cat')), $cat->name);
        ?>
        <h2 class="woocommerce-loop-category__title">
        <?php
            themerex_show_layout($cat->name);

        if ( $cat->count > 0 ) {
            echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . esc_html( $cat->count ) . ')</mark>', $cat ); // WPCS: XSS ok.
        }
        ?>
        </h2><?php
    }
}

// Show pagination links
if ( !function_exists( 'themerex_woocommerce_pagination' ) ) {
	//Handler of add_filter( 'woocommerce_after_shop_loop', 'themerex_woocommerce_pagination', 10 );
	function themerex_woocommerce_pagination() {
		themerex_show_pagination(array(
			'class' => 'pagination_wrap pagination_pages',
			'style' => 'pages',
			'button_class' => '',
			'first_text'=> '',
			'last_text' => '',
			'prev_text' => '',
			'next_text' => '',
			'pages_in_group' => 10
			)
		);
	}
}

// text before price
if ( !function_exists( 'themerex_woocommerce_before_price' ) ) {
	function themerex_woocommerce_before_price() {
		echo '<div class="product_price">';
	}
}

// text after price
if ( !function_exists( 'themerex_woocommerce_after_price' ) ) {
	function themerex_woocommerce_after_price() {
		echo '</div>';
	}
}
?>