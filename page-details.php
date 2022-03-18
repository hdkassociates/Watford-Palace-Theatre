<?php
/**
 * Template Name: Spektrix Details
 *
 * This is the template that redirects Spektrix ids to the actual event
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */
global $Spektrix;
$id = $_SERVER['QUERY_STRING'];
$event = $Spektrix->SpektrixGetEventShortID($id);
$post_obj = get_page_by_title($event['name'],OBJECT,'wpt_event');
var_dump($post_obj);
if($post_obj){
    wp_redirect(get_permalink($post_obj));
}
else{
    wp_redirect(site_url('/whats-on'));
}