<?php

get_header();
?>

<main id="primary" class="c-main">
    <?php 
        if ( post_password_required() ) {
           echo get_the_password_form();
        } else {
            get_template_part( 'template-parts/content', 'flexible' ); 
        }
    ?>
</main>

<?php
get_footer();
