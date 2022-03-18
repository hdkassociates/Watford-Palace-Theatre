<?php
/**
 * The template for displaying 404 pages (not found)
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

					<section class="error-404 not-found">
						<header class="page-header">
							<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'watfordpalace' ); ?></h1>
						</header><!-- .page-header -->

						<div class="page-content">
							<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'watfordpalace' ); ?></p>

							<?php get_search_form(); ?>
						</div><!-- .page-content -->
					</section><!-- .error-404 -->

				</div><!-- .content-area -->
			</div><!-- .inner -->
		</div><!-- .site-main -->

<?php get_footer(); ?>
