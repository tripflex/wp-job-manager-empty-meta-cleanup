<?php

namespace sMyles\WPJM\EMC\Plugins;

use sMyles\WPJM\EMC\Meta\Remove as MetaRemove;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class MASCM
 *
 * @package sMyles\WPJM\EMC
 */
class MASCM extends MetaRemove {

	/**
	 * @var string
	 */
	public $type = 'company';

	/**
	 * MASCM constructor.
	 */
	public function __construct() {
		add_action( 'mas_job_manager_company_update_company_data', [ $this, 'check_fields_and_remove' ], 99999, 2 );
	}

	/**
	 * Get Company Manager Fields
	 *
	 * @return array
	 * @since @@version
	 *
	 */
	public function get_fields() {

		if ( ! defined( 'JOB_MANAGER_PLUGIN_DIR' ) || ! class_exists( 'MAS_WP_Job_Manager_Company' ) ) {
			return [];
		}

		if ( ! class_exists( 'WP_Job_Manager_Form' ) ) {
			include( JOB_MANAGER_PLUGIN_DIR . '/includes/abstracts/abstract-wp-job-manager-form.php' );
		}

		if ( ! class_exists( 'MAS_WP_Job_Manager_Company_Form_Submit_Company' ) ) {
			$mas_cm_instance = \MAS_WP_Job_Manager_Company::instance();
			require_once( $mas_cm_instance->plugin_dir . 'includes/forms/class-mas-wp-job-manager-company-form-submit-company.php' );
		}

		$wpcm = \MAS_WP_Job_Manager_Company_Form_Submit_Company::instance();

		return [
			'company_fields' => $wpcm->get_fields( 'company_fields' )
		];
	}
}