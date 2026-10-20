<?php
add_action('wp_after_insert_post', 'generate_post_css_file');



function is_current_acf_row_disabled($post_id, $field_name) {
    static $cache = [];
 
    $cache_key = $post_id . '_' . $field_name;
 
    if (!isset($cache[$cache_key])) {
        $layout_meta = get_post_meta($post_id, '_' . $field_name . '_layout_meta', true);
        $cache[$cache_key] = (!empty($layout_meta['disabled']) && is_array($layout_meta['disabled']))
            ? $layout_meta['disabled']
            : [];
    }
 
    // get_row_index() is 1-based; ACF's disabled list is 0-based
    $current_row_index = get_row_index() - 1;
 
    return in_array($current_row_index, $cache[$cache_key], true);
}


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
		
		$counter = 1;
		
        while (have_rows('flexible_content', $post_id)) {
            the_row();
			
			
			if (is_current_acf_row_disabled($post_id, 'flexible_content')) {
				continue; // skip this row
			} 	
			
			$section_id = get_sub_field('sec_id') ?: 'sec_' . $counter;
		
            $sections[$section_id] = [
                'base'   => [],
                '768px'  => [],
                '1280px' => [],
                '1440px' => [],
            ];

            if ($has_value($section_bg_gradient = get_sub_field('section_bg_gradient'))) {
                $sections[$section_id]['base'][] = "--bg-gradient:{$section_bg_gradient};";
            }

            
            if ($has_value($section_bg_image = get_sub_field('section_bg_image'))) {
                $sections[$section_id]['base'][] = "--bg-image:url('{$section_bg_image}');";
            }
            if ($has_value($section_bg_position = get_sub_field('section_bg_position'))) {
                $sections[$section_id]['base'][] = "--bg-position:{$section_bg_position};";
            }
            if ($has_value($section_bg_fixed = get_sub_field('section_bg_fixed'))) {
                $sections[$section_id]['base'][] = "--bg-fixed: fixed;";
            }

            if ($has_value($columns_gap = get_sub_field('columns_gap'))) {
                $sections[$section_id]['base'][] = "--gapy:{$columns_gap};";
            }

            if ($has_value($rows_gap = get_sub_field('rows_gap'))) {
                $sections[$section_id]['base'][] = "--gapx:{$rows_gap};";
            }

            if ($has_value($columns_count = get_sub_field('columns_count'))) {
                
                if( $columns_count != 'auto-columns' ) {
                    
                    $sections[$section_id]['768px'][] = "--columns: 2;";

                    if ($columns_count > 2) {
                        $sections[$section_id]['1280px'][] = "--columns: {$columns_count};";
                    }

                }
            
            }
            
            if ($has_value($bg = get_sub_field('sec_bg_color'))) {
                $sections[$section_id]['base'][] = "--bg-color:{$bg};";
            }

            if ($has_value($wrapper_width = get_sub_field('wrapper_width'))) {
                $sections[$section_id]['base'][] = "--wrapperx:{$wrapper_width};";
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
                $sections[$section_id]['1440px'][] = "--pt:{$pt}px;";
            }
            if ($has_value($pb = get_sub_field('sec_btm_desktop'))) {
                $sections[$section_id]['1440px'][] = "--pb:{$pb}px;";
            }
			
			$counter++;
			
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

        if (!empty($rules['1280px'])) {
            $css .= "@media (min-width:1280px){#{$id}{" . implode('', $rules['1280px']) . "}}\n";
        }

        if (!empty($rules['1440px'])) {
            $css .= "@media (min-width:1440px){#{$id}{" . implode('', $rules['1440px']) . "}}\n";
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