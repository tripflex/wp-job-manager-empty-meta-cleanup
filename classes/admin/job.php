<?php

namespace sMyles\WPJM\EMC\Admin;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Job
 *
 * @package sMyles\WPJM\EMC
 */
class Job extends Meta\Remove {

	/**
	 * @var \sMyles\WPJM\EMC\Job
	 */
	public $type;

	/**
	 * Job constructor.
	 *
	 * @param $type \sMyles\WPJM\EMC\Job
	 */
	public function __construct( $type ) {
		$this->type = $type;
		new Job\Settings( $this );

		/**
		 * Priority must be higher than 20 to be called after core WPJM handling
		 */
		add_action( 'job_manager_save_job_listing', [ $this, 'check_fields_and_remove' ], 99999, 2 );
	}

	/**
	 * Get Job Fields
	 *
	 * @return array
	 * @since 1.0.0
	 *
	 */
	public function get_fields() {

		if ( ! class_exists( 'WP_Job_Manager_Post_Types' ) ) {
			include( JOB_MANAGER_PLUGIN_DIR . '/includes/class-wp-job-manager-post-types.php' );
		}

		return \WP_Job_Manager_Post_Types::get_job_listing_fields();
	}
}