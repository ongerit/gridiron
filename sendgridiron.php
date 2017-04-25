<?php

 /*
 Plugin Name: Gridiron Challenge
 Plugin URI: /gridiron
 Description: A code challenge for prospective WordPress devs for at SendGrid.
 Version: 1.0
 Author: Thomas Ongeri
 Author URI: www.thomasongeri.com
 */

// Register Gridiron Type and Tax

function register_gridiron() {

	register_post_type( 'gridiron', array(
    'public' => true,
    'label'  => 'Gridiron',
    'has_archive' => true,
    'menu_position' => 15,
    'menu_icon' => 'dashicons-grid-view',
    'supports' => array( 'title', 'editor', 'custom-fields' ),
    'rewrite' => array( 'slug' => 'gridiron', 'with_front' => false ),
    'taxonomies' => array( 'gridlines' )
  ));

}

// Create Gridiron Posts

function create_irons() {

	// Create our Gridiron yardlines

	$irons = array ('010','020','030','040','050','060','070','080','090','100');

	foreach ( $irons as $iron ) {

		$new_iron = array(
		  'post_title'   => $iron,
		  'post_content' => 'Ten Yards',
		  'post_date' => date('Y-m-d', time() - 60 * 60 * 24),
		  'post_type' => 'gridiron',
		  'post_status'  => 'publish',
		  'post_author'  => get_current_user_id(),
		);

		wp_insert_post( $new_iron );
	}

}
add_action( 'init', 'register_gridiron' );

// Gridiron Template

function gridiron_template( $archive_template ) {
     global $post;

     if ( is_post_type_archive ('gridiron') ) {
          $archive_template = dirname( __FILE__ ) . '/challenge.php';
     }
     return $archive_template;
}
add_filter('archive_template','gridiron_template');

// Install Gridiron plugin

function gridiron_install() {

  register_gridiron();
  create_irons();
  flush_rewrite_rules();

}
register_activation_hook(__FILE__, 'gridiron_install');

function delete_post_type() {
  $post_type = 'gridiron';
  // [TO] setting numberposts
  // to -1 returns all the posts
  $gridiron_posts = get_posts( array( 'post_type' => $post_type, 'numberposts' => -1));

  foreach( $gridiron_posts as $gridiron_post ) {
     // Delete's each post.
    wp_delete_post( $gridiron_post->ID, true);
    // [TO] Set to False if
    // you want to send them to Trash.
  }
}

// [BONUS] 1. Use register_uninstall_hook() to
// remove instances of the content type from the
// database when the plugin is deleted.
register_uninstall_hook(__FILE__, delete_post_type);

?>
