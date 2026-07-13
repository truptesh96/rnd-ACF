<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LEISURED_THEME_VERSION', '1.0.0' );
define( 'LEISURED_THEME_DIR', get_template_directory() );
define( 'LEISURED_THEME_URI', get_template_directory_uri() );

require_once LEISURED_THEME_DIR . '/inc/setup.php';
require_once LEISURED_THEME_DIR . '/inc/enqueue.php';
require_once LEISURED_THEME_DIR . '/inc/customizer.php';
require_once LEISURED_THEME_DIR . '/inc/helpers.php';
 


/*----------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------
Custom Functions
----------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------*/

// Hook For converting Gravity Form submit input to Button
add_filter( 'gform_submit_button', 'form_submit_button', 10, 2 );
function form_submit_button( $button, $form ) {
    $dom = new DOMDocument();
    $dom->loadHTML( '<?xml encoding="utf-8" ?>' . $button );
    $input = $dom->getElementsByTagName( 'input' )->item( 0 );
    $button_text = $input->getAttribute( 'value' );
    
    $attributes = [];
    $custom_classes = 'c-button';
    foreach ( $input->attributes as $attr ) {
        if ( $attr->name === 'class' ) {
            $attributes[] = 'class="' . $attr->value . ' ' . $custom_classes . '"';
        } elseif ( $attr->name !== 'value' && $attr->name !== 'id' ) {
            $attributes[] = $attr->name . '="' . $attr->value . '"';
        }
    }
    
    return "<button class='{$custom_classes}' id='gform_submit_button_{$form['id']}' " . implode( ' ', $attributes ) . "><span class='c-button__label'>{$button_text}</span></button>";
}


require get_template_directory() . '/inc/custom_functions.php';

// For admin Use
if ( is_user_logged_in() ) {
	require get_template_directory() . '/inc/acf-sync.php';
}

function enqueue_post_css() {
	$upload_dir = wp_upload_dir(); 
    $css_dir_url  = $upload_dir['baseurl']. '/css/';

	if ( is_singular() ) {
        global $post;
        if ( $post ) {
            $post_slug = $post->post_name;
            $post_css  = "post-{$post_slug}.css";

                wp_enqueue_style(
                    "post-{$post_slug}",
                    $css_dir_url . $post_css,
                    [],
                    false);
            }
	}
}

add_action( 'wp_enqueue_scripts', 'enqueue_post_css' );
 
if ( is_user_logged_in() ) {
    
	require get_template_directory() . '/inc/css_generation_dev.php';
}


add_filter('gform_disable_css', '__return_true');
add_filter('show_admin_bar', '__return_false');