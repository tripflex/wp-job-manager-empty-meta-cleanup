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
		$hook = $this->get_custom_field_hook();
		/**
		 * Field type required to have type slug (job/resume/company/etc) to prevent duplicate output in
		 * admin area due to adding action for same hook mulitple times
		 */
		add_action( "{$hook}existing_{$this->admin->type->slug}_meta_cleaner", [ $this, 'cleanup_handler' ] );
	}

	/**
	 * Cleanup Handler Output
	 *
	 * @param $option
	 *
	 * @since @@version
	 *
	 */
	public function cleanup_handler( $option ) {
		$show_default = apply_filters( 'job_manager_empty_meta_cleanup_handler_output_show_default', true, $this );
		if( $show_default ){
			echo __( 'Existing meta removal requires either the WP Job Manager Field Editor 1.21.1+, or the Search and Filtering for WP Job Manager 1.1.9+ plugin.' );
		}

		do_action( 'job_manager_empty_meta_cleanup_handler_output', $this->admin, $this );
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
				],
				[
					'name'     => "job_manager_empty_meta_cleanup_{$slug}_existing_cleaner",
					'label'    => __( 'Existing Meta' ),
					'desc'     => __( 'When this setting is enabled, and a listing is submitted and/or updated, any empty meta values will automatically be removed from the database' ),
					'type'     => "existing_{$this->admin->type->slug}_meta_cleaner"
				]
			]
		];

		return $settings;
	}
}