<?php require(dirname(__DIR__) . '/common/common-section_settings.php'); ?>
  
<section id="<?php echo $sec_id ? $sec_id : 'block'.get_row_index(); ?>"  class="o-flex c-block c-fullMedia py-0 px-0 <?php echo esc_attr($sec_classes); ?>" >
    <div class="o-wrapper mt-auto wid-100">
        <?php get_template_part( 'template-parts/common/common', 'media', ['imgSize' => 'full', 'class' => 'c-fullMedia__inst' ]); ?>
    </div>
</section>

