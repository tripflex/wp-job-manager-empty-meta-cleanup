<?php
namespace sMyles\WPJM\EMC;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Admin
 *
 * @package sMyles\WPJM\EMC
 */
class Admin {

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		new Admin\Job();
		new Admin\Resume();

		/**
		 * Company related plugin handling is initialized by the Plugin class
		 */
	}
}