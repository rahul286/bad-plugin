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
/**
 * Adds Bad_Widget widget.
 */
class Bad_Widget extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct('Bad_widget', // Base ID
        __('Bad Widget', 'bad-plugin'), // Name
        array('description' => __('A Bad widget which slows down your site', 'bad-plugin'),) // Args
        );
    }
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        global $wpdb;
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        echo __('This is bad widegt! Ok, not at the monet but this is supposed to slow down yours ite!', 'bad_plugin');
        /*
          bad-query:: show posts with author-name where post contains certain keywords
        */
        $res = $wpdb->get_results("select post_title, display_name from wp_posts p, wp_users u WHERE p.post_author = u.ID AND p.post_status = 'publish' AND p.post_type = 'post' AND p.post_content LIKE '%microsoft%' OR  p.post_content LIKE '%apple%'",ARRAY_A);
        /*
          good-query :: fixed mistake in OR condition
        */
        // $res = $wpdb->get_results("select post_title, display_name from wp_posts p, wp_users u WHERE p.post_author = u.ID AND p.post_status = 'publish' AND p.post_type = 'post' AND (p.post_content LIKE '%microsoft%' OR  p.post_content LIKE '%apple%')", ARRAY_A);
          var_dump($res);
        echo $args['after_widget'];
    }
} // class Bad_Widget
// register Bad_Widget widget
function register_bad_widget() {
    register_widget('Bad_Widget');
}
add_action('widgets_init', 'register_bad_widget');
