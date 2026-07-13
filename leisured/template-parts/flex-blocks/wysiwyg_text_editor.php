<?php require(dirname(__DIR__) . '/common/common-section_settings.php'); ?>

<?php 
    $content = get_sub_field('content');
    if(!$content) return;
?>
  
<section id="<?php echo $sec_id ? $sec_id : 'block'.get_row_index(); ?>"  class="o-flex c-text c-block <?php echo esc_attr($sec_classes); ?>" >
     
    <div class="o-wrapper mt-auto wid-100 pr-0">
        <?php echo $content; ?>
    </div>
</section>