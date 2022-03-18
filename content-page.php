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

	<div class="contentblocks">
		<?php
			echo '<div class="contentblockcolumn">';

				echo '<div class="contentblock">';
				echo '<div class="ebin">';

				echo '<header class="page-header">';
				the_title( '<h1 class="entry-title">', '</h1>' );
				echo '</header><!-- .page-header -->';

				// this is for content sections in the right column
				include('content-blocks.php');

				echo '</div><!-- .ebin -->';
				echo '</div><!-- .contentblock -->';

			echo '</div><!-- .contentblockcolumn (1) -->';
			echo '<div class="contentblockcolumn">';

			$contentblocksleft = get_field('content_blocks_left');
			if($contentblocksleft){
				foreach($contentblocksleft as $cbl){
					echo '<div class="contentblock cblblock">';
					$layout = $cbl['acf_fc_layout'];
					if($layout == 'slider'){
						$slides = $cbl['slides'];
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

					}elseif($layout == 'wide_image'){
						$image = $cbl['image'];
						if($image){
							echo '<img src="'.$image['sizes']['half-width-free-height'].'" alt="'.$image['alt'].'" />';
						}
					}elseif($layout == 'two_images_side_by_side'){
						$images = $cbl['images'][0];
						if($images){
							echo '<div class="sbs">';
							foreach($images as $image){
								echo '<div class="sbsimgwrapper"><img src="'.$image['sizes']['quarter-width-horizontal'].'" alt="'.$image['alt'].'" /></div>';
							}
							echo '</div>';
						}
					}elseif($layout == 'staff_members'){
						$staffmembers = $cbl['staff_members'];
						if($staffmembers){
							echo '<div class="staffmembers">';
							foreach($staffmembers as $sm){
								$smimage = $sm['image']['sizes']['bio-portrait'];
								$smname = $sm['name'];
								$smrole = $sm['role'];
								echo '<div class="sm"><div class="inside" style="background-image:url('.$smimage.');">';
								echo '<div class="overlay">';
								echo '<span class="smname">'.$smname.'</span>';
								echo '<span class="smrole">'.$smrole.'</span>';
								echo '</div>';
								echo '</div></div>';
							}
							echo '</div><!-- .staffmembers -->';
						}
					}elseif($layout == 'video'){
						$video = '';
						$vidtype = $cbl['type_of_video'];
						if($vidtype == 'youtube'){
							$vidcode = $cbl['youtube_video_code'];
							if($vidcode){
								$video = '<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/'.$vidcode.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
							}
						}elseif($vidtype == 'vimeo'){
							$vidcode = $cbl['vimeo_video_code'];
							if($vidcode){
								$video = '<iframe src="https://player.vimeo.com/video/'.$vidcode.'?color=ffffff" width="640" height="480" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
							}
						}
						if($video){
							echo '<div class="videowrap"><div class="videobox">';
							echo $video;
							echo '</div></div>';
						}

					}elseif($layout == 'embed'){
						$embedcode = $cbl['embed_code'];
						if($embedcode){
							echo '<div class="embed3rdparty">';
							echo $embedcode;
							echo '</div>';
						}

					}
					echo '</div><!-- .contentblock .cblblock -->';
				}
			}


			echo '</div><!-- .contentblockcolumn (2) -->';
		?>
	</div><!-- .contentblocks -->

</article><!-- #post-## -->
