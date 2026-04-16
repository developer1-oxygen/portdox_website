<?php 
global $THEMEREX_GLOBALS;
if (empty($THEMEREX_GLOBALS['menu_user'])) 
	$THEMEREX_GLOBALS['menu_user'] = themerex_get_nav_menu('menu_user');
if (empty($THEMEREX_GLOBALS['menu_user'])) {
	?>
	<ul id="menu_user" class="menu_user_nav">
    <?php
} else {
	$menu = themerex_substr($THEMEREX_GLOBALS['menu_user'], 0, themerex_strlen($THEMEREX_GLOBALS['menu_user'])-5);
	$pos = themerex_strpos($menu, '<ul');
	if ($pos!==false) $menu = themerex_substr($menu, 0, $pos+3) . ' class=""' . themerex_substr($menu, $pos+3);
	echo str_replace('class=""', '', $menu);
}
?>


<?php if (themerex_get_custom_option('show_languages')=='yes' && function_exists('icl_get_languages')) {
	$languages = icl_get_languages('skip_missing=1');
	if (!empty($languages)) {
		$lang_list = '';
		$lang_active = '';
		foreach ($languages as $lang) {
			$lang_title = esc_attr($lang['translated_name']);
			if ($lang['active']) {
				$lang_active = $lang_title;
			}
			$lang_list .= "\n".'<li><a rel="alternate" hreflang="' . esc_attr($lang['language_code']) . '" href="' . esc_url(apply_filters('WPML_filter_link', $lang['url'], $lang)) . '">'
				.'<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang_title) . '" title="' . esc_attr($lang_title) . '" />'
				. ($lang_title)
				.'</a></li>';
		}
		?>
		<li class="menu_user_language">
			<a href="#"><span><?php themerex_show_layout($lang_active); ?></span></a>
			<ul><?php themerex_show_layout($lang_list); ?></ul>
		</li>
<?php
	}
}



if (themerex_get_custom_option('show_bookmarks')=='yes') {
	// Load core messages
	themerex_enqueue_messages();
	?>
	<li class="menu_user_bookmarks"><a href="#" class="bookmarks_show icon-star" title="<?php esc_attr_e('Show bookmarks', 'globallogistics'); ?>"></a>
	<?php 
		$list = themerex_get_value_gpc('themerex_bookmarks', '');
		if (!empty($list)) $list = json_decode($list, true);
		?>
		<ul class="bookmarks_list">
			<li><a href="#" class="bookmarks_add" title="<?php esc_attr_e('Add the current page into bookmarks', 'globallogistics'); ?>"><?php esc_html_e('Add bookmark', 'globallogistics'); ?></a></li>
			<?php 
			if (!empty($list)) {
				foreach ($list as $bm) {
					echo '<li><a href="'.esc_url($bm['url']).'" class="bookmarks_item">'.($bm['title']).'<span class="bookmarks_delete icon-cancel-1" title="'.esc_attr__('Delete this bookmark', 'globallogistics').'"></span></a></li>';
				}
			}
			?>
		</ul>
	</li>
	<?php 
}


if (themerex_get_custom_option('show_login')=='yes') {

	// Load Popup engine
	themerex_enqueue_popup_login();
	wp_enqueue_script('jquery-ui-tabs', false, array('jquery','jquery-ui-core'), null, true);
	wp_enqueue_script('jquery-effects-fade', false, array('jquery','jquery-effects-core'), null, true);

	if ( !is_user_logged_in() ) {
		// Load core messages
		themerex_enqueue_messages();
		?>
		<li class="login_wrap">
			<a href="#user-popUp" class="popup_link popup_login_link">
				<span class="icon-profile"></span>
				<?php esc_html_e('Log in', 'globallogistics'); ?>
			</a>
			<?php require_once( themerex_get_file_dir('templates/parts/login.php') ); ?>
		</li>
	<?php

	} else { ?>
		<li class="login_wrap">
			<a href="#user-popUp" class="popup_link popup_account_link">
				<span class="icon-profile"></span>
				<?php esc_html_e('My account', 'globallogistics'); ?>
			</a>
			<?php require_once( themerex_get_file_dir('templates/parts/account.php') ); ?>
		</li>
	<?php
	}
}
?>


<?php
	if(themerex_get_custom_option('top_social_icons')=='yes' && shortcode_exists('trx_socials')){
?>
	<li class="top_socials">
		<?php echo do_shortcode('[trx_socials size="tiny" custom="no"][/trx_socials]'); ?>
	</li>
<?php
	}
?>

</ul>