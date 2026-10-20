<?php 
    $heading = get_sub_field('heading');
    $subheading = get_sub_field('subheading');
    $subheading_tag = get_sub_field('subheading_tag');
    $heading_tag = get_sub_field('heading_tag') ?: 'h2';
    $content = get_sub_field('content');
    $link = get_sub_field('cta');
	 
    // Use $args directly as passed from get_template_part()
    $headingClass = isset($args['headingClass']) ? $args['headingClass'] : 'head';
    $subHeadingClass = isset($args['subHeadingClass']) ? $args['subHeadingClass'] : 'sub-head';
    $contentClass = isset($args['contentClass']) ? $args['contentClass'] : 'content';
    $linkClass = isset($args['linkClass']) ? $args['linkClass'] : 'c-button';
?>

<div class="c-content o-flex is-column">
     <div class="c-content__head">
        <?php if($subheading_tag === $heading_tag): ?>
        <<?php echo esc_html($heading_tag); ?>>
            <span class="<?php echo esc_attr($headingClass); ?>"><?php echo $heading; ?></span>
             <span class="<?php echo esc_attr($subHeadingClass); ?>"><?php echo $subheading; ?></span>
        </<?php echo esc_html($heading_tag); ?>>
        <?php else: ?>

            <?php if ($heading) : ?>
                <<?php echo esc_html($heading_tag); ?> class="<?php echo esc_attr($headingClass); ?>">
                    <?php echo $heading; ?>
                </<?php echo esc_html($heading_tag); ?>>
            <?php endif; ?>

            <?php if ($subheading) : ?>
                <<?php echo esc_html($subheading_tag); ?> class="<?php echo esc_attr($subHeadingClass); ?>">
                    <?php echo $subheading; ?>
                </<?php echo esc_html($subheading_tag); ?>>
            <?php endif; ?>

        <?php endif; ?>
    </div>
<?php if ($content) : ?>
    <div class="c-content__text <?php echo esc_attr($contentClass); ?>">
        <?php echo $content; ?>
    </div>
<?php endif; ?>

<?php get_template_part( 'template-parts/common/common', 'buttons', ['class' => $linkClass]); ?>

</div>