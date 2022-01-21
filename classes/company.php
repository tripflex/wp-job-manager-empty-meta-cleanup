<?php

namespace sMyles\WPJM\EMC;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Company
 *
 * @package sMyles\WPJM\EMC
 */
class Company extends Meta\Remove {

	/**
	 * @var string
	 */
	public $type = 'company';

	/**
	 * Company constructor.
	 */
	public function __construct() {
		add_action( 'company_manager_update_company_data', array( $this, 'check_fields_and_remove' ), 99999, 2 );
	}

	/**
	 * Get Submit Form Class Name
	 *
	 * @return string
	 * @since @@version
	 *
	 */
	public static function get_submit_form_class_name() {
		return apply_filters( 'wpjm_emc_company_submit_form_class_name', 'WP_Job_Manager_Field_Editor_Company_Submit_Form' );
	}
}