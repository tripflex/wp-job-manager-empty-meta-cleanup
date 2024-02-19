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

		if ( ! defined( 'CARIERA_PLUGIN_DIR' ) ) {
			return [];
		}

		/**
		 * Version >= 1.7.2+ of Cariera changes to using namespaces
		 */
		if ( ! class_exists( '\Cariera_Core\Core\Company_Manager\Writepanels' ) ) {
			// Check for the existence of the old class name
			if ( class_exists( 'Cariera_Company_Manager_Writepanels' ) ) {
				class_alias( 'Cariera_Company_Manager_Writepanels', '\Cariera_Core\Core\Company_Manager\Writepanels' );
			} else {

				// Define the new and old file paths
				$new_file_path = CARIERA_PLUGIN_DIR . '/inc/core/company-manager/writepanels.php';
				$old_file_path = CARIERA_PLUGIN_DIR . '/inc/core/wp-company-manager/writepanels.php';

				// Check if the new file exists
				if ( file_exists( $new_file_path ) ) {
					require_once( $new_file_path );
				} // If the new file doesn't exist, check if the old file exists
				else if ( file_exists( $old_file_path ) ) {
					require_once( $old_file_path );
				}
			}
		}

		return \Cariera_Core\Core\Company_Manager\Writepanels::company_fields();
	}
}