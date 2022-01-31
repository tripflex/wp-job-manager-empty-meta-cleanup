<?php

namespace sMyles\WPJM\EMC;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Job
 *
 * @package sMyles\WPJM\EMC
 */
class Job extends Meta\Remove {

	/**
	 * @var string
	 */
	public $slug = 'job';

	/**
	 * @var string
	 */
	public $post_type = 'job_listing';

	/**
	 * @var Admin\Job
	 */
	public $admin;

	/**
	 * @var null|\sMyles\WPJM\EMC\Job
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return Job A single instance of this class.
	 * @since  1.0.0
	 */
	public static function get_instance() {

		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Job constructor.
	 */
	public function __construct() {
		if( is_admin() ){
			$this->admin = new Admin\Job( $this );
		}

		add_action( 'job_manager_update_job_data', array( $this, 'check_fields_and_remove' ), 99999, 2 );
	}

	/**
	 * Get Label
	 *
	 * @return string|void
	 * @since 1.0.0
	 *
	 */
	public function get_label(){
		return __( 'Job' );
	}

	/**
	 * Get WP Job Manager Fields
	 *
	 * @param bool $only_fields
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function get_fields( $only_fields = false ) {

		if ( ! defined( 'JOB_MANAGER_PLUGIN_DIR' ) ) {
			return [];
		}

		if ( ! class_exists( 'WP_Job_Manager_Form' ) ) {
			include( JOB_MANAGER_PLUGIN_DIR . '/includes/abstracts/abstract-wp-job-manager-form.php' );
		}

		if ( ! class_exists( 'WP_Job_Manager_Form_Submit_Job' ) ) {
			// As of WPJM 1.25.2 and newer, the job_manager_multi_job_type() function is called in the init_fields() method, if for some reason
			// that function is not available, we have to manually load the files, and remove the core method that includes them to prevent fatal PHP errors.
			if ( defined( 'JOB_MANAGER_VERSION' ) && version_compare( JOB_MANAGER_VERSION, '1.25.2', 'ge' ) && ! function_exists( 'job_manager_multi_job_type' ) ) {
				remove_class_filter( 'after_setup_theme', 'WP_Job_Manager', 'include_template_functions', 11 );
				require_once JOB_MANAGER_PLUGIN_DIR . '/wp-job-manager-functions.php';
				require_once JOB_MANAGER_PLUGIN_DIR . '/wp-job-manager-template.php';
			}
			require_once JOB_MANAGER_PLUGIN_DIR . '/includes/forms/class-wp-job-manager-form-submit-job.php';
		}

		$wpjm = \WP_Job_Manager_Form_Submit_Job::instance();
		$wpjm->init_fields();

		if( $only_fields ){
			return array_merge( $wpjm->get_fields( 'job' ), $wpjm->get_fields( 'company' ) );
		}

		return [
			'job'     => $wpjm->get_fields( 'job' ),
			'company' => $wpjm->get_fields( 'company' )
		];
	}
}