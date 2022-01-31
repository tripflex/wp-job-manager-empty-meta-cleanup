<?php

namespace sMyles\WPJM\EMC\Admin\Job;
use sMyles\WPJM\EMC\Admin\Settings as AdminSettings;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Settings
 *
 * @package sMyles\WPJM\EMC\Admin\Job
 */
class Settings extends AdminSettings {

	/**
	 * Settings constructor.
	 *
	 * @param $admin \sMyles\WPJM\EMC\Admin\Job
	 */
	public function __construct( $admin ) {
		$this->admin = $admin;
		add_filter( 'job_manager_settings', array( $this, 'add_tab' ), 999999 );
		$this->init_fields();
	}

}