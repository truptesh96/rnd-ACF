<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function leisured_setup() {

	load_theme_textdomain( 'leisured', LEISURED_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
	add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'leisured' ),
			'footer'  => __( 'Footer Menu', 'leisured' ),
		)
	);
}

add_action( 'after_setup_theme', 'leisured_setup' );