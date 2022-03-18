<?php
$filterdate = filter_input(INPUT_GET,"date",FILTER_SANITIZE_STRING);
$filtercategory = filter_input(INPUT_GET,"category",FILTER_SANITIZE_STRING);

if($filtercategory != ''){
    $thetaxquery = array(
	        array(
	            'taxonomy' => 'wpt_event_category',
	            'field'    => 'slug',
	            'terms'    => $filtercategory,
	        ),
    );
}else{
	$thetaxquery = '';
}

if($filterdate != ''){
    $themetaquery = array(
        array(
            'key' => 'event_start_date',
            'compare' => 'LIKE', // = equal to picked date
            'value' => $filterdate,
        )
    );
}else{
	$themetaquery = array(
		array(
			'key' => 'event_end_date',
			'compare' => '>=', // Upcoming Events - Greater than or equal to today
			'value' => $today,
		),
	);
}

// note to self to give client full access to show what goes on main What's on page
// separate between filtered and not filtered
// below is for filtered.
// for non-filtered, order by 'post__in'
// get 'post__in' from a relation field.


// filtered or main page?
if($filterdate == '' AND $filtercategory == ''){

	// no filters, so we go by client's choice.
	$chosenids = get_field('choose_events',11);

	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$args = array(
		'post_type'			=>	'wpt_event',
		'post_status'		=>	'publish',
		'posts_per_page'	=>	26,
		'paged'				=>	$paged,
		'post__in'			=> 	$chosenids,
		'orderby' 			=>	'post__in',
		'order' 			=>	'ASC',
	);

}else{

	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$args = array(
		'post_type'			=>	'wpt_event',
		'post_status'		=>	'publish',
		'posts_per_page'	=>	26,
		'paged'				=>	$paged,
		'tax_query' 		=>	$thetaxquery,
		'meta_query' 		=>	$themetaquery,
		'meta_key' 			=>	'event_start_date',
		'orderby' 			=>	'meta_value',
		'order' 			=>	'ASC',
	);
}

$temp = $wp_query;
$wp_query = null;
$wp_query = new WP_Query();
$wp_query->query($args);

if ( $wp_query->have_posts() ) {

	while ( $wp_query->have_posts() ) {
		$wp_query->the_post();

		get_template_part( 'content', 'wpt_event' );
	}

//	kriesi_pagination();

	// Previous/next page navigation.
	the_posts_pagination( array(
		'prev_text'          => __( '&lt;', 'mythemethemeupdated' ),
		'next_text'          => __( '&gt;', 'mythemethemeupdated' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'mythemethemeupdated' ) . ' </span>',
	) );

}else{
	?>
	<div class="gridblock eventitem noevents">
		<div class="inside">
			<div class="overlaywrapper">
				<div class="">
				<?php
				echo '<div class="noeventstext">'.get_field('no_events_in_category',11).'</div>';
				?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
$wp_query = null;
$wp_query = $temp;

wp_reset_postdata();
