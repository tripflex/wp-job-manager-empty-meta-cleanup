<?php

namespace sMyles\WPJM\EMC\Admin\Plugins;
use sMyles\WPJM\EMC\Admin\Meta\Remove as MetaRemove;

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
		add_action( 'cariera_save_company', [ $this, 'check_fields_and_remove' ], 99999, 2 );
	}

	/**
	 * Get Company Manager Fields
	 *
	 * @return array
	 * @since @@version
	 *
	 */
	public function get_fields() {

		if ( ! class_exists( 'Cariera_Company_Manager_Writepanels' ) ) {

			if ( ! defined( 'CARIERA_PLUGIN_DIR' ) ) {
				return [];
			}

			require_once( CARIERA_PLUGIN_DIR . '/inc/core/wp-company-manager/writepanels.php' );
		}

		return \Cariera_Company_Manager_Writepanels::company_fields();
	}
}