<?php
/**
 * Template part for password-protected content form.
 *
 * @package leisured
 */
?>
<form class="post-password-form" action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" method="post">
	<p><?php esc_html_e( 'This content is password protected. To view it please enter your password below:', 'leisured' ); ?></p>
	<label for="post-password">
		<input name="post_password" id="post-password" type="password" size="20" placeholder="<?php esc_attr_e( 'Password', 'leisured' ); ?>" />
	</label>
	<button type="submit" class="button button-primary"><?php esc_html_e( 'Submit', 'leisured' ); ?></button>
</form>
