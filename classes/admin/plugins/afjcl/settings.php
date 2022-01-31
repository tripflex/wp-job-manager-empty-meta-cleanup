<?php

namespace sMyles\WPJM\EMC\Admin\Plugins\AFJCL;
use sMyles\WPJM\EMC\Admin\Settings as AdminSettings;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Settings
 *
 * @package sMyles\WPJM\EMC\Admin\Plugins\AFJCL
 */
class Settings extends AdminSettings {

	/**
	 * Settings constructor.
	 *
	 * @param \sMyles\WPJM\EMC\Admin\Plugins\AFJCL $admin
	 */
	public function __construct( $admin ) {
		$this->admin = $admin;
		add_filter( 'company_listings_settings', array( $this, 'add_tab' ), 999999 );
		$this->init_fields();
	}

	/**
	 * Custom Field Hook
	 *
	 * Who knows why they are using this hook, it makes ZERO sense!
	 *
	 * @return string
	 * @since 1.0.0
	 *
	 */
	public function get_custom_field_hook() {
		return 'wp_bp_events_calendar_admin_field_';
	}
}