<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you would like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */

get_header(); ?>

			<div id="main" class="site-main" role="main">
				<div class="inner">
					<div id="primary" class="content-area">
						<div class="gridblocks">
							<?php include 'whatsontop.php'; ?>
							<?php
							if ( have_posts() ) : ?>
								<?php
								// Start the Loop.
								while ( have_posts() ) : the_post();

									/*
									 * Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									get_template_part( 'content', 'wpt_event' );

								// End the loop.
								endwhile;
								?>
								<?php

								// kriesi_pagination();

								// Previous/next page navigation.
								the_posts_pagination( array(
									'prev_text'          => __( '&lt;', 'mythemethemeupdated' ),
									'next_text'          => __( '&gt;', 'mythemethemeupdated' ),
									'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'mythemethemeupdated' ) . ' </span>',
								) );

							// If no content, include the "No posts found" template.
							else :
								get_template_part( 'content', 'none' );

							endif;
							?>
						</div><!-- .gridblocks -->
					</div><!-- .content-area -->
				</div><!-- .inner -->
			</div><!-- .site-main -->

<?php get_footer(); ?>
