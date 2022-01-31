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
	public $slug = 'resume';
	/**
	 * @var string
	 */
	public $post_type = 'resume';

	/**
	 * @var null|\sMyles\WPJM\EMC\Resume
	 */
	protected static $single_instance = null;
	/**
	 * @var \sMyles\WPJM\EMC\Admin\Resume
	 */
	public $admin;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return Resume A single instance of this class.
	 * @since  1.0.0
	 */
	public static function get_instance() {

		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Resume constructor.
	 */
	public function __construct() {

		if( is_admin() ){
			$this->admin = new Admin\Resume( $this );
		}

		add_action( 'resume_manager_update_resume_data', array( $this, 'check_fields_and_remove' ), 99999, 2 );
	}

	/**
	 * Get Label
	 *
	 * @return string|void
	 * @since @@version
	 *
	 */
	public function get_label() {
		return __( 'Resume' );
	}

	/**
	 * Get Resume Manager Fields
	 *
	 * @param bool $only_fields
	 *
	 * @return array
	 * @since @@version
	 */
	public function get_fields( $only_fields = false ) {

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

		return $only_fields ? $wprm->get_fields( 'resume_fields' ) : [ 'resume_fields' => $wprm->get_fields( 'resume_fields' ) ];
	}
}