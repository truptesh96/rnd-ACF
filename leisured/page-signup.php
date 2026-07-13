<?php
/**
 * Template Name: Signup Page
 *
 * @package leisured
 */

get_header();
?>

<main id="main" class="c-main" role="main">
	<section class="page-signup">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Sign Up', 'leisured' ); ?></h1>
		</header>

		<?php if ( is_user_logged_in() ) : ?>
			<p><?php esc_html_e( 'You are already logged in.', 'leisured' ); ?></p>
		<?php elseif ( ! get_option( 'users_can_register' ) ) : ?>
			<p><?php esc_html_e( 'Registration is currently closed.', 'leisured' ); ?></p>
		<?php else : ?>
			<?php get_template_part( 'template-parts/form', 'signup' ); ?>
		<?php endif; ?>
	</section>
</main>

<?php
get_footer();
