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
