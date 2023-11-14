<?php

namespace sMyles\WPJM\EMC\Plugins;
use sMyles\WPJM\EMC\Meta\Remove as MetaRemove;
use sMyles\WPJM\EMC\Admin\Plugins\Cariera as CarieraAdmin;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Cariera
 *
 * @package sMyles\WPJM\EMC
 */
class Cariera extends MetaRemove {

	/**
	 * @var string
	 */
	public $slug = 'company';
	/**
	 * @var string
	 */
	public $post_type = 'company';

	/**
	 * @var null|\sMyles\WPJM\EMC\Plugins\Cariera
	 */
	protected static $single_instance = null;
	/**
	 * @var \sMyles\WPJM\EMC\Admin\Plugins\Cariera
	 */
	public $admin;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return Cariera A single instance of this class.
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
		add_action( 'cariera_update_company_data', [ $this, 'check_fields_and_remove' ], 99999, 2 );
		add_filter( 'job_manager_empty_meta_cleaner_extra_meta_keys', [ $this, 'extra_meta_keys' ] );
		if ( is_admin() ) {
			$this->admin = new CarieraAdmin( $this );
		}

		add_filter( 'job_manager_empty_meta_cleaner_admin_diff_keys', [ $this, 'admin_diff_keys' ] );
	}

	/**
	 * Extra Meta Keys to Clean
	 *
	 * Extra meta cleans to clean from database (these are used for frontend), but in some situations could exist saved to the database.
	 *
	 * @param $extra
	 *
	 * @return mixed
	 * @since 1.0.0
	 *
	 */
	public function extra_keys( $extra ) {
		$frontend = [ 'candidate_rate', 'candidate_languages', 'candidate_featured_image', 'candidate_facebook', 'candidate_twitter', 'candidate_linkedin', 'candidate_instagram', 'candidate_youtube', 'candidate_rate' ];
		return array_merge( $extra, $frontend );
	}

	/**
	 * Admin/Frontend Different Meta Keys
	 *
	 * For some reason Gino decided to use different keys for admin area and frontend, this will tell FE
	 * to use a specific meta key for admin and specific one for frontend.
	 *
	 * @param $keys
	 *
	 * @return mixed
	 * @since 1.0.0
	 *
	 */
	public function admin_diff_keys( $keys ) {

		$keys['candidate_rate']           = 'rate';
		$keys['candidate_languages']      = 'languages';
		$keys['candidate_featured_image'] = 'featured_image';
		$keys['candidate_facebook']       = 'facebook';
		$keys['candidate_twitter']        = 'twitter';
		$keys['candidate_linkedin']       = 'linkedin';
		$keys['candidate_instagram']      = 'instagram';
		$keys['candidate_youtube']        = 'youtube';
		$keys['candidate_rate']           = 'rate';

		return $keys;
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
	 * @return array
	 * @since 1.0.0
	 *
	 */
	public function get_fields( $only_fields = false ) {

		if ( ! defined( 'JOB_MANAGER_PLUGIN_DIR' ) || ! defined( 'CARIERA_PLUGIN_DIR' ) ) {
			return [];
		}

		if ( ! class_exists( 'WP_Job_Manager_Form' ) ) {
			include( JOB_MANAGER_PLUGIN_DIR . '/includes/abstracts/abstract-wp-job-manager-form.php' );
		}

		if ( ! class_exists( '\Cariera_Core\Core\Company_Manager\Forms\Submit_Company' ) ) {
			require_once( CARIERA_PLUGIN_DIR . '/inc/core/company-manager/form/submit-company.php' );
		}

		$wpcm = \Cariera_Core\Core\Company_Manager\Forms\Submit_Company::instance();

		return $only_fields ? $wpcm->get_fields( 'company_fields' ) : [ 'company_fields' => $wpcm->get_fields( 'company_fields' ) ];
	}
}
