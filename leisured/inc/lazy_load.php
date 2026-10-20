<?php
// Lazy Load Image
function custom_lazy_image( $attachment_id, $size = 'large', $attributes = array() ) {
    if ( ! $attachment_id ) return '';

    // Get image source data
    $image_data = wp_get_attachment_image_src( $attachment_id, $size );
    if ( ! $image_data ) return '';

    $srcset = wp_get_attachment_image_srcset( $attachment_id, $size ) ? wp_get_attachment_image_srcset( $attachment_id, $size ) : wp_get_attachment_image_url( $attachment_id, 'full' );
    $sizes  = wp_get_attachment_image_sizes( $attachment_id, $size );
    $alt    = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

    $default_attrs = array(
        'src'         => '', // blank for lazy load
        'data-srcset' => $srcset,
        'data-sizes'  => $sizes,
        'alt'         => $alt,
        'width'       => $image_data[1],
        'height'      => $image_data[2],
    );

    $all_attrs = array_merge( $default_attrs, $attributes );

    // Build attributes string
    $attr_str = '';
    foreach ( $all_attrs as $key => $val ) {
        if ( $val !== '' ) {
            $attr_str .= esc_attr( $key ) . '="' . esc_attr( $val ) . '" ';
        }
    }

    return '<img ' . trim( $attr_str ) . '/>';
}

?>