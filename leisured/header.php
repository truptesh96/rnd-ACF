<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header c-head" role="banner">

	<div class="o-flex u-align-center">
		<button class="c-hamburger c-menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="u-sr-text c-menu-toggle__label"><?php esc_html_e( 'Menu', 'publicmarketemeryville' ); ?></span></button>

		<div class="site-branding">
			<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
				<div class="site-logo">
					<?php the_custom_logo(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</header>


<nav class="c-nav" aria-label="Primary navigation" id="primary-menu" hidden >
		<div class="o-flex c-nav__wrap is-column just-center wrapper wrapper--pull-right">
		<div class="c-nav__items">
			<div class="c-flymenu">
				<?php get_template_part( 'template-parts/header', 'nav' ); ?>
			</div>

			<div class="c-social">
			<?php 
				if(have_rows('social_links', 'option')) {
					while(have_rows('social_links', 'option')) {
						the_row();
						$social_link = get_sub_field('social_media_link');
						$icon_image = get_sub_field('icon_image');
						?>
						<a href="<?php echo $social_link['url']; ?>" target="<?php echo $social_link['target']; ?>" class="c-social__item">
							<i class="c-social__icon" aria-hidden="true"><?php echo $icon_image; ?></i>
							<span class="c-social__text u-sr-text"><?php echo $social_link['title']; ?></span>
						</a>
					<?php
					}
				}
			?>
			</div>
		</div>
		<div class="c-nav__img"></div>
		</div>
	</nav><!-- #site-navigation -->

<div id="content" class="site-content">
