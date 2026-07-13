<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function leisured_customize_register( WP_Customize_Manager $wp_customize ) {

	$wp_customize->add_setting(
		'leisured_display_site_title',
		array(
			'default'           => true,
			'sanitize_callback' => 'leisured_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'leisured_display_site_title',
		array(
			'label'    => __( 'Display site title', 'leisured' ),
			'section'  => 'title_tagline',
			'settings' => 'leisured_display_site_title',
			'type'     => 'checkbox',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'leisured_display_tagline',
		array(
			'default'           => true,
			'sanitize_callback' => 'leisured_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'leisured_display_tagline',
		array(
			'label'    => __( 'Display tagline', 'leisured' ),
			'section'  => 'title_tagline',
			'settings' => 'leisured_display_tagline',
			'type'     => 'checkbox',
			'priority' => 20,
		)
	);

	$wp_customize->add_setting(
		'leisured_footer_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'leisured_footer_text',
		array(
			'label'    => __( 'Footer text', 'leisured' ),
			'section'  => 'title_tagline',
			'settings' => 'leisured_footer_text',
			'type'     => 'text',
			'priority' => 80,
		)
	);

	$wp_customize->add_section(
		'leisured_colors',
		array(
			'title'    => __( 'Theme Colors', 'leisured' ),
			'priority' => 160,
		)
	);

	$colors = array(
		'leisured_color_primary'   => __( 'Primary color', 'leisured' ),
		'leisured_color_secondary' => __( 'Secondary color', 'leisured' ),
		'leisured_color_accent'    => __( 'Accent color', 'leisured' ),
		'leisured_color_background' => __( 'Background color', 'leisured' ),
		'leisured_color_text'      => __( 'Text color', 'leisured' ),
	);

	$defaults = array(
		'leisured_color_primary'   => '#1e73be',
		'leisured_color_secondary' => '#d81159',
		'leisured_color_accent'    => '#f5a623',
		'leisured_color_background' => '#ffffff',
		'leisured_color_text'      => '#333333',
	);

	foreach ( $colors as $setting => $label ) {
		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => $defaults[ $setting ],
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$setting,
				array(
					'label'    => $label,
					'section'  => 'leisured_colors',
					'settings' => $setting,
				)
			)
		);
	}
}

/**
 * Sanitize checkbox values.
 *
 * @param bool|string $checked Checkbox value.
 * @return bool
 */
function leisured_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true === $checked ) || '1' === $checked;
}

/**
 * Print Customizer-driven theme styles.
 */
function leisured_customizer_css() {
	$colors = array(
		'primary'    => get_theme_mod( 'leisured_color_primary', '#1e73be' ),
		'secondary'  => get_theme_mod( 'leisured_color_secondary', '#d81159' ),
		'accent'     => get_theme_mod( 'leisured_color_accent', '#f5a623' ),
		'background' => get_theme_mod( 'leisured_color_background', '#ffffff' ),
		'text'       => get_theme_mod( 'leisured_color_text', '#333333' ),
	);

	echo '<style id="leisured-customizer-css">';
	echo ':root {';
	echo ' --clr-primary: ' . esc_html( $colors['primary'] ) . ';';
	echo ' --clr-secondary: ' . esc_html( $colors['secondary'] ) . ';';
	echo ' --clr-accent: ' . esc_html( $colors['accent'] ) . ';';
	echo ' --clr-background: ' . esc_html( $colors['background'] ) . ';';
	echo ' --color: ' . esc_html( $colors['text'] ) . ';';
	echo '}';
	echo '</style>';
}

add_action( 'customize_register', 'leisured_customize_register' );
add_action( 'wp_head', 'leisured_customizer_css' );
