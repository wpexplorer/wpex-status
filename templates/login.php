<?php
/**
 * Template Name: Login/Register
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( isset( $_POST['st_add_user'] )
	&& isset( $_POST['st-add-user'] )
	&& isset( $_POST['st-add-user'] )
) {

	// Die if the nonce fails
	if ( ! wp_verify_nonce( $_POST['st-add-user'], 'st-add-user' ) ) {
		wp_die( 'Sorry! That was secure, guess you\'re cheatin huh!', 'status' );
	}

	// Setup new user
	else {
		
		// Username check
		if ( empty( $_POST['st_user_name'] ) ) {
			$error = __( 'A <strong>username</strong> is required for registration.', 'status' );
		} elseif ( username_exists( $userdata['user_login'] ) ) {
			$error = __( 'Sorry, that username already exists!', 'status' );
		}

		// Email check
		elseif ( empty( $_POST['st_user_email'] ) ) {
			$error = __( 'An <strong>email</strong> is required for registration.', 'status' );
		} elseif ( ! is_email( $_POST['st_user_email'] ) ) {
			$error = __( 'You must enter a valid email address.', 'status' );
		} elseif ( email_exists( $_POST['st_user_email'] ) ) {
			$error = __( 'Sorry, that email address is already used!', 'status' );
		}

		// Pass 1
		elseif ( empty( $_POST['st_user_pass'] ) ) {
			$error = __( 'A <strong>password</strong> is required for registration.', 'status' );
		}

		// Pass 1
		elseif ( empty( $_POST['st_user_pass_repeat'] ) ) {
			$error = __( 'Please confirm your password.', 'status' );
		}

		// Password match
		elseif( $_POST['st_user_pass'] != $_POST['st_user_pass_repeat'] ) {
			$error = __( 'Passwords do not match.', 'status' );
		}

		// setup new users and send notification
		else {
			$new_user = wp_insert_user( array(
				'user_login'		=> esc_attr( $_POST['st_user_name'] ),
				'user_email'		=> esc_attr( $_POST['st_user_email'] ),
				'user_pass'			=> esc_attr( $_POST['st_user_pass'] ),
				'user_pass_repeat'	=> esc_attr( $_POST['st_user_pass_repeat'] ),
				'role'				=> get_option( 'default_role' ),
			) );
			wp_new_user_notification( $new_user );
		}
	}
} ?>

<?php get_template_part( 'partials/page/thumbnail' ); ?>

	<div class="st-content-area st-clr">

		<main class="st-site-main st-clr">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php if ( ! get_post_meta( get_the_ID(), 'st_hide_title', true ) ) :
					get_template_part( 'partials/page/header' );
				endif; ?>

				<?php get_template_part( 'partials/page/content' ); ?>

			<?php endwhile; ?>

			<?php
			// If user is already logged in
			if ( is_user_logged_in() ) : ?>

				<div class="st-already-logged-in st-clr">
					<p><?php
					// Get current user and display already logged in message
					$current_user = wp_get_current_user();
					echo __( 'You are already logged in as:', 'status' ) .' <span>'. $current_user->display_name; ?><span></p>
					<a href="<?php echo wp_logout_url( get_permalink() ); ?>" class="st-theme-button"><?php esc_html_e( 'Logout', 'status' ); ?></a>
				</div><!-- .st-already-logged-in -->

			<?php
			// User not logged in
			else : ?>

				<div class="st-login-template-forms st-clr">

					<div class="st-login-form">

						<h2><?php _e( 'Login to an account', 'status' ); ?></h2>
						<?php wp_login_form( array(
							'label_username' => '',
							'label_password' => '',
							'remember'       => false,
						) ); ?>
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" title="<?php _e( 'Lost Password? Recover it here.', 'status' ); ?>"><?php _e( 'Lost Password?', 'status' ); ?></a>

					</div><!-- .st-login-form -->

					<div class="st-register-form st-clr">
						<?php
						// User was created display message
						if ( isset( $new_user ) ) { ?>

							<div class="st-registration-notice st-green"><?php
								_e( 'Registration successful. You can now log in above.', 'status' );
							?></div><!-- .st-registration-notice -->

						<?php }
						// User not created, display error
						elseif ( ! isset( $new_user ) && isset( $error ) && ! empty( $error ) ) { ?>

							<div class="st-registration-notice st-yellow"><?php
								echo wp_kses_post( $error );
							?></div><!-- .st-registration-notice -->

						<?php } ?>

						<h2><?php _e( 'Register for an account', 'status' ); ?></h2>

						<form method="POST" class="user-forms" action="" autocomplete="off">
							
							<p><input class="text-input" name="st_user_name" type="text" id="st_user_name" value="<?php echo isset( $_POST['st_user_name'] ) ? $_POST['st_user_name'] : ''; ?>" placeholder="<?php esc_html_e( 'Username', 'status' ); ?> *" /></p>

							<p><input class="text-input" name="st_user_email" type="text" id="st_user_email" value="<?php echo isset( $_POST['st_user_email'] ) ? $_POST['st_user_email'] : ''; ?>" placeholder="<?php esc_html_e( 'E-mail', 'status' ); ?> *" /></p>

							<p><input class="text-input" name="st_user_pass" type="password" id="st_user_pass" value="" placeholder="<?php esc_html_e( 'Password', 'status' ); ?> *" /></p>

							<p><input class="text-input" name="st_user_pass_repeat" type="password" id="st_user_pass_repeat" value="" placeholder="<?php esc_html_e( 'Confirm password', 'status' ); ?> *" /></p>

							<p class="st-pass-strength"><span><?php _e( 'Strength indicator', 'status' ); ?></span></p>

							<p class="st-form-submit">
								<?php wp_nonce_field( 'st-add-user', 'st-add-user' ) ?>
								<input name="st_add_user" type="submit" value="<?php esc_html_e( 'Submit', 'status' ); ?>" />
							</p>

						</form>

					</div><!-- .st-register-form -->

				</div><!-- .login-template-forms -->

			<?php endif; ?>

		</main><!-- .st-site-main -->

	</div><!-- .st-content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>