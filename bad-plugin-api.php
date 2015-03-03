<?php
/*
	Plugin Name: Bad Plugin - API example
	Plugin URI: https://github.com/rahul286/bad-plugin
  Description: Goal of this plugin to show how a small but bad plugin affect your site's performance
	Author: rtCamp
	Version: 0.1
	Author URI: http://rtcamp.com/
	Text Domain: bad-plugin
*/

global $res;

function bad_api_notice() {
    var_dump($res);
    ?>
    <div class="error">
          <p><?php _e( "<h2>" . "BAD API at Work" . $res['body'] ."</h2>", 'bad-plugin' ); ?></p>
    </div>
    <?php
}

function bad_api_call( $post_id ) {
  if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

  $st = wp_is_post_revision( $post_id );

  if ( $st != 'publish' )	return;

  $res = wp_remote_get( 'http://wcmum.rtcamp.net/ping.php');
  var_dump($res);
  add_action( 'admin_notices', 'bad_api_notice' );
}

// add_action('publish_post', 'bad_api_call');
// add_action('post_updated', 'bad_api_call');
add_action('save_post', 'bad_api_call');
// add_action('edit_post', 'bad_api_call');


// add_action('draft_to_publish', 'bad_api_call');

// add_action('save_post', 'bad_api_call' );


function rt_hello() {
    ?>
    <div class="update-nag">
          <p><?php _e( "Hello from bad plugin! Just try to save post to see my badneess! :P", 'bad-plugin' ); ?></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'rt_hello' );
