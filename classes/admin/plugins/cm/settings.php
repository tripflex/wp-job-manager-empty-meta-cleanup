<?php

namespace sMyles\WPJM\EMC\Admin\Plugins\CM;
use sMyles\WPJM\EMC\Admin\Settings as AdminSettings;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Settings
 *
 * @package sMyles\WPJM\EMC\Admin\Plugins\CM
 */
class Settings extends AdminSettings {

	/**
	 * Settings constructor.
	 *
	 * @param \sMyles\WPJM\EMC\Admin\Plugins\CM $admin
	 */
	public function __construct( $admin ) {
		$this->admin = $admin;
		add_filter( 'company_manager_settings', array( $this, 'add_tab' ), 999999 );
		$this->init_fields();
	}
}