					<div class="filterset">
						<p>Events in </p>
						<ul class="tags months">
							<?php
	// get all the upcoming months in which we have events

	$today = date('Ymd');
	// Temporarily:
	// $today = '20200101';

	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$args = array(
		'post_type'			=>	'wpt_event',
		'post_status'		=>	'publish',
		'posts_per_page'	=>	1000,
		'paged'				=>	$paged,
		'meta_query' 		=> array(
			array(
				'key' => 'event_end_date',
				'compare' => '>=', // Upcoming Events - Greater than or equal to today
				'value' => $today,
			)
		),
		'meta_key' => 'event_start_date',
		'orderby' => 'meta_value',
		'order' => 'ASC',
	);

	$temp = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query();
	$wp_query->query($args);

	if ( $wp_query->have_posts() ) {
		// there are upcoming dates, so we show the selector
		$eventdates = array();
		while ( $wp_query->have_posts() ) {

			$wp_query->the_post();
			$startdate = get_field('event_start_date');
			// need to double check that Y-m is always enough for strtotime use
			$eventdateraw = date("Y-m",strtotime($startdate));
			if($startdate < $today){
				// these are ongoing dates
				// array_push($eventdates,'ongoing');
				// put the current month in there, in case there aren not any other events in the current month
				array_push($eventdates,date('Y-m'));
			}else{
				array_push($eventdates,$eventdateraw);
			}
		}
		$selectdates = array_unique($eventdates);
		if($selectdates){
			foreach($selectdates as $selectdate){
				echo '<li class="month"><a href="'.get_the_permalink(11).'?date='.date("Ym",strtotime($selectdate)).'">'.date("M",strtotime($selectdate)).'</a></li>';
			}
		}

	}else{
		// there are no upcoming dates
	}
	$wp_query = null;
	$wp_query = $temp;

	wp_reset_postdata();

							?>
						</ul>
					</div>
					<div class="filterset">
						<p>Events that are </p>
						<ul class="tags categories">
						<?php
							$args = array(
							  'taxonomy'     => 'wpt_event_category',
							  'orderby'      => 'name',
							  'hide_empty'	 => false // temporary?
							);
							$terms = get_terms($args);
							foreach($terms as $term){
								$colourclass = get_field('tag_colour',$term);
								echo '<li class="tag_'.$term->slug.' tag_'.$colourclass.'"><a href="'.get_the_permalink(11).'?category='.$term->slug.'">'.$term->name.'</a></li>';
							}
						?>
						</ul>
					</div>
