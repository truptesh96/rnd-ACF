<?php
/*-------- Regenerate All CSS ------------*/

/**
 * Add Regenerate Button to WP Admin Bar
 */
add_action('admin_bar_menu', 'cg_register_adminbar_button', 100);
function cg_register_adminbar_button($admin_bar) {

    if (!current_user_can('manage_options')) {
        return;
    }

    $nonce = wp_create_nonce('cg-generate-css');
    $link  = add_query_arg(
        [
            'cg_generate_all_css' => 1,
            'cg_nonce'            => $nonce,
        ],
        admin_url()
    );

    $admin_bar->add_node([
        'id'    => 'cg-regenerate-css',
        'title' => __('Regenerate CSS', 'cg'),
        'href'  => $link,
        'meta'  => [
            'title' => __('Generate CSS for all posts and pages', 'cg'),
        ],
    ]);
}


/**
 * Handle CSS regeneration and show notice
 */
add_action('admin_init', 'cg_process_css_regeneration');
function cg_process_css_regeneration() {

    if (!isset($_GET['cg_generate_all_css'])) {
        return;
    }

    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have permission to do this.', 'cg'));
    }

    if (
        !isset($_GET['cg_nonce']) ||
        !wp_verify_nonce($_GET['cg_nonce'], 'cg-generate-css')
    ) {
        wp_die(__('Invalid request. Nonce verification failed.', 'cg'));
    }

    $count = cg_generate_all_pages_css();

    set_transient('cg_css_regen_count', $count, 30);

    wp_safe_redirect(remove_query_arg(['cg_generate_all_css', 'cg_nonce']));
    exit;
}


/**
 * Generate CSS for all pages/posts and cleanup unused files
 */
function cg_generate_all_pages_css() {

    $upload_dir = wp_upload_dir();

    // ✅ FILESYSTEM PATH (IMPORTANT)
    $css_dir = trailingslashit($upload_dir['basedir']) . 'css/';

    // Ensure directory exists
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }

    $posts = get_posts([
        'post_type'      => ['page', 'post'],
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ]);

    if (empty($posts)) {
        return 0;
    }

    /**
     * 1. Generate CSS for each post
     */
    $valid_files = [];

    foreach ($posts as $post_id) {
        $slug = get_post_field('post_name', $post_id);
        if (!$slug) {
            continue;
        }

        $filename      = "post-{$slug}.css";
        $valid_files[] = $filename;

        // Your existing generator
        generate_post_css_file($post_id);
    }

    /**
     * 2. Cleanup unused CSS files
     */
    $all_css_files = glob($css_dir . '*.css');

    if (!empty($all_css_files)) {
        foreach ($all_css_files as $file_path) {
            $basename = basename($file_path);

            if (!in_array($basename, $valid_files, true)) {
                unlink($file_path);
            }
        }
    }

    return count($posts);
}


/**
 * Show Admin Notice
 */
add_action('admin_notices', 'cg_css_regen_notice');
function cg_css_regen_notice() {

    $count = get_transient('cg_css_regen_count');
    if ($count === false) {
        return;
    }

    delete_transient('cg_css_regen_count');

    echo '<div class="notice notice-success is-dismissible">
        <p>
            <strong>CSS regenerated for ' . intval($count) . ' posts/pages.</strong><br>
            Unused CSS files were cleaned up.
        </p>
    </div>';
}

/*-------- Regenerate All CSS Ends ------------*/
?>
