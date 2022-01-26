<?php

namespace sMyles\WPJM\EMC\Admin;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Job
 *
 * @package sMyles\WPJM\EMC
 */
class Settings {

	/**
	 * @var \sMyles\WPJM\EMC\Admin\Job|\sMyles\WPJM\EMC\Admin\Resume|\sMyles\WPJM\EMC\Admin\Plugins\Cariera|\sMyles\WPJM\EMC\Admin\Plugins\AFJCL|\sMyles\WPJM\EMC\Admin\Plugins\CM|\sMyles\WPJM\EMC\Admin\Plugins\MASCM
	 */
	public $admin;

	/**
	 * Init Fields
	 *
	 * @since @@version
	 *
	 */
	public function init_fields(){
//		add_action( 'wp_job_manager_admin_field_cleanup_handler', [ $this, 'cleanup_handler' ] );
	}

	/**
	 * Custom Field Hook
	 *
	 * @return string
	 * @since @@version
	 *
	 */
	public function get_custom_field_hook() {
		return 'wp_job_manager_admin_field_';
	}

	/**
	 * Get Tab Label
	 *
	 * @return string|void
	 * @since @@version
	 *
	 */
	public function get_tab_label() {
		return __( 'Meta' );
	}

	/**
	 * Get Tab Slug
	 *
	 * @return string
	 * @since @@version
	 *
	 */
	public function get_tab_slug() {
		return 'meta';
	}

	/**
	 * Add Meta Tab
	 *
	 * @param $settings
	 *
	 * @return mixed
	 * @since @@version
	 *
	 */
	public function add_tab( $settings ) {
		$slug = $this->admin->type->slug;

		$settings[ $this->get_tab_slug() ] = [
			$this->get_tab_label(),
			[
				[
					'name'     => "job_manager_empty_meta_cleanup_{$slug}_enable",
					'std'      => '1',
					'cb_label' => sprintf( __( 'Enable %s listing automatic empty meta removal' ), $this->admin->type->get_label() ),
					'label'    => __( 'Auto Removal' ),
					'desc'     => __( 'When this setting is enabled, and a listing is submitted and/or updated, any empty meta values will automatically be removed from the database' ),
					'type'     => 'checkbox'
				]
			]
		];

		return $settings;
	}
}