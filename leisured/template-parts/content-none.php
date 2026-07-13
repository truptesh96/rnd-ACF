<?php
/**
 * Template part for when no content is available
 *
 * @package leisured
 */
?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'leisured' ); ?></h1>
	</header>

	<div class="page-content">
		<?php if ( is_search() ) : ?>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'leisured' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'It seems we can’t find what you’re looking for. Perhaps searching can help.', 'leisured' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
