<?php
/**
 * Template part for login form.
 *
 * @package leisured
 */
?>
<form name="loginform" id="loginform" action="<?php echo esc_url( wp_login_url() ); ?>" method="post">
	<p>
		<label for="user_login"><?php esc_html_e( 'Username or Email Address', 'leisured' ); ?></label>
		<input type="text" name="log" id="user_login" class="input" value="<?php echo esc_attr( wp_unslash( $_POST['log'] ?? '' ) ); ?>" size="20" />
	</p>
	<p>
		<label for="user_pass"><?php esc_html_e( 'Password', 'leisured' ); ?></label>
		<input type="password" name="pwd" id="user_pass" class="input" size="20" />
	</p>
	<p class="login-remember">
		<label>
			<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember Me', 'leisured' ); ?>
		</label>
	</p>
	<p class="login-submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="<?php esc_attr_e( 'Log In', 'leisured' ); ?>" />
		<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url() ); ?>" />
	</p>
	<p class="login-links">
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'leisured' ); ?></a>
	</p>
</form>
