<?php

namespace sMyles\WPJM\EMC\Admin\Resume;
use sMyles\WPJM\EMC\Admin\Settings as AdminSettings;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Settings
 *
 * @package sMyles\WPJM\EMC\Admin\Resume
 */
class Settings extends AdminSettings {

	/**
	 * Settings constructor.
	 *
	 * @param $admin \sMyles\WPJM\EMC\Admin\Resume
	 */
	public function __construct( $admin ) {
		$this->admin = $admin;
		add_filter( 'resume_manager_settings', array( $this, 'add_tab' ), 999999 );
		$this->init_fields();
	}

}