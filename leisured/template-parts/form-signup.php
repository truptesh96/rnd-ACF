<?php
/**
 * Template part for signup form.
 *
 * @package leisured
 */
?>
<form class="signup-form" action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>" method="post">
	<p>
		<label for="user_login"><?php esc_html_e( 'Username', 'leisured' ); ?></label>
		<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr( wp_unslash( $_POST['user_login'] ?? '' ) ); ?>" size="20" />
	</p>
	<p>
		<label for="user_email"><?php esc_html_e( 'Email', 'leisured' ); ?></label>
		<input type="email" name="user_email" id="user_email" class="input" value="<?php echo esc_attr( wp_unslash( $_POST['user_email'] ?? '' ) ); ?>" size="20" />
	</p>
	<p class="signup-submit">
		<input type="submit" name="wp-submit" class="button button-primary" value="<?php esc_attr_e( 'Register', 'leisured' ); ?>" />
	</p>
</form>
