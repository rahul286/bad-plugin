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
class Bad_Api_Plugin {
    // source :: http://wordpress.stackexchange.com/a/152059/5075
    public function __construct() {
        add_action('save_post', array($this, 'save_post'));
        add_action('admin_notices', array($this, 'admin_notices'));
    }
    public function save_post($post_id, $post, $update) {
        $rt_status = get_post_status($post_id);

        if ($rt_status == 'auto-draft') return;
        if ($rt_status == 'inherit') return;

        $res = wp_remote_get('http://wcmum.rtcamp.net/ping.php',array( 'timeout' => 30));
        // $res['body'] = 'pong';
        rt_error_log("post-status");
        rt_error_log($post_id . " " . $rt_status);
        rt_error_log("dump res");
        rt_error_log($res);
        rt_error_log("dump body");
        rt_error_log($res['body']);

        update_post_meta($post_id, 'rt_ping', $res['body'], 'rt_ping');

        // Add your query var if the coordinates are not retreive correctly.
        add_filter('redirect_post_location', array($this, 'add_notice_query_var'), 99);
    }
    public function add_notice_query_var($location) {
        global $post;
        $val = get_post_meta($post->ID, 'rt_ping', true);
        // rt_error_log("locaiton");
        // rt_error_log($location);
        // rt_error_log("post_id");
        // rt_error_log($post->ID);
        // rt_error_log("val");
        // rt_error_log($val);
        remove_filter('redirect_post_location', array($this, 'add_notice_query_var'), 99);
        return add_query_arg(array('bad' => $val), $location);
    }
    public function admin_notices() {
        if (!isset($_GET['bad'])) {
            return;
        }
?>
         <div class="error">
           <p><?php _e("BAD API at Work:  " . $_GET['bad'], 'bad-plugin'); ?></p>
         </div>
         <?php
    }
}
$bad_api_plugin = new Bad_Api_Plugin;
function rt_error_log($str) {
    if (is_string($str)) {
        error_log("\n\n" . $str . "\n\n");
    } elseif (is_array($str)) {
        rt_error_log(var_export($str, true));
    } elseif (is_object($str)) {
        rt_error_log(var_export((array)$str, true));
    } else {
        rt_error_log("ERROR: Paramter is not string or array. Instead it's " . gettype($str));
    }
}
