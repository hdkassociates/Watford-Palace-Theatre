<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */
?>

			<?php
			$topimage = get_field('top_image');
			if($topimage){
			?>
			<div class="gridblock supportfirst">
				<div class="inside">
				<?php
				echo '<div class="topimage">';
				echo '<img src="'.$topimage['sizes']['full-width-horizontal'].'" alt="" />';
				// echo '<header class="page-header"><h1 class="page-title">'.get_the_title().'</h1></header><!-- .page-header -->';
				echo '</div>';
				?>
					<div class="scrollmore">Scroll for more</div>
				</div>
			</div>
			<?php
			}
			?>

	<?php
	$linktothesepages = get_field('links_to_sub_pages');
	if($linktothesepages){
		foreach($linktothesepages as $linked){
			$linkID = $linked['sub_page']->ID;
			$thumbraw = $linked['thumbnail'];
			if($thumbraw){
				// note: this image size is used on the 'take part' page
				// on the 'your palace' page, the image size is 'quarter-width-square'.
				$thumb = $thumbraw['sizes']['third-width-vertical'];
			}else{
				$thumb = '';
			}

			?>
				<div class="gridblock landing">
					<div class="inside" style="background-image:url(<?php echo $thumb; ?>);">
						<div class="overlaywrapper">
							<?php
							echo '<a href="'.esc_url( get_permalink($linkID) ).'" rel="bookmark">';
							?>
								<div class="overlay">
								<?php
								echo '<h2 class="entry-title">'.get_the_title($linkID).'</h2>';
								?>
								</div>
							</a>
						</div>
					</div>
				</div>
			<?php
		}
	}



