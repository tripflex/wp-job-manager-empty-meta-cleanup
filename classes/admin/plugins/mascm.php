<?php

namespace sMyles\WPJM\EMC\Admin\Plugins;
use sMyles\WPJM\EMC\Admin\Meta\Remove as MetaRemove;

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
		add_action( 'company_manager_save_company', [ $this, 'check_fields_and_remove' ], 99999, 2 );
	}

	/**
	 * Get Company Manager Fields
	 *
	 * @return array
	 * @since @@version
	 *
	 */
	public function get_fields() {

		if ( ! class_exists( 'MAS_WP_Job_Manager_Company' ) ) {
			return [];
		}

		if ( ! class_exists( 'MAS_WPJMC_Writepanels' ) ) {
			$mas_cm_instance = \MAS_WP_Job_Manager_Company::instance();
			require_once( $mas_cm_instance->plugin_dir . 'includes/class-mas-wp-job-manager-company-writepanels.php' );
		}

		return \MAS_WPJMC_Writepanels::company_fields();
	}
}