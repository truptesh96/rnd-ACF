<?php 
    $link = get_sub_field('cta');
    
?>
<?php if( have_rows('buttons') ): ?>
    <div class="o-flex c-btn-wrap">
        <?php 
        while( have_rows('buttons') ): the_row();
        $button_type =get_sub_field('button_type') ? get_sub_field('button_type') : '';

        if (!$button_type) {
            $button_type = 'c-button';
        } else if ($button_type == 'c-button--bordered') {
            $button_type = 'c-button c-button--bordered';
        }

        $link = get_sub_field('cta');
        if ($link) : ?>
            <a class="<?php echo esc_attr($button_type); ?>" href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
                <span class="c-button__label"><?php echo esc_html($link['title']); ?></span>
            </a>
        <?php endif; 
        endwhile;
        ?>
    </div>
<?php endif; ?>