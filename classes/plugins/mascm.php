<?php

namespace sMyles\WPJM\EMC\Plugins;
use sMyles\WPJM\EMC\Meta\Remove as MetaRemove;
use sMyles\WPJM\EMC\Admin\Plugins\MASCM as MASCMAdmin;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class MASCM
 *
 * @package sMyles\WPJM\EMC
 */
class MASCM extends MetaRemove {

	/**
	 * @var string
	 */
	public $slug = 'company';
	/**
	 * @var string
	 */
	public $post_type = 'company';
	/**
	 * @var null|\sMyles\WPJM\EMC\Plugins\MASCM
	 */
	protected static $single_instance = null;
	/**
	 * @var \sMyles\WPJM\EMC\Admin\Plugins\MASCM
	 */
	public $admin;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return MASCM A single instance of this class.
	 * @since  1.0.0
	 */
	public static function get_instance() {

		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * MASCM constructor.
	 */
	public function __construct() {
		add_action( 'mas_job_manager_company_update_company_data', [ $this, 'check_fields_and_remove' ], 99999, 2 );

		if ( is_admin() ) {
			$this->admin = new MASCMAdmin( $this );
		}
	}

	/**
	 * Get Label
	 *
	 * @return string|void
	 * @since 1.0.0
	 *
	 */
	public function get_label() {

		return __( 'Company' );
	}

	/**
	 * Get Company Manager Fields
	 *
	 * @param bool $only_fields
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function get_fields( $only_fields = false ) {

		if ( ! defined( 'JOB_MANAGER_PLUGIN_DIR' ) || ! class_exists( 'MAS_WP_Job_Manager_Company' ) ) {
			return [];
		}

		if ( ! class_exists( 'WP_Job_Manager_Form' ) ) {
			include( JOB_MANAGER_PLUGIN_DIR . '/includes/abstracts/abstract-wp-job-manager-form.php' );
		}

		if ( ! class_exists( 'MAS_WP_Job_Manager_Company_Form_Submit_Company' ) ) {
			$mas_cm_instance = \MAS_WP_Job_Manager_Company::instance();
			require_once( $mas_cm_instance->plugin_dir . 'includes/forms/class-mas-wp-job-manager-company-form-submit-company.php' );
		}

		$wpcm = \MAS_WP_Job_Manager_Company_Form_Submit_Company::instance();

		return $only_fields ? $wpcm->get_fields( 'company_fields' ) : [ 'company_fields' => $wpcm->get_fields( 'company_fields' ) ];
	}
}