<?php

/**
*  Removing Unwanted defualt Wordpress style and JS
**/

    add_action( 'wp_enqueue_scripts', function() {
        wp_dequeue_style( 'global-styles-inline-css' );
        wp_dequeue_style( 'classic-theme-styles' ); 
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style('global-styles');
        wp_dequeue_style('global-styles-inline');
        wp_dequeue_style('global-styles-inline-css');
        wp_deregister_style('global-styles');
        wp_deregister_style('global-styles-inline');
        wp_deregister_style('global-styles-inline-css');
    }, 100);

    // Disable emoji scripts and styles
    add_action( 'init', function() {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        add_filter( 'tiny_mce_plugins', function( $plugins ) {
            return is_array( $plugins ) ? array_diff( $plugins, [ 'wpemoji' ] ) : [];
        } );
        add_filter( 'emoji_svg_url', '__return_false' );
    } );
?>