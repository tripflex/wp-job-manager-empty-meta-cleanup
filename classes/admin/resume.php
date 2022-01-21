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

}