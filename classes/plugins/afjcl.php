<?php

namespace sMyles\WPJM\EMC\Plugins;
use sMyles\WPJM\EMC\Meta\Remove as MetaRemove;

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
	public $type = 'company';

	/**
	 * AFJCL constructor.
	 */
	public function __construct() {
		add_action( 'company_listings_update_company_data', [ $this, 'check_fields_and_remove' ], 99999, 2 );
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
			require_once( COMPANY_LISTINGS_PLUGIN_DIR . '/includes/forms/class-afj-company-listings-company-form.php' );
		}

		if ( ! class_exists( 'WP_Job_Manager_Company_Listings_Form_Submit_Company' ) ) {
			require_once( COMPANY_LISTINGS_PLUGIN_DIR . '/includes/forms/class-afj-company-listings-form-submit-company.php' );
		}
		$wpcm = \WP_Job_Manager_Company_Listings_Form_Submit_Company::instance();

		return [
			'company_fields' => $wpcm->get_fields( 'company_fields' )
		];
	}
}