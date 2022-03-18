<?php
/**
 * Template Name: What&rsquo;s On
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
						<div class="gridblocks">
							<?php include 'whatsontop.php'; ?>
							<?php
							while ( have_posts() ) : the_post();
								include('whatson-filtered.php');
							endwhile;
							?>
						</div><!-- .gridblocks -->
						<div class="spektrix_modal--container" id="spektrix_container">
							<a href="javascript:void(0)" class="buttonstyle1 spektrix_modal--close" id="modal_close"></a>
							<div class="spektrix_modal--modal" id="spektrix_modal">
							</div>	
						</div>
					</div><!-- .content-area -->
				</div><!-- .inner -->
			</div><!-- .site-main -->

<?php get_footer(); ?>
