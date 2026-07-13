<?php
/**
 * The template for displaying search forms
 *
 * @package leisured
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'leisured' ); ?></span>
		<input type="search" class="search-field"
			placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder', 'leisured' ); ?>"
			value="<?php echo get_search_query(); ?>"
			name="s"
			aria-label="<?php esc_attr_e( 'Search for:', 'leisured' ); ?>" />
	</label>
	<button type="submit" class="search-submit"><?php echo esc_html_x( 'Search', 'submit button', 'leisured' ); ?></button>
</form>
