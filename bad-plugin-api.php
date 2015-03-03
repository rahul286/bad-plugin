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

function bad_api_call( $post_id ) {
  $res = wp_remote_get( 'http://wcmum.rtcamp.net/ping.php');
  echo "<h2>" . "BAD API at Work" . $res['body'] ."</h2>";
}

add_action('save_post', 'register_bad_api_call');
