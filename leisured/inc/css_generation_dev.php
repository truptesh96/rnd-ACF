<?php

add_action('wp_after_insert_post', 'generate_post_css_file');
function generate_post_css_file($post_id) {

    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }

    if (get_post_type($post_id) !== 'page') {
        return;
    }

    $post_slug = get_post_field('post_name', $post_id);
    $upload_dir = wp_upload_dir();

    // FILESYSTEM path (IMPORTANT)
    $css_dir  = $upload_dir['basedir'] . '/css/';
    $css_file = $css_dir . 'post-' . $post_slug . '.css';

    // Ensure directory exists
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }

    $sections = [];

    $has_value = function ($v) {
        return $v !== '' && $v !== null && $v !== false;
    };

    if (have_rows('flexible_content', $post_id)) {
        while (have_rows('flexible_content', $post_id)) {
            the_row();

            $section_id = get_sub_field('sec_id') ?: 'sec_' . get_row_index();

            $sections[$section_id] = [
                'base'   => [],
                '768px'  => [],
                '1600px' => [],
            ];

            if ($has_value($bg = get_sub_field('sec_bg_color'))) {
                $sections[$section_id]['base'][] = "--bg-color:{$bg};";
            }

            if ($has_value($color = get_sub_field('section_text_color'))) {
                $sections[$section_id]['base'][] = "--color:{$color};";
            }

            if ($has_value($pt = get_sub_field('sec_top_mobile'))) {
                $sections[$section_id]['base'][] = "--pt:{$pt}px;";
            }

            if ($has_value($pb = get_sub_field('sec_btm_mobile'))) {
                $sections[$section_id]['base'][] = "--pb:{$pb}px;";
            }

            if ($has_value($bg = get_sub_field('mobile_background'))) {
                $sections[$section_id]['base'][] = "background:{$bg};";
            }

            if ($has_value($pt = get_sub_field('sec_top_tablet'))) {
                $sections[$section_id]['768px'][] = "--pt:{$pt}px;";
            }

            if ($has_value($pb = get_sub_field('sec_btm_tablet'))) {
                $sections[$section_id]['768px'][] = "--pb:{$pb}px;";
            }

            if ($has_value($pt = get_sub_field('sec_top_desktop'))) {
                $sections[$section_id]['1600px'][] = "--pt:{$pt}px;";
            }

            if ($has_value($pb = get_sub_field('sec_btm_desktop'))) {
                $sections[$section_id]['1600px'][] = "--pb:{$pb}px;";
            }
        }
    }

    $css = '';

    foreach ($sections as $id => $rules) {
        if (!empty($rules['base'])) {
            $css .= "#{$id}{" . implode('', $rules['base']) . "}\n";
        }

        if (!empty($rules['768px'])) {
            $css .= "@media (min-width:768px){#{$id}{" . implode('', $rules['768px']) . "}}\n";
        }

        if (!empty($rules['1600px'])) {
            $css .= "@media (min-width:1600px){#{$id}{" . implode('', $rules['1600px']) . "}}\n";
        }
    }

    file_put_contents($css_file, $css);
}

add_action('before_delete_post', 'delete_post_css_file');
add_action('wp_trash_post', 'delete_post_css_file');

function delete_post_css_file($post_id) {

    if (get_post_type($post_id) !== 'page') return;

    $post_slug = get_post_field('post_name', $post_id);
    $upload_dir = wp_upload_dir();

    $css_file = $upload_dir['basedir'] . '/css/post-' . $post_slug . '.css';

    if (file_exists($css_file)) {
        unlink($css_file);
    }
}

add_action('wp_enqueue_scripts', function () {
    if (!is_page()) return;

    global $post;
    $upload_dir = wp_upload_dir();

    $css_url = $upload_dir['baseurl'] . '/css/post-' . $post->post_name . '.css';
    $css_path = $upload_dir['basedir'] . '/css/post-' . $post->post_name . '.css';

    if (file_exists($css_path)) {
        wp_enqueue_style(
            'page-css-' . $post->ID,
            $css_url,
            [],
            false
        );
    }
});