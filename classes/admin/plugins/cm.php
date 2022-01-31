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
	 * @var \sMyles\WPJM\EMC\Plugins\CM
	 */
	public $type;

	/**
	 * CM constructor.
	 *
	 * @param \sMyles\WPJM\EMC\Plugins\CM $type
	 */
	public function __construct( $type ) {
		$this->type = $type;
		new CM\Settings( $this );
		add_action( 'company_manager_save_company', [ $this, 'check_fields_and_remove' ], 99999, 2 );
	}

	/**
	 * Get Company Manager Fields
	 *
	 * @return array
	 * @since 1.0.0
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