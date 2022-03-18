<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Watford_Palace
 * @since Watford Palace 1.0
 */
// bool setcookie ( string $name [, string $value [, int $expire = 0 [, string $path [, string $domain [, bool $secure = false [, bool $httponly = false ]]]]]] )
$valuec1 = 'This cookie is to test if we can set a cookie';
setcookie("cookieson", $valuec1);
setcookie("cookieson", $valuec1, time()+3600);  /* expire in 1 hour */
setcookie("cookieson", $valuec1, time()+3600, "/", "https://watfordpalacetheatre.co.uk", 0, 0);
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<script>(function(){document.documentElement.className='js'})();</script>
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.typekit.net/mzg5zpp.css">
	<?php if(is_page('book')||is_page('checkout')||is_page('basket')||is_page('membership-schemes')||is_page('why-donate')){
		global $Spektrix;
		$Spektrix->SpektrixGetJavascriptCode();
	}
	?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PHHJDJ9');</script>
<!-- End Google Tag Manager -->
<?php wp_head(); ?>
<?php if(is_front_page()){ ?>
<meta name="facebook-domain-verification" content="yt6g9wk6206zt6av6v33kuu1j4yuiy">
<?php } ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/jquery.bxslider.css" rel="stylesheet" />
</head>
<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src=https://www.googletagmanager.com/ns.html?id=GTM-PHHJDJ9
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="cookiebanner" title="Cookies">
	<div class="inner">
		<p>We use cookies on this site in accordance with our <a href="<?php echo get_the_permalink(3); ?>">Privacy Policy</a></p>
		<p><a class="continue" id="setCookie">X</a></p>
	</div>
</div>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'watfordpalace' ); ?></a>
	<a class="skip-link screen-reader-text keyboardnav" href="#site-navigation"><?php _e( 'Open navigation', 'watfordpalace' ); ?></a>
	<div class="site-branding">
		<?php
		if ( is_front_page() ) :
			$el = 'h1';
		else :
			$el = 'p';
		endif;
		echo '<'.$el.' class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home"><img src="'.esc_url( get_template_directory_uri() ).'/img/logo-white.png" alt="'.get_bloginfo( 'name' ).'" /></a></'.$el.'>';
		?>
	</div><!-- .site-branding -->
	<header id="masthead" class="site-header">
		<div class="inner">
			<div class="inside">
				<div class="minimenu">
					<h3 class="menu-toggle"><span>menu</span></h3>
					<ul class="mm-icons">
						<li class="mm-basket"><a href="/basket"><span>basket</span></a></li>
						<li class="mm-account"><a href="/my-account"><span>account</span></a></li>
						<li class="mm-search"><a href="/search/"><span>search</span></a></li>
					</ul>
				</div>
				<div class="searchpanel">
					<?php
					echo '<div class="main-search">';
					get_search_form();
					echo '</div>';
					?>
				</div>
				<div class="scrollbox">
					<div class="site-nav">
						<nav id="site-navigation" class="main-navigation">
							<div class="menu-main-nav-container">
								<ul id="menu-main-nav">
							<?php
								// Primary navigation menu.
								$topnav = wp_nav_menu( array(
									'menu_class'     => 'nav-menu',
									'container'		 => '',
									'items_wrap'	 => '%3$s',
									'theme_location' => 'primary',
									'echo' => 0
								) );

								echo '<li id="menu-item-100" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-100"><a href="'.get_the_permalink(11).'">What’s on</a>';
								include('filters.php');
								echo '<div class="site-search">';
								get_search_form();
								echo '</div>';
								echo '</li>';

								echo '<li class="navgroup"><ul class="ulflexgroup">';
								echo $topnav;
								echo '</ul></li>';
							?>
								</ul>
							</div>
						</nav><!-- .main-navigation -->
						</div><!-- .site-nav -->
					<a class="skip-link screen-reader-text keyboardnav" href="#content">Close navigation</a>
				</div>
			</div><!-- .inside -->
		</div><!-- .inner -->
	</header><!-- .site-header -->
	<div id="content" class="site-content">
