<?php
$media_type = get_sub_field('media_type');
$video_type = get_sub_field('video_type');


$overlay_type = get_sub_field('overlay_type');

if($overlay_type != 'gradient') {
    $media_overlay = get_sub_field('media_overlay');
} else {
    $media_overlay = get_sub_field('media_overlay_gradient');
}


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

<div  class="c-video-wrap c-media <?php echo esc_attr($class); ?>" <?php echo $media_overlay_style; ?>>

    <?php if ($video_type != 'third-party') : ?>

        <?php if (!$videoAutoplay) : ?>
            <button
                class="play-btn video-toggle"
                type="button"
                aria-label="Play video"
                aria-controls="<?php echo esc_attr($video_id); ?>"
                aria-pressed="false">
                <span class="screen-reader-text">Play video</span>
                <i class="c-video__icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="75" height="75" viewBox="0 0 75 75">
                  <defs>
                    <filter id="np_play_654294_000000" x="0" y="0" width="75" height="75" filterUnits="userSpaceOnUse">
                     <feComposite operator="in" in2="blur"></feComposite>
                      <feComposite in="SourceGraphic"></feComposite>
                    </filter>
                  </defs>
                  <g id="np_play_654294_000000-2" data-name="np_play_654294_000000">
                    <g transform="">
                      <path id="np_play_654294_000000-3" data-name="np_play_654294_000000" d="M37.5,0A37.5,37.5,0,1,0,64.016,10.984,37.5,37.5,0,0,0,37.5,0ZM49.506,38.514,31.354,49A1.172,1.172,0,0,1,29.6,47.98V27.021A1.172,1.172,0,0,1,31.354,26l18.152,10.48v0a1.17,1.17,0,0,1,0,2.027Z" fill="#fff"></path>
                      <path id="np_play_hover" data-name="np_play_hover" d="M37.5,0A37.5,37.5,0,1,0,64.016,10.984,37.5,37.5,0,0,0,37.5,0ZM49.506,38.514,31.354,49A1.172,1.172,0,0,1,29.6,47.98V27.021A1.172,1.172,0,0,1,31.354,26l18.152,10.48v0a1.17,1.17,0,0,1,0,2.027Z" fill="#0FA896"></path>
                    </g>
                  </g>
                </svg></i>
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

    <?php else: 
        
        $third_party_video = get_sub_field('third_party_url');
        if ($third_party_video) :
    ?>
    
        <div class="c-video__embed">
            <?php echo wp_oembed_get($third_party_video); ?>
        </div>

    <?php endif; ?>

    <?php endif; ?>

</div>


<?php 
    else:
    // For images
    $image = get_sub_field('image');
    $imgSize = isset($args['imgSize']) ? $args['imgSize'] : 'full';
    $mobile_img = get_sub_field('mobile_img');
    $imgSize_mobile = 'large';
    $lazyload = isset($args['layload']) ? $args['layload'] : true;
?>
    <div class="c-img-wrap c-media <?php echo esc_attr($class); ?>" <?php echo $media_overlay_style; ?> >
        <?php if($lazyload): ?>
            <?php echo $image ? custom_lazy_image( $image, $imgSize, array( 'class' => 'u-sm-hide default-img' ) ) : ''; ?>
            <?php echo $mobile_img ? custom_lazy_image( $mobile_img, $imgSize_mobile, array( 'class' => 'u-lg-hide mobile-img' ) ) : ''; ?>
        <?php else: ?>
            <?php echo wp_get_attachment_image($image, $imgSize, false, array( 'class' => 'u-sm-hide default-img') ); ?>
            <?php echo $mobile_img ? wp_get_attachment_image( $mobile_img, 'large', false, array( 'class' => 'u-lg-hide mobile-img' ) ) : ''; ?>
        <?php endif; ?>
    </div>
 

<?php endif; ?>