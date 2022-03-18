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

	$startdateraw = get_field('event_start_date');
	$enddateraw   = get_field('event_end_date');

	$dateoverride = get_field('date_display_override');

	$startdatestr = strtotime($startdateraw);
	$enddatestr = strtotime($enddateraw);

	$startdate = date("j M Y",$startdatestr);
	$startdateyear = date("Y",$startdatestr);
	$startdatemonth = date("M",$startdatestr);
	$startdateday = date("j",$startdatestr);

	$enddate = date("j M Y",$enddatestr);
	$enddateyear = date("Y",$enddatestr);
	$enddatemonth = date("M",$enddatestr);
	$enddateday = date("j",$enddatestr);

	if($startdate == $enddate){
		$displaydate = $startdate;
	}elseif($startdateyear == $enddateyear){
		if($startdatemonth == $enddatemonth){
			$displaydate = $startdateday.' - '.$enddate;
		}else{
			$displaydate = $startdateday.' '.$startdatemonth.' - '.$enddate;
		}
	}else{
		$displaydate = $startdate.' - '.$enddate;
	}
	if($dateoverride){
		$displaydate = $dateoverride;
	}

	$bookbuttonlink = '';
	$bookbutton = get_field('book_now_button_link');
	$bookbuttontype = $bookbutton['type_of_link'];
	if($bookbuttontype == 'spektrix'){
		// NOTE: once spektrix is in place, we need to convert the spektrix code to a full URL to the spektrix system/event
		$bookbuttonlink = $bookbutton['spektrix_code'];
	}elseif($bookbuttontype == 'url'){
		$bookbuttonlink = $bookbutton['booking_url'];
	}

