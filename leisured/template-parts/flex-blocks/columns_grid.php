<?php require(dirname(__DIR__) . '/common/common-section_settings.php'); ?>

<?php 
    $columns_gap = get_sub_field('columns_gap');
    $rows_gap = get_sub_field('rows_gap');
    $columns_count = get_sub_field('columns_count');
    if(have_rows('columns')) : 
?>

<section id="<?php echo $sec_id ? $sec_id : 'block'.get_row_index(); ?>"  class="o-flex c-grid <?php echo esc_attr($sec_classes); ?>" 
style=" <?php echo $columns_count ? '--columns: ' . $columns_count . '; ' : ''; ?>; <?php echo $columns_gap ? '--gapx: ' . $columns_gap . '; ' : ''; ?>; <?php echo $rows_gap ? '--gapy: ' . $rows_gap . '; ' : ''; ?>;"
>
   
    <div class="o-wrapper o-flex wid-100" >
        <?php while(have_rows('columns')) : the_row(); 
            $column_content = get_sub_field('column_content');
        ?>
        
        <?php if($column_content) : ?>
        <div class="c-grid__col u-typo">
            <?php echo $column_content; ?>
        </div>
        <?php endif; endwhile; ?>
    </div>
</section>

<?php endif; ?>
