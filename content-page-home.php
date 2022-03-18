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
<?php
$scroller = get_field('text_scroller');
if($scroller != ''){
	$marquee = str_replace("<br />"," &nbsp; <span> &nbsp; | &nbsp; </span> &nbsp; ",$scroller).' &nbsp; <span> &nbsp; | &nbsp; </span> &nbsp; ';
	// repeat marquee 8 times to delay the inevitable black line a the end.
	echo '<div class="topstripthing"><div class="inner"><div class="strip"><marquee><p>'.$marquee.$marquee.$marquee.$marquee.$marquee.$marquee.$marquee.$marquee.'</p></marquee></div></div></div>';
}
// slider or video?
$slidesorvideo = get_field('slider_or_video');
if($slidesorvideo == 'slider'){
	$slides = get_field('slides');
	$video = '';
}elseif($slidesorvideo == 'video'){
	$slides = '';
	$video = get_field('video');
}else{
	// something is wrong, neither option was picked
	$slides = '';
	$video = '';
}
$bxslider = '';
if($slides){
	foreach($slides as $slide){
		$image = $slide['image'];
		$slidetitle = $slide['overlay']['title'];
		$slidebuttontext = $slide['overlay']['button_text'];
		$slidebuttonlinktype = $slide['overlay']['button_link_type'];
		if($slidebuttonlinktype == 'eventcat'){
			$slidebuttonlinkraw = $slide['overlay']['button_link_eventcat'];
			$slug = $slidebuttonlinkraw->slug;
			$slidebuttonlink = get_the_permalink(11).'?category='.$slug;
		}elseif($slidebuttonlinktype == 'none'){
			$slidebuttonlink = '';
		}else{
			$slidebuttonlink = $slide['overlay']['button_link'];
		}
		$slidetext = $slide['overlay']['slide_text'];
		$slideimage = $image['sizes']['full-width-horizontal'];

		$bxslider .= '<li><div class="img" style="background-image:url('.$slideimage.');">';
		$bxslider .= '<div class="overlay">';
		if($slidetitle){
			$bxslider .= '<h1>'.$slidetitle.'</h1>';
		}
		if($slidebuttontext AND $slidebuttonlink){
			$bxslider .= '<div class="button"><a class="buttonstyle3" href="'.$slidebuttonlink.'">'.$slidebuttontext.'</a></div>';
		}
		if($slidetext){
			$bxslider .= '<div class="slidetext">'.$slidetext.'</div>';
		}
		$bxslider .= '</div>';
		$bxslider .= '</div></li>';
	}
	echo '<ul class="bxslider">';
	echo $bxslider;
	echo '</ul>';
}
if($video){
	$vidcode = $video[0]['video_code'];
	$overlaytitle = $video[0]['overlay']['title'];
	$overlaybuttontext = $video[0]['overlay']['button_text'];
	$overlaybuttonlinktype = $video[0]['overlay']['button_link_type'];
	if($overlaybuttonlinktype == 'eventcat'){
		$overlaybuttonlinkraw = $video[0]['overlay']['button_link_eventcat'];
		$slug = $overlaybuttonlinkraw->slug;
		$overlaybuttonlink = get_the_permalink(11).'?category='.$slug;
	}elseif($overlaybuttonlinktype == 'none'){
		$overlaybuttonlink = '';
	}else{
		$overlaybuttonlink = $video[0]['overlay']['button_link'];
	}
	$overlaytext = $video[0]['overlay']['slide_text'];
	$overlay = '';
	if($vidcode){
		echo '<div class="homevideo">';
		echo '<div class="videocover"><div class="videocoverbox">';
		echo '<iframe id="youtube-video" width="560" height="315" src="https://www.youtube.com/embed/'.$vidcode.'?playlist='.$vidcode.'&autoplay=1&loop=1&feature=youtu.be&controls=0&showinfo=0&enablejsapi=1&rel=0&mute=1&modestbranding=1&VQ=HD1080&playsinline=1" allow="autoplay" enablejsapi="1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
		$overlay .= '<div class="overlay">';
		if($overlaytitle){
			$overlay .= '<h1>'.$overlaytitle.'</h1>';
		}
		if($overlaybuttontext AND $overlaybuttonlink){
			$overlay .= '<div class="button"><a class="buttonstyle3" href="'.$overlaybuttonlink.'">'.$overlaybuttontext.'</a></div>';
		}
		if($overlaytext){
			$overlay .= '<div class="slidetext">'.$overlaytext.'</div>';
		}
		$overlay .= '</div>';
		echo $overlay;
		echo '</div></div>';
		echo '</div>';
	}
	?>
	<script type="text/javascript">

	var tag = document.createElement('script');
	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	var player;

	function onYouTubeIframeAPIReady() {
		player = new YT.Player('youtube-video', {
			events: {
				'onReady': onPlayerReady,
				'onStateChange': onStateChange
			}
		});
	}

	function onPlayerReady() {
		player.loadVideoById('<?php echo $vidcode; ?>', 0);
	}

	function onStateChange(event){
		if (event.data == YT.PlayerState.ENDED) {
			player.loadVideoById('<?php echo $vidcode; ?>', 0);
		}
	}
	</script>
	<?php
}
?>

</article><!-- #post-## -->
