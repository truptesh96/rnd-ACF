<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function leisured_enqueue_assets() {
    
    // Enqueue scripts
	wp_enqueue_script( 'leisured-libs', LEISURED_THEME_URI . '/assets/js/libs.js', array( 'jquery' ), LEISURED_THEME_VERSION, true );
	wp_enqueue_script( 'leisured-main', LEISURED_THEME_URI . '/assets/js/main.js', array( 'jquery' ), LEISURED_THEME_VERSION, true );

	// Enqueue styles
	wp_enqueue_style( 'leisured-style', LEISURED_THEME_URI . '/style.css', array(), false );

}

add_action( 'wp_enqueue_scripts', 'leisured_enqueue_assets' );