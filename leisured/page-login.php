<?php
/**
 * Template Name: Login Page
 *
 * @package leisured
 */

get_header();
?>

<main id="main" class="c-main" role="main">
	<section class="page-login">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Log In', 'leisured' ); ?></h1>
		</header>

		<?php if ( is_user_logged_in() ) : ?>
			<p><?php esc_html_e( 'You are already logged in.', 'leisured' ); ?></p>
		<?php else : ?>
			<?php get_template_part( 'template-parts/form', 'login' ); ?>
		<?php endif; ?>
	</section>
</main>

<?php
get_footer();
