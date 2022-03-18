<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */
?>

<?php

$postdate = $post->post_date;
$postdate = get_the_date();

if ( is_single() ) : ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="contentblocks postblocks">
		<?php
			$authorcredit = get_field('author_credit_line');
			$slides = get_field('slides');
			$trailer = get_field('trailer');
			$about = get_field('about_content');
			$ymals = get_field('pick_and_mix');

			echo '<div class="contentblockcolumn">';

				if($slides){
					echo '<div class="contentblock sliderbox">';
					echo '<ul class="eventslider">';
					foreach($slides as $slide){
						$image = $slide['image'];
						$slideimage = $image['sizes']['half-width-square'];
						if($image){
							echo '<li><div class="img" style="background-image:url('.$slideimage.');">';
							echo '<div class="overlay">';
							echo '</div>';
							echo '</div></li>';
						}
					}
					echo '</ul>';
					echo '</div><!-- .contentblock -->';
				}
				if($trailer){
					echo '<div class="contentblock wideonly">';
					foreach($trailer as $vid){
						$video = '';
						$videotype = $vid['type_of_video'];
						if($videotype == 'youtube'){
							$video = '<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/'.$vid['video_code'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
						}elseif($videotype == 'vimeo'){
							$video = '<iframe src="https://player.vimeo.com/video/'.$vid['video_code'].'?color=ffffff" width="640" height="480" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
						}
						if($video){
							echo '<div class="videowrap">';
							echo '<div class="videobox">';
							echo $video;
							echo '</div>';
							echo '</div>';
						}

					}
					echo '</div><!-- .contentblock -->';
				}


			echo '</div><!-- .contentblockcolumn (1) -->';
			echo '<div class="contentblockcolumn">';
				echo '<div class="contentblock backtags">';
				echo '<p class="backtonews"><a href="'.esc_url(get_permalink(1346)).'"><img src="'.esc_url(get_template_directory_uri()).'/img/left-red.png" alt="&lt;" /></a></p>';
				echo '<div class="postdate"><span>'.$postdate.'</span></div>';
				echo '</div>';


				echo '<div class="contentblock decorated">';
				echo '<div class="ebin">';
				echo '<header class="entry-header">';
				the_title( '<h1 class="entry-title">', '</h1>' );
				if($authorcredit){
					echo '<p class="authorcredit">Written by '.$authorcredit.'</p>';
				}
				echo '</header><!-- .entry-header -->';

include('content-blocks.php');

				echo '</div><!-- .ebin -->';
				echo '</div><!-- .contentblock -->';


				if($trailer){
					echo '<div class="contentblock mobileonly">';
					foreach($trailer as $vid){
						$videotype = $vid['type_of_video'];
						if($videotype == 'youtube'){
							$video = '<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/'.$vid['video_code'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
						}elseif($videotype == 'vimeo'){
							$video = '<iframe src="https://player.vimeo.com/video/'.$vid['video_code'].'?color=ffffff" width="640" height="480" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
						}
						if($video){
							echo '<div class="videowrap">';
							echo '<div class="videobox">';
							echo $video;
							echo '</div>';
							echo '</div>';
						}

					}
					echo '</div><!-- .contentblock -->';
				}

				// get 2 latest post IDs

				$lpids = array();

$args = array(
	'post_type'			=>	'post',
	'post_status'		=>	'publish',
	'posts_per_page'	=>	2,
	'orderby'			=>	'date',
    'order' 			=>	'DESC',
);
$temp = $wp_query;
$wp_query = null;
$wp_query = new WP_Query();
$wp_query->query($args);
if ( $wp_query->have_posts() ) {
	while ( $wp_query->have_posts() ) {
		$wp_query->the_post();
		array_push($lpids,$post->ID);
	}
}
$wp_query = null;
$wp_query = $temp;
wp_reset_postdata();


				if($lpids){
					echo '<div class="contentblock ymal">';
					echo '<h2>Latest Posts</h2>';
					echo '<div class="gridblocks gridblocks2">';
						foreach($lpids as $pid){
							$postlink = esc_url(get_permalink($pid));
							$overlaytext = get_field('short_title',$pid);
							$thumbraw = get_field('thumbnail',$pid);
							if($thumbraw){
								$thumb = $thumbraw['sizes']['quarter-width-square'];
							}else{
								$thumb = '';
							}
							?>
							<div class="gridblock eventitem">
								<div class="inside" style="background-image:url(<?php echo $thumb; ?>);">
									<a href="<?php echo $postlink; ?>">
										<div class="overlaywrapper">
											<div class="overlay">
											<?php
											echo '<span class="buttonstyle1">';
											if($overlaytext){
												echo '<h2 class="entry-title">'.$overlaytext.'</h2>';
											}
											echo '</span>';
											?>
											</div>
										</div>
									</a>
								</div>
							</div>
							<?php
						}
					echo '</div><!-- .ymalblock -->';
					echo '</div><!-- .contentblock -->';
				}


			echo '</div><!-- .contentblockcolumn (2) -->';
		?>
	</div><!-- .contentblocks -->
</article><!-- #post-## -->
<?php else : ?>

	<?php
	$thumbraw = get_field('thumbnail');
	if($thumbraw){
		$thumb = $thumbraw['sizes']['third-width-vertical'];
	}else{
		$thumb = '';
	}
	?>

	<div class="gridblock postitem">
		<div class="inside" style="background-image:url(<?php echo $thumb; ?>);">
			<a href="<?php echo esc_url(get_permalink()); ?>">
				<div class="overlaywrapper">
					<div class="overlay">
					<?php
					// the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
					echo '<h2 class="entry-title">'.get_field('short_title').'</h2>';
					echo '<div class="postdate"><span>'.$postdate.'</span></div>';
					echo '<div class="showonhover">';
					echo '<p></p>';
					echo '<div class="button">';
					echo '<span class="buttonstyle5">More info</span>';
					echo '</div>';
					echo '</div>';
					?>
					</div>
				</div>
			</a>
		</div>
	</div>

<?php endif; ?>
