<?php

namespace sMyles\WPJM\EMC\Admin\Plugins\MASCM;
use sMyles\WPJM\EMC\Admin\Settings as AdminSettings;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Settings
 *
 * @package sMyles\WPJM\EMC\Admin\Plugins\MASCM
 */
class Settings extends AdminSettings {

	/**
	 * Settings constructor.
	 *
	 * @param \sMyles\WPJM\EMC\Admin\Plugins\MASCM $admin
	 */
	public function __construct( $admin ) {
		$this->admin = $admin;
		/**
		 * MASCM seems to put these under the Job Manager settings area (for some reason who knows why)
		 */
		add_filter( 'job_manager_settings', array( $this, 'add_tab' ), 999999 );
		$this->init_fields();
	}

	/**
	 * Get Tab Label
	 *
	 * @return string|void
	 * @since 1.0.0
	 *
	 */
	public function get_tab_label() {
		return __( 'Company Meta' );
	}

	/**
	 * Get Tab Slug
	 *
	 * @return string
	 * @since 1.0.0
	 *
	 */
	public function get_tab_slug() {
		return 'company_meta';
	}
}