<?php
/**
 * Plugin Name: Empty Meta Cleanup for WP Job Manager
 * Plugin URI:  https://smyl.es
 * Description: Clean up and prevent empty meta from being saved for Job, Company, or Resume listings in database
 * Version:     1.0.0
 * Author:      Myles McNamara
 * Author URI:  https://smyl.es
 * Plugin URI:  https://github.com/tripflex/wp-job-manager-empty-meta-cleanup
 * License:     GPL v3 or later
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

if ( ! function_exists( 'remove_class_filter' ) ) {
	/**
	 * Remove Class Filter Without Access to Class Object
	 *
	 * In order to use the core WordPress remove_filter() on a filter added with the callback
	 * to a class, you either have to have access to that class object, or it has to be a call
	 * to a static method.  This method allows you to remove filters with a callback to a class
	 * you don't have access to.
	 *
	 * Works with WordPress 1.2+ (4.7+ support added 9-19-2016)
	 * Updated 2-27-2017 to use internal WordPress removal for 4.7+ (to prevent PHP warnings output)
	 *
	 * @param string $tag         Filter to remove
	 * @param string $class_name  Class name for the filter's callback
	 * @param string $method_name Method name for the filter's callback
	 * @param int    $priority    Priority of the filter (default 10)
	 *
	 * @return bool Whether the function is removed.
	 */
	function remove_class_filter( $tag, $class_name = '', $method_name = '', $priority = 10 ) {

		global $wp_filter;

		// Check that filter actually exists first
		if ( ! isset( $wp_filter[ $tag ] ) ) {
			return false;
		}

		/**
		 * If filter config is an object, means we're using WordPress 4.7+ and the config is no longer
		 * a simple array, rather it is an object that implements the ArrayAccess interface.
		 *
		 * To be backwards compatible, we set $callbacks equal to the correct array as a reference (so $wp_filter is updated)
		 *
		 * @see https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/
		 */
		if ( is_object( $wp_filter[ $tag ] ) && isset( $wp_filter[ $tag ]->callbacks ) ) {
			// Create $fob object from filter tag, to use below
			$fob       = $wp_filter[ $tag ];
			$callbacks = &$wp_filter[ $tag ]->callbacks;
		} else {
			$callbacks = &$wp_filter[ $tag ];
		}

		// Exit if there aren't any callbacks for specified priority
		if ( ! isset( $callbacks[ $priority ] ) || empty( $callbacks[ $priority ] ) ) {
			return false;
		}

		// Loop through each filter for the specified priority, looking for our class & method
		foreach ( (array) $callbacks[ $priority ] as $filter_id => $filter ) {

			// Filter should always be an array - array( $this, 'method' ), if not goto next
			if ( ! isset( $filter['function'] ) || ! is_array( $filter['function'] ) ) {
				continue;
			}

			// If first value in array is not an object, it can't be a class
			if ( ! is_object( $filter['function'][0] ) ) {
				continue;
			}

			// Method doesn't match the one we're looking for, goto next
			if ( $filter['function'][1] !== $method_name ) {
				continue;
			}

			// Method matched, now let's check the Class
			if ( get_class( $filter['function'][0] ) === $class_name ) {

				// WordPress 4.7+ use core remove_filter() since we found the class object
				if ( isset( $fob ) ) {
					// Handles removing filter, reseting callback priority keys mid-iteration, etc.
					$fob->remove_filter( $tag, $filter['function'], $priority );

				} else {
					// Use legacy removal process (pre 4.7)
					unset( $callbacks[ $priority ][ $filter_id ] );
					// and if it was the only filter in that priority, unset that priority
					if ( empty( $callbacks[ $priority ] ) ) {
						unset( $callbacks[ $priority ] );
					}
					// and if the only filter for that tag, set the tag to an empty array
					if ( empty( $callbacks ) ) {
						$callbacks = array();
					}
					// Remove this filter from merged_filters, which specifies if filters have been sorted
					unset( $GLOBALS['merged_filters'][ $tag ] );
				}

				return true;
			}
		}

		return false;
	}
}