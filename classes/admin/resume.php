<?php

namespace sMyles\WPJM\EMC\Admin;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Resume
 *
 * @package sMyles\WPJM\EMC\Admin
 */
class Resume extends Meta\Remove {

	/**
	 * @var string
	 */
	public $type = 'resume';

	/**
	 * Resume constructor.
	 */
	public function __construct() {
		add_action( 'resume_manager_save_resume', [ $this, 'check_fields_and_remove' ], 99999, 2 );
	}

	/**
	 * Get Job Fields
	 *
	 * @return array
	 * @since @@version
	 *
	 */
	public function get_fields() {

		if ( ! class_exists( 'WP_Resume_Manager_Writepanels' ) ) {
			include( RESUME_MANAGER_PLUGIN_DIR . '/includes/admin/class-wp-resume-manager-writepanels.php' );
		}

		return \WP_Resume_Manager_Writepanels::resume_fields();
	}
}