<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Star Wars Info
 * Description:       Display Star Wars character information
 * Version:           1.0.0
 * Author:            David Wilhelm
 * Author URI:        http://davwilh.com/
 */

// prevent direct access to file for security
if (!defined('ABSPATH')) {
  exit;
}

// load files
// require_once(plugin_dir_path(__FILE__) . '/includes/star-wars-info-scripts.php');
require_once(plugin_dir_path(__FILE__) . '/includes/star-wars-info-class.php');
require_once(plugin_dir_path(__FILE__) . '/includes/star-wars-info-metabox.php');

// register SWI_Widget widget
function register_swi_widget()
{
  register_widget('SWI_Widget');
}
add_action('widgets_init', 'register_swi_widget');
