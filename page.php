<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */

get_header(); ?>

		<div id="main" class="site-main" role="main">
			<div class="inner">
				<div id="primary" class="content-area">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'content', 'page' );

				endwhile;
				?>

				</div><!-- .content-area -->
			</div><!-- .inner -->
		</div><!-- .site-main -->

<?php get_footer(); ?>
