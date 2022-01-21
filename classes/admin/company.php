<?php

namespace sMyles\WPJM\EMC\Admin;

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
		add_action( 'company_manager_save_company', array( $this, 'check_fields_and_remove' ), 99999, 2 );
	}
}