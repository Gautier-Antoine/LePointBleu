<?php
function bg_customize_register( $wp_customize ) {
    // Add Settings
    $wp_customize->add_setting('customizer_setting_bg', array(
        'transport'         => 'refresh',
        'height'         => 325,
    ));
    // Add Section
    $wp_customize->add_section('bg-img', array(
        'title'             => 'Background Image',
        'priority'          => 70,
    ));
    // Add Controls
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'customizer_setting_bg_control', array(
        'label'             => 'Choose the background image',
        'section'           => 'bg-img',
        'settings'          => 'customizer_setting_bg',
    )));
}
add_action('customize_register', 'bg_customize_register');


/** SELECT BG IMAGE **/
function mytheme_register_assets() {
	if (get_theme_mod( 'customizer_setting_bg' )) {
		wp_enqueue_style('bg-php', 'bg-css.php' );
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
 }
 add_action('wp_enqueue_scripts', 'mytheme_register_assets');