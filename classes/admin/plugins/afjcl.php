<?php

namespace sMyles\WPJM\EMC\Admin\Plugins;
use sMyles\WPJM\EMC\Admin\Meta\Remove as MetaRemove;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class AFJCL
 *
 * @package sMyles\WPJM\EMC
 */
class AFJCL extends MetaRemove {

	/**
	 * @var \sMyles\WPJM\EMC\Plugins\AFJCL
	 */
	public $type;

	/**
	 * AFJCL constructor.
	 *
	 * @param $type \sMyles\WPJM\EMC\Plugins\AFJCL
	 */
	public function __construct( $type ) {
		$this->type = $type;
		new AFJCL\Settings( $this );
		add_action( 'company_listings_save_company', [ $this, 'check_fields_and_remove' ], 99999, 2 );
	}

	/**
	 * Get Company Manager Fields
	 *
	 * @return array
	 * @since 1.0.0
	 *
	 */
	public function get_fields() {

		if ( ! class_exists( 'WP_Job_Manager_Company_Listings_Writepanels' ) ) {

			if ( ! defined( 'COMPANY_LISTINGS_PLUGIN_DIR' ) ) {
				return [];
			}

			/**
			 * Original TechBrise Company Listings Plugin compatibility
			 */
			if ( file_exists( COMPANY_LISTINGS_PLUGIN_DIR . '/includes/admin/class-wp-job-manager-company-listings-writepanels.php' ) ) {
				require_once( COMPANY_LISTINGS_PLUGIN_DIR . '/includes/admin/class-wp-job-manager-company-listings-writepanels.php' );
			} else {
				require_once( COMPANY_LISTINGS_PLUGIN_DIR . '/includes/admin/class-afj-company-listings-writepanels.php' );
			}
		}

		return \WP_Job_Manager_Company_Listings_Writepanels::company_fields();
	}

}