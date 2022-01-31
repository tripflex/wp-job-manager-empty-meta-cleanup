<?php

namespace sMyles\WPJM\EMC\Plugins;
use sMyles\WPJM\EMC\Meta\Remove as MetaRemove;
use sMyles\WPJM\EMC\Admin\Plugins\CM as CMAdmin;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class CM
 *
 * @package sMyles\WPJM\EMC
 */
class CM extends MetaRemove {

	/**
	 * @var string
	 */
	public $slug = 'company';
	/**
	 * @var string
	 */
	public $post_type = 'company';
	/**
	 * @var null|\sMyles\WPJM\EMC\Plugins\CM
	 */
	protected static $single_instance = null;
	/**
	 * @var \sMyles\WPJM\EMC\Admin\Plugins\CM
	 */
	public $admin;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return CM A single instance of this class.
	 * @since  1.0.0
	 */
	public static function get_instance() {

		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * CM constructor.
	 */
	public function __construct() {
		add_action( 'company_manager_update_company_data', [ $this, 'check_fields_and_remove' ], 99999, 2 );

		if( is_admin() ){
			$this->admin = new CMAdmin( $this );
		}
	}

	/**
	 * Get Label
	 *
	 * @return string|void
	 * @since @@version
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
	 * @since @@version
	 */
	public function get_fields( $only_fields = false ) {

		if ( ! defined( 'JOB_MANAGER_PLUGIN_DIR' ) || ! defined( 'COMPANY_MANAGER_PLUGIN_DIR' ) ) {
			return [];
		}

		if ( ! class_exists( 'WP_Job_Manager_Form' ) ) {
			include( JOB_MANAGER_PLUGIN_DIR . '/includes/abstracts/abstract-wp-job-manager-form.php' );
		}

		if ( ! class_exists( 'WP_Company_Manager_Form_Submit_Company' ) ) {
			require_once( COMPANY_MANAGER_PLUGIN_DIR . '/includes/forms/submit-company.php' );
		}

		$wpcm = \WP_Company_Manager_Form_Submit_Company::instance();

		return $only_fields ? $wpcm->get_fields( 'company_fields' ) : [ 'company_fields' => $wpcm->get_fields( 'company_fields' ) ];
	}
}