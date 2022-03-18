<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */
?>

			<div class="gridblock yourpalacefirst">
				<div class="inside">
			<?php
			echo '<div class="blocktextcentered">';
			echo '<div class="centerbox">';
			echo get_field('block_text');
			echo '</div>';
			echo '</div>';
			?>
				</div>
			</div>
	<?php
	$linktothesepages = get_field('links_to_sub_pages');
	if($linktothesepages){
		foreach($linktothesepages as $linked){
			$linkID = $linked['sub_page']->ID;
			$thumbraw = $linked['thumbnail'];
			if($thumbraw){
				// note: this image size is used on the 'your palace' page
				// on the 'support the palace' page, the image size is 'third-width-vertical'.
				$thumb = $thumbraw['sizes']['quarter-width-square'];
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



