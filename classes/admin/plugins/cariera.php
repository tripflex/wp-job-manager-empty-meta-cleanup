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
	 * @var \sMyles\WPJM\EMC\Plugins\Cariera
	 */
	public $type;

	/**
	 * Cariera constructor.
	 *
	 * @param $type
	 */
	public function __construct( $type ) {
		$this->type = $type;
		new Cariera\Settings( $this );
		add_action( 'cariera_save_company', [ $this, 'check_fields_and_remove' ], 99999, 2 );
	}

	/**
	 * Get Company Manager Fields
	 *
	 * @return array
	 * @since 1.0.0
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