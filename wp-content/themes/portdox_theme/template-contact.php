<?php
/**
 * Contact page layout (used by Portdox Contact template).
 *
 * @package Portdox_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portdox_assets = get_template_directory_uri();
$page_id        = get_queried_object_id();
$page_title     = $page_id ? get_the_title( $page_id ) : __( 'Contact Us', 'portdox_theme' );
$page_content   = $page_id ? get_post_field( 'post_content', $page_id ) : '';
$contact_flag   = isset( $_GET['contact'] ) ? sanitize_text_field( wp_unslash( $_GET['contact'] ) ) : '';
?>
<style id="portdox-contact-inline">
	.portdox-contact-notice.error { color: #c00; margin-bottom: 1rem; }
	.portdox-contact-notice.success { color: #0a0; margin-bottom: 1rem; }
</style>

		<!--Start Page Header-->
		<section class="page-header">
			<div class="page-header__bg" style="background-image: url(<?php echo esc_url( $portdox_assets ); ?>/assets/images/backgrounds/page-header-bg.jpg)">
			</div>
			<div class="page-header__pattern"><img src="<?php echo esc_url( $portdox_assets ); ?>/assets/images/pattern/page-header-pattern.png" alt=""></div>
			<div class="container">
				<div class="page-header__inner">
					<h2><?php echo esc_html( $page_title ); ?></h2>
					<ul class="thm-breadcrumb">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'portdox_theme' ); ?></a></li>
						<li><span class="icon-right-arrow21"></span></li>
						<li><?php echo esc_html( $page_title ); ?></li>
					</ul>
				</div>
			</div>
		</section>
		<!--End Page Header-->

		<?php if ( trim( (string) $page_content ) ) : ?>
		<section class="contact-page contact-page--editor py-4">
			<div class="container">
				<div class="entry-content"><?php echo apply_filters( 'the_content', $page_content ); ?></div>
			</div>
		</section>
		<?php endif; ?>

		<!--Start Contact Page-->
		<section class="contact-page">
			<!--Start Contact Page Top-->
			<div class="contact-page__top">
				<div class="contact-page__top-pattern"
					style="background-image: url(<?php echo esc_url( $portdox_assets ); ?>/assets/images/pattern/contact-page-top-pattern.png);"></div>
				<div class="container">
					<div class="row">
						<!--Start Contact Page Top Content-->
						<div class="col-xl-6">
							<div class="contact-page__top-content">
								<div class="sec-title tg-heading-subheading animation-style2">
									<div class="sec-title__tagline">
										<div class="line"></div>
										<div class="text tg-element-title">
											<h4><?php esc_html_e( 'Contact us', 'portdox_theme' ); ?></h4>
										</div>
										<div class="icon">
											<span class="icon-plane2 float-bob-x3"></span>
										</div>
									</div>
									<h2 class="sec-title__title tg-element-title"><?php esc_html_e( 'Get in Touch And We’ll', 'portdox_theme' ); ?> <br> <?php esc_html_e( 'Help Your Business', 'portdox_theme' ); ?>
									</h2>
								</div>

								<div class="contact-page__top-content-text1">
									<p><?php esc_html_e( 'Our dedicated team of experts is here to guide you through every step, ensuring you make informed choices tailored to your unique needs.', 'portdox_theme' ); ?></p>
								</div>

								<?php $portdox_social = portdox_get_social_profile_urls(); ?>
								<div class="social-links">
									<a href="<?php echo esc_url( $portdox_social['facebook'] ); ?>" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'portdox_theme' ); ?>"><span class="icon-facebook-f"></span></a>
									<a href="<?php echo esc_url( $portdox_social['instagram'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'portdox_theme' ); ?>"><span class="icon-instagram"></span></a>
									<a href="<?php echo esc_url( $portdox_social['linkedin'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'LinkedIn', 'portdox_theme' ); ?>"><span class="icon-linkedin"></span></a>
								</div>
							</div>
						</div>
						<!--End Contact Page Top Content-->

						<!--Start Contact Page Top Form-->
						<div class="col-xl-6">
							<div class="contact-page__top-form">
								<?php if ( 'sent' === $contact_flag ) : ?>
									<p class="portdox-contact-notice success"><?php esc_html_e( 'Thank you — your message has been sent.', 'portdox_theme' ); ?></p>
								<?php elseif ( in_array( $contact_flag, array( 'failed', 'invalid' ), true ) ) : ?>
									<p class="portdox-contact-notice error"><?php esc_html_e( 'Something went wrong. Please check your email address and try again.', 'portdox_theme' ); ?></p>
								<?php endif; ?>

								<form class="contact-form-validated why-choose-one__form"
									action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
									method="post"
									novalidate="novalidate">
									<input type="hidden" name="action" value="portdox_contact_submit">
									<?php wp_nonce_field( 'portdox_contact', 'portdox_contact_nonce' ); ?>

									<div class="row">
										<div class="col-xl-6 col-lg-6 col-md-6">
											<div class="input-box">
												<input type="text" name="contact_name" placeholder="<?php esc_attr_e( 'Name', 'portdox_theme' ); ?>" required>
												<div class="icon"><span class="icon-user"></span></div>
											</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6">
											<div class="input-box">
												<input type="email" name="contact_email" placeholder="<?php esc_attr_e( 'Email', 'portdox_theme' ); ?>" required>
												<div class="icon"><span class="icon-email"></span></div>
											</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6">
											<div class="input-box">
												<input type="text" name="contact_phone" placeholder="<?php esc_attr_e( 'Phone', 'portdox_theme' ); ?>" required>
												<div class="icon"><span class="icon-phone2"></span></div>
											</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6">
											<div class="input-box">
												<div class="select-box">
													<input type="text" name="contact_subject" placeholder="<?php esc_attr_e( 'Subject', 'portdox_theme' ); ?>" required>
												</div>
											</div>
										</div>

										<div class="col-xl-12">
											<div class="input-box">
												<textarea name="contact_message" placeholder="<?php esc_attr_e( 'Message', 'portdox_theme' ); ?>"></textarea>
												<div class="icon style2"><span class="icon-pen"></span></div>
											</div>
										</div>

										<div class="col-xl-12">
											<div class="why-choose-one__form-btn">
												<button type="submit" class="thm-btn">
													<?php esc_html_e( 'Submit Now', 'portdox_theme' ); ?>
													<i class="icon-right-arrow21"></i>
													<span class="hover-btn hover-bx"></span>
													<span class="hover-btn hover-bx2"></span>
													<span class="hover-btn hover-bx3"></span>
													<span class="hover-btn hover-bx4"></span>
												</button>
											</div>
										</div>
									</div>
								</form>
								<div class="result"></div>
							</div>
						</div>
						<!--End Contact Page Top Form-->
					</div>
				</div>
			</div>
			<!--End Contact Page Top-->

			<!--Start Contact Page Bottom-->
			<div class="contact-page__bottom">
				<div class="container">
					<div class="contact-page__bottom-inner">
						<ul class="list-unstyled">
							<li class="contact-page__bottom-single">
								<div class="icon">
									<span class="icon-address"></span>
								</div>
								<div class="content">
									<h2><?php esc_html_e( 'Location', 'portdox_theme' ); ?></h2>
									<p><?php echo portdox_get_contact_address_html(); ?></p>
								</div>
							</li>

							<li class="contact-page__bottom-single">
								<div class="icon">
									<span class="icon-clock2"></span>
								</div>
								<div class="content">
									<h2><?php esc_html_e( 'Working Hours', 'portdox_theme' ); ?></h2>
									<p><?php echo wp_kses_post( nl2br( esc_html( get_theme_mod( 'portdox_contact_hours', "Wednesday - Sunday\n7:00 AM - 5:00 PM" ) ) ) ); ?></p>
								</div>
							</li>

							<li class="contact-page__bottom-single">
								<div class="icon">
									<span class="icon-email"></span>
								</div>
								<div class="content">
									<h2><?php esc_html_e( 'Email', 'portdox_theme' ); ?></h2>
									<p>
										<?php
										$ce = portdox_get_contact_email();
										?>
										<a href="mailto:<?php echo esc_attr( $ce ); ?>"><?php echo esc_html( $ce ); ?></a>
									</p>
								</div>
							</li>

							<li class="contact-page__bottom-single">
								<div class="icon">
									<span class="icon-phone"></span>
								</div>
								<div class="content">
									<h2><?php esc_html_e( 'Phones', 'portdox_theme' ); ?></h2>
									<p>
										<?php
										$cp  = portdox_get_service_sidebar_phone_display();
										$tel = portdox_get_service_sidebar_phone_tel();
										$thr = '' !== $tel ? 'tel:' . $tel : '#';
										?>
										<a href="<?php echo esc_url( $thr ); ?>"><?php echo esc_html( $cp ); ?></a>
									</p>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!--End Contact Page Bottom-->
		</section>
		<!--End Contact Page-->

		<!--Start Google Map One-->
		<section class="google-map-one">
			<?php
			/*$map_embed = get_theme_mod(
				'portdox_contact_map_embed',
				'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6209.242755903148!2d-77.04363602434464!3d38.90977276948481!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1394992895496'
			);*/
			$map_embed = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2722.2985238559654!2d-123.81611629999999!3d46.9754709!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54923b78c0ca7315%3A0x834238b65136fbc3!2sPortdox!5e0!3m2!1sen!2s!4v1775104212993!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade';
			$map_embed = esc_url( $map_embed );
			?>
			<iframe
				title="<?php esc_attr_e( 'Map', 'portdox_theme' ); ?>"
				src="<?php echo $map_embed; ?>"
				class="google-map-one__map"
				loading="lazy"
				referrerpolicy="no-referrer-when-downgrade">
			</iframe>
		</section>
		<!--End Google Map One-->
