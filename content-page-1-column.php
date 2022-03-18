<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="singlecolcontent">
		<header class="page-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .page-header -->

		<div class="contentblock">
		<?php
		the_content();
		include('content-blocks.php');

		if($post->ID == 54){

			// this is the sitemap page

			$user = wp_get_current_user();

			if($user->ID == 1){

				$args = array(
					'echo'		=> 0,
					'title_li'	=>	'',
				);
				$thepages = wp_list_pages($args);
				echo '<ul class="sitemap">'.$thepages.'</ul>';

				wp_nav_menu( array(
					'container'	=> '',
					'menu_class'	=>	'sitemap',
					'theme_location' => 'sitemap',
				) );

			}else{
				echo '<div class="sitemaplist">';
				wp_nav_menu( array(
					'container'	=> '',
					'menu_class'	=>	'sitemap',
					'theme_location' => 'sitemap',
				) );
				echo '</div>';

			}

		}

		?>
		</div><!-- .contentblock -->
	</div><!-- .singlecolcontent -->
</article><!-- #post-## -->
