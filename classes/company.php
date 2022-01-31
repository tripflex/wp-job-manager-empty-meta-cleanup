<?php

namespace sMyles\WPJM\EMC;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Company
 *
 * @package sMyles\WPJM\EMC
 */
class Company {

	/**
	 * @var null|\sMyles\WPJM\EMC\Plugins\CM|\sMyles\WPJM\EMC\Plugins\Cariera|\sMyles\WPJM\EMC\Plugins\MASCM|\sMyles\WPJM\EMC\Plugins\AFJCL
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return \sMyles\WPJM\EMC\Plugins\CM|\sMyles\WPJM\EMC\Plugins\Cariera|\sMyles\WPJM\EMC\Plugins\MASCM|\sMyles\WPJM\EMC\Plugins\AFJCL A single instance of the companies class
	 * @since  1.0.0
	 */
	public static function get_instance() {

		if ( null === self::$single_instance ) {
			if ( self::has_company_manager() ) {
				self::$single_instance = Plugins\CM::get_instance();
			} elseif ( self::has_cariera_companies() ) {
				self::$single_instance = Plugins\Cariera::get_instance();
			} elseif ( self::has_mascm_companies() ) {
				self::$single_instance = Plugins\MASCM::get_instance();
			} elseif ( self::has_afjcl_companies() ) {
				self::$single_instance = Plugins\AFJCL::get_instance();
			}
		}

		return self::$single_instance;
	}

	/**
	 * Company Manager
	 *
	 * @return bool
	 * @since @@version
	 *
	 */
	public static function has_company_manager() {

		$wpcm = 'wp-company-manager/wp-company-manager.php';

		if ( defined( 'COMPANY_MANAGER_PLUGIN_DIR' ) || class_exists( 'WP_Company_Manager' ) ) {
			return true;
		}

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		if ( is_plugin_active( $wpcm ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Cariera Companies (built-in to theme)
	 *
	 * @return bool
	 * @since @@version
	 *
	 */
	public static function has_cariera_companies() {

		$wpcm = 'cariera-plugin/cariera-core.php';

		if ( defined( 'CARIERA_PLUGIN_DIR' ) || class_exists( 'Cariera_Company_Manager' ) ) {
			return true;
		}

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		if ( is_plugin_active( $wpcm ) ) {
			return true;
		}

		return false;
	}

	/**
	 * MAS Company Manager
	 *
	 * @return bool
	 * @since @@version
	 *
	 */
	public static function has_mascm_companies() {

		return class_exists( 'MAS_WP_Job_Manager_Company' );
	}

	/**
	 * Astoundify Company Listings
	 *
	 * @return bool
	 * @since @@version
	 *
	 */
	public static function has_afjcl_companies() {

		return class_exists( 'WP_Job_Manager_Company_Listings' );
	}
}