<?php
/**
 * Plugin Name: Empty Meta Cleanup for WP Job Manager
 * Plugin URI:  https://smyl.es
 * Description: Clean up and prevent empty meta from being saved for Job, Company, or Resume listings in database
 * Version:     1.0.0
 * Author:      Myles McNamara
 * Author URI:  https://smyl.es
 * License:     GPL3
 * Text Domain: wp-job-manager-empty-meta-cleanup
 * Domain Path: /languages
 * Requires at least: 4.2
 * Tested up to: 5.8.2
 * Last Updated: @@timestamp
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( ! defined( 'WPJM_EMPTY_META_CLEANUP_VERSION' ) ) {
	define( 'WPJM_EMPTY_META_CLEANUP_VERSION', '1.0.0' );
}
if ( ! defined( 'WPJM_EMPTY_META_CLEANUP_PLUGIN_DIR' ) ) {
	define( 'WPJM_EMPTY_META_CLEANUP_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
}
if ( ! defined( 'WPJM_EMPTY_META_CLEANUP_PLUGIN_URL' ) ) {
	define( 'WPJM_EMPTY_META_CLEANUP_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
}
if ( ! defined( 'WPJM_EMPTY_META_CLEANUP_BASENAME' ) ) {
	define( 'WPJM_EMPTY_META_CLEANUP_BASENAME', plugin_basename( __FILE__ ) );
}

require_once( 'autoload.php' );
use sMyles\WPJM\EMC\Main as Main;

/**
 * Grab the WPJM_Empty_Meta_Cleanup object and return it.
 * Wrapper for Plugin_Name::get_instance()
 *
 * @since  1.0.0
 * @return \sMyles\WPJM\EMC\Main  Singleton instance of plugin class.
 */
function WPJM_Empty_Meta_Cleanup() {
	return Main::get_instance();
}

add_action( 'plugins_loaded', array( WPJM_Empty_Meta_Cleanup(), 'hooks' ) );
