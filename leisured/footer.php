</div><!-- #content -->

<footer class="site-footer" role="contentinfo">
	<div class="site-info">
		<?php
		$footer_text = get_theme_mod( 'leisured_footer_text', '' );
		if ( $footer_text ) {
			echo wp_kses_post( $footer_text );
		} else {
			printf(
				/* translators: %s: WordPress link. */
				esc_html__( 'Proudly powered by %s', 'leisured' ),
				'<a href="https://wordpress.org/">WordPress</a>'
			);
		}
		?>
	</div>
</footer>

<script src="https://unpkg.com/lenis@1.3.17/dist/lenis.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/gsap@3.0.1/dist/gsap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.js"></script>

<?php wp_footer(); ?>
</body>
</html>
