<div id="user-popUp" class="user-popUp mfp-with-anim mfp-hide">
	<div class="sc_tabs">
		<ul class="loginHeadTab">
			<li><a href="#loginForm" class="loginFormTab icon"><?php esc_html_e('Log In', 'globallogistics'); ?></a></li>
			<li><a href="#registerForm" class="registerFormTab icon"><?php esc_html_e('Create an Account', 'globallogistics'); ?></a></li>
		</ul>

		<div id="loginForm" class="formItems loginFormBody popup_wrap popup_login">
			<div class="form_left">
				<form action="<?php echo wp_login_url(); ?>" method="post" name="login_form" class="popup_form login_form">
					<input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url('/')); ?>">
					<div class="icon popup_form_field login_field iconed_field icon-mail"><input type="text" id="log" name="log" value="" placeholder="<?php esc_attr_e('Login or Email', 'globallogistics'); ?>"></div>
					<div class="icon popup_form_field password_field iconed_field icon-lock-2"><input type="password" id="password" name="pwd" value="" placeholder="<?php esc_attr_e('Password', 'globallogistics'); ?>"></div>
					<div class="popup_form_field remember_field">
						<a href="<?php echo esc_url(wp_lostpassword_url( get_permalink() )); ?>" class="forgot_password"><?php esc_html_e('Forgot password?', 'globallogistics'); ?></a>
						<input type="checkbox" value="forever" id="rememberme" name="rememberme">
						<label for="rememberme"><?php esc_html_e('Remember me', 'globallogistics'); ?></label>
					</div>
					<div class="popup_form_field submit_field"><input type="submit" class="submit_button sc_button sc_button_square sc_button_style_filled sc_button_bg_link sc_button_size_medium" value="<?php esc_attr_e('Login', 'globallogistics'); ?>"></div>
				</form>
			</div>
			<div class="form_right">
				<div class="login_socials_title"><?php esc_html_e('You can login using your social profile', 'globallogistics'); ?></div>
				<?php
				$social_login = str_replace('[', '', themerex_get_theme_option('social_login'));
				$social_login = str_replace(']', '', $social_login);
				if (strlen($social_login) > 0) {
					?>
					<div class="loginSoc login_plugin">
						<?php
						if (strlen($social_login) > 0) echo do_shortcode( '[' . $social_login . ']' );
						?>
					</div>
				<?php } else {?>
					<div><?php esc_html_e("Install social plugin that has it's own SHORTCODE and add it to Theme Options - Socials - 'Login via Social network' field. We recommend: Wordpress Social Login", 'globallogistics'); ?></div>
				<?php }?>
				<div class="result message_block"></div>
			</div>
		</div>


		<div id="registerForm" class="formItems registerFormBody popup_wrap popup_registration">
			<form name="registration_form" method="post" class="popup_form registration_form">
				<input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url('/')); ?>"/>
				<div class="form_left">
					<div class="icon popup_form_field login_field iconed_field icon-man"><input type="text" id="registration_username" name="registration_username"  value="" placeholder="<?php esc_attr_e('User name (login)', 'globallogistics'); ?>"></div>
					<div class="icon popup_form_field email_field iconed_field icon-mail"><input type="text" id="registration_email" name="registration_email" value="" placeholder="<?php esc_attr_e('E-mail', 'globallogistics'); ?>"></div>
					<div class="popup_form_field agree_field">
						<input type="checkbox" value="agree" id="registration_agree" name="registration_agree">
						<label for="registration_agree"><?php esc_html_e('I agree with', 'globallogistics'); ?></label> <a href="#"><?php esc_html_e('Terms &amp; Conditions', 'globallogistics'); ?></a>
					</div>
					<div class="popup_form_field submit_field"><input type="submit" class="submit_button sc_button sc_button_square sc_button_style_filled sc_button_bg_link sc_button_size_medium" value="<?php esc_attr_e('Sign Up', 'globallogistics'); ?>"></div>
				</div>
				<div class="form_right">
					<div class="icon popup_form_field password_field iconed_field icon-lock-2"><input type="password" id="registration_pwd"  name="registration_pwd"  value="" placeholder="<?php esc_attr_e('Password', 'globallogistics'); ?>"></div>
					<div class="icon popup_form_field password_field iconed_field icon-lock-2"><input type="password" id="registration_pwd2" name="registration_pwd2" value="" placeholder="<?php esc_attr_e('Confirm Password', 'globallogistics'); ?>"></div>
					<div class="popup_form_field description_field"><?php esc_html_e('Minimum 6 characters', 'globallogistics'); ?></div>
				</div>
			</form>
			<div class="result messageBlock"></div>
		</div>

	</div>	<!-- /.sc_tabs -->
</div>		<!-- /.user-popUp -->