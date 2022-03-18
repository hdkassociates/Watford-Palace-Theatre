<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
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
					<?php if ( have_posts() ){
						while ( have_posts() ) {
							the_post();
							get_template_part( 'content', get_post_format() );
						}
						// kriesi_pagination();

						// Previous/next page navigation.
						the_posts_pagination( array(
							'prev_text'          => __( '&lt;', 'mythemethemeupdated' ),
							'next_text'          => __( '&gt;', 'mythemethemeupdated' ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'mythemethemeupdated' ) . ' </span>',
						) );

					}else{
						?>
						<div class="gridblock postitem noposts">
							<div class="inside">
								<div class="overlaywrapper">
									<div class="">
									<?php
									echo '<div class="noeventstext">'.get_field('no_posts_in_category',1346).'</div>';
									?>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
					?>
						</div><!-- .gridblocks -->
					</div><!-- .content-area -->
				</div><!-- .inner -->
			</div><!-- .site-main -->

<?php get_footer(); ?>
