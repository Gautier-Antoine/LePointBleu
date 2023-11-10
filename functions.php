<?php

/**   Image thumbnails accueil   **/
add_theme_support( 'post-thumbnails' );

require_once 'functions/storefront.php';
require_once 'functions/metabox-date.php';
require_once 'custom/customizer-bg.php';

 /**   Test Compteur mot excerpt   **/
 function size_excerpt_length($length) {
	return 20;
 }
 add_filter('excerpt_length', 'size_excerpt_length');

 function size_more( $more ) {
	return '...';
 }
 add_filter('excerpt_more', 'size_more');



/** OTHER FUNCTIONS */


add_action( 'init', 'custom_remove_footer_credit', 10 );
function custom_remove_footer_credit () {
    remove_action( 'storefront_footer', 'storefront_credit', 20 );
    add_action( 'storefront_footer', 'custom_storefront_credit', 20 );
}

function custom_storefront_credit() {
	?>
	<div class="icons">
		<a href="mailto:contact@lepointbleu.net" target="_blank" class="email" title="Envoyez un mail"></a>
		<a href="tel:+33-9-72-42-15-66" target="_blank" class="phone" title="Appelez-nous !"></a>
		<a href="https://goo.gl/maps/1pUMbgfskstKAnZC6" target="_blank" class="map" title="Notre adresse"></a>
		<a
			href="https://www.facebook.com/pg/LePointBleuAssociation/"
			target="_blank"
			class="facebook"
			title="Notre page Facebook"
		></a>
	</div>
  	<a href="https://www.lepointbleu.net/mentions-legales/">Mentions Légales</a>
	<div class="copyright">
		&copy; <?php echo get_bloginfo( 'name' ) . ' ' . get_the_date( 'Y' ); ?> / designed by <a href="https://www.gautierantoine.com" alt="gautierantoine.com" target="_blank">gautierantoine.com</a>
	</div><!-- .site-info -->
	<?php
}



function remove_wordpress_version() {
  return '';
}
add_filter('the_generator', 'remove_wordpress_version');

function _remove_script_version( $src ){
  $parts = explode( '?', $src );
  return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
// add_filter('login_errors', create_function('$a', "return null;"));
remove_action('wp_head', 'wlwmanifest_link');

function shortened_title() {
	$original_title = get_the_title();
	$title = html_entity_decode($original_title, ENT_QUOTES, "UTF-8");
	// indiquer le nombre de caratère
	$limit = "30";
	// fin du titre couper
	$ending="...";
	if (strlen($title) >= ($limit+3)) {
		$title = substr($title, 0, $limit) . $ending;
	}
	echo $title;
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset( $content_width )) {
	$content_width = 810;
}



/**   Google Map   **/

function rockable_googlemap($atts, $content = null) {
	extract(
		shortcode_atts(array(
			"width" => '940',
			"height" => '300',
			"src" => ''
		), $atts)
	);
	return '
		<div>
			<iframe src="'.$src.'&output=embed" width="'.$width.'" height="'.$height.'"  frameborder="0" marginwidth="0" marginheight="0" scrolling="no"></iframe>
		</div>
   ';
}
add_shortcode("googlemap", "rockable_googlemap");



/**   Google Analytics **/

function ns_google_analytics() { ?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-130967049-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-130967049-1');
	</script>
      <?php
      }
add_action( 'wp_head', 'ns_google_analytics', 10 );
