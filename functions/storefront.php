<?php

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


        $post = get_post();
        $stored_mea = get_post_meta($post->ID);
        if (isset($stored_mea['_date_event'])) {
            $value = strval($stored_mea['_date_event'][0]);
            $formated_date = date_i18n(get_option('date_format'), strtotime($value));
            echo '<span class="tags-links"> - ' . $formated_date . '</span>';
        }
        // ! OLD
        $tags_list = get_the_tag_list( '', __( ', ', 'storefront' ) );
        // if ( $tags_list ) {
            // echo esc_html( _n( '', '', count( get_the_tags() ), 'storefront' ) );
            // echo '<span class="tags-links"> - ' . wp_kses_post( $tags_list ) . '</span>';
        // }
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
