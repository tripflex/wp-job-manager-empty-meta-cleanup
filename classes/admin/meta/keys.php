<?php

namespace sMyles\WPJM\EMC\Admin\Meta;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Keys
 *
 * @package sMyles\WPJM\EMC\Admin\Meta
 */
class Keys {

	/**
	 * Get Different Meta Keys
	 *
	 * This method returns meta keys that are different on the frontend and admin area (at least through the filter).
	 *
	 * The array format should be the frontend meta key as the array key, and admin area meta key as the value (without any prepended underscores)
	 *
	 * @since @@version
	 *
	 */
	public static function get_diff_keys() {
		return apply_filters( 'job_manager_empty_meta_cleaner_admin_diff_keys', [ 'job_deadline' => 'application_deadline' ] );
	}

}