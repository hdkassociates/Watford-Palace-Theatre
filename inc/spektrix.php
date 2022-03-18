<?php
/**
 * Functions for Watford Palace Spektrix Integration
 *
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */

function spektrix_scripts(){
    if(is_page('book') || is_page('basket')|| is_page('why-donate') || is_page('checkout') || is_page('my-account') || is_page( 'membership-schemes' ) || is_singular('wpt_event')){
        wp_enqueue_script('spektrix_scripts',get_template_directory_uri() . '/js/spektrix/spektrix.js', array('jquery'), '1.1.0', true);
        wp_enqueue_style( 'spektrix_styles', get_template_directory_uri() . '/css/spektrix/spektrix.css', array(),'1.1.0' );
    }
    if(is_page('whats-on')){
        wp_enqueue_script('spektrix_whatson',get_template_directory_uri() . '/js/spektrix/whatson-ajax.js', array('jquery'), '1.1.0', true);
        wp_enqueue_style( 'spektrix_styles', get_template_directory_uri() . '/css/spektrix/spektrix.css', array(),'1.1.0' );
    }
}
add_action( 'wp_enqueue_scripts', 'spektrix_scripts' );

function spektrix_booking_block($id,$post_id=false,$modal=false){
    global $Spektrix;
	$event = $Spektrix->SpektrixGetEvent($id);
	$event_instances = $Spektrix->SpektrixGetEventInstances($event['id']);
    ?><div class="spektrix_booking" id="booking_block"><?php
    if($modal){
        ?><h2><?php echo $event['name']; ?></h2><?php
    }
    $previous = '';
    $count=0;
    foreach($event_instances as $item){
        if($modal && $count>4){
            echo '<div class="spektrix_more button"><a class="buttonstyle1" href="'.esc_url(get_the_permalink($post_id)).'">See All Dates</a></div>';
            break;
        }
        $event_dates = $Spektrix->SpektrixConvertTimeStamps($item['start']);
        $price_range = $Spektrix->SpektrixGetPriceRange($item['id']);
        $iid =  preg_split("/[a-zA-Z]/",$item['id'],2);
        if ($item['id'] != $previous) {
			?>
        	<div class="spektrix_booking--event">
		        <div class="spektrix_booking--date"><?php echo ucwords(strtolower($event_dates[0])); ?></div>
		        <div class="spektrix_booking--time"><?php echo $event_dates[1]; ?></div>
                <div class="spektrix_booking--range">From £<?php echo $price_range['MinPrice'];?><?php if($price_range['MinPrice']!=$price_range['MaxPrice']){ ?> to £<?php echo $price_range['MaxPrice']; }?></div>
                <div class="spektrix_booking--button">
                    <a href="<?php bloginfo('url'); ?>/book?pid=<?php echo $post_id?$post_id:get_the_ID(); ?>&sid=<?php echo $event['id']; ?>&iid=<?php echo $iid[0]; ?>" class="button">Book Now</a></div>
                </div>
	        <?php $previous = $item['id'];
	    }
        
        $count++;
    }
    ?></div><?php 
    if($count>4){
        ?>
        <div class="button seemore">
            <a class="buttonstyle1" id="see_more" href="javascript:void(0)">See More Dates</a>
        </div>
        <?php
    } 
}

function spektrix_merch_block($pid){
    if(have_rows('merchandise',$pid)){
        global $Spektrix;
        ?>
        <div class="spektrix_modal--container spektrix_modal--merch" id="spektrix_container">
            <a href="javascript:void(0)" class="buttonstyle1 spektrix_modal--close" id="modal_close"></a>
            <div class="gridblock spektrixmerch">
                <h2>Add merchandise to your purchase</h2>
                
                <?php
                while(have_rows('merchandise',$pid)){
                    the_row();
                    $merch_id = get_sub_field('linked_merch');
                    $merch_data = $Spektrix->SpektrixGetMerch($merch_id);
                    ?>
                    <div class="spektrixmerch--row">
                        <spektrix-merchandise custom-domain="tickets.watfordpalacetheatre.co.uk" client-name="watfordpalace"  merchandise-item-id="<?php echo $merch_data['id'] ;?>">
                            <div class="merch-row">
                                <h3><?php echo $merch_data['name']; ?></h3>    
                                <h3 class="quantity">
                                    <span data-display-quantity></span>
                                </h3>
                            </div>
                            <div class="increments">
                                <button data-increment-quantity> + </button>
                                <button data-decrement-quantity> - </button>
                            </div>
                            <button class="submit" data-submit-merchandise>Add to Basket</button>
                            <div class="success" data-success-container style="display: none;">Succesfully added to your <a href="/basket">basket</a></div>
                            <div class="fail" data-fail-container style="display: none;">Something went wrong. Please try again</div>
                        </spektrix-merchandise> 
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        
        <?php
        
    }
}

function spektrix_merch_button($pid){
    if(have_rows('merchandise',$pid)){
        ?><div class = "spektrix_open_modal button">
            <a class="buttonstyle2" href="javascript:void(0)" onclick="toggleModal()">Add merchandise to your purchase</a>
        </div>
    <?php
    }
}

add_action('wp_ajax_book_now_modal', 'spektrix_whats_on_modal'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_book_now_modal', 'spektrix_whats_on_modal');
function spektrix_whats_on_modal(){
    spektrix_booking_block($_POST['id'],$_POST['pid'],true);
    die();
}

function spektrix_get_ticketing_data($id){
    global $Spektrix;
    $event = $Spektrix->SpektrixGetEvent($id);
	$event_instances = $Spektrix->SpektrixGetEventInstances($event['id']);
	$price_range=array('MaxPrice'=>false,'MinPrice'=>false);
	foreach($event_instances as $key=>$instance){
		$prices=$Spektrix->SpektrixGetPriceRange($instance['id']);
		if($key==0){
			$price_range['MaxPrice']=$prices['MaxPrice'];
			$price_range['MinPrice']=$prices['MinPrice'];
		}
		else{
			if($prices['MaxPrice']>$price_range['MaxPrice']){
				$price_range['MaxPrice']=$prices['MaxPrice'];
			}
			if($prices['MinPrice']<$price_range['MinPrice']){
				$price_range['MinPrice']=$prices['MinPrice'];
			}
		}
	}
    return $price_range;
}