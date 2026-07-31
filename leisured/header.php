<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header c-head w-100" role="banner">

	<div class="c-head__head o-flex u-align-center u-space-between">
		<button class="c-hamburger c-menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="u-sr-text c-menu-toggle__label"><?php esc_html_e( 'Menu', 'publicmarketemeryville' ); ?></span></button>

		<a href="<?php echo home_url( '/' ); ?>" class="site-branding">
			<span class="u-sr-text"><?php echo  bloginfo( 'name' ); ?></span>
			<div class="c-head__logo">
				<?php if ( get_field('site_logo', 'option') ): ?>
					<?php echo get_field('site_logo', 'option'); ?>
					<?php elseif ( !function_exists( 'the_custom_logo' ) && has_custom_logo() ) : the_custom_logo(); ?>
				 <?php endif; ?>
			</div>
		</a>

		<?php 
			$register_link = get_field('register_link', 'option');
			if($register_link) {
				?>
				<a href="<?php echo $register_link['url']; ?>" target="<?php echo $register_link['target']; ?>" class="c-register c-button">
					<?php echo $register_link['title']; ?>
				</a>
			<?php
			}
		?>
 
	</div>
</header>


<nav class="c-nav" aria-label="Primary navigation" id="primary-menu" hidden >
		<div class="o-flex c-nav__wrap is-column just-center wrapper wrapper--pull-right">
		<div class="c-nav__items">
			<div class="c-flymenu">
				<?php get_template_part( 'template-parts/header', 'nav' ); ?>
			</div>

			 <?php get_template_part( 'template-parts/globals', 'social_links' ); ?>
		</div>
		<div class="c-nav__img"></div>
		</div>
	</nav><!-- #site-navigation -->

<div id="content" class="site-content">
