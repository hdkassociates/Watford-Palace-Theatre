<?php
/**
 * Template Name: Spektrix Booking
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */

get_header(); 
$pid = $_GET['pid'];
$sid = $_GET['sid'];
$iid = $_GET['iid'];
?>

			<div id="main" class="site-main" role="main">
				<div class="inner">
					<div id="primary" class="content-area">
							<?php
							while ( have_posts() ) : the_post();
							$featured = get_field('featured_image')
							?>
							<div class="gridblocks bookingblocks">
								<div class="gridblock bookingtitle">
									<div class="inside" style="<?php echo $featured?'background-image:url(\''.$featured.'\');':''; ?>">
										<div class="blocktextcentered">
											<div class="centerbox">
											Book Now for <strong><?php echo get_the_title($pid);?></strong>
											</div>
											<?php spektrix_merch_button($pid); ?>
										</div>
									</div>
								</div>
								<div class="gridblock spektrixiframe">
									
									<iframe name="SpektrixIFrame" id="SpektrixIFrame" frameborder="0" src="<?php echo $Spektrix->book_link.$iid; ?>" style="width:100%; height:2000px;" language="javascript" onload="setTimeout(function(){ window.scrollTo(0,0);}, 100)"></iframe>	
								</div>
								<?php 						
									spektrix_merch_block($pid);
								?>
							</div>
							<?php
							endwhile;
							?>
					</div><!-- .content-area -->
				</div><!-- .inner -->
			</div><!-- .site-main -->

<?php get_footer(); ?>
