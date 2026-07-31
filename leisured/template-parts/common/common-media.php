<?php
$media_type = get_sub_field('media_type');
$video_type = get_sub_field('video_type');
$media_overlay = get_sub_field('media_overlay');
$custom_video_poster_image = get_sub_field('custom_video_poster_image');
$videoAutoplay = get_sub_field('custom_video_autoplay') ? true : false;

$class = isset($args['class']) ? $args['class'] : 'full';

$class = $media_overlay ? $class . ' has-overlay' : $class;
$media_overlay_style = $media_overlay ? 'style="--overlay:' . esc_attr($media_overlay) . ';"' : '';

$video_id = 'video-' . wp_unique_id();
?>

<?php if ($media_type == 'video') :

    $custom_video = get_sub_field('custom_video');
    $custom_video_mobile = get_sub_field('custom_video_mobile');
?>

<div class="c-video-wrap c-media <?php echo esc_attr($class); ?>" <?php echo $media_overlay_style; ?>>

    <?php if ($video_type != 'third-party') : ?>

        <?php if (!$videoAutoplay) : ?>

            <button
                class="play-btn video-toggle"
                type="button"
                aria-label="Play video"
                aria-controls="<?php echo esc_attr($video_id); ?>"
                aria-pressed="false">
                <span class="screen-reader-text">Play video</span>
            </button>

        <?php endif; ?>

        <?php if ($custom_video) : ?>

        <video
            id="<?php echo esc_attr($video_id); ?>"
            class="custom-video <?php echo $videoAutoplay ? 'autoplay' : ''; ?>"
            preload="none"
            <?php echo $videoAutoplay ? 'autoplay muted' : ''; ?>
            loop
            playsinline
            poster="<?php echo esc_url($custom_video_poster_image); ?>"
            data-desktop="<?php echo esc_url($custom_video); ?>"
            data-mobile="<?php echo esc_url($custom_video_mobile); ?>"
            <?php echo $videoAutoplay ? 'aria-hidden="true"' : ''; ?>>

            <source src="" type="video/mp4">

        </video>

    <?php endif; ?>

    <?php endif; ?>

</div>

<?php endif; ?>