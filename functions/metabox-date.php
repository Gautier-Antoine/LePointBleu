<?php
// TODO UPDATE
/*
What I have added on themes/cartt/parts/loop-single.php

$hide_author = get_post_meta( get_the_ID(), '_date_event', TRUE);
if ($hide_author != 'yes') {
    show author
}
*/

/**
 *  Metabox markup per post/page
 *
 * @since 1.2.0
 */

 function lpb_meta_box_markup($post)
 {
    wp_nonce_field(basename(__FILE__), "date_nonce");
    $stored_mea = get_post_meta($post->ID);
    ?>
    <input
        type="date"
        name="_date_event"
        id="_date_event"
        <?php
            if (isset($stored_mea ['_date_event'])) {
                echo 'value="' . strval($stored_mea['_date_event'][0]) . '"';
            }
        ?>
    />
    <?php
 }
 
 /**
  *  Save metabox markup per post/page
  *
  * @since 1.2.0
  */
 
 function lpb_save_custom_meta_box($post_id)
 {
     // Checks save status
     $is_autosave = wp_is_post_autosave($post_id);
     $is_revision = wp_is_post_revision($post_id);
     $is_valid_nonce = (isset($_POST[ 'date_nonce' ]) && wp_verify_nonce($_POST[ 'date_nonce' ], basename(__FILE__))) ? true : false;
 
     // Exits script depending on save status
     if ($is_autosave || $is_revision || !$is_valid_nonce) {
         return;
    }

    // Checks for input and saves
    if (isset($_POST[ '_date_event' ])) {
        $value = strval($_POST['_date_event']);
        update_post_meta($post_id, '_date_event', $value);
    } else {
        update_post_meta($post_id, '_date_event', '');
    }
 }
 add_action('save_post', 'lpb_save_custom_meta_box', 10, 2);
 
 
 /**
  *  Add Metabox per post/page and any registered custom post type
  *
  * @since 1.2.0
  */
 function lpb_add_custom_meta_box()
 {
     $post_types = get_post_types();
     foreach ($post_types as $post_type) {
         add_meta_box('date-meta-box', __('Ajouter la date', 'lpb-date-meta'), 'lpb_meta_box_markup', $post_types, 'side', 'default', null);
     }
 }
 add_action('add_meta_boxes', 'lpb_add_custom_meta_box');
 