<?php

namespace sMyles\WPJM\EMC\Plugins;

use sMyles\WPJM\EMC\Meta\Remove as MetaRemove;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Cariera
 *
 * @package sMyles\WPJM\EMC
 */
class Cariera extends MetaRemove {

	/**
	 * @var string
	 */
	public $type = 'company';

	/**
	 * CM constructor.
	 */
	public function __construct() {
		add_action( 'cariera_update_company_data', [ $this, 'check_fields_and_remove' ], 99999, 2 );
	}

	/**
	 * Get Company Manager Fields
	 *
	 * @return array
	 * @since @@version
	 *
	 */
	public function get_fields() {

		if ( ! defined( 'JOB_MANAGER_PLUGIN_DIR' ) || ! defined( 'CARIERA_PLUGIN_DIR' ) ) {
			return [];
		}

		if ( ! class_exists( 'WP_Job_Manager_Form' ) ) {
			include( JOB_MANAGER_PLUGIN_DIR . '/includes/abstracts/abstract-wp-job-manager-form.php' );
		}

		if ( ! class_exists( 'Cariera_Company_Manager_Form_Submit_Company' ) ) {
			require_once( CARIERA_PLUGIN_DIR . '/inc/core/wp-company-manager/form/submit-company.php' );
		}

		$wpcm = \Cariera_Company_Manager_Form_Submit_Company::instance();

		return [
			'company_fields' => $wpcm->get_fields( 'company_fields' )
		];
	}
}