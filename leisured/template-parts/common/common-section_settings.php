<?php 
    $sec_id = get_sub_field( 'sec_id' ) ? : 'sec_' . get_row_index();
    $sec_classes = get_sub_field('sec_classes');
    
    $section_bg_fixed = get_sub_field('section_bg_fixed');
    $section_bg_image = get_sub_field('section_bg_image');
 

    // Add classes based on settings
    $sec_classes .= $section_bg_fixed ? ' has-bg-fixed' : '';
    $sec_classes .= $section_bg_image ? ' has-bg' : '';

?>