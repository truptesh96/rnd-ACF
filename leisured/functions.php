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





// ACF Block Render Callback Function
function my_acf_block_render_callback( $block ) {
    
    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
    $slug = str_replace('acf/', '', $block['name']);
    
    // include a template part from within the "template-parts/block" folder
    if( file_exists( get_theme_file_path("/template-parts/block/content-{$slug}.php") ) ) {
        include( get_theme_file_path("/template-parts/block/content-{$slug}.php") );
    }
}










//*----------------- Not a part of defult setup -----------------*//

function update_team_title_with_user_id($post_id, $post, $update) {

    // Don't run for revisions, autosaves, or auto-drafts
    if (
        wp_is_post_revision($post_id) ||
        wp_is_post_autosave($post_id) ||
        $post->post_status === 'auto-draft'
    ) {
        return;
    }

    // Only update if the ID isn't already in the title
    $suffix = ' u-' . $post_id;

    if (str_ends_with($post->post_title, $suffix)) {
        return;
    }

    $new_title = $post->post_title . $suffix;

    remove_action('save_post_profile', 'update_team_title_with_user_id', 10);

    wp_update_post([
        'ID'         => $post_id,
        'post_title' => $new_title,
        'post_name'  => sanitize_title($new_title),
    ]);

    add_action('save_post_profile', 'update_team_title_with_user_id', 10, 3);
}

add_action('save_post_profile', 'update_team_title_with_user_id', 10, 3);

//*----------------- Not a part of defult setup Ends -----------------*//