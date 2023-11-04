<?php

 /**   Test Compteur mot excerpt   **/
 function size_excerpt_length($length) {
	return 20;
 }
 add_filter('excerpt_length', 'size_excerpt_length');
 function size_more( $more ) {
	return '...';
 }
 add_filter('excerpt_more', 'size_more');

/** SELECT BG IMAGE **/
 function mytheme_register_assets() {
       if (get_theme_mod( 'customizer_setting_bg' )) {
         wp_enqueue_style('bg-php', 'custom/bg-css.php' );
         $imgurl = esc_url( get_theme_mod( 'customizer_setting_bg' ) );
         $custom_bg = "
           body {
             background-image: linear-gradient(295deg,rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.8) 50%),url($imgurl) !important;
             background-position: center bottom;
             background-repeat: no-repeat;
             background-color: white;
             background-attachment: fixed;
             background-size: cover;
           }
         ";
         wp_add_inline_style( 'bg-php', $custom_bg );
      }
 };
 require_once 'custom/customizer-bg.php';
 add_action('wp_enqueue_scripts', 'mytheme_register_assets');


/**
OTHER FUNCTIONS
 */


add_action( 'init', 'custom_remove_footer_credit', 10 );
function custom_remove_footer_credit () {
    remove_action( 'storefront_footer', 'storefront_credit', 20 );
    add_action( 'storefront_footer', 'custom_storefront_credit', 20 );
}

function custom_storefront_credit() {
	// TODO Add in another file
	?>
  <div class="icons">
  	<a href="mailto:contact@lepointbleu.net" target="_blank" class="email" title="Envoyez un mail"></a>
  	<a href="tel:+33-9-72-42-15-66" target="_blank" class="phone" title="Appelez-nous !"></a>
  	<a href="https://goo.gl/maps/1pUMbgfskstKAnZC6" target="_blank" class="map" title="Notre adresse"></a>

  	<a href="https://www.facebook.com/pg/LePointBleuAssociation/" target="_blank" class="facebook" title="Notre page Facebook"></a>
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
add_filter('login_errors',create_function('$a', "return null;"));remove_action('wp_head', 'wlwmanifest_link');

function shortened_title() {
	$original_title = get_the_title();
	$title = html_entity_decode($original_title, ENT_QUOTES, "UTF-8");
	// indiquer le nombre de caratère
	$limit = "30";
	// fin du titre couper
	$ending="...";
	if(strlen($title) >= ($limit+3)) {
	$title = substr($title, 0, $limit) . $ending; }
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



/**   Image thumbnails accueil   **/
add_theme_support( 'post-thumbnails' );









/**
* FUNCTIONS FROM STOREFRONT
**/


if ( ! function_exists( 'storefront_post_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function storefront_post_header() {
		?>
		<header class="entry-header">
		<?php

		/**
		 * Functions hooked in to storefront_post_header_before action.
		 *
		 * @hooked storefront_post_meta - 10
		 */

		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		}

    do_action( 'storefront_post_header_before' );
		do_action( 'storefront_post_header_after' );
		?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'storefront_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function storefront_post_content() {

    if ( ! is_single() ){
      echo '<a href="'.get_permalink().'">';
    }
		?>
		<div class="entry-content">
    <?php

		/**
		 * Functions hooked in to storefront_post_content_before action.
		 *
		 * @hooked storefront_post_thumbnail - 10
		 */
		do_action( 'storefront_post_content_before' );
    if ( is_single() ) {
      the_content(
  			sprintf(
  				/* translators: %s: post title */
  				__( 'Continue reading %s', 'storefront' ),
  				'<span class="screen-reader-text">' . get_the_title() . '</span>'
  			)
  		);
    } else {
      the_excerpt(
  			sprintf(
  				/* translators: %s: post title */
  				__( 'Continue reading %s', 'storefront' ),
  				'<span class="screen-reader-text">' . get_the_title() . '</span>'
  			)
  		);
    }


		do_action( 'storefront_post_content_after' );

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
				'after'  => '</div>',
			)
		);

		?>
		</div><!-- .entry-content -->
		<?php
    if ( ! is_single() ){
      echo '</a>';
    }
	}
}

if ( ! function_exists( 'storefront_post_meta' ) ) {
	/**
	 * Display the post meta
	 *
	 * @since 1.0.0
	 */
	function storefront_post_meta() {
		if ( 'post' !== get_post_type() ) {
			return;
		}

		// Posted on.
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$output_time_string = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );

		$posted_on = '
			<span class="posted-on"> - ' .
			/* translators: %s: post date */
			sprintf( __( 'Paru le %s', 'storefront' ), $output_time_string ) .
			'</span>';

		// Author.
		$author = sprintf(
			'<span class="post-author">%1$s <a href="%2$s" class="url fn" rel="author">%3$s</a></span>',
			__( 'by', 'storefront' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);

		// Comments.
		$comments = '';

		if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
			$comments_number = get_comments_number_text( __( 'Leave a comment', 'storefront' ), __( '1 Comment', 'storefront' ), __( '% Comments', 'storefront' ) );

			$comments = sprintf(
				'<span class="post-comments">&mdash; <a href="%1$s">%2$s</a></span>',
				esc_url( get_comments_link() ),
				$comments_number
			);
		}
    // ShareFb.
		$shareNav = sprintf('
      <span class="share">
        <a class="share-text">Partagez</a>
        <a target="_blank" title="Facebook" href="https://www.facebook.com/sharer/sharer.php?u=%2$s">
          <div class="facebook"></div>
        </a>
        <a target="_blank" title="Twitter" href="https://twitter.com/share?url=%2$s">
          <div class="twitter"></div>
        </a>
        <a target="_blank" title="WhatsApp" href="https://wa.me/?text=%2$s">
          <div class="whatsapp"></div>
        </a>
        <a target="_blank" title="Pinterest" href="http://pinterest.com/pin/create/button/?url=%2$s&amp;media=%3$s&amp;description=%4$s">
          <div class="pinterest"></div>
        </a>
        <a target="_blank" title="Telegram" href="https://t.me/share/url?url=%2$s">
          <div class="telegram"></div>
        </a>
        <a target="_blank" title="Email" href="mailto:?body=%2$s">
          <div class="email"></div>
        </a>
      </span>',
      __( 'by', 'storefront' ),
			esc_url( get_permalink() ),
			esc_html( get_the_post_thumbnail_url(get_the_ID(),'full') ),
      esc_html( get_the_title() )
    );


    $categories_list = get_the_category_list( __( ', ', 'storefront' ) );
    if ( $categories_list ){ echo '<span class="cat">'.wp_kses_post( $categories_list ).'</span>'; }

		$tags_list = get_the_tag_list( '', __( ', ', 'storefront' ) );
    if ( $tags_list ) {
         echo esc_html( _n( '', '', count( get_the_tags() ), 'storefront' ) );
         echo '<span class="tags-links"> - ' . wp_kses_post( $tags_list ) . '</span>';
    }
		echo wp_kses(
			sprintf( '%1$s %2$s %3$s', $posted_on, $author, $shareNav, $comments, $categories_list, $tags_list), array(
				'span' => array(
					'class' => array(),
				),
        'div' => array(
					'class' => array(),
				),
				'a'    => array(
					'href'  => array(),
					'class'  => array(),
					'target'  => array(),
					'title' => array(),
					'rel'   => array(),
				),
				'time' => array(
					'datetime' => array(),
					'class'    => array(),
				),
			)
		);
	}
}