if ( is_single() ) : ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

	// get the months to show as tags
	$start    = (new DateTime($startdateraw))->modify('first day of this month');
	$end      = (new DateTime($enddateraw))->modify('first day of next month');
	$interval = DateInterval::createFromDateString('1 month');
	$period   = new DatePeriod($start, $interval, $end);
	$monthtags = '';
	foreach ($period as $dt) {
		$monthtags .= '<li class="month"><a href="'.get_the_permalink(11).'?month='.$dt->format("Ym").'">'.$dt->format("M").'</a></li>';
	}

	?>


	<div class="contentblocks eventblocks">
		<?php
			$producercredit = get_field('producer_credit_line');
			$authorcredit = get_field('author_credit_line');
			$slides = get_field('slides');
			$trailer = get_field('trailer');
			$about = get_field('about_content');
			$credits = '<p>Credits - coming soon</p>';
			$castandcrew = '<p>Cast and Crew - coming soon</p>';
			$pricing = '<p>Pricing - coming soon</p>';
			$accessibility = '<p>Accessibility - coming soon</p>';
			$reviews = get_field('quotes');
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

					if($bookbuttonlink != ''){
						if($bookbuttontype == 'spektrix'){
							echo '<div class="button"><a class="buttonstyle4cut" href="#booking_block" id="spektrix_book_now">Book now</a></div>';
						}
						else{
							echo '<div class="button"><a class="buttonstyle4cut" href="'.htmlspecialchars($bookbuttonlink).'">Book now</a></div>';
						}
					}

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
				if($bookbuttontype == 'spektrix'){
					spektrix_booking_block($bookbuttonlink);
				}

			echo '</div><!-- .contentblockcolumn (1) -->';
			echo '<div class="contentblockcolumn">';

				echo '<div class="contentblock backtags">';
				echo '<p class="backtowhatson"><a href="'.esc_url(get_permalink(11)).'"><img src="'.esc_url(get_template_directory_uri()).'/img/left-red.png" alt="&lt;" /></a></p>';
				echo '<ul class="tags">';
				// check if we want to show monthtags at all
				$showmonthtags = get_field('show_or_hide_month_tags');
				if($showmonthtags != 'hide'){
					echo $monthtags;
				}
				$args =  array(
					'taxonomy' => 'wpt_event_category',
				);
				$terms = wp_get_post_terms($post->ID, $args);
				foreach($terms as $term){
					echo '<li class="tag_'.$term->slug.'"><a href="'.get_term_link($term->term_id).'">'.$term->name.'</a></li>';
				}
				echo '</ul>';
				echo '</div>';


				echo '<div class="contentblock">';
				echo '<div class="ebin">';
				echo '<header class="entry-header">';
				if($producercredit){
					echo '<p class="authorcredit">'.$producercredit.'</p>';
				}
				the_title( '<h1 class="entry-title">', '</h1>' );
				if($authorcredit){
					echo '<p class="authorcredit">'.$authorcredit.'</p>';
				}
				echo '</header><!-- .entry-header -->';
				if($displaydate){
					echo '<p class="eventdates">'.$displaydate.'</p>';
				}

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

				if($reviews){
					echo '<div class="contentblock reviewquotes">';
					echo '<div class="ebin">';
					foreach($reviews as $rev){
						echo '<div class="reviewquote">';
						$n = $rev['stars'];
						$i=0;
						$stars = '';
						while($i < $n){
							$i++;
							$stars .= '&#9733;';
						}
						if($stars != ''){
							echo '<p class="stars">'.$stars.'</p>';
						}
						echo '<p class="quote">&ldquo;'.$rev['quote'].'&rdquo;</p>';
						if($rev['byline']){
							echo '<p class="byline">&mdash; '.$rev['byline'].'</p>';
						}
						echo '</div>';
					}
					echo '</div><!-- .ebin -->';
					echo '</div><!-- .contentblock -->';
				}
				if($ymals){
					echo '<div class="contentblock ymal">';
					echo '<h2>You May Also Like</h2>';
					echo '<div class="gridblocks gridblocks2">';
						foreach($ymals as $ymal){
							$objecttolinkto = $ymal['page_or_event_to_link_to'];
							$overlaytext = $ymal['overlay_text'];
							$thumbraw = $ymal['image_to_use'];
							if($thumbraw){
								$thumb = $thumbraw['sizes']['quarter-width-square'];
							}else{
								$thumb = '';
							}
							?>
							<div class="gridblock eventitem">
								<div class="inside" style="background-image:url(<?php echo $thumb; ?>);">
									<a href="'.esc_url(get_permalink($objecttolinkto->ID)).'">
										<div class="overlaywrapper">
											<div class="overlay">
											<?php
											echo '<span class="buttonstyle1" href="'.esc_url(get_permalink($objecttolinkto->ID)).'">';
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
	<ul class="sidetags">
		<li><a href="<?php echo get_the_permalink(19); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/sidetag-your-visit.png" alt="Your Visit" /></a></li>
		<li><a href="<?php echo get_the_permalink(13); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/sidetag-support-us.png" alt="Support Us" /></a></li>
	</ul>

</article><!-- #post-## -->

<?php else : ?>

	<?php
	$thumbraw = get_field('thumbnail');
	if($thumbraw){
		$thumb = $thumbraw['sizes']['third-width-vertical'];
	}else{
		$thumb = '';
	}
	if($bookbuttontype == 'spektrix'){
		$spektrix_data = spektrix_get_ticketing_data($bookbuttonlink);
		$tickets = 'Tickets from £' . $spektrix_data['MinPrice'];
	}

	$thedates = $displaydate;
	?>

	<div class="gridblock postitem">
		<div class="inside" style="background-image:url(<?php echo $thumb; ?>);">
			<a href="<?php echo esc_url(get_permalink()); ?>">
				<div class="overlaywrapper">
					<div class="overlay">
					<?php
					// the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
					echo '<h2 class="entry-title">'.get_field('short_title').'</h2>';
					echo '<div class="showonhover">';
					echo '<p>'.get_field('excerpt').'</p>';
					echo '<p class="info">'.$thedates.'<br />';
					echo $spektrix_data?$tickets.'</p>':'</p>';
					echo '<div class="button">';
					echo '<span class="buttonstyle5">More info</span>';
					echo "\n";
					/*if($bookbuttonlink != ''){
						if($bookbuttontype == 'spektrix'){
							echo '<a class="buttonstyle2 spektrixbooknow" href="javascript:void(0)" id="'.$bookbuttonlink.'"data-post="'.get_the_ID().'">book now</a>';
						}
						else{
							echo '<a class="buttonstyle2" href="'.$bookbuttonlink.'">book now</a>';
						}
					}*/
					echo '</div>';
					echo '</div>';
					?>
					</div>
				</div>
			</a>
		</div>
	</div>

<?php endif; ?>


