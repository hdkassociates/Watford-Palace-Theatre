<?php
/**
 * The template for displaying image attachments
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
					// Start the loop.
					while ( have_posts() ) : the_post();
				?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<nav id="image-navigation" class="navigation image-navigation">
							<div class="nav-links">
								<div class="nav-previous"><?php previous_image_link( false, __( 'Previous Image', 'watfordpalace' ) ); ?></div><div class="nav-next"><?php next_image_link( false, __( 'Next Image', 'watfordpalace' ) ); ?></div>
							</div><!-- .nav-links -->
						</nav><!-- .image-navigation -->

						<header class="entry-header">
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						</header><!-- .entry-header -->

						<div class="entry-content">

							<div class="entry-attachment">
								<?php
									/**
									 * Filter the default Watford Palace image attachment size.
									 *
									 * @since Watford Palace 1.0
									 *
									 * @param string $image_size Image size. Default 'large'.
									 */
									$image_size = apply_filters( 'watfordpalace_attachment_size', 'large' );

									echo wp_get_attachment_image( get_the_ID(), $image_size );
								?>

								<?php if ( has_excerpt() ) : ?>
									<div class="entry-caption">
										<?php the_excerpt(); ?>
									</div><!-- .entry-caption -->
								<?php endif; ?>

							</div><!-- .entry-attachment -->

							<?php
								the_content();
								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'watfordpalace' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
									'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'watfordpalace' ) . ' </span>%',
									'separator'   => '<span class="screen-reader-text">, </span>',
								) );
							?>
						</div><!-- .entry-content -->

						<footer class="entry-footer">
							<?php watfordpalace_entry_meta(); ?>
							<?php edit_post_link( __( 'Edit', 'watfordpalace' ), '<span class="edit-link">', '</span>' ); ?>
						</footer><!-- .entry-footer -->

					</article><!-- #post-## -->

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

						// Previous/next post navigation.
						the_post_navigation( array(
							'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'watfordpalace' ),
						) );

					// End the loop.
					endwhile;
				?>

				</div><!-- .content-area -->
			</div><!-- .inner -->
		</div><!-- .site-main -->

<?php get_footer(); ?>
