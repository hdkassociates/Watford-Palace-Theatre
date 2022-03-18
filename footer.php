<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */
?>

	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="inner">
			<div class="fcols">
				<div class="fcol fcol1">
					<h3 id="signup" class="joinconvo"><span>Join the mailing list</span></h3>
					<form class="c-form c-form--newsletter" action="https://tickets.watfordpalacetheatre.co.uk/watfordpalace/website/secure/signup.aspx" method="POST">
						<input type="hidden" name="ReturnUrl" value="http://watfordpalacetheatre.co.uk?newsletter=subscribed">

						<div class="o-input">
							<label for="FirstName" class="">First name</label>
							<input name="FirstName" type="text" placeholder="First name">
						</div>
						<div class="o-input">
							<label for="LastName" class="">First name</label>
							<input name="LastName" type="text" placeholder="Last name">
						</div>
						<div class="o-input">
							<label for="Email" lass="">Email</label>
							<input name="Email" type="text" placeholder="Email">
						</div>
						<input class="o-button o-button--primary" type="submit" value="Sign up">
					</form>
				</div>
				<div class="fcol fcol2">
					<h3 class="contactus"><span>Contact us</span></h3>
					<p class="phonenumber">01923 225 671</p>
					<p class="footeremail"><a href="mailto:sales@watfordpalacetheatre.co.uk">sales@watfordpalacetheatre.co.uk</a></p>
					<?php
						wp_nav_menu( array(
							'container'	=> '',
							'menu_class'	=>	'footersocial',
							'theme_location' => 'social',
							'depth'          => 1,
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>',
						) );
					?>
				</div>
				<div class="fcol fcol3">
					<h2><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo-black.png" alt="<?php bloginfo( 'name' ); ?>" /></a></h2>
					<p class="footeraddress">Watford Palace Theatre,<br />
					20 Clarendon Road, Watford, WD17 1JZ</p>
					<p class="footermaplink"><a href="https://goo.gl/maps/xk8RjxGQrBQVh1Zv5 " target="_blank">View in Google Maps</a></p>
					<?php
					// old link: https://www.google.co.uk/maps/dir/''/@51.6571264,-0.3993298,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x48766ac151c1488f:0x5879b314c72cb7fa!2m2!1d-0.3971411!2d51.6571264?hl=en
					// oldest link: https://goo.gl/maps/wnm3YgsLuPzupuPc6
					?>
				</div>
			</div><!-- .fcols -->
			<div class="fend">
				<div class="footernav">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'secondary',
						) );
					?>
				</div>
				<?php
				$thelogos = '';
				$flogos = get_field('logos',2);
				if($flogos){
					foreach($flogos as $flogo){
						$imageraw = $flogo['logo_image'];
						$imagealt = $flogo['logo_image_alt_text'];
						$logolink = $flogo['logo_link'];
						if($imageraw != ''){
							$image = '<img src="'.$imageraw['sizes']['footer-logo'].'" alt="'.$imagealt.'" />';
							$thelogos .= '<li>';
							if($logolink != ''){
								$thelogos .= '<a href="'.$logolink.'" target="_blank">'.$image.'</a>';
							}else{
								$thelogos .= '<span>'.$image.'</span>';
							}
							$thelogos .= '</li>';
						}
					}
					if($thelogos != ''){
						echo '<div class="logoswrap"><ul class="logos">'.$thelogos.'</ul></div>';
					}
				}
				?>
				<div class="site-info">
					<p>A Company Limited by Guarantee Reg No. 03218719.</p>
					<p>Registered as Charity Number: 1056950.</p>
					<p class="sitebyfeast">Site by <a href="https://feastcreative.com/" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/feast.png" alt="feast" /></a></p>
				</div><!-- .site-info -->
			</div>
		</div><!-- .inner -->
	</footer><!-- .site-footer -->

</div><!-- .site -->

<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery.bxslider.js"></script>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery.cookie.js"></script>
<script>
$(function() {
	$("h3.menu-toggle,a.keyboardnav").click(function(){
		$("body").toggleClass("toggled-on").removeClass("toggled-search");
		return false;
	});
	$(".mm-search a").click(function(){
		$("body").toggleClass("toggled-search").removeClass("toggled-on");
		return false;
	});
});
$(document).ready(function($) {
	$('.bxslider').bxSlider({
		'auto'			: true,
		'pause'			: 6000,
		'stopAutoOnClick': true,
		'touchEnabled'	: false
	});
	$('.eventslider').bxSlider({
		'auto'			: true,
		'pause'			: 6000,
		'stopAutoOnClick': true,
		'touchEnabled'	: false,
		'controls' 		: false
	});
	$('.dd').addClass('hidden');
	$('.dd h4').click(function(){
		$(this).parent().toggleClass('showing');
	});

    $(window).scroll(function () {
        if ($(window).scrollTop() > 50) {
            $('#page').addClass('scrolled');
        }
        else{
            $('#page').removeClass('scrolled');
        }
    });
});
</script>
<script>
$(function($) {
	if ($.cookie('cookieson')) {
	// test cookie was set via PHP
		if ($.cookie('nobanner')){
			$( "#cookiebanner" ).css({
				'display':'none'
			});
		}else{
			$( "#cookiebanner" ).css({
				'display':'block'
			});
		}
	} else {
	  $.cookie('cookieson', null);
	}
	$('#setCookie').click(function() {
		$.cookie('nobanner', 'This+cookie+gets+rid+of+the+cookie+banner.', { path: '/', expires: 30 });
		$( "#cookiebanner" ).css({
			'display':'none'
		});
	});
});
</script>
<?php wp_footer(); ?>
</body>
</html>
