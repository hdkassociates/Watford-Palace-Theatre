<?php
/**
 * The template part for displaying results in search pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('sr'); ?>>

	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header><!-- .entry-header -->

<?php if ( 'post' == get_post_type() ) : ?>

	<footer class="entry-footer">
		<?php echo '<p>News | '.get_the_date().'</p>'; ?>
	</footer><!-- .entry-footer -->

<?php elseif ( 'wpt_event' == get_post_type() ) : ?>

	<footer class="entry-footer">
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
		if($displaydate){
			echo '<p>Event | '.$displaydate.'</p>';
		}else{
			echo '<p>Event</p>';
		}
		?>
	</footer><!-- .entry-footer -->

<?php endif; ?>

</article><!-- #post-## -->
