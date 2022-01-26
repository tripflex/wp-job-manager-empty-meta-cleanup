<?php

namespace sMyles\WPJM\EMC\Plugins;
use sMyles\WPJM\EMC\Meta\Remove as MetaRemove;
use sMyles\WPJM\EMC\Admin\Plugins\AFJCL as AFJCLAdmin;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class AFJCL
 *
 * @package sMyles\WPJM\EMC
 */
class AFJCL extends MetaRemove {

	/**
	 * @var string
	 */
	public $slug = 'company';

	/**
	 * AFJCL constructor.
	 */
	public function __construct() {
		add_action( 'company_listings_update_company_data', [ $this, 'check_fields_and_remove' ], 99999, 2 );

		if ( is_admin() ) {
			new AFJCLAdmin( $this );
		}
	}

	/**
	 * Get Label
	 *
	 * @return string|void
	 * @since @@version
	 *
	 */
	public function get_label() {
		return __( 'Company' );
	}

	/**
	 * Get Company Manager Fields
	 *
	 * @return array
	 * @since @@version
	 *
	 */
	public function get_fields() {

		if ( ! defined( 'JOB_MANAGER_PLUGIN_DIR' ) || ! defined( 'COMPANY_LISTINGS_PLUGIN_DIR' ) ) {
			return [];
		}

		if ( ! class_exists( 'WP_Job_Manager_Form' ) ) {
			include( JOB_MANAGER_PLUGIN_DIR . '/includes/abstracts/abstract-wp-job-manager-form.php' );
		}

		if ( ! class_exists( 'WP_Job_Manager_Company_Form' ) ) {
			/**
			 * Original TechBrise Company Listings Plugin compatibility
			 */
			if ( file_exists( COMPANY_LISTINGS_PLUGIN_DIR . '/includes/forms/class-wp-job-manager-company-listings-company-form.php' ) ) {
				require_once( COMPANY_LISTINGS_PLUGIN_DIR . '/includes/forms/class-wp-job-manager-company-listings-company-form.php' );
			} else {
				require_once( COMPANY_LISTINGS_PLUGIN_DIR . '/includes/forms/class-afj-company-listings-company-form.php' );
			}
		}

		if ( ! class_exists( 'WP_Job_Manager_Company_Listings_Form_Submit_Company' ) ) {
			/**
			 * Original TechBrise Company Listings Plugin compatibility
			 */
			if ( file_exists( COMPANY_LISTINGS_PLUGIN_DIR . '/includes/forms/class-wp-job-manager-company-listings-form-submit-company.php' ) ) {
				require_once( COMPANY_LISTINGS_PLUGIN_DIR . '/includes/forms/class-wp-job-manager-company-listings-form-submit-company.php' );
			} else {
				require_once( COMPANY_LISTINGS_PLUGIN_DIR . '/includes/forms/class-afj-company-listings-form-submit-company.php' );
			}
		}

		$wpcm = \WP_Job_Manager_Company_Listings_Form_Submit_Company::instance();

		return [
			'company_fields' => $wpcm->get_fields( 'company_fields' )
		];
	}
}