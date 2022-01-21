<?php

namespace sMyles\WPJM\EMC;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Plugins
 *
 * @package sMyles\WPJM\EMC
 */
class Plugins {

	/**
	 * Admin constructor.
	 */
	public function __construct() {

		/**
		 * Disable the built-in field editor handling as this would just be duplicate of what this plugin does
		 */
		add_filter( 'field_editor_save_admin_custom_fields_remove_empty_value_fields', '__return_false' );
		add_filter( 'field_editor_save_custom_fields_remove_empty_value_fields', '__return_false' );

		if( $this->has_company_manager() ){
			new Plugins\CM();
		} elseif( $this->has_cariera_companies() ){
			new Plugins\Cariera();
		} elseif( $this->has_mascm_companies() ){
			new Plugins\MASCM();
		} elseif( $this->has_afjcl_companies() ){
			new Plugins\AFJCL();
		}
	}

	/**
	 * Company Manager
	 *
	 * @return bool
	 * @since @@version
	 *
	 */
	public function has_company_manager() {

		$wpcm   = 'wp-company-manager/wp-company-manager.php';

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
	public function has_cariera_companies() {

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
	public function has_mascm_companies() {
		return class_exists( 'MAS_WP_Job_Manager_Company' );
	}

	/**
	 * Astoundify Company Listings
	 *
	 * @return bool
	 * @since @@version
	 *
	 */
	public function has_afjcl_companies() {

		return class_exists( 'WP_Job_Manager_Company_Listings' );
	}
}