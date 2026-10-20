<?php require(dirname(__DIR__) . '/common/common-section_settings.php'); ?>

<?php $items = get_sub_field('items'); $faqs_style = get_sub_field('faqs_style'); $faqs_open_settings = get_sub_field('faqs_open_settings'); /* * Add FAQ classes */ if ($faqs_open_settings) { $sec_classes .= ' ' . $faqs_open_settings; } if ($faqs_style) { $sec_classes .= ' ' . $faqs_style; } /* * Section ID */ $section_id = $sec_id ? $sec_id : 'block' . get_row_index(); ?>

<section id="<?php echo esc_attr($section_id); ?>" class="o-flex c-block c-faqs <?php echo esc_attr(trim($sec_classes)); ?>  " >
    <div class="o-wrapper wid-100">
        <div class="o-flex c-faqs__wrap">
            <?php get_template_part( 'template-parts/common/common', 'headings', [ 'headingClass' =>
            'e-head', 'subHeadingClass' => 'c-img-text__title u-sm-hide fs30', 'contentClass' => 'fs16' ] ); ?>
            <?php if ($items) : ?>
            <div class="o-flex c-faqs__items">
                <?php foreach ($items as $index =>
                $item) : ?>
                <?php $question_id = $section_id . '-question-' . ($index + 1); $answer_id = $section_id . '-answer-' . ($index + 1); ?>
                <div class="c-faqs__item">
                    <button type="button" id="<?php echo esc_attr($question_id); ?>
                        " class="c-faqs__question" aria-expanded="false" aria-controls="
                        <?php echo esc_attr($answer_id); ?>
                        " >
                        <span class="c-faqs__question-text">
                            <?php echo esc_html($item['heading']); ?>
                        </span>
                        <span class="c-faqs__question-icon" aria-hidden="true" >
                        </span>
                    </button>
                    <div id="<?php echo esc_attr($answer_id); ?>
                        " class="c-faqs__answer" role="region" aria-labelledby="
                        <?php echo esc_attr($question_id); ?>
                        " aria-hidden="true" >
                        <?php echo wp_kses_post($item['description']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>