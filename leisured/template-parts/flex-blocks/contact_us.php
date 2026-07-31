<?php require(dirname(__DIR__) . '/common/common-section_settings.php'); ?>

<?php 
    $form_content = get_sub_field('form_content');
?>

<section id="<?php echo $sec_id ? $sec_id : 'block'.get_row_index(); ?>"  class="o-flex c-block c-contact <?php echo esc_attr($sec_classes); ?>" >
   
    <div class="o-wrapper mt-auto wid-100 pr-0">
        <div class="o-flex c-contact__text fs85 w300 justify-between">
             <?php get_template_part( 'template-parts/common/common', 'headings', ['headingClass' => 'e-head', 'subHeadingClass' => 'c-img-text__title u-sm-hide fs30', 'contentClass' => 'fs16']); ?>

             <?php if($form_content) : ?>
                <div class="c-form">
                    <?php echo $form_content; ?> 
                </div>
             <?php endif; ?>

        </div>
    </div>
</section>