<?php
/**
 * The template used for displaying page content in template-homepage.php
 *
 * @package storefront
 */

    $featured_image = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
?>

<div 
    id="post-<?php the_ID(); ?>"
    <?php post_class(); ?>
    style="<?php storefront_homepage_content_styles(); ?>"
    data-featured-image="<?php echo esc_url( $featured_image ); ?>"
>
	<div class="col-full">
		<?php
            /**
             * Functions hooked in to storefront_page add_action
             *
             * @hooked storefront_homepage_header      - 10
             * @hooked storefront_page_content         - 20
             */
            do_action( 'storefront_homepage' );
		?>
	</div>

    <h2>Les derniers articles</h2>
    <div class="row">
        <?php
            $query = new WP_Query([
                'post_type' => 'post',
                'posts_per_page' => 3,
                'orderby' => 'date'
            ]);
            while($query->have_posts()): $query->the_post();
                get_template_part('card');
            endwhile;
            wp_reset_postdata();
        ?>
    </div>
</div><!-- #post-## -->
