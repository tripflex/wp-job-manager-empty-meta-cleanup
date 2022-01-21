<?php

namespace sMyles\WPJM\EMC;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Resume
 *
 * @package sMyles\WPJM\EMC
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
		add_action( 'resume_manager_update_resume_data', array( $this, 'check_fields_and_remove' ), 99999, 2 );
	}

	/**
	 * Get Resume Manager Fields
	 *
	 * @return array
	 * @since @@version
	 *
	 */
	public function get_fields() {

		if ( ! defined( 'JOB_MANAGER_PLUGIN_DIR' ) || ! defined( 'RESUME_MANAGER_PLUGIN_DIR' ) ) {
			return [];
		}

		if ( ! class_exists( 'WP_Job_Manager_Form' ) ) {
			include( JOB_MANAGER_PLUGIN_DIR . '/includes/abstracts/abstract-wp-job-manager-form.php' );
		}

		if ( ! class_exists( 'WP_Resume_Manager_Form_Submit_Resume' ) ) {
			require_once( RESUME_MANAGER_PLUGIN_DIR . '/includes/forms/class-wp-resume-manager-form-submit-resume.php' );
		}

		$wprm = \WP_Resume_Manager_Form_Submit_Resume::instance();

		return [
			'resume_fields' => $wprm->get_fields( 'resume_fields' )
		];
	}
}