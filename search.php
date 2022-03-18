<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */

get_header(); ?>

			<div id="main" class="site-main" role="main">
				<div class="inner">
					<div id="primary" class="content-area">

						<div class="spacetopblock"></div>
							<div class="singlecolcontent">
							<header class="page-header">
								<?php get_search_form(); ?>
								<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'watfordpalace' ), get_search_query() ); ?></h1>
							</header><!-- .page-header -->

							<div class="page-content">

								<?php if ( have_posts() ) : ?>
									<?php
									// Start the loop.
									while ( have_posts() ) : the_post(); ?>

										<?php
										/*
										 * Run the loop for the search to output the results.
										 * If you want to overload this in a child theme then include a file
										 * called content-search.php and that will be used instead.
										 */
										get_template_part( 'content', 'search' );

									// End the loop.
									endwhile;

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
							</div><!-- .page-content -->
						</div><!-- .singlecolcontent -->
					</div><!-- .content-area -->
				</div><!-- .inner -->
			</div><!-- .site-main -->

<?php get_footer(); ?>
