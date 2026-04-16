<div id="user-popUp" class="account_wrap user-popUp mfp-with-anim mfp-hide">
	<div class="user-account">
	<?php $current_user = wp_get_current_user(); ?>
	<div class="user_account">
		<?php
		$user_avatar = '';
		if ($current_user->user_email) $user_avatar = get_avatar($current_user->user_email, 63*min(2, max(1, themerex_get_theme_option("retina_ready"))));
		if ($user_avatar) {	?>
			<span class="user_avatar"><?php themerex_show_layout($user_avatar); ?></span>
		<?php } ?>
		<span class="user_text"><?php esc_html_e('My account:', 'globallogistics'); ?></span>
		<span class="user_name"><?php themerex_show_layout($current_user->display_name); ?></span>
	</div>

	<ul class="user_info">
		<?php if (current_user_can('publish_posts')) { ?>
			<li class="new_post"><a href="<?php echo esc_url(home_url('/')); ?>/wp-admin/post-new.php?post_type=post" class="icon icon-file-1"><?php esc_html_e('New post', 'globallogistics'); ?></a></li>
		<?php } ?>
		<li class="settings"><a href="<?php echo esc_url(get_edit_user_link()); ?>" class="icon icon-cog-1"><?php esc_html_e('Settings', 'globallogistics'); ?></a></li>
		<li class="help"><a href="#" class="icon icon-life_buoy"><?php esc_html_e('Help', 'globallogistics'); ?></a></li>
	</ul>

	<div class="user_logout"><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="icon icon-logout sc_button sc_button_square sc_button_style_filled sc_button_bg_custom sc_button_size_medium"><?php esc_html_e('Log out', 'globallogistics'); ?></a></div>

	</div>
</div>