<?php

namespace sMyles\WPJM\EMC\Admin\Plugins;
use sMyles\WPJM\EMC\Admin\Meta\Remove as MetaRemove;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class CM
 *
 * @package sMyles\WPJM\EMC
 */
class CM extends MetaRemove {

	/**
	 * @var string
	 */
	public $type = 'company';

	/**
	 * CM constructor.
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

		if ( ! defined( 'COMPANY_MANAGER_PLUGIN_DIR' ) ) {
			return [];
		}

		if ( ! class_exists( 'WP_Company_Manager_Admin_Writepanels' ) ) {
			require_once( COMPANY_MANAGER_PLUGIN_DIR . '/includes/admin/writepanels.php' );
		}

		return \WP_Company_Manager_Admin_Writepanels::company_fields();
	}
}