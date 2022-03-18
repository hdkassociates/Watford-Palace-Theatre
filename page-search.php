<?php
/**
 * Template Name: Search
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

						<header class="page-header">
							<h1 class="page-title"><?php echo get_the_title(); ?></h1>
						</header><!-- .page-header -->

						<div class="page-content">
							<?php get_search_form(); ?>
						</div><!-- .page-content -->

					</div><!-- .content-area -->
				</div><!-- .inner -->
			</div><!-- .site-main -->

<?php get_footer(); ?>
