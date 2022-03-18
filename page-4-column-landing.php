<?php
/**
 * Template Name: 4 Column landing page
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */

get_header(); ?>

			<div id="main" class="site-main" role="main">
				<div class="inner">
					<div id="primary" class="content-area no-overflow">
						<div class="gridblocks gridblocks4">
							<?php
							while ( have_posts() ) : the_post();
								get_template_part( 'content', 'page-4-column-landing' );
							endwhile;
							?>
						</div><!-- .gridblocks -->
					</div><!-- .content-area -->
				</div><!-- .inner -->
			</div><!-- .site-main -->

<?php get_footer(); ?>
