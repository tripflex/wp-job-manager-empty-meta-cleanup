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
	 * @var string
	 */
	public $type = 'job';

	/**
	 * Job constructor.
	 */
	public function __construct() {
		add_action( 'job_manager_save_job_listing', [ $this, 'check_fields_and_remove' ], 99999, 2 );
	}


}