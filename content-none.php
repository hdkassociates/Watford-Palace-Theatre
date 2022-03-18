<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */
?>

<section class="no-results not-found">
	<header class="page-sub-header">
		<h2 class="page-title"><?php _e( 'Nothing Found', 'watfordpalace' ); ?></h2>
	</header><!-- .page-sub-header -->

	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'watfordpalace' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

	<?php elseif ( is_search() ) : ?>

		<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'watfordpalace' ); ?></p>
		<?php // no search form here, as we already put it in the top of the search page ?>

	<?php else : ?>

		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'watfordpalace' ); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>

</section><!-- .no-results -->
