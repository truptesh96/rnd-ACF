<?php require(dirname(__DIR__) . '/common/common-section_settings.php'); ?>
  
<section id="<?php echo $sec_id ? $sec_id : 'block'.get_row_index(); ?>"  class="o-flex c-block c-banner has-bg ptb-0 <?php echo esc_attr($sec_classes); ?>" >
    <?php get_template_part( 'template-parts/common/common', 'media', ['imgSize' => 'full', 'class' => 'c-banner__media is-bg' ]); ?>
    
    <div class="o-wrapper mt-auto wid-100 pr-0 z2">
        <div class="o-flex c-banner__text fs85 w300 justify-between">
             <?php get_template_part( 'template-parts/common/common', 'headings', ['headingClass' => 'e-head', 'subHeadingClass' => 'c-img-text__title u-sm-hide fs30', 'contentClass' => 'fs16']); ?>
        </div>
    </div>
</section>