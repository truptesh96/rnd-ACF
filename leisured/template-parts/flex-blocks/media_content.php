<?php require(dirname(__DIR__) . '/common/common-section_settings.php'); ?>

<?php 
    $section_media_position = get_sub_field('section_media_position');
?>

<section id="<?php echo $sec_id ? $sec_id : 'block'.get_row_index(); ?>"  class="o-flex c-block c-imgContent <?php echo esc_attr($sec_classes); ?>" >
    
    <div class="o-wrapper mt-auto wid-100">
        <div class="o-flex c-imgContent__wrap <?php echo $section_media_position ? $section_media_position : '';  ?>">
            <?php get_template_part( 'template-parts/common/common', 'media', ['imgSize' => 'full', 'class' => 'is-cover'] ); ?>
            <?php get_template_part( 'template-parts/common/common', 'headings', ['headingClass' => 'e-head', 'subHeadingClass' => 'c-img-text__title u-sm-hide fs30', 'contentClass' => 'fs16']); ?>
        </div>
    </div>
</section>