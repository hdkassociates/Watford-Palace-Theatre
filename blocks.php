<?php

$contentblocks = get_field('content_blocks');
if($contentblocks){
	foreach($contentblocks as $cb){
		$layout = $cb['acf_fc_layout'];
		if($layout == 'regular_text'){
			echo $cb['text'];
		}elseif($layout == 'videos'){

		}elseif($layout == 'start_2nd_column'){

		}
	}
}