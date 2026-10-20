<?php require(dirname(__DIR__) . '/common/common-section_settings.php'); ?>


<?php 
    $columns_count = get_sub_field('columns_count'); 
    $column_card_class = get_sub_field('column_card_class');
	$section_layout = get_sub_field('section_layout');
?>

<?php if(have_rows('columns')) :  ?>

<section id="<?php echo $sec_id ? $sec_id : 'block'.get_row_index(); ?>"  class="o-flex c-grid <?php echo esc_attr($sec_classes); ?>" >
   
    <div class="o-wrapper o-flex wid-100 <?php echo implode(' ', $section_layout); ?>" >
        <?php while(have_rows('columns')) : the_row(); 
            $column_content = get_sub_field('column_content');
            $columns_width = get_sub_field('columns_width');
        ?>
        <?php if($column_content) : ?>
        <div class="c-grid__col <?php echo esc_attr($column_card_class); ?>" <?php echo $columns_width &&  $column_content != 'auto-columns' ? 'style="--colx:' . esc_attr($columns_width) . ';"' : ''; ?>>
            <?php echo $column_content; ?>
        </div>
        <?php endif; endwhile; ?>
    </div>
</section>

<?php endif; ?>
